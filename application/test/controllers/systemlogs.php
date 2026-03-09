<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class systemlogs extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('SESS_USER_ID') == '') {
            redirect('login/session_expired');
          }
      
          $maintenance= $this->login_model->GET_MAINTENANCE();
          $isAdmin = $this->session->userdata('SESS_ADMIN');
          if ($maintenance == '1' && $isAdmin != 1) {
            redirect('login/maintenance');
          }
    }
    function index()
    {
        $this->load->view('templates/header');
        
    }
}