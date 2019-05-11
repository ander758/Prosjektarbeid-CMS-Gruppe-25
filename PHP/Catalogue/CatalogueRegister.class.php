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
            $stmt = $this->db->query("SELECT * FROM Cataologue ORDER BY Name");
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
            $stmt = $this->db->prepare("SELECT * FROM Cataologue WHERE CatalogueID = :catalogueID");
            $stmt->bindParam(":catalogueID", $CatalogueID, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchObject("Catalogue");
        } catch (InvalidArgumentException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function addCatalogue(Catalogue $catalogue)
    {
            try {
                alert($catalogue->getName());
                alert($catalogue->getCatalogue_CatalogueID());
                $stmt = $this->db->query("INSERT INTO `Cataologue`(`Name`,`Cataologue_CatalogueID`) VALUES (:name, :catalogue_CatalogueID)");

                $stmt->bindValue(':name', $catalogue->getName(), PDO::PARAM_STR);
                $stmt->bindValue(':catalogue_CatalogueID', $catalogue->getCatalogue_CatalogueID(), PDO::PARAM_INT);

                $stmt->execute();
                $result = $stmt->execute();
                if ($result)
                    echo "Catalogue added!";
            } catch (InvalidArgumentException $e) {
                print $e->getMessage() . "Failed adding catalogue!" . PHP_EOL;
            }

    }

    public function fetchLastCatalogueID(): int
    {
        // TODO: Implement fetchLastCatalogueID() method.

    }
}