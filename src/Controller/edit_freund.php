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

<div class="max-w-md pb-5">
    <form method="POST">
        <div class="mb-6">
            <label for="vorname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vorname</label>
            <input type="text" name="vorname" id="vorname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= $_POST['vorname'] ?? $vorname ?>">
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                <span class="font-medium">
                    <?php
                    echo isset($errors['vorname']) ? $errors['vorname'] : '';
                    ?>
                </span>
            </p>
        </div>
        <div class="mb-6">
            <label for="nachname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nachname</label>
            <input type="text" name="nachname" id="nachname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= $_POST['nachname'] ?? $nachname ?>">
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                <span class="font-medium">
                    <?php
                    echo isset($errors['nachname']) ? $errors['nachname'] : '';
                    ?>
                </span>
            </p>
        </div>
        <div class="mb-6">
            <label for="geburtsdatum" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Geburtsdatum</label>
            <input type="text" name="geburtsdatum" id="geburtsdatum" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= $_POST['geburtsdatum'] ?? $geburtsdatum ?>">
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                <span class="font-medium">
                    <?php
                    echo isset($errors['geburtsdatum']) ? $errors['geburtsdatum'] : '';
                    ?>
                </span>
            </p>
        </div>

        <input type="hidden" name="freundId" value="<?= $_GET['freundId']; ?>">

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
    </form>




    <!-- <div class="pt-5">
        <div class="relative overflow-x-auto shadow-md rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                    <?= $adressenCount ?>
                </caption>
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Plz
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Ort
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Straße
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($adressen as $adresse) { ?>
                        <tr class="bg-white border-t dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= $adresse->getPlz() ?>
                            </th>
                            <td class="px-6 py-4">
                                <?= $adresse->getOrt() ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= $adresse->getStraße() ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="<?= $_SERVER['url'] ?>/kartei/src/Controller/edit_adresse.php?adresseId=<?= $adresse->getId() ?>&freundId=<?= $freundId  ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div> -->
</div>

<div class="flex max-w-2xl flex-wrap gap-5 mt-5">
    <?php foreach ($adressen as $adresse) { ?>
        <div class="w-48 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="mb-3">
                <?= $adresse->getPlz() ?> <br>
                <?= $adresse->getOrt() ?><br>
                <?= $adresse->getStraße() ?><br>
            </div>
            <a href="<?= $_SERVER['url'] ?>/kartei/src/Controller/edit_adresse.php?adresseId=<?= $adresse->getId() ?>&freundId=<?= $freundId  ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
            <a href="<?= $_SERVER['url'] ?>/kartei/src/Controller/delete_adresse.php?freundId=<?= $freund->getId() ?>&adresseId=<?= $adresse->getId() ?>" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                Delete
            </a>
        </div>
    <?php } ?>
</div>





<?php include('../Components/_footer.php');
// var_dump($_POST)
?>