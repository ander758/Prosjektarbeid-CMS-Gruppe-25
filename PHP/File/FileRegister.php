<?php
    session_start();
    require_once('../DB.class.php');
    // File
    require_once('File.class.php');
    require_once('FileInterface.php');
    require_once('FileRegister.class.php');
    // Comments
    require_once('../Comments/Comment.class.php');
    require_once('../Comments/CommentInterface.php');
    require_once('../Comments/CommentRegister.class.php');
    // Catalogue
    require_once('../Catalogue/Catalogue.class.php');
    require_once('../Catalogue/CatalogueInterface.class.php');
    require_once('../Catalogue/CatalogueRegister.class.php');

    // twig
    require_once('../../vendor/autoload.php');
    $loader = new Twig_Loader_Filesystem('../../templates');
    $twig = new Twig_Environment($loader);

    // Registers
    $fileRegister = new FileRegister(DB::getDBConnection());
    $commentRegister = new CommentRegister(DB::getDBConnection());
    $catalogueRegister = new CatalogueRegister(DB::getDBConnection());


    alert("Det er " . $fileRegister->countAllFiles() . " filer i tabellen File");
    function alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }

    /*
     * Display files depending on access
     * logged in -> show ALL files   and   logged out -> show ONLY files with access=false
     * */
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']=='yes') $access = 1; else $access = 0;
    try {
        $files = $fileRegister->showAllFiles($access);
        echo $twig->render('displayFilesExample.twig', array('files' => $files));
    } catch (Exception $e) {
        print "Could not show files!" . $e->getMessage() . PHP_EOL;
    }


    // Show file upload screen if logged in
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']=='yes') {
        try {
            $catalogues = $catalogueRegister->showAllCatalogues();
            echo $twig->render('fileUpload.twig', array('catalogues' => $catalogues));
        } catch (Exception $e) {
            print "Could not show all catalogues!" . $e->getMessage() . PHP_EOL;
        }
    }

    // Upload File to database
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']=='yes' && $_SESSION['clientIp']==$_SERVER['REMOTE_ADDR'] && isset($_POST['submit_fileUpload'])) { // TODO -> Må hente inn UserID for den som laster opp, om ikke allerede gjort under
        // Med noe hjelp fra https://bytes.com/topic/php/insights/740327-uploading-files-into-mysql-database-using-php

        // Gather data
        $userID = $_SESSION['id'];
        $blob = $_FILES['uploadedFile']['tmp_name'];
        $name = $_FILES['uploadedFile']['name'];
        $type = $_FILES['uploadedFile']['type'];
        $size = $_FILES['uploadedFile']['size'];
        $access = filter_input(INPUT_POST, 'fileAccess', FILTER_SANITIZE_NUMBER_INT);
        $catalogueID = filter_input(INPUT_POST, 'fileCatalogue', FILTER_SANITIZE_NUMBER_INT);
        $description = filter_input(INPUT_POST, 'fileDescription', FILTER_SANITIZE_STRING);

        if (is_uploaded_file($blob) && $size != 0 && $size <= 16777215) {
            try {
                $data = file_get_contents($blob);

                $file = new file();
                $file->setFile($data);
                $file->setUserID($userID);
                $file->setAuthor($fileRegister->fetchAuthor($userID));
                $file->setFilename($name);
                $file->setServerFilename($name);
                $file->setSize($size);
                $file->setMimetype($type);
                $file->setDescription($description);
                $file->setAccess($access);
                $file->setUserUserID($userID);
                $file->setCatalogueID($catalogueID);
                $file->setCatalogueCatalogueID($catalogueID);

                $fileRegister->addFile($file, $userID);
            } catch (Exception $e) {
                print $e->getMessage() . PHP_EOL;
            }
        }
    }


    // Delete File from database
    if (isset($_POST['id']) && isset($_POST['submit_deleteFile'])) {
        // Gather UserID and FileID
        $fileID = -1; // TODO: Må finne FileID før vi sletter filen!!!
        $userID = $_SESSION['id'];

        // Check if userID is owner of file to delete
        if ($fileRegister->isFileOwner($fileID, $userID)){
            // Delete certain File
            $fileRegister->deleteFile($fileID);
            // Delete all comments in certain File
            $commentRegister->deleteAllCommentsFromFile($fileID);
        }
        else
            echo "Could not delete file!";
    }