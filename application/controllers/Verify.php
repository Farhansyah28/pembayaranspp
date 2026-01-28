<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Controller
{
    public $settings;
    private $salt = 'PESANTREN_QR_SECURE_2024';

    public function __construct()
    {
        parent::__construct();
        // Load settings globally like MY_Controller
        $settings_raw = $this->db->get('pengaturan')->result();
        $this->settings = new stdClass();
        foreach ($settings_raw as $s) {
            $this->settings->{$s->h_key} = $s->h_value;
        }
    }

    public function payment($id = null, $hash = null)
    {
        if (!$id || !$hash) {
            show_404();
        }

        // Verify Hash
        $expected_hash = md5($id . $this->salt);
        if ($hash !== $expected_hash) {
            $this->load->view('public/verify_payment', ['status' => 'INVALID']);
            return;
        }

        // Get Payment Data
        $this->db->select('pembayaran.*, santri.nama as santri_nama, santri.nis, kelas.nama as kelas_nama, tagihan_spp.bulan, tagihan_spp.tahun');
        $this->db->from('pembayaran');
        $this->db->join('tagihan_spp', 'tagihan_spp.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id');
        $this->db->where('pembayaran.id', $id);
        $this->db->where('pembayaran.status', 'VERIFIED');
        $data['p'] = $this->db->get()->row();

        if (!$data['p']) {
            $this->load->view('public/verify_payment', ['status' => 'NOT_FOUND']);
            return;
        }

        $data['status'] = 'VALID';
        $data['settings'] = $this->settings;
        $this->load->view('public/verify_payment', $data);
    }
}
