<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logger {
    protected $CI;

    private $table_name = 'tbl_activity_logs';

    public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
	}

	public function log_activity($user_id, $description)
	{
        $data = array(
            'create_date'   => date('Y-m-d H:i:s'),
            'empl_id'       => $user_id,
            'description'   => $description,
            'ip_address'    => $this->get_ip_address(),
            'computer_name' => $this->get_computer_name()
        );

        return $this->CI->db->insert($this->table_name, $data);
	}

	private function get_ip_address()
	{
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ip_list[0]);
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } else {
            return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        }
	}

	private function get_computer_name()
	{
        $ip = $this->get_ip_address();
        $hostname = @gethostbyaddr($ip);
        return ($hostname && $hostname !== $ip) ? $hostname : 'Unknown';
	}
}