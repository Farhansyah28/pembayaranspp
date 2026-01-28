<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property CI_Input $input
 * @property CI_Router $router
 * @property CI_Form_validation $form_validation
 */
class MY_Controller extends CI_Controller
{

    protected $user_id;
    protected $username;
    protected $role;
    protected $allowed_roles = [];
    public $settings;

    public function __construct()
    {
        parent::__construct();

        // Load dynamic settings
        $settings_raw = $this->db->get('pengaturan')->result();
        $this->settings = new stdClass();

        // Default values
        $this->settings->nama_pesantren = 'Pesantren Digital';
        $this->settings->alamat_pesantren = '-';
        $this->settings->telepon_pesantren = '-';
        $this->settings->logo_pesantren = 'logo.png';

        foreach ($settings_raw as $s) {
            $this->settings->{$s->h_key} = $s->h_value;
        }

        // Security Headers
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('X-Content-Type-Options: nosniff');

        // Demo Mode Logic
        if (defined('DEMO_MODE') && DEMO_MODE) {
            // 1. Auto Login if no session
            if (!$this->session->userdata('user_id')) {
                $admin = $this->db->where('role', 'SUPER_ADMIN')->get('users')->row();
                if ($admin) {
                    $this->session->set_userdata([
                        'user_id' => $admin->id,
                        'username' => $admin->username,
                        'role' => $admin->role,
                        'logged_in' => TRUE
                    ]);
                }
            }

            // 2. Block POST requests (Write Protection)
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->router->class !== 'auth') {
                $this->session->set_flashdata('error', 'Mode Demo Aktif: Perubahan data tidak diizinkan.');
                redirect($_SERVER['HTTP_REFERER'] ?? 'dashboard');
            }

            // 3. Block Logout & Profile modifications
            if (($this->router->class === 'auth' && $this->router->method === 'logout') || $this->router->class === 'profile') {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' || $this->router->method === 'logout') {
                    $this->session->set_flashdata('error', 'Mode Demo Aktif: Akses dibatasi.');
                    redirect('dashboard');
                }
            }
        }

        // Skip auth check untuk controller Auth (Controller: Auth)
        if ($this->router->class !== 'auth') {
            $this->check_login();
            $this->check_role();
        }
    }

    private function check_login()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        $this->user_id = $this->session->userdata('user_id');
        $this->username = $this->session->userdata('username');
        $this->role = $this->session->userdata('role');
    }

    private function check_role()
    {
        if (!empty($this->allowed_roles)) {
            if (!in_array($this->role, $this->allowed_roles)) {
                show_error('Akses ditolak. Anda tidak memiliki hak akses yang cukup.', 403);
            }
        }
    }

    protected function render($view, $data = [])
    {
        $data['user_id'] = $this->user_id;
        $data['username'] = $this->username;
        $data['role'] = $this->role;
        $data['title'] = $data['title'] ?? 'SPP Pesantren';
        $data['user'] = $this->db->where('id', $this->session->userdata('user_id'))->get('users')->row();
        $data['settings'] = $this->settings;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('templates/footer', $data);
    }

    protected function log_activity($aktivitas, $modul, $data_before = null, $data_after = null)
    {
        $this->db->insert('log_aktivitas', [
            'user_id' => $this->user_id,
            'aktivitas' => $aktivitas,
            'modul' => $modul,
            'data_before' => $data_before ? json_encode($data_before) : null,
            'data_after' => $data_after ? json_encode($data_after) : null,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent()
        ]);
    }

    public function format_wa_number($number)
    {
        $number = preg_replace('/[^0-9]/', '', $number);
        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        } elseif (substr($number, 0, 2) !== '62') {
            $number = '62' . $number;
        }
        return $number;
    }

    public function generate_wa_link($phone, $message)
    {
        $phone = $this->format_wa_number($phone);
        return "https://wa.me/$phone?text=" . urlencode($message);
    }
}
