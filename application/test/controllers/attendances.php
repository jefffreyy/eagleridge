<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class attendances extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('templates/main_table_01_model');
    $this->load->model('templates/main_table_02_model');
    $this->load->model('modules/attendance_model');

    if ($this->session->userdata('SESS_USER_ID') == '') {
      redirect('login/session_expired');
    }

    $maintenance                                        = $this->login_model->GET_MAINTENANCE();
    $isAdmin                                            = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }

   
  }
  function index()
  {
    echo '<script src="https://kit.fontawesome.com/v5.15.3/js/all.min.js" crossorigin="anonymous"></script>';
    
    $data["Modules"] =  array(
      array("title" => "Attendance Records",      "value" => "Attendance Records",      "icon" => "fa-duotone fa-calendar-clock",                   "url" => "attendances/attendance_records",     "access" => "Attendance",  "id" => "attendance_records"),
      array("title" => "Shift Assignment",        "value" => "Shift Assignment",        "icon" => "fa-duotone fa-chart-gantt",                      "url" => "attendances/shift_assignment",       "access" => "Attendance",  "id" => "shift_assignment"),
      // array("title" => "Daily Attendance",     "value" => "Daily Attendance",        "icon" => "fas fa-sun",            "url" => "attendances/daily_attendances",      "access" => "Attendance" ,"id"=>"daily_attendance"),
      array("title" => "Work Shifts",             "value" => "Work Shifts",             "icon" => "fa-duotone fa-moon-over-sun",                    "url" => "attendances/work_shifts",            "access" => "Attendance",  "id" => "work_shifts"),
      // array("title" => "Shift Template",       "value" => "Shift Template",          "icon" => "fas fa-clock",          "url" => "attendances/shift_templates",        "access" => "Attendance" ,"id"=>"shift_template"),
      array("title" => "Holidays",                "value" => "Attendance Holidays",     "icon" => "fa-duotone fa-person-hiking",                    "url" => "attendances/holidays",               "access" => "Attendance",  "id" => "holidays"),
      array("title" => "Overtime",                "value" => "Overtime Requests",       "icon" => "fa-duotone fa-gauge-max",                        "url" => "attendances/overtimes",              "access" => "Attendance",  "id" => "overtime"),
      array("title" => "Holiday Work",            "value" => "Holiday Work",            "icon" => "fa-duotone fa-car-building",                     "url" => "attendances/holiday_work",           "access" => "Attendance",  "id" => "holiday_work"),
      array("title" => "Time Adjustment List",    "value" => "Time Adjustment List",    "icon" => "fa-duotone fa-reply-clock",                      "url" => "attendances/time_adjustment_lists",  "access" => "Attendance",  "id" => "time_adjustment_list"),
      array("title" => "Overtime Approval Route", "value" => "Overtime Approval Route", "icon" => "fa-duotone fa-circle-exclamation-check",         "url" => "attendances/approval_routes",        "access" => "Attendance",  "id" => "overtime_approval_route"),
      array("title" => "Zkteco Attendance",       "value" => "Zkteco Attendance",       "icon" => "fa-duotone fa-fingerprint",                      "url" => "attendances/zkteco_attendance",      "access" => "Attendance",  "id" => "zkteco_attendance"),
      array("title" => "Zkteco Code",             "value" => "Zkteco Code",             "icon" => "fa-duotone fa-fingerprint",                      "url" => "attendances/zkteco_code",            "access" => "Attendance",  "id" => "zkteco_code"),
      // array("title" => "Table Record",         "value" => "Shift Assignment",        "icon" => "fas fa-clock",          "url" => "attendances/table_record",           "access" => "Attendance" ,"id"=>"table_record")
    );
    $data["title_page"]                                   = "Attendance Module";
    $user_access_id                                       = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE']                        = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
    $array_page                                           = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
    $data['Modules']                                      = filter_array($data["Modules"], $array_page);
    $this->load->view('templates/header');
    $this->load->view('templates/main_nav', $data);
  }
  function suminac_timekeep()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
    $data["module_name"]      = $module       = 'attendances';
    $data["page_name"]        = $page_name    = 'suminac_timekeep';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_attendance_suminac";
    $data["module"]           = [base_url() . $module, "Attendances", "Suminac Assignment"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "SUM";
    $data["excel_output"]     = [true, "suminac_timekeep.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add Entry  "];                                                                 // Enable, Button Name modal_add_enable   = true;
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
    $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                        = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
    $data["C_ARRAY_1"]                          = $this->$model->get_allowance_name();
    $data["C_ARRAY_2"]                          = [];
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
    $data["C_DATA_TAB"]                        = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_views', $data);
  }
  function deduction_assign()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
    $data["module_name"]      = $module       = 'employees';
    $data["page_name"]        = $page_name    = 'deduction_assign';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_employee_deductionassign";
    $data["module"]           = [base_url() . $module, "Employees", "Deduction Assignment"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "DDA";
    $data["excel_output"]     = [true, "deduction_assign.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add Assignment"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
        array("name", "text", 256, 1, 1, 1, 15, "Deduction", "array1", 1, "0"),
        array("values", "text", 256, 1, 1, 1, 15, "Amount", "none", 1, "0"),
        array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
      );
    //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
    $search                                    = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                       = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]                  = $this->$model->get_empl_name();
    $data["C_ARRAY_1"]                         = $this->$model->get_deduction_name();
    $data["C_ARRAY_2"]                         = [];
    $page                                      = $this->input->get('page');
    $row                                       = $this->input->get('row');
    $tab                                       = $this->input->get('tab');
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
    $data["C_DATA_TAB"]                        = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_views', $data);
  }
  function get_searched_employee()
  {
    $search = $this->input->post('search');
    $data = $this->attendance_model->MOD_GET_SEARCHED_DATA($search);
    echo (json_encode($data));
  }

  function attendance_lock()
  {
    $data["EMPL_ID"]                          = $user_id = $this->input->post('EMPL_ID');
    $data["PAYROLL_SCHED"]                    = $period = $this->input->post('PAYROLL_SCHED');
    if ($this->input->post('SUM_PRESENT') == "") {
      $data["SUM_PRESENT"] = 0;
    } else {
      $data["SUM_PRESENT"]                    = $this->input->post('SUM_PRESENT');
    }
    if ($this->input->post('SUM_ABSENT') == "") {
      $data["SUM_ABSENT"] = 0;
    } else {
      $data["SUM_ABSENT"]                     = $this->input->post('SUM_ABSENT');
    }
    if ($this->input->post('SUM_TARDINESS') == "") {
      $data["SUM_TARDINESS"] = 0;
    } else {
      $data["SUM_TARDINESS"]                  = $this->input->post('SUM_TARDINESS');
    }
    if ($this->input->post('SUM_UNDERTIME') == "") {
      $data["SUM_UNDERTIME"] = 0;
    } else {
      $data["SUM_UNDERTIME"]                  = $this->input->post('SUM_UNDERTIME');
    }
    if ($this->input->post('SUM_PAID_LEAVE') == "") {
      $data["SUM_PAID_LEAVE"] = 0;
    } else {
      $data["SUM_PAID_LEAVE"]                 = $this->input->post('SUM_PAID_LEAVE');
    }
    if ($this->input->post('SUM_REG_HOURS') == "") {
      $data["SUM_REG_HOURS"] = 0;
    } else {
      $data["SUM_REG_HOURS"]                  = $this->input->post('SUM_REG_HOURS');
    }
    if ($this->input->post('SUM_REG_OT') == "") {
      $data["SUM_REG_OT"] = 0;
    } else {
      $data["SUM_REG_OT"]                     = $this->input->post('SUM_REG_OT');
    }
    if ($this->input->post('SUM_REG_ND') == "") {
      $data["SUM_REG_ND"] = 0;
    } else {
      $data["SUM_REG_ND"]                     = $this->input->post('SUM_REG_ND');
    }
    if ($this->input->post('SUM_REG_NDOT') == "") {
      $data["SUM_REG_NDOT"] = 0;
    } else {
      $data["SUM_REG_NDOT"]                   = $this->input->post('SUM_REG_NDOT');
    }
    if ($this->input->post('SUM_REST_HOURS') == "") {
      $data["SUM_REST_HOURS"] = 0;
    } else {
      $data["SUM_REST_HOURS"]                 = $this->input->post('SUM_REST_HOURS');
    }
    if ($this->input->post('SUM_REST_OT') == "") {
      $data["SUM_REST_OT"] = 0;
    } else {
      $data["SUM_REST_OT"]                    = $this->input->post('SUM_REST_OT');
    }
    if ($this->input->post('SUM_REST_ND') == "") {
      $data["SUM_REST_ND"] = 0;
    } else {
      $data["SUM_REST_ND"]                    = $this->input->post('SUM_REST_ND');
    }
    if ($this->input->post('SUM_REST_NDOT') == "") {
      $data["SUM_REST_NDOT"] = 0;
    } else {
      $data["SUM_REST_NDOT"]                  = $this->input->post('SUM_REST_NDOT');
    }
    if ($this->input->post('SUM_LEG_HOURS') == "") {
      $data["SUM_LEG_HOURS"] = 0;
    } else {
      $data["SUM_LEG_HOURS"]                  = $this->input->post('SUM_LEG_HOURS');
    }
    if ($this->input->post('SUM_LEG_OT') == "") {
      $data["SUM_LEG_OT"] = 0;
    } else {
      $data["SUM_LEG_OT"]                     = $this->input->post('SUM_LEG_OT');
    }
    if ($this->input->post('SUM_LEG_ND') == "") {
      $data["SUM_LEG_ND"] = 0;
    } else {
      $data["SUM_LEG_ND"]                     = $this->input->post('SUM_LEG_ND');
    }
    if ($this->input->post('SUM_LEG_NDOT') == "") {
      $data["SUM_LEG_NDOT"] = 0;
    } else {
      $data["SUM_LEG_NDOT"]                   = $this->input->post('SUM_LEG_NDOT');
    }
    if ($this->input->post('SUM_LEGREST_HOURS') == "") {
      $data["SUM_LEGREST_HOURS"] = 0;
    } else {
      $data["SUM_LEGREST_HOURS"]              = $this->input->post('SUM_LEGREST_HOURS');
    }
    if ($this->input->post('SUM_LEGREST_OT') == "") {
      $data["SUM_LEGREST_OT"] = 0;
    } else {
      $data["SUM_LEGREST_OT"]                 = $this->input->post('SUM_LEGREST_OT');
    }
    if ($this->input->post('SUM_LEGREST_ND') == "") {
      $data["SUM_LEGREST_ND"] = 0;
    } else {
      $data["SUM_LEGREST_ND"]                 = $this->input->post('SUM_LEGREST_ND');
    }
    if ($this->input->post('SUM_LEGREST_NDOT') == "") {
      $data["SUM_LEGREST_NDOT"] = 0;
    } else {
      $data["SUM_LEGREST_NDOT"]               = $this->input->post('SUM_LEGREST_NDOT');
    }
    if ($this->input->post('SUM_SPE_HOURS') == "") {
      $data["SUM_SPE_HOURS"] = 0;
    } else {
      $data["SUM_SPE_HOURS"]                  = $this->input->post('SUM_SPE_HOURS');
    }
    if ($this->input->post('SUM_SPE_OT') == "") {
      $data["SUM_SPE_OT"] = 0;
    } else {
      $data["SUM_SPE_OT"]                     = $this->input->post('SUM_SPE_OT');
    }
    if ($this->input->post('SUM_SPE_ND') == "") {
      $data["SUM_SPE_ND"] = 0;
    } else {
      $data["SUM_SPE_ND"]                     = $this->input->post('SUM_SPE_ND');
    }
    if ($this->input->post('SUM_SPE_NDOT') == "") {
      $data["SUM_SPE_NDOT"] = 0;
    } else {
      $data["SUM_SPE_NDOT"]                   = $this->input->post('SUM_SPE_NDOT');
    }
    if ($this->input->post('SUM_SPEREST_HOURS') == "") {
      $data["SUM_SPEREST_HOURS"] = 0;
    } else {
      $data["SUM_SPEREST_HOURS"]              = $this->input->post('SUM_SPEREST_HOURS');
    }
    if ($this->input->post('SUM_SPEREST_OT') == "") {
      $data["SUM_SPEREST_OT"] = 0;
    } else {
      $data["SUM_SPEREST_OT"]                 = $this->input->post('SUM_SPEREST_OT');
    }
    if ($this->input->post('SUM_SPEREST_ND') == "") {
      $data["SUM_SPEREST_ND"] = 0;
    } else {
      $data["SUM_SPEREST_ND"]                 = $this->input->post('SUM_SPEREST_ND');
    }
    if ($this->input->post('SUM_SPEREST_NDOT') == "") {
      $data["SUM_SPEREST_NDOT"] = 0;
    } else {
      $data["SUM_SPEREST_NDOT"]               = $this->input->post('SUM_SPEREST_NDOT');
    }



    $response                                 = $this->attendance_model->IS_DUPLICATE_LOCK($user_id, $period);
    $response;
    if ($response == 0) {
      $this->attendance_model->INSERT_ATTENDANCE_LOCK($data);
    } else {
      $this->attendance_model->UPDATE_ATTENDANCE_LOCK($data);
    }





    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }

  function attendance_records()
  {
    $division                     = $this->input->get("division");
    $branch                       = $this->input->get("branch");
    $team                         = $this->input->get("team");
    $dept                         = $this->input->get("dept");
    $section                      = $this->input->get("section");
    $group                        = $this->input->get("group");
    $line                         = $this->input->get("line");
    $status                       = $this->input->get("status");
    $period                       = $this->input->get("period");
    $employee                     = $this->input->get("employee");

    if ($dept == null) {
      $dept = '';
    }
    if ($section == null) {
      $section = '';
    }
    if ($group == null) {
      $group = '';
    }
    if ($line == null) {
      $line = '';
    }
    if ($status == null) {
      $status = '';
    }

    $data['DISP_EMP_LIST']              = $employee_list = $this->attendance_model->FILTER_ATTENDANCE_RECORDS($dept, $section, $group, $division, $branch, $team);

    $data['DISP_PAYROLL_SCHED']         = $payroll_list = $this->attendance_model->MOD_DISP_PAY_SCHED();

    $data['DISP_DISTINCT_BRANCH']       = $this->attendance_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DIVISION']     = $this->attendance_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_TEAM']         = $this->attendance_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_DEPARTMENT']   = $this->attendance_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_SECTION']      = $this->attendance_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_Group']                 = $this->attendance_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_Line']                  = $this->attendance_model->MOD_DISP_DISTINCT_LINE();
    $data['DISP_INOUT_TYPE']            = $inout_type  = $this->attendance_model->GET_IN_OUT_TYPE();
    $res_data                           = $this->get_employee_data();
    $data['DISP_CUTOFF']                = $res_data['cutoff_data'];

    if (!empty($employee_list)) {
      if ($employee == null || $employee == 'undefined') {
        $employee_id                    = $employee_list[0]->id;
      } else {
        $employee_id                    = $employee;
      }
    }
    if (empty($employee_list)) {
      $employee_id = '';
    }


    if ($period == null) {
      $period = $payroll_list[0]->id;
    }

    $data['DISP_READY_PAYSLIP']         = $this->attendance_model->GET_READY_PAYSLIP($period);
    $data['DISP_NOT_READY_PAYSLIP']     = $this->attendance_model->GET_NOT_READY_PAYSLIP($period);

    $date_period                        = $this->attendance_model->GET_PERIOD_DATA($period);
    $date_from                          = $date_period['date_from'];
    $date_to                            = $date_period['date_to'];

    if ($employee_id) {

      $response                           = $this->attendance_model->IS_DUPLICATE_LOCK($employee_id, $period);
      if ($response == 0) {
        $data['DISP_LOCK_DATA']                      = 0;
      } else {
        $data['DISP_LOCK_DATA']                      = 1;
      }

      $response                           = $this->attendance_model->IS_PAYSLIP($employee_id, $period);
      if ($response == 0) {
        $data['DISP_PAYSLIP_DATA']                   = 0;
      } else {
        $data['DISP_PAYSLIP_DATA']                   = 1;
      }

      $response                           = $this->attendance_model->IS_LEAVE($employee_id, $date_from, $date_to);
      if ($response == 0) {
        $data['DISP_LEAVE_DATA']                     = 0;
      } else {
        $data['DISP_LEAVE_DATA']                     = 1;
      }

      $response                           = $this->attendance_model->IS_TIME($employee_id, $date_from, $date_to);
      if ($response == 0) {
        $data['DISP_TIME_DATA']                      = 0;
      } else {
        $data['DISP_TIME_DATA']                      = 1;
      }

      $response                           = $this->attendance_model->IS_OVERTIME($employee_id, $date_from, $date_to);
      if ($response == 0) {
        $data['DISP_OVERTIME_DATA']                  = 0;
      } else {
        $data['DISP_OVERTIME_DATA']                  = 1;
      }

      $response                           = $this->attendance_model->IS_HOLIDAY($employee_id, $date_from, $date_to);
      if ($response == 0) {
        $data['DISP_HOLIDAY_DATA']                   = 0;
      } else {
        $data['DISP_HOLIDAY_DATA']                   = 1;
      }
    }

    $time_data                          = $this->attendance_model->GET_ATTENDANCE_RECORD($employee_id);
    // $zkteco_time_data                   = $this->attendance_model->GET_ZKTECO_ATTENDANCE_RECORD($employee_id);
    $salary_type                        = $this->attendance_model->GET_SALARY_TYPE($employee_id);
    $approved_leaves                    = $this->attendance_model->GET_APPROVED_LEAVES($employee_id, $date_from, $date_to);
    $leave_typelist                     = $this->attendance_model->GET_LEAVE_NAMES();
    $approved_ot                        = $this->attendance_model->GET_APPROVED_OT($employee_id, $date_from, $date_to);

    $shift_assignment                   = $this->attendance_model->GET_SHIFT_ASSIGN_SPECIFIC($employee_id);
    $shift_data                         = $this->attendance_model->GET_WORK_SHIFT_DATA();
    $data['INI_EMPL']                   = $employee_id;
    $data['INI_PAYROLL']                = $period;
    $data['SALARY_TYPE']                = $salary_type;

    $begin                              = new DateTime($date_from);
    $end                                = new DateTime($date_to);
    $end                                = $end->modify('+1 day');
    $holidays                           = $this->attendance_model->GET_HOLIDAY();
    $interval                           = new DateInterval('P1D');
    $daterange                          = new DatePeriod($begin, $interval, $end);
    $data_arr                           = array();
    $index                              = 0;

    $error_shift_assign                 = 0;

    $sum_present                        = 0;
    $sum_absent                         = 0;
    $sum_tardiness                      = 0;
    $sum_undertime                      = 0;
    $sum_slider                         = 0;

    $sum_paid_leave                     = 0;
    $sum_lwop                     = 0;
    $sum_awol                           = 0;

    $sum_reg_hours                      = 0;
    $sum_reg_regot                      = 0;
    $sum_reg_nd                         = 0;
    $sum_reg_ndot                       = 0;
    $sum_rest_hours                     = 0;
    $sum_rest_regot                     = 0;
    $sum_rest_nd                        = 0;
    $sum_rest_ndot                      = 0;
    $sum_leg_hours                      = 0;
    $sum_leg_regot                      = 0;
    $sum_leg_nd                         = 0;
    $sum_leg_ndot                       = 0;
    $sum_legrest_hours                  = 0;
    $sum_legrest_regot                  = 0;
    $sum_legrest_nd                     = 0;
    $sum_legrest_ndot                   = 0;
    $sum_spe_hours                      = 0;
    $sum_spe_regot                      = 0;
    $sum_spe_nd                         = 0;
    $sum_spe_ndot                       = 0;
    $sum_sperest_hours                  = 0;
    $sum_sperest_regot                  = 0;
    $sum_sperest_nd                     = 0;
    $sum_sperest_ndot                   = 0;

    foreach ($daterange as $date) 
    {
      $date_name                        = $date->format("M d, Y (D)");
      $date_pdf                         = $date->format("Y/m/d D");
      $shift_name                       = '-';

      $shift_regular_start              = '00:00';
      $shift_regular_end                = '00:00';
      $shift_break_start                = '00:00';
      $shift_break_end                  = '00:00';
      $shift_overtime_start             = '00:00';
      $shift_overtime_end               = '00:00';
      $shift_regular_enable             = 0;
      $shift_regular_reg        = 0;
      $shift_nd_hours        = 0;
      $shift_break_enable        = 0;
      $shift_break_hours        = 0;
      $shift_overtime_enable        = 0;
      $shift_overtime_ot        = 0;
      $shift_overtime_nd        = 0;

      $shift_pdf                        = '-';
      $shift_color                      = '#555555';
      $hol_code                         = "REGULAR";

      $zkteco_time_in                   = "00:00";
      $zkteco_time_out                  = "00:00";
      $zkteco_break_in                   = "00:00";
      $zkteco_break_out                  = "00:00";
      $remote_time_in                   = "00:00";
      $remote_time_out                  = "00:00";


      $raw_time_in                      = '00:00';
      $raw_time_out                     = '00:00';
      $raw_time_break_start             = '00:00';
      $raw_time_break_end               = '00:00';

      $raw_shift_time_regular_start     = '00:00';
      $raw_shift_time_regular_end       = '00:00';
      $raw_shift_break_time_in          = '00:00';
      $raw_shift_break_time_out         = '00:00';
      $shift_break_hours                = 0;


      $reg_hrs                          = 0;
      $lwop                          = 0;
      $awol                          = 0;

      $calculate_work_duration          = 0;
      $tardiness                        = 0;
      $undertime                        = 0;
      $work_hours                       = 0;
      $absent                           = 0;
      $remarks                          = '-';;
      $paid_leave                       = 0;
      $reg_ot                           = 0;
      $nd_ot                            = 0;
      $nd                               = 0;
      $leave_type                       = 0;
      $leave_typename                   = '-';

      $earlybreak                       = 0;
      $overbreak                       = 0;

      $zkteco_time_data                   = $this->attendance_model->GET_ZKTECO_ATTENDANCE_RECORD($employee_id);

      foreach ($shift_assignment as $shift_assignment_row) {
        if ($shift_assignment_row->date == $date->format("Y-m-d")) {
          foreach ($shift_data as $shift_data_row) {
            if ($shift_assignment_row->shift_id == $shift_data_row->id) {

              $shift_name = $shift_data_row->code;
              
              $shift_regular_enable = $shift_data_row->time_regular_enable;
              $shift_regular_start  = date("H:i", strtotime($shift_data_row->time_regular_start));
              $shift_regular_end    = date("H:i", strtotime($shift_data_row->time_regular_end));
              $shift_regular_reg    = $shift_data_row->time_regular_reg;
              $shift_nd_hours       = $shift_data_row->time_regular_nd;

              $shift_break_enable    = $shift_data_row->time_break_enable;
              $shift_break_start    = date("H:i", strtotime($shift_data_row->time_break_start));
              $shift_break_end      = date("H:i", strtotime($shift_data_row->time_break_end));
              $shift_break_hours    = $shift_data_row->time_break_hours;

              $shift_overtime_enable= $shift_data_row->time_overtime_enable;
              $shift_overtime_start = date("H:i", strtotime($shift_data_row->time_overtime_start));
              $shift_overtime_end   = date("H:i", strtotime($shift_data_row->time_overtime_end));
              $shift_overtime_ot    = $shift_data_row->time_overtime_ot;
              $shift_overtime_nd    = $shift_data_row->time_overtime_nd;
              
              // $shift_name = $shift_data_row->code . " (" . $shift_data_row->name . ")";

              if ($shift_data_row->code == "REST") {
                $shift_name           = "REST";
              }

              $shift_color                  = $shift_data_row->color;
              $raw_shift_time_regular_start = $shift_data_row->time_regular_start;
              $raw_shift_time_regular_end   = $shift_data_row->time_regular_end;
              $raw_shift_break_time_in      = $shift_data_row->time_break_start;
              $raw_shift_break_time_out     = $shift_data_row->time_break_end;
              $shift_pdf                    = $shift_data_row->code;
              break;
            }
          }
          break;
        }
      }
      foreach ($holidays as $holiday) {
        if ($holiday->col_holi_date == $date->format("Y-m-d")) {
          if ($holiday->col_holi_type == "Regular Holiday") {
            $hol_code                 = "LEGAL";
          } else {
            $hol_code                 = "SPECIAL";
          }
          break;
        }
      }

      $time_in_array    = [];
      $time_out_array   = [];
      $break_in_array   = [];
      $break_out_array  = [];

      foreach ($zkteco_time_data as $zkteco_time_data_row) {
        if (date("Y-m-d", strtotime($zkteco_time_data_row->punch_time)) == $date->format("Y-m-d")) {

          if ($zkteco_time_data_row->punch_state == 0) {
            array_push($time_in_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
          } elseif ($zkteco_time_data_row->punch_state == 4) {
            array_push($break_in_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
          } elseif ($zkteco_time_data_row->punch_state == 5) {
            array_push($break_out_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
          } else  {
            array_push($time_out_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
          }
        }
      }

      if ($time_in_array) 
      {
        $oldest_in_time            = min(array_map('strtotime', $time_in_array));
        $zkteco_time_in            = date("H:i", $oldest_in_time);
      }

      if ($time_out_array) 
      {
        $latest_time_out          = max(array_map('strtotime', $time_out_array));
        $zkteco_time_out           = date("H:i", $latest_time_out);
      }

      if ($break_in_array) 
      {
        $oldest_in_time            = min(array_map('strtotime', $break_in_array));
        $zkteco_break_in            = date("H:i", $oldest_in_time);
      }

      if ($break_out_array) 
      {
        $latest_time_out          = min(array_map('strtotime', $break_out_array));
        $zkteco_break_out           = date("H:i", $latest_time_out);
      }

      
      foreach ($time_data as $time_data_row)  
      {
        if ($time_data_row->date == $date->format("Y-m-d")) 
        {
          $remote_time_in        = date("H:i", strtotime($time_data_row->time_in));
          $remote_time_out       = date("H:i", strtotime($time_data_row->time_out));

          break;
        }
      }


      if ($zkteco_time_in != "00:00" && $remote_time_in != "00:00") 
      {
        $raw_time_in = min($remote_time_in, $zkteco_time_in);
      } 
      else if ($zkteco_time_in != "00:00" && $remote_time_in == "00:00") 
      {
        $raw_time_in = $zkteco_time_in;
      } 
      else 
      {
        $raw_time_in = $remote_time_in;
      }

      if ($zkteco_time_out != "00:00" && $remote_time_out != "00:00") 
      {
        $raw_time_out = max($remote_time_out, $zkteco_time_out);
      } 
      else if ($zkteco_time_out != "00:00" && $remote_time_out == "00:00") 
      {
        $raw_time_out = $zkteco_time_out;
      } 
      else 
      {
        $raw_time_out = $remote_time_out;
      }

      $raw_time_break_start             = $zkteco_break_in;
      $raw_time_break_end               = $zkteco_break_out;


   
      foreach ($approved_leaves as $approved_leaves_row) {
        if ($approved_leaves_row->leave_date == $date->format("Y-m-d")) {
          $paid_leave           = $approved_leaves_row->duration;
          $leave_type           = $approved_leaves_row->type;

          foreach ($leave_typelist as $leave_typelist_row) {
            if ($leave_type == $leave_typelist_row->id) {
              $leave_typename   = $leave_typelist_row->name;
            }
          }
          break;
        }
      }

      foreach ($approved_ot as $approved_ot_row) {
        if ($approved_ot_row->date_ot == $date->format("Y-m-d")) {
          if ($approved_ot_row->type == "Regular") {
            $reg_ot           = $approved_ot_row->hours;
          } else {
            $nd_ot            = $approved_ot_row->hours;
          }
          break;
        }
      }

      // Approve Leave
      if ($paid_leave != 0) {
        if ($hol_code == "REGULAR") {
          $remarks      = "Approved Leave";
          $shift_color  = "#D6ECD7";
        } else if ($hol_code == "LEGAL") {
          $remarks      = "ERR:LV on HOL";
          $paid_leave   = 0;
        } else if ($hol_code == "SPECIAL") {
          $remarks      = "ERR:LV on HOL";
          $paid_leave   = 0;
        }
      }
      // raw_shift_time_regular_start
      // raw_shift_time_regular_end
      // raw_time_in
      // raw_time_out
      // Not Leave

      //----------------    CALCULATION START
      if ($shift_name != '-' && $shift_name != 'REST') 
      {

        // $nd                       = $this->calculate_night_differential($raw_time_in, $raw_time_out, $raw_shift_time_regular_start, $raw_shift_time_regular_end);
        // $work_hours               = $this->calculate_shift_duration(0, $raw_shift_time_regular_start, $raw_shift_time_regular_end) - $shift_break_hours;
        $work_hours = $shift_regular_reg - $paid_leave;

        if($raw_time_in != "00:00" && $raw_time_out != "00:00" ){
          $tardiness  = $this->deduction_in($raw_time_in, $shift_regular_start);
          $undertime  = $this->deduction_out($raw_time_out, $shift_regular_end);

          if ($undertime >= 2 && $tardiness >= 2) { // Absent if Too much undertime
            $absent     = $work_hours;
            
            $tardiness  = 0;
            $undertime  = 0;
            $remarks = "Tardiness,Undertime>=2H,8H Absent";
          }
          if ($tardiness >= 4) {  // Absent if Too much late
            $absent     = $work_hours;
            $tardiness  = 0;
            $undertime  = 0;
            $remarks = "Late>=4H,8H Absent";
          }
          else if ($tardiness >= 2) {  // Absent if Too much late
            $absent     = 4;
            $tardiness  = 0;
            $remarks = "Late>=2H,4H Absent";
          }

          if ($undertime >= 4) { // Absent if Too much undertime
            $absent     = $work_hours;
            $tardiness  = 0;
            $undertime  = 0;
            $remarks = "Undertime>=4H,8H Absent";
          }
          else if ($undertime >= 2) { // Absent if Too much undertime
            $absent     = 4;
            $undertime  = 0;
            $remarks = "Undertime>=2H,4H Absent";
          }
          $awol       = $absent - $lwop;
          $reg_hrs    = $work_hours - $awol - $lwop - $tardiness - $undertime;
        }
        else{
          $reg_hrs    = 0;
          $tardiness = 0;
          $undertime = 0;
          $awol       = $work_hours - $lwop;
          $remarks = "NO IN/OUT,8H Absent";
        }



        // if($shift_break_start != "00:00" && $raw_time_break_start != "00:00")
        // {
        //   $earlybreak = $this->early_break($raw_time_break_start, $shift_break_start);
        // }
        // if($shift_break_end != "00:00" && $raw_time_break_end != "00:00"){
        //   $overbreak = $this->over_break($raw_time_break_end, $shift_break_end);
        // }


        // $calculate_work_duration  = $this->calculate_work_duration_1(0, $raw_time_in, $raw_time_out, $raw_shift_time_regular_start, $raw_shift_time_regular_end, $work_hours);

        // if ($calculate_work_duration <= 0) {
        //   $calculate_work_duration = 0;
        //   $remarks = "Invalid Attendance";
        // }
        
       
        $raw_time_in;
        $raw_time_out;
        $raw_shift_time_regular_start;
        $raw_shift_time_regular_end;
        $work_hours;
        $calculate_work_duration;
      } 
      else if ($shift_name == 'REST') {
        $reg_ot                 = 0;
        $nd                     = 0;
        $nd_ot                  = 0;
      } else {
        $reg_ot                 = 0;
        $nd                     = 0;
        $nd_ot                  = 0;

        $remarks                = "No Shift";
        $error_shift_assign     = 1;
      }

      if ($hol_code != "REGULAR") {
        $calculate_work_duration        = 0;
        $work_hours                     = 0;
        $tardiness                      = 0;
        $absent                         = 0;
      }

      if ($reg_hrs >= 4) {
        $sum_present    += 1;
      }
      if ($lwop >= 0) {
        $sum_lwop     += $lwop;
      }
      if ($awol >= 0) {
        $sum_awol     += $awol;
      }
      if ($tardiness >= 0) {
        $sum_tardiness  += $tardiness;
      }
      if ($undertime >= 0) {
        $sum_undertime  += $undertime;
      }
      if ($paid_leave >= 0) {
        $sum_paid_leave += $paid_leave;
      }

      if ($hol_code == "REGULAR" && $shift_name != "REST") {
        if ($reg_hrs > 0) {
          $sum_reg_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_reg_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_reg_nd += $nd_ot;
        }
        if ($nd > 0) {
          $sum_reg_ndot += $nd;
        }
      } elseif ($hol_code == "REGULAR" && $shift_name == "REST") {
        if ($reg_hrs > 0) {
          $sum_rest_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_rest_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_rest_nd += $nd_ot;
        }
        if ($nd > 0) {
          $sum_rest_ndot += $nd;
        }
      } elseif ($hol_code == "LEGAL" && $shift_name != "REST") {
        if ($reg_hrs > 0) {
          $sum_leg_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_leg_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_leg_nd += $nd_ot;
        }
        if ($nd > 0) {
          $sum_leg_ndot += $nd;
        }
      } elseif ($hol_code == "LEGAL" && $shift_name == "REST") {
        if ($reg_hrs > 0) {
          $sum_legrest_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_legrest_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_legrest_nd += $nd_ot;
        }
        if ($nd > 0) {
          $sum_legrest_ndot += $nd;
        }
      } elseif ($hol_code == "SPECIAL" && $shift_name != "REST") {
        if ($reg_hrs > 0) {
          $sum_spe_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_spe_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_spe_nd += $nd_ot;
        }
        if ($nd > 0) {
          $sum_spe_ndot += $nd;
        }
      } elseif ($hol_code == "SPECIAL" && $shift_name == "REST") {
        if ($reg_hrs > 0) {
          $sum_sperest_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_sperest_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_sperest_nd += $nd_ot;
        }
        if ($nd > 0) {
          $sum_sperest_ndot += $nd;
        }
      }

      // var_dump($reg_hrs);
      if ($reg_hrs == 0) {
        $reg_hrs_disp = '';
      } else {
        $reg_hrs_disp     = number_format($reg_hrs, 2);
      }
      if ($absent == 0) {
        $absent_disp = '';
      } else {
        $absent_disp      = number_format($absent, 2);
      }
      if ($lwop == 0) {
        $lwop_disp = '';
      } else {
        $lwop_disp      = number_format($lwop, 2);
      }

      if ($awol == 0) {
        $awol_disp = '';
      } else {
        $awol_disp      = number_format($awol, 2);
      }
      if ($tardiness == 0) {
        $tardiness_disp = '';
      } else {
        $tardiness_disp   = number_format($tardiness, 2);
      }
      if ($undertime == 0) {
        $undertime_disp = '';
      } else {
        $undertime_disp   = number_format($undertime, 2);
      }
      if ($paid_leave == 0) {
        $paid_leave_disp = '';
      } else {
        $paid_leave_disp  = number_format($paid_leave, 2);
      }
      if ($reg_ot == 0) {
        $reg_ot_disp = '';
      } else {
        $reg_ot_disp      = number_format($reg_ot, 2);
      }
      if ($nd_ot == 0) {
        $nd_ot_disp = '';
      } else {
        $nd_ot_disp       = number_format($nd_ot, 2);
      }
      if ($nd == 0) {
        $nd_disp = '';
      } else {
        $nd_disp          = number_format($nd, 2);
      }

      if ($raw_time_in == "00:00") {
        $raw_time_in = '';
      }
      if ($raw_time_out == "00:00") {
        $raw_time_out = '';
      }

      if ($raw_time_break_start == "00:00") {
        $raw_time_break_start = '';
      }
      if ($raw_time_break_end == "00:00") {
        $raw_time_break_end = '';
      }

      if ($shift_regular_start == "00:00") {
        $shift_regular_start = '';
      }
      if ($shift_regular_end == "00:00") {
        $shift_regular_end = '';
      }
      if ($shift_break_start == "00:00") {
        $shift_break_start = '';
      }
      if ($shift_break_end == "00:00") {
        $shift_break_end = '';
      }
      if ($shift_overtime_start == "00:00") {
        $shift_overtime_start = '';
      }
      if ($shift_overtime_end == "00:00") {
        $shift_overtime_end = '';
      }

      if ($earlybreak == 0) {
        $earlybreak_disp = '';
      } else {
        $earlybreak_disp     = number_format($earlybreak, 2);
      }
      if ($overbreak == 0) {
        $overbreak_disp = '';
      } else {
        $overbreak_disp     = number_format($overbreak, 2);
      }

      $data_arr[$index]["Date"]       = $date_name;
      $data_arr[$index]["Date_PDF"]   = $date_pdf;
      $data_arr[$index]["holi_type"]  = $hol_code;

      $data_arr[$index]["shift"]      = $shift_name;

      $data_arr[$index]["shift_regular_start"]      = $shift_regular_start;
      $data_arr[$index]["shift_regular_end"]        = $shift_regular_end;
      $data_arr[$index]["shift_break_start"]        = $shift_break_start;
      $data_arr[$index]["shift_break_end"]          = $shift_break_end;
      $data_arr[$index]["shift_overtime_start"]     = $shift_overtime_start;
      $data_arr[$index]["shift_overtime_end"]       = $shift_overtime_end;
      $data_arr[$index]["earlybreak"]               = $earlybreak_disp;
      $data_arr[$index]["overbreak"]                = $overbreak_disp;


      $data_arr[$index]["shift_PDF"]  = $shift_pdf;
      $data_arr[$index]["shift_color"] = $shift_color;

      $data_arr[$index]['time_in']   = $raw_time_in;
      $data_arr[$index]['time_out']  = $raw_time_out;
      $data_arr[$index]['break_in']   = $raw_time_break_start;
      $data_arr[$index]['break_out']  = $raw_time_break_end;

      $data_arr[$index]['reg_hrs']    = $reg_hrs_disp;
      // $data_arr[$index]['absent']     = $absent_disp;
      $data_arr[$index]['lwop']     = $lwop_disp;
      $data_arr[$index]['awol']     = $awol_disp;
      $data_arr[$index]['tardiness']  = $tardiness_disp;
      $data_arr[$index]['undertime']  = $undertime_disp;
      $data_arr[$index]['paid_leave'] = $paid_leave_disp;

      $data_arr[$index]['reg_ot']     = $reg_ot_disp;
      $data_arr[$index]['nd']         = $nd_disp;
      $data_arr[$index]['nd_ot']      = $nd_ot_disp;

      $data_arr[$index]['remarks']    = $remarks;
      $index += 1;
    }

    if ($sum_present == 0) {
      $sum_present = '';
    } else {
      $sum_present          = number_format($sum_present, 2);
    }
    if ($sum_absent == 0) {
      $sum_absent = '';
    } else {
      $sum_absent           = number_format($sum_absent, 2);
    }
    if ($sum_tardiness == 0) {
      $sum_tardiness = '';
    } else {
      $sum_tardiness        = number_format($sum_tardiness, 2);
    }
    if ($sum_undertime == 0) {
      $sum_undertime = '';
    } else {
      $sum_undertime        = number_format($sum_undertime, 2);
    }
    if ($sum_slider == 0) {
      $sum_slider = '';
    } else {
      $sum_slider           = number_format($sum_slider, 2);
    }
    if ($sum_paid_leave == 0) {
      $sum_paid_leave = '';
    } else {
      $sum_paid_leave       = number_format($sum_paid_leave, 2);
    }
    if ($sum_lwop == 0) {
      $sum_lwop = '';
    } else {
      $sum_lwop       = number_format($sum_lwop, 2);
    }
    if ($sum_awol == 0) {
      $sum_awol = '';
    } else {
      $sum_awol             = number_format($sum_awol, 2);
    }
    if ($sum_reg_hours == 0) {
      $sum_reg_hours = '';
    } else {
      $sum_reg_hours        = number_format($sum_reg_hours, 2);
    }
    if ($sum_reg_regot == 0) {
      $sum_reg_regot = '';
    } else {
      $sum_reg_regot        = number_format($sum_reg_regot, 2);
    }
    if ($sum_reg_nd == 0) {
      $sum_reg_nd = '';
    } else {
      $sum_reg_nd           = number_format($sum_reg_nd, 2);
    }
    if ($sum_reg_ndot == 0) {
      $sum_reg_ndot = '';
    } else {
      $sum_reg_ndot         = number_format($sum_reg_ndot, 2);
    }
    if ($sum_rest_hours == 0) {
      $sum_rest_hours = '';
    } else {
      $sum_rest_hours       = number_format($sum_rest_hours, 2);
    }
    if ($sum_rest_regot == 0) {
      $sum_rest_regot = '';
    } else {
      $sum_rest_regot       = number_format($sum_rest_regot, 2);
    }
    if ($sum_rest_nd == 0) {
      $sum_rest_nd = '';
    } else {
      $sum_rest_nd          = number_format($sum_rest_nd, 2);
    }
    if ($sum_rest_ndot == 0) {
      $sum_rest_ndot = '';
    } else {
      $sum_rest_ndot        = number_format($sum_rest_ndot, 2);
    }
    if ($sum_leg_hours == 0) {
      $sum_leg_hours = '';
    } else {
      $sum_leg_hours        = number_format($sum_leg_hours, 2);
    }
    if ($sum_leg_regot == 0) {
      $sum_leg_regot = '';
    } else {
      $sum_leg_regot        = number_format($sum_leg_regot, 2);
    }
    if ($sum_leg_nd == 0) {
      $sum_leg_nd = '';
    } else {
      $sum_leg_nd           = number_format($sum_leg_nd, 2);
    }
    if ($sum_leg_ndot == 0) {
      $sum_leg_ndot = '';
    } else {
      $sum_leg_ndot         = number_format($sum_leg_ndot, 2);
    }
    if ($sum_legrest_hours == 0) {
      $sum_legrest_hours = '';
    } else {
      $sum_legrest_hours    = number_format($sum_legrest_hours, 2);
    }
    if ($sum_legrest_regot == 0) {
      $sum_legrest_regot = '';
    } else {
      $sum_legrest_regot    = number_format($sum_legrest_regot, 2);
    }
    if ($sum_legrest_nd == 0) {
      $sum_legrest_nd = '';
    } else {
      $sum_legrest_nd       = number_format($sum_legrest_nd, 2);
    }
    if ($sum_legrest_ndot == 0) {
      $sum_legrest_ndot = '';
    } else {
      $sum_legrest_ndot     = number_format($sum_legrest_ndot, 2);
    }
    if ($sum_spe_hours == 0) {
      $sum_spe_hours = '';
    } else {
      $sum_spe_hours        = number_format($sum_spe_hours, 2);
    }
    if ($sum_spe_regot == 0) {
      $sum_spe_regot = '';
    } else {
      $sum_spe_regot        = number_format($sum_spe_regot, 2);
    }
    if ($sum_spe_nd == 0) {
      $sum_spe_nd = '';
    } else {
      $sum_spe_nd           = number_format($sum_spe_nd, 2);
    }
    if ($sum_spe_ndot == 0) {
      $sum_spe_ndot = '';
    } else {
      $sum_spe_ndot         = number_format($sum_spe_ndot, 2);
    }
    if ($sum_sperest_hours == 0) {
      $sum_sperest_hours = '';
    } else {
      $sum_sperest_hours    = number_format($sum_sperest_hours, 2);
    }
    if ($sum_sperest_regot == 0) {
      $sum_sperest_regot = '';
    } else {
      $sum_sperest_regot    = number_format($sum_sperest_regot, 2);
    }
    if ($sum_sperest_nd == 0) {
      $sum_sperest_nd = '';
    } else {
      $sum_sperest_nd       = number_format($sum_sperest_nd, 2);
    }
    if ($sum_sperest_ndot == 0) {
      $sum_sperest_ndot = '';
    } else {
      $sum_sperest_ndot     = number_format($sum_sperest_ndot, 2);
    }



    $data["DATE_RANGE"]         = $data_arr;

    $data["ERROR_SHIFT_ASSIGN"] = $error_shift_assign;



    $data["SUM_PRESENT"]        = $sum_present;
    $data["SUM_ABSENT"]         = $sum_absent;
    $data["SUM_TARDINESS"]      = $sum_tardiness;
    $data["SUM_UNDERTIME"]      = $sum_undertime;
    $data["SUM_SLIDER"]         = $sum_slider;

    $data["SUM_PAID_LEAVE"]     = $sum_paid_leave;
    $data["SUM_LWOP"]           = $sum_lwop;
    $data["SUM_AWOL"]           = $sum_awol;

    $data["SUM_REG_HOURS"]      = $sum_reg_hours;
    $data["SUM_REG_OT"]         = $sum_reg_regot;
    $data["SUM_REG_ND"]         = $sum_reg_nd;
    $data["SUM_REG_NDOT"]       = $sum_reg_ndot;

    $data["SUM_REST_HOURS"]     = $sum_rest_hours;
    $data["SUM_REST_OT"]        = $sum_rest_regot;
    $data["SUM_REST_ND"]        = $sum_rest_nd;
    $data["SUM_REST_NDOT"]      = $sum_rest_ndot;

    $data["SUM_LEG_HOURS"]      = $sum_leg_hours;
    $data["SUM_LEG_OT"]         = $sum_leg_regot;
    $data["SUM_LEG_ND"]         = $sum_leg_nd;
    $data["SUM_LEG_NDOT"]       = $sum_leg_ndot;

    $data["SUM_LEGREST_HOURS"]  = $sum_legrest_hours;
    $data["SUM_LEGREST_OT"]     = $sum_legrest_regot;
    $data["SUM_LEGREST_ND"]     = $sum_legrest_nd;
    $data["SUM_LEGREST_NDOT"]   = $sum_legrest_ndot;

    $data["SUM_SPE_HOURS"]      = $sum_spe_hours;
    $data["SUM_SPE_OT"]         = $sum_spe_regot;
    $data["SUM_SPE_ND"]         = $sum_spe_nd;
    $data["SUM_SPE_NDOT"]       = $sum_spe_ndot;

    $data["SUM_SPEREST_HOURS"]  = $sum_sperest_hours;
    $data["SUM_SPEREST_OT"]     = $sum_sperest_regot;
    $data["SUM_SPEREST_ND"]     = $sum_sperest_nd;
    $data["SUM_SPEREST_NDOT"]   = $sum_sperest_ndot;


    $data['DISP_VIEW_BRANCH']         = $this->attendance_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']     = $this->attendance_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']       = $this->attendance_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION']        = $this->attendance_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']          = $this->attendance_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']           = $this->attendance_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']           = $this->attendance_model->GET_SYSTEM_SETTING("com_line");


    $this->load->view('templates/header');
    $this->load->view('modules/attendances/attendance_record_views', $data);
  }

  function attendance_rec_csv()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/attendance_rec_csv_views');
  }
  function getEmployee($id)
  {
    $empl_info                        = $this->attendance_model->GET_EMPLOYEE_INFO($id);
    echo json_encode($empl_info);
  }
  function attendance_rec_csv_process()
  {
    $handle                           = fopen($_FILES['file']['tmp_name'], "r");
    $headers                          = fgetcsv($handle, 1000, ",");

    if (count($headers) != 6) {
      $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Incomplete Headers");
      redirect('attendances/attendance_rec_csv');
      return;
    }

    if (
      $headers[0] != 'date' || $headers[1] != 'Employee_id' || $headers[2] != 'time_in1' || $headers[3] != 'time_out1' ||
      $headers[4] != 'time_in2' || $headers[5] != 'time_out2'
    ) {

      $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Wrong Header Name");
      redirect('attendances/attendance_rec_csv');
      return;
    }

    $emp                              = $this->attendance_model->GET_ALL_EMP();

    $arr_data                         = array();

    function convert_id($array, $data)
    {
      $empl_id = "";
      foreach ($array as $row) {
        if ($row->col_empl_cmid == $data) {
          $empl_id = $row->id;
        }
      }
      return $empl_id;
    }

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $date_raw                     = date("Y-m-d", strtotime($data[0]));
      $user_raw                     = convert_id($emp, $data[1]);

      $response                     = $this->attendance_model->IS_DUPLICATE_CSV($date_raw, $user_raw);

      if ($response == 0) {
        $arr_data[$headers[0]] = date("Y-m-d", strtotime($data[0]));
        $arr_data[$headers[1]] = convert_id($emp, $data[1]);
        $arr_data[$headers[2]] = $data[2];
        $arr_data[$headers[3]] = $data[3];
        // $arr_data[$headers[4]] = $data[4];
        // $arr_data[$headers[5]] = $data[5];

        $this->attendance_model->INSERT_ATTENDANCE_REC_CSV($arr_data);
      } else {
        if ($data[2] == '') {
          $data_2 = '00:00:00';
        } else {
          $data_2 = $data[2];
        }
        if ($data[3] == '') {
          $data_3 = '00:00:00';
        } else {
          $data_3 = $data[3];
        }
        if ($data[4] == '') {
          $data_4 = '00:00:00';
        } else {
          $data_4 = $data[4];
        }
        if ($data[5] == '') {
          $data_5 = '00:00:00';
        } else {
          $data_5 = $data[5];
        }

        $arr_data[$headers[0]] = $data_2;
        $arr_data[$headers[1]] = $data_3;
        // $arr_data[$headers[2]] = $data_4;
        // $arr_data[$headers[3]] = $data_5;
        $arr_data[$headers[4]] = date("Y-m-d", strtotime($data[0]));
        $arr_data[$headers[5]] = convert_id($emp, $data[1]);

        $this->attendance_model->UPDATE_ATTENDANCE_REC_CSV($arr_data);
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT_CSV', 'Successfully uploaded data');
      }
    }

    fclose($handle);

    redirect('attendances/attendance_rec_csv');
  }



  function csv_uploads()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/csv_upload_views');
  }

  function approval_csv_process()
  {
    $handle                   = fopen($_FILES['file']['tmp_name'], "r");
    $headers                  = fgetcsv($handle, 1000, ",");

    if (count($headers) != 7) {
      $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Incomplete Headers");
      redirect('attendances/csv_import');
      return;
    }

    if (
      $headers[0] != 'Employee_id' || $headers[1] != 'approver_1a' || $headers[2] != 'approver_1b' ||
      $headers[3] != 'approver_2a' || $headers[4] != 'approver_2b' || $headers[5] != 'approver_3a' || $headers[6] != 'approver_3b'
    ) {

      $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Wrong Header Name");
      redirect('attendances/csv_import');
      return;
    }
    $emp                      = $this->attendance_model->GET_ALL_EMP();

    $arr_data                 = array();

    function convert_id($array, $data)
    {
      $empl_id = "";
      foreach ($array as $row) {
        if ($row->col_empl_cmid == $data) {
          $empl_id            = $row->id;
        }
      }
      return $empl_id;
    }

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $arr_data[$headers[0]] = convert_id($emp, $data[0]);
      $arr_data[$headers[1]] = convert_id($emp, $data[1]);
      $arr_data[$headers[2]] = convert_id($emp, $data[2]);
      $arr_data[$headers[3]] = convert_id($emp, $data[3]);
      $arr_data[$headers[4]] = convert_id($emp, $data[4]);
      $arr_data[$headers[5]] = convert_id($emp, $data[5]);
      $arr_data[$headers[6]] = convert_id($emp, $data[6]);
      $this->attendance_model->INSERT_APPROVAL_CSV($arr_data);
    }

    fclose($handle);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_CSV', 'Approval Updated Successfully!');
    redirect('attendances/approval_routes');
  }

  function csv_process()
  {
    $handle                 = fopen($_FILES['file']['tmp_name'], "r");
    $headers                = fgetcsv($handle, 1000, ",");

    if (count($headers) != 34) {
      $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Incomplete Headers");
      redirect('attendances/csv_uploads');
      return;
    }

    if (
      $headers[0]  != 'empl_id'       || $headers[1]  != 'cut_off'       || $headers[2]  != 'reg_hrs'          ||
      $headers[3]  != 'swap'          || $headers[4]  != 'rest_day_ot'   || $headers[5]  != 'legal_w'          ||
      $headers[6]  != 'legal_wo'      || $headers[7]  != 'spe_hol'       || $headers[8]  != 'reg_ot'           ||
      $headers[9]  != 'free_lunch'    || $headers[10] != 'excess_ot_hol' || $headers[11] != 'excess_ot_spe'    ||
      $headers[12] != 'excess_ot_reg' || $headers[13] != 'allo_meal_ot'  || $headers[14] != 'nd'               ||
      $headers[15] != 'nd_ot'         || $headers[16] != 'absent'        || $headers[17] != 'tardiness'        ||
      $headers[18] != 'undertime'     || $headers[19] != 'allo_rice'     || $headers[20] != 'allo_ctpa'        || $headers[21] != 'allo_sea' ||
      $headers[22] != 'allo_transpo'  || $headers[23] != 'allo_swc'      || $headers[24] != 'loan_rcbc'        || $headers[25] != 'vac' ||
      $headers[26] != 'adj_medical'   || $headers[27] != 'adj_rice'      || $headers[28] != 'adj_nightdiff'    || $headers[29] != 'adj_restot' ||
      $headers[30] != 'adj_shot'      || $headers[31] != 'adj_lhot'      || $headers[32] != 'adj_allo_transpo' || $headers[33] != 'adj_regot'
    ) {
      $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Wrong Header Name");
      redirect('attendances/csv_uploads');
      return;
    }

    $arr_data       = array();
    while (($data   = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $user_id      = $this->attendance_model->GET_SPECIFIC_USER_ID($data[0])->id;
      // var_dump($user_id);
      // return;
      if (empty($user_id)) {
        // escape data id employee id not exist
        continue;
      }
      $arr_data[$headers[0]]  = $user_id;
      $arr_data[$headers[1]]  = $data[1];
      $arr_data[$headers[2]]  = $data[2];
      $arr_data[$headers[3]]  = $data[3];
      $arr_data[$headers[4]]  = $data[4];
      $arr_data[$headers[5]]  = $data[5];
      $arr_data[$headers[6]]  = $data[6];
      $arr_data[$headers[7]]  = $data[7];
      $arr_data[$headers[8]]  = $data[8];
      $arr_data[$headers[9]]  = $data[9];
      $arr_data[$headers[10]] = $data[10];
      $arr_data[$headers[11]] = $data[11];
      $arr_data[$headers[12]] = $data[12];
      $arr_data[$headers[13]] = $data[13];
      $arr_data[$headers[14]] = $data[14];
      $arr_data[$headers[15]] = $data[15];
      $arr_data[$headers[16]] = $data[16];
      $arr_data[$headers[17]] = $data[17];
      $arr_data[$headers[18]] = $data[18];
      $arr_data[$headers[19]] = $data[19];
      $arr_data[$headers[20]] = $data[20];
      $arr_data[$headers[21]] = $data[21];
      $arr_data[$headers[22]] = $data[22];
      $arr_data[$headers[23]] = $data[23];
      $arr_data[$headers[24]] = $data[24];
      $arr_data[$headers[25]] = $data[25];
      $arr_data[$headers[26]] = $data[26];
      $arr_data[$headers[27]] = $data[27];
      $arr_data[$headers[28]] = $data[28];
      $arr_data[$headers[29]] = $data[29];
      $arr_data[$headers[30]] = $data[30];
      $arr_data[$headers[31]] = $data[31];
      $arr_data[$headers[32]] = $data[32];
      $arr_data[$headers[33]] = $data[33];
      $this->attendance_model->INSERT_CSV($arr_data);
    }
    fclose($handle);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_CSV', 'Successfully uploaded data');
    redirect('attendances/csv_uploads');
  }

  function early_break($time, $shift)
  {
    $shift_min           = $this->convert_time_to_float($shift, 'minute');
    $time_min            = $this->convert_time_to_float($time, 'minute');
    $min              = $shift_min - $time_min;
    $ded              = 0.0;

    if (($min > 0) && ($min <= 15)) {
      $ded = 0.25;
    } else if (($min > 15) && ($min <= 30)) {
      $ded = 0.5;
    } else if (($min > 30) && ($min <= 45)) {
      $ded = 0.75;
    } else if ($min > 45){
      $ded = 1.00;
    } 
    return $ded;
  }

  function over_break($time, $shift)
  {
    $shift_min           = $this->convert_time_to_float($shift, 'minute');
    $time_min            = $this->convert_time_to_float($time, 'minute');
    $min              = $shift_min - $time_min;
    $ded              = 0;

    if (($min > 0) && ($min <= 15)) {
      $ded = 0.25;
    } else if (($min > 15) && ($min <= 30)) {
      $ded = 0.5;
    } else if (($min > 30) && ($min <= 45)) {
      $ded = 0.75;
    } else if ($min > 45){
      $ded = 1;
    } 
    return $ded;
  }
  

  function deduction_in($time_in, $shift_in)
  {
    $shift_in_min           = $this->convert_time_to_float($shift_in, 'minute');
    $time_in_min            = $this->convert_time_to_float($time_in, 'minute');
    $in_min                 = $time_in_min - $shift_in_min;
    $in_ded                 = 0;
    if (($in_min > 0) && ($in_min <= 30)) {
      $in_ded = 0.5;
    } else if (($in_min > 30) && ($in_min <= 60)) {
      $in_ded = 1;
    } else if (($in_min > 60) && ($in_min <= 90)) {
      $in_ded = 1.5;
    } else if (($in_min > 90) && ($in_min <= 120)) {
      $in_ded = 2.0;
    } else if (($in_min > 120) && ($in_min <= 150)) {
      $in_ded = 2.5;
    } else if (($in_min > 150) && ($in_min <= 180)) {
      $in_ded = 3.0;
    } else if (($in_min > 180) && ($in_min <= 210)) {
      $in_ded = 3.5;
    } else if (($in_min > 210) && ($in_min <= 240)) {
      $in_ded = 4.5;
    } else if (($in_min > 240) && ($in_min <= 270)) {
      $in_ded = 5.0;
    } else if (($in_min > 270) && ($in_min <= 300)) {
      $in_ded = 5.5;
    } else if (($in_min > 300) && ($in_min <= 330)) {
      $in_ded = 6.0;
    } else if (($in_min > 330) && ($in_min <= 360)) {
      $in_ded = 6.5;
    } else if (($in_min > 360) && ($in_min <= 390)) {
      $in_ded = 7.0;
    } else if (($in_min > 390) && ($in_min <= 420)) {
      $in_ded = 7.5;
    } else if (($in_min > 420)) {
      $in_ded = 8.0;
    } 
    return $in_ded;
  }


  function deduction_out($time_out, $shift_out)
  {
    $shift_out_min          =  $this->convert_time_to_float($shift_out, 'minute');
    $time_out_min           =  $this->convert_time_to_float($time_out, 'minute');

    $out_min                = $shift_out_min - $time_out_min;
    $out_ded                = 0;
    if (($out_min > 0) && ($out_min <= 30)) {
      $out_ded = 0.5;
    } else if (($out_min > 30) && ($out_min <= 60)) {
      $out_ded = 1.0;
    } else if (($out_min > 60) && ($out_min <= 90)) {
      $out_ded = 1.5;
    } else if (($out_min > 90) && ($out_min <= 120)) {
      $out_ded = 2.0;
    } else if (($out_min > 120) && ($out_min <= 150)) {
      $out_ded = 2.5;
    } else if (($out_min > 150) && ($out_min <= 180)) {
      $out_ded = 3.0;
    } else if (($out_min > 180) && ($out_min <= 210)) {
      $out_ded = 3.5;
    } else if (($out_min > 210) && ($out_min <= 240)) {
      $out_ded = 4.0;
    } else if (($out_min > 240) && ($out_min <= 270)) {
      $out_ded = 4.5;
    } else if (($out_min > 270) && ($out_min <= 300)) {
      $out_ded = 5.0;
    } else if (($out_min > 300) && ($out_min <= 330)) {
      $out_ded = 5.5;
    } else if (($out_min > 330) && ($out_min <= 360)) {
      $out_ded = 6.0;
    } else if (($out_min > 360) && ($out_min <= 390)) {
      $out_ded = 6.5;
    } else if (($out_min > 390) && ($out_min <= 420)) {
      $out_ded = 7.0;
    } else if (($out_min > 420) && ($out_min <= 450)) {
      $out_ded = 7.5;
    } else if (($out_min > 450)) {
      $out_ded = 8.0;
    }
    return $out_ded;
  }
  function convert_time_to_float($time, $type)
  {
    $split_time_in            = explode(":", $time);
    if ($type == 'minute') {
      $converted_time         = ((float)$split_time_in[0] * 60) + (float)$split_time_in[1];
    } else {
      $converted_time         = (float)$split_time_in[0] + ((float)$split_time_in[1] / 60);
    }
    return (float)$converted_time;
  }
  function calculate_work_duration_1($hasNextDay, $raw_time_in_1, $raw_time_out_1, $raw_shift_time_in_1, $raw_shift_time_out_1, $work_hours)
  {
    $work_duration            = (float)($work_hours) - $this->deduction_in($raw_time_in_1, $raw_shift_time_in_1) - $this->deduction_out($raw_time_out_1, $raw_shift_time_out_1);
    return $work_duration;
  }

  function calculate_night_differential($time_in, $time_out, $shift_time_in, $shift_time_out)
  {
    $shift_in_min             = $this->convert_time_to_float($shift_time_in, 'minute');
    $shift_out_min            = $this->convert_time_to_float($shift_time_out, 'minute');
    $time_in_min              = $this->convert_time_to_float($time_in, 'minute');
    $time_out_min             = $this->convert_time_to_float($time_out, 'minute');
    $work_duration            = 0;
    $work_duration_1          = 0;
    $work_duration_2          = 0;

    if ($shift_out_min < $shift_in_min || $shift_out_min > 1320) {
      if ($time_out_min < $time_in_min) {
        $work_duration_1      = 1440 - $time_in_min;
        $work_duration_2      = $time_out_min;

        if ($work_duration_1 > 120) {
          $work_duration_1    = 120;
        }
        if ($work_duration_2 > 360) {
          $work_duration_2    = 360;
        }

        $work_duration        = ($work_duration_1 + $work_duration_2) / 60;
      } else {
        $work_duration_1      = $time_out_min - 1320;


        if ($time_in_min > 1320) {
          $work_duration      = ($work_duration_1 - ($time_in_min - 1320)) / 60;
        } else {
          $work_duration      = ($work_duration_1) / 60;
        }
      }
    }


    return (float)$work_duration;
  }

  function calculate_shift_duration($hasNextDay, $shift_time_in, $shift_time_out)
  {
    $shift_in_min           = $this->convert_time_to_float($shift_time_in, 'minute');
    $shift_out_min          = $this->convert_time_to_float($shift_time_out, 'minute');

    if ($shift_out_min >= $shift_in_min) {
      $work_duration        = ($shift_out_min - $shift_in_min) / 60;
    } else {
      $work_duration        = ($shift_out_min + (1440 - $shift_in_min)) / 60;
    }

    return (float)$work_duration;
  }


  function get_employee_data()
  {
    $employee_id                  = $this->input->get('employee');
    $date_period                  = $this->attendance_model->GET_PERIOD_DATA($this->input->get('period')); // $this->input->get('period');
    if (empty($date_period)) {
      $data['employee_data']      = array();
      $data['cutoff_data']        = array();
      return $data;
    }
    $start_date                   = $date_period['date_from'];
    $end_date                     =  $date_period['date_to'];
    $data['employee_data']        = $this->attendance_model->MOD_DISP_EMPLOYEE($employee_id);
    $data['cutoff_data']          = $this->attendance_model->MON_DISP_CUTOFF_PERIOD($start_date, $end_date, $employee_id);
    return $data;
  }
  function attendance_data($dates, $holidays, $employees)
  {
  }

  function shift_assignment()
  {
    if (!isset($_GET["branch"])) {
      $param_branch         = "all";
    } else {
      $param_branch         = $_GET["branch"];
    }
    if (!isset($_GET["dept"])) {
      $param_dept           = "all";
    } else {
      $param_dept           = $_GET["dept"];
    }
    if (!isset($_GET["division"])) {
      $param_division       = "all";
    } else {
      $param_division       = $_GET["division"];
    }
    if (!isset($_GET["section"])) {
      $param_section        = "all";
    } else {
      $param_section        = $_GET["section"];
    }
    if (!isset($_GET["group"])) {
      $param_group          = "all";
    } else {
      $param_group          = $_GET["group"];
    }
    if (!isset($_GET["team"])) {
      $param_team           = "all";
    } else {
      $param_team           = $_GET["team"];
    }
    if (!isset($_GET["line"])) {
      $param_line           = "all";
    } else {
      $param_line           = $_GET["line"];
    }
    if (!isset($_GET["status"])) {
      $param_status         = "all";
    } else {
      $param_status         = $_GET["status"];
    }

    if (!isset($_GET["employee"])) {
      $_GET["employee"] = "";
    }

    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["C_ROW_DISPLAY"]                    =  [25, 50, 100];

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    if ($row == null) {
      $row = 25;
    }
    if ($page  == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);

    if ($this->input->get('all') == null) {
      $data['DISP_EMP_LIST']                  = $empl_list = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_2($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
      $data['DISP_EMP_LIST_DATA']             = $empl_list = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_DATA($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
      $data['C_DATA_COUNT']                   = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
    } else {
      $data['DISP_EMP_LIST']                  = $this->attendance_model->GET_SEARCHED($search);
      $data['C_DATA_COUNT']                   = count($this->attendance_model->GET_SEARCHED($search));
    }

    $data['DISP_PAYROLL_SCHED']               = $payroll_list = $this->attendance_model->MOD_DISP_PAY_SCHED();

    // echo '<pre>';
    // echo  $data['C_DATA_COUNT'];
    // return;
    if (!isset($_GET["period"])) {
      $period = $payroll_list[0]->id;
    } else {
      $period = $_GET["period"];
    }
    // $data['EMPL_INITIAL']             = $empl_list[0];
    $data['PERIOD_INITIAL']             = $period;
    $res_data                           = $this->get_employee_data();
    $data['DISP_CUTOFF']                = $res_data['cutoff_data'];
    $data['DISP_WORK_SHIFT_DATA']       = $this->attendance_model->GET_WORK_SHIFT_DATA();

    $data['DISP_DISTINCT_BRANCH']       = $this->attendance_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT']   = $this->attendance_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']     = $this->attendance_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_SECTION']      = $this->attendance_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']        = $this->attendance_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']         = $this->attendance_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']         = $this->attendance_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_BRANCH']           = $this->attendance_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']       = $this->attendance_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']         = $this->attendance_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION']          = $this->attendance_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']            = $this->attendance_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']             = $this->attendance_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']             = $this->attendance_model->GET_SYSTEM_SETTING("com_line");


    if (!empty($DISP_EMP_LIST)) {
      $data['DISP_USER_ID']             = $data['DISP_EMP_LIST'][0]->id;
    } else {
      $data['DISP_USER_ID']             = 0;
    }

    $date_period                        = $this->attendance_model->GET_PERIOD_DATA($period);


    if (isset($_GET['yearmonth_from'])) {
      $yearmonth_from                   = $_GET['yearmonth_from'];
    } else {
      $yearmonth_from                   = date('Y-m-01');
    }

    if (isset($_GET['yearmonth_to'])) {
      $yearmonth_to                     = $_GET['yearmonth_to'];
    } else {
      $yearmonth_to                     = date('Y-m-t');
    }

    $firstDay                           = date('Y-m-d', strtotime($yearmonth_from));
    $lastDay                            = date('Y-m-d', strtotime($yearmonth_to));


    $begin                              = new DateTime($firstDay);
    $end                                = new DateTime($lastDay);
    $end                                = $end->modify('+1 day');
    $holidays                           = $this->attendance_model->GET_HOLIDAY();
    $interval                           = new DateInterval('P1D');
    $daterange                          = new DatePeriod($begin, $interval, $end);

    $data['SHIFT_DATA_DATERANGE']       = $this->attendance_model->GET_SHIFT_DATA_DATERANGE($firstDay, $lastDay);
    // $data['DATE_FROM']                = $date_period['date_from'];
    // $data['DATE_TO']                  = $date_period['date_to'];
    $data['DATE_FROM']                  = $firstDay;
    $data['DATE_TO']                    = $lastDay;
    $data['SHIFT_DATA']                 = $this->attendance_model->GET_SHIFT_ALL_DATA();
    // var_dump($data['SHIFT_DATA_DATERANGE'] );
    $data["DATE_RANGE"]                 = $this->assign_shift_data($daterange, $holidays);

    $this->load->view('templates/header');
    $this->load->view('modules/attendances/shift_assignment_views', $data);
  }
  function bulk_import()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/bulk_import_views');
  }

  function assign_shift_data($dates, $holidays)
  {
    $data_arr                         = array();
    $index                            = 0;
    foreach ($dates as $date) {
      $data_arr[$index]["Date"] = $date;
      $is_found                       = FALSE;
      $is_match                       = FALSE;
      foreach ($holidays as $holiday) {
        if ($holiday->col_holi_date == $date->format("Y-m-d")) {
          if ($holiday->col_holi_type == "Regular Holiday") {
            $data_arr[$index]["holi_type"] = "LEGAL";
          } else {
            $data_arr[$index]["holi_type"] = "SPECIAL";
          }
          $is_found                   = TRUE;
          break;
        }
      }
      // foreach ($shifts as $shift) {
      //   if ($shift->date == $date->format("Y-m-d")) {
      //     $data_arr[$index]["shift"] = $shift->shift_id;
      //     $is_match = TRUE;
      //     break;
      //   }
      // }
      // if (!$is_match) {
      //   $data_arr[$index]["shift"] = "";
      // }
      if (!$is_found) {
        $data_arr[$index]["holi_type"] = "REGULAR";
      }
      $index += 1;
    }
    return $data_arr;
  }
  function process_assigning($user_id, $shift_id, $date)
  {
    $response                               = $this->attendance_model->IS_DUPLICATE($user_id, $date);
    // var_dump($date);
    $response;
    if ($response == 0) {
      $res_insrt                            = $this->attendance_model->ADD_USER_WORK_SHIFT($user_id, $shift_id, $date);
    } else {
      $res_insrt                            = $this->attendance_model->UPDATE_USER_WORK_SHIFT($user_id, $shift_id, $date);
    }

    // redirect('attendances/shift_assignment');

    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }

  function update_shift()
  {

    $count_date                           = $this->input->post('COUNT_DATE');
    $date_from                            = $this->input->post('DATE_FROM');
    $date_to                              = $this->input->post('DATE_TO');
    $mark_id                              = $this->input->post('UPDATE_ID');
    $data_arr                             = array();
    $ids_int                              = array_map('intval', explode(',', $mark_id));
    $begin                                = new DateTime($date_from);
    $end                                  = new DateTime($date_to);
    $end                                  = $end->modify('+1 day');
    $interval                             = new DateInterval('P1D');
    $daterange                            = new DatePeriod($begin, $interval, $end);
    $i                                    = 0;

    foreach ($ids_int as $ids_int_row) {
      $i                                  = 0;

      foreach ($daterange as $dt) {
        $date                             = $dt->format("Y-m-d");
        $shift_id                         = $this->input->post('UPDT_SHIFT_' . ($i + 1));
        $i++;

        $user_id                          = $ids_int_row;

        $response                         = $this->attendance_model->IS_DUPLICATE($user_id, $date);

        if ($response == 0) {
          $res_insrt                      = $this->attendance_model->ADD_USER_WORK_SHIFT($user_id, $shift_id, $date);
        } else {
          $res_insrt                      = $this->attendance_model->UPDATE_USER_WORK_SHIFT($user_id, $shift_id, $date);
        }
      }
    }

    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }

  function daily_attendances()
  {
    $attendance_date                      = $this->input->get('date');
    $department                           = $this->input->get('department');
    $section                              = $this->input->get('section');
    $group                                = $this->input->get('group');
    $line                                 = $this->input->get('line');
    if (!$attendance_date) {

      $data['DISP_EMPL_NOT_YET_IN_OFFICE']         = $this->attendance_model->MOD_DISP_EMPL_NOT_YET_IN_OFFICE();
      $data['DISP_EMPL_ALREADY_IN_OFFICE']         = $this->attendance_model->MOD_DISP_EMPL_ALREADY_IN_OFFICE();
      $data['DISP_EMPL_OUT_OF_OFFICE']             = $this->attendance_model->MOD_DISP_EMPL_OUT_OF_OFFICE();
      $data['DISP_EMPL_ON_REST']                   = $this->attendance_model->MOD_DISP_EMPL_ON_REST();
      $data['DISP_ON_LEAVE']                       = $this->attendance_model->MOD_DISP_ON_LEAVE();
      $data['DISP_DISTINCT_DEPARTMENT']            = $this->attendance_model->MOD_DISP_DISTINCT_DEPARTMENT();
      $data['DISP_DISTINCT_SECTION']               = $this->attendance_model->MOD_DISP_DISTINCT_SECTION();
      $data['DISP_Group']                          = $this->attendance_model->MOD_DISP_DISTINCT_GROUP();
      $data['DISP_Line']                           = $this->attendance_model->MOD_DISP_DISTINCT_LINE();
    } else {
      $data['DISP_EMPL_NOT_YET_IN_OFFICE']         = $this->attendance_model->MOD_DISP_EMPL_NOT_YET_IN_OFFICE_AJAX($attendance_date);
      $data['DISP_EMPL_ALREADY_IN_OFFICE']         = $this->attendance_model->MOD_DISP_EMPL_ALREADY_IN_OFFICE_AJAX($attendance_date);
      $data['DISP_EMPL_OUT_OF_OFFICE']             = $this->attendance_model->MOD_DISP_EMPL_OUT_OF_OFFICE_AJAX($attendance_date);
      $data['DISP_EMPL_ON_REST']                   = $this->attendance_model->MOD_DISP_EMPL_ON_REST_AJAX($attendance_date);
      $data['DISP_ON_LEAVE']                       = $this->attendance_model->MOD_DISP_ON_LEAVE_AJAX($attendance_date);
      $data['DISP_DISTINCT_DEPARTMENT']            = $this->attendance_model->MOD_DISP_DISTINCT_DEPARTMENT();
      $data['DISP_DISTINCT_SECTION']               = $this->attendance_model->MOD_DISP_DISTINCT_SECTION();
      $data['DISP_Group']                          = $this->attendance_model->MOD_DISP_DISTINCT_GROUP();
      $data['DISP_Line']                           = $this->attendance_model->MOD_DISP_DISTINCT_LINE();
    }
    $data['DISP_EMP_LIST']                         = $this->attendance_model->MOD_DISP_ALL_EMPLOYEES();
    $data['DISP_DEPARTMENT']                       = $this->attendance_model->GET_ALL_DEPT();
    $data['DISP_SECTION']                          = $this->attendance_model->GET_ALL_SECT();
    $data['DISP_GROUP']                            = $this->attendance_model->GET_ALL_GROUP();
    $data['DISP_LINES']                            = $this->attendance_model->GET_ALL_LINE();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/daily_attendance_views', $data);
  }
  // Workshift page
  function work_shifts()
  {
    $search                                       = str_replace('_', ' ', $this->input->get('all') ?? "");

    $tab                                          = $this->input->get('tab') ? $this->input->get('tab') : 'Active';

    $page                                         = $this->input->get('page');
    $row                                          = $this->input->get('row');

    if ($row == null) {
      $row = 25;
    }
    if ($page  == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);

    $data["C_ROW_DISPLAY"]                        = [25, 50, 100];
    $data['PAGE']                                 = $page;
    $data['ROW']                                  = $row;
    $data['TAB']                                  = $tab;

    $data['ACTIVES']                              = count($this->attendance_model->GET_WORK_SHIFT_ACTIVE_COUNT('Active'));
    $data['INACTIVES']                            = count($this->attendance_model->GET_WORK_SHIFT_INACTIVE_COUNT('InActive'));

    if ($this->input->get('all') == null) {
      $data['DISP_WRK_SHFT_INFO']                 = $this->attendance_model->MOD_DISP_WRK_SHFT($tab, $row, $offset);
      $data['C_DATA_COUNT']                       = $data_count = count($this->attendance_model->MOD_DISP_WRK_SHFT_COUNT($tab));
    } else {
      $data['DISP_WRK_SHFT_INFO']                 = $this->attendance_model->MOD_DISP_SEARCH_WRK_SHFT($tab, $search);
      $data['C_DATA_COUNT']                       = $data_count = count($this->attendance_model->MOD_DISP_SEARCH_WRK_SHFT($tab, $search));
    }

    $page_count                         = intval($data_count / $row);
    $excess                             = $data_count % $row;
    $data['PAGES_COUNT']                = $excess > 0 ? $page_count += 1 : $page_count;
    $data['DISP_INOUT_TYPE']                      = $this->attendance_model->GET_IN_OUT_TYPE();


    $this->load->view('templates/header');
    $this->load->view('modules/attendances/work_shift_views', $data);
  }

  function workshift_mark_active()
  {
    $id                                           = $this->input->post('APPROVE_ID');
    $ids                                          = explode(",", $id);
    foreach ($ids as $id) {
      $this->attendance_model->UPDATE_WORKSHIFT($id, 'Active');
    }
    $this->session->set_userdata('succ_approved', 'Mark as Active Successfully!');
    redirect('attendances/work_shifts');
  }

  function workshift_mark_inactive()
  {
    $id                                           = $this->input->post('WORKSHIFT_ID');
    $ids                                          = explode(",", $id);
    foreach ($ids as $id) {
      $this->attendance_model->UPDATE_WORKSHIFT($id, 'Inactive');
    }
    $this->session->set_userdata('succ_approved', 'Mark as Inactive Successfully!');
    redirect('attendances/work_shifts');
  }

  function insrt_work_shift()
  {
    $input_data                           = $this->input->post();
    $input_data['time_regular_start']     = empty($input_data['time_regular_start']) ? '00:00:00' : date("H:i", strtotime($input_data['time_regular_start']));
    $input_data['time_regular_end']       = empty($input_data['time_regular_end']) ? '00:00:00' : date("H:i", strtotime($input_data['time_regular_end']));
    $input_data['time_break_start']       = empty($input_data['time_break_start']) ? '00:00:00' : date("H:i", strtotime($input_data['time_break_start']));
    $input_data['time_break_end']         = empty($input_data['time_break_end']) ? '00:00:00' : date("H:i", strtotime($input_data['time_break_end']));
    $input_data['time_overtime_start']    = empty($input_data['time_overtime_start']) ? '00:00:00' : date("H:i", strtotime($input_data['time_overtime_start']));
    $input_data['time_overtime_end']      = empty($input_data['time_overtime_end']) ? '00:00:00' : date("H:i", strtotime($input_data['time_overtime_end']));
    $input_data['status']                 = 'Active';
    $this->attendance_model->ADD_WORK_SHIFT($input_data);
    //   echo '<pre>';
    //   var_dump($input_data);
    //   return;
    // $code                   = $this->input->post('WRK_SHFT_INPF_CODE');
    // $shift_name             = $this->input->post('WRK_SHFT_INPF_NAME');
    // //$working_hours = $this->input->post('WRK_SHFT_INPF_WORKING_HOURS');
    // $time_in                = date("H:i", strtotime(($this->input->post('WRK_SHFT_INPF_TIME_IN')) ? $this->input->post('WRK_SHFT_INPF_TIME_IN') : "00:00"));
    // $time_out               = date("H:i", strtotime(($this->input->post('WRK_SHFT_INPF_TIME_OUT')) ? $this->input->post('WRK_SHFT_INPF_TIME_OUT') : "00:00"));
    // $time_in_2              = date("H:i", strtotime(($this->input->post('WRK_SHFT_INPF_TIME_IN_2')) ? $this->input->post('WRK_SHFT_INPF_TIME_IN_2') : "00:00"));
    // $time_out_2             = date("H:i", strtotime(($this->input->post('WRK_SHFT_INPF_TIME_OUT_2')) ? $this->input->post('WRK_SHFT_INPF_TIME_OUT_2') : "00:00"));
    // $time_out_w_ot          = date("H:i", strtotime($this->input->post('WRK_SHFT_INPF_TIME_OUT_W_OT')));
    // $color                  = '';
    // $has_next_day           = '';
    // $lunchbreak           = '';
    // // $has_break = '';
    // $day_shift              = $this->input->post('day_shift');
    // $night_shift            = $this->input->post('night_shift');
    // $day_shift_OT           = $this->input->post('day_shift_OT');
    // $night_shift_OT         = $this->input->post('night_shift_OT');
    // $work_hours             = $this->input->post('work_hours');

    // $lunch_break_start      = date("H:i", strtotime(($this->input->post('WRK_SHFT_INPF_LUNCH_BREAK_START')) ? $this->input->post('WRK_SHFT_INPF_LUNCH_BREAK_START') : "00:00" ));
    // $lunch_break_end        = date("H:i", strtotime(($this->input->post('WRK_SHFT_INPF_LUNCH_BREAK_END')) ? $this->input->post('WRK_SHFT_INPF_LUNCH_BREAK_END') : "00:00" ));


    // if ($this->input->post('has_next_day_add') == 'true') {
    //   $has_next_day         = 'true';
    // }
    // else{
    //   $has_next_day         = 'false';
    // }

    // // if ($this->input->post('onehourlunch_add') == 'true') {
    // //   $lunchbreak         = 1;
    // // }
    // // else{
    // //   $lunchbreak         = 0;
    // // }
    // // if ($this->input->post('has_break_time') == 'true') {
    // //   $has_break = 'true';
    // // }
    // if ($this->input->post('shift_color')) {
    //   $color                = $this->input->post('shift_color');
    // } else {
    //   $color                = '#000000';
    // }
    // $status                 = "Active";
    // $this->attendance_model->MOD_INSRT_WRK_SHFT($code, $shift_name, $time_in, $time_out, $time_in_2, $time_out_2, $time_out_w_ot, $has_next_day, $color,$status, $lunch_break_start, $lunch_break_end);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_WRK_SHFT', 'New work shift added successfully!');
    redirect('attendances/work_shifts');
  }



  function edit_work_shift($id)
  {
    $shift_data             = $this->attendance_model->MOD_GET_WRK_SHFT_DATA($id);
    echo json_encode($shift_data);
  }
  function updt_work_shift()
  {
    $input_data                           = $this->input->post();
    $input_data['time_regular_start']     = empty($input_data['time_regular_start']) ? '00:00:00' : date("H:i", strtotime($input_data['time_regular_start']));
    $input_data['time_regular_end']       = empty($input_data['time_regular_end']) ? '00:00:00' : date("H:i", strtotime($input_data['time_regular_end']));
    $input_data['time_break_start']       = empty($input_data['time_break_start']) ? '00:00:00' : date("H:i", strtotime($input_data['time_break_start']));
    $input_data['time_break_end']         = empty($input_data['time_break_end']) ? '00:00:00' : date("H:i", strtotime($input_data['time_break_end']));
    $input_data['time_overtime_start']    = empty($input_data['time_overtime_start']) ? '00:00:00' : date("H:i", strtotime($input_data['time_overtime_start']));
    $input_data['time_overtime_end']      = empty($input_data['time_overtime_end']) ? '00:00:00' : date("H:i", strtotime($input_data['time_overtime_end']));
    $input_data['status']                 = 'Active';
    $response                             = $this->attendance_model->UPDATE_SPE_WORKSHIFT($input_data['id'], $input_data);
    // echo '<pre>';
    // var_dump($input_data);
    // return;
    // $id                     = $this->input->post('WRK_SHFT_INPF_ID');
    // $code                   = $this->input->post('WRK_SHFT_INPF_CODE');
    // $shift_name             = $this->input->post('WRK_SHFT_INPF_NAME');
    // $time_in                = date("H:i", strtotime($this->input->post('WRK_SHFT_INPF_TIME_IN')));
    // $time_out               = date("H:i", strtotime($this->input->post('WRK_SHFT_INPF_TIME_OUT')));
    // $time_in_2              = date("H:i", strtotime($this->input->post('WRK_SHFT_INPF_TIME_IN_2')));
    // $time_out_2             = date("H:i", strtotime($this->input->post('WRK_SHFT_INPF_TIME_OUT_2')));
    // $time_out_w_ot          = date("H:i", strtotime($this->input->post('WRK_SHFT_INPF_TIME_OUT_W_OT')));
    // $color                  = '';
    // $has_next_day           = '';
    // $lunchbreak = '';

    // $lunch_break_start      = date("H:i", strtotime(($this->input->post('WRK_SHFT_INPF_LUNCH_BREAK_START')) ? $this->input->post('WRK_SHFT_INPF_LUNCH_BREAK_START') : "00:00" ));
    // $lunch_break_end        = date("H:i", strtotime(($this->input->post('WRK_SHFT_INPF_LUNCH_BREAK_END')) ? $this->input->post('WRK_SHFT_INPF_LUNCH_BREAK_END') : "00:00" ));

    // if ($this->input->post('next_day_upt') == 'on') {
    //   $has_next_day         = 'true';
    // }
    // else{
    //   $has_next_day         = 'false';
    // }
    // if ($this->input->post('shift_color')) {
    //   $color                = $this->input->post('shift_color');
    // } else {
    //   $color                = '#000000';
    // }

    // // if ($this->input->post('onehourlunch_upt') == "on") {
    // //   $lunchbreak         = 1;
    // // }
    // // else{
    // //   $lunchbreak         = 0;
    // // }

    // $response               = $this->attendance_model->MOD_UPDT_WRK_SHFT($code, $shift_name, $time_in, $time_out, $time_in_2, $time_out_2, $time_out_w_ot, $has_next_day, $color, $id, $lunch_break_start, $lunch_break_end);

    if ($response) {
      $this->session->set_flashdata('SESS_SUCC_MSG_UPDT_WRK_SHFT', 'Work shift updated successfully!');
    } else {
      $this->session->set_flashdata('SESS_ERROR_MSG_UPDT_WRK_SHFT', 'Fail!');
    }
    redirect('attendances/work_shifts');
  }


  // DELETE POSITION
  function dlt_work_shift()
  {
    $work_shift_id          = $this->input->get('delete_id');
    $this->attendance_model->MOD_DLT_WRK_SHFT($work_shift_id);
    $this->session->set_flashdata('SESS_SUCC_MSG_DLT_WRK_SHFT', 'Deleted Successfully!');

    redirect('attendances/work_shifts');
  }
  // Shift Template page actions
  function shift_templates()
  {
    $data['DISP_SHIFTTEMPLATE_INFO']            = $this->attendance_model->MOD_DISP_SHIFTTEMPLATE();
    $data['DISP_WORK_SHIFT']                    = $this->attendance_model->MOD_DISP_WRK_SHFT();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/shift_template_views', $data);
  }
  function insrt_ShiftTemplate()
  {
    $code               = $this->input->post('SHIFTTEMPLATE_INPF_CODE');
    $name               = $this->input->post('SHIFTTEMPLATE_INPF_NAME');
    $monday             = $this->input->post('SHIFTTEMPLATE_INPF_MONDAY');
    $tuesday            = $this->input->post('SHIFTTEMPLATE_INPF_TUESDAY');
    $wednesday          = $this->input->post('SHIFTTEMPLATE_INPF_WEDNESDAY');
    $thursday           = $this->input->post('SHIFTTEMPLATE_INPF_THURSDAY');
    $friday             = $this->input->post('SHIFTTEMPLATE_INPF_FRIDAY');
    $saturday           = $this->input->post('SHIFTTEMPLATE_INPF_SATURDAY');
    $sunday             = $this->input->post('SHIFTTEMPLATE_INPF_SUNDAY');
    $this->attendance_model->MOD_INSRT_SHIFTTEMPLATE($code, $name, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_SHIFTTEMPLATE', 'Added Successfully!');
    redirect('attendances/shift_templates');
  }
  // UPDATE POSITION
  function updt_ShiftTemplate()
  {
    $id                 = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_ID');
    $code               = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_CODE');
    $name               = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_NAME');
    $monday             = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_MONDAY');
    $tuesday            = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_TUESDAY');
    $wednesday          = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_WEDNESDAY');
    $thursday           = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_THURSDAY');
    $friday             = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_FRIDAY');
    $saturday           = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_SATURDAY');
    $sunday             = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_SUNDAY');
    $this->attendance_model->MOD_UPDT_SHIFTTEMPLATE($code, $name, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $id);
    $this->session->set_userdata('SESS_SUCC_MSG_UPDT_SHIFTTEMPLATE', 'Updated Successfully!');
    redirect('attendances/shift_templates');
  }
  // DELETE POSITION
  function dlt_ShiftTemplate()
  {
    $ShiftTemplate_id   = $this->input->get('delete_id');
    $this->attendance_model->MOD_DLT_SHIFTTEMPLATE($ShiftTemplate_id);
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_SHIFTTEMPLATE', 'Deleted Successfully!');
    redirect('attendances/shift_templates');
  }
  // Holidays actions page
  function holidays()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'employee_id', $user]; //all or user
    $data["module_name"]      = $module       = 'attendances';
    $data["page_name"]        = $page_name    = 'holidays';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_std_holidays";
    $data["module"]           = [base_url() . $module, "Attendance", "Holidays"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "HOL";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [false, "holidays.xlsx"];                                                       // Enable, File Name
    // $data["add_button"]       = [true, "Add Holiday"];       
    $data["add_button"]       = [true, false];                                                            // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["", "", "", ""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab             = array(
      array(2023, "year", 2023, 0),
      array(2022, "year", 2022, 0),
      array(2021, "year", 2021, 0)
    );
    $data["C_BULK_BUTTON"]  = array();
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
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
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
  function insrt_holiday()
  {
    $HOLIDAY_INPF_NAME                    = $this->input->post('HOLIDAY_INPF_NAME');
    $HOLIDAY_INPF_DATE                    = $this->input->post('HOLIDAY_INPF_DATE');
    $HOLIDAY_INPF_TYPE                    = $this->input->post('HOLIDAY_INPF_TYPE');
    $this->attendance_model->MOD_INSRT_HOLIDAY($HOLIDAY_INPF_NAME, $HOLIDAY_INPF_DATE, $HOLIDAY_INPF_TYPE);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_HOLIDAY', 'Added Successfully!');
    redirect('attendances/holidays');
  }
  // UPDATE POSITION
  function updt_holiday()
  {
    $UPDT_HOLIDAY_INPF_ID                 = $this->input->post('UPDT_HOLIDAY_INPF_ID');
    $UPDT_HOLIDAY_INPF_NAME               = $this->input->post('UPDT_HOLIDAY_INPF_NAME');
    $UPDT_HOLIDAY_INPF_DATE               = $this->input->post('UPDT_HOLIDAY_INPF_DATE');
    $UPDT_HOLIDAY_INPF_TYPE               = $this->input->post('UPDT_HOLIDAY_INPF_TYPE');
    $this->attendance_model->MOD_UPDT_HOLIDAY($UPDT_HOLIDAY_INPF_NAME, $UPDT_HOLIDAY_INPF_DATE, $UPDT_HOLIDAY_INPF_TYPE, $UPDT_HOLIDAY_INPF_ID);
    $this->session->set_userdata('SESS_SUCC_MSG_UPDT_HOLIDAY', 'Updated Successfully!');
    redirect('attendances/holidays');
  }
  // DELETE POSITION
  function dlt_holiday()
  {
    $holiday_id                           = $this->input->get('delete_id');
    $this->attendance_model->MOD_DLT_HOLIDAY($holiday_id);
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_HOLIDAY', 'Deleted Successfully!');
    redirect('attendances/holidays');
  }
  // Overtime pages actions
  function overtimes()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
    $data["module_name"]      = $module       = 'attendances';
    $data["page_name"]        = $page_name    = 'overtimes';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_overtimes";
    $data["module"]           = [base_url() . $module, "Attendances", "Overtime Requests"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "OVT";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "overtimes.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add Overtimes"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab               = array(
      array("Pending 1", "status", "Pending 1", 0),
      array("Pending 2", "status", "Pending 2", 0),
      array("Pending 3", "status", "Pending 3", 0),
      array("Approved", "status", "Approved", 0),
      array("Rejected", "status", "Rejected", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      //array(true, "btn_mark_approve","far fa-check-circle","Mark as Approved","status","Approved"),    //visible,id,icon,Button Name,column,status
      //array(true, "btn_mark_rejected","far fa-times-circle","Mark as Rejected","status","Rejected")    //visible,id,icon,Button Name,column,status	
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_user", "Last Edited By", "user", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("assigned_by", "Assigned By", "user", "0", 1, 15, 1, 1, 0, 1, 1, 1),
        array("empl_id", "Employee", "user", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("type", "Type", "fixed-sel-direct", "Regular; Night Shift; Rest; Special; Legal; Rest + Special; Rest + Legal", 1, 10, 1, 1, 1, 1, 1, 1),
        array("date_ot", "Shift Type", "date", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("time_out", "Time Out", "time", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("hours", "Overtime Hours", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("reason", "Reason", "text-area", "0", 1, 0, 1, 0, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Pending 1;Pending 2;Pending 3;Approved;Rejected", 1, 15, 1, 0, 0, 1, 0, 1),
        array("comment", "Remarks", "text-area", "0", 1, 0, 1, 0, 1, 1, 1, 1),

      );
    //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
    $search                               = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                  = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]             = $this->$model->get_empl_name();
    // $data["C_ARRAY_1"]                  = $this->$model->get_allowance_name();
    $data["C_ARRAY_2"]                    = [];
    $data["C_BUTTON_ADD"]                 = array('title' => 'Add Overtime', 'path' => base_url('attendances/add_overtime'));
    $page                                 = $this->input->get('page');
    $row                                  = $this->input->get('row');
    $tab                                  = $this->input->get('tab');
    $tab_filter                           = $this->input->get('tab_filter');

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
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
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
  function add_overtime()
  {
    $data['C_EMPLOYEES']              = $this->attendance_model->GET_EMPLOYEELIST();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/add_overtime_views', $data);
  }
  function add_new_overtime()
  {
    $input_data                   = $this->input->post();
    $input_data['create_date']    = date('Y-m-d H:i:s');
    $input_data['edit_date']      = date('Y-m-d H:i:s');
    $res                          = $this->attendance_model->ADD_DATA('tbl_overtimes', $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('attendances/add_overtime');
      return;
    }
    redirect('attendances/overtimes');
  }


  // Holiday Work pages actions
  function holiday_work()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
    $data["module_name"]      = $module       = 'attendances';
    $data["page_name"]        = $page_name    = 'holiday_work';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_holidaywork";
    $data["module"]           = [base_url() . $module, "Attendances", "Holiday Work"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "HOW";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "holiday_work.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add Holiday Work"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab               = array(
      array("Pending 1", "status", "Pending 1", 0),
      array("Pending 2", "status", "Pending 2", 0),
      array("Pending 3", "status", "Pending 3", 0),
      array("Approved", "status", "Approved", 0),
      array("Rejected", "status", "Rejected", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      //array(true, "btn_mark_approve","far fa-check-circle","Mark as Approved","status","Approved"),    //visible,id,icon,Button Name,column,status
      //array(true, "btn_mark_rejected","far fa-times-circle","Mark as Rejected","status","Rejected")    //visible,id,icon,Button Name,column,status	
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_user", "Last Edited By", "user", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("assigned_by", "Assigned By", "user", "0", 1, 15, 1, 1, 0, 1, 1, 1),
        array("empl_id", "Employee", "user", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("date", "Date", "date", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("type", "Type", "fixed-sel-direct", "Regular; Night Shift; Rest; Special; Legal; Rest + Special; Rest + Legal", 1, 10, 1, 1, 1, 1, 1, 1),
        array("hours", "Working Hours", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("reason", "Reason", "text-area", "0", 1, 0, 1, 0, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Pending 1;Pending 2;Pending 3;Approved;Rejected", 1, 15, 1, 0, 0, 1, 0, 1),
        array("comment", "Remarks", "text-area", "0", 1, 0, 1, 0, 1, 1, 1, 1),

      );
    //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
    $search                               = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                  = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]             = $this->$model->get_empl_name();
    // $data["C_ARRAY_1"]                  = $this->$model->get_allowance_name();
    $data["C_ARRAY_2"]                    = [];
    $data["C_BUTTON_ADD"]                 = array('title' => 'Add Holiday Work', 'path' => base_url('attendances/add_holiday_work'));
    $page                                 = $this->input->get('page');
    $row                                  = $this->input->get('row');
    $tab                                  = $this->input->get('tab');
    $tab_filter                           = $this->input->get('tab_filter');

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
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
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
  function add_holiday_work()
  {
    $data['C_EMPLOYEES']              = $this->attendance_model->GET_EMPLOYEELIST();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/add_holiday_work_views', $data);
  }
  function add_new_holiday_work()
  {
    $input_data                   = $this->input->post();
    $input_data['create_date']    = date('Y-m-d H:i:s');
    $input_data['edit_date']      = date('Y-m-d H:i:s');
    $res                          = $this->attendance_model->ADD_DATA('tbl_holidaywork', $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('attendances/add_holiday_work');
      return;
    }
    redirect('attendances/holiday_work');
  }
  function insrt_assign_overtime()
  {
    $employee_id                                    = $this->input->post('EMPLOYEE_ID');
    $assigned_by                                    = $this->session->userdata('SESS_USER_ID');
    $url_directory                                  = $this->input->post('url_directory');
    if ($url_directory == 'assign_overtime') {
      $url_directory                                = 'attendance/assign_overtime';
    } else if ($url_directory == 'overtimes') {
      $url_directory                                = 'attendances/overtimes';
    }
    $overtime_date                                  = $this->input->post('overtime_date');
    $time_out                                       = $this->input->post('time_out');
    // $type = $this->input->post('overtime_type');
    $type                                           = 'Regular OT';
    $num_hours                                      = $this->input->post('num_hours');
    $reason                                         = $this->input->post('reason');
    $status                                         = 'Pending';
    $approval_route                                 = $this->attendance_model->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();
    // for notification
    $empl_group                                     = 'No Group';
    $empl_name                                      = '';
    $empl_info                                      = $this->attendance_model->MOD_DISP_EMPLOYEE($employee_id);
    foreach ($empl_info as $empl_info_row) {
      $empl_group                                   = $empl_info_row->col_empl_group;
      $empl_name                                    = $empl_info_row->col_frst_name . ' ' . $empl_info_row->col_last_name;
    }
    //save the filename of the uploaded file to db
    $ot_id                                          = $this->attendance_model->MOD_INSRT_OVERTIME($overtime_date, $type, $time_out, $num_hours, $reason, $status, $assigned_by, $employee_id);
    if ($ot_id) {
      foreach ($approval_route as $approval_route_row) {
        $my_user_id                                 = $this->session->userdata('SESS_USER_ID');
        if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id)) {
          $this->attendance_model->MOD_UPDT_OT_STATUS_APPR1('Pending', $ot_id);
        }
        if (($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id)) {
          $this->attendance_model->MOD_UPDT_OT_STATUS_APPR2('Pending', $ot_id);
        }
      }
      // save info for notif
      $recievers_arr                                = [];
      $get_ot_approver                              = $this->attendance_model->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();
      if ($get_ot_approver) {
        if ($get_ot_approver[0]->approver1) {
          array_push($recievers_arr, $get_ot_approver[0]->approver1);
        }
        if ($get_ot_approver[0]->approver2) {
          array_push($recievers_arr, $get_ot_approver[0]->approver2);
        }
        if ($get_ot_approver[0]->approver3) {
          array_push($recievers_arr, $get_ot_approver[0]->approver3);
        }
        if ($get_ot_approver[0]->approver4) {
          array_push($recievers_arr, $get_ot_approver[0]->approver4);
        }
        if ($get_ot_approver[0]->approver5) {
          array_push($recievers_arr, $get_ot_approver[0]->approver5);
        }
      }
      $appr_type                                = 'Overtime';
      $reciever                                 = implode(",", $recievers_arr);
      $date_created                             = date('Y-m-d H:i:s');
      $message                                  = 'Assigned Overtime to: ';
      $notif_status                             = 0;
      $requested_by                             = $assigned_by;
      $this->attendance_model->MOD_INSRT_NOTIF_LOGS($employee_id, $empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $ot_id, $requested_by);
      $this->attendance_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by, $message, $appr_type, $date_created, $ot_id, $notif_status);
      $this->session->set_userdata('SESS_SUCC_MSG_INSRT_OVERTIME', 'Over-Time application submitted!');
    } else {
      $this->session->set_userdata('SESS_ERR_MSG_INSRT_OVERTIME', 'Submission Failed!');
    }
    redirect($url_directory);
  }
  function updt_overtime_application()
  {
    $overtime_id                                = $this->input->post('appl_overtime_id');
    $actual_ot_duration                         = $this->input->post('actual_ot_duration');
    $appl_overtime_date                         = $this->input->post('appl_overtime_date');
    $appl_overtime_empl_id                      = $this->input->post('appl_overtime_empl_id');
    $appl_type                                  = $this->input->post('appl_type');
    $empl_id                                    = $this->input->post('appl_overtime_empl_id');
    $this->attendance_model->MOD_UPDT_OVERTIME_APPLICATION($actual_ot_duration, $overtime_id);
    if ($appl_type == 'Regular OT') {
      $this->attendance_model->MOD_UPDT_ATT_REG_OT($actual_ot_duration, $appl_overtime_date, $empl_id);
    } else if ($appl_type == 'Night Shift OT') {
      $this->attendance_model->MOD_UPDT_ATT_ND_OT($actual_ot_duration, $appl_overtime_date, $empl_id);
    } else if ($appl_type == 'Rest OT') {
      $this->attendance_model->MOD_UPDT_ATT_REST_OT($actual_ot_duration, $appl_overtime_date, $empl_id);
    }
    $this->session->set_userdata('success', 'Overtime Application Updated');
    redirect('attendances/overtime');
  }
  // Time Adjustments actions
  function time_adjustment_lists()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'empl_id', $user]; //all or user
    $data["module_name"]      = $module       = 'attendances';
    $data["page_name"]        = $page_name    = 'time_adjustment_lists';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_attendance_adjustments";
    $data["module"]           = [base_url() . $module, "Attendance", "Time Adjustment List"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "ADJ";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "my_time_adjustment.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add Adjustment"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Approved", "Pending", "Rejected", ""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab               = array(
      array("Pending 1", "status", "Pending 1", 0),
      array("Pending 2", "status", "Pending 2", 0),
      array("Pending 3", "status", "Pending 3", 0),
      array("Approved", "status", "Approved", 0),
      array("Rejected", "status", "Rejected", 0)
    );
    $data["C_BULK_BUTTON"]    = array();
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_user", "Last Edited By", "user", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("empl_id", "Employee", "user", "0", 1, 30, 1, 1, 0, 1, 1, 1),
        array("assigned_by", "Assigned By", "user", "0", 1, 15, 1, 1, 0, 1, 1, 1),
        array("date_adjustment", "Adjustment Date", "date", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("shift_type", "Shift Type", "fixed-sel-direct", "REST;DS 8-5;DS 9-6;DS 7-4;SAT 8-2", 1, 10, 1, 1, 1, 1, 1, 1),
        array("time_in_1", "Time&nbsp;In&nbsp;1", "time", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("time_out_1", "Time&nbsp;Out&nbsp;1", "time", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("time_in_2", "Time&nbsp;In&nbsp;2", "time", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("time_out_2", "Time&nbsp;Out&nbsp;2", "time", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("attachment", "Attachment", "attachment", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("reason", "Reason", "text-area", "0", 0, 0, 1, 1, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Pending 1;Pending 2;Pending 3;Approved;Rejected", 1, 15, 1, 0, 0, 1, 0, 1),
        array("remarks", "Remarks", "text-area", "0", 0, 0, 1, 1, 1, 1, 1, 1),
      );


    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";
    //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
    $search                               = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                  = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]             = $this->$model->get_empl_name();
    $data["C_ARRAY_1"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
    $data["C_ARRAY_2"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
    $data["C_ARRAY_3"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
    $data["C_ARRAY_4"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
    $data["C_ARRAY_5"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);
    $data["C_BUTTON_ADD"]                 = array('title' => 'Add Adjustment', 'path' => base_url('attendances/add_time_adjustment'));

    $page                                 = $this->input->get('page');
    $row                                  = $this->input->get('row');
    $tab                                  = $this->input->get('tab');
    if ($row == null) {
      $row = $filter_row[0];
    }
    if ($tab == null) {
      $tab = $c_data_tab[0][0];
    }
    $offset = $row * ($page - 1);
    $data["C_TAB_SELECT"] = $tab;
    $tab_filter = 'status';
    if ($this->input->get('all') == null) {
      $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
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
  function add_time_adjustment()
  {
    $data['C_EMPLOYEES']              = $this->attendance_model->GET_EMPLOYEELIST();
    $data['C_SHIFT_TYPES']            = $this->attendance_model->GET_SHIFT_ALL_DATA();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/add_time_adjustment_views', $data);
  }
  function add_new_time_adjustments()
  {
    $input_data                   = $this->input->post();
    $attachment                   = $_FILES['attachment']['name'];
    $file_info = pathinfo($attachment);
    $input_data['create_date']    = date('Y-m-d H:i:s');
    $input_data['edit_date']      = date('Y-m-d H:i:s');
    $input_data['attachment']     = $attachment;
    if (!empty($attachment)) {
      $res = $this->upload_file('./assets_user/files/attendances/');
      if (!$res) {
        redirect('attendances/add_time_adjustment');
        return;
      }
    }
    $res = $this->attendance_model->ADD_DATA('tbl_attendance_adjustments', $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('attendances/add_time_adjustment');
      return;
    }
    redirect('attendances/time_adjustment_lists');
  }
  function upload_file($path)
  {
    $config['upload_path']          = $path;
    $config['max_size']             = 10000;
    $config['allowed_types']        = '*';
    $config['overwrite']            = 'TRUE';
    $this->load->library('upload', $config);
    if (!$this->upload->do_upload('attachment')) {
      $error = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('ERR', $error['error']);

      // var_dump($error);
      return false;
    }
    return true;
  }
  function table_record()
  {
    //filter period
    $cut_off_period                           = $this->input->get('cut_off');
    $data['C_SUMINAC_REC']                    = $this->attendance_model->GET_ATTE_SUMINAC_REC($cut_off_period);
    $data['C_EMP_NAME']                       = $this->attendance_model->GET_EMPLOYEE_NAME();
    $data['C_PAY_SCHED']                      = $this->attendance_model->GET_PAY_SCHED();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/table_record_views', $data);
  }
  // Approval route actions
  function approval_routes()
  {
    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    if (!isset($_GET["branch"])) {
      $param_branch                           = "all";
    } else {
      $param_branch                           = $_GET["branch"];
    }
    if (!isset($_GET["dept"])) {
      $param_dept                             = "all";
    } else {
      $param_dept                             = $_GET["dept"];
    }
    if (!isset($_GET["division"])) {
      $param_division                         = "all";
    } else {
      $param_division                         = $_GET["division"];
    }
    if (!isset($_GET["section"])) {
      $param_section                          = "all";
    } else {
      $param_section                          = $_GET["section"];
    }
    if (!isset($_GET["group"])) {
      $param_group                            = "all";
    } else {
      $param_group                            = $_GET["group"];
    }
    if (!isset($_GET["team"])) {
      $param_team                             = "all";
    } else {
      $param_team                             = $_GET["team"];
    }
    if (!isset($_GET["line"])) {
      $param_line                             = "all";
    } else {
      $param_line                             = $_GET["line"];
    }
    if (!isset($_GET["status"])) {
      $param_status                           = "all";
    } else {
      $param_status                           = $_GET["status"];
    }

    $data["C_ROW_DISPLAY"]                    =  [25, 50, 100];
    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    if ($row == null) {
      $row                                    = 25;
    }
    if ($page  == null) {
      $page                                   = 1;
    }
    $offset = $row * ($page - 1);

    $data['DISP_EMPLOYEES_NONFILTERED']       = $leave_approvers = $this->attendance_model->GET_EMPLOYEELIST();

    if ($this->input->get('all') == null) {
      $data['DISP_EMPLOYEES']                 = $leave_approvers = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_2($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
      $data['C_DATA_COUNT']                   = $this->attendance_model->GET_COUNT_EMPLOYEELIST();
    } else {
      $data['DISP_EMPLOYEES']                 = $leave_approvers = $this->attendance_model->GET_SEARCHED($search);
      $data['C_DATA_COUNT']                   = count($this->attendance_model->GET_SEARCHED($search));
    }

    $C_APPROVERS = array();
    // $leave_approvers              = $this->attendance_model->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();
    $approval_list                            = $this->attendance_model->MOD_DISP_APPR_ROUT_LIST();

    $i = 0;
    foreach ($leave_approvers as $leave_approvers_ROW) {
      $C_APPROVERS[$i]["id"]         = $leave_approvers_ROW->id;
      $C_APPROVERS[$i]["approver1A"] = "N/A";
      $C_APPROVERS[$i]["approver1B"] = "N/A";
      $C_APPROVERS[$i]["approver2A"] = "N/A";
      $C_APPROVERS[$i]["approver2B"] = "N/A";
      $C_APPROVERS[$i]["approver3A"] = "N/A";
      $C_APPROVERS[$i]["approver3B"] = "N/A";

      foreach ($approval_list as $approval_list_ROW) {
        if ($leave_approvers_ROW->id == $approval_list_ROW->empl_id) {
          $C_APPROVERS[$i]["approver1A"] = $approval_list_ROW->approver_1a;
          $C_APPROVERS[$i]["approver1B"] = $approval_list_ROW->approver_1b;
          $C_APPROVERS[$i]["approver2A"] = $approval_list_ROW->approver_2a;
          $C_APPROVERS[$i]["approver2B"] = $approval_list_ROW->approver_2b;
          $C_APPROVERS[$i]["approver3A"] = $approval_list_ROW->approver_3a;
          $C_APPROVERS[$i]["approver3B"] = $approval_list_ROW->approver_3b;
        }
      }
      $i++;
    }


    $data['DISP_APPROVER'] =  $C_APPROVERS;
    $data['DISP_DISTINCT_BRANCH']     = $this->attendance_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT'] = $this->attendance_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']   = $this->attendance_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_SECTION']    = $this->attendance_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']      = $this->attendance_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']       = $this->attendance_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']       = $this->attendance_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_BRANCH']         = $this->attendance_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']     = $this->attendance_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']       = $this->attendance_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION']        = $this->attendance_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']          = $this->attendance_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']           = $this->attendance_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']           = $this->attendance_model->GET_SYSTEM_SETTING("com_line");

    $this->load->view('templates/header');
    $this->load->view('modules/attendances/approval_route_views', $data);
  }

  function zkteco_attendance()
  {
    $data["C_ROW_DISPLAY"]                    =  [25, 50, 100];

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    if ($row == null) {
      $row                                    = 25;
    }
    if ($page  == null) {
      $page                                   = 1;
    }
    $offset = $row * ($page - 1);

    $data["C_EMPLOYEE"]                       = $this->attendance_model->GET_ALL_EMPLOYEES();
    $data['C_DATA_COUNT']                     = $this->attendance_model->GET_COUNT_ZKTECO_RECORDS();
    $data['DISP_ATTENDANCE']                  = $this->zkteco_attendance_data($offset, $row);

    // $data['DISP_ATTENDANCE']                = $this->attendance_model->GET_ZKTECO_RECORDS($offset,$row);
    // $data['C_BIOMETICS']                    = $this->attendance_model->GET_ALL_BIOMETRICS();

    $this->load->view('templates/header');
    $this->load->view('modules/attendances/zkteco_attendance_views', $data);
  }

  function zkteco_code()
  {

    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");

    if (!isset($_GET["branch"])) {
      $param_branch   = "all";
    } else {
      $param_branch    = $_GET["branch"];
    }
    if (!isset($_GET["dept"])) {
      $param_dept     = "all";
    } else {
      $param_dept      = $_GET["dept"];
    }
    if (!isset($_GET["division"])) {
      $param_division = "all";
    } else {
      $param_division  = $_GET["division"];
    }
    if (!isset($_GET["section"])) {
      $param_section  = "all";
    } else {
      $param_section   = $_GET["section"];
    }
    if (!isset($_GET["group"])) {
      $param_group    = "all";
    } else {
      $param_group     = $_GET["group"];
    }
    if (!isset($_GET["team"])) {
      $param_team     = "all";
    } else {
      $param_team      = $_GET["team"];
    }
    if (!isset($_GET["line"])) {
      $param_line     = "all";
    } else {
      $param_line      = $_GET["line"];
    }
    if (!isset($_GET["status"])) {
      $param_status   = "all";
    } else {
      $param_status    = $_GET["status"];
    }
    $data["C_ROW_DISPLAY"]                   =  [25, 50, 100];

    $page                   = $this->input->get('page');
    $row                    = $this->input->get('row');
    if ($row == null) {
      $row                    = 25;
    }
    if ($page  == null) {
      $page                   = 1;
    }
    $offset = $row * ($page - 1);

    if ($this->input->get('all') == null) {
      $data['DISP_EMP_LIST']                  = $empl_list = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_3($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
      $data['C_DATA_COUNT']                   = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
    } else {
      $data['DISP_EMP_LIST']                  = $this->attendance_model->GET_SEARCHED_3($search);
      $data['C_DATA_COUNT']                   = count($this->attendance_model->GET_SEARCHED_3($search));
    }

    // $data['DISP_YEARS']        		        = $year_list = $this->attendance_model->GET_YEARS();
    // $data["DISP_DEDUCTION_TYPES"] 		= $this->attendance_model->GET_TAXABLE_DEDUCTION_TYPES();

    $data['DISP_DISTINCT_DEPARTMENT']       = $this->attendance_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']         = $this->attendance_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_SECTION']          = $this->attendance_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_BRANCH']           = $this->attendance_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_GROUP']            = $this->attendance_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']             = $this->attendance_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']             = $this->attendance_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_DEPARTMENT']           = $this->attendance_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']             = $this->attendance_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION']              = $this->attendance_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_BRANCH']               = $this->attendance_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_GROUP']                = $this->attendance_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                 = $this->attendance_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                 = $this->attendance_model->GET_SYSTEM_SETTING("com_line");

    $this->load->view('templates/header');
    $this->load->view('modules/attendances/zkteco_code_views', $data);
  }

  function process_code_update($id, $empl_id, $code)
  {

    if ($code == 'null' || $code == null) {
      $this->session->set_userdata("SESS_EMPTY_MSG", "Employee code is required!");
      if (isset($_SERVER["HTTP_REFERER"])) {
        redirect($_SERVER["HTTP_REFERER"]);
      }
      return;
    }

    $empl_response                          = $this->attendance_model->IS_DUPLICATE_CMID($empl_id);
    $code_response                          = $this->attendance_model->IS_DUPLICATE_CODE($code);


    if ($code_response > 0) {
      $this->session->set_userdata('SESS_ERROR_MSG', "Employee code already exists!");
      if (isset($_SERVER["HTTP_REFERER"])) {
        redirect($_SERVER["HTTP_REFERER"]);
      }
      return;
    }


    if ($empl_response > 0) {
      $this->attendance_model->UPDATE_EMPL_CODE($id, $empl_id, $code);
    } else {
      $this->attendance_model->INSERT_EMPL_CODE($id, $empl_id, $code);
    }

    $this->session->set_userdata('SESS_SUCCESS_MSG', "Employee code is updated successfully!");
    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }

  function zkteco_attendance_data($offset, $row)
  {

    $attendance                             = $this->attendance_model->GET_ZKTECO_RECORDS($offset, $row);
    $biometrics                             = $this->attendance_model->GET_ALL_BIOMETRICS();
    $employees                              = $this->attendance_model->GET_ALL_EMPLOYEES();
    // $code                                   = $this->attendance_model->GET_ALL_EMPLOYEES();
    $result                                 = [];
    $index                                  = 0;

    foreach ($attendance  as $attendance_row) {

      $result[$index]["id"]                       = $attendance_row->id;
      $result[$index]["empl_id"]                  = $attendance_row->emp_code;
      $result[$index]["punch_time"]               = $attendance_row->punch_time;
      $result[$index]["punch_state"]              = $attendance_row->punch_state;
      $result[$index]["terminal_sn"]              = strtoupper($attendance_row->terminal_sn);
      foreach ($employees as $employee_row) {

        $code_id = $this->attendance_model->GET_ZKTECO_CODE($attendance_row->emp_code);
        // var_dump($employee_row->id);
        if ($code_id == $employee_row->id) {
          $result[$index]["employee_name"]              = $employee_row->col_last_name . ', ' . $employee_row->col_frst_name . ' ' . $employee_row->col_midl_name;
        }
      }

      // foreach ($biometrics as $biometrics_row) {
      //   if ($attendance_row->terminal_sn == $biometrics_row->terminal_sn) {
      //     $result[$index]["terminal_sn"]              =  $biometrics_row->name;
      //   }
      // }
      $index++;
    }

    return $result;
  }


  function csv_import()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/approval_csv_import_views');
  }

  function add_approval()
  {
    $data['DISP_EMPLOYEES']               = $this->attendance_model->MOD_DISP_ALL_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/add_approval_views', $data);
  }

  function add_approval_data()
  {
    $emp_id               = $this->input->post('insrt_name');
    $app1a                = $this->input->post('insrt_approver_1a');
    $app1b                = $this->input->post('insrt_approver_1b');
    $app2a                = $this->input->post('insrt_approver_2a');
    $app2b                = $this->input->post('insrt_approver_2b');
    $app3a                = $this->input->post('insrt_approver_3a');
    $app3b                = $this->input->post('insrt_approver_3b');

    $this->attendance_model->MOD_INSERT_APPROVER_DATA($emp_id, $app1a, $app1b, $app2a, $app2b, $app3a, $app3b);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPROVER', "Approval Route Added Successfully!");

    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }

  function get_approval_route_ot_adj()
  {
    $approval_id        = $this->input->post('approval_id');
    $data               = $this->attendance_model->MOD_DISP_APPR_ROUTE_OT_ADJ($approval_id);
    echo (json_encode($data));
  }
  function assign_approvers_ot_adj()
  {
    $date               = date("Y-m-d H:i:s");
    $empl_id            = $this->input->post('APPROVAL_ID');
    $approver1a         = $this->input->post('UPDT_APPROVER1a');
    $approver1b         = $this->input->post('UPDT_APPROVER1b');
    $approver2a         = $this->input->post('UPDT_APPROVER2a');
    $approver2b         = $this->input->post('UPDT_APPROVER2b');
    $approver3a         = $this->input->post('UPDT_APPROVER3a');
    $approver3b         = $this->input->post('UPDT_APPROVER3b');

    $empl_ids           = explode(",", $empl_id);

    foreach ($empl_ids as $id) {

      $result           = $this->attendance_model->GET_OVERTIME_APPROVER($id);

      if ($result) {
        $this->attendance_model->MOD_UPDT_OVERTIME_APPROVER($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b, $id);
      } else {

        $this->attendance_model->MOD_INSERT_OVERTIME_APPROVER($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b, $id);
      }
    }
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPROVER', "Approval Route Updated Successfully!");

    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }
  // End function page here
  // Other functions
  function get_employee_all_ampl_data()
  {
    $sample_var         = $this->input->post('empl_cmid');
    $data               = $this->attendance_model->MOD_DISP_EMPL_INFO_BIOM();
    echo (json_encode($data));
  }
  //-------------------------------------------------------- CRUD FUNCTIONS starts
  function get_data_all_list()
  {
    $model              = $this->input->post('model_name');
    $table              = $this->input->post('table_name');
    $modal_id           = $this->input->post('modal_id');
    $data               = $this->$model->get_data_row($table, $modal_id);
    echo (json_encode($data));
  }
  function show_data()
  {
    $data["model_name"]       = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"] = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_show', $data);
  }
  function edit_data()
  {
    $data["model_name"]       = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"] = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_edit', $data);
  }
  function ADD_DATA()
  {
    $data["model_name"]       = $model  = "main_table_01_model";
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_add', $data);
  }
  function edit_row()
  {
    $edit_user                = $this->session->userdata('SESS_USER_ID');
    $input_data               = $this->input->get();
    $set_array = array();
    foreach ($input_data as $key => $value) {
      if ($key == "id") {
        $id = $value;
      } else if ($key == "table") {
        $table = $value;
      } else if ($key == "module") {
        $module_name = $value;
      } else if ($key == "page") {
        $page_name = $value;
      } else {
        $set_array[$key]      = $value;
      }
    }
    $set_array['edit_user']   = $edit_user;
    $this->main_table_01_model->edit_table_row($table, $id, $set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function add_row()
  {
    $edit_user                = $this->session->userdata('SESS_USER_ID');
    $input_data               = $this->input->get();
    $set_array                = array();
    foreach ($input_data as $key => $value) {
      if ($key == "table") {
        $table = $value;
      } else if ($key == "module") {
        $module_name = $value;
      } else if ($key == "page") {
        $page_name = $value;
      } else {
        $set_array[$key] = $value;
      }
    }
    $set_array['edit_user']   = $edit_user;
    $this->main_table_01_model->add_table_row($table, $set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function delete_row()
  {
    $edit_user                = $this->session->userdata('SESS_USER_ID');
    $id                       = $this->input->get('delete_id');
    $table                    = $this->input->get('table');
    $module_name              = $this->input->get('module');
    $page_name                = $this->input->get('page');
    $this->main_table_01_model->delete_table_row($id, $table, $edit_user);
    $this->session->set_userdata('delete', 'Deleted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function edit_bulk_status()
  {
    $edit_user              = $this->session->userdata('SESS_USER_ID');
    $status                 = $this->input->post('modal_title');
    $ids                    = $this->input->post('list_mark_ids');
    $ids_int                = array_map('intval', explode(',', $ids));
    $module_name            = $this->input->get('module');
    $page_name              = $this->input->get('page_name');
    $table                  = $this->input->get('table');
    $page                   = $this->input->get('page');
    $row_url                = '&row=';
    $row                    = $this->input->get('row');
    $tab                    = $this->input->get('tab');
    if ($page == null) {
      $page = 1;
    }
    if ($row == null) {
      $row_url = '';
      $row = '';
    }
    if ($tab == null) {
      $tab = "all";
    }
    // var_dump($status . $ids );
    $this->main_table_01_model->edit_bulk_status($table, $status, $ids_int, $edit_user);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    //  var_dump($ids_int);
    redirect($module_name . '/' . $page_name . '?page=' . $page . $row_url . $row . '&tab=' . $tab);
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
