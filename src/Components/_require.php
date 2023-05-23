<?php
require_once __DIR__ . '/../Entity/Kartei.php';
require_once __DIR__ . '/../Entity/Freund.php';
require_once __DIR__ . '/../Entity/Adresse.php';
require_once __DIR__ . '/Modal.php';
$_SERVER['url'] = 'http://localhost/workspace/schule';
// $_SERVER['url'] = 'http://localhost/code';

session_start();

if (isset($_SESSION['success'])) {
    $nachricht = $_SESSION['success'];
    unset($_SESSION['success']);
}
