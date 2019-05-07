<?php
class User {
    private $id=-1;
    private $username;
    private $email;
    private $firstName;
    private $lastName;
    private $loggedIn = false;
    private $db;
    private $passHash;
    private $verificationKey;

    public function __construct(){}

    //lets us create a new user with specified variables
    public static function createUser($username, $email, $firstName, $lastName) {
        $obj = new self();
        $obj->username=$username;
        $obj->email=$email;
        $obj->firstName=$firstName;
        $obj->lastName=$lastName;
        return $obj;
    }

    // Getters
    public function getId() {
        return $this->id;
    }
    public function getUsername() {
        return $this->username;
    }
    function getEmail() {
        return $this->email;
    }
    function getFirstName() {
        return $this->firstName;
    }
    function getLastName() {
        return $this->lastName;
    }
    function getName() {
        return $this->firstName . " " . $this->lastName;
    }
    function getPassHash(){
        return $this->passHash;
    }
    public function getVerificationKey(){
        return $this->verificationKey;
    }

    // Setters
    function setUsername($username) {
        $this->username = $username;
    }
    function setEmail($email) {
        $this->email = $email;
    }
    function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    function setLastName($lastName) {
        $this->lastName = $lastName;
    }
    function setPassHash($passHash){
        $this->passHash=$passHash;
    }
    public function setVerificationKey($verificationKey){
        $this->verificationKey = $verificationKey;
    }

    //copied from earlier assignments, checks if login data
    //has been submitted, then calls the log-in method to
    //log in the user
    public function checkLogin($db) {

        $this->db = $db;

        if (isset($_POST['login'])) {
            //sjekk om brukernavn og passord er riktig
            return $this->login($_POST['username'], $_POST['password']);
        } else if (isset($_POST['logout'])) {
            $this->logout();
        } else if (isset($_SESSION['loggedIn'])) {
            $this->loggedIn = true;
        }
    }

    //returns wether or not the current user is logged in
    public function loggedIn() {
        return $this->loggedIn;
    }


    //Tries to log in the user, returns error if the user doesn't exists or bad password
    //Does not tell wether the username or password was wrong, to limit brute-force attacks somewhat
    public function login($uname, $pwd) {
        $stmt = $this->db->prepare("SELECT UserID, FirstName, LastName, PassHash, Verified FROM User WHERE Username=:username");
        $stmt->bindParam(':username', $uname, PDO::PARAM_STR);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if($row['Verified']==1) {
                if (password_verify($pwd, $row['PassHash'])) {
                    $_SESSION['id'] = $row['UserID'];
                    $this->id = $row['UserID'];
                    $_SESSION['name'] = ucfirst($row['FirstName']);
                    $_SESSION['loggedIn'] = true;
                    $this->loggedIn = true;
                    return array('status' => 'OK');
                } else {
                    return array('status' => 'FAIL', 'errorMessage' => 'Bad password or user does not exist!');
                }
            } else {
                return array('status' => 'FAIL', 'errorMessage' => 'User not verified!');
            }
        } else {
            return array('status'=>'FAIL', 'errorMessage'=>'Bad password or user does not exist!');
        }
    }

    public function logOut(){
        unset($_SESSION['loggedIn']);
        unset($_SESSION['id']);
        unset($_SESSION['name']);
        $this->loggedIn = false;
    }


}