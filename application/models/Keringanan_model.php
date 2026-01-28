<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keringanan_model extends CI_Model
{

    protected $table = 'keringanan_spp';

    public function get_active_by_santri($santri_id)
    {
        return $this->db->get_where($this->table, [
            'santri_id' => $santri_id,
            'aktif' => 1
        ])->row();
    }

    public function get_all()
    {
        $this->db->select('keringanan_spp.*, santri.nama as santri_nama, users.username as admin_nama');
        $this->db->from($this->table);
        $this->db->join('santri', 'santri.id = keringanan_spp.santri_id');
        $this->db->join('users', 'users.id = keringanan_spp.created_by');
        return $this->db->get()->result();
    }

    public function calculate_reduction($nominal_awal, $keringanan)
    {
        if (!$keringanan)
            return $nominal_awal;

        if ($keringanan->tipe == 'PERSEN') {
            $potongan = ($nominal_awal * $keringanan->nilai) / 100;
        } else {
            $potongan = $keringanan->nilai;
        }

        $final = $nominal_awal - $potongan;
        return ($final < 0) ? 0 : $final;
    }
}
