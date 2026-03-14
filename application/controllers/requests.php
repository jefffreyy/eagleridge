<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class requests extends CI_Controller
{
  public $requests_model;
  function __construct()
  {
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('modules/overtimes_model');
    $this->load->model('modules/requests_model');
    $this->load->model('modules/leaves_model');
    $this->load->model('modules/selfservices_model');
    
    $this->load->model('home/home_model');
    $this->load->library('encrypt');
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

    $maintenance                            = $this->login_model->GET_MAINTENANCE();
    $isAdmin                                = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }


  function index()
  {
    $data["Modules"] =  array(
      array("title" => "Overtime Request",     "value" => "Overtime-Overtime Request",  "icon" => "clock-nine-duotone.svg",            "info" => "Lets you view and initiate an overtime request for hours worked beyond their regular work schedule. ",      "url" => "requests/overtime",         "access" => "Request", "id" => "overtime_overtime"),
      array("title" => "Leave Request",        "value" => "Leave Request",              "icon" => "house-person-leave-duotone.svg", 		"info" => "Lets you view the leave requests and initiate the leave request process by submitting a formal request for time off.",		"url" => "requests/leave_lists",     "access" => "Request", "id" => "leave_request"),
      // array("title" => "Holiday Work", "value" => "Overtime-Holiday Work",          "icon" => "calendar-xmark-duotone-2xl.svg",    "info" => "Lets you view and initiate a holiday work overtime request for hours worked on a recognized holiday. ",      "url" => "overtimes/holiday_works",    "access" => "Overtime", "id" => "overtime_holidaywork"),
      
      array("title" => "Change Shift Request", "value" => "Change-Shift Request",          "icon" => "calendar-xmark-duotone-2xl.svg",    "info" => " ",      "url" => "requests/change_shift",    "access" => "Request", "id" => "change_shift"),
      array("title" => "Change Off Request", "value" => "Change-Off Request",          "icon" => "calendar-xmark-duotone-2xl.svg",    "info" => " ",      "url" => "requests/change_off",    "access" => "Request", "id" => "change_off"),
      array("title" => "Undertime Request", "value" => "Undertime-Request",          "icon" => "calendar-xmark-duotone-2xl.svg",    "info" => " ",      "url" => "requests/undertime",    "access" => "Request", "id" => "undertime"),
      array("title" => "Offset Request", "value" => "Offset-Request",          "icon" => "calendar-xmark-duotone-2xl.svg",    "info" => " ",      "url" => "requests/apply_offsets",    "access" => "Request", "id" => "apply_offsets"),
      array("title" => "Exempt Undertime Requests",   "value" => "Exempt Undertime Approval",         "icon" => "table-list-duotone-att.svg",     "info" => "",             "url" => "requests/exemptut",      "access" => "Self-Service", "id" => "exemptut_approval"),
      
    );

    $data["overtime_pending_count"]         = $this->overtimes_model->GET_PENDING_OVERTIME_COUNT();
    $data["holiday_work_pending_count"]     = $this->overtimes_model->GET_PENDING_HOLIDAY_WORK_COUNT();
    $data['leave_request_pending_count']		= $this->leaves_model->GET_PENDING_LEAVE_COUNT();
    // $data['settings']                       = "overtimes/setting_general";
    // $data['settings']                       = "overtimes/overtime_step";

    $data["title_page"]                     = "Requests Management";
    $data["title_description"]              = "Allows you to oversee and administer all of the requests";
    $user_access_id                         = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE']          = $this->main_nav_model->GET_USER_ACCESS_PAGE($user_access_id['col_user_access']);
    $array_page                             = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
    $data["maiya_theme"]                    = $this->overtimes_model->GET_MAYA_THEME();
    $data['Modules']                        = filter_array($data["Modules"], $array_page);
    $this->load->view('templates/header');
    $this->load->view('templates/main_container', $data);
  }

  function change_shift(){

    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);

    $data['STATUS']                                  = $status;
    $data['STATUSES']                                = array('Pending', 'Approved', 'Rejected', 'Withdrawed');
    $data['TABLE_DATA']                              = $tablbe_data = $this->requests_model->GET_EMPL_CHANGESHIFT($userId, $status, $limit, $offset);

    foreach ($tablbe_data as $row_shift) {
      $shift_result = $this->requests_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
      $shift_result_to = $this->requests_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift_to);

      if ($shift_result) {
        $row_shift->request_shift = $shift_result->name;
      }

      if ($shift_result_to) {
        $row_shift->request_shift_to = $shift_result_to->name;
      }
    }

    $total_count                                     = $this->requests_model->GET_EMPL_CHANGESHIFT_COUNT($userId, $status);

    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
    $data['DATE_FORMAT']                              = $this->requests_model->GET_SYSTEM_SETTINGS("date_format");


    $this->load->view('templates/header');
    $this->load->view('modules/requests/change_shift_request_views', $data);
  }

  function changeshift_withdraw($id)
  {
    $this->requests_model->CHANGESHIFT_WITHDRAW($id);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Withdrew change shift request ID: ' . $id);
    $this->session->set_flashdata('SUCC', 'Change shift request has been Withdrawn!');
    redirect('requests/change_shift');
  }

  function change_off(){
    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);

    $data['STATUS']                                  = $status;
    $data['STATUSES']                                = array('Pending', 'Approved', 'Rejected', 'Withdrawed');
    $data['TABLE_DATA']                              = $tablbe_data = $this->requests_model->GET_EMPL_CHANGEOFF($userId, $status, $limit, $offset);

    foreach ($tablbe_data as $row_shift) {
      $shift_result = $this->requests_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
      $shift_result_to = $this->requests_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift_to);

      if ($shift_result) {
        $row_shift->request_shift = $shift_result->name;
      }

      if ($shift_result_to) {
        $row_shift->request_shift_to = $shift_result_to->name;
      }
    }

    $total_count                                     = $this->requests_model->GET_EMPL_CHANGEOFF_COUNT($userId, $status);

    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
    $data['DATE_FORMAT']                              = $this->requests_model->GET_SYSTEM_SETTINGS("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/requests/changeoff_views', $data);
  }

  function changeoff_withdraw($id)
  {
    $this->requests_model->CHANGEOFF_WITHDRAW($id);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Withdrew change off request ID: ' . $id);
    $this->session->set_flashdata('SUCC', 'Change off request has been Withdrawn!');
    redirect('requests/change_off');
  }

  function undertime(){
    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);

    $data['STATUS']                                  = $status;
    $data['STATUSES']                                 = array('Pending', 'Approved', 'Rejected', 'Withdrawn');
    $data['TABLE_DATA']                              = $tablbe_data = $this->requests_model->GET_EMPL_UNDERTIME($userId, $status, $limit, $offset);

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

    $total_count                                     = $this->requests_model->GET_EMPL_UNDERTIME_COUNT($userId, $status);

    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
    $data['DATE_FORMAT']                             = $this->requests_model->GET_SYSTEM_SETTINGS("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/requests/undertime_views', $data);
  }

  function undertime_withdraw($id)
  {
    $this->requests_model->UNDERTIME_WITHDRAW($id);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Withdrew undertime request ID: ' . $id);
    $this->session->set_flashdata('SUCC', 'Undertime request has been Withdrawn!');
    redirect('requests/undertime');
  }

  function apply_offsets(){
    
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

    $data['DEPARTMENTS']                 = $this->requests_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES']                   = $this->requests_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES']                    = $this->requests_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS']                   = $this->requests_model->GET_STD_DATA('tbl_std_divisions');
    $data['CLUBHOUSE']                   = $this->requests_model->GET_STD_DATA('tbl_std_clubhouse');
    $data['SECTIONS']                    = $this->requests_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS']                      = $this->requests_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS']                       = $this->requests_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES']                       = $this->requests_model->GET_STD_DATA('tbl_std_lines');

    $data['DISP_VIEW_COMPANY']              = $this->requests_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']               = $this->requests_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']           = $this->requests_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']             = $this->requests_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']            = $this->requests_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']              = $this->requests_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                = $this->requests_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                 = $this->requests_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                 = $this->requests_model->GET_SYSTEM_SETTING("com_line");
    // $data['DISP_VIEW_REQUIREDAPPROVERS']        = $this->teams_model->GET_SYSTEM_SETTING("requireApprovers");
    $data['DISP_VIEW_REQUIREDAPPROVERS']    = 1;
    // $data['LEAVES']                      = $this->teams_model->GET_LEAVES2($status, $search, $limit, $offset, $filter_arr, $user_id);
    $data['TABLE_DATA']                     = $this->requests_model->GET_OFFSETS($status, $search, $limit, $offset, $filter_arr, $user_id);

    $total_count                            = $this->requests_model->GET_OFFSET_COUNT($search, $status, $filter_arr, $user_id);
    $excess                                 = $total_count % $limit;
    $data['C_DATA_COUNT']                   = $total_count;
    $data['PAGES_COUNT']                    = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                           = $page;
    $data['ROW']                            = $limit;
    $data['C_ROW_DISPLAY']                  = array(50);
    $data['DISP_EMPLOYEES_NONFILTERED']     = $this->requests_model->MOD_DISP_ALL_EMPLOYEES($user_id);

    $data['EMPLOYEES']                      = $this->requests_model->GET_EMPLOYEES_MEMBERS($user_id);
    $data['DATE_FORMAT']                    = $this->requests_model->GET_DATE_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/requests/apply_offset_views', $data);

  }
  

  function request_myshift()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $data['SHIFTLIST']                      = $this->requests_model->GET_ALL_SHIFTS();
    // $data['EMPLOYEES']                      = $this->teams_model->GET_EMPOLOYEES($user_id);
    $data['EMPLOYEES']                          = $this->requests_model->GET_EMPLOYEES_MEMBERS($user_id);
    $current_date                           = date('Y-m-d');
    // var_dump($step_count);
    $this->load->view('templates/header');
    $this->load->view('modules/requests/request_changeshift_views', $data);
  }


  function add_request_shift()
  {
    header('Content-Type: application/json');
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $input_data                                     = $this->input->post();
    $day_type                                       = $_POST['date_shift'];

    $input_data['status']                           = 'Pending 1';
    $approvers                                      = $this->requests_model->GET_USERS_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    // var_dump($approvers);
    $approver                                       = $approvers && $approvers->checked_by ? $approvers->checked_by : 0;
    $autoApprovedEnabled                            = $this->requests_model->getApprovalsAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('requests/request_myshift');
    }
    if (
      $autoApprovedEnabled ||
      ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0))
    ) {
      $input_data['status'] = 'Approved';
    }

    if ($input_data['current_shift'] == 'No shift assign' || $input_data['current_shift'] == '') {
      $this->session->set_flashdata("ERR", "Missing Shift. Please check shifts first then try again");
      redirect('requests/request_myshift');
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

    $res                = $this->requests_model->ADD_CHANGESHIFT_REQUEST($input_data);

    if ($res && $input_data['status'] == 'Approved') {
      $this->requests_model->UPDATE_CHANGESHIFT($input_data['empl_id'], $input_data['date_shift'], $input_data['request_shift']);
    }

    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->requests_model->GET_REQUESTORS('shiftrequest', $res);
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
      $notif = $this->requests_model->ADD_NOTIFICATIONS($notif_data);
    }

    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Created change shift request ID: ' . $res);
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('requests/change_shift');
      return;
    }

    $this->session->set_flashdata('ERR', 'Fail to add new data');
    redirect('requests/request_myshift');
  }

  function request_change_off(){
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $user_department                        = $this->requests_model->GET_USER_DEPARMENT($user_id);
    $data['SHIFTLIST']                      = $this->requests_model->GET_ALL_SHIFTS();
    // $data['EMPLOYEES']                      = $this->teams_model->GET_EMPOLOYEES($user_id);
    $data['EMPLOYEES']                          = $this->requests_model->GET_EMPLOYEES_MEMBERS($user_id);
    $current_date                           = date('Y-m-d');
    $data['USER_DEPARTMENT']                = $user_department;
    $data['holiday_info']                   = $this->requests_model->MOD_DISP_HOLIDAY_BASED_DATE($current_date);
    $data['is_holiday']                     = !empty($data['holiday_info']);
    // var_dump($step_count);
    $this->load->view('templates/header');
    $this->load->view('modules/requests/request_changeoff_views', $data);
  }


  
  function add_request_change_off()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $input_data                                     = $this->input->post();
    $day_type                                       = $_POST['date_shift'];

    $input_data['status']                           = 'Pending 1';
    $approvers                                      = $this->requests_model->GET_USERS_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    // var_dump($approvers);
    $approver                                       = $approvers && $approvers->checked_by ? $approvers->checked_by : 0;
    $autoApprovedEnabled  = $this->requests_model->getApprovalsAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('requests/request_change_off');
    }
    if (
      $autoApprovedEnabled ||
      ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0))
    ) {
      $input_data['status'] = 'Approved';
    }

    if ($input_data['current_shift'] == 'No shift assign' || $input_data['current_shift'] == '' || $input_data['current_shift_to'] == 'No shift assign' ||  $input_data['current_shift_to'] == '') {
      $this->session->set_flashdata("ERR", "Missing Shift. Please check shifts first then try again");
      redirect('requests/request_change_off');
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

    $res                = $this->requests_model->ADD_CHANGEOFF_REQUEST($input_data);


    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->requests_model->GET_REQUESTORS('changeOff', $res);
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
      $notif = $this->requests_model->ADD_NOTIFICATIONS($notif_data);
    }

    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Created change off request ID: ' . $res);
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('requests/change_off');
      return;
    }

    $this->session->set_flashdata('ERR', 'Fail to add new data');
    redirect('requests/request_change_off');
  }

  function request_undertime()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $user_department                        = $this->requests_model->GET_USER_DEPARMENT($user_id);
    $data['SHIFTLIST']                      = $this->requests_model->GET_ALL_SHIFTS();
    // $data['EMPLOYEES']                      = $this->teams_model->GET_EMPOLOYEES($user_id);
    $data['EMPLOYEES']                      = $this->requests_model->GET_EMPLOYEES_MEMBERS($user_id);
    $current_date                           = date('Y-m-d');
    $data['USER_DEPARTMENT']                = $user_department;
    $data['holiday_info']                   = $this->requests_model->MOD_DISP_HOLIDAY_BASED_DATE($current_date);
    $data['is_holiday']                     = !empty($data['holiday_info']);

    $this->load->view('templates/header');
    $this->load->view('modules/requests/request_undertime_views', $data);
  }

  
  function add_request_undertime()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $input_data                                     = $this->input->post();
    $day_type                                       = $_POST['date_shift'];

    $input_data['status']                           = 'Pending 1';
    $approvers                                      = $this->requests_model->GET_USERS_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    // var_dump($approvers);
    $approver                                       = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $autoApprovedEnabled                            = $this->requests_model->getApprovalsAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('requests/request_undertime');
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

    $res                = $this->requests_model->ADD_UNDERTIME_REQUEST($input_data);


    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->requests_model->GET_REQUESTORS('undertimeRequest', $res);
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
      $notif = $this->requests_model->ADD_NOTIFICATIONS($notif_data);
    }

    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Created undertime request ID: ' . $res);
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('requests/undertime');
      return;
    }

    $this->session->set_flashdata('ERR', 'Fail to add new data');
    redirect('requests/request_undertime');
  }

  function acquire_offset()
  {
    $data['userId']                                 = $user_id = $this->session->userdata('SESS_USER_ID');
    $data['EMPLOYEES']                              = $this->requests_model->GET_EMPLOYEES_MEMBERS($user_id);

    $this->load->view('templates/header');
    $this->load->view('modules/requests/acquire_offset_request_views', $data);
  }

  function redeemed_offset()
  {
    $data['userId']                                 = $user_id = $this->session->userdata('SESS_USER_ID');
    $data['EMPLOYEES']                              = $this->requests_model->GET_EMPLOYEES_MEMBERS($user_id);

    $data['DISP_TOTAL_REDEEMED_OFFSET']             = $total_redeemed     = $this->requests_model->GET_TOTAL_REDEEMED_OFFSET($user_id);
    $data['DISP_TOTAL_ACQUIRED_OFFSET']             = $total_acquired     = $this->requests_model->GET_TOTAL_ACQUIRED_OFFSET($user_id);
    $data['DISP_TOTAL_OFFSET']                      = $total_acquired->total_acquired_offset - $total_redeemed->total_redeemed_offset;

    // $data['isLeaveHours']                       = $this->teams_model->get_leaves_settings_by_setting('isLeaveHours','1');
    $this->load->view('templates/header');
    $this->load->view('modules/requests/request_offset_views', $data);
  }

  function add_new_offset()
  {
    $user_id                                          = $this->session->userdata('SESS_USER_ID');
    // $isApproversEnable                  = $this->selfservices_model->GET_SETUP_SETTING('requireApprovers');
    // $attachment                         = $_FILES['attachment']['name'];
    $input_data                                       = $this->input->post();
    $date = $input_data['offset_date'];
    if (preg_match('/^\d{1,3}-\d{2}-\d{2}$/', $date) || preg_match('/^\d{5,}-\d{2}-\d{2}$/', $date)) {
      $this->session->set_flashdata('ERR', "Invalid Date. Please fix and try again");
      redirect('requests/apply_offsets');
    }

    $input_data['assigned_by']                        = $user_id;
    // $input_data['empl_id']              = $empl_id;
    // $input_data['status']               = $isApproversEnable == 1 ? 'Pending 1' : 'Approved';
    $input_data['status']                             = 'Pending 1';
    // $file_info = pathinfo($attachment);
    $input_data['create_date']                        = date('Y-m-d H:i:s');
    $input_data['edit_date']                          = date('Y-m-d H:i:s');
    $employee                                         = $this->requests_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
    $approvers                                        = $this->requests_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');

    $autoApprovedEnabled = $this->selfservices_model->getApprovalAutoApproveEnabledovertime($input_data['empl_id']);

    if ($autoApprovedEnabled) {
      $input_data['status'] = 'Approved';
    }

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

    $is_duplicate                                     = $this->requests_model->GET_OFFSETS_IS_DUPLICATE_DATE_EMPL_ID($input_data['offset_type'], $input_data['offset_date'], $user_id);

    if ($is_duplicate > 0) {
      $this->session->set_flashdata('ERR', "Offset submission failed. It looks like you have already submitted a offset request for the same dates.");
      redirect('requests/apply_offsets');
      return;
    } else {
      $res                                            = $this->requests_model->ADD_OFFSET_REQUEST($input_data);
      if ($res) {
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Created offset request ID: ' . $res);
        $this->session->set_flashdata('SUCC', 'Successfully added');
        if ($isApproversEnable == 0) {
          redirect('requests/apply_offsets');
          return;
        }
        $requestor      = $this->requests_model->GET_REQUESTORS('offsets', $res);
        $description    = "Offset Application Review for [OFF" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
        $notif_data     = array(
          'create_date' => date('Y-m-d H:i:s'),
          'empl_id' => $approvers->approver_1a,
          'type' => 'offset',
          'content_id' => $res,
          'location' => 'selfservices/offset_approval',
          'description' => $description
        );
        $notif = $this->requests_model->ADD_NOTIFICATIONS($notif_data);
      } else {
        $this->session->set_flashdata('ERR', 'Fail to add new data');
        redirect('requests/apply_offsets');
        return;
      }
    }
    redirect('requests/apply_offsets');
  }
  


  function overtime()
  {
    $data['TABLE_DATA']                     =  array();
    $data['DATE_FORMAT']                    = $this->overtimes_model->GET_SYSTEM_SETTING("date_format");
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

    // echo "<pre>";
    // echo "search";
    // echo "<br>";
    // print_r($search);
    // echo "<pre>"; die();

    $data['TABLE_DATA']                     = $this->overtimes_model->GET_OVERTIMES($status, $search, $limit, $offset, $filter_arr, $user_id);
    $total_count                            = $this->overtimes_model->GET_OVERTIMES_COUNT($status, $search, $filter_arr, $user_id);


    $data['STATUS']                         = $status;
    $data['STATUSES']                       = array('Pending', 'Approved', 'Rejected', 'Withdrawn');
    // $data['TABLE_DATA']                     = $this->overtimes_model->GET_OVERTIMES($status, $search, $limit, $offset, $filter_arr,$user_id);
    // $total_count                            = $this->overtimes_model->GET_OVERTIMES_COUNT($status, $search, $filter_arr,$user_id);
    $excess                                 = $total_count % $limit;
    $data['C_DATA_COUNT']                   = $total_count;
    $data['PAGES_COUNT']                    = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                           = $page;
    $data['ROW']                            = $limit;
    $data['C_ROW_DISPLAY']                  = array(50);

    $data['DEPARTMENTS']                    = $this->overtimes_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES']                      =   $this->overtimes_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES']                       =   $this->overtimes_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS']                      =   $this->overtimes_model->GET_STD_DATA('tbl_std_divisions');
    $data['CLUBHOUSE']                      =   $this->overtimes_model->GET_STD_DATA('tbl_std_clubhouse');
    $data['SECTIONS']                       =   $this->overtimes_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS']                         =   $this->overtimes_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS']                          =   $this->overtimes_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES']                          =   $this->overtimes_model->GET_STD_DATA('tbl_std_lines');

    // $data['DISP_VIEW_COMPANY']              = $this->overtimes_model->GET_SYSTEM_SETTING("com_company");
    // $data['DISP_VIEW_BRANCH']               = $this->overtimes_model->GET_SYSTEM_SETTING("com_branch");
    // $data['DISP_VIEW_DEPARTMENT']           = $this->overtimes_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_COMPANY']              = $this->overtimes_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']               = $this->overtimes_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']           = $this->overtimes_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']             = $this->overtimes_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']             = $this->overtimes_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']              = $this->overtimes_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                = $this->overtimes_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                 = $this->overtimes_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                 = $this->overtimes_model->GET_SYSTEM_SETTING("com_line");
    // $data['EMPLOYEES']                      = $this->overtimes_model->GET_EMPLOYEES($user_id);
    $data['EMPLOYEES']                      = $this->overtimes_model->GET_EMPLOYEES_ALL();

    $data['multiple_request']                     = $this->overtimes_model->get_system_setup_by_setting('multiple_request', '0');

    $this->load->view('templates/header');
    $this->load->view('modules/requests/ovt_overtime_views', $data);
  }

  function request_overtime()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $current_date                           = date('Y-m-d');
    $data['disable_overtime_hours']         = $this->overtimes_model->get_system_setup_by_setting2('disable_overtime_hours', '0');
    $data['holiday_info']                   = $this->overtimes_model->MOD_DISP_HOLIDAY_BASED_DATE($current_date);
    $data['is_holiday']                     = !empty($data['holiday_info']);
    $data['C_EMPLOYEES']                    = $this->overtimes_model->GET_TEAMS($user_id);

    $this->load->view('templates/header');
    $this->load->view('modules/requests/add_overtime_views', $data);
  }

  function exemptut()
  { 
    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);

    $data['STATUS']                                  = $status;
    $data['STATUSES']                                = array('Pending', 'Approved', 'Rejected', 'Cancelled', 'Withdrawn');
    $data['TABLE_DATA']                              = $this->selfservices_model->GET_EMPL_EXEMPTUT_ALL($status, $limit, $offset);
    $total_count                                     = $this->selfservices_model->GET_EMPL_EXEMPTUT_COUNT_ALL($status);

    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/requests/exemput_list_views', $data);
  }

  function request_exemptut()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $user_department                        = $this->selfservices_model->GET_USER_DEPARMENT($user_id);
    $data['SHIFTLIST']                      = $this->selfservices_model->GET_ALL_SHIFTS();
    $data['EMPLOYEES']                      = $this->requests_model->GET_EMPLOYEES();
    $current_date                           = date('Y-m-d');
    $data['USER_DEPARTMENT']                = $user_department;
    $data['holiday_info']                   = $this->selfservices_model->MOD_DISP_HOLIDAY_BASED_DATE($current_date);
    $data['is_holiday']                     = !empty($data['holiday_info']);
    // var_dump($step_count);
    $this->load->view('templates/header');
    $this->load->view('modules/requests/request_exemptut_views', $data);
  }

