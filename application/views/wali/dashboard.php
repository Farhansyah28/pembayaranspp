<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div
        class="md:col-span-2 p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Selamat Datang, <?= $username ?>!</h2>
        <p class="text-gray-600 dark:text-gray-400">Silakan pantau status pendidikan dan pembayaran putra-putri Anda
            melalui portal ini.</p>
    </div>
    <div class="p-6 bg-red-50 border border-red-200 rounded-lg shadow-sm dark:border-red-900 dark:bg-gray-800">
        <h3 class="text-xs font-semibold text-red-600 uppercase mb-1">Total Belum Terbayar</h3>
        <p class="text-2xl font-bold text-red-700 dark:text-red-400">Rp
            <?= number_format($total_tunggakan, 0, ',', '.') ?></p>
    </div>
</div>

<h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Daftar Putra/Putri</h3>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <?php if (empty($anak)): ?>
        <div
            class="md:col-span-2 p-10 text-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 dark:bg-gray-900 dark:border-gray-700">
            <p class="text-gray-500">Data anak belum tertaut ke akun Anda. Silakan hubungi admin.</p>
        </div>
    <?php else: ?>
        <?php foreach ($anak as $s): ?>
            <div
                class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex items-start space-x-4">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white"><?= $s->nama ?></h4>
                    <p class="text-sm text-gray-500 mb-2">NIS: <?= $s->nis ?> | Kelas: <?= $s->kelas_nama ?></p>
                    <div class="flex space-x-2">
                        <a href="<?= base_url('wali/tagihan?santri_id=' . $s->id) ?>"
                            class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md font-medium transition">Lihat
                            Tagihan</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>