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

        <div class="mt-6 flex justify-end">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>