<?php defined('BASEPATH') OR exit('No direct script access allowed');
ob_start(); 
class login extends CI_Controller
{
    function __construct()
    {
      parent::__construct();
      $this->load->model('login/login_model');
      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');
      $this->load->library('session');
      
    }

    function index()
    {
      $this->session->unset_userdata('SESS_USER_ID');
      $this->session->unset_userdata('SESS_ADMIN');
      delete_cookie('username');
      delete_cookie('password');
      delete_cookie('cookie_search');
      $this->load->view('login/login_views');
    }

    function maintenance()
    {
      $this->session->unset_userdata('SESS_USER_ID');
      $this->session->unset_userdata('SESS_ADMIN');
      delete_cookie('username');
      delete_cookie('password');
      delete_cookie('cookie_search');

      $this->load->view('login/maintenance_views');
    }

    function session_expired()
    {
      $this->session->unset_userdata('SESS_USER_ID');
      $this->session->unset_userdata('SESS_ADMIN');
      delete_cookie('username');
      delete_cookie('password');
      delete_cookie('cookie_search');

      $this->load->view('login/session_expired_views');
    }

    function forgot_password(){
      $data['DISP_LOGO']                                            = $this->login_model->GET_LOGO();
      $this->load->view('login/forgot_pass_views',$data);
    }

    function change_password(){
      $this->load->view('login/change_pass_views');
    }

    function ip_address() {
      $ipaddress = '';
      if (isset($_SERVER['HTTP_CLIENT_IP']))
          $ipaddress                                                = $_SERVER['HTTP_CLIENT_IP'];
      else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
          $ipaddress                                                = $_SERVER['HTTP_X_FORWARDED_FOR'];
      else if(isset($_SERVER['HTTP_X_FORWARDED']))
          $ipaddress                                                = $_SERVER['HTTP_X_FORWARDED'];
      else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
          $ipaddress                                                = $_SERVER['HTTP_FORWARDED_FOR'];
      else if(isset($_SERVER['HTTP_FORWARDED']))
          $ipaddress                                                = $_SERVER['HTTP_FORWARDED'];
      else if(isset($_SERVER['REMOTE_ADDR']))
          $ipaddress                                                = $_SERVER['REMOTE_ADDR'];
      else
          $ipaddress                                                = 'UNKNOWN';
      return $ipaddress;
  }
    
    function sign_in(){
      $ip_add                                                       = $this->login_model->GET_IP_ADDRESS($this->ip_address());
      $activate_ip_address                                          = $this->login_model->GET_SYSTEM_IP_ADDRESS();
      
      $maintenance                                                  = $this->login_model->GET_MAINTENANCE();

      $activation                                                   = $this->login_model->GET_ACTIVATION();

      if($activation == "0"){
        redirect('client_activation/deactivated');
        return;
      }

      if($maintenance == '1'){
        $this->load->view('login/maintenance_views');
      }else{

      if($this->session->userdata('SESS_ADMIN')){
        redirect('admin/admin_home');
        return;
      }

      $email                                                      = htmlentities($this->input->post('CALC_INPF_EMAIL'));
      $password                                                   = htmlentities($this->input->post('CALC_INPF_PASS'));
      $remember                                                   = htmlentities($this->input->post('remember'));

      if($email && $password){
        if(count($this->login_model->VALIDATE_USER($email))){
          $user = $this->login_model->GET_USER_ID($email);
          $disabled = $this->login_model->GET_DISABLED($email);

          if($user->password_attempt>=10){
            $this->session->set_userdata('SESS_ERR_MSG_INVALID1','Error 103 : Account Locked');
            redirect('login');
          }

          if($disabled > 0){
            $this->session->set_userdata('SESS_ERR_MSG_INVALID1','Error 102 : Account Disabled');
            redirect('login');
            return;
          }

          $user_access_id                                         = $this->login_model->GET_USER_ACCESS_ID($user->id);
          $user_id                                                = $this->login_model->LOGIN_USER($email,$password,$user->col_salt_key);
          if(!$user_id){
            $this->session->set_userdata('SESS_ERR_MSG_INVALID1','Error 101 : Incorrect Password');
            $this->login_model->UPDATE_ATTEMPT($user->id,TRUE);
            redirect('login');
          }

          if($activate_ip_address == 1){
            if($ip_add <= 0){
              $this->session->set_userdata('SESS_ERR_MSG_INVALID1','Error 104 : IP Address is not whitelisted');
              redirect('login');
              return;
            }
          }
          
          $this->login_model->UPDATE_ATTEMPT($user->id,FALSE);
          $check_status                                           = $this->login_model->GET_USER_STATUS($user_id);
          $this->session->set_userdata('SESS_USER_ACCESS_ID',$user_access_id);
          $this->session->set_userdata('SESS_USER_ID', $user_id);

          if($remember){
            set_cookie("username", $email , 2*60);
            set_cookie("password", $password , 2*60);
          }

          if($check_status == 0){
            redirect('login/change_password');
          } else {
              $this->session->set_userdata('SESS_SUCC_MSG_LOGIN','Login Successfully!');
              $this->session->set_userdata('SESS_ADMIN','0');

              redirect('home');
          }
        } else {
          $this->session->set_userdata('SESS_ERR_MSG_INVALID1','Error 100 : Account does not exist');
          redirect('login');
        }
      }
    }
    }

