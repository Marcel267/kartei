<div class="max-w-md pb-5">
    <form method="POST">
        <div class="mb-6">
            <label for="vorname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vorname</label>
            <input type="text" name="vorname" id="vorname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= isset($_POST['vorname']) ? $_POST['vorname'] : (isset($vorname) ? $vorname : '') ?>">
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
            <input type="text" name="nachname" id="nachname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= isset($_POST['nachname']) ? $_POST['nachname'] : (isset($nachname) ? $nachname : '') ?>">
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
            <input type="text" name="geburtsdatum" id="geburtsdatum" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= isset($_POST['geburtsdatum']) ? $_POST['geburtsdatum'] : (isset($geburtsdatum) ? $geburtsdatum : '') ?>">
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                <span class="font-medium">
                    <?php
                    echo isset($errors['geburtsdatum']) ? $errors['geburtsdatum'] : '';
                    ?>
                </span>
            </p>
        </div>

        <input type="hidden" name="freundId" value="<?= isset($freundId) ? $freundId : '' ?>">

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 flex gap-2">
            Speichern
        </button>
    </form>
</div>