<?php
interface FileInterface {
    public function visAlle() : array;                          // Returnerer arrary med File referanser
    public function visFil(int $id) : File;                     // Returnerer referanse til File med angitt id
    public function leggTilFile(File $file) : int;              // Returnerer id for nyopprettet File
    public function oppdaterFil(File $file, int $id) : bool;   // Returnerer bool for status ved oppdatering av fil
    public function slettFil(File $file, int $id) : bool;       // Returnerer bool for status ved sletting av fil
}