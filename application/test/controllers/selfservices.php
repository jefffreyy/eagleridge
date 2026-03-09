<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class selfservices extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('templates/main_nav_model');
    $this->load->model('templates/main_table_01_model');
    $this->load->model('templates/main_table_02_model');
    $this->load->model('modules/selfservices_model');
    $this->load->model('modules/employees_model');
    $this->load->model('modules/companies_model');
    $this->load->model('login/login_model');

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
      array("title" => "My Profile",                "icon" => "fa-duotone fa-address-card",             "url" => "selfservices/my_profile_personal",          "access" => "Self-Service", "id" => "my_profile"),
      array("title" => "My Team",                   "icon" => "fa-duotone fa-people-group",             "url" => "selfservices/my_teams",                     "access" => "Self-Service", "id" => "my_team"),
      array("title" => "My Calendar",               "icon" => "fa-duotone fa-calendar-range",           "url" => "selfservices/my_calendars",                 "access" => "Self-Service", "id" => "my_calendar"),
      array("title" => "My Tasks",                  "icon" => "fa-duotone fa-diagram-subtask",          "url" => "selfservices/my_tasks",                     "access" => "Self-Service", "id" => "my_tasks"),
      array("title" => "My Attendance Record",      "icon" => "fa-duotone fa-chess-clock",              "url" => "selfservices/my_time_records",              "access" => "Self-Service", "id" => "my_time_records"),
      array("title" => "Remote Attendance",         "icon" => "fa-duotone fa-map-location-dot",         "url" => "selfservices/my_time_in_outs",              "access" => "Self-Service", "id" => "my_time_in_outs"),
      array("title" => "My Time Adjustments",       "icon" => "fa-duotone fa-rotate",                   "url" => "selfservices/my_time_adjustments",          "access" => "Self-Service", "id" => "my_time_adjustments"),
      array("title" => "My Leaves",                 "icon" => "fa-duotone fa-house-person-leave",       "url" => "selfservices/my_leaves",                    "access" => "Self-Service", "id" => "my_leaves"),
      array("title" => "My Overtimes",              "icon" => "fa-duotone fa-gauge-max",                "url" => "selfservices/my_overtimes",                 "access" => "Self-Service", "id" => "my_overtimes"),
      array("title" => "My Holiday Work",           "icon" => "fa-duotone fa-car-building",             "url" => "selfservices/my_holiday_work",              "access" => "Self-Service", "id" => "my_holiday_work"),
      array("title" => "My Payslips",               "icon" => "fa-duotone fa-file-invoice",             "url" => "selfservices/my_payslips",                  "access" => "Self-Service", "id" => "my_payslips"),
      array("title" => "My Support Requests",       "icon" => "fa-duotone fa-comments-question-check",  "url" => "selfservices/my_support_requests",          "access" => "Self-Service", "id" => "my_support_requests"),
      array("title" => "My Complaints",             "icon" => "fa-duotone fa-person-sign",              "url" => "selfservices/my_complaints",                "access" => "Self-Service", "id" => "my_complaints"),
      array("title" => "My Warnings",               "icon" => "fa-duotone fa-circle-exclamation",       "url" => "selfservices/my_warnings",                  "access" => "Self-Service", "id" => "my_warnings"),
      array("title" => "My Trainings",              "icon" => "fas fa-laptop",                          "url" => "selfservices/my_trainings",                 "access" => "Self-Service", "id" => "my_trainings"),
      array("title" => "My Onboardings",            "icon" => "fas fa-sign-in-alt",                     "url" => "selfservices/my_onboardings",               "access" => "Self-Service", "id" => "my_onboardings"),
      array("title" => "My Offboardings",           "icon" => "fas fa-sign-in-alt",                     "url" => "selfservices/my_offboardings",              "access" => "Self-Service", "id" => "my_offboardings"),
      array("title" => "My Survey",                 "icon" => "fa  fa-file-text",                       "url" => "selfservices/my_surveys",                   "access" => "Self-Service", "id" => "my_surveys"),
      array("title" => "Activity Logs",             "icon" => "fa  fa-file-text",                       "url" => "selfservices/activity_logs",                "access" => "Self-Service", "id" => "activity_logs"),
      array("title" => "Notifications",             "icon" => "fa-duotone fa-light-emergency-on",       "url" => "selfservices/notifications",                "access" => "Self-Service", "id" => "notifications"),
      array("title" => "Leave Approval",            "icon" => "fa-duotone fa-plane-circle-check",       "url" => "selfservices/leave_approval",               "access" => "Self-Service", "id" => "leave_approval"),
      array("title" => "Overtime Approval",         "icon" => "fa-duotone fa-person-circle-check",      "url" => "selfservices/overtime_approval",            "access" => "Self-Service", "id" => "overtime_approval"),
      array("title" => "Holiday Work Approval",     "icon" => "fa-duotone fa-car-building",             "url" => "selfservices/holidaywork_approval",         "access" => "Self-Service", "id" => "holidaywork_approval"),
      array("title" => "Time Adjustment Approval",  "icon" => "fa-duotone fa-reply-clock",              "url" => "selfservices/time_adjustment_approval",     "access" => "Self-Service", "id" => "time_adjustment_approval"),
    );

    $data["title_page"]                 = "Self-services Module";
    $user_access_id                     = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE']      = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
    $array_page                         = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
    $data['Modules']                    = filter_array($data["Modules"], $array_page);
    $this->load->view('templates/header');
    $this->load->view('templates/main_nav', $data);
    
  }
  function activity_logs()
  {
    $data['C_ACTIVITIES']               = $this->selfservices_model->GET_ACTIVITY_LOGS($this->session->userdata('SESS_USER_ID'));
    $data['C_EMPLOYEES_ID']             = $this->selfservices_model->GET_EMPLOYEE_IDS();
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/activity_log_views', $data);
    
  }
  
  function notifications()
  {
    $data['C_NOTIFICATION']             = $this->selfservices_model->GET_NOTIFICATIONS();
    $data['C_EMPLOYEES_ID']             = $this->selfservices_model->GET_EMPLOYEE_IDS();
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/notification_views', $data);
    
  }
  function my_profile_personal()
  {

    $employee_id                        = $this->session->userdata('SESS_USER_ID');

    $data["C_COM_STRUCTURE"]            = $this->selfservices_model->GET_COMP_STRUCTURE();

    $data['C_TYPE']                     = $this->selfservices_model->GET_TYPE();
    $data['C_POSITIONS']                = $this->selfservices_model->GET_POSITION();
    $data['C_BRANCH']                   = $this->selfservices_model->GET_BRANCHES();
    $data['C_DEPARTMENTS']              = $this->selfservices_model->GET_DEPARTMENTS();
    $data['C_DIVISIONS']                = $this->selfservices_model->GET_DIVISIONS();
    $data['C_SECTIONS']                 = $this->selfservices_model->GET_SECTIONS();
    $data['C_GROUPS']                   = $this->selfservices_model->GET_GROUPS();
    $data['C_GENDERS']                  = $this->selfservices_model->GET_GENDERS();
    $data['C_NATIONALITY']              = $this->selfservices_model->GET_NATIONALITY();
    $data['C_MARITAL']                  = $this->selfservices_model->GET_MARITAL();
    $data['C_SHIRT_SIZE']               = $this->selfservices_model->GET_SHIRT_SIZE();
    $data['C_HMO']                      = $this->selfservices_model->GET_HMO();
    $data['C_LINES']                    = $this->selfservices_model->GET_LINES();
    $data['C_TEAMS']                    = $this->selfservices_model->GET_TEAMS();
    $data['C_EDUCATION']                = $this->selfservices_model->GET_EDUCATION_SPECIFIC($employee_id);
    $data['C_SKILLS_MATRIX']            = $this->selfservices_model->GET_SKILL_MATRIX_SPECIFIC($employee_id);
    $data['C_SKILLS_NAME']              = $this->selfservices_model->GET_SKILL_NAME();
    $data['C_SKILLS_LEVEL']             = $this->selfservices_model->GET_SKILL_LEVEL();

    $data['C_EMP_INFO']                 = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC($employee_id);
    $data['C_DEPENDENTS']               = $this->selfservices_model->GET_DEPENDENTS_SPECIFIC($employee_id);
    $data['C_EMERGENCY']                = $this->selfservices_model->GET_EMERGENCY_SPECIFIC($employee_id);
    $data['C_DOCUMENTS']                = $this->selfservices_model->GET_DOCUMENTS_SPECIFIC($employee_id);

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_profile_personal_views', $data);
    
  }
  function change_password()
  {
    // $this->load->library('email');
    // $this->email->from('nutsudragneel50@gmail.com', 'Aldrin');
    // $this->email->to('aldrinlobis1@gmail.com');
    // $this->email->subject('Password Reset');
    // $new_password = random_string('alnum', 8);
    // $this->email->message('Your new password is: '.$new_password);
    // $this->email->send();
    $this->load->view('modules/selfservices/change_password_views');
  }
  function submit_new_password()
  {
    $user_id              = $this->input->post('user_id');
    $current_pass         = $this->input->post('current_password');
    $new_password         = $this->input->post('new_password');
    $retype_password      = $this->input->post('retype_password');
    $pass_key             = $this->selfservices_model->GET_USER_PASSWORD_KEYS($user_id);
    if ($pass_key->col_user_pass != md5($current_pass . '' . $pass_key->col_salt_key)) {
      $this->session->set_userdata("SESS_ERR_PASSWORD", "Incorrent Current Password");
      redirect('selfservices/change_password');
    }
    if ($new_password == $retype_password) {
      if (preg_match('/[\^£$%&*()}{#~?><>,|=+¬-]/', $new_password)) {
        $this->session->set_userdata("SESS_ERR_PASSWORD", "Invalid Password only '@','_', and '.' are permitted");
        redirect('selfservices/change_password');
      } else {

        $this->selfservices_model->MOD_CHANGE_PASSWORD($new_password, $user_id);
        $this->session->set_flashdata('SESS_SUCC_MSG', 'Successfully change password!');
        redirect('selfservices/my_profile_personal');
      }
    } else {
      $this->session->set_userdata("SESS_ERR_PASSWORD", "Password does not match");
      redirect('selfservices/change_password');
    }
  }
  function my_teams()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_team_views');
    
  }
  function setup_my_teams(){
        if (!isset($_GET["branch"]))    { $param_branch   = "all"; }  else{$param_branch    = $_GET["branch"];}
        if (!isset($_GET["dept"]))      { $param_dept     = "all"; }  else{$param_dept      = $_GET["dept"];}
        if (!isset($_GET["division"]))  { $param_division = "all"; }  else{$param_division  = $_GET["division"];}
        if (!isset($_GET["section"]))   { $param_section  = "all"; }  else{$param_section   = $_GET["section"];}
        if (!isset($_GET["group"]))     { $param_group    = "all"; }  else{$param_group     = $_GET["group"];}
        if (!isset($_GET["team"]))      { $param_team     = "all"; }  else{$param_team      = $_GET["team"];}
        if (!isset($_GET["line"]))      { $param_line     = "all"; }  else{$param_line      = $_GET["line"];}
        if (!isset($_GET["status"]))    { $param_status   = "all"; }  else{$param_status    = $_GET["status"];}

        $data["C_ROW_DISPLAY"]                    =  [25,50,100];
        $page                                     = $this->input->get('page');
        $row                                      = $this->input->get('row');
        if ($row == null) {
        $row = 25;
        }
        if($page  == null){
        $page = 1;
        }
        $offset = $row * ($page - 1);

        $data['DISP_EMP_LIST']                    = $empl_list = $this->selfservices_model->GET_FILTERED_EMPLOYEELIST($offset,$row,$param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
        $data['ALL_EMPLOYEES']                    = $this->companies_model->GET_ALL_EMPLOYEES();
        $data['DISP_YEARS']        		            = $year_list = $this->employees_model->GET_YEARS();
        // $data['C_DATA_COUNT']                   = $this->employees_model->GET_COUNT_EMPLOYEELIST();
        $data['C_DATA_COUNT']                     = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
        (!isset($_GET["year"])) ? $year           = $year_list[0]->id : $year = $_GET["year"];
     
        $data['YEAR_INITIAL']                     = $year;
        $data["DISP_ALLOWANCE"]		                = $this->employees_model->GET_ALLOWANCE_TAX_DATA($year);

        $data['DISP_DISTINCT_DEPARTMENT']         = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
        $data['DISP_DISTINCT_DIVISION']           = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
        $data['DISP_DISTINCT_SECTION']            = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
        $data['DISP_DISTINCT_BRANCH']             = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
        $data['DISP_DISTINCT_GROUP']              = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
        $data['DISP_DISTINCT_TEAM']               = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
        $data['DISP_DISTINCT_LINE']               = $this->employees_model->MOD_DISP_DISTINCT_LINE();   
    
        $data['DISP_VIEW_DEPARTMENT']             = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
        $data['DISP_VIEW_DIVISION']               = $this->employees_model->GET_SYSTEM_SETTING("com_division");
        $data['DISP_VIEW_SECTION']                = $this->employees_model->GET_SYSTEM_SETTING("com_section");
        $data['DISP_VIEW_BRANCH']                 = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
        $data['DISP_VIEW_GROUP']                  = $this->employees_model->GET_SYSTEM_SETTING("com_group");
        $data['DISP_VIEW_TEAM']                   = $this->employees_model->GET_SYSTEM_SETTING("com_team");
        $data['DISP_VIEW_LINE']                   = $this->employees_model->GET_SYSTEM_SETTING("com_line");
        $this->load->view('templates/header');
        $this->load->view('modules/selfservices/setup_my_team_views',$data);
  }
  function update_my_teams(){
        $ids                      = explode(",", $this->input->post('employee_ids'));
        $action                   = $this->input->post('action');
        $reporting_to             = $this->session->userdata('SESS_USER_ID');
        if($action=='remove'){
            $reporting_to='';
        }
        $res                      = $this->selfservices_model->UPDATE_MY_TEAM($ids,$reporting_to);
        redirect('selfservices/setup_my_teams');
  }
  // Calendar
  function my_calendars()
  {
    $data["TITLE"]                  = "My Calendar";
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_calendar_views', $data);
    
  }
  function fetch_data()
  {

    $data["HOLIDAYS_INFO"]          = $this->selfservices_model->FETCH_HOLIDAYS();
    // $data['EVENTS_INFO']             = $this->selfservices_model->FETCH_EVENTS();
    $data['EVENTS_INFO']            =[];
    $data['TASK_INFO']              = $this->selfservices_model->FETCH_TASKS($this->session->userdata('SESS_USER_ID'));
    $data['MY_SCHEDULE']            = $this->selfservices_model->FETCH_MY_SCHEDULE($this->session->userdata('SESS_USER_ID'));
    // echo '<pre>';
    // var_dump($data);
    echo json_encode($data);
  }

  // End Calendar

  function leave_approval()
  {
    $user_id                        = $this->session->userdata('SESS_USER_ID');
    $data["C_ROW_DISPLAY"]                    =  [25,50,100];

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    if ($row == null) {
    $row = 25;
    }
    if($page  == null){
    $page = 1;
    }
    $offset = $row * ($page - 1);

    $data['DISP_EMPLOYEES']                   = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $data['DISP_TYPES']                       = $this->selfservices_model->GET_ALL_LEAVETYPES();
    $data['DISP_SHIFT']                       = $this->selfservices_model->GET_LEAVE_APPROVALS($user_id,$offset,$row);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_COUNT_LEAVE_APPROVALS($user_id));

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_leaves_assign');
    
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/leave_approval_views', $data);
    
  }

  function time_adjustment_approval(){
    $user_id                                  = $this->session->userdata('SESS_USER_ID');
    $data["C_ROW_DISPLAY"]                    =  [25,50,100];

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    if ($row == null) {
    $row = 25;
    }
    if($page  == null){
    $page = 1;
    }
    $offset = $row * ($page - 1);

    $data['DISP_EMPLOYEES']                   = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $data['DISP_TIME_ADJUSTMENT']             = $this->selfservices_model->GET_TIME_ADJUSTMENT_APPROVALS($user_id,$offset,$row);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_COUNT_TIME_ADJUSTMENT_APPROVALS($user_id));

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_attendance_adjustments');
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/time_adjustment_approval_views',$data);
    

  }

  function insert_approved_time_adjustment($id){

    $time_adj                         = $this->selfservices_model->GET_APPROVED_TIME_ADJUSTMENT($id);
    $attendance_shift                 = $this->selfservices_model->GET_ATTENDANCE_SHIFT($time_adj->shift_type);
    
    $shift_id                         = $attendance_shift->id;

    $date                             = $time_adj->date_adjustment;
    $empl_id                          = $time_adj->empl_id;
    $timeIn1                          = $time_adj->time_in_1;
    $timeOut1                         = $time_adj->time_out_1;
    $timeIn2                          = $time_adj->time_in_2;
    $timeOut2                         = $time_adj->time_out_2;

    $result                           = $this->selfservices_model->IS_DUPLICATE_TIME_ADDJ($empl_id, $date);
    $att_shift_result                 = $this->selfservices_model->IS_DUPLICATE_ATTENDANCE_SHIFTASSIGN($empl_id, $date);

    if ($result <= 0) {
      $this->selfservices_model->INSERT_TIME_ADJUSTMENT($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date);
    }else{
      $this->selfservices_model->UPDATE_TIME_ADJUSTMENT($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date);
    }

    if ($att_shift_result <= 0) {
      $this->selfservices_model->INSERT_ATTENDANCE_SHIFT_ASSIGN($shift_id, $empl_id, $date);
    }else{
      $this->selfservices_model->UPDATE_ATTENDANCE_SHIFT_ASSIGN($shift_id, $empl_id, $date);
    }

    return;
  }



  function overtime_approval()
  {
    $user_id                                  = $this->session->userdata('SESS_USER_ID');
    $data["C_ROW_DISPLAY"]                    =  [25,50,100];

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    if ($row == null) {
    $row = 25;
    }
    if($page  == null){
    $page = 1;
    }
    $offset = $row * ($page - 1);

    $data['DISP_EMPLOYEES']                   = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $data['DISP_OVERTIME']                    = $this->selfservices_model->GET_OVERTIME_APPROVALS($user_id,$offset,$row);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_COUNT_OVERTIME_APPROVALS($user_id));
    
    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_overtimes');
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/overtime_approval_views', $data);
    
  }

  function holidaywork_approval(){
    $user_id                                  = $this->session->userdata('SESS_USER_ID');
    $data["C_ROW_DISPLAY"]                    =  [25,50,100];

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    if ($row == null) {
    $row = 25;
    }
    if($page  == null){
    $page = 1;
    }
    $offset = $row * ($page - 1);

    $data['DISP_EMPLOYEES']                   = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $data['DISP_HOLIDAYWORK']                 = $this->selfservices_model->GET_HOLIDAYWORK_APPROVALS($user_id,$offset,$row);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_COUNT_HOLIDAYWORK_APPROVALS($user_id));

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_overtimes');


    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/holidaywork_approval_views', $data);
    

  }


  function get_specific_leave_request($id)
  {

    $leave_types                = $this->selfservices_model->GET_ALL_LEAVETYPES();
    $empls                      = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $leave_req                  = $this->selfservices_model->GET_SPECIFIC_LEAVE_REQUEST($id);

    foreach ($leave_req as $leave) {
      $leave_req['leave_date'] = date("F d, Y", strtotime($leave['leave_date']));
      foreach ($leave_types as $type) {
        if ($leave["type"] == $type->id) {
          $leave_req["type"] = $type->name;
        }
      }
      foreach ($empls as $empl) {
        if ($leave["empl_id"] == $empl->id) {
          $leave_req["empl_id"] = $empl->col_empl_cmid;
          $leave_req["name"] = $empl->col_last_name . ', ' . $empl->col_frst_name . ' ' . $empl->col_midl_name;
        }
      }
    }
    echo json_encode($leave_req);
  }


  function get_specific_overtime_request($id)
  {

    $empls                = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $leave_req            = $this->selfservices_model->GET_SPECIFIC_OVERTIME($id);

    foreach ($leave_req as $leave) {
      // $leave_req['leave_date'] = date("F d, Y", strtotime($leave['leave_date']));

      foreach ($empls as $empl) {
        if ($leave["empl_id"] == $empl->id) {
          $leave_req["empl_id"] = $empl->col_empl_cmid;
          $leave_req["name"] = $empl->col_last_name . ', ' . $empl->col_frst_name . ' ' . $empl->col_midl_name;
        }
      }
    }
    echo json_encode($leave_req);
  }

  function get_specific_holidaywork_request($id)
  {

    $empls                = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $holiday_req          = $this->selfservices_model->GET_SPECIFIC_HOLIDAYWORK($id);

    foreach ($holiday_req as $leave) {
      // $leave_req['leave_date'] = date("F d, Y", strtotime($leave['leave_date']));

      foreach ($empls as $empl) {
        if ($leave["empl_id"] == $empl->id) {
          $holiday_req["empl_id"] = $empl->col_empl_cmid;
          $holiday_req["name"] = $empl->col_last_name . ', ' . $empl->col_frst_name . ' ' . $empl->col_midl_name;
        }
      }
    }
    echo json_encode($holiday_req);
  }





  function get_specific_time_adj_request($id)
  {

    $empls                = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $leave_req            = $this->selfservices_model->GET_SPECIFIC_TIME_ADJ($id);

    foreach ($leave_req as $leave) {
      // $leave_req['leave_date'] = date("F d, Y", strtotime($leave['leave_date']));

      foreach ($empls as $empl) {
        if ($leave["empl_id"] == $empl->id) {
          $leave_req["empl_id"] = $empl->col_empl_cmid;
          $leave_req["name"] = $empl->col_last_name . ', ' . $empl->col_frst_name . ' ' . $empl->col_midl_name;
        }
      }
    }
    echo json_encode($leave_req);
  }


  function update_leave_assign()
  {
    $id                   = $this->input->get('approved_id');
    $leave_assign         = $this->selfservices_model->GET_LEAVE_ASSIGN();

    foreach ($leave_assign as $leave_row) {
      if ($leave_row->id == $id && $leave_row->status == 'Pending 1') {
        $status           = 'Pending 2';
        $date_created = date('Y-m-d H:i:s');
        $emp_id           = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($leave_row->id == $id && $leave_row->status == 'Pending 2') {
        $status           = 'Pending 3';
        $date_created = date('Y-m-d H:i:s');
        $emp_id           = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($leave_row->id == $id && $leave_row->status == 'Pending 3') {
        $status           = 'Approved';
        $date_created = date('Y-m-d H:i:s');
        $emp_id           = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Leave request has been approved!');
    redirect('selfservices/leave_approval');
  }



  function reject_leave_assign()
  {
    $id                 = $this->input->get('reject_id');
    $leave_assign       = $this->selfservices_model->GET_LEAVE_ASSIGN();

    foreach ($leave_assign as $leave_row) {
      if ($leave_row->id == $id && $leave_row->status == 'Pending 1') {
        $status         = 'Rejected';
        $date_created = date('Y-m-d H:i:s');
        $emp_id         = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($leave_row->id == $id && $leave_row->status == 'Pending 2') {
        $status         = 'Rejected';
        $date_created = date('Y-m-d H:i:s');
        $emp_id         = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($leave_row->id == $id && $leave_row->status == 'Pending 3') {
        $status         = 'Rejected';
        $date_created = date('Y-m-d H:i:s');
        $emp_id         = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Leave request has been rejected!');
    redirect('selfservices/leave_approval');
  }

  function update_overtime_assign()
  {

    $id               = $this->input->get('approved_id');
    $overtime_assign  = $this->selfservices_model->GET_OVERTIME_ASSIGN();

    foreach ($overtime_assign as $overtime_row) {

      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 1') {
        $status       = 'Pending 2';
        $this->selfservices_model->UPDATE_OVERTIME_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 2') {
        $status       = 'Pending 3';
        $this->selfservices_model->UPDATE_OVERTIME_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 3') {
        $status       = 'Approved';
        $this->selfservices_model->UPDATE_OVERTIME_ASSIGN3($status, $emp_id, $date_created, $id);
      }

    }
    $this->session->set_userdata('succ_approved', 'Overtime request has been approved!');
    redirect('selfservices/overtime_approval');
  }


  function update_holidaywork_assign()
  {

    $id               = $this->input->get('approved_id');
    $overtime_assign  = $this->selfservices_model->GET_HOLIDAYWORK_ASSIGN();

    foreach ($overtime_assign as $overtime_row) {
      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 1') {
        $status       = 'Pending 2';
        $date_created = date('Y-m-d H:i:s');
        $emp_id       = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 2') {
        $status       = 'Pending 3';
        $date_created = date('Y-m-d H:i:s');
        $emp_id       = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 3') {
        $status       = 'Approved';
        $date_created = date('Y-m-d H:i:s');
        $emp_id       = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN3($status, $emp_id, $date_created, $id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Holiday work request has been approved!');
    redirect('selfservices/holidaywork_approval');
  }


  function approve_time_adj_assign()
  {
    $id                           = $this->input->get('approved_id');

    $time_adjustment_assign       = $this->selfservices_model->GET_TIME_ADJUSTMENT_ASSIGN();

    foreach ($time_adjustment_assign as $time_adjustment_assign_row) {

      $date_created               = date('Y-m-d H:i:s');
      $emp_id                     = $this->session->userdata('SESS_USER_ID');

      if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 1') {
        $status                   = 'Pending 2';
        $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 2') {
        $status                   = 'Pending 3';
        $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 3') {
        $status                   = 'Approved';
        $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN3($status, $emp_id, $date_created, $id);
        $this->insert_approved_time_adjustment($id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Time Adjustment request has been approved!');
    redirect('selfservices/time_adjustment_approval');
  }


  function reject_overtime_assign()
  {
    $id                   = $this->input->get('reject_id');
    $overtime_assign      = $this->selfservices_model->GET_OVERTIME_ASSIGN();

    foreach ($overtime_assign as $overtime_row) {

      $date_created       = date('Y-m-d H:i:s');
      $emp_id             = $this->session->userdata('SESS_USER_ID');
      $status             = 'Rejected';

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 1') {
        $this->selfservices_model->UPDATE_OVERTIME_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 2') {
        $this->selfservices_model->UPDATE_OVERTIME_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 3') {
        $this->selfservices_model->UPDATE_OVERTIME_ASSIGN3($status, $emp_id, $date_created, $id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Overtime request has been rejected!');
    redirect('selfservices/overtime_approval');
  }


  function reject_holidaywork_assign()
  {
    $id                   = $this->input->get('reject_id');
    $overtime_assign      = $this->selfservices_model->GET_HOLIDAYWORK_ASSIGN();

    foreach ($overtime_assign as $overtime_row) {
      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 1') {
        $status           = 'Rejected';
        $date_created     = date('Y-m-d H:i:s');
        $emp_id           = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 2') {
        $status           = 'Rejected';
        $date_created = date('Y-m-d H:i:s');
        $emp_id           = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 3') {
        $status           = 'Rejected';
        $date_created = date('Y-m-d H:i:s');
        $emp_id           = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN3($status, $emp_id, $date_created, $id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Holiday work request has been rejected!');
    redirect('selfservices/holidaywork_approval');
  }


  function reject_time_adj_assign()
  {
    $id                     = $this->input->get('reject_id');
    $time_adjustment_assign = $this->selfservices_model->GET_TIME_ADJUSTMENT_ASSIGN();

    foreach ($time_adjustment_assign as $time_adjustment_assign_row) {

      $status               = 'Rejected';
      $date_created         = date('Y-m-d H:i:s');
      $emp_id               = $this->session->userdata('SESS_USER_ID');

      if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 1') {
        $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 2') {
        $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 3') {
        $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN3($status, $emp_id, $date_created, $id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Time Adjustment request has been rejected!');
    redirect('selfservices/time_adjustment_approval');
  }



  function my_tasks()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['user', 'employee_id', $user]; //all or user
    $data["module_name"]      = $module       = 'selfservices';
    $data["page_name"]        = $page_name    = 'my_tasks';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_employee_tasks";
    $data["module"]           = [base_url() . $module, "Self Services", "My Tasks"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "TSK";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "my_tasks.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add My Tasks"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Open", "Closed", "", ""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab               = array(
      array("Open",   "status", "Open", 0),
      array("Closed", "status", "Closed", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      array(true, "btn_mark_open", "far fa-check-circle", "Mark as Open", "status", "Open"),    //visible,id,icon,Button Name,column,status
      array(true, "btn_mark_closed", "far fa-times-circle", "Mark as Closed", "status", "Closed")    //visible,id,icon,Button Name,column,status
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("employee_id", "Employee", "user", "self", 0, 15, 1, 1, 1, 1, 0, 1),
        array("task_title", "Title", "text-row", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("task_description", "Description", "text-area", "0", 1, 0, 1, 0, 1, 1, 1, 1),
        array("task_date_from", "Date From", "date", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("task_date_to", "Date to", "date", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Open;Closed", 1, 15, 1, 1, 1, 1, 1, 1),
        array("attachment", "Attachment", "attachment", "0", 0, 0, 1, 0, 1, 1, 1, 1),
        array("remarks", "Remarks", "text-area", "0", 1, 15, 1, 0, 1, 1, 1, 1),

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

    // column name to search data
    

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
    //  echo '1'; 
      $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);

    } else {
        // echo '2';
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type)); 
      // $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    }
    // echo '<pre>';
    // echo $view_type;
    // var_dump( $data["C_DATA_TABLE"]  );
    // return;
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                   = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_tasks_views', $data);
    
  }
    function request_task(){
         $this->load->view('templates/header');
        $this->load->view('modules/selfservices/request_task_views');
    }
        function add_new_task(){
            $input_data                 = $this->input->post();
            $attachment                 = $_FILES['attachment']['name'];
            $file_info                  = pathinfo($attachment);
            $input_data['create_date']  = date('Y-m-d H:i:s');
            $input_data['edit_date']    = date('Y-m-d H:i:s');
            $employee                   = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
            $input_data['attachment']   = $attachment ;
            
            // echo '<pre>';
            // var_dump( $file_info['extension']);
            // return;
            if(!empty($attachment)){
                $input_data['attachment']       = $employee->col_empl_cmid.'_'.$employee->col_last_name.'_task_request_'.date('Y-m-d').'.'.$file_info['extension'];
                $config['upload_path']          = './assets_user/files/selfservices';
                $config['max_size']             = 10000;
                $config['file_name']            = $employee->col_empl_cmid.'_'.$employee->col_last_name.'_task_request_'.date('Y-m-d');
                $config['overwrite']            = 'TRUE';
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('attachment'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('ERR', $error['error']);
                    redirect('selfservices/request_task');
                    // var_dump($error);
                    return;
                }
            }
            $res=$this->selfservices_model->ADD_DATA('tbl_employee_tasks',$input_data);
            if($res){
                $this->session->set_flashdata('SUCC', 'Successfully added new request');
            }
            else{
                $this->session->set_flashdata('ERR', 'Fail to add new request');
                redirect('selfservices/request_task');
                return;
            }
            redirect('selfservices/my_tasks');
        }

  function my_time_records()
  {
    $userId                                   = $this->session->userdata('SESS_USER_ID');
    $data["C_ROW_DISPLAY"]                    =  [10,25,50,100];

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    $cutoff_param                             = $this->input->get('cutoff');
    $yearmonth                                = $this->input->get('yearmonth');

    if(isset($_GET['yearmonth_from'])){
      $yearmonth_from                         = $_GET['yearmonth_from'];
    }
    else{
      $yearmonth_from                         = date('Y-m-01');
    }

    if(isset($_GET['yearmonth_to'])){
      $yearmonth_to                           = $_GET['yearmonth_to'];
    }
    else{
      $yearmonth_to                           = date('Y-m-t');
    }

    if ($row == null) {
      $row = 10;
    }
    if($page  == null){
      $page = 1;
    }
    // if ($yearmonth == null) {
    //   $yearmonth = date('Y-m');
    // }

    $offset = $row * ($page - 1);
    $data['CUT_OFFS']                         = $this->selfservices_model->GET_CUT_OFFS();
    $date=null;
    $data['DISP_INOUT_TYPE']                  = $this->selfservices_model->GET_IN_OUT_TYPE();

    // $firstDay = date('Y-m-01', strtotime($yearmonth));
    // $lastDay = date('Y-m-t', strtotime($yearmonth));

    $firstDay                                 = date('Y-m-d', strtotime($yearmonth_from));
    $lastDay                                  = date('Y-m-d', strtotime($yearmonth_to));

    // var_dump($lastDay);
    foreach( $data['CUT_OFFS'] as $cut_off){
        
        if(!$cutoff_param){
            $date['from']=$cut_off->date_from;
            $date['to']=$cut_off->date_to;
            $data['SELECTED_CUTOFF']=$cut_off->id;
            break;
        }
        $cutoff_id=(int) $cut_off->id;
        if($cutoff_id==$cutoff_param){
            $date['from']=$cut_off->date_from;
            $date['to']=$cut_off->date_to;
            $data['SELECTED_CUTOFF']=$cut_off->id;
            break;
        }
    }
    
    $attendanceRecord                       = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE_RECORD($userId,$firstDay,$lastDay);
    $zktecoRecord                           = $this->selfservices_model->GET_SPECIFIC_ZKTECO_RECORD($userId,$firstDay,$lastDay);


    $data['C_DATA_COUNT']                   = $this->selfservices_model->GET_COUNT_ATTENDANCE_RECORD($userId);
    $data['C_SALARY_TYPE']  = $salary_type  = $this->selfservices_model->GET_SALARY_TYPE($userId);
     
    $date1    = new DateTime($firstDay);
    $date2    = new DateTime($lastDay);
    
    
    $interval = DateInterval::createFromDateString('1 day');
    $period   = new DatePeriod($date1, $interval, $date2->modify('+1 day'));
    
    $data['PERIOD']=$period;
    $data['DISP_ATTENDANCE']=array();

    
    $zkteco_new_data = array();
    $index = 0;

    foreach ($period as $date) {
      // time in - time out from tbl_zkteco
      $time_in_array  = [];
      $time_out_array = [];
      $raw_time_in_1  = "";
      $raw_time_out_2 = "";

      foreach ($zktecoRecord as $zkteco_time_data_row) {
        if (date("Y-m-d", strtotime($zkteco_time_data_row['punch_time'])) == $date->format("Y-m-d")) {

          if ($zkteco_time_data_row['punch_state'] == 0) {
            array_push($time_in_array, date("H:i:s", strtotime($zkteco_time_data_row['punch_time'])));
          } else {
            array_push($time_out_array, date("H:i:s", strtotime($zkteco_time_data_row['punch_time'])));
          }
        }
      }
      
      if ($time_in_array) {
        $oldest_in_time           = min(array_map('strtotime', $time_in_array));
        $raw_time_in_1            = date("H:i:s", $oldest_in_time);
      }

      if ($time_out_array) {
        $latest_time_out          = max(array_map('strtotime', $time_out_array));
        $raw_time_out_2           = date("H:i:s", $latest_time_out);
      }

      $zkteco_new_data[$index]['time_in1']            = $raw_time_in_1;
      $zkteco_new_data[$index]['time_out1']           = $raw_time_out_2;
      $zkteco_new_data[$index]['time_in2']            = "";
      $zkteco_new_data[$index]['time_out2']           = "";
      $zkteco_new_data[$index]['time_in1_address']    = "";
      $zkteco_new_data[$index]['time_out1_address']   = "";
      $zkteco_new_data[$index]['time_in2_address']    = "";
      $zkteco_new_data[$index]['time_out2_address']   = "";
      
      $zkteco_new_data[$index]['date']                = $date->format("Y-m-d");

      $index+=1;
    }

    // var_dump($zkteco_new_data);
    foreach ($period as $dt) {


        $period_date=$dt->format("Y-m-d");
        
      
        $filteredArray      = array_filter($attendanceRecord, function($object) use($period_date) {
               return $object['date'] == $period_date;
        });

        $filteredZkteco     = array_filter($zkteco_new_data, function($object) use($period_date) {
          return $object['date'] == $period_date;
        });

        $shift_assign_id    = $this->selfservices_model->GET_SHIFT_ASSIGN_ID($period_date, $userId);
        $shift_info=array(
                "code"=>null,
                "name"=>null,
                "time_in"=>null,
                "time_out"=>null,
                "time_in_2"=>null,
                "time_out_2"=>null
            );
        if($shift_assign_id){
             $shift_info    = $this->selfservices_model->GET_SHIFT($shift_assign_id);
        }
        // $shift_info=$this->selfservices_model->GET_SHIFT($shift_assign_id);
        $attendance_data    = reset($filteredArray);
        $zkteco_data        = reset($filteredZkteco);

        if($filteredArray){
            $attendance_data['code']=$shift_info['code']?$shift_info['code'] : "";
            $attendance_data['shift_name']=$shift_info['name']?$shift_info['name']:"";
            $attendance_data['shift_time_in']=$shift_info['time_in']?$shift_info['time_in']:"";
            $attendance_data['shift_time_out']=$shift_info['time_out']?$shift_info['time_out']:"";
            $attendance_data['shift_time_in_2']=$shift_info['time_in_2']?$shift_info['time_in_2']:"";
            $attendance_data['shift_time_out_2']=$shift_info['time_out_2']?$shift_info['time_out_2']:"";

          if($zkteco_data['time_in1']){
            $latest_time_in = min($attendance_data['time_in1'], $zkteco_data['time_in1']);
            $attendance_data['time_in1'] = $latest_time_in;
            
          }
          if($zkteco_data['time_out1']){
            $latest_time_out = max($attendance_data['time_out1'], $zkteco_data['time_out1']);
            $attendance_data['time_out1'] = $latest_time_out;
          }
            array_push($data['DISP_ATTENDANCE'],$attendance_data);

        }else if ($filteredZkteco){
          $zkteco_data['code']=$shift_info['code']?$shift_info['code'] : "";
          $zkteco_data['shift_name']=$shift_info['name']?$shift_info['name']:"";
          $zkteco_data['shift_time_in']=$shift_info['time_in']?$shift_info['time_in']:"";
          $zkteco_data['shift_time_out']=$shift_info['time_out']?$shift_info['time_out']:"";
          $zkteco_data['shift_time_in_2']=$shift_info['time_in_2']?$shift_info['time_in_2']:"";
          $zkteco_data['shift_time_out_2']=$shift_info['time_out_2']?$shift_info['time_out_2']:"";

          if($filteredArray){
            $latest_time_in = min($attendance_data['time_in1'], $zkteco_data['time_in1']);
            $latest_time_out = max($attendance_data['time_out1'], $zkteco_data['time_out1']);
            $zkteco_data['time_in1'] = $latest_time_in;
            $zkteco_data['time_out1'] = $latest_time_out;
          }
          array_push($data['DISP_ATTENDANCE'],$zkteco_data);
        }
        else{
            array_push($data['DISP_ATTENDANCE'],array(
                "date"=>$period_date,
                "time_in1"=>"",
                "time_out1"=>"",
                "time_in2"=>"",
                "time_out2"=>"",
                "time_in1_address"=>"",
                "time_out1_address"=>"",
                "time_in2_address"=>"",
                "time_out2_address"=>"",
                "code"=>$shift_info['code']?$shift_info['code'] : "",
                "shift_name"=>$shift_info['name']?$shift_info['name']:"",
                "shift_time_in"=>$shift_info['time_in']?$shift_info['time_in']:"",
                "shift_time_out"=>$shift_info['time_out']?$shift_info['time_out']:"",
                "shift_time_in_2"=>$shift_info['time_in_2']?$shift_info['time_in_2']:"",
                "shift_time_out_2"=>$shift_info['time_out_2']?$shift_info['time_out_2']:""
                ));
        }
    }
    
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_time_record_views', $data);
    
  }


  function my_time_in_outs()
  {
    $userId                                 = $this->session->userdata('SESS_USER_ID');
    $data['DISP_EMPLOYEE_INFO']             = $this->selfservices_model->MOD_DISP_EMPLOYEE($userId);

    $todaySchedule                          = $this->selfservices_model->MOD_DISP_EMPLOYEE_REMOTE_ATTENDANCE($userId);
    $shift_list                             = $this->selfservices_model->GET_SHIFT_LIST();

    $shift_name           = "N/A";
    $shift_time_in1       = "N/A";
    $shift_time_out1      = "N/A";
    $shift_time_in2       = "N/A";
    $shift_time_out2      = "N/A";

    $shift_time_in1_act   = "N/A";
    $shift_time_out1_act  = "N/A";
    $shift_time_in2_act   = "N/A";
    $shift_time_out2_act  = "N/A";

    if (!empty($todaySchedule)) {


      foreach ($shift_list as $shift_list_row) {
        if ($todaySchedule[0]->shift_id == $shift_list_row->id) {
          $shift_name         = $shift_list_row->name;
          $shift_time_in1     = $shift_list_row->time_in;
          $shift_time_out1    = $shift_list_row->time_out;
          $shift_time_in2     = $shift_list_row->time_in_2;
          $shift_time_out2    = $shift_list_row->time_out_2;

          $response           = $this->selfservices_model->IS_DUPLICATE_REMOTE($userId);


          if ($response == 1) {
            $atte_data        = $this->selfservices_model->GET_ATTENDANCE_DATA($userId);

            $shift_time_in1_act   = $atte_data->time_in;
            $shift_time_out1_act  = $atte_data->time_out;
            // $shift_time_in2_act   = $atte_data->time_in2;
            // $shift_time_out2_act  = $atte_data->time_out2;
          }

          break;
        }
      }
    }


    // $shift = $this->p171_workshifts_mod->MOD_GET_WRK_SHFT_DATA($todaySchedule[0]->shift_id);
    $data['SHIFT_NAME']     = $shift_name;
    $data['SHIFT_IN1']      = $shift_time_in1;
    $data['SHIFT_OUT1']     = $shift_time_out1;
    $data['SHIFT_IN2']      = $shift_time_in2;
    $data['SHIFT_OUT2']     = $shift_time_out2;


    $data['SHIFT_IN1_A']    = $shift_time_in1_act;
    $data['SHIFT_OUT1_A']   = $shift_time_out1_act;
    $data['SHIFT_IN2_A']    = $shift_time_in2_act;
    $data['SHIFT_OUT2_A']   = $shift_time_out2_act;

    $data['DISP_INOUT_TYPE']                  = $this->selfservices_model->GET_IN_OUT_TYPE();

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_remote_attendance', $data);
    
  }

  function current_location($in_out,$lat_long){
   
    $string                 = urldecode($lat_long);
    $array_lat_long         = explode(",", $string);
    $data['lat_loc']        = $array_lat_long[0];
    $data['long_loc']       = $array_lat_long[1];
    $data['in_out']         = $in_out;
   
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_current_location_views',$data);
    
  }

  function employee_time_in1()
  {
    $empl_id             = $this->session->userdata('SESS_USER_ID');
    $time_address        = $this->input->post('time_address');
    $latitude            = $this->input->post('time_latitude');
    $longitude           = $this->input->post('time_longitude');
    $current_date        = date('Y-m-d');
    $time                = date('H:i:s');
    $lat_long            = $latitude . ',' . $longitude;

    $this->selfservices_model->UPDATE_EMPL_TIME_IN_1($empl_id, $current_date, $time, $lat_long);
    $this->session->set_userdata('succ_time_in1', 'Successfully Time In 1');
    redirect('selfservices/my_time_in_outs');
  }

  function employee_time_out1()
  {
    $empl_id            = $this->session->userdata('SESS_USER_ID');
    $time_address       = $this->input->post('time_address');
    $latitude           = $this->input->post('time_latitude');
    $longitude          = $this->input->post('time_longitude');
    $current_date       = date('Y-m-d');
    $time               = date('H:i:s');
    $lat_long           = $latitude . ',' . $longitude;

    $this->selfservices_model->UPDATE_EMPL_TIME_OUT_1($empl_id, $current_date, $time, $lat_long);
    $this->session->set_userdata('succ_time_out1', 'Successfully Time Out 1');
    redirect('selfservices/my_time_in_outs');
  }

  function employee_time_in2()
  {
    $empl_id             = $this->session->userdata('SESS_USER_ID');
    $time_address        = $this->input->post('time_address');
    $latitude            = $this->input->post('time_latitude');
    $longitude           = $this->input->post('time_longitude');
    $current_date        = date('Y-m-d');
    $time                = date('H:i:s');
    $lat_long            = $latitude . ',' . $longitude;

    $this->selfservices_model->UPDATE_EMPL_TIME_IN_2($empl_id, $current_date, $time, $lat_long);
    $this->session->set_userdata('succ_time_in2', 'Successfully Time In 2');
    redirect('selfservices/my_time_in_outs');
  }

  function employee_time_out2()
  {
    $empl_id            = $this->session->userdata('SESS_USER_ID');
    $time_address       = $this->input->post('time_address');
    $latitude           = $this->input->post('time_latitude');
    $longitude          = $this->input->post('time_longitude');
    $current_date       = date('Y-m-d');
    $time               = date('H:i:s');
    $lat_long           = $latitude . ',' . $longitude;

    $this->selfservices_model->UPDATE_EMPL_TIME_OUT_2($empl_id, $current_date, $time, $lat_long);
    $this->session->set_userdata('succ_time_out2', 'Successfully Time Out 2');
    redirect('selfservices/my_time_in_outs');
  }
  function my_time_adjustments()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['user', 'empl_id', $user]; //all or user
    $data["module_name"]      = $module       = 'selfservices';
    $data["page_name"]        = $page_name    = 'my_time_adjustments';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_attendance_adjustments";
    $data["module"]           = [base_url() . $module, "Self Services", "My Time Adjustment"];         // Main Menu Path, Module, Page Title
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
        array("id", "ID", "id", "0", 1, 0, 0, 0, 0, 0, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_user", "Last Edited By", "user", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("assigned_by", "Assigned&nbsp;By", "user", "self", 0, 15, 1, 1, 0, 1, 1, 0),
        array("empl_id", "Employee", "user", "self", 0, 30, 1, 1, 0, 1, 1, 1),
        array("date_adjustment", "Adjustment&nbsp;Date", "date", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        // array("shift_type", "Shift&nbsp;Type", "fixed-sel-direct", "REST;DS 8-5;DS 9-6;DS 7-4;SAT 8-2", 1, 10, 1, 1, 1, 1, 1, 1),
        array("time_in_1", "Time&nbsp;In&nbsp;1", "time", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("time_out_1", "Time&nbsp;Out&nbsp;1", "time", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("time_in_2", "Time&nbsp;In&nbsp;2", "time", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("time_out_2", "Time&nbsp;Out&nbsp;2", "time", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("attachment", "Attachment", "attachment", "0", 1, 10, 1, 0, 1, 1, 1, 1),
        array("reason", "Reason", "text-area", "0", 1, 0, 1, 1, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Pending 1;Approved;Rejected", 1, 15, 1, 0, 0, 1, 0, 1),
        array("remarks", "Remarks", "text-area", "0", 0, 0, 1, 1, 1, 1, 1, 1),
      );

    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";
    //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
    $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]           = $this->$model->get_empl_name();
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
      $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);

    } else {
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
      // $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                   = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_time_adjustment_views', $data);
    
  }

  function request_time_adjustment(){
      $date                             = $this->input->get('date');
      $data['ATTENDANCE_REC']           = $this->selfservices_model->GET_ATTENDANCE_EMPL_REC($this->session->userdata('SESS_USER_ID'));
      $data['DEFAULT_VAL']              =[];
      if($date==null && $data['ATTENDANCE_REC']){
          $data['DEFAULT_VAL']          = $data['ATTENDANCE_REC'][0];
      }
      if($date && $data['ATTENDANCE_REC']){
          foreach ($data['ATTENDANCE_REC'] as $attendance){
              if($date==$attendance->date){
                  $data['DEFAULT_VAL']  = $attendance;
                  break;
              }
          }
      }
      // echo '<pre>';
      // var_dump($data['DEFAULT_VAL']);
      // return;
      $this->load->view('templates/header');
      $this->load->view('modules/selfservices/request_time_adjustment_views', $data);
  }
  
  function add_time_adjustment(){
      $input_data=$this->input->post();
      $attachment                 = $_FILES['attachment']['name'];
      $file_info = pathinfo($attachment);
      $input_data['create_date']  = date('Y-m-d H:i:s');
      $input_data['edit_date']    = date('Y-m-d H:i:s');
      $employee                   = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
      $input_data['attachment']   = $attachment ;
      
      // echo '<pre>';
      // var_dump( $input_data);
      // return;
      if(!empty($attachment)){
          $input_data['attachment']       = $employee->col_empl_cmid.'_'.$employee->col_last_name.'_leave_request_'.$input_date["date_adjustment"].'.'.$file_info['extension'];
          $config['upload_path']          = './assets_user/files/selfservices';
          $config['allowed_types']        = 'pdf|jpg';
          $config['max_size']             = 10000;
          $config['file_name']            = $employee->col_empl_cmid.'_'.$employee->col_last_name.'_time_adjustment_request_'.$input_date["date_adjustment"];
          $config['overwrite']            = 'TRUE';
          $this->load->library('upload', $config);

          if ( ! $this->upload->do_upload('attachment'))
          {
              $error = array('error' => $this->upload->display_errors());
              $this->session->set_userdata('ERR', $error['error']);
              redirect('selfservices/request_time_adjustment');
              // var_dump($error);
              return;
          }
      }
      $res=$this->selfservices_model->ADD_TIME_ADJUSTMENT_REQUEST($input_data);
      if($res){
          $this->session->set_userdata('SUCC', 'Successfully added');
      }
      else{
          $this->session->set_userdata('ERR', 'Fail to add new data');
          redirect('selfservices/request_time_adjustment');
          return;
      }
      redirect('selfservices/my_time_adjustments');
      
  }


  function my_leaves()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['user', 'empl_id', $user]; //all or user
    $data["module_name"]      = $module       = 'selfservices';
    $data["page_name"]        = $page_name    = 'my_leaves';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_leaves_assign";
    $data["module"]           = [base_url() . $module, "Self Services", "My Leave Applications"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "LEA";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "leave_lists.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add Request"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Approved", "Rejected", "Pending 1", ""];                                                          //Green, Red, Orange, Gray
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
        array("id", "Leave ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("assigned_by", "Assigned&nbsp;by", "user", "self", 0, 15, 1, 0, 0, 1, 1, 0),
        array("empl_id", "Employee", "user", "self", 0, 10, 1, 1, 0, 1, 1, 1),
        array("type", "Type", "db-sel", "array1", 1, 15, 1, 1, 1, 1, 1, 1),
        array("leave_date", "Leave Date", "date", "0", 1, 15, 1, 1, 1, 1, 0, 1),
        array("duration", "Leave Duration (Hours)", "number", "2", 1, 10, 1, 1, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Pending 1;Pending 2;Pending 3;Approved;Rejected", 1, 15, 1, 0, 0, 1, 0, 1),
        array("remarks", "Remarks", "text-area", "0", 1, 0, 1, 0, 1, 1, 1, 1),
        array("attachment", "Attachment", "attachment", "jpg;png;pdf", 0, 0, 1, 0, 1, 1, 1, 1),

      );

    $C_ARRAY_TABLE_1 = "tbl_std_leavetypes";
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
      $row = 25;
    }
    if ($tab == null) {
      $tab = 0;
    }
    if ($tab_filter == null) {
      $tab_filter = $c_data_tab[0][1];
    }
    if ($page == null) {
      $page = 1;
    }

    $offset = $row * ($page - 1);
    $data["C_TAB_SELECT"] = $tab;
    if ($this->input->get('all') == null) {
      // $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]               = $this->selfservices_model->GET_DATA_COUNT($user);
    } else {
      // $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
      // $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
      $data["C_DATA_COUNT"]               = $this->selfservices_model->GET_DATA_COUNT($user);
    }

    $data["C_DATA_TABLE"]               = $this->selfservices_model->GET_LEAVE_LIST($user,$row,$offset) ;
    


    // foreach( $data["C_DATA_TABLE"]   as $db_data){
    //     $db_data->type                    = $this->filter_data_array($data["C_ARRAY_1"],$db_data->type);
    // }
    // echo '<pre>';
    // var_dump(  $data["C_DATA_TABLE"]  );
    // return ;
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    
    $data["C_DATA_TAB"]                   = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_leave_views', $data);
    
  }
  function filter_data_array($arr_data,$db_data){
      foreach($arr_data as $arr){
          if($arr->id==$db_data){
              return $arr->name;
              break;
          }
      }
      return '';
  }
  function request_leave(){
    $data['EMPLOYEES']                  = $this->selfservices_model->GET_EMPOLOYEES();
    $data['LEAVE_TYPES']                = $this->selfservices_model->GET_ALL_LEAVETYPES();
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/request_leave_views',$data);
  }

  function add_leave_request(){
      $input_data                       = $this->input->post();
      $attachment                       = $_FILES['attachment']['name'];
      $file_info = pathinfo($attachment);
      $input_data['create_date']        = date('Y-m-d H:i:s');
      $input_data['edit_date']          = date('Y-m-d H:i:s');
      $employee                         = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
      $input_data['attachment']         = $attachment ;
      
      // echo '<pre>';
      // var_dump( $file_info['extension']);
      // return;
      if(!empty($attachment)){
          $input_data['attachment']       = $employee->col_empl_cmid.'_'.$employee->col_last_name.'_leave_request_'.date('Y-m-d').'.'.$file_info['extension'];
          $config['upload_path']          = './assets_user/files/selfservices';
          $config['allowed_types']        = 'pdf|jpg';
          $config['max_size']             = 10000;
          $config['file_name']            = $employee->col_empl_cmid.'_'.$employee->col_last_name.'_leave_request_'.date('Y-m-d');
          $config['overwrite']            = 'TRUE';
          $this->load->library('upload', $config);

          if ( ! $this->upload->do_upload('attachment'))
          {
              $error = array('error' => $this->upload->display_errors());
              $this->session->set_userdata('ERR', $error['error']);
              redirect('selfservices/request_leave');
              // var_dump($error);
              return;
          }
      }
      $is_duplicate                       = $this->selfservices_model->GET_IS_DUPLICATE_DATE($input_data['leave_date']);

      if($is_duplicate > 0){
        $this->session->set_userdata('ERR', "Leave submission failed. It looks like you have already submitted a leave request for the same dates.");
        redirect('selfservices/my_leaves');
        
      }else{
        $res                              = $this->selfservices_model->ADD_LEAVE_REQUEST($input_data);
        if($res){
            $this->session->set_userdata('SUCC', 'Successfully added');
        }
        else{
            $this->session->set_userdata('ERR', 'Fail to add new data');
            redirect('selfservices/request_leave');
            return;
        }
        
      }
     
      redirect('selfservices/my_leaves');
  }

        
  function my_overtimes()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['user', 'empl_id', $user]; //before = ['user', 'edit_user', $user];
    $data["module_name"]      = $module       = 'selfservices';
    $data["page_name"]        = $page_name    = 'my_overtimes';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_overtimes";
    $data["module"]           = [base_url() . $module, "Self Services", "My Overtimes"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "OVT";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "my_overtimes.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add My Overtimes"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Approved", "Rejected", "Pending 1", ""];                                                 //Green, Red, Orange, Gray
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
        array("id", "ID", "id", "0", 1, 0, 0, 0, 0, 0, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_user", "Last Edited By", "user", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("assigned_by", "Assigned By", "user", "self", 0, 15, 1, 1, 0, 1, 0, 1),
        array("empl_id", "Employee", "user", "self", 0, 15, 0, 1, 0, 1, 0, 1),
        array("type", "Type", "fixed-sel-direct", "Regular; Night Shift; Rest; Special; Legal; Rest + Special; Rest + Legal", 0, 10, 1, 1, 1, 1, 1, 1),
        array("date_ot", "Shift Date", "date", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("time_out", "Time Out", "time", "0", 0, 10, 1, 1, 1, 1, 1, 1),
        array("hours", "Overtime Hours", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("reason", "Reason", "text-area", "0", 1, 0, 1, 1, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Pending 1;Pending 2;Pending 3;Approved;Rejected", 1, 15, 1, 0, 0, 1, 0, 1),
        array("comment", "Remarks", "text-area", "0", 1, 0, 1, 1, 1, 1, 1, 1),

      );
    //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
    $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]           = $this->$model->get_empl_name();
    // $data["C_ARRAY_1"]                  = $this->$model->get_allowance_name();
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
      $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
      
    } else {
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
      // $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                   = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_overtime_views',$data);
    
  }

  function request_overtime(){
      $data['EMPLOYEES']                = $this->selfservices_model->GET_EMPOLOYEES();
      $this->load->view('templates/header');
      $this->load->view('modules/selfservices/request_overtime_views',$data);
  }

  function add_request_overtime(){
      $input_data=$this->input->post();
      $res=$this->selfservices_model->ADD_OVERTIME_REQUEST($input_data);
      if($res){
          $this->session->set_userdata('SUCC','Successfully added');
          redirect('selfservices/my_overtimes');
          return;
      }
      $this->session->set_userdata('ERR','Fail to add new data');
      redirect('selfservices/request_overtime');
  }

  function my_holiday_work()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['user', 'empl_id', $user]; //before = ['user', 'edit_user', $user];
    $data["module_name"]      = $module       = 'selfservices';
    $data["page_name"]        = $page_name    = 'my_holiday_work';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_holidaywork";
    $data["module"]           = [base_url() . $module, "Self Services", "My Holiday Work"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "MHW";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "my_holiday_work.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add My Holiday Work"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Approved", "Rejected", "Pending 1", ""];                                                 //Green, Red, Orange, Gray
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
        array("id", "ID", "id", "0", 1, 0, 0, 0, 0, 0, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("edit_user", "Last Edited By", "user", "0", 0, 0, 0, 0, 0, 0, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("assigned_by", "Assigned By", "user", "self", 0, 15, 1, 1, 0, 1, 1, 0),
        array("empl_id", "Employee", "user", "self", 0, 15, 1, 1, 1, 1, 1, 1),
        array("date", "Date", "date", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("type", "Type", "fixed-sel-direct", "Regular; Night Shift; Rest; Special; Legal; Rest + Special; Rest + Legal", 1, 10, 1, 1, 1, 1, 1, 1),
        array("hours", "Working Hours", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("reason", "Reason", "text-area", "0", 1, 0, 1, 1, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Pending 1;Pending 2;Pending 3;Approved;Rejected", 1, 15, 1, 0, 0, 1, 0, 1),
        array("comment", "Remarks", "text-area", "0", 1, 0, 1, 1, 1, 1, 1, 1),

      );
    //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
    $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]           = $this->$model->get_empl_name();
    // $data["C_ARRAY_1"]                  = $this->$model->get_allowance_name();
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
      $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
      
    } else {
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
      
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                   = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_holiday_work_views', $data);
    
  }
    function request_holiday_work(){
        $data=[];
        $this->load->view('templates/header');
        $this->load->view('modules/selfservices/request_holiday_work_views', $data);
    }
    function add_holiday_work(){
        $input_data                       = $this->input->post();
        $res                              = $this->selfservices_model->ADD_HOLIDAY_WORK($input_data);
        if($res){
                $this->session->set_flashdata('SUCC','Successfully added');
                redirect('selfservices/my_holiday_work');
                return;
            }
        $this->session->set_flashdata('ERR','Fail to add new data');
        redirect('selfservices/request_holiday_work');
        
    }
  // function my_payslips()
  // {
  //   //------------------------------------------------------- START OF DYNAMIC PARAMETERS
  //   $user = $this->session->userdata('SESS_USER_ID');
  //   $data["view_type"]        = $view_type    = ['user', 'empl_id', $user]; //all or user
  //   $data["module_name"]      = $module       = 'selfservices';
  //   $data["page_name"]        = $page_name    = 'my_payslips';
  //   $data["model_name"]       = $model        = "main_table_02_model";
  //   $data["table_name"]       = $table        = "tbl_payroll_payslips";
  //   $data["module"]           = [base_url() . $module, "Self Services", "My Payslips"];         // Main Menu Path, Module, Page Title
  //   $data["id_prefix"]        = "PAY";
  //   $data["excel_import"]     = [false];
  //   $data["excel_output"]     = [false, "my_payslips.xlsx"];                                                       // Enable, File Name
  //   $data["add_button"]       = [false, "Add My Payslips"];                                                                 // Enable, Button Name modal_add_enable   = true;
  //   $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
  //   $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
  //   $c_data_tab             = array(
  //     array("Active", "status", "Active", 0),
  //     array("Inactive", "status", "Inactive", 0)
  //   );
  //   $data["C_BULK_BUTTON"]  = array(
  //     array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),    //visible,id,icon,Button Name,column,status
  //     array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")    //visible,id,icon,Button Name,column,status
  //   );
  //   $data["C_DB_DESIGN"]  =
  //     array(
  //       array("id", "ID", "id", "0", 0, 0, 0, 0, 0, 0, 0, 1),
  //       array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
  //       array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
  //       array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 0, 0, 1),
  //       array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
  //       // array("empl_id", "Assigned By", "user", "self", 1, 25, 1, 1, 0, 0, 0, 1),
  //       array("PAYSLIP_EMPLOYEE_CMID", "Employee&nbsp;ID", "text-row", "0", 1, 15, 1, 1, 1, 1, 1, 1),
  //       array("PAYSLIP_EMPLOYEE_NAME", "Name", "text-row", "0", 1, 15, 1, 1, 1, 1, 1, 1),
  //       array("PAYSLIP_SALARY_RATE", "Salary&nbsp;Rate", "text-row", "0", 1, 15, 1, 1, 1, 1, 1, 1),
  //       array("PAYSLIP_SALARY_TYPE", "Salary&nbsp;Type", "text-row", "0", 1, 15, 1, 1, 1, 1, 1, 1),



  //     );
  //   $C_ARRAY_TABLE_1 = "tbl_payroll_period";
  //   $C_ARRAY_TABLE_2 = "";
  //   $C_ARRAY_TABLE_3 = "";
  //   $C_ARRAY_TABLE_4 = "";
  //   $C_ARRAY_TABLE_5 = "";

  //   //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
  //   $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
  //   $data["default_row"]                = $filter_row[0];
  //   $data["C_DATA_EMPL_NAME"]           = $this->$model->GET_EMPL_NAME();
  //   $data["C_ARRAY_1"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
  //   $data["C_ARRAY_2"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
  //   $data["C_ARRAY_3"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
  //   $data["C_ARRAY_4"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
  //   $data["C_ARRAY_5"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);
  //   $page                               = $this->input->get('page');
  //   $row                                = $this->input->get('row');
  //   $tab                                = $this->input->get('tab');
  //   $tab_filter                         = $this->input->get('tab_filter');

  //   if ($row == null) {
  //     $row = $filter_row[0];
  //   }
  //   if ($tab == null) {
  //     $tab = $c_data_tab[0][0];
  //   }
  //   if ($tab_filter == null) {
  //     $tab_filter = $c_data_tab[0][1];
  //   }

  //   $offset = $row * ($page - 1);
  //   $data["C_TAB_SELECT"] = $tab;
  //   if ($this->input->get('all') == null) {
  //     $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
  //     $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
  //   } else {
  //     $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
  //     $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
  //   }
  //   $i = 0;
  //   foreach ($c_data_tab as $c_data_tab_row) {
  //     $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
  //     $i++;
  //   }
  //   $data["C_DATA_TAB"]    = $c_data_tab;
  //   $this->load->view('templates/header');
  //   $this->load->view('templates/main_table_02_views', $data);
  //   
  // }

  function my_payslips(){
    $dateFilter                               = $this->input->get('date');
    $user_id                                  = $this->session->userdata('SESS_USER_ID');
    $data["C_ROW_DISPLAY"]                    =  [25,50,100];

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    if ($row == null) {
    $row = 25;
    }
    if($page  == null){
    $page = 1;
    }
    $offset = $row * ($page - 1);

    if($dateFilter == null){
      $payslips                               = $this->selfservices_model->GET_ALL_MY_PAYSPLIP($user_id,$offset,$row);
      $data['C_DATA_COUNT']                   = count($this->selfservices_model->GET_COUNT_MY_PAYSPLIP($user_id));
    }else{
      $payslips                               = $this->selfservices_model->GET_FILTERED_MY_PAYSPLIP($user_id,$dateFilter);
      $data['C_DATA_COUNT']                   = count($this->selfservices_model->GET_FILTERED_MY_PAYSPLIP($user_id,$dateFilter));
    }

    $data['DISP_PAYROLL_SCHED']               = $this->selfservices_model->MOD_DISP_PAY_SCHED();
    $employees                                = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC($user_id);
    $positions                                = $this->selfservices_model->GET_SPECIFIC_POSITION();
    $types                                    = $this->selfservices_model->GET_SPECIFIC_EMPLOYEE_TYPE();
    

    $payslips_data = [];
    $index = 0;

    if($payslips){
      foreach($payslips as $payslip){
        $payslips_data[$index]['id']          = $payslip->id;
        $payslips_data[$index]['empl_id']     = $payslip->col_empl_cmid;
        $payslips_data[$index]['fullname']    = $payslip->col_last_name . ', ' . $payslip->col_frst_name . ' ' . strtoupper(substr($payslip->col_midl_name, 0, 1)) . '.';
        // $payslips_data[$index]['position'] = $this->selfservices_model->GET_SPECIFIC_POSITION($payslip->col_empl_posi);

        foreach($positions as $position){
          if($position->id == $payslip->col_empl_posi){
            $payslips_data[$index]['position'] = $position->name;
          }
        }

        foreach($types as $type){
          if($type->id == $payslip->col_empl_type){
            $payslips_data[$index]['type']    = $type->name;
          }
        }

        $index+=1;
      }
    }

    $data['DISP_PAYSLIPS']                    = $payslips_data;

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_payslips_views',$data);
    
  }

  function getPayslipData($id){
    $payslip                                  = $this->selfservices_model->GET_PAYSLIP_DATA($id);
    echo json_encode($payslip);
  }

  function delete_payslip(){
    $payslip_ids                              = $this->input->post('payslip_ids');
    $array_id                                 = explode(",", $payslip_ids);
    // var_dump($array_id);
    // echo $id;
    $res=$this->payrolls_model->DELETE_PAYSLIP_DATA($array_id);
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_PAYROLL', 'Deleted Successfully!');
    redirect('payrolls/payslip_generator');
}


  function my_support_requests()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['user', 'employee_id', $user]; //all or user
    $data["module_name"]      = $module       = 'selfservices';
    $data["page_name"]        = $page_name    = 'my_support_requests';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_supports";
    $data["module"]           = [base_url() . $module, "Self Services", "Supports"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "SUP";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "supports.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add Supports"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
        array("employee_id", "Employee", "user", "self", 1, 10, 1, 1, 1, 1, 0, 1),
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
      $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type)); 
      // $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                   = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_support_request_views', $data);
    
  }
    function request_support(){
        $this->load->view('templates/header');
        $this->load->view('modules/selfservices/request_support_views');
    }
        function add_new_support(){
            $input_data                 = $this->input->post();
            $attachment                 = $_FILES['attachment']['name'];
            $file_info                  = pathinfo($attachment);
            $input_data['create_date']  = date('Y-m-d H:i:s');
            $input_data['edit_date']    = date('Y-m-d H:i:s');
            $employee                   = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['employee_id']);
            $input_data['attachment']   = $attachment ;
            
            // echo '<pre>';
            // var_dump( $file_info['extension']);
            // return;
            if(!empty($attachment)){
                $config['upload_path']          = './assets_user/files/selfservices';
                $config['max_size']             = 10000;
                $config['overwrite']            = 'TRUE';
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('attachment'))
                {
                    $error                      = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('ERR', $error['error']);
                    redirect('selfservices/request_support');
                    // var_dump($error);
                    return;
                }
            }
            $res=$this->selfservices_model->ADD_DATA('tbl_hr_supports',$input_data);
            if($res){
                $this->session->set_flashdata('SUCC', 'Successfully added');
            }
            else{
                $this->session->set_flashdata('ERR', 'Fail to add new data');
                redirect('selfservices/request_support');
                return;
            }
            redirect('selfservices/my_support_requests');
        }

  function my_complaints()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['user', 'employee_id', $user]; //all or user
    $data["module_name"]      = $module       = 'selfservices';
    $data["page_name"]        = $page_name    = 'my_complaints';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_complaints";
    $data["module"]           = [base_url() . $module, "Self Services", "Complaints"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "CMP";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "complaints.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add Complaints"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
        array("employee_id", "Employee", "user", "self", 1, 10, 1, 1, 1, 1, 0, 1),
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
      $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                   = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_complaint_views', $data);
    
  }
    function add_complaint(){
        $this->load->view('templates/header');
        $this->load->view('modules/selfservices/add_complaint_views');
    }
        function add_new_complaint(){
            $input_data                 = $this->input->post();
            $attachment                 = $_FILES['attachment']['name'];
            $file_info                  = pathinfo($attachment);
            $input_data['create_date']  = date('Y-m-d H:i:s');
            $input_data['edit_date']    = date('Y-m-d H:i:s');
            $employee                   = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
            $input_data['attachment']   = $attachment ;
            
            // echo '<pre>';
            // var_dump( $file_info['extension']);
            // return;
            if(!empty($attachment)){
               $res                     = $this->upload_file('./assets_user/files/selfservices');
               if(!$res){
                   redirect('selfservices/add_complaint');
                   return;
               }
            }
            $res=$this->selfservices_model->ADD_DATA('tbl_hr_complaints',$input_data);
            if($res){
                $this->session->set_flashdata('SUCC', 'Successfully added');
            }
            else{
                $this->session->set_flashdata('ERR', 'Fail to add new data');
                redirect('selfservices/add_complaint');
                return;
            }
            redirect('selfservices/my_complaints');
            
        }
  function upload_file($path){
        $config['upload_path']          = $path;
        $config['max_size']             = 10000;
        $config['allowed_types']        = 'gif';
        $config['overwrite']            = 'TRUE';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('attachment'))
        {
            $error                      = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('ERR', $error['error']);
            
            // var_dump($error);
            return false;
        }
        return true;
  }
  function my_warnings()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['user', 'employee_id', $user]; //all or user
    $data["module_name"]      = $module       = 'selfservices';
    $data["page_name"]        = $page_name    = 'my_warnings';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_warnings";
    $data["module"]           = [base_url() . $module, "Self Services", "Warnings"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "WRN";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "warnings.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add Warnings"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
        array("employee_id", "Employee", "user", "self", 1, 10, 1, 1, 1, 1, 0, 1),
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
      $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
      // $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }

    $data["C_DATA_TAB"]                   = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_warnings_views', $data);
    
  }
    function add_warning(){
        $this->load->view('templates/header');
        $this->load->view('modules/selfservices/add_warning_views');
    }
        function add_new_warning(){
            $input_data                 = $this->input->post();
            $attachment                 = $_FILES['attachment']['name'];
            $file_info = pathinfo($attachment);
            $input_data['create_date']  = date('Y-m-d H:i:s');
            $input_data['edit_date']    = date('Y-m-d H:i:s');
            $employee                   = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['employee_id']);
            $input_data['attachment']   = $attachment ;
            
            // echo '<pre>';
            // var_dump( $file_info['extension']);
            // return;
            if(!empty($attachment)){
               $res=$this->upload_file('./assets_user/files/selfservices');
               if(!$res){
                   redirect('selfservices/add_warning');
                   return;
               }
            }
            $res=$this->selfservices_model->ADD_DATA('tbl_hr_warnings',$input_data);
            if($res){
                $this->session->set_flashdata('SUCC', 'Successfully added');
            }
            else{
                $this->session->set_flashdata('ERR', 'Fail to add new data');
                redirect('selfservices/add_warning');
                return;
            }
            redirect('selfservices/my_warnings');
        }


  function my_trainings()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['user', 'edit_user', $user]; //all or user
    $data["module_name"]      = $module       = 'selfservices';
    $data["page_name"]        = $page_name    = 'my_trainings';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_employee_allowanceassign";
    $data["module"]           = [base_url() . $module, "Self Services", "My Trainings"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "TRN";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "my_trainings.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add My Trainings"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
    $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
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
      $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
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

  function my_surveys()
  {
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['user', 'edit_user', $user]; //all or user
    $data["module_name"]      = $module       = 'selfservices';
    $data["page_name"]        = $page_name    = 'my_surveys';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_employee_allowanceassign";
    $data["module"]           = [base_url() . $module, "Self Services", "My Surveys"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "SRV";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "my_surveys.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true, "Add My Surveys"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
    $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
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
      $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]               = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
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

  //-------------------------------------------------------- CRUD FUNCTIONS starts
  function get_data_all_list()
  {
    $model                                = $this->input->post('model_name');
    $table                                = $this->input->post('table_name');
    $modal_id                             = $this->input->post('modal_id');
    $data = $this->$model->get_data_row($table, $modal_id);
    echo (json_encode($data));
  }
  function show_data()
  {
    $data["model_name"]                   = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"]             = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_show', $data);
    
  }
  function edit_data()
  {
    $data["model_name"]                   = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"]             = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_edit', $data);
    
  }
  function add_data()
  {
    $data["model_name"]                   = $model  = "main_table_01_model";
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_add', $data);
    
  }
  function edit_row()
  {
    $edit_user                            = $this->session->userdata('SESS_USER_ID');
    $input_data                           = $this->input->get();
    $set_array                            = array();
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
        $set_array[$key] = $value;
      }
    }
    $set_array['edit_user']               = $edit_user;
    $this->main_table_01_model->edit_table_row($table, $id, $set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function add_row()
  {
    $edit_user                            = $this->session->userdata('SESS_USER_ID');
    $input_data                           = $this->input->get();
    $set_array                            = array();
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
    $set_array['edit_user']               = $edit_user;
    $this->main_table_01_model->add_table_row($table, $set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function delete_row()
  {
    $edit_user                            = $this->session->userdata('SESS_USER_ID');
    $id                                   = $this->input->get('delete_id');
    $table                                = $this->input->get('table');
    $module_name                          = $this->input->get('module');
    $page_name                            = $this->input->get('page');
    $this->main_table_01_model->delete_table_row($id, $table, $edit_user);
    $this->session->set_userdata('delete', 'Deleted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function edit_bulk_status()
  {
    $edit_user                  = $this->session->userdata('SESS_USER_ID');
    $status                     = $this->input->post('modal_title');
    $ids                        = $this->input->post('list_mark_ids');
    $ids_int                    = array_map('intval', explode(',', $ids));
    $module_name                = $this->input->get('module');
    $page_name                  = $this->input->get('page_name');
    $table                      = $this->input->get('table');
    $page                       = $this->input->get('page');
    $row_url                    = '&row=';
    $row                        = $this->input->get('row');
    $tab                        = $this->input->get('tab');
    if ($page == null) {
      $page = 1;
    }
    if ($row == null) {
      $row_url = '';
      $row = '';
    }
    if ($tab == null) {
      $tab = "All";
    }
    $this->main_table_01_model->edit_bulk_status($table, $status, $ids_int, $edit_user);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . '/' . $page_name . '?page=' . $page . $row_url . $row . '&tab=' . $tab);
  }
  //-------------------------------------------------------- CRUD FUNCTIONS ends
  function insrt_skill()
  {
    $employee_id            = $this->input->post('SKILL_EMPL_ID');
    $skill                  = $this->input->post('INSRT_SKILL_NAME');
    $level                  = $this->input->post('INSRT_SKILL_LEVEL');
    $this->selfservices_model->MOD_INSRT_SKILL($employee_id, $skill, $level);
    $this->session->set_userdata('SESS_SUCC_INSRT_SKILL', 'Skill Added Successfully!');
    redirect('profile');
  }
  //  +++++++++++++++ PERSONAL INFORMATION +++++++++++++++
  function edit_employee_info()
  {
    $employee_key           = $this->input->post('EDIT_EMPL_ID');
    $employee_id            = $this->input->post('UPDT_EMPL_ID');
    $lastname               = $this->input->post('UPDT_EMPL_LNAME');
    $middlename             = $this->input->post('UPDT_EMPL_MNAME');
    $firstname              = $this->input->post('UPDT_EMPL_FNAME');
    $birthday               = $this->input->post('UPDT_EMPL_BIRTHDAY');
    $gender                 = $this->input->post('UPDT_EMPL_GENDER');
    $marital_status         = $this->input->post('UPDT_EMPL_MRTL_STAT');
    $shirt_size             = $this->input->post('UPDT_EMPL_SHIRT_SIZE');
    $nationality            = $this->input->post('UPDT_EMPL_NATIONALITY');
    $home_address           = $this->input->post('UPDT_EMPL_HOME_ADDR');
    $current_address        = $this->input->post('UPDT_EMPL_CURR_ADDR');
    $this->selfservices_model->MOD_UPDT_EMPLOYEE_INFO($employee_id, $lastname, $middlename, $firstname, $birthday, $gender, $marital_status, $shirt_size, $nationality, $home_address, $current_address, $employee_key);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_INFO', 'Updated Successfully!');
    redirect('profile');
  }
  //  +++++++++++++++ CONTACT +++++++++++++++
  function edit_employee_contact()
  {
    $employee_key           = $this->input->post('EDIT_EMPL_ID');
    $work_email             = $this->input->post('UPDT_EMPL_WORK_EMAIL');
    $personal_email         = $this->input->post('UPDT_EMPL_PERS_EMAIL');
    $work_number            = $this->input->post('UPDT_EMPL_WORK_NUMBER');
    $personal_number        = $this->input->post('UPDT_EMPL_PERS_NUMBER');
    $this->selfservices_model->MOD_UPDT_EMPLOYEE_CONTACT($work_email, $personal_email, $work_number, $personal_number, $employee_key);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_CONTACT', 'Contacts Updated Successfully!');
    redirect('profile');
  }
  //  +++++++++++++++ EDUCATION +++++++++++++++
  function edit_employee_education()
  {
    $education_id         = $this->input->post('UPDT_EDUC_ID');
    $employee_id          = $this->input->post('UPDT_EDUC_EMPL_ID');
    $school               = $this->input->post('UPDT_EDUC_SCHOOL');
    $degree               = $this->input->post('UPDT_EDUC_DEGREE');
    $from_year            = $this->input->post('UPDT_EDUC_FROM_YEAR');
    $to_year              = $this->input->post('UPDT_EDUC_TO_YEAR');
    $grade                = $this->input->post('UPDT_EDUC_GRADE');
    $this->selfservices_model->MOD_UPDT_EDUCATION($school, $degree, $from_year, $to_year, $grade, $employee_id, $education_id);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_EDUC', 'Education Background Updated Successfully!');
    redirect('profile');
  }
  function delete_employee_education()
  {
    $education_id         = $this->input->get('delete_id');
    $employee_id          = $this->input->get('employee_id');
    $this->selfservices_model->MOD_DLT_EDUCATION($education_id);
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_EDUC', 'Education Background Deleted');
    redirect('profile');
  }
  // DISPLAY SPECIFIC POSITION IN MODAL
  function getEducationData()
  {
    $education_id         = $this->input->post('education_id');
    $data                 = $this->selfservices_model->MOD_GET_EDUCATION_DATA($education_id);
    echo (json_encode($data));
  }
  // +++++++++++++++ LICENSE CERTIFICATION +++++++++++++++
  function edit_employee_certification()
  {
    $certification_id         = $this->input->post('UPDT_CERT_ID');
    $employee_id              = $this->input->post('UPDT_CERT_EMPL_ID');
    $certificate_name         = $this->input->post('UPDT_CERT_NAME');
    $issuer                   = $this->input->post('UPDT_CERT_ISSUER');
    $issued_on                = $this->input->post('UPDT_CERT_ISSUED_ON');
    $expires_on               = $this->input->post('UPDT_CERT_EXPIRE');
    $this->selfservices_model->MOD_UPDT_LICENSE($certificate_name, $issuer, $issued_on, $expires_on, $employee_id, $certification_id);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_CERT', 'Certification Updated Successfully!');
    redirect('profile');
  }
  function delete_employee_certification()
  {
    $certification_id         = $this->input->get('delete_id');
    $employee_id              = $this->input->get('employee_id');
    $this->selfservices_model->MOD_DLT_LICENSE($certification_id);
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_CERT', 'Certification Deleted!');
    redirect('profile');
  }
  // DISPLAY SPECIFIC POSITION IN MODAL
  function getCertificationData()
  {
    $certification_id         = $this->input->post('certification_id');
    $data                     = $this->selfservices_model->MOD_GET_LICENSE_DATA($certification_id);
    echo (json_encode($data));
  }
  // +++++++++++++++ SKILLs +++++++++++++++
  function edit_employee_skill()
  {
    $skill_id                 = $this->input->post('UPDT_SKILL_ID');
    $employee_id              = $this->input->post('UPDT_SKILL_EMPL_ID');
    $skill_name               = $this->input->post('UPDT_SKILL_NAME');
    $level                    = $this->input->post('UPDT_SKILL_LEVEL');
    $this->selfservices_model->MOD_UPDT_SKILL($skill_name, $level, $employee_id, $skill_id);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_SKILL', 'SKILL Updated Successfully!');
    redirect('profile');
  }
  function delete_employee_skill()
  {
    $skill_id                 = $this->input->get('delete_id');
    $employee_id              = $this->input->get('employee_id');
    $this->selfservices_model->MOD_DLT_SKILL($skill_id);
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_SKILL', 'Certification Deleted!');
    redirect('profile');
  }
  // DISPLAY SPECIFIC POSITION IN MODAL
  function getSkillData()
  {
    $skill_id                 = $this->input->post('skill_id');
    $data                     = $this->selfservices_model->MOD_GET_SKILL_DATA($skill_id);
    echo (json_encode($data));
  }

  function update_employee_id()
  {
    $employee_id              = htmlentities($this->input->post('UPDT_EMP_ID'));
    $sss                      = htmlentities($this->input->post('UPDT_ID_SSS'));
    $hdmf                     = htmlentities($this->input->post('UPDT_ID_HDMF'));
    $philhealth               = htmlentities($this->input->post('UPDT_ID_PHIL'));
    $tin                      = htmlentities($this->input->post('UPDT_ID_TIN'));
    $drivers_license          = htmlentities($this->input->post('UPDT_ID_DRV'));
    $national_id              = htmlentities($this->input->post('UPDT_ID_NAT'));
    $passport                 = htmlentities($this->input->post('UPDT_ID_PSSP'));
    $this->selfservices_model->MOD_UPDT_EMPLOYEE_ID($sss, $hdmf, $philhealth, $tin, $drivers_license, $national_id, $passport, $employee_id);
    $this->session->set_userdata('SESS_SUCC_UPDT', 'Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/ids'</script>";
  }

  function edit_employee_job()
  {
    $employee_id              = $this->input->post('UPDT_EMPL_ID');
    $hired_on                 = $this->input->post('UPDT_JOB_HIRE_ON');
    $end_on                   = $this->input->post('UPDT_JOB_END_ON');
    $this->selfservices_model->MOD_UPDT_JOB($hired_on, $end_on, $employee_id);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_JOB', 'Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/job'</script>";
  }
  function edit_employment_details()
  {
    $user_id                  = $this->input->post('EMPL_ID');
    $emp_type                 = $this->input->post('emp_type');
    $position                 = $this->input->post('position');
    $department               = $this->input->post('department');
    $groups                   = $this->input->post('groups');
    $line                     = $this->input->post('line');
    $section                  = $this->input->post('section');
    $hmo                      = $this->input->post('hmo');
    $hmo_number               = $this->input->post('hmo_number');
    // $this->selfservices_model->MOD_UPDT_EMPL_DETAILS($emp_type,$position,$department,$division,$location,$reporting_to,$comp_email,$comp_number,$section,$hmo,$hmo_number,$user_id);
    $this->selfservices_model->MOD_UPDT_EMPL_DETAILS($emp_type, $position, $department, $section, $groups, $line, $hmo, $hmo_number, $user_id);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_JOB', 'Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/job'</script>";
  }
  function edit_employee_salary_rate()
  {
    $salary_rate              = $this->input->post('salary_rate');
    $salary_type              = $this->input->post('salary_type');
    $user_id                  = $this->input->post('EMPL_ID');
    $this->selfservices_model->MOD_UPDT_EMPL_SALARY_RATE($salary_rate, $salary_type, $user_id);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_JOB', 'Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/job'</script>";
  }

  function add_employee_document()
  {
    $employee_id              = $this->input->post('INSRT_DOC_EMPL_ID');
    $document_name            = $_FILES['employee_file']['name'];
    $config['upload_path']    = './employee_files/';
    $config['allowed_types']  = 'docx|xlsx|pdf|pptx';
    $config['max_size']       = '50000';
    $config['file_name']      = $employee_id . '_' . $document_name;
    $config['overwrite']      = 'TRUE';
    $this->load->library('upload', $config);
    if ($_FILES['employee_file']['size'] != 0) {
      if ($this->upload->do_upload('employee_file')) {
        $data_upload          = array('employee_file' => $this->upload->data());
        $document_file        = $data_upload['employee_file']['file_name'];
        $this->selfservices_model->MOD_INSRT_DOC($document_file, $document_name, $employee_id);
        $this->session->set_userdata('SESS_SUCC_ADD_EMPL_DOC', 'Document Added Successfully!');
        echo "<script>window.location.href='" . base_url() . "profile/documents'</script>";
      }
    } else {
      $this->session->set_userdata('SESS_ERR_ADD_EMPL_DOC', 'Document Not Found!');
      echo "<script>window.location.href='" . base_url() . "profile/documents'</script>";
    }
  }
  function delete_employee_document()
  {
    $document_id              = $this->input->get('id');
    $file                     = $this->input->get('file');
    $employee_id              = $this->input->get('employee_id');
    // get the file from the path
    $filestring = PUBPATH . 'employee_files/' . $file;
    if (file_exists($filestring)) {
      // delete file in the directory
      unlink($filestring);
      $this->selfservices_model->MOD_DLT_DOCU($document_id);
      $this->session->set_userdata('SESS_SUCC_DLT_EMPL_DOC', 'Document Deleted Successfully!');
      echo "<script>window.location.href='" . base_url() . "employees/documents?id=" . $employee_id . "'</script>";
    } else {
      // File not found.
      $this->session->set_userdata('SESS_ERR_DLT_EMPL_DOC', 'File not found');
      echo "<script>window.location.href='" . base_url() . "profile/documents'</script>";
    }
  }


  function add_employee_asset()
  {
    $assign_to                = $this->input->post('INSRT_ASSET_EMPL_ID');
    $user_id                  = $this->input->post('INSRT_ASSET_USER_ID');
    $issued_on                = $this->input->post('INSRT_ASSET_ISSUED_ON');
    $asset_id                 = $this->input->post('INSRT_ASSET_NAME');
    $asset_list               = $this->selfservices_model->MOD_DISP_ASSET_INFO($asset_id);
    $status                   = $asset_list[0]->col_asset_status;
    if (($status == '') || ($status == 'in-stockroom')) {
      $this->selfservices_model->MOD_INSRT_ASSET_LOGS($assign_to, $user_id, $issued_on, $asset_id);
      $this->selfservices_model->MOD_UPDT_ASSET_STATUS_TRANSFER($assign_to, $issued_on, $user_id, $asset_id);
      $this->session->set_userdata('SESS_SUCC_MSG_TRANSFER_TO_EMPLOYEE', 'Assigned Successfully!');
      echo "<script>window.location.href='" . base_url() . "profile/assets'</script>";
    } else if ($status == 'in-use') {
      // if asset is in-use and is being transferred to another user
      $issued_on_key          = $asset_list[0]->col_asset_issued_on;
      $assigned_to_key        = $asset_list[0]->col_asset_assigned_to;
      $this->selfservices_model->MOD_UPDT_ASSET_STATUS_TRANSFER($assign_to, $issued_on, $user_id, $asset_id);
      $this->selfservices_model->MOD_UPDT_ASSET_LOGS($issued_on_key, $asset_id, $assigned_to_key);
      $this->selfservices_model->MOD_INSRT_ASSET_LOGS($assign_to, $user_id, $issued_on, $asset_id);
      $this->session->set_userdata('SESS_SUCC_MSG_TRANSFER_ASSET', 'Transferred Successfully!');
      echo "<script>window.location.href='" . base_url() . "profile/assets'</script>";
    }
  }

  function insert_emergency()
  {
    $INSRT_EMER_EMPID       = $this->input->post('INSRT_EMER_EMPID');
    $INSRT_EMER_NAME        = $this->input->post('INSRT_EMER_NAME');
    $INSRT_EMER_RELA        = $this->input->post('INSRT_EMER_RELA');
    $INSRT_EMER_MNUM        = $this->input->post('INSRT_EMER_MNUM');
    $INSRT_EMER_WPHN        = $this->input->post('INSRT_EMER_WPHN');
    $INSRT_EMER_HPHN        = $this->input->post('INSRT_EMER_HPHN');
    $INSRT_EMER_ADDR        = $this->input->post('INSRT_EMER_ADDR');
    $this->selfservices_model->MOD_INSRT_EMERGENCY(
      $INSRT_EMER_EMPID,
      $INSRT_EMER_NAME,
      $INSRT_EMER_RELA,
      $INSRT_EMER_MNUM,
      $INSRT_EMER_WPHN,
      $INSRT_EMER_HPHN,
      $INSRT_EMER_ADDR
    );
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_EMERGENCY', 'Emergency Contact Added Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/emergency'</script>";
  }
  function delete_emergency()
  {
    $DATA_ID              = $this->input->get('delete_id');
    $employee_id          = $this->input->get('employee_id');
    $this->selfservices_model->MOD_DLT_EMERGENCY($DATA_ID);
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_EMERGENCY', 'Emergency Contact Deleted Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/emergency'</script>";
  }
  // DISPLAY SPECIFIC POSITION IN MODAL
  function get_emergency_data()
  {
    $DATA_ID              = $this->input->post('DATA_ID');
    $data                 = $this->selfservices_model->MOD_GET_EMERGENCY_DATA($DATA_ID);
    echo (json_encode($data));
  }
  // Update Emergency
  function update_emergency()
  {
    $UPDT_EMER_EMPID      = $this->input->post('UPDT_EMER_EMPID');
    $UPDT_EMER_NAME       = $this->input->post('UPDT_EMER_NAME');
    $UPDT_EMER_RELA       = $this->input->post('UPDT_EMER_RELA');
    $UPDT_EMER_MNUM       = $this->input->post('UPDT_EMER_MNUM');
    $UPDT_EMER_WPHN       = $this->input->post('UPDT_EMER_WPHN');
    $UPDT_EMER_HPHN       = $this->input->post('UPDT_EMER_HPHN');
    $UPDT_EMER_ADDR       = $this->input->post('UPDT_EMER_ADDR');
    $DATA_ID              = $this->input->post('UPDT_EMER_ID');
    $this->selfservices_model->MOD_UPDT_EMERGENCY(
      $UPDT_EMER_EMPID,
      $UPDT_EMER_NAME,
      $UPDT_EMER_RELA,
      $UPDT_EMER_MNUM,
      $UPDT_EMER_WPHN,
      $UPDT_EMER_HPHN,
      $UPDT_EMER_ADDR,
      $DATA_ID
    );
    $this->session->set_userdata('SESS_SUCC_MSG_UPDT_EMERGENCY', 'Emergency Contact Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/emergency'</script>";
  }
  function insert_dependents()
  {
    $INSRT_DEPT_EMPID     = $this->input->post('INSRT_DEPT_EMPID');
    $INSRT_DEPT_NAME      = $this->input->post('INSRT_DEPT_NAME');
    $INSRT_DEPT_BDAY      = $this->input->post('INSRT_DEPT_BDAY');
    //$INSRT_DEPT_AGE = $this->input->post('INSRT_DEPT_AGE');
    $INSRT_DEPT_GNDR      = $this->input->post('INSRT_DEPT_GNDR');
    $INSRT_DEPT_RELA      = $this->input->post('INSRT_DEPT_RELA');
    $this->selfservices_model->MOD_INSRT_DEPENDENTS($INSRT_DEPT_EMPID, $INSRT_DEPT_NAME, $INSRT_DEPT_BDAY, $INSRT_DEPT_GNDR, $INSRT_DEPT_RELA);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_DEPENDENTS', 'Dependents Added Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/dependents'</script>";
  }
  function delete_dependents()
  {
    $DATA_ID              = $this->input->post('delete_id');
    $employee_id          = $this->input->post('employee_id');
    $this->selfservices_model->MOD_DLT_DEPENDENTS($DATA_ID);
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_DEPENDENTS', 'Dependents Deleted Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/dependents'</script>";
  }
  // DISPLAY SPECIFIC POSITION IN MODAL
  function get_dependents_data()
  {
    $DATA_ID = $this->input->post('DATA_ID');
    $data = $this->selfservices_model->MOD_GET_DEPENDENTS_DATA($DATA_ID);
    echo (json_encode($data));
  }
  function update_dependents()
  {
    $UPDT_DEPT_EMPID      = $this->input->post('UPDT_DEPT_EMPID');
    $UPDT_DEPT_NAME       = $this->input->post('UPDT_DEPT_NAME');
    $UPDT_DEPT_BDAY       = $this->input->post('UPDT_DEPT_BDAY');
    $UPDT_DEPT_GNDR       = $this->input->post('UPDT_DEPT_GNDR');
    $UPDT_DEPT_RELA       = $this->input->post('UPDT_DEPT_RELA');
    $DATA_ID              = $this->input->post('UPDT_DEPT_ID');
    $this->selfservices_model->MOD_UPDT_DEPENDENTS($UPDT_DEPT_EMPID, $UPDT_DEPT_NAME, $UPDT_DEPT_BDAY, $UPDT_DEPT_GNDR, $UPDT_DEPT_RELA, $DATA_ID);
    $this->session->set_userdata('SESS_SUCC_MSG_UPDT_DEPENDENTS', 'Dependents Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/dependents'</script>";
  }

  function insert_notes()
  {
    $INSRT_NOTE_CRBY      = $this->input->post('INSRT_NOTE_CRBY');
    $INSRT_NOTE_CRDT      = $this->input->post('INSRT_NOTE_CRDT');
    $INSRT_NOTE_DESC      = $this->input->post('INSRT_NOTE_DESC');
    $INSRT_NOTE_EMID      = $this->input->post('INSRT_NOTE_EMID');
    $this->selfservices_model->MOD_INSRT_NOTES($INSRT_NOTE_CRBY, $INSRT_NOTE_CRDT, $INSRT_NOTE_DESC, $INSRT_NOTE_EMID);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_NOTES', 'Note Added Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/notes'</script>";
  }
  function delete_notes()
  {
    $DATA_ID              = $_GET['delete_id'];
    $this->selfservices_model->MOD_DLT_NOTES($DATA_ID);
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_NOTES', 'Note Deleted Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/notes'</script>";
  }
  // DISPLAY SPECIFIC POSITION IN MODAL
  function get_notes_data()
  {
    $DATA_ID              = $this->input->post('DATA_ID');
    $data                 = $this->selfservices_model->MOD_GET_NOTES_DATA($DATA_ID);
    echo (json_encode($data));
  }
  function update_notes()
  {
    $UPDT_NOTE_CRBY       = $this->input->post('UPDT_NOTE_CRBY');
    $UPDT_NOTE_CRDT       = $this->input->post('UPDT_NOTE_CRDT');
    $UPDT_NOTE_DESC       = $this->input->post('UPDT_NOTE_DESC');
    $UPDT_NOTE_EMID       = $this->input->post('UPDT_NOTE_EMID');
    $DATA_ID              = $this->input->post('UPDT_NOTE_ID');
    $this->selfservices_model->MOD_UPDT_NOTES($UPDT_NOTE_CRBY, $UPDT_NOTE_CRDT, $UPDT_NOTE_DESC, $UPDT_NOTE_EMID, $DATA_ID);
    $this->session->set_userdata('SESS_SUCC_MSG_UPDT_NOTES', 'Note Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/notes'</script>";
  }


  function leave_bulk_approve()
  {
    $empl_id              = $this->input->post('EMPLOYEE_ID');
    $id                   = $this->input->post('APPROVE_ID');

    $ids                  = explode(",", $id);

    foreach ($ids as $id) {
      $leave_assign       = $this->selfservices_model->GET_LEAVE_ASSIGN();

      foreach ($leave_assign as $leave_row) {
        if ($leave_row->id == $id && $leave_row->status == 'Pending 1') {
          $status         = 'Pending 2';
          $date_created   = date('Y-m-d H:i:s');
          $emp_id         = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id);
        }

        if ($leave_row->id == $id && $leave_row->status == 'Pending 2') {
          $status         = 'Pending 3';
          $date_created   = date('Y-m-d H:i:s');
          $emp_id         = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id);
        }

        if ($leave_row->id == $id && $leave_row->status == 'Pending 3') {
          $status         = 'Approved';
          $date_created   = date('Y-m-d H:i:s');
          $emp_id         = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id);
        }
      }
    }
    $this->session->set_userdata('succ_approved', 'Leave request has been approved!');
    redirect('selfservices/leave_approval');
  }


  function leave_bulk_reject()
  {
    $empl_id        = $this->input->post('REJECT_EMPLOYEE_ID');
    $id             = $this->input->post('REJECTED_ID');

    $ids            = explode(",", $id);

    foreach ($ids as $id) {
      $leave_assign = $this->selfservices_model->GET_LEAVE_ASSIGN();

      foreach ($leave_assign as $leave_row) {
        if ($leave_row->id == $id && $leave_row->status == 'Pending 1') {
          $status   = 'Rejected';
          $date_created = date('Y-m-d H:i:s');
          $emp_id   = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id);
        }

        if ($leave_row->id == $id && $leave_row->status == 'Pending 2') {
          $status   = 'Rejected';
          $date_created = date('Y-m-d H:i:s');
          $emp_id   = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id);
        }

        if ($leave_row->id == $id && $leave_row->status == 'Pending 3') {
          $status   = 'Rejected';
          $date_created = date('Y-m-d H:i:s');
          $emp_id   = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id);
        }
      }
    }

    $this->session->set_userdata('succ_approved', 'Leave request has been rejected!');
    redirect('selfservices/leave_approval');
  }


  function overtime_bulk_approve()
  {

    $id                 = $this->input->post('APPROVE_ID');
    $ids                = explode(",", $id);

    foreach ($ids as $id) {
      $overtime_assign  = $this->selfservices_model->GET_OVERTIME_ASSIGN();

      foreach ($overtime_assign as $overtime_row) {
        if ($overtime_row->id == $id && $overtime_row->status == 'Pending 1') {
          $status       = 'Pending 2';
          $date_created = date('Y-m-d H:i:s');
          $emp_id       = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_OVERTIME_ASSIGN($status, $emp_id, $date_created, $id);
        }

        if ($overtime_row->id == $id && $overtime_row->status == 'Pending 2') {
          $status       = 'Pending 3';
          $date_created = date('Y-m-d H:i:s');
          $emp_id       = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_OVERTIME_ASSIGN2($status, $emp_id, $date_created, $id);
        }

        if ($overtime_row->id == $id && $overtime_row->status == 'Pending 3') {
          $status       = 'Approved';
          $date_created = date('Y-m-d H:i:s');
          $emp_id       = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_OVERTIME_ASSIGN3($status, $emp_id, $date_created, $id);
        }
      }
    }
    $this->session->set_userdata('succ_approved', 'Overtime request has been approved!');
    redirect('selfservices/overtime_approval');
  }


  function holidaywork_bulk_approve()
  {

    $id                 = $this->input->post('APPROVE_ID');
    $ids                = explode(",", $id);

    foreach ($ids as $id) {
      $overtime_assign  = $this->selfservices_model->GET_HOLIDAYWORK_ASSIGN();

      foreach ($overtime_assign as $overtime_row) {
        if ($overtime_row->id == $id && $overtime_row->status == 'Pending 1') {
          $status       = 'Pending 2';
          $date_created = date('Y-m-d H:i:s');
          $emp_id       = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN($status, $emp_id, $date_created, $id);
        }

        if ($overtime_row->id == $id && $overtime_row->status == 'Pending 2') {
          $status       = 'Pending 3';
          $date_created = date('Y-m-d H:i:s');
          $emp_id       = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN2($status, $emp_id, $date_created, $id);
        }

        if ($overtime_row->id == $id && $overtime_row->status == 'Pending 3') {
          $status       = 'Approved';
          $date_created = date('Y-m-d H:i:s');
          $emp_id       = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN3($status, $emp_id, $date_created, $id);
        }
      }
    }
    $this->session->set_userdata('succ_approved', 'Holiday Work request has been approved!');
    redirect('selfservices/holidaywork_approval');
  }


  
  function time_adjustment_bulk_approve()
  {

    $id                       = $this->input->post('APPROVE_ID');
    $ids                      = explode(",", $id);

    foreach ($ids as $id) {
      $time_adjustment_assign = $this->selfservices_model->GET_TIME_ADJUSTMENT_ASSIGN();

      foreach ($time_adjustment_assign as $time_adjustment_assign_row) {
        if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 1') {
          $status             = 'Pending 2';
          $date_created       = date('Y-m-d H:i:s');
          $emp_id             = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN($status, $emp_id, $date_created, $id);
        }

        if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 2') {
          $status             = 'Pending 3';
          $date_created       = date('Y-m-d H:i:s');
          $emp_id             = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN2($status, $emp_id, $date_created, $id);
        }

        if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 3') {
          $status             = 'Approved';
          $date_created       = date('Y-m-d H:i:s');
          $emp_id             = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN3($status, $emp_id, $date_created, $id);
          $this->insert_approved_time_adjustment($id);
        }
      }
    }
    $this->session->set_userdata('succ_approved', 'Time Adjustment request has been approved!');
    redirect('selfservices/time_adjustment_approval');
  }



  function overtime_bulk_reject()
  {
    $id                 = $this->input->post('REJECTED_ID');
    $ids                = explode(",", $id);

    foreach ($ids as $id) {
      $overtime_assign  = $this->selfservices_model->GET_OVERTIME_ASSIGN();

      foreach ($overtime_assign as $overtime_row) {
        if ($overtime_row->id == $id && $overtime_row->status == 'Pending 1') {
          $status       = 'Rejected';
          $date_created = date('Y-m-d H:i:s');
          $emp_id       = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_OVERTIME_ASSIGN($status, $emp_id, $date_created, $id);
        }

        if ($overtime_row->id == $id && $overtime_row->status == 'Pending 2') {
          $status       = 'Rejected';
          $date_created = date('Y-m-d H:i:s');
          $emp_id       = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_OVERTIME_ASSIGN2($status, $emp_id, $date_created, $id);
        }

        if ($overtime_row->id == $id && $overtime_row->status == 'Pending 3') {
          $status       = 'Rejected';
          $date_created = date('Y-m-d H:i:s');
          $emp_id       = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_OVERTIME_ASSIGN3($status, $emp_id, $date_created, $id);
        }
      }
    }
    $this->session->set_userdata('succ_approved', 'Overtime request has been rejected!');
    redirect('selfservices/overtime_approval');
  }


  function holidaywork_bulk_reject()
  {
    $id                 = $this->input->post('REJECTED_ID');
    $ids                = explode(",", $id);

    foreach ($ids as $id) {
      $overtime_assign  = $this->selfservices_model->GET_HOLIDAYWORK_ASSIGN();

      foreach ($overtime_assign as $overtime_row) {
        if ($overtime_row->id == $id && $overtime_row->status == 'Pending 1') {
          $status       = 'Rejected';
          $date_created = date('Y-m-d H:i:s');
          $emp_id       = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN($status, $emp_id, $date_created, $id);
        }

        if ($overtime_row->id == $id && $overtime_row->status == 'Pending 2') {
          $status       = 'Rejected';
          $date_created = date('Y-m-d H:i:s');
          $emp_id       = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN2($status, $emp_id, $date_created, $id);
        }

        if ($overtime_row->id == $id && $overtime_row->status == 'Pending 3') {
          $status       = 'Rejected';
          $date_created = date('Y-m-d H:i:s');
          $emp_id       = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN3($status, $emp_id, $date_created, $id);
        }
      }
    }
    $this->session->set_userdata('succ_approved', 'Holiday Work request has been rejected!');
    redirect('selfservices/holidaywork_approval');
  }




  function time_adjustment_bulk_reject()
  {
    $id                       = $this->input->post('REJECTED_ID');
    $ids                      = explode(",", $id);

    foreach ($ids as $id) {
      $time_adjustment_assign = $this->selfservices_model->GET_TIME_ADJUSTMENT_ASSIGN();

      foreach ($time_adjustment_assign as $time_adjustment_assign_row) {
        if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 1') {
          $status             = 'Rejected';
          $date_created       = date('Y-m-d H:i:s');
          $emp_id             = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN($status, $emp_id, $date_created, $id);
        }

        if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 2') {
          $status             = 'Rejected';
          $date_created       = date('Y-m-d H:i:s');
          $emp_id             = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN2($status, $emp_id, $date_created, $id);
        }

        if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 3') {
          $status             = 'Rejected';
          $date_created       = date('Y-m-d H:i:s');
          $emp_id             = $this->session->userdata('SESS_USER_ID');
          $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN3($status, $emp_id, $date_created, $id);
        }
      }
    }
    $this->session->set_userdata('succ_approved', 'Overtime request has been rejected!');
    redirect('selfservices/time_adjustment_approval');
  }

  // ============================================================ ALLOWANCES ====================================================================

  function get_my_team()
  {
    $user                   = $this->session->userdata('SESS_USER_ID');
    $empl_name              = $this->selfservices_model->GET_POSITION();
    $res                    = $this->selfservices_model->GET_MY_TEAM($user);

    foreach ($res as &$res_row) {
      foreach ($empl_name as &$empl_name_row) {
        if ($res_row["position"] == $empl_name_row->id) {
          $res_row["position"] = $empl_name_row->name;
        }
        if ($res_row["superior_position"] == $empl_name_row->id) {
          $res_row["superior_position"] = $empl_name_row->name;
        }
      }
    }
    echo json_encode($res);
  }


  function edit_image(){
    
    $get_image_name       = $_FILES['employee_image']['name'];
    $userID               = $this->input->post('INSRT_EMPL_ID');
    $url_directory        = $this->input->post('URL_DIRECTORY');
    $employee             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC($userID);
    // echo '<pre>';
    // var_dump($employee);
    $employee=$employee? $employee[0] : redirect('selfservices/my_profile_personal');
    // set uploading file config
    $config['upload_path']    = './assets_user/user_profile';
    // $config['allowed_types'] = 'jpg|png|jpeg';
    $config['allowed_types']  = '*';
    $config['max_size']       = '5000';
    $config['file_name']      = $employee->col_empl_cmid;
    $config['overwrite']      = 'TRUE';
    $this->load->library('upload', $config);
    if($_FILES['employee_image']['size'] != 0){
        if ($this->upload->do_upload('employee_image'))
        {
            $data_upload      = array('employee_image' => $this->upload->data());
            $user_img         = $data_upload['employee_image']['file_name'];
            $this->selfservices_model->INSERT_EMPLOYEE_IMAGE($user_img, $userID);
            $this->session->set_userdata('SESS_SUCC_UPDT_IMG', 'Profile Updated!');
        }
        else{
            $error            = array('error' => $this->upload->display_errors());
            var_dump($error);
        }
    } else {
        echo 'fail to change profile image';
        $this->session->set_userdata('SESS_ERR_IMAGE', 'No employee photo was selected');
    }
    redirect('selfservices/my_profile_personal','refresh');
}


}


function filter_array($user_modules, $user_access)
{
  $modules = array();
  foreach ($user_modules as $module) {
    foreach ($user_access as $access) {
      if ($module["title"] == $access) {
        $modules[] = $module;
      }
    }
  }
  return $modules;
}
