<?php

class Kartei
{
    private array $freunde;

    public function __construct()
    {
        $this->freunde = [];
    }

    public function validateFields(array $fields): array
    {
        $errors = [];
        foreach ($fields as $propertyName => $expectedType) {
            if (empty($_POST[$propertyName])) {
                $errors[$propertyName] = $propertyName . ' darf nicht leer sein';
            } elseif ($expectedType === 'numeric' && !is_numeric($_POST[$propertyName])) {
                $errors[$propertyName] = $propertyName . ' muss ein ' . $expectedType . ' sein';
            } elseif ($expectedType === 'string' && is_numeric($_POST[$propertyName])) {
                $errors[$propertyName] = $propertyName . ' muss ein ' . $expectedType . ' sein';
            }
        }
        return $errors;
    }

    public function addFreund(Freund $freund): void
    {
        $this->freunde[] = $freund;
    }

    public function getFreundByKey(int|string $key)
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

    // public function updateFreundByKey(int $key, Freund $newFreund): bool
    // {
    //     foreach ($this->freunde as $index => $freund) {
    //         if ($freund->getKey() === $key) {
    //             $this->freunde[$index] = $newFreund;
    //             return true;
    //         }
    //     }
    //     return false;
    // }

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

    public function getFreunde(): array
    {
        return $this->freunde;
    }
}
