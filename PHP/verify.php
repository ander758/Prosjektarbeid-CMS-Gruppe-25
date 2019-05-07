<?php
require_once 'DB.class.php';
require_once('User/UsersInterface.class.php');
require_once 'User/Users.class.php';
require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader, array(
//    'cache' => './compilation_cache',
));

//TODO: Add autologin when verified?


if(isset($_GET['key'])){

    $users = new Users(DB::getDBConnection());
    if($users->verifyUser($_GET['key'])){
        echo $twig->render('verify.twig', array('verified' => true));
    } else {
        echo $twig->render('verify.twig', array('verified' => false));
    }
} else {
    echo $twig->render('verify.twig', array('noVerify' => true));
}