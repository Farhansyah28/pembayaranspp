<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            $this->redirect_by_role();
        } else {
            redirect('auth/login');
        }
    }

    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            $this->redirect_by_role();
            return;
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login');
        } else {
            $this->do_login();
        }
    }

    private function do_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->User_model->get_by_username($username);

        if ($user && password_verify($password, $user->password)) {
            if ($user->status !== 'ACTIVE') {
                $this->session->set_flashdata('error', 'Akun Anda tidak aktif.');
                redirect('auth/login');
                return;
            }

            $this->session->set_userdata([
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'logged_in' => TRUE
            ]);

            $this->redirect_by_role();
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah.');
            redirect('auth/login');
        }
    }

    private function redirect_by_role()
    {
        $role = $this->session->userdata('role');
        switch ($role) {
            case 'SUPER_ADMIN':
            case 'ADMIN_KEUANGAN':
                redirect('dashboard/admin');
                break;
            case 'WALI_SANTRI':
                redirect('dashboard/wali');
                break;
            case 'SANTRI':
                redirect('dashboard/santri');
                break;
            default:
                redirect('auth/logout');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
