<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keringanan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->allowed_roles = ['SUPER_ADMIN', 'ADMIN_KEUANGAN'];
        $this->load->model('Keringanan_model');
    }

    public function index()
    {
        $data['title'] = 'Manajemen Keringanan SPP';
        $data['keringanan'] = $this->Keringanan_model->get_all();
        $this->render('keuangan/keringanan/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Keringanan Baru';
        $data['santri'] = $this->db->where(['status' => 'ACTIVE'])->get('santri')->result();
        $this->render('keuangan/keringanan/create', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('santri_id', 'Santri', 'required');
        $this->form_validation->set_rules('tipe', 'Tipe', 'required');
        $this->form_validation->set_rules('nilai', 'Nilai', 'required|numeric');
        $this->form_validation->set_rules('mulai_berlaku', 'Tanggal Mulai', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            // Nonaktifkan keringanan aktif sebelumnya untuk santri ini
            $this->db->where(['santri_id' => $this->input->post('santri_id')])->update('keringanan_spp', ['aktif' => 0]);

            $data = [
                'santri_id' => $this->input->post('santri_id'),
                'tipe' => $this->input->post('tipe'),
                'nilai' => $this->input->post('nilai'),
                'alasan' => $this->input->post('alasan'),
                'mulai_berlaku' => $this->input->post('mulai_berlaku'),
                'berakhir' => $this->input->post('berakhir') ? $this->input->post('berakhir') : null,
                'aktif' => 1,
                'created_by' => $this->session->userdata('user_id')
            ];

            $this->db->insert('keringanan_spp', $data);
            $this->log_activity("Menambahkan keringanan untuk santri ID " . $data['santri_id'], 'Keringanan');
            $this->session->set_flashdata('success', 'Keringanan berhasil ditambahkan.');
            redirect('keuangan/keringanan');
        }
    }

    public function nonaktifkan($id)
    {
        $this->db->where(['id' => $id])->update('keringanan_spp', ['aktif' => 0]);
        $this->session->set_flashdata('success', 'Keringanan berhasil dinonaktifkan.');
        redirect('keuangan/keringanan');
    }
}
