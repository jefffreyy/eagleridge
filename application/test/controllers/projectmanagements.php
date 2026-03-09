<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class projectmanagements extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('modules/project_management_model');
    $this->load->model('templates/main_nav_model');
    $this->load->model('templates/main_table_01_model');
    if ($this->session->userdata('SESS_USER_ID') == '') {
      redirect('login/session_expired');
    }

    $maintenance          = $this->login_model->GET_MAINTENANCE();
    $isAdmin              = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }
  function index(){
    $data["Modules"]=  array( 
      array("title"=>"Task Management", "icon"=>"fas fa-tasks",        "url"=>"projectmanagements/task_managements", "access"=>"Project Management"),
      array("title"=>"Kanban Board",    "icon"=>"fas fa-table",        "url"=>"projectmanagements/kanban_boards",    "access"=>"Project Management"),
      array("title"=>"Schedule",        "icon"=>"fas fa-calendar-day", "url"=>"projectmanagements/schedules",        "access"=>"Project Management"),
      array("title"=>"Projects",        "icon"=>"fas fa-calendar-day", "url"=>"projectmanagements/projects",         "access"=>"Project Management"),
    );
    $data["title_page"]                   = "Project Managements Modules";
    $user_access_id                       = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE']        = $this->main_nav_model->get_user_access_page($user_access_id["col_user_access"]);
    $array_page                           = explode(", ",$data['DISP_USER_ACCESS_PAGE']["user_page"]);
    $data['Modules']                      = filter_array($data["Modules"],$array_page);
    $this->load->view('templates/header');
    $this->load->view('templates/main_nav',$data);
    
  }
  function task_managements(){

    $user_id                = $this->session->userdata('SESS_USER_ID');

    $data['DISP_TABLE']     = $this->project_management_model->MOD_DISP_ML_ALL_TASK();

    $data['DISP_ROW_COUNT'] = $this->project_management_model->MOD_DISP_ML_DATA_COUNT($user_id);

    $empl_id                = $this->session->userdata('SESS_USER_ID');

   
      
    
    $this->load->view('templates/header');

    $this->load->view('modules/project_managements/task_management_views', $data);

    
  } 

  function kanban_boards(){
    $this->load->view('templates/header');

    $this->load->view('modules/project_managements/KanbanView');

    
  }
  function schedules(){


    $this->load->view('templates/header');

    $this->load->view('modules/Calendar');

    

  }

  function projects(){

    
    $data['DISP_ALL_EMPLOYEES']     = $this->project_management_model->MOD_DISP_ALL_EMPLOYEES();

    $data['DISP_ALL_DATA']          = $this->project_management_model->MOD_DISP_ALL_REQUEST();
    $data['DISP_PROJECT_ASSIGN']    = $this->project_management_model->MOD_DISP_ALL_PROJECT_ASSIGN();

    $this->load->view('templates/header');

    $this->load->view('modules/project_managements/project_views', $data);

    

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
    $data["model_name"]                     = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"]               = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_show', $data);
    
  }
  function edit_data(){
    $data["model_name"]                     = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"]               = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_edit', $data);
    
  }
  function add_data(){
    $data["model_name"]                     = $model  = "main_table_01_model";
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_add', $data);
    
  }
  function edit_row(){
    $edit_user                              = $this->session->userdata('SESS_USER_ID');
    $input_data                             = $this->input->get();
    $set_array                              = array();
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
    $set_array['edit_user']                 = $edit_user;
    $this->main_table_01_model->edit_table_row($table,$id,$set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function add_row(){
    $edit_user                              = $this->session->userdata('SESS_USER_ID');
    $input_data                             = $this->input->get();
    $set_array                              = array();
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
    $set_array['edit_user']                 = $edit_user;
    $this->main_table_01_model->add_table_row($table, $set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function delete_row(){
    $edit_user                        = $this->session->userdata('SESS_USER_ID');
    $id                               = $this->input->get('delete_id');
    $table                            = $this->input->get('table');
    $module_name                      = $this->input->get('module');
    $page_name                        = $this->input->get('page');
    $this->main_table_01_model->delete_table_row($id,$table,$edit_user);
    $this->session->set_userdata('delete', 'Deleted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function edit_bulk_status(){
    $edit_user                        = $this->session->userdata('SESS_USER_ID');
    $status                           = $this->input->post('modal_title');
    $ids                              = $this->input->post('list_mark_ids');
    $ids_int                          = array_map('intval', explode(',', $ids));
    $module_name                      = $this->input->get('module');
    $page_name                        = $this->input->get('page_name');
    $table                            = $this->input->get('table');
    $page                             = $this->input->get('page');
    $row_url                          = '&row=';
    $row                              = $this->input->get('row');
    $tab                              = $this->input->get('tab');
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