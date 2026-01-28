<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pembayaran -
        <?= $settings->nama_pesantren ?? 'SPP Pesantren' ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <?php if ($status === 'VALID'): ?>
            <div class="bg-green-500 p-6 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full mb-4">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white uppercase tracking-wider">PEMBAYARAN VALID</h1>
                <p class="text-green-100 opacity-90">Data terverifikasi oleh sistem</p>
            </div>

            <div class="p-6 space-y-4">
                <div class="flex flex-col items-center mb-4">
                    <?php if ($settings->logo_pesantren && file_exists('./uploads/branding/' . $settings->logo_pesantren)): ?>
                        <img src="<?= base_url('uploads/branding/' . $settings->logo_pesantren) ?>" class="h-12 mb-2"
                            alt="Logo">
                    <?php endif; ?>
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-widest text-center">
                        <?= $settings->nama_pesantren ?>
                    </h2>
                </div>

                <div class="border-t border-b border-dashed border-gray-200 py-4 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">No. Transaksi</span>
                        <span class="font-mono font-bold text-gray-800">#PAY-
                            <?= str_pad($p->id, 5, '0', STR_PAD_LEFT) ?>
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Nama Santri</span>
                        <span class="font-bold text-gray-800 text-right">
                            <?= $p->santri_nama ?>
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">NIS</span>
                        <span class="text-gray-800">
                            <?= $p->nis ?>
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Bulan Tagihan</span>
                        <span class="text-gray-800">
                            <?= date('F Y', mktime(0, 0, 0, $p->bulan, 10, $p->tahun)) ?>
                        </span>
                    </div>
                    <div class="flex justify-between pt-2">
                        <span class="text-gray-500 text-sm font-semibold">Total Dibayar</span>
                        <span class="text-green-600 font-extrabold text-xl">Rp
                            <?= number_format($p->jumlah, 0, ',', '.') ?>
                        </span>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-[10px] text-gray-400 italic italic uppercase">
                        Terima kasih atas partisipasi Anda dalam mendukung pendidikan pesantren.
                    </p>
                </div>
            </div>

        <?php elseif ($status === 'INVALID' || $status === 'NOT_FOUND'): ?>
            <div class="bg-red-500 p-6 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full mb-4">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white uppercase tracking-wider">DATA TIDAK VALID</h1>
                <p class="text-red-100 opacity-90">Kwitansi tidak ditemukan atau palsu</p>
            </div>
            <div class="p-8 text-center">
                <p class="text-gray-600 mb-6">Mohon hubungi bagian bendahara untuk pengecekan lebih lanjut.</p>
                <a href="<?= base_url() ?>"
                    class="inline-block bg-gray-800 text-white px-6 py-2 rounded-lg font-medium hover:bg-gray-700 transition">Back
                    to Home</a>
            </div>
        <?php endif; ?>

        <div class="bg-gray-50 p-4 border-t border-gray-100 text-center">
            <span class="text-[10px] text-gray-400 uppercase tracking-tighter">Powered by Smart SPP Pesantren &copy;
                <?= date('Y') ?>
            </span>
        </div>
    </div>

</body>

</html>