<?php
    require_once('../DB.class.php');
    require_once('File.class.php');
    require_once('FileInterface.php');
    require_once('FileRegister.class.php');
    require_once('../../vendor/autoload.php');

    $loader = new Twig_Loader_Filesystem('../templates');
    $twig = new Twig_Environment($loader);
    $fileRegister = new FileRegister(DB::getDBConnection());

    if (isset($_POST['id']) && isset($_POST['submit_fileUpload'])) { // TODO -> Må sette inn skjult POST id for userID for opplasting av fil?
        // Med noe hjelp fra https://bytes.com/topic/php/insights/740327-uploading-files-into-mysql-database-using-php
        // Mediumblom max size = MEDIUMBLOB 16777215 bytes = 16.78 Mb

        // Allowed file extensions, add more if needed
        $allowedExtensions = array("jpeg","jpg","png","txt","html","php","gif", "zip", "pdf", "exe", "msi", "java");

        // Gather data
        $userID = intval($_GET['id']); // UserID
        $name = $_FILES['uploadedFile']['name']; // File's name
        $mime = $_FILES['uploadedFile']['type'];
        $temporaryFile = file_get_contents($_FILES['uploadedFile']['tmp_name']); // Temporary file for later Insertion to database
        $description = filter_input(INPUT_POST, 'fileDescription', FILTER_SANITIZE_STRING);
        $file_size = $_FILES['submit_fileUpload']['size']; // File's size

        // Check if allowed file extensions
        $fileExtension = strtolower(end(explode('.', $_FILES['uploadedFile']['name']))); // File's extension
        if (in_array($fileExtension, $allowedExtensions)) {
            // Add the file object to database
            $file = new file();
            $file->setUserID($userID);
            $file->setFilename($name);
            $file->setFileSize($file_size);
            $file->setMimetype($mime);
            $file->setFile($temporaryFile);
            $file->setDescription($description);
            $file->setDate(date("Y-m-d H:i:s"));

            // Cancel operation if file size over MEDIUMBLOB limit = 16777215 bytes
            if ($file->getFileSize() < 16777215) {
                $fileRegister->addFile($file);
            } else {
                echo "File size limit is 16.78 Mb!";
            }
        } else {
            echo "Allowed file extensions: " . implode(", ", $allowedExtensions);
        }
    } elseif (isset($_POST['id']) && isset($_POST['submit_deleteFile'])) {
        // Gather UserID and FileID
        $fileID = -1; // TODO: Find FileID of file to delete
        $userID = intval($_GET['id']);

        // Check if userID is owner of file to delete
        if ($fileRegister->isFileOwner($fileID, $userID))
            $fileRegister->deleteFile($fileID);
        else
            echo "Could not delete!";
    }