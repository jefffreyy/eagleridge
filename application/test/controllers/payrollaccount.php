<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class payrollaccount extends CI_Controller{
  function __construct(){
    parent::__construct();
    
    $this->load->library('session');
    $this->load->model('modules/payrollaccount_model');
  }
  function index(){
    $this->session->sess_destroy();
    $this->session->unset_userdata('SESS_ADMIN');
    $this->session->unset_userdata('SESS_USER_ID');
    $data['C_title']          = "Special Account";
    $data['C_action']         ='payrollaccount/login';
    $this->load->view('login/admin_login_views',$data);

  }
  function login(){

        $username             = $this->input->post('CALC_INPF_EMAIL');
        $password             = $this->input->post('CALC_INPF_PASS');
        $res                  = $this->payrollaccount_model->CHECKACCOUNT($username,$password);
        if(!empty($res->id)){
            $this->session->set_userdata('SESS_SPE_ACCOUNT',TRUE);
            $this->session->set_userdata('SESS_USER_ID',$res->id);
            redirect('payrollaccount/payroll');
        }
        
    }
    function payroll(){
        if ($this->session->userdata('SESS_USER_ID') == '') {
            redirect('login/session_expired');
        }
        $data["Modules"]=  array( 
            array("title"=>"Payslip Generator",     "value"=>"Payslip Generator",     "icon"=>"fas fa-receipt",              "url"=>"payrolls/payslip_generator",     "access"=>"Payroll"),
            array("title"=>"Company Contributions", "value"=>"Company Contributions", "icon"=>"fas fa-university",           "url"=>"payrolls/company_contributions", "access"=>"Payroll"),
            array("title"=>"13th Month Pay",        "value"=>"13th Month Pay",        "icon"=>"fas fa-hand-holding-usd",     "url"=>"payrolls/thitteenthmonthpay",    "access"=>"Payroll"),
            array("title"=>"Reimbursement",         "value"=>"Reimbursement",         "icon"=>"fas fa-undo",                 "url"=>"payrolls/reimbursements",        "access"=>"Payroll"),
            array("title"=>"Loans",                 "value"=>"Loans",                 "icon"=>"fas fa-hand-holding-medical", "url"=>"payrolls/loans",                 "access"=>"Payroll"),
            array("title"=>"Payroll Schedule",      "value"=>"Payroll Schedule",      "icon"=>"fas fa-clipboard-list",       "url"=>"payrolls/payroll_schedules",     "access"=>"Payroll"),
            array("title"=>"SSS Rates",             "value"=>"SSS Rates",             "icon"=>"fas fa-search-dollar",        "url"=>"payrolls/sss_rates",             "access"=>"Payroll"),
            array("title"=>"Philhealth Rates",      "value"=>"Philhealth Rates",      "icon"=>"fas fa-search-dollar",        "url"=>"payrolls/philhealth_rates",      "access"=>"Payroll"),
            array("title"=>"HDMF Rates",            "value"=>"HDMF Rates",            "icon"=>"fas fa-search-dollar",        "url"=>"payrolls/hdmf_rates",            "access"=>"Payroll"),
            array("title"=>"Withholding Tax",       "value"=>"Withholding Tax",       "icon"=>"fas fa-user-minus",           "url"=>"payrolls/tax_rates",             "access"=>"Payroll"),
          );
          $data["title_page"]="Payroll Module";
          $this->load->view('templates/header');
          $this->load->view('templates/main_nav',$data);
          
        // $this->load->view('templates/header_special');
        // $this->load->view('home/home_views', $data);
        // 
    }
}