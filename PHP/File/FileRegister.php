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

    require_once('../../vendor/autoload.php');

    $loader = new Twig_Loader_Filesystem('../../templates');
    $twig = new Twig_Environment($loader);
    $fileRegister = new FileRegister(DB::getDBConnection());
    $commentRegister = new CommentRegister(DB::getDBConnection());

    // Display all files test
    try {
        $files = $fileRegister->showAllFiles();
        echo $twig->render('displayAllFilesExample.twig', array('files' => $files));
    } catch (Exception $e) {
        print "Could not show all files!" . $e->getMessage() . PHP_EOL;
    }

    echo "<form method=\"post\" style=\"border: 1px solid #ccc\">";
    echo "<h1>Last opp fil</h1>";
    echo "<label for=\"fileToUpload\"><b>Velg ønsket fil fra din PC: </b></label>";
    echo "<input type=\"file\" name=\"uploadedFile\"  placeholder=\"Velg fil\" required>";
    echo "<label for=\"fileDescription\"><b>Beskrivelse av fil: </b></label>";
    echo "<input type=\"text\" name=\"fileDescription\" placeholder=\"Beskriv filen din\" maxlength=\"45\" required>";
    echo "<label for=\"submit_fileUpload\"><b>Last opp</b></label>";
    echo "<input type=\"submit\" name=\"sumbit_fileToUpload\">";
    echo "</form>";




    // Insert File to database
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']=='yes' && $_SESSION['clientIp']==$_SERVER['REMOTE_ADDR'] && isset($_POST['submit_fileUpload'])) { // TODO -> Må hente inn UserID for den som laster opp, om ikke allerede gjort under
        // Med noe hjelp fra https://bytes.com/topic/php/insights/740327-uploading-files-into-mysql-database-using-php

        // Gather data
        $userID = intval($_GET['id']);
        $file = $_FILES['uploadedFile']['tmp_name'];
        $name = $_FILES['uploadedFile']['name'];
        $type = $_FILES['uploadedFile']['type'];
        $size = $_FILES['uploadedFile']['size'];
        $description = filter_input(INPUT_POST, 'fileDescription', FILTER_SANITIZE_STRING);

        if (is_uploaded_file($file) && $size != 0 && $size <= 512000) {
            try {
                $data = file_get_contents($file);

                $fileObj = new file();
                $fileObj->setFile($data);
                $fileObj->setUserID($userID);
                $fileObj->setAuthor("per"); //TODO: FIKS
                $fileObj->setFilename($name);
                $fileObj->setFileSize($size);
                $fileObj->setMimetype($type);
                $fileObj->setDescription($description);
                $fileObj->setDate(date("Y-m-d H:i:s"));

                $fileRegister->addFile($fileObj);
            } catch (Exception $e) {
                print $e->getMessage() . PHP_EOL;
            }
        }
    }

    // Delete File from database
    if (isset($_POST['id']) && isset($_POST['submit_deleteFile'])) {
        // Gather UserID and FileID
        $fileID = -1; // TODO: Må finne FileID før vi sletter filen!!!
        $userID = intval($_GET['id']);

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