<?php

interface FileInterface {

    public function visAlle() : array;                          // Returnerer arrary med File referanser
    public function visFil(int $id) : File;                     // Returnerer referanse til File med angitt id
    public function leggTilFile(File $file) : int;              // Returnerer id for nyopprettet File
    public function oppdaterFil(File $file, int $id) : bool ;   // Returnerer true eller false avhengig av om oppdateringen var vellykket eller ikke

}