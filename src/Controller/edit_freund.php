<?php

include('../Components/_header.php');

//get freunde
if (!isset($_SESSION['kartei'])) {
    echo 'Kartei nicht erhalten!';
    return;
}
$kartei = $_SESSION['kartei'];
$freunde = $kartei->getFreunde();

// Get object ID from the query parameter
$freundId = $_GET['id'] ?? null;

if (!$freundId) {
    echo 'Keine Id erhalten!';
    exit();
}

// Find the corresponding object from the list
$editFreund = null;
foreach ($freunde as $freund) {
    if ($freund->getId() == $freundId) {
        $editFreund = $freund;
        break;
    }
}

// Check if the object was found
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
    $errors = validateFields(['vorname' => 'string', 'nachname' => 'string', 'geburtsdatum' => 'string']);

    // if form is valid
    if (empty($errors)) {
        $editFreund->setVorname($_POST['vorname']);
        $editFreund->setNachname($_POST['nachname']);
        $editFreund->setGeburtsdatum($_POST['geburtsdatum']);

        // $_SESSION['nachricht'] = 'Erfolgreich gespeichert'; für alert oder so...
        //villeicht redirect
    }
}

function validateFields(array $fields): array
{
    $errors = [];
    foreach ($fields as $propertyName => $expectedType) {
        if (empty($_POST[$propertyName])) {
            $errors[$propertyName] = $propertyName . ' ist leer';
        } elseif ($expectedType === 'numeric' && !is_numeric($_POST[$propertyName])) {
            $errors[$propertyName] = $propertyName . ' muss ein ' . $expectedType . ' sein';
        } elseif ($expectedType === 'string' && is_numeric($_POST[$propertyName])) {
            $errors[$propertyName] = $propertyName . ' muss ein ' . $expectedType . ' sein';
        }
    }
    return $errors;
}


?>

<div class="max-w-md pb-5">
    <form method="POST">
        <div class="mb-6">
            <label for="vorname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vorname</label>
            <input type="text" name="vorname" id="vorname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= $_POST['vorname'] ?? $vorname ?>">
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                <span class="font-medium">
                    <?php
                    // echo isset($errors['vornameEmpty']) ? $errors['vornameEmpty'] . '<br>' : '';
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
                    // echo isset($errors['nachnameEmpty']) ? $errors['nachnameEmpty'] . '<br>' : '';
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
                    // echo isset($errors['geburtsdatumEmpty']) ? $errors['geburtsdatumEmpty'] . '<br>' : '';
                    echo isset($errors['geburtsdatum']) ? $errors['geburtsdatum'] : '';
                    ?>
                </span>
            </p>
        </div>

        <input type="hidden" name="id" value="<?= $_GET['id']; ?>">

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
                                <a href="Controller/edit_freund.php?id=<?= $freund->getId() ?>&kartei=<?= urlencode(serialize($kartei)) ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div> -->
</div>

<!-- <div class="grid grid-rows-3 grid-flow-col gap-5"> -->
<div class="flex max-w-lg flex-wrap gap-5">
    <?php foreach ($adressen as $adresse) { ?>
        <div class="max-w-fit p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="mb-3">
                <?= $adresse->getPlz() ?> <br>
                <?= $adresse->getOrt() ?><br>
                <?= $adresse->getStraße() ?><br>
            </div>
            <a href="Controller/edit_freund.php?id=<?= $freund->getId() ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
        </div>
    <?php } ?>
</div>





<?php include('../Components/_footer.php');
// var_dump($_POST)
?>