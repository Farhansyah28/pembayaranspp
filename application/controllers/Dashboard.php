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

        // Combined Pending & Tunggakan Query - Optimized
        $this->db->select("COUNT(*) as total_pending, 
                          SUM(nominal_akhir) as total_akhir, 
                          SUM(jumlah_dibayar) as total_bayar");
        $this->db->where_in('status', ['BELUM_BAYAR', 'CICILAN']);
        $stats = $this->db->get('tagihan_spp')->row();

        $data['total_tagihan_pending'] = $stats->total_pending ?? 0;
        $data['total_tunggakan'] = ($stats->total_akhir ?? 0) - ($stats->total_bayar ?? 0);

        // Pemasukan bulan ini - Restored
        $this->db->select_sum('jumlah');
        $this->db->where('status', 'VERIFIED');
        $this->db->where('MONTH(tanggal_bayar)', date('m'));
        $this->db->where('YEAR(tanggal_bayar)', date('Y'));
        $data['pemasukan_bulan_ini'] = $this->db->get('pembayaran')->row()->jumlah ?? 0;

        // Grafik tren 6 bulan terakhir - OPTIMIZED & FIXED (only_full_group_by safe)
        $start_limit = date('Y-m-01', strtotime("-5 month"));
        $this->db->select("DATE_FORMAT(tanggal_bayar, '%Y-%m') as month_key, 
                          DATE_FORMAT(tanggal_bayar, '%b') as month_name, 
                          SUM(jumlah) as total");
        $this->db->from('pembayaran');
        $this->db->where('status', 'VERIFIED');
        $this->db->where('tanggal_bayar >=', $start_limit);
        $this->db->group_by('month_key, month_name');
        $this->db->order_by('month_key', 'ASC');
        $chart_data_raw = $this->db->get()->result_array();

        // Map data ke format chart
        $data['chart_labels'] = [];
        $data['chart_values'] = [];

        // Buat map [Tahun-Bulan] => Total
        $map = [];
        foreach ($chart_data_raw as $cr) {
            $map[$cr['month_key']] = $cr['total'];
        }

        for ($i = 5; $i >= 0; $i--) {
            $month_key = date('Y-m', strtotime("-$i month"));
            $month_name = date('M', strtotime("-$i month"));

            $data['chart_labels'][] = $month_name;
            $data['chart_values'][] = $map[$month_key] ?? 0;
        }

        $this->render('admin/dashboard', $data);
    }

    public function wali()
    {
        $data['title'] = 'Wali Santri Dashboard';
        $user_id = $this->session->userdata('user_id');

        // Get anak-anak
        $this->db->select('santri.*');
        $this->db->from('santri');
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
