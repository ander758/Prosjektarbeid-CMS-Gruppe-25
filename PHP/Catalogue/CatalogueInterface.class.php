<?php
interface CatalogueInterface {
    public function showAllCatalogues() : array;                    // Return array with all catalogues
    public function showCatalogue(int $CatalogueID) : Catalogue;    // Return specific Catalogue
    public function addCatalogue(Catalogue $catalogue) : int;      // Return ID for added Catalogue in table
}