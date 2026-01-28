<div class="mb-4">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Entri Pembayaran Tunai</h2>
</div>

<div class="max-w-2xl p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <form action="<?= base_url('keuangan/pembayaran/process_cash') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
            value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
            value="<?= $this->security->get_csrf_hash() ?>">

        <div class="mb-4">
            <label for="tagihan_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                Tagihan</label>
            <select id="tagihan_id" name="tagihan_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white select2"
                required>
                <option value="">Cari NIS atau Nama Santri...</option>
                <?php foreach ($tagihan_list as $t): ?>
                    <option value="<?= $t->id ?>">
                        [
                        <?= $t->nis ?>]
                        <?= $t->santri_nama ?> -
                        Bulan
                        <?= date('M Y', mktime(0, 0, 0, $t->bulan, 10, $t->tahun)) ?>
                        (Sisa: Rp
                        <?= number_format($t->nominal_akhir - $t->jumlah_dibayar, 0, ',', '.') ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal
                Bayar</label>
            <input type="number" id="nominal" name="nominal"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                required>
        </div>

        <div class="mb-4">
            <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                Bayar</label>
            <input type="date" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                required>
        </div>

        <div class="mb-6">
            <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan
                (Opsional)</label>
            <textarea id="keterangan" name="keterangan" rows="2"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
        </div>

        <button type="submit"
            class="w-full text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Proses
            Bayar Lunas/Cicil</button>
    </form>
</div>