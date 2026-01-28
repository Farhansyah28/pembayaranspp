<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->allowed_roles = ['SUPER_ADMIN', 'ADMIN_KEUANGAN'];
        $this->load->model('Keringanan_model');
    }

    public function index()
    {
        $data['title'] = 'Data Tagihan SPP';
        $this->db->select('tagihan_spp.*, santri.nama as santri_nama, santri.nis, kelas.nama as kelas_nama');
        $this->db->from('tagihan_spp');
        $this->db->join('santri', 'santri.id = tagihan_spp.santri_id');
        $this->db->join('kelas', 'kelas.id = santri.kelas_id');
        $this->db->where_in('tagihan_spp.status', ['BELUM_BAYAR', 'CICILAN']);
        $this->db->order_by('tagihan_spp.created_at', 'DESC');
        $data['tagihan'] = $this->db->get()->result();

        $this->render('keuangan/tagihan/index', $data);
    }

    public function generate()
    {
        $data['title'] = 'Generate Tagihan Baru';
        $data['tahun_ajaran'] = $this->db->where(['aktif' => 1])->get('tahun_ajaran')->row();
        $this->render('keuangan/tagihan/generate', $data);
    }

    public function do_generate()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        $tahun_ajaran = $this->db->where(['aktif' => 1])->get('tahun_ajaran')->row();
        if (!$tahun_ajaran) {
            $this->session->set_flashdata('error', 'Tidak ada tahun ajaran aktif.');
            redirect('keuangan/tagihan/generate');
        }

        // 1. Ambil data santri yang BELUM punya tagihan di bulan/tahun ini
        // Serta join dengan tarif dan keringanan aktif dalam SATU QUERY
        $this->db->select('s.id as santri_id, tr.nominal as tarif_awal, k.id as keringanan_id, k.tipe as k_tipe, k.nilai as k_nilai');
        $this->db->from('santri s');
        $this->db->join('kelas kls', 'kls.id = s.kelas_id');
        $this->db->join('tarif_spp tr', 'tr.jenjang_id = kls.jenjang_id AND tr.tahun_ajaran_id = ' . $tahun_ajaran->id);
        $this->db->join('keringanan_spp k', 'k.santri_id = s.id AND k.aktif = 1', 'left');
        // Left join untuk cek existensi tagihan
        $this->db->join('tagihan_spp t', "t.santri_id = s.id AND t.bulan = $bulan AND t.tahun = $tahun", 'left');

        $this->db->where('s.status', 'ACTIVE');
        $this->db->where('t.id IS NULL');
        $targets = $this->db->get()->result();

        $batch_data = [];
        $jatuh_tempo = date('Y-m-d', strtotime("$tahun-$bulan-10"));

        foreach ($targets as $t) {
            $nominal_asal = $t->tarif_awal;
            $nominal_akhir = $nominal_asal;
            $potongan = 0;

            if ($t->keringanan_id) {
                if ($t->k_tipe == 'PERSEN') {
                    $potongan = ($t->k_nilai / 100) * $nominal_asal;
                } else {
                    $potongan = $t->k_nilai;
                }
                $nominal_akhir = max(0, $nominal_asal - $potongan);
            }

            $batch_data[] = [
                'santri_id' => $t->santri_id,
                'tahun_ajaran_id' => $tahun_ajaran->id,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'tarif_awal' => $nominal_asal,
                'potongan' => $potongan,
                'nominal_akhir' => $nominal_akhir,
                'keringanan_id' => $t->keringanan_id,
                'status' => 'BELUM_BAYAR',
                'jatuh_tempo' => $jatuh_tempo
            ];
        }

        if (!empty($batch_data)) {
            $this->db->insert_batch('tagihan_spp', $batch_data);
        }

        $count = count($batch_data);
        $this->log_activity("Generate tagihan bulan $bulan $tahun untuk $count santri (OPTI MODE)", 'Tagihan');
        $this->session->set_flashdata('success', "Berhasil generate $count tagihan baru (Optimized).");
        redirect('keuangan/tagihan');
    }
}
