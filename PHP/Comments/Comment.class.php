<?php
class comment {
    private $CommentID;
    private $FileID;
    private $UserID;
    private $Date;
    private $Comment;

    function __construct() {
    }


    // Getters
    function getCommentId() {
        return $this->CommentID;
    }
    function getFileID() {
        return $this->FileID;
    }
    function getUserID() {
        return $this->UserID;
    }
    function getDate() {
        return $this->Date;
    }
    function getComment() {
        return $this->Comment;
    }

    // Setters
    function setCommentID($CommentID) {
        $this->setCommentID($CommentID);
    }
    function setFileID($FileID) {
        $this->FileID = $FileID;
    }
    function setUserID($UserID) {
        $this->UserID = $UserID;
    }
    function setDate($Date) {
        $this->Date = $Date;
    }
    function setComment($commentContent) {
        $this->Comment = $commentContent;
    }
}