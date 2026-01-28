<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->allowed_roles = ['SUPER_ADMIN'];
    }

    public function index()
    {
        $data['title'] = 'Manajemen User';
        $data['users'] = $this->db->get('users')->result();
        $this->render('admin/users/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah User';
        $this->render('admin/users/create', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]|alpha_numeric|min_length[4]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[SUPER_ADMIN,ADMIN_KEUANGAN,WALI_SANTRI,SANTRI]');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role' => $this->input->post('role'),
                'status' => 'ACTIVE'
            ];

            $this->db->insert('users', $data);
            $this->log_activity('Menambah user baru: ' . $data['username'], 'Users', null, $data);

            $this->session->set_flashdata('success', 'User berhasil ditambahkan.');
            redirect('admin/users');
        }
    }

    public function edit($id)
    {
        $user = $this->db->get_where('users', ['id' => $id])->row();
        if (!$user)
            show_404();

        $data['title'] = 'Edit User';
        $data['user'] = $user;
        $this->render('admin/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->db->get_where('users', ['id' => $id])->row();
        if (!$user)
            show_404();

        $this->form_validation->set_rules('role', 'Role', 'required|in_list[SUPER_ADMIN,ADMIN_KEUANGAN,WALI_SANTRI,SANTRI]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[ACTIVE,INACTIVE]');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'role' => $this->input->post('role'),
                'status' => $this->input->post('status')
            ];

            // If password is provided, update it
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
                if ($this->form_validation->run() === TRUE) {
                    $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
                }
            }

            $this->db->update('users', $data, ['id' => $id]);
            $this->log_activity('Mengupdate user: ' . $user->username, 'Users', $user, $data);

            $this->session->set_flashdata('success', 'User berhasil diperbarui.');
            redirect('admin/users');
        }
    }

    public function delete($id)
    {
        $user = $this->db->get_where('users', ['id' => $id])->row();
        if (!$user)
            show_404();

        // Prevent deleting self
        if ($id == $this->user_id) {
            $this->session->set_flashdata('error', 'Anda tidak bisa menghapus akun sendiri.');
        } else {
            $this->db->delete('users', ['id' => $id]);
            $this->log_activity('Menghapus user: ' . $user->username, 'Users', $user, null);
            $this->session->set_flashdata('success', 'User berhasil dihapus.');
        }

        redirect('admin/users');
    }
}
