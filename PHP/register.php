<?php
require_once('DB.class.php');
require_once('User/User.class.php');
require_once('User/UsersInterface.class.php');
require_once('User/Users.class.php');
require_once '../vendor/autoload.php'; // ../ For relativ path

$loader = new Twig_Loader_Filesystem('../templates'); // ../?
$twig = new Twig_Environment($loader);
$users = new Users(DB::getDBConnection());

if (isset($_POST['submit_signup'])) { // TODO -> need to send confirmation email to user before '$userregister->leggTilUser($user);'?
    if(isset($_POST['psw']) && isset($_POST['psw-repeat']) && $_POST['psw'] == $_POST['psw-repeat']) {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
        $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
        $passHash = password_hash($_POST['psw'], PASSWORD_DEFAULT);

        $user = User::createUser($username, $email, $firstName, $lastName);
        $user->setPassHash($passHash);
        $users->addUser($user);

        echo $twig->render('register.twig', array('registerSuccess' => true));

    } else {
        echo $twig->render('register.twig', array('passNoMatch' => true));
    }
} elseif (isset($_POST['cancel_signup'])) {
    // Redirect back to index page...
    header('index.php');
    // Exit current script
    die();
} else {
    echo $twig->render('register.twig', array('loggedIn' => false));
}
?>