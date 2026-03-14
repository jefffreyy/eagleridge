<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class client_activation extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('modules/client_activation_model');
    $this->load->library('logger');
  }

  function index()
  {
    $this->load->view('modules/activation/client_activation_view');
  }

  function setup_1()
  {
    $data['DISP_COMPANY_NAME']                          = $this->client_activation_model->GET_COMPANY_NAME();
    $data['DISP_NAVBAR_LOGO']                           = $this->client_activation_model->GET_NAVBAR();
    $this->load->view('modules/activation/client_activation_1_view', $data);
  }

  function setup_2()
  {
    $this->load->view('modules/activation/client_activation_2_view');
  }

  function setup_3()
  {
    $this->load->view('modules/activation/client_activation_3_view');
  }

  function setup_4()
  {
    $this->load->view('modules/activation/client_activation_4_view');
  }

  function setup_5()
  {
    $this->load->view('modules/activation/client_activation_5_view');
  }

  function deactivated()
  {
    $this->load->view('modules/activation/client_deactivated_view');
  }

  function add_account()
  {

    $password                                           = $this->input->post('password');
    $c_password                                         = $this->input->post('confirm_password');

    if ($password == $c_password) {

      $empl_no                                          = $this->input->post('empl_no');
      $firstname                                        = $this->input->post('firstname');
      $midlname                                         = $this->input->post('midlname');
      $lastname                                         = $this->input->post('lastname');
      $username                                         = $this->input->post('username');

      $duplicate                                        = $this->client_activation_model->IS_DUPLICATE($username);
      if ($duplicate > 0) {
        $this->session->set_userdata("SESS_ERROR_MSG", "Username is already taken.");
        redirect("client_activation");
        return;
      }

      $this->client_activation_model->INSERT_NEW_ACCOUNT($empl_no, $username, $password, $lastname, $midlname, $firstname);
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added client account');
      redirect("client_activation/setup_1");
    } else {
      $this->session->set_userdata("SESS_ERROR_MSG", "The password and confirm password do not match.");
      redirect("client_activation");
    }
  }

  function UPDATE_COMPANY_NAME()
  {

    $data                                               = array(
      1 => $this->input->post('update_comp_name'),
    );

    $this->client_activation_model->UPDATE_COMPANY_NAME($data);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated company name');
    $this->load->library('upload');

    $logo_inputs                                        = array(
      'update_nav_logo' => 3
    );

    foreach ($logo_inputs as $input_name => $id) {
      $logo_file                                        = $_FILES[$input_name]['name'];

      if (!empty($logo_file)) {
        $rand = uniqid();
        $config['upload_path'] = './assets_system/images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '5000';
        $config['file_name'] = $rand . '_' . $logo_file;
        $config['overwrite'] = 'TRUE';
        $this->upload->initialize($config);

        $old_file                                       = $this->client_activation_model->GET_OLD_LOGO($id);
        if ($old_file && file_exists('./assets_system/images/' . $old_file)) {
          unlink('./assets_system/images/' . $old_file);
        }

        if ($this->upload->do_upload($input_name)) {

          $data_upload                                  = array($input_name => $this->upload->data());
          $upload_img                                   = $data_upload[$input_name]['file_name'];
          $this->client_activation_model->UPDATE_LOGIN_LOGO($upload_img, $id);
          $this->session->set_flashdata('SESS_SUCC_INSRT', 'Logos updated successfully');
        } else {
          $error_msg                                    = $this->upload->display_errors();
          $this->session->set_flashdata('error_msg', $error_msg);
        }
      }
    }
    redirect("client_activation/setup_2");
  }

  function update_organization()
  {
    $data                                               = array(
      33 => $this->input->post('branch'),
      34 => $this->input->post('dept'),
      35 => $this->input->post('division'),
      36 => $this->input->post('sect'),
      37 => $this->input->post('group'),
      38 => $this->input->post('team'),
      39 => $this->input->post('line')
    );

    $this->client_activation_model->UPDATE_ORG($data);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated organization');
    redirect("client_activation/setup_3");
  }

  function contribution_setting()
  {

    $data                                               = array(
      48 => $this->input->post('tax'),
      49 => $this->input->post('sss'),
      50 => $this->input->post('philhealth'),
      51 => $this->input->post('pagibig'),
      52 => $this->input->post('loans')
    );

    $this->client_activation_model->UPDATE_CONTRIBUTIONS_SETTING($data);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated contribution setting');
    redirect("client_activation/setup_4");
  }

  function date_coverage()
  {
    $name                                               = $this->input->post('label');
    $data_from                                          = $this->input->post('date_from');
    $date_to                                            = $this->input->post('date_to');
    $pay_period                                         = $this->input->post('pay_period');
    $year                                               = $this->input->post('year');

    $this->client_activation_model->INSERT_DATE_COVERAGE($name, $data_from, $date_to, $pay_period, $year);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated date coverage');
    redirect("client_activation/setup_5");
  }

  function site_restriction()
  {
    $create_date                                        = date("Y-m-d H:i:s");
    $ip_address                                         = $this->input->post('ip_address');

    $data = array(
      'site_access'                                     => $this->input->post('site_access'),
      'remote_attendance'                               => $this->input->post('remote'),
      'forgot_password'                                 => $this->input->post('forgot_pass')
    );

    $result                                             = $this->client_activation_model->UPDATE_SITE_RESTICTION_SETTING($data);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated site restriction');

    if ($ip_address) {
      $ip_add                                           = $this->client_activation_model->INSERT_IP_ADDRESS($create_date, $ip_address);
    }
    if ($result == 1) {
      $this->client_activation_model->UPDATE_ACTIVATION_SETTING();
      redirect("login");
    }
  }
}
