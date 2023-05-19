<?php

class Adresse
{
    // private static int $nextId = 1;
    public static int $nextId;
    private int $id;
    private string $plz;
    private string $ort;
    private string $straße;

    public function __construct(string $plz, string $ort, string $straße)
    {
        $this->id = self::$nextId++;
        $this->plz = $plz;
        $this->ort = $ort;
        $this->straße = $straße;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPlz(): string
    {
        return $this->plz;
    }

    public function getOrt(): string
    {
        return $this->ort;
    }

    public function getStraße(): string
    {
        return $this->straße;
    }

    public function setPlz(string $plz)
    {
        $this->plz = $plz;
    }

    public function setOrt(string $ort)
    {
        $this->ort = $ort;
    }

    public function setStraße(string $straße)
    {
        $this->straße = $straße;
    }
}
