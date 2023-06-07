<?php
include('../Components/_require.php');

//restart session so data can be reset
session_unset();
session_destroy();
session_start();

$_SESSION['success'] = 'Daten zurückgesetzt';

header("Location: " . $_SERVER['url'] . "/kartei/src/index.php");
die();

include('../Components/_header.php');
