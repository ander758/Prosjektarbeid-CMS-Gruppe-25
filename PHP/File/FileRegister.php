<?php
    require_once('../DB.class.php');
    require_once('File.class.php');
    require_once('FileInterface.php');
    require_once('FileRegister.class.php');
    require_once('../../vendor/autoload.php');

    $loader = new Twig_Loader_Filesystem('../templates');
    $twig = new Twig_Environment($loader);
    $fileRegister = new FileRegister(DB::getDBConnection());

    // Med hjelp fra https://bytes.com/topic/php/insights/740327-uploading-files-into-mysql-database-using-php
    if (isset($_POST['id']) && isset($_POST['submit_fileUpload'])) {
        // Mediumblom max size = MEDIUMBLOB 16777215 bytes = 16.78 Mb

        // Hent data
        $id = intval($_GET['id']); // UserID
        $name = $_FILES(['uploadedFile']['name']);
        $mime = $_FILES(['uploadedFile']['type']);
        $data = file_get_contents($_FILES['uploadedFile']['tmp_name']);
        $description = filter_input(INPUT_POST, 'fileDescription', FILTER_SANITIZE_STRING);

        // Lag fil Object
        $file = new file();
        $file->settUserID($id);
        $file->settFilename($name);
        $file->settMimetype($mime);
        $file->settFile($data);
        $file->settDescription($description);
        $file->settDate(date("Y-m-d H:i:s"));

        // Legg til $file
        $fileRegister->leggTilFil($file);
    }

    // TODO -> slettFil