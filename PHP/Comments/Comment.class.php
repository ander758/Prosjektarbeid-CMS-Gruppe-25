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
    function getCommentId() {
        return $this->commentID;
    }
    function getFileID() {
        return $this->fileID;
    }
    function getUserID() {
        return $this->userID;
    }
    function getDate() {
        return $this->date;
    }
    function getComment() {
        return $this->comment;
    }

    // Setters
    function setFileID($fileID) {
        $this->fileID = $fileID;
    }
    function setUserID($userID) {
        $this->userID = $userID;
    }
    function setDate($date) {
        $this->date = $date;
    }
    function setComment($commentContent) {
        $this->comment = $commentContent;
    }
}