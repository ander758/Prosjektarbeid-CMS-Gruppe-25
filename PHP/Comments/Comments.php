<?php
class Comments {
    private $id;
    private $userID; // ID to table 'USER'
    private $date;
    private $comment;

    function __construct() {
    }

    // Getters
    function hentId() {
        return $this->id;
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

    }


}