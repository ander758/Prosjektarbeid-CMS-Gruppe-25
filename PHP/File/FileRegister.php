<?php
    require_once('../DB.class.php');
    require_once('File.class.php');
    require_once('FileInterface.php');
    require_once('FileRegister.class.php');
    require_once('../../vendor/autoload.php');

    $loader = new Twig_Loader_Filesystem('../templates');
    $twig = new Twig_Environment($loader);
    $fileRegister = new FileRegister(DB::getDBConnection());

    if (isset($_POST['id']) && isset($_POST['submit_fileToUpload'])) {
        // Legg til fil
        // Mediumblom max size = MEDIUMBLOB 16777215 bytes = 16.78 Mb
        $id = intval($_GET['id']); // UserID
        $description = filter_input(INPUT_POST, 'fileDescription', FILTER_SANITIZE_STRING);

        $file = new file();
        $file->settUserID($id);
        $file->settDescription($description);
        $fileRegister->leggTilFile($file);
    }

    // TODO -> slettFil