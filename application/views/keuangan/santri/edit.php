<div class="mb-4">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="<?= base_url('dashboard') ?>"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="<?= base_url('keuangan/santri') ?>"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Santri</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Edit</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Santri</h2>

<div class="max-w-4xl p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <form action="<?= base_url('keuangan/santri/update/' . $s->id) ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
            value="<?= $this->security->get_csrf_hash() ?>">

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="nis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIS</label>
                <input type="text" id="nis" name="nis" value="<?= set_value('nis', $s->nis) ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required>
                <?= form_error('nis', '<p class="mt-2 text-sm text-red-600">', '</p>') ?>
            </div>
            <div>
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                    Lengkap</label>
                <input type="text" id="nama" name="nama" value="<?= set_value('nama', $s->nama) ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required>
                <?= form_error('nama', '<p class="mt-2 text-sm text-red-600">', '</p>') ?>
            </div>

            <div>
                <label for="angkatan_id"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Angkatan</label>
                <select id="angkatan_id" name="angkatan_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required>
                    <option value="">Pilih Angkatan</option>
                    <?php foreach ($angkatan as $a): ?>
                        <option value="<?= $a->id ?>" <?= set_select('angkatan_id', $a->id, $a->id == $s->angkatan_id) ?>>
                            <?= $a->nama ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('angkatan_id', '<p class="mt-2 text-sm text-red-600">', '</p>') ?>
            </div>

            <div>
                <label for="wali_user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Wali
                    Santri</label>
                <select id="wali_user_id" name="wali_user_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required>
                    <option value="">Pilih Wali</option>
                    <?php foreach ($wali as $w): ?>
                        <option value="<?= $w->id ?>" <?= set_select('wali_user_id', $w->id, $w->id == $s->wali_user_id) ?>>
                            <?= $w->nama ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('wali_user_id', '<p class="mt-2 text-sm text-red-600">', '</p>') ?>
            </div>
            <div>
                <label for="jenis_kelamin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis
                    Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required>
                    <option value="L" <?= set_select('jenis_kelamin', 'L', $s->jenis_kelamin == 'L') ?>>Laki-laki
                    </option>
                    <option value="P" <?= set_select('jenis_kelamin', 'P', $s->jenis_kelamin == 'P') ?>>Perempuan
                    </option>
                </select>
                <?= form_error('jenis_kelamin', '<p class="mt-2 text-sm text-red-600">', '</p>') ?>
            </div>
            <div>
                <label for="tanggal_lahir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                    Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                    value="<?= set_value('tanggal_lahir', $s->tanggal_lahir) ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                <select id="status" name="status"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required>
                    <option value="ACTIVE" <?= set_select('status', 'ACTIVE', $s->status == 'ACTIVE') ?>>Aktif</option>
                    <option value="INACTIVE" <?= set_select('status', 'INACTIVE', $s->status == 'INACTIVE') ?>>Nonaktif
                    </option>
                    <option value="LULUS" <?= set_select('status', 'LULUS', $s->status == 'LULUS') ?>>Lulus</option>
                    <option value="KELUAR" <?= set_select('status', 'KELUAR', $s->status == 'KELUAR') ?>>Keluar</option>
                </select>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Perbarui
                Santri</button>
            <a href="<?= base_url('keuangan/santri') ?>"
                class="text-gray-500 bg-white border border-gray-200 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5">Batal</a>
        </div>
    </form>
</div>