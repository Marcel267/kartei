<?php
require_once 'Kartei.php';
require_once 'Freund.php';
require_once 'Adresse.php';

// neue Kartei anlegen
$kartei = new Kartei();

// neue Freunde hinzufügen
$freund1 = new Freund('Max', 'Mustermann', '01.01.2000', array(new Adresse('12345', 'Berlin', 'Musterstraße 1'), new Adresse('12345', 'Berlin', 'Musterstraße 1')));
$freund2 = new Freund('Anna', 'Müller', '02.02.2001', array(new Adresse('23456', 'Hamburg', 'Musterstraße 2')));
$kartei->addFreund($freund1);
$kartei->addFreund($freund2);

// var_dump($freund1);
// var_dump($freund2);
// die();

// // Freund mit Schlüssel '1' ausgeben
// $freund1_gefunden = $kartei->getFreundByKey(1);
// echo "Freund mit Schlüssel '1': " . $freund1_gefunden->getFullName() . "<hr>";

// // Freund mit Nachnamen 'Müller' ausgeben
// $freunde_mit_müller = $kartei->searchFreundeByNachname('Müller');
// echo "Freunde mit Nachnamen 'Müller': <br>";
// foreach ($freunde_mit_müller as $freund) {
//     echo "- " . $freund->getFullName() . "<br>";
// }
// echo "<hr>";

// print_r($freund1);
// print_r($freund2->getAdressen());
// die();

// Freunde bearbeiten
// $freund2->setVorname('Hannah');
// $freund2->addAdresse(new Adresse('34567', 'Berlin', 'Musterstraße 3'));

// Freunde löschen
// $kartei->removeFreundByKey($freund1->getId());

// var_dump($freund2);
// die();

// alle Freunde ausgeben
// echo "Alle Freunde in der Kartei:<br>";
// foreach ($kartei->getFreunde() as $freund) {
//     echo "- " . $freund->getFullName() . "<br>";
// }
// echo "<hr>";

// Adressliste aller Freunde erstellen
// echo "Adressliste aller Freunde:<br>";
// foreach ($kartei->getFreunde() as $freund) {
//     echo $freund->getId() . ". " . $freund->getFullName() . ":<br>";
//     foreach ($freund->getAdressen() as $adresse) {
//         echo "- " . $adresse->getPlz() . " " . $adresse->getOrt() . ", " . $adresse->getStraße() . "<br>";
//     }
// }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../dist/output.css" rel="stylesheet">
    <title>Document</title>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="bg-white dark:bg-slate-900 container mx-auto min-h-screen pt-5">

    <!-- Darkmode toggle -->
    <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
        </svg>
        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
        </svg>
    </button>

    <div class="pt-5">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                    Freunde
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
                    <?php foreach ($kartei->getFreunde() as $freund) { ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
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
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>


    <script src="script.js"></script>
    <script src="../node_modules/flowbite/dist/flowbite.js"></script>
</body>

</html>