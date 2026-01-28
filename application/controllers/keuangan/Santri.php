<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Santri extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->allowed_roles = ['SUPER_ADMIN', 'ADMIN_KEUANGAN'];
    }

    public function index()
    {
        $data['title'] = 'Manajemen Santri';
        $this->db->select('santri.*, kelas.nama as kelas_nama, angkatan.nama as angkatan_nama, wali_user.username as wali_username');
        $this->db->from('santri');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id');
        $this->db->join('angkatan', 'angkatan.id = santri.angkatan_id');
        $this->db->join('users as wali_user', 'wali_user.id = santri.wali_user_id');
        $data['santri'] = $this->db->get()->result();
        $this->render('keuangan/santri/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Santri';
        $data['kelas'] = $this->db->get('kelas')->result();
        $data['angkatan'] = $this->db->get('angkatan')->result();

        // Get all wali users
        $this->db->select('users.id, wali_santri.nama');
        $this->db->from('users');
        $this->db->join('wali_santri', 'wali_santri.user_id = users.id');
        $this->db->where('users.role', 'WALI_SANTRI');
        $data['wali'] = $this->db->get()->result();

        $this->render('keuangan/santri/create', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('nis', 'NIS', 'required|is_unique[santri.nis]');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('kelas_id', 'Kelas', 'required');
        $this->form_validation->set_rules('angkatan_id', 'Angkatan', 'required');
        $this->form_validation->set_rules('wali_user_id', 'Wali Santri', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $data = [
                'nis' => $this->input->post('nis'),
                'nama' => $this->input->post('nama'),
                'kelas_id' => $this->input->post('kelas_id'),
                'angkatan_id' => $this->input->post('angkatan_id'),
                'wali_user_id' => $this->input->post('wali_user_id'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'status' => 'ACTIVE'
            ];

            $this->db->insert('santri', $data);
            $this->log_activity('Menambah santri: ' . $data['nama'], 'Santri');
            $this->session->set_flashdata('success', 'Santri berhasil ditambahkan.');
            redirect('keuangan/santri');
        }
    }
}
