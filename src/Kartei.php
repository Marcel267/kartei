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

    public function removeFreundByKey(int $key): bool
    {
        foreach ($this->freunde as $index => $freund) {
            if ($freund->getKey() === $key) {
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
            if ($freund->getNachname() === $nachname) {
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
