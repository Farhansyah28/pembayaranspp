<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->allowed_roles = ['SUPER_ADMIN'];
        $this->load->helper('file');
    }

    public function index()
    {
        $data['title'] = 'Sistem Maintenance & Storage';

        // Path to bukti folder
        $path = './uploads/bukti/';

        // 1. Calculate Folder Size
        $data['folder_size'] = $this->_get_folder_size($path);

        // 2. Count Files
        $files = is_dir($path) ? array_diff(scandir($path), array('.', '..')) : [];
        $data['total_files'] = count($files);

        // 3. Find files older than 6 months
        $data['old_files_count'] = 0;
        $six_months_ago = time() - (6 * 30 * 24 * 60 * 60);

        foreach ($files as $file) {
            if (filemtime($path . $file) < $six_months_ago) {
                $data['old_files_count']++;
            }
        }

        $this->render('admin/maintenance/index', $data);
    }

    public function cleanup()
    {
        $path = './uploads/bukti/';
        $files = is_dir($path) ? array_diff(scandir($path), array('.', '..')) : [];
        $six_months_ago = time() - (6 * 30 * 24 * 60 * 60);
        $deleted = 0;

        foreach ($files as $file) {
            $file_path = $path . $file;
            if (filemtime($file_path) < $six_months_ago) {
                if (@unlink($file_path)) {
                    $deleted++;
                }
            }
        }

        $this->log_activity("Melakukan pembersihan storage: Menghapus $deleted file bukti lama.", 'Maintenance');
        $this->session->set_flashdata('success', "Pembersihan berhasil. $deleted file bukti lama telah dihapus.");
        redirect('admin/maintenance');
    }

    private function _get_folder_size($path)
    {
        $size = 0;
        if (!is_dir($path))
            return 0;

        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $file) {
            $size += $file->getSize();
        }
        return $size;
    }
}
