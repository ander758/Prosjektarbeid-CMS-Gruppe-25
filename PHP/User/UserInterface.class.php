<?php
interface UserInterface {
    public function visAlle() : array;                          // Returnerer array med User referanser
    public function visAlleFiler(User $user) : array;           // Returnerer array med alle filer for en user
    public function visUser(int $id) : User;                    // Returnerer referanse til User med angitt id
    public function leggTilUser(User $user) : int;              // Returnerer id for nyopprettet User
    public function oppdaterUser(User $user, int $id) : bool;   // Returnerer true eller false avhengig av om oppdateringen var vellykket eller ikke
}