<div class="mb-4">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Log Aktivitas Sistem</h2>
    <p class="text-sm text-gray-500">Menampilkan 100 aktivitas terbaru di sistem.</p>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Waktu</th>
                <th scope="col" class="px-6 py-3">User</th>
                <th scope="col" class="px-6 py-3">Modul</th>
                <th scope="col" class="px-6 py-3">Aktivitas</th>
                <th scope="col" class="px-6 py-3">IP Address</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $l): ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?= $l->created_at ?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        <?= html_escape($l->username) ?>
                    </td>
                    <td class="px-6 py-4">
                        <span
                            class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                            <?= html_escape($l->modul) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <?= html_escape($l->aktivitas) ?>
                    </td>
                    <td class="px-6 py-4 text-xs">
                        <?= $l->ip_address ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>