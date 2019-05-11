<?php
session_start();
require_once "User/User.class.php";
require_once "../vendor/autoload.php";


require_once('DB.class.php');
// File
require_once('File/File.class.php');
require_once('File/FileInterface.php');
require_once('File/FileRegister.class.php');
// Catalogue
require_once('Catalogue/Catalogue.class.php');
require_once('Catalogue/CatalogueInterface.class.php');
require_once('Catalogue/CatalogueRegister.class.php');

$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader, array(
//    'cache' => './compilation_cache',
));

include_once 'File/RecentFiles.php';

$fileRegister = new FileRegister(DB::getDBConnection());
$catalogueRegister = new CatalogueRegister(DB::getDBConnection());


if(isset($_GET['view']) && $_GET['view']=='all'){

    //TODO: fetch and generate tree of all files

    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']=='yes') $access = 1; else $access = 0;
    try {
        $catalogues = $catalogueRegister->showAllCatalogues();
        $files = $fileRegister->showAllFiles($access);

        echo $twig->render('main.twig', array('links'=>$links, 'files'=>true, 'loggedIn' => true, 'name'=>$_SESSION['name'], 'fileArr' => $files, 'catalogueArr' => $catalogues));
    } catch (Exception $e) {
        print "Could not show files! " . $e->getMessage() . PHP_EOL;
    }

} else {
    //TODO: fetch and generate tree of personal files
    echo $twig->render('main.twig', array('links'=>$links, 'files'=>true, 'loggedIn' => true, 'name'=>$_SESSION['name']));
}