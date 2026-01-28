<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <!-- Card Total Santri -->
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center">
            <div
                class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-blue-600 bg-blue-100 rounded-lg dark:bg-blue-900 dark:text-blue-300">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                    </path>
                </svg>
            </div>
            <div class="flex-shrink-0 ml-3">
                <span class="text-2xl font-bold leading-none text-gray-900 dark:text-white"><?= $total_santri ?></span>
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Total Santriii</h3>
            </div>
        </div>
    </div>

    <!-- Card Pending -->
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center">
            <div
                class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-red-600 bg-red-100 rounded-lg dark:bg-red-900 dark:text-red-300">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                    </path>
                </svg>
            </div>
            <div class="flex-shrink-0 ml-3">
                <span
                    class="text-2xl font-bold leading-none text-gray-900 dark:text-white"><?= $total_tagihan_pending ?></span>
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Tagihan Pending</h3>
            </div>
        </div>
    </div>

    <!-- Card Pemasukan -->
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center">
            <div
                class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-green-600 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-300">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="flex-shrink-0 ml-3">
                <span class="text-xl font-bold leading-none text-gray-900 dark:text-white">Rp
                    <?= number_format($pemasukan_bulan_ini, 0, ',', '.') ?></span>
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Income Bln Ini</h3>
            </div>
        </div>
    </div>

    <!-- Card Tunggakan -->
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center">
            <div
                class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-orange-600 bg-orange-100 rounded-lg dark:bg-orange-900 dark:text-orange-300">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="flex-shrink-0 ml-3">
                <span class="text-xl font-bold leading-none text-gray-900 dark:text-white">Rp
                    <?= number_format($total_tunggakan, 0, ',', '.') ?></span>
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Total Tunggakan</h3>
            </div>
        </div>
    </div>
</div>

<div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-8">
    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Selamat Datang,
        <?= $this->session->userdata('username') ?>!
    </h5>
    <p class="font-normal text-gray-700 dark:text-gray-400">Sistem ini memfasilitasi pengelolaan administrasi SPP Santri
        secara terpadu. Gunakan menu navigasi di sebelah kiri untuk mengakses fitur-fitur utama.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Shortcut Section -->
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Akses Cepat</h3>
        <div class="grid grid-cols-2 gap-2">
            <a href="<?= base_url('keuangan/tagihan/generate') ?>"
                class="flex items-center p-3 text-sm font-medium text-gray-900 bg-gray-50 rounded-lg hover:bg-gray-100 group dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white">
                <span class="flex-1 ml-3 whitespace-nowrap">Generate Tagihan</span>
            </a>
            <a href="<?= base_url('keuangan/pembayaran/pending') ?>"
                class="flex items-center p-3 text-sm font-medium text-gray-900 bg-gray-50 rounded-lg hover:bg-gray-100 group dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white">
                <span class="flex-1 ml-3 whitespace-nowrap">Verifikasi Transfer</span>
            </a>
            <a href="<?= base_url('keuangan/laporan/pemasukan') ?>"
                class="flex items-center p-3 text-sm font-medium text-gray-900 bg-gray-50 rounded-lg hover:bg-gray-100 group dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white">
                <span class="flex-1 ml-3 whitespace-nowrap">Laporan Pemasukan</span>
            </a>
            <a href="<?= base_url('keuangan/laporan/tunggakan') ?>"
                class="flex items-center p-3 text-sm font-medium text-gray-900 bg-gray-50 rounded-lg hover:bg-gray-100 group dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white">
                <span class="flex-1 ml-3 whitespace-nowrap">Daftar Tunggakan</span>
            </a>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tren Pemasukan 6 Bulan Terakhir</h3>
        <div class="flex items-end justify-around h-48 pt-4">
            <?php
            $max_val = max($chart_values) ?: 1;
            foreach ($chart_labels as $index => $label):
                $val = $chart_values[$index];
                $height = ($val / $max_val) * 100;
                ?>
                <div class="flex flex-col items-center group w-full">
                    <div class="relative w-8 bg-blue-500 rounded-t-md hover:bg-blue-600 transition-all duration-300"
                        style="height: <?= max(5, $height) ?>%">
                        <div
                            class="absolute -top-8 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-gray-900 text-white text-[10px] py-1 px-2 rounded whitespace-nowrap z-20 transition-opacity">
                            Rp <?= number_format($val, 0, ',', '.') ?>
                        </div>
                    </div>
                    <span class="text-[10px] text-gray-500 mt-2"><?= $label ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>