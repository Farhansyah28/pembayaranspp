<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Tagihan SPP Anda</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Daftar riwayat dan kewajiban pembayaran SPP putra-putri Anda.
        </p>
    </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="p-4 mb-6 text-sm text-green-800 rounded-2xl bg-green-50 border border-green-100 flex items-center space-x-2"
        role="alert">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="font-medium"><?= $this->session->flashdata('success') ?></span>
    </div>
<?php endif; ?>

<!-- Desktop Table (Visible on md and up) -->
<div
    class="hidden md:block overflow-hidden shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-4 font-bold">Santri</th>
                <th scope="col" class="px-6 py-4 font-bold">Bulan / Tahun</th>
                <th scope="col" class="px-6 py-4 font-bold text-right">Nominal</th>
                <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <?php foreach ($tagihan as $t): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white"><?= $t->santri_nama ?></td>
                    <td class="px-6 py-4"><?= date('F', mktime(0, 0, 0, $t->bulan, 10)) ?>     <?= $t->tahun ?></td>
                    <td class="px-6 py-4 text-right font-mono font-bold text-gray-900 dark:text-white">Rp
                        <?= number_format($t->nominal_akhir, 0, ',', '.') ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <?php
                        $statusClass = $t->status == 'LUNAS' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700';
                        if ($t->status == 'BELUM_BAYAR')
                            $statusClass = 'bg-red-100 text-red-700';
                        ?>
                        <span class="<?= $statusClass ?> text-[10px] font-black uppercase px-2.5 py-1 rounded-lg">
                            <?= str_replace('_', ' ', $t->status) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center space-y-2">
                        <?php if ($t->status == 'LUNAS' && $t->verified_pembayaran_id): ?>
                            <a href="<?= base_url('wali/tagihan/kwitansi/' . $t->verified_pembayaran_id) ?>" target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                📄 Cetak Kwitansi
                            </a>
                        <?php elseif ($t->bukti_status == 'PENDING'): ?>
                            <div class="flex flex-col items-center justify-center text-amber-500">
                                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-[10px] font-black uppercase">Menunggu Verifikasi</span>
                            </div>
                        <?php elseif ($t->status == 'BELUM_BAYAR'): ?>
                            <a href="<?= base_url('wali/tagihan/upload_bukti/' . $t->id) ?>"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                Upload Bukti
                            </a>
                        <?php else: ?>
                            <div class="flex items-center justify-center text-green-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                    </path>
                                </svg>
                                <span class="ml-1 text-xs font-bold">Terverifikasi</span>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Mobile Cards (Visible on small screens) -->
<div class="grid grid-cols-1 gap-4 md:hidden">
    <?php foreach ($tagihan as $t): ?>
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-black text-gray-900 dark:text-white"><?= $t->santri_nama ?></h4>
                    <p class="text-xs text-gray-500"><?= date('F Y', mktime(0, 0, 0, $t->bulan, 10, $t->tahun)) ?></p>
                </div>
                <?php
                $statusClass = $t->status == 'LUNAS' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700';
                if ($t->status == 'BELUM_BAYAR')
                    $statusClass = 'bg-red-100 text-red-700';
                ?>
                <span class="<?= $statusClass ?> text-[10px] font-black uppercase px-2 py-1 rounded-md">
                    <?= str_replace('_', ' ', $t->status) ?>
                </span>
            </div>

            <div class="flex items-center justify-between mb-5">
                <span class="text-xs text-gray-400">Total Tagihan</span>
                <span class="text-lg font-black text-gray-900 dark:text-white">Rp
                    <?= number_format($t->nominal_akhir, 0, ',', '.') ?></span>
            </div>

            <?php if ($t->status == 'LUNAS' && $t->verified_pembayaran_id): ?>
                <a href="<?= base_url('wali/tagihan/kwitansi/' . $t->verified_pembayaran_id) ?>" target="_blank"
                    class="w-full flex items-center justify-center py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-md">
                    📄 Cetak Kwitansi Sah
                </a>
            <?php elseif ($t->bukti_status == 'PENDING'): ?>
                <div
                    class="w-full py-3 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 rounded-xl font-bold flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Menunggu Verifikasi Admin
                </div>
            <?php elseif ($t->status == 'BELUM_BAYAR'): ?>
                <a href="<?= base_url('wali/tagihan/upload_bukti/' . $t->id) ?>"
                    class="w-full flex items-center justify-center py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-md">
                    Upload Bukti Pembayaran
                </a>
            <?php else: ?>
                <div
                    class="w-full py-3 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded-xl font-bold flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Terbayar Lunas
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <?php if (empty($tagihan)): ?>
        <div
            class="p-8 text-center bg-gray-50 dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
            <p class="text-gray-400 italic">Belum ada data tagihan tertampil.</p>
        </div>
    <?php endif; ?>
</div>