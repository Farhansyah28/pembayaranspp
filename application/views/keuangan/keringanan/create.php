<div class="mb-4">
    <a href="<?= base_url('keuangan/keringanan') ?>" class="text-blue-600 hover:underline flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
            </path>
        </svg>
        Kembali ke Daftar
    </a>
</div>

<div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Tambah Keringanan Baru</h2>

    <form action="<?= base_url('keuangan/keringanan/store') ?>" method="POST" class="space-y-6">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
            value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
            value="<?= $this->security->get_csrf_hash() ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="santri_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                    Santri</label>
                <select id="santri_id" name="santri_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    required>
                    <option value="">-- Pilih Santri --</option>
                    <?php foreach ($santri as $s): ?>
                        <option value="<?= $s->id ?>">
                            <?= $s->nama ?> (
                            <?= $s->nis ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="tipe" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe
                        Potongan</label>
                    <select id="tipe" name="tipe"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        required>
                        <option value="PERSEN">Persentase (%)</option>
                        <option value="NOMINAL">Nominal Rupiah (Rp)</option>
                    </select>
                </div>
                <div>
                    <label for="nilai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai
                        Potongan</label>
                    <input type="number" name="nilai" id="nilai"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        placeholder="Misal: 50 atau 50000" required>
                </div>
            </div>

            <div>
                <label for="mulai_berlaku" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                    Mulai Berlaku</label>
                <input type="date" name="mulai_berlaku" id="mulai_berlaku" value="<?= date('Y-m-d') ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    required>
            </div>

            <div>
                <label for="berakhir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                    Berakhir (Opsional)</label>
                <input type="date" name="berakhir" id="berakhir"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
            </div>

            <div class="md:col-span-2">
                <label for="alasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alasan
                    Keringanan</label>
                <textarea id="alasan" name="alasan" rows="3"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Contoh: Santri Yatim / Prestasi" required></textarea>
            </div>
        </div>

        <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div>
                <span class="font-medium">Perhatian!</span> Jika santri sudah memiliki keringanan aktif, maka keringanan
                lama akan otomatis dinonaktifkan.
            </div>
        </div>

        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Simpan Keringanan
        </button>
    </form>
</div>