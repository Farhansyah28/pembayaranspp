<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->allowed_roles = ['WALI_SANTRI'];
    }

    public function index()
    {
        $data['title'] = 'Tagihan SPP';

        // Get all tagihan for children of this wali
        $this->db->select('tagihan_spp.*, santri.nama as santri_nama, santri.nis');
        $this->db->from('tagihan_spp');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->where('santri.wali_user_id', $this->session->userdata('user_id'));
        $this->db->order_by('tagihan_spp.bulan', 'DESC');
        $data['tagihan'] = $this->db->get()->result();

        $this->render('wali/tagihan/index', $data);
    }

    public function upload_bukti($tagihan_id)
    {
        $tagihan = $this->db->get_where('tagihan_spp', ['id' => $tagihan_id])->row();
        if (!$tagihan)
            show_404();

        $data['title'] = 'Upload Bukti Transfer';
        $data['tagihan'] = $tagihan;
        $this->render('wali/tagihan/upload', $data);
    }

    public function do_upload($tagihan_id)
    {
        $config['upload_path'] = './uploads/bukti/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = 'BUKTI_' . $tagihan_id . '_' . time();

        if (!is_dir('./uploads/bukti/')) {
            mkdir('./uploads/bukti/', 0777, TRUE);
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto_bukti')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('wali/tagihan/upload_bukti/' . $tagihan_id);
        } else {
            $upload_data = $this->upload->data();

            $this->db->trans_start();

            // 1. Create Pembayaran (PENDING)
            $pembayaran_data = [
                'tagihan_id' => $tagihan_id,
                'admin_id' => $this->session->userdata('user_id'),
                'jumlah' => $this->input->post('nominal'),
                'metode' => 'TRANSFER',
                'tanggal_bayar' => date('Y-m-d H:i:s'),
                'status' => 'PENDING',
                'catatan' => 'Upload oleh Wali Santri'
            ];
            $this->db->insert('pembayaran', $pembayaran_data);
            $pembayaran_id = $this->db->insert_id();

            // 2. Create Bukti Transfer
            $bukti_data = [
                'pembayaran_id' => $pembayaran_id,
                'user_id' => $this->session->userdata('user_id'),
                'foto_bukti' => $upload_data['file_name'],
                'status' => 'PENDING'
            ];
            $this->db->insert('bukti_transfer', $bukti_data);

            $this->db->trans_complete();

            $this->session->set_flashdata('success', 'Bukti transfer berhasil diupload. Silakan tunggu verifikasi admin.');
            redirect('wali/tagihan');
        }
    }
}
