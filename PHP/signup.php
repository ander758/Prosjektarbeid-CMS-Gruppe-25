<?php
require_once('auth_pdo.php');
require_once('User.class.php');
require_once('UserInterface.class.php');
require_once('UserRegister.class.php');
require_once ('vendor/autoload.php');

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
$userregister = new UserRegister($db);

if (isset($_POST['submit_signup'])) { // TODO -> need to send confirmation email to user first
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);

    $user = new user();
    $user->settUsername($username);
    $user->settEpost($email);
    $user->settForNavn($firstName);
    $user->settEtterNavn($lastName);
    $userregister->leggTilUser($user);
}
?>

/*




*/
