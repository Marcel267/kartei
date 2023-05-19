<?php
include('../Components/_require.php');

if (!isset($_SESSION['kartei'])) {
    echo 'Kartei nicht erhalten!';
    return;
}

$freundId = $_GET['freundId'] ?? null;
if (!$freundId) {
    echo 'Keine Id erhalten!';
    exit();
}

$kartei = $_SESSION['kartei'];
$gefundeneFreund = $kartei->getFreundByKey($freundId);
if (!$gefundeneFreund) {
    echo 'Freund nicht gefunden!';
    exit();
}

//löschen
$remove = $kartei->removeFreundByKey($freundId);
if (!$remove) {
    echo 'Freund konnte nicht entfernt werden';
    exit();
}

$_SESSION['success'] = 'Freund erfolgreich entfernt';

header("Location: " . $_SERVER['url'] . "/kartei/src/index.php");
die();

include('../Components/_header.php');
