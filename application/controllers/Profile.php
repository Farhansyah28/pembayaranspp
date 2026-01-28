<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller
{

    public function index()
    {
        $data['title'] = 'Profil Saya';
        $data['user'] = $this->db->get_where('users', ['id' => $this->user_id])->row();
        $this->render('common/profile', $data);
    }

    public function update()
    {
        $password = $this->input->post('password');

        $data = [];
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        if (!empty($data)) {
            $this->db->update('users', $data, ['id' => $this->user_id]);
            $this->log_activity('Update password profil', 'Profile');
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('info', 'Tidak ada perubahan data.');
        }

        redirect('profile');
    }
}
