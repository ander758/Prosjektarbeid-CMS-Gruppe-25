<?php
interface FileInterface {
    public function showAllFiles(int $access) : array;                  // Return array of all Files
    public function showFile(int $id) : File;                           // Return given File by it's ID
    public function addFile(File $file, int $UserID) : int;             // Return ID for added File
    public function updateFile(File $file, int $id) : bool;             // Return bool for status for updating File
    public function deleteFile(int $id) : bool;                         // Return bool for status of deleting File
    public function showAllFilesInCatalogue(int $catalogueID) : Array;  // Return array of all files in given Catalogue
    public function countAllFiles() : int;                              // return number of files in database as int
    public function isFileOwner(int $fileID, int $userID) : bool;       // return true if certain User is owner of specific File
    public function fetchAuthor(int $userID) : string;                  // Return author for given user as string
}