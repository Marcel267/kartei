<?php
include('../Components/_header.php');

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
$editFreund = $kartei->getFreundByKey($freundId);
if (!$editFreund) {
    echo 'Freund nicht gefunden!';
    exit();
}

$vorname = $editFreund->getVorname();
$nachname = $editFreund->getNachname();
$geburtsdatum = $editFreund->getGeburtsdatum();
$adressen = $editFreund->getAdressen();


$adressenCount = $adressen ? (count($adressen) > 1 ? count($adressen) . " Adressen" : count($adressen) . " Adresse") : "Keine Adresse vorhanden";

//if form submitted
if ($_POST) {
    $errors = $kartei->validateFields(['vorname' => 'string', 'nachname' => 'string', 'geburtsdatum' => 'string']);

    // if form is valid
    if (empty($errors)) {
        $editFreund->setVorname($_POST['vorname']);
        $editFreund->setNachname($_POST['nachname']);
        $editFreund->setGeburtsdatum($_POST['geburtsdatum']);
        // $freund = new Freund();

        $_SESSION['success'] = 'Erfolgreich gespeichert'; //für alert oder so...
        //redirect
        header("Location: " . $_SERVER['url'] . "/kartei/src/index.php");
        die();
    }
}


?>
<h2 class="text-2xl font-semibold dark:text-white mb-5 flex items-center gap-3">
    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"></path>
    </svg>
    Freund bearbeiten
</h2>

<?php include('../Form/_freund.php'); ?>

<div class="flex max-w-2xl flex-wrap gap-5 mt-5 mb-6">
    <?php foreach ($adressen as $adresse) { ?>
        <div class="w-48 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="mb-3">
                <?= $adresse->getPlz() ?> <br>
                <?= $adresse->getOrt() ?><br>
                <?= $adresse->getStraße() ?><br>
            </div>
            <a href="<?= $_SERVER['url'] ?>/kartei/src/Controller/edit_adresse.php?adresseId=<?= $adresse->getId() ?>&freundId=<?= $freundId  ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
            <a href="<?= $_SERVER['url'] ?>/kartei/src/Controller/delete_adresse.php?freundId=<?= $freundId ?>&adresseId=<?= $adresse->getId() ?>" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                Delete
            </a>
        </div>
    <?php } ?>
</div>
<a href="<?= $_SERVER['url'] . '/kartei/src/Controller/add_adresse.php?freundId=' . $freundId ?>" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ">
    Adresse anlegen
</a>

<?php include('../Components/_footer.php');
// var_dump($_POST)
?>