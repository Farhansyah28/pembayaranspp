<div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-4">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Wali Santri</h2>
    <a href="<?= base_url('keuangan/wali/create') ?>"
        class="text-white bg-primary-700 hover:bg-primary-800 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700">
        Tambah Wali
    </a>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Nama</th>
                <th scope="col" class="px-6 py-3">Username</th>
                <th scope="col" class="px-6 py-3">No HP</th>
                <th scope="col" class="px-6 py-3">Alamat</th>
                <th scope="col" class="px-6 py-3">Status Akun</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wali as $w): ?>
                <?php
                $tunggakan = $w->total_tunggakan ?? 0;
                $wa_msg = "Assalamu'alaikum Ibu/Bapak *{$w->nama}*,\n\nKami dari *{$settings->nama_pesantren}* ingin menginformasikan ringkasan tagihan SPP putra/putri Bapak/Ibu.\n\nTotal tunggakan saat ini: *Rp " . number_format($tunggakan, 0, ',', '.') . "*.\n\nMohon untuk segera melakukan pelunasan. Terima kasih. 🙏";
                $wa_link = get_instance()->generate_wa_link($w->no_hp, $wa_msg);
                ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?= $w->nama ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $w->username ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $w->no_hp ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $w->alamat ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php if ($w->status == 'ACTIVE'): ?>
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Aktif</span>
                        <?php else: ?>
                            <span
                                class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php if ($tunggakan > 0): ?>
                            <a href="<?= $wa_link ?>" target="_blank"
                                class="inline-flex items-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 focus:outline-none"
                                title="Kirim Tagihan Rapel">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .004 5.412 0 12.049a11.82 11.82 0 001.597 5.922L0 24l6.102-1.6c1.848.995 3.931 1.519 6.046 1.52h.005c6.637 0 12.046-5.412 12.05-12.049A11.814 11.814 0 0020.464 3.488z" />
                                </svg>
                                WA Rapel
                            </a>
                        <?php else: ?>
                            <span class="text-xs text-gray-400">Lunas</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>