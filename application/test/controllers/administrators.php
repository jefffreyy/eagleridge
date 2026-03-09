<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class administrators extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('templates/main_nav_model');
        $this->load->model('templates/main_table_01_model');
        $this->load->model('modules/administrators_model');

        
        if ($this->session->userdata('SESS_USER_ID') == '') {
            redirect('login/session_expired');
          }
      
          $maintenance      = $this->login_model->GET_MAINTENANCE();
          $isAdmin          = $this->session->userdata('SESS_ADMIN');
          if ($maintenance == '1' && $isAdmin != 1) {
            redirect('login/maintenance');
          }
    }
    function index()
    {
        $data["Modules"]    =  array(
            array("title" => "Access Management",           "value" => "Access Management",     "icon" => "fa-duotone fa-building-lock",                "url" => "administrators/access",               "access" => "Administrator" ,"id"=>"access_management"),
            array("title" => "Home Settings",               "value" => "Home Settings",         "icon" => "fa-duotone fa-house-user",                   "url" => "administrators/homesettings",         "access" => "Administrator" ,"id"=>"home_settings"),
            array("title" => "User Accessibility",          "value" => "User Accessibility",    "icon" => "fa-duotone fa-plane-circle-check",           "url" => "administrators/useraccess",           "access" => "Administrator" ,"id"=>"user_accessibility"),
            array("title" => "Standard Settings",           "value" => "Standard Settings",     "icon" => "fa-duotone fa-building-shield",              "url" => "administrators/taxable_allowances",   "access" => "Administrator" ,"id"=>"standard_settings"),
            array("title" => "Company Structure Settings",  "value" => "Company Structure",     "icon" => "fa-duotone fa-sitemap",                      "url" => "administrators/structuresettings",    "access" => "Administrator" ,"id"=>"company_structure_settings"),
            array("title" => "Activity Logs",               "value" => "Activity Logs(Admin)",  "icon" => "fas fa-universal-access",                    "url" => "administrators/activity_logs",        "access" => "Administrator" ,"id"=>"activity_logs"),
            array("title" => "IP Address",                  "value" => "IP Address",            "icon" => "fa-duotone fa-block-brick-fire",             "url" => "administrators/ip_address",           "access" => "Administrator" ,"id"=>"ip_address"),
            array("title" => "General Settings",            "value" => "General Settings",      "icon" => "fa-duotone fa-solar-system",                 "url" => "administrators/generalsettings",      "access" => "Administrator" ,"id"=>"general_settings"),
        );

        $data["title_page"]                    = "Administrator Module";
        $user_access_id                        = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
        $data['DISP_USER_ACCESS_PAGE']         = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
        $array_page                            = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
        $data['Modules']                       = filter_array($data["Modules"], $array_page);

        $this->load->view('templates/header');
        $this->load->view('templates/main_nav', $data);
        
        
    }
    function activity_logs(){
        $data['C_ACTIVITIES']                  = $this->administrators_model->GET_ACTIVITY_LOGS();
        $data['C_EMPLOYEES_ID']                = $this->administrators_model->GET_EMPLOYEE_IDS();
        $this->load->view('templates/header');
        $this->load->view('modules/administrator/activity_log_views',$data);
        
    }
    function access()
    {
        $search                                 = str_replace('_', ' ', $this->input->get('all') ?? "");
        $page                                   = $this->input->get('page');
        $row                                    = $this->input->get('row');
        $tab                                    = $this->input->get('tab');
        
        $is_active=0;
        if ($row == null) {
        $row = 10;
        }
        if($page  == null){
        $page = 1;
        }
        if($tab==null){
            $tab='Active';
        }
        if($tab=='Inactive'){
            $is_active=1;
        }
        $data['TAB']=$tab;
        $data['INACTIVES']                      = $this->administrators_model->GET_INACTIVE_USER_COUNT();
        $data['ACTIVES']                        = $this->administrators_model->GET_ACTIVE_USER_COUNT();
        
        $offset = $row * ($page - 1);

        $user_count                             = $this->administrators_model->GET_USER_COUNT($is_active);
        if($this->input->get('all') == null){
            $data['C_USERS']                    = $this->administrators_model->GET_USERS($row,$offset,$is_active);
        }else{
            $data['C_USERS']                    = $this->administrators_model->GET_SEARCHED_USERS($row,$offset,$search,$is_active);
            $user_count                         = $this->administrators_model->GET_SEARCH_USER_COUNT($search,$is_active);
            $data['INACTIVES']                  = $this->administrators_model->GET_SEARCH_IS_ACTIVE_COUNT($search,1);
            $data['ACTIVES']                    = $this->administrators_model->GET_SEARCH_IS_ACTIVE_COUNT($search,0);
        }
        
        $data['C_POSITIONS']                    = $this->administrators_model->GET_POSITIONS();
        $data['C_USER_ACCESS']                  = $this->administrators_model->GET_USER_ACCESS();
        $excess                                 = $user_count%$row;
        $data['ROW']                            = $row;
        $page_count                             = $user_count/$data['ROW'];
        $data['PAGE']                           = $page;
        $data['PAGES_COUNT']                    = $excess>0? intval($page_count)+1: intval($page_count);
        $data['ALL']                            = $search;
        $data['C_DATA_COUNT']                   = $user_count;
        $this->load->view('templates/header');
        $this->load->view('modules/administrator/user_access_management_views', $data);
        
    }

    function user_activation($user_id,$is_disabled)
    {
        $this->administrators_model->SET_ACTIVATION_EMPLOYEE($user_id,$is_disabled);
        redirect("administrators/access");
    }

    function homesettings()
    {
        $data["HOME_ANNOUNCEMENT"]              = $this->administrators_model->GET_HOME_ANNOUNCEMENT();
        $data["HOME_CELEB"]                     = $this->administrators_model->GET_HOME_CELEBRATION();
        $data["HOME_DATE"]                      = $this->administrators_model->GET_HOME_DATE();
        $data["HOME_LEAVE"]                     = $this->administrators_model->GET_HOME_LEAVE();
        $data["HOME_WHOS_OUT"]                  = $this->administrators_model->GET_HOME_WHOS_OUT();
        $data["HOME_START_GUIDE"]               = $this->administrators_model->GET_HOME_START_GUIDE();
        $data["HOME_NEW_MEMBER"]                = $this->administrators_model->GET_HOME_NEW_MEMBER();

        $this->load->view('templates/header', $data);
        $this->load->view('modules/administrator/home_setting_views');
        
    }
    function structuresettings()
    {
        $data["C_COM_STRUCTURE"]                = $this->administrators_model->GET_COMP_STRUCTURE();
        $this->load->view('templates/header');
        $this->load->view('modules/administrator/company_structure_setting_views', $data);
        
    }
    function generalsettings(){
        $data['DISP_COMPANY_NAME']                          = $this->administrators_model->get_company_name();
        $data['DISP_NAVBAR_LOGO']                           = $this->administrators_model->get_navbar();
        $data['DISP_LOGIN_LOGO']                            = $this->administrators_model->get_login_logo();
        $data['DISP_HEADER_LOGO']                           = $this->administrators_model->get_header();
        $data['DISP_HEADER_CONTENT']                        = $this->administrators_model->get_header_content();

        $this->load->view('templates/header');
        $this->load->view('modules/administrator/general_setting_views', $data);
        

    }
    function useraccess()
    {
        $data["USER_ACCESS"]                                = $this->administrators_model->GET_ALL_USER_ACCESS();
        $data["MODULES"]                                    = $this->administrators_model->GET_MODULE_ACCESS();

        $this->load->view('templates/header');
        $this->load->view('modules/administrator/user_access_views', $data);
        
    }
    function skill_assign()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type           = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module              = 'administrators';
        $data["page_name"]        = $page_name           = 'skill_assign';
        $data["model_name"]       = $model               = "main_table_02_model";
        $data["table_name"]       = $table               = "tbl_employee_skillassign";
        $data["module"]           = [base_url() . $module, "Administrators", "Skill Assignment"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "DDA";
        $data["excel_output"]     = [true, "skill_assign.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Assignment"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),     //visible,id,icon,Button Name,column,status
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
                array("name", "text", 256, 1, 1, 1, 15, "Skill", "array1", 1, "0"),
                array("values", "text", 256, 1, 1, 1, 15, "Level", "array2", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                         = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                            = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                       = $this->$model->get_empl_name();
        $data["C_ARRAY_1"]                              = $this->$model->get_skill_name();
        $data["C_ARRAY_2"]                              = $this->$model->get_skill_level();
        $page                                           = $this->input->get('page');
        $row                                            = $this->input->get('row');
        $tab                                            = $this->input->get('tab');
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                      = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                      = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                      = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                      = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                         = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                            = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_02_views', $data);
        
    }
    function adjustments()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type           = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module              = 'administrators';
        $data["page_name"]        = $page_name           = 'adjustments';
        $data["model_name"]       = $model               = "main_table_01_model";
        $data["table_name"]       = $table               = "tbl_std_adjustments";
        $data["module"]           = [base_url() . $module, "Adjustments", "Adjustments"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "ADJ";
        $data["excel_output"]     = [true, "adjustments.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Adjustments"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")    //visible,id,icon,Button Name,column,status
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date",   "datetime-local", 0, 0, 0, 0, 0,  "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                   = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                   = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                   = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                   = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function allowances()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type          = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module             = 'administrators';
        $data["page_name"]        = $page_name          = 'allowances';
        $data["model_name"]       = $model              = "main_table_01_model";
        $data["table_name"]       = $table              = "tbl_std_allowances";
        $data["module"]           = [base_url() . $module, "Administrators", "Allowances"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "ALL";
        $data["excel_output"]     = [true, "allowances.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Allowance"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
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
                array("name", "text", 256, 1, 1, 1, 35, "Title", "none", 1, "0"),
                array("type", "text", 256, 1, 1, 1, 25, "Type", "dropdown", 1, "Fixed;Attendance"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function branches()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'branches';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_branches";
        $data["module"]           = [base_url() . $module, "Administrators", "Branches"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "BRC";
        $data["excel_output"]     = [true, "branches.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Branch"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
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
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                   = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                   = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                   = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                   = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function divisions()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type          = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module             = 'administrators';
        $data["page_name"]        = $page_name          = 'divisions';
        $data["model_name"]       = $model              = "main_table_01_model";
        $data["table_name"]       = $table              = "tbl_std_divisions";
        $data["module"]           = [base_url() . $module, "Administrators", "Divisions"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "DIV";
        $data["excel_output"]     = [true, "divisions.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Division"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
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
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function deductions()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'deductions';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_deductions";
        $data["module"]           = [base_url() . $module, "Administrators", "Deductions"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "DDL";
        $data["excel_output"]     = [true, "deductions.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Deduction"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("type", "text", 256, 1, 1, 1, 25, "Type", "dropdown", 1, "Fixed;Attendance"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }

    function taxable_deductions()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'taxable_deductions';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_deductions_tax";
        $data["module"]           = [base_url() . $module, "Administrators", "Taxable Deductions"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "TDE";
        $data["excel_output"]     = [true, "taxable_deductions.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Taxable Deductions"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("type", "text", 256, 1, 1, 1, 25, "Type", "dropdown", 1, "Fixed;Attendance"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
            // $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }

    function non_taxable_deductions()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'non_taxable_deductions';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_deductions_nontax";
        $data["module"]           = [base_url() . $module, "Administrators", "Non Taxable Deductions"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "NDE";
        $data["excel_output"]     = [true, "non_taxable_deductions.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Non Taxable Deductions"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
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
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("type", "text", 256, 1, 1, 1, 25, "Type", "dropdown", 1, "Fixed;Attendance"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                         = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                            = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                       = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                        = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                           = $this->input->get('page');
        $row                                            = $this->input->get('row');
        $tab                                            = $this->input->get('tab');
        $tab_filter                                     = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                       = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                       = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                       = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                       = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
            // $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                          = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                             = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }

    function positions()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'positions';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_positions";
        $data["module"]           = [base_url() . $module, "Administrators", "Positions"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "POS";
        $data["excel_output"]     = [true, "positions.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Position"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
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
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page = $this->input->get('page');
        $row  = $this->input->get('row');
        $tab  = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function employment_types()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'employment_types';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_employeetypes";
        $data["module"]           = [base_url() . $module, "Administrators", "Employment Types"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "ETY";
        $data["excel_output"]     = [true, "employment_types.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Employment Type"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
                $offset = $row * ($page - 1);
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
            // $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function skill_levels()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'skill_levels';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_skilllevels";
        $data["module"]           = [base_url() . $module, "Administrators", "Skill Levels"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "SKL";
        $data["excel_output"]     = [true, "skill_levels.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Skill Level"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
            // $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function genders()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'genders';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_genders";
        $data["module"]           = [base_url() . $module, "Administrators", "Genders"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "GND";
        $data["excel_output"]     = [true, "genders.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Gender"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab             = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                   = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                   = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                   = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                   = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
            // $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function nationalities()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'nationalities';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_nationalities";
        $data["module"]           = [base_url() . $module, "Administrators", "Nationalities"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "NAT";
        $data["excel_output"]     = [true, "nationalities.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Nationality"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
            // $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function shirt_sizes()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'shirt_sizes';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_shirtsizes";
        $data["module"]           = [base_url() . $module, "Administrators", "Shirt Sizes"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "SSZ";
        $data["excel_output"]     = [true, "shirt_sizes.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Shirt Size"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                       = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                          = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                     = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                      = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                         = $this->input->get('page');
        $row                                          = $this->input->get('row');
        $tab                                          = $this->input->get('tab');
        $tab_filter                                   = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
            // $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function marital_statuses()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'marital_statuses';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_maritalstatuses";
        $data["module"]           = [base_url() . $module, "Administrators", "Marital Statuses"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "MAR";
        $data["excel_output"]     = [true, "marital_statuses.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Marital Status"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
            // $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function skill_names()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'skill_names';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_skillnames";
        $data["module"]           = [base_url() . $module, "Administrators", "Skill Names"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "SKN";
        $data["excel_output"]     = [true, "skills.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Skill"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
            // $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function hmos()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'hmos';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_hmos";
        $data["module"]           = [base_url() . $module, "Administrators", "HMOs"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "HMO";
        $data["excel_output"]     = [true, "HMOs.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add HMO"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function departments()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'departments';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_departments";
        $data["module"]           = [base_url() . $module, "Administrators", "Departments"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "DEP";
        $data["excel_output"]     = [true, "departments.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Department"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 30, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function sections()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'sections';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_sections";
        $data["module"]           = [base_url() . $module, "Administrators", "Sections"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "SEC";
        $data["excel_output"]     = [true, "sections.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Section"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function groups()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'groups';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_groups";
        $data["module"]           = [base_url() . $module, "Administrators", "Groups"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "GRP";
        $data["excel_output"]     = [true, "groups.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Group"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page = $this->input->get('page');
        $row  = $this->input->get('row');
        $tab  = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function lines()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'lines';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_lines";
        $data["module"]           = [base_url() . $module, "Administrators", "Lines"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "LIN";
        $data["excel_output"]     = [true, "lines.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Line"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function teams()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'teams';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_teams";
        $data["module"]           = [base_url() . $module, "Administrators", "Teams"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "TMS";
        $data["excel_output"]     = [true, "teams.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Team"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function blood_types()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'blood_types';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_bloodtypes";
        $data["module"]           = [base_url() . $module, "Administrators", "Blood Type"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "BLD";
        $data["excel_output"]     = [true, "blood_types.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Type"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                         = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                            = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                       = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                        = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                           = $this->input->get('page');
        $row                                            = $this->input->get('row');
        $tab                                            = $this->input->get('tab');
        $tab_filter                                     = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }

        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function religions()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'religions';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_religions";
        $data["module"]           = [base_url() . $module, "Administrators", "Religion"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "RLG";
        $data["excel_output"]     = [true, "religions.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Religion"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }

        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function banks()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'banks';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_banks";
        $data["module"]           = [base_url() . $module, "Administrators", "Banks"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "BNK";
        $data["excel_output"]     = [true, "banks.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Bank"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function asset_categories()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'asset_categories';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_assetcategories";
        $data["module"]           = [base_url() . $module, "Administrators", "Asset Categories"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "ASC";
        $data["excel_output"]     = [true, "asset_categories.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Category"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }
    function GET_USER_ACCESS_BY_ID($id){
        // position_id
        $data                                       = $this->administrators_model->GET_USER_ACCESS_BY_ID($id);
        echo json_encode($data);
    }
    function UPDATE_USER_ACCESS(){
        $name                                       = $this->input->post('position_name');
        if($this->input->post("data")){
            
            $data                                   = implode(", ", $this->input->post("data"));
            $modules                                = implode(", ",$this->input->post("module"));
            $response                               = $this->administrators_model->UPDATE_USER_ACCESS_DATA($this->input->post('position_id'),$name,$data,$modules);
        }
        else{
            $response                               =$this->administrators_model->UPDATE_USER_ACCESS_DATA($this->input->post('position_id'),$name,"","");
        }

        $this->session->set_userdata('SESS_SUCC_MSG', 'User Accessibility List Updated Successfully!');
        redirect("administrators/useraccess");
    }

    function ADD_USER_ACCESS(){
      
        $name                                       = $this->input->post('position_name');
        $data                                       = implode(", ", $this->input->post("data"));
        $modules                                    = implode(", ",$this->input->post("module"));
  
        $this->administrators_model->ADD_USER_ACCESS($name, $data, $modules);

        $this->session->set_userdata('SESS_SUCC_MSG', 'New List Added Successfully!');
        redirect("administrators/useraccess");
    }

    function leave_types()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'leave_types';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_leavetypes";
        $data["module"]           = [base_url() . $module, "Administrators", "Leave Types"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "LVT";
        $data["excel_output"]     = [true, "leave_types.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Type"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }

    function company_locations()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'company_locations';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_companylocations";
        $data["module"]           = [base_url() . $module, "Administrators", "Company Locations"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "COL";
        $data["excel_output"]     = [true, "company_locations.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Company Location"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }


    function employee_types()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'employee_types';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_employeetypes";
        $data["module"]           = [base_url() . $module, "Administrators", "Employee Types"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "EMT";
        $data["excel_output"]     = [true, "employee_types.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Employee Types"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }


    function holidays()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'holidays';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_holidays";
        $data["module"]           = [base_url() . $module, "Administrators", "Holidays"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "HLD";
        $data["excel_output"]     = [false, "holidayss.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Holidays"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 0, 0, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("col_holi_date", "date", 256, 1, 1, 1, 20, "Date", "none", 1, "0"),
                array("name", "text", 256, 1, 1, 1, 40, "Title", "none", 1, "0"),
                array("col_holi_type", "text", 256, 1, 1, 1, 30, "Type", "status", 1, "Regular Holiday;Special Non-Working Holiday"),
                array("year", "text", 256, 1, 1, 1, 10, "Year", "status", 1, "2023;2022;2021"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }


    function knowledge_articles()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'knowledge_articles';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_knowledgearticles";
        $data["module"]           = [base_url() . $module, "Administrators", "Knowledge Article"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "KWA";
        $data["excel_output"]     = [true, "knowledge_articles.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Knowledge Article"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]      = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }


    function knowledge_categories()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'knowledge_categories';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_knowledgecategories";
        $data["module"]           = [base_url() . $module, "Administrators", "Knowledge Categories"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "KWC";
        $data["excel_output"]     = [true, "knowledge_categories.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Knowledge Categories"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }


    function pay_grade()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'pay_grade';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_paygrade";
        $data["module"]           = [base_url() . $module, "Administrators", "Pay Grade"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "PYG";
        $data["excel_output"]     = [true, "pay_grade.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Pay Grade"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }

    function stockrooms()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'stockrooms';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_stockrooms";
        $data["module"]           = [base_url() . $module, "Administrators", "Stockrooms"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "STM";
        $data["excel_output"]     = [true, "stockrooms.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Stockrooms"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]   = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }


    function termination_types()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'termination_types';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_terminationtypes";
        $data["module"]           = [base_url() . $module, "Administrators", "Termination Types"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "TMT";
        $data["excel_output"]     = [true, "termination_types.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Termination Types"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }


    function biometrics()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'biometrics';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_biometrics";
        $data["module"]           = [base_url() . $module, "Administrators", "biometrics"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "BIO";
        $data["excel_output"]     = [true, "biometrics.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add biometrics"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("terminal_sn", "text", 256, 1, 1, 1, 55, "Terminal SN", "none", 1, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Name", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }

    function taxable_allowances()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'taxable_allowances';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_allowances_tax";
        $data["module"]           = [base_url() . $module, "Administrators", "Taxable Allowances"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "TAL";
        $data["excel_output"]     = [true, "taxable_allowances.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Taxable Allowances"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab             = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active", "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 35, "Title", "none", 1, "0"),
                array("type", "text", 256, 1, 1, 1, 25, "Type", "dropdown", 1, "Fixed;Attendance"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();

        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');
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
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
            // $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }


    function non_taxable_allowances()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'non_taxable_allowances';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_allowances_nontax";
        $data["module"]           = [base_url() . $module, "Administrators", "Non Taxable Allowances"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "NAL";
        $data["excel_output"]     = [true, "non_taxable_allowances.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Non Taxable Allowances"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]   = array(
            array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),    //visible,id,icon,Button Name,column,status
            array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 35, "Title", "none", 1, "0"),
                array("type", "text", 256, 1, 1, 1, 25, "Type", "dropdown", 1, "Fixed;Attendance"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');
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
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
            // $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
        
    }

    function ip_address(){

        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["C_ROW_DISPLAY"]                      =  [25,50,100];
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');

        if ($row == null) {
        $row = 25;
        }
        if($page  == null){
        $page = 1;
        }
        $offset = $row * ($page - 1);
        $data["SYSTEM_IP_ADDRESS"]                  = $this->administrators_model->GET_SYSTEM_IP_ADDRESS();

        if($this->input->get('all') == null){
            $data["DISP_IP_ADDRESS"]                = $this->administrators_model->GET_IP_ADDRESS($offset,$row);
            $data["C_DATA_COUNT"]                   = count($this->administrators_model->get_count_ip_address($offset,$row));
        }else{
            $data["DISP_IP_ADDRESS"]                = $this->administrators_model->get_search_ip_address($search);
            $data["C_DATA_COUNT"]                   = count($this->administrators_model->get_search_ip_address($search));
        }   

        $this->load->view('templates/header');
        $this->load->view('modules/administrator/ip_address_views',$data);
        
    }
    
    function ip_address_form(){
        
        $this->load->view('templates/header');
        $this->load->view('modules/administrator/ip_address_form_views');
        
    }

    function insert_ip_address(){
        $create_date                             = date("Y-m-d H:i:s");
        $status                                  = $this->input->post('insrt_status');
        $ip_add                                  = $this->input->post('insrt_ip_add');
        $remarks                                 = $this->input->post('insrt_remarks');

        $this->administrators_model->MOD_INSERT_IP($create_date, $ip_add,$remarks, $status);
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT', 'IP Address Added Successfully!');
        redirect('administrators/ip_address');
    }
    
    function delete_id_address($id){
        $this->administrators_model->MOD_DELETE_IP_ADDRESS($id);
        $this->session->set_userdata('SESS_SUCC_MSG_DELETE', 'IP Address Deleted Successfully!');
        redirect('administrators/ip_address');
    }

    function reset_empl_password(){
        $empl_id                            = $this->input->post('empl_id');
        $reset_pass                         = $this->input->post('reset_pass');
        echo $reset_pass;
        echo $empl_id;
        // var_dump($empl_id);
        // var_dump($reset_pass);
        $res                                = $this->administrators_model->MOD_RESET_USER_PASSWORD($empl_id, $reset_pass);
        // if($res){
        //     $this->session->set_flashdata('SESS_PASS', true);
        // }else{
        //     $this->session->set_flashdata('SESS_PASS', false);
        // }
        // echo $res;=
        // redirect('administrators/access');
        // echo(json_encode($data));
    }

    function update_empl_user_access(){
        $disable                            = $this->input->post('disable');
        $user_access                        = $this->input->post('user_access');
        $remote_attendance                  = $this->input->post('remote_attendance');
        $empl_id                            = $this->input->post('empl_id');
        
        $data = $this->administrators_model->MOD_UPDT_USER_ACCESS($user_access, $remote_attendance, $disable, $empl_id);
        echo(json_encode($data));
    }

    function update_setting(){
        $id                                 = $this->input->post('id');
        $value                              = $this->input->post('check_status');
        $checked = ($value == '') ? 0 : 1;
        var_dump($checked);
        $this->administrators_model->MOD_UPDATE_STATUS($checked, $id);
        redirect("administrators/structuresettings");
    }

    function update_ip_address(){
        $setting                            = "ip_address";
        $value                              = $this->input->post('val_setting');
        $checked                            = ($value == '') ? 0 : 1;
        $this->administrators_model->MOD_UPDATE_IP_ADDRESS($checked,$setting);
        redirect("administrators/ip_address");
    }

    function update_status($id){
        $checked                            = isset($_POST["check_status"])? 1:0;
        $res                                = $this->administrators_model->MOD_UPDATE_STATUS($checked, $id);
        echo $res;
        // redirect("home_settings");
    }

    function update_general_settings(){
        $data = array(
            1   => $this->input->post('update_comp_name'),
            24  => $this->input->post('update_header_content')
        );

        $this->administrators_model->update_general_setting($data);
        $this->load->library('upload');

        $logo_inputs = array(
            'update_nav_logo' => 3 ,
            'update_login_logo' =>  2,
            'update_header_logo' => 4
        );

        // Loop through each logo input and process the upload
        foreach ($logo_inputs as $input_name => $id) {
            $logo_file                               = $_FILES[$input_name]['name'];

            if (!empty($logo_file)) {
                $rand = uniqid();
                $config['upload_path']               = './assets_system/images/';
                $config['allowed_types']             = 'gif|jpg|png|jpeg';
                $config['max_size']                  = '5000';
                $config['file_name']                 = $rand.'_'.$logo_file;
                $config['overwrite']                 = 'TRUE';
                // $this->load->library('upload', $config);
                $this->upload->initialize($config);
                
                // check if old image exist, if it exists this condition will remove old existing image
                $old_file                           = $this->administrators_model->get_old_logo($id);
                if ($old_file && file_exists('./assets_system/images/'.$old_file)) {
                    unlink('./assets_system/images/'.$old_file);
                }

                if ($this->upload->do_upload($input_name)) {
                    
                    // If the upload is successful, save the new logo to the database
                    $data_upload                    = array($input_name => $this->upload->data());
                    $upload_img                     = $data_upload[$input_name]['file_name'];
                    $this->administrators_model->update_login_logo($upload_img, $id);
                    $this->session->set_flashdata('SESS_SUCC_INSRT', 'Logos updated successfully');
                } else {
                    // If the upload fails, display an error message
                    $error_msg                      = $this->upload->display_errors();
                    $this->session->set_flashdata('error_msg', $error_msg);
                }
            }
        }

        $this->session->set_userdata('SESS_SUCC_UPDATE', ' General Settings Updated Successfully!');
        redirect('administrators/generalsettings');
    }
    
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
