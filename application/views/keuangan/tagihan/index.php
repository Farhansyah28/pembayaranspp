<div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-4">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Data Tagihan SPP</h2>
    <a href="<?= base_url('keuangan/tagihan/generate') ?>"
        class="text-white bg-primary-700 hover:bg-primary-800 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 confirm-action"
        data-title="Generate Tagihan?"
        data-text="Sistem akan membuat tagihan SPP untuk semua santri aktif di bulan ini."
        data-confirm-text="Ya, Generate!" data-icon="info">
        Generate Tagihan Baru
    </a>
</div>

</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Bulan/Tahun</th>
                <th scope="col" class="px-6 py-3">Nama Santri</th>
                <th scope="col" class="px-6 py-3">Nominal Akhir</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tagihan as $t): ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?= date('F', mktime(0, 0, 0, $t->bulan, 10)) ?>
                        <?= $t->tahun ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $t->santri_nama ?> (<?= $t->nis ?>)
                    </td>
                    <td class="px-6 py-4">Rp
                        <?= number_format($t->nominal_akhir, 0, ',', '.') ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php if ($t->status == 'LUNAS'): ?>
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Lunas</span>
                        <?php elseif ($t->status == 'CICILAN'): ?>
                            <span
                                class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Dicicil</span>
                        <?php else: ?>
                            <span
                                class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Belum
                                Bayar</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <a href="<?= base_url('keuangan/pembayaran/detail/' . $t->id) ?>"
                            class="text-blue-600 dark:text-blue-500 hover:underline">Detail</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>