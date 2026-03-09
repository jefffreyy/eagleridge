<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class companies extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('templates/main_table_01_model');
    $this->load->model('templates/main_table_02_model');
    $this->load->model('modules/employees_model');
    $this->load->model('modules/companies_model');
    if ($this->session->userdata('SESS_USER_ID') == '') {
      redirect('login/session_expired');
    }

    $maintenance = $this->login_model->GET_MAINTENANCE();
    $isAdmin = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }
  function index()
  {
    $data["Modules"] =  array(
      array("title" => "About the Company",    "value" => "Company-About the Company", "icon" => "fa-duotone fa-buildings",             "url" => "companies/about_the_company",    "access" => "Company" ,"id"=>"about_the_company"),
      array("title" => "Announcements",        "value" => "Company Announcements",     "icon" => "fa-duotone fa-bullhorn",              "url" => "companies/announcements",        "access" => "Company" ,"id"=>"announcements"),
      array("title" => "Policies",             "value" => "Company Policies",          "icon" => "fa-duotone fa-scale-balanced",        "url" => "companies/policies",             "access" => "Company" ,"id"=>"policies"),
      array("title" => "Organizational Chart", "value" => "Organizational Chart",      "icon" => "fa-duotone fa-sitemap",               "url" => "companies/organizational_chart", "access" => "Company" ,"id"=>"organizational_chart"),
      array("title" => "Holidays",             "value" => "Company Holidays",          "icon" => "fa-duotone fa-person-hiking",         "url" => "companies/holidays",             "access" => "Company" ,"id"=>"holidays"),
      array("title" => "Knowledge Base",       "value" => "Company Knowledge Base",    "icon" => "fa-duotone fa-head-side-brain",       "url" => "companies/knowledges_bases",     "access" => "Company" ,"id"=>"knowlegde_base"),
    );
    $data["title_page"]                                = "Company Module";
    $user_access_id                                    = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE']                     = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
    $array_page                                        = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
    $data['Modules']                                   = filter_array($data["Modules"], $array_page);
    $this->load->view('templates/header');
    $this->load->view('templates/main_nav', $data);
    
  }
  function about_the_company()
  {
    $data['DISP_ALL_DATA']                             = $this->companies_model->MOD_DISP_ALL_REQUEST();
    $data['DISP_ROW_COUNT']                            = $this->companies_model->MOD_DISP_ALL_DATA_COUNT();
    $this->load->view('templates/header');
    $this->load->view('modules/companies/about_us_views', $data);
    
  }
  function setup_organization(){
      if (!isset($_GET["branch"]))      { $param_branch   = "all"; }  else{$param_branch    = $_GET["branch"];}
        if (!isset($_GET["dept"]))      { $param_dept     = "all"; }  else{$param_dept      = $_GET["dept"];}
        if (!isset($_GET["division"]))  { $param_division = "all"; }  else{$param_division  = $_GET["division"];}
        if (!isset($_GET["section"]))   { $param_section  = "all"; }  else{$param_section   = $_GET["section"];}
        if (!isset($_GET["group"]))     { $param_group    = "all"; }  else{$param_group     = $_GET["group"];}
        if (!isset($_GET["team"]))      { $param_team     = "all"; }  else{$param_team      = $_GET["team"];}
        if (!isset($_GET["line"]))      { $param_line     = "all"; }  else{$param_line      = $_GET["line"];}
        if (!isset($_GET["status"]))    { $param_status   = "all"; }  else{$param_status    = $_GET["status"];}

        $data["C_ROW_DISPLAY"]                            =  [25,50,100];
        $page                                             = $this->input->get('page');
        $row                                              = $this->input->get('row');
        if ($row == null) {
        $row = 25;
        }
        if($page  == null){
        $page = 1;
        }
        $offset = $row * ($page - 1);

        $data['DISP_EMP_LIST']                  = $empl_list = $this->companies_model->GET_FILTERED_EMPLOYEELIST($offset,$row,$param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
        $data['ALL_EMPLOYEES']                  =$this->companies_model->GET_ALL_EMPLOYEES();
        $data['DISP_YEARS']        		          = $year_list = $this->employees_model->GET_YEARS();
        // $data['C_DATA_COUNT']                   = $this->employees_model->GET_COUNT_EMPLOYEELIST();
        $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
        (!isset($_GET["year"])) ? $year         = $year_list[0]->id : $year = $_GET["year"];
     
        $data['YEAR_INITIAL']                   = $year;
        $data["DISP_ALLOWANCE"]		              = $this->employees_model->GET_ALLOWANCE_TAX_DATA($year);

        $data['DISP_DISTINCT_DEPARTMENT']       = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
        $data['DISP_DISTINCT_DIVISION']         = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
        $data['DISP_DISTINCT_SECTION']          = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
        $data['DISP_DISTINCT_BRANCH']           = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
        $data['DISP_DISTINCT_GROUP']            = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
        $data['DISP_DISTINCT_TEAM']             = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
        $data['DISP_DISTINCT_LINE']             = $this->employees_model->MOD_DISP_DISTINCT_LINE();   
    
        $data['DISP_VIEW_DEPARTMENT']           = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
        $data['DISP_VIEW_DIVISION']             = $this->employees_model->GET_SYSTEM_SETTING("com_division");
        $data['DISP_VIEW_SECTION']              = $this->employees_model->GET_SYSTEM_SETTING("com_section");
        $data['DISP_VIEW_BRANCH']               = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
        $data['DISP_VIEW_GROUP']                = $this->employees_model->GET_SYSTEM_SETTING("com_group");
        $data['DISP_VIEW_TEAM']                 = $this->employees_model->GET_SYSTEM_SETTING("com_team");
        $data['DISP_VIEW_LINE']                 = $this->employees_model->GET_SYSTEM_SETTING("com_line");
    $this->load->view('templates/header');
    $this->load->view('modules/companies/setup_organization_views',$data);
    
  }
    function update_organization(){
        $ids                                    = explode(",", $this->input->post('employee_ids'));
        $reporting_to                           = $this->input->post('reporting_to');
        $res                                    = $this->companies_model->UPDATE_ORGANIZATION($ids,$reporting_to);
        redirect('companies/setup_organization');
    }
  function edit_about()
  {
    $data['DISP_ALL_DATA']                      = $this->companies_model->MOD_DISP_ALL_REQUEST();
    $this->load->view('templates/header');
    $this->load->view('modules/companies/edit_about_us_views', $data);
    
  }

  function edit_about_us_data()
  {
    $about            = $this->input->post('about');
    $mission          = $this->input->post('mission');
    $vision           = $this->input->post('vision');

    $this->companies_model->EDIT_ABOUT_ALL($about, $mission, $vision);
    $this->session->set_userdata('MSG_EDIT_ABOUT_US', 'About the company updated successfully!');
    redirect('companies/about_the_company');
  }
  function announcements()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
    $data["module_name"]      = $module       = 'companies';
    $data["page_name"]        = $page_name    = 'announcements';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_announcements";
    $data["module"]           = [base_url() . $module, "Companies", "Announcements"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "ANN";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "announcements.xlsx"];                                                       // Enable, File Name
    // $data["add_button"]       = [true, "Add Announcements"]; 
    $data["add_button"]       = [true, false];                                                                // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab               = array(
      array("Active",   "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
      array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")    //visible,id,icon,Button Name,column,status
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("title", "Title", "text-row", "0", 1, 20, 1, 1, 1, 1, 1, 1),
        array("description", "Description", "text-area", "0", 1, 35, 1, 1, 1, 1, 1, 1),
        array("attachment", "Attachment", "attachment", "0", 0, 0, 1, 1, 1, 1, 0, 1),
        array("status", "Status", "fixed-sel-direct", "Active; Inactive", 1, 15, 1, 1, 1, 1, 1, 1),


      );
    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";

    //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
    $search                             = str_replace('_', ' ', $this->input->get('all')?? "");
    $data["default_row"]                = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]           = $this->$model->GET_EMPL_NAME();
    $data["C_ARRAY_1"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
    $data["C_ARRAY_2"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
    $data["C_ARRAY_3"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
    $data["C_ARRAY_4"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
    $data["C_ARRAY_5"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

    $page                               = $this->input->get('page');
    $row                                = $this->input->get('row');
    $tab                                = $this->input->get('tab');
    $tab_filter                         = $this->input->get('tab_filter');

    if ($row == null) {
      $row = $filter_row[0];
    }
    if ($tab == null) {
      $tab = $c_data_tab[0][0];
    }
    if ($tab_filter == null) {
      $tab_filter = $c_data_tab[0][1];
    }

    $offset = $row * ($page - 1);
    $data["C_TAB_SELECT"] = $tab;
    if ($this->input->get('all') == null) {
      $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($tab,$tab_filter, $table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_data($tab,$tab_filter, $table, $search, $row, $offset, $view_type));
      // $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                   = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_views', $data);
    
  }
  function policies()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
    $data["module_name"]      = $module       = 'companies';
    $data["page_name"]        = $page_name    = 'policies';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_policies";
    $data["module"]           = [base_url() . $module, "Companies", "Policies"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "POL";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "policies.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, false];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab               = array(
      array("Active",   "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),    //visible,id,icon,Button Name,column,status
      array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")    //visible,id,icon,Button Name,column,status
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("employee_id", "Employee", "user", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("title", "Title", "text-row", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("description", "Description", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("feedback", "Feedback", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("attachment", "Attachment", "attachment", "0", 0, 0, 1, 1, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Active; Inactive", 1, 15, 1, 1, 1, 1, 1, 1),



      );
    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";

    //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
    $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]           = $this->$model->GET_EMPL_NAME();
    $data["C_ARRAY_1"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
    $data["C_ARRAY_2"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
    $data["C_ARRAY_3"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
    $data["C_ARRAY_4"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
    $data["C_ARRAY_5"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

    $page                               = $this->input->get('page');
    $row                                = $this->input->get('row');
    $tab                                = $this->input->get('tab');
    $tab_filter                         = $this->input->get('tab_filter');

    if ($row == null) {
      $row = $filter_row[0];
    }
    if ($tab == null) {
      $tab = $c_data_tab[0][0];
    }
    if ($tab_filter == null) {
      $tab_filter = $c_data_tab[0][1];
    }

    $offset = $row * ($page - 1);
    $data["C_TAB_SELECT"] = $tab;
    if ($this->input->get('all') == null) {
      $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                   = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_views', $data);
    
  }
  function organizational_chart()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/companies/organizational_chart_views');
    
  }
  function knowledges_bases()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
    $data["module_name"]      = $module       = 'companies';
    $data["page_name"]        = $page_name    = 'knowledges_bases';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_employee_allowanceassign";
    $data["module"]           = [base_url() . $module, "Company", "Knowledges Bases"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "ALA";
    $data["excel_output"]     = [true, "knowledges_bases.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add Knowledges Bases"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab               = array(
      array("Active",   "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
      array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")    //visible,id,icon,Button Name,column,status
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
        array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
        array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
        array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
        array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
        array("username", "text", 256, 1, 1, 1, 20, "Employee Name", "user", 1, "0"),
        array("name", "text", 256, 1, 1, 1, 15, "Allowance", "array1", 1, "0"),
        array("values", "text", 256, 1, 1, 1, 15, "Amount", "none", 1, "0"),
        array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")


      );
    //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
    $search                             = str_replace('_', ' ', $this->input->get('all'));
    $data["default_row"]                = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]           = $this->$model->get_empl_name();
    $data["C_ARRAY_1"]                  = $this->$model->get_allowance_name();
    $data["C_ARRAY_2"]                  = [];
    $page                               = $this->input->get('page');
    $row                                = $this->input->get('row');
    $tab                                = $this->input->get('tab');
    $tab_filter                         = $this->input->get('tab_filter');

    if ($row == null) {
      $row = $filter_row[0];
    }
    if ($tab == null) {
      $tab = $c_data_tab[0][0];
    }
    if ($tab_filter == null) {
      $tab_filter = $c_data_tab[0][1];
    }

    $offset = $row * ($page - 1);
    $data["C_TAB_SELECT"] = $tab;
    if ($this->input->get('all') == null) {
      $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                   = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_views', $data);
    
  }
  function holidays()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'employee_id', $user]; //all or user
    $data["module_name"]      = $module       = 'companies';
    $data["page_name"]        = $page_name    = 'holidays';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_std_holidays";
    $data["module"]           = [base_url() . $module, "Companies", "Holidays"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "HOL";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [false, "holidays.xlsx"];                                                       // Enable, File Name
    // $data["add_button"]       = [true, "Add Holiday"];    
    $data["add_button"]       = [true, false];                                                               // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["", "", "", ""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab               = array(
      array(2023, "year", 2023, 0),
      array(2022, "year", 2022, 0),
      array(2021, "year", 2021, 0)
    );
    $data["C_BULK_BUTTON"]    = array();
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 0, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 0, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("col_holi_date", "Date", "date", "0", 1, 20, 1, 1, 1, 1, 1, 1),
        array("name", "Name", "text-row", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("col_holi_type", "Type", "fixed-sel-direct", "Regular Holiday;Special Holiday", 1, 15, 1, 1, 1, 1, 1, 1),
        array("year", "Year", "fixed-sel-direct", "2023;2022;2021", 1, 15, 1, 1, 1, 1, 1, 1),

      );

    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";

    //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
    $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]           = $this->$model->GET_EMPL_NAME();
    $data["C_ARRAY_1"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
    $data["C_ARRAY_2"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
    $data["C_ARRAY_3"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
    $data["C_ARRAY_4"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
    $data["C_ARRAY_5"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

    $page                               = $this->input->get('page');
    $row                                = $this->input->get('row');
    $tab                                = $this->input->get('tab');
    $tab_filter                         = $this->input->get('tab_filter');

    if ($row == null) {
      $row = $filter_row[0];
    }
    if ($tab == null) {
      $tab = $c_data_tab[0][0];
    }
    if ($tab_filter == null) {
      $tab_filter = $c_data_tab[0][1];
    }

    $offset = $row * ($page - 1);
    $data["C_TAB_SELECT"] = $tab;
    if ($this->input->get('all') == null) {
      $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($tab,$tab_filter, $table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_data($tab,$tab_filter, $table, $search, $row, $offset, $view_type));
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                   = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_views', $data);
    
  }
  function get_organizational_chart()
  {
    $empl_name                            = $this->companies_model->GET_POSITION();
    $res                                  = $this->companies_model->GET_ORGANIZATION_CHART();
    foreach ($res as &$res_row) {
      foreach ($empl_name as &$empl_name_row) {
        if ($res_row["position"] == $empl_name_row->id) {
          $res_row["position"]            = $empl_name_row->name;
        }
        if ($res_row["superior_position"] == $empl_name_row->id) {
          $res_row["superior_position"]   = $empl_name_row->name;
        }
      }
    }
    echo json_encode($res);
  }
  //-------------------------------------------------------- CRUD FUNCTIONS ends
}
function filter_array($user_modules, $user_access)
{
  $modules = array();
  foreach ($user_modules as $module) {
    foreach ($user_access as $access) {
      if ($module["value"] == $access) {
        $modules[] = $module;
      }
    }
  }
  return $modules;
}
