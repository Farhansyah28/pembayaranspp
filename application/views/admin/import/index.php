<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold dark:text-white">Import Data Santri & Wali</h2>
        <a href="<?= base_url('admin/import/template') ?>"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 transition">
            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Download Template CSV
        </a>
    </div>

    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h3 class="mb-4 text-lg font-semibold dark:text-white text-yellow-600 flex items-center">
            <svg class="w-5 h-5 me-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"></path>
            </svg>
            Petunjuk Import
        </h3>
        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400 list-disc list-inside">
            <li>Gunakan file template CSV yang telah disediakan.</li>
            <li>Gunakan delimiter <strong>titik koma (;)</strong>.</li>
            <li><strong>Username Wali</strong> akan otomatis menggunakan Nomor HP Wali.</li>
            <li><strong>Password Wali</strong> akan otomatis menggunakan Tanggal Lahir Santri (Format: <code
                    class="bg-gray-100 px-1 rounded">DDMMYYYY</code>, contoh: 30012010).</li>
            <li>Petunjuk: <strong>Nama Kelas</strong> dan <strong>Alamat</strong> sekarang bersifat opsional (boleh
                kosong).</li>
            <li>Jika <strong>Nama Kelas</strong> diisi, pastikan sama persis dengan yang ada di sistem (contoh: Kelas 1
                SMP). Jika dikosongkan, santri akan tetap masuk namun belum memiliki kelas.</li>
            <li>Kolom <strong>Tahun Masuk</strong> diisi angka tahun (contoh: 2024). Sistem akan otomatis membuat data
                Angkatan jika belum ada.</li>
            <li>Jenis Kelamin diisi <code class="bg-gray-100 px-1 rounded">L</code> untuk Laki-laki dan <code
                    class="bg-gray-100 px-1 rounded">P</code> untuk Perempuan.</li>
        </ul>
    </div>

    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <form action="<?= base_url('admin/import/process') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                value="<?= $this->security->get_csrf_hash(); ?>">
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_csv">Upload File
                    CSV</label>
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    id="file_csv" name="file_csv" type="file" accept=".csv" required>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">Hanya file .csv yang diperbolehkan.</p>
            </div>
            <button type="submit"
                class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition transform active:scale-95 flex items-center justify-center">
                <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                    </path>
                </svg>
                Proses Import Data
            </button>
        </form>
    </div>
</div>