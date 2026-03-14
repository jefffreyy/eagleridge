<?php defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class admin extends CI_Controller
{
    // test for github
    function __construct()
    {
        parent::__construct();
        $this->load->model('login/admin_model');
        
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('logger');
    }
    
    function index()
    { 
        $this->session->sess_destroy();
        $data['C_title']                                         = "Admin";
        $data['C_action']                                        = 'admin/sign_in';
        $data['DISP_LOGO']                                       = $this->admin_model->get_logo();
        $this->load->view('login/admin_login_views', $data);
    }
    
    function user_select(){
        $data['DISP_LOGO']                                       = $this->admin_model->get_logo();
        $admin_session                                           = $this->session->userdata('SESS_ADMIN');
        if ($admin_session != 1) {
            redirect('admin');
        }
        $data["Users"]                                           = $this->admin_model->GET_ALL_USERS();
        $data["positions"]                                       = $this->admin_model->GET_ALL_POSITIONS();
        $this->load->view('login/admin_user_select_views', $data);
    }
    
    function sign_in(){
        $username                                                = htmlentities($this->input->post('CALC_INPF_EMAIL'));
        $password                                                = htmlentities($this->input->post('CALC_INPF_PASS'));
        $response                                                = $this->admin_model->LOGIN_ADMIN($username, $password);

        if ($response) {
            $this->session->set_userdata('SESS_ADMIN', 1);
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Admin logged in');
            redirect('admin/user_select');
        } else {
            redirect('admin');
        }
    }

    function login_user(){
        $user_id                                                = $this->input->get('id');
        $this->session->set_userdata('SESS_USER_ID', $user_id);
        $this->logger->log_activity($user_id, 'Admin logged in');
        if (empty($user_id)) {
            redirect('admin');
            return;
        } 
        $disabled                                               = $this->admin_model->GET_USER_DISABLED($user_id);
        if ($disabled['disabled'] == '1' || $disabled['termination_type'] >= '1') {
            $this->session->set_userdata('SESS_ERR_MSG_DISABLED', 'Your account was disabled');
            redirect('admin/user_select');
            return;
        }
        redirect('home');
    }
    
    function signout(){
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Admin logged out');
        $this->session->unset_userdata('SESS_ADMIN');
        redirect('admin');
    }
}
