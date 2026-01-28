<div class="mb-4">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Verifikasi Pembayaran Transfer</h2>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Wali</th>
                <th scope="col" class="px-6 py-3">Tagihan</th>
                <th scope="col" class="px-6 py-3">Nominal</th>
                <th scope="col" class="px-6 py-3">Bukti</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pending_list as $p): ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?= $p->wali_username ?>
                    </td>
                    <td class="px-6 py-4">Bulan
                        <?= date('M Y', mktime(0, 0, 0, $p->bulan, 10, $p->tahun)) ?>
                    </td>
                    <td class="px-6 py-4">Rp <?= number_format($p->jumlah, 0, ',', '.') ?></td>
                    <td class="px-6 py-4">
                        <a href="<?= base_url('uploads/bukti/' . $p->foto_bukti) ?>" target="_blank"
                            class="text-blue-600 hover:underline">Lihat Bukti</a>
                    </td>
                    <td class="px-6 py-4 flex space-x-2">
                        <a href="<?= base_url('keuangan/pembayaran/verify/' . $p->id . '/SUCCESS') ?>"
                            class="bg-green-600 text-white text-xs px-3 py-1.5 rounded"
                            onclick="return confirm('Terima pembayaran ini?')">Terima</a>
                        <a href="<?= base_url('keuangan/pembayaran/verify/' . $p->id . '/FAILED') ?>"
                            class="bg-red-600 text-white text-xs px-3 py-1.5 rounded"
                            onclick="return confirm('Tolak pembayaran ini?')">Tolak</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($pending_list)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center">Tidak ada verifikasi tertunda.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>