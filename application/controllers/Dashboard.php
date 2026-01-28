<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // MY_Controller handles auth check
    }

    public function index()
    {
        $data['title'] = 'Dashboard';

        // Load role-specific data if needed
        switch ($this->role) {
            case 'SUPER_ADMIN':
            case 'ADMIN_KEUANGAN':
                $this->admin();
                break;
            case 'WALI_SANTRI':
                $this->wali();
                break;
            case 'SANTRI':
                $this->santri();
                break;
        }
    }

    public function admin()
    {
        $data['title'] = 'Admin Dashboard';
        $data['total_santri'] = $this->db->count_all('santri');
        $data['total_tagihan_pending'] = $this->db->where_in('status', ['BELUM_BAYAR', 'CICILAN'])->count_all_results('tagihan_spp');

        // Pemasukan bulan ini
        $this->db->select_sum('jumlah');
        $this->db->where('status', 'SUCCESS');
        $this->db->where('MONTH(tanggal_bayar)', date('m'));
        $this->db->where('YEAR(tanggal_bayar)', date('Y'));
        $data['pemasukan_bulan_ini'] = $this->db->get('pembayaran')->row()->jumlah ?? 0;

        // Total tunggakan
        $this->db->select_sum('nominal_akhir');
        $this->db->select_sum('jumlah_dibayar');
        $this->db->where_in('status', ['BELUM_BAYAR', 'CICILAN']);
        $res_tunggakan = $this->db->get('tagihan_spp')->row();
        $data['total_tunggakan'] = ($res_tunggakan->nominal_akhir ?? 0) - ($res_tunggakan->jumlah_dibayar ?? 0);

        // Grafik tren 6 bulan terakhir
        $data['chart_labels'] = [];
        $data['chart_values'] = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('m', strtotime("-$i month"));
            $year = date('Y', strtotime("-$i month"));
            $month_name = date('M', strtotime("-$i month"));

            $this->db->select_sum('jumlah');
            $this->db->where('status', 'VERIFIED');
            $this->db->where('MONTH(tanggal_bayar)', $month);
            $this->db->where('YEAR(tanggal_bayar)', $year);
            $val = $this->db->get('pembayaran')->row()->jumlah ?? 0;

            $data['chart_labels'][] = $month_name;
            $data['chart_values'][] = $val;
        }

        $this->render('admin/dashboard', $data);
    }

    public function wali()
    {
        $data['title'] = 'Wali Santri Dashboard';
        $user_id = $this->session->userdata('user_id');

        // Get anak-anak
        $this->db->select('santri.*, kelas.nama as kelas_nama');
        $this->db->from('santri');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id');
        $this->db->where('santri.wali_user_id', $user_id);
        $data['anak'] = $this->db->get()->result();

        // Get total tunggakan all anak
        $this->db->select_sum('nominal_akhir');
        $this->db->select_sum('jumlah_dibayar');
        $this->db->from('tagihan_spp');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->where('santri.wali_user_id', $user_id);
        $this->db->where_in('tagihan_spp.status', ['BELUM_BAYAR', 'CICILAN']);
        $totals = $this->db->get()->row();

        $data['total_tunggakan'] = ($totals->nominal_akhir ?? 0) - ($totals->jumlah_dibayar ?? 0);

        $this->render('wali/dashboard', $data);
    }

    public function santri()
    {
        $data['title'] = 'Santri Dashboard';
        $this->render('santri/dashboard', $data);
    }
}