function add_request_overtime()
{
    header('Content-Type: application/json');

    try {
        
        $input_data = $this->input->post();
        $userId     = $input_data['empl_id'];
        if (!$input_data) {
            echo json_encode([
                'messageError' => 'No POST data received'
            ]);
            exit;
        }

        $day_type = $input_data['date_ot'] ?? null;
        $date     = $input_data['date_ot'] ?? null;

        $input_data['status'] = 'Pending 1';
        $input_data['assigned_by'] = $this->session->userdata('SESS_USER_ID');

        $approvers = $this->selfservices_model->GET_USER_APPROVERS($userId, 'tbl_approvers');
        $day_types = $this->selfservices_model->GET_DAY_TYPE($day_type);

        $autoApprovedEnabled = $this->selfservices_model->getApprovalAutoApproveEnabledovertime($input_data['empl_id']);

        // Min allowed date = Today - 2 days
        $min_allowed_date = date('Y-m-d', strtotime('-2 days'));

        if ($date < $min_allowed_date) {
            echo json_encode([
                'messageError' => 'Past overtime must be filed within 2 days.'
            ]);
            exit;
        }

        // No approver check
        if (
            !$autoApprovedEnabled &&
            (!$approvers || (
                $approvers->approver_1a == 0 &&
                $approvers->approver_2a == 0 &&
                $approvers->approver_3a == 0
            ))
        ) {
            echo json_encode([
                'messageError' => 'No Approver. Please add approver first then try again'
            ]);
            exit;
        }

        // Auto approve logic
        if (
            $autoApprovedEnabled ||
            ((!$approvers || $approvers->approver_1a == 0) &&
            (!$approvers || $approvers->approver_2a == 0) &&
            (!$approvers || $approvers->approver_3a == 0) &&
            (!$approvers || $approvers->approver_4a == 0) &&
            (!$approvers || $approvers->approver_5a == 0))
        ) {
            $input_data['status'] = 'Approved';
        }

        $day_typess = $day_types ?: "Regular";

        // Approvers assignment
        $input_data['approver1'] = $approvers->approver_1a ?? 0;
        $input_data['approver2'] = $approvers->approver_2a ?? 0;
        $input_data['approver3'] = $approvers->approver_3a ?? 0;
        $input_data['approver4'] = $approvers->approver_4a ?? 0;
        $input_data['approver5'] = $approvers->approver_5a ?? 0;

        $input_data['approver1_b'] = $approvers->approver_1b ?? 0;
        $input_data['approver2_b'] = $approvers->approver_2b ?? 0;
        $input_data['approver3_b'] = $approvers->approver_3b ?? 0;
        $input_data['approver4_b'] = $approvers->approver_4b ?? 0;
        $input_data['approver5_b'] = $approvers->approver_5b ?? 0;

        $input_data['approved_by_1'] = $approvers->approved_by_1 ?? 0;
        $input_data['approved_by_2'] = $approvers->approved_by_2 ?? 0;
        $input_data['approved_by_3'] = $approvers->approved_by_3 ?? 0;
        $input_data['approved_by_4'] = $approvers->approved_by_4 ?? 0;
        $input_data['approved_by_5'] = $approvers->approved_by_5 ?? 0;

        // Save request
        $key = 'TECHNOS';
        $res = $this->requests_model->ADD_OVERTIME_REQUEST($input_data);

        if (!$res) {
            echo json_encode([
                'messageError' => 'Failed to save overtime request'
            ]);
            exit;
        }

        // SUCCESS JSON RESPONSE
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Created overtime request ID: ' . $res);
        echo json_encode([
            'status' => 'success',
            'redirect' => base_url('requests/overtime'),
            'message' => 'Successfully added'
        ]);
        exit;

    } catch (Throwable $e) {
        echo json_encode([
            'messageError' => 'Server Error: ' . $e->getMessage()
        ]);
        exit;
    }
}




  
  function add_overtime()
  {

    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $input_data                             = $this->input->post();
    $input_data['create_date']              = date('Y-m-d H:i:s');
    $input_data['edit_date']                = date('Y-m-d H:i:s');
    $input_data['status']                   = 'Pending 1';
    $input_data['assigned_by']              = $user_id;
    $approvers                              = $this->overtimes_model->GET_USER_APPROVERS($input_data['empl_id']);

    $input_data['approver1']                = $approvers || $approvers->approver_1a ? $approvers->approver_1a : 0;
    $input_data['approver2']                = $approvers || $approvers->approver_2a ? $approvers->approver_2a : 0;
    $input_data['approver3']                = $approvers || $approvers->approver_3a ? $approvers->approver_3a : 0;
    $input_data['approver4']                = $approvers || $approvers->approver_4a ? $approvers->approver_4a : 0;
    $input_data['approver5']                = $approvers || $approvers->approver_5a ? $approvers->approver_5a : 0;

    $input_data['approver1_b']              = $approvers || $approvers->approver_1b ? $approvers->approver_1b : 0;
    $input_data['approver2_b']              = $approvers || $approvers->approver_2b ? $approvers->approver_2b : 0;
    $input_data['approver3_b']              = $approvers || $approvers->approver_3b ? $approvers->approver_3b : 0;
    $input_data['approver4_b']              = $approvers || $approvers->approver_4b ? $approvers->approver_4b : 0;
    $input_data['approver5_b']              = $approvers || $approvers->approver_5b ? $approvers->approver_5b : 0;

    // $input_data['reason']                   = $input_data['reason'];

    $approver                               = $approvers->approver_1a ? $approvers->approver_1a : 0;

    $autoApprovedEnabled  = $this->overtimes_model->getApprovalAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('requests/request_overtime');
    }
    if ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0)
      && (!$approvers || $approvers->approver_3a == 0) && (!$approvers || $approvers->approver_4a == 0)
      && (!$approvers || $approvers->approver_5a == 0)
      && $autoApprovedEnabled
    ) {
      $input_data['status'] = 'Approved';
    }

    // if ($is_enable_approvers == 1) {
    //   if ($approver == 0) {
    //     $this->session->set_flashdata('ERR', 'No assign approvers');
    //     redirect('overtimes/request_overtime');
    //     return;
    //   }
    // }
    
    $res                                    = $this->overtimes_model->ADD_DATA('tbl_overtimes', $input_data);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Created overtime request ID: ' . $res);
    }
    $this->session->set_flashdata('SUCC', 'Successfully added');
    // if ($is_enable_approvers == 0) {
    //   redirect('overtimes/overtime');
    //   return;
    // }

    if ($res && $input_data['status'] != 'Approved') {

      $this->create_notification = function($approver, $res, $input_data) {
        $requestor      = $this->overtimes_model->GET_REQUESTOR('overtime', $res);
        $description    = "Overtime Application Review for [OVA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";

        // $notif_data     = array(
        //   'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $input_data['approver1'], 'type' => 'overtime',
        //   'content_id' => $res, 'location' => 'selfservices/overtime_approval', 'description' => $description
        // );

        $token['type']          = 'approval';
        $token['table']         = 'tbl_overtimes';
        $token['id']            = $res;
        $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));

        // $token['approver']              = 'approver1';
        // $token['id']                    = $res;
        // $token['approver_id']           = $input_data['approver1'];
        // $token['approver_date_col']     = 'approver1_date';

        $token = array(
          'approver' => $approver,
          'approver_id' => $approver,
          'approver_date_col' => $approver . '_date',
          'id' => $res
        );

        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));

        $notif_data     = array(
          'create_date' => date('Y-m-d H:i:s'), 
          'empl_id' => $approver, 
          'type' => 'overtime_approval',
          'content_id' => $res, 
          'location' => 'selfservices/overtime_approval', 
          'description' => $description
        );

        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif = $this->overtimes_model->ADD_NOTIFICATION($notif_data);
      };

      $approvers_list = array(
        $input_data['approver1'], $input_data['approver2'], $input_data['approver3'], $input_data['approver4'], $input_data['approver5'],
				$input_data['approver1_b'], $input_data['approver2_b'], $input_data['approver3_b'], $input_data['approver4_b'], $input_data['approver5_b']
      );

      foreach ($approvers_list as $approver){
        if($approver){
          call_user_func($this->create_notification, $approver, $res, $input_data);
        }
      }

      redirect('requests/overtime');
      return;

    }
    redirect('requests/overtime');

    // if ($res) {
    //   $this->session->set_flashdata('SUCC', 'Successfully added');
    // } else {
    //   $this->session->set_flashdata('ERR', 'Fail to add new data');
    //   redirect('attendances/add_overtime');
    //   return;
    // }
    // redirect('overtimes/overtime');
  }

  function overtime_recommendations()
  {
    $data['TABLE_DATA']                                = array();
    $cutoff                                            = $this->input->get('cutoff');
    $limit                                             = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                              = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                            = $limit * ($page - 1);
    $cut_off_data                                      = $this->overtimes_model->GET_CUTOFF();
    $date_from                                         = '';
    $date_to                                           = '';
    $data['CUTOFF_ID']                                 = 0;
    if (!$cutoff && $cut_off_data) {
      $date_from  = $cut_off_data[0]->date_from;
      $date_to    = $cut_off_data[0]->date_to;
    }
    if ($cutoff) {
      $cutoff_data_row    = $this->overtimes_model->GET_DATA_ROW('tbl_payroll_period', 'id', $cutoff);
      $data['CUTOFF_ID']  = $cutoff_data_row->id;
      if ($cutoff_data_row) {
        $date_from  = $cutoff_data_row->date_from;
        $date_to    = $cutoff_data_row->date_to;
      }
    }
    $data['STATUSES']                                  = array('Pending', 'Approved', 'Rejected');
    $data['TABLE_DATA']                                = $this->overtimes_model->GET_ATT_RECORDS($limit, $offset, $date_from, $date_to);
    $total_count                                       = $this->overtimes_model->GET_ATT_RECORDS_COUNT($date_from, $date_to);
    $excess                                            = $total_count % $limit;
    $data['C_DATA_COUNT']                              = $total_count;
    $data['PAGES_COUNT']                               = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                      = $page;
    $data['ROW']                                       = $limit;
    $data['C_ROW_DISPLAY']                             = array(10, 25, 50);
    $data['CUTOFF']                                    = $cut_off_data;
    $this->load->view('templates/header');
    $this->load->view('modules/requests/ovt_overtime_recommendation_views', $data);
  }

  function overtime_multi()
  {
    $data['TABLE_DATA']                     =  array();
    $status                                 =  $this->input->get('status');
    $limit                                  =  $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                   =  $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                 =  $limit * ($page - 1);
    $search                                 = $this->input->get('search');
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $filter_arr                             = array();
    $filter_arr['company']                  = $this->input->get('company');
    $filter_arr['branch']                   = $this->input->get('branch');
    $filter_arr['dept']                     = $this->input->get('dept');
    $filter_arr['div']                      = $this->input->get('div');
    $filter_arr['section']                  = $this->input->get('section');
    $filter_arr['group']                    = $this->input->get('group');
    $filter_arr['team']                     = $this->input->get('team');
    $filter_arr['line']                     = $this->input->get('line');

    // echo "<pre>";
    // echo "search";
    // echo "<br>";
    // print_r($search);
    // echo "<pre>"; die();
    $data['TABLE_DATA']                     = $this->overtimes_model->GET_OVERTIMES_DIRECT($status, $search, $limit, $offset, $filter_arr);
    $total_count                            = $this->overtimes_model->GET_OVERTIMES_COUNT_DIRECT($status, $search, $filter_arr);

    $data['STATUS']                         = $status;
    $data['STATUSES']                       = array('Pending', 'Approved', 'Rejected');
    // $data['TABLE_DATA']                     = $this->overtimes_model->GET_OVERTIMES($status, $search, $limit, $offset, $filter_arr,$user_id);
    // $total_count                            = $this->overtimes_model->GET_OVERTIMES_COUNT($status, $search, $filter_arr,$user_id);
    $excess                                 = $total_count % $limit;
    $data['C_DATA_COUNT']                   = $total_count;
    $data['PAGES_COUNT']                    = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                           = $page;
    $data['ROW']                            = $limit;
    $data['C_ROW_DISPLAY']                  = array(10, 25, 50);

    $data['DEPARTMENTS']                    = $this->overtimes_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES']                      =   $this->overtimes_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES']                       =   $this->overtimes_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS']                      =   $this->overtimes_model->GET_STD_DATA('tbl_std_divisions');
    $data['SECTIONS']                       =   $this->overtimes_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS']                         =   $this->overtimes_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS']                          =   $this->overtimes_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES']                          =   $this->overtimes_model->GET_STD_DATA('tbl_std_lines');

    // $data['DISP_VIEW_COMPANY']              = $this->overtimes_model->GET_SYSTEM_SETTING("com_company");
    // $data['DISP_VIEW_BRANCH']               = $this->overtimes_model->GET_SYSTEM_SETTING("com_branch");
    // $data['DISP_VIEW_DEPARTMENT']           = $this->overtimes_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_COMPANY']              = $this->overtimes_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']               = $this->overtimes_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']           = $this->overtimes_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']             = $this->overtimes_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION']              = $this->overtimes_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                = $this->overtimes_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                 = $this->overtimes_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                 = $this->overtimes_model->GET_SYSTEM_SETTING("com_line");
    // $data['EMPLOYEES']                      = $this->overtimes_model->GET_EMPLOYEES($user_id);
    $data['EMPLOYEES']                      = $this->overtimes_model->GET_EMPLOYEES_ALL();


    $this->load->view('templates/header');
    $this->load->view('modules/requests/ovt_overtime_multi_views', $data);
  }


  function new_request_overtime_direct()
  {
    $data['DISP_EMPLOYEES_NONFILTERED']     = $this->overtimes_model->GET_EMPLOYEES_ALL();
    $this->load->view('templates/header');
    $this->load->view('modules/requests/new_overtime_request_direct_views', $data);
  }


  function leave_lists(){
    $data['LEAVES']             				= array();
		$status                     				= $this->input->get('status');
		$limit                      				= $this->input->get('row') ? $this->input->get('row')  : 50;
		$page                      					= $this->input->get('page') ? $this->input->get('page') : 1;
		$offset                     				=  $limit * ($page - 1);
		$search                     				= $this->input->get('search');

		$filter_arr                 				= array();
		$filter_arr['company']      				= $this->input->get('company');
		$filter_arr['branch']      					= $this->input->get('branch');
		$filter_arr['dept']         				= $this->input->get('dept');
		$filter_arr['div']          				= $this->input->get('div');
		$filter_arr['clubhouse']          				= $this->input->get('clubhouse');
		$filter_arr['section']      				= $this->input->get('section');
		$filter_arr['group']       					= $this->input->get('group');
		$filter_arr['team']        					= $this->input->get('team');
		$filter_arr['line']        					= $this->input->get('line');

		$data['STATUS']         					  = $status;
		$data['STATUSES']                   = array('Pending', 'Approved', 'Rejected', 'Withdrawed');

		$total_count 								        = $this->leaves_model->GET_LEAVES_COUNT($search, $status, $filter_arr);
		$excess      								        = $total_count % $limit;
		$data['C_DATA_COUNT']   					  = $total_count;
		$data['PAGES_COUNT']    					  = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
		$data['PAGE']           					  = $page;
		$data['ROW']            					  = $limit;
		$data['C_ROW_DISPLAY']  					  = array(50);

		$data['DEPARTMENTS']   	    				= $this->leaves_model->GET_STD_DATA('tbl_std_departments');
		$data['COMPANIES']     	    				= $this->leaves_model->GET_STD_DATA('tbl_std_companies');
		$data['BRANCHES']      	    				= $this->leaves_model->GET_STD_DATA('tbl_std_branches');
		$data['DIVISIONS']     	   				 	= $this->leaves_model->GET_STD_DATA('tbl_std_divisions');
		$data['CLUBHOUSE']     	   				 	= $this->leaves_model->GET_STD_DATA('tbl_std_clubhouse');
		$data['SECTIONS']      	    				= $this->leaves_model->GET_STD_DATA('tbl_std_sections');
		$data['GROUPS']        	    				= $this->leaves_model->GET_STD_DATA('tbl_std_groups');
		$data['TEAMS']         	    				= $this->leaves_model->GET_STD_DATA('tbl_std_teams');
		$data['LINES']         	    				= $this->leaves_model->GET_STD_DATA('tbl_std_lines');

		$data['DISP_VIEW_COMPANY']        			= $this->leaves_model->GET_SYSTEM_SETTING("com_company");
		$data['DISP_VIEW_BRANCH']         			= $this->leaves_model->GET_SYSTEM_SETTING("com_branch");
		$data['DISP_VIEW_DEPARTMENT']     			= $this->leaves_model->GET_SYSTEM_SETTING("com_Department");
		$data['DISP_VIEW_DIVISION']       			= $this->leaves_model->GET_SYSTEM_SETTING("com_division");
		$data['DISP_VIEW_CLUBHOUSE']       			= $this->leaves_model->GET_SYSTEM_SETTING("com_clubhouse");
		$data['DISP_VIEW_SECTION']        			= $this->leaves_model->GET_SYSTEM_SETTING("com_section");
		$data['DISP_VIEW_GROUP']          			= $this->leaves_model->GET_SYSTEM_SETTING("com_group");
		$data['DISP_VIEW_TEAM']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_team");
		$data['DISP_VIEW_LINE']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_line");

		$data['DATE_FORMAT']           			    = $this->leaves_model->GET_SYSTEM_SETTING("date_format");
		// $data['DATE_FORMAT']           			= $this->leaves_model->AUTO_INSERT_SETTINGS("date_format",);
		
		$data['LEAVES']         					      = $this->leaves_model->GET_LEAVES($status, $search, $limit, $offset, $filter_arr);
		$data['DISP_EMPLOYEES_NONFILTERED']     = $this->leaves_model->MOD_DISP_ALL_EMPLOYEES();
		$data['EMPLOYEES']                      = $this->leaves_model->GET_EMPLOYEES();
		$data['multiple_request']               = $this->leaves_model->get_system_setup_by_setting('multiple_request','0'); 

		// echo '<pre>';
		// var_dump($data['DISP_VIEW_REQUIREDAPPROVERS']);die(); 
		$this->load->view('templates/header');
		$this->load->view('modules/requests/leave_request_views', $data);
  }

  function leave_recommendation(){
    $data['TABLE_DATA']                                = array();
    $cutoff                                            = $this->input->get('cutoff');
    $limit                                             = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                              = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                            = $limit * ($page - 1);
    $cut_off_data                                      = $this->leaves_model->GET_CUTOFF();
    $date_from                                         = '';
    $date_to                                           = '';
    $data['CUTOFF_ID']                                 = 0;
    if(!$cutoff && $cut_off_data){
        $date_from  = $cut_off_data[0]->date_from;
        $date_to    = $cut_off_data[0]->date_to;
    }
    if($cutoff){
        $cutoff_data_row    = $this->leaves_model->GET_DATA_ROW('tbl_payroll_period','id',$cutoff);
        $data['CUTOFF_ID']  = $cutoff_data_row->id; 
        if($cutoff_data_row){
            $date_from  = $cutoff_data_row->date_from;
            $date_to    = $cutoff_data_row->date_to;
        }
    }
    $data['STATUSES']                                  = array('Pending', 'Approved', 'Rejected');
    $data['TABLE_DATA']                                = $this->leaves_model->GET_ATT_RECORDS($limit,$offset,$date_from,$date_to);
    $total_count                                       = $this->leaves_model->GET_ATT_RECORDS_COUNT($date_from,$date_to);
    $excess                                            = $total_count % $limit;
    $data['C_DATA_COUNT']                              = $total_count;
    $data['PAGES_COUNT']                               = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                      = $page;
    $data['ROW']                                       = $limit;
    $data['C_ROW_DISPLAY']                             = array(10, 25, 50);
    $data['CUTOFF']                                    = $cut_off_data;
    $data['LEAVE_TYPES']                               = $this->leaves_model->MOD_DISP_LEAVETYPES();
    $data['LEAVE_SETTINGS']     				       = $this->leaves_model->GET_ALL_LEAVE_SETTING();
    $data['EMPLOYEES']                                  = $this->leaves_model->GET_EMPLOYEES();
    
    $this->load->view('templates/header');
    $this->load->view('modules/requests/leave_recommendation_views',$data);
  }

  function leave_lists_multi()
	{
		$data['LEAVES']             				= array();
		$status                     				= $this->input->get('status');
		$limit                      				= $this->input->get('row') ? $this->input->get('row')  : 25;
		$page                      					= $this->input->get('page') ? $this->input->get('page') : 1;
		$offset                     				=  $limit * ($page - 1);
		$search                     				= $this->input->get('search');

		$filter_arr                 				= array();
		$filter_arr['company']      				= $this->input->get('company');
		$filter_arr['branch']      					= $this->input->get('branch');
		$filter_arr['dept']         				= $this->input->get('dept');
		$filter_arr['div']          				= $this->input->get('div');
		$filter_arr['clubhouse']          			= $this->input->get('clubhouse');

		$filter_arr['section']      				= $this->input->get('section');
		$filter_arr['group']       					= $this->input->get('group');
		$filter_arr['team']        					= $this->input->get('team');
		$filter_arr['line']        					= $this->input->get('line');

		$data['STATUS']         					= $status;
		$data['STATUSES'] 							= array('Pending', 'Withdrawed', 'Approved', 'Rejected');

		$total_count 								= $this->leaves_model->GET_LEAVES_COUNT($search, $status, $filter_arr);
		$excess      								= $total_count % $limit;
		$data['C_DATA_COUNT']   					= $total_count;
		$data['PAGES_COUNT']    					= $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
		$data['PAGE']           					= $page;
		$data['ROW']            					= $limit;
		$data['C_ROW_DISPLAY']  					= array(10, 25, 50);

		$data['DEPARTMENTS']   	    				= $this->leaves_model->GET_STD_DATA('tbl_std_departments');
		$data['COMPANIES']     	    				= $this->leaves_model->GET_STD_DATA('tbl_std_companies');
		$data['BRANCHES']      	    				= $this->leaves_model->GET_STD_DATA('tbl_std_branches');
		$data['DIVISIONS']     	   				 	= $this->leaves_model->GET_STD_DATA('tbl_std_divisions');
		$data['SECTIONS']      	    				= $this->leaves_model->GET_STD_DATA('tbl_std_sections');
		$data['GROUPS']        	    				= $this->leaves_model->GET_STD_DATA('tbl_std_groups');
		$data['TEAMS']         	    				= $this->leaves_model->GET_STD_DATA('tbl_std_teams');
		$data['LINES']         	    				= $this->leaves_model->GET_STD_DATA('tbl_std_lines');

		$data['DISP_VIEW_COMPANY']        			= $this->leaves_model->GET_SYSTEM_SETTING("com_company");
		$data['DISP_VIEW_BRANCH']         			= $this->leaves_model->GET_SYSTEM_SETTING("com_branch");
		$data['DISP_VIEW_DEPARTMENT']     			= $this->leaves_model->GET_SYSTEM_SETTING("com_Department");
		$data['DISP_VIEW_DIVISION']       			= $this->leaves_model->GET_SYSTEM_SETTING("com_division");
		$data['DISP_VIEW_SECTION']        			= $this->leaves_model->GET_SYSTEM_SETTING("com_section");
		$data['DISP_VIEW_GROUP']          			= $this->leaves_model->GET_SYSTEM_SETTING("com_group");
		$data['DISP_VIEW_TEAM']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_team");
		$data['DISP_VIEW_LINE']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_line");
		$data['DISP_VIEW_REQUIREDAPPROVERS']    = $this->leaves_model->GET_SYSTEM_SETTING("requireApprovers");
		
		$data['LEAVES']         					      = $this->leaves_model->GET_LEAVES2($status, $search, $limit, $offset, $filter_arr);
		$data['DISP_EMPLOYEES_NONFILTERED']     = $this->leaves_model->MOD_DISP_ALL_EMPLOYEES_NAME();
		$data['leaveTypes']     								= $this->leaves_model->leaveTypesNames();
		$data['EMPLOYEES']                      = $this->leaves_model->GET_EMPLOYEES();
		// echo '<pre>';
		// var_dump($data['DISP_VIEW_REQUIREDAPPROVERS']);die();
		$data['isLeaveHours']  = $this->leaves_model->get_leaves_settings_by_setting('isLeaveHours','1');
		$this->load->view('templates/header');
		$this->load->view('modules/requests/leave_request_multi_views', $data);
	}

	function new_request_leave_direct()
	{
		$data['DISP_EMPLOYEES_NONFILTERED']     = $this->leaves_model->MOD_DISP_ALL_EMPLOYEES_NAME();
		$data['leaveTypes']     				= $this->leaves_model->leaveTypesNames();
		$data['isLeaveHours']  = $this->leaves_model->get_leaves_settings_by_setting('isLeaveHours','1');
		$this->load->view('templates/header');
		$this->load->view('modules/requests/new_leave_request_direct_views', $data);
	}

  function request_leave()
	{
		//    $this->mailers->sendMail('aldrinlobis1@gmail.com','Aldrin');
		//    redirect('emails');
		// $validKeys = ['lwop_enable', 'offset_enable', 'sil_enable', 'vacation_enable', 'sick_enable', 'bereav_enable', 'maternity_enable', 'paternity_enable', 'soloparent_enable', 'marriage_enable', 'emergency_enable', 'other_enable'];

		// $credits = ['sil_credit', 'vacation_credit', 'sick_credit', 'bereav_credit', 'maternitycredit', 'paternity_credit', 'soloparent_credit', 'marriage_credit', 'emergency_credit', 'other_credit'];

		$data['LEAVE_SETTINGS']     				= $this->leaves_model->GET_ALL_LEAVE_SETTING();

		// $data['LEAVE_TYPE']   						= $this->leaves_model->MOD_DISP_LEAVETYPES();
		$data['LEAVE_TYPES']   						= $this->leaves_model->GET_LEAVE_TYPES_ACTIVE();

		// $data['settings']							= $this->leaves_model->MOD_DISP_LEAVE_TYPE_AND_SETTINGS();

		$data['EMPLOYEES']                          = $this->leaves_model->GET_EMPLOYEES();
		$data['isLeaveHours']   = $this->leaves_model->get_leaves_settings_by_setting('isLeaveHours','1');

		// var_dump($data['settings']);

		$this->load->view('templates/header');
		$this->load->view('modules/requests/new_leave_request_views', $data);
	}

  function exemptut_approval()
  {
    $user_id                        = $this->session->userdata('SESS_USER_ID');
    $search                                    = str_replace('_', ' ', $this->input->get('all') ?? "");
    $dept                                      = $this->input->get('dept');
    $sec                                       = $this->input->get('section');
    $group                                     = $this->input->get('group');
    $line                                      = $this->input->get('line');
    $branch                                    = $this->input->get('branch');
    $division                                  = $this->input->get('division');
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

    $data['DISP_EMPLOYEES']                   = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $data['DISP_TYPES']                       = $this->selfservices_model->GET_ALL_LEAVETYPES();
    $data['DISP_SHIFT']                       = $this->selfservices_model->GET_EXEMPTUT_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_EXEMPTUT_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team));
    // $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_COUNT_LEAVE_APPROVALS($user_id, $company, $dept, $sec, $group, $line, $branch, $division, $team));

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_leaves_assign');

    $data['DISP_DISTINCT_COMPANY']            = $this->selfservices_model->MOD_DISP_DISTINCT_COMPANY();
    $data['DISP_DISTINCT_BRANCH']             = $this->selfservices_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT']         = $this->selfservices_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']           = $this->selfservices_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_SECTION']            = $this->selfservices_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']              = $this->selfservices_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']               = $this->selfservices_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']               = $this->selfservices_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_COMPANY']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']                 = $this->selfservices_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']             = $this->selfservices_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']               = $this->selfservices_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                  = $this->selfservices_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_line");
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/requests/exemptut_approval_views', $data);
  }

  
  function exemptut_list_approval()
  {
    $user_id                                   = $this->session->userdata('SESS_USER_ID');
    $search                                    = str_replace('_', ' ', $this->input->get('all') ?? "");
    $dept                                      = $this->input->get('dept');
    $sec                                       = $this->input->get('section');
    $group                                     = $this->input->get('group');
    $line                                      = $this->input->get('line');
    $branch                                    = $this->input->get('branch');
    $division                                  = $this->input->get('division');
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

    $data['DISP_EMPLOYEES']                   = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $data['DISP_TYPES']                       = $this->selfservices_model->GET_ALL_LEAVETYPES();
    $data['DISP_SHIFT']                       = $this->selfservices_model->GET_EXEMPTUT_LIST_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_EXEMPTUT_LIST_APPROVALS_COUNT($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team));
    // $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_COUNT_LEAVE_APPROVALS($user_id, $company, $dept, $sec, $group, $line, $branch, $division, $team));

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_leaves_assign');

    $data['DISP_DISTINCT_COMPANY']            = $this->selfservices_model->MOD_DISP_DISTINCT_COMPANY();
    $data['DISP_DISTINCT_BRANCH']             = $this->selfservices_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT']         = $this->selfservices_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']           = $this->selfservices_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_SECTION']            = $this->selfservices_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']              = $this->selfservices_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']               = $this->selfservices_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']               = $this->selfservices_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_COMPANY']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']                 = $this->selfservices_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']             = $this->selfservices_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']               = $this->selfservices_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                  = $this->selfservices_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_line");
    $data['DATE_FORMAT']                      = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/requests/exemptut_list_approval_views', $data);
  }




} // end of requests class


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