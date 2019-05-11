<?php
class CatalogueRegister implements CatalogueInterface {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function showAllCatalogues(): array
    {
        $catalogues = array();
        try {
            $stmt = $this->db->query("SELECT * FROM Catalogue ORDER BY Name");
            $stmt->execute();
            while ($catalogue = $stmt->fetchObject("Catalogue")) {
                $catalogues[] = $catalogue;
            }
        } catch (Exception $e) {
            print $e->getMessage() . PHP_EOL;
        }
        return $catalogues;
    }

    public function showCatalogue(int $CatalogueID): Catalogue
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM Catalogue WHERE CatalogueID = :catalogueID");
            $stmt->bindParam(":catalogueID", $CatalogueID, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchObject("Catalogue");
        } catch (InvalidArgumentException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function addCatalogue(string $Name, int $Catalogue_CatalogueID)
    {
        if ($Catalogue_CatalogueID != 0) {
            // Add master Catalogue
            try {
                $stmt = $this->db->prepare("INSERT INTO `Catalogue`(`Name`,`Catalogue_CatalogueID`) VALUES (:name, :catalogue_CatalogueID)");
                $stmt->bindParam(':name', $Name);
                $stmt->bindParam(':catalogue_CatalogueID', $Catalogue_CatalogueID);

                $result = $stmt->execute();
                if ($result) {
                    alert("Katalog lastet opp!");
                    return true;
                } else {
                    alert("Katalog ble ikke lastet opp!");
                    return false;
                }
            } catch (InvalidArgumentException $e) {
                print $e->getMessage() . "Failed adding catalogue!" . PHP_EOL;
            }
        } else {
            // Add sub Catalogue
            try {
                $stmt = $this->db->prepare("INSERT INTO `Catalogue`(`Name`) VALUES (:name)");
                $stmt->bindParam(':name', $Name);

                $result = $stmt->execute();
                if ($result) {
                    alert("Katalog lastet opp!");
                    return true;
                } else {
                    alert("Katalog ble ikke lastet opp!");
                    return false;
                }
            } catch (InvalidArgumentException $e) {
                print $e->getMessage() . "Failed adding catalogue!" . PHP_EOL;
            }
        }



        //if ($catalogue->getCatalogue_CatalogueID() != 0) {
        $bool = NULL;
            try {
                $stmt = $this->db->prepare("INSERT INTO `Catalogue`(`Name`,`Catalogue_CatalogueID`) VALUES (:name, :catalogue_CatalogueID)");
                $stmt->bindParam(':name', $Name);
                if ($Catalogue_CatalogueID == 0)
                    $stmt->bindParam(':catalogue_CatalogueID', $bool);
                else
                    $stmt->bindParam(':catalogue_CatalogueID', $Catalogue_CatalogueID);

                $result = $stmt->execute();
                if ($result) {
                    alert("Katalog lastet opp!");
                    return true;
                } else {
                    alert("Katalog ble ikke lastet opp!");
                    return false;
                }
            } catch (InvalidArgumentException $e) {
                print $e->getMessage() . "Failed adding catalogue!" . PHP_EOL;
            }
        /*} else if ($catalogue->getCatalogue_CatalogueID() == NULL) {
            try {
                // Add as master catalogue (Catalogue_CatalogueID = null)
                $stmt = $this->db->prepare("INSERT INTO `Catalogue`(`Name`,`Catalogue_CatalogueID`) VALUES (:name, NULL)");
                $stmt->bindValue(':name', $catalogue->getName(), PDO::PARAM_STR);

                $stmt->execute();
                $result = $stmt->execute();
                if ($result)
                    echo "Catalogue added!";
            } catch (InvalidArgumentException $e) {
                print $e->getMessage() . "Failed adding catalogue!" . PHP_EOL;
            }
        }*/
    }

    public function fetchLastCatalogueID(): int
    {
        // TODO: Implement fetchLastCatalogueID() method.

    }
}