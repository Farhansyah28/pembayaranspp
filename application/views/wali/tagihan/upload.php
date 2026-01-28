<div class="mb-4">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li><a href="<?= base_url('wali/tagihan') ?>"
                    class="text-sm font-medium text-gray-700 hover:text-blue-600">Tagihan</a></li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500">Upload Bukti</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Upload Bukti Transfer</h2>

<div class="max-w-md p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="mb-4 p-4 text-sm text-blue-800 bg-blue-50 rounded-lg">
        <p>Tagihan: <strong>
                <?= date('F Y', mktime(0, 0, 0, $tagihan->bulan, 10, $tagihan->tahun)) ?>
            </strong></p>
        <p>Total: <strong>Rp
                <?= number_format($tagihan->nominal_akhir, 0, ',', '.') ?>
            </strong></p>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('wali/tagihan/do_upload/' . $tagihan->id) ?>" method="POST"
        enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
            value="<?= $this->security->get_csrf_hash() ?>">

        <div class="mb-4">
            <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal yang
                Ditransfer</label>
            <input type="number" id="nominal" name="nominal" value="<?= $tagihan->nominal_akhir ?>"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="foto_bukti">Foto Bukti /
                PDF</label>
            <input
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700"
                id="foto_bukti" name="foto_bukti" type="file" required>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Format: JPG, PNG, PDF (Max 2MB)</p>
        </div>

        <button type="submit"
            class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Kirim
            Bukti</button>
    </form>
</div>