<?php
class UserRegister implements UserInterface {
	private $db;
	
	public function __construct(PDO $db) {
		$this->db = $db;
	}


	public function visAlle(): array {
		$users = array();

        try {
            $stmt = $this->db->prepare("SELECT * FROM User");
            $stmt->execute();
            while ($user = $stmt->fetchObject("User")) {
                $users[] = $user;
            }
            return $users;
        }
        catch (Exception $e) {
            print $e->getMessage() . PHP_EOL;
        }
		return $users;
    }

    public function visAlleFiler(): array {
        $files = array();

        try {
            $stmt = $this->db->prepare("SELECT * FROM File");
            $stmt->execute();
            while ($file = $stmt->fetchObject("File")) {
                $files[] = $file;
            }
            return $files;
        } catch (Exception $e) {
            print $e->getMessage() . PHP_EOL;
        }
        return $files;
    }

	public function visUser(int $id) : User {
        try {
            $stmt = $this->db->prepare("SELECT * FROM User WHERE ID = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchObject("User");
        } catch (InvalidArgumentException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function leggUser(User $user) : int {
        try {
            $username = $user->hentUsername();
            $epost = $user->hentEpost();
            $fornavn = $user->HentForNavn();
            $etternavn =

            $fornavn = $user->hentForNavn();
            $etternavn = $user->hentEtterNavn();
            $klasse = $student->hentKlasse();
            $mobil = $student->hentMobil();
            $www = $student->hentURL();
            $epost = $student->hentEpost();
            $opprettet = date('Y/m/d h:i:s'); // Henter systemets dato

            $stmt = $this->db->prepare("INSERT INTO `student`(`id`, `etternavn`, `fornavn`, `klasse`, `mobil`, `www`, `epost`, `opprettet`) VALUES (NULL , $etternavn, $fornavn, $klasse, $mobil, $www, $epost, $opprettet)");
            $result = $stmt->execute();

            if ($result) {
                return true;
            } else {
                echo "Feil ved innlegging av ny student!";
                return false;
            }
        }
        catch (InvalidArgumentException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function oppdaterStudent(Student $student, int $id) : bool {
        try
        {
            // implementer denne
            $stmt = $this->db->prepare("UPDATE studenter SET etternavn= :etternavn, fornavn= :fornavn, klasse= :klasse, mobil= :mobil, www= :www, epost= :epost WHERE id = :id ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':etternavn', $student->hentEtterNavn(), PDO::PARAM_STR);
            $stmt->bindValue(':fornavn', $student->hentForNavn(), PDO::PARAM_STR);
            $stmt->bindValue(':klasse', $student->hentKlasse(), PDO::PARAM_INT);
            $stmt->bindValue(':mobil', $student->hentMobil(), PDO::PARAM_STR);
            $stmt->bindValue(':www', $student->hentURL(), PDO::PARAM_STR);
            $stmt->bindValue(':epost', $student->hentEpost(), PDO::PARAM_STR);
            $result = $stmt->execute();

            if ($result) {
                return true;
            } else {
                echo "Feil ved oppdatering av post!";
                return false;
            }
        } catch(Exception $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }
}