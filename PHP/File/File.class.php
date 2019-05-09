<?php
class file {
    private $FileID;
    private $File;
    private $Author; // ?
    private $UserID;
    private $Filename;
    private $Size;
    private $Mimetype;
    private $Description;
    private $Views;
    private $Date;

    function __construct() {
    }

    // Getters
    function getFileID() {
        return $this->FileID;
    }
    function getFile() {
        return $this->File;
    }
    function getAuthor() {
        return $this->Author;
    }
    function getUserID() {
        return $this->UserID;
    }
    function getFileName() {
        return $this->Filename;
    }
    function getSize() {
        return $this->Size;
    }
    function getMimetype() {
        return $this->Mimetype;
    }
    function getDescription() {
        return $this->Description;
    }
    function getViews() {
        return $this->Views;
    }
    function getDate() {
        return $this->Date;
    }

    // Setters
    function setFile($File) {
        $this->File = $File;
    }
    function setAuthor($Author) {
        $this->Author = $Author;
    }
    function setUserID($userID) {
        $this->userID = $userID;
    }
    function setFilename($Filename) { // Trenger vi denne? https://php.net/manual/en/function.rename.php
        $this->Filename = $Filename;
    }
    function setSize($Size) {
        $this->Size = $Size;
    }
    function setDescription($Description) {
        $this->Description = $Description;
    }
    function setDate($Date) {
        $this->Date = $Date;
    }
    function setMimetype($Mimetype) {
        $this->Mimetype = $Mimetype;
    }
}
?>