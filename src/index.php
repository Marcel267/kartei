<?php
include('Components/_require.php');

// get Kartei aus Session, wenn nicht da lege alles an
if (isset($_SESSION['kartei'])) {
    $kartei = $_SESSION['kartei'];
} else {
    $kartei = new Kartei();
    Freund::$nextId = 1;
    Adresse::$nextId = 1;
    $freund1 = new Freund('Max', 'Mustermann', '01.01.2000', array(new Adresse('12345', 'Berlin', 'Musterstraße 1')));
    Freund::$nextId = 2;
    Adresse::$nextId = 2;
    $freund2 = new Freund('Anna', 'Müller', '02.02.2001', array(new Adresse('23456', 'Hamburg', 'Musterstraße 2')));
    Freund::$nextId = 3;
    $freund3 = new Freund('Anna', 'Müller', '02.02.2001', array());
    $kartei->addFreund($freund1);
    $kartei->addFreund($freund2);
    $kartei->addFreund($freund3);
    $_SESSION['kartei'] = $kartei;
    $_SESSION['nextFreundId'] = 4;
    $_SESSION['nextAdresseId'] = 3;
}

// var_dump($_SESSION['kartei']);

//suche freunde
$freunde = [];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    if (ctype_digit($_GET['search'])) {
        $freund = $kartei->getFreundByKey($_GET['search']);
        $freunde = $freund ? [$freund] : [];
    } else {
        $freunde = $kartei->searchFreundeByNachname($_GET['search']);
    }
} else {
    $freunde = $kartei->getFreunde();
}

$freundeCount = $freunde ? (count($freunde) > 1 ? count($freunde) . " Freunde" : count($freunde) . " Freund") : "Keine Freunde :(";

include('Components/_header.php');
?>

<div class="flex justify-between">
    <div class="flex gap-2 w-full sm:w-96">
        <div class="bg-white dark:bg-gray-900 w-full">
            <form action="index.php" method="get" id="search-form">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input id="search-input" type="text" name="search" id="table-search" class="w-full block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg  bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Suche Freunde" value="<?= isset($_GET['search']) ? $_GET['search'] : "" ?>">
                </div>
            </form>
        </div>

        <div>
            <button id="search-reset" value="" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 flex gap-2 justify-center">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" data-darkreader-inline-fill="">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2.515 10.674a1.875 1.875 0 000 2.652L8.89 19.7c.352.351.829.549 1.326.549H19.5a3 3 0 003-3V6.75a3 3 0 00-3-3h-9.284c-.497 0-.974.198-1.326.55l-6.375 6.374zM12.53 9.22a.75.75 0 10-1.06 1.06L13.19 12l-1.72 1.72a.75.75 0 101.06 1.06l1.72-1.72 1.72 1.72a.75.75 0 101.06-1.06L15.31 12l1.72-1.72a.75.75 0 10-1.06-1.06l-1.72 1.72-1.72-1.72z"></path>
                </svg>
                <span>Reset</span>
            </button>
        </div>
    </div>

    <button type="button" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:focus:ring-yellow-900 flex gap-2 justify-center" data-modal-target="popup-modal-resetData" data-modal-toggle="popup-modal-resetData">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"></path>
        </svg>
        <span>Daten zurücksetzen</span>
    </button>
    <?php
    $modal = new Modal(
        'resetData',
        'Willst du wirklich die Daten zurücksetzen?',
        $_SERVER['url'] . '/kartei/src/Controller/reset_data.php',
        'Ja, zurücksetzen'
    );
    echo $modal->render();
    ?>
</div>

<div class="mt-4">
    <div class="relative overflow-x-auto shadow-md rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                <span>
                    <?= $freundeCount ?>
                </span>
                <span class="float-right">
                    <a href="<?= $_SERVER['url'] . '/kartei/src/Controller/add_freund.php' ?>" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 inline-flex gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" data-darkreader-inline-fill="">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M12 5.25a.75.75 0 01.75.75v5.25H18a.75.75 0 010 1.5h-5.25V18a.75.75 0 01-1.5 0v-5.25H6a.75.75 0 010-1.5h5.25V6a.75.75 0 01.75-.75z"></path>
                        </svg>
                        Freund anlegen
                    </a>
                </span>
            </caption>
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Vorname
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nachnahme
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Geburtsdatum
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Adressen
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($freunde as $freund) { ?>
                    <tr class="bg-white border-t dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?= $freund->getId() ?>
                        </th>
                        <td class="px-6 py-4">
                            <?= $freund->getVorname() ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= $freund->getNachname() ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= $freund->getGeburtsdatum() ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php foreach ($freund->getAdressen() as $adresse) { ?>
                                <?php echo "PLZ: " . $adresse->getPlz() . ", Ort: " . $adresse->getOrt() . ", Straße: " . $adresse->getStraße() . "<br>"; ?>
                            <?php } ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="<?= $_SERVER['url'] ?>/kartei/src/Controller/edit_freund.php?freundId=<?= $freund->getId() ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                Edit
                            </a>
                            <br>
                            <button class="font-medium text-red-600 dark:text-red-500 hover:underline" data-modal-target="popup-modal-<?= $freund->getId() ?>" data-modal-toggle="popup-modal-<?= $freund->getId() ?>">
                                Delete
                            </button>
                        </td>
                    </tr>


                <?php
                    $modal = new Modal(
                        $freund->getId(),
                        'Willst du wirklich ' . $freund->getFullName() . ' löschen?',
                        $_SERVER['url'] . '/kartei/src/Controller/delete_freund.php?freundId=' . $freund->getId(),
                        'Ja, löschen'
                    );
                    echo $modal->render();
                } ?>
            </tbody>
        </table>
    </div>
</div>


<?php include('Components/_footer.php') ?>