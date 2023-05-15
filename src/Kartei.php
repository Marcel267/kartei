<?php

class Kartei
{
    private array $freunde;

    public function __construct()
    {
        $this->freunde = [];
    }

    public function addFreund(Freund $freund): void
    {
        $this->freunde[] = $freund;
    }

    public function getFreundByKey(int $key)
    {
        foreach ($this->freunde as $freund) {
            if ($freund->getId() == $key) {
                return $freund;
            }
        }
        return null;
    }


    public function removeFreundByKey(int $key): bool
    {
        foreach ($this->freunde as $index => $freund) {
            if ($freund->getId() === $key) {
                unset($this->freunde[$index]);
                return true;
            }
        }
        return false;
    }

    public function updateFreundByKey(int $key, Freund $newFreund): bool
    {
        foreach ($this->freunde as $index => $freund) {
            if ($freund->getKey() === $key) {
                $this->freunde[$index] = $newFreund;
                return true;
            }
        }
        return false;
    }

    public function searchFreundeByNachname(string $nachname): array
    {
        $result = [];
        foreach ($this->freunde as $freund) {
            // if (strtolower($freund->getNachname()) === strtolower($nachname)) {
            if (str_contains(strtolower($freund->getNachname()), strtolower($nachname))) {
                $result[] = $freund;
            }
        }
        return $result;
    }

    public function getFreundCount(): int
    {
        return count($this->freunde);
    }

    public function getFreunde(): array
    {
        return $this->freunde;
    }
}
