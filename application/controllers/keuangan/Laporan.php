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

        $this->db->select('tagihan_spp.*, santri.nama as santri_nama, santri.nis, ws.nama as wali_nama, ws.no_hp');
        $this->db->from('tagihan_spp');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
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
        $this->db->select('santri.nis, santri.nama as santri_nama, tagihan_spp.bulan, tagihan_spp.tahun, tagihan_spp.status, tagihan_spp.nominal_akhir');
        $this->db->from('tagihan_spp');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->where_in('tagihan_spp.status', ['BELUM_BAYAR', 'CICILAN']);
        $query = $this->db->get();

        $this->load->helper('download');
        $filename = "Laporan_Tunggakan_" . date('Y-m-d') . ".csv";

        $data = "NIS,Nama Santri,Bulan/Tahun,Status,Sisa Tagihan\n";
        foreach ($query->result() as $row) {
            $period = date('F', mktime(0, 0, 0, $row->bulan, 10)) . " " . $row->tahun;
            $data .= "{$row->nis},{$row->santri_nama},{$period},{$row->status},{$row->nominal_akhir}\n";
        }

        force_download($filename, $data);
    }

    public function monitoring()
    {
        $data['title'] = 'Matrix Monitoring SPP';
        $this->load->library('pagination');

        // 1. Get Tahun Ajaran & Filter Data
        $data['tahun_ajaran_list'] = $this->db->get('tahun_ajaran')->result();
        $data['angkatan_list'] = $this->db->get('angkatan')->result();

        $ta_id = $this->input->get('tahun_ajaran_id');
        $angkatan_id = $this->input->get('angkatan_id');
        $search = $this->input->get('search');

        // Default to active TA if not selected
        if (!$ta_id) {
            $active_ta = $this->db->where(['aktif' => 1])->get('tahun_ajaran')->row();
            $ta_id = $active_ta ? $active_ta->id : null;
        }

        $ta_selected = $this->db->where(['id' => $ta_id])->get('tahun_ajaran')->row();
        $data['ta_selected'] = $ta_selected;
        $data['angkatan_id'] = $angkatan_id;
        $data['search'] = $search;

        if ($ta_selected) {
            // 2. Pagination & Filtering Logic
            $this->db->from('santri s');
            if ($angkatan_id)
                $this->db->where('s.angkatan_id', $angkatan_id);
            if ($search) {
                $this->db->group_start();
                $this->db->like('s.nama', $search);
                $this->db->or_like('s.nis', $search);
                $this->db->group_end();
            }
            $this->db->where('s.status', 'ACTIVE');
            $total_rows = $this->db->count_all_results();

            $per_page = 25;
            $offset = $this->input->get('per_page');
            if ($offset === NULL) {
                $offset = 0;
                $_GET['per_page'] = '0'; // Penting: Pagination CI3 membaca langsung dari $_GET jika page_query_string = TRUE
            }
            $offset = (int) $offset;

            $config['base_url'] = base_url('keuangan/laporan/monitoring');
            $config['total_rows'] = (int) $total_rows;
            $config['per_page'] = $per_page;
            $config['page_query_string'] = TRUE;
            $config['reuse_query_string'] = TRUE;
            $config['query_string_segment'] = 'per_page';
            $config['cur_page'] = (string) $offset; // Explicitly set to avoid null detection
            $config['prefix'] = '';
            $config['suffix'] = '';

            // Styling Pagination (Tailwind/Flowbite compatible)
            $config['full_tag_open'] = '<ul class="flex items-center -space-x-px h-8 text-sm">';
            $config['full_tag_close'] = '</ul>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li><a href="#" aria-current="page" class="z-10 flex items-center justify-center px-3 h-8 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['attributes'] = array('class' => 'flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white');

            $this->pagination->initialize($config);

            // 3. Get Paginated Santri
            $this->db->select('s.id, s.nama, s.nis, a.nama as angkatan_nama');
            $this->db->from('santri s');
            $this->db->join('angkatan a', 'a.id = s.angkatan_id');
            if ($angkatan_id)
                $this->db->where('s.angkatan_id', $angkatan_id);
            if ($search) {
                $this->db->group_start();
                $this->db->like('s.nama', $search);
                $this->db->or_like('s.nis', $search);
                $this->db->group_end();
            }
            $this->db->where('s.status', 'ACTIVE');
            $this->db->order_by('a.tahun_masuk', 'DESC');
            $this->db->order_by('s.nama', 'ASC');
            $this->db->limit($per_page, $offset);
            $santri = $this->db->get()->result_array();

            // 4. Get Tagihan only for visible santris
            $tagihan_map = [];
            if (!empty($santri)) {
                $santri_ids = array_column($santri, 'id');
                $this->db->select('id, santri_id, bulan, tahun, status, nominal_akhir, jumlah_dibayar');
                $this->db->where_in('santri_id', $santri_ids);
                $this->db->where('tahun_ajaran_id', $ta_id);
                $tagihan_raw = $this->db->get('tagihan_spp')->result_array();

                foreach ($tagihan_raw as $t) {
                    $tagihan_map[$t['santri_id']][$t['bulan']][$t['tahun']] = $t;
                }
            }

            // 5. Define Months (Juli - Juni)
            $months = [];
            for ($i = 0; $i < 12; $i++) {
                $m = (($i + 6) % 12) + 1;
                $y = ($m >= 7) ? $ta_selected->tahun_mulai : $ta_selected->tahun_selesai;
                $months[] = ['bulan' => $m, 'tahun' => $y];
            }

            $data['santri'] = $santri;
            $data['tagihan_map'] = $tagihan_map;
            $data['months'] = $months;
            $data['pagination'] = $this->pagination->create_links();
        }

        $this->render('keuangan/laporan/monitoring', $data);
    }

    public function export_monitoring()
    {
        $ta_id = $this->input->get('tahun_ajaran_id');
        $ta = $this->db->where(['id' => $ta_id])->get('tahun_ajaran')->row();
        if (!$ta)
            redirect('keuangan/laporan/monitoring');

        $this->db->select('s.id, s.nama, s.nis, a.nama as angkatan_nama');
        $this->db->from('santri s');
        $this->db->join('angkatan a', 'a.id = s.angkatan_id');
        $this->db->where('s.status', 'ACTIVE');
        $this->db->order_by('a.tahun_masuk', 'DESC');
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

        $header = "NIS,Nama,Angkatan";
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
            $row = "{$s['nis']},{$s['nama']},{$s['angkatan_nama']}";
            foreach ($months as $mn) {
                $status = isset($tagihan_map[$s['id']][$mn['m']][$mn['y']]) ? $tagihan_map[$s['id']][$mn['m']][$mn['y']] : '-';
                $row .= ",{$status}";
            }
            $content .= $row . "\n";
        }

        force_download($filename, $content);
    }
}
