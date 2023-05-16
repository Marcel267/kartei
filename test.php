<?php

// Klasse Adresse zur Verwaltung der Adressen
class Adresse
{
    private $strasse;
    private $plz;
    private $ort;

    // Konstruktor
    public function __construct($strasse, $plz, $ort)
    {
        $this->strasse = $strasse;
        $this->plz = $plz;
        $this->ort = $ort;
    }

    // Getter-Methoden
    public function getStrasse()
    {
        return $this->strasse;
    }

    public function getPlz()
    {
        return $this->plz;
    }

    public function getOrt()
    {
        return $this->ort;
    }

    // Setter-Methoden
    public function setStrasse($strasse)
    {
        $this->strasse = $strasse;
    }

    public function setPlz($plz)
    {
        $this->plz = $plz;
    }

    public function setOrt($ort)
    {
        $this->ort = $ort;
    }
}

// Klasse Freund zur Verwaltung der Freunde
class Freund
{
    private $vorname;
    private $nachname;
    private $geburtsdatum;
    private $adressen = array(); // Array zur Speicherung der Adressen des Freundes
    private $schluessel;

    // Konstruktor
    public function __construct($vorname, $nachname, $geburtsdatum, $adresse, $schluessel)
    {
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->geburtsdatum = $geburtsdatum;
        $this->adressen[] = $adresse;
        $this->schluessel = $schluessel;
    }

    // Getter-Methoden
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

    public function getSchluessel()
    {
        return $this->schluessel;
    }

    // Setter-Methoden
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

    // Methode zum Hinzufügen einer neuen Adresse
    public function addAdresse($adresse)
    {
        $this->adressen[] = $adresse;
    }

    // Methode zum Löschen einer Adresse
    public function deleteAdresse($index)
    {
        unset($this->adressen[$index]);
        $this->adressen = array_values($this->adressen); // Indizes neu zuweisen
    }
}
class Kartei
{
    private $freunde = array();

    public function getFreunde()
    {
        return $this->freunde;
    }

    public function addFreund($freund)
    {
        if ($freund instanceof Freund) {
            $this->freunde[] = $freund;
        } else {
            throw new Exception('Ungültiger Typ');
        }
    }

    public function removeFreund($index)
    {
        if (isset($this->freunde[$index])) {
            unset($this->freunde[$index]);
            $this->freunde = array_values($this->freunde); // Reindex the array
        } else {
            throw new Exception('Freund nicht gefunden');
        }
    }

    public function updateFreund($index, $freund)
    {
        if (isset($this->freunde[$index])) {
            if ($freund instanceof Freund) {
                $this->freunde[$index] = $freund;
            } else {
                throw new Exception('Ungültiger Typ');
            }
        } else {
            throw new Exception('Freund nicht gefunden');
        }
    }

    public function searchFreunde($nachname)
    {
        $result = array();
        foreach ($this->freunde as $freund) {
            if (strtolower($freund->getNachname()) === strtolower($nachname)) {
                $result[] = $freund;
            }
        }
        return $result;
    }

    public function getAnzahlFreunde()
    {
        return count($this->freunde);
    }
}


// Kartei-Objekt erstellen
$kartei = new Kartei();

// Adressen erstellen
$adresse1 = new Adresse("12345", "Berlin", "Musterstraße 1");
$adresse2 = new Adresse("54321", "Hamburg", "Musterweg 2");

// Freund-Objekte erstellen
$freund1 = new Freund("Max", "Mustermann", "01.01.1990", [$adresse1, $adresse2], 1);
// $freund1->addAdresse($adresse1);
// $freund1->addAdresse($adresse2);

$freund2 = new Freund("Lisa", "Musterfrau", "02.02.1995", [$adresse1, $adresse2], 2);
$freund2->addAdresse($adresse1);

// Freunde der Kartei hinzufügen
$kartei->addFreund($freund1);
$kartei->addFreund($freund2);

// Anzahl der Freunde in der Kartei ausgeben
echo "Anzahl der Freunde in der Kartei: " . $kartei->getAnzahlFreunde() . "\n";

// Freund suchen und ausgeben
// $gefundenerFreund = $kartei->sucheFreund("Mustermann");
// if ($gefundenerFreund) {
//     echo "Gefundener Freund: " . $gefundenerFreund->getVorname() . " " . $gefundenerFreund->getNachname() . "\n";
// } else {
//     echo "Freund nicht gefunden.\n";
// }

// // Freund bearbeiten
// $gefundenerFreund = $kartei->sucheFreund("Musterfrau");
// if ($gefundenerFreund) {
//     $gefundenerFreund->setGeburtsdatum("03.03.1997");
//     echo "Geburtsdatum geändert.\n";
// } else {
//     echo "Freund nicht gefunden.\n";
// }

// // Freund löschen
// $gefundenerFreund = $kartei->sucheFreund("Musterfrau");
// if ($gefundenerFreund) {
//     $kartei->loescheFreund($gefundenerFreund->getSchluessel());
//     echo "Freund gelöscht.\n";
// } else {
//     echo "Freund nicht gefunden.\n";
// }

// // Adressliste aller Freunde ausgeben
// echo "Adressliste aller Freunde:\n";
// foreach ($kartei->getAlleFreunde() as $freund) {
//     echo $freund->getVorname() . " " . $freund->getNachname() . ":\n";
//     foreach ($freund->getAdressen() as $adresse) {
//         echo "- " . $adresse->getStrasse() . ", " . $adresse->getPlz() . " " . $adresse->getOrt() . "\n";
//     }
// }
// _____________________________________

// print_r($kartei);
// die();


// var_dump($freund1);
// var_dump($freund2);
// die();

// // Freund mit Schlüssel '1' ausgeben
// $freund1_gefunden = $kartei->getFreundByKey(1);
// echo "Freund mit Schlüssel '1': " . $freund1_gefunden->getFullName() . "<hr>";

// // Freund mit Nachnamen 'Müller' ausgeben
// $freunde_mit_müller = $kartei->searchFreundeByNachname('Müller');
// echo "Freunde mit Nachnamen 'Müller': <br>";
// foreach ($freunde_mit_müller as $freund) {
//     echo "- " . $freund->getFullName() . "<br>";
// }
// echo "<hr>";

// print_r($freund1);
// print_r($freund2->getAdressen());
// die();

// Freunde bearbeiten
// $freund2->setVorname('Hannah');
// $freund2->addAdresse(new Adresse('34567', 'Berlin', 'Musterstraße 3'));

// Freunde löschen
// $kartei->removeFreundByKey($freund1->getId());

// var_dump($freund2);
// die();

// alle Freunde ausgeben
// echo "Alle Freunde in der Kartei:<br>";
// foreach ($kartei->getFreunde() as $freund) {
//     echo "- " . $freund->getFullName() . "<br>";
// }
// echo "<hr>";

// Adressliste aller Freunde erstellen
// echo "Adressliste aller Freunde:<br>";
// foreach ($kartei->getFreunde() as $freund) {
//     echo $freund->getId() . ". " . $freund->getFullName() . ":<br>";
//     foreach ($freund->getAdressen() as $adresse) {
//         echo "- " . $adresse->getPlz() . " " . $adresse->getOrt() . ", " . $adresse->getStraße() . "<br>";
//     }
// }
