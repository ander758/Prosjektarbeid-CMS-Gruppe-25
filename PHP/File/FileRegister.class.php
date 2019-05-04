<?php
class FileRegister implements FileInterface {
	private $db;
	
	public function __construct(PDO $db) {
		$this->db = $db;
	}


    public function visAlle(): array
    {
        // TODO: Implement visAlle() method.
        $files = array();



    }

    public function visFil(int $id): File
    {
        // TODO: Implement visFil() method.
    }

    public function leggTilFile(File $file): int
    {
        // TODO: Implement leggTilFile() method.
    }

    public function oppdaterFil(File $file, int $id): bool
    {
        // TODO: Implement oppdaterFil() method.
    }
}