<div class="mb-4">
    <a href="<?= base_url('keuangan/tagihan') ?>" class="text-blue-600 hover:underline flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
            </path>
        </svg>
        Kembali ke Daftar Tagihan
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Student & Bill Info -->
    <div class="md:col-span-1 space-y-6">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Profil Santri</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nama Lengkap</p>
                    <p class="font-medium text-gray-900 dark:text-white">
                        <?= $tagihan->santri_nama ?>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">NIS</p>
                    <p class="font-medium text-gray-900 dark:text-white">
                        <?= $tagihan->nis ?>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Angkatan</p>
                    <p class="font-medium text-gray-900 dark:text-white">
                        <?= $tagihan->angkatan_nama ?: '-' ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Detail Tagihan</h3>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Bulan/Tahun:</span>
                    <span class="font-medium text-gray-900 dark:text-white">
                        <?= date('F Y', mktime(0, 0, 0, $tagihan->bulan, 10, $tagihan->tahun)) ?>
                    </span>
                </div>
                <div class="flex justify-between border-t pt-2">
                    <span class="text-gray-500 dark:text-gray-400">Tarif Dasar:</span>
                    <span class="font-medium text-gray-900 dark:text-white">Rp
                        <?= number_format($tagihan->tarif_awal, 0, ',', '.') ?>
                    </span>
                </div>
                <div class="flex justify-between text-red-600">
                    <span>Potongan/Keringanan:</span>
                    <span>- Rp
                        <?= number_format($tagihan->potongan, 0, ',', '.') ?>
                    </span>
                </div>
                <div class="flex justify-between border-t pt-2 text-lg font-bold">
                    <span class="text-gray-900 dark:text-white">Total Tagihan:</span>
                    <span class="text-blue-600">Rp
                        <?= number_format($tagihan->nominal_akhir, 0, ',', '.') ?>
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Sudah Dibayar:</span>
                    <span class="text-green-600 font-bold">Rp
                        <?= number_format($tagihan->jumlah_dibayar, 0, ',', '.') ?>
                    </span>
                </div>
                <div class="flex justify-between border-t pt-2">
                    <span class="text-gray-900 dark:text-white">Status:</span>
                    <?php if ($tagihan->status == 'LUNAS'): ?>
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Lunas</span>
                    <?php elseif ($tagihan->status == 'CICILAN'): ?>
                        <span
                            class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Cicilan</span>
                    <?php else: ?>
                        <span
                            class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Belum
                            Bayar</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment History -->
    <div class="md:col-span-2">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Riwayat Transaksi</h3>
            <?php if (empty($pembayaran)): ?>
                <div class="p-4 text-sm text-gray-500 bg-gray-50 rounded-lg dark:bg-gray-700 dark:text-gray-300">
                    Belum ada data pembayaran untuk tagihan ini.
                </div>
            <?php else: ?>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Tanggal</th>
                                <th scope="col" class="px-4 py-3">Metode</th>
                                <th scope="col" class="px-4 py-3">Admin</th>
                                <th scope="col" class="px-4 py-3 text-right">Jumlah</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pembayaran as $p): ?>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-4 py-3">
                                        <?= date('d/m/Y H:i', strtotime($p->tanggal_bayar)) ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="<?= $p->metode == 'CASH' ? 'text-blue-600' : 'text-purple-600' ?> font-semibold">
                                            <?= $p->metode ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?= $p->admin_nama ?? '-' ?>
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold">Rp
                                        <?= number_format($p->jumlah, 0, ',', '.') ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php if ($p->status == 'VERIFIED'): ?>
                                            <span class="text-green-600 font-medium">Berhasil</span>
                                        <?php elseif ($p->status == 'PENDING'): ?>
                                            <span class="text-yellow-600 font-medium">Menunggu</span>
                                        <?php else: ?>
                                            <span class="text-red-600 font-medium">Ditolak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <?php if ($p->status == 'VERIFIED'): ?>
                                            <a href="<?= base_url('keuangan/pembayaran/nota/' . $p->id) ?>" target="_blank"
                                                class="text-blue-600 hover:underline">Cetak</a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>