<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->allowed_roles = ['SUPER_ADMIN', 'ADMIN_KEUANGAN'];
    }

    public function pemasukan()
    {
        $data['title'] = 'Laporan Pemasukan';

        $start_date = $this->input->get('start_date') ?? date('Y-m-01');
        $end_date = $this->input->get('end_date') ?? date('Y-m-t');

        $this->db->select('pembayaran.*, santri.nama as santri_nama, tagihan_spp.bulan, tagihan_spp.tahun');
        $this->db->from('pembayaran');
        $this->db->join('tagihan_spp', 'tagihan_spp.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->where('pembayaran.status', 'VERIFIED');
        $this->db->where('DATE(pembayaran.tanggal_bayar) >=', $start_date);
        $this->db->where('DATE(pembayaran.tanggal_bayar) <=', $end_date);
        $data['pemasukan'] = $this->db->get()->result();

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['total'] = array_sum(array_column($data['pemasukan'], 'jumlah'));

        $this->render('keuangan/laporan/pemasukan', $data);
    }

    public function tunggakan()
    {
        $data['title'] = 'Laporan Tunggakan';

        $this->db->select('tagihan_spp.*, santri.nama as santri_nama, santri.nis, kelas.nama as kelas_nama, ws.nama as wali_nama, ws.no_hp');
        $this->db->from('tagihan_spp');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id');
        $this->db->join('wali_santri ws', 'ws.user_id = santri.wali_user_id');
        $this->db->where_in('tagihan_spp.status', ['BELUM_BAYAR', 'CICILAN']);
        $data['tunggakan'] = $this->db->get()->result();

        $this->render('keuangan/laporan/tunggakan', $data);
    }

    public function export_pemasukan()
    {
        $start_date = $this->input->get('start_date') ?? date('Y-m-01');
        $end_date = $this->input->get('end_date') ?? date('Y-m-t');

        $this->db->select('pembayaran.tanggal_bayar, santri.nama as santri_nama, tagihan_spp.bulan, tagihan_spp.tahun, pembayaran.metode, pembayaran.jumlah');
        $this->db->from('pembayaran');
        $this->db->join('tagihan_spp', 'tagihan_spp.id = pembayaran.tagihan_id');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->where('pembayaran.status', 'VERIFIED');
        $this->db->where('DATE(pembayaran.tanggal_bayar) >=', $start_date);
        $this->db->where('DATE(pembayaran.tanggal_bayar) <=', $end_date);
        $query = $this->db->get();

        $this->load->helper('download');
        $filename = "Laporan_Pemasukan_{$start_date}_{$end_date}.csv";

        $data = "Tanggal,Nama Santri,Bulan/Tahun,Metode,Jumlah\n";
        foreach ($query->result() as $row) {
            $period = date('F', mktime(0, 0, 0, $row->bulan, 10)) . " " . $row->tahun;
            $data .= "{$row->tanggal_bayar},{$row->santri_nama},{$period},{$row->metode},{$row->jumlah}\n";
        }

        force_download($filename, $data);
    }

    public function export_tunggakan()
    {
        $this->db->select('santri.nis, santri.nama as santri_nama, kelas.nama as kelas_nama, tagihan_spp.bulan, tagihan_spp.tahun, tagihan_spp.status, tagihan_spp.nominal_akhir');
        $this->db->from('tagihan_spp');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id');
        $this->db->where_in('tagihan_spp.status', ['BELUM_BAYAR', 'CICILAN']);
        $query = $this->db->get();

        $this->load->helper('download');
        $filename = "Laporan_Tunggakan_" . date('Y-m-d') . ".csv";

        $data = "NIS,Nama Santri,Kelas,Bulan/Tahun,Status,Sisa Tagihan\n";
        foreach ($query->result() as $row) {
            $period = date('F', mktime(0, 0, 0, $row->bulan, 10)) . " " . $row->tahun;
            $data .= "{$row->nis},{$row->santri_nama},{$row->kelas_nama},{$period},{$row->status},{$row->nominal_akhir}\n";
        }

        force_download($filename, $data);
    }

    public function monitoring()
    {
        $data['title'] = 'Matrix Monitoring SPP';

        // 1. Get Tahun Ajaran
        $data['tahun_ajaran_list'] = $this->db->get('tahun_ajaran')->result();
        $ta_id = $this->input->get('tahun_ajaran_id');

        // Default to active TA if not selected
        if (!$ta_id) {
            $active_ta = $this->db->where(['aktif' => 1])->get('tahun_ajaran')->row();
            $ta_id = $active_ta ? $active_ta->id : null;
        }

        $ta_selected = $this->db->where(['id' => $ta_id])->get('tahun_ajaran')->row();
        $data['ta_selected'] = $ta_selected;

        if ($ta_selected) {
            // 2. Get All Santri
            $this->db->select('s.id, s.nama, s.nis, k.nama as kelas_nama');
            $this->db->from('santri s');
            $this->db->join('kelas k', 'k.id = s.kelas_id');
            $this->db->where('s.status', 'ACTIVE');
            $this->db->order_by('k.tingkat', 'ASC');
            $this->db->order_by('s.nama', 'ASC');
            $santri = $this->db->get()->result_array();

            // 3. Get All Tagihan for this TA (Optimized columns)
            $this->db->select('id, santri_id, bulan, tahun, status, nominal_akhir, jumlah_dibayar');
            $tagihan_raw = $this->db->where(['tahun_ajaran_id' => $ta_id])->get('tagihan_spp')->result_array();

            // Map tagihan to [santri_id][bulan][tahun]
            $tagihan_map = [];
            foreach ($tagihan_raw as $t) {
                $tagihan_map[$t['santri_id']][$t['bulan']][$t['tahun']] = $t;
            }

            // 4. Define Months (Juli - Juni)
            $months = [];
            for ($i = 0; $i < 12; $i++) {
                $m = (($i + 6) % 12) + 1; // 7, 8, 9, 10, 11, 12, 1, 2, 3, 4, 5, 6
                $y = ($m >= 7) ? $ta_selected->tahun_mulai : $ta_selected->tahun_selesai;
                $months[] = ['bulan' => $m, 'tahun' => $y];
            }

            $data['santri'] = $santri;
            $data['tagihan_map'] = $tagihan_map;
            $data['months'] = $months;
        }

        $this->render('keuangan/laporan/monitoring', $data);
    }

    public function export_monitoring()
    {
        $ta_id = $this->input->get('tahun_ajaran_id');
        $ta = $this->db->where(['id' => $ta_id])->get('tahun_ajaran')->row();
        if (!$ta)
            redirect('keuangan/laporan/monitoring');

        $this->db->select('s.id, s.nama, s.nis, k.nama as kelas_nama');
        $this->db->from('santri s');
        $this->db->join('kelas k', 'k.id = s.kelas_id');
        $this->db->where('s.status', 'ACTIVE');
        $this->db->order_by('k.tingkat', 'ASC');
        $this->db->order_by('s.nama', 'ASC');
        $santri = $this->db->get()->result_array();

        $this->db->select('santri_id, bulan, tahun, status');
        $tagihan_raw = $this->db->where(['tahun_ajaran_id' => $ta_id])->get('tagihan_spp')->result_array();
        $tagihan_map = [];
        foreach ($tagihan_raw as $t) {
            $tagihan_map[$t['santri_id']][$t['bulan']][$t['tahun']] = $t['status'];
        }

        $this->load->helper('download');
        $filename = "Monitoring_SPP_" . str_replace('/', '_', $ta->nama) . ".csv";

        $header = "NIS,Nama,Kelas";
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $m = (($i + 6) % 12) + 1;
            $y = ($m >= 7) ? $ta->tahun_mulai : $ta->tahun_selesai;
            $months[] = ['m' => $m, 'y' => $y];
            $header .= "," . date('M Y', mktime(0, 0, 0, $m, 10, $y));
        }
        $header .= "\n";

        $content = $header;
        foreach ($santri as $s) {
            $row = "{$s['nis']},{$s['nama']},{$s['kelas_nama']}";
            foreach ($months as $mn) {
                $status = isset($tagihan_map[$s['id']][$mn['m']][$mn['y']]) ? $tagihan_map[$s['id']][$mn['m']][$mn['y']] : '-';
                $row .= ",{$status}";
            }
            $content .= $row . "\n";
        }

        force_download($filename, $content);
    }
}