    function submit_new_password(){
      $user_id                                                    = $this->input->post('user_id');
      $new_password                                               = $this->input->post('new_password');
      $retype_password                                            = $this->input->post('retype_password');

      if($new_password == $retype_password){

        if(preg_match('/[\^£$%&*()}{#~?><>,|=+¬-]/', $new_password)){
          $this->session->set_userdata("SESS_ERR_PASSWORD", "Invalid Password only '@','_', and '.' are permitted");
          redirect('login/change_password');
          
        } else {

          $this->login_model->MOD_CHANGE_PASSWORD($new_password, $user_id);
          $this->session->set_userdata('SESS_SUCC_MSG_LOGIN','Login Successfully!');
          redirect('home');
        }

      } else {
        $this->session->set_userdata("SESS_ERR_PASSWORD", "Password does not match");
        redirect('login/change_password');
      }
    }

    function send_email(){

        $user_name= $this->input->post('user_name');

        $res=$this->login_model->GET_USER_EMAIL($user_name);
        $user_email='';
        if($res){
            $user_email=$res->col_empl_emai;
        }
      $empl_info = $this->login_model->CHECK_IF_EMAIL_EXIST($user_email);
      if($empl_info){
        $empl_id = '';
        $empl_cmid = '';
        $empl_name = '';

        foreach($empl_info as $empl_info_row){
          $empl_id                                                  = $empl_info_row->id;
          $empl_cmid                                                = $empl_info_row->col_empl_cmid;
          $empl_name                                                = $empl_info_row->col_frst_name.' '.$empl_info_row->col_last_name;
        }


        $reset_password_link                                        = base_url().'login/new_password?id='.$empl_id;

        $content_message                                            = "Hi There, ".$empl_name."!\r\n \r\nForgot your password?\r\nWe received a request to reset the password for your account \r\n \r\nTo reset your password, click the link below:\r\n".$reset_password_link."\r\n \r\n - HRCare Support Team";

        $message                                                    = $content_message;
        
        $fromname                                                   = 'HRCare Support';
        $subject                                                    = 'Password Reset';
        $fromemail                                                  = 'no-reply@erovoutika.ph'; //CPANEL EMAIL
        $mailto = $user_email;

        $separator                                                  = md5(time());
        $eol = "\r\n";

        $headers                                                    = "From: ".$fromname." <".$fromemail.">" . $eol;
        $headers                                                   .= "MIME-Version: 1.0" . $eol;
        $headers                                                   .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
        $headers                                                   .= "Content-Transfer-Encoding: 7bit" . $eol;
        $headers                                                   .= "This is a MIME encoded message." . $eol;

        $body                                                       = "--" . $separator . $eol;
        $body                                                      .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
        $body                                                      .= "Content-Transfer-Encoding: 8bit" . $eol;

        $body                                                      .= $message . $eol;


        //--------------- ATTACHMENT ----------------
        // $body .= "--" . $separator . $eol;
        // $body .= "Content-Type: application/octet-stream; name=\"" . $filenameee . "\"" . $eol;
        // $body .= "Content-Transfer-Encoding: base64" . $eol;
        // $body .= "Content-Disposition: attachment" . $eol;
        // $body .= $content . $eol;
        // $body .= "--" . $separator . "--";

        //SEND Mail
        if (mail($mailto, $subject, $body, $headers)) {

           $this->session->set_flashdata('success',"We've already sent a link to: ".$user_email.".<br> You may use this link to reset your password.");
           redirect('login/forgot_password');

        } else {

          echo 'failed';
        }
        

      } else {
        $this->session->set_flashdata('success',"We've already sent a link to: ".$user_email.".<br> You may use this link to reset your password.");
        redirect('login/forgot_password');
      }

    }

    function new_password(){
      $empl_id                                                      = $this->input->get('id');
      $this->session->set_userdata('SESS_USER_ID',$empl_id);
      $this->login_model->MOD_UPDT_REAL_PASS($empl_id);

      $this->load->view('login/new_password_views');
    }

    function sign_out(){

      
      if($this->session->userdata('SESS_ADMIN')){
        redirect('admin/user_select');
        return;
      }
      if($this->session->userdata('SESS_SPE_ACCOUNT')){
        redirect('payrollaccount');
        return;
      }
      $this->session->sess_destroy();
      redirect('login');
    }
}
