<?php
include('../Components/_header.php');

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


// Find the corresponding object from the list
$adressen = $freund->getAdressen();
$editAdresse = null;
foreach ($adressen as $adresse) {
    if ($adresse->getId() == $adressen) {
        $editAdresse = $adresse;
        break;
    }
}

// Check if the object was found
if (!$editAdresse) {
    echo 'Adresse nicht gefunden!';
    exit();
}

$plz = $editAdresse->getPlz();
$ort = $editAdresse->getOrt();
$straße = $editAdresse->getStraße();
$adressen = $editFreund->getAdressen();


// $adressenCount = $adressen ? (count($adressen) > 1 ? count($adressen) . " Adressen" : count($adressen) . " Adresse") : "Keine Adresse vorhanden";

//if form submitted
if ($_POST) {
    $errors = validateFields(['plz' => 'string', 'ort' => 'string', 'straße' => 'string']);

    // if form is valid
    if (empty($errors)) {
        $editAdresse->setPlz($_POST['plz']);
        $editAdresse->setOrt($_POST['ort']);
        $editAdresse->setStraße($_POST['straße']);

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
<h2 class="text-2xl font-semibold dark:text-white mb-5 flex items-center gap-3">
    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z"></path>
    </svg>
    Adressen bearbeiten
</h2>

<div class="max-w-md pb-5">
    <form method="POST">
        <div class="mb-6">
            <label for="plz" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PLZ</label>
            <input type="text" name="plz" id="plz" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= $_POST['plz'] ?? $plz ?>">
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                <span class="font-medium">
                    <?php
                    // echo isset($errors['vornameEmpty']) ? $errors['vornameEmpty'] . '<br>' : '';
                    echo isset($errors['plz']) ? $errors['plz'] : '';
                    ?>
                </span>
            </p>
        </div>
        <div class="mb-6">
            <label for="ort" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ort</label>
            <input type="text" name="ort" id="ort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= $_POST['ort'] ?? $ort ?>">
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                <span class="font-medium">
                    <?php
                    // echo isset($errors['nachnameEmpty']) ? $errors['nachnameEmpty'] . '<br>' : '';
                    echo isset($errors['ort']) ? $errors['ort'] : '';
                    ?>
                </span>
            </p>
        </div>
        <div class="mb-6">
            <label for="straße" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Straße</label>
            <input type="text" name="straße" id="straße" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= $_POST['straße'] ?? $straße ?>">
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                <span class="font-medium">
                    <?php
                    // echo isset($errors['geburtsdatumEmpty']) ? $errors['geburtsdatumEmpty'] . '<br>' : '';
                    echo isset($errors['straße']) ? $errors['straße'] : '';
                    ?>
                </span>
            </p>
        </div>

        <input type="hidden" name="freundId" value="<?= $_GET['freundId']; ?>">
        <input type="hidden" name="adresseId" value="<?= $_GET['adresseId']; ?>">

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
    </form>
</div>

<?php include('../Components/_footer.php'); ?>