<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class recruitments extends CI_Controller
{
  function __construct(){
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('templates/main_table_01_model');
    // 
    $this->load->model('modules/recruitments_model');
  
    // 
    $this->load->helper(array('form', 'url'));
    $this->load->model('modules/recruitments_model');


    if ($this->session->userdata('SESS_USER_ID') == '') {
      redirect('login/session_expired');
    }

    $maintenance              = $this->login_model->GET_MAINTENANCE();
    $isAdmin                  = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }
  function index(){
    $data["Modules"]=  array( 
      array("title"=>"Job Posting",        "icon"=>"fas fa-search-plus", "url"=>"recruitments/job_postings",        "access"=>"Recruitment"),
      array("title"=>"Applicant Tracking", "icon"=>"fas fa-route",       "url"=>"recruitments/applicant_trackings", "access"=>"Recruitment"),
      array("title"=>"Examination List",   "icon"=>"fas fa-users",       "url"=>"recruitments/examination_list",    "access"=>"Recruitment"),
      array("title"=>"Exam Forms",         "icon"=>"fas fa-file-alt",    "url"=>"recruitments/exam_forms",          "access"=>"Recruitment"),
      array("title"=>"Onboarding",         "icon"=>"fas fa-sign-in-alt", "url"=>"recruitments/onboardings",         "access"=>"Recruitment"),
    );
    // var_dump($data["Modules"]);
    $data["title_page"]             = "Recruitment Modules";
    $user_access_id                 = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE']  = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
    $array_page                     =  explode(", ",$data['DISP_USER_ACCESS_PAGE']["user_page"]);
    $data['Modules']                = filter_array($data["Modules"],$array_page);
    $this->load->view('templates/header');
    $this->load->view('templates/main_nav',$data);
    
  }
  function job_postings(){
    $data['DISP_ALL_DATA']          = $this->recruitments_model->MOD_DISP_ALL_REQUEST();
    $data['DISP_ROW_COUNT']         = $this->recruitments_model->MOD_DISP_ALL_DATA_COUNT();
    $this->load->view('templates/header');
    $this->load->view('modules/recruitments/job_posting_views', $data);
    
  }
  function applicant_trackings(){
    $data['DISP_ALL_DATA']          = $this->recruitments_model->MOD_DISP_ALL_REQUEST_APPLICANT();
    $this->load->view('templates/header');
    $this->load->view('modules/recruitments/applicant_tracking_views', $data);
    
  }
  function examination_list(){
    $user_id                        = $this->session->userdata('SESS_USER_ID');
    $data['DISP_TABLE']             = $this->examination_model->MOD_DISP_MY_REQUEST($user_id);
    $data['DISP_TYPES_INFO']        = $this->recruitments_model->MOD_DISP_LEAVETYPES();
    $data['DISP_ROW_COUNT']         = $this->examination_model->MOD_DISP_ML_DATA_COUNT($user_id);
    $empl_id                        = $this->session->userdata('SESS_USER_ID');
    $notif_application              = $this->recruitments_model->MOD_DISP_NOTIF_APPLICATION($empl_id);
    foreach($notif_application as $notif_application_row){
        $notif_id                   = $notif_application_row->id;
        if($notif_application_row->type == "Leave"){
            $my_app_info            = $this->login_model->mod_check_leave_application_status($notif_application_row->application_id);
            if(count($my_app_info) > 0){
                $my_appl_status1    = $my_app_info[0]->col_leave_status1;
                $my_appl_status2    = $my_app_info[0]->col_leave_status2;
                $my_appl_status3    = $my_app_info[0]->col_leave_status3;
                if( ($my_appl_status1 == "Approved") && ($my_appl_status2 == "Approved") && ($my_appl_status3 == "Approved") ){
                    $this->recruitments_model->MOD_UPDT_APPLICATION_NOTIF_STATUS(1, $empl_id, $notif_id);
                }
                if( ($my_appl_status1 == "Rejected") || ($my_appl_status2 == "Rejected") || ($my_appl_status3 == "Rejected") ){
                    $this->recruitments_model->MOD_UPDT_APPLICATION_NOTIF_STATUS(1, $empl_id, $notif_id);
                }
            }
        }
    }
    $this->load->view('templates/header');
    $this->load->view('modules/recruitments/examination_views',$data);
    
  }
  function exam_forms(){
    $user_id                      = $this->session->userdata('SESS_USER_ID');
    $data['DISP_TABLE']           = $this->recruitment_model->MOD_DISP_MY_REQUEST($user_id);
    $data['DISP_TYPES_INFO']      = $this->recruitments_model->MOD_DISP_LEAVETYPES();
    $data['DISP_ROW_COUNT']       = $this->recruitment_model->MOD_DISP_ML_DATA_COUNT($user_id);
    $empl_id                      = $this->session->userdata('SESS_USER_ID');
    $notif_application            = $this->recruitments_model->MOD_DISP_NOTIF_APPLICATION($empl_id);
    foreach($notif_application as $notif_application_row){
        $notif_id                 = $notif_application_row->id;
        if($notif_application_row->type == "Leave"){
            $my_app_info          = $this->login_model->mod_check_leave_application_status($notif_application_row->application_id);
            if(count($my_app_info) > 0){
                $my_appl_status1  = $my_app_info[0]->col_leave_status1;
                $my_appl_status2  = $my_app_info[0]->col_leave_status2;
                $my_appl_status3  = $my_app_info[0]->col_leave_status3;
                if( ($my_appl_status1 == "Approved") && ($my_appl_status2 == "Approved") && ($my_appl_status3 == "Approved") ){
                    $this->recruitments_model->MOD_UPDT_APPLICATION_NOTIF_STATUS(1, $empl_id, $notif_id);
                }
                if( ($my_appl_status1 == "Rejected") || ($my_appl_status2 == "Rejected") || ($my_appl_status3 == "Rejected") ){
                    $this->recruitments_model->MOD_UPDT_APPLICATION_NOTIF_STATUS(1, $empl_id, $notif_id);
                }
            }
        }
    }
    $this->load->view('templates/header');
    $this->load->view('modules/recruitments/examination_form_views',$data);
    
  }
  function onboardings(){
    $data['DISP_ALL_DATA']      = $this->onboarding_model->MOD_DISP_ALL_REQUEST();
    $data['DISP_ROW_COUNT']     = $this->onboarding_model->MOD_DISP_ALL_DATA_COUNT();
    $this->load->view('templates/header');
    $this->load->view('modules/onboarding/onboarding_views', $data);
    
  }
  //-------------------------------------------------------- CRUD FUNCTIONS starts
  function get_data_all_list(){
    $model                      = $this->input->post('model_name');
    $table                      = $this->input->post('table_name');
    $modal_id                   = $this->input->post('modal_id');
    $data = $this->$model->get_data_row($table,$modal_id);
    echo (json_encode($data));
  }
  function show_data(){
    $data["model_name"]         = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"]   = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_show', $data);
    
  }
  function edit_data(){
    $data["model_name"]         = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"]   = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_edit', $data);
    
  }
  function add_data(){
    $data["model_name"]         = $model  = "main_table_01_model";
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_add', $data);
    
  }
  function edit_row(){
    $edit_user                  = $this->session->userdata('SESS_USER_ID');
    $input_data                 = $this->input->get();
    $set_array                  = array();
    foreach($input_data as $key => $value){
      if($key == "id"){
        $id = $value;
      }
      else if($key == "table"){
        $table = $value;
      }
      else if($key == "module"){
        $module_name = $value;
      }
      else if($key == "page"){
        $page_name = $value;
      }
      else{
        $set_array[$key] = $value;
      }
    }
    $set_array['edit_user']       = $edit_user;
    $this->main_table_01_model->edit_table_row($table,$id,$set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function add_row(){
    $edit_user                    = $this->session->userdata('SESS_USER_ID');
    $input_data                   = $this->input->get();
    $set_array                    = array();
    foreach($input_data as $key => $value){
      if($key == "table"){
        $table = $value;
      }
      else if($key == "module"){
        $module_name = $value;
      }
      else if($key == "page"){
        $page_name = $value;
      }
      else{
        $set_array[$key] = $value;
      }
    }
    $set_array['edit_user']       = $edit_user;
    $this->main_table_01_model->add_table_row($table, $set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function delete_row(){
    $edit_user                    = $this->session->userdata('SESS_USER_ID');
    $id                           = $this->input->get('delete_id');
    $table                        = $this->input->get('table');
    $module_name                  = $this->input->get('module');
    $page_name                    = $this->input->get('page');
    $this->main_table_01_model->delete_table_row($id,$table,$edit_user);
    $this->session->set_userdata('delete', 'Deleted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function edit_bulk_status(){
    $edit_user                    = $this->session->userdata('SESS_USER_ID');
    $status                       = $this->input->post('modal_title');
    $ids                          = $this->input->post('list_mark_ids');
    $ids_int = array_map('intval', explode(',', $ids));
    $module_name                  = $this->input->get('module');
    $page_name                    = $this->input->get('page_name');
    $table                        = $this->input->get('table');
    $page                         = $this->input->get('page');
    $row_url                      = '&row=';
    $row                          = $this->input->get('row');
    $tab                          = $this->input->get('tab');
    if($page == null){ $page = 1; }
    if($row == null){ $row_url = ''; $row='';}
    if($tab == null){ $tab = "All"; }
    // var_dump($status . $ids );
    $this->main_table_01_model->edit_bulk_status($table,$status,$ids_int,$edit_user);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    //  var_dump($ids_int);
    redirect($module_name.'/'.$page_name.'?page='.$page.$row_url.$row.'&tab='.$tab);
  }
  //-------------------------------------------------------- CRUD FUNCTIONS ends
}
function filter_array($user_modules,$user_access){
  $modules=array();
  foreach($user_modules as $module){
    foreach($user_access as $access){
      if($module["title"]== $access){
          $modules[]=$module;
      }
    }
  }
  return $modules;
}