<?php
//TEST
include('Components/_header.php');

// get Kartei aus Session, wenn nicht da lege alles an
if (isset($_SESSION['kartei'])) {
    $kartei = $_SESSION['kartei'];
} else {
    $kartei = new Kartei();
    $freund1 = new Freund('Max', 'Mustermann', '01.01.2000', array(
        new Adresse('12345', 'Berlin', 'Musterstraße 1'),
        new Adresse('12345', 'Berlin', 'Musterstraße 1'),
        new Adresse('12345', 'Berlin', 'Musterstraße 1'),
        new Adresse('12345', 'Berlin', 'Musterstraße 1'),
        new Adresse('12345', 'Berlin', 'Musterstraße 1'),
    ));
    $freund2 = new Freund('Anna', 'Müller', '02.02.2001', array(new Adresse('23456', 'Hamburg', 'Musterstraße 2')));
    $freund3 = new Freund('Anna', 'Müller', '02.02.2001', array());
    $kartei->addFreund($freund1);
    $kartei->addFreund($freund2);
    $kartei->addFreund($freund3);
    $_SESSION['kartei'] = $kartei;
}
// session_destroy();
// var_dump($_SESSION['kartei']);
// print_r($_SESSION['kartei']);
//suche freunde
$freunde = [];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $freunde =
        $kartei->getFreundByKey($_GET['search']) ? [$kartei->getFreundByKey($_GET['search'])]
        :
        $kartei->searchFreundeByNachname($_GET['search']);
} else {
    $freunde = $kartei->getFreunde();
}

$freundeCount = $freunde ? (count($freunde) > 1 ? count($freunde) . " Freunde" : count($freunde) . " Freund") : "Keine Freunde :(";

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

        <button id="search-reset" value="" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Reset
        </button>

    </div>

    <!-- <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
        </svg>
        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
        </svg>
    </button> -->
</div>

<div class="pt-5">
    <div class="relative overflow-x-auto shadow-md rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                <?= $freundeCount ?>
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
                            <a href="<?= $_SERVER['url'] ?>/kartei/src/Controller/delete_freund.php?freundId=<?= $freund->getId() ?>" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<?php include('Components/_footer.php') ?>