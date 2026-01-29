<div class="mb-8">
    <nav class="flex" aria-label="Breadcrumb">
        <ol
            class="inline-flex items-center space-x-1 md:space-x-3 bg-gray-50 dark:bg-gray-800/50 px-4 py-2 rounded-xl border border-gray-100 dark:border-gray-700">
            <li class="inline-flex items-center">
                <a href="<?= base_url('wali/tagihan') ?>"
                    class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011-1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                        </path>
                    </svg>
                    Tagihan
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-bold text-gray-900 dark:text-gray-300">Upload Bukti</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<div class="max-w-2xl mx-auto">
    <div class="mb-8 text-center md:text-left">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white">Konfirmasi Pembayaran</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-2 text-lg">Unggah bukti transfer Anda untuk verifikasi otomatis
            oleh admin.</p>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl shadow-blue-100/50 dark:shadow-none border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-8 bg-blue-600">
            <div class="flex justify-between items-center text-white">
                <div>
                    <span class="text-blue-100 text-xs font-bold uppercase tracking-widest">Tagihan Periode</span>
                    <h3 class="text-xl font-black mt-1">
                        <?= date('F Y', mktime(0, 0, 0, $tagihan->bulan, 10, $tagihan->tahun)) ?></h3>
                </div>
                <div class="text-right">
                    <span class="text-blue-100 text-xs font-bold uppercase tracking-widest">Total Bayar</span>
                    <h3 class="text-2xl font-black mt-1">Rp <?= number_format($tagihan->nominal_akhir, 0, ',', '.') ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="p-8">
            <?php if ($this->session->flashdata('error')): ?>
                <div class="p-4 mb-6 text-sm text-red-800 rounded-2xl bg-red-50 border border-red-100 flex items-center"
                    role="alert">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 112 0 1 1 0 01-2 0zm-1 9a1 1 0 102 0v-3a1 1 0 00-2 0v3z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-bold"><?= $this->session->flashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('wali/tagihan/do_upload/' . $tagihan->id) ?>" method="POST"
                enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                    value="<?= $this->security->get_csrf_hash() ?>">

                <div>
                    <label for="nominal"
                        class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wide">Nominal
                        Transfer (Rp)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-400 font-bold">Rp</span>
                        </div>
                        <input type="number" id="nominal" name="nominal" value="<?= $tagihan->nominal_akhir ?>"
                            class="block w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-gray-700 border-2 border-gray-100 dark:border-gray-600 text-gray-900 dark:text-white font-black text-xl rounded-2xl focus:ring-blue-500 focus:border-blue-500 transition-all"
                            required>
                    </div>
                </div>

                <div>
                    <label
                        class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wide"
                        for="foto_bukti">File Bukti / Screenshot</label>
                    <label
                        class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-200 border-dashed rounded-2xl cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 transition-colors"
                        for="foto_bukti">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4-4m4 4v12"></path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-bold">Tekan untuk pilih file
                                atau foto</p>
                            <p class="text-xs text-gray-400 uppercase tracking-tighter">JPG, PNG, PDF (Max 2MB)</p>
                        </div>
                        <input id="foto_bukti" name="foto_bukti" type="file" class="hidden" required
                            onchange="updateFileName(this)">
                    </label>
                    <p id="file-name-display" class="mt-2 text-xs font-bold text-blue-600 text-center"></p>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full flex items-center justify-center space-x-3 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-black rounded-2xl text-lg px-8 py-5 text-center transition-all shadow-xl shadow-blue-200 dark:shadow-none transform active:scale-95">
                        <span>Konfirmasi & Unggah</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                    <a href="<?= base_url('wali/tagihan') ?>"
                        class="block w-full text-center mt-4 text-sm font-bold text-gray-400 hover:text-gray-600 transition">Batal
                        dan Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : '';
        document.getElementById('file-name-display').textContent = fileName ? 'File terpilih: ' + fileName : '';
    }
</script>