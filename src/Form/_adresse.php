<div class="max-w-md pb-5">
    <form method="POST">
        <div class="mb-6">
            <label for="plz" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PLZ</label>
            <input type="text" name="plz" id="plz" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= $_POST['plz'] ?? $plz ?>">
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                <span class="font-medium">
                    <?php
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
                    echo isset($errors['straße']) ? $errors['straße'] : '';
                    ?>
                </span>
            </p>
        </div>

        <input type="hidden" name="freundId" value="<?= $freundId ?>">

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Speichern</button>
    </form>
</div>