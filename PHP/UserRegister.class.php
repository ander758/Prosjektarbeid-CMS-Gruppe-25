<?php
class UserRegister implements UserInterface {
	private $db;
	
	public function __construct(PDO $db) {
		$this->db = $db;
	}

	public function visAlle(): array {
		$users = array();

        try {
            $stmt = $this->db->prepare("SELECT * FROM User"); // TODO -> Ser ut som at 'User' er en SQL syntax her?
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

    public function leggTilUser(User $user) : int {
        try {
            $stmt = $this->db->prepare("INSERT INTO User (UserID, Username, Email, PassHash, FirstName, LastName) VALUES (NULL,:username,:epost,NULL,:fornavn,:etternavn)"); // TODO -> PassHash her?
            $stmt->bindValue(':username', $user->hentUsername(), PDO::PARAM_STR);
            $stmt->bindValue(':epost', $user->hentEpost(), PDO::PARAM_STR);
            $stmt->bindValue(':fornavn', $user->hentForNan(), PDO::PARAM_STR);
            $stmt->bindValue(':etternavn', $user->hentEtterNavn(), PDO::PARAM_STR);
            $result = $stmt->execute();

            if ($result) {
                return true;
            } else {
                echo "Feil ved innlegging av ny bruker!";
                return false;
            }
        } catch (InvalidArgumentException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    // TODO -> Fortsett her
    public function oppdaterUser(User $user, int $id) : bool {
        try {
            $stmt = $this->db->prepare("UPDATE User SET Username= :username, Email= :epost, FirstName= :fornavn, LastName= :etternavn WHERE UserID =:id"); // TODO -> Skal vi ha med 'SET PassHash' her?
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':username', $user->hentUsername(), PDO::PARAM_STR);
            $stmt->bindValue(':epost', $user->hentEpost(), PDO::PARAM_STR);
            $stmt->bindValue(':fornavn', $user->hentFornavn(), PDO::PARAM_STR);
            $stmt->bindValue(':etternavn', $user->hentEtternavn(), PDO::PARAM_STR);
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