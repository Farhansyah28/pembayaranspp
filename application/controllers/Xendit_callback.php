<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xendit_callback extends CI_Controller
{
    public function index()
    {
        // 1. Get Xendit Callback Token from Settings
        $settings = $this->db->where('h_key', 'xendit_callback_token')->get('pengaturan')->row();
        $xendit_token = $settings ? $settings->h_value : '';

        // 2. Get headers (More robust way for various server environments)
        $received_token = $this->input->get_request_header('x-callback-token', TRUE);
        if (!$received_token) {
            $received_token = isset($_SERVER['HTTP_X_CALLBACK_TOKEN']) ? $_SERVER['HTTP_X_CALLBACK_TOKEN'] : '';
        }

        if ($received_token !== $xendit_token) {
            header('HTTP/1.1 403 Forbidden');
            echo 'Invalid Token';
            return;
        }

        // 3. Get JSON Payload
        $raw_json = file_get_contents('php://input');
        $payload = json_decode($raw_json, true);

        if (!$payload) {
            header('HTTP/1.1 400 Bad Request');
            echo 'Invalid Payload';
            return;
        }

        // 4. Handle Invoice Paid event
        if ($payload['status'] === 'PAID') {
            $external_id = $payload['external_id']; // Format: SPP-ID-TIME
            $parts = explode('-', $external_id);
            if (count($parts) < 2)
                return;

            $tagihan_id = $parts[1];
            $amount = $payload['amount'];
            $payment_method = $payload['payment_method'];
            $payment_channel = $payload['payment_channel'];

            // Start Transaction
            $this->db->trans_start();

            // Check if tagihan exists
            $tagihan = $this->db->where('id', $tagihan_id)->get('tagihan_spp')->row();
            if ($tagihan && $tagihan->status != 'LUNAS') {

                // 5. Insert to Pembayaran
                $pembayaran_data = [
                    'tagihan_id' => $tagihan_id,
                    'admin_id' => NULL, // Automated
                    'jumlah' => $amount,
                    'metode' => 'ONLINE (' . $payment_channel . ')',
                    'tanggal_bayar' => date('Y-m-d H:i:s'),
                    'status' => 'VERIFIED',
                    'catatan' => 'Pembayaran otomatis via Xendit'
                ];
                $this->db->insert('pembayaran', $pembayaran_data);

                // 6. Update Tagihan Status
                $total_bayar = $this->db->select_sum('jumlah')->where(['tagihan_id' => $tagihan_id, 'status' => 'VERIFIED'])->get('pembayaran')->row()->jumlah;
                $new_status = ($total_bayar >= $tagihan->nominal_akhir) ? 'LUNAS' : 'CICILAN';

                $this->db->where('id', $tagihan_id)->update('tagihan_spp', [
                    'status' => $new_status,
                    'xendit_external_id' => $external_id // Ensure synced
                ]);
            }

            $this->db->trans_complete();
        }

        echo 'Success';
    }
}
