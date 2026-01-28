<div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-4">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Keringanan SPP</h2>
    <a href="<?= base_url('keuangan/keringanan/create') ?>"
        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700">
        Tambah Keringanan
    </a>
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
                <th scope="col" class="px-6 py-3">Nama Santri</th>
                <th scope="col" class="px-6 py-3">Tipe</th>
                <th scope="col" class="px-6 py-3 text-right">Nilai</th>
                <th scope="col" class="px-6 py-3 text-center">Periode Berlaku</th>
                <th scope="col" class="px-6 py-3 text-center">Status</th>
                <th scope="col" class="px-6 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($keringanan as $k): ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?= $k->santri_nama ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $k->tipe ?>
                    </td>
                    <td class="px-6 py-4 text-right font-bold">
                        <?= $k->tipe == 'PERSEN' ? $k->nilai . '%' : 'Rp ' . number_format($k->nilai, 0, ',', '.') ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <?= date('d/m/Y', strtotime($k->mulai_berlaku)) ?> -
                        <?= $k->berakhir ? date('d/m/Y', strtotime($k->berakhir)) : 'Selamanya' ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <?php if ($k->aktif): ?>
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Aktif</span>
                        <?php else: ?>
                            <span
                                class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <?php if ($k->aktif): ?>
                            <a href="<?= base_url('keuangan/keringanan/nonaktifkan/' . $k->id) ?>"
                                class="text-red-600 dark:text-red-500 hover:underline"
                                onclick="return confirm('Apakah Anda yakin ingin menonaktifkan keringanan ini?')">Matikan</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>