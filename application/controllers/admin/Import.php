<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->allowed_roles = ['SUPER_ADMIN', 'ADMIN_KEUANGAN'];
        $this->load->model('User_model');
    }

    public function index()
    {
        $data['title'] = 'Import Data Santri';
        $this->render('admin/import/index', $data);
    }

    public function template()
    {
        $filename = 'template_import_santri.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Headers
        fputcsv($output, [
            'nis',
            'nama_santri',
            'jenis_kelamin',
            'tanggal_lahir',
            'nama_kelas',
            'tahun_masuk',
            'nama_wali',
            'no_hp_wali',
            'alamat'
        ], ';');

        // Sample Data
        fputcsv($output, [
            '2024005',
            'Budi Santoso',
            'L',
            '2010-01-30',
            'Kelas 1 SMP',
            '2024',
            'Agus Santoso',
            '08123456789',
            'Jl. Mawar No. 10'
        ], ';');

        fclose($output);
    }

    public function process()
    {
        $config['upload_path'] = './uploads/temp/';
        $config['allowed_types'] = 'csv|txt';
        $config['max_size'] = 2048;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file_csv')) {
            $this->session->set_flashdata('error', 'Gagal upload: ' . $this->upload->display_errors('', ''));
            redirect('admin/import');
            return;
        }

        $file_data = $this->upload->data();
        $file_path = $file_data['full_path'];

        $handle = fopen($file_path, 'r');
        $header = fgetcsv($handle, 0, ';'); // Skip header

        $this->db->trans_start();
        $success_count = 0;
        $skip_count = 0;

        while (($row = fgetcsv($handle, 0, ';')) !== FALSE) {
            // Skip baris kosong atau tidak lengkap kolomnya
            if (empty($row) || count($row) < 9) {
                $skip_count++;
                continue;
            }

            $data = [
                'nis' => trim($row[0]),
                'nama_santri' => trim($row[1]),
                'jenis_kelamin' => trim($row[2]),
                'tanggal_lahir' => trim($row[3]),
                'nama_kelas' => trim($row[4]),
                'tahun_masuk' => trim($row[5]),
                'nama_wali' => trim($row[6]),
                'no_hp_wali' => trim($row[7]),
                'alamat' => trim($row[8])
            ];

            // Validasi data wajib: NIS, Nama, Kelas, No HP Wali
            if (empty($data['nis']) || empty($data['nama_santri']) || empty($data['nama_kelas']) || empty($data['no_hp_wali'])) {
                $skip_count++;
                continue;
            }

            // 1. Get Kelas ID
            $kelas = $this->db->where('nama', $data['nama_kelas'])->get('kelas')->row();
            if (!$kelas) {
                // Jangan rollback, cukup skip baris ini jika kelas tidak ditemukan
                $skip_count++;
                continue;
            }

            // 2. Get or Create Angkatan ID
            $angkatan = $this->db->where('tahun_masuk', $data['tahun_masuk'])->get('angkatan')->row();
            if (!$angkatan) {
                $next_index = $this->db->count_all('angkatan') + 1;
                $angkatan_data = [
                    'nama' => "Angkatan " . $next_index,
                    'tahun_masuk' => $data['tahun_masuk'],
                    'keterangan' => 'Generasi ke-' . $next_index . ' (Sistem Otomatis)'
                ];
                $this->db->insert('angkatan', $angkatan_data);
                $angkatan_id = $this->db->insert_id();
            } else {
                $angkatan_id = $angkatan->id;
            }

            // 3. Create/Get User Wali
            $password_raw = date('dmY', strtotime($data['tanggal_lahir']));
            $username_wali = $data['no_hp_wali'];

            $user = $this->db->where('username', $username_wali)->get('users')->row();
            if (!$user) {
                $user_data = [
                    'username' => $username_wali,
                    'password' => password_hash($password_raw, PASSWORD_DEFAULT),
                    'role' => 'WALI_SANTRI',
                    'status' => 'ACTIVE'
                ];
                $this->db->insert('users', $user_data);
                $user_id = $this->db->insert_id();

                // Create Wali Santri record
                $wali_data = [
                    'user_id' => $user_id,
                    'nama' => $data['nama_wali'],
                    'no_hp' => $data['no_hp_wali'],
                    'alamat' => $data['alamat']
                ];
                $this->db->insert('wali_santri', $wali_data);
            } else {
                $user_id = $user->id;
            }

            // 4. Create Santri
            $santri_data = [
                'nis' => $data['nis'],
                'nama' => $data['nama_santri'],
                'kelas_id' => $kelas->id,
                'angkatan_id' => $angkatan_id,
                'wali_user_id' => $user_id,
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'status' => 'ACTIVE'
            ];

            // Cek NIS agar tidak duplikat
            $exists = $this->db->where('nis', $data['nis'])->get('santri')->row();
            if ($exists) {
                $this->db->where('id', $exists->id)->update('santri', $santri_data);
            } else {
                $this->db->insert('santri', $santri_data);
            }

            $success_count++;
        }

        fclose($handle);
        if (file_exists($file_path))
            unlink($file_path);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Terjadi kesalahan sistem saat memproses database.');
        } else {
            $msg = "Import selesai. Berhasil: $success_count";
            if ($skip_count > 0) {
                $msg .= ", Terlewati (Data tidak lengkap): $skip_count";
            }
            $this->log_activity($msg, 'Import');
            $this->session->set_flashdata('success', $msg);
        }

        redirect('admin/import');
    }
}
