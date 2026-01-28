<div class="mb-4">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Tagihan SPP Anda</h2>
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
                <th scope="col" class="px-6 py-3">Bulan/Tahun</th>
                <th scope="col" class="px-6 py-3">Nominal</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tagihan as $t): ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?= $t->santri_nama ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= date('F', mktime(0, 0, 0, $t->bulan, 10)) ?>
                        <?= $t->tahun ?>
                    </td>
                    <td class="px-6 py-4">Rp
                        <?= number_format($t->nominal_akhir, 0, ',', '.') ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php if ($t->status == 'LUNAS'): ?>
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Lunas</span>
                        <?php else: ?>
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                <?= str_replace('_', ' ', $t->status) ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php if ($t->status != 'LUNAS'): ?>
                            <a href="<?= base_url('wali/tagihan/upload_bukti/' . $t->id) ?>"
                                class="text-white bg-blue-600 hover:bg-blue-700 text-xs font-medium px-3 py-1.5 rounded">Upload
                                Bukti</a>
                        <?php else: ?>
                            <span class="text-gray-400">Selesai</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>