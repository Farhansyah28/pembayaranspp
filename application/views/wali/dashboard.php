<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div
        class="md:col-span-2 p-8 bg-gradient-to-br from-white to-blue-50 border border-blue-100 rounded-2xl shadow-sm dark:from-gray-800 dark:to-gray-900 dark:border-gray-700">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-3">Selamat Datang, <?= $username ?>! 👋</h2>
        <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed">Pantau status pendidikan dan kemudahan
            pembayaran putra-putri Anda melalui portal resmi santri.</p>
    </div>

    <div class="p-8 bg-red-600 rounded-2xl shadow-lg shadow-red-200 dark:shadow-none flex flex-col justify-center">
        <h3 class="text-sm font-bold text-red-100 uppercase tracking-widest mb-2">Total Tunggakan</h3>
        <p class="text-3xl font-black text-white">
            Rp <?= number_format($total_tunggakan, 0, ',', '.') ?>
        </p>
        <?php if ($total_tunggakan > 0): ?>
            <a href="<?= base_url('wali/tagihan') ?>"
                class="mt-4 inline-flex items-center justify-center px-4 py-2 bg-white text-red-600 rounded-xl font-bold text-sm hover:bg-red-50 transition shadow-sm">
                Bayar Sekarang
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="flex items-baseline justify-between mb-6">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Putra / Putri Anda</h3>
    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full"><?= count($anak) ?> Santri</span>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (empty($anak)): ?>
        <div
            class="sm:col-span-2 lg:col-span-3 p-12 text-center bg-gray-50 rounded-3xl border-2 border-dashed border-gray-300 dark:bg-gray-900 dark:border-gray-700">
            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354l1.1-.63a2 2 0 012.773.74l.11.19a2 2 0 002.73.73l.22-.11a2 2 0 012.63.15c.34.34.45.85.29 1.3l-.11.23a2 2 0 00.73 2.73l.19.11a2 2 0 01.74 2.773l-.63 1.1a2 2 0 01-2.773.74l-.11-.19a2 2 0 00-2.73-.73l-.22.11a2 2 0 01-2.63-.15c-.34-.34-.45-.85-.29-1.3l.11-.23a2 2 0 00-.73-2.73l-.19-.11a2 2 0 01-.74-2.773l.63-1.1z">
                    </path>
                </svg>
            </div>
            <p class="text-gray-500 font-medium italic text-lg">Data anak belum tertaut. Silakan hubungi admin Pesantren.
            </p>
        </div>
    <?php else: ?>
        <?php foreach ($anak as $s): ?>
            <div
                class="group p-1 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="bg-white dark:bg-gray-800 rounded-[15px] p-6 h-full flex flex-col">
                    <div class="flex items-center space-x-4 mb-6">
                        <div
                            class="w-16 h-16 bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:rotate-6 transition-transform">
                            <span class="text-2xl">🎓</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white truncate"><?= $s->nama ?></h4>
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400 tracking-wider">NIS: <?= $s->nis ?>
                            </p>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <a href="<?= base_url('wali/tagihan?santri_id=' . $s->id) ?>"
                            class="w-full inline-flex items-center justify-center space-x-2 bg-gray-900 hover:bg-blue-600 text-white dark:bg-gray-700 dark:hover:bg-blue-600 px-6 py-3 rounded-xl font-bold transition-all duration-300">
                            <span>Lihat Tagihan</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>