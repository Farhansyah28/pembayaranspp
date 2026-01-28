<div class="mb-4">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Profil Saya</h2>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<div class="max-w-md p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center space-x-4 mb-6">
        <img class="w-20 h-20 rounded-full"
            src="https://ui-avatars.com/api/?name=<?= str_replace(' ', '+', $username) ?>&background=random&size=128"
            alt="Avatar">
        <div>
            <h3 class="text-xl font-bold dark:text-white">
                <?= $username ?>
            </h3>
            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                <?= $role ?>
            </span>
        </div>
    </div>

    <form action="<?= base_url('profile/update') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
            value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
            value="<?= $this->security->get_csrf_hash() ?>">

        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
            <input type="text" value="<?= $username ?>"
                class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" readonly>
        </div>

        <div class="mb-6">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ganti Password
                (Kosongkan jika tidak diganti)</label>
            <input type="password" id="password" name="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="••••••••">
        </div>

        <button type="submit"
            class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan
            Perubahan</button>
    </form>
</div>