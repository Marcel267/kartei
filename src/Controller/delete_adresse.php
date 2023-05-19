<?php
include('../Components/_require.php');

if (!isset($_SESSION['kartei'])) {
    echo 'Kartei nicht erhalten!';
    return;
}

$adresseId = $_GET['adresseId'] ?? null;
if (!$adresseId) {
    echo 'Keine adresseId erhalten!';
    exit();
}

$freundId = $_GET['freundId'] ?? null;
if (!$freundId) {
    echo 'Keine freundId erhalten!';
    exit();
}

$kartei = $_SESSION['kartei'];
$freund = $kartei->getFreundByKey($freundId);
if (!$freund) {
    echo 'Freund nicht gefunden!';
    exit();
}

$gefundeneAdresse = $freund->getAdresseByKey($adresseId);
if (!$gefundeneAdresse) {
    echo 'Adresse nicht gefunden!';
    exit();
}


//löschen
$remove = $freund->removeAdresseByKey($adresseId);

if (!$remove) {
    echo 'Adresse konnte nicht entfernt werden';
    exit();
}

$_SESSION['success'] = 'Adresse erfolgreich entfernt';

header("Location: " . $_SERVER['url'] . "/kartei/src/Controller/edit_freund.php?freundId=" . $freundId);
die();

include('../Components/_header.php');
