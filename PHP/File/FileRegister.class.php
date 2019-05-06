<?php
class FileRegister implements FileInterface {
	private $db;
	
	public function __construct(PDO $db) {
		$this->db = $db;
	}

    public function visAlle(): array
    {
        $files = array();
        try {
            $stmt = $this->db->query("SELECT * FROM File");
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

    public function visFil(int $id): File
    {
        // Gir File med gitt FileID
        try {
            $stmt = $this->db->prepare("SELECT * FROM File WHERE FileID = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchObject("File");
        } catch (InvalidArgumentException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function leggTilFile(File $file): int
    {
        // TODO: Implement leggTilFile() method.
        $stmt = $this->db->prepare("INSERT INTO `File`(`FileID`, `File`, `UserID`, `Author`, `Filename`, `ServerFilename`, `Size`, `Mimetype`, `Description`, `Accessed`, `Views`, `Date`, `Access`, `User_UserID`, `CatalogueID`, `Cataologue_CatalogueID`) 
            VALUES (NULL,:file,:userID,:author,:filename,:serverFilename,`:size`,:mimetype,:description,NULL,0,`:date`,NULL,NULL,NULL,NULL)");
        $stmt->bindValue(':file', $file->hentFile(), PDO::PARAM_LOB);
        $stmt->bindValue(':userID', $file->hentUserID(), PDO::PARAM_INT);
        $stmt->bindValue(':author', $file->hentAuthor(), PDO::PARAM_STR);
        $stmt->bindValue(':filename', $file->hentFileName(), PDO::PARAM_STR);
        $stmt->bindValue(':serverFileName', NULL, PDO::PARAM_NULL); //??
        $stmt->bindValue(':size', $file->hentFileSize(), PDO::PARAM_INT);
        $stmt->bindValue(':mimetype', $file->hentMimetype(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $file->hentDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':date', $file->hentDate(), PDO::PARAM_INT); //??
    }

    public function oppdaterFil(File $file, int $id): bool
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

    public function slettFil(File $file, int $id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM File Where FileID= :fileID");
            $stmt->bindParam(':fileID', $id, PDO::PARAM_INT);
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
}