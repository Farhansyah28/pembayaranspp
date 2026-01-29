<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xendit_lib
{
    protected $ci;
    protected $secret_key;

    public function __construct()
    {
        $this->ci =& get_instance();

        // Get secret key from database settings
        $settings = $this->ci->db->where('h_key', 'xendit_secret_key')->get('pengaturan')->row();
        $this->secret_key = $settings ? $settings->h_value : '';
    }

    /**
     * Create an Invoice using Xendit
     */
    public function create_invoice($external_id, $amount, $payer_email, $description, $redirect_url = '')
    {
        $url = 'https://api.xendit.co/v2/invoices';

        $data = [
            'external_id' => $external_id,
            'amount' => (int) $amount,
            'payer_email' => $payer_email,
            'description' => $description,
            'should_send_email' => true,
            'currency' => 'IDR'
        ];

        if ($redirect_url) {
            $data['success_redirect_url'] = $redirect_url;
            $data['failure_redirect_url'] = $redirect_url;
        }

        return $this->_send_request($url, 'POST', $data);
    }

    /**
     * Get Invoice details
     */
    public function get_invoice($invoice_id)
    {
        $url = 'https://api.xendit.co/v2/invoices/' . $invoice_id;
        return $this->_send_request($url, 'GET');
    }

    /**
     * Internal CURL helper
     */
    private function _send_request($url, $method = 'POST', $data = [])
    {
        $headers = [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($this->secret_key . ':')
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($http_code < 200 || $http_code >= 300) {
            return [
                'status' => false,
                'message' => isset($result['message']) ? $result['message'] : 'Xendit API Error',
                'error_code' => isset($result['error_code']) ? $result['error_code'] : 'UNKNOWN_ERROR'
            ];
        }

        return [
            'status' => true,
            'data' => $result
        ];
    }
}
