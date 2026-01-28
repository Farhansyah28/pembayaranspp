<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends MY_Controller
{

    public $settings;

    public function __construct()
    {
        parent::__construct();
        $this->allowed_roles = ['SUPER_ADMIN', 'ADMIN_KEUANGAN'];
    }

    public function cash()
    {
        $data['title'] = 'Entri Pembayaran Tunai';
        // Get tagihan yang belum lunas
        $this->db->select('tagihan_spp.*, santri.nama as santri_nama, santri.nis');
        $this->db->from('tagihan_spp');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->where_in('tagihan_spp.status', ['BELUM_BAYAR', 'CICILAN']);
        $data['tagihan_list'] = $this->db->get()->result();

        $this->render('keuangan/pembayaran/form_cash', $data);
    }

    public function process_cash()
    {
        $tagihan_id = $this->input->post('tagihan_id');
        $nominal = $this->input->post('nominal');
        $tanggal = $this->input->post('tanggal');

        $tagihan = $this->db->where(['id' => $tagihan_id])->get('tagihan_spp')->row();
        if (!$tagihan)
            show_404();

        $this->db->trans_start();

        // 1. Simpan ke tabel pembayaran
        $pembayaran_data = [
            'tagihan_id' => $tagihan_id,
            'admin_id' => $this->session->userdata('user_id'),
            'jumlah' => $nominal,
            'metode' => 'CASH',
            'tanggal_bayar' => $tanggal,
            'status' => 'VERIFIED',
            'catatan' => $this->input->post('keterangan')
        ];
        $this->db->insert('pembayaran', $pembayaran_data);

        // 2. Update status tagihan
        $total_bayar = $this->db->select_sum('jumlah')->where(['tagihan_id' => $tagihan_id, 'status' => 'VERIFIED'])->get('pembayaran')->row()->jumlah;

        $status = 'CICILAN';
        if ($total_bayar >= $tagihan->nominal_akhir) {
            $status = 'LUNAS';
        }

        $this->db->update('tagihan_spp', ['status' => $status], ['id' => $tagihan_id]);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal memproses pembayaran.');
        } else {
            $this->log_activity("Input pembayaran cash Rp $nominal untuk tagihan ID $tagihan_id", 'Pembayaran');
            $this->session->set_flashdata('success', 'Pembayaran berhasil disimpan.');
        }
        redirect('keuangan/tagihan');
    }

    public function pending()
    {
        $data['title'] = 'Verifikasi Transfer';
        $this->db->select('bukti_transfer.*, pembayaran.jumlah, pembayaran.tanggal_bayar, users.username as wali_username, tagihan_spp.bulan, tagihan_spp.tahun');
        $this->db->from('bukti_transfer');
        $this->db->join('pembayaran', 'pembayaran.id = bukti_transfer.pembayaran_id');
        $this->db->join('users', 'users.id = bukti_transfer.user_id');
        $this->db->join('tagihan_spp', 'tagihan_spp.id = pembayaran.tagihan_id');
        $this->db->where('bukti_transfer.status', 'PENDING');
        $data['pending_list'] = $this->db->get()->result();

        $this->render('keuangan/pembayaran/pending', $data);
    }

    public function verify($id, $status)
    {
        if (!in_array($status, ['SUCCESS', 'FAILED']))
            show_404();

        $bukti = $this->db->where(['id' => $id])->get('bukti_transfer')->row();
        if (!$bukti)
            show_404();

        $this->db->trans_start();

        // Update status bukti
        $this->db->update('bukti_transfer', ['status' => $status == 'SUCCESS' ? 'SUCCESS' : 'FAILED'], ['id' => $id]);

        // Update status pembayaran
        $this->db->update('pembayaran', ['status' => $status == 'SUCCESS' ? 'VERIFIED' : 'REJECTED'], ['id' => $bukti->pembayaran_id]);

        if ($status == 'SUCCESS') {
            $pembayaran = $this->db->where(['id' => $bukti->pembayaran_id])->get('pembayaran')->row();
            $tagihan_id = $pembayaran->tagihan_id;
            $tagihan = $this->db->where(['id' => $tagihan_id])->get('tagihan_spp')->row();

            // Re-calculate tagihan status
            $total_bayar = $this->db->select_sum('jumlah')->where(['tagihan_id' => $tagihan_id, 'status' => 'VERIFIED'])->get('pembayaran')->row()->jumlah;
            $new_status = ($total_bayar >= $tagihan->nominal_akhir) ? 'LUNAS' : 'CICILAN';
            $this->db->update('tagihan_spp', ['status' => $new_status], ['id' => $tagihan_id]);
        }

        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Status verifikasi berhasil diperbarui.');
        redirect('keuangan/pembayaran/pending');
    }

    public function detail($tagihan_id)
    {
        $this->db->select('tagihan_spp.*, santri.nama as santri_nama, santri.nis, kelas.nama as kelas_nama, angkatan.nama as angkatan_nama');
        $this->db->from('tagihan_spp');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id');
        $this->db->join('angkatan', 'angkatan.id = santri.angkatan_id');
        $this->db->where('tagihan_spp.id', $tagihan_id);
        $data['tagihan'] = $this->db->get()->row();

        if (!$data['tagihan'])
            show_404();

        $data['title'] = 'Detail Tagihan & Pembayaran';

        // Get payment history
        $this->db->select('pembayaran.*, users.username as admin_nama');
        $this->db->from('pembayaran');
        $this->db->join('users', 'users.id = pembayaran.admin_id', 'left');
        $this->db->where('pembayaran.tagihan_id', $tagihan_id);
        $this->db->order_by('pembayaran.tanggal_bayar', 'DESC');
        $data['pembayaran'] = $this->db->get()->result();

        $this->render('keuangan/pembayaran/detail', $data);
    }

    public function nota($pembayaran_id)
    {
        $this->db->select('pembayaran.*, tagihan_spp.bulan, tagihan_spp.tahun, tagihan_spp.nominal_akhir, santri.nama as santri_nama, santri.nis, kelas.nama as kelas_nama, users.username as admin_nama');
        $this->db->from('pembayaran');
        $this->db->join('tagihan_spp', 'tagihan_spp.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id');
        $this->db->join('users', 'users.id = pembayaran.admin_id', 'left');
        $this->db->where('pembayaran.id', $pembayaran_id);
        $data['p'] = $this->db->get()->row();

        if (!$data['p'])
            show_404();

        // Get total paid for this tagihan to calculate remaining
        $data['total_bayar'] = $this->db->select_sum('jumlah')
            ->where([
                'tagihan_id' => $data['p']->tagihan_id,
                'status' => 'VERIFIED'
            ])->get('pembayaran')->row()->jumlah;

        $data['settings'] = $this->settings;
        $this->load->view('keuangan/pembayaran/nota', $data);
    }
}
