<?php defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class login_sms extends CI_Controller
{
    // Constructor
    function __construct()
    {
        parent::__construct();
        $this->load->model('login/login_sms_model');
        
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
    }


    // Load the payroll login view
    function index()
    { 
        // $this->session->sess_destroy();
        $data['C_title']                                = "SMS Login";
        $data['C_action']                               = 'login_sms/sign_in';
        $this->load->view('login/sms_login_views', $data);
    }


     // Process Payroll sign-in
     function sign_in(){
        $username                                       = htmlentities($this->input->post('CALC_INPF_EMAIL'));
        $password                                       = htmlentities($this->input->post('CALC_INPF_PASS'));
        $response                                       = $this->login_sms_model->login_sms($username, $password);

        if ($response) {
            $this->session->set_userdata('SESS_USER_ID', 99999);
            redirect('sms_user');
        } else {
            $this->session->set_userdata('SESS_ERR_MSG_INVALID1','Incorrect Password or Email');
            redirect('login_sms');
        }
    }

}