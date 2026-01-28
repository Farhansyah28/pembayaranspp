<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->allowed_roles = ['SUPER_ADMIN'];
    }

    public function index()
    {
        $data['title'] = 'Log Aktivitas Sistem';

        $this->db->select('log_aktivitas.*, users.username');
        $this->db->from('log_aktivitas');
        $this->db->join('users', 'users.id = log_aktivitas.user_id');
        $this->db->order_by('log_aktivitas.created_at', 'DESC');
        $this->db->limit(100);
        $data['logs'] = $this->db->get()->result();

        $this->render('admin/logs/index', $data);
    }
}
