<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wali extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->allowed_roles = ['SUPER_ADMIN', 'ADMIN_KEUANGAN'];
    }

    public function index()
    {
        $data['title'] = 'Manajemen Wali Santri';
        $this->db->select('ws.*, u.username, u.status');
        $this->db->select('(SELECT SUM(nominal_akhir - jumlah_dibayar) FROM tagihan_spp t JOIN santri s ON s.id = t.santri_id WHERE s.wali_user_id = ws.user_id AND t.status IN ("BELUM_BAYAR", "CICILAN")) as total_tunggakan');
        $this->db->from('wali_santri ws');
        $this->db->join('users u', 'u.id = ws.user_id');
        $data['wali'] = $this->db->get()->result();
        $this->render('keuangan/wali/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Wali Santri';
        $this->render('keuangan/wali/create', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();

            // 1. Create User
            $user_data = [
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role' => 'WALI_SANTRI',
                'status' => 'ACTIVE'
            ];
            $this->db->insert('users', $user_data);
            $user_id = $this->db->insert_id();

            // 2. Create Wali Profile
            $wali_data = [
                'user_id' => $user_id,
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat')
            ];
            $this->db->insert('wali_santri', $wali_data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Gagal menyimpan data.');
            } else {
                $this->log_activity('Menambah wali santri: ' . $wali_data['nama'], 'Wali Santri');
                $this->session->set_flashdata('success', 'Wali santri berhasil ditambahkan.');
            }
            redirect('keuangan/wali');
        }
    }
}
