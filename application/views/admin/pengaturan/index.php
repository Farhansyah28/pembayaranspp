<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            <?= $title ?>
        </h2>
    </div>

    <form action="<?= base_url('admin/pengaturan/update') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
            value="<?= $this->security->get_csrf_hash(); ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Info -->
            <div class="space-y-4">
                <div>
                    <label for="nama_pesantren"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Pesantren</label>
                    <input type="text" name="nama_pesantren" id="nama_pesantren"
                        value="<?= $settings->nama_pesantren ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        required>
                </div>
                <div>
                    <label for="telepon_pesantren"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Telepon /
                        WhatsApp</label>
                    <input type="text" name="telepon_pesantren" id="telepon_pesantren"
                        value="<?= $settings->telepon_pesantren ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>
                <div>
                    <label for="alamat_pesantren"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Lengkap</label>
                    <textarea name="alamat_pesantren" id="alamat_pesantren" rows="3"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"><?= $settings->alamat_pesantren ?></textarea>
                </div>
            </div>

            <!-- Logo Branding -->
            <div class="space-y-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Logo Pesantren
                        (Dashboard & Kwitansi)</label>
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex-shrink-0 w-24 h-24 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center dark:border-gray-600 overflow-hidden">
                            <?php if ($settings->logo_pesantren && file_exists('./uploads/branding/' . $settings->logo_pesantren)): ?>
                                <img src="<?= base_url('uploads/branding/' . $settings->logo_pesantren) ?>" alt="Logo"
                                    class="max-w-full max-h-full object-contain">
                            <?php else: ?>
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow">
                            <input type="file" name="logo_pesantren" id="logo_pesantren"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, or GIF (Recomended:
                                512x512px)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-8 border-gray-200 dark:border-gray-700">

        <h3 class="text-lg font-black text-gray-900 dark:text-white mb-6 flex items-center">
            <span class="p-2 bg-indigo-50 text-indigo-600 rounded-lg mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                    </path>
                </svg>
            </span>
            Xendit Payment Gateway (Automated)
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6">
            <div class="space-y-4">
                <div>
                    <label for="xendit_status"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status Fitur</label>
                    <select name="xendit_status" id="xendit_status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="DISABLED" <?= ($settings->xendit_status == 'DISABLED') ? 'selected' : '' ?>>🔴
                            NON-AKTIF (Hidden from Wali)</option>
                        <option value="ENABLED" <?= ($settings->xendit_status == 'ENABLED') ? 'selected' : '' ?>>🟢 AKTIF
                            (Visible to Wali)</option>
                    </select>
                    <p class="mt-2 text-xs text-amber-600 font-medium italic">Status saat ini menentukan apakah tombol
                        "Bayar Online" muncul di halaman parents.</p>
                </div>
                <div>
                    <label for="xendit_secret_key"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Xendit Secret Key</label>
                    <input type="password" name="xendit_secret_key" id="xendit_secret_key"
                        value="<?= $settings->xendit_secret_key ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="xnd_development_...">
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <label for="xendit_callback_token"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Xendit Callback
                        Token</label>
                    <input type="password" name="xendit_callback_token" id="xendit_callback_token"
                        value="<?= $settings->xendit_callback_token ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <p class="mt-2 text-xs text-gray-500">Gunakan token ini untuk verifikasi Webhook di dashboard
                        Xendit.</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-600">
                    <span class="block text-xs font-bold text-gray-400 uppercase mb-2">Webhook URL:</span>
                    <code
                        class="text-xs font-mono text-indigo-600 dark:text-indigo-400 break-all"><?= base_url('xendit_callback') ?></code>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>