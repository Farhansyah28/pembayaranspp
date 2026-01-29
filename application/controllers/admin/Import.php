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

        // Headers (Tanpa Kelas)
        fputcsv($output, [
            'nis',
            'nama_santri',
            'jenis_kelamin',
            'tanggal_lahir',
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
            // Skip baris kosong atau tidak lengkap kolomnya (Minimal 8 kolom sekarang)
            if (empty($row) || count($row) < 8) {
                $skip_count++;
                continue;
            }

            // Normalize Tanggal Lahir (Handle DD/MM/YYYY or YYYY-MM-DD)
            $raw_tgl = trim($row[3]);
            $tgl_lahir = NULL;
            if (!empty($raw_tgl)) {
                $date_obj = date_create_from_format('d/m/Y', $raw_tgl);
                if (!$date_obj) {
                    $date_obj = date_create($raw_tgl);
                }
                if ($date_obj) {
                    $tgl_lahir = $date_obj->format('Y-m-d');
                }
            }

            $data = [
                'nis' => trim($row[0]),
                'nama_santri' => trim($row[1]),
                'jenis_kelamin' => trim($row[2]),
                'tanggal_lahir' => $tgl_lahir,
                'tahun_masuk' => trim($row[4]),
                'nama_wali' => trim($row[5]),
                'no_hp_wali' => trim($row[6]),
                'alamat' => trim($row[7])
            ];

            // Validasi data wajib: NIS, Nama, No HP Wali (Alamat Opsional)
            if (empty($data['nis']) || empty($data['nama_santri']) || empty($data['no_hp_wali'])) {
                $skip_count++;
                continue;
            }

            // 1. Get or Create Angkatan ID
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

            // 2. Create/Get User Wali
            $password_raw = !empty($data['tanggal_lahir']) ? date('dmY', strtotime($data['tanggal_lahir'])) : '123456';
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
                    'alamat' => !empty($data['alamat']) ? $data['alamat'] : NULL
                ];
                $this->db->insert('wali_santri', $wali_data);
            } else {
                $user_id = $user->id;
            }

            // 3. Create/Get User Santri
            $username_santri = $data['nis'];
            $user_santri = $this->db->where('username', $username_santri)->get('users')->row();
            if (!$user_santri) {
                $user_santri_data = [
                    'username' => $username_santri,
                    'password' => password_hash($password_raw, PASSWORD_DEFAULT),
                    'role' => 'SANTRI',
                    'status' => 'ACTIVE'
                ];
                $this->db->insert('users', $user_santri_data);
                $santri_user_id = $this->db->insert_id();
            } else {
                $santri_user_id = $user_santri->id;
            }

            // 4. Create Santri (Tanpa Kelas)
            $santri_data = [
                'nis' => $data['nis'],
                'nama' => $data['nama_santri'],
                'user_id' => $santri_user_id,
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
