<?php defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class login_payroll extends CI_Controller
{
    // Constructor
    function __construct()
    {
        parent::__construct();
        $this->load->model('login/login_payroll_model');
        
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('logger');
    }


    // Load the payroll login view
    function index()
    { 
        // $this->session->sess_destroy();
        $data['C_title']                                            = "Payroll Login";
        $data['C_action']                                           = 'login_payroll/sign_in';
        $this->load->view('login/payroll_login_views', $data);
    }


     // Process Payroll sign-in
     function sign_in(){
        $username                                                   = htmlentities($this->input->post('CALC_INPF_EMAIL'));
        $password                                                   = htmlentities($this->input->post('CALC_INPF_PASS'));
        $response                                                   = $this->login_payroll_model->login_payroll($username, $password);

        if ($response) {
            $this->session->set_userdata('SESS_USER_ID', 105);
            $this->logger->log_activity(105, 'Payroll login successful');
            redirect('payrolls');
        } else {
            $this->session->set_userdata('SESS_ERR_MSG_INVALID1','Incorrect Password or Email');
            redirect('login_payroll');
        }
    }

}