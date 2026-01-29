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
        $this->db->select('tagihan_spp.*, santri.nama as santri_nama, santri.nis, pembayaran.id as verified_pembayaran_id, bukti_transfer.status as bukti_status');
        $this->db->from('tagihan_spp');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->join('pembayaran', 'pembayaran.tagihan_id = tagihan_spp.id AND pembayaran.status = \'VERIFIED\'', 'left');
        $this->db->join('bukti_transfer', 'bukti_transfer.pembayaran_id = tagihan_spp.id AND bukti_transfer.status = \'PENDING\'', 'left');
        $this->db->where('santri.wali_user_id', $this->session->userdata('user_id'));
        $this->db->order_by('tagihan_spp.bulan', 'DESC');
        $data['tagihan'] = $this->db->get()->result();

        $this->render('wali/tagihan/index', $data);
    }

    public function upload_bukti($tagihan_id)
    {
        $tagihan = $this->db->where('id', $tagihan_id)->get('tagihan_spp')->row();
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

            // Compress image if it's not a PDF
            if ($upload_data['file_ext'] != '.pdf') {
                $this->_compress_image($upload_data['full_path']);
            }

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

    public function kwitansi($pembayaran_id)
    {
        // Security check: Ensure this payment belongs to the current wali's child
        $this->db->select('pembayaran.*, tagihan_spp.bulan, tagihan_spp.tahun, tagihan_spp.nominal_akhir, santri.nama as santri_nama, santri.nis, angkatan.nama as angkatan_nama, users.username as admin_nama');
        $this->db->from('pembayaran');
        $this->db->join('tagihan_spp', 'tagihan_spp.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->join('angkatan', 'angkatan.id = santri.angkatan_id', 'left');
        $this->db->join('users', 'users.id = pembayaran.admin_id', 'left');
        $this->db->where('pembayaran.id', $pembayaran_id);
        $this->db->where('santri.wali_user_id', $this->session->userdata('user_id'));
        $data['p'] = $this->db->get()->row();

        if (!$data['p']) {
            $this->session->set_flashdata('error', 'Kwitansi tidak ditemukan atau Anda tidak memiliki akses.');
            redirect('wali/tagihan');
        }

        // Get total paid for this tagihan to calculate remaining
        $data['total_bayar'] = $this->db->select_sum('jumlah')
            ->where([
                'tagihan_id' => $data['p']->tagihan_id,
                'status' => 'VERIFIED'
            ])->get('pembayaran')->row()->jumlah;

        $data['settings'] = $this->settings;
        $this->load->view('keuangan/pembayaran/nota', $data);
    }

    public function bayar_online($tagihan_id)
    {
        $this->load->library('xendit_lib');

        // 1. Get Tagihan Data
        $this->db->select('tagihan_spp.*, santri.nama as santri_nama, users.email');
        $this->db->from('tagihan_spp');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->join('users', 'users.id = santri.wali_user_id');
        $this->db->where('tagihan_spp.id', $tagihan_id);
        $tagihan = $this->db->get()->row();

        if (!$tagihan || $tagihan->status == 'LUNAS') {
            $this->session->set_flashdata('error', 'Tagihan tidak ditemukan atau sudah lunas.');
            redirect('wali/tagihan');
        }

        // 2. If already has a payment URL, redirect there
        if ($tagihan->xendit_payment_url) {
            redirect($tagihan->xendit_payment_url);
        }

        // 3. Create Xendit Invoice
        $external_id = 'SPP-' . $tagihan_id . '-' . time();
        $description = "Pembayaran SPP - " . $tagihan->santri_nama . " (" . date('F Y', mktime(0, 0, 0, $tagihan->bulan, 10, $tagihan->tahun)) . ")";

        $response = $this->xendit_lib->create_invoice(
            $external_id,
            $tagihan->nominal_akhir,
            $tagihan->email ?: 'wali@pesantren.com',
            $description,
            base_url('wali/tagihan')
        );

        if ($response['status']) {
            $invoice = $response['data'];

            // Save info to database
            $this->db->where('id', $tagihan_id)->update('tagihan_spp', [
                'xendit_external_id' => $invoice['external_id'],
                'xendit_payment_url' => $invoice['invoice_url']
            ]);

            redirect($invoice['invoice_url']);
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat tagihan online: ' . $response['message']);
            redirect('wali/tagihan');
        }
    }

    private function _compress_image($source_path)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_path;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 800;
        $config['height'] = 800;
        $config['quality'] = '70%';

        $this->load->library('image_lib');
        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            log_message('error', 'Image compression failed: ' . $this->image_lib->display_errors());
        }

        $this->image_lib->clear();
    }
}
