<?php
include('../Components/_header.php');

if (!isset($_SESSION['kartei'])) {
    echo 'Kartei nicht erhalten!';
    return;
}
$kartei = $_SESSION['kartei'];

$freundId = $_GET['freundId'] ?? null;
if (!$freundId) {
    echo 'Keine freundId erhalten!';
    exit();
}
$freund = $kartei->getFreundByKey($freundId);
if (!$freund) {
    echo 'Freund nicht gefunden!';
    exit();
}

//to use the form
$plz = '';
$ort = '';
$straße = '';
// $adresseId = '';

//if form submitted
if ($_POST) {
    $errors = $kartei->validateFields(['plz' => 'numeric', 'ort' => 'string', 'straße' => 'string']);

    // if form is valid
    if (empty($errors)) {
        $nextId = $_SESSION['nextAdresseId'];
        Adresse::$nextId = $nextId;
        $newAdresse = new Adresse($_POST['plz'], $_POST['ort'], $_POST['straße']);
        $freund->addAdresse($newAdresse);
        $_SESSION['nextAdresseId'] = $nextId + 1;

        $_SESSION['success'] = 'Adresse erfolgreich angelegt'; //für alert oder so...
        //redirect
        header("Location: " . $_SERVER['url'] . "/kartei/src/Controller/edit_freund.php?freundId=" . $freundId);
        die();
    }
}


?>
<h2 class="text-2xl font-semibold dark:text-white mb-5 flex items-center gap-3">
    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"></path>
    </svg>
    Freund anlegen
</h2>



<?php
include('../Form/_adresse.php');
include('../Components/_footer.php');
// var_dump($_POST)
?>