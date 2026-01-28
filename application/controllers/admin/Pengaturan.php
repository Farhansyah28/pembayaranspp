<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->allowed_roles = ['SUPER_ADMIN'];
    }

    public function index()
    {
        $data['title'] = 'Pengaturan Pesantren';
        $this->render('admin/pengaturan/index', $data);
    }

    public function update()
    {
        $nama = $this->input->post('nama_pesantren');
        $alamat = $this->input->post('alamat_pesantren');
        $telepon = $this->input->post('telepon_pesantren');

        $this->db->update('pengaturan', ['h_value' => $nama], ['h_key' => 'nama_pesantren']);
        $this->db->update('pengaturan', ['h_value' => $alamat], ['h_key' => 'alamat_pesantren']);
        $this->db->update('pengaturan', ['h_value' => $telepon], ['h_key' => 'telepon_pesantren']);

        // Handle Logo Upload
        if (!empty($_FILES['logo_pesantren']['name'])) {
            $config['upload_path'] = './uploads/branding/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = 'logo_' . time();

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('logo_pesantren')) {
                $upload_data = $this->upload->data();
                $this->db->update('pengaturan', ['h_value' => $upload_data['file_name']], ['h_key' => 'logo_pesantren']);
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
        }

        $this->log_activity("Memperbarui pengaturan branding pesantren", 'Pengaturan');
        $this->session->set_flashdata('success', 'Pengaturan berhasil diperbarui.');
        redirect('admin/pengaturan');
    }
}
