<?php
session_start();
require_once "User/User.class.php";
require_once "../vendor/autoload.php";

$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader, array(
//    'cache' => './compilation_cache',
));

include_once '5RecentFiles.php';

if(isset($_GET['view']) && $_GET['view']=='all'){

    //TODO: fetch and generate tree of all files
    echo $twig->render('main.twig', array('links'=>$links, 'files'=>true, 'loggedIn' => true, 'name'=>$_SESSION['name']));
;}
else {
    //TODO: fetch and generate tree of personal files
    echo $twig->render('main.twig', array('links'=>$links, 'files'=>true, 'loggedIn' => true, 'name'=>$_SESSION['name']));
}