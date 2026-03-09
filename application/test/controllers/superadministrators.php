<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class superadministrators extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model('modules/superadministrators_model');
        $this->load->library('session');
        $this->load->helper('form');
        if ($this->session->userdata('SESS_USER_ID') == '') {
            redirect('login/session_expired');
          }
      
          $maintenance      = $this->login_model->GET_MAINTENANCE();
          $isAdmin          = $this->session->userdata('SESS_ADMIN');
          if ($maintenance == '1' && $isAdmin != 1) {
            redirect('login/maintenance');
          }
    }
    function index(){
        $data['DISP_SADMIN_STATUS']                 = $this->superadministrators_model->GET_SADMIN_STATUS1($this->session->userdata('SESS_USER_ID'));
        if($this->session->userdata("SESS_ADMIN")){
            $this->load->view('templates/header');
            $this->load->view('modules/superadministrators/super_administrator_views');
            
        }else{
            $this->load->view('templates/header');
            $this->load->view('modules/superadministrators/404_page_views');
            
        }
    }
    function setups(){
        $data['DISP_NAME']                          = $this->superadministrators_model->GET_NAME();
        $data['DISP_LOGO']                          = $this->superadministrators_model->GET_LOGO();
        $data['DISP_NAVBAR']                        = $this->superadministrators_model->GET_NAVBAR();
        $data['DISP_HEADER']                        = $this->superadministrators_model->GET_HEADER();
        $data['DISP_MOBILE_BANNER']                 = $this->superadministrators_model->GET_MOBILE_BANNER();
        $data['DISP_DESKTOP_BANNER']                = $this->superadministrators_model->GET_DESKTOP_BANNER();
        $data['DISP_HEADER_CONTENT']                = $this->superadministrators_model->GET_HEADER_CONTENT();
        $data['DISP_FOOTER_CONTENT']                = $this->superadministrators_model->GET_FOOTER_CONTENT();
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/setup_views',$data);
        
    }
    function module_activations()
    {
        $data['DISP_STATUS']                        = $this->superadministrators_model->GET_STATUS();
        $data['DISP_COMPANY_STATUS']                = $this->superadministrators_model->GET_COMPANY_STATUS();
        $data['DISP_EMPLOYEE_STATUS']               = $this->superadministrators_model->GET_EMPLOYEE_STATUS();
        $data['DISP_HR_STATUS']                     = $this->superadministrators_model->GET_HR_STATUS();
        $data['DISP_ATTENDANCE_STATUS']             = $this->superadministrators_model->GET_ATTENDANCE_STATUS();
        $data['DISP_LEAVE_STATUS']                  = $this->superadministrators_model->GET_LEAVE_STATUS();
        $data['DISP_PAYROLL_STATUS']                = $this->superadministrators_model->GET_PAYROLL_STATUS();
        $data['DISP_REC_STATUS']                    = $this->superadministrators_model->GET_REC_STATUS();
        $data['DISP_LEARN_STATUS']                  = $this->superadministrators_model->GET_LEARN_STATUS();
        $data['DISP_PERFORMANCE_STATUS']            = $this->superadministrators_model->GET_PERFORMANCE_STATUS();
        $data['DISP_REWARDS_STATUS']                = $this->superadministrators_model->GET_REWARDS_STATUS();
        $data['DISP_EXIT_STATUS']                   = $this->superadministrators_model->GET_EXIT_STATUS();
        $data['DISP_ASSET_STATUS']                  = $this->superadministrators_model->GET_ASSET_STATUS();
        $data['DISP_PROJ_STATUS']                   = $this->superadministrators_model->GET_PROJ_STATUS();
        $data['DISP_ADMIN_STATUS']                  = $this->superadministrators_model->GET_ADMIN_STATUS();
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/module_activation_views', $data);
        
    }

    function configurations(){
        $data["C_MAINTENANCE"]              = $this->superadministrators_model->GET_MAINTENANCE();
        $data["C_TIME_OUT"]                 = $this->superadministrators_model->GET_TIME_OUT();
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/configuration_views', $data);
        
    }
    function system_variables(){
        $data['SET_UP_VARIABLES']           = $this->superadministrators_model->GET_SET_UP_VARIABLES();
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/system_variable_views',$data);
        
    }
    function update_system_varibles(){
        $data           = $this->input->post();
        $process_data   = array();
        foreach($data as $key => $val) {
            $process_data[] =array(
                'id'        => $val['id'],
                'setting'   => $key,
                'value'     => $val['value']
                );
        }
        $res=$this->superadministrators_model->UPDATE_SETUP_VARIABLES($process_data);
        // if(!$res){
        //     $this->session->set_flashdata('error', 'Unable to update system variables');
        //     redirect('superadministrators/system_variables');
        //     return;
        // }
        $this->session->set_flashdata('success', 'Successfully Updated!');
        redirect('superadministrators/system_variables');
    }
    function system_data_reset(){
        $tables = $this->superadministrators_model->GET_ALL_TABLES();

        foreach ($tables as $table) {
            if( $table != 'tbl_system_setup' && 
                $table != 'tbl_employee_infos' && 
                $table != 'tbl_special_account' && 
                $table != 'tbl_system_adminusers' && 
                $table != 'tbl_system_useraccess' &&
                $table != 'tbl_payroll_period' &&
                $table != 'tbl_std_holidays' &&
                $table != 'tbl_payroll_sss' && 
                $table != 'tbl_payroll_philhealth' &&
                $table != 'tbl_std_adjustments' && 
                $table != 'tbl_std_allowances' && 
                $table != 'tbl_std_allowances_nontax' &&
                $table != 'tbl_std_allowances_tax' &&
                $table != 'tbl_std_assetcategories' &&
                $table != 'tbl_std_banks' &&
                $table != 'tbl_std_bloodtypes' &&
                $table != 'tbl_std_branches' &&
                $table != 'tbl_std_companylocations' &&
                $table != 'tbl_std_custom_contribution' &&
                $table != 'tbl_std_deductions' &&
                $table != 'tbl_std_deductions_nontax' &&
                $table != 'tbl_std_deductions_tax' &&
                $table != 'tbl_std_departments' &&
                $table != 'tbl_std_divisions' &&
                $table != 'tbl_std_employeetypes' &&
                $table != 'tbl_std_genders' &&
                $table != 'tbl_std_groups' &&
                $table != 'tbl_std_hmos' &&
                $table != 'tbl_std_holidays' &&
                $table != 'tbl_std_knowledgearticles' &&
                $table != 'tbl_std_knowledgecategories' &&
                $table != 'tbl_std_leavetypes' &&
                $table != 'tbl_std_lines' &&
                $table != 'tbl_std_maritalstatuses' &&
                $table != 'tbl_std_nationalities' &&
                $table != 'tbl_std_paygrade' &&
                $table != 'tbl_std_positions' &&
                $table != 'tbl_std_religions' &&
                $table != 'tbl_std_sections' &&
                $table != 'tbl_std_shirtsizes' &&
                $table != 'tbl_std_skilllevels' &&
                $table != 'tbl_std_skillnames' &&
                $table != 'tbl_std_stockrooms' &&
                $table != 'tbl_std_teams' &&
                $table != 'tbl_std_terminationtypes' &&
                $table != 'tbl_std_years' &&
                $table != 'tbl_attendance_shifts' ){
                $result = $this->superadministrators_model->TRUNCATE_DATABASE_TABLE($table);
            } 
        }
    }

    function time_out(){
        
        $id                 = $this->input->post('id');
        $is_on              = $this->input->post('main_on');
        $minutes            = 0;
        if($is_on=='on'){
            $minutes        = $this->input->post('minutes');
            $this->superadministrators_model->MOD_UPDATE_TIME_OUT($id,$minutes);
        }else{
            $this->superadministrators_model->MOD_UPDATE_TIME_OUT($id,$minutes);
        }
        redirect('superadministrators/configurations');
    }


    //======================================================== UPDATE SET_UPS FUNCTION ================================================================
    function update_company_name(){
        $companyName                                = $this->input->post('UPDATE_NAME');
        $this->superadministrators_model->MOD_UPDATE_NAME($companyName);
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPLY', '  Submitted Successfully!');
        redirect('superadministrators/setups');
    }
    function update_header_content(){
        $h_content                                  = $this->input->post('header');
        $this->superadministrators_model->UPDATE_HEADER_CONTENT($h_content);
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPLY', '  Submitted Successfully!');
        redirect('superadministrators/setups');
    }
    function update_footer_content(){
        $f_content                                  = $this->input->post('footer');
        $this->superadministrators_model->UPDATE_FOOTER_CONTENT($f_content);
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPLY', ' Submitted Successfully!');
        redirect('superadministrators/setups');
    }
    function update_logo()
    {
        $get_logo_name                              = $_FILES['INSRT_LOGIN_LOGO']['name'];
        $config['upload_path']                      = './assets_system/images/';
        $config['allowed_types']                    = 'png';
        $config['file_name']                        = "login_logo.png";
        $config['overwrite']                        = 'TRUE';
        $this->load->library('upload', $config);
        if($_FILES['INSRT_LOGIN_LOGO']['size'] != 0)
        {
            if ($this->upload->do_upload('INSRT_LOGIN_LOGO'))
            {
                $data_upload                            = array('INSRT_LOGIN_LOGO' => $this->upload->data());
                $logo_img                               = $data_upload['INSRT_LOGIN_LOGO']['file_name'];
                $this->superadministrators_model->INSERT_LOGO($logo_img);
                $this->session->set_flashdata('SESS_SUCC', 'New logo was Added!');
            }else{
                $error                                  = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('SESS_ERR_IMAGE', $error['error']);
            }
            
        } else {
            $this->session->set_flashdata('SESS_ERR_IMAGE', 'No logo was selected');
        }
        redirect('superadministrators/setups');
    }
    function update_navbar()
    {
        $get_logo_name                              = $_FILES['INSRT_NAVBAR_LOGO']['name'];
        $config['upload_path']                      = './assets_system/images/';
        $config['allowed_types']                    = 'png';
        $config['file_name']                        = 'navbar_logo.png';
        $config['overwrite']                        = 'TRUE';
        $this->load->library('upload', $config);
        if($_FILES['INSRT_NAVBAR_LOGO']['size'] != 0)
        {
            if ($this->upload->do_upload('INSRT_NAVBAR_LOGO'))
            {
                $data_upload                            = array('INSRT_NAVBAR_LOGO' => $this->upload->data());
                $logo_img                               = $data_upload['INSRT_NAVBAR_LOGO']['file_name'];
                $this->superadministrators_model->INSERT_NAVBAR($logo_img);
                $this->session->set_flashdata('SESS_SUCC', 'New logo was Added!');
            }else{
                $error                                  = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('SESS_ERR_IMAGE', $error['error']);
            }
        } else {
            $this->session->set_flashdata('SESS_ERR_IMAGE', 'No File selected');
            
        }
        redirect('superadministrators/setups');
    }
    function truncate_database_tables(){
        $data["tables"]         = $this->superadministrators_model->GET_ALL_TABLES();
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/truncate_table_views',$data);
        
    }
    function db_tracate($db_name){
        if($db_name=='tbl_system_setup'){
            redirect('database_tables');
            return;
        }
        $res=$this->superadministrators_model->DB_RESET($db_name);
    }
    function update_header()
    {
        $get_logo_name                              = $_FILES['INSRT_HEADER_LOGO']['name'];
        $config['upload_path']                      = './assets_system/images/';
        $config['allowed_types']                    = 'png';
        $config['file_name']                        = "header_logo.png";
        $config['overwrite']                        = 'TRUE';
        $this->load->library('upload', $config);
        if($_FILES['INSRT_HEADER_LOGO']['size'] != 0)
        {
            if ($this->upload->do_upload('INSRT_HEADER_LOGO'))
            {
                $data_upload                        = array('INSRT_HEADER_LOGO' => $this->upload->data());
                $logo_img                           = $data_upload['INSRT_HEADER_LOGO']['file_name'];
                $this->superadministrators_model->INSERT_HEADER($logo_img);
                $this->session->set_flashdata('SESS_SUCC_INSRT', 'New logo was Added!');
            }
        } else {
            $error                                  = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('SESS_ERR_IMAGE', $error['error']);
        }
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPLY', '  Submitted Successfully!');
        redirect('superadministrators/setups');
    }
    function mobile_banner()
    {
        $get_logo_name                              = $_FILES['INSRT_MOBILE_BANNER']['name'];
        $config['upload_path']                      = './assets_system/images/';
        $config['allowed_types']                    = 'jpg';
        $config['file_name']                        = "mobile_banner.jpg";
        $config['overwrite']                        = 'TRUE';
        $this->load->library('upload', $config);
        if($_FILES['INSRT_MOBILE_BANNER']['size'] != 0)
        {
            if ($this->upload->do_upload('INSRT_MOBILE_BANNER'))
            {
                $data_upload                        = array('INSRT_MOBILE_BANNER' => $this->upload->data());
                $logo_img                           = $data_upload['INSRT_MOBILE_BANNER']['file_name'];
                $this->superadministrators_model->UPDATE_MOBILE_BANNER($logo_img);
                $this->session->set_flashdata('SESS_SUCC', 'New banner was Added!');
            }
            else{
                $error                              = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('SESS_ERR_IMAGE', $error['error']);
            }
        } else {
            $this->session->set_flashdata('SESS_ERR_IMAGE', 'No logo was selected');
            redirect('superadministrators/setups');
        }
        $this->session->set_flashdata('SESS_SUCC', '  Submitted Successfully!');
        redirect('superadministrators/setups');
    }
    function desktop_banner()
    {
        $get_logo_name                              = $_FILES['INSRT_DESKTOP_BANNER']['name'];
        $config['upload_path']                      = './assets_system/images';
        $config['allowed_types']                    = 'jpg';
        $config['file_name']                        = "desktop_banner.jpg";
        $config['overwrite']                        = 'TRUE';
        $this->load->library('upload', $config);
        if($_FILES['INSRT_DESKTOP_BANNER']['size'] != 0){
            if ($this->upload->do_upload('INSRT_DESKTOP_BANNER'))
            {
                $data_upload                        = array('INSRT_DESKTOP_BANNER' => $this->upload->data());
                $logo_img                           = $data_upload['INSRT_DESKTOP_BANNER']['file_name'];
                $this->superadministrators_model->UPDATE_DESKTOP_BANNER($logo_img);
                $this->session->set_flashdata('SESS_SUCC', 'New banner was Added!');
            }
            else{
                $error                              = array('error' => $this->upload->display_errors());
                 $this->session->set_flashdata('SESS_ERR_IMAGE', $error['error']);
            }
        } else {
            $this->session->set_flashdata('SESS_ERR_IMAGE', 'No logo was selected');
            redirect('superadministrators/setups');
        }
        // $this->session->set_flashdata('SESS_SUCC', '  Submitted Successfully!');
        redirect('superadministrators/setups');
    }
    //======================================================== UPDATE MODULE ACTIVAITON =========================================================
    function update_status(){
        $data_check                                 = $this->input->post('data');
        foreach($data_check as $data){
            $status_id                              = isset($data['id']) ? $data['id'] : '';
            $value                                  = isset($data['values'])?implode(" ,",$data['values']) : 0 ;
            $this->superadministrators_model->MOD_UPDATE_STATUS($value, $status_id);
        }
        // $this->module_model->set_userdata('SESS_SUCC_MSG_INSRT_APPLY', '  Submitted Successfully!');
        redirect('superadministrators/module_activations');
    }

    function update_maintenance(){
        $id             = $this->input->post('id');
        $value          = $this->input->post('main_on');
        $checked = ($value == '') ? 0 : 1;
        $this->superadministrators_model->MOD_UPDATE_STATUS($checked, $id);
        redirect("superadministrators/configurations");
    }


    function update_process($status_id,$value){
        $checked = ($value == '') ? 0 : $value;
        $this->superadministrators_model->MOD_UPDATE_STATUS($checked, $status_id);
    }
    function get_modules(){
        $data[] = $this->superadministrators_model->GET_STATUS();
        $data[] = $this->superadministrators_model->GET_COMPANY_STATUS();
        $data[] = $this->superadministrators_model->GET_EMPLOYEE_STATUS();
        $data[] = $this->superadministrators_model->GET_HR_STATUS();
        $data[] = $this->superadministrators_model->GET_ATTENDANCE_STATUS();
        $data[] = $this->superadministrators_model->GET_LEAVE_STATUS();
        $data[] = $this->superadministrators_model->GET_PAYROLL_STATUS();
        $data[] = $this->superadministrators_model->GET_REC_STATUS();
        $data[] = $this->superadministrators_model->GET_LEARN_STATUS();
        $data[] = $this->superadministrators_model->GET_PERFORMANCE_STATUS();
        $data[] = $this->superadministrators_model->GET_REWARDS_STATUS();
        $data[] = $this->superadministrators_model->GET_EXIT_STATUS();
        $data[] = $this->superadministrators_model->GET_ASSET_STATUS();
        $data[] = $this->superadministrators_model->GET_PROJ_STATUS();
        $data[] = $this->superadministrators_model->GET_ADMIN_STATUS();
        // echo "<pre>";
        //     var_dump($data);
        // echo "</pre>";
        $data_string=array();
        $data_string[0]["user_page"]="";
        foreach($data as $module){
            $data_string[0]["user_page"].=$module['value'];
        }
        echo json_encode($data_string);
    }


    function insrt_attachment(){
        $attachment= $_FILES["INSRT_ATTACHMENT"]["name"];
        $response=$this->superadministrators_model->MOD_INSRT_ANNOUNCEMENTS($attachment);
        if($response){
            $upload_response=$this->do_upload();
            $this->session->set_userdata('SESS_SUCC_MSG_INSRT_ANNOUNCEMENTS','Knowledge Bases Added Successfully!');
        }
        redirect('superadministrators/configurations');
    }
    function get_time_out(){
        $time_out=$this->superadministrators_model->GET_TIME_OUT();
        echo json_encode($time_out);
    }

    public function do_upload(){
        $config['upload_path'] = './assets_system/sample_file/';
        $config['allowed_types'] = '*';
        $config['max_size'] = 0;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
  
        $this->load->library('upload', $config);
  
        if ( ! $this->upload->do_upload('INSRT_ATTACHMENT')){
          $error = array('error' => $this->upload->display_errors());
          return $error;
        }
        else
        {
          $data = array('upload_data' => $this->upload->data());
          return $data;
        }
      }


}