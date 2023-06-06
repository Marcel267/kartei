<?php
include('../Components/_require.php');

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

        $_SESSION['success'] = 'Adresse erfolgreich angelegt';
        //redirect
        header("Location: " . $_SERVER['url'] . "/kartei/src/Controller/edit_freund.php?freundId=" . $freundId);
        die();
    }
}

include('../Components/_header.php');
?>
<h2 class="text-2xl font-semibold dark:text-white mb-5 flex items-center gap-3">
    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z"></path>
    </svg>
    Adresse anlegen
</h2>



<?php
include('../Form/_adresse.php');
include('../Components/_footer.php');
?>