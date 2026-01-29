<div class="mb-4">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Tunggakan</h2>
</div>

<div class="mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">Daftar Santri Belum Lunas</h3>
    </div>
    <div class="flex space-x-2">
        <a href="<?= base_url('keuangan/laporan/export_tunggakan') ?>"
            class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5">Export Excel
            (CSV)</a>
        <button onclick="window.print()"
            class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">Export
            PDF</button>
    </div>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="tabel-tunggakan">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">NIS</th>
                <th scope="col" class="px-6 py-3">Nama Santri</th>
                <th scope="col" class="px-6 py-3">Bulan Tagihan</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Sisa Tagihan</th>
                <th scope="col" class="px-6 py-3 no-print">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_tunggakan = 0;
            foreach ($tunggakan as $t):
                $total_tunggakan += $t->nominal_akhir;
                $bulan_nama = date('F Y', mktime(0, 0, 0, $t->bulan, 10, $t->tahun));
                $wa_msg = "Assalamu'alaikum Ibu/Bapak *{$t->wali_nama}*,\n\nKami dari *{$settings->nama_pesantren}* ingin menginformasikan bahwa santri *{$t->santri_nama}* memiliki tagihan SPP bulan *{$bulan_nama}* sebesar *Rp " . number_format($t->nominal_akhir, 0, ',', '.') . "* yang belum terlunasi.\n\nMohon untuk segera melakukan pembayaran. Terima kasih. 🙏";
                $wa_link = get_instance()->generate_wa_link($t->no_hp, $wa_msg);
                ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        <?= $t->nis ?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        <?= $t->santri_nama ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $bulan_nama ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php if ($t->status == 'CICILAN'): ?>
                            <span class="text-yellow-600 font-medium">Cicilan</span>
                        <?php else: ?>
                            <span class="text-red-600 font-medium">Belum Bayar</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-red-600">Rp
                        <?= number_format($t->nominal_akhir, 0, ',', '.') ?>
                    </td>
                    <td class="px-6 py-4 no-print">
                        <a href="<?= $wa_link ?>" target="_blank"
                            class="inline-flex items-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 focus:outline-none">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .004 5.412 0 12.049a11.82 11.82 0 001.597 5.922L0 24l6.102-1.6c1.848.995 3.931 1.519 6.046 1.52h.005c6.637 0 12.046-5.412 12.05-12.049A11.814 11.814 0 0020.464 3.488z" />
                            </svg>
                            Kirim WA
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($tunggakan)): ?>
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center">Alhamdulillah, tidak ada tunggakan tagihan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot class="bg-gray-50 dark:bg-gray-700">
            <tr class="font-bold text-gray-900 dark:text-white">
                <td colspan="5" class="px-6 py-3 text-right">TOTAL TUNGGAKAN</td>
                <td class="px-6 py-3 text-right">Rp
                    <?= number_format($total_tunggakan, 0, ',', '.') ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>