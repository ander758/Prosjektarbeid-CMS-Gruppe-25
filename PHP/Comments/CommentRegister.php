<?php
    require_once ('../DB.class.php');
    require_once ('Comment.class.php');
    require_once ('CommentInterface.php');
    require_once ('CommentRegister.php');
    require_once ('../../vendor/autoload.php');

    $loader = new Twig_Loader_Filesystem('../templates');
    $twig = new Twig_Environment($loader);
    $commentRegister = new CommentRegister(DB::getDBConnection());
    $deletedCommentRegister = new DeletedCommentRegister(DB::getDBConnection());

    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']=='yes' && isset($_POST['submit_comment'])) {
        // Gather date from submitted Comment
        $fileID = intval($_GET['fileID']);
        $userID = intval($_GET['id']); // UserID
        $date = date("Y-m-d H:i:s");
        $commentContent = filter_input(INPUT_POST, 'commentContent', FILTER_SANITIZE_STRING);

        // Make Comment object
        $comment = new comment();
        $comment->setFileID($fileID);
        $comment->setUserID($userID);
        $comment->setDate($date);
        $comment->setComment($commentContent);

        // Pass the object to $commentRegister to add it to the database
        $commentRegister->addComment($comment);

    } elseif (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']=='yes' && isset($_POST['submit_deleteComment'])) {
        // Gather data from comment to delete
        $userID = intval($_GET['id']);
        $commentID = -1; // TODO: Need to find commentID for comment to remove

        // Make Comment object
        $comment = new comment();
        $comment->setCommentID($commentID);

        // Delete the comment from database
        $commentRegister->deleteComment($commentID);
    }