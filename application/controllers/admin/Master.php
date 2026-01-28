<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->allowed_roles = ['SUPER_ADMIN', 'ADMIN_KEUANGAN'];
    }

    // ==========================================
    // TAHUN AJARAN
    // ==========================================
    public function tahun_ajaran()
    {
        $data['title'] = 'Master Tahun Ajaran';
        $data['tahun_ajaran'] = $this->db->order_by('tahun_mulai', 'DESC')->get('tahun_ajaran')->result();
        $this->render('admin/master/tahun_ajaran', $data);
    }

    public function tahun_ajaran_store()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[tahun_ajaran.nama]');
        $this->form_validation->set_rules('tahun_mulai', 'Tahun Mulai', 'required|numeric');
        $this->form_validation->set_rules('tahun_selesai', 'Tahun Selesai', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->tahun_ajaran();
        } else {
            $data = [
                'nama' => $this->input->post('nama'),
                'tahun_mulai' => $this->input->post('tahun_mulai'),
                'tahun_selesai' => $this->input->post('tahun_selesai'),
                'aktif' => 0
            ];
            $this->db->insert('tahun_ajaran', $data);
            $this->session->set_flashdata('success', 'Tahun ajaran berhasil ditambahkan.');
            redirect('admin/master/tahun_ajaran');
        }
    }

    public function tahun_ajaran_aktifkan($id)
    {
        // Karena trigger dihapus, kita handle di sini
        $this->db->update('tahun_ajaran', ['aktif' => 0]);
        $this->db->update('tahun_ajaran', ['aktif' => 1], ['id' => $id]);

        $this->session->set_flashdata('success', 'Tahun ajaran berhasil diaktifkan.');
        redirect('admin/master/tahun_ajaran');
    }

    // ==========================================
    // JENJANG
    // ==========================================
    public function jenjang()
    {
        $data['title'] = 'Master Jenjang';
        $data['jenjang'] = $this->db->get('jenjang')->result();
        $this->render('admin/master/jenjang', $data);
    }

    public function jenjang_store()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[jenjang.nama]');

        if ($this->form_validation->run() === FALSE) {
            $this->jenjang();
        } else {
            $data = [
                'nama' => $this->input->post('nama'),
                'keterangan' => $this->input->post('keterangan')
            ];
            $this->db->insert('jenjang', $data);
            $this->session->set_flashdata('success', 'Jenjang berhasil ditambahkan.');
            redirect('admin/master/jenjang');
        }
    }

    // ==========================================
    // KELAS
    // ==========================================
    public function kelas()
    {
        $data['title'] = 'Master Kelas';
        $this->db->select('kelas.*, jenjang.nama as jenjang_nama');
        $this->db->from('kelas');
        $this->db->join('jenjang', 'jenjang.id = kelas.jenjang_id');
        $data['kelas'] = $this->db->get()->result();
        $data['jenjang'] = $this->db->get('jenjang')->result();
        $this->render('admin/master/kelas', $data);
    }

    public function kelas_store()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jenjang_id', 'Jenjang', 'required');
        $this->form_validation->set_rules('tingkat', 'Tingkat', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->kelas();
        } else {
            $data = [
                'nama' => $this->input->post('nama'),
                'jenjang_id' => $this->input->post('jenjang_id'),
                'tingkat' => $this->input->post('tingkat')
            ];
            $this->db->insert('kelas', $data);
            $this->session->set_flashdata('success', 'Kelas berhasil ditambahkan.');
            redirect('admin/master/kelas');
        }
    }

    // ==========================================
    // ANGKATAN
    // ==========================================
    public function angkatan()
    {
        $data['title'] = 'Master Angkatan';
        $data['angkatan'] = $this->db->order_by('tahun_masuk', 'DESC')->get('angkatan')->result();
        $this->render('admin/master/angkatan', $data);
    }

    public function angkatan_store()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[angkatan.nama]');
        $this->form_validation->set_rules('tahun_masuk', 'Tahun Masuk', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->angkatan();
        } else {
            $data = [
                'nama' => $this->input->post('nama'),
                'tahun_masuk' => $this->input->post('tahun_masuk'),
                'keterangan' => $this->input->post('keterangan')
            ];
            $this->db->insert('angkatan', $data);
            $this->session->set_flashdata('success', 'Angkatan berhasil ditambahkan.');
            redirect('admin/master/angkatan');
        }
    }

    // ==========================================
    // TARIF SPP
    // ==========================================
    public function tarif()
    {
        $data['title'] = 'Master Tarif SPP';
        $this->db->select('tarif_spp.*, tahun_ajaran.nama as tahun_ajaran_nama, jenjang.nama as jenjang_nama');
        $this->db->from('tarif_spp');
        $this->db->join('tahun_ajaran', 'tahun_ajaran.id = tarif_spp.tahun_ajaran_id');
        $this->db->join('jenjang', 'jenjang.id = tarif_spp.jenjang_id');
        $data['tarif'] = $this->db->get()->result();

        $data['tahun_ajaran'] = $this->db->get('tahun_ajaran')->result();
        $data['jenjang'] = $this->db->get('jenjang')->result();

        $this->render('admin/master/tarif', $data);
    }

    public function tarif_store()
    {
        $this->form_validation->set_rules('tahun_ajaran_id', 'Tahun Ajaran', 'required');
        $this->form_validation->set_rules('jenjang_id', 'Jenjang', 'required');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->tarif();
        } else {
            $data = [
                'tahun_ajaran_id' => $this->input->post('tahun_ajaran_id'),
                'jenjang_id' => $this->input->post('jenjang_id'),
                'nominal' => $this->input->post('nominal'),
                'keterangan' => $this->input->post('keterangan')
            ];

            // Cek unique constraint tahun_ajaran & jenjang
            $exists = $this->db->where([
                'tahun_ajaran_id' => $data['tahun_ajaran_id'],
                'jenjang_id' => $data['jenjang_id']
            ])->get('tarif_spp')->row();

            if ($exists) {
                $this->session->set_flashdata('error', 'Tarif untuk tahun ajaran dan jenjang tersebut sudah ada.');
            } else {
                $this->db->insert('tarif_spp', $data);
                $this->session->set_flashdata('success', 'Tarif berhasil ditambahkan.');
            }
            redirect('admin/master/tarif');
        }
    }
}
