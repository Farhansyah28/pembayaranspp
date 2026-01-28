<div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-4">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Santri</h2>
    <div class="flex items-center space-x-2">
        <a href="<?= base_url('admin/import') ?>"
            class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-500 dark:hover:bg-green-600 flex items-center">
            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Import Santri
        </a>
        <a href="<?= base_url('keuangan/santri/create') ?>"
            class="text-white bg-primary-700 hover:bg-primary-800 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700">
            Tambah Santri
        </a>
    </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">NIS</th>
                <th scope="col" class="px-6 py-3">Nama</th>
                <th scope="col" class="px-6 py-3">Kelas</th>
                <th scope="col" class="px-6 py-3">Angkatan</th>
                <th scope="col" class="px-6 py-3">Wali</th>
                <th scope="col" class="px-6 py-3">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($santri as $s): ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?= $s->nis ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $s->nama ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $s->kelas_nama ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $s->angkatan_nama ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $s->wali_username ?>
                    </td>
                    <td class="px-6 py-4">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                            <?= $s->status ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>