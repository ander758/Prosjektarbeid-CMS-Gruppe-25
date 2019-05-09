<?php
class FileRegister implements FileInterface {
	private $db;
	
	public function __construct(PDO $db) {
		$this->db = $db;
	}

    public function showAllFiles(): array
    {
        try {
            $stmt = $this->db->query("SELECT `File` FROM File ORDER BY `Date` DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function showFile(int $id): File
    {
        // Return given file with FileID
        try {
            $stmt = $this->db->prepare("SELECT * FROM File WHERE FileID = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchObject("File");
        } catch (InvalidArgumentException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function addFile(File $file): int
    {
        // Add file to table `File`
        try {
            $stmt = $this->db->prepare("INSERT INTO `File`(`File`, `UserID`, `Author`, `Filename`, `ServerFilename`, `Size`, `Mimetype`, `Description`, `Accessed`, `Views`, `Date`, `Access`, `User_UserID`, `CatalogueID`)
 VALUES (:file,:userID,:author,:filename,:serverFilename,:size,:mimetype,:description,0,0,current_timestamp,1,:userID,1)");

            $serverFileNameTest = "server fil navn"; // TODO: Change later
            $stmt->bindParam(':file', $file->getFile(), PDO::PARAM_LOB);
            $stmt->bindParam(':userID', $file->getUserID(), PDO::PARAM_INT);
            $stmt->bindParam(':author', $file->getAuthor(), PDO::PARAM_STR);
            $stmt->bindParam(':filename', $file->getFileName(), PDO::PARAM_STR);
            $stmt->bindParam(':serverFileName', $serverFileNameTest, PDO::PARAM_STR); //??
            $stmt->bindParam(':size', $file->getFileSize(), PDO::PARAM_INT);
            $stmt->bindParam(':mimetype', $file->getMimetype(), PDO::PARAM_STR);
            $stmt->bindParam(':description', $file->getDescription(), PDO::PARAM_STR);
            //$stmt->bindParam(':date', $file->getDate(), PDO::PARAM_STR);
            $result = $stmt->execute();

            if ($result) {
                echo "Filen er lastet opp!";
                return true;
            } else {
                echo "Feil ved innlegging av fil!";
                return false;
            }
        } catch (InvalidArgumentException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function updateFile(File $file, int $id): bool
    {
        try {
            $stmt = $this->db->prepare("UPDATE File SET Description= :description WHERE FileID= :fileID");
            $stmt->bindParam(':fileID', $id, PDO::PARAM_INT);
            $stmt->bindValue(':description', $file->hentDescription(), PDO::PARAM_STR);
            $result = $stmt->execute();

            if ($result) {
                return true;
            } else {
                echo "Feil ved oppdatering av fil!";
                return false;
            }
        } catch (Exception $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function deleteFile(int $fileID): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM File Where FileID= :fileID");
            $stmt->bindParam(':fileID', $fileID, PDO::PARAM_INT);
            $result = $stmt->execute();

            if ($result) {
                return true;
            } else {
                echo "Feil ved sletting av fil!";
                return false;
            }
        } catch (Exception $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function showAllFilesInCatalogue(int $catalogueID): Array
    {
        // Return array of files in given Catalogue
        $files = array();
        try {
            $stmt = $this->db->prepare("SELECT * FROM File WHERE CatalogueID = :catalogueID");
            $stmt->bindParam(':catalogueID', $catalogueID, PDO::PARAM_INT);
            $stmt->execute();

            while ($file = $stmt->fetchObject("File")) {
                $files = $file;
            }
            return $files;
        } catch (Exception $e) {
            print $e->getMessage() . PHP_EOL;
        }
        return $files;
    }

    public function countAllFiles(): int
    {
        // Return number of files in database as int
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM Files");
            $stmt->execute();

            // Return number of rows in table `Files`
            return $stmt;
        } catch (InvalidArgumentException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function isFileOwner(int $fileID, int $userID): bool
    {
        // Check if the UserID from fetched result from table `Files` equals $userID
        try {
            $stmt = $this->db->prepare("SELECT UserID FROM Files WHERE FileID = :fileID");
            $stmt->bindParam(':fileID', $fileID, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt == $userID) {
                return true;
            } else {
                echo "Could not delete file, not authorized!";
                return false;
            }
        } catch (InvalidArgumentException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }
}