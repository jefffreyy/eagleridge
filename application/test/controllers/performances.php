<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class performances extends CI_Controller
{
  function __construct(){
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('templates/main_table_01_model');
    if ($this->session->userdata('SESS_USER_ID') == '') {
      redirect('login/session_expired');
    }

    $maintenance            = $this->login_model->GET_MAINTENANCE();
    $isAdmin                = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }
  function index(){
    $data["Modules"]=  array( 
      array("title"=>"Promotions",       "value"=>"Promotions",       "icon"=>"fas fa-user-check",  "url"=>"performances/promotions",       "access"=>"Performance"),
      array("title"=>"Appraisals",       "value"=>"Apprasals",        "icon"=>"fas fa-search",      "url"=>"performances/appraisals",       "access"=>"Performance"),
      array("title"=>"KPIs",             "value"=>"KPIs",             "icon"=>"fas fa-list-ol",     "url"=>"performances/kpis",             "access"=>"Performance"),
      array("title"=>"Goals",            "value"=>"Goals",            "icon"=>"fas fa-bullseye",    "url"=>"performances/goals",            "access"=>"Performance"),
      array("title"=>"Review Templates", "value"=>"Review Templates", "icon"=>"fas fa-book-reader", "url"=>"performances/review_templates", "access"=>"Performance"),
    );
    $data["title_page"]                         = "Performance Module";
    $user_access_id                             = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE']              = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
    $array_page                                 = explode(", ",$data['DISP_USER_ACCESS_PAGE']["user_page"]);
    $data['Modules']                            = filter_array($data["Modules"],$array_page);
    $this->load->view('templates/header');
    $this->load->view('templates/main_nav',$data);
    
  }
  function promotions(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'performances';
    $data["page_name"]        = $page_name    = 'supports';
    $data["model_name"]       = $model        = "main_table_01_model"; 
    $data["table_name"]       = $table        = "tbl_hr_supports";
    $data["module"]           = ["https://testhr.technos.app/performances","Performances", "Promotions"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "WRN";
    $data["excel_output"]     = [true,"promotions.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Promotion"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
    $search                                     = str_replace('_', ' ', $this->input->get('all'));
    $data["default_row"]                        = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
    $page                                       = $this->input->get('page');
    $row                                        = $this->input->get('row');
    $tab                                        = $this->input->get('tab');
    if($page == null){ $page = 1; }
    if($row == null){ $row = $filter_row[0]; }
    if($tab == null){ $tab = "All"; }
    $offset = $row * ($page - 1);
    if($this->input->get('all') == null){
      $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table,$offset,$row,$tab,$view_type);
      $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table,$tab,$view_type);
    }else{
      $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($search,$row,$offset,$view_type); 
      $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table,$tab,$view_type);
    }
    $i=0;
    foreach($c_data_tab as $c_data_tab_row){
      $c_data_tab[$i][3]                       = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                        = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_01', $data);
    
  }
  function appraisals(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'performances';
    $data["page_name"]        = $page_name    = 'supports';
    $data["model_name"]       = $model        = "main_table_01_model"; 
    $data["table_name"]       = $table        = "tbl_hr_supports";
    $data["module"]           = ["https://testhr.technos.app/performances","Performances", "Appraisals"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "WRN";
    $data["excel_output"]     = [true,"appraisals.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Appraisal"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
    $search                                     = str_replace('_', ' ', $this->input->get('all'));
    $data["default_row"]                        = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
    $page = $this->input->get('page');
    $row  = $this->input->get('row');
    $tab  = $this->input->get('tab');
    if($page == null){ $page = 1; }
    if($row == null){ $row = $filter_row[0]; }
    if($tab == null){ $tab = "All"; }
    $offset = $row * ($page - 1);
    if($this->input->get('all') == null){
      $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table,$offset,$row,$tab,$view_type);
      $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table,$tab,$view_type);
    }else{
      $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($search,$row,$offset,$view_type); 
      $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table,$tab,$view_type);
    }
    $i=0;
    foreach($c_data_tab as $c_data_tab_row){
      $c_data_tab[$i][3]                       = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                        = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_01', $data);
    
  }
  function kpis(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'performances';
    $data["page_name"]        = $page_name    = 'supports';
    $data["model_name"]       = $model        = "main_table_01_model"; 
    $data["table_name"]       = $table        = "tbl_hr_supports";
    $data["module"]           = ["https://testhr.technos.app/performances","Performances", "KPIs"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "WRN";
    $data["excel_output"]     = [true,"KPIs.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add KPI"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
    $search                                         = str_replace('_', ' ', $this->input->get('all'));
    $data["default_row"]                            = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]                       = $this->$model->get_empl_name();
    $page = $this->input->get('page');
    $row  = $this->input->get('row');
    $tab  = $this->input->get('tab');
    if($page == null){ $page = 1; }
    if($row == null){ $row = $filter_row[0]; }
    if($tab == null){ $tab = "All"; }
    $offset = $row * ($page - 1);
    if($this->input->get('all') == null){
      $data["C_DATA_TABLE"]                         = $this->$model->get_data_list($table,$offset,$row,$tab,$view_type);
      $data["C_DATA_COUNT"]                         = $this->$model->get_data_count($table,$tab,$view_type);
    }else{
      $data["C_DATA_TABLE"]                         = $this->$model->get_specific_data($search,$row,$offset,$view_type); 
      $data["C_DATA_COUNT"]                         = $this->$model->get_data_count($table,$tab,$view_type);
    }
    $i=0;
    foreach($c_data_tab as $c_data_tab_row){
      $c_data_tab[$i][3]                            = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                             = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_01', $data);
    
  }
  function goals(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'performances';
    $data["page_name"]        = $page_name    = 'supports';
    $data["model_name"]       = $model        = "main_table_01_model"; 
    $data["table_name"]       = $table        = "tbl_hr_supports";
    $data["module"]           = ["https://testhr.technos.app/performances","Performances", "Goals"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "WRN";
    $data["excel_output"]     = [true,"goals.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Goal"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
    $search                                       = str_replace('_', ' ', $this->input->get('all'));
    $data["default_row"]                          = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]                     = $this->$model->get_empl_name();
    $page                                         = $this->input->get('page');
    $row                                          = $this->input->get('row');
    $tab                                          = $this->input->get('tab');
    if($page == null){ $page = 1; }
    if($row == null){ $row = $filter_row[0]; }
    if($tab == null){ $tab = "All"; }
    $offset = $row * ($page - 1);
    if($this->input->get('all') == null){
      $data["C_DATA_TABLE"]                       = $this->$model->get_data_list($table,$offset,$row,$tab,$view_type);
      $data["C_DATA_COUNT"]                       = $this->$model->get_data_count($table,$tab,$view_type);
    }else{
      $data["C_DATA_TABLE"]                       = $this->$model->get_specific_data($search,$row,$offset,$view_type); 
      $data["C_DATA_COUNT"]                       = $this->$model->get_data_count($table,$tab,$view_type);
    }
    $i=0;
    foreach($c_data_tab as $c_data_tab_row){
      $c_data_tab[$i][3]                          = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                           = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_01', $data);
    
  }
  function review_templates(){
  }
  //-------------------------------------------------------- CRUD FUNCTIONS starts
  function get_data_all_list(){
    $model                                = $this->input->post('model_name');
    $table                                = $this->input->post('table_name');
    $modal_id                             = $this->input->post('modal_id');
    $data                                 = $this->$model->get_data_row($table,$modal_id);
    echo (json_encode($data));
  }
  function show_data(){
    $data["model_name"]                   = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"]             = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_show', $data);
    
  }
  function edit_data(){
    $data["model_name"]                   = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"]             = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_edit', $data);
    
  }
  function add_data(){
    $data["model_name"]                   = $model  = "main_table_01_model";
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_add', $data);
    
  }
  function edit_row(){
    $edit_user                            = $this->session->userdata('SESS_USER_ID');
    $input_data                           = $this->input->get();
    $set_array                            = array();
    foreach($input_data as $key => $value){
      if($key == "id"){
        $id = $value;
      }
      else if($key == "table"){
        $table                            = $value;
      }
      else if($key == "module"){
        $module_name                      = $value;
      }
      else if($key == "page"){
        $page_name                        = $value;
      }
      else{
        $set_array[$key]                  = $value;
      }
    }
    $set_array['edit_user']               = $edit_user;
    $this->main_table_01_model->edit_table_row($table,$id,$set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function add_row(){
    $edit_user                            = $this->session->userdata('SESS_USER_ID');
    $input_data                           = $this->input->get();
    $set_array                            = array();
    foreach($input_data as $key => $value){
      if($key == "table"){
        $table                            = $value;
      }
      else if($key == "module"){
        $module_name                      = $value;
      }
      else if($key == "page"){
        $page_name                        = $value;
      }
      else{
        $set_array[$key]                  = $value;
      }
    }
    $set_array['edit_user']               = $edit_user;
    $this->main_table_01_model->add_table_row($table, $set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function delete_row(){
    $edit_user                          = $this->session->userdata('SESS_USER_ID');
    $id                                 = $this->input->get('delete_id');
    $table                              = $this->input->get('table');
    $module_name                        = $this->input->get('module');
    $page_name                          = $this->input->get('page');
    $this->main_table_01_model->delete_table_row($id,$table,$edit_user);
    $this->session->set_userdata('delete', 'Deleted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function edit_bulk_status(){
    $edit_user                          = $this->session->userdata('SESS_USER_ID');
    $status                             = $this->input->post('modal_title');
    $ids                                = $this->input->post('list_mark_ids');
    $ids_int                            = array_map('intval', explode(',', $ids));
    $module_name                        = $this->input->get('module');
    $page_name                          = $this->input->get('page_name');
    $table                              = $this->input->get('table');
    $page                               = $this->input->get('page');
    $row_url                            = '&row=';
    $row                                = $this->input->get('row');
    $tab                                = $this->input->get('tab');
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
      if($module["value"]== $access){
          $modules[]=$module;
      }
    }
  }
  return $modules;
}