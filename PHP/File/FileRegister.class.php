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
        // Vis til fillokajon BLOB på kark.uit.no?

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