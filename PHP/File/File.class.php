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
    function hentId() {
        return $this->id;
    }
    function hentFile() {
        return $this->file;
    }
    function hentAuthor() {
        return $this->author;
    }
    function hentUserID() {
        return $this->userID;
    }
    function hentFileName() {
        return $this->filename;
    }
    function hentFileSize() {
        return $this->fileSize;
    }
    function hentMimetype() {
        return $this->mimetype;
    }
    function hentDescription() {
        return $this->description;
    }
    function hentViews() {
        return $this->views;
    }
    function hentDate() {
        return $this->date;
    }

    // Setters
    function settFile($file) {
        $this->file = $file;
    }
    function settUserID($userID) {
        $this->userID = $userID;
    }
    function settFilename($filename) { // Trenger vi denne? https://php.net/manual/en/function.rename.php
        $this->filename = $filename;
    }
    function settDescription($description) {
        $this->description = $description;
    }
    function settDate($date) {
        $this->date = $date;
    }
    function settMimetype($mimetype) {
        $this->mimetype = $mimetype;
    }
}
?>