<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class learnanddevelops extends CI_Controller
{
  function __construct(){
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('templates/main_table_01_model');
    $this->load->library('logger');
    //
    $this->load->model('modules/skill_map/skill_map_model');
    $this->load->model('settings/p220_leavetyp_mod');
    $this->load->model('main/p020_emplist_mod');
    $this->load->model('main/notif_model');
    // auto login starts
    $this->load->model('admin_model');
    $auto_login = $this->admin_model->get_system_setup_by_setting2('auto_login', '0');
    if ($auto_login == '1' && empty($this->session->userdata('SESS_USER_ID'))) {
      $this->session->set_userdata('SESS_USER_ID', 1);
    }
    // auto login ends
    if ($this->session->userdata('SESS_USER_ID') == '') {
      redirect('login/session_expired');
    }

    $maintenance= $this->login_model->GET_MAINTENANCE();
    $isAdmin = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }
  function index(){
    $data["Modules"]=  array( 
      array("title"=>"Trainings",        "value"=>"learn&develop_Trainings",                    "icon"=>"fas fa-running",      "url"=>"learnanddevelops/trainings",          "access"=>"Learn and Develop"),
      array("title"=>"Training Calendar","value"=>"Training Calendar",            "icon"=>"fas fa-calendar-day", "url"=>"learnanddevelops/training_calendars", "access"=>"Learn and Develop"),
      array("title"=>"Skills",           "value"=>"Learn and Development Skills", "icon"=>"fas fa-brain",        "url"=>"learnanddevelops/skills",             "access"=>"Learn and Develop")
    );
    $data["title_page"]="Learn and Develop Module";
    $user_access_id=$this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE']=$this->main_nav_model->get_user_access_page($user_access_id["col_user_access"]);
    $array_page=explode(", ",$data['DISP_USER_ACCESS_PAGE']["user_page"]);
    $data['Modules']=filter_array($data["Modules"],$array_page);
    $this->load->view('templates/header');
    $this->load->view('templates/main_nav',$data);
    
  }
  function trainings(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'learnanddevelops';
    $data["page_name"]        = $page_name    = 'supports';
    $data["model_name"]       = $model        = "main_table_01_model"; 
    $data["table_name"]       = $table        = "tbl_hr_supports";
    $data["module"]           = ["https://testhr.technos.app/learnanddevelops","Learn and Develops", "Trainings"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "WRN";
    $data["excel_output"]     = [true,"trainings.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Training"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Active","Inactive","","Pending"];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [10,25,50,100];
    $c_data_tab             = array(
                              array("All","status","All",0),
                              array("Active","status","Active",0),
                              array("Inactive","status","Inactive",0)
                            );
    $data["C_BULK_BUTTON"]  = array(
                              array(true, "btn_mark_active","far fa-check-circle","Mark as Active","status","Active"),    //visible,id,icon,Button Name,column,status
                              array(true, "btn_mark_inactive","far fa-times-circle","Mark as Inactive","status","Inactive"),    //visible,id,icon,Button Name,column,status
                              array(true, "btn_mark_pending","fas fa-exchange-alt","Mark as Pending","status","Pending")
                            );
    $data["C_DB_DESIGN"]  =	
    array(
      array("id","text",0,0,0,1,5,"ID","id",1,"0"),
      array("create_date","datetime-local",0,0,0,1,10,"Create Date","date",1,"0"),
      array("edit_date","datetime-local",0,0,0,0,0,"Edit Date","date",1,"0"),
      array("edit_user","text",0,0,0,0,0,"Last Edited By","user",1,"0"),
      array("is_deleted","text",0,0,0,0,0,"Is Deleted","none",0,"0"),
      array("title","text",256,1,1,1,25,"Title","none",1,"0"),
      array("description","area",256,1,1,1,30,"Description","textarea",1,"0"),
      array("feedback","area",256,1,1,0,0,"Feedback","textarea",1,"0"),
      array("status","sel",256,1,1,1,15,"Status","status",1,"Active;Inactive;Pending"),
      array("attachment","text",256,1,1,0,0,"Attachment","none",1,"0")
      );
    //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
    $search = str_replace('_', ' ', $this->input->get('all'));
    $data["default_row"]      = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]                =$this->$model->get_empl_name();
    $page = $this->input->get('page');
    $row  = $this->input->get('row');
    $tab  = $this->input->get('tab');
    if($page == null){ $page = 1; }
    if($row == null){ $row = $filter_row[0]; }
    if($tab == null){ $tab = "All"; }
    $offset = $row * ($page - 1);
    if($this->input->get('all') == null){
      $data["C_DATA_TABLE"]                    =$this->$model->get_data_list($table,$offset,$row,$tab,$view_type);
      $data["C_DATA_COUNT"]                    =$this->$model->get_data_count($table,$tab,$view_type);
    }else{
      $data["C_DATA_TABLE"]                    =$this->$model->get_specific_data($search,$row,$offset,$view_type); 
      $data["C_DATA_COUNT"]                    =$this->$model->get_data_count($table,$tab,$view_type);
    }
    $i=0;
    foreach($c_data_tab as $c_data_tab_row){
      $c_data_tab[$i][3] = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
      $i++;
    }
    $data["C_DATA_TAB"]    = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_01', $data);
    
  }
  function training_calendars(){
    $this->load->view('templates/header');
    
  }
  function skills(){
    $data['DISP_ALL_DATA'] = $this->skill_map_model->MOD_DISP_ALL_REQUEST();
    $data['DISP_ROW_COUNT'] = $this->skill_map_model->MOD_DISP_ALL_DATA_COUNT();
   
    $this->load->view('templates/header');
    $this->load->view('modules/learn_and_develop/skill_views', $data);
    
  }
  //-------------------------------------------------------- CRUD FUNCTIONS starts
  function get_data_all_list(){
    $model            = $this->input->post('model_name');
    $table            = $this->input->post('table_name');
    $modal_id         = $this->input->post('modal_id');
    $data = $this->$model->get_data_row($table,$modal_id);
    echo (json_encode($data));
  }
  function show_data(){
    $data["model_name"]       = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"] =$this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_show', $data);
    
  }
  function edit_data(){
    $data["model_name"]       = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"] = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_edit', $data);
    
  }
  function add_data(){
    $data["model_name"]       = $model  = "main_table_01_model";
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added learning and development record');
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_add', $data);

  }
  function edit_row(){
    $edit_user = $this->session->userdata('SESS_USER_ID');
    $input_data = $this->input->get();
    $set_array = array();
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
    $set_array['edit_user'] = $edit_user;
    $this->main_table_01_model->edit_table_row($table,$id,$set_array);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Edited learning record');
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function add_row(){
    $edit_user = $this->session->userdata('SESS_USER_ID');
    $input_data = $this->input->get();
    $set_array = array();
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
    $set_array['edit_user'] = $edit_user;
    $this->main_table_01_model->add_table_row($table, $set_array);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added learning record');
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function delete_row(){
    $edit_user    = $this->session->userdata('SESS_USER_ID');
    $id           = $this->input->get('delete_id');
    $table        = $this->input->get('table');
    $module_name  = $this->input->get('module');
    $page_name    = $this->input->get('page');
    $this->main_table_01_model->delete_table_row($id,$table,$edit_user);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted learning record');
    $this->session->set_userdata('delete', 'Deleted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function edit_bulk_status(){
    $edit_user    = $this->session->userdata('SESS_USER_ID');
    $status            = $this->input->post('modal_title');
    $ids              = $this->input->post('list_mark_ids');
    $ids_int = array_map('intval', explode(',', $ids));
    $module_name          = $this->input->get('module');
    $page_name            = $this->input->get('page_name');
    $table                = $this->input->get('table');
    $page                 = $this->input->get('page');
    $row_url              = '&row=';
    $row                  = $this->input->get('row');
    $tab                  = $this->input->get('tab');
    if($page == null){ $page = 1; }
    if($row == null){ $row_url = ''; $row='';}
    if($tab == null){ $tab = "All"; }
    // var_dump($status . $ids );
    $this->main_table_01_model->edit_bulk_status($table,$status,$ids_int,$edit_user);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated learning bulk status');
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
      if($module["value"]== $access){
          $modules[]=$module;
      }
    }
  }
  return $modules;
}