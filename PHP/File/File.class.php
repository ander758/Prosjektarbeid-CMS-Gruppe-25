<?php
class file {
    private $id;
    private $author; // ?
    private $filename;
    private $fileSize;
    private $description;
    private $views;
    private $date;

    function __construct() {
    }

    // Getters
    function hentId() {
        return $this->id;
    }
    function hentAuthor() {
        return $this->author;
    }
    function hentFileName() {
        return $this->filename;
    }
    function hentFileSize() {
        return $this->fileSize;
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
    function settFilename($filename) { // Trenger vi denne? https://php.net/manual/en/function.rename.php
        $this->filename = $filename;
    }
    function settDescription($description) {
        $this->description = $description;
    }
}
?>