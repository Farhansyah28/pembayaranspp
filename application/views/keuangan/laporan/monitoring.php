<div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-4">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <?= $title ?>
    </h2>
    <?php if ($ta_selected): ?>
        <a href="<?= base_url('keuangan/laporan/export_monitoring?tahun_ajaran_id=' . $ta_selected->id) ?>"
            class="flex items-center justify-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
            Export Excel (CSV)
        </a>
    <?php endif; ?>
</div>

<!-- Filter -->
<div class="p-4 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <form action="<?= base_url('keuangan/laporan/monitoring') ?>" method="GET" class="flex flex-wrap items-end gap-4">
        <div class="w-full md:w-48">
            <label for="tahun_ajaran_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun
                Ajaran</label>
            <select name="tahun_ajaran_id" id="tahun_ajaran_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <?php foreach ($tahun_ajaran_list as $ta): ?>
                    <option value="<?= $ta->id ?>" <?= ($ta_selected && $ta_selected->id == $ta->id) ? 'selected' : '' ?>>
                        <?= $ta->nama ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="w-full md:w-48">
            <label for="angkatan_id"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Angkatan</label>
            <select name="angkatan_id" id="angkatan_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <option value="">Semua Angkatan</option>
                <?php foreach ($angkatan_list as $a): ?>
                    <option value="<?= $a->id ?>" <?= ($angkatan_id == $a->id) ? 'selected' : '' ?>><?= $a->nama ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="w-full md:w-64">
            <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cari
                Nama/NIS</label>
            <input type="text" name="search" id="search" value="<?= $search ?>" placeholder="Ketik nama atau nis..."
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
        </div>
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Tampilkan
        </button>
    </form>
</div>

<?php if (!$ta_selected): ?>
    <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
        role="alert">
        Silakan pilih Tahun Ajaran terlebih dahulu.
    </div>
<?php else: ?>
    <!-- Legend -->
    <div
        class="flex flex-wrap gap-4 mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-green-500 rounded"></div>
            <span class="text-sm dark:text-white">Lunas</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-yellow-400 rounded"></div>
            <span class="text-sm dark:text-white">Cicilan</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-red-500 rounded"></div>
            <span class="text-sm dark:text-white">Belum Bayar</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-gray-300 rounded"></div>
            <span class="text-sm dark:text-white">Belum Generate</span>
        </div>
    </div>

    <!-- Matrix Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col"
                        class="px-4 py-3 text-left sticky left-0 bg-gray-50 dark:bg-gray-700 z-10 w-48 shadow-[1px_0_0_0_rgba(0,0,0,0.1)]">
                        Nama Santri</th>
                    <th scope="col" class="px-4 py-3 whitespace-nowrap">Angkatan</th>
                    <?php foreach ($months as $m): ?>
                        <th scope="col" class="px-2 py-3 whitespace-nowrap">
                            <?= date('M y', mktime(0, 0, 0, $m['bulan'], 10, $m['tahun'])) ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($santri as $s): ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td
                            class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-left sticky left-0 bg-white dark:bg-gray-800 z-10 shadow-[1px_0_0_0_rgba(0,0,0,0.1)]">
                            <?= $s['nama'] ?>
                            <p class="text-[10px] text-gray-400">
                                <?= $s['nis'] ?>
                            </p>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <?= $s['angkatan_nama'] ?>
                        </td>
                        <?php foreach ($months as $mn): ?>
                            <?php
                            $t = isset($tagihan_map[$s['id']][$mn['bulan']][$mn['tahun']]) ? $tagihan_map[$s['id']][$mn['bulan']][$mn['tahun']] : null;
                            $color = 'bg-gray-300';
                            $link = '#';
                            if ($t) {
                                $link = base_url('keuangan/pembayaran/detail/' . $t['id']);
                                if ($t['status'] == 'LUNAS')
                                    $color = 'bg-green-500';
                                elseif ($t['status'] == 'CICILAN')
                                    $color = 'bg-yellow-400';
                                else
                                    $color = 'bg-red-500';
                            }
                            ?>
                            <td class="px-2 py-4">
                                <a href="<?= $link ?>"
                                    class="block w-6 h-6 mx-auto rounded <?= $color ?> hover:opacity-75 transition-opacity"
                                    title="<?= $t ? $t['status'] : 'Belum Generate' ?>"></a>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex flex-col md:flex-row justify-between items-center space-y-3 md:space-y-0">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Menampilkan <span class="font-bold"><?= count($santri) ?></span> data santri.
        </p>
        <nav aria-label="Table navigation">
            <?= $pagination ?>
        </nav>
    </div>
<?php endif; ?>