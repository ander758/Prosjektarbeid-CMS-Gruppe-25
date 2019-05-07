<?php
interface FileInterface {
    public function showAllFiles() : array;                 // Return array of all Files
    public function showFile(int $id) : File;               // Return given File by it's ID
    public function addFile(File $file) : int;              // Return ID for added File
    public function updateFile(File $file, int $id) : bool; // Return bool for status for updating File
    public function deleteFile(File $file, int $id) : bool; // Return bool for status of deleting File
    public function showAllFilesInCatalogue(int $catalogueID) : Array; // Return array of all files in given Catalogue
}