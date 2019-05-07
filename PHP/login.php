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
    echo $twig->render('main.twig', array('error'=>true, 'msg' => 'Unable to connect to the database!'));
    die();  // Abort further execution of the script
}

$user = new User();
$status=$user->checkLogin($db);

if(isset($_GET['action']) && $_GET['action']=='logout'){
    if($user->loggedIn()){
        $user->logOut();
        session_destroy();
        //TODO: add twig-template for this
        echo "logged out";
        exit();
    }
    else {
        //TODO: add twig-template for this
        echo "not logged in";
        exit();
    }
}

if ($user->loggedIn()) {
    if(!isset($_SESSION['clientIp'])){
        $_SESSION['clientIp']=$_SERVER['REMOTE_ADDR'];
    } else {
        $_SESSION['clientIp']=$_SERVER['REMOTE_ADDR'];
    }
    //Logged in, show logged-in page, then redirect to index
    header("Location: index.php");
}
else{
    //Not logged in, show log-in page
    echo $twig->render('main.twig', array('login'=>true, 'loggedIn'=>false, 'status'=>$status));
}