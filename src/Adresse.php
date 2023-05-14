<?php

class Adresse
{
    private $plz;
    private $ort;
    private $straße;

    public function __construct($plz, $ort, $straße)
    {
        $this->plz = $plz;
        $this->ort = $ort;
        $this->straße = $straße;
    }

    public function getPlz()
    {
        return $this->plz;
    }

    public function getOrt()
    {
        return $this->ort;
    }

    public function getStraße()
    {
        return $this->straße;
    }

    public function setPlz($plz)
    {
        $this->plz = $plz;
    }

    public function setOrt($ort)
    {
        $this->ort = $ort;
    }

    public function setStraße($straße)
    {
        $this->straße = $straße;
    }
}
