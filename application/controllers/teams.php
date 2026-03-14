<?php
class teams extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('modules/teams_model');
    $this->load->model('modules/selfservices_model');
    $this->load->model('modules/leaves_model');
    $this->load->library('technos_encryption');
    $this->load->library('system_functions');
    $this->load->library('logger');

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

    $maintenance                                        = $this->login_model->GET_MAINTENANCE();
    $isAdmin                                            = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }

  function index()
  {

    $employee_id = $this->session->userdata('SESS_USER_ID');
    $user_access = $this->main_nav_model->get_user_access_id($employee_id);
    $exempt_undertime_access    = $this->selfservices_model->GET_SYSTEM_SETUP('teams_exempt_undertime');
    
    $exempt_undertime_ids = [];
    if ($exempt_undertime_access && !empty($exempt_undertime_access)) {
      $exempt_undertime_ids = explode(',', $exempt_undertime_access);
    }


    $this->db->select('value');
    $this->db->from('tbl_system_setup');
    $this->db->where('setting', 'teams_offset');
    $result = $this->db->get()->row();

    $allowed_ids = [];

    if ($result && !empty($result->value)) {
      $allowed_ids = explode(',', $result->value);
    }
    // var_dump($allowed_ids);
    {
      $data["Modules"] =  array(
        array("title" => "Apply Leaves",                  "value" => "Apply Leaves",              "icon" => "house-person-leave-duotone.svg",                 "info" => "This system maintains accurate and up-to-date records of employees' leave balances, usage, and history.",           "url" => "teams/apply_leaves",       "access" => "Teams",  "id" => "apply_leaves"),
        array("title" => "Apply Overtimes",               "value" => "Apply Overtimes",           "icon" => "clock-duotone.svg",                            "info" => "This system maintains accurate records of employees' overtime hours, ensuring that both employees and the organization have a clear view of overtime usage.",           "url" => "teams/apply_overtimes",      "access" => "Teams", "id" => "apply_overtimes"),
        array("title" => "Apply Time Adjustments",        "value" => "Apply Time Adjustments",    "icon" => "rotate-duotone.svg",                           "info" => "This system provides transparency in the time adjustment process. Employees can submit requests, track the status of their requests, and receive notifications about approvals or denials.",           "url" => "teams/apply_time_adjustments",      "access" => "Teams", "id" => "apply_time_adj"),
        array("title" => "Exempt Undertime",           "value" => "Exempt Undertime",       "icon" => "clock-nine-duotone.svg",                   "info" => "",             "url" => "teams/exemptut",      "access" => "Teams", "id" => "apply_holiday_works"),
        array("title" => "Change Shift Request",          "value" => "Change Shift Request",      "icon" => "calendar-xmark-duotone-2xl.svg",                   "info" => "",             "url" => "teams/mychange_shift",      "access" => "Teams", "id" => "change_shift"),
        array("title" => "Change Off Request",            "value" => "Change Off Request",        "icon" => "calendar-xmark-duotone-2xl.svg",                   "info" => "",             "url" => "teams/team_change_off",      "access" => "Teams", "id" => "team_change_off"),

        array("title" => "Undertime Request",             "value" => "Undertime Request",       "icon" => "calendar-xmark-duotone-2xl.svg",                   "info" => "",             "url" => "teams/undertime",      "access" => "Teams", "id" => "undertime"),
        // array("title" => "Change Shift Approval",         "value" => "Change Shift Approval",       "icon" => "calendar-xmark-duotone-2xl.svg",                   "info" => "",             "url" => "teams/mychange_approval",      "access" => "Teams", "id" => "changeshift_approval"),
        // array("title" => "Undertime Approval",            "value" => "Undertime Approval",       "icon" => "calendar-xmark-duotone-2xl.svg",                   "info" => "",             "url" => "teams/undertrime_approval",      "access" => "Teams", "id" => "undertrime_approval"),
        array("title" => "Shift Assignment",              "value" => "Shift Assignment",          "icon" => "chart-gantt-duotone-att.svg",                   "info" => "",             "url" => "teams/myshifts",      "access" => "Teams", "id" => "shift_assignment"),
        // array("title" => "Shift Approval",                "value" => "Shift Approval",            "icon" => "chart-gantt-duotone-att.svg",                   "info" => "This system allow employees to initiate requests for holiday work, view their holiday work history, and access information related to compensation policies.",             "url" => "teams/shift_approval",      "access" => "Teams", "id" => "shift_approval"),
        array("title" => "Team In/Out",                   "value" => "Team In/Out",               "icon" => "chart-gantt-duotone-att.svg",                   "info" => "",             "url" => "teams/team_in_out",      "access" => "Teams", "id" => "team_in_out"),
        array("title" => "Shift Approver",                "value" => "Shift Approver",            "icon" => "chart-gantt-duotone-att.svg",                   "info" => "",             "url" => "teams/shift_approver",      "access" => "Teams", "id" => "shift_approver"),
        array("title" => "Apply Offsets",                 "value" => "Apply Offsets",            "icon" => "chart-gantt-duotone-att.svg",                   "info" => "",             "url" => "teams/apply_offsets",      "access" => "Teams", "id" => "apply_holiday_works"),
    
        array("title" => "Exempt Undertime",              "value" => "Exempt Undertime",         "icon" => "clock-nine-duotone.svg",                        "info" => "",             "url" => "teams/exemptut",           "access" => "Teams", "id" => "exemptut"),
      );
      $data["title_page"]                                   = "Teams Management";
      $data["title_description"]                            = "Allows supervisors and managers to organize and manage the team members within an organization";
      $data["maiya_theme"]                                  = $this->teams_model->GET_MAYA_THEME();
      $user_access_id                                       = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
      $data['DISP_USER_ACCESS_PAGE']                        = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
      $array_page                                           = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);

      if (!empty($allowed_ids) && !in_array($employee_id, $allowed_ids)) {
        $data["Modules"] = array_filter($data["Modules"], function ($module) {
          return $module["id"] !== "apply_offsets";
        });
      }

      if (!empty($exempt_undertime_ids) && !in_array($employee_id, $exempt_undertime_ids)) {
        $data["Modules"] = array_filter($data["Modules"], function ($module) {
          return $module["id"] !== "exemptut";
        });
      }

      $data['Modules']                                      = filter_array($data["Modules"], $array_page);
    }

    $this->load->view('templates/header');
    $this->load->view('templates/main_container', $data);
  }

  function shift_approval()
  {
    $data['TABLE_DATA']                     =  array();
    $data['DATE_FORMAT']                    = $this->teams_model->GET_SYSTEM_SETTING("date_format");
    $status                                 =  $this->input->get('status');
    $limit                                  =  $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                   =  $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                 =  $limit * ($page - 1);
    $search                                 = $this->input->get('search');
    $user_id                                = $this->session->userdata('SESS_USER_ID');


    $data['TABLE_DATA']                     = $this->teams_model->GET_SHIFTAPPROVAL_LIST();
    $total_count                            = 0;


    $data['STATUS']                         = $status;
    $data['STATUSES']                       = array('Pending', 'Approved', 'Rejected');
    // $data['TABLE_DATA']                     = $this->teams_model->GET_OVERTIMES($status, $search, $limit, $offset, $filter_arr,$user_id);
    // $total_count                            = $this->teams_model->GET_OVERTIMES_COUNT($status, $search, $filter_arr,$user_id);
    $excess                                 = $total_count % $limit;
    $data['C_DATA_COUNT']                   = $total_count;
    $data['PAGES_COUNT']                    = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                           = $page;
    $data['ROW']                            = $limit;
    $data['C_ROW_DISPLAY']                  = array(10, 25, 50);


    // $data['EMPLOYEES']                      = $this->teams_model->GET_EMPLOYEES_ALL();

    $data['multiple_request']                     = $this->teams_model->get_system_setup_by_setting('multiple_request', '0');

    $this->load->view('templates/header');
    $this->load->view('modules/teams/shift_approval_views', $data);
  }

  function shift_approver()
  {

    $status                     = $this->input->get('status');
    $limit                      = $this->input->get('row') ? $this->input->get('row')  : 50;
    $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                     =  $limit * ($page - 1);
    $search                     = $this->input->get('all');

    $filter_arr                 = array();
    $filter_arr['company']      = $this->input->get('company');
    $filter_arr['branch']       = $this->input->get('branch');
    $filter_arr['dept']         = $this->input->get('dept');
    $filter_arr['div']          = $this->input->get('division');
    $filter_arr['clubhouse']    = $this->input->get('clubhouse');
    $filter_arr['section']      = $this->input->get('section');
    $filter_arr['group']        = $this->input->get('group');
    $filter_arr['team']         = $this->input->get('team');
    $filter_arr['line']         = $this->input->get('line');
    $filter_arr['id']           = $this->input->get('search');

    $data['DISP_EMPLOYEES_NONFILTERED'] = $this->teams_model->MOD_DISP_ALL_EMPLOYEES_LIST($search, $limit, $offset, $filter_arr);
    $data['DISP_APPROVERS']             = $approvers = $this->teams_model->GET_EMPL_APPROVALS_NEW($search, $limit, $offset, $filter_arr);

    $total_count = $this->teams_model->GET_EMPL_APPROVALS_COUNT($search, $filter_arr);
    $excess      = $total_count % $limit;
    $data['C_DATA_COUNT']   = $total_count;
    $data['PAGES_COUNT']    = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']           = $page;
    $data['ROW']            = $limit;
    $data['C_ROW_DISPLAY']              = array(50);

    $data['DISP_DISTINCT_BRANCH']     = $this->teams_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT'] = $this->teams_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']   = $this->teams_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_CLUBHOUSE']   = $this->teams_model->MOD_DISP_DISTINCT_CLUBHOUSE();
    $data['DISP_DISTINCT_SECTION']    = $this->teams_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']      = $this->teams_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']       = $this->teams_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']       = $this->teams_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_COMPANY']         = $this->teams_model->GET_SYSTEM_SETTING_2("com_company");
    $data['DISP_VIEW_BRANCH']         = $this->teams_model->GET_SYSTEM_SETTING_2("com_branch");
    $data['DISP_VIEW_DIVISION']       = $this->teams_model->GET_SYSTEM_SETTING_2("com_division");
    $data['DISP_VIEW_CLUBHOUSE']      = $this->teams_model->GET_SYSTEM_SETTING_2("com_clubhouse");
    $data['DISP_VIEW_TEAM']           = $this->teams_model->GET_SYSTEM_SETTING_2("com_team");
    $data['DISP_VIEW_DEPARTMENT']     = $this->teams_model->GET_SYSTEM_SETTING_2("com_Department");
    $data['DISP_VIEW_SECTION']        = $this->teams_model->GET_SYSTEM_SETTING_2("com_section");
    $data['DISP_VIEW_GROUP']          = $this->teams_model->GET_SYSTEM_SETTING_2("com_group");
    $data['DISP_VIEW_LINE']           = $this->teams_model->GET_SYSTEM_SETTING_2("com_line");

    $data['NUM_APPROVERS']                      = $this->teams_model->GET_SYSTEM_SETTING("num_approvers");

    $data['DISP_DEPARTMENTS']                      = $this->teams_model->MOD_DISP_DISTINCT_DEPARTMENT();

    $employeeSearchRaw                  = $this->teams_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
    foreach ($employeeSearchRaw as &$item) {
      if (!empty($item->col_suffix)) {
        $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
      }
      $item->name = $item->col_empl_cmid . ' - ' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
    }
    unset($item);
    $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;

    $this->load->view('templates/header');
    $this->load->view('modules/teams/shift_approver_views', $data);
  }

  function get_leave_approval_status($id)
  {
    $data['LEAVE'] = $this->teams_model->GET_LEAVE_APPROVAL_STATUS($id);
    $data['tableData'] = $this->teams_model->GET_LEAVE_APPROVAL_TABLE_DATA($id);
    $data['hours'] = $this->teams_model->GET_LEAVE_APPROVAL_HOURS($id);
    $data['days'] = count($data['tableData']);
    $this->load->view('modules/partials/_approval_modal_content', $data);
  }

  function withdraw_leave()
  {
    $id = $this->input->post('rowId');
    $status = "Withdrawed";
    $res = $this->teams_model->MOD_UPDATE_LEAVE_STATUS($id, $status);
    echo $res;
    // $this->session->set_userdata('SUCC', 'Withdraw Leave Updated Successfully!');
    // redirect('selfservices/my_leaves');
  }

  function mychange_shift()
  {
    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);

    $data['STATUS']                                  = $status;
    $data['STATUSES']                                = array('Pending', 'Approved', 'Rejected', 'Withdrawed');
    $data['TABLE_DATA']                              = $tablbe_data = $this->teams_model->GET_EMPL_CHANGESHIFT($userId, $status, $limit, $offset);

    foreach ($tablbe_data as $row_shift) {
      $shift_result = $this->teams_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
      $shift_result_to = $this->teams_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift_to);

      if ($shift_result) {
        $row_shift->request_shift = $shift_result->name;
      }

      if ($shift_result_to) {
        $row_shift->request_shift_to = $shift_result_to->name;
      }
    }

    $total_count                                     = $this->teams_model->GET_EMPL_CHANGESHIFT_COUNT($userId, $status);

    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
    $data['DATE_FORMAT']                              = $this->teams_model->GET_SYSTEM_SETTINGS("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/teams/my_changeshift_views', $data);
  }

  function team_change_off()
  {
    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);

    $data['STATUS']                                  = $status;
    $data['STATUSES']                                = array('Pending', 'Approved', 'Rejected', 'Withdrawed');
    $data['TABLE_DATA']                              = $tablbe_data = $this->teams_model->GET_EMPL_CHANGEOFF($userId, $status, $limit, $offset);

    foreach ($tablbe_data as $row_shift) {
      $shift_result = $this->teams_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
      $shift_result_to = $this->teams_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift_to);

      if ($shift_result) {
        $row_shift->request_shift = $shift_result->name;
      }

      if ($shift_result_to) {
        $row_shift->request_shift_to = $shift_result_to->name;
      }
    }

    $total_count                                     = $this->teams_model->GET_EMPL_CHANGEOFF_COUNT($userId, $status);

    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
    $data['DATE_FORMAT']                              = $this->teams_model->GET_SYSTEM_SETTINGS("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/teams/team_changeoff_views', $data);
  }

  function undertime()
  {
    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);

    $data['STATUS']                                  = $status;
    $data['STATUSES']                                 = array('Pending', 'Approved', 'Rejected', 'Withdrawn');
    $data['TABLE_DATA']                              = $tablbe_data = $this->teams_model->GET_EMPL_UNDERTIME($userId, $status, $limit, $offset);

    // foreach ($tablbe_data as $row_shift) {
    //   $shift_result = $this->teams_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
    //   $shift_result_to = $this->teams_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift_to);

    //   if ($shift_result) {
    //     $row_shift->request_shift = $shift_result->name;
    //   }

    //   if ($shift_result_to) {
    //     $row_shift->request_shift_to = $shift_result_to->name;
    //   }

    // }

    $total_count                                     = $this->teams_model->GET_EMPL_UNDERTIME_COUNT($userId, $status);

    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
    $data['DATE_FORMAT']       = $this->teams_model->GET_SYSTEM_SETTINGS("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/teams/undertime_views', $data);
  }

  function request_myshift()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $user_department                        = $this->teams_model->GET_USER_DEPARMENT($user_id);
    $data['SHIFTLIST']                      = $this->teams_model->GET_ALL_SHIFTS();
    // $data['EMPLOYEES']                      = $this->teams_model->GET_EMPOLOYEES($user_id);
    $data['EMPLOYEES']                          = $this->teams_model->GET_EMPLOYEES_MEMBERS($user_id);
    $current_date                           = date('Y-m-d');
    $data['USER_DEPARTMENT']                = $user_department;
    $data['holiday_info']                   = $this->teams_model->MOD_DISP_HOLIDAY_BASED_DATE($current_date);
    $data['is_holiday']                     = !empty($data['holiday_info']);
    // var_dump($step_count);
    $this->load->view('templates/header');
    $this->load->view('modules/teams/request_changeshift_views', $data);
  }

  function request_team_change_off()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $user_department                        = $this->teams_model->GET_USER_DEPARMENT($user_id);
    $data['SHIFTLIST']                      = $this->teams_model->GET_ALL_SHIFTS();
    // $data['EMPLOYEES']                      = $this->teams_model->GET_EMPOLOYEES($user_id);
    $data['EMPLOYEES']                          = $this->teams_model->GET_EMPLOYEES_MEMBERS($user_id);
    $current_date                           = date('Y-m-d');
    $data['USER_DEPARTMENT']                = $user_department;
    $data['holiday_info']                   = $this->teams_model->MOD_DISP_HOLIDAY_BASED_DATE($current_date);
    $data['is_holiday']                     = !empty($data['holiday_info']);
    // var_dump($step_count);
    $this->load->view('templates/header');
    $this->load->view('modules/teams/request_changeoff_views', $data);
  }




  function request_undertime()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $user_department                        = $this->teams_model->GET_USER_DEPARMENT($user_id);
    $data['SHIFTLIST']                      = $this->teams_model->GET_ALL_SHIFTS();
    // $data['EMPLOYEES']                      = $this->teams_model->GET_EMPOLOYEES($user_id);
    $data['EMPLOYEES']                          = $this->teams_model->GET_EMPLOYEES_MEMBERS($user_id);
    $current_date                           = date('Y-m-d');
    $data['USER_DEPARTMENT']                = $user_department;
    $data['holiday_info']                   = $this->teams_model->MOD_DISP_HOLIDAY_BASED_DATE($current_date);
    $data['is_holiday']                     = !empty($data['holiday_info']);

    $this->load->view('templates/header');
    $this->load->view('modules/teams/request_undertime_views', $data);
  }

  function get_shift_type()
  {
    $input_data = $this->input->post();

    $data = $this->teams_model->GET_SHIFT_TYPE($input_data['empl'], $input_data['date']);
    echo json_encode($data);
  }

  function add_request_shift()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $input_data                                     = $this->input->post();
    $day_type                                       = $_POST['date_shift'];

    $input_data['status']                           = 'Pending 1';
    $approvers                                      = $this->teams_model->GET_USERS_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    // var_dump($approvers);
    $approver                                       = $approvers && $approvers->checked_by ? $approvers->checked_by : 0;
    $autoApprovedEnabled  = $this->teams_model->getApprovalsAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('teams/request_myshift');
    }
    if (
      $autoApprovedEnabled ||
      ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0))
    ) {
      $input_data['status'] = 'Approved';
    }

    if ($input_data['current_shift'] == 'No shift assign' || $input_data['current_shift'] == '') {
      $this->session->set_flashdata("ERR", "Missing Shift. Please check shifts first then try again");
      redirect('teams/request_myshift');
    }
    $input_data['approver1'] = $approvers || $approvers->approver_1a ? $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers || $approvers->approver_2a ? $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers || $approvers->approver_3a ? $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers || $approvers->approver_4a ? $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers || $approvers->approver_5a ? $approvers->approver_5a : 0;

    $input_data['approver1_b'] = $approvers || $approvers->approver_1b ? $approvers->approver_1b : 0;
    $input_data['approver2_b'] = $approvers || $approvers->approver_2b ? $approvers->approver_2b : 0;
    $input_data['approver3_b'] = $approvers || $approvers->approver_3b ? $approvers->approver_3b : 0;
    $input_data['approver4_b'] = $approvers || $approvers->approver_4b ? $approvers->approver_4b : 0;
    $input_data['approver5_b'] = $approvers || $approvers->approver_5b ? $approvers->approver_5b : 0;

    $res                = $this->teams_model->ADD_CHANGESHIFT_REQUEST($input_data);

    if ($res && $input_data['status'] == 'Approved') {
      $this->teams_model->UPDATE_CHANGESHIFT($input_data['empl_id'], $input_data['date_shift'], $input_data['request_shift']);
    }

    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->teams_model->GET_REQUESTORS('shiftrequest', $res);
      $description    = "Change Shift Application Review for [CSH" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $token['type']          = 'approval';
      $token['table']         = 'tbl_attendance_changeshift';
      $token['id']            = $res;
      $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));
      $token['approver']              = 'approver1';
      $token['id']                    = $res;
      $token['approver_id']           = $input_data['approver1'];
      $token['approver_date_col']     = 'approver1_date';
      $json_token                     =  json_encode($token);
      $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['approver1'],
        'type' => 'changeshift_approval',
        'content_id' => $res,
        'location' => 'selfservices/changeshift_approval',
        'description' => $description
      );
      $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
      $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
      $notif = $this->teams_model->ADD_NOTIFICATIONS($notif_data);
    }

    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed team shift change request');
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('teams/mychange_shift');
      return;
    }

    $this->session->set_flashdata('ERR', 'Fail to add new data');
    redirect('teams/request_myshift');
  }

  function add_request_change_off()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $input_data                                     = $this->input->post();
    $day_type                                       = $_POST['date_shift'];

    $input_data['status']                           = 'Pending 1';
    $approvers                                      = $this->teams_model->GET_USERS_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    // var_dump($approvers);
    $approver                                       = $approvers && $approvers->checked_by ? $approvers->checked_by : 0;
    $autoApprovedEnabled  = $this->teams_model->getApprovalsAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('teams/request_myshift');
    }
    if (
      $autoApprovedEnabled ||
      ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0))
    ) {
      $input_data['status'] = 'Approved';
    }

    if ($input_data['current_shift'] == 'No shift assign' || $input_data['current_shift'] == '' || $input_data['current_shift_to'] == 'No shift assign' ||  $input_data['current_shift_to'] == '') {
      $this->session->set_flashdata("ERR", "Missing Shift. Please check shifts first then try again");
      redirect('teams/request_myshift');
    }

    $input_data['approver1'] = $approvers || $approvers->approver_1a ? $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers || $approvers->approver_2a ? $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers || $approvers->approver_3a ? $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers || $approvers->approver_4a ? $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers || $approvers->approver_5a ? $approvers->approver_5a : 0;

    $input_data['approver1_b'] = $approvers || $approvers->approver_1b ? $approvers->approver_1b : 0;
    $input_data['approver2_b'] = $approvers || $approvers->approver_2b ? $approvers->approver_2b : 0;
    $input_data['approver3_b'] = $approvers || $approvers->approver_3b ? $approvers->approver_3b : 0;
    $input_data['approver4_b'] = $approvers || $approvers->approver_4b ? $approvers->approver_4b : 0;
    $input_data['approver5_b'] = $approvers || $approvers->approver_5b ? $approvers->approver_5b : 0;

    $res                = $this->teams_model->ADD_CHANGEOFF_REQUEST($input_data);


    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->teams_model->GET_REQUESTORS('changeOff', $res);
      $description    = "Change ofF Application Review for [CSH" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $token['type']          = 'approval';
      $token['table']         = 'tbl_attendance_changeoff';
      $token['id']            = $res;
      $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));
      $token['approver']              = 'approver1';
      $token['id']                    = $res;
      $token['approver_id']           = $input_data['approver1'];
      $token['approver_date_col']     = 'approver1_date';
      $json_token                     =  json_encode($token);
      $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['approver1'],
        'type' => 'changeoff_approval',
        'content_id' => $res,
        'location' => 'selfservices/changeoff_approval',
        'description' => $description
      );
      $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
      $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
      $notif = $this->teams_model->ADD_NOTIFICATIONS($notif_data);
    }

    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed team change-off request');
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('teams/team_change_off');
      return;
    }

    $this->session->set_flashdata('ERR', 'Fail to add new data');
    redirect('teams/request_team_change_off');
  }


  function add_request_undertime()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $input_data                                     = $this->input->post();
    $day_type                                       = $_POST['date_shift'];

    $input_data['status']                           = 'Pending 1';
    $approvers                                      = $this->teams_model->GET_USERS_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    // var_dump($approvers);
    $approver                                       = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $autoApprovedEnabled  = $this->teams_model->getApprovalsAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('teams/request_myshift');
    }
    if (
      $autoApprovedEnabled ||
      ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0))
    ) {
      $input_data['status'] = 'Approved';
    }

    // if($input_data['current_shift'] == 'No shift assign' || $input_data['current_shift'] == '' || $input_data['current_shift_to'] == 'No shift assign' ||  $input_data['current_shift_to'] == ''){
    //   $this->session->set_flashdata("ERR", "Missing Shift. Please check shifts first then try again");
    //   redirect('teams/request_myshift');
    // }

    $input_data['approver1'] = $approvers || $approvers->approver_1a ? $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers || $approvers->approver_2a ? $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers || $approvers->approver_3a ? $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers || $approvers->approver_4a ? $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers || $approvers->approver_5a ? $approvers->approver_5a : 0;

    $input_data['approver1_b'] = $approvers || $approvers->approver_1b ? $approvers->approver_1b : 0;
    $input_data['approver2_b'] = $approvers || $approvers->approver_2b ? $approvers->approver_2b : 0;
    $input_data['approver3_b'] = $approvers || $approvers->approver_3b ? $approvers->approver_3b : 0;
    $input_data['approver4_b'] = $approvers || $approvers->approver_4b ? $approvers->approver_4b : 0;
    $input_data['approver5_b'] = $approvers || $approvers->approver_5b ? $approvers->approver_5b : 0;

    $res                = $this->teams_model->ADD_UNDERTIME_REQUEST($input_data);


    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->selfservices_model->GET_REQUESTOR('undertimeRequest', $res);
      $description    = "Undertime Application Review for [UND" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $token['type']          = 'undertime';
      $token['table']         = 'tbl_attendance_undertime';
      $token['id']            = $res;
      $token['approver']              = 'approver1';
      $token['id']                    = $res;
      $token['approver_id']           = $input_data['approver1'];
      $token['approver_date_col']     = 'approver1_date';
      $json_token                     =  json_encode($token);
      $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['approver1'],
        'type' => 'undertime',
        'content_id' => $res,
        'location' => 'selfservices/my_undetime',
        'description' => $description
      );
      $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
      $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
      $notif = $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed team undertime request');
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('teams/undertime');
      return;
    }

    $this->session->set_flashdata('ERR', 'Fail to add new data');
    redirect('teams/request_undertime');
  }



  function changeshift_withdraw($id)
  {
    $this->teams_model->CHANGESHIFT_WITHDRAW($id);
    $this->session->set_flashdata('SUCC', 'Change shift request has been Withdrawn!');
    redirect('teams/mychange_shift');
  }

  function changeoff_withdraw($id)
  {
    $this->teams_model->CHANGEOFF_WITHDRAW($id);
    $this->session->set_flashdata('SUCC', 'Change off request has been Withdrawn!');
    redirect('teams/team_change_off');
  }



  function undertime_withdraw($id)
  {
    $this->teams_model->UNDERTIME_WITHDRAW($id);
    $this->session->set_flashdata('SUCC', 'Undertime request has been Withdrawn!');
    redirect('teams/undertime');
  }

  function apply_offsets()
  {
    $data['LEAVES']                     = array();
    $status                             = $this->input->get('status');
    $limit                              = $this->input->get('row') ? $this->input->get('row')  : 50;
    $page                                = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                             =  $limit * ($page - 1);
    $search                             = $this->input->get('search');
    $user_id                              = $this->session->userdata('SESS_USER_ID');
    $filter_arr                         = array();
    $filter_arr['company']              = $this->input->get('company');
    $filter_arr['branch']                = $this->input->get('branch');
    $filter_arr['dept']                 = $this->input->get('dept');
    $filter_arr['div']                  = $this->input->get('div');
    $filter_arr['clubhouse']             = $this->input->get('clubhouse');
    $filter_arr['section']              = $this->input->get('section');
    $filter_arr['group']                 = $this->input->get('group');
    $filter_arr['team']                  = $this->input->get('team');
    $filter_arr['line']                  = $this->input->get('line');

    $data['STATUS']                       = $status;
    $data['STATUSES']                     = array('Pending', 'Withdrawed', 'Approved', 'Rejected', 'Withdraw');

    $data['DEPARTMENTS']                 = $this->teams_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES']                   = $this->teams_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES']                    = $this->teams_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS']                   = $this->teams_model->GET_STD_DATA('tbl_std_divisions');
    $data['CLUBHOUSE']                   = $this->teams_model->GET_STD_DATA('tbl_std_clubhouse');
    $data['SECTIONS']                    = $this->teams_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS']                      = $this->teams_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS']                       = $this->teams_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES']                       = $this->teams_model->GET_STD_DATA('tbl_std_lines');

    $data['DISP_VIEW_COMPANY']              = $this->teams_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']               = $this->teams_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']           = $this->teams_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']             = $this->teams_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']            = $this->teams_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']              = $this->teams_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                = $this->teams_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                 = $this->teams_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                 = $this->teams_model->GET_SYSTEM_SETTING("com_line");
    // $data['DISP_VIEW_REQUIREDAPPROVERS']        = $this->teams_model->GET_SYSTEM_SETTING("requireApprovers");
    $data['DISP_VIEW_REQUIREDAPPROVERS']        = 1;
    // $data['LEAVES']                   = $this->teams_model->GET_LEAVES2($status, $search, $limit, $offset, $filter_arr, $user_id);
    $data['TABLE_DATA']               = $this->teams_model->GET_OFFSETS($status, $search, $limit, $offset, $filter_arr, $user_id);

    $total_count                      = $this->teams_model->GET_OFFSET_COUNT($search, $status, $filter_arr, $user_id);
    $excess                           = $total_count % $limit;
    $data['C_DATA_COUNT']             = $total_count;
    $data['PAGES_COUNT']              = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                     = $page;
    $data['ROW']                      = $limit;
    $data['C_ROW_DISPLAY']            = array(50);
    $data['DISP_EMPLOYEES_NONFILTERED']     = $this->teams_model->MOD_DISP_ALL_EMPLOYEES($user_id);

    $data['EMPLOYEES']                          = $this->teams_model->GET_EMPLOYEES_MEMBERS($user_id);
    $data['DATE_FORMAT']       = $this->teams_model->GET_DATE_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/teams/apply_offset_views', $data);
  }

  function get_acquired_hours_summary()
  {
    $user_id = $this->session->userdata('SESS_USER_ID');

    $totalHours = $this->teams_model->DISP_TOTAL_ACQUIRED_OFFSET($user_id);
    $employeeData = $this->teams_model->DISP_EMPLOYEE_ACQUIRED_OFFSET($user_id);

    echo json_encode([
      'total_acquired_offset' => $totalHours->total_acquired_offset ?? 0,
      'employee_data' => $employeeData
    ]);
  }


  function apply_leaves()
  {
    $data['LEAVES']                     = array();
    $status                             = $this->input->get('status');
    $limit                              = $this->input->get('row') ? $this->input->get('row')  : 50;
    $page                                = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                             =  $limit * ($page - 1);
    $search                             = $this->input->get('search');
    $user_id                              = $this->session->userdata('SESS_USER_ID');
    $filter_arr                         = array();
    $filter_arr['company']              = $this->input->get('company');
    $filter_arr['branch']                = $this->input->get('branch');
    $filter_arr['dept']                 = $this->input->get('dept');
    $filter_arr['div']                  = $this->input->get('div');
    $filter_arr['clubhouse']             = $this->input->get('clubhouse');
    $filter_arr['section']              = $this->input->get('section');
    $filter_arr['group']                 = $this->input->get('group');
    $filter_arr['team']                  = $this->input->get('team');
    $filter_arr['line']                  = $this->input->get('line');

    $data['STATUS']                       = $status;
    $data['STATUSES']                     = array('Pending', 'Withdrawed', 'Approved', 'Rejected');

    $data['DEPARTMENTS']                 = $this->teams_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES']                   = $this->teams_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES']                    = $this->teams_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS']                   = $this->teams_model->GET_STD_DATA('tbl_std_divisions');
    $data['CLUBHOUSE']                   = $this->teams_model->GET_STD_DATA('tbl_std_clubhouse');
    $data['SECTIONS']                    = $this->teams_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS']                      = $this->teams_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS']                       = $this->teams_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES']                       = $this->teams_model->GET_STD_DATA('tbl_std_lines');

    $data['DISP_VIEW_COMPANY']              = $this->teams_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']               = $this->teams_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']           = $this->teams_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']             = $this->teams_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']            = $this->teams_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']              = $this->teams_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                = $this->teams_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                 = $this->teams_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                 = $this->teams_model->GET_SYSTEM_SETTING("com_line");
    // $data['DISP_VIEW_REQUIREDAPPROVERS']        = $this->teams_model->GET_SYSTEM_SETTING("requireApprovers");
    $data['DISP_VIEW_REQUIREDAPPROVERS']        = 1;
    $data['LEAVES']                   = $this->teams_model->GET_LEAVES2($status, $search, $limit, $offset, $filter_arr, $user_id);

    $total_count                 = $this->teams_model->GET_LEAVES_COUNT($search, $status, $filter_arr, $user_id);
    $excess                      = $total_count % $limit;
    $data['C_DATA_COUNT']             = $total_count;
    $data['PAGES_COUNT']              = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                     = $page;
    $data['ROW']                      = $limit;
    $data['C_ROW_DISPLAY']            = array(50);
    $data['DISP_EMPLOYEES_NONFILTERED']     = $this->teams_model->MOD_DISP_ALL_EMPLOYEES($user_id);

    $data['EMPLOYEES']                          = $this->teams_model->GET_EMPLOYEES_MEMBERS($user_id);
    $data['DATE_FORMAT']       = $this->teams_model->GET_DATE_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/teams/apply_leave_views', $data);
  }

  function add_new_offset()
  {
    $user_id                            = $this->session->userdata('SESS_USER_ID');
    $isApproversEnable                  = $this->selfservices_model->GET_SETUP_SETTING('requireApprovers');
    // $attachment                         = $_FILES['attachment']['name'];
    $input_data                         = $this->input->post();
    $date = $input_data['offset_date'];
    if (preg_match('/^\d{1,3}-\d{2}-\d{2}$/', $date) || preg_match('/^\d{5,}-\d{2}-\d{2}$/', $date)) {
      $this->session->set_flashdata('ERR', "Invalid Date. Please fix and try again");
      redirect('teams/apply_offsets');
    }

    $input_data['assigned_by']          = $user_id;
    // $input_data['empl_id']              = $empl_id;
    // $input_data['status']               = $isApproversEnable == 1 ? 'Pending 1' : 'Approved';
    $input_data['status']               = 'Pending 1';
    // $file_info = pathinfo($attachment);
    $input_data['create_date']                        = date('Y-m-d H:i:s');
    $input_data['edit_date']                          = date('Y-m-d H:i:s');
    $employee                                         = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
    $approvers = $this->selfservices_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');

    $approver = $approvers->approver_1a ? $approvers->approver_1a : 0;

    $input_data['approver1'] = $approvers || $approvers->approver_1a ? $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers || $approvers->approver_2a ? $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers || $approvers->approver_3a ? $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers || $approvers->approver_4a ? $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers || $approvers->approver_5a ? $approvers->approver_5a : 0;

    $input_data['approver1_b'] = $approvers || $approvers->approver_1b ? $approvers->approver_1b : 0;
    $input_data['approver2_b'] = $approvers || $approvers->approver_2b ? $approvers->approver_2b : 0;
    $input_data['approver3_b'] = $approvers || $approvers->approver_3b ? $approvers->approver_3b : 0;
    $input_data['approver4_b'] = $approvers || $approvers->approver_4b ? $approvers->approver_4b : 0;
    $input_data['approver5_b'] = $approvers || $approvers->approver_5b ? $approvers->approver_5b : 0;

    // if ($approver == 0) {
    //   $this->session->set_flashdata('ERR', 'No Approver Assign');
    //   redirect('teams/request_offset');
    //   return;
    // }

    if (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0))) {
      $this->session->set_flashdata('ERR', 'No Approver. Please add approver first then try again');
      return;
    }

    $is_duplicate                                     = $this->selfservices_model->GET_OFFSETS_IS_DUPLICATE_DATE_EMPL_ID($input_data['offset_type'], $input_data['offset_date'], $user_id);

    if ($is_duplicate > 0) {
      $this->session->set_flashdata('ERR', "Offset submission failed. It looks like you have already submitted a offset request for the same dates.");
      redirect('teams/apply_offsets');
      return;
    } else {
      $res                                            = $this->selfservices_model->ADD_OFFSET_REQUEST($input_data);
      if ($res) {
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed team offset request');
        $this->session->set_flashdata('SUCC', 'Successfully added');
        if ($isApproversEnable == 0) {
          redirect('teams/apply_offsets');
          return;
        }
        $requestor      = $this->selfservices_model->GET_REQUESTOR('offsets', $res);
        $description    = "Offset Application Review for [OFF" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
        $notif_data     = array(
          'create_date' => date('Y-m-d H:i:s'),
          'empl_id' => $approvers->approver_1a,
          'type' => 'offset',
          'content_id' => $res,
          'location' => 'selfservices/offset_approval',
          'description' => $description
        );
        $notif = $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      } else {
        $this->session->set_flashdata('ERR', 'Fail to add new data');
        redirect('teams/apply_offsets');
        return;
      }
    }
    redirect('teams/apply_offsets');
  }

  function add_team_leaves_api()
  {
    $user_id                              = $this->session->userdata('SESS_USER_ID');
    $input_data                           = $this->input->post();
    $messageError                         = '';
    $empl_id                              = $input_data['empl_id'];
    $type                                 = $input_data['type'];
    $dates                                = $this->input->post('dates');
    $hours                                = $this->input->post('hours');
    $leave_range                          = $this->input->post('leave_range');
    $current_shift                         = $this->input->post('current_shift');

    $typeName = $this->selfservices_model->get_leave_type_name_by_id($type);
    if (
      $typeName == 'Service Incentive Leave (SIL)' || $typeName == 'Vacation Leave' || $typeName == 'Sick Leave' || $typeName == 'Bereavement Leave'
      || $typeName == 'Maternity Leave' || $typeName == 'Paternity Leave' || $typeName == 'Solo-Parent Leave' || $typeName == 'Marriage Leave' || $typeName == 'Wedding Leave'
      || $typeName == 'Emergency Leave' || $typeName == 'Leave without Pay (LWOP)' || $typeName == 'Offset'
    ) {
      $display_attachment = $this->selfservices_model->SHOW_HIDE_ATTACHMENT($type);
      $display_reason = $this->selfservices_model->SHOW_HIDE_REASON($type);
    } else {
      $display_attachment = $this->selfservices_model->get_leave_setting2('other_attachment');
      $display_reason = $this->selfservices_model->get_leave_setting2('other_reason');
    }

    if (!$input_data['reason'] && $display_reason == 1) {
      echo json_encode(array('messageError' =>  'Reason is required.'));
      return;
    }

    if (!$input_data['attachment'] && $display_attachment == 1) {
      echo json_encode(array('messageError' => 'Attachment is required.'));
      return;
    }

    // Today minus 2 days
    $min_allowed_date = date('Y-m-d', strtotime('-2 days'));

    unset($input_data['dates']);
    unset($input_data['hours']);
    unset($input_data['leave_range']);
    if (!(!empty($dates) && !empty($hours) && count($dates) == count($hours))) {
      echo json_encode(array('messageError' => 'Missing Dates and or Hours. Please refresh and try again'));
      return;
    }

    $firstDate = $dates[0];
    $firstDateParts = explode('-', $firstDate);
    $firstYear = $firstDateParts[0];
    $totalHours = 0;

    for ($i = 0; $i < count($dates); $i++) {

      if ($dates[$i] < $min_allowed_date) {
        $formatted_date = date('m/d/Y', strtotime($dates[$i]));
        echo json_encode(array('messageError' => 'Past leaves must be filed within 2 days.'));
        return;
      }

      if ($i > 0) {
        $dateParts = explode('-', $dates[$i]);
        if ($firstYear != $dateParts[0]) {
          $messageError = "Found year: " . $firstYear . " and " . $dateParts[0] . "." . " You can only apply leaves in the same year";
          echo json_encode(array('messageError' => $messageError . ' . Please fix and try again'));
          return;
        }
      }
      $isLeaveHours  = $this->leaves_model->get_leaves_settings_by_setting('isLeaveHours', '1');
      $input_data['leave_date']   = $dates[$i];
      $is_duplicate = $this->selfservices_model->GET_IS_DUPLICATE_DATE_EMPL_ID($input_data['leave_date'], $input_data['empl_id']);
      if ($is_duplicate > 0) {
        if (empty($messageError)) {
          $messageError = 'Already applied for date/s: ' . $dates[$i];
          echo json_encode(array('messageError' => $messageError . ' . Please fix and try again'));
          return;
        } else {
          $messageError = $messageError . ', ' . $dates[$i];
          echo json_encode(array('messageError' => $messageError . ' . Please fix and try again'));
          return;
        }
      }

      if ($isLeaveHours) {
        $totalHours = $totalHours + $hours[$i];
      } else {
        $totalHours = $totalHours + ($hours[$i] * 8);
      }
    }

    $dateStart = date("Y-m-d", strtotime($firstYear . "-01-01"));
    $dateEnd = date("Y-m-d", strtotime($firstYear . "-12-31"));
    $leavesTotal =  $this->selfservices_model->get_leaves_total($empl_id, $type, $dateStart, $dateEnd);
    $leaveEntitlementValue = 0;
    $leaveEntitlement = 'Auto';

    $display_attachment = $this->selfservices_model->SHOW_HIDE_ATTACHMENT($type);

    if (!$typeName) {
      echo json_encode(array('messageError' => 'Unexpected Error. Leave Type not found'));
      return;
    }

    $display_credit = $this->selfservices_model->SHOW_HIDE_CREDITS($type);
    if ($typeName == "Offset") {
      $leaveEntitlement =  $this->selfservices_model->get_offset_approve_count($empl_id);
      if ($leaveEntitlement) {
        $leaveEntitlementValue = $leaveEntitlement['value'];
      }
      $balance = $leaveEntitlementValue - $leavesTotal;
      if (!($balance >= $totalHours)) {
        if ($isLeaveHours != 0) {
          $projectedHours = $balance - $totalHours;
          echo json_encode(array('messageError' => "Insufficient Balance. Your balance is: " . $balance . " and your total hours applying is: " . $totalHours . " which equal to " . $projectedHours . " projected hours"));
          return;
        } else {
          if ($balance < 8) {
            $dividedValue = $balance >= 4 ? 0.5 : 0;
          } else {
            $dividedValue = floor($balance / 8);
            if ($balance % 8 >= 4) {
              $dividedValue += 0.5;
            }
          }
          $balance = $dividedValue;

          if ($totalHours < 8) {
            $dividedHours = $totalHours >= 4 ? 0.5 : 0;
          } else {
            $dividedHours = floor($totalHours / 8);
            if ($totalHours % 8 >= 4) {
              $dividedHours += 0.5;
            }
          }
          $totalHours = $dividedHours;
          $projectedHours = $balance - $totalHours;
          echo json_encode(array('messageError' => "Insufficient Balance. Your balance is: " . $balance . " and your total days applying is: " . $totalHours . " which equal to " . $projectedHours . " projected days"));
          return;
        }
      }
    } else if ($typeName != 'Leave without Pay (LWOP)' && $display_credit == 1) {
      $leaveSetting =  $this->selfservices_model->GET_SETUP_SETTING('leave_setting');
      if ($leaveSetting) {
        $leaveEntitlementValue =  $this->selfservices_model->GET_SETUP_LEAVE_SETTING(str_replace(' ', '_', $typeName));
        if (!$leaveEntitlementValue) {
          $leaveEntitlementValue = 0;
        }
      } else {
        $leaveEntitlement =  $this->selfservices_model->get_leave_entitlement_by_id_typeName_year($empl_id, $typeName, $firstYear);
        if (!$leaveEntitlement) {
          $leaveEntitlementValue = 0;
        }
        $leaveEntitlementValue = $leaveEntitlement['value'];
      }
      $balance = $leaveEntitlementValue - $leavesTotal;
      if (!($balance >= $totalHours)) {

        if ($isLeaveHours != 0) {
          $projectedHours = $balance - $totalHours;
          echo json_encode(array('messageError' => "Insufficient Balance. Your balance is: " . $balance . " and your total hours applying is: " . $totalHours . " which equal to " . $projectedHours . " projected hours"));
          return;
        } else {
          if ($balance < 8) {
            $dividedValue = $balance >= 4 ? 0.5 : 0;
          } else {
            $dividedValue = floor($balance / 8);
            if ($balance % 8 >= 4) {
              $dividedValue += 0.5;
            }
          }
          $balance = $dividedValue;

          if ($totalHours < 8) {
            $dividedHours = $totalHours >= 4 ? 0.5 : 0;
          } else {
            $dividedHours = floor($totalHours / 8);
            if ($totalHours % 8 >= 4) {
              $dividedHours += 0.5;
            }
          }
          $totalHours = $dividedHours;


          $projectedHours = $balance - $totalHours;
          echo json_encode(array('messageError' => "Insufficient Balance. Your balance is: " . $balance . " and your total days applying is: " . $totalHours . " which equal to " . $projectedHours . " projected days"));
          return;
        }
      }
    }

    if (!empty($messageError)) {
      echo json_encode(array('messageError' => $messageError . ' . Please fix and try again'));
      return;
    }
    $input_data['create_date']  = date('Y-m-d H:i:s');
    $input_data['edit_date']    = date('Y-m-d H:i:s');

    $enable_nurseapproval = $this->leaves_model->get_leave_setting2('nurse_approver'); // 1
    if ($input_data['type'] == '5') {
      if ($enable_nurseapproval) {
        $input_data['status']       = 'Nurse';
      } else {
        $input_data['status']       = 'Pending 1';
      }
    } else {
      $input_data['status']       = 'Pending 1';
    }

    // $input_data['status']       = 'Pending 1';
    $input_data['assigned_by']  = $user_id;
    $input_data['parent_id']    = null;
    // $approvers = $this->teams_model->GET_USER_APPROVERS($user_id, 'tbl_approvers');
    $approvers = $this->teams_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    $is_auto_approve  = $this->teams_model->GET_LEAVE_SETTING('policy_autoapprove');
    $autoApprovedEnabled  = $this->leaves_model->getApprovalAutoApproveEnabled($input_data['empl_id']);
    if (
      $is_auto_approve != 1 && !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      echo json_encode(array('messageError' => "No Approver. Please add approver first then try again"));
      return;
    }
    if (($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)) || $is_auto_approve == 1 || !$approvers || $autoApprovedEnabled) {
      $input_data['status'] = 'Approved';
    }
    $dateCount = count($dates);
    $parent_id = 0;
    for ($i = 0; $i < $dateCount; $i++) {
      if ($dateCount > 1 && $i == 0) {
        $input_data['parent_id'] = 0;
      }
      $input_data['leave_date']   = $dates[$i];

      if (!$isLeaveHours) {
        $hours[$i] = $hours[$i] * 8;
      }
      $input_data['duration']  = $hours[$i];
      $input_data['current_shift']  = $current_shift[$i];
      $input_data['leave_range']  = $leave_range[$i];

      // $input_data['approver1']      = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0 ;
      // $input_data['approver2']      = $approvers && $approvers->approver_2a ? $approvers->approver_2a : 0 ;
      // $input_data['approver3']      = $approvers && $approvers->approver_3a ? $approvers->approver_3a : 0 ;
      // $input_data['approver4']      = $approvers && $approvers->approver_4a ? $approvers->approver_4a : 0 ;
      // $input_data['approver5']      = $approvers && $approvers->approver_5a ? $approvers->approver_5a : 0 ;

      $input_data['approver1'] = $approvers || $approvers->approver_1a ? $approvers->approver_1a : 0;
      $input_data['approver2'] = $approvers || $approvers->approver_2a ? $approvers->approver_2a : 0;
      $input_data['approver3'] = $approvers || $approvers->approver_3a ? $approvers->approver_3a : 0;
      $input_data['approver4'] = $approvers || $approvers->approver_4a ? $approvers->approver_4a : 0;
      $input_data['approver5'] = $approvers || $approvers->approver_5a ? $approvers->approver_5a : 0;

      $input_data['approver1_b'] = $approvers || $approvers->approver_1b ? $approvers->approver_1b : 0;
      $input_data['approver2_b'] = $approvers || $approvers->approver_2b ? $approvers->approver_2b : 0;
      $input_data['approver3_b'] = $approvers || $approvers->approver_3b ? $approvers->approver_3b : 0;
      $input_data['approver4_b'] = $approvers || $approvers->approver_4b ? $approvers->approver_4b : 0;
      $input_data['approver5_b'] = $approvers || $approvers->approver_5b ? $approvers->approver_5b : 0;

      // $res = $this->teams_model->ADD_LEAVE_REQUEST($input_data);
      $res  = $this->teams_model->ADD_LEAVE_REQUEST($input_data);
      if ($res) {


        if ($input_data['status'] != 'Approved' && ($input_data['parent_id'] == null || $input_data['parent_id'] == 0)) {

          $this->create_notification = function ($approver, $res, $input_data) {
            $requestor      = $this->teams_model->GET_REQUESTOR('leave', $res);
            $description    = "Leave Application Review for [LEA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
            $token['type']          = 'approval';
            $token['table']         = 'tbl_leaves_assign';
            $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));

            // $token['approver']              = 'approver1';
            // $token['approver_id']           = $input_data['approver1'];
            // $token['approver_date_col']     = 'approver1_date';
            // $token['id']                    = $res;

            $token = array(
              'approver' => $approver,
              'approver_id' => $approver,
              'approver_date_col' => $approver . '_date',
              'id' => $res
            );

            $notif_data     = array(
              'create_date' => date('Y-m-d H:i:s'),
              'empl_id' => $approver,
              'type' => 'leave_approval',
              'content_id' => $res,
              'location' => 'selfservices/leave_approval',
              'description' => $description
              // 'approve'=>'approvals/approve_request?token='.urlencode($encrypted_token),
              // 'reject'=>'approvals/reject_request?token='.urlencode($encrypted_token)
            );
            $notif = $this->teams_model->ADD_NOTIFICATION($notif_data);
          };
          $approvers_list = array(
            $input_data['approver1'],
            $input_data['approver1_b']
          );

          foreach ($approvers_list as $approver) {
            if ($approver) {
              call_user_func($this->create_notification, $approver, $res, $input_data);
            }
          }
        }
        // $input_data['parent_id'] = $res;

        if ($parent_id == 0) {
          $parent_id = $res;
        }

        $input_data['parent_id'] = $parent_id;
      } else {
        if (empty($messageError)) {
          // $messageError ='Failed to date/s: '.$dates[$i];
          $messageError = 'Failed to date/s: ' . date('d/m/Y', strtotime($dates[$i]));
        } else {
          // $messageError = $messageError.', '.$dates[$i];
          $messageError = $messageError . ', ' . date('d/m/Y', strtotime($dates[$i]));
        }
      }
    }
    if (!empty($messageError)) {
      echo json_encode(array('messageError' => $messageError . ' . Please reload page and try again'));
      return;
    }
    $this->session->set_flashdata('SUCC', 'Successfully Added');
    echo json_encode(array('messageSuccess' => 'Successfully Submitted'));
  }

  function request_leave()
  {
    $user_id                                    = $this->session->userdata('SESS_USER_ID');
    $data['EMPLOYEES']                          = $this->teams_model->GET_EMPLOYEES_MEMBERS($user_id);
    $data['LEAVE_TYPES']                        = $this->teams_model->GET_LEAVE_TYPES();
    $data['isLeaveHours']                       = $this->teams_model->get_leaves_settings_by_setting('isLeaveHours', '1');
    $this->load->view('templates/header');
    $this->load->view('modules/teams/request_leave_views', $data);
  }

  // function request_offset()
  // {
  //   $data['userId']                             = $user_id = $this->session->userdata('SESS_USER_ID');
  //   $data['EMPLOYEES']                          = $this->teams_model->GET_EMPLOYEES_MEMBERS($user_id);

  //   $data['DISP_TOTAL_OT']                = $total_ot         = $this->teams_model->GET_TOTAL_OT($user_id);
  //   $data['DISP_TOTAL_OFFSET']            = $total_offset     = $this->teams_model->GET_TOTAL_OFFSET($user_id);
  //   $data['DISP_REMAINING_OT']            = $total_ot->total_ot - $total_offset->total_offset;

  //   // $data['isLeaveHours']                       = $this->teams_model->get_leaves_settings_by_setting('isLeaveHours','1');
  //   $this->load->view('templates/header');
  //   $this->load->view('modules/teams/request_offset_views', $data);
  // }

  function redeemed_offset()
  {
    $data['userId']                                 = $user_id = $this->session->userdata('SESS_USER_ID');
    $data['EMPLOYEES']                              = $this->teams_model->GET_EMPLOYEES_MEMBERS($user_id);

    $data['DISP_TOTAL_REDEEMED_OFFSET']             = $total_redeemed     = $this->teams_model->GET_TOTAL_REDEEMED_OFFSET($user_id);
    $data['DISP_TOTAL_ACQUIRED_OFFSET']             = $total_acquired     = $this->teams_model->GET_TOTAL_ACQUIRED_OFFSET($user_id);
    $data['DISP_TOTAL_OFFSET']                      = $total_acquired->total_acquired_offset - $total_redeemed->total_redeemed_offset;

    // $data['isLeaveHours']                       = $this->teams_model->get_leaves_settings_by_setting('isLeaveHours','1');
    $this->load->view('templates/header');
    $this->load->view('modules/teams/request_offset_views', $data);
  }

  function acquire_offset()
  {
    $data['userId']                                 = $user_id = $this->session->userdata('SESS_USER_ID');
    $data['EMPLOYEES']                              = $this->teams_model->GET_EMPLOYEES_MEMBERS($user_id);

    $this->load->view('templates/header');
    $this->load->view('modules/teams/acquire_offset_request_views', $data);
  }

  function get_offset_value()
  {
    $input_data = $this->input->post();

    // $total_ot                             = $this->teams_model->GET_TOTAL_OT($input_data['empl']);
    // $total_offset                         = $this->teams_model->GET_TOTAL_OFFSET($input_data['empl']);
    // $data['DISP_REMAINING_OT']            = $total_ot->total_ot - $total_offset->total_offset;

    // $data['DISP_TOTAL_REDEEMED_OFFSET']            = $total_redeemed     = $this->teams_model->GET_TOTAL_REDEEMED_OFFSET($input_data['empl']);
    // $data['DISP_TOTAL_ACQUIRED_OFFSET']            = $total_acquired     = $this->teams_model->GET_TOTAL_ACQUIRED_OFFSET($input_data['empl']);
    // $data['DISP_TOTAL_OFFSET']                     = $total_acquired->total_acquired_offset - $total_redeemed->total_redeemed_offset;

    $total_redeemed                                     = $this->teams_model->GET_TOTAL_REDEEMED_OFFSET($input_data['empl']);
    $total_acquired                                     = $this->teams_model->GET_TOTAL_ACQUIRED_OFFSET($input_data['empl']);

    $expired_acquired_offset                            = $total_acquired->expired_acquired_offset ?? 0;
    $available_offset                                   = ($total_acquired->total_acquired_offset - $expired_acquired_offset) - $total_redeemed->total_redeemed_offset;

    $data['DISP_TOTAL_REDEEMED_OFFSET']                 = $total_redeemed->total_redeemed_offset;
    $data['DISP_TOTAL_ACQUIRED_OFFSET']                 = $total_acquired->total_acquired_offset;
    $data['DISP_TOTAL_OFFSET']                          = max(0, $available_offset);

    $data['employee_id'] = $input_data['empl'];

    echo json_encode($data);
  }

  function get_attendance_record()
  {
    $input_data                                          = $this->input->post();
    $empl_id                                             = $input_data['empl'];
    $date                                                = $input_data['date'];

    $data['attendance']                                  = $this->teams_model->GET_ATTENDANCE_RECORD($empl_id, $date);

    echo json_encode($data);
  }

  function add_new_leave()
  {
    $isApproversEnable                  = $this->teams_model->GET_SYSTEM_SETTING('requireApprovers');
    $user_id                            = $this->session->userdata('SESS_USER_ID');
    // $attachment                         = $_FILES['attachment']['name'];
    $input_data                         = $this->input->post();
    $input_data['assigned_by']          = $user_id;
    $input_data['status']               = $isApproversEnable == 1 ? 'Pending 1' : 'Approved';
    // $file_info = pathinfo($attachment);
    $input_data['create_date']                        = date('Y-m-d H:i:s');
    $input_data['edit_date']                          = date('Y-m-d H:i:s');
    $employee                                         = $this->teams_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
    $approvers = $this->teams_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    $approver = $approvers->approver_1a ? $approvers->approver_1a : 0;
    // if ($approver == 0) {
    //   $this->session->set_flashdata('ERR', 'No Approver Assign');
    //   redirect('teams/request_leave');
    //   return;
    // }
    if (($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)) || $is_auto_approve == 1 || !$approvers) {
      $input_data['status'] = 'Approved';
    }
    $dates = $this->input->post('dates');
    $hours = $this->input->post('hours');
    $leave_range = $this->input->post('leave_range');

    unset($input_data['dates']);
    unset($input_data['hours']);
    unset($input_data['leave_range']);

    if (!empty($dates) && !empty($hours) && count($dates) == count($hours)) {
      $added = [];
      $notAdded = [];
      for ($i = 0; $i < count($dates); $i++) {
        $input_data['leave_date']   = $dates[$i];
        $input_data['duration']  = $hours[$i];
        $input_data['leave_range']  = $leave_range[$i];
        $input_data['approver1']      = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
        $input_data['approver2']      = $approvers && $approvers->approver_2a ? $approvers->approver_2a : 0;
        $input_data['approver3']      = $approvers && $approvers->approver_3a ? $approvers->approver_3a : 0;
        $input_data['approver4']      = $approvers && $approvers->approver_4a ? $approvers->approver_4a : 0;
        $input_data['approver5']      = $approvers && $approvers->approver_5a ? $approvers->approver_5a : 0;
        $is_duplicate = $this->teams_model->GET_IS_DUPLICATE_DATE($input_data['empl_id'], $input_data['leave_date']);
        if ($is_duplicate > 0) {
          $notAdded[] = 'Date: ' . $dates[$i] . '(Duplicate)';
          continue;
        }
        $res  = $this->teams_model->ADD_LEAVE_REQUEST($input_data);
        if ($res) {
          $added[] = 'Date: ' . $dates[$i];
          $requestor      = $this->teams_model->GET_REQUESTOR('leave', $res);
          $description    = "Leave Application Review for [LEA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
          $token['type']          = 'approval';
          $token['table']         = 'tbl_leaves_assign';
          $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));
          $token['approver']              = 'approver1';
          $token['approver_id']           = $input_data['approver1'];
          $token['approver_date_col']     = 'approver1_date';
          $token['id']                    = $res;
          $json_token                     =  json_encode($token);
          $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
          $notif_data     = array(
            'create_date' => date('Y-m-d H:i:s'),
            'empl_id' => $input_data['approver1'],
            'type' => 'leave',
            'content_id' => $res,
            'location' => 'selfservices/leave_approval',
            'description' => $description,
            'approve' => 'approvals/approve_request?token=' . urlencode($encrypted_token),
            'reject' => 'approvals/reject_request?token=' . urlencode($encrypted_token)
          );

          $notif = $this->teams_model->ADD_NOTIFICATION($notif_data);
        } else {
          $notAdded[] = 'Date: ' . $dates[$i];
        }
      }

      $joinedAdded = '';
      $joinedNotAdded = '';
      if (count($added) > 0 && count($notAdded) < 1) {
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed team leave request');
        $joinedAdded = implode(', ', $added);
        $this->session->set_flashdata('SUCC', 'Successfully added: ' . $joinedAdded);
        redirect('teams/apply_leaves');
      } else {
        $joinedNotAdded = implode(', ', $notAdded);
        $joinedAdded = implode(', ', $added);
        if ($joinedAdded) {
          $this->session->set_flashdata('ERR', 'Successfully added: ' . $joinedAdded . '. But failed to add: ' . $joinedNotAdded);
        } else {
          $this->session->set_flashdata('ERR', 'Unable to add: ' . $joinedNotAdded);
        }
        redirect('teams/request_leave');
      }
    } else {
      $this->session->set_flashdata('ERR', 'Unable to add: No Dates Submitted');
      redirect('teams/request_leave');
    }

    // $is_duplicate                                     = $this->teams_model->GET_IS_DUPLICATE_DATE($input_data['empl_id'], $input_data['leave_date']);
    // echo '<pre>';
    // var_dump($is_duplicate);
    // return;

    // if ($is_duplicate > 0) {
    //   $this->session->set_flashdata('ERR', "Leave submission failed. It looks like you have already submitted a leave request for the same dates.");
    //   redirect('teams/request_leave');
    //   return;
    // } else {
    //   $res                                            = $this->teams_model->ADD_LEAVE_REQUEST($input_data);
    //   if ($res) {
    //     $this->session->set_flashdata('SUCC', 'Successfully added');
    //     if ($isApproversEnable == 0) {
    //       redirect('teams/apply_leaves');
    //       return;
    //     }
    //     $requestor      = $this->teams_model->GET_REQUESTOR('leave', $res);
    //     $description    = "Leave Application Review for [LEA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
    //     $notif_data     = array(
    //       'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $approvers->approver_1a, 'type' => 'leave',
    //       'content_id' => $res, 'location' => 'selfservices/leave_approval', 'description' => $description
    //     );
    //     $notif = $this->teams_model->ADD_NOTIFICATION($notif_data);
    //   } else {
    //     $this->session->set_flashdata('ERR', 'Fail to add new data');
    //     redirect('teams/request_leave');
    //     return;
    //   }
    // }
    // redirect('teams/apply_leaves');
    redirect('teams/apply_leaves');
  }
  function new_request_leave_direct()
  {
    $user_id                                    = $this->session->userdata('SESS_USER_ID');
    $data['DISP_EMPLOYEES_NONFILTERED']         = $this->teams_model->MOD_DISP_ALL_EMPLOYEES($user_id);
    $this->load->view('templates/header');
    $this->load->view('modules/teams/new_leave_request_direct_views', $data);
  }


  function apply_overtimes()
  {
    $data['TABLE_DATA']                     =  array();
    $status                                 =  $this->input->get('status');
    $limit                                  =  $this->input->get('row') ? $this->input->get('row')  : 50;
    $page                                   =  $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                 =  $limit * ($page - 1);
    $search                                 = $this->input->get('search');
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $filter_arr                             = array();
    $filter_arr['company']                  = $this->input->get('company');
    $filter_arr['branch']                   = $this->input->get('branch');
    $filter_arr['dept']                     = $this->input->get('dept');
    $filter_arr['div']                      = $this->input->get('div');
    $filter_arr['clubhouse']                = $this->input->get('clubhouse');
    $filter_arr['section']                  = $this->input->get('section');
    $filter_arr['group']                    = $this->input->get('group');
    $filter_arr['team']                     = $this->input->get('team');
    $filter_arr['line']                     = $this->input->get('line');

    $data['DISP_VIEW_REQUIREDAPPROVERS']    = 1; //$this->teams_model->GET_SYSTEM_SETTING("requireApprovers");
    // $total_count                            = $this->teams_model->GET_OVERTIMES_COUNT_DIRECT($status, $search, $filter_arr, $user_id);
    $total_count                            = $this->teams_model->GET_OVERTIMES_DIRECT_COUNT($status, $search, $filter_arr, $user_id);

    $employee_list_setup = $this->teams_model->GET_SYSTEM_SETTING("employee_list");

    if ($employee_list_setup == 'showAll') {
      $data['TABLE_DATA']                     = $this->teams_model->GET_OVERTIMES_ALL($status, $search, $limit, $offset, $filter_arr, $user_id);
    } else if ($employee_list_setup == 'membersOnly') {
      $data['TABLE_DATA']                     = $this->teams_model->GET_OVERTIMES_DIRECT($status, $search, $limit, $offset, $filter_arr, $user_id);
    }

    //     if ($data['DISP_VIEW_REQUIREDAPPROVERS'] == 0) {
    // 			$data['TABLE_DATA']                     = $this->teams_model->GET_OVERTIMES_DIRECT($status, $search, $limit, $offset, $filter_arr,$user_id);
    //       $total_count                            = $this->teams_model->GET_OVERTIMES_COUNT_DIRECT($status, $search, $filter_arr,$user_id);
    // 		} else {
    //       $data['TABLE_DATA']                     = $this->teams_model->GET_OVERTIMES($status, $search, $limit, $offset, $filter_arr,$user_id);
    //       $total_count                            = $this->teams_model->GET_OVERTIMES_COUNT($status, $search, $filter_arr,$user_id);
    // 		}

    $data['STATUS']                         = $status;
    $data['STATUSES']                       = array('Pending', 'Approved', 'Rejected', 'Withdrawn');
    $excess                                 = $total_count % $limit;
    $data['C_DATA_COUNT']                   = $total_count;
    $data['PAGES_COUNT']                    = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                           = $page;
    $data['ROW']                            = $limit;
    $data['C_ROW_DISPLAY']                  = array(50);

    $data['DEPARTMENTS']                    = $this->teams_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES']                      =   $this->teams_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES']                       =   $this->teams_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS']                      =   $this->teams_model->GET_STD_DATA('tbl_std_divisions');
    $data['CLUBHOUSE']                   = $this->teams_model->GET_STD_DATA('tbl_std_clubhouse');
    $data['SECTIONS']                       =   $this->teams_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS']                         =   $this->teams_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS']                          =   $this->teams_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES']                          =   $this->teams_model->GET_STD_DATA('tbl_std_lines');
    $data['DISP_VIEW_COMPANY']              = $this->teams_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']               = $this->teams_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']           = $this->teams_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']             = $this->teams_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']            = $this->teams_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']              = $this->teams_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                = $this->teams_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                 = $this->teams_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                 = $this->teams_model->GET_SYSTEM_SETTING("com_line");
    // $data['EMPLOYEES']                      = $this->teams_model->GET_EMPLOYEES($user_id);
    $data['EMPLOYEES']                          = $this->teams_model->GET_EMPLOYEES($user_id);

    $this->load->view('templates/header');
    $this->load->view('modules/teams/apply_overtime_views', $data);
  }
  function request_overtime()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $employee_list_setup = $this->teams_model->GET_SYSTEM_SETTING("employee_list");
    $data['disable_overtime_hours']         = $this->teams_model->get_system_setup_by_setting('disable_overtime_hours', '0');
    if ($employee_list_setup == 'showAll') {
      $data['EMPLOYEES']                          = $this->teams_model->GET_EMPLOYEES_ALL($user_id);
    } else if ($employee_list_setup == 'membersOnly') {
      $data['EMPLOYEES']                          = $this->teams_model->GET_EMPLOYEES_MEMBERS($user_id);
    }
    // $data['EMPLOYEES']                          = $this->teams_model->GET_EMPLOYEES($user_id);
    $this->load->view('templates/header');
    $this->load->view('modules/teams/request_overtime_views', $data);
  }
  function add_overtime()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    // $is_enable_approvers                    = $this->teams_model->GET_SYSTEM_SETTING('requireApprovers');
    $input_data                             = $this->input->post();
    $input_data['status']                   = 'Pending 1';
    $day_type                               = $_POST['date_ot'];
    $day_types                              = $this->teams_model->GET_DAY_TYPE($day_type);

    if ($day_types) {
      echo 'YYY';
      $input_data['type']              = $day_types;
    } else {
      echo 'xxx';
      $input_data['type']              = "Regular";
    }
    $input_data['create_date']              = date('Y-m-d H:i:s');
    $input_data['edit_date']                = date('Y-m-d H:i:s');
    // $input_data['status']                   = $is_enable_approvers == 1 ? 'Pending 1' : 'Approved';
    $input_data['assigned_by']              = $user_id;
    $approvers                              = $this->teams_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    // $approver                               = $approvers->approver_1a ? $approvers->approver_1a : 0;
    $autoApprovedEnabled  = $this->selfservices_model->getApprovalAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('teams/request_overtime');
    }
    $input_data['approver1'] = $approvers || $approvers->approver_1a ? $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers || $approvers->approver_2a ? $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers || $approvers->approver_3a ? $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers || $approvers->approver_4a ? $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers || $approvers->approver_5a ? $approvers->approver_5a : 0;

    $input_data['approver1_b'] = $approvers || $approvers->approver_1b ? $approvers->approver_1b : 0;
    $input_data['approver2_b'] = $approvers || $approvers->approver_2b ? $approvers->approver_2b : 0;
    $input_data['approver3_b'] = $approvers || $approvers->approver_3b ? $approvers->approver_3b : 0;
    $input_data['approver4_b'] = $approvers || $approvers->approver_4b ? $approvers->approver_4b : 0;
    $input_data['approver5_b'] = $approvers || $approvers->approver_5b ? $approvers->approver_5b : 0;

    // if ($is_enable_approvers == 1) {
    //   if ($approver == 0) {
    //     $this->session->set_flashdata('ERR', 'No assign approvers');
    //     redirect('teams/request_overtime');
    //     return;
    //   }
    // }
    if ($autoApprovedEnabled && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0
      &&  $approvers->approver_3a == 0 &&  $approvers->approver_4a == 0
      &&   $approvers->approver_5a == 0)))) {
      $input_data['status'] = 'Approved';
    }
    $res                                    = $this->teams_model->ADD_DATA('tbl_overtimes', $input_data);
    $this->session->set_flashdata('SUCC', 'Successfully added');
    // if ($is_enable_approvers == 0) {
    //   redirect('teams/apply_overtimes');
    //   return;
    // }
    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->teams_model->GET_REQUESTOR('overtime', $res);
      $description    = "Overtime Application Review for [OVA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['approver1'],
        'type' => 'overtime',
        'content_id' => $res,
        'location' => 'selfservices/overtime_approval',
        'description' => $description
      );
      $token['type']          = 'approval';
      $token['table']         = 'tbl_overtimes';
      $token['id']            = $res;
      $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));
      $token['approver']              = 'approver1';
      $token['id']                    = $res;
      $token['approver_id']           = $input_data['approver1'];
      $token['approver_date_col']     = 'approver1_date';
      $json_token                     =  json_encode($token);
      $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['approver1'],
        'type' => 'overtime_approval',
        'content_id' => $res,
        'location' => 'selfservices/overtime_approval',
        'description' => $description
      );
      $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
      $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
      $notif = $this->teams_model->ADD_NOTIFICATION($notif_data);

      redirect('teams/apply_overtimes');
      return;
    }
    // $this->session->set_flashdata('ERR', 'Fail to add new overtime');
    redirect('teams/apply_overtimes');

    // if ($res) {
    //   $this->session->set_flashdata('SUCC', 'Successfully added');
    // } else {
    //   $this->session->set_flashdata('ERR', 'Fail to add new data');
    //   redirect('attendances/add_overtime');
    //   return;
    // }
    // redirect('overtimes/overtime');
  }
  function new_request_overtime_direct()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $data['DISP_EMPLOYEES_NONFILTERED']     = $this->teams_model->GET_EMPLOYEES($user_id);
    $this->load->view('templates/header');
    $this->load->view('modules/teams/new_overtime_request_direct_views', $data);
  }
  function apply_time_adjustments()
  {
    $data['TABLE_DATA']                     =  array();
    $status                                 =  $this->input->get('status');
    $limit                                  =  $this->input->get('row') ? $this->input->get('row')  : 50;
    $page                                   =  $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                 =  $limit * ($page - 1);
    $search                                 = $this->input->get('search');
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $filter_arr                             = array();
    $filter_arr['company']                  = $this->input->get('company');
    $filter_arr['branch']                   = $this->input->get('branch');
    $filter_arr['dept']                     = $this->input->get('dept');
    $filter_arr['div']                      = $this->input->get('div');
    $filter_arr['clubhouse']                = $this->input->get('clubhouse');
    $filter_arr['section']                  = $this->input->get('section');
    $filter_arr['group']                    = $this->input->get('group');
    $filter_arr['team']                     = $this->input->get('team');
    $filter_arr['line']                     = $this->input->get('line');

    $data['DISP_VIEW_REQUIREDAPPROVERS']    = 1; //$this->teams_model->GET_SYSTEM_SETTING("requireApprovers");
    $data['TABLE_DATA']                     = $this->teams_model->GET_TIME_ADJ_DIRECT($status, $search, $limit, $offset, $filter_arr, $user_id);
    $total_count                            = $this->teams_model->GET_TIME_ADJ_COUNT_DIRECT($status, $search, $filter_arr, $user_id);
    //     if ($data['DISP_VIEW_REQUIREDAPPROVERS'] == 0) {
    // 			$data['TABLE_DATA']                     = $this->teams_model->GET_TIME_ADJ_DIRECT($status, $search, $limit, $offset, $filter_arr,$user_id);
    //             $total_count                            = $this->teams_model->GET_TIME_ADJ_COUNT_DIRECT($status, $search, $filter_arr,$user_id);
    // 		} else {
    //       $data['TABLE_DATA']                     = $this->teams_model->GET_OVERTIMES($status, $search, $limit, $offset, $filter_arr,$user_id);
    //       $total_count                            = $this->teams_model->GET_OVERTIMES_COUNT($status, $search, $filter_arr,$user_id);
    // 		}

    $data['STATUS']                         = $status;
    $data['STATUSES']                       = array('Pending', 'Approved', 'Rejected');
    $excess                                 = $total_count % $limit;
    $data['C_DATA_COUNT']                   = $total_count;
    $data['PAGES_COUNT']                    = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                           = $page;
    $data['ROW']                            = $limit;
    $data['C_ROW_DISPLAY']                  = array(50);

    $data['DEPARTMENTS']                    = $this->teams_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES']                      =   $this->teams_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES']                       =   $this->teams_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS']                      =   $this->teams_model->GET_STD_DATA('tbl_std_divisions');
    $data['CLUBHOUSE']                      =   $this->teams_model->GET_STD_DATA('tbl_std_clubhouse');
    $data['SECTIONS']                       =   $this->teams_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS']                         =   $this->teams_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS']                          =   $this->teams_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES']                          =   $this->teams_model->GET_STD_DATA('tbl_std_lines');
    $data['DISP_VIEW_COMPANY']              = $this->teams_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']               = $this->teams_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']           = $this->teams_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']             = $this->teams_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']            = $this->teams_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']              = $this->teams_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                = $this->teams_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                 = $this->teams_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                 = $this->teams_model->GET_SYSTEM_SETTING("com_line");
    // $data['EMPLOYEES']                      = $this->teams_model->GET_EMPLOYEES($user_id);
    $data['EMPLOYEES']                          = $this->teams_model->GET_EMPLOYEES($user_id);

    $this->load->view('templates/header');
    $this->load->view('modules/teams/apply_time_adjustment_views', $data);
  }

  function get_request_leave_by_date()
  {
    $rawData = file_get_contents('php://input');
    $jsonData = parseJsonData($rawData);
    $leaveDate = $jsonData['leave_date'];
    $empl_id = $jsonData['empl_id'];
    $type = $jsonData['type'];
    $year = substr($leaveDate, 0, 4);
    $dateStart = date("Y-m-d", strtotime($year . "-01-01"));
    $dateEnd = date("Y-m-d", strtotime($year . "-12-31"));
    $leavesTotal =  $this->teams_model->get_leaves_total($empl_id, $type, $dateStart, $dateEnd);
    $leaveEntitlementValue = 0;
    $leaveEntitlement = 'Auto';

    $display_attachment = $this->teams_model->SHOW_HIDE_ATTACHMENT($type);
    $display_reason = $this->teams_model->SHOW_HIDE_REASON($type);

    if (!$leaveDate) {
      echo json_encode(['success' => false, 'error' => 'Invalid date received', 'data' => $jsonData,]);
      return;
    }

    $typeName = $jsonData['typeName'];
    if ($typeName == "Offset") {
      $leaveEntitlement =  $this->teams_model->get_offset_approve_count($empl_id);
      // $leaveEntitlement = array('value' => 10);
      if (!$leaveEntitlement) {
        ob_start();
        echo json_encode(['messageError' => '0', 'data' => $jsonData, 'leaveEntitlement ' => $leaveEntitlement]);
        ob_end_flush();
        return;
      }
      $leaveEntitlementValue = $leaveEntitlement['value'];


      $balance = $leaveEntitlementValue - $leavesTotal;
      echo json_encode([
        'messageSuccess' => 'Entitlement Found',
        'data' => $jsonData,
        'leaveEntitlement' => $leaveEntitlement,
        'leavesTotal ' => $leavesTotal,
        'leaveEntitlementValue' => $leaveEntitlementValue,
        'balance' => $balance,
        // 'leaveSetting' => $leaveSetting,
        'display_credit' => 1,
        'display_attachment' => $display_attachment,
        'display_reason' => $display_reason,

      ]);
    } else if ($typeName == 'Leave without Pay (LWOP)') {
      echo json_encode([
        'messageSuccess' => 'Entitlement Found',
        'data' => $jsonData,
        'leaveEntitlement' => null,
        'leavesTotal ' => null,
        'leaveEntitlementValue' => null,
        'balance' => null,
        // 'leaveSetting' => $leaveSetting,
        'display_credit' => null,
        'display_attachment' => $display_attachment,
        'display_reason' => $display_reason,

      ]);
    } else {
      $display_credit = $this->teams_model->SHOW_HIDE_CREDITS($type);

      $leaveSetting =  $this->teams_model->GET_SETUP_SETTING('leave_setting');
      if ($leaveSetting) {
        $leaveEntitlementValue =  $this->teams_model->GET_SETUP_LEAVE_SETTING(str_replace(' ', '_', $typeName));
        if (!$leaveEntitlementValue) {
          // echo json_encode(['messageError' => '0', 'data' => $jsonData, 'leaveEntitlementValue ' => $leaveEntitlementValue]);
          // return;
          $leaveEntitlementValue = 0;
        }
      } else {

        $leaveEntitlement =  $this->teams_model->get_leave_entitlement_by_id_typeName_year($empl_id, $typeName, $year);
        if (!$leaveEntitlement) {
          // ob_start();
          // echo json_encode(['messageError' => '0', 'data' => $jsonData, 'leaveEntitlement ' => $leaveEntitlement]);
          // ob_end_flush();
          // return;
          $leaveEntitlementValue = 0;
        }
        // $leaveEntitlementValue = $leaveEntitlement['value'];
        $leaveEntitlementValue = isset($leaveEntitlement['value']) ? $leaveEntitlement['value'] : 0;
      }

      $balance = $leaveEntitlementValue - $leavesTotal;
      echo json_encode([
        'messageSuccess' => true,
        'data' => $jsonData,
        'leaveEntitlement' => $leaveEntitlement,
        'leavesTotal ' => $leavesTotal,
        'leaveEntitlementValue' => $leaveEntitlementValue,
        'balance' => $balance,
        'leaveSetting' => $leaveSetting,
        'display_credit' => $display_credit,
        'display_attachment' => $display_attachment,
        'display_reason' => $display_reason,

      ]);
    }
  }



  function update_time_adjustment_direct()
  {
    // $input_data=$this->input->post();
    // echo json_encode($input_data);
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    $validKeys = [
      'id',
      'date_adjustment',
      'shift_type',
      'time_in_1',
      'time_out_1',
      'remarks',
    ];
    $input_data = array();
    foreach ($data as $input) {
      $input_data[]             = array_intersect_key($input, array_flip($validKeys));
    }
    $res                         = $this->teams_model->UPDATE_TIME_ADJ($input_data);
    $response['res']             = $res;
    $response['success_message'] = $res >= 1 ? 'Successfully updated Time Adjustment' : false;
    $response['error_message']   = $res < 1 ? 'No Changes' : false;

    echo json_encode($response);
  }
  function new_request_times_adjustment_direct()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $data['DISP_EMPLOYEES_NONFILTERED']     = $this->teams_model->GET_EMPLOYEES($user_id);
    $this->load->view('templates/header');
    $this->load->view('modules/teams/new_request_times_adjustment_direct_views', $data);
  }
  private function insert_approved_time_adjustment($id)
  {

    $time_adj                                 = $this->selfservices_model->GET_APPROVED_TIME_ADJUSTMENT($id);
    // $attendance_shift                         = $this->selfservices_model->GET_ATTENDANCE_SHIFT($time_adj->shift_type);
    $shift_id                                 = $attendance_shift->id;
    $date                                     = $time_adj->date_adjustment;
    $empl_id                                  = $time_adj->empl_id;
    $timeIn1                                  = $time_adj->time_in_1;
    $timeOut1                                 = $time_adj->time_out_1;
    $timeIn2                                  = $time_adj->time_in_2;
    $timeOut2                                 = $time_adj->time_out_2;
    // var_dump($time_adj);
    // return;
    $result                                   = $this->selfservices_model->IS_DUPLICATE_TIME_ADDJ($empl_id, $date);
    $att_shift_result                         = $this->selfservices_model->IS_DUPLICATE_ATTENDANCE_SHIFTASSIGN($empl_id, $date);

    if ($result <= 0) {
      $this->selfservices_model->INSERT_TIME_ADJUSTMENT($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date);
    } else {
      $this->selfservices_model->UPDATE_TIME_ADJUSTMENT($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date);
    }

    // if ($att_shift_result <= 0) {
    //   $this->selfservices_model->INSERT_ATTENDANCE_SHIFT_ASSIGN($shift_id, $empl_id, $date);
    // } else {
    //   $this->selfservices_model->UPDATE_ATTENDANCE_SHIFT_ASSIGN($shift_id, $empl_id, $date);
    // }

    return;
  }
  function request_times_adjustment()
  {
    $user_id                                             = $this->session->userdata('SESS_USER_ID');
    $data['ATTENDANCE_REC']                              = array();
    $data['EMPLOYEES']                                   = array();
    $date                                                = $this->input->get('date');
    $empl_id                                             = $this->input->get('empl_id');
    $data['EMPLOYEES']                                   = $this->teams_model->GET_EMPLOYEES($user_id);

    if ($data['EMPLOYEES'] && !$empl_id) {
      $data['ATTENDANCE_REC']                           = $this->teams_model->GET_ATTENDANCE_EMPL_REC($data['EMPLOYEES'][0]->id);
    }
    if ($empl_id) {
      $data['ATTENDANCE_REC']                         = $this->teams_model->GET_ATTENDANCE_EMPL_REC($empl_id);
    }

    $data['DEFAULT_VAL']                                 = [];
    if ($date == null && $data['ATTENDANCE_REC']) {
      $data['DEFAULT_VAL']            = $data['ATTENDANCE_REC'][0];
    }
    if ($date && $data['ATTENDANCE_REC']) {
      foreach ($data['ATTENDANCE_REC'] as $attendance) {
        if ($date == $attendance->date) {
          $data['DEFAULT_VAL']  = $attendance;
          break;
        }
      }
    }

    $this->load->view('templates/header');
    $this->load->view('modules/teams/request_times_adjustment_views', $data);
  }
  function add_time_adjustment()
  {
    $input_data = $this->input->post();
    $validKeys = [
      'id',
      'date_adjustment',
      'shift_type',
      'time_in_1',
      'time_out_1',
      'remarks',
      'attachment',
      'empl_id'
    ];
    $is_enable_approvers                                = $this->teams_model->GET_SYSTEM_SETTING('requireApprovers');
    $input_data  = array_intersect_key($input_data, array_flip($validKeys));
    $userId                                             = $this->session->userdata('SESS_USER_ID');
    $input_data['status']                               = 'Pending 1';
    $input_data['create_date']                          = date('Y-m-d H:i:s');
    $input_data['edit_date']                            = date('Y-m-d H:i:s');
    $input_data['assigned_by']                          = $userId;
    $approvers = $this->leaves_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    $autoApprovedEnabled  = $this->selfservices_model->getApprovalAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('teams/request_times_adjustment');
    }

    if ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0) && (!$approvers || $approvers->approver_3a == 0) && (!$approvers || $approvers->approver_4a == 0) && (!$approvers || $approvers->approver_5a == 0)
      || $autoApprovedEnabled
    ) {
      $input_data['status'] = 'Approved';
    }
    $input_data['approver1'] = $approvers && $approvers->approver_1a ?  $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers && $approvers->approver_2a ?  $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers && $approvers->approver_3a ?  $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers && $approvers->approver_4a ?  $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers && $approvers->approver_5a ?  $approvers->approver_5a : 0;

    $res = $this->teams_model->ADD_DATA('tbl_attendance_adjustments', $input_data);
    $this->session->set_flashdata('SUCC', 'Successfully added');

    if ($is_enable_approvers == 0) {
      redirect('teams/apply_time_adjustments');
      return;
    }


    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->teams_model->GET_REQUESTOR('leave', $res);
      $description    = "Time Adjustment Application Review for [LEA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $approvers->approver_1a,
        'type' => 'time adjustment',
        'content_id' => $res,
        'location' => 'selfservices/time_adjustment_approval',
        'description' => $description
      );
      $token['type']          = 'approval';
      $token['table']         = 'tbl_attendance_adjustments';
      $token['id']            = $res;
      $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));
      $token['approver']              = 'approver1';
      $token['id']                    = $res;
      $token['approver_id']           = $input_data['approver1'];
      $token['approver_date_col']     = 'approver1_date';
      $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
      $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);

      $notif = $this->teams_model->ADD_NOTIFICATION($notif_data);
      $this->session->set_flashdata('SUCC', 'Successfully added');
    }
    if (!$res) {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('teams/request_times_adjustment');
      return;
    }
    if ($res && $input_data['status'] == 'Approved') {
      $this->insert_approved_time_adjustment($res);
    }
    redirect('teams/apply_time_adjustments');
  }
  function insert_time_adjustment_direct()
  {
    $json_data  = file_get_contents('php://input');
    $data       = json_decode($json_data, true);
    $res        = $this->teams_model->ADD_TIME_ADJ($data);

    $response['res']             = $res;
    $response['success_message'] = $res >= 1 ? 'Successfully updated Time Adjustment' : false;
    echo json_encode($response);
  }
  function apply_holiday_works()
  {
    $user_id                                 = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                     = array();
    $status                                 = $this->input->get('status');
    $limit                                  = $this->input->get('row') ? $this->input->get('row')  : 50;
    $page                                   = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                 =  $limit * ($page - 1);
    $search                                 = $this->input->get('search');

    $filter_arr                             = array();
    $filter_arr['company']                  = $this->input->get('company');
    $filter_arr['branch']                   = $this->input->get('branch');
    $filter_arr['dept']                     = $this->input->get('dept');
    $filter_arr['div']                      = $this->input->get('div');
    $filter_arr['clubhouse']                = $this->input->get('clubhouse');
    $filter_arr['section']                  = $this->input->get('section');
    $filter_arr['group']                    = $this->input->get('group');
    $filter_arr['team']                     = $this->input->get('team');
    $filter_arr['line']                     = $this->input->get('line');

    $data['STATUS']                         = $status;
    $data['STATUSES']                       = array('Pending', 'Approved', 'Rejected');

    $data['DISP_VIEW_REQUIREDAPPROVERS']    = 1; //$this->teams_model->GET_SYSTEM_SETTING("requireApprovers");
    $data['TABLE_DATA']                     = $this->teams_model->GET_HOLIDAY_WORKS_DIRECT($status, $search, $limit, $offset, $filter_arr, $user_id);
    $total_count                            = $this->teams_model->GET_HOLIDAY_WORKS_COUNT($search, $status, $filter_arr, $user_id);
    //     if ($data['DISP_VIEW_REQUIREDAPPROVERS'] == 0) {
    //       $data['TABLE_DATA']                     = $this->teams_model->GET_HOLIDAY_WORKS_DIRECT($status, $search, $limit, $offset, $filter_arr,$user_id);
    //       $total_count                            = $this->teams_model->GET_HOLIDAY_WORKS_COUNT($search, $status, $filter_arr,$user_id);
    // 	}
    // 	else {
    //       $data['TABLE_DATA']                     = $this->teams_model->GET_HOLIDAY_WORKS($status, $search, $limit, $offset, $filter_arr);
    //       $total_count                            = $this->teams_model->GET_HOLIDAY_WORKS_COUNT($search, $status, $filter_arr);
    // 	}

    $excess                                 = $total_count % $limit;
    $data['C_DATA_COUNT']                   = $total_count;
    $data['PAGES_COUNT']                    = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                           = $page;
    $data['ROW']                            = $limit;
    $data['C_ROW_DISPLAY']                  = array(50);

    $data['DEPARTMENTS']                    = $this->teams_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES']                      = $this->teams_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES']                       = $this->teams_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS']                      = $this->teams_model->GET_STD_DATA('tbl_std_divisions');
    $data['CLUBHOUSE']                      = $this->teams_model->GET_STD_DATA('tbl_std_clubhouse');
    $data['SECTIONS']                       = $this->teams_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS']                         = $this->teams_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS']                          = $this->teams_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES']                          = $this->teams_model->GET_STD_DATA('tbl_std_lines');

    $data['DISP_VIEW_COMPANY']              = $this->teams_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']               = $this->teams_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']           = $this->teams_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']             = $this->teams_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']            = $this->teams_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']              = $this->teams_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                = $this->teams_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                 = $this->teams_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                 = $this->teams_model->GET_SYSTEM_SETTING("com_line");

    $data['EMPLOYEES']                      = $this->teams_model->GET_EMPLOYEES($user_id);
    $this->load->view('templates/header');
    $this->load->view('modules/teams/apply_holiday_work_views', $data);
  }
  function new_holiday_work_request_direct()
  {
    $user_id                                             = $this->session->userdata('SESS_USER_ID');
    $data['DISP_EMPLOYEES_NONFILTERED']     = $this->teams_model->GET_EMPLOYEES($user_id);
    $this->load->view('templates/header');
    $this->load->view('modules/teams/new_holiday_work_request_direct_views', $data);
  }
  function request_holiday_work()
  {
    $user_id                            = $this->session->userdata('SESS_USER_ID');
    $data['EMPLOYEES']                  = $this->teams_model->GET_EMPLOYEES($user_id);
    $this->load->view('templates/header');
    $this->load->view('modules/teams/holiday_work_request_views', $data);
  }

  // function update_holiday_works_direct()
  // {
  //   $json_data = file_get_contents('php://input');
  //   $data = json_decode($json_data, true);
  //   // $res = $this->employees_model->UPDATE_WORK_HISTORY_ALL($data_row,$this->session->userdata('SESS_USER_ID'));

  //   $updatedRequests = [];
  //   $notUpdatedRequests = [];
  //   $is_duplicate = null;
  //   // $resArray = [];
  //   // $data_rowArray = [];
  //   foreach ($data as $data_row) {
  //     $modified_data_row = $data_row;

  //     $modified_data_row['edit_date'] = date('Y-m-d H:i:s');
  //     $modified_data_row['empl_id'] = $this->teams_model->GET_EMPLOYEE_TABLE_ID($data_row['employee']);

  //     if ($modified_data_row['empl_id'] === null) {
  //       $notUpdatedRequests[] = $data_row['c_id'] . '(ID Not Found)';
  //       continue;
  //     }
  //     $date = $modified_data_row['date'];
  //     $empl_id = $modified_data_row['empl_id'];
  //     $id = $modified_data_row['id'];

  //     $is_duplicate = $this->teams_model->GET_HOLIDAY_WORKS_IS_DUPLICATE_DATE_BY_ID($date, $empl_id, $id);
  //     if ($is_duplicate > 0) {
  //       $notUpdatedRequests[] = $data_row['c_id'] . '(Duplicate Employee and Date)';
  //       continue;
  //     }
  //     unset($modified_data_row['id']);
  //     unset($modified_data_row['employee']);
  //     $modified_data_row['edit_user'] = $this->session->userdata('SESS_USER_ID');
  //     $res = $this->teams_model->UPDATE_HOLIDAY_WORKS($modified_data_row, $id);
  //     $resArray[] = $res;

  //     if ($res) {
  //       $updatedRequests[] = $data_row['c_id'];
  //     } else {
  //       $notUpdatedRequests[] = $data_row['c_id'];
  //     }
  //     // $data_rowArray[] = $modified_data_row;
  //   }
  //   $joinedupdatedRequests = '';
  //   $joinednotUpdatedRequests = '';
  //   if (count($updatedRequests) > 0 && count($notUpdatedRequests) < 1) {
  //     $joinedupdatedRequests = implode(', ', $updatedRequests);
  //     $this->session->set_flashdata('SUCC', 'Successfully updated: ' . $joinedupdatedRequests);
  //   } else {
  //     $joinednotUpdatedRequests = implode(', ', $notUpdatedRequests);
  //     $joinedupdatedRequests = implode(', ', $updatedRequests);
  //     if ($joinedupdatedRequests) {
  //       $this->session->set_flashdata('ERR', 'Successfully updated: ' . $joinedupdatedRequests . '. But failed to update: ' . $joinednotUpdatedRequests);
  //     } else {
  //       $this->session->set_flashdata('ERR', 'Unable to update: ' . $joinednotUpdatedRequests);
  //     }
  //   }
  //   $response = array(
  //     'reload' => true,
  //     'joinedupdatedRequests' => $joinedupdatedRequests,
  //     'joinednotUpdatedRequests' => $joinednotUpdatedRequests,
  //     // 'resArray' => $resArray,
  //     // 'data_rowArray' => $data_rowArray,
  //     'date' => $date,
  //     'empl_id' => $empl_id,
  //     'id' => $id,
  //     '$is_duplicate' => $is_duplicate,
  //   );

  //   $this->output->set_content_type('application/json')->set_output(json_encode($response));
  // }

  function add_new_holiday_work()
  {
    $input_data                                     = $this->input->post();
    $input_data['status']                           = 'Pending 1';
    $is_enable_approvers                            = $this->teams_model->GET_SYSTEM_SETTING('requireApprovers');
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $validKeys = [
      'date',
      'type',
      'hours',
      'reason',
      'comment',
      'empl_id'
    ];
    $input_data                                     = array_intersect_key($input_data, array_flip($validKeys));
    $input_data['create_date']                      = date('Y-m-d H:i:s');
    $input_data['edit_date']                        = date('Y-m-d H:i:s');
    $input_data['assigned_by']                      = $userId;
    $empl_id                                        = $input_data['empl_id'];
    $approvers                                      = $this->teams_model->GET_USER_APPROVERS($empl_id, 'tbl_approvers');
    $approver                                       = $approvers->approver_1a ? $approvers->approver_1a : 0;
    $autoApprovedEnabled  = $this->teams_model->getApprovalAutoApproveEnabled($input_data['empl_id']);
    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('teams/request_holiday_work');
    }

    if ($autoApprovedEnabled || (!$approvers || ($approvers && $approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0))) {
      $input_data['status'] = 'Approved';
    }
    $input_data['approver1'] = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers && $approvers->approver_2a ? $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers && $approvers->approver_3a ? $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers && $approvers->approver_4a ? $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers && $approvers->approver_5a ? $approvers->approver_5a : 0;
    $res                                            = $this->teams_model->ADD_DATA('tbl_holidaywork', $input_data);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed team holiday work request');
    }
    $this->session->set_flashdata('SUCC', 'Successfully added');
    // if ($is_enable_approvers == 0) {
    //   redirect('teams/apply_holiday_works');
    //   return;
    // }
    if ($res && $input_data['status'] != 'Approved') {

      $requestor                    = $this->teams_model->GET_REQUESTOR('holiday work', $res);
      $description                  = "Holiday Work Application Review for [HDW" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $notif_data                   = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $approvers->approver_1a,
        'type' => 'holiday work',
        'content_id' => $res,
        'location' => 'selfservices/holidaywork_approval',
        'description' => $description
      );
      $token['type']          = 'approval';
      $token['table']         = 'tbl_holidaywork';
      $token['id']            = $res;
      $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));
      $token['approver']              = 'approver1';
      $token['id']                    = $res;
      $token['approver_id']           = $input_data['approver1'];
      $token['approver_date_col']     = 'approver1_date';
      $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
      $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
      $notif = $this->teams_model->ADD_NOTIFICATION($notif_data);
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('teams/apply_holiday_works');
      return;
    }
    // $this->session->set_flashdata('ERR', 'Fail to add new data');
    redirect('teams/apply_holiday_works');
  }

  function get_employee_data()
  {
    $employee_id                  = $this->input->get('employee');
    $date_period                  = $this->teams_model->GET_PERIOD_DATA($this->input->get('period'));
    if (empty($date_period)) {
      $data['employee_data']      = array();
      $data['cutoff_data']        = array();
      return $data;
    }
    $start_date                   = $date_period['date_from'];
    $end_date                     = $date_period['date_to'];
    $data['employee_data']        = $this->teams_model->MOD_DISP_EMPLOYEE($employee_id);
    $data['cutoff_data']          = $this->teams_model->MON_DISP_CUTOFF_PERIOD($start_date, $end_date, $employee_id);
    return $data;
  }

  function my_requested_shift($empl_id, $cutoff_period)
  {

    $payroll_period =  $this->selfservices_model->GET_PAYROLL_PERIOD($cutoff_period);

    $data['DISP_EMP_LIST_DATA'] =  $this->selfservices_model->GET_FILTERED_EMPLOYEELIST_DATA($empl_id);

    $begin = new DateTime($payroll_period->date_from);
    $end = new DateTime($payroll_period->date_to);
    $holidays = $this->selfservices_model->GET_HOLIDAY();
    $end = $end->modify('+1 day');
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval, $end);
    $data['SHIFT_DATA_DATERANGE'] = $this->selfservices_model->GET_SHIFT_DATA_DATERANGE($empl_id, $payroll_period->date_from, $payroll_period->date_to);
    $data['SHIFT_DATA'] = $this->selfservices_model->GET_SHIFT_ALL_DATA();
    $data["DATE_RANGE"] = $this->assign_shift_data($daterange, $holidays);
    $this->load->view('templates/header');
    $this->load->view('modules/teams/my_requested_shift_views', $data);
  }

  function myshifts()
  {
    $user_id                                   = $this->session->userdata('SESS_USER_ID');
    $search                                    = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["C_ROW_DISPLAY"]                     = [25, 50, 100];
    $page                                      = $this->input->get('page');
    $row                                       = $this->input->get('row');
    if ($row == null) {
      $row = 25;
    }
    if ($page  == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);

    // $data['DISP_EMPLOYEES']                   = $this->teams_model->GET_ALL_EMPLOYEE();
    $data['DISP_EMPLOYEES']                   = $this->teams_model->GET_EMPLOYEES_MEMBERS($user_id);
    $data['DISP_SHIFT']                       = $this->teams_model->GET_SHIFT_APPROVALS($user_id);
    $data['C_DATA_COUNT']                     = 0;
    $data['FILTER']                           = $this->input->get('employee');

    $this->load->view('templates/header');
    $this->load->view('modules/teams/myshift_views', $data);
  }


  function shift_assignment()
  {
    $id = $this->session->userdata('SESS_USER_ID');

    if (!isset($_GET["branch"]) || $_GET["branch"] === "undefined") {
      $param_branch         = "all";
    } else {
      $param_branch         = $_GET["branch"];
    }
    if (!isset($_GET["dept"]) || $_GET["dept"] === "undefined") {
      $param_dept           = "all";
    } else {
      $param_dept           = $_GET["dept"];
    }
    if (!isset($_GET["division"]) || $_GET["division"] === "undefined") {
      $param_division       = "all";
    } else {
      $param_division       = $_GET["division"];
    }
    if (!isset($_GET["section"]) || $_GET["section"] === "undefined") {
      $param_section        = "all";
    } else {
      $param_section        = $_GET["section"];
    }
    if (!isset($_GET["group"]) || $_GET["group"] === "undefined") {
      $param_group          = "all";
    } else {
      $param_group          = $_GET["group"];
    }
    if (!isset($_GET["team"]) || $_GET["team"] === "undefined") {
      $param_team           = "all";
    } else {
      $param_team           = $_GET["team"];
    }
    if (!isset($_GET["line"]) || $_GET["line"] === "undefined") {
      $param_line           = "all";
    } else {
      $param_line           = $_GET["line"];
    }
    if (!isset($_GET["status"]) || $_GET["status"] === "undefined") {
      $param_status         = "all";
    } else {
      $param_status         = $_GET["status"];
    }
    if (!isset($_GET["employee"])) {
      $_GET["employee"] = "";
    }
    // $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $search                                   = str_replace('_', ' ', $this->input->get('search') ?? "");
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
    if ($this->input->get('search') == null) {
      // $data['DISP_EMP_LIST']                  = $empl_list = $this->teams_model->GET_FILTERED_EMPLOYEELIST_2($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line, $id);
      $data['DISP_EMP_LIST_DATA']             = $empl_list = $this->teams_model->GET_FILTERED_EMPLOYEELIST_DATA($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line, $id);
      $data['C_DATA_COUNT']                   = $this->teams_model->GET_FILTERED_EMPLOYEELIST_DATA_COUNT($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line, $id);
    } else {
      $data['DISP_EMP_LIST']                  = $this->teams_model->GET_SEARCHED($search);
      $data['DISP_EMP_LIST_DATA']             = $this->teams_model->GET_SEARCHED_EMPL($search);
      $data['C_DATA_COUNT']                   = count($this->teams_model->GET_SEARCHED($search));
    }
    $data['DISP_ALL_EMP_LIST_DATA']             = $this->teams_model->GET_SEARCHED_ALL_EMPL($id);
    $data['DISP_PAYROLL_SCHED']               = $payroll_list = $this->teams_model->MOD_DISP_PAY_SCHED();

    $period = $this->input->get('period');
    if (!isset($period)) {
      $period = $payroll_list[0]->id;
    }

    $data['PERIOD']                           = $period;
    $res_data                                 = $this->get_employee_data();
    $data['DISP_CUTOFF']                      = $res_data['cutoff_data'];
    $data['DISP_WORK_SHIFT_DATA']             = $this->teams_model->GET_WORK_SHIFT_DATA();

    if (!empty($DISP_EMP_LIST)) {
      $data['DISP_USER_ID']                   = $data['DISP_EMP_LIST'][0]->id;
    } else {
      $data['DISP_USER_ID']                   = 0;
    }
    $date_period                              = $this->teams_model->GET_PERIOD_DATA($period);

    $data['DISP_CUTOFF_PERIOD']               = $this->teams_model->GET_PERIOD_LIST();

    if (isset($_GET['yearmonth'])) {
      $yearmonth                              = $_GET['yearmonth'];

      $firstDaya = new DateTime($yearmonth . '-01');

      $lastDaya = clone $firstDaya;
      $lastDaya->modify('last day of this month');

      $yearmonth_from                           = $firstDaya->format('Y-m-d');
      $yearmonth_to                             = $lastDaya->format('Y-m-d');
    } else {
      $yearmonth                                = date('Y-m');
      $yearmonth_from                           = date('Y-m-01');
      $yearmonth_to                             = date('Y-m-t');
    }

    $data['YEARMONTH']                        = $yearmonth;
    $data['YEARMONTH_FROM']                   = $yearmonth_from;
    $data['YEARMONTH_TO']                     = $yearmonth_to;

    $start_date                               = $date_period['date_from'];
    $end_date                                 = $date_period['date_to'];

    // $firstDay                                 = date('Y-m-d', strtotime($yearmonth_from));
    // $lastDay                                  = date('Y-m-d', strtotime($yearmonth_to));

    $begin                                    = new DateTime($start_date);
    $end                                      = new DateTime($end_date);
    $end                                      = $end->modify('+1 day');
    $holidays                                 = $this->teams_model->GET_HOLIDAY();
    $interval                                 = new DateInterval('P1D');
    $daterange                                = new DatePeriod($begin, $interval, $end);
    $data['SHIFT_DATA_DATERANGE']             = $this->teams_model->GET_SHIFT_DATA_DATERANGE($start_date, $end_date);
    $data['DATE_FROM']                        = $start_date;
    $data['DATE_TO']                          = $end_date;
    $data['SHIFT_DATA']                       = $this->teams_model->GET_SHIFT_ALL_DATA();
    $data["DATE_RANGE"]                       = $this->assign_shift_data($daterange, $holidays);
    $data['SHIFT_ASSIGNED_APPROVAL']          = $this->teams_model->GET_SHIFT_APPROVAL($id, $period);

    $this->load->view('templates/header');
    $this->load->view('modules/teams/team_shift_assignment_views', $data);
  }

  function shift_assignments()
  {
    $period                             = $this->input->get('period');
    $empl_id                            = $this->session->userdata('SESS_USER_ID');
    $data['CUTOFF_PERIODS']             = $cuttoff_periods = $this->teams_model->GET_CUTOFF_LIST();
    $latest_period                      = $this->teams_model->GET_LATEST_PAYROLL_PERIOD();

    if ($period == null) {
      if ($latest_period) {
        $period = $latest_period->id;
      }
    }

    $data['PERIOD']                   = $period;
    $payroll_period                   = $this->teams_model->GET_PAYROLL_PERIOD($period);
    $data['DISP_EMP_LIST_DATA']       = $this->teams_model->GET_TEAMS_EMPLOYEELIST_DATA($empl_id);

    $begin                            = new DateTime($payroll_period->date_from);
    $end                              = new DateTime($payroll_period->date_to);
    $holidays                         = $this->selfservices_model->GET_HOLIDAY();
    $end                              = $end->modify('+1 day');
    $interval                         = new DateInterval('P1D');
    $daterange                        = new DatePeriod($begin, $interval, $end);

    $data['SHIFT_DATA_DATERANGE']     = $this->teams_model->GET_SHIFT_DATA_DATERANGE_TEAM($empl_id, $payroll_period->date_from, $payroll_period->date_to);
    $data['SHIFT_DATA']               = $this->selfservices_model->GET_SHIFT_ALL_DATA();
    $data["DATE_RANGE"]               = $this->assign_shift_data($daterange, $holidays);

    $this->load->view('templates/header');
    $this->load->view('modules/teams/requested_shift_views', $data);
  }

  function assign_shift_data($dates, $holidays)
  {
    $data_arr                         = array();
    $index                            = 0;
    foreach ($dates as $date) {
      $data_arr[$index]["Date"] = $date;
      $is_found                       = FALSE;
      $is_match                       = FALSE;
      $current_date                   = $date->format("Y-m-d");
      foreach ($holidays as $holiday) {
        if ($holiday->col_holi_date == $current_date) {
          if ($holiday->col_holi_type == "Regular Holiday") {
            $data_arr[$index]["holi_type"] = "LEGAL";
          } else {
            $data_arr[$index]["holi_type"] = "SPECIAL";
          }
          $is_found                   = TRUE;
          break;
        }
      }
      if (!$is_found) {
        $data_arr[$index]["holi_type"] = "REGULAR";
      }
      $index += 1;
    }
    return $data_arr;
  }

  public function update_data()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $updatedData = $data['updatedData'];
    $employeeData = $data['employeeData'];

    $extractedData = [];
    for ($i = 0; $i < count($updatedData); $i++) {
      $id = $updatedData[$i][0];
      for ($j = 3; $j < count($updatedData[$i]); $j++) {
        $shift = $updatedData[$i][$j];
        $date = $employeeData[$i][$j];
        if ($shift !== '') {
          array_push($extractedData, [$id, $shift, $date]);
        }
      }
    }

    try {
      foreach ($extractedData as $data_row) {
        $this->teams_model->update_shift_data($data_row, $this->session->userdata('SESS_USER_ID'));
      }
      $response = array('success_message' => 'Data updated successfully');
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
    }

    echo json_encode($response);
  }

  

  function update_shift_assignment()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $updatedData = $data['updatedData'];
    $employeeData = $data['employeeData'];
    $cutOffPeriodValue = $data['cutOffPeriodValue'];

    $cutoffData = [];
    for ($i = 0; $i < count($employeeData); $i++) {
      $id = $updatedData[$i][0];
      for ($j = 3; $j < count($updatedData[$i]); $j++) {
        $shift = $updatedData[$i][$j];
        if ($shift !== '') {
          array_push($cutoffData, [$id, $cutOffPeriodValue]);
        }
      }
    }

    $uniqueCutoffData = array_unique($cutoffData, SORT_REGULAR);
    $uniqueCutoffData = array_values($uniqueCutoffData);

    try {
      foreach ($uniqueCutoffData as $data_row) {
        $this->teams_model->update_shift_approval($data_row, $this->session->userdata('SESS_USER_ID'));
      }
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated team shift assignment');
      $response = array('success_message' => 'Data updated successfully');
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
    }

    echo json_encode($response);
  }

  function update_shift_approval()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $updatedData = $data['updatedData'];
    try {
      foreach ($updatedData as $data_row) {
        $this->teams_model->UPDATE_SHIFT_APPROVER($data_row, $this->session->userdata('SESS_USER_ID'));
      }
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated team shift approval');
      $response = array('success_message' => 'Data updated successfully');
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
    }
    echo json_encode($response);
  }

  function update_shift()
  {
    $date_from                            = $this->input->post('DATE_FROM');
    $date_to                              = $this->input->post('DATE_TO');
    $mark_id                              = $this->input->post('UPDATE_ID');
    $shift_date                           = $this->input->post('UPDT_SHIFT_DATE');
    $data_arr                             = array();
    $ids_int                              = array_map('intval', explode(',', $mark_id));
    $begin                                = new DateTime($date_from);
    $end                                  = new DateTime($date_to);
    $end                                  = $end->modify('+1 day');
    $interval                             = new DateInterval('P1D');
    $daterange                            = new DatePeriod($begin, $interval, $end);
    $i                                    = 0;
    $parts = [];
    for ($i = 0; $i < 7; $i++) {
      $shift_id[$i] = $this->input->post('UPDT_SHIFT_' . ($i + 1));
      $parts[$i] = explode(",", $shift_id[$i]);
    }
    $dayToShiftId = [
      $parts[0][1] => $parts[0][0],
      $parts[1][1] => $parts[1][0],
      $parts[2][1] => $parts[2][0],
      $parts[3][1] => $parts[3][0],
      $parts[4][1] => $parts[4][0],
      $parts[5][1] => $parts[5][0],
      $parts[6][1] => $parts[6][0],
    ];
    foreach ($ids_int as $ids_int_row) {
      foreach ($daterange as $dt) {
        $date                             = $dt->format("Y-m-d");
        $dayOfWeek                        = date("l", strtotime($date));
        $user_id                          = $ids_int_row;
        $response                         = $this->teams_model->IS_DUPLICATE($user_id, $date);
        if (isset($dayToShiftId[$dayOfWeek])) {
          $shift_id = $dayToShiftId[$dayOfWeek];
          if ($response == 0) {
            $res_insrt                    = $this->teams_model->ADD_USER_WORK_SHIFT($user_id, $shift_id, $date);
          } else {
            $res_insrt                    = $this->teams_model->UPDATE_USER_WORK_SHIFT($user_id, $shift_id, $date);
          }
        }
      }
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated team shift');
    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }

  function undertrime_approval()
  {
    $user_id                                   = $this->session->userdata('SESS_USER_ID');
    $search                                    = str_replace('_', ' ', $this->input->get('all') ?? "");
    $dept                                      = $this->input->get('dept');
    $sec                                       = $this->input->get('section');
    $group                                     = $this->input->get('group');
    $line                                      = $this->input->get('line');
    $branch                                    = $this->input->get('branch');
    $division                                  = $this->input->get('division');
    $clubhouse                                 = $this->input->get('clubhouse');
    $team                                      = $this->input->get('team');
    $status                                    = $this->input->get('status');
    $company                                   = $this->input->get('company');

    $data["C_ROW_DISPLAY"]                     = [25, 50, 100];

    $page                                      = $this->input->get('page');
    $row                                       = $this->input->get('row');
    if ($row == null) {
      $row = 25;
    }
    if ($page  == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);
    if ($status == null) {
      $status = 0;
    }

    $data['DISP_EMPLOYEES']                   = $this->teams_model->GET_ALL_EMPLOYEE();
    $data['DISP_TYPES']                       = $this->teams_model->GET_ALL_LEAVETYPES();

    $data['DISP_SHIFT']                       = $attendance_shifts = $this->teams_model->GET_UNDERTIME_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->teams_model->GET_CHANGESHIFT_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team));

    // foreach ($attendance_shifts as $row_shift) {
    //   $shift_result = $this->teams_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
    //   if ($shift_result) {
    //     $row_shift->request_shift = $shift_result->name;
    //   }
    // }

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->teams_model->GET_EMPL_NAMES('tbl_leaves_assign');

    $data['DISP_DISTINCT_COMPANY']            = $this->teams_model->MOD_DISP_DISTINCT_COMPANY();
    $data['DISP_DISTINCT_BRANCH']             = $this->teams_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT']         = $this->teams_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']           = $this->teams_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_CLUBHOUSE']          = $this->teams_model->MOD_DISP_DISTINCT_CLUBHOUSE();
    $data['DISP_DISTINCT_SECTION']            = $this->teams_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']              = $this->teams_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']               = $this->teams_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']               = $this->teams_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_COMPANY']                = $this->teams_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']                 = $this->teams_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']             = $this->teams_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']               = $this->teams_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']                = $this->teams_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']                = $this->teams_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                  = $this->teams_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                   = $this->teams_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                   = $this->teams_model->GET_SYSTEM_SETTING("com_line");
    $data['DATE_FORMAT']                      = $this->teams_model->GET_SYSTEM_SETTING("date_format");

    $employeeSearchRaw                  = $this->teams_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
    foreach ($employeeSearchRaw as &$item) {
      if (!empty($item->col_suffix)) {
        $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
      }
      $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
    }
    unset($item);
    $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;

    $this->load->view('templates/header');
    $this->load->view('modules/teams/undertime_approval_views', $data);
  }


  function mychange_approval()
  {
    $user_id                                   = $this->session->userdata('SESS_USER_ID');
    $search                                    = str_replace('_', ' ', $this->input->get('all') ?? "");
    $dept                                      = $this->input->get('dept');
    $sec                                       = $this->input->get('section');
    $group                                     = $this->input->get('group');
    $line                                      = $this->input->get('line');
    $branch                                    = $this->input->get('branch');
    $division                                  = $this->input->get('division');
    $clubhouse                                 = $this->input->get('clubhouse');
    $team                                      = $this->input->get('team');
    $status                                    = $this->input->get('status');
    $company                                   = $this->input->get('company');

    $data["C_ROW_DISPLAY"]                     = [25, 50, 100];

    $page                                      = $this->input->get('page');
    $row                                       = $this->input->get('row');
    if ($row == null) {
      $row = 25;
    }
    if ($page  == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);
    if ($status == null) {
      $status = 0;
    }

    $data['DISP_EMPLOYEES']                   = $this->teams_model->GET_ALL_EMPLOYEE();
    $data['DISP_TYPES']                       = $this->teams_model->GET_ALL_LEAVETYPES();

    $data['DISP_SHIFT']                       = $attendance_shifts = $this->teams_model->GET_CHANGESHIFT_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->teams_model->GET_CHANGESHIFT_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team));

    foreach ($attendance_shifts as $row_shift) {
      $shift_result = $this->teams_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
      if ($shift_result) {
        $row_shift->request_shift = $shift_result->name;
      }
    }

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->teams_model->GET_EMPL_NAMES('tbl_leaves_assign');

    $data['DISP_DISTINCT_COMPANY']            = $this->teams_model->MOD_DISP_DISTINCT_COMPANY();
    $data['DISP_DISTINCT_BRANCH']             = $this->teams_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT']         = $this->teams_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']           = $this->teams_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_CLUBHOUSE']          = $this->teams_model->MOD_DISP_DISTINCT_CLUBHOUSE();
    $data['DISP_DISTINCT_SECTION']            = $this->teams_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']              = $this->teams_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']               = $this->teams_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']               = $this->teams_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_COMPANY']                = $this->teams_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']                 = $this->teams_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']             = $this->teams_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']               = $this->teams_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']                = $this->teams_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']                = $this->teams_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                  = $this->teams_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                   = $this->teams_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                   = $this->teams_model->GET_SYSTEM_SETTING("com_line");
    $data['DATE_FORMAT']                      = $this->teams_model->GET_SYSTEM_SETTING("date_format");

    $employeeSearchRaw                  = $this->teams_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
    foreach ($employeeSearchRaw as &$item) {
      if (!empty($item->col_suffix)) {
        $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
      }
      $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
    }
    unset($item);
    $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;

    $this->load->view('templates/header');
    $this->load->view('modules/teams/changeshift_approval_views', $data);
  }

  function changeshiftapproval($approve, $changeshift_id)
  {

    $data           = $this->teams_model->GET_CHANGESHIFT_DATA($changeshift_id);
    $numofapprovers = $this->teams_model->GET_APPROVERCOUNT($changeshift_id);

    $status         = $data->status;
    $approver1      = $data->approver1;
    $approver1_b    = $data->approver1_b;

    $approver2      = $data->approver2;
    $approver2_b    = $data->approver2_b;

    $approver3      = $data->approver3;
    $approver3_b    = $data->approver3_b;

    $approver4      = $data->approver4;
    $approver4_b    = $data->approver4_b;

    $approver5      = $data->approver5;
    $approver5_b    = $data->approver5_b;

    $next_status    = "";
    $approverdate   = "";

    //------------------- APPROVED IF REACH MAX APPROVER AND NO NEXT ASSIGNED APPROVER --------------
    if ($status == "Pending 1" && ($approver1 != 0 || $approver1_b != 0) && (($approver2 == 0 &&  $approver2_b == 0))) {
      $next_status = "Approved";
      $approverdate = 'approver1_date';
    }
    if ($status == "Pending 1" && ($approver1 == 0 || $approver1_b == 0) && ($approver2 != 0 || $approver2_b != 0) && ($approver3 == 0 &&  $approver3_b == 0)) {
      $next_status = "Approved";
      $approverdate = 'approver2_date';
    }
    if ($status == "Pending 2" && (($approver3 == 0 && $approver3_b == 0))) {
      $next_status = "Approved";
      $approverdate = 'approver2_date';
    }
    if ($status == "Pending 3" && (($approver4 == 0 && $approver4_b == 0))) {
      $next_status = "Approved";
      $approverdate = 'approver3_date';
    }
    if ($status == "Pending 4" && ($numofapprovers == 4 || ($approver5 == 0 && $approver5_b == 0))) {
      $next_status = "Approved";
      $approverdate = 'approver4_date';
    }
    if ($status == "Pending 5") {
      $next_status = "Approved";
      $approverdate = 'approver5_date';
    }

    //------------------- APPROVED IF REACH MAX APPROVER AND NO NEXT ASSIGNED APPROVER --------------
    if ($status == "Pending 1" && ($approver2 != 0 && $approver2_b != 0)) {
      $next_status = "Pending 2";
      $approverdate = 'approver1_date';
    }
    if ($status == "Pending 2" && ($approver3 != 0 && $approver3_b == 0)) {
      $next_status = "Pending 3";
      $approverdate = 'approver2_date';
    }
    if ($status == "Pending 3" && ($approver4 != 0 && $approver4_b == 0)) {
      $next_status = "Pending 4";
      $approverdate = 'approver3_date';
    }
    if ($status == "Pending 4" && ($approver5 != 0 && $approver5_b == 0)) {
      $next_status = "Pending 5";
      $approverdate = 'approver4_date';
    }

    if ($approve == 'approve') {
      $this->teams_model->CHANGESHIFT_APPROVELEAVE($changeshift_id, $next_status, $approverdate);
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved team shift change');
      $this->session->set_flashdata('SUCC', 'Change Shift request has been Approved!');
    } else {
      $this->teams_model->CHANGESHIFT_APPROVELEAVE($changeshift_id, 'Rejected', $approverdate);
      $this->session->set_flashdata('SUCC', 'Change Shift request has been Rejected!');
    }

    // $result = $this->teams_model->GET_CHANGED_SHIFT($changeshift_id);

    // if ($result->status == "Approved") {
    //   $this->teams_model->UPDATE_CHANGESHIFT($result->empl_id, $result->date_shift, $result->request_shift);
    // }
    redirect('teams/mychange_approval');
  }


  function undertime_approval($approve, $undertime_id)
  {

    $data           = $this->teams_model->GET_UNDERTIME_DATA($undertime_id);
    $numofapprovers = $this->teams_model->GET_APPROVERCOUNT($undertime_id);

    $status         = $data->status;
    $approver1      = $data->approver1;
    $approver1_b    = $data->approver1_b;

    $approver2      = $data->approver2;
    $approver2_b    = $data->approver2_b;

    $approver3      = $data->approver3;
    $approver3_b    = $data->approver3_b;

    $approver4      = $data->approver4;
    $approver4_b    = $data->approver4_b;

    $approver5      = $data->approver5;
    $approver5_b    = $data->approver5_b;

    $next_status    = "";
    $approverdate   = "";

    //------------------- APPROVED IF REACH MAX APPROVER AND NO NEXT ASSIGNED APPROVER --------------
    if ($status == "Pending 1" && ($approver1 != 0 || $approver1_b != 0) && (($approver2 == 0 &&  $approver2_b == 0))) {
      $next_status = "Approved";
      $approverdate = 'approver1_date';
    }
    if ($status == "Pending 1" && ($approver1 == 0 || $approver1_b == 0) && ($approver2 != 0 || $approver2_b != 0) && ($approver3 == 0 &&  $approver3_b == 0)) {
      $next_status = "Approved";
      $approverdate = 'approver2_date';
    }
    if ($status == "Pending 2" && (($approver3 == 0 && $approver3_b == 0))) {
      $next_status = "Approved";
      $approverdate = 'approver2_date';
    }
    if ($status == "Pending 3" && (($approver4 == 0 && $approver4_b == 0))) {
      $next_status = "Approved";
      $approverdate = 'approver3_date';
    }
    if ($status == "Pending 4" && ($numofapprovers == 4 || ($approver5 == 0 && $approver5_b == 0))) {
      $next_status = "Approved";
      $approverdate = 'approver4_date';
    }
    if ($status == "Pending 5") {
      $next_status = "Approved";
      $approverdate = 'approver5_date';
    }

    //------------------- APPROVED IF REACH MAX APPROVER AND NO NEXT ASSIGNED APPROVER --------------
    if ($status == "Pending 1" && ($approver2 != 0 && $approver2_b != 0)) {
      $next_status = "Pending 2";
      $approverdate = 'approver1_date';
    }
    if ($status == "Pending 2" && ($approver3 != 0 && $approver3_b == 0)) {
      $next_status = "Pending 3";
      $approverdate = 'approver2_date';
    }
    if ($status == "Pending 3" && ($approver4 != 0 && $approver4_b == 0)) {
      $next_status = "Pending 4";
      $approverdate = 'approver3_date';
    }
    if ($status == "Pending 4" && ($approver5 != 0 && $approver5_b == 0)) {
      $next_status = "Pending 5";
      $approverdate = 'approver4_date';
    }



    if ($approve == 'approve') {
      $this->teams_model->UNDERTIME_APPROVAL($undertime_id, $next_status, $approverdate);
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved team undertime');
      $this->session->set_flashdata('SUCC', 'Undertime request has been Approved!');
    }

    if ($approve == 'reject') {
      $this->teams_model->UNDERTIME_APPROVAL($undertime_id, 'Rejected', $approverdate);
      $this->session->set_flashdata('SUCC', 'Undertime request has been Rejected!');
    }

    // $result = $this->teams_model->GET_CHANGED_SHIFT($changeshift_id);

    // if ($result->status == "Approved") {
    //   $this->teams_model->UPDATE_CHANGESHIFT($result->empl_id, $result->date_shift, $result->request_shift);
    // }
    redirect('teams/undertrime_approval');
  }



  function team_in_out()
  {
    $id = $this->session->userdata('SESS_USER_ID');

    $data['members'] = $this->teams_model->GET_MY_TEAM($id);

    $this->load->view('templates/header');
    $this->load->view('modules/teams/team_in_out_management_views', $data);
  }



  function exemptut()
  { //aw
    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);

    $data['STATUS']                                  = $status;
    $data['STATUSES']                                = array('Pending', 'Approved', 'Rejected', 'Cancelled', 'Withdrawn');
    $data['TABLE_DATA']                              = $this->selfservices_model->GET_EMPL_EXEMPTUT($userId, $status, $limit, $offset);
    $total_count                                     = $this->selfservices_model->GET_EMPL_EXEMPTUT_COUNT($userId, $status);

    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/teams/exemptut_views', $data);
  }

  function request_exemptut()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $user_department                        = $this->selfservices_model->GET_USER_DEPARMENT($user_id);
    $data['SHIFTLIST']                      = $this->selfservices_model->GET_ALL_SHIFTS();
    $data['EMPLOYEES']                      = $this->teams_model->GET_EMPLOYEES_MEMBERS($user_id);
    $current_date                           = date('Y-m-d');
    $data['USER_DEPARTMENT']                = $user_department;
    $data['holiday_info']                   = $this->selfservices_model->MOD_DISP_HOLIDAY_BASED_DATE($current_date);
    $data['is_holiday']                     = !empty($data['holiday_info']);
    // var_dump($step_count);
    $this->load->view('templates/header');
    $this->load->view('modules/teams/request_exemptut_views', $data);
  }


  function add_request_exemptut()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $input_data                                     = $this->input->post();
    $day_type                                       = $_POST['date_undertime'];

    $input_data['status']                           = 'Pending 1';
    $approvers                                      = $this->selfservices_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');


    $approver                                       = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $autoApprovedEnabled  = $this->selfservices_model->getApprovalAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('teams/request_exemptut');
    }
    if (
      $autoApprovedEnabled ||
      ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0)
        && (!$approvers || $approvers->approver_3a == 0) && (!$approvers || $approvers->approver_4a == 0)
        && (!$approvers || $approvers->approver_5a == 0))
    ) {
      $input_data['status'] = 'Approved';
    }

    $input_data['approver1'] = $approvers || $approvers->approver_1a ? $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers || $approvers->approver_2a ? $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers || $approvers->approver_3a ? $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers || $approvers->approver_4a ? $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers || $approvers->approver_5a ? $approvers->approver_5a : 0;

    $res                = $this->selfservices_model->ADD_EXEMPTUT_REQUEST($input_data);


    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->selfservices_model->GET_REQUESTOR('exemptut', $res);
      $description    = "Exempt Undertime Application Review for [EXU" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $token['type']          = 'approval';
      $token['table']         = 'tbl_attendance_undertimerequest';
      $token['id']            = $res;
      $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));
      $token['approver']              = 'approver1';
      $token['id']                    = $res;
      $token['approver_id']           = $input_data['approver1'];
      $token['approver_date_col']     = 'approver1_date';
      $json_token                     =  json_encode($token);
      $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['approver1'],
        'type' => 'exemptut',
        'content_id' => $res,
        'location' => 'selfservices/exemptut',
        'description' => $description
      );
      $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
      $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
      $notif = $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('teams/exemptut');
      return;
    }
    $this->session->set_flashdata('ERR', 'Fail to add new data');
    redirect('teams/request_exemptut');
  }

  function add_request_exemptut_admin()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $input_data                                     = $this->input->post();
    $day_type                                       = $_POST['date_undertime'];

    $input_data['status']                           = 'Pending 1';
    $approvers                                      = $this->selfservices_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');


    $approver                                       = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $autoApprovedEnabled  = $this->selfservices_model->getApprovalAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('teams/request_exemptut');
    }
    if (
      $autoApprovedEnabled ||
      ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0)
        && (!$approvers || $approvers->approver_3a == 0) && (!$approvers || $approvers->approver_4a == 0)
        && (!$approvers || $approvers->approver_5a == 0))
    ) {
      $input_data['status'] = 'Approved';
    }

    $input_data['approver1'] = $approvers || $approvers->approver_1a ? $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers || $approvers->approver_2a ? $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers || $approvers->approver_3a ? $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers || $approvers->approver_4a ? $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers || $approvers->approver_5a ? $approvers->approver_5a : 0;

    $res                = $this->selfservices_model->ADD_EXEMPTUT_REQUEST($input_data);


    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->selfservices_model->GET_REQUESTOR('exemptut', $res);
      $description    = "Exempt Undertime Application Review for [EXU" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $token['type']          = 'approval';
      $token['table']         = 'tbl_attendance_undertimerequest';
      $token['id']            = $res;
      $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));
      $token['approver']              = 'approver1';
      $token['id']                    = $res;
      $token['approver_id']           = $input_data['approver1'];
      $token['approver_date_col']     = 'approver1_date';
      $json_token                     =  json_encode($token);
      $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['approver1'],
        'type' => 'exemptut',
        'content_id' => $res,
        'location' => 'selfservices/exemptut',
        'description' => $description
      );
      $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
      $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
      $notif = $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('requests/exemptut');
      return;
    }
    $this->session->set_flashdata('ERR', 'Fail to add new data');
    redirect('requests/request_exemptut');
  }

  function exemptut_withdraw($id)
  {
    $this->selfservices_model->EXEMPT_UNDERTIME_WITHDRAW($id);
    $this->session->set_flashdata('SUCC', 'Exempt Undertime request has been Withdrawn!');
    redirect('teams/exemptut');
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
  $modules = array_unique($modules, SORT_REGULAR);
  return $modules;
}

function parseJsonData($rawData)
{
  $jsonData = json_decode($rawData, true);
  if (!is_array($jsonData) || json_last_error() !== JSON_ERROR_NONE) {
    throw new Exception('Invalid JSON data');
  }
  return $jsonData;
}
