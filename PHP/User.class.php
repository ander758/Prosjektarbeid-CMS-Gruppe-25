<?php
class student {
    private $id;
    private $username;
    private $epost;
    private $fornavn;
    private $etternavn;

    function __construct() {
    }

    // Getters
    function hentId() {
        return $this->id;
    }
    function hentUsername() {
        return $this->username;
    }
    function hentEpost() {
        return $this->epost;
    }
    function hentForNavn() {
        return $this->fornavn;
    }
    function hentEtterNavn() {
        return $this->etternavn;
    }
    function hentNavn() {
        return $this->fornavn . " " . $this->etternavn;
    }

    // Setters
    function settEpost($epost) {
        $this->epost = $epost;
    }
    function settForNavn($fornavn) {
        $this->fornavn = $fornavn;
    }
    function settEtterNavn($etterNavn) {
        $this->etternavn = $etterNavn;
    }
}
?>