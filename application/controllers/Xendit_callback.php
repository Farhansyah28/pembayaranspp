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

        // Debug Logging
        $log_data = "[" . date('Y-m-d H:i:s') . "] Callback received: " . $raw_json . "\n";
        file_put_contents('./xendit_debug.txt', $log_data, FILE_APPEND);

        if (!$payload) {
            file_put_contents('./xendit_debug.txt', "[" . date('Y-m-d H:i:s') . "] Error: Invalid Payload\n", FILE_APPEND);
            header('HTTP/1.1 400 Bad Request');
            echo 'Invalid Payload';
            return;
        }

        // 4. Handle Invoice Paid event
        if (isset($payload['status']) && $payload['status'] === 'PAID') {
            $external_id = isset($payload['external_id']) ? $payload['external_id'] : '';
            $parts = explode('-', $external_id);

            if (count($parts) >= 2) {
                $tagihan_id = $parts[1];
                $amount = $payload['amount'];
                $payment_channel = isset($payload['payment_channel']) ? $payload['payment_channel'] : 'XENDIT';

                file_put_contents('./xendit_debug.txt', "[" . date('Y-m-d H:i:s') . "] Processing Tagihan ID: $tagihan_id, Amount: $amount\n", FILE_APPEND);

                // Start Transaction
                $this->db->trans_start();

                // Check if tagihan exists
                $tagihan = $this->db->where('id', $tagihan_id)->get('tagihan_spp')->row();
                if ($tagihan && $tagihan->status != 'LUNAS') {

                    // 5. Insert to Pembayaran
                    $pembayaran_data = [
                        'tagihan_id' => $tagihan_id,
                        'admin_id' => NULL, // Automated (Allow NULL in Table)
                        'jumlah' => $amount,
                        'metode' => 'ONLINE (' . $payment_channel . ')',
                        'tanggal_bayar' => date('Y-m-d H:i:s'),
                        'status' => 'VERIFIED',
                        'catatan' => 'Pembayaran otomatis via Xendit'
                    ];

                    if (!$this->db->insert('pembayaran', $pembayaran_data)) {
                        $error = $this->db->error();
                        file_put_contents('./xendit_debug.txt', "[" . date('Y-m-d H:i:s') . "] DB Error Insert: " . json_encode($error) . "\n", FILE_APPEND);
                    }

                    // 6. Update Tagihan Status
                    $total_bayar = $this->db->select_sum('jumlah')->where(['tagihan_id' => $tagihan_id, 'status' => 'VERIFIED'])->get('pembayaran')->row()->jumlah;
                    $new_status = ($total_bayar >= $tagihan->nominal_akhir) ? 'LUNAS' : 'CICILAN';

                    if (!$this->db->where('id', $tagihan_id)->update('tagihan_spp', ['status' => $new_status, 'xendit_external_id' => $external_id])) {
                        $error = $this->db->error();
                        file_put_contents('./xendit_debug.txt', "[" . date('Y-m-d H:i:s') . "] DB Error Update: " . json_encode($error) . "\n", FILE_APPEND);
                    }

                    file_put_contents('./xendit_debug.txt', "[" . date('Y-m-d H:i:s') . "] Success: Status updated to $new_status\n", FILE_APPEND);
                } else {
                    file_put_contents('./xendit_debug.txt', "[" . date('Y-m-d H:i:s') . "] Skip: Tagihan not found or already LUNAS\n", FILE_APPEND);
                }

                $this->db->trans_complete();
            } else {
                file_put_contents('./xendit_debug.txt', "[" . date('Y-m-d H:i:s') . "] Error: Invalid external_id format\n", FILE_APPEND);
            }
        }

        echo 'Success';
    }
}
