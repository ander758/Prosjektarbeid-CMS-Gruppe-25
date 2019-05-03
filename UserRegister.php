<?php
    require_once ('auth_pdo.php');
    require_once('User.class.php');
    require_once('UserInterface.class.php');
    require_once('UserRegister.class.php');
    require_once 'vendor/autoload.php';

    $loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader);
    $userregister = new UserRegister($db);

    if(isset($_POST['id']) && isset($_POST['edit'])){
        //Rediger en student
        $id = intval($_GET['id']);
        try {
            if($user = $userregister->visUser($id) ) {
                echo $twig->render('edit.twig', array('student' => $student, 'edit' => true));
            }
        }
        catch (InvalidArgumentException $e) {
            echo $twig->render('error.twig', array('msg' => $e->getMessage() ));
        }
    }

    elseif(isset($_POST['id']) && isset($_POST['save'])){
        //Vasker input & lagrer en student
        $id = intval($_POST['id']);
        $forNavn = filter_input(INPUT_POST, 'forNavn', FILTER_SANITIZE_STRING);
        $etterNavn = filter_input(INPUT_POST, 'etterNavn', FILTER_SANITIZE_STRING);
        $mobil = filter_input(INPUT_POST, 'mobil', FILTER_SANITIZE_NUMBER_INT);
        $klasse = filter_input(INPUT_POST, 'klasse', FILTER_SANITIZE_STRING);
        $epost = filter_input(INPUT_POST, 'epost', FILTER_VALIDATE_EMAIL);
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($epost) {
                $student = new Student();
                $student->settEtterNavn($etterNavn);
                $student->settForNavn($forNavn);
                $student->settEpost($epost);
                if($studentregister->oppdaterStudent($student, $id) ) {
                    echo $twig->render('edit.twig', array('student' => $student));
                }
                else echo $twig->render('error.twig', array('msg' => 'Student not found!'));
        }
        else  echo $twig->render('error.twig', array('msg' => 'Wrong input'));
    }

    elseif(isset($_POST['id']) && isset($_POST['submit_leggTil'])) {
        $fornavn = filter_input(INPUT_POST, 'forNavn', FILTER_SANITIZE_STRING);
        $etterNavn = filter_input(INPUT_POST, 'etterNavn', FILTER_SANITIZE_STRING);
        $mobil = filter_input(INPUT_POST, 'mobil', FILTER_SANITIZE_NUMBER_INT);
        $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
        $klasse = filter_input(INPUT_POST, 'klasse', FILTER_SANITIZE_NUMBER_INT);
        $epost = filter_input(INPUT_POST, 'epost', FILTER_SANITIZE_EMAIL);

        $student = new student();
        $student->settForNavn($fornavn);
        $student->settEtterNavn($etterNavn);
        $student->settMobil($mobil);
        $student->settURL($url);
        $student->settKlasse($klasse);
        $student->settEpost($epost);
        $studentregister->leggTilStudent($student);
    }

    elseif(isset($_GET['id']) && ctype_digit($_GET['id'])){
        //Viser en student
        $id = intval($_GET['id']);
        try {
            if($student = $studentregister->visStudent($id) ) {
                echo $twig->render('edit.twig', array('student' => $student));
            }
        }
        catch (InvalidArgumentException $e) {
            echo $twig->render('error.twig', array('msg' => $e->getMessage() ));
        }
    }
    else {
        $studenter = $studentregister->visAlle();
        echo $twig->render('edit.twig', array('studenter' => $studenter));

        $klasser = $studentregister->visAlleKlasser();
        echo $twig->render('insertStudent.twig', array('klasser' => $klasser));
    }



?>