<?php
class comment {
    private $commentID;
    private $fileID;
    private $userID; // ID to table 'USER'
    private $date;
    private $comment;

    function __construct() {
    }


    // Getters
    function hentCommentId() {
        return $this->commentID;
    }
    function hentFileID() {
        return $this->fileID;
    }
    function hentUserID() {
        return $this->userID;
    }
    function hentDate() {
        return $this->date;
    }
    function hentComment() {
        return $this->comment;
    }

    // Setters
    function settComment($comment) {
        $this->comment = $comment;
    }
}