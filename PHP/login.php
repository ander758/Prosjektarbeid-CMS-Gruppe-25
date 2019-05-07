<?php
session_start();
require_once "DB.class.php";
require_once "User/User.class.php";
require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader, array(
//    'cache' => './compilation_cache',
));

$db = DB::getDBConnection();

if ($db==null) {
    echo $twig->render('error.twig', array('msg' => 'Unable to connect to the database!'));
    die();  // Abort further execution of the script
}

$user = new User();
$status=$user->checkLogin($db);

if ($user->loggedIn()) {
    if(!isset($_SESSION['clientIp'])){
        $_SESSION['clientIp']=$_SERVER['REMOTE_ADDR'];
    } else {
        $_SESSION['clientIp']=$_SERVER['REMOTE_ADDR'];
    }
    //Logged in, show logged-in page, then redirect to index
    echo $twig->render('login.twig', array('loggedIn'=>'true', 'name'=>$_SESSION['name'] )); // Add other data as needed
}
else {
    //Not logged in, show log-in page
    echo $twig->render('login.twig', array('loggedIn'=>'false', 'status'=>$status));
}