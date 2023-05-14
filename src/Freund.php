<?php

class Freund
{
    private static $nextId = 1;
    private $id;
    private $vorname;
    private $nachname;
    private $geburtsdatum;
    private $adressen = array();

    public function __construct($vorname, $nachname, $geburtsdatum, $adressen)
    {
        $this->id = self::$nextId++;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->geburtsdatum = $geburtsdatum;
        $this->adressen = $adressen;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getVorname()
    {
        return $this->vorname;
    }

    public function getNachname()
    {
        return $this->nachname;
    }

    public function getGeburtsdatum()
    {
        return $this->geburtsdatum;
    }

    public function getAdressen()
    {
        return $this->adressen;
    }

    public function getFullName()
    {
        return $this->vorname . ' ' . $this->nachname;
    }

    public function addAdresse(Adresse $adresse)
    {
        $this->adressen[] = $adresse;
    }

    public function setVorname($vorname)
    {
        $this->vorname = $vorname;
    }

    public function setNachname($nachname)
    {
        $this->nachname = $nachname;
    }

    public function setGeburtsdatum($geburtsdatum)
    {
        $this->geburtsdatum = $geburtsdatum;
    }

    public function setAdressen($adressen)
    {
        $this->adressen = $adressen;
    }
}
