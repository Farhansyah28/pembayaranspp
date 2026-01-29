<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <a href="<?= base_url() ?>" class="flex ms-2 md:me-24">
                    <?php if (property_exists($settings, 'logo_pesantren') && $settings->logo_pesantren && file_exists('./uploads/branding/' . $settings->logo_pesantren)): ?>
                        <img src="<?= base_url('uploads/branding/' . $settings->logo_pesantren) ?>" class="h-8 me-3"
                            alt="Logo" />
                    <?php else: ?>
                        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="Logo" />
                    <?php endif; ?>
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">
                        <?= $settings->nama_pesantren ?? 'SPP Pesantren' ?>
                    </span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button"
                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full"
                                src="https://ui-avatars.com/api/?name=<?= str_replace(' ', '+', $username) ?>&background=random"
                                alt="user photo">
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                        id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 dark:text-white" role="none">
                                <?= $username ?>
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                <?= $role ?>
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <?php if (!(defined('DEMO_MODE') && DEMO_MODE)): ?>
                                <li>
                                    <a href="<?= base_url('profile') ?>"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Profil</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('auth/logout') ?>"
                                        class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Keluar</a>
                                </li>
                            <?php else: ?>
                                <li class="px-4 py-2 text-xs text-gray-400 italic">Menu Dibatasi (Mode Demo)</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="<?= base_url('dashboard') ?>"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path
                            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path
                            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            <?php if (in_array($role, ['SUPER_ADMIN', 'ADMIN_KEUANGAN'])): ?>
                <li class="pt-4 pb-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase px-2">Data Master</span>
                </li>
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        aria-controls="dropdown-master" data-collapse-toggle="dropdown-master">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                            <path
                                d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.184.653-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                        </svg>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Master</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-master" class="hidden py-2 space-y-2">
                        <li>
                            <a href="<?= base_url('admin/master/tahun_ajaran') ?>"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Tahun
                                Ajaran</a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/master/angkatan') ?>"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Angkatan</a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/master/tarif') ?>"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Tarif
                                SPP</a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/import') ?>"
                                class="flex items-center w-full p-2 text-blue-600 font-bold transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-blue-400 dark:hover:bg-gray-700 italic">
                                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Import Santri
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?= base_url('keuangan/wali') ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                        </svg>
                        <span class="ms-3">Wali Santri</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('keuangan/santri') ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path
                                d="M14 2a3.963 3.963 0 0 0-3.667 2.440L10.466 11h.068l1.012-4.554A3.963 3.963 0 0 0 14 2Zm1 9h-1.264l-1.12 5.04a1 1 0 0 1-.972.784H7.356a1 1 0 0 1-.972-.784L5.264 11H4a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h1.264l1.12-5.04A1 1 0 0 1 7.356 0h5.288a1 1 0 0 1 .972.784L14.736 4H16a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1Z" />
                        </svg>
                        <span class="ms-3">Santri</span>
                    </a>
                </li>

                <li class="pt-4 pb-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase px-2">Transaksi</span>
                </li>
                <li>
                    <a href="<?= base_url('keuangan/tagihan/generate') ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path
                                d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                        </svg>
                        <span class="ms-3">Generate Tagihan</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('keuangan/pembayaran/cash') ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M11.074 4 8.442.408A.95.95 0 0 0 7.014.254L2.926 4h8.148ZM9 13v-1a4 4 0 0 1 4-4h6V6a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h9a1 1 0 0 1-1-1v-4Z" />
                            <path
                                d="M19 10h-6a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1Zm-4.5 3.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM12.62 4h2.78L12.539.41a1.086 1.086 0 0 0-1.7 0L12.62 4Z" />
                        </svg>
                        <span class="ms-3">Bayar Tunai</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('keuangan/keringanan') ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M18.435 7.426c-.175-.308-.453-.541-.784-.65l-5.716-1.89-1.393-5.833C10.453.308 10.233 0 10 0c-.233 0-.453.308-.541.65l-1.393 5.833L2.349 6.776c-.331.11-.609.342-.784.65-.175.308-.216.66-.118.987l1.734 5.76-4.524 4.192c-.22.203-.312.508-.242.793.07.284.288.514.569.601L8.35 20c.541.168 1.107.252 1.65.252s1.109-.084 1.65-.252l9.366-3.041c.281-.087.499-.317.569-.601.07-.285-.022-.59-.242-.793l-4.524-4.192 1.734-5.76c.098-.327.057-.679-.118-.987z" />
                            <span class="ms-3">Keringanan SPP</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('keuangan/pembayaran/pending') ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm5 11h-4v4h-2v-4H5v-2h4V5h2v4h4v2Z" />
                        </svg>
                        <span class="ms-3">Verifikasi Transfer</span>
                    </a>
                </li>

                <li class="pt-4 pb-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase px-2">Laporan</span>
                </li>
                <li>
                    <a href="<?= base_url('keuangan/laporan/pemasukan') ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4h12v12H4V4zm2 2v2h8V6H6zm0 4v2h8v-2H6z" />
                        </svg>
                        <span class="ms-3">Pemasukan SPP</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('keuangan/laporan/tunggakan') ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 0C4.477 0 0 4.477 0 10s4.477 10 10 10 10-4.477 10-10S15.523 0 10 0zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm-1-13h2v6h-2V5zm0 8h2v2h-2v-2z" />
                        </svg>
                        <span class="ms-3">Tunggakan Santri</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('keuangan/laporan/monitoring') ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a8 8 0 1 0 0 16 8 8 0 0 0 0-16zM5 9h10v2H5V9zm0 4h10v2H5v-2zM5 5h10v2H5V5z" />
                        </svg>
                        <span class="ms-3">Monitoring Tahunan</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($role == 'WALI_SANTRI'): ?>
                <li>
                    <a href="<?= base_url('wali/tagihan') ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.947 13.5h-7.894L10 6.5l3.947 7Z" />
                        </svg>
                        <span class="ms-3">Tagihan Anak</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($role == 'SUPER_ADMIN'): ?>
                <li class="pt-4 pb-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase px-2">Sistem</span>
                </li>
                <li>
                    <a href="<?= base_url('admin/users') ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-7 9a7 7 0 1 1 14 0H3Z" />
                        </svg>
                        <span class="ms-3">Manajemen User</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/logs') ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2.166 13h15.668a.5.5 0 0 0 .39-.812l-3.92-5.25a.5.5 0 0 0-.662-.112l-2.4 1.6-3.872-5.162a.5.5 0 0 0-.712-.088l-4.505 3.5a.5.5 0 0 0-.175.4zM11 11H9v2h2v-2z" />
                        </svg>
                        <span class="ms-3">Log Aktivitas</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/pengaturan') ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ms-3">Pengaturan</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</aside>

<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">