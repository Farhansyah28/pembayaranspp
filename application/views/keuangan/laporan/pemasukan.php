<div class="mb-4">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Pemasukan</h2>
</div>

<div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-6">
    <form action="<?= base_url('keuangan/laporan/pemasukan') ?>" method="GET"
        class="grid gap-4 md:grid-cols-3 items-end">
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Mulai</label>
            <input type="date" name="start_date" value="<?= $start_date ?>"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Selesai</label>
            <input type="date" name="end_date" value="<?= $end_date ?>"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>
        <div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Filter
                Laporan</button>
        </div>
    </form>
</div>

<div class="mb-4 flex justify-between items-center">
    <span class="text-lg font-semibold dark:text-white">Total Pemasukan: <span class="text-green-600">Rp
            <?= number_format($total, 0, ',', '.') ?>
        </span></span>
    <div class="flex space-x-2">
        <a href="<?= base_url('keuangan/laporan/export_pemasukan?start_date=' . $start_date . '&end_date=' . $end_date) ?>"
            class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5">Export Excel
            (CSV)</a>
        <button onclick="window.print()"
            class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">Cetak
            / PDF</button>
    </div>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Tanggal</th>
                <th scope="col" class="px-6 py-3">Nama Santri</th>
                <th scope="col" class="px-6 py-3">Tagihan</th>
                <th scope="col" class="px-6 py-3">Metode</th>
                <th scope="col" class="px-6 py-3">Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pemasukan as $p): ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        <?= date('d/m/Y H:i', strtotime($p->tanggal_bayar)) ?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        <?= $p->santri_nama ?>
                    </td>
                    <td class="px-6 py-4">Bulan
                        <?= date('M Y', mktime(0, 0, 0, $p->bulan, 10, $p->tahun)) ?>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                            <?= $p->metode ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-semibold">Rp
                        <?= number_format($p->jumlah, 0, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($pemasukan)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center">Tidak ada data untuk periode ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>