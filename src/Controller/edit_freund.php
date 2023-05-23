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

        $_SESSION['success'] = 'Freund erfolgreich aktualisiert'; //für alert oder so...
        //redirect
        header("Location: " . $_SERVER['url'] . "/kartei/src/index.php");
        die();
    }
}

include('../Components/_header.php');
?>
<h2 class="text-2xl font-semibold dark:text-white mb-5 flex items-center gap-3">
    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"></path>
    </svg>
    Freund bearbeiten
</h2>

<?php include('../Form/_freund.php'); ?>

<h2 class="text-2xl font-semibold dark:text-white mb-5 flex items-center gap-3">
    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z"></path>
    </svg>
    <?= $adressenCount ?>
</h2>

<div class="flex max-w-2xl flex-wrap gap-5 mt-5 mb-6">
    <?php foreach ($adressen as $adresse) { ?>
        <div class="w-48 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="mb-3">
                <?= $adresse->getPlz() ?> <br>
                <?= $adresse->getOrt() ?><br>
                <?= $adresse->getStraße() ?><br>
            </div>
            <a href="<?= $_SERVER['url'] ?>/kartei/src/Controller/edit_adresse.php?adresseId=<?= $adresse->getId() ?>&freundId=<?= $freundId  ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
            <button class="font-medium text-red-600 dark:text-red-500 hover:underline"
            data-modal-target="popup-modal-<?= $adresse->getId() ?>" data-modal-toggle="popup-modal-<?= $adresse->getId() ?>">
                Delete
            </button>
        </div>

        <div id="popup-modal-<?= $adresse->getId() ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="popup-modal-<?= $adresse->getId() ?>">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-6 text-center">
                        <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                            Willst du wirklich die Adresse löschen?
                        </h3>
                        <a href="<?= $_SERVER['url'] ?>/kartei/src/Controller/delete_adresse.php?freundId=<?= $freundId ?>&adresseId=<?= $adresse->getId() ?>" data-modal-hide="popup-modal-<?= $adresse->getId() ?>" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Ja, löschen
                        </a>
                        <button data-modal-hide="popup-modal-<?= $adresse->getId() ?>" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Nein, Abbruch</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<a href="<?= $_SERVER['url'] . '/kartei/src/Controller/add_adresse.php?freundId=' . $freundId ?>" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 inline-flex gap-2">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" data-darkreader-inline-fill="">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M12 5.25a.75.75 0 01.75.75v5.25H18a.75.75 0 010 1.5h-5.25V18a.75.75 0 01-1.5 0v-5.25H6a.75.75 0 010-1.5h5.25V6a.75.75 0 01.75-.75z"></path>
    </svg>
    Adresse anlegen
</a>

<?php include('../Components/_footer.php');
// var_dump($_POST)
?>