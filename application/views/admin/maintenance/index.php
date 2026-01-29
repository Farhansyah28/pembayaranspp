<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Maintenance & Storage</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Kelola penggunaan ruang penyimpanan server Anda.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Storage Info Cards -->
    <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center space-x-3 mb-4">
            <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 dark:text-white">Total File Bukti</h3>
        </div>
        <p class="text-3xl font-black text-gray-900 dark:text-white">
            <?= number_format($total_files) ?>
        </p>
        <p class="text-sm text-gray-500 mt-1">File tersimpan di /uploads/bukti/</p>
    </div>

    <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center space-x-3 mb-4">
            <div class="p-2 bg-green-100 rounded-lg text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-15 0m15 0v10l-8 4-8-4V7m8 4v10"></path>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 dark:text-white">Ukuran Folder</h3>
        </div>
        <p class="text-3xl font-black text-gray-900 dark:text-white">
            <?= number_format($folder_size / (1024 * 1024), 2) ?> MB
        </p>
        <p class="text-sm text-gray-500 mt-1">Kuota Hosting Bapak: 4,000 MB (4 GB)</p>
    </div>

    <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center space-x-3 mb-4">
            <div class="p-2 bg-amber-100 rounded-lg text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 dark:text-white">File Lama (6 Bln+)</h3>
        </div>
        <p class="text-3xl font-black text-amber-600">
            <?= number_format($old_files_count) ?>
        </p>
        <p class="text-sm text-gray-500 mt-1">File fisik yang sudah aman dihapus</p>
    </div>
</div>

<div class="p-8 bg-white border border-gray-200 rounded-3xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <div class="max-w-2xl mx-auto text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-amber-50 rounded-full mb-6">
            <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                </path>
            </svg>
        </div>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-4">Pembersihan Storage Otomatis</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
            Gunakan fitur ini untuk menghapus <b>file fisik bukti transfer</b> yang usianya sudah lebih dari 6 bulan.
            Tindakan ini hanya akan menghapus file gambar/PDF di server, tapi <b>data riwayat pembayaran di database
                tetap aman</b> dan tidak akan hilang.
        </p>

        > [!IMPORTANT]
        > Menghapus file ini akan menghemat ruang hosting Bapak secara signifikan. Pastikan Bapak sudah melakukan backup
        data tahunan jika diperlukan.

        <div class="mt-8">
            <button onclick="confirmCleanup()"
                class="inline-flex items-center px-8 py-4 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-2xl transition transform hover:scale-105 shadow-xl shadow-amber-200">
                Bersihkan
                <?= $old_files_count ?> File Lama Sekarang
            </button>
        </div>
    </div>
</div>

<script>
    function confirmCleanup() {
        Swal.fire({
            title: 'Yakin bersihkan storage?',
            text: "Anda akan menghapus <?= $old_files_count ?> file bukti transfer lama. Ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Bersihkan!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-xl mr-3',
                cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-3 px-6 rounded-xl'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('admin/maintenance/cleanup') ?>';
            }
        })
    }
</script>