<?php

class Adresse
{
    private string $plz;
    private string $ort;
    private string $straße;

    public function __construct(string $plz, string $ort, string $straße)
    {
        $this->plz = $plz;
        $this->ort = $ort;
        $this->straße = $straße;
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
