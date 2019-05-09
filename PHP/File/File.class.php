<?php
class file {
    private $id;
    private $file;
    private $author; // ?
    private $userID;
    private $filename;
    private $fileSize;
    private $mimetype;
    private $description;
    private $views;
    private $date;

    function __construct() {
    }

    // Getters
    function getId() {
        return $this->id;
    }
    function getFile() {
        return $this->file;
    }
    function getAuthor() {
        return $this->author;
    }
    function getUserID() {
        return $this->userID;
    }
    function getFileName() {
        return $this->filename;
    }
    function getFileSize() {
        return $this->fileSize;
    }
    function getMimetype() {
        return $this->mimetype;
    }
    function getDescription() {
        return $this->description;
    }
    function getViews() {
        return $this->views;
    }
    function getDate() {
        return $this->date;
    }

    // Setters
    function setFile($file) {
        $this->file = $file;
    }
    function setAuthor($author) {
        $this->author = $author;
    }
    function setUserID($userID) {
        $this->userID = $userID;
    }
    function setFilename($filename) { // Trenger vi denne? https://php.net/manual/en/function.rename.php
        $this->filename = $filename;
    }
    function setFileSize($fileSize) {
        $this->fileSize = $fileSize;
    }
    function setDescription($description) {
        $this->description = $description;
    }
    function setDate($date) {
        $this->date = $date;
    }
    function setMimetype($mimetype) {
        $this->mimetype = $mimetype;
    }
}
?>