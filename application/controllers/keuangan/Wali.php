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
        $this->db->select('ws.*, u.username, u.status, tunggakan.total_tunggakan');
        $this->db->from('wali_santri ws');
        $this->db->join('users u', 'u.id = ws.user_id');
        // Join with grouped subquery (more efficient than subquery in SELECT)
        $subquery = " (SELECT s.wali_user_id, SUM(t.nominal_akhir - t.jumlah_dibayar) as total_tunggakan 
                       FROM tagihan_spp t 
                       JOIN santri s ON s.id = t.santri_id 
                       WHERE t.status IN ('BELUM_BAYAR', 'CICILAN') 
                       GROUP BY s.wali_user_id) as tunggakan";
        $this->db->join($subquery, 'tunggakan.wali_user_id = ws.user_id', 'left');
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

    public function edit($id)
    {
        $data['title'] = 'Edit Wali Santri';
        $this->db->select('ws.*, u.username, u.status');
        $this->db->from('wali_santri ws');
        $this->db->join('users u', 'u.id = ws.user_id');
        $this->db->where('ws.id', $id);
        $data['w'] = $this->db->get()->row();

        if (!$data['w'])
            show_404();

        $this->render('keuangan/wali/edit', $data);
    }

    public function update($id)
    {
        $wali = $this->db->where('id', $id)->get('wali_santri')->row();
        if (!$wali)
            show_404();

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $this->db->trans_start();

            // Update Profile
            $wali_data = [
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat')
            ];
            $this->db->where('id', $id)->update('wali_santri', $wali_data);

            // Update User status & password if provided
            $user_data = ['status' => $this->input->post('status')];
            if ($this->input->post('password')) {
                $user_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            }
            $this->db->where('id', $wali->user_id)->update('users', $user_data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Gagal memperbarui data.');
            } else {
                $this->log_activity('Memperbarui wali santri: ' . $wali_data['nama'], 'Wali Santri');
                $this->session->set_flashdata('success', 'Wali santri berhasil diperbarui.');
            }
            redirect('keuangan/wali');
        }
    }

    public function delete($id)
    {
        $wali = $this->db->where('id', $id)->get('wali_santri')->row();
        if (!$wali)
            show_404();

        $this->db->trans_start();
        // Delete profile and user (cascading)
        $this->db->where('id', $wali->user_id)->delete('users');
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        } else {
            $this->log_activity('Menghapus wali santri: ' . $wali->nama, 'Wali Santri');
            $this->session->set_flashdata('success', 'Wali santri berhasil dihapus.');
        }
        redirect('keuangan/wali');
    }
}
