<?php

class Freund
{
    private static int $nextId = 1;
    private int $id;
    private string $vorname;
    private string $nachname;
    private string $geburtsdatum;
    private array $adressen;

    public function __construct(string $vorname, string $nachname, string $geburtsdatum, array $adressen)
    {
        $this->id = self::$nextId++;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->geburtsdatum = $geburtsdatum;
        $this->adressen = $adressen;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getVorname(): string
    {
        return $this->vorname;
    }

    public function getNachname(): string
    {
        return $this->nachname;
    }

    public function getGeburtsdatum(): string
    {
        return $this->geburtsdatum;
    }

    public function getAdressen(): array
    {
        return $this->adressen;
    }

    public function getFullName(): string
    {
        return $this->vorname . ' ' . $this->nachname;
    }

    public function addAdresse(Adresse $adresse)
    {
        $this->adressen[] = $adresse;
    }

    public function setVorname(string $vorname)
    {
        $this->vorname = $vorname;
    }

    public function setNachname(string $nachname)
    {
        $this->nachname = $nachname;
    }

    public function setGeburtsdatum(string $geburtsdatum)
    {
        $this->geburtsdatum = $geburtsdatum;
    }

    public function setAdressen(array $adressen)
    {
        $this->adressen = $adressen;
    }
}
