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
                    <a href="<?= base_url('keuangan/wali') ?>"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Wali
                        Santri</a>
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

<h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Wali Santri</h2>

<div class="max-w-4xl p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <form action="<?= base_url('keuangan/wali/update/' . $w->id) ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
            value="<?= $this->security->get_csrf_hash() ?>">

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div class="col-span-2">
                <h3 class="text-lg font-semibold dark:text-white border-b pb-2">Data Akun</h3>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                <input type="text" value="<?= $w->username ?>"
                    class="bg-gray-100 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400"
                    disabled>
                <p class="mt-1 text-xs text-gray-500">Username tidak dapat diubah.</p>
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Baru
                    (Kosongkan jika tidak ganti)</label>
                <input type="password" id="password" name="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <?= form_error('password', '<p class="mt-2 text-sm text-red-600">', '</p>') ?>
            </div>
            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status
                    Akun</label>
                <select id="status" name="status"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required>
                    <option value="ACTIVE" <?= set_select('status', 'ACTIVE', $w->status == 'ACTIVE') ?>>Aktif</option>
                    <option value="INACTIVE" <?= set_select('status', 'INACTIVE', $w->status == 'INACTIVE') ?>>Nonaktif
                    </option>
                </select>
            </div>

            <div class="col-span-2 mt-4">
                <h3 class="text-lg font-semibold dark:text-white border-b pb-2">Profil Wali</h3>
            </div>
            <div>
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                    Lengkap</label>
                <input type="text" id="nama" name="nama" value="<?= set_value('nama', $w->nama) ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required>
                <?= form_error('nama', '<p class="mt-2 text-sm text-red-600">', '</p>') ?>
            </div>
            <div>
                <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No HP /
                    WhatsApp</label>
                <input type="text" id="no_hp" name="no_hp" value="<?= set_value('no_hp', $w->no_hp) ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="08123456789" required>
                <?= form_error('no_hp', '<p class="mt-2 text-sm text-red-600">', '</p>') ?>
            </div>
            <div class="col-span-2">
                <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"><?= set_value('alamat', $w->alamat) ?></textarea>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Perbarui
                Data</button>
            <a href="<?= base_url('keuangan/wali') ?>"
                class="text-gray-500 bg-white border border-gray-200 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5">Batal</a>
        </div>
    </form>
</div>