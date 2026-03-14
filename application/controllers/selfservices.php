<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class selfservices extends CI_Controller
{
  private $isApproversEnable = 0;

  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('templates/main_nav_model');
    $this->load->model('templates/main_table_01_model');
    $this->load->model('templates/main_table_02_model');
    $this->load->model('modules/selfservices_model');
    $this->load->model('modules/leaves_model');

    $this->load->library('system_functions');
    $this->load->library('technos_encryption');
    $this->load->library('logger');
    $this->isApproversEnable = $this->selfservices_model->GET_SYSTEM_SETUP('requireApprovers');

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

    $maintenance = $this->selfservices_model->GET_MAINTENANCE();
    $isAdmin = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }

  function index()
  {
    $employee_id                = $this->session->userdata('SESS_USER_ID');
    $user_access                = $this->main_nav_model->get_user_access_id($employee_id);
    $exempt_undertime_access    = $this->selfservices_model->GET_SYSTEM_SETUP('selfservice_exempt_undertime');
    
    $exempt_undertime_ids = [];
    if ($exempt_undertime_access && !empty($exempt_undertime_access)) {
      $exempt_undertime_ids = explode(',', $exempt_undertime_access);
    }

    
    $this->db->select('value');
    $this->db->from('tbl_system_setup');
    $this->db->where('setting', 'selfservice_offset');
    $result = $this->db->get()->row();

    $allowed_ids = [];
    if ($result && !empty($result->value)) {
      $allowed_ids = explode(',', $result->value);
    } {
      $data["Modules"] =  array(
        array("title" => "My Profile",                "icon" => "address-card-duotone.svg",             "info" => "View your personal and employment information all in one page.",                                         "url" => "selfservices/my_profile_personal",          "access" => "Self-Service", "id" => "my_profile"),
        array("title" => "Remote Attendance",         "icon" => "map-location-dot-duotone.svg",         "info" => "Time-in and Time-out on the app",                                                                        "url" => "selfservices/my_time_in_outs",              "access" => "Self-Service", "id" => "my_time_in_outs"),
        array("title" => "My Attendance Record",      "icon" => "clock-duotone.svg",                    "info" => "Track your In/Out records and leaves all in one place.",                                                 "url" => "selfservices/my_time_records",              "access" => "Self-Service", "id" => "my_time_records"),
        array("title" => "My Time Adjustments",       "icon" => "rotate-duotone.svg",                   "info" => "Manage and rectify inaccuracies in your recorded work hours",                                            "url" => "selfservices/my_time_adjustments",          "access" => "Self-Service", "id" => "my_time_adjustments"),
        array("title" => "My Leaves",                 "icon" => "house-person-leave-duotone.svg",       "info" => "View, track, and manage leaves, ensuring you never miss a day.",                                         "url" => "selfservices/my_leaves",                    "access" => "Self-Service", "id" => "my_leaves"),
        array("title" => "My Overtimes",              "icon" => "gauge-max-duotone.svg",                "info" => "View, track, and manage overtime hours and pay with ease",                                               "url" => "selfservices/my_overtimes",                 "access" => "Self-Service", "id" => "my_overtimes"),
        array("title" => "My Offsets",                "icon" => "file-chart-column-duotone.svg",        "info" => "View, track, and manage offsets hours and pay with ease",                                                "url" => "selfservices/my_offsets",                 "access" => "Self-Service", "id" => "my_offsets"),
        array("title" => "My Holiday Work",           "icon" => "car-building-duotone.svg",             "info" => "View, track, and manage Holiday and pay with ease",                                                      "url" => "selfservices/my_holiday_work",              "access" => "Self-Service", "id" => "my_holiday_work"),
        array("title" => "My Reimbursements",           "icon" => "square-sliders-vertical-solid.svg",  "info" => "View, track, and manage Reimbursement and pay with ease",                                                "url" => "selfservices/my_reimbursement",              "access" => "Self-Service", "id" => "my_reimbursement"),
        array("title" => "My Cash Advances",           "icon" => "money-bill-1-wave-duotone.svg",       "info" => "View, track, and manage Cash Advance and pay with ease",                                                "url" => "selfservices/my_cashadvance",              "access" => "Self-Service", "id" => "my_cashadvance"),
        array("title" => "My Payslips",               "icon" => "file-invoice-duotone.svg",             "info" => "Access and review your payslips anytime, anywhere.",                                                     "url" => "selfservices/my_payslips",                  "access" => "Self-Service", "id" => "my_payslips"),
        array("title" => "My Support Requests",       "icon" => "comments-question-check-duotone.svg",  "info" => "Track, respond to, and resolve all your HR-related issues",                                              "url" => "selfservices/my_support_requests",          "access" => "Self-Service", "id" => "my_support_requests"),
        array("title" => "My Complaints",             "icon" => "person-sign-duotone.svg",              "info" => "Track and manage any grievances you've lodged with HR.",                                                 "url" => "selfservices/my_complaints",                "access" => "Self-Service", "id" => "my_complaints"),
        array("title" => "My Warnings",               "icon" => "circle-exclamation-duotone.svg",       "info" => "Check any disciplinary warnings issued to you",                                                          "url" => "selfservices/my_warnings",                  "access" => "Self-Service", "id" => "my_warnings"),
        array("title" => "My Loans",                  "icon" => "loans.svg",                            "info" => "View loan details, installments due, and repayment progress",                                            "url" => "selfservices/my_loans",                     "access" => "Self-Service", "id" => "my_loans"),
        array("title" => "My Team",                   "icon" => "people-group-duotone.svg",             "info" => "Visually maps your team structure.",                                                                     "url" => "selfservices/my_teams",                     "access" => "Self-Service", "id" => "my_team"),
        array("title" => "My Calendar",               "icon" => "calendar-range-duotone.svg",           "info" => "Centralizes your work schedule, tasks, and holidays.",                                                   "url" => "selfservices/my_calendars",                 "access" => "Self-Service", "id" => "my_calendar"),
        array("title" => "My Tasks",                  "icon" => "diagram-subtask-duotone.svg",          "info" => "View your to-dos keeping you on top of deadlines.",                                                      "url" => "selfservices/my_tasks",                     "access" => "Self-Service", "id" => "my_tasks"),
        array("title" => "Notifications",             "icon" => "light-emergency-on-duotone.svg",       "info" => "Receive reminders for tasks, approvals, and deadlines",                                                  "url" => "selfservices/notifications",                "access" => "Self-Service", "id" => "notifications"),
        array("title" => "Leave Approval",            "icon" => "plane-circle-check-duotone.svg",       "info" => "Review and approve (or deny) leave requests submitted by your team",                                     "url" => "selfservices/leave_approval",               "access" => "Self-Service", "id" => "leave_approval"),
        array("title" => "Overtime Approval",         "icon" => "person-circle-check-duotone.svg",      "info" => "Manage employee overtime requests, ensuring compliance with policies.",                                  "url" => "selfservices/overtime_approval",            "access" => "Self-Service", "id" => "overtime_approval"),
        array("title" => "Holiday Work Approval",     "icon" => "car-building-duotone.svg",             "info" => "Review and approve requests to work on holidays for specific duties",                                    "url" => "selfservices/holidaywork_approval",         "access" => "Self-Service", "id" => "holidaywork_approval"),
        array("title" => "Time Adjustment Approval",  "icon" => "reply-clock-duotone_ss.svg",           "info" => "Handle employee requests to adjust their recorded working hours.",                                    "url" => "selfservices/time_adjustment_approval",     "access" => "Self-Service", "id" => "time_adjustment_approval"),
        array("title" => "Offset Approval",           "icon" => "reply-clock-duotone.svg",              "info" => "",       "url" => "selfservices/offset_approval",              "access" => "Self-Service", "id" => "offset_approval"),
        // array("title" => "Backup Approvals",          "icon" => "stamp-duotone.svg",                    "info" => "Handle employee requests approval as secondary approver.",                                               "url" => "selfservices/backup_approvals",             "access" => "Self-Service", "id" => "backup_approval"),
        array("title" => "Backup Approvals",          "icon" => "stamp-duotone.svg",                    "info" => "Handle employee requests approval as secondary approver.",                                               "url" => "selfservices/backup_approvals",             "access" => "Self-Service", "id" => "backup_approval"),
        array("title" => "My Assets",                 "icon" => "hands-holding-dollar-duotone.svg",     "info" => "Review assets assigned to the employee",                                                                 "url" => "selfservices/my_assets",                    "access" => "Self-Service", "id" => "my_assets"),
        array("title" => "My Activities",             "icon" => "universal-access-duotone.svg",         "info" => "Review activity assigned to the employee",                                                               "url" => "selfservices/my_activities",                "access" => "Self-Service", "id" => "my_activities"),
        array("title" => "My Messages",               "icon" => "messages-question-duotone.svg",        "info" => "Allow employees to message and communicate other employees.",                                             "url" => "selfservices/my_messages",                  "access" => "Self-Service", "id" => "my_messages"),
        array("title" => "Shift Request Approvals",    "icon" => "check-to-slot-duotone.svg",           "info" => "",                                             "url" => "selfservices/shift_request_approval",                  "access" => "Self-Service", "id" => "shift_request_approval"),
        array("title" => "My Shift Assignment",        "value" => "My Shift Assignment",                "icon" => "chart-gantt-duotone-att.svg",    "info" => "",             "url" => "selfservices/my_shifts_assignment",      "access" => "Self-Service", "id" => "my_shifts_assignment"),
        array("title" => "Nurse Approval",              "value" => "Nurse Approval",                    "icon" => "file-import-duotone-att.svg",    "info" => "",             "url" => "selfservices/nurse_approval",         "access" => "Self-Service", "id" => "nurse_approval"),
        array("title" => "My Change Shift Request",     "value" => "My Change Shift Request",           "icon" => "calendar-clock-duotone.svg",     "info" => "",             "url" => "selfservices/mychange_shift",         "access" => "Self-Service", "id" => "mychange_shift"),
        array("title" => "My Change Off Request",       "value" => "My Change Off Request",             "icon" => "calendar-clock-duotone.svg",     "info" => "",             "url" => "selfservices/mychange_off",           "access" => "Self-Service", "id" => "mychange_off"),
        array("title" => "My Undertime Request",        "value" => "My Undertime Request",              "icon" => "calendar-clock-duotone.svg",     "info" => "",             "url" => "selfservices/my_undetime",            "access" => "Self-Service", "id" => "my_undetime"),
        array("title" => "My Exempt Undertime Request", "value" => "My Exempt Undertime Request",       "icon" => "clock-nine-duotone.svg",         "info" => "",             "url" => "selfservices/exemptut",               "access" => "Self-Service", "id" => "exemptut"),
        array("title" => "Change Shift Approval",       "value" => "Change Shift Approval",             "icon" => "calendar-check-duotone.svg",     "info" => "",             "url" => "selfservices/mychange_approval",      "access" => "Self-Service", "id" => "mychange_approval"),
        array("title" => "Change Off Approval",       "value" => "Change Off Approval",                 "icon" => "calendar-check-duotone.svg",     "info" => "",             "url" => "selfservices/mychange_off_approval",      "access" => "Self-Service", "id" => "mychange_off_approval"),

        array("title" => "My Exempt Undertime Approval",   "value" => "My Exempt Undertime Approval",         "icon" => "table-list-duotone-att.svg",     "info" => "",             "url" => "selfservices/exemptut_approval",      "access" => "Self-Service", "id" => "exemptut_approval"),
        array("title" => "Undertime Request Approval",   "value" => "Undertime Request Approval",       "icon" => "table-list-duotone-att.svg",     "info" => "",             "url" => "selfservices/undertime_request_approval",      "access" => "Self-Service", "id" => "undertime_request_approval"),
      );

      $data['DISP_REMOTE_ATTENDANCE']     = $this->selfservices_model->GET_SPECIFIC_EMPLOYEE_REMOTE_ATTENDANCE($this->session->userdata('SESS_USER_ID'));

      $data["title_page"]                 = "Self-services";
      $data["title_description"]          = "Allows employees to manage and accessing their own HR-related information. Employees can perform various tasks without having to rely on the HR department for every transaction.";
      $data["maiya_theme"]                = $this->selfservices_model->GET_MAYA_THEME();
      $user_access_id                     = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
      $data['DISP_USER_ACCESS_PAGE']      = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
      $array_page                         = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);

      if (!empty($allowed_ids) && !in_array($employee_id, $allowed_ids)) {
        $data["Modules"] = array_filter($data["Modules"], function ($module) {
          return $module["id"] !== "my_offsets";
        });
      }

      if (!empty($exempt_undertime_ids) && !in_array($employee_id, $exempt_undertime_ids)) {
        $data["Modules"] = array_filter($data["Modules"], function ($module) {
          return $module["id"] !== "exemptut";
        });
      }

      $data['Modules']                    = filter_array($data["Modules"], $array_page);
    }

    $this->load->view('templates/header');
    $this->load->view('templates/main_container', $data);
  }

  function get_messages_api()
  {
    $postData = json_decode(file_get_contents('php://input'), true);
    $receiverId = $postData['id'];
    // $groupId = $postData['groupId'];
    $senderId = $this->session->userdata('SESS_USER_ID');
    // echo '<pre>';
    // print_r($groupId); die();
    if (isset($postData['groupId'])) {
      $groupId = $postData['groupId'];
    } else {
      $groupId = $this->selfservices_model->get_message_group_id($senderId, $receiverId);
    }
    // echo '<pre>';
    // print_r($groupId); die();
    // if (empty($groupId)) {
    //   $groupId = $this->selfservices_model->get_message_group_id($senderId,$receiverId);
    // }

    $userId = $this->session->userdata('SESS_USER_ID');
    $messages = $this->selfservices_model->get_messages($groupId, $userId);
    if ($messages == 'Prohibited') {
      header('Content-Type: application/json');
      echo json_encode(array('groupId' => null, 'messages' => $messages, 'userId' => null));
    }
    header('Content-Type: application/json');
    echo json_encode(array('groupId' => $groupId, 'messages' => $messages, 'userId' => $userId,));
  }

  function send_messages_api()
  {
    $postData = json_decode(file_get_contents('php://input'), true);
    $groupId = $postData['groupId'];
    $userId = $this->session->userdata('SESS_USER_ID');
    $checkMembership = $this->selfservices_model->checkMembership($groupId, $userId);
    if (!$checkMembership) {
      header('Content-Type: application/json');
      echo json_encode(array('groupId' => $groupId, 'messages' => 'Prohibited', 'userId' => $userId));
      return;
    }
    $messageInputValue = $postData['messageInputValue'];
    $attachment = $postData['attachment'];

    $data = array(
      'create_date' => date("Y-m-d H:i:s"),
      'edit_date' => date("Y-m-d H:i:s"),
      'edit_user' => $userId,
      'group_id' => $groupId,
      'sender_id' => $userId,
      'message' => $messageInputValue,
      'attachment' => $attachment,
      'status' => 'Active',
      'seen_by' => $userId,
    );
    $response = $this->selfservices_model->send_messages_api($data);
    if ($response) {
      $messages = $this->selfservices_model->get_messages($groupId, $userId);
      if ($messages == 'Prohibited') {
        header('Content-Type: application/json');
        echo json_encode(array('groupId' => null, 'messages' => $messages, 'userId' => null));
      }
    } else {
      $messages = null;
    }

    header('Content-Type: application/json');
    echo json_encode(array('groupId' => $groupId, 'messages' => $messages, 'userId' => $userId));
  }

  function my_messages_api()
  {
    $postData = json_decode(file_get_contents('php://input'), true);
    $search = $postData['search'];

    // echo '<pre>';
    // print_r($search); die();
    $results = $this->selfservices_model->GET_EMPLOYEES_BY_SEARCH($search);
    header('Content-Type: application/json');
    echo json_encode($results);
  }
  function my_messages()
  {
    $data['data'] = [];
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $search = $this->input->get('search');
    $groupId = $this->input->get('groupId');
    $userId = $this->session->userdata('SESS_USER_ID');
    if (isset($search)) {
      $data['data'] = $this->selfservices_model->GET_EMPLOYEES_BY_SEARCH($search);
      $data['search'] = $search;
    } else if (isset($groupId) && !empty($groupId)) {
      $data['data'] = $this->selfservices_model->get_messages($groupId, $userId);
      if ($data['data'] == 'Prohibited') {
        redirect('login/session_expired');
      }
      $data['groupId'] = $groupId;
      $data['receiverName'] = $this->selfservices_model->get_group_member_name_by_groupId($groupId, $this->session->userdata('SESS_USER_ID'));
      $data['userId'] = $userId;
    } else {
      // $data['userId'] = $this->session->userdata('SESS_USER_ID');
      // echo 'test'; print_r($this->session->userdata('SESS_USER_ID')); die();
      $data['userId'] = $userId;
      $data['data'] = $this->selfservices_model->get_message_group_by_userId($this->session->userdata('SESS_USER_ID'));
      $data['unseenCount'] = $this->selfservices_model->get_unseen_messages($this->session->userdata('SESS_USER_ID'));
    }
    // echo '<pre>';
    // print_r($data['unseenCount']); die();
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/messages_views', $data);
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
    $data['C_NOTIFICATION']             = $this->selfservices_model->GET_NOTIFICATIONS($this->session->userdata('SESS_USER_ID'));
    $data['C_EMPLOYEES_ID']             = $this->selfservices_model->GET_EMPLOYEE_IDS();
    $data['DATE_FORMAT']                = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/notification_views', $data);
  }

  function view_notification($id)
  {
    $res        = $this->selfservices_model->UPDATE_NOTIFICATION($id);
    // $location   = $this->input->post('location') ? $this->input->post('location') : 'selfservices/notifications';
    // redirect($location);
    echo $res;
  }
  function mark_as_read()
  {
    $input_data = $this->input->post();

    $res        = $this->selfservices_model->UPDATE_NOTIFICATION($input_data['id']);
    echo $res;
  }
  function mark_all_as_read($id)
  {
    $res        = $this->selfservices_model->UPDATE_NOTIFICATION_READ_ALL($id);
    redirect('selfservices/notifications');
  }
  function delete_notification($id)
  {
    $res = $this->selfservices_model->DELETE_NOTIFICATION($id);
    redirect('selfservices/notifications');
  }
  function my_loans()
  {

    // var_dump($loan_count);
    $userId                                           = $this->session->userdata('SESS_USER_ID');
    // $data['DISP_PAYROLL_LOAN']                       = array();
    $status                                          = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          = $limit * ($page - 1);
    $search                                          = $this->input->get('all') ? $this->input->get('all') : '';

    $data['TAB']                                     = $status;
    $loan_data                       = $this->selfservices_model->GET_EMPL_LOANS($userId, $limit, $offset, $search);

    foreach ($loan_data as $row) {
      $row->loan_paid_count = $this->selfservices_model->GET_LOANS($row->id) + $row->initial_paid;
    }

    $data['DISP_PAYROLL_LOAN']                       = $loan_data;
    $total_count                                     = $this->selfservices_model->GET_EMPL_LOANS_COUNT($userId);
    $excess                                          = $total_count % $limit;

    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_loans_views', $data);
  }
  function get_loan_payments_api()
  {
    $json_data          = file_get_contents('php://input');
    $loanId               = json_decode($json_data);
    // $id                 = $data->id;
    $loan_payments      = $this->selfservices_model->get_loan_payments_api($loanId);

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($loan_payments));
  }
  function my_activities()
  {
    $user_id                                           = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                                = array();
    $limit                                             = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                              = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                            = $limit * ($page - 1);
    $date_from                                         = '';
    $date_to                                           = '';
    $data['TABLE_DATA']                                = $this->selfservices_model->GET_USER_ACTIVITIES($user_id, $limit, $offset);
    $total_count                                       = $this->selfservices_model->GET_USER_ACTIVITIES_COUNT($user_id);
    $excess                                            = $total_count % $limit;
    $data['C_DATA_COUNT']                              = $total_count;
    $data['PAGES_COUNT']                               = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                      = $page;
    $data['ROW']                                       = $limit;
    $data['C_ROW_DISPLAY']                             = array(10, 25, 50);
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_activity_views', $data);
  }
  function response_activity()
  {
    $input_data = $this->input->post();
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('response', 'Response', 'required|callback__validate_user_response');
    $this->form_validation->set_rules('id', 'Id', 'required|numeric');
    if ($this->form_validation->run() == FALSE) {
      $errors[] = form_error('response');
      $errors[] = form_error('id');
      $this->session->set_flashdata("ERR", join("", $errors));
    } else {
      $res = $this->selfservices_model->UPDATE_DATA('tbl_participants', $input_data['id'], $input_data);
      if ($res) {
        $this->session->set_flashdata("SUCC", 'Successfully Updated!');
      }
    }
    redirect("selfservices/my_activities");
  }
  function _validate_user_response($response)
  {
    $valid_response = array("Accepted", "Declined", "Maybe");
    if (!in_array($response, $valid_response)) {
      $this->form_validation->set_message('username_check', 'The ' . $response . ' is an invalid response.');
      return FALSE;
    }
    return TRUE;
  }
  function my_profile_personal()
  {

    $employee_id                        = $this->session->userdata('SESS_USER_ID');

    $data["C_COM_STRUCTURE"]            = $this->selfservices_model->GET_COMP_STRUCTURE();
    $data['DISP_VIEW_COMPANY']          = $this->selfservices_model->GET_SYSTEM_SETTING("com_company");
    $data['C_TYPE']                     = $this->selfservices_model->GET_TYPE();
    $data['C_POSITIONS']                = $this->selfservices_model->GET_POSITION();
    $data['C_COMPANIES']                = $this->selfservices_model->GET_COMPANIES();
    $data['C_BRANCH']                   = $this->selfservices_model->GET_BRANCHES();
    $data['C_DEPARTMENTS']              = $this->selfservices_model->GET_DEPARTMENTS();
    $data['C_DIVISIONS']                = $this->selfservices_model->GET_DIVISIONS();
    $data['C_SECTIONS']                 = $this->selfservices_model->GET_SECTIONS();
    $data['C_RESIGNATION_REASONS']      = $this->selfservices_model->GET_RESIGNATION_REASONS();
    $data['C_TERMINATION_REASONS']      = $this->selfservices_model->GET_TERMINATION_REASONS();
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
    $data['C_LOGS']                     = $this->selfservices_model->GET_EMPLOYEE_LOGS_SPECIFIC($employee_id);
    $data['C_OTHER_DETAILS']            = $this->selfservices_model->GET_EMPLOYEE_OTHER_DETAILS($employee_id);
    $data['DATE_FORMAT']                 = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    // echo '<pre>';
    // var_dump($data['C_OTHER_DETAILS']);
    // return;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_profile_personal_views', $data);
  }

  function edit_personal_detail($employee_id)
  {

    $data['C_SHIRT_SIZE']               = $this->selfservices_model->GET_SHIRT_SIZE();
    $data['C_GENDERS']                  = $this->selfservices_model->GET_GENDERS();
    $data['C_MARITAL']                  = $this->selfservices_model->GET_MARITAL();
    $data['C_NATIONALITY']              = $this->selfservices_model->GET_NATIONALITY();
    $data['C_EMP_INFO']                 = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC($employee_id);

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/edit_personal_detail_views', $data);
  }

  function update_personal_detail()
  {

    $user_id                            = $this->input->post('user_id');
    $first_name                         = $this->input->post('UPDATE_FIRSTNAME');
    $middlename                         = $this->input->post('UPDATE_MIDDLENAME');
    $lastname                           = $this->input->post('UPDATE_LASTNAME');
    $marital_status                     = $this->input->post('UPDATE_MART_STAT');
    $mobile_number                      = $this->input->post('UPDATE_MOB_NUM');
    $birthdate                          = $this->input->post('UPDATE_BIRTHDATE');
    $gender                             = $this->input->post('UPDATE_GENDER');
    $nationality                        = $this->input->post('UPDATE_NATIONALITY');
    $shirt_size                         = $this->input->post('UPDATE_SHIRT_SIZE');
    $email                              = $this->input->post('UPDATE_EMAIL');
    $home_address                       = $this->input->post('UPDATE_HOME_ADD');
    $current_address                    = $this->input->post('UPDATE_CURRENT_ADD');

    $old = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC($user_id);

    $new = [];
    foreach ($old[0] as $key => $value) {
      if ($key == "col_frst_name" && !empty($first_name) && $value != $first_name) {
        array_push($new, [
          $this->selfservices_model->columnCategory($key),
          $value,
          $first_name,
        ]);
      }
      if ($key == "col_midl_name" && !empty($middlename) && $value != $middlename) {
        array_push($new, [
          $this->selfservices_model->columnCategory($key),
          $value,
          $middlename,
        ]);
      }
      if ($key == "col_last_name" && !empty($lastname) && $value != $lastname) {
        array_push($new, [
          $this->selfservices_model->columnCategory($key),
          $value,
          $lastname,
        ]);
      }
      if ($key == "col_mart_stat" && !empty($marital_status) && $value != $marital_status) {
        array_push($new, [
          $this->selfservices_model->columnCategory($key),
          returnString($this->selfservices_model->GET_MARITAL(), 'name', $value),
          returnString($this->selfservices_model->GET_MARITAL(), 'name', $marital_status),
        ]);
      }
      if ($key == "col_mobl_numb" && !empty($mobile_number) && $value != $mobile_number) {
        array_push($new, [
          $this->selfservices_model->columnCategory($key),
          $value,
          $mobile_number,
        ]);
      }
      if ($key == "col_birt_date" && !empty($birthdate) && $value != $birthdate) {
        array_push($new, [
          $this->selfservices_model->columnCategory($key),
          $value,
          $birthdate,
        ]);
      }
      if ($key == "col_empl_gend" && !empty($gender) && $value != $gender) {
        array_push($new, [
          $this->selfservices_model->columnCategory($key),
          returnString($this->selfservices_model->GET_GENDERS(), 'name', $value),
          returnString($this->selfservices_model->GET_GENDERS(), 'name', $gender),
        ]);
      }
      if ($key == "col_empl_nati" && !empty($nationality) && $value != $nationality) {
        array_push($new, [
          $this->selfservices_model->columnCategory($key),
          returnString($this->selfservices_model->GET_NATIONALITY(), 'name', $value),
          returnString($this->selfservices_model->GET_NATIONALITY(), 'name', $nationality),
        ]);
      }
      if ($key == "col_shir_size" && !empty($shirt_size) && $value != $shirt_size) {
        array_push($new, [
          $this->selfservices_model->columnCategory($key),
          returnString($this->selfservices_model->GET_SHIRT_SIZE(), 'name', $value),
          returnString($this->selfservices_model->GET_SHIRT_SIZE(), 'name', $shirt_size),
        ]);
      }
      if ($key == "col_empl_emai" && !empty($email) && $value != $email) {
        array_push($new, [
          $this->selfservices_model->columnCategory($key),
          $value,
          $email,
        ]);
      }
      if ($key == "col_home_addr" && !empty($home_address) && $value != $home_address) {
        array_push($new, [
          $this->selfservices_model->columnCategory($key),
          $value,
          $home_address,
        ]);
      }
      if ($key == "col_curr_addr" && !empty($current_address) && $value != $current_address) {
        array_push($new, [
          $this->selfservices_model->columnCategory($key),
          $value,
          $current_address,
        ]);
      }
    }

    if (empty($new)) {
      $this->session->set_flashdata('SUCC', 'Personal details No Changes!');
      redirect('selfservices/my_profile_personal?id=' . $user_id);
    } else {
      $this->selfservices_model->UPDATE_PERSONAL_DETAIL($first_name, $middlename, $lastname, $marital_status, $mobile_number, $birthdate, $gender, $nationality, $shirt_size, $email, $home_address, $current_address, $user_id);
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated personal details');
      $edit_id = $this->session->userdata('SESS_USER_ID');
      $empl_id = $user_id;
      try {
        foreach ($new as $new_row) {
          $category = $new_row[0];
          $from_val = $new_row[1];
          $to_val = $new_row[2];
          $this->selfservices_model->ADD_EMPLOYEE_LOGS($edit_id, $empl_id, $category, $from_val, $to_val);
        }
        $this->session->set_flashdata('SUCC', 'Personal details updated successfully!');
        redirect('selfservices/my_profile_personal?id=' . $user_id);
        // redirect('employees/edit_personal_detail/'.$user_id);
      } catch (Exception $e) {
        $this->session->set_flashdata('SUCC', 'Personal details updated successfully!. But Log update error: ' . $e->getMessage());
        redirect('selfservices/my_profile_personal?id=' . $user_id);
      }
    }
  }

  function change_password()
  {

    $this->load->view('modules/selfservices/change_password_views');
  }

  function submit_new_password()
  {
    $user_id                            = $this->input->post('user_id');
    $current_pass                       = $this->input->post('current_password');
    $new_password                       = $this->input->post('new_password');
    $retype_password                    = $this->input->post('retype_password');
    $pass_key                           = $this->selfservices_model->GET_USER_PASSWORD_KEYS($user_id);

    if (!password_verify($current_pass . $pass_key->col_salt_key, $pass_key->col_user_pass)) {
      $this->session->set_userdata("SESS_ERR_PASSWORD", "Incorrent Current Password");
      $this->system_functions->log_access('Unable to change password', 'change password');
      redirect('selfservices/change_password');
    }

    if ($new_password == $retype_password) {
      if (preg_match('/[\^£$%&*()}{#~?><>,|=+¬-]/', $new_password)) {
        $this->session->set_userdata("SESS_ERR_PASSWORD", "Invalid Password only '@','_', and '.' are permitted");
        $this->system_functions->log_access('Unable to change password', 'change password');
        redirect('selfservices/change_password');
      } else {

        $this->selfservices_model->MOD_CHANGE_PASSWORD($new_password, $user_id);
        $this->session->set_flashdata('SESS_SUCC_MSG', 'Successfully change password!');
        $this->system_functions->log_access('Successfully change password', 'change password');
        redirect('selfservices/my_profile_personal');
      }
    } else {
      $this->session->set_userdata("SESS_ERR_PASSWORD", "Password does not match");
      $this->system_functions->log_access('Unable to change password', 'change password');
      redirect('selfservices/change_password');
    }
  }

  function my_teams()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_team_views');
  }

  function setup_my_teams()
  {
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

    $data['DISP_EMP_LIST']                    = $empl_list = $this->selfservices_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
    $data['ALL_EMPLOYEES']                    = $this->selfservices_model->GET_ALL_EMPLOYEES();
    $data['DISP_YEARS']                       = $year_list = $this->selfservices_model->GET_YEARS();
    $data['C_DATA_COUNT']                     = $this->selfservices_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);

    (!isset($_GET["year"])) ? $year           = $year_list[0]->id : $year = $_GET["year"];

    $data['YEAR_INITIAL']                     = $year;
    $data["DISP_ALLOWANCE"]                   = $this->selfservices_model->GET_ALLOWANCE_TAX_DATA($year);

    $data['DISP_DISTINCT_DEPARTMENT']         = $this->selfservices_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']           = $this->selfservices_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_SECTION']            = $this->selfservices_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_BRANCH']             = $this->selfservices_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_GROUP']              = $this->selfservices_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']               = $this->selfservices_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']               = $this->selfservices_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_DEPARTMENT']             = $this->selfservices_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']               = $this->selfservices_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_BRANCH']                 = $this->selfservices_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_GROUP']                  = $this->selfservices_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_line");

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/setup_my_team_views', $data);
  }

  function update_my_teams()
  {
    $ids                                      = explode(",", $this->input->post('employee_ids'));
    $action                                   = $this->input->post('action');
    $reporting_to                             = $this->session->userdata('SESS_USER_ID');
    if ($action == 'remove') {
      $reporting_to = '';
    }
    $res                                      = $this->selfservices_model->UPDATE_MY_TEAM($ids, $reporting_to);
    redirect('selfservices/setup_my_teams');
  }

  function my_calendars()
  {
    $data["TITLE"]                  = "My Calendar";
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_calendar_views', $data);
  }

  function fetch_data()
  {

    $data["HOLIDAYS_INFO"]                    = $this->selfservices_model->FETCH_HOLIDAYS();
    $data['EVENTS_INFO']                      = [];
    $data['TASK_INFO']                        = $this->selfservices_model->FETCH_TASKS($this->session->userdata('SESS_USER_ID'));
    $data['MY_SCHEDULE']                      = $this->selfservices_model->FETCH_MY_SCHEDULE($this->session->userdata('SESS_USER_ID'));
    echo json_encode($data);
  }

  function backup_approvals()
  {
    $user_id                                  = $this->session->userdata('SESS_USER_ID');
    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $approval_type                            = $this->input->get('approval');
    $dept                                     = $this->input->get('dept');
    $sec                                      = $this->input->get('section');
    $group                                    = $this->input->get('group');
    $line                                     = $this->input->get('line');
    $branch                                   = $this->input->get('branch');
    $division                                 = $this->input->get('division');
    $team                                     = $this->input->get('team');
    $status                                   = $this->input->get('status');
    $company                                  = $this->input->get('company');

    $data["C_ROW_DISPLAY"]                    = [25, 50, 100];

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
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
    $table                                    = 'tbl_leaves_assign';
    $columns                                  = "tb1.id,tb1.empl_id,tb1.type,tb1.leave_date as date,tb1.status,tb1.duration";
    $data['PREFIX']                           = 'LEA';
    $data['APPROVE_URL']                      = 'selfservices/leave_bulk_approve';
    $data['REJECT_URL']                       = 'selfservices/leave_bulk_reject';
    if ($approval_type == 'overtime') {
      $data['PREFIX'] = 'OVA';
      $data['APPROVE_URL']                    = 'selfservices/overtime_bulk_approve';
      $data['REJECT_URL']                     = 'selfservices/overtime_bulk_reject';
      $table                                  = 'tbl_overtimes';
      $columns                                = "tb1.id,tb1.empl_id,tb1.date_ot as date,tb1.type,tb1.hours as duration,tb1.status";
    }

    if ($approval_type == 'time_adjustments') {

      $data['PREFIX']  = 'TAD';
      $data['APPROVE_URL']                    = 'selfservices/time_adjustment_bulk_approve';
      $data['REJECT_URL']                     = 'selfservices/time_adjustment_bulk_reject';
      $table           = 'tbl_attendance_adjustments';
      $columns        = "tb1.id,tb1.empl_id,tb1.date_adjustment as date,tb1.shift_type as type,tb1.status,tb1.time_in_1,tb1.time_out_1";
    }

    if ($approval_type == 'holiday_work') {
      $data['PREFIX'] = 'HWA';
      $data['APPROVE_URL']                     = 'selfservices/holidaywork_bulk_approve';
      $data['REJECT_URL']                      = 'selfservices/holidaywork_bulk_reject';
      $table          = 'tbl_holidaywork';
      $columns        = "tb1.id,tb1.empl_id,tb1.date,tb1.type,tb1.status,tb1.hours as duration";
    }
    $data['DISP_EMPLOYEES']                   = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $data['DISP_TYPES']                       = $this->selfservices_model->GET_ALL_LEAVETYPES();
    $data['DISP_SHIFT']                       = $this->selfservices_model->GET_BACKUP_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team, $table, $columns);
    $data['C_DATA_COUNT']                     = $this->selfservices_model->GET_COUNT_BACKUP_APPROVALS($user_id, $company, $dept, $sec, $group, $line, $branch, $division, $team, $table);
    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES($table);
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

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/backup_approval_views', $data);
  }

  function offset_approval()
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
    $data['DISP_SHIFT']                       = $this->selfservices_model->GET_OFFSET_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_OFFSET_APPROVALS_COUNT($user_id, $company, $dept, $sec, $group, $line, $branch, $division, $team));

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_attendance_offsets');

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

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/offset_approval_views', $data);
  }

  function offset_list_approval(){
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

    $data['STATUS']                                    = $status;
    $data['STATUSES']                          = array('Pending', 'Approved', 'Rejected', 'Withdrawn');

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
    $data['DISP_SHIFT']                       = $this->selfservices_model->GET_OFFSET_APPROVALS_LIST($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team, $status);
    
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_OFFSET_APPROVALS_LIST_COUNT($user_id, $company, $dept, $sec, $group, $line, $branch, $division, $team, $status));

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_attendance_offsets');

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

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/offset_list_approval_views', $data);
  }

  function nurse_approval()
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
    $data['DISP_SHIFT']                       = $this->selfservices_model->GET_NURSE_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_NURSE_APPROVALS_COUNT($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team));
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
    $this->load->view('modules/selfservices/nurse_approval_views', $data);
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
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_EXEMPTUT_APPROVALS_COUNT($user_id, $company, $dept, $sec, $group, $line, $branch, $division, $team));
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
    $this->load->view('modules/selfservices/exemptut_approval_views', $data);
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
    $data['STATUS']                            = $status;
    $data['STATUSES']                          = array('Pending', 'Approved', 'Rejected', 'Withdrawn');

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
    $data['DISP_SHIFT']                       = $this->selfservices_model->GET_EXEMPTUT_LIST_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team, $status);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_EXEMPTUT_LIST_APPROVALS_COUNT($user_id, $company, $dept, $sec, $group, $line, $branch, $division, $team, $status));
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
    $this->load->view('modules/selfservices/exemptut_list_approval_views', $data);
  }

  function changeoff_list_approval()
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
    $data['STATUS']                                    = $status;
    $data['STATUSES']                          = array('Pending', 'Approved', 'Rejected', 'Withdrawn');
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

    $data['DISP_SHIFT']                       = $attendance_shifts = $this->selfservices_model->GET_CHANGEOFF_APPROVALS_LIST($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team, $status);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_CHANGEOFF_APPROVALS_LIST_COUNT($user_id, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team, $status));

    foreach ($attendance_shifts as $row_shift) {
      $shift_result = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
      $shift_result_to = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift_to);

      if ($shift_result) {
        $row_shift->request_shift = $shift_result->name;
      }

      if ($shift_result_to) {
        $row_shift->request_shift_to = $shift_result_to->name;
      }
    }

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_leaves_assign');

    $data['DISP_DISTINCT_COMPANY']            = $this->selfservices_model->MOD_DISP_DISTINCT_COMPANY();
    $data['DISP_DISTINCT_BRANCH']             = $this->selfservices_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT']         = $this->selfservices_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']           = $this->selfservices_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_CLUBHOUSE']          = $this->selfservices_model->MOD_DISP_DISTINCT_CLUBHOUSE();
    $data['DISP_DISTINCT_SECTION']            = $this->selfservices_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']              = $this->selfservices_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']               = $this->selfservices_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']               = $this->selfservices_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_COMPANY']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']                 = $this->selfservices_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']             = $this->selfservices_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']               = $this->selfservices_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                  = $this->selfservices_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_line");
    $data['DATE_FORMAT']                      = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $employeeSearchRaw                        = $this->selfservices_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
    foreach ($employeeSearchRaw as &$item) {
      if (!empty($item->col_suffix)) {
        $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
      }
      $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
    }
    unset($item);
    $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;


    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/changeoff_list_approval_views', $data);
  }

  function changeshift_list_approval(){
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
    $data['STATUS']                                    = $status;
    $data['STATUSES']                          = array('Pending', 'Approved', 'Rejected', 'Withdrawn');

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

    $data['DISP_SHIFT']                       = $attendance_shifts = $this->selfservices_model->GET_CHANGESHIFT_APPROVALS_LIST($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team, $status);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_CHANGESHIFT_APPROVALS_LIST_COUNT($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team, $status));

    foreach ($attendance_shifts as $row_shift) {
      $shift_result = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);

      if ($shift_result) {
        $row_shift->request_shift = $shift_result->name;
      }
    }

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_leaves_assign');

    $data['DISP_DISTINCT_COMPANY']            = $this->selfservices_model->MOD_DISP_DISTINCT_COMPANY();
    $data['DISP_DISTINCT_BRANCH']             = $this->selfservices_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT']         = $this->selfservices_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']           = $this->selfservices_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_CLUBHOUSE']          = $this->selfservices_model->MOD_DISP_DISTINCT_CLUBHOUSE();
    $data['DISP_DISTINCT_SECTION']            = $this->selfservices_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']              = $this->selfservices_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']               = $this->selfservices_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']               = $this->selfservices_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_COMPANY']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']                 = $this->selfservices_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']             = $this->selfservices_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']               = $this->selfservices_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                  = $this->selfservices_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_line");
    $data['DATE_FORMAT']                      = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $employeeSearchRaw                  = $this->selfservices_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
    foreach ($employeeSearchRaw as &$item) {
      if (!empty($item->col_suffix)) {
        $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
      }
      $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
    }
    unset($item);
    $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/changeshift_list_approval_views', $data);
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

    $data['DISP_EMPLOYEES']                   = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $data['DISP_TYPES']                       = $this->selfservices_model->GET_ALL_LEAVETYPES();

    $data['DISP_SHIFT']                       = $attendance_shifts = $this->selfservices_model->GET_CHANGESHIFT_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_CHANGESHIFT_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team));

    foreach ($attendance_shifts as $row_shift) {
      $shift_result = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);

      if ($shift_result) {
        $row_shift->request_shift = $shift_result->name;
      }
    }

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_leaves_assign');

    $data['DISP_DISTINCT_COMPANY']            = $this->selfservices_model->MOD_DISP_DISTINCT_COMPANY();
    $data['DISP_DISTINCT_BRANCH']             = $this->selfservices_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT']         = $this->selfservices_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']           = $this->selfservices_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_CLUBHOUSE']          = $this->selfservices_model->MOD_DISP_DISTINCT_CLUBHOUSE();
    $data['DISP_DISTINCT_SECTION']            = $this->selfservices_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']              = $this->selfservices_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']               = $this->selfservices_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']               = $this->selfservices_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_COMPANY']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']                 = $this->selfservices_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']             = $this->selfservices_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']               = $this->selfservices_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                  = $this->selfservices_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_line");
    $data['DATE_FORMAT']                      = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $employeeSearchRaw                  = $this->selfservices_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
    foreach ($employeeSearchRaw as &$item) {
      if (!empty($item->col_suffix)) {
        $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
      }
      $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
    }
    unset($item);
    $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/changeshift_approval_views', $data);
  }

  function undertime_request_approval()
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

    $data['DISP_EMPLOYEES']                   = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $data['DISP_TYPES']                       = $this->selfservices_model->GET_ALL_LEAVETYPES();

    $data['DISP_SHIFT']                       = $attendance_shifts = $this->selfservices_model->GET_UNDERTIME_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_UNDERTIME_APPROVALS_COUNT($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team));

    // foreach ($attendance_shifts as $row_shift) {
    //   $shift_result = $this->teams_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
    //   if ($shift_result) {
    //     $row_shift->request_shift = $shift_result->name;
    //   }
    // }

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_leaves_assign');

    $data['DISP_DISTINCT_COMPANY']            = $this->selfservices_model->MOD_DISP_DISTINCT_COMPANY();
    $data['DISP_DISTINCT_BRANCH']             = $this->selfservices_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT']         = $this->selfservices_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']           = $this->selfservices_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_CLUBHOUSE']          = $this->selfservices_model->MOD_DISP_DISTINCT_CLUBHOUSE();
    $data['DISP_DISTINCT_SECTION']            = $this->selfservices_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']              = $this->selfservices_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']               = $this->selfservices_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']               = $this->selfservices_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_COMPANY']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']                 = $this->selfservices_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']             = $this->selfservices_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']               = $this->selfservices_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                  = $this->selfservices_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_line");
    $data['DATE_FORMAT']                      = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $employeeSearchRaw                  = $this->selfservices_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
    foreach ($employeeSearchRaw as &$item) {
      if (!empty($item->col_suffix)) {
        $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
      }
      $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
    }
    unset($item);
    $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/undertime_approval_views', $data);
  }

  function undertime_list_request_approval(){
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
    $data['STATUS']                                    = $status;
    $data['STATUSES']                          = array('Pending', 'Approved', 'Rejected', 'Withdrawn');


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

    $data['DISP_SHIFT']                       = $attendance_shifts = $this->selfservices_model->GET_UNDERTIME_APPROVALS_LIST($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team, $status);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_UNDERTIME_APPROVALS_LIST_COUNT($user_id, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team, $status));

    // foreach ($attendance_shifts as $row_shift) {
    //   $shift_result = $this->teams_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
    //   if ($shift_result) {
    //     $row_shift->request_shift = $shift_result->name;
    //   }
    // }

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_leaves_assign');

    $data['DISP_DISTINCT_COMPANY']            = $this->selfservices_model->MOD_DISP_DISTINCT_COMPANY();
    $data['DISP_DISTINCT_BRANCH']             = $this->selfservices_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT']         = $this->selfservices_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']           = $this->selfservices_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_CLUBHOUSE']          = $this->selfservices_model->MOD_DISP_DISTINCT_CLUBHOUSE();
    $data['DISP_DISTINCT_SECTION']            = $this->selfservices_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']              = $this->selfservices_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']               = $this->selfservices_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']               = $this->selfservices_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_COMPANY']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']                 = $this->selfservices_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']             = $this->selfservices_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']               = $this->selfservices_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                  = $this->selfservices_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_line");
    $data['DATE_FORMAT']                      = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $employeeSearchRaw                  = $this->selfservices_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
    foreach ($employeeSearchRaw as &$item) {
      if (!empty($item->col_suffix)) {
        $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
      }
      $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
    }
    unset($item);
    $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/undertime_list_approval_views', $data);
  }

  function mychange_off_approval()
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

    $data['DISP_EMPLOYEES']                   = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $data['DISP_TYPES']                       = $this->selfservices_model->GET_ALL_LEAVETYPES();

    $data['DISP_SHIFT']                       = $attendance_shifts = $this->selfservices_model->GET_CHANGEOFF_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_CHANGESHIFT_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team));

    foreach ($attendance_shifts as $row_shift) {
      $shift_result = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
      $shift_result_to = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift_to);

      if ($shift_result) {
        $row_shift->request_shift = $shift_result->name;
      }

      if ($shift_result_to) {
        $row_shift->request_shift_to = $shift_result_to->name;
      }
    }

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_leaves_assign');

    $data['DISP_DISTINCT_COMPANY']            = $this->selfservices_model->MOD_DISP_DISTINCT_COMPANY();
    $data['DISP_DISTINCT_BRANCH']             = $this->selfservices_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT']         = $this->selfservices_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']           = $this->selfservices_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_CLUBHOUSE']          = $this->selfservices_model->MOD_DISP_DISTINCT_CLUBHOUSE();
    $data['DISP_DISTINCT_SECTION']            = $this->selfservices_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']              = $this->selfservices_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']               = $this->selfservices_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']               = $this->selfservices_model->MOD_DISP_DISTINCT_LINE();

    $data['DISP_VIEW_COMPANY']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']                 = $this->selfservices_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']             = $this->selfservices_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']               = $this->selfservices_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']                = $this->selfservices_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                  = $this->selfservices_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                   = $this->selfservices_model->GET_SYSTEM_SETTING("com_line");
    $data['DATE_FORMAT']                      = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $employeeSearchRaw                  = $this->selfservices_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
    foreach ($employeeSearchRaw as &$item) {
      if (!empty($item->col_suffix)) {
        $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
      }
      $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
    }
    unset($item);
    $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/change_off_approval_views', $data);
  }

  function nurseapproval($approve, $leave_id)
  {
    if ($approve == 'approve') {
      $this->selfservices_model->NURSE_APPROVELEAVE($leave_id);
      $this->session->set_flashdata('SUCC', 'Sick Leave request has been Approved!');
    } else {
      $this->selfservices_model->NURSE_REJECTLEAVE($leave_id);
      $this->session->set_flashdata('SUCC', 'Sick Leave request has been Rejected!');
    }
    redirect('selfservices/nurse_approval');
  }

  function changeshiftapproval($approve, $changeshift_id)
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');

    $approver_list        = array();
    $id                   = $changeshift_id;
    $offset_assign         = $this->selfservices_model->GET_CHNAGESHIFT_ASSIGN($id);
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);

    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $this->changeshift_action_approve($input_data = null, $approver_name, $offset_assign, $id);
    $this->session->set_flashdata('SUCC', 'Change shift request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function changeoffapproval($approve, $changeoff_id)
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver_list        = array();
    $id                   = $changeoff_id;
    $changeoff_request    = $this->selfservices_model->GET_CHNAGEOFF_ASSIGN($id);
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    $this->changeoff_action_approve($input_data = null, $approver_name, $changeoff_request, $id);
    $this->session->set_flashdata('SUCC', 'Change off request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function changeshiftapproval1($approve, $changeshift_id)
  {

    $data           = $this->selfservices_model->GET_CHANGESHIFT_DATA($changeshift_id);
    $numofapprovers = $this->selfservices_model->GET_APPROVERCOUNT($changeshift_id);

    $status     = $data->status;
    $approver1  = $data->approver1;
    $approver2  = $data->approver2;
    $approver3  = $data->approver3;
    $approver4  = $data->approver4;
    $approver5  = $data->approver5;
    $next_status = "";
    $approverdate = "";

    //------------------- APPROVED IF REACH MAX APPROVER AND NO NEXT ASSIGNED APPROVER --------------
    if ($status == "Pending 1" && ($numofapprovers == 1 || $approver2 == 0)) {
      $next_status = "Approved";
      $approverdate = 'approver1_date';
    }
    if ($status == "Pending 2" && ($numofapprovers == 2 || $approver3 == 0)) {
      $next_status = "Approved";
      $approverdate = 'approver2_date';
    }
    if ($status == "Pending 3" && ($numofapprovers == 3 || $approver4 == 0)) {
      $next_status = "Approved";
      $approverdate = 'approver3_date';
    }
    if ($status == "Pending 4" && ($numofapprovers == 4 || $approver5 == 0)) {
      $next_status = "Approved";
      $approverdate = 'approver4_date';
    }
    if ($status == "Pending 5") {
      $next_status = "Approved";
      $approverdate = 'approver5_date';
    }

    //------------------- APPROVED IF REACH MAX APPROVER AND NO NEXT ASSIGNED APPROVER --------------
    if ($status == "Pending 1" && $approver2 != 0) {
      $next_status = "Pending 2";
      $approverdate = 'approver1_date';
    }
    if ($status == "Pending 2" && $approver3 != 0) {
      $next_status = "Pending 3";
      $approverdate = 'approver2_date';
    }
    if ($status == "Pending 3" && $approver4 != 0) {
      $next_status = "Pending 4";
      $approverdate = 'approver3_date';
    }
    if ($status == "Pending 4" && $approver5 != 0) {
      $next_status = "Pending 5";
      $approverdate = 'approver4_date';
    }

    if ($approve == 'approve') {
      $this->selfservices_model->CHANGESHIFT_APPROVELEAVE($changeshift_id, $next_status, $approverdate);
      $this->session->set_flashdata('SUCC', 'Change Shift request has been Approved!');
    } else {
      $this->selfservices_model->CHANGESHIFT_APPROVELEAVE($changeshift_id, 'Rejected', $approverdate);
      $this->session->set_flashdata('SUCC', 'Change Shift request has been Rejected!');
    }

    $result = $this->selfservices_model->GET_CHANGED_SHIFT($changeshift_id);

    if ($result->status == "Approved") {
      $this->selfservices_model->UPDATE_CHANGESHIFT($result->empl_id, $result->date_shift, $result->request_shift);
    }

    redirect('selfservices/mychange_approval');
  }


  function changeoffapproval1($approve, $changeoff_id)
  {

    $data           = $this->selfservices_model->GET_CHANGEOFF_DATA($changeoff_id);
    $numofapprovers = $this->selfservices_model->GET_APPROVERCOUNT($changeoff_id);

    $status       = $data->status;
    $approver1    = $data->approver1;
    $approver1_b  = $data->approver1_b;
    $approver2    = $data->approver2;
    $approver2_b  = $data->approver2_b;
    $approver3    = $data->approver3;
    $approver3_b  = $data->approver3_b;
    $approver4    = $data->approver4;
    $approver4_b  = $data->approver4_b;
    $approver5    = $data->approver5;
    $approver5_b  = $data->approver5_b;
    $next_status  = "";
    $approverdate = "";

    //------------------- APPROVED IF REACH MAX APPROVER AND NO NEXT ASSIGNED APPROVER --------------
    if ($status == "Pending 1" && ($numofapprovers == 1 || ($approver2 == 0 && $approver2_b == 0))) {
      $next_status = "Approved";
      $approverdate = 'approver1_date';
    }
    if ($status == "Pending 2" && ($numofapprovers == 2 || ($approver3 == 0 && $approver3_b == 0))) {
      $next_status = "Approved";
      $approverdate = 'approver2_date';
    }
    if ($status == "Pending 3" && ($numofapprovers == 3 || ($approver4 == 0 && $approver4_b == 0))) {
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
    if ($status == "Pending 1" && ($approver2 != 0 || $approver2_b != 0)) {
      $next_status = "Pending 2";
      $approverdate = 'approver1_date';
    }
    if ($status == "Pending 2" && ($approver3 != 0 || $approver3_b != 0)) {
      $next_status = "Pending 3";
      $approverdate = 'approver2_date';
    }
    if ($status == "Pending 3" && ($approver4 != 0 || $approver4_b != 0)) {
      $next_status = "Pending 4";
      $approverdate = 'approver3_date';
    }
    if ($status == "Pending 4" && ($approver5 != 0 || $approver5_b != 0)) {
      $next_status = "Pending 5";
      $approverdate = 'approver4_date';
    }

    if ($approve == 'approve') {
      $this->selfservices_model->CHANGEOFF_APPROVAL($changeoff_id, $next_status, $approverdate);
      $this->session->set_flashdata('SUCC', 'Change Shift request has been Approved!');
    } else {
      $this->selfservices_model->CHANGEOFF_APPROVAL($changeoff_id, 'Rejected', $approverdate);
      $this->session->set_flashdata('SUCC', 'Change Shift request has been Rejected!');
    }

    $result = $this->selfservices_model->GET_CHANGED_OFF($changeoff_id);

    if ($result->status == "Approved") {

      $this->selfservices_model->UPDATE_CHANGESHIFT($result->empl_id, $result->date_shift, $result->request_shift);
      $this->selfservices_model->UPDATE_CHANGESHIFT($result->empl_id, $result->date_shift_to, $result->request_shift_to);
    }


    redirect('selfservices/mychange_off_approval');
  }



  function exemptutapproval($approve, $exemptut_id)
  {


    $data           = $this->selfservices_model->GET_EXEMPTUT_DATA($exemptut_id);
    $numofapprovers = $this->selfservices_model->GET_APPROVERCOUNT($exemptut_id);

    $status     = $data->status;
    $approver1  = $data->approver1;
    $approver2  = $data->approver2;
    $approver3  = $data->approver3;
    $approver4  = $data->approver4;
    $approver5  = $data->approver5;
    $next_status = "";
    $approverdate = "";

    //------------------- APPROVED IF REACH MAX APPROVER AND NO NEXT ASSIGNED APPROVER --------------
    if ($status == "Pending 1" && ($numofapprovers == 1 || $approver2 == 0)) {
      $next_status = "Approved";
      $approverdate = 'approver1_date';
    }
    if ($status == "Pending 2" && ($numofapprovers == 2 || $approver3 == 0)) {
      $next_status = "Approved";
      $approverdate = 'approver2_date';
    }
    if ($status == "Pending 3" && ($numofapprovers == 3 || $approver4 == 0)) {
      $next_status = "Approved";
      $approverdate = 'approver3_date';
    }
    if ($status == "Pending 4" && ($numofapprovers == 4 || $approver5 == 0)) {
      $next_status = "Approved";
      $approverdate = 'approver4_date';
    }
    if ($status == "Pending 5") {
      $next_status = "Approved";
      $approverdate = 'approver5_date';
    }

    //------------------- APPROVED IF REACH MAX APPROVER AND NO NEXT ASSIGNED APPROVER --------------
    if ($status == "Pending 1" && $approver2 != 0) {
      $next_status = "Pending 2";
      $approverdate = 'approver1_date';
    }
    if ($status == "Pending 2" && $approver3 != 0) {
      $next_status = "Pending 3";
      $approverdate = 'approver2_date';
    }
    if ($status == "Pending 3" && $approver4 != 0) {
      $next_status = "Pending 4";
      $approverdate = 'approver3_date';
    }
    if ($status == "Pending 4" && $approver5 != 0) {
      $next_status = "Pending 5";
      $approverdate = 'approver4_date';
    }

    if ($approve == 'approve') {
      $this->selfservices_model->EXEMPTUT_APPROVE($exemptut_id, $next_status, $approverdate);
    } else {
      $this->selfservices_model->EXEMPTUT_APPROVE($exemptut_id, 'Rejected', $approverdate);
    }

    redirect('selfservices/exemptut_approval');
  }

  function leave_approval()
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
    $data['DISP_SHIFT']                       = $this->selfservices_model->GET_LEAVE_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_LEAVE_APPROVALS_COUNT($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team));
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
    $this->load->view('modules/selfservices/leave_approval_views', $data);
  }

  function list_leave_approval()
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
    $data['STATUS']                                    = $status;
    $data['STATUSES']                          = array('Pending', 'Approved', 'Rejected', 'Withdrawn');
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
    $data['DISP_SHIFT']                       = $this->selfservices_model->GET_LEAVE_LIST_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team, $status);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_LEAVE_LIST_APPROVALS_COUNT($user_id, $company, $dept, $sec, $group, $line, $branch, $division, $team, $status));

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
    $this->load->view('modules/selfservices/list_leave_approval_views', $data);
  }

  function time_adjustment_approval()
  {
    $user_id                                  = $this->session->userdata('SESS_USER_ID');
    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $dept                                     = $this->input->get('dept');
    $sec                                      = $this->input->get('section');
    $group                                    = $this->input->get('group');
    $line                                     = $this->input->get('line');
    $branch                                   = $this->input->get('branch');
    $division                                 = $this->input->get('division');
    $team                                     = $this->input->get('team');
    $status                                   = $this->input->get('status');
    $company                                  = $this->input->get('company');

    $data["C_ROW_DISPLAY"]                    = [25, 50, 100];

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
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
    $data['DISP_TIME_ADJUSTMENT']             = $this->selfservices_model->GET_TIME_ADJUSTMENT_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_COUNT_TIME_ADJUSTMENT_APPROVALS($user_id, $company, $dept, $sec, $group, $line, $branch, $division, $team, $company));

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_attendance_adjustments');

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
    $data['DATE_FORMAT']                       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/time_adjustment_approval_views', $data);
  }

  private function insert_approved_time_adjustment($id)
  {

    $time_adj                                 = $this->selfservices_model->GET_APPROVED_TIME_ADJUSTMENT($id);
    $attendance_shift                         = $this->selfservices_model->GET_ATTENDANCE_SHIFT($time_adj->shift_type);
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

  function overtime_approval()
  {
    $user_id                                  = $this->session->userdata('SESS_USER_ID');
    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $company                                  = $this->input->get('company');
    $dept                                     = $this->input->get('dept');
    $sec                                      = $this->input->get('section');
    $group                                    = $this->input->get('group');
    $line                                     = $this->input->get('line');
    $branch                                   = $this->input->get('branch');
    $division                                 = $this->input->get('division');
    $team                                     = $this->input->get('team');
    $status                                   = $this->input->get('status');

    $data["C_ROW_DISPLAY"]                    = [25, 50, 100];

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
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
    $data['DISP_OVERTIME']                    = $this->selfservices_model->GET_OVERTIME_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_COUNT_OVERTIME_APPROVALS($user_id, $company, $dept, $sec, $group, $line, $branch, $division, $team));

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_overtimes');

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
    $this->load->view('modules/selfservices/overtime_approval_views', $data);
  }


  function overtime_approval_list()
  {
    $user_id                                  = $this->session->userdata('SESS_USER_ID');
    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $company                                  = $this->input->get('company');
    $dept                                     = $this->input->get('dept');
    $sec                                      = $this->input->get('section');
    $group                                    = $this->input->get('group');
    $line                                     = $this->input->get('line');
    $branch                                   = $this->input->get('branch');
    $division                                 = $this->input->get('division');
    $team                                     = $this->input->get('team');
    $status                                   = $this->input->get('status');

    $data["C_ROW_DISPLAY"]                    = [25, 50, 100];
    $data['STATUS']                                    = $status;
    $data['STATUSES']                          = array('Pending', 'Approved', 'Rejected', 'Withdrawn');

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
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
    $data['DISP_OVERTIME']                    = $this->selfservices_model->GET_OVERTIME_APPROVALS_LIST($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team, $status);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_OVERTIME_APPROVALS_LIST_COUNT($user_id, $company, $dept, $sec, $group, $line, $branch, $division, $team, $status));

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_overtimes');

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
    $this->load->view('modules/selfservices/overtime_approval_list_views', $data);
  }

  function holidaywork_approval()
  {
    $user_id                                  = $this->session->userdata('SESS_USER_ID');
    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $company                                  = $this->input->get('company');
    $dept                                     = $this->input->get('dept');
    $sec                                      = $this->input->get('section');
    $group                                    = $this->input->get('group');
    $line                                     = $this->input->get('line');
    $branch                                   = $this->input->get('branch');
    $division                                 = $this->input->get('division');
    $team                                     = $this->input->get('team');
    $status                                   = $this->input->get('status');
    $empl_id                                  = $this->input->get('employee');
    $data["C_ROW_DISPLAY"]                    = [25, 50, 100];
    $empl_id                                  = $empl_id == 'all' ? '' : $empl_id;
    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
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
    $data['DISP_HOLIDAYWORK']                 = $this->selfservices_model->GET_HOLIDAYWORK_APPROVALS($user_id, $empl_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_HOLIDAYWORK_APPROVALS_COUNT($user_id, $empl_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team));
    // $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_COUNT_HOLIDAYWORK_APPROVALS($user_id, $empl_id, $company, $dept, $sec, $group, $line, $branch, $division, $team));

    $data['FILTER']                           = $this->input->get('employee');
    $data['OPTIONS_EMPLOYEES']                = $this->selfservices_model->GET_EMPL_NAMES('tbl_overtimes');

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
    $this->load->view('modules/selfservices/holidaywork_approval_views', $data);
  }

  function get_specific_leave_request($id)
  {

    $leave_types                              = $this->selfservices_model->GET_ALL_LEAVETYPES();
    $empls                                    = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $leave_req                                = $this->selfservices_model->GET_SPECIFIC_LEAVE_REQUEST($id);

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

    $empls                                    = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $leave_req                                = $this->selfservices_model->GET_SPECIFIC_OVERTIME($id);

    foreach ($leave_req as $leave) {

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

    $empls                                    = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $holiday_req                              = $this->selfservices_model->GET_SPECIFIC_HOLIDAYWORK($id);

    foreach ($holiday_req as $leave) {

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

    $empls                                    = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $leave_req                                = $this->selfservices_model->GET_SPECIFIC_TIME_ADJ($id);

    foreach ($leave_req as $leave) {

      foreach ($empls as $empl) {
        if ($leave["empl_id"] == $empl->id) {
          $leave_req["empl_id"] = $empl->col_empl_cmid;
          $leave_req["name"] = $empl->col_last_name . ', ' . $empl->col_frst_name . ' ' . $empl->col_midl_name;
        }
      }
    }
    echo json_encode($leave_req);
  }


  function update_approve_exempt_undertime()
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $input_data           = $this->input->post();
    $approver_list        = array();
    $id                   = $input_data['id'];
    $request              = $this->selfservices_model->GET_EXEMPT_UNDERTIME_ASSIGN($id);
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    $this->exempt_undertime_action_approve($input_data, $approver_name, $request, $id);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved exempt undertime request');
    $this->session->set_flashdata('SUCC', 'Undertime request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  private function exempt_undertime_action_approve($input_data, $approver_name, $request, $id)
  {
    $approver_list        = array();
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver1);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver1_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver2);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver2_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver3);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver3_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver4);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver4_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver5);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver5_b);

    $token['type']          = 'undertime';
    $token['table']         = 'tbl_attendance_undertimerequest';
    $token['id']            = $request->id;
    $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));

    if ($request->status == 'Pending 1') {
      $status             = 'Pending 2';
      $description        = "Exempt Undertime Application Review for [EXU" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[2] && !$approver_list[3]) {
        $status             = 'Approved';
        $description = "Exempt Undertime Application Review for [EXU" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }

      $date_created       = date('Y-m-d H:i:s');
      $emp_id             = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_EXEMPT_UNDERTIME_ASSIGN($status, $emp_id, $date_created, $id);

      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $request->empl_id,
        'type' => 'exemptut',
        'content_id' => $id,
        'location' => 'selfservices/exemptut',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 2') {
        $token['approver']              = 'approver2';
        $token['approver_id']           = $request->approver2;
        $token['approver_date_col']     = 'approver2_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'exemptut';
        $notif_data['empl_id']      = $request->approver2;
        $notif_data['description']  = "Exempt Undertime Application Review for [EXU" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = "selfservices/exemptut";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    if ($request->status == 'Pending 2') {
      $status           = 'Pending 3';
      $description     = "Undertime Application Review for [EXU" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $date_created     = date('Y-m-d H:i:s');
      $emp_id           = $this->session->userdata('SESS_USER_ID');
      if (!$approver_list[4] && !$approver_list[5]) {
        $status             = 'Approved';
        $description = "Exempt Undertime Application Review for [EXU" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      $this->selfservices_model->UPDATE_EXEMPT_UNDERTIME_ASSIGN2($status, $emp_id, $date_created, $id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $request->empl_id,
        'type' => 'undertime',
        'content_id' => $id,
        'location' => 'selfservices/exemptut',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Pending 3') {
        $token['approver']          = 'approver3';
        $token['approver_id']       = $request->approver3;
        $token['approver_date_col']     = 'approver3_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve']      = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject']       = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'exemptut';
        $notif_data['empl_id']      = $request->approver3;
        $notif_data['description']  = "Exempt Undertime Application Review for [EXU" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = "selfservices/exemptut";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    // if ($request->status == 'Pending 3') {
    //   $status           = 'Pending 4';
    //   $description     = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   if (!$approver_list[6] && !$approver_list[7]) {
    //     $status             = 'Approved';
    //     $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
    //   $this->selfservices_model->UPDATE_OFFSET_ASSIGN3($status, $emp_id, $date_created, $id);
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   if ($status == 'Pending 4') {
    //     $token['approver']          = 'approver4';
    //     $token['approver_id']       = $request->approver4;
    //     $token['approver_date_col']     = 'approver4_date';
    //     $json_token                     =  json_encode($token);
    //     $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
    //     $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
    //     $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
    //     $notif_data['type']         = 'leave_approval';
    //     $notif_data['empl_id']      = $request->approver4;
    //     $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
    //     $notif_data['location']     = "selfservices/leave_approval";
    //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   }
    // }

    // if ($request->status == 'Pending 4') {
    //   $status           = 'Pending 5';
    //   $description     = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   if (!$approver_list[8] && !$approver_list[9]) {
    //     $status             = 'Approved';
    //     $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
    //   $this->selfservices_model->UPDATE_LEAVE_ASSIGN4($status, $emp_id, $date_created, $id);
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   if ($status == 'Pending 5') {
    //     $token['approver']          = 'approver5';
    //     $token['approver_id']       = $request->approver5;
    //     $token['approver_date_col']     = 'approver5_date';
    //     $json_token                     =  json_encode($token);
    //     $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
    //     $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
    //     $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
    //     $notif_data['type']         = 'leave_approval';
    //     $notif_data['empl_id']      = $request->approver5;
    //     $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
    //     $notif_data['location']     = "selfservices/leave_approval";
    //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   }
    // }
    // if ($request->status == 'Pending 5') {
    //   $status           = 'Approved';
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   $this->selfservices_model->UPDATE_LEAVE_ASSIGN5($status, $emp_id, $date_created, $id);
    //   $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    // }
  }

  function reject_exempt_undertime_assign()
  {
    $input_data           = $this->input->post();
    $id                   = $input_data['id'];
    $request              = $this->selfservices_model->GET_EXEMPT_UNDERTIME_ASSIGN($id);
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    if ($request->status == 'Pending 1') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');

      $this->selfservices_model->UPDATE_EXEMPT_UNDERTIME_ASSIGN($status, $emp_id, $date_created, $id, $input_data['remarks']);

      $description = "Exempt Undertime Application Review for [EXU" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['empl_id'],
        'type' => 'exemptut',
        'content_id' => $id,
        'location' => 'selfservices/exemptut',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($request->status == 'Pending 2') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_EXEMPT_UNDERTIME_ASSIGN2($status, $emp_id, $date_created, $id);
      $description    = "Exempt Undertime Application Review for [EXU" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['empl_id'],
        'type' => 'exemptut',
        'content_id' => $id,
        'location' => 'selfservices/exemptut',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    // if ($request->status == 'Pending 3') {
    //   $status         = 'Rejected';
    //   $date_created   = date('Y-m-d H:i:s');
    //   $emp_id         = $this->session->userdata('SESS_USER_ID');
    //   $this->selfservices_model->UPDATE_OFFSET_ASSIGN3($status, $emp_id, $date_created, $id);
    //   $description = "Offset Application Review for [OFS" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $input_data['empl_id'], 'type' => 'offset',
    //     'content_id' => $id, 'location' => 'selfservices/my_offsets', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    // }

    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected exempt undertime request');
    $this->session->set_flashdata('SUCC', 'Undertime request has been rejected!');

    redirect($this->input->server('HTTP_REFERER'));
  }



  function update_approve_undertime()
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $input_data           = $this->input->post();
    $approver_list        = array();
    $id                   = $input_data['id'];
    $request              = $this->selfservices_model->GET_UNDERTIME_ASSIGN($id);
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    $this->undertime_action_approve($input_data, $approver_name, $request, $id);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved undertime request');
    $this->session->set_flashdata('SUCC', 'Undertime request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  private function undertime_action_approve($input_data, $approver_name, $request, $id)
  {
    $approver_list        = array();
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver1);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver1_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver2);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver2_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver3);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver3_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver4);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver4_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver5);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver5_b);

    $token['type']          = 'undertime';
    $token['table']         = 'tbl_attendance_undertime';
    $token['id']            = $request->id;
    $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));

    if ($request->status == 'Pending 1') {
      $status             = 'Pending 2';
      $description        = "Undertime Application Review for [UND" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[2] && !$approver_list[3]) {
        $status             = 'Approved';
        $description = "Undertime Application Review for [UND" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }

      $date_created       = date('Y-m-d H:i:s');
      $emp_id             = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_UNDERTIME_ASSIGN($status, $emp_id, $date_created, $id);

      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $request->empl_id,
        'type' => 'undertime',
        'content_id' => $id,
        'location' => 'selfservices/my_undetime',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 2') {
        $token['approver']              = 'approver2';
        $token['approver_id']           = $request->approver2;
        $token['approver_date_col']     = 'approver2_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'undertime';
        $notif_data['empl_id']      = $request->approver2;
        $notif_data['description']  = "Undertime Application Review for [UND" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = "selfservices/my_undetime";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    if ($request->status == 'Pending 2') {
      $status           = 'Pending 3';
      $description     = "Undertime Application Review for [UND" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $date_created     = date('Y-m-d H:i:s');
      $emp_id           = $this->session->userdata('SESS_USER_ID');
      if (!$approver_list[4] && !$approver_list[5]) {
        $status             = 'Approved';
        $description = "Undertime Application Review for [UND" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      $this->selfservices_model->UPDATE_UNDERTIME_ASSIGN2($status, $emp_id, $date_created, $id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $request->empl_id,
        'type' => 'undertime',
        'content_id' => $id,
        'location' => 'selfservices/my_undetime',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Pending 3') {
        $token['approver']          = 'approver3';
        $token['approver_id']       = $request->approver3;
        $token['approver_date_col']     = 'approver3_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve']      = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject']       = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'undertime';
        $notif_data['empl_id']      = $request->approver3;
        $notif_data['description']  = "Undertime Application Review for [UND" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = "selfservices/my_undetime";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    // if ($request->status == 'Pending 3') {
    //   $status           = 'Pending 4';
    //   $description     = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   if (!$approver_list[6] && !$approver_list[7]) {
    //     $status             = 'Approved';
    //     $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
    //   $this->selfservices_model->UPDATE_OFFSET_ASSIGN3($status, $emp_id, $date_created, $id);
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   if ($status == 'Pending 4') {
    //     $token['approver']          = 'approver4';
    //     $token['approver_id']       = $request->approver4;
    //     $token['approver_date_col']     = 'approver4_date';
    //     $json_token                     =  json_encode($token);
    //     $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
    //     $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
    //     $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
    //     $notif_data['type']         = 'leave_approval';
    //     $notif_data['empl_id']      = $request->approver4;
    //     $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
    //     $notif_data['location']     = "selfservices/leave_approval";
    //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   }
    // }

    // if ($request->status == 'Pending 4') {
    //   $status           = 'Pending 5';
    //   $description     = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   if (!$approver_list[8] && !$approver_list[9]) {
    //     $status             = 'Approved';
    //     $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
    //   $this->selfservices_model->UPDATE_LEAVE_ASSIGN4($status, $emp_id, $date_created, $id);
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   if ($status == 'Pending 5') {
    //     $token['approver']          = 'approver5';
    //     $token['approver_id']       = $request->approver5;
    //     $token['approver_date_col']     = 'approver5_date';
    //     $json_token                     =  json_encode($token);
    //     $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
    //     $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
    //     $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
    //     $notif_data['type']         = 'leave_approval';
    //     $notif_data['empl_id']      = $request->approver5;
    //     $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
    //     $notif_data['location']     = "selfservices/leave_approval";
    //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   }
    // }
    // if ($request->status == 'Pending 5') {
    //   $status           = 'Approved';
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   $this->selfservices_model->UPDATE_LEAVE_ASSIGN5($status, $emp_id, $date_created, $id);
    //   $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    // }
  }

  function reject_undertime_assign()
  {
    $input_data           = $this->input->post();
    $id                   = $input_data['id'];
    $request              = $this->selfservices_model->GET_UNDERTIME_ASSIGN($id);
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    if ($request->status == 'Pending 1') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');

      $this->selfservices_model->UPDATE_UNDERTIME_ASSIGN($status, $emp_id, $date_created, $id, $input_data['remarks']);

      $description = "Undertime Application Review for [UND" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['empl_id'],
        'type' => 'undertime',
        'content_id' => $id,
        'location' => 'selfservices/my_undetime',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($request->status == 'Pending 2') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_UNDERTIME_ASSIGN2($status, $emp_id, $date_created, $id);
      $description    = "Undertime Application Review for [UND" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['empl_id'],
        'type' => 'undertime',
        'content_id' => $id,
        'location' => 'selfservices/my_undetime',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    // if ($request->status == 'Pending 3') {
    //   $status         = 'Rejected';
    //   $date_created   = date('Y-m-d H:i:s');
    //   $emp_id         = $this->session->userdata('SESS_USER_ID');
    //   $this->selfservices_model->UPDATE_OFFSET_ASSIGN3($status, $emp_id, $date_created, $id);
    //   $description = "Offset Application Review for [OFS" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $input_data['empl_id'], 'type' => 'offset',
    //     'content_id' => $id, 'location' => 'selfservices/my_offsets', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    // }

    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected undertime request');
    $this->session->set_flashdata('SUCC', 'Undertime request has been rejected!');

    redirect($this->input->server('HTTP_REFERER'));
  }



  function update_approve_changeoff()
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $input_data           = $this->input->post();
    $approver_list        = array();
    $id                   = $input_data['id'];
    $changeoff_request    = $this->selfservices_model->GET_CHNAGEOFF_ASSIGN($id);
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    $this->changeoff_action_approve($input_data, $approver_name, $changeoff_request, $id);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved change-off request');
    $this->session->set_flashdata('SUCC', 'Change off request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  private function changeoff_action_approve($input_data, $approver_name, $request, $id)
  {
    $approver_list        = array();
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver1);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver1_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver2);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver2_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver3);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver3_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver4);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver4_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver5);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver5_b);

    $token['type']          = 'changeoff_approval';
    $token['table']         = 'tbl_attendance_changeshift';
    $token['id']            = $request->id;
    $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));

    if ($request->status == 'Pending 1') {
      $status             = 'Pending 2';
      $description        = "Change off Application Review for [CHO" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[2] && !$approver_list[3]) {
        $status             = 'Approved';
        $description = "Change off Application Review for [CHO" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }

      $date_created       = date('Y-m-d H:i:s');
      $emp_id             = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_CHANGEOFF_ASSIGN($status, $emp_id, $date_created, $id);

      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $request->empl_id,
        'type' => 'changeoff_approval_status',
        'content_id' => $id,
        'location' => 'selfservices/mychange_off',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 2') {
        $token['approver']              = 'approver2';
        $token['approver_id']           = $request->approver2;
        $token['approver_date_col']     = 'approver2_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'changeoff_approval';
        $notif_data['empl_id']      = $request->approver2;
        $notif_data['description']  = "Change off Application Review for [CHO" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = "selfservices/mychange_off";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    if ($request->status == 'Pending 2') {
      $status           = 'Pending 3';
      $description     = "Change off Application Review for [CHO" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $date_created     = date('Y-m-d H:i:s');
      $emp_id           = $this->session->userdata('SESS_USER_ID');
      if (!$approver_list[4] && !$approver_list[5]) {
        $status             = 'Approved';
        $description = "Change off Application Review for [CHO" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      $this->selfservices_model->UPDATE_CHANGEOFF_ASSIGN2($status, $emp_id, $date_created, $id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $request->empl_id,
        'type' => 'changeoff_approval_status',
        'content_id' => $id,
        'location' => 'selfservices/mychange_off',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Pending 3') {
        $token['approver']          = 'approver3';
        $token['approver_id']       = $request->approver3;
        $token['approver_date_col']     = 'approver3_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve']      = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject']       = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'changeoff_approval';
        $notif_data['empl_id']      = $request->approver3;
        $notif_data['description']  = "Change off Application Review for [CHO" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = "selfservices/mychange_off";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    $changeoff_result = $this->selfservices_model->GET_CHANGED_OFF($id);

    if ($changeoff_result->status == "Approved") {

      $this->selfservices_model->UPDATE_CHANGESHIFT($changeoff_result->empl_id, $changeoff_result->date_shift, $changeoff_result->request_shift);
      $this->selfservices_model->UPDATE_CHANGESHIFT($changeoff_result->empl_id, $changeoff_result->date_shift_to, $changeoff_result->request_shift_to);
    }

    // if ($request->status == 'Pending 3') {
    //   $status           = 'Pending 4';
    //   $description     = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   if (!$approver_list[6] && !$approver_list[7]) {
    //     $status             = 'Approved';
    //     $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
    //   $this->selfservices_model->UPDATE_OFFSET_ASSIGN3($status, $emp_id, $date_created, $id);
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   if ($status == 'Pending 4') {
    //     $token['approver']          = 'approver4';
    //     $token['approver_id']       = $request->approver4;
    //     $token['approver_date_col']     = 'approver4_date';
    //     $json_token                     =  json_encode($token);
    //     $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
    //     $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
    //     $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
    //     $notif_data['type']         = 'leave_approval';
    //     $notif_data['empl_id']      = $request->approver4;
    //     $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
    //     $notif_data['location']     = "selfservices/leave_approval";
    //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   }
    // }

    // if ($request->status == 'Pending 4') {
    //   $status           = 'Pending 5';
    //   $description     = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   if (!$approver_list[8] && !$approver_list[9]) {
    //     $status             = 'Approved';
    //     $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
    //   $this->selfservices_model->UPDATE_LEAVE_ASSIGN4($status, $emp_id, $date_created, $id);
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   if ($status == 'Pending 5') {
    //     $token['approver']          = 'approver5';
    //     $token['approver_id']       = $request->approver5;
    //     $token['approver_date_col']     = 'approver5_date';
    //     $json_token                     =  json_encode($token);
    //     $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
    //     $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
    //     $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
    //     $notif_data['type']         = 'leave_approval';
    //     $notif_data['empl_id']      = $request->approver5;
    //     $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
    //     $notif_data['location']     = "selfservices/leave_approval";
    //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   }
    // }
    // if ($request->status == 'Pending 5') {
    //   $status           = 'Approved';
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   $this->selfservices_model->UPDATE_LEAVE_ASSIGN5($status, $emp_id, $date_created, $id);
    //   $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    // }
  }

  function reject_changeoff_assign()
  {
    $input_data           = $this->input->post();
    $id                   = $input_data['id'];
    $request              = $this->selfservices_model->GET_CHNAGEOFF_ASSIGN($id);
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    if ($request->status == 'Pending 1') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_CHANGEOFF_ASSIGN($status, $emp_id, $date_created, $id, $input_data['remarks']);
      $description = "Change off Application Review for [CHO" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['empl_id'],
        'type' => 'changeoff_approval',
        'content_id' => $id,
        'location' => 'selfservices/mychange_off',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($request->status == 'Pending 2') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_CHANGEOFF_ASSIGN2($status, $emp_id, $date_created, $id);
      $description    = "Change off Application Review for [CHO" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['empl_id'],
        'type' => 'changeoff_approval',
        'content_id' => $id,
        'location' => 'selfservices/mychange_off',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    // if ($request->status == 'Pending 3') {
    //   $status         = 'Rejected';
    //   $date_created   = date('Y-m-d H:i:s');
    //   $emp_id         = $this->session->userdata('SESS_USER_ID');
    //   $this->selfservices_model->UPDATE_OFFSET_ASSIGN3($status, $emp_id, $date_created, $id);
    //   $description = "Offset Application Review for [OFS" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $input_data['empl_id'], 'type' => 'offset',
    //     'content_id' => $id, 'location' => 'selfservices/my_offsets', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    // }

    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected change-off request');
    $this->session->set_flashdata('SUCC', 'Change off request has been rejected!');

    redirect($this->input->server('HTTP_REFERER'));
  }


  function update_approve_changeshift()
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $input_data           = $this->input->post();

    $approver_list        = array();
    $id                   = $input_data['id'];

    $offset_assign         = $this->selfservices_model->GET_CHNAGESHIFT_ASSIGN($id);
    // $offset_approvers      = $this->selfservices_model->GET_OFFSET_APPROVERS($input_data['empl_id']);
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    // $empl_approvers       = $this->selfservices_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');

    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $this->changeshift_action_approve($input_data, $approver_name, $offset_assign, $id);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved shift change request');
    $this->session->set_flashdata('SUCC', 'Change shift request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  private function changeshift_action_approve($input_data, $approver_name, $leave_assign, $id)
  {
    $approver_list        = array();
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver1);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver1_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver2);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver2_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver3);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver3_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver4);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver4_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver5);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver5_b);

    $token['type']          = 'changeshift_approval';
    $token['table']         = 'tbl_attendance_changeshift';
    $token['id']            = $leave_assign->id;
    $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));

    if ($leave_assign->status == 'Pending 1') {
      $status             = 'Pending 2';
      $description        = "Change shift Application Review for [CSH" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[2] && !$approver_list[3]) {
        $status             = 'Approved';
        $description = "Change shift Application Review for [CSH" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }

      $date_created       = date('Y-m-d H:i:s');
      $emp_id             = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_CHANGESHIFT_ASSIGN($status, $emp_id, $date_created, $id);

      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'changeshift_approval_status',
        'content_id' => $id,
        'location' => 'selfservices/mychange_shift',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 2') {
        $token['approver']              = 'approver2';
        $token['approver_id']           = $leave_assign->approver2;
        $token['approver_date_col']     = 'approver2_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'changeshift_approval';
        $notif_data['empl_id']      = $leave_assign->approver2;
        $notif_data['description']  = "Change shift Application Review for [CSH" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $leave_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/offset_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    if ($leave_assign->status == 'Pending 2') {
      $status           = 'Pending 3';
      $description     = "Change shift Application Review for [CSH" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $date_created     = date('Y-m-d H:i:s');
      $emp_id           = $this->session->userdata('SESS_USER_ID');
      if (!$approver_list[4] && !$approver_list[5]) {
        $status             = 'Approved';
        $description = "Change shift Application Review for [CSH" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      $this->selfservices_model->UPDATE_CHANGESHIFT_ASSIGN2($status, $emp_id, $date_created, $id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'changeshift_approval_status',
        'content_id' => $id,
        'location' => 'selfservices/mychange_shift',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Pending 3') {
        $token['approver']          = 'approver3';
        $token['approver_id']       = $leave_assign->approver3;
        $token['approver_date_col']     = 'approver3_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve']      = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject']       = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'changeshift_approval';
        $notif_data['empl_id']      = $leave_assign->approver3;
        $notif_data['description']  = "Leave Application Review for [CSH" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $leave_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/mychange_shift";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    $result = $this->selfservices_model->GET_CHANGED_SHIFT($id);

    if ($result->status == "Approved") {
      $this->selfservices_model->UPDATE_CHANGESHIFT($result->empl_id, $result->date_shift, $result->request_shift);
    }

    // if ($leave_assign->status == 'Pending 3') {
    //   $status           = 'Pending 4';
    //   $description     = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   if (!$approver_list[6] && !$approver_list[7]) {
    //     $status             = 'Approved';
    //     $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
    //   $this->selfservices_model->UPDATE_OFFSET_ASSIGN3($status, $emp_id, $date_created, $id);
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $leave_assign->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   if ($status == 'Pending 4') {
    //     $token['approver']          = 'approver4';
    //     $token['approver_id']       = $leave_assign->approver4;
    //     $token['approver_date_col']     = 'approver4_date';
    //     $json_token                     =  json_encode($token);
    //     $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
    //     $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
    //     $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
    //     $notif_data['type']         = 'leave_approval';
    //     $notif_data['empl_id']      = $leave_assign->approver4;
    //     $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $leave_assign->employee . " has been requested";
    //     $notif_data['location']     = "selfservices/leave_approval";
    //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   }
    // }

    // if ($leave_assign->status == 'Pending 4') {
    //   $status           = 'Pending 5';
    //   $description     = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   if (!$approver_list[8] && !$approver_list[9]) {
    //     $status             = 'Approved';
    //     $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
    //   $this->selfservices_model->UPDATE_LEAVE_ASSIGN4($status, $emp_id, $date_created, $id);
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $leave_assign->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   if ($status == 'Pending 5') {
    //     $token['approver']          = 'approver5';
    //     $token['approver_id']       = $leave_assign->approver5;
    //     $token['approver_date_col']     = 'approver5_date';
    //     $json_token                     =  json_encode($token);
    //     $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
    //     $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
    //     $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
    //     $notif_data['type']         = 'leave_approval';
    //     $notif_data['empl_id']      = $leave_assign->approver5;
    //     $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $leave_assign->employee . " has been requested";
    //     $notif_data['location']     = "selfservices/leave_approval";
    //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   }
    // }
    // if ($leave_assign->status == 'Pending 5') {
    //   $status           = 'Approved';
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   $this->selfservices_model->UPDATE_LEAVE_ASSIGN5($status, $emp_id, $date_created, $id);
    //   $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $leave_assign->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    // }
  }

  function reject_changeshift_assign()
  {
    $input_data           = $this->input->post();
    $id                   = $input_data['id'];
    $request              = $this->selfservices_model->GET_CHNAGESHIFT_ASSIGN($id);
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    if ($request->status == 'Pending 1') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_CHANGESHIFT_ASSIGN($status, $emp_id, $date_created, $id, $input_data['remarks']);
      $description = "Change shift Application Review for [CSH" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['empl_id'],
        'type' => 'changeshift_approval',
        'content_id' => $id,
        'location' => 'selfservices/mychange_shift',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($request->status == 'Pending 2') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_CHANGESHIFT_ASSIGN2($status, $emp_id, $date_created, $id);
      $description    = "Change shift Application Review for [CSH" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['empl_id'],
        'type' => 'changeshift_approval',
        'content_id' => $id,
        'location' => 'selfservices/mychange_shift',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    // if ($request->status == 'Pending 3') {
    //   $status         = 'Rejected';
    //   $date_created   = date('Y-m-d H:i:s');
    //   $emp_id         = $this->session->userdata('SESS_USER_ID');
    //   $this->selfservices_model->UPDATE_OFFSET_ASSIGN3($status, $emp_id, $date_created, $id);
    //   $description = "Change shift Application Review for [CSH" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $input_data['empl_id'], 'type' => 'changeshift_approval',
    //     'content_id' => $id, 'location' => 'selfservices/mychange_shift', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    // }


    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected shift change request');
    $this->session->set_flashdata('SUCC', 'Change shift request has been rejected!');

    redirect($this->input->server('HTTP_REFERER'));
  }



  function update_approve_offset_assign()
  {

    $user_id              = $this->session->userdata('SESS_USER_ID');
    $input_data           = $this->input->post();

    $approver_list        = array();
    $id                   = $input_data['id'];
    $offset_assign         = $this->selfservices_model->GET_OFFSET_ASSIGN($id);
    $offset_approvers      = $this->selfservices_model->GET_OFFSET_APPROVERS($input_data['empl_id']);

    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $empl_approvers       = $this->selfservices_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');

    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $this->offset_action_approve($input_data, $approver, $approver_name, $offset_assign, $offset_approvers, $id);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved offset request');
    $this->session->set_flashdata('SUCC', 'Offset request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  private function offset_action_approve($input_data, $approver, $approver_name, $leave_assign, $leave_approvers, $id)
  {
    $approver_list        = array();
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver1);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver1_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver2);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver2_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver3);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver3_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver4);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver4_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver5);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver5_b);

    $token['type']          = 'approval';
    $token['table']         = 'tbl_attendance_offsets';
    $token['id']            = $leave_assign->id;
    $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));

    if ($leave_assign->status == 'Pending 1') {
      $status             = 'Pending 2';
      $description        = "Offset Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[2] && !$approver_list[3]) {
        $status             = 'Approved';
        $description = "Offset Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }

      $date_created       = date('Y-m-d H:i:s');
      $emp_id             = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_OFFSET_ASSIGN($status, $emp_id, $date_created, $id);

      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'offset',
        'content_id' => $id,
        'location' => 'selfservices/my_offsets',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 2') {
        $token['approver']              = 'approver2';
        $token['approver_id']           = $leave_assign->approver2;
        $token['approver_date_col']     = 'approver2_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'offset';
        $notif_data['empl_id']      = $leave_assign->approver2;
        $notif_data['description']  = "Offset Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $leave_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/offset_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    if ($leave_assign->status == 'Pending 2') {
      $status           = 'Pending 3';
      $description     = "Offset Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $date_created     = date('Y-m-d H:i:s');
      $emp_id           = $this->session->userdata('SESS_USER_ID');
      if (!$approver_list[4] && !$approver_list[5]) {
        $status             = 'Approved';
        $description = "Offset Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      $this->selfservices_model->UPDATE_OFFSET_ASSIGN2($status, $emp_id, $date_created, $id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'offset',
        'content_id' => $id,
        'location' => 'selfservices/my_offsets',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Pending 3') {
        $token['approver']          = 'approver3';
        $token['approver_id']       = $leave_assign->approver3;
        $token['approver_date_col']     = 'approver3_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve']      = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject']       = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'offset_approval';
        $notif_data['empl_id']      = $leave_assign->approver3;
        $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $leave_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/offset_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    // if ($leave_assign->status == 'Pending 3') {
    //   $status           = 'Pending 4';
    //   $description     = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   if (!$approver_list[6] && !$approver_list[7]) {
    //     $status             = 'Approved';
    //     $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
    //   $this->selfservices_model->UPDATE_OFFSET_ASSIGN3($status, $emp_id, $date_created, $id);
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $leave_assign->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   if ($status == 'Pending 4') {
    //     $token['approver']          = 'approver4';
    //     $token['approver_id']       = $leave_assign->approver4;
    //     $token['approver_date_col']     = 'approver4_date';
    //     $json_token                     =  json_encode($token);
    //     $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
    //     $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
    //     $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
    //     $notif_data['type']         = 'leave_approval';
    //     $notif_data['empl_id']      = $leave_assign->approver4;
    //     $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $leave_assign->employee . " has been requested";
    //     $notif_data['location']     = "selfservices/leave_approval";
    //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   }
    // }

    // if ($leave_assign->status == 'Pending 4') {
    //   $status           = 'Pending 5';
    //   $description     = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   if (!$approver_list[8] && !$approver_list[9]) {
    //     $status             = 'Approved';
    //     $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
    //   $this->selfservices_model->UPDATE_LEAVE_ASSIGN4($status, $emp_id, $date_created, $id);
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $leave_assign->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   if ($status == 'Pending 5') {
    //     $token['approver']          = 'approver5';
    //     $token['approver_id']       = $leave_assign->approver5;
    //     $token['approver_date_col']     = 'approver5_date';
    //     $json_token                     =  json_encode($token);
    //     $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
    //     $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
    //     $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
    //     $notif_data['type']         = 'leave_approval';
    //     $notif_data['empl_id']      = $leave_assign->approver5;
    //     $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $leave_assign->employee . " has been requested";
    //     $notif_data['location']     = "selfservices/leave_approval";
    //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   }
    // }
    // if ($leave_assign->status == 'Pending 5') {
    //   $status           = 'Approved';
    //   $date_created     = date('Y-m-d H:i:s');
    //   $emp_id           = $this->session->userdata('SESS_USER_ID');
    //   $this->selfservices_model->UPDATE_LEAVE_ASSIGN5($status, $emp_id, $date_created, $id);
    //   $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $leave_assign->empl_id, 'type' => 'leave',
    //     'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    // }
  }

  function update_leave_assign()
  {

    $user_id              = $this->session->userdata('SESS_USER_ID');
    $input_data           = $this->input->post();

    $approver_list        = array();
    $id                   = $input_data['id'];
    $leave_assign         = $this->selfservices_model->GET_LEAVE_ASSIGN($id);
    $leave_approvers      = $this->selfservices_model->GET_LEAVE_APPROVERS($input_data['empl_id']);

    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $empl_approvers       = $this->selfservices_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver1);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver2);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver3);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver4);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver5);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $this->leave_action_approve($input_data, $approver, $approver_name, $leave_assign, $leave_approvers, $id);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved leave request');
    $this->session->set_flashdata('SUCC', 'Leave request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  private function leave_action_approve($input_data, $approver, $approver_name, $leave_assign, $leave_approvers, $id)
  {
    $approver_list        = array();
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver1);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver2);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver3);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver4);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver5);

    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_approvers->approver_1a);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_approvers->approver_1b);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_approvers->approver_2a);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_approvers->approver_2b);

    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_approvers->approver_3a);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_approvers->approver_3b);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_approvers->approver_4a);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_approvers->approver_4b);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_approvers->approver_5a);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_approvers->approver_5b);

    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver1);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver1_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver2);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver2_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver3);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver3_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver4);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver4_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver5);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($leave_assign->approver5_b);

    $token['type']          = 'approval';
    $token['table']         = 'tbl_leaves_assign';
    $token['id']            = $leave_assign->id;
    $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));

    if ($leave_assign->status == 'Pending 1') {
      $status             = 'Pending 2';
      $description        = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[2] && !$approver_list[3]) {
        $status             = 'Approved';
        $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }


      $date_created       = date('Y-m-d H:i:s');
      $emp_id             = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Pending 2') {
        $token['approver']              = 'approver2';
        $token['approver_id']           = $leave_assign->approver2;
        $token['approver_date_col']     = 'approver2_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'leave_approval';
        $notif_data['empl_id']      = $leave_assign->approver2;
        $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $leave_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/leave_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    if ($leave_assign->status == 'Pending 2') {
      $status           = 'Pending 3';
      $description     = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $date_created     = date('Y-m-d H:i:s');
      $emp_id           = $this->session->userdata('SESS_USER_ID');
      if (!$approver_list[4] && !$approver_list[5]) {
        $status             = 'Approved';
        $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Pending 3') {
        $token['approver']          = 'approver3';
        $token['approver_id']       = $leave_assign->approver3;
        $token['approver_date_col']     = 'approver3_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'leave_approval';
        $notif_data['empl_id']      = $leave_assign->approver3;
        $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $leave_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/leave_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    if ($leave_assign->status == 'Pending 3') {
      $status           = 'Pending 4';
      $description     = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $date_created     = date('Y-m-d H:i:s');
      $emp_id           = $this->session->userdata('SESS_USER_ID');
      if (!$approver_list[6] && !$approver_list[7]) {
        $status             = 'Approved';
        $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Pending 4') {
        $token['approver']          = 'approver4';
        $token['approver_id']       = $leave_assign->approver4;
        $token['approver_date_col']     = 'approver4_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'leave_approval';
        $notif_data['empl_id']      = $leave_assign->approver4;
        $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $leave_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/leave_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($leave_assign->status == 'Pending 4') {
      $status           = 'Pending 5';
      $description     = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $date_created     = date('Y-m-d H:i:s');
      $emp_id           = $this->session->userdata('SESS_USER_ID');
      if (!$approver_list[8] && !$approver_list[9]) {
        $status             = 'Approved';
        $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN4($status, $emp_id, $date_created, $id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Pending 5') {
        $token['approver']          = 'approver5';
        $token['approver_id']       = $leave_assign->approver5;
        $token['approver_date_col']     = 'approver5_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'leave_approval';
        $notif_data['empl_id']      = $leave_assign->approver5;
        $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $leave_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/leave_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($leave_assign->status == 'Pending 5') {
      $status           = 'Approved';
      $date_created     = date('Y-m-d H:i:s');
      $emp_id           = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN5($status, $emp_id, $date_created, $id);
      $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
  }

  private function  offset_action_reject($leave_assign, $id, $remarks = '')
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    if ($leave_assign->status == 'Pending 1') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_OFFSET_ASSIGN($status, $emp_id, $date_created, $id, $remarks);
      $description = "Offset Application Review for [OFS" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'offset',
        'content_id' => $id,
        'location' => 'selfservices/my_offsets',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($leave_assign->status == 'Pending 2') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id, $remarks);
      $description    = "Offset Application Review for [OFS" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'offset',
        'content_id' => $id,
        'location' => 'selfservices/my_offsets',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($leave_assign->status == 'Pending 3') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_OFFSET_ASSIGN3($status, $emp_id, $date_created, $id, $remarks);
      $description = "Offset Application Review for [OFS" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'offset',
        'content_id' => $id,
        'location' => 'selfservices/my_offsets',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
  }


  private function  leave_action_reject($leave_assign, $id, $remarks = '')
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    if ($leave_assign->status == 'Pending 1') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id, $remarks);
      $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($leave_assign->status == 'Pending 2') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id, $remarks);
      $description    = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($leave_assign->status == 'Pending 3') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id, $remarks);
      $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
    if ($leave_assign->status == 'Pending 4') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN4($status, $emp_id, $date_created, $id, $remarks);
      $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
    if ($leave_assign->status == 'Pending 5') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN5($status, $emp_id, $date_created, $id, $remarks);
      $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $leave_assign->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
  }

  private function  shift_request_reject($data, $id, $remarks = '')
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    if ($data->status == 'Pending 1') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_SHIFT_ASSIGN($status, $emp_id, $date_created, $id, $remarks);
      $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $data->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($data->status == 'Pending 2') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id, $remarks);
      $description    = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $data->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($data->status == 'Pending 3') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id, $remarks);
      $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $data->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
    if ($data->status == 'Pending 4') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN4($status, $emp_id, $date_created, $id, $remarks);
      $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $data->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
    if ($data->status == 'Pending 5') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_LEAVE_ASSIGN5($status, $emp_id, $date_created, $id, $remarks);
      $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $data->empl_id,
        'type' => 'leave',
        'content_id' => $id,
        'location' => 'selfservices/my_leaves',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
  }

  function leave_bulk_approve()
  {
    $empl_id              = $this->input->post('EMPLOYEE_ID');
    $id                   = $this->input->post('APPROVE_ID');
    $input_data = $this->input->post();
    $ids                  = explode(",", $id);
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    foreach ($ids as $id) {
      $leave_assign       = $this->selfservices_model->GET_LEAVE_ASSIGN($id);
      $approvers          = $this->selfservices_model->GET_USER_APPROVERS($leave_assign->empl_id, 'tbl_approvers');
      $this->leave_action_approve($input_data, $approver, $approver_name, $leave_assign, $id);
      $this->session->set_flashdata('SUCC', 'Leave request has been approved!');
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk approved leave requests');
    redirect($this->input->server('HTTP_REFERER'));
  }
  function update_offset_assign()
  {
    $user_id = $this->session->userdata('SESS_USER_ID');
    $input_data = $this->input->post();
    $id = $input_data['id'];
    $offset_assign = $this->selfservices_model->GET_OFFSET_ASSIGN($id);
    $approver = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    $status = '';
    $description = '';
    $notif_data = [
      'create_date' => date('Y-m-d H:i:s'),
      'empl_id' => $input_data['empl_id'],
      'type' => 'leave',
      'content_id' => $id,
      'location' => 'selfservices/my_offsets'
    ];

    if ($offset_assign->status == 'Pending 1') {
      $status = 'Pending 2';
      $description = "Offset Application Review for [OFS" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $notif_data['description'] = $description;
      $this->selfservices_model->UPDATE_OFFSET_ASSIGN($status, $user_id, date('Y-m-d H:i:s'), $id);
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);

      $notif_data['empl_id'] = $input_data['approver_2a'];
      $notif_data['description'] = "Offset Application Review for [OFS" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $input_data['employee'] . " has been requested";
      $notif_data['location'] = "selfservices/offset_approval";
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    } elseif ($offset_assign->status == 'Pending 2') {
      $status = 'Pending 3';
      $description = "Offset Application Review for [OFS" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $notif_data['description'] = $description;
      $this->selfservices_model->UPDATE_OFFSET_ASSIGN2($status, $user_id, date('Y-m-d H:i:s'), $id);

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);

      $notif_data['empl_id'] = $input_data['approver_3a'];
      $notif_data['description'] = "Offset Application Review for [OFS" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $input_data['employee'] . " has been requested";
      $notif_data['location'] = "selfservices/offset_approval";
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    } elseif ($offset_assign->status == 'Pending 3') {
      $status = 'Approved';
      $description = "Offset Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      $notif_data['description'] = $description;
      $this->selfservices_model->UPDATE_OFFSET_ASSIGN3($status, $user_id, date('Y-m-d H:i:s'), $id);

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved offset request');
    $this->session->set_flashdata('SUCC', 'Leave request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function reject_offset_assign()
  {
    $input_data           = $this->input->post();
    $id                   = $input_data['id'];
    $offset_assign        = $this->selfservices_model->GET_OFFSET_ASSIGN($id);
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    if ($offset_assign->status == 'Pending 1') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_OFFSET_ASSIGN($status, $emp_id, $date_created, $id, $input_data['remarks']);
      $description = "Offset Application Review for [OFS" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['empl_id'],
        'type' => 'offset',
        'content_id' => $id,
        'location' => 'selfservices/my_offsets',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($offset_assign->status == 'Pending 2') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_OFFSET_ASSIGN2($status, $emp_id, $date_created, $id);
      $description    = "Offset Application Review for [OFS" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['empl_id'],
        'type' => 'offset',
        'content_id' => $id,
        'location' => 'selfservices/my_offsets',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($offset_assign->status == 'Pending 3') {
      $status         = 'Rejected';
      $date_created   = date('Y-m-d H:i:s');
      $emp_id         = $this->session->userdata('SESS_USER_ID');
      $this->selfservices_model->UPDATE_OFFSET_ASSIGN3($status, $emp_id, $date_created, $id);
      $description = "Offset Application Review for [OFS" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['empl_id'],
        'type' => 'offset',
        'content_id' => $id,
        'location' => 'selfservices/my_offsets',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected offset request');
    $this->session->set_flashdata('SUCC', 'Offset request has been rejected!');

    redirect($this->input->server('HTTP_REFERER'));
  }

  function reject_offset_assign_2()
  {

    $input_data           = $this->input->post();
    // $id                   = $input_data['id'];
    // $offset_assign        = $this->selfservices_model->GET_OFFSET_ASSIGN($id);
    // $user_id              = $this->session->userdata('SESS_USER_ID');
    // $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    // $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    // $this->offset_action_reject($offset_assign, $id, $input_data['remarks']);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected offset request');
    $this->session->set_flashdata('SUCC', 'Offset request has been rejected!');

    redirect($this->input->server('HTTP_REFERER'));
  }

  function reject_leave_assign()
  {
    $input_data           = $this->input->post();
    // echo '<pre>';
    // var_dump($input_data);
    // return;
    $id                   = $input_data['id'];
    $leave_assign         = $this->selfservices_model->GET_LEAVE_ASSIGN($id);
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $this->leave_action_reject($leave_assign, $id, $input_data['remarks']);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected leave request');
    $this->session->set_flashdata('SUCC', 'Leave request has been rejected!');

    redirect($this->input->server('HTTP_REFERER'));
  }

  function reject_shift_request()
  {
    $input_data           = $this->input->post();
    // echo '<pre>';
    // var_dump($input_data); die();
    // return;
    $id                   = $input_data['id'];
    $leave_assign         = $this->selfservices_model->GET_SHIFT_REQUEST($id);
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $this->leave_action_reject($leave_assign, $id, $input_data['remarks']);
    $this->session->set_flashdata('SUCC', 'Shift request has been rejected!');

    redirect($this->input->server('HTTP_REFERER'));
  }

  function offset_bulk_reject()
  {
    $empl_id              = $this->input->post('REJECT_EMPLOYEE_ID');
    $id                   = $this->input->post('REJECTED_ID');
    $ids                  = explode(",", $id);

    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->formatName2($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    foreach ($ids as $id) {
      $offset       = $this->selfservices_model->GET_OFFSET_ASSIGN($id);
      $approvers          = $this->selfservices_model->GET_USER_APPROVERS($offset->empl_id, 'tbl_approvers');
      if ($offset->status == 'Pending 1') {
        $status       = 'Rejected';
        $date_created = date('Y-m-d H:i:s');
        $emp_id   = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id);
        $description = "Offset Application Review for [OFF" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
        $notif_data = array(
          'create_date' => date('Y-m-d H:i:s'),
          'empl_id' => $offset->empl_id,
          'type' => 'offset',
          'content_id' => $id,
          'location' => 'selfservices/my_offset',
          'description' => $description
        );
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }

      if ($offset->status == 'Pending 2') {
        $status       = 'Rejected';
        $date_created = date('Y-m-d H:i:s');
        $emp_id   = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id);
        $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
        $notif_data = array(
          'create_date' => date('Y-m-d H:i:s'),
          'empl_id' => $offset->empl_id,
          'type' => 'leave',
          'content_id' => $id,
          'location' => 'selfservices/my_leaves',
          'description' => $description
        );
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }

      if ($offset->status == 'Pending 3') {
        $status       = 'Rejected';
        $date_created = date('Y-m-d H:i:s');
        $emp_id   = $this->session->userdata('SESS_USER_ID');
        $this->selfservices_model->UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id);
        $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
        $notif_data = array(
          'create_date' => date('Y-m-d H:i:s'),
          'empl_id' => $offset->empl_id,
          'type' => 'leave',
          'content_id' => $id,
          'location' => 'selfservices/my_leaves',
          'description' => $description
        );
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk rejected offset requests');
    $this->session->set_flashdata('SUCC', 'Leave request has been rejected!');
    redirect($this->input->server('HTTP_REFERER'));
  }
  function leave_bulk_reject()
  {
    $empl_id              = $this->input->post('REJECT_EMPLOYEE_ID');
    $id                   = $this->input->post('REJECTED_ID');
    $ids                  = explode(",", $id);

    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    foreach ($ids as $id) {
      $leave_assign       = $this->selfservices_model->GET_LEAVE_ASSIGN($id);
      $approvers          = $this->selfservices_model->GET_USER_APPROVERS($leave_assign->empl_id, 'tbl_approvers');
      $this->leave_action_reject($leave_assign, $leave_assign->id, '');
      //   if ($leave_assign->status == 'Pending 1') {
      //     $status       = 'Rejected';
      //     $date_created = date('Y-m-d H:i:s');
      //     $emp_id   = $this->session->userdata('SESS_USER_ID');
      //     $this->selfservices_model->UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id);
      //     $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      //     $notif_data = array(
      //       'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $leave_assign->empl_id, 'type' => 'leave',
      //       'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
      //     );
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //   }

      //   if ($leave_assign->status == 'Pending 2') {
      //     $status       = 'Rejected';
      //     $date_created = date('Y-m-d H:i:s');
      //     $emp_id   = $this->session->userdata('SESS_USER_ID');
      //     $this->selfservices_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id);
      //     $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      //     $notif_data = array(
      //       'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $leave_assign->empl_id, 'type' => 'leave',
      //       'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
      //     );
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //   }

      //   if ($leave_assign->status == 'Pending 3') {
      //     $status       = 'Rejected';
      //     $date_created = date('Y-m-d H:i:s');
      //     $emp_id   = $this->session->userdata('SESS_USER_ID');
      //     $this->selfservices_model->UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id);
      //     $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      //     $notif_data = array(
      //       'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $leave_assign->empl_id, 'type' => 'leave',
      //       'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
      //     );
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //   }
    }

    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk rejected leave requests');
    $this->session->set_flashdata('SUCC', 'Leave request has been rejected!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function update_overtime_assign()
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $input_data           = $this->input->post();
    $id                   = $input_data['id'];
    $approver_list        = array();
    $overtime_assign      = $this->selfservices_model->GET_OVERTIME_ASSIGN($id);
    $overtime_approvers   = $this->selfservices_model->GET_OVERTIME_APPROVERS($input_data['empl_id']);

    $date_created         = date('Y-m-d H:i:s');
    $emp_id               = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $empl_approvers       = $this->selfservices_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    // $this->overtime_action_approve($overtime_assign);
    $this->overtime_action_approve($overtime_assign, $overtime_approvers);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved overtime request');

    $this->session->set_flashdata('SUCC', 'Overtime request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }
  private function overtime_action_approve($overtime_assign, $overtime_approvers)
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_list        = array();
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver1);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver2);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver3);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver4);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver5);

    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_approvers->approver_1a);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_approvers->approver_1b);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_approvers->approver_2a);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_approvers->approver_2b);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_approvers->approver_3a);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_approvers->approver_3b);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_approvers->approver_4a);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_approvers->approver_4b);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_approvers->approver_5a);
    // $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_approvers->approver_5b);

    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver1);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver1_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver2);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver2_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver3);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver3_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver4);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver4_b);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver5);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($overtime_assign->approver5_b);

    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $date_created         = date('Y-m-d H:i:s');
    $emp_id               = $this->session->userdata('SESS_USER_ID');
    $token['type']          = 'approval';
    $token['table']         = 'tbl_overtimes';
    $token['id']            = $overtime_assign->id;
    $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));

    if ($overtime_assign->status == 'Pending 1') {
      $status         = 'Pending 2';
      $description    = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[2] && !$approver_list[3]) {
        $status = 'Approved';
        $description = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      //   if ($empl_approvers->approver_2a == 0 && $empl_approvers->approver_3a == 0) {
      //     $status = 'Approved';
      //     $description = "Overtime Application Review for [OVT" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      //   }
      $this->selfservices_model->UPDATE_OVERTIME_ASSIGN($status, $emp_id, $date_created, $overtime_assign->id);

      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $overtime_assign->empl_id,
        'type' => 'overtime',
        'content_id' => $overtime_assign->id,
        'location' => 'selfservices/my_overtimes',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Pending 2') {
        $token['approver']          = 'approver2';
        $token['approver_id']       = $overtime_assign->approver2;
        $token['approver_date_col']     = 'approver2_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'overtime_approval';
        $notif_data['empl_id']      = $overtime_assign->approver2;
        $notif_data['description']  = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] by " . $overtime_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/overtime_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($overtime_assign->status == 'Pending 2') {
      $status       = 'Pending 3';
      $description = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[4] && !$approver_list[5]) {
        $status = 'Approved';
        $description = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      //   if ($empl_approvers->approver_3a == 0) {
      //     $status = 'Approved';
      //     $description = "Overtime Application Review for [OVT" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      //   }
      $this->selfservices_model->UPDATE_OVERTIME_ASSIGN2($status, $emp_id, $date_created, $overtime_assign->id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $overtime_assign->empl_id,
        'type' => 'overtime',
        'content_id' => $overtime_assign->id,
        'location' => 'selfservices/my_overtimes',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 3') {
        $token['approver']          = 'approver3';
        $token['approver_id']       = $overtime_assign->approver3;
        $token['approver_date_col']     = 'approver3_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'overtime_approval';
        $notif_data['empl_id']      = $overtime_assign->approver3;
        $notif_data['description']  = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] by " . $overtime_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/overtime_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($overtime_assign->status == 'Pending 3') {
      $status       = 'Pending 4';
      $description = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[6] && !$approver_list[7]) {
        $status = 'Approved';
        $description = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      //   if ($empl_approvers->approver_3a == 0) {
      //     $status = 'Approved';
      //     $description = "Overtime Application Review for [OVT" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      //   }
      $this->selfservices_model->UPDATE_OVERTIME_ASSIGN3($status, $emp_id, $date_created, $overtime_assign->id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $overtime_assign->empl_id,
        'type' => 'overtime',
        'content_id' => $overtime_assign->id,
        'location' => 'selfservices/my_overtimes',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 4') {
        $token['approver']          = 'approver4';
        $token['approver_id']       = $overtime_assign->approver4;
        $token['approver_date_col']     = 'approver4_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'overtime_approval';
        $notif_data['empl_id']      = $overtime_assign->approver4;
        $notif_data['description']  = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] by " . $overtime_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/overtime_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($overtime_assign->status == 'Pending 4') {
      $status       = 'Pending 5';
      $description = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[8] && !$approver_list[9]) {
        $status = 'Approved';
        $description = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      //   if ($empl_approvers->approver_3a == 0) {
      //     $status = 'Approved';
      //     $description = "Overtime Application Review for [OVT" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      //   }
      $this->selfservices_model->UPDATE_OVERTIME_ASSIGN4($status, $emp_id, $date_created, $overtime_assign->id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $overtime_assign->empl_id,
        'type' => 'overtime',
        'content_id' => $overtime_assign->id,
        'location' => 'selfservices/my_overtimes',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 5') {
        $token['approver']          = 'approver5';
        $token['approver_id']       = $overtime_assign->approver5;
        $token['approver_date_col']     = 'approver5_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'overtime_approval';
        $notif_data['empl_id']      = $overtime_assign->approver5;
        $notif_data['description']  = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] by " . $overtime_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/overtime_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    if ($overtime_assign->status == 'Pending 5') {
      $status       = 'Approved';
      $this->selfservices_model->UPDATE_OVERTIME_ASSIGN5($status, $emp_id, $date_created, $overtime_assign->id);
      $description = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $overtime_assign->empl_id,
        'type' => 'overtime',
        'content_id' => $overtime_assign->id,
        'location' => 'selfservices/my_overtimes',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
  }
  private function  overtime_action_reject($overtime_assign, $remarks = '')
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $date_created         = date('Y-m-d H:i:s');
    $emp_id               = $this->session->userdata('SESS_USER_ID');
    $status               = 'Rejected';
    $description = "Overtime Application Review for [OVT" . str_pad($overtime_assign->id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
    $notif_data = array(
      'create_date' => date('Y-m-d H:i:s'),
      'empl_id' => $overtime_assign->empl_id,
      'type' => 'overtime',
      'content_id' => $overtime_assign->id,
      'location' => 'selfservices/my_overtimes',
      'description' => $description
    );
    if ($overtime_assign->status == 'Pending 1') {
      $this->selfservices_model->UPDATE_OVERTIME_ASSIGN($status, $emp_id, $date_created, $overtime_assign->id, $remarks);
    }

    if ($overtime_assign->status == 'Pending 2') {
      $this->selfservices_model->UPDATE_OVERTIME_ASSIGN2($status, $emp_id, $date_created, $overtime_assign->id, $remarks);
    }

    if ($overtime_assign->status == 'Pending 3') {
      $this->selfservices_model->UPDATE_OVERTIME_ASSIGN3($status, $emp_id, $date_created, $overtime_assign->id, $remarks);
    }
    if ($overtime_assign->status == 'Pending 4') {
      $this->selfservices_model->UPDATE_OVERTIME_ASSIGN4($status, $emp_id, $date_created, $overtime_assign->id, $remarks);
    }
    if ($overtime_assign->status == 'Pending 5') {
      $this->selfservices_model->UPDATE_OVERTIME_ASSIGN5($status, $emp_id, $date_created, $overtime_assign->id, $remarks);
    }
    $this->selfservices_model->ADD_NOTIFICATION($notif_data);
  }
  function overtime_bulk_approve()
  {
    $id                 = $this->input->post('APPROVE_ID');
    $ids                = explode(",", $id);

    $user_id            = $this->session->userdata('SESS_USER_ID');
    $approver           = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name      = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    foreach ($ids as $id) {
      $overtime_assign    = $this->selfservices_model->GET_OVERTIME_ASSIGN($id);
      $approvers          = $this->selfservices_model->GET_USER_APPROVERS($overtime_assign->empl_id, 'tbl_approvers');
      $this->overtime_action_approve($overtime_assign);
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk approved overtime requests');
    $this->session->set_flashdata('SUCC', 'Overtime request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function reject_overtime_assign()
  {

    $input_data           = $this->input->post();
    // echo '<pre>';
    // var_dump($input_data);
    // return;
    $id                   = $input_data['id'];
    $overtime_assign      = $this->selfservices_model->GET_OVERTIME_ASSIGN($id);

    $date_created       = date('Y-m-d H:i:s');
    $emp_id             = $this->session->userdata('SESS_USER_ID');
    $status             = 'Rejected';

    $user_id            = $this->session->userdata('SESS_USER_ID');
    $approver           = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name      = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    $remarks            = $input_data['remarks'];
    $this->overtime_action_reject($overtime_assign, $remarks);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected overtime request');
    $this->session->set_flashdata('SUCC', 'Overtime request has been rejected!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function overtime_bulk_reject()
  {

    $id                 = $this->input->post('REJECTED_ID');
    $ids                = explode(",", $id);
    $status             = 'Rejected';
    $user_id            = $this->session->userdata('SESS_USER_ID');
    $approver           = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name      = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    foreach ($ids as $id) {
      $overtime_assign  = $this->selfservices_model->GET_OVERTIME_ASSIGN($id);
      $this->overtime_action_reject($overtime_assign);
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk rejected overtime requests');
    $this->session->set_flashdata('SUCC', 'Overtime request has been rejected!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function update_holidaywork_assign()
  {

    $input_data           = $this->input->post();
    $id                   = $input_data['id'];
    $holiday_work_assign  = $this->selfservices_model->GET_HOLIDAYWORK_ASSIGN($id);
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $empl_approvers       = $this->selfservices_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    $this->holidaywork_action_approve($holiday_work_assign);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved holiday work request');
    $this->session->set_flashdata('SUCC', 'Holiday work request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }
  private function holidaywork_action_approve($holiday_work_assign)
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_list        = array();
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($holiday_work_assign->approver1);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($holiday_work_assign->approver2);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($holiday_work_assign->approver3);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($holiday_work_assign->approver4);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($holiday_work_assign->approver5);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $date_created         = date('Y-m-d H:i:s');
    $emp_id               = $this->session->userdata('SESS_USER_ID');
    $token['type']          = 'approval';
    $token['table']         = 'tbl_holidaywork';
    $token['id']            = $holiday_work_assign->id;
    $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));

    if ($holiday_work_assign->status == 'Pending 1') {
      $status         = 'Pending 2';
      $description    = "Holiday Work Application Review for [HDW" . str_pad($holiday_work_assign->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[1]) {
        $status = 'Approved';
        $description = "Holiday Work Application Review for [HDW" . str_pad($holiday_work_assign->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      //   if ($empl_approvers->approver_2a == 0 && $empl_approvers->approver_3a == 0) {
      //     $status = 'Approved';
      //     $description = "Overtime Application Review for [OVT" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      //   }
      $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN($status, $emp_id, $date_created, $holiday_work_assign->id);

      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $holiday_work_assign->empl_id,
        'type' => 'holiday_work',
        'content_id' => $holiday_work_assign->id,
        'location' => 'selfservices/my_holiday_work',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Pending 2') {
        $token['approver']          = 'approver2';
        $token['approver_id']       = $holiday_work_assign->approver2;
        $token['approver_date_col']     = 'approver2_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);

        $notif_data['type']         = 'holiday_work_approval';
        $notif_data['empl_id']      = $holiday_work_assign->approver2;
        $notif_data['description']  = "Holiday Work Application Review for [HDW" . str_pad($holiday_work_assign->id, 5, '0', STR_PAD_LEFT) . "] by " . $holiday_work_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/holidaywork_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($holiday_work_assign->status == 'Pending 2') {
      $status       = 'Pending 3';
      $description = "Holiday Work Application Review for [HDW" . str_pad($holiday_work_assign->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[1]) {
        $status = 'Approved';
        $description = "Holiday Work Application Review for [HDW" . str_pad($holiday_work_assign->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      //   if ($empl_approvers->approver_3a == 0) {
      //     $status = 'Approved';
      //     $description = "Overtime Application Review for [OVT" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      //   }
      $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN2($status, $emp_id, $date_created, $holiday_work_assign->id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $holiday_work_assign->empl_id,
        'type' => 'holiday_work',
        'content_id' => $holiday_work_assign->id,
        'location' => 'selfservices/my_holiday_work',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 3') {
        $token['approver']          = 'approver3';
        $token['approver_id']       = $holiday_work_assign->approver3;
        $token['approver_date_col']     = 'approver3_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);

        $notif_data['type']         = 'holiday_work_approval';
        $notif_data['empl_id']      = $holiday_work_assign->approver3;
        $notif_data['description']  = "Holiday Work Application Review for [HDW" . str_pad($holiday_work_assign->id, 5, '0', STR_PAD_LEFT) . "] by " . $holiday_work_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/holidaywork_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($holiday_work_assign->status == 'Pending 3') {
      $status       = 'Pending 4';
      $description = "Holiday Work Application Review for [HDW" . str_pad($holiday_work_assign->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[3]) {
        $status = 'Approved';
        $description = "Holiday Work Application Review for [HDW" . str_pad($holiday_work_assign->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      //   if ($empl_approvers->approver_3a == 0) {
      //     $status = 'Approved';
      //     $description = "Overtime Application Review for [OVT" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      //   }
      $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN3($status, $emp_id, $date_created, $holiday_work_assign->id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $holiday_work_assign->empl_id,
        'type' => 'holiday_work',
        'content_id' => $holiday_work_assign->id,
        'location' => 'selfservices/my_holiday_work',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 4') {
        $token['approver']          = 'approver4';
        $token['approver_id']       = $holiday_work_assign->approver4;
        $token['approver_date_col']     = 'approver4_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);

        $notif_data['type']         = 'holiday_work_approval';
        $notif_data['empl_id']      = $holiday_work_assign->approver4;
        $notif_data['description']  = "Holiday Work Application Review for [HDW" . str_pad($holiday_work_assign->id, 5, '0', STR_PAD_LEFT) . "] by " . $holiday_work_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/holidaywork_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($holiday_work_assign->status == 'Pending 4') {
      $status       = 'Pending 5';
      $description = "Holiday Work Application Review for [HDW" . str_pad($holiday_work_assign->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      if (!$approver_list[4]) {
        $status = 'Approved';
        $description = "Holiday Work Application Review for [HDW" . str_pad($holiday_work_assign->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      //   if ($empl_approvers->approver_3a == 0) {
      //     $status = 'Approved';
      //     $description = "Overtime Application Review for [OVT" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      //   }
      $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN4($status, $emp_id, $date_created, $holiday_work_assign->id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $holiday_work_assign->empl_id,
        'type' => 'holiday_work',
        'content_id' => $holiday_work_assign->id,
        'location' => 'selfservices/my_holiday_work',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 5') {
        $token['approver']          = 'approver5';
        $token['approver_id']       = $holiday_work_assign->approver5;
        $token['approver_date_col']     = 'approver5_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'holiday_work_approval';
        $notif_data['empl_id']      = $holiday_work_assign->approver5;
        $notif_data['description']  = "Holiday Work Application Review for [HDW" . str_pad($holiday_work_assign->id, 5, '0', STR_PAD_LEFT) . "] by " . $holiday_work_assign->employee . " has been requested";
        $notif_data['location']     = "selfservices/holidaywork_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    if ($holiday_work_assign->status == 'Pending 5') {
      $status       = 'Approved';
      $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN5($status, $emp_id, $date_created, $holiday_work_assign->id);
      $description = "Holiday Work Application Review for [HDW" . str_pad($holiday_work_assign->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $holiday_work_assign->empl_id,
        'type' => 'holiday_work',
        'content_id' => $holiday_work_assign->id,
        'location' => 'selfservices/my_holiday_work',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
  }
  private function holidaywork_action_reject($request_assign, $remarks = '')
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $date_created         = date('Y-m-d H:i:s');
    $emp_id               = $this->session->userdata('SESS_USER_ID');
    $status               = 'Rejected';
    $description = "Holiday Work Application Review for [HDW" . str_pad($request_assign->id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
    $notif_data = array(
      'create_date' => date('Y-m-d H:i:s'),
      'empl_id' => $request_assign->empl_id,
      'type' => 'holiday_work',
      'content_id' => $request_assign->id,
      'location' => 'selfservices/my_holiday_work',
      'description' => $description
    );
    if ($request_assign->status == 'Pending 1') {
      $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN($status, $emp_id, $date_created, $request_assign->id, $remarks);
    }

    if ($request_assign->status == 'Pending 2') {
      $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN2($status, $emp_id, $date_created, $request_assign->id, $remarks);
    }

    if ($request_assign->status == 'Pending 3') {
      $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN3($status, $emp_id, $date_created, $request_assign->id, $remarks);
    }
    if ($request_assign->status == 'Pending 4') {
      $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN4($status, $emp_id, $date_created, $request_assign->id, $remarks);
    }
    if ($request_assign->status == 'Pending 5') {
      $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN5($status, $emp_id, $date_created, $request_assign->id, $remarks);
    }
    $this->selfservices_model->ADD_NOTIFICATION($notif_data);
  }
  function holidaywork_bulk_approve()
  {
    $id                 = $this->input->post('APPROVE_ID');
    $ids                = explode(",", $id);
    $user_id            = $this->session->userdata('SESS_USER_ID');
    $approver           = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name      = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    foreach ($ids as $id) {
      $holiday_work_assign  = $this->selfservices_model->GET_HOLIDAYWORK_ASSIGN($id);
      $this->holidaywork_action_approve($holiday_work_assign);
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk approved holiday work requests');
    $this->session->set_flashdata('SUCC', 'Holiday Work request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function reject_holidaywork_assign()
  {
    $input_data             = $this->input->post();
    $id                     = $input_data['id'];
    $holiday_work           = $this->selfservices_model->GET_HOLIDAYWORK_ASSIGN($id);
    $user_id                = $this->session->userdata('SESS_USER_ID');
    $approver               = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name          = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $this->holidaywork_action_reject($holiday_work, $input_data['remarks']);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected holiday work request');
    $this->session->set_flashdata('SUCC', 'Holiday work request has been rejected!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function holidaywork_bulk_reject()
  {
    $id                     = $this->input->post('REJECTED_ID');
    $ids                    = explode(",", $id);
    $user_id                = $this->session->userdata('SESS_USER_ID');
    $approver               = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name          = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);

    foreach ($ids as $id) {
      $holiday_work_assign  = $this->selfservices_model->GET_HOLIDAYWORK_ASSIGN($id);
      $this->holidaywork_action_reject($holiday_work_assign);
      //   $approvers            = $this->selfservices_model->GET_USER_APPROVERS($holiday_work_assign->empl_id, 'tbl_approvers');
      //   if ($holiday_work_assign->status == 'Pending 1') {
      //     $status       = 'Rejected';
      //     $date_created = date('Y-m-d H:i:s');
      //     $emp_id       = $this->session->userdata('SESS_USER_ID');
      //     $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN($status, $emp_id, $date_created, $id);
      //     $description = "Holiday Work Application Review for [MHW" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      //     $notif_data = array(
      //       'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $holiday_work_assign->empl_id, 'type' => 'holiday work',
      //       'content_id' => $id, 'location' => 'selfservices/my_holiday_work', 'description' => $description
      //     );
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //   }

      //   if ($holiday_work_assign->status == 'Pending 2') {
      //     $status       = 'Rejected';
      //     $date_created = date('Y-m-d H:i:s');
      //     $emp_id       = $this->session->userdata('SESS_USER_ID');
      //     $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN2($status, $emp_id, $date_created, $id);
      //     $description = "Holiday Work Application Review for [MHW" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      //     $notif_data = array(
      //       'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $holiday_work_assign->empl_id, 'type' => 'holiday work',
      //       'content_id' => $id, 'location' => 'selfservices/my_holiday_work', 'description' => $description
      //     );
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //   }

      //   if ($holiday_work_assign->status == 'Pending 3') {
      //     $status                  = 'Rejected';
      //     $date_created            = date('Y-m-d H:i:s');
      //     $emp_id                  = $this->session->userdata('SESS_USER_ID');
      //     $this->selfservices_model->UPDATE_HOLIDAYWORK_ASSIGN3($status, $emp_id, $date_created, $id);
      //     $description             = "Holiday Work Application Review for [MHW" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      //     $notif_data              = array(
      //       'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $holiday_work_assign->empl_id, 'type' => 'holiday work',
      //       'content_id' => $id, 'location' => 'selfservices/my_holiday_work', 'description' => $description
      //     );
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //   }
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk rejected holiday work requests');
    $this->session->set_flashdata('SUCC', 'Holiday Work request has been rejected!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function approve_time_adj_assign()
  {
    $input_data                 = $this->input->post();

    $id                         = $input_data['id'];
    $time_adjustment_assign     = $this->selfservices_model->GET_TIME_ADJUSTMENT_ASSIGN($id);
    $date_created               = date('Y-m-d H:i:s');
    $user_id                    = $this->session->userdata('SESS_USER_ID');
    $approver                   = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name              = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $empl_approvers       = $this->selfservices_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    // echo '<pre>';
    // var_dump($time_adjustment_assign);
    $this->time_adj_action_approved($time_adjustment_assign);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved time adjustment request');
    // if ($time_adjustment_assign->status == 'Pending 1') {
    //   $status                   = 'Pending 2';
    //   $description = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
    //   if ($empl_approvers->approver_2a == 0 && $empl_approvers->approver_3a == 0) {
    //     $status = 'Approved';
    //     $description = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
    //   $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN($status, $user_id, $date_created, $id);

    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $input_data['empl_id'], 'type' => 'time adjustment',
    //     'content_id' => $id, 'location' => 'selfservices/my_time_adjustments', 'description' => $description
    //   );
    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   if ($status == 'Approved') {
    //     $this->insert_approved_time_adjustment($id);
    //   }
    //   if ($status == 'Pending 2') {
    //     $notif_data['empl_id']      = $input_data['approver_2a'];
    //     $notif_data['description']  = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $input_data['employee'] . " has been requested";
    //     $notif_data['location']     = "selfservices/time_adjustment_approval";
    //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   }
    // }

    // if ($time_adjustment_assign->status == 'Pending 2') {
    //   $status                   = 'Pending 3';
    //   $description = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
    //   if ($empl_approvers->approver_3a == 0) {
    //     $status = 'Approved';
    //     $description = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
    //   $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN2($status, $user_id, $date_created, $id);
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $input_data['empl_id'], 'type' => 'time adjustment',
    //     'content_id' => $id, 'location' => 'selfservices/my_time_adjustments', 'description' => $description
    //   );

    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   if ($status == 'Approved') {
    //     $this->insert_approved_time_adjustment($id);
    //   }
    //   if ($status == 'Pending 3') {
    //     $notif_data['empl_id']      = $input_data['approver_3a'];
    //     $notif_data['description']  = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $input_data['employee'] . " has been requested";
    //     $notif_data['location']     = "selfservices/time_adjustment_approval";
    //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    //   }
    // }

    // if ($time_adjustment_assign->status == 'Pending 3') {
    //   $status                   = 'Approved';
    //   $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN3($status, $user_id, $date_created, $id);
    //   $this->insert_approved_time_adjustment($id);
    //   $description = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   $notif_data = array(
    //     'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $input_data['empl_id'], 'type' => 'time adjustment',
    //     'content_id' => $id, 'location' => 'selfservices/my_time_adjustments', 'description' => $description
    //   );
    //   $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    // }
    $this->session->set_flashdata('SUCC', 'Time Adjustment request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }
  private function time_adj_action_approved($request)
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_list        = array();
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver1);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver2);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver3);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver4);
    $approver_list[]      = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver5);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $date_created         = date('Y-m-d H:i:s');
    $emp_id               = $this->session->userdata('SESS_USER_ID');
    $token['type']          = 'approval';
    $token['table']         = 'tbl_attendance_adjustments';
    $token['id']            = $request->id;
    $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));
    // echo '<pre>';
    // return;
    if ($request->status == 'Pending 1') {
      $status                   = 'Pending 2';
      $description = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      //   if ($empl_approvers->approver_2a == 0 && $empl_approvers->approver_3a == 0) {
      // $status = 'Approved';
      // $description = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      //   }
      if (!$approver_list[1]) {
        $status = 'Approved';
        $description = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN($status, $user_id, $date_created, $request->id);

      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $request->empl_id,
        'type' => 'time_adjustment',
        'content_id' => $request->id,
        'location' => 'selfservices/my_time_adjustments',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Approved') {
        $this->insert_approved_time_adjustment($request->id);
      }
      if ($status == 'Pending 2') {
        $token['approver']              = 'approver2';
        $token['approver_id']           = $request->approver2;
        $token['approver_date_col']     = 'approver2_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'time_adjustment_approval';
        $notif_data['empl_id']      = $request->approver2;
        $notif_data['description']  = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = "selfservices/time_adjustment_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }

    if ($request->status == 'Pending 2') {
      $status                   = 'Pending 3';
      $description = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      //   if ($empl_approvers->approver_3a == 0) {
      //     $status = 'Approved';
      //     $description = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      //   }
      if (!$approver_list[2]) {
        $status = 'Approved';
        $description = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN2($status, $user_id, $date_created, $request->id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $request->empl_id,
        'type' => 'time_adjustment',
        'content_id' => $request->id,
        'location' => 'selfservices/my_time_adjustments',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Approved') {
        $this->insert_approved_time_adjustment($request->id);
      }
      if ($status == 'Pending 3') {
        $token['approver']              = 'approver3';
        $token['approver_id']           = $request->approver3;
        $token['approver_date_col']     = 'approver3_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'time_adjustment_approval';
        $notif_data['empl_id']      = $request->approver3;
        $notif_data['description']  = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = "selfservices/time_adjustment_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($request->status == 'Pending 3') {
      $status                   = 'Pending 4';
      $description = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      //   if ($empl_approvers->approver_3a == 0) {
      //     $status = 'Approved';
      //     $description = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      //   }
      if (!$approver_list[3]) {
        $status = 'Approved';
        $description = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN3($status, $user_id, $date_created, $request->id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $request->empl_id,
        'type' => 'time_adjustment',
        'content_id' => $request->id,
        'location' => 'selfservices/my_time_adjustments',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Approved') {
        $this->insert_approved_time_adjustment($request->id);
      }
      if ($status == 'Pending 4') {
        $token['approver']              = 'approver4';
        $token['approver_id']           = $request->approver4;
        $token['approver_date_col']     = 'approver4_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['type']         = 'time_adjustment_approval';
        $notif_data['empl_id']      = $request->approver4;
        $notif_data['description']  = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = "selfservices/time_adjustment_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($request->status == 'Pending 4') {
      $status                   = 'Pending 5';
      $description = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      //   if ($empl_approvers->approver_3a == 0) {
      //     $status = 'Approved';
      //     $description = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      //   }
      if (!$approver_list[4]) {
        $status = 'Approved';
        $description = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      }
      $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN4($status, $user_id, $date_created, $request->id);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $request->empl_id,
        'type' => 'time_adjustment',
        'content_id' => $request->id,
        'location' => 'selfservices/my_time_adjustments',
        'description' => $description
      );

      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Approved') {
        $this->insert_approved_time_adjustment($request->id);
      }
      if ($status == 'Pending 5') {
        $token['approver']              = 'approver5';
        $token['approver_id']           = $request->approver5;
        $token['approver_date_col']     = 'approver5_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
        $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
        $notif_data['empl_id']      = $request->approver5;
        $notif_data['type']         = 'time_adjustment_approval';
        $notif_data['description']  = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = "selfservices/time_adjustment_approval";
        $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($request->status == 'Pending 5') {
      $status                   = 'Approved';
      $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN5($status, $user_id, $date_created, $request->id);
      $this->insert_approved_time_adjustment($request->id);
      $description = "Time Adjustment Application Review for [TAD" . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $request->empl_id,
        'type' => 'time_adjustment',
        'content_id' => $request->id,
        'location' => 'selfservices/my_time_adjustments',
        'description' => $description
      );
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
  }
  private function time_adj_action_reject($request_assign, $remarks = '')
  {
    $user_id              = $this->session->userdata('SESS_USER_ID');
    $approver             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $date_created         = date('Y-m-d H:i:s');
    $emp_id               = $this->session->userdata('SESS_USER_ID');
    $status               = 'Rejected';
    $description = "Time Adjustment Application Review for [TAD" . str_pad($request_assign->id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
    $notif_data = array(
      'create_date' => date('Y-m-d H:i:s'),
      'empl_id' => $request_assign->empl_id,
      'type' => 'time_adjustment',
      'content_id' => $request_assign->id,
      'location' => 'selfservices/my_time_adjustments',
      'description' => $description
    );
    if ($request_assign->status == 'Pending 1') {
      $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN($status, $emp_id, $date_created, $request_assign->id, $remarks);
    }

    if ($request_assign->status == 'Pending 2') {
      $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN2($status, $emp_id, $date_created, $request_assign->id, $remarks);
    }

    if ($request_assign->status == 'Pending 3') {
      $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN3($status, $emp_id, $date_created, $request_assign->id, $remarks);
    }
    if ($request_assign->status == 'Pending 4') {
      $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN4($status, $emp_id, $date_created, $request_assign->id, $remarks);
    }
    if ($request_assign->status == 'Pending 5') {
      $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN5($status, $emp_id, $date_created, $request_assign->id, $remarks);
    }
    $this->selfservices_model->ADD_NOTIFICATION($notif_data);
  }
  function reject_time_adj_assign()
  {
    $input_data                 = $this->input->post();
    $id                         = $input_data['id'];
    $time_adjustment_assign     = $this->selfservices_model->GET_TIME_ADJUSTMENT_ASSIGN($id);
    $status                     = 'Rejected';
    $date_created               = date('Y-m-d H:i:s');
    $user_id                    = $this->session->userdata('SESS_USER_ID');
    $approver                   = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name              = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $this->time_adj_action_reject($time_adjustment_assign, $input_data['remarks']);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected time adjustment request');
    $this->session->set_flashdata('SUCC', 'Time Adjustment request has been rejected!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function time_adjustment_bulk_approve()
  {

    $id                       = $this->input->post('APPROVE_ID');
    $ids                      = explode(",", $id);
    $user_id                  = $this->session->userdata('SESS_USER_ID');
    $approver                 = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name            = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    foreach ($ids as $id) {
      $time_adjustment_assign = $this->selfservices_model->GET_TIME_ADJUSTMENT_ASSIGN($id);
      //   $approvers              = $this->selfservices_model->GET_USER_APPROVERS($time_adjustment_assign->empl_id, 'tbl_approvers');
      $this->time_adj_action_approved($time_adjustment_assign);
      //   if ($time_adjustment_assign->status == 'Pending 1') {
      //     $status               = 'Pending 2';
      //     $date_created         = date('Y-m-d H:i:s');
      //     $emp_id               = $this->session->userdata('SESS_USER_ID');
      //     $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN($status, $emp_id, $date_created, $id);
      //     $description = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      //     $notif_data = array(
      //       'create_date' => date('Y-m-d H:i:s'),
      //       'empl_id' => $time_adjustment_assign->empl_id, 'type' => 'time adjustment',
      //       'content_id' => $id, 'location' => 'selfservices/my_time_adjustments',
      //       'description' => $description
      //     );
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //     $notif_data['empl_id']      = $approvers->approver_2a;
      //     $notif_data['description']  = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $approvers->employee . " has been requested";
      //     $notif_data['location']     = "selfservices/time_adjustment_approval";
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //   }

      //   if ($time_adjustment_assign->status == 'Pending 2') {
      //     $status             = 'Pending 3';
      //     $date_created       = date('Y-m-d H:i:s');
      //     $emp_id             = $this->session->userdata('SESS_USER_ID');
      //     $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN2($status, $emp_id, $date_created, $id);
      //     $description = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      //     $notif_data = array(
      //       'create_date' => date('Y-m-d H:i:s'),
      //       'empl_id' => $time_adjustment_assign->empl_id, 'type' => 'time adjustment',
      //       'content_id' => $id, 'location' => 'selfservices/my_time_adjustments',
      //       'description' => $description
      //     );
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //     $notif_data['empl_id']      = $approvers->approver_3a;
      //     $notif_data['description']  = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $approvers->employee . " has been requested";
      //     $notif_data['location']     = "selfservices/time_adjustment_approval";
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //   }

      //   if ($time_adjustment_assign->status == 'Pending 3') {
      //     $status             = 'Approved';
      //     $date_created       = date('Y-m-d H:i:s');
      //     $emp_id             = $this->session->userdata('SESS_USER_ID');
      //     $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN3($status, $emp_id, $date_created, $id);
      //     $description = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      //     $notif_data = array(
      //       'create_date' => date('Y-m-d H:i:s'),
      //       'empl_id' => $time_adjustment_assign->empl_id, 'type' => 'time adjustments',
      //       'content_id' => $id, 'location' => 'selfservices/my_time_adjustment',
      //       'description' => $description
      //     );
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //     $this->insert_approved_time_adjustment($id);
      //   }
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk approved time adjustment requests');
    $this->session->set_flashdata('SUCC', 'Time Adjustment request has been approved!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function time_adjustment_bulk_reject()
  {
    $id                         = $this->input->post('REJECTED_ID');
    $ids                        = explode(",", $id);
    $user_id                    = $this->session->userdata('SESS_USER_ID');
    $approver                   = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name              = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    foreach ($ids as $id) {
      $time_adjustment_assign = $this->selfservices_model->GET_TIME_ADJUSTMENT_ASSIGN($id);
      $this->time_adj_action_reject($time_adjustment_assign);
      //   $approvers              = $this->selfservices_model->GET_USER_APPROVERS($time_adjustment_assign->empl_id, 'tbl_approvers');
      //   if ($time_adjustment_assign->status == 'Pending 1') {
      //     $status             = 'Rejected';
      //     $date_created       = date('Y-m-d H:i:s');
      //     $emp_id             = $this->session->userdata('SESS_USER_ID');
      //     $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN($status, $emp_id, $date_created, $id);
      //     $description = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      //     $notif_data = array(
      //       'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $time_adjustment_assign->empl_id, 'type' => 'time adjustment',
      //       'content_id' => $id, 'location' => 'selfservices/my_time_adjustments', 'description' => $description
      //     );
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //   }

      //   if ($time_adjustment_assign->status == 'Pending 2') {
      //     $status             = 'Rejected';
      //     $date_created       = date('Y-m-d H:i:s');
      //     $emp_id             = $this->session->userdata('SESS_USER_ID');
      //     $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN2($status, $emp_id, $date_created, $id);
      //     $description = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      //     $notif_data = array(
      //       'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $time_adjustment_assign->empl_id, 'type' => 'time adjustment',
      //       'content_id' => $id, 'location' => 'selfservices/my_time_adjustments', 'description' => $description
      //     );
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //   }

      //   if ($time_adjustment_assign->status == 'Pending 3') {
      //     $status             = 'Rejected';
      //     $date_created       = date('Y-m-d H:i:s');
      //     $emp_id             = $this->session->userdata('SESS_USER_ID');
      //     $this->selfservices_model->UPDATE_TIME_ADJ_ASSIGN3($status, $emp_id, $date_created, $id);
      //     $description = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
      //     $notif_data = array(
      //       'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $time_adjustment_assign->empl_id, 'type' => 'time adjustment',
      //       'content_id' => $id, 'location' => 'selfservices/my_time_adjustments', 'description' => $description
      //     );
      //     $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      //   }
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk rejected time adjustment requests');
    $this->session->set_flashdata('SUCC', 'Time Adjustment request has been rejected!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function my_tasks()
  {
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['user', 'employee_id', $user];
    $data["module_name"]      = $module       = 'selfservices';
    $data["page_name"]        = $page_name    = 'my_tasks';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_employee_tasks";
    $data["module"]           = [base_url() . $module, "Self Services", "My Tasks"];
    $data["id_prefix"]        = "TSK";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "my_tasks.xlsx"];
    $data["add_button"]       = [true, "Add My Tasks"];
    $data["status_text"]      = ["Open", "Closed", "", ""];
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab               = array(
      array("Open",   "status", "Open", 0),
      array("Closed", "status", "Closed", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      array(true, "btn_mark_open", "circle-check-solid_mark.svg", "Mark as Open", "status", "Open", "technos-button-green"),
      array(true, "btn_mark_closed", "circle-x-solid_mark_as.svg", "Mark as Closed", "status", "Closed", "btn-danger")
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("employee_id", "Employee", "user", "self", 0, 15, 1, 1, 1, 1, 0, 1),
        array("task_title", "TITLE", "text-row", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("task_description", "DESCRIPTION", "text-area", "0", 1, 0, 1, 0, 1, 1, 1, 1),
        array("task_date_from", "DATE FROM", "date", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("task_date_to", "DATE TO", "date", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("status", "STATUS", "fixed-sel-direct", "Open;Closed", 1, 15, 1, 1, 1, 1, 1, 1),
        array("attachment", "Attachment", "attachment", "0", 0, 0, 1, 0, 1, 1, 1, 1),
        array("remarks", "REMARKS", "text-area", "0", 1, 15, 1, 0, 1, 1, 1, 1),

      );

    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";
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
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data_2($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data_2($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
    }

    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                   = $c_data_tab;
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_tasks_views', $data);
  }
  function request_task()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/request_task_views');
  }
  function add_new_task()
  {
    $input_data                           = $this->input->post();
    // $attachment                           = $_FILES['attachment']['name'];
    // $file_info                            = pathinfo($attachment);
    $input_data['create_date']            = date('Y-m-d H:i:s');
    $input_data['edit_date']              = date('Y-m-d H:i:s');
    $employee                             = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
    // $input_data['attachment']             = $attachment;

    // if (!empty($attachment)) {
    //   $input_data['attachment']           = $employee->col_empl_cmid . '_' . $employee->col_last_name . '_task_request_' . date('Y-m-d') . '.' . $file_info['extension'];
    //   $config['upload_path']              = './assets_user/files/selfservices';
    //   $config['max_size']                 = 10000;
    //   $config['file_name']                = $employee->col_empl_cmid . '_' . $employee->col_last_name . '_task_request_' . date('Y-m-d');
    //   $config['overwrite']                = 'TRUE';
    //   $this->load->library('upload', $config);

    //   if (!$this->upload->do_upload('attachment')) {
    //     $error = array('error' => $this->upload->display_errors());
    //     $this->session->set_flashdata('ERR', $error['error']);
    //     redirect('selfservices/request_task');
    //     return;
    //   }
    // }
    $res = $this->selfservices_model->ADD_DATA('tbl_employee_tasks', $input_data);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added task');
      $this->session->set_flashdata('SUCC', 'Successfully added new request');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new request');
      redirect('selfservices/request_task');
      return;
    }
    redirect('selfservices/my_tasks');
  }
  function edit_task($id)
  {
    $data['TASK'] = $this->selfservices_model->GET_TASK($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    // echo '<pre>';
    // var_dump($data['TASK']);
    // return;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/edit_task_views', $data);
  }
  function view_task($id)
  {
    $data['TASK']                           = $this->selfservices_model->GET_TASK($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/view_task_views', $data);
  }
  function update_task($id)
  {
    $input_data = $this->input->post();
    if (!$input_data) {
      redirect('selfservices/edit_task/' . $id);
    }
    $input_data['edit_user'] = $this->session->userdata('SESS_USER_ID');
    $input_data['edit_date'] = date('Y-m-d H:i:s');
    //   echo '<pre>';
    //   var_dump($input_data);
    //   return;
    $res = $this->selfservices_model->UPDATE_TASK($input_data, $id);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated task');
      redirect('selfservices/my_tasks');
    }
  }
  function my_time_records()
  {
    $userId                                = $this->session->userdata('SESS_USER_ID');
    $data["C_ROW_DISPLAY"]                 =  [10, 25, 50, 100];

    $page                                  = $this->input->get('page');
    $row                                   = $this->input->get('row');
    $cutoff_param                          = $this->input->get('cutoff');
    $yearmonth                             = $this->input->get('yearmonth');

    if (isset($_GET['yearmonth_from'])) {
      $yearmonth_from                      = $_GET['yearmonth_from'];
    } else {
      $yearmonth_from                      = date('Y-m-01');
    }

    if (isset($_GET['yearmonth_to'])) {
      $yearmonth_to                        = $_GET['yearmonth_to'];
    } else {
      $yearmonth_to                        = date('Y-m-t');
    }

    if ($row == null) {
      $row = 10;
    }
    if ($page  == null) {
      $page = 1;
    }

    $offset = $row * ($page - 1);
    $data['CUT_OFFS']                      = $this->selfservices_model->GET_CUT_OFFS();
    $date = null;
    $data['DISP_INOUT_TYPE']               = $this->selfservices_model->GET_IN_OUT_TYPE();

    $firstDay                              = date('Y-m-d', strtotime($yearmonth_from));
    $lastDay                               = date('Y-m-d', strtotime($yearmonth_to));

    foreach ($data['CUT_OFFS'] as $cut_off) {

      if (!$cutoff_param) {
        $date['from']                      = $cut_off->date_from;
        $date['to']                        = $cut_off->date_to;
        $data['SELECTED_CUTOFF']           = $cut_off->id;
        break;
      }
      $cutoff_id = (int) $cut_off->id;

      if ($cutoff_id == $cutoff_param) {
        $date['from']                      = $cut_off->date_from;
        $date['to']                        = $cut_off->date_to;
        $data['SELECTED_CUTOFF']           = $cut_off->id;
        break;
      }
    }

    $SHF_ATTENDANCE_RECORDS                = $this->selfservices_model->GET_SPECIFIC_SHIFT_RECORD($userId, $firstDay, $lastDay);
    $REM_ATTENDANCE_RECORDS                = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE_RECORD($userId, $firstDay, $lastDay);
    $ZKT_ATTENDANCE_RECORDS                = $this->selfservices_model->GET_SPECIFIC_ZKTECO_RECORD($userId, $firstDay, $lastDay);
    $WORK_SHIFT_DATA                       = $this->selfservices_model->GET_WORK_SHIFT_DATA();
    $APPROVED_LEAVES                       = $this->selfservices_model->GET_APPROVED_LEAVES($userId, $firstDay, $lastDay);
    $LEAVE_TYPE_LIST                       = $this->selfservices_model->GET_LEAVE_NAMES();
    $APPROVED_OT_DATA                      = $this->selfservices_model->GET_APPROVED_OT($userId, $firstDay, $lastDay);
    $HOLIDAYS                              = $this->selfservices_model->GET_HOLIDAY();
    $SHIFT_ASSIGN_DATA                     = $this->selfservices_model->GET_SHIFT_ASSIGN_SPECIFIC($userId);
    $chk_lateundertime_deductiontype       = $this->selfservices_model->GET_LATEUNDERTIME_DEDUCTIONTYPE();
    $chk_graceperiod                       = $this->selfservices_model->GET_GRACEPERIOD();


    $data['C_DATA_COUNT']                  = $this->selfservices_model->GET_COUNT_ATTENDANCE_RECORD($userId);
    $data['C_SALARY_TYPE']  = $salary_type = $this->selfservices_model->GET_SALARY_TYPE($userId);

    $date1                                 = new DateTime($firstDay);
    $date2                                 = new DateTime($lastDay);


    $interval = DateInterval::createFromDateString('1 day');
    $period   = new DatePeriod($date1, $interval, $date2->modify('+1 day'));

    $data['PERIOD'] = $period;
    $data['DISP_ATTENDANCE'] = array();


    $zkteco_new_data = array();
    $index = 0;
    $ATTENDANCE_DATA = array();


    foreach ($period as $period_row) {

      $period_row_arr = (array) $period_row;
      $DATE_DATA = date("Y-m-d", strtotime($period_row_arr["date"]));


      $shift_name = "";
      $shift_time_in = "";
      $shift_time_out = "";
      $shift_break_start = "";
      $shift_break_end = "";
      $time_overtime_start = "";
      $time_overtime_end = "";
      $shift_regular_reg                = 0;
      $work_hours                       = 0;

      $tardiness                        = 0;
      $undertime                        = 0;
      $absent                           = 0;
      $leave_typename                   = '-';

      $reg_hrs                          = 0;
      $lwop                             = 0;
      $awol                             = 0;
      $paid_leave                       = 0;
      $leave_type                       = 0;
      $reg_ot                           = 0;
      $nd_ot                            = 0;
      $nd                               = 0;

      $totalWorkedHours                 = 0;
      $totalTardinessHours              = 0;
      $totalUnderTimeHours              = 0;
      $totalPaidHours                   = 0;
      $totalAbsencesHours               = 0;
      $totalLWOPHours                   = 0;

      $total_regot                      = 0;
      $total_nd                         = 0;
      $total_nd_ot                      = 0;

      foreach ($SHF_ATTENDANCE_RECORDS as $SHIFT_DATA) {
        if ($SHIFT_DATA["date"] == $DATE_DATA) {



          foreach ($WORK_SHIFT_DATA as $WORK_SHIFT) {
            if ($SHIFT_DATA["shift_id"] == $WORK_SHIFT->id) {
              $shift_name               = ($WORK_SHIFT->code == "00:00:00") ? "" : $WORK_SHIFT->code;
              $shift_time_in            = ($WORK_SHIFT->time_regular_start == "00:00:00") ? "" : $WORK_SHIFT->time_regular_start;
              $shift_time_out           = ($WORK_SHIFT->time_regular_end == "00:00:00") ? "" : $WORK_SHIFT->time_regular_end;
              $shift_break_start        = ($WORK_SHIFT->time_break_start == "00:00:00") ? "" : $WORK_SHIFT->time_break_start;
              $shift_break_end          = ($WORK_SHIFT->time_break_end == "00:00:00") ? "" : $WORK_SHIFT->time_break_end;
              $time_overtime_start      = ($WORK_SHIFT->time_overtime_start == "00:00:00") ? "" : $WORK_SHIFT->time_overtime_start;
              $time_overtime_end        = ($WORK_SHIFT->time_overtime_end == "00:00:00") ? "" : $WORK_SHIFT->time_overtime_end;
              $shift_regular_reg        = $WORK_SHIFT->time_regular_reg;
            }
          }
        }
      }

      $hol_code                         = "REGULAR";

      $raw_time_in = "";
      $raw_time_out = "";

      $time_in_array    = [];
      $time_out_array   = [];
      $break_in_array   = [];
      $break_out_array  = [];

      $zkteco_time_in = "";
      $zkteco_time_out = "";
      $zkteco_break_in = "";
      $zkteco_break_out = "";

      $remote_time_in = "";
      $remote_time_out = "";
      $remote_break_in = "";
      $remote_break_out = "";




      foreach ($ZKT_ATTENDANCE_RECORDS as $ZKT_ATTENDANCE_RECORD) {
        $attendance_date = date("Y-m-d", strtotime($ZKT_ATTENDANCE_RECORD['punch_time']));

        if ($attendance_date == $DATE_DATA) {
          if ($ZKT_ATTENDANCE_RECORD['punch_state'] == 0) {
            array_push($time_in_array, date("H:i", strtotime($ZKT_ATTENDANCE_RECORD['punch_time'])));
          } elseif ($ZKT_ATTENDANCE_RECORD['punch_state'] == 4) {
            array_push($break_in_array, date("H:i", strtotime($ZKT_ATTENDANCE_RECORD['punch_time'])));
          } elseif ($ZKT_ATTENDANCE_RECORD['punch_state'] == 5) {
            array_push($break_out_array, date("H:i", strtotime($ZKT_ATTENDANCE_RECORD['punch_time'])));
          } else {
            array_push($time_out_array, date("H:i", strtotime($ZKT_ATTENDANCE_RECORD['punch_time'])));
          }
        }
      }

      if ($time_in_array) {
        $oldest_in_time            = min(array_map('strtotime', $time_in_array));
        $zkteco_time_in            = date("H:i", $oldest_in_time);
      }

      if ($time_out_array) {
        $latest_time_out          = max(array_map('strtotime', $time_out_array));
        $zkteco_time_out           = date("H:i", $latest_time_out);
      }

      if ($break_in_array) {
        $oldest_in_time            = min(array_map('strtotime', $break_in_array));
        $zkteco_break_in            = date("H:i", $oldest_in_time);
      }

      if ($break_out_array) {
        $latest_time_out          = min(array_map('strtotime', $break_out_array));
        $zkteco_break_out           = date("H:i", $latest_time_out);
      }

      $snapshot_in = null;
      $snapshot_out = null;
      $time_in_address = null;
      $time_out_address = null;
      $break_in_snapshot = null;
      $break_in_address = null;
      $break_out_snapshot = null;
      $break_out_address = null;
      foreach ($REM_ATTENDANCE_RECORDS as $REM_ATTENDANCE_RECORD) {

        if ($REM_ATTENDANCE_RECORD['date'] == $DATE_DATA) {

          if (!is_null($REM_ATTENDANCE_RECORD['time_in'])) {
            $remote_time_in = date("H:i", strtotime($REM_ATTENDANCE_RECORD['time_in']));
          } else {
            $remote_time_in = "00:00";
          }

          if (!is_null($REM_ATTENDANCE_RECORD['time_out'])) {
            $remote_time_out = date("H:i", strtotime($REM_ATTENDANCE_RECORD['time_out']));
          } else {
            $remote_time_out = "00:00";
          }

          if (!is_null($REM_ATTENDANCE_RECORD['break_in'])) {
            $remote_break_in = date("H:i", strtotime($REM_ATTENDANCE_RECORD['break_in']));
          } else {
            $remote_break_in = "00:00";
          }

          if (!is_null($REM_ATTENDANCE_RECORD['break_out'])) {
            $remote_break_out = date("H:i", strtotime($REM_ATTENDANCE_RECORD['break_out']));
          } else {
            $remote_break_out = "00:00";
          }

          $snapshot_in           = $REM_ATTENDANCE_RECORD['snapshot_in'];
          $snapshot_out          = $REM_ATTENDANCE_RECORD['snapshot_out'];
          $time_in_address       = $REM_ATTENDANCE_RECORD['time_in_address'];
          $time_out_address      = $REM_ATTENDANCE_RECORD['time_out_address'];
          $break_in_address      = $REM_ATTENDANCE_RECORD['break_in_address'];
          $break_in_snapshot     = $REM_ATTENDANCE_RECORD['break_in_snapshot'];
          $break_out_address      = $REM_ATTENDANCE_RECORD['break_out_address'];
          $break_out_snapshot     = $REM_ATTENDANCE_RECORD['break_out_snapshot'];
        }
      }


      if ($zkteco_time_in != "" && $remote_time_in != "") {
        $raw_time_in = min($remote_time_in, $zkteco_time_in);
      } else if ($zkteco_time_in != "" && $remote_time_in == "") {
        $raw_time_in = $zkteco_time_in;
      } else {
        $raw_time_in = $remote_time_in;
      }

      if ($zkteco_time_out != "" && $remote_time_out != "") {
        $raw_time_out = max($remote_time_out, $zkteco_time_out);
      } else if ($zkteco_time_out != "" && $remote_time_out == "") {
        $raw_time_out = $zkteco_time_out;
      } else {
        $raw_time_out = $remote_time_out;
      }

      if ($zkteco_break_in != "00:00" && $remote_break_in != "00:00") {
        $raw_break_in = max($remote_break_in, $zkteco_break_in);
      } else if ($zkteco_break_in != "00:00" && $remote_break_in == "00:00") {
        $raw_break_in = $zkteco_break_in;
      } else {
        $raw_break_in = $remote_break_in;
      }

      if ($zkteco_break_out != "00:00" && $remote_break_out != "00:00") {
        $raw_break_out = max($remote_break_out, $zkteco_break_out);
      } else if ($zkteco_break_out != "00:00" && $remote_break_out == "00:00") {
        $raw_break_out = $zkteco_break_out;
      } else {
        $raw_break_out = $remote_break_out;
      }



      foreach ($APPROVED_LEAVES as $APPROVED_LEAVE) {
        if ($APPROVED_LEAVE->leave_date == $DATE_DATA) {

          $leave_type_name      = $this->selfservices_model->GET_SPECIFIC_LEAVE_NAME($APPROVED_LEAVE->type);

          if ($APPROVED_LEAVE->type != "1") {
            $paid_leave           = $APPROVED_LEAVE->duration;
            $leave_type           = $APPROVED_LEAVE->type;

            foreach ($LEAVE_TYPE_LIST as $LEAVE_TYPE) {
              if ($leave_type == $LEAVE_TYPE->id) {
                $leave_typename   = $LEAVE_TYPE->name;
              }
            }
            break;
          } else {
            $lwop           = $APPROVED_LEAVE->duration;
            break;
          }
        }
      }

      foreach ($APPROVED_OT_DATA as $APPROVED_OT) {
        if ($APPROVED_OT->date_ot == $DATE_DATA) {
          if ($APPROVED_OT->type == "Regular") {
            $reg_ot           = $APPROVED_OT->hours;
          } else {
            $nd_ot            = $APPROVED_OT->hours;
          }
          break;
        }
      }

      foreach ($HOLIDAYS as $HOLIDAY) {
        if ($HOLIDAY->col_holi_date == $DATE_DATA) {
          if ($HOLIDAY->col_holi_type == "Regular Holiday") {
            $hol_code                 = "LEGAL";
          } else {
            $hol_code                 = "SPECIAL";
          }
          break;
        }
      }

      if ($paid_leave != 0) {
        if ($hol_code == "REGULAR") {
        } else if ($hol_code == "LEGAL") {
          $paid_leave   = 0;
        } else if ($hol_code == "SPECIAL") {
          $paid_leave   = 0;
        }
      }

      if ($shift_name != '-' && $shift_name != 'REST') {
        $work_hours = $shift_regular_reg - $paid_leave;

        if ($raw_time_in != "" && $raw_time_out != "") {

          $in_min                 = $this->convert_time_to_float($raw_time_in, 'minute') - $this->convert_time_to_float($shift_time_in, 'minute');

          if ($in_min < 0) {
            $in_min  = 0;
          }

          if ($chk_graceperiod < $in_min) {
            if ($chk_lateundertime_deductiontype == 1) {
              $tardiness             = $in_min / 60;
            } else {
              $tardiness             = ceil($in_min / 30) / 2;
            }
          } else {
            $tardiness = 0;
          }


          $out_min                = $this->convert_time_to_float($shift_time_out, 'minute') - $this->convert_time_to_float($raw_time_out, 'minute');
          if ($out_min < 0) {
            $out_min  = 0;
          }

          if ($chk_lateundertime_deductiontype == 1) {
            $undertime             = $out_min / 60;
          } else {
            $undertime    = ceil($out_min / 30) / 2;
          }

          $awol       = $absent - $lwop;
          $reg_hrs    = $work_hours - $awol - $lwop - $tardiness - $undertime;

          if ($reg_hrs < 0) {
            $reg_hrs   = 0;
            $tardiness = 0;
            $undertime = 0;
            $awol       = $work_hours - $lwop;
          }
        } else {
          $reg_hrs   = 0;
          $tardiness = 0;
          $undertime = 0;
          $awol       = $work_hours - $lwop;
        }
      } else if ($shift_name == 'REST') {
        $reg_ot                 = 0;
        $nd                     = 0;
        $nd_ot                  = 0;
      } else {
        $reg_ot                 = 0;
        $nd                     = 0;
        $nd_ot                  = 0;
      }



      $totalWorkedHours += $reg_hrs;
      $totalAbsencesHours += $awol;
      $totalLWOPHours += $lwop;
      $totalTardinessHours += $tardiness;
      $totalUnderTimeHours += $undertime;
      $totalPaidHours += $paid_leave;
      $total_regot += $reg_ot;
      $total_nd += $nd;
      $total_nd_ot += $nd_ot;


      $ATTENDANCE_DATA[$index]["day_code"]                = $hol_code;
      $ATTENDANCE_DATA[$index]["shift_code"]              = $shift_name;
      $ATTENDANCE_DATA[$index]["shift_time_in"]           = $shift_time_in != ""   ?  date("H:i", strtotime($shift_time_in)) : "";
      $ATTENDANCE_DATA[$index]["shift_time_out"]          = $shift_time_out != ""   ?  date("H:i", strtotime($shift_time_out)) : "";
      $ATTENDANCE_DATA[$index]["shift_break_start"]       = $shift_break_start != ""   ?  date("H:i", strtotime($shift_break_start)) : "";
      $ATTENDANCE_DATA[$index]["shift_break_end"]         = $shift_break_end != ""   ?  date("H:i", strtotime($shift_break_end)) : "";
      $ATTENDANCE_DATA[$index]["time_overtime_start"]     = $time_overtime_start != ""   ?  date("H:i", strtotime($time_overtime_start)) : "";
      $ATTENDANCE_DATA[$index]["time_overtime_end"]       = $time_overtime_end != ""   ?  date("H:i", strtotime($time_overtime_end)) : "";


      $ATTENDANCE_DATA[$index]["time_in"]                 = $raw_time_in;
      $ATTENDANCE_DATA[$index]["time_out"]                = $raw_time_out;
      $ATTENDANCE_DATA[$index]["break_in"]                = $raw_break_in;
      $ATTENDANCE_DATA[$index]["break_out"]               = $raw_break_out;
      // $ATTENDANCE_DATA[$index]['reg_hrs']                  = $reg_hrs_disp;
      $ATTENDANCE_DATA[$index]["worked_hours"]            = ($totalWorkedHours != 0)    ? number_format($totalWorkedHours, 2) : "";
      $ATTENDANCE_DATA[$index]["tardiness"]               = ($totalTardinessHours != 0) ? number_format($totalTardinessHours, 2) : "";
      $ATTENDANCE_DATA[$index]["undertime"]               = ($totalUnderTimeHours != 0) ? number_format($totalUnderTimeHours, 2) : "";
      $ATTENDANCE_DATA[$index]["paid_leave"]              = ($totalPaidHours != 0)      ? number_format($totalPaidHours, 2) : "";
      $ATTENDANCE_DATA[$index]["lwop"]                    = ($totalLWOPHours != 0)      ? number_format($totalLWOPHours, 2) : "";
      $ATTENDANCE_DATA[$index]["awol"]                    = ($totalAbsencesHours != 0)  ? number_format($totalAbsencesHours, 2) : "";
      $ATTENDANCE_DATA[$index]["reg_ot"]                  = ($total_regot != 0)         ? number_format($total_regot, 2) : "";
      $ATTENDANCE_DATA[$index]["nd"]                      = ($total_nd != 0)            ? number_format($total_nd, 2) : "";
      $ATTENDANCE_DATA[$index]["nd_ot"]                   = ($total_nd_ot != 0)         ? number_format($total_nd_ot, 2) : "";

      $ATTENDANCE_DATA[$index]["date"]                    = $DATE_DATA;

      $ATTENDANCE_DATA[$index]["snapshot_in"]             = $snapshot_in;
      $ATTENDANCE_DATA[$index]["snapshot_out"]            = $snapshot_out;
      $ATTENDANCE_DATA[$index]["time_in_address"]         = $time_in_address;
      $ATTENDANCE_DATA[$index]["time_out_address"]        = $time_out_address;
      $ATTENDANCE_DATA[$index]["break_in_address"]        = $break_in_address;
      $ATTENDANCE_DATA[$index]["break_in_snapshot"]       = $break_in_snapshot;
      $ATTENDANCE_DATA[$index]["break_out_address"]        = $break_out_address;
      $ATTENDANCE_DATA[$index]["break_out_snapshot"]       = $break_out_snapshot;

      $index += 1;
    }

    $data['ATTENDANCE_DATA'] = $ATTENDANCE_DATA;

    $data["AWOL"]              = $this->selfservices_model->get_system_setup_setting('awol');
    $data["LWOP"]              = $this->selfservices_model->get_system_setup_setting('lwop');
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_time_record_views', $data);
  }

  function my_time_in_outs()
  {
    $userId                                            = $this->session->userdata('SESS_USER_ID');
    $data['DISP_EMPLOYEE_INFO']                        = $this->selfservices_model->MOD_DISP_EMPLOYEE($userId);

    // $data['todaySchedule'] = $todaySchedule                                  = $this->selfservices_model->MOD_DISP_EMPLOYEE_REMOTE_ATTENDANCE($userId);

    $data['shift_list'] = $shift_list                                        = $this->selfservices_model->GET_SHIFT_LIST();
    $attendance_shift                                 = $this->selfservices_model->GET_TODAY_SHIFT($userId);
    $shift_name                                        = $attendance_shift ? $attendance_shift->name : "N/A";
    $shift_time_in1                                    = $attendance_shift ? $attendance_shift->time_regular_start : "N/A";
    $shift_time_out1                                   = $attendance_shift ? $attendance_shift->time_regular_end : "N/A";
    $shift_time_in2                                    = "N/A";
    $shift_time_out2                                   = "N/A";

    $shift_time_in1_act                                = null;
    $shift_time_out1_act                               = null;
    $shift_time_in2_act                                = null;
    $shift_time_out2_act                               = null;

    $snapshot_in = null;
    $snapshot_out = null;
    $data['todaySchedule'] = $todaySchedule          = $this->selfservices_model->GET_TODAY_USER_ATTENDANCE($userId);
    if ($todaySchedule) {
      $shift_name                 = $todaySchedule->shift_name ? $todaySchedule->shift_name : "N/A";
      $shift_time_in1             = $todaySchedule->time_regular_start;
      $shift_time_out1            = $todaySchedule->time_regular_end;
      $shift_time_in2             = $todaySchedule->time_in_2;
      $shift_time_out2            = $todaySchedule->time_out_2;
      $shift_time_in1_act         = $todaySchedule->time_in;
      $snapshot_in                = $todaySchedule->snapshot_in;
      $shift_time_in2_act         = $todaySchedule->break_in;
      $shift_time_out2_act        = $todaySchedule->break_out;
      $shift_time_out1_act        = $todaySchedule->time_out;
      $snapshot_out               = $todaySchedule->snapshot_out;
    }
    $data['FENCES_AREAS']         = $this->selfservices_model->GET_USER_FENCES($userId);
    // echo '<pre>';
    // var_dump($data['FENCES_AREAS']);
    // return;
    // if (!empty($todaySchedule)) {
    //   foreach ($shift_list as $shift_list_row) {
    //     if ($todaySchedule[0]->shift_id == $shift_list_row->id) {
    //       $shift_name                                  = $shift_list_row->name;
    //       // $shift_time_in1                              = $shift_list_row->time_in;
    //       // $shift_time_out1                             = $shift_list_row->time_out;
    //       $shift_time_in1                              = $shift_list_row->time_regular_start;
    //       $shift_time_out1                             = $shift_list_row->time_regular_end;
    //       $shift_time_in2                              = $shift_list_row->time_in_2;
    //       $shift_time_out2                             = $shift_list_row->time_out_2;

    //       $response                                    = $this->selfservices_model->IS_DUPLICATE_REMOTE($userId);

    //       if ($response == 1) {
    //         $atte_data        = $this->selfservices_model->GET_ATTENDANCE_DATA($userId);
    //         // echo "<pre>";
    //         // echo 'atte_data';
    //         // print_r($atte_data);
    //         // echo "<pre>";
    //         // die();
    //         $shift_time_in1_act   = $atte_data->time_in;
    //         $snapshot_in          = $atte_data->snapshot_in;
    //         $shift_time_in2_act   = $atte_data->break_in;
    //         $shift_time_out2_act   = $atte_data->break_out;
    //         $shift_time_out1_act  = $atte_data->time_out;
    //         $snapshot_out          = $atte_data->snapshot_out;
    //       }
    //       break;
    //     }
    //   }
    // }

    $data['SHIFT_NAME']                                = $shift_name;
    $data['SHIFT_IN1']                                 = $shift_time_in1;
    $data['SHIFT_OUT1']                                = $shift_time_out1;
    $data['SHIFT_IN2']                                 = $shift_time_in2;
    $data['SHIFT_OUT2']                                = $shift_time_out2;

    $data['SHIFT_IN1_A']                               = $shift_time_in1_act;
    $data['snapshot_in']                               = $snapshot_in;
    $data['SHIFT_IN2_A']                               = $shift_time_in2_act;
    $data['SHIFT_OUT2_A']                              = $shift_time_out2_act;
    $data['SHIFT_OUT1_A']                              = $shift_time_out1_act;
    $data['snapshot_out']                               = $snapshot_out;

    $data['DISP_INOUT_TYPE']                           = $this->selfservices_model->GET_IN_OUT_TYPE();
    // echo '<pre>';
    // var_dump($data);
    // return;
    $data['data']               = json_encode($data);
    $data["remoteCamera"]                              = $this->selfservices_model->GET_SYSTEM_SETTING("remoteCamera");
    $data["remoteGPS"]                                 = $this->selfservices_model->GET_SYSTEM_SETTING("remoteGPS");
    $data["geo_fencing"]                               = $this->selfservices_model->GET_SYSTEM_SETTING("geo_fencing");
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_remote_attendance', $data);
  }

  function current_location($in_out, $lat_long)
  {

    $string                                            = urldecode($lat_long);
    $array_lat_long                                    = explode(",", $string);
    $data['lat_loc']                                   = $array_lat_long[0];
    $data['long_loc']                                  = $array_lat_long[1];
    $data['in_out']                                    = $in_out;

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_current_location_views', $data);
  }

  function employee_time_in1()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $time_latitude                        = empty($this->input->post('time_latitude')) ? null : $this->input->post('time_latitude');
      $time_longitude                       = empty($this->input->post('time_longitude')) ? null : $this->input->post('time_longitude');
      // $time_address                         = empty($this->input->post('time_address'))? null: $this->input->post('time_address');
      $empl_id                              = $this->session->userdata('SESS_USER_ID');
      $current_date                         = date('Y-m-d');
      $time                                 = date('H:i:s');
      // echo '<pre>';
      // var_dump($this->input->post());
      // return;
      $lat_long = '';
      if ($time_latitude && $time_longitude) {
        $lat_long                             = $time_latitude . ',' . $time_longitude;
      }
      $imageData = $this->input->post('image');
      if (!empty($imageData)) {

        $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));

        if ($decodedImage !== false) {
          $file_name = $empl_id . '_' . uniqid() . '.png';
          $file_path = './assets_user/snapshots/' . $file_name;
          file_put_contents($file_path, $decodedImage);

          try {

            // $res  = $this->employees_model->UPDATE_EMPL_REQUIREMENTS_ATTACHMENT($upload_data['file_name'],$requirement_id,$id);
            $this->selfservices_model->UPDATE_EMPL_TIME_IN_1($empl_id, $current_date, $time, $lat_long, $file_name);
            $this->session->set_flashdata('SUCC', 'Successfully Time In');
            redirect('selfservices/my_time_in_outs');
          } catch (Exception $e) {
            $this->session->set_flashdata('ERR', 'Failed to add requirement.' . $e->getMessage());
            redirect('selfservices/my_time_in_outs');
          }
        } else {
          $this->session->set_flashdata('ERR', 'File Decoding Failed');
          redirect('selfservices/my_time_in_outs');
        }
      } else {
        $file_name = '';
        $this->selfservices_model->UPDATE_EMPL_TIME_IN_1($empl_id, $current_date, $time, $lat_long, $file_name);
        $this->session->set_flashdata('SUCC', 'Successfully Time In');
        redirect('selfservices/my_time_in_outs');
        // $error_message = "An error occurred during picture upload.";
        // switch ($_FILES['file']['error']) {
        //     case UPLOAD_ERR_INI_SIZE:
        //     $error_message = "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
        //     break;
        // case UPLOAD_ERR_FORM_SIZE:
        //     $error_message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
        //     break;
        // }
        // $this->session->set_flashdata('ERR', $error_message);
        //   redirect('selfservices/my_time_in_outs');
      }
    } else {
      redirect('login/session_expired');
    }
  }

  function employee_time_out1()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // $time_latitude = empty($this->input->post('time_latitude'))? null : $this->input->post('time_latitude');
      // $time_longitude = empty($this->input->post('time_longitude'))? null: $this->input->post('time_longitude');
      $time_latitude                        = empty($this->input->post('time_latitude')) ? null : $this->input->post('time_latitude');
      $time_longitude                       = empty($this->input->post('time_longitude')) ? null : $this->input->post('time_longitude');
      // $time_address = $this->input->post('time_address');
      $empl_id                                           = $this->session->userdata('SESS_USER_ID');
      $current_date                                      = date('Y-m-d');
      $time                                              = date('H:i:s');

      $lat_long = null;
      if ($time_latitude && $time_longitude) {
        $lat_long                             = $time_latitude . ',' . $time_longitude;
      }

      $imageData = $this->input->post('image_out');
      if (!empty($imageData)) {
        $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
        if ($decodedImage !== false) {
          $file_name = $empl_id . '_' . uniqid() . '.png';
          $file_path = './assets_user/snapshots/' . $file_name;
          file_put_contents($file_path, $decodedImage);

          try {
            // $res  = $this->employees_model->UPDATE_EMPL_REQUIREMENTS_ATTACHMENT($upload_data['file_name'],$requirement_id,$id);
            $this->selfservices_model->UPDATE_EMPL_TIME_OUT_1($empl_id, $current_date, $time, $lat_long, $file_name);
            $this->session->set_flashdata('SUCC', 'Successfully Time Out');
            redirect('selfservices/my_time_in_outs');
          } catch (Exception $e) {
            $this->session->set_flashdata('ERR', 'Failed to add requirement.' . $e->getMessage());
            redirect('selfservices/my_time_in_outs');
          }
        } else {
          $this->session->set_flashdata('ERR', 'File Decoding Failed');
          redirect('selfservices/my_time_in_outs');
        }
      } else {
        $file_name = null;
        $this->selfservices_model->UPDATE_EMPL_TIME_OUT_1($empl_id, $current_date, $time, $lat_long, $file_name);
        $this->session->set_flashdata('SUCC', 'Successfully Time Out');
        redirect('selfservices/my_time_in_outs');
        // $error_message = "An error occurred during picture upload.";
        // switch ($_FILES['file']['error']) {
        //     case UPLOAD_ERR_INI_SIZE:
        //     $error_message = "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
        //     break;
        // case UPLOAD_ERR_FORM_SIZE:
        //     $error_message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
        //     break;
        // }
        // $this->session->set_flashdata('ERR', $error_message);
        //   redirect('selfservices/my_time_in_outs');
      }
    } else {
      redirect('login/session_expired');
    }
  }
  function employee_time_out1_old()
  {
    $empl_id                                           = $this->session->userdata('SESS_USER_ID');
    $time_address                                      = $this->input->post('time_address');
    $latitude                                          = $this->input->post('time_latitude');
    $longitude                                         = $this->input->post('time_longitude');
    $current_date                                      = date('Y-m-d');
    $time                                              = date('H:i:s');
    $lat_long                                          = $latitude . ',' . $longitude;

    $this->selfservices_model->UPDATE_EMPL_TIME_OUT_1($empl_id, $current_date, $time, $lat_long);
    $this->session->set_userdata('succ_time_out1', 'Successfully Time Out 1');
    redirect('selfservices/my_time_in_outs');
  }

  // function employee_time_in2()
  // {
  //   $empl_id                                           = $this->session->userdata('SESS_USER_ID');
  //   $time_address                                      = $this->input->post('time_address');
  //   $latitude                                          = $this->input->post('time_latitude');
  //   $longitude                                         = $this->input->post('time_longitude');
  //   $current_date                                      = date('Y-m-d');
  //   $time                                              = date('H:i:s');
  //   $lat_long                                          = $latitude . ',' . $longitude;

  //   $this->selfservices_model->UPDATE_EMPL_TIME_IN_2($empl_id, $current_date, $time, $lat_long);
  //   $this->session->set_userdata('succ_time_in2', 'Successfully Time In 2');
  //   redirect('selfservices/my_time_in_outs');
  // }
  function employee_time_in2()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $time_latitude                        = empty($this->input->post('time_latitude')) ? null : $this->input->post('time_latitude');
      $time_longitude                       = empty($this->input->post('time_longitude')) ? null : $this->input->post('time_longitude');
      // $time_address                         = empty($this->input->post('time_address'))? null: $this->input->post('time_address');
      $empl_id                              = $this->session->userdata('SESS_USER_ID');
      $current_date                         = date('Y-m-d');
      $time                                 = date('H:i:s');
      // echo '<pre>';
      // var_dump($this->input->post());
      // return;
      $lat_long = '';
      if ($time_latitude && $time_longitude) {
        $lat_long                             = $time_latitude . ',' . $time_longitude;
      }
      $imageData = $this->input->post('image');
      if (!empty($imageData)) {

        $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));

        if ($decodedImage !== false) {
          $file_name = $empl_id . '_' . uniqid() . '.png';
          $file_path = './assets_user/snapshots/' . $file_name;
          file_put_contents($file_path, $decodedImage);

          try {

            // $res  = $this->employees_model->UPDATE_EMPL_REQUIREMENTS_ATTACHMENT($upload_data['file_name'],$requirement_id,$id);
            $this->selfservices_model->UPDATE_EMPL_TIME_IN_2($empl_id, $current_date, $time, $lat_long, $file_name);
            $this->session->set_flashdata('SUCC', 'Successfully Time In');
            redirect('selfservices/my_time_in_outs');
          } catch (Exception $e) {
            $this->session->set_flashdata('ERR', 'Failed to add requirement.' . $e->getMessage());
            redirect('selfservices/my_time_in_outs');
          }
        } else {
          $this->session->set_flashdata('ERR', 'File Decoding Failed');
          redirect('selfservices/my_time_in_outs');
        }
      } else {
        $file_name = '';
        $this->selfservices_model->UPDATE_EMPL_TIME_IN_2($empl_id, $current_date, $time, $lat_long, $file_name);
        $this->session->set_flashdata('SUCC', 'Successfully Time In');
        redirect('selfservices/my_time_in_outs');
        // $error_message = "An error occurred during picture upload.";
        // switch ($_FILES['file']['error']) {
        //     case UPLOAD_ERR_INI_SIZE:
        //     $error_message = "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
        //     break;
        // case UPLOAD_ERR_FORM_SIZE:
        //     $error_message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
        //     break;
        // }
        // $this->session->set_flashdata('ERR', $error_message);
        //   redirect('selfservices/my_time_in_outs');
      }
    } else {
      redirect('login/session_expired');
    }
    // $empl_id                                           = $this->session->userdata('SESS_USER_ID');
    // $current_date                                      = date('Y-m-d');
    // $break_in                                          = date('H:i:s');

    // $this->selfservices_model->UPDATE_EMPL_TIME_IN_2($break_in, $current_date, $empl_id);
    // $this->session->set_userdata('succ_time_in2', 'Break started successfully');
    // redirect('selfservices/my_time_in_outs');
  }

  // function employee_time_out2()
  // {
  //   $empl_id                                           = $this->session->userdata('SESS_USER_ID');
  //   $time_address                                      = $this->input->post('time_address');
  //   $latitude                                          = $this->input->post('time_latitude');
  //   $longitude                                         = $this->input->post('time_longitude');
  //   $current_date                                      = date('Y-m-d');
  //   $time                                              = date('H:i:s');
  //   $lat_long                                          = $latitude . ',' . $longitude;

  //   $this->selfservices_model->UPDATE_EMPL_TIME_OUT_2($empl_id, $current_date, $time, $lat_long);
  //   $this->session->set_userdata('succ_time_out2', 'Successfully Time Out 2');
  //   redirect('selfservices/my_time_in_outs');
  // }
  function employee_time_out2()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // $time_latitude = empty($this->input->post('time_latitude'))? null : $this->input->post('time_latitude');
      // $time_longitude = empty($this->input->post('time_longitude'))? null: $this->input->post('time_longitude');
      $time_latitude                        = empty($this->input->post('time_latitude')) ? null : $this->input->post('time_latitude');
      $time_longitude                       = empty($this->input->post('time_longitude')) ? null : $this->input->post('time_longitude');
      // $time_address = $this->input->post('time_address');
      $empl_id                                           = $this->session->userdata('SESS_USER_ID');
      $current_date                                      = date('Y-m-d');
      $time                                              = date('H:i:s');

      $lat_long = null;
      if ($time_latitude && $time_longitude) {
        $lat_long                             = $time_latitude . ',' . $time_longitude;
      }

      $imageData = $this->input->post('image');
      if (!empty($imageData)) {

        $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
        if ($decodedImage !== false) {
          $file_name = $empl_id . '_' . uniqid() . '.png';
          $file_path = './assets_user/snapshots/' . $file_name;
          file_put_contents($file_path, $decodedImage);

          try {
            // $res  = $this->employees_model->UPDATE_EMPL_REQUIREMENTS_ATTACHMENT($upload_data['file_name'],$requirement_id,$id);
            $this->selfservices_model->UPDATE_EMPL_TIME_OUT_2($empl_id, $current_date, $time, $lat_long, $file_name);
            $this->session->set_flashdata('SUCC', 'Successfully Break In');
            redirect('selfservices/my_time_in_outs');
          } catch (Exception $e) {
            $this->session->set_flashdata('ERR', 'Failed to add requirement.' . $e->getMessage());
            redirect('selfservices/my_time_in_outs');
          }
        } else {
          $this->session->set_flashdata('ERR', 'File Decoding Failed');
          redirect('selfservices/my_time_in_outs');
        }
      } else {
        $file_name = null;
        $this->selfservices_model->UPDATE_EMPL_TIME_OUT_2($empl_id, $current_date, $time, $lat_long, $file_name);
        $this->session->set_flashdata('SUCC', 'Successfully Break In');
        redirect('selfservices/my_time_in_outs');
      }
    } else {
      redirect('login/session_expired');
    }
    // $empl_id                                           = $this->session->userdata('SESS_USER_ID');
    // $current_date                                      = date('Y-m-d');
    // $break_out                                         = date('H:i:s');

    // $this->selfservices_model->UPDATE_EMPL_TIME_OUT_2($break_out, $current_date, $empl_id);
    // $this->session->set_userdata('succ_time_out2', 'Successfully Time Out 2');
    // redirect('selfservices/my_time_in_outs');
  }

  function my_time_adjustments()
  {
    $userId                                            = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                                = array();
    $data["excel_import"]                              = [false];
    $status                                            = $this->input->get('status');
    $limit                                             = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                              = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                            =  $limit * ($page - 1);

    $data['STATUS']                                    = $status;
    $data['STATUSES']                                  = array('Pending', 'Approved', 'Rejected');
    $data['TABLE_DATA']                                = $this->selfservices_model->GET_EMPL_TIME_ADJ($userId, $status, $limit, $offset);
    $total_count                                       = $this->selfservices_model->GET_EMPL_TIME_ADJ_COUNT($userId, $status);
    $excess                                            = $total_count % $limit;
    $data['C_DATA_COUNT']                              = $total_count;
    $data['PAGES_COUNT']                               = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                      = $page;
    $data['ROW']                                       = $limit;
    $data['C_ROW_DISPLAY']                             = array(10, 25, 50);
    $data['DATE_FORMAT']                                = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_time_adjustment_views', $data);
  }

  function my_shift_request()
  {
    $userId                                            = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                                = array();
    $data["excel_import"]                              = [false];
    $status                                            = $this->input->get('status');
    $limit                                             = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                              = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                            =  $limit * ($page - 1);

    $data['STATUS']                                    = $status;
    $data['STATUSES']                                  = array('Pending', 'Approved', 'Rejected');
    $data['TABLE_DATA']                                = $this->selfservices_model->GET_EMPL_TIME_ADJ($userId, $status, $limit, $offset);
    $total_count                                       = $this->selfservices_model->GET_EMPL_TIME_ADJ_COUNT($userId, $status);
    $excess                                            = $total_count % $limit;
    $data['C_DATA_COUNT']                              = $total_count;
    $data['PAGES_COUNT']                               = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                      = $page;
    $data['ROW']                                       = $limit;
    $data['C_ROW_DISPLAY']                             = array(10, 25, 50);

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_shift_request_views', $data);
  }

  function request_shift()
  {
    $data['shifts'] = $this->selfservices_model->GET_ALL_SHIFTS();

    // echo '<pre>';
    // print_r($data['shifts']);

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/request_shift_views', $data);
  }

  function add_shift_request()
  {
    $userId                                             = $this->session->userdata('SESS_USER_ID');
    $input_data                                         = $this->input->post();
    // $attachment                                         = $_FILES['attachment']['name'];
    $input_data['empl_id']                              = $this->session->userdata('SESS_USER_ID');
    $input_data['assigned_by']                          = $this->session->userdata('SESS_USER_ID');
    $input_data['status']                               = 'Pending 1';
    // $file_info = pathinfo($attachment);
    $employee                                           = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
    // $input_data['attachment']                           = $attachment;

    $approvers = $this->selfservices_model->GET_USER_APPROVERS($userId, 'tbl_approvers');
    $approver  = $approvers->approver_1a ? $approvers->approver_1a : 0;
    if ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0) && (!$approvers || $approvers->approver_3a == 0) && (!$approvers || $approvers->approver_4a == 0) && (!$approvers || $approvers->approver_5a == 0)) {
      $input_data['status'] = 'Approved';
    }
    $input_data['approver1'] = $approvers && $approvers->approver_1a ?  $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers && $approvers->approver_2a ?  $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers && $approvers->approver_3a ?  $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers && $approvers->approver_4a ?  $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers && $approvers->approver_5a ?  $approvers->approver_5a : 0;

    $res = $this->selfservices_model->ADD_SHIFT_REQUEST($input_data);

    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed shift change request');
    }

    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->selfservices_model->GET_REQUESTOR('shift', $res);
      $description    = "Shift Request Review for [SHF" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $token['approver']              = 'approver1';
      $token['approver_id']           = $input_data['approver1'];
      $token['approver_date_col']     = 'approver1_date';
      $token['id']                    = $res;
      $json_token                     =  json_encode($token);
      $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['approver1'],
        'type' => 'shift_approval',
        'content_id' => $res,
        'location' => 'selfservices/my_shift_request',
        'description' => $description,
        'approve' => 'approvals/approve_request?token=' . urlencode($encrypted_token),
        'reject' => 'approvals/reject_request?token=' . urlencode($encrypted_token)
      );
      $notif = $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Successfully added request.');
        redirect('selfservices/my_shift_request');
        return;
      }
    } else {
      $this->session->set_flashdata('ERR', 'Failed adding request.');
      redirect('selfservices/request_shift');
      return;
    }
  }

  function edit_time_adjustments($id)
  {
    $data['TIME_ADJ'] = $this->selfservices_model->GET_TIME_ADJ($id);

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/edit_time_adjustment_views', $data);
  }

  function update_time_adjustment()
  {
    $input_data = $this->input->post();
    $id         = $input_data['id'];
    $res        = $this->selfservices_model->UPDATE_TIME_ADJ($id, $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Updated successfully');
    }
    redirect('selfservices/my_time_adjustments');
  }

  // function get_offset_status($id)
  // {
  //   $data['OFFSETS'] = $this->selfservices_model->GET_OFFSET($id);
  //   // echo '<pre>';
  //   // var_dump($data['TIME_ADJS']);
  //   // return;
  //   $this->load->view('modules/partials/_my_offset_modal_content', $data);
  // }
  function get_time_adj_status($id)
  {
    $data['TIME_ADJS'] = $this->selfservices_model->GET_TIME_ADJUSTMENT($id);
    $row_data               = $this->selfservices_model->GET_ROW_DATA('tbl_attendance_adjustments', $id);
    $data['C_APPROVERS']    = array();
    if ($row_data->approver5) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver5, $row_data->approver5_date, $row_data->status, 'Pending 5', '0000-00-00 00:00:00');
    }
    if ($row_data->approver4) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver4, $row_data->approver4_date, $row_data->status, 'Pending 4', $row_data->approver5_date);
    }
    if ($row_data->approver3) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver3, $row_data->approver3_date, $row_data->status, 'Pending 3', $row_data->approver4_date);
    }
    if ($row_data->approver2) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver2, $row_data->approver2_date, $row_data->status, 'Pending 2', $row_data->approver3_date);
    }
    if ($row_data->approver1) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver1, $row_data->approver1_date, $row_data->status, 'Pending 1', $row_data->approver2_date);
    }
    $data['DATE_FORMAT']                                = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    // echo '<pre>';
    // var_dump($data['TIME_ADJS']); die();
    // return;
    $this->load->view('modules/partials/_my_time_adj_modal_content', $data);
  }

  function get_time_adjustment_approval($id)
  {
    $time_adjs                      = $this->selfservices_model->GET_TIME_ADJUSTMENT($id);
    $user_id                        = $this->session->userdata('SESS_USER_ID');
    $adj_times                      = $this->selfservices_model->GET_ADJUSTMENTS_SPECIFIC($time_adjs->date_adjustment, $user_id);
    $actualtimes                    = $this->selfservices_model->GET_ACTUAL_TIMES($time_adjs->date_adjustment, $user_id);
    $row_data                       = $this->selfservices_model->GET_ROW_DATA('tbl_attendance_adjustments', $id);
    $data["ACTUALTIME"]             = $actualtimes;
    $data["TIME_DATAS"]             = $adj_times;
    $data['TIME_ADJS']              =  $time_adjs;
    $data['C_APPROVERS']    = array();
    if ($row_data->approver5) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver5, $row_data->approver5_date, $row_data->status, 'Pending 5', '0000-00-00 00:00:00');
    }
    if ($row_data->approver4) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver4, $row_data->approver4_date, $row_data->status, 'Pending 4', $row_data->approver5_date);
    }
    if ($row_data->approver3) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver3, $row_data->approver3_date, $row_data->status, 'Pending 3', $row_data->approver4_date);
    }
    if ($row_data->approver2) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver2, $row_data->approver2_date, $row_data->status, 'Pending 2', $row_data->approver3_date);
    }
    if ($row_data->approver1) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver1, $row_data->approver1_date, $row_data->status, 'Pending 1', $row_data->approver2_date);
    }
    $data['row_data']   = $row_data;
    $data['userId']     = $this->session->userdata('SESS_USER_ID');
    $data['DATE_FORMAT']           = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    // if(( $row_data->approver1 == $userId && $row_data->approver1_date='0000-00-00 00:00:00') ||  
    //     ($row_data->approver2==$userId && $row_data->approver1_date!='0000-00-00 00:00:00' && $row_data->approver2_date=='0000-00-00 00:00:00'  ) ||
    //     ($row_data->approver3==$userId && $row_data->approver1_date!='0000-00-00 00:00:00' && $row_data->approver2_date!='0000-00-00 00:00:00' AND $row_data->approver3_date=='0000-00-00 00:00:00'  ) ||
    //     ($row_data->approver4==$userId AND $row_data->approver1_date!='0000-00-00 00:00:00' && $row_data->approver2_date!='0000-00-00 00:00:00' AND $row_data->approver3_date!='0000-00-00 00:00:00' AND $row_data->approver4_date=='0000-00-00 00:00:00'  ) ||
    //     ($row_data->approver5==$userId AND $row_data->approver1_date!='0000-00-00 00:00:00' && $row_data->approver2_date!='0000-00-00 00:00:00' AND $row_data->approver3_date!='0000-00-00 00:00:00' AND $row_data->approver4_date!='0000-00-00 00:00:00' AND $row_data->approver5_date=='0000-00-00 00:00:00')
    // ){
    //         // echo 'form approved';
    //     }

    // echo '<pre>';
    // var_dump($data['ROW_DATA']);

    // return;
    $this->load->view('modules/partials/_time_adjustment_modal_content', $data);
  }

  function request_time_adjustment()
  {
    $date                                                = $this->input->get('date');
    $data['ATTENDANCE_REC']                              = $this->selfservices_model->GET_ATTENDANCE_EMPL_REC($this->session->userdata('SESS_USER_ID'));
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
    $this->load->view('modules/selfservices/request_time_adjustment_views', $data);
  }

  function add_time_adjustment()
  {
    $userId                                             = $this->session->userdata('SESS_USER_ID');
    $input_data                                         = $this->input->post();
    // $attachment                                         = $_FILES['attachment']['name'];
    $input_data['status']                               = 'Pending 1';
    // $file_info = pathinfo($attachment);
    $input_data['create_date']                          = date('Y-m-d H:i:s');
    $input_data['edit_date']                            = date('Y-m-d H:i:s');
    $employee                                           = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
    // $input_data['attachment']                           = $attachment;

    $approvers = $this->selfservices_model->GET_USER_APPROVERS($userId, 'tbl_approvers');
    $autoApprovedEnabled  = $this->selfservices_model->getApprovalAutoApproveEnabled($input_data['empl_id']);
    $approver  = $approvers->approver_1a ? $approvers->approver_1a : 0;

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('selfservices/request_time_adjustment');
    }

    if ($autoApprovedEnabled || (!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0) && (!$approvers || $approvers->approver_3a == 0) && (!$approvers || $approvers->approver_4a == 0) && (!$approvers || $approvers->approver_5a == 0)) {
      $input_data['status'] = 'Approved';
    }
    $input_data['approver1'] = $approvers && $approvers->approver_1a ?  $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers && $approvers->approver_2a ?  $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers && $approvers->approver_3a ?  $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers && $approvers->approver_4a ?  $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers && $approvers->approver_5a ?  $approvers->approver_5a : 0;
    $res = $this->selfservices_model->ADD_TIME_ADJUSTMENT_REQUEST($input_data);
    // if ($input_data['status'] == 'Approved') {
    //   $this->insert_approved_time_adjustment($res);
    // }
    // if ($this->isApproversEnable == 0) {
    //   redirect('selfservices/my_time_adjustments');
    //   return;
    // }
    // echo $res;
    // return;
    if ($input_data['status'] != 'Approved') {
      $this->session->set_userdata('SUCC', 'Successfully added');
      $requestor      = $this->selfservices_model->GET_REQUESTOR('time adjustment', $res);
      $description    = "Time Adjustment Application Review for [TAD" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['approver1'],
        'type' => 'time_adjustment_approval',
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

      $json_token                     =  json_encode($token);
      $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));


      $notif = $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Successfully added request.');
        redirect('selfservices/my_time_adjustments');
        return;
      }
    }
    redirect('selfservices/my_time_adjustments');

    //   $this->session->set_userdata('SUCC', 'Successfully added');
    // } else if ($res  && $input_data['status'] == 'Approved') {
    //   $this->session->unset_userdata('SUCC', 'Successfully added');
    //   redirect('selfservices/my_time_adjustments');
    //   return;
    // }
    // redirect('selfservices/my_time_adjustments');
  }

  function my_leaves()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $data['LEAVE_SETTINGS']                         = $this->leaves_model->GET_ALL_LEAVE_SETTING();
    $data['TABLE_DATA']                             = array();
    $status                                         = $this->input->get('status');
    $limit                                          = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                           = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                         =  $limit * ($page - 1);

    $data['STATUS']                                 = $status;
    $data['STATUSES']                               = array('Pending', 'Approved', 'Rejected', 'Withdrawn');
    $data['TABLE_DATA']                             = $this->selfservices_model->GET_LEAVE_LIST($userId, $status, $limit, $offset);
    $total_count                                    = $this->selfservices_model->GET_LEAVE_LIST_COUNT($userId, $status);
    $excess                                         = $total_count % $limit;
    $data['C_DATA_COUNT']                           = $total_count;
    $data['PAGES_COUNT']                            = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                   = $page;
    $data['ROW']                                    = $limit;
    $data['C_ROW_DISPLAY']                          = array(10, 25, 50);
    $SL_COUNT                                       = $this->selfservices_model->GET_LEAVE_ENTITLEMENT($userId, 'Sick Leave');
    $VL_COUNT                                       = $this->selfservices_model->GET_LEAVE_ENTITLEMENT($userId, 'Vacation Leave');

    $data['C_LEAVE_ENTITLEMENT_SICK']               = $SL_COUNT;
    $data['C_LEAVE_ENTITLEMENT_VACATION']           = $VL_COUNT;

    $currentYear = date("Y");
    $data['REMAINING_SIL_HOURS']                    = $this->selfservices_model->REMAINING_SIL_HOURS($userId) - $this->selfservices_model->USED_SIL_HOURS($userId);
    $data['REMAINING_VACATION_HOURS']               = $this->selfservices_model->REMAINING_VACATION_HOURS($userId) - $this->selfservices_model->USED_VACATION_HOURS($userId);
    $data['REMAINING_SICK_HOURS']                   = $this->selfservices_model->REMAINING_SICK_HOURS($userId) - $this->selfservices_model->USED_SICK_HOURS($userId);
    $data['REMAINING_OFFSET_HOURS']                 = $this->selfservices_model->OFFSET_APPROVED_COUNT($userId);
    $data['DATE_FORMAT']                            = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_leave_views', $data);
    return;
  }

  function my_offsets()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                             = array();
    $status                                         = $this->input->get('status');
    $limit                                          = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                           = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                         =  $limit * ($page - 1);

    $data['STATUS']                                 = $status;
    $data['STATUSES']                               = array('Pending', 'Approved', 'Rejected', 'Withdrawn');
    $data['TABLE_DATA']                             = $this->selfservices_model->GET_OFFSETS_LIST($userId, $status, $limit, $offset);
    $total_count                                    = $this->selfservices_model->GET_OFFSETS_LIST_COUNT($userId, $status);
    $excess                                         = $total_count % $limit;
    $data['C_DATA_COUNT']                           = $total_count;
    $data['PAGES_COUNT']                            = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                   = $page;
    $data['ROW']                                    = $limit;
    $data['C_ROW_DISPLAY']                          = array(10, 25, 50);
    $data['DATE_FORMAT']                            = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_offsets_views', $data);
    return;
  }

  // function redeemed_offset()
  // {
  //   $data['userId']                       = $empl_id          = $this->session->userdata('SESS_USER_ID');
  //   $data['DISP_TOTAL_REDEEMED_OFFSET']            = $total_redeemed     = $this->selfservices_model->GET_TOTAL_REDEEMED_OFFSET($empl_id);
  //   $data['DISP_TOTAL_ACQUIRED_OFFSET']            = $total_acquired     = $this->selfservices_model->GET_TOTAL_ACQUIRED_OFFSET($empl_id);
  //   $data['DISP_TOTAL_OFFSET']                      = $total_acquired->total_acquired_offset - $total_redeemed->total_redeemed_offset;


  //   $this->load->view('templates/header');
  //   $this->load->view('modules/selfservices/new_offset_request_views', $data);
  // }

  function redeemed_offset()
  {
    $data['userId']                                     = $empl_id          = $this->session->userdata('SESS_USER_ID');

    $total_redeemed                                     = $this->selfservices_model->GET_TOTAL_REDEEMED_OFFSET($empl_id);
    $total_acquired                                     = $this->selfservices_model->GET_TOTAL_ACQUIRED_OFFSET($empl_id);

    $expired_acquired_offset                            = $total_acquired->expired_acquired_offset ?? 0;
    $available_offset                                   = ($total_acquired->total_acquired_offset - $expired_acquired_offset) - $total_redeemed->total_redeemed_offset;

    $data['DISP_TOTAL_REDEEMED_OFFSET']                 = $total_redeemed->total_redeemed_offset;
    $data['DISP_TOTAL_ACQUIRED_OFFSET']                 = $total_acquired->total_acquired_offset;
    $data['DISP_TOTAL_OFFSET']                          = max(0, $available_offset);

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/new_offset_request_views', $data);
  }

  function acquire_offset()
  {
    $data['userId']                       = $empl_id          = $this->session->userdata('SESS_USER_ID');

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/acquire_offset_request_views', $data);
  }

  function withdraw_acquire_offset()
  {
    $id = $this->input->post('rowId');
    $reason = $this->input->post('reason');
    $status = "Withdrawn";

    $res = $this->selfservices_model->MOD_UPDATE_ACQUIRE_OFFSET_STATUS($id, $status, $reason);

    $this->session->set_flashdata('SUCC', 'Acquired Offset Withdrawal Updated Successfully!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function get_attendance_record()
  {
    $input_data                             = $this->input->post();
    $empl_id                                = $this->session->userdata('SESS_USER_ID');
    $date                                   = $input_data['date'];

    $data['userId']                         = $empl_id;
    $data['shift']                          = $this->selfservices_model->GET_SHIFT_TYPE($empl_id, $date);
    $data['attendance']                     = $this->selfservices_model->GET_ATTENDANCE_RECORD($empl_id, $date);

    echo json_encode($data);
  }

  function get_acquired_hours_summary()
  {
    $empl_id = $this->input->post('empl_id');
    $totalHours = $this->selfservices_model->DISP_TOTAL_ACQUIRED_OFFSET($empl_id);
    $monthlyData = $this->selfservices_model->DISP_MONTHLY_ACQUIRED_OFFSET($empl_id);

    echo json_encode([
      'total_acquired_offset' => $totalHours->total_acquired_offset ?? 0,
      'monthly_data' => $monthlyData
    ]);
  }

  function add_new_offset()
  {
    $user_id                            = $this->session->userdata('SESS_USER_ID');
    $isApproversEnable                  = $this->selfservices_model->GET_SETUP_SETTING('requireApprovers');
    // $attachment                         = $_FILES['attachment']['name'];
    $input_data                         = $this->input->post();
    $date                               = $input_data['offset_date'];
    $actual_time_in                     = $input_data['actual_time_in'];
    $actual_time_out                    = $input_data['actual_time_out'];

    if (preg_match('/^\d{1,3}-\d{2}-\d{2}$/', $date) || preg_match('/^\d{5,}-\d{2}-\d{2}$/', $date)) {
      $this->session->set_flashdata('ERR', "Invalid Date. Please fix and try again");
      redirect('selfservices/my_offsets');
    }

      // Today minus 2 days
      $min_allowed_date = date('Y-m-d', strtotime('-2 days'));

      if ($date < $min_allowed_date) {
        $formatted_date = date('m/d/Y', strtotime($date));
        $this->session->set_flashdata("ERR", "Past offset must be filed within 2 days.");
        redirect('selfservices/request_overtime');
        return;
      }

    $input_data['assigned_by']          = $user_id;
    $input_data['empl_id']              = $user_id;
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

    if ($approver == 0) {
      $this->session->set_flashdata('ERR', 'No Approver Assign');
      redirect('selfservices/my_offsets');
      return;
    }
    $is_duplicate                                     = $this->selfservices_model->GET_OFFSETS_IS_DUPLICATE_DATE_EMPL_ID($input_data['offset_type'], $input_data['offset_date'], $user_id);

    if ($is_duplicate > 0) {
      $this->session->set_flashdata('ERR', "Offset submission failed. It looks like you have already submitted a offset request for the same dates.");
      redirect('selfservices/my_offsets');
      return;
    } else {
      $res                                            = $this->selfservices_model->ADD_OFFSET_REQUEST($input_data);
      if ($res) {
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed offset request');
        $this->session->set_flashdata('SUCC', 'Successfully added');
        if ($isApproversEnable == 0) {
          redirect('selfservices/my_offsets');
          return;
        }
        $requestor      = $this->selfservices_model->GET_REQUESTOR('offsets', $res);
        $description    = "Offset Application Review for [OFF" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
        $token = array(
          'approver' => $approvers->approver_1a,
          'approver_id' => $approvers->approver_1a,
          'approver_date_col' => $approvers->approver_1a . '_date',
          'id' => $res
        );

        $json_token = json_encode($token);
        $encrypted_token = $this->technos_encryption->encryptData($json_token);

        $notif_data     = array(
          'create_date' => date('Y-m-d H:i:s'),
          'empl_id' => $approvers->approver_1a,
          'type' => 'offset',
          'content_id' => $res,
          'location' => 'selfservices/offset_approval',
          'description' => $description,
          'approve' => 'approvals/approve_request?token=' . urlencode($encrypted_token),
          'reject' => 'approvals/reject_request?token=' . urlencode($encrypted_token)
        );
        $notif = $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      } else {
        $this->session->set_flashdata('ERR', 'Fail to add new data');
        redirect('selfservices/my_offsets');
        return;
      }
    }
    redirect('selfservices/my_offsets');
  }

  function get_offset_status($id)
  {
    $data['OFFSET']             = $this->selfservices_model->GET_OFFSET_STATUS($id);
    $data['DATE_FORMAT']        = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $offset                  = $this->selfservices_model->GET_ROW_DATA('tbl_attendance_offsets', $id);

    $data['C_APPROVERS']    = array();

    if ($offset->approver5 || $offset->approver5_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver5, $offset->approver5_date, $offset->status, 'Pending 5');
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver5_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_5);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver4 || $offset->approver4_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver4, $offset->approver4_date, $offset->status, 'Pending 4', $offset->approver5_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver4_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_4);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver3 || $offset->approver3_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver3, $offset->approver3_date, $offset->status, 'Pending 3', $offset->approver4_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver3_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_3);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver2 || $offset->approver2_b) {
      // $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($leave->approver2, $leave->approver2_date, $leave->status, 'Pending 2', $leave->approver3_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver2, $offset->approver2_date, $offset->status, 'Pending 2', $offset->approver3_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver2_b);

      if ($offset->approved_by_2 !== null) {
        $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_2);
      } else {
        $obj3 = (object) ['approvedby' => ''];
      }

      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver1 || $offset->approver1_b) {
      // $data['C_APPROVERS'][] = $this->selfservices_model->GET_APPROVER_DATA($leave->approver1, $leave->approver1_date, $leave->status, 'Pending 1', $leave->approver2_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver1, $offset->approver1_date, $offset->status, 'Pending 1', $offset->approver2_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver1_b);

      if ($offset->approved_by_1 !== null) {
        $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_1);
      } else {
        $obj3 = (object) ['approvedby' => ''];
      }

      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    // echo '<pre>';
    // var_dump($data['OFFSET']);
    // return;
    $this->load->view('modules/partials/_offset_modal_content', $data);
  }

  function filter_data_array($arr_data, $db_data)
  {
    foreach ($arr_data as $arr) {
      if ($arr->id == $db_data) {
        return $arr->name;
        break;
      }
    }
    return '';
  }
  //back
  function merge_object($obj_1, $obj_2, $obj_3)
  {
    $mergedObject = new stdClass();

    // Merge properties from $test into $mergedObject
    if ($obj_3) {
      foreach ($obj_3 as $key => $value) {
        $mergedObject->$key = $value;
      }
    }


    // Merge properties from $test2 into $mergedObject
    foreach ($obj_2 as $key => $value) {
      $mergedObject->$key = $value;
    }

    // Merge properties from $test into $mergedObject
    foreach ($obj_1 as $key => $value) {
      $mergedObject->$key = $value;
    }


    return  $mergedObject;
  }

  function get_leave_approval_status($id)
  {
    
    $empl_id = $this->session->userdata('SESS_USER_ID');
    
    
    $data['LEAVE']          = $this->selfservices_model->GET_LEAVE_APPROVAL_STATUS($id);
    $data['DATE_FORMAT']    = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $leave                  = $this->selfservices_model->GET_ROW_DATA('tbl_leaves_assign', $id);
    $data['C_APPROVERS']    = array();

    if ($leave->approver5 || $leave->approver5_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver5, $leave->approver5_date, $leave->status, 'Pending 5');
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver5_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_5);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver4 || $leave->approver4_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver4, $leave->approver4_date, $leave->status, 'Pending 4', $leave->approver5_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver4_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_4);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver3 || $leave->approver3_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver3, $leave->approver3_date, $leave->status, 'Pending 3', $leave->approver4_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver3_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_3);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver2 || $leave->approver2_b) {
      // $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($leave->approver2, $leave->approver2_date, $leave->status, 'Pending 2', $leave->approver3_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver2, $leave->approver2_date, $leave->status, 'Pending 2', $leave->approver3_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver2_b);

      if ($leave->approved_by_2 !== null) {
        $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_2);
      } else {
        $obj3 = (object) ['approvedby' => ''];
      }

      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver1 || $leave->approver1_b) {
      // $data['C_APPROVERS'][] = $this->selfservices_model->GET_APPROVER_DATA($leave->approver1, $leave->approver1_date, $leave->status, 'Pending 1', $leave->approver2_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver1, $leave->approver1_date, $leave->status, 'Pending 1', $leave->approver2_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver1_b);

      if ($leave->approved_by_1 !== null) {
        $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_1);
      } else {
        $obj3 = (object) ['approvedby' => ''];
      }

      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }


    $data['tableData']      = $tableData = $this->selfservices_model->GET_LEAVE_APPROVAL_TABLE_DATA($id);
    $data['hours']          = $this->selfservices_model->GET_LEAVE_APPROVAL_HOURS($id);
    $count = 0;
    foreach ($tableData as $row) {
      if ($row->duration > 4) {
        $count += 1;
      } elseif ($row->duration == 4) {
        $count += .5;
      }
    }
    $data['days']           = $count;
    // $data['days']           = count($data['tableData']);

    // echo '<pre>';
    // var_dump($data['C_APPROVERS']);
    // return;
    $data['user_access'] = $this->selfservices_model->get_user_access($empl_id);
    
    $this->load->view('modules/partials/_my_leave_approval_modal_content', $data);
  }

  function get_exemptut_status($id)
  {
    $data['LEAVE']          = $this->selfservices_model->GET_EXEMPT_UNDERTIME_APPROVAL_STATUS($id);
    $data['DATE_FORMAT']    = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $leave                  = $this->selfservices_model->GET_ROW_DATA('tbl_attendance_undertimerequest', $id);
    $data['C_APPROVERS']    = array();
    
    if ($leave->approver5 || $leave->approver5_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver5, $leave->approver5_date, $leave->status, 'Pending 5');
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver5_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_5);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver4 || $leave->approver4_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver4, $leave->approver4_date, $leave->status, 'Pending 4', $leave->approver5_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver4_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_4);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver3 || $leave->approver3_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver3, $leave->approver3_date, $leave->status, 'Pending 3', $leave->approver4_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver3_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_3);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver2 || $leave->approver2_b) {
      // $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($leave->approver2, $leave->approver2_date, $leave->status, 'Pending 2', $leave->approver3_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver2, $leave->approver2_date, $leave->status, 'Pending 2', $leave->approver3_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver2_b);

      if ($leave->approved_by_2 !== null) {
        $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_2);
      } else {
        $obj3 = (object) ['approvedby' => ''];
      }

      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver1 || $leave->approver1_b) {
      // $data['C_APPROVERS'][] = $this->selfservices_model->GET_APPROVER_DATA($leave->approver1, $leave->approver1_date, $leave->status, 'Pending 1', $leave->approver2_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver1, $leave->approver1_date, $leave->status, 'Pending 1', $leave->approver2_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver1_b);

      if ($leave->approved_by_1 !== null) {
        $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_1);
      } else {
        $obj3 = (object) ['approvedby' => ''];
      }

      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }


    // $data['tableData']      = $tableData = $this->selfservices_model->GET_LEAVE_APPROVAL_TABLE_DATA($id);
    // $data['hours']          = $this->selfservices_model->GET_LEAVE_APPROVAL_HOURS($id);
    // $count = 0;
    // foreach ($tableData as $row) {
    //   if ($row->duration > 4) {
    //     $count += 1;
    //   } elseif ($row->duration == 4) {
    //     $count += .5;
    //   }
    // }
    // $data['days']           = $count;
    // $data['days']           = count($data['tableData']);

    // echo '<pre>';
    // var_dump($data['C_APPROVERS']);
    // return;
    $this->load->view('modules/partials/_my_exemptut_approval_modal_content', $data);
  }

  function get_leave_approval($id)
  {
    $data['userId']     = $empl_id = $this->session->userdata('SESS_USER_ID');
    $data['LEAVE'] = $this->selfservices_model->GET_LEAVE_APPROVAL_STATUS($id);
    $leave                  = $this->selfservices_model->GET_ROW_DATA('tbl_leaves_assign', $id);
    $data['C_APPROVERS']    = array();


    // if ($leave->approver5) {
    //   $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($leave->approver5, $leave->approver5_date, $leave->status, 'Pending 5');
    // }
    // if ($leave->approver4) {
    //   $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($leave->approver4, $leave->approver4_date, $leave->status, 'Pending 4', $leave->approver5_date);
    // }
    // if ($leave->approver3) {
    //   $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($leave->approver3, $leave->approver3_date, $leave->status, 'Pending 3', $leave->approver4_date);
    // }
    // if ($leave->approver2) {
    //   $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($leave->approver2, $leave->approver2_date, $leave->status, 'Pending 2', $leave->approver3_date);
    // }
    // if ($leave->approver1) {
    //   $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($leave->approver1, $leave->approver1_date, $leave->status, 'Pending 1', $leave->approver2_date);
    // }

    if ($leave->approver5 || $leave->approver5_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver5, $leave->approver5_date, $leave->status, 'Pending 5');
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver5_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_5);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver4 || $leave->approver4_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver4, $leave->approver4_date, $leave->status, 'Pending 4', $leave->approver5_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver4_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_4);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver3 || $leave->approver3_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver3, $leave->approver3_date, $leave->status, 'Pending 3', $leave->approver4_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver3_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_3);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver2 || $leave->approver2_b) {
      // $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($leave->approver2, $leave->approver2_date, $leave->status, 'Pending 2', $leave->approver3_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver2, $leave->approver2_date, $leave->status, 'Pending 2', $leave->approver3_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver2_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_2);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver1 || $leave->approver1_b) {
      // $data['C_APPROVERS'][] = $this->selfservices_model->GET_APPROVER_DATA($leave->approver1, $leave->approver1_date, $leave->status, 'Pending 1', $leave->approver2_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver1, $leave->approver1_date, $leave->status, 'Pending 1', $leave->approver2_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver1_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_1);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }

    $data['btn_status'] = '';
    if ($leave->status == 'Approved' || $leave->status == 'Rejected') {
      $data['btn_status'] = 'disabled';
    }
    if (($leave->approver1 || $leave->approver1_b) && !$leave->approved_by_1 && ($leave->approver2 == $empl_id || $leave->approver2_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }
    if (($leave->approved_by_1 == $empl_id) && ($leave->approver1 == $empl_id || $leave->approver1_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }

    $data['tableData'] = $this->selfservices_model->GET_LEAVE_APPROVAL_TABLE_DATA($id);
    $data['hours'] = $this->selfservices_model->GET_LEAVE_APPROVAL_HOURS($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $data['days'] = count($data['tableData']);
    $data['row_data']   = $leave;

    // echo '<pre>';
    // var_dump($data['row_data']->approver1);
    // return;
    $this->load->view('modules/partials/_leave_approval_modal_content', $data);
  }

  function get_shift_approval($id)
  {
    $data['data'] = $this->selfservices_model->GET_SHIFT_APPROVAL($id);
    // echo '<pre>';
    // print_r($data['LEAVE']); die();
    $data2                  = $this->selfservices_model->GET_ROW_DATA('tbl_attendance_shiftassign', $id);
    // echo '<pre>';
    // print_r($data2->approver2_date); die();
    $data['C_APPROVERS']    = array();
    if ($data2->approver5) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($data2->approver5, $data2->approver5_date, $data2->status, 'Pending 5');
    }
    if ($data2->approver4) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($data2->approver4, $data2->approver4_date, $data2->status, 'Pending 4', $data2->approver5_date);
    }
    if ($data2->approver3) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($data2->approver3, $data2->approver3_date, $data2->status, 'Pending 3', $data2->approver4_date);
    }
    if ($data2->approver2) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($data2->approver2, $data2->approver2_date, $data2->status, 'Pending 2', $data2->approver3_date);
    }
    if ($data2->approver1) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($data2->approver1, $data2->approver1_date, $data2->status, 'Pending 1', $data2->approver2_date);
    }
    // $data['tableData'] = $this->selfservices_model->GET_LEAVE_APPROVAL_TABLE_DATA($id);
    // $data['hours'] = $this->selfservices_model->GET_LEAVE_APPROVAL_HOURS($id);
    // $data['days'] = count($data['tableData']);
    $data['row_data']   = $data2;
    $data['userId']     = $this->session->userdata('SESS_USER_ID');
    // echo '<pre>';
    // var_dump($data['row_data']->approver1);
    // return;
    $this->load->view('modules/partials/_shif_approval_modal_content', $data);
  }

  function get_offset_approval_status()
  {
    $data['OFFSET']          = $this->selfservices_model->GET_OFFSET_APPROVAL_STATUS($id);
    $data['DATE_FORMAT']    = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $leave                  = $this->selfservices_model->GET_ROW_DATA('tbl_attendance_offsets', $id);
    $data['C_APPROVERS']    = array();

    if ($leave->approver5 || $leave->approver5_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver5, $leave->approver5_date, $leave->status, 'Pending 5');
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver5_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_5);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver4 || $leave->approver4_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver4, $leave->approver4_date, $leave->status, 'Pending 4', $leave->approver5_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver4_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_4);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver3 || $leave->approver3_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver3, $leave->approver3_date, $leave->status, 'Pending 3', $leave->approver4_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver3_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_3);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver2 || $leave->approver2_b) {
      // $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($leave->approver2, $leave->approver2_date, $leave->status, 'Pending 2', $leave->approver3_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver2, $leave->approver2_date, $leave->status, 'Pending 2', $leave->approver3_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver2_b);

      if ($leave->approved_by_2 !== null) {
        $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_2);
      } else {
        $obj3 = (object) ['approvedby' => ''];
      }

      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($leave->approver1 || $leave->approver1_b) {
      // $data['C_APPROVERS'][] = $this->selfservices_model->GET_APPROVER_DATA($leave->approver1, $leave->approver1_date, $leave->status, 'Pending 1', $leave->approver2_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($leave->approver1, $leave->approver1_date, $leave->status, 'Pending 1', $leave->approver2_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($leave->approver1_b);

      if ($leave->approved_by_1 !== null) {
        $obj3 = $this->selfservices_model->GET_APPROVED_BY($leave->approved_by_1);
      } else {
        $obj3 = (object) ['approvedby' => ''];
      }

      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }

    // $data['tableData']      = $this->selfservices_model->GET_LEAVE_APPROVAL_TABLE_DATA($id);
    // $data['hours']          = $this->selfservices_model->GET_LEAVE_APPROVAL_HOURS($id);
    // $data['days']           = count($data['tableData']);
    // echo '<pre>';
    // var_dump($data['C_APPROVERS']);
    // return;
    $this->load->view('modules/partials/_offset_modal_content', $data);
  }

  function get_offset_approval($id)
  {

    $data['OFFSETS']     = $this->selfservices_model->GET_OFFSET_APPROVAL_STATUS($id);

    $data['userId']     = $empl_id = $this->session->userdata('SESS_USER_ID');
    // $data['LEAVE'] = $this->selfservices_model->GET_LEAVE_APPROVAL_STATUS($id);
    $offset                  = $this->selfservices_model->GET_ROW_DATA('tbl_attendance_offsets', $id);
    $data['C_APPROVERS']    = array();

    if ($offset->approver5 || $offset->approver5_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver5, $offset->approver5_date, $offset->status, 'Pending 5');
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver5_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_5);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver4 || $offset->approver4_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver4, $offset->approver4_date, $offset->status, 'Pending 4', $offset->approver5_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver4_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_4);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver3 || $offset->approver3_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver3, $offset->approver3_date, $offset->status, 'Pending 3', $offset->approver4_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver3_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_3);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver2 || $offset->approver2_b) {
      // $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($offset->approver2, $offset->approver2_date, $offset->status, 'Pending 2', $offset->approver3_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver2, $offset->approver2_date, $offset->status, 'Pending 2', $offset->approver3_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver2_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_2);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver1 || $offset->approver1_b) {
      // $data['C_APPROVERS'][] = $this->selfservices_model->GET_APPROVER_DATA($offset->approver1, $offset->approver1_date, $offset->status, 'Pending 1', $offset->approver2_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver1, $offset->approver1_date, $offset->status, 'Pending 1', $offset->approver2_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver1_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_1);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }

    $data['btn_status'] = '';
    if ($offset->status == 'Approved' || $offset->status == 'Rejected') {
      $data['btn_status'] = 'disabled';
    }
    if (($offset->approver1 || $offset->approver1_b) && !$offset->approved_by_1 && ($offset->approver2 == $empl_id || $offset->approver2_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }
    if (($offset->approved_by_1 == $empl_id) && ($offset->approver1 == $empl_id || $offset->approver1_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }

    $data['tableData'] = $this->selfservices_model->GET_OFFSET_APPROVAL_TABLE_DATA($id);
    $data['hours'] = $this->selfservices_model->GET_LEAVE_APPROVAL_HOURS($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $data['days'] = count($data['tableData']);
    $data['row_data']   = $offset;


    $this->load->view('modules/partials/_offset_approval_modal_content', $data);
  }

  function get_request_leave_by_date()
  {
    $rawData = file_get_contents('php://input');
    $jsonData = parseJsonData($rawData);
    $leaveDate = $jsonData['leave_date'];
    $empl_id = $this->session->userdata('SESS_USER_ID');
    $type = $jsonData['type'];
    $year = substr($leaveDate, 0, 4);
    $dateStart = date("Y-m-d", strtotime($year . "-01-01"));
    $dateEnd = date("Y-m-d", strtotime($year . "-12-31"));
    $leavesTotal =  $this->selfservices_model->get_leaves_total($empl_id, $type, $dateStart, $dateEnd);
    $leaveEntitlementValue = 0;
    $leaveEntitlement = 'Auto';

    $display_attachment = $this->selfservices_model->SHOW_HIDE_ATTACHMENT($type);
    $display_reason = $this->selfservices_model->SHOW_HIDE_REASON($type);

    if (!$leaveDate) {
      echo json_encode(['messageError' => false, 'error' => 'Invalid date received', 'data' => $jsonData,]);
      return;
    }

    $typeName = $jsonData['typeName'];
    if ($typeName == "Offset") {
      $leaveEntitlement =  $this->selfservices_model->get_offset_approve_count($empl_id);
      // $leaveEntitlement = array('value' => 10);
      if (!$leaveEntitlement) {
        $leaveEntitlementValue = 0;
        // ob_start();
        // echo json_encode(['messageError' => '0', 'data' => $jsonData, 'leaveEntitlement ' => $leaveEntitlement]);
        // ob_end_flush();
        // return;
      } else {
        $leaveEntitlementValue = $leaveEntitlement['value'];
      }

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
      $display_credit = 0;
      if (
        $typeName == 'Service Incentive Leave (SIL)' || $typeName == 'Vacation Leave' || $typeName == 'Sick Leave' || $typeName == 'Bereavement Leave'
        || $typeName == 'Maternity Leave' || $typeName == 'Paternity Leave' || $typeName == 'Solo-Parent Leave' || $typeName == 'Marriage Leave' || $typeName == 'Wedding Leave'
        || $typeName == 'Emergency Leave'
      ) {
        $display_credit = $this->selfservices_model->SHOW_HIDE_CREDITS($type);
      } else {
        $display_credit = $this->selfservices_model->SHOW_HIDE_CREDITS_OTHERS($type);
      }
      $leaveSetting =  $this->selfservices_model->GET_SETUP_SETTING('leave_setting');
      if ($leaveSetting) {
        $leaveEntitlementValue =  $this->selfservices_model->GET_SETUP_LEAVE_SETTING(str_replace(' ', '_', $typeName));
        if (!$leaveEntitlementValue) {
          $leaveEntitlementValue = 0;
        }
      } else {
        $leaveEntitlement =  $this->selfservices_model->get_leave_entitlement_by_id_typeName_year($empl_id, $typeName, $year);
        if (!$leaveEntitlement) {
          $leaveEntitlementValue = 0;
        } else {
          $leaveEntitlementValue = $leaveEntitlement['value'];
        }
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
  function request_leave()
  {
    $userId                                           = $this->session->userdata('SESS_USER_ID');
    $data['EMPLOYEES']                                = $this->selfservices_model->GET_EMPOLOYEES();
    // $data['LEAVE_TYPES']                              = $this->selfservices_model->GET_ALL_LEAVETYPES2();
    $data['LEAVE_TYPES']                              = $this->selfservices_model->GET_LEAVE_TYPES_ACTIVE();
    // $data['isLeaveHours']                             = $this->selfservices_model->get_leaves_settings_by_setting('isLeaveHours','1');

    // $currentYear = date("Y");
    // $data['C_LEAVE_ENTITLEMENT_VACATION']               = $this->selfservices_model->REMAINING_VACATION_HOURS($userId, $currentYear) - $this->selfservices_model->USED_VACATION_HOURS($userId, $currentYear);
    // $data['C_LEAVE_ENTITLEMENT_SICK']                   = $this->selfservices_model->REMAINING_SICK_HOURS($userId, $currentYear) - $this->selfservices_model->USED_SICK_HOURS($userId, $currentYear);

    $data['isLeaveHours']                             = $this->selfservices_model->get_leaves_settings_by_setting('isLeaveHours', '1');

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/request_leave_views', $data);
  }

  function add_my_leaves_api()
  {
    $empl_id                                          = $user_id = $this->session->userdata('SESS_USER_ID');
    $input_data                                       = $this->input->post();

    $display_reason                                   = 0;
    $display_attachment                               = 0;
    $type                                             = $this->input->post('type');
    $reason                                             = $this->input->post('reason');
    $typeName                                         = $this->selfservices_model->get_leave_type_name_by_id($type);
    $token['type']                                    = 'approval';
    $token['table']                                   = 'tbl_leaves_assign';
    $token['expiration']                              = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));
    

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
    if (!$reason && !($display_reason != 1)) {
      echo json_encode(array('messageError' =>  'Reason is required.'));
      return;
    }
    if (!$input_data['attachment'] && $display_attachment == 1) {
      echo json_encode(array('messageError' => 'Attachment is required.'));
      return;
    }

    $messageError = '';
    $input_data['empl_id'] = $user_id;
    // echo json_encode(array('messageError' => "Type: ".$input_data['type']));
    // return;
    $dates = $this->input->post('dates');
    $hours = $this->input->post('hours');
    $leave_range = $this->input->post('leave_range');
    $current_shift = $this->input->post('current_shift');

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

      // Today minus 2 days
      $min_allowed_date = date('Y-m-d', strtotime('-2 days'));

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
      $totalHours = $totalHours + $hours[$i];
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
    $display_credit = 0;
    if (
      $typeName == 'Service Incentive Leave (SIL)' || $typeName == 'Vacation Leave' || $typeName == 'Sick Leave' || $typeName == 'Bereavement Leave'
      || $typeName == 'Maternity Leave' || $typeName == 'Paternity Leave' || $typeName == 'Solo-Parent Leave' || $typeName == 'Marriage Leave' || $typeName == 'Wedding Leave'
      || $typeName == 'Emergency Leave'
    ) {
      $display_credit = $this->selfservices_model->SHOW_HIDE_CREDITS($type);
    } else {
      $display_credit = $this->selfservices_model->SHOW_HIDE_CREDITS_OTHERS();
    }

    if ($typeName == "Offset") {
      $leaveEntitlement =  $this->selfservices_model->get_offset_approve_count($empl_id);
      if ($leaveEntitlement) {
        $leaveEntitlementValue = $leaveEntitlement['value'];
      }
      $balance = $leaveEntitlementValue - $leavesTotal;
      if (!($balance >= $totalHours)) {
        $projectedHours = $balance - $totalHours;
        echo json_encode(array('messageError' => "Insufficient Balance. Your balance is: " . $balance . " and your total hours applying is: " . $totalHours . " which equal to " . $projectedHours . " projected hours"));
        return;
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
        } else {
          $leaveEntitlementValue = $leaveEntitlement['value'];
        }
      }
      $balance = $leaveEntitlementValue - $leavesTotal;
      if (!($balance >= $totalHours)) {
        $projectedHours = $balance - $totalHours;
        echo json_encode(array('messageError' => "Insufficient Balance. Your balance is: " . $balance . " and your total hours applying is: " . $totalHours . " which equal to " . $projectedHours . " projected hours"));
        return;
      }
    }

    if (!empty($messageError)) {
      echo json_encode(array('messageError' => $messageError . ' . Please fix and try again'));
      return;
    }
    $input_data['create_date']  = date('Y-m-d H:i:s');
    $input_data['edit_date']    = date('Y-m-d H:i:s');

    $enable_nurseapproval = $this->selfservices_model->get_leave_setting2('nurse_approver'); // 1
    if ($input_data['type'] == '5') {
      if ($enable_nurseapproval) {
        $input_data['status']       = 'Nurse';
      } else {
        $input_data['status']       = 'Pending 1';
      }
    } else {
      $input_data['status']       = 'Pending 1';
    }

    $input_data['assigned_by']  = $user_id;
    $input_data['parent_id']    = null;
    $approvers = $this->selfservices_model->GET_USER_APPROVERS($user_id, 'tbl_approvers');
    $is_auto_approve  = $this->selfservices_model->GET_LEAVE_SETTING('policy_autoapprove');
    $autoApprovedEnabled  = $this->selfservices_model->getApprovalAutoApproveEnabled($input_data['empl_id']);

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
    $isLeaveHours = $this->selfservices_model->get_leaves_settings_by_setting('isLeaveHours', '1');

    $dateCount = count($dates);
    $parent_id = 0;
    for ($i = 0; $i < $dateCount; $i++) {
      if ($dateCount > 1 && $i == 0) {
        $input_data['parent_id'] = 0;
      }
      $input_data['leave_date']     = $dates[$i];

      if ($isLeaveHours == 1) {
        $input_data['duration']       = $hours[$i];
      }

      if ($isLeaveHours == 0) {
        $input_data['duration']       = $hours[$i] * 8;
      }

      $input_data['leave_range']    = $leave_range[$i];
      $input_data['current_shift']  = $current_shift[$i];

      if ($input_data['status'] != 'Nurse') {
        $input_data['approver1']      = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
        $input_data['approver2']      = $approvers && $approvers->approver_2a ? $approvers->approver_2a : 0;
        $input_data['approver3']      = $approvers && $approvers->approver_3a ? $approvers->approver_3a : 0;
        $input_data['approver4']      = $approvers && $approvers->approver_4a ? $approvers->approver_4a : 0;
        $input_data['approver5']      = $approvers && $approvers->approver_5a ? $approvers->approver_5a : 0;

        $input_data['approver1_b'] = $approvers || $approvers->approver_1b ? $approvers->approver_1b : 0;
        $input_data['approver2_b'] = $approvers || $approvers->approver_2b ? $approvers->approver_2b : 0;
        $input_data['approver3_b'] = $approvers || $approvers->approver_3b ? $approvers->approver_3b : 0;
        $input_data['approver4_b'] = $approvers || $approvers->approver_4b ? $approvers->approver_4b : 0;
        $input_data['approver5_b'] = $approvers || $approvers->approver_5b ? $approvers->approver_5b : 0;
      }



      $res = $this->selfservices_model->ADD_LEAVE_REQUEST($input_data);
      if ($res) {
        if ($input_data['status'] != 'Nurse' && $input_data['status'] != 'Approved' && ($input_data['parent_id'] == null || $input_data['parent_id'] == 0)) {

          $this->create_notification = function ($approver, $res, $input_data) {
            $requestor = $this->selfservices_model->GET_REQUESTOR('leave', $res);
            $description = "Leave Application Review for [LEA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";

            $token = array(
              'approver' => $approver,
              'approver_id' => $approver,
              'approver_date_col' => $approver . '_date',
              'id' => $res
            );

            $json_token = json_encode($token);
            $encrypted_token = $this->technos_encryption->encryptData($json_token);
            $notif_data = array(
              'create_date' => date('Y-m-d H:i:s'),
              'empl_id' => $approver,
              'type' => 'leave_approval',
              'content_id' => $res,
              'location' => 'selfservices/leave_approval',
              'description' => $description,
              'approve' => 'approvals/approve_request?token=' . urlencode($encrypted_token),
              'reject' => 'approvals/reject_request?token=' . urlencode($encrypted_token)
            );

            $this->selfservices_model->ADD_NOTIFICATION($notif_data);
          };

          $approvers_list = array(
            $input_data['approver1'],
            $input_data['approver2'],
            $input_data['approver3'],
            $input_data['approver4'],
            $input_data['approver5'],
            $input_data['approver1_b'],
            $input_data['approver2_b'],
            $input_data['approver3_b'],
            $input_data['approver4_b'],
            $input_data['approver5_b']
          );

          foreach ($approvers_list as $approver) {
            if ($approver) {
              call_user_func($this->create_notification, $approver, $res, $input_data);
            }
          }
        }

        // $input_data['parent_id' ] = $res;

        if ($parent_id == 0) {
          $parent_id = $res;
        }

        $input_data['parent_id'] = $parent_id;
      } else if ($input_data['duration'] <= 0) {
        $messageError = 'Invalid duration for date ' . $input_data['leave_date'];
        echo json_encode(array('messageError' => $messageError . '. Please fix and try again'));
        return;
      } else {
        if (empty($messageError)) {
          $messageError = 'Failed to date/s: ' . $dates[$i];
        } else {
          $messageError = $messageError . ', ' . $dates[$i];
        }
      }
    }
    // echo json_encode($input_data);
    if (!empty($messageError)) {
      echo json_encode(array('messageError' => $messageError . ' . Please reload page and try again'));
      return;
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed leave request');
    $this->session->set_flashdata('SUCC', 'Successfully Added');
    echo json_encode(array('messageSuccess' => 'Successfully Submitted'));
  }

  function add_leave_request()
  {
    $user_id                            = $this->session->userdata('SESS_USER_ID');
    // $attachment                         = $_FILES['attachment']['name'];
    $input_data                         = $this->input->post();

    // echo '<pre>';
    // var_dump($input_data);
    // return;
    // $file_info = pathinfo($attachment);
    $input_data['create_date']                          = date('Y-m-d H:i:s');
    $input_data['edit_date']                            = date('Y-m-d H:i:s');
    $input_data['status']                               = 'Pending 1';
    $input_data['empl_id']                              = $user_id;
    $input_data['assigned_by']                          = $user_id;

    $employee                                           = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approvers                                          = $this->selfservices_model->GET_USER_APPROVERS($user_id, 'tbl_approvers');
    $is_auto_approve                                    = $this->selfservices_model->GET_LEAVE_SETTING('policy_autoapprove');
    // $approver = $approvers->approver_1a ? $approvers->approver_1a : 0;
    // if($this->isApproversEnable==1){
    //     if ($approver == 0) {
    //       $this->session->set_flashdata('ERR', 'You dont have an approver');
    //       redirect('selfservices/my_leaves');
    //       return;
    //     }   
    // }

    $dates = $this->input->post('dates');
    $hours = $this->input->post('hours');
    $leave_range = $this->input->post('leave_range');

    unset($input_data['dates']);
    unset($input_data['hours']);
    unset($input_data['leave_range']);
    if (($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0) || $is_auto_approve->value == 1) {
      $input_data['status'] = 'Approved';
    }
    // echo $input_data['status'];
    // var_dump($input_data);
    // return;
    if (!empty($dates) && !empty($hours) && count($dates) == count($hours)) {
      // echo 'here';
      $added = [];
      $notAdded = [];
      for ($i = 0; $i < count($dates); $i++) {
        $input_data['leave_date']   = $dates[$i];
        $input_data['duration']  = $hours[$i];
        $input_data['leave_range']  = $leave_range[$i];
        $is_duplicate = $this->selfservices_model->GET_IS_DUPLICATE_DATE_EMPL_ID($input_data['leave_date'], $input_data['empl_id']);
        if ($is_duplicate > 0) {
          $notAdded[] = 'Date: ' . $dates[$i] . '(Duplicate)';
          continue;
        }

        $res  = $this->selfservices_model->ADD_LEAVE_REQUEST($input_data);
        if ($res && $input_data['status'] != 'Approved') {
          $requestor      = $this->selfservices_model->GET_REQUESTOR('leave', $res);
          $description    = "Leave Application Review for [LEA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
          $notif_data     = array(
            'create_date' => date('Y-m-d H:i:s'),
            'empl_id' => $approvers->approver_1a,
            'type' => 'leave',
            'content_id' => $res,
            'location' => 'selfservices/leave_approval',
            'description' => $description
          );
          $notif = $this->selfservices_model->ADD_NOTIFICATION($notif_data);
        }
        if ($res) {
          $added[] = 'Date: ' . $dates[$i];
        } else {
          $notAdded[] = 'Date: ' . $dates[$i];
        }
      }

      $joinedAdded = '';
      $joinedNotAdded = '';
      if (count($added) > 0 && count($notAdded) < 1) {
        $joinedAdded = implode(', ', $added);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed leave request');
        $this->session->set_flashdata('SUCC', 'Successfully added: ' . $joinedAdded);
        redirect('selfservices/my_leaves');
      } else {
        $joinedNotAdded = implode(', ', $notAdded);
        $joinedAdded = implode(', ', $added);
        if ($joinedAdded) {
          $this->session->set_flashdata('ERR', 'Successfully added: ' . $joinedAdded . '. But failed to add: ' . $joinedNotAdded);
        } else {
          $this->session->set_flashdata('ERR', 'Unable to add: ' . $joinedNotAdded);
        }
        redirect('selfservices/request_leave');
      }
    } else {
      $this->session->set_flashdata('ERR', 'Unable to add: No Dates Submitted');
      redirect('selfservices/request_leave');
    }
    redirect('selfservices/my_leaves');
  }

  function my_reimbursement()
  {
    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);

    $data['STATUS']                                  = $status;
    $data['STATUSES']                                = array('Pending', 'Approved', 'Rejected', 'Withdrawed');
    $data['TABLE_DATA']                              = $this->selfservices_model->get_reimbursement($limit, $offset, $userId, $status);
    $total_count                                     = $this->selfservices_model->get_reimbursement_count($limit, $offset, $userId, $status);
    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_reimbursement_views', $data);
  }

  function my_cashadvance()
  {
    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);

    $data['STATUS']                                  = $status;
    $data['STATUSES']                                = array('Pending', 'Approved', 'Rejected', 'Withdrawed');
    $data['TABLE_DATA']                              = $this->selfservices_model->get_cashadvance($limit, $offset, $userId, $status);
    $total_count                                     = $this->selfservices_model->get_cashadvance_count($limit, $offset, $userId, $status);
    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_cashadvance_views', $data);
  }

  function add_reimbursement_form()
  {
    $user_id                            = $this->session->userdata('SESS_USER_ID');
    $input_data                         = $this->input->post();
    $input_data['empl_id']          = $user_id;
    $input_data['status']           = "Pending";
    $input_data['edit_user']        = $user_id;
    $input_data['requested_by']       = $user_id;
    $input_data['create_date']                        = date('Y-m-d H:i:s');
    $input_data['edit_date']                          = date('Y-m-d H:i:s');

    // unset($input_data['dates']);
    $table = 'tbl_benefits_reimbursement';
    $res  = $this->selfservices_model->add_table_data($table, $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('selfservices/my_reimbursement');
    } else {
      $this->session->set_flashdata('ERR', 'Unable to add');
      redirect('selfservices/add_reimbursement');
    }
  }

  function add_cashadvance_action()
  {
    $user_id                            = $this->session->userdata('SESS_USER_ID');
    $input_data                         = $this->input->post();
    $input_data['empl_id']          = $user_id;
    $input_data['status']           = "Pending";
    $input_data['edit_user']        = $user_id;
    $input_data['requested_by']       = $user_id;
    $input_data['create_date']                        = date('Y-m-d H:i:s');
    $input_data['edit_date']                          = date('Y-m-d H:i:s');

    // unset($input_data['dates']);
    $table = 'tbl_benefits_cashadvance';
    $res  = $this->selfservices_model->add_table_data($table, $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('selfservices/my_cashadvance');
    } else {
      $this->session->set_flashdata('ERR', 'Unable to add');
      redirect('selfservices/add_cashadvance');
    }
  }


  function add_reimbursement()
  {
    $data['EMPLOYEES']                          = $this->selfservices_model->GET_EMPLOYEES();
    $data['types']                          = $this->selfservices_model->get_reimbursement_types();
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/add_reimbursement_views', $data);
  }

  function add_cashadvance()
  {
    $data['EMPLOYEES']                          = $this->selfservices_model->GET_EMPLOYEES();
    $data['types']                          = $this->selfservices_model->get_cashadvance_types();
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/add_cashadvance_views', $data);
  }

  function edit_reimbursement_form()
  {
    $user_id                            = $this->session->userdata('SESS_USER_ID');
    $input_data                         = $this->input->post();
    $input_data['edit_user']          = $user_id;
    $input_data['create_date']                        = date('Y-m-d H:i:s');
    $input_data['edit_date']                          = date('Y-m-d H:i:s');

    $id = $input_data['id'];
    unset($input_data['id']);
    $table = 'tbl_benefits_reimbursement';
    $res  = $this->selfservices_model->update_table_data($table, $input_data, $id);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Edited reimbursement');
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('benefits/reimbursement');
    } else {
      $this->session->set_flashdata('ERR', 'Unable to add');
      redirect('benefits/add_reimbursement');
    }
  }
  function approval_reimbursement($id)
  {
    $data['reimbursement']                        = $this->selfservices_model->get_reimbursement_id_approval($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/approval_reimbursement_views', $data);
  }

  function approval_cashadvance($id)
  {
    $data['data']                           = $this->selfservices_model->get_cashadvance_id_approval($id);
    $data['DATE_FORMAT']                     = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/approval_cashadvance_views', $data);
  }

  function reimbursement_approval_action()
  {
    $user_id                            = $this->session->userdata('SESS_USER_ID');
    $input_data['remarks']   = $this->input->post('remarks');
    $input_data['status'] = "Withdrawed";
    $input_data['edit_user']          = $user_id;
    $input_data['edit_date']                          = date('Y-m-d H:i:s');
    $input_data['approver']          = $user_id;
    $input_data['approver_date']                          = date('Y-m-d H:i:s');

    $id = $this->input->post('id');
    $table = 'tbl_benefits_reimbursement';
    $res  = $this->selfservices_model->update_table_data($table, $input_data, $id);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved reimbursement');
      $this->session->set_flashdata('SUCC', 'Successfully updated');
      redirect('selfservices/my_reimbursement');
    } else {
      $this->session->set_flashdata('ERR', 'Update Failed');
      redirect('selfservices/approval_reimbursement');
    }
  }

  function cashadvance_approval_action()
  {
    $user_id                            = $this->session->userdata('SESS_USER_ID');
    $input_data['remarks']   = $this->input->post('remarks');
    $input_data['status'] = "Withdrawed";
    $input_data['edit_user']          = $user_id;
    $input_data['edit_date']                          = date('Y-m-d H:i:s');
    $input_data['approver']          = $user_id;
    $input_data['approver_date']                          = date('Y-m-d H:i:s');

    $id = $this->input->post('id');
    $table = 'tbl_benefits_cashadvance';
    $res  = $this->selfservices_model->update_table_data($table, $input_data, $id);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved cash advance');
      $this->session->set_flashdata('SUCC', 'Successfully updated');
      redirect('selfservices/my_cashadvance');
    } else {
      $this->session->set_flashdata('ERR', 'Update Failed');
      redirect('selfservices/approval_cashadvance');
    }
  }

  function edit_reimbursement($id)
  {
    $data['reimbursement']                        = $this->selfservices_model->get_reimbursement_id($id);
    // var_dump($data['reimbursement']); 
    // var_dump($data['reimbursement']['id'] ); 
    // var_dump($data['reimbursement'][0]); 
    // die();
    $data['EMPLOYEES']                          = $this->selfservices_model->GET_EMPLOYEES();
    $data['types']                          = $this->selfservices_model->get_reimbursement_types();
    $this->load->view('templates/header');
    $this->load->view('modules/benefits/edit_reimbursement_views', $data);
  }



  function my_overtimes()
  {
    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);

    $data['STATUS']                                  = $status;
    $data['STATUSES']                                = array('Pending', 'Approved', 'Rejected', 'Withdrawn');
    $data['TABLE_DATA']                              = $this->selfservices_model->GET_EMPL_OVERTIME($userId, $status, $limit, $offset);
    $total_count                                     = $this->selfservices_model->GET_EMPL_OVERTIME_COUNT($userId, $status);
    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
    $data['DATE_FORMAT']                             = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_overtime_views', $data);
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
    $this->load->view('modules/selfservices/exemptut_views', $data);
  }
  function request_exemptut()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $user_department                        = $this->selfservices_model->GET_USER_DEPARMENT($user_id);
    $data['SHIFTLIST']                      = $this->selfservices_model->GET_ALL_SHIFTS();
    $data['EMPLOYEES']                      = $this->selfservices_model->GET_EMPOLOYEES();
    $current_date                           = date('Y-m-d');
    $data['USER_DEPARTMENT']                = $user_department;
    $data['holiday_info']                   = $this->selfservices_model->MOD_DISP_HOLIDAY_BASED_DATE($current_date);
    $data['is_holiday']                     = !empty($data['holiday_info']);
    // var_dump($step_count);
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/request_exemptut_views', $data);
  }

  function exemptut_withdraw($id)
  {
    $this->selfservices_model->EXEMPT_UNDERTIME_WITHDRAW($id);
    $this->session->set_flashdata('SUCC', 'Exempt Undertime request has been Withdrawn!');
    redirect('selfservices/exemptut');
  }

  function exemptut_withdraw_admin($id)
  {
    $this->selfservices_model->EXEMPT_UNDERTIME_WITHDRAW($id);
    $this->session->set_flashdata('SUCC', 'Exempt Undertime request has been Withdrawn!');
    redirect('requests/exemptut');
  }

  function my_undetime()
  {
    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);

    $data['STATUS']                                  = $status;
    $data['STATUSES']                                = array('Pending', 'Approved', 'Rejected', 'Withdrawn');
    $data['TABLE_DATA']                              = $tablbe_data = $this->selfservices_model->GET_EMPL_UNDERTIME($userId, $status, $limit, $offset);

    // foreach ($tablbe_data as $row_shift) {
    //   $shift_result = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
    //   if ($shift_result) {
    //     $row_shift->request_shift = $shift_result->name;
    //   }
    // }

    $total_count                                     = $this->selfservices_model->GET_EMPL_UNDERTIME_COUNT($userId, $status);

    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
    $data['DATE_FORMAT']                             = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_undertime_views', $data);
  }

  function mychange_off()
  {
    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);
    $approved_changeoff_shift                        = $this->selfservices_model->GET_APPROVED_CHANGEOFF_SHIFT($userId);
    $data['STATUS']                                  = $status;
    $data['STATUSES']                                = array('Pending', 'Approved', 'Rejected', 'Withdrawed');
    $data['TABLE_DATA']                              = $tablbe_data = $this->selfservices_model->GET_EMPL_CHANGE_OFF($userId, $status, $limit, $offset);

    foreach ($tablbe_data as $row_shift) {
      $shift_result = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
      $shift_result_to = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift_to);

      if ($shift_result) {
        $row_shift->request_shift = $shift_result->name;
      }

      if ($shift_result_to) {
        $row_shift->request_shift_to = $shift_result_to->name;
      }
    }
         $current_date = date('Y-m-d');
    //------------------- GET APPROVED CHANGE OFF SHIFT  ---------------------------------- 
      foreach ($approved_changeoff_shift as $approved_changeoff_row) {
        if ($approved_changeoff_row->date_shift == $current_date) {
          $this->selfservices_model->UPDATE_CHANGESHIFT($approved_changeoff_row->empl_id, $approved_changeoff_row->date_shift, $approved_changeoff_row->request_shift);
          $this->selfservices_model->UPDATE_CHANGESHIFT($approved_changeoff_row->empl_id, $approved_changeoff_row->date_shift_to, $approved_changeoff_row->request_shift_to);
          
        }
      }


    $total_count                                     = $this->selfservices_model->GET_EMPL_CHANGEOFF_COUNT($userId, $status);

    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_change_off_views', $data);
  }

  function mychange_shift()
  { //aw
    $userId                                          = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                              = array();
    $status                                          = $this->input->get('status');
    $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                          =  $limit * ($page - 1);
    $approved_change_shift                           = $this->selfservices_model->GET_APPROVED_CHANGE_SHIFT($userId);
    $data['STATUS']                                  = $status;
    $data['STATUSES']                                = array('Pending', 'Approved', 'Rejected', 'Withdrawed');
    $data['TABLE_DATA']                              = $tablbe_data = $this->selfservices_model->GET_EMPL_CHANGESHIFT($userId, $status, $limit, $offset);

    foreach ($tablbe_data as $row_shift) {
      $shift_result = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE_SHIFT($row_shift->request_shift);
      if ($shift_result) {
        $row_shift->request_shift = $shift_result->name;
      }
    }
    $current_date = date('Y-m-d');
    //------------------- GET APPROVED CHANGE SHIFT  ---------------------------------- 
      foreach ($approved_change_shift as $approved_change_row) {
        if ($approved_change_row->date_shift == $current_date) {
          $this->selfservices_model->UPDATE_CHANGESHIFT($approved_change_row->empl_id, $approved_change_row->date_shift, $approved_change_row->request_shift);
        }
      }

    $total_count                                     = $this->selfservices_model->GET_EMPL_CHANGESHIFT_COUNT($userId, $status);

    $excess                                          = $total_count % $limit;
    $data['C_DATA_COUNT']                            = $total_count;
    $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                    = $page;
    $data['ROW']                                     = $limit;
    $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_changeshift_views', $data);
  }

  function request_myshift()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $user_department                        = $this->selfservices_model->GET_USER_DEPARMENT($user_id);
    $data['SHIFTLIST']                      = $this->selfservices_model->GET_ALL_SHIFTS();
    $data['EMPLOYEES']                      = $this->selfservices_model->GET_EMPOLOYEES();
    $current_date                           = date('Y-m-d');
    $data['USER_DEPARTMENT']                = $user_department;
    $data['holiday_info']                   = $this->selfservices_model->MOD_DISP_HOLIDAY_BASED_DATE($current_date);
    $data['is_holiday']                     = !empty($data['holiday_info']);
    // var_dump($step_count);
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/request_changeshift_views', $data);
  }

  function request_myoff()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $user_department                        = $this->selfservices_model->GET_USER_DEPARMENT($user_id);
    $data['SHIFTLIST']                      = $this->selfservices_model->GET_ALL_SHIFTS();
    $data['EMPLOYEES']                      = $this->selfservices_model->GET_EMPOLOYEES();
    $current_date                           = date('Y-m-d');
    $data['USER_DEPARTMENT']                = $user_department;
    $data['holiday_info']                   = $this->selfservices_model->MOD_DISP_HOLIDAY_BASED_DATE($current_date);
    $data['is_holiday']                     = !empty($data['holiday_info']);
    // var_dump($step_count);
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/request_changeoff_views', $data);
  }

  function request_my_undertime()
  {
    // $user_id                                = $this->session->userdata('SESS_USER_ID');
    // $user_department                        = $this->selfservices_model->GET_USER_DEPARMENT($user_id);
    $data['SHIFTLIST']                      = $this->selfservices_model->GET_ALL_SHIFTS();
    // $data['EMPLOYEES']                      = $this->selfservices_model->GET_EMPOLOYEES();
    // $current_date                           = date('Y-m-d');
    // $data['USER_DEPARTMENT']                = $user_department;
    // $data['holiday_info']                   = $this->selfservices_model->MOD_DISP_HOLIDAY_BASED_DATE($current_date);
    // $data['is_holiday']                     = !empty($data['holiday_info']);
    // var_dump($step_count);
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/request_undertime_views', $data);
  }

  function changeshift_withdraw($id)
  {
    $this->selfservices_model->CHANGESHIFT_WITHDRAW($id);
    $this->session->set_flashdata('SUCC', 'Change shift request has been Withdrawn!');
    redirect('selfservices/mychange_shift');
  }

  function changeoff_withdraw($id)
  {
    $this->selfservices_model->CHANGEOFF_WITHDRAW($id);
    $this->session->set_flashdata('SUCC', 'Change off request has been Withdrawn!');
    redirect('selfservices/mychange_off');
  }


  function undertime_withdraw($id)
  {
    $this->selfservices_model->UNDERTIME_WITHDRAW($id);
    $this->session->set_flashdata('SUCC', 'Undertime request has been Withdrawn!');
    redirect('selfservices/my_undetime');
  }


  function request_overtime()
  {
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $chk_breaktime                          = $this->selfservices_model->CHECK_SHIFT_BREAKTIME($user_id);
    // var_dump($chk_breaktime);

    $user_department                        = $this->selfservices_model->GET_USER_DEPARMENT($user_id);
    // $step_count                             =  $this->selfservices_model->GET_OVERTIME_STEP($user_department);
    // $data['STEP']                           = $step_count;
    $data['EMPLOYEES']                      = $this->selfservices_model->GET_EMPOLOYEES();
    $data['CHECK_BREAKTIME']                      = $chk_breaktime;
    $data['disable_overtime_hours']         = $this->selfservices_model->get_system_setup_by_setting2('disable_overtime_hours', '0');
    $current_date                           = date('Y-m-d');
    $data['USER_DEPARTMENT']                = $user_department;
    $data['holiday_info']                   = $this->selfservices_model->MOD_DISP_HOLIDAY_BASED_DATE($current_date);
    $data['is_holiday']                     = !empty($data['holiday_info']);
    // var_dump($step_count);
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/request_overtime_views', $data);
  }

  function get_department_min_hour()
  {
    $input_data = $this->input->post();
    $data = $this->overtimes_model->GET_DEPARTMENT_MIN_HOUR($input_data['empl']);
    echo json_encode($data);
  }

  function check_holiday()
  {
    $selectedDate = $this->input->post('date');


    $isHoliday = $this->selfservices_model->MOD_DISP_HOLIDAY_BASED_DATE($selectedDate);


    $response = array(
      'isHoliday' => !empty($isHoliday),
      'holidayType' => (!empty($isHoliday)) ? $isHoliday[0]->col_holi_type : null
    );


    $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }
  function add_request_overtime()
{
    header('Content-Type: application/json');

    try {
        
        $input_data = $this->input->post();
        $userId     = $this->session->userdata('SESS_USER_ID');
        $input_data['empl_id'] = $this->session->userdata('SESS_USER_ID');
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
        $res = $this->selfservices_model->ADD_OVERTIME_REQUEST($input_data);

        if ($res) {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed overtime request');
        }

        if (!$res) {
            echo json_encode([
                'messageError' => 'Failed to save overtime request'
            ]);
            exit;
        }

        // SUCCESS JSON RESPONSE
        echo json_encode([
            'status' => 'success',
            'redirect' => base_url('selfservices/my_overtimes'),
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



  function add_request_shift()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $input_data                                     = $this->input->post();
    $day_type                                       = $_POST['date_shift'];
    $date                                           = $input_data['date_shift'];
    $messageError                                   = '';
    $input_data['status']                           = 'Pending 1';
    $approvers                                      = $this->selfservices_model->GET_USER_APPROVERS($userId, 'tbl_approvers');


    $approver                                       = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $autoApprovedEnabled  = $this->selfservices_model->getApprovalAutoApproveEnabled($input_data['empl_id']);

      // Today minus 2 days
      $min_allowed_date = date('Y-m-d', strtotime('-2 days'));

      if ($date < $min_allowed_date) {
        $formatted_date = date('m/d/Y', strtotime($date));
        echo json_encode(array('messageError' =>  'Past request must be filed within 2 days.'));
        return;
      }

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      echo json_encode(array('messageError' =>  'No Approver. Please add approver first then try again'));
      return;
    }
    if (
      $autoApprovedEnabled ||
      ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0)
        && (!$approvers || $approvers->approver_3a == 0) && (!$approvers || $approvers->approver_4a == 0)
        && (!$approvers || $approvers->approver_5a == 0))
    ) {
      $input_data['status'] = 'Approved';
    }

    if ($input_data['current_shift'] == 'No shift assign' || $input_data['current_shift'] == '') {

      echo json_encode(array('messageError' =>  'Missing Shift. Please check shifts first then try again'));
      return;
    }

    $is_duplicate = $this->selfservices_model->IS_DUPLICATE_CHAGE_SHIFT($input_data['date_shift'], $input_data['empl_id']);
    if ($is_duplicate > 0) {
      if (empty($messageError)) {
        $messageError = 'Already applied for date/s: ' . $input_data['date_shift'];
        echo json_encode(array('messageError' => $messageError . ' . Please fix and try again'));
        return;
      }
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

    $res                = $this->selfservices_model->ADD_CHANGESHIFT_REQUEST($input_data);

    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed shift change request');
    }

    if ($res && $input_data['status'] == 'Approved') {
      $this->selfservices_model->UPDATE_CHANGESHIFT($input_data['empl_id'], $input_data['date_shift'], $input_data['request_shift']);
    }

    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->selfservices_model->GET_REQUESTOR('shiftrequest', $res);
      $description    = "Change Shift Application Review for [CSH" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $token['type']          = 'changeshift_approval';
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
        'location' => 'selfservices/mychange_approval',
        'description' => $description
      );
      $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
      $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
      $notif = $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
      // redirect('selfservices/mychange_shift');
      echo json_encode(array('messageSuccess' => 'Successfully Submitted'));
      return;
    }
    $this->session->set_flashdata('ERR', 'Fail to add new data');
    return;
    // redirect('selfservices/request_myshift');
  }


  function add_request_off()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $input_data                                     = $this->input->post();
    $day_type                                       = $_POST['date_shift'];
    $date_shift_from                                = $input_data['date_shift'];
    $date_shift_to                                  = $input_data['date_shift_to'];
    $input_data['status']                           = 'Pending 1';
    $approvers                                      = $this->selfservices_model->GET_USER_APPROVERS($userId, 'tbl_approvers');

    // Today minus 2 days
    $min_allowed_date = date('Y-m-d', strtotime('-2 days'));

    if ($date_shift_from < $min_allowed_date || $date_shift_to < $min_allowed_date) {
      $formatted_date = date('m/d/Y', strtotime($date));
      $this->session->set_flashdata("ERR", "Past request must be filed within 2 days.");
      redirect('selfservices/request_myoff');
    }


    $approver                                       = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $autoApprovedEnabled  = $this->selfservices_model->getApprovalAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('selfservices/request_myoff');
    }
    if (
      $autoApprovedEnabled ||
      ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0)
        && (!$approvers || $approvers->approver_3a == 0) && (!$approvers || $approvers->approver_4a == 0)
        && (!$approvers || $approvers->approver_5a == 0))
    ) {
      $input_data['status'] = 'Approved';
    }

    if ($input_data['current_shift'] == 'No shift assign' || $input_data['current_shift'] == '' || $input_data['current_shift_to'] == 'No shift assign' ||  $input_data['current_shift_to'] == '') {
      $this->session->set_flashdata("ERR", "Missing Shift. Please check shifts first then try again");
      redirect('selfservices/request_myoff');
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

    $res                = $this->selfservices_model->ADD_CHANGEOFF_REQUEST($input_data);

    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed change-off request');
    }

    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->selfservices_model->GET_REQUESTOR('changeOff', $res);
      $description    = "Change Off Application Review for [CHO" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $token['type']          = 'changeoff_approval';
      $token['table']         = 'tbl_attendance_changeoff';
      $token['id']            = $res;
      // $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));
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
        'location' => 'selfservices/mychange_off_approval',
        'description' => $description
      );
      $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
      $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
      $notif = $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('selfservices/mychange_off');
      return;
    }
    $this->session->set_flashdata('ERR', 'Fail to add new data');
    redirect('selfservices/request_myoff');
  }


  function add_request_undertime()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $input_data                                     = $this->input->post();
    $day_type                                       = $_POST['date_shift'];
    $date                                           = $input_data['date_undertime'];
    $input_data['status']                           = 'Pending 1';
    $approvers                                      = $this->selfservices_model->GET_USER_APPROVERS($userId, 'tbl_approvers');

    $approver                                       = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $autoApprovedEnabled                            = $this->selfservices_model->getApprovalAutoApproveEnabled($input_data['empl_id']);

    // Today minus 2 days
      $min_allowed_date = date('Y-m-d', strtotime('-2 days'));

      if ($date < $min_allowed_date) {
        $formatted_date = date('m/d/Y', strtotime($date));
        $this->session->set_flashdata("ERR", "Past undertime must be filed within 2 days.");
        redirect('selfservices/request_my_undertime');
      }

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('selfservices/request_my_undertime');
    }
    if (
      $autoApprovedEnabled ||
      ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0)
        && (!$approvers || $approvers->approver_3a == 0) && (!$approvers || $approvers->approver_4a == 0)
        && (!$approvers || $approvers->approver_5a == 0))
    ) {
      $input_data['status'] = 'Approved';
    }


    if ($input_data['current_shift'] == 'No shift assign' || $input_data['current_shift'] == '') {
      $this->session->set_flashdata("ERR", "Missing Shift. Please check shifts first then try again");
      redirect('selfservices/request_my_undertime');
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


    $res                = $this->selfservices_model->ADD_UNDERTIME_REQUEST($input_data);

    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed undertime request');
    }

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
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('selfservices/my_undetime');
      return;
    }
    $this->session->set_flashdata('ERR', 'Fail to add new data');
    redirect('selfservices/request_my_undertime');
  }

  function add_request_exemptut()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $input_data                                     = $this->input->post();
    $day_type                                       = $_POST['date_undertime'];
    $date                                           = $input_data['date_undertime'];
    $input_data['status']                           = 'Pending 1';
    $approvers                                      = $this->selfservices_model->GET_USER_APPROVERS($userId, 'tbl_approvers');

    $approver                                       = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $autoApprovedEnabled  = $this->selfservices_model->getApprovalAutoApproveEnabled($input_data['empl_id']);
    
    // Today minus 2 days
      $min_allowed_date = date('Y-m-d', strtotime('-2 days'));

      if ($date < $min_allowed_date) {
        $formatted_date = date('m/d/Y', strtotime($date));
        $this->session->set_flashdata("ERR", "Past requests must be filed within 2 days.");
        redirect('selfservices/request_exemptut');
      }

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('selfservices/request_exemptut');
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

    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed exempt undertime request');
    }

    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->selfservices_model->GET_REQUESTOR('shiftrequest', $res);
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
      $notif = $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('selfservices/exemptut');
      return;
    }
    $this->session->set_flashdata('ERR', 'Fail to add new data');
    redirect('selfservices/request_exemptut');
  }
  function edit_overtime($id)
  {
    $data['OVERTIME']                               = $this->selfservices_model->GET_OVERTIME($id);
    $data['TYPES']                                  = array('Regular', 'Night Shift', 'Rest', 'Special', 'Legal', 'Rest + Special', 'Rest + Legal');
    $status                                         = $data['OVERTIME']->status;

    if ($status != "Pending 1" && $status != "Pending 2" && $status != "Pending 3") {
      redirect('selfservices/my_overtimes');
      return;
    }

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/edit_overtime_views', $data);
  }

  function update_overtime()
  {
    $input_data                                     = $this->input->post();
    $id                                             = $input_data['id'];
    $res                                            = $this->selfservices_model->UPDATE_OVERTIME($id, $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully Updated');
    }
    redirect('selfservices/my_overtimes');
  }

  function get_overtime_status($id)
  {
    $data['OVERTIME']       = $this->selfservices_model->GET_OVERTIME_STATUS($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $row_data               = $this->selfservices_model->GET_ROW_DATA('tbl_overtimes', $id);

    $data['C_APPROVERS'] = [];
    if ($row_data->approver5 || $row_data->approved_by_5) {
      $data['C_APPROVERS'][] = [
        'main' => $this->selfservices_model->GET_APPROVER_DATA($row_data->approver5, $row_data->approver5_date, $row_data->status, 'Pending 5', '0000-00-00 00:00:00'),
        'approvedby' => $this->selfservices_model->GET_APPROVED_BY($row_data->approved_by_5),
        'backup' => $row_data->approver5_b ? $this->selfservices_model->GET_APPROVER_DATA($row_data->approver5_b, $row_data->approver5_date, $row_data->status, 'Pending 5', '0000-00-00 00:00:00') : null
      ];
    }
    if ($row_data->approver4 || $row_data->approved_by_4) {
      $data['C_APPROVERS'][] = [
        'main' => $this->selfservices_model->GET_APPROVER_DATA($row_data->approver4, $row_data->approver4_date, $row_data->status, 'Pending 4', $row_data->approver5_date),
        'approvedby' => $this->selfservices_model->GET_APPROVED_BY($row_data->approved_by_4),
        'backup' => $row_data->approver4_b ? $this->selfservices_model->GET_APPROVER_DATA($row_data->approver4_b, $row_data->approver4_date, $row_data->status, 'Pending 4', '0000-00-00 00:00:00') : null
      ];
    }
    if ($row_data->approver3 || $row_data->approved_by_3) {
      $data['C_APPROVERS'][] = [
        'main' => $this->selfservices_model->GET_APPROVER_DATA($row_data->approver3, $row_data->approver3_date, $row_data->status, 'Pending 3', $row_data->approver4_date),
        'approvedby' => $this->selfservices_model->GET_APPROVED_BY($row_data->approved_by_3),
        'backup' => $row_data->approver3_b ? $this->selfservices_model->GET_APPROVER_DATA($row_data->approver3_b, $row_data->approver3_date, $row_data->status, 'Pending 3', '0000-00-00 00:00:00') : null
      ];
    }
    if (($row_data->approver2 || $row_data->approved_by_2)  && ($row_data->approver2 != 0 || $row_data->approver2_b != 0)) {
      $data['C_APPROVERS'][] = [
        'main' => $this->selfservices_model->GET_APPROVER_DATA($row_data->approver2, $row_data->approver2_date, $row_data->status, 'Pending 2', $row_data->approver3_date),
        'approvedby' => $this->selfservices_model->GET_APPROVED_BY($row_data->approved_by_2),
        'backup' => $row_data->approver2_b ? $this->selfservices_model->GET_APPROVER_DATA($row_data->approver2_b, $row_data->approver2_date, $row_data->status, 'Pending 2', '0000-00-00 00:00:00') : null
      ];
    }
    if (($row_data->approver1 || $row_data->approved_by_1)  &&  ($row_data->approver1 != 0 || $row_data->approver1_b != 0)) {
      $data['C_APPROVERS'][] = [
        'main' => $this->selfservices_model->GET_APPROVER_DATA($row_data->approver1, $row_data->approver1_date, $row_data->status, 'Pending 1', $row_data->approver2_date),
        'approvedby' => $this->selfservices_model->GET_APPROVED_BY($row_data->approved_by_1),
        'backup' => $row_data->approver1_b ? $this->selfservices_model->GET_APPROVER_DATA($row_data->approver1_b, $row_data->approver1_date, $row_data->status, 'Pending 1', '0000-00-00 00:00:00') : null
      ];
    }
    // var_dump($this->selfservices_model->GET_APPROVED_BY($row_data->approved_by_1));


    // echo '<pre>';
    // var_dump($data['C_APPROVERS']);
    // return;
    $empl_id = $this->session->userdata('SESS_USER_ID');
    $data['user_access'] = $this->selfservices_model->get_user_access($empl_id);
    $this->load->view('modules/partials/_my_overtime_modal_content', $data);
  }

  function get_overtime_approval($id)
  {
    $data['userId']         = $empl_id = $this->session->userdata('SESS_USER_ID');
    $row_data               = $this->selfservices_model->GET_ROW_DATA('tbl_overtimes', $id);

    $data['C_APPROVERS'] = [];
    if ($row_data->approver5 || $row_data->approved_by_5) {
      $data['C_APPROVERS'][] = [
        'main' => $this->selfservices_model->GET_APPROVER_DATA($row_data->approver5, $row_data->approver5_date, $row_data->status, 'Pending 5', '0000-00-00 00:00:00'),
        'approvedby' => $this->selfservices_model->GET_APPROVED_BY($row_data->approved_by_5),
        'backup' => $row_data->approver5_b ? $this->selfservices_model->GET_APPROVER_DATA($row_data->approver5_b, $row_data->approver5_date, $row_data->status, 'Pending 5', '0000-00-00 00:00:00') : null
      ];
    }
    if ($row_data->approver4 || $row_data->approved_by_4) {
      $data['C_APPROVERS'][] = [
        'main' => $this->selfservices_model->GET_APPROVER_DATA($row_data->approver4, $row_data->approver4_date, $row_data->status, 'Pending 4', $row_data->approver5_date),
        'approvedby' => $this->selfservices_model->GET_APPROVED_BY($row_data->approved_by_4),
        'backup' => $row_data->approver4_b ? $this->selfservices_model->GET_APPROVER_DATA($row_data->approver4_b, $row_data->approver4_date, $row_data->status, 'Pending 4', '0000-00-00 00:00:00') : null
      ];
    }
    if ($row_data->approver3 || $row_data->approved_by_3) {
      $data['C_APPROVERS'][] = [
        'main' => $this->selfservices_model->GET_APPROVER_DATA($row_data->approver3, $row_data->approver3_date, $row_data->status, 'Pending 3', $row_data->approver4_date),
        'approvedby' => $this->selfservices_model->GET_APPROVED_BY($row_data->approved_by_3),
        'backup' => $row_data->approver3_b ? $this->selfservices_model->GET_APPROVER_DATA($row_data->approver3_b, $row_data->approver3_date, $row_data->status, 'Pending 3', '0000-00-00 00:00:00') : null
      ];
    }
    if (($row_data->approver2 || $row_data->approved_by_2) && ($row_data->approver2 != 0 || $row_data->approver2_b != 0)) {
      $data['C_APPROVERS'][] = [
        'main' => $this->selfservices_model->GET_APPROVER_DATA($row_data->approver2, $row_data->approver2_date, $row_data->status, 'Pending 2', $row_data->approver3_date),
        'approvedby' => $this->selfservices_model->GET_APPROVED_BY($row_data->approved_by_2),
        'backup' => $row_data->approver2_b ? $this->selfservices_model->GET_APPROVER_DATA($row_data->approver2_b, $row_data->approver2_date, $row_data->status, 'Pending 2', '0000-00-00 00:00:00') : null
      ];
    }
    if (($row_data->approver1 || $row_data->approved_by_1) &&  ($row_data->approver1 != 0 || $row_data->approver1_b != 0)) {
      $data['C_APPROVERS'][] = [
        'main' => $this->selfservices_model->GET_APPROVER_DATA($row_data->approver1, $row_data->approver1_date, $row_data->status, 'Pending 1', $row_data->approver2_date),
        'approvedby' => $this->selfservices_model->GET_APPROVED_BY($row_data->approved_by_1),
        'backup' => $row_data->approver1_b ? $this->selfservices_model->GET_APPROVER_DATA($row_data->approver1_b, $row_data->approver1_date, $row_data->status, 'Pending 1', '0000-00-00 00:00:00') : null
      ];
    }

    $data['btn_status'] = '';
    if ($row_data->status == 'Approved' || $row_data->status == 'Rejected') {
      $data['btn_status'] = 'disabled';
    }
    if (($row_data->approver1 || $row_data->approver1_b) && !$row_data->approved_by_1 && ($row_data->approver2 == $empl_id || $row_data->approver2_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }
    if (($row_data->approved_by_1) && ($row_data->approver1 == $empl_id || $row_data->approver1_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }

    $data['row_data']   = $row_data;
    $data['OVERTIME'] = $this->selfservices_model->GET_OVERTIME_STATUS($id);
    $data['DATE_FORMAT']           = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('modules/partials/_overtime_approval_modal_content', $data);
  }

  function my_holiday_work()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $data['TABLE_DATA']                             = array();
    $status                                         = $this->input->get('status');
    $limit                                          = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                           = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                         =  $limit * ($page - 1);

    $data['STATUS']                                 = $status;
    $data['STATUSES']                               = array('Pending', 'Approved', 'Rejected');
    $data['TABLE_DATA']                             = $this->selfservices_model->GET_EMPL_HOLIDAY_WORK($userId, $status, $limit, $offset);
    $total_count                                    = $this->selfservices_model->GET_EMPL_HOLIDAY_WORK_COUNT($userId, $status);
    $excess                                         = $total_count % $limit;
    $data['C_DATA_COUNT']                           = $total_count;
    $data['PAGES_COUNT']                            = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                   = $page;
    $data['ROW']                                    = $limit;
    $data['C_ROW_DISPLAY']                          = array(10, 25, 50);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");


    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_holiday_work_views', $data);
  }

  function request_holiday_work()
  {
    $data = [];
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/request_holiday_work_views', $data);
  }

  function add_holiday_work()
  {
    $userId                                         = $this->session->userdata('SESS_USER_ID');
    $input_data                                     = $this->input->post();
    $approvers                                      = $this->selfservices_model->GET_USER_APPROVERS($userId, 'tbl_approvers');
    $input_data['status']                           = 'Pending 1';
    $approver                                       = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $autoApprovedEnabled  = $this->selfservices_model->getApprovalAutoApproveEnabled($input_data['empl_id']);
    // if($this->isApproversEnable==1){
    //     if ($approver == 0) {
    //       $this->session->set_flashdata('ERR', 'You dont have an approver');
    //       redirect('selfservices/my_holiday_work');
    //       return;
    //     }
    // }
    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('selfservices/request_holiday_work');
    }

    if ($autoApprovedEnabled || (!$approvers || ($approvers && $approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0))) {
      $input_data['status'] = 'Approved';
    }
    $input_data['approver1'] = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers && $approvers->approver_2a ? $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers && $approvers->approver_3a ? $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers && $approvers->approver_4a ? $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers && $approvers->approver_5a ? $approvers->approver_5a : 0;
    $res                                            = $this->selfservices_model->ADD_HOLIDAY_WORK($input_data);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Filed holiday work request');
    }
    $this->session->set_flashdata('SUCC', 'Successfully added');
    if ($this->isApproversEnable == 0) {
      redirect('selfservices/my_holiday_work');
      return;
    }
    if ($res && $input_data['status'] != 'Approved') {

      $requestor                    = $this->selfservices_model->GET_REQUESTOR('holiday work', $res);
      $description                  = "Holiday Work Application Review for [HWA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $notif_data                   = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $input_data['approver1'],
        'type' => 'holiday_work_approval',
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

      $notif = $this->selfservices_model->ADD_NOTIFICATION($notif_data);
      $this->session->set_flashdata('SUCC', 'Successfully added');
    }
    if ($res) {
      redirect('selfservices/my_holiday_work');
      return;
    }
    $this->session->set_flashdata('ERR', 'Fail to add new data');
    redirect('selfservices/request_holiday_work');
  }

  function edit_holiday_work($id)
  {
    $data['HOLIDAY_WORK'] = $this->selfservices_model->GET_HOLIDAY_WORK($id);
    $data['TYPES']        = array('Regular', 'Night Shift', 'Rest', 'Special', 'Legal', 'Rest + Special', 'Rest + Legal');

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/edit_holiday_work_views', $data);
  }

  function update_holiday_work()
  {
    $input_data = $this->input->post();
    $id         = $input_data['id'];
    $res        = $this->selfservices_model->UPDATE_HOLIDAY_WORK($id, $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully updated');
    }
    redirect('selfservices/my_holiday_work');
  }


  function get_holiday_work_status($id)
  {
    $data['HOLIDAY_WORK'] = $this->selfservices_model->GET_HOLIDAY_WORK_STATUS($id);
    $data['DATE_FORMAT']        = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $row_data               = $this->selfservices_model->GET_ROW_DATA('tbl_holidaywork', $id);
    $data['C_APPROVERS']    = array();
    if ($row_data->approver5) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver5, $row_data->approver5_date, $row_data->status, 'Pending 5', '0000-00-00 00:00:00');
    }
    if ($row_data->approver4) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver4, $row_data->approver4_date, $row_data->status, 'Pending 4', $row_data->approver5_date);
    }
    if ($row_data->approver3) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver3, $row_data->approver3_date, $row_data->status, 'Pending 3', $row_data->approver4_date);
    }
    if ($row_data->approver2) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver2, $row_data->approver2_date, $row_data->status, 'Pending 2', $row_data->approver3_date);
    }
    if ($row_data->approver1) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver1, $row_data->approver1_date, $row_data->status, 'Pending 1', $row_data->approver2_date);
    }
    // echo '<pre>';
    // var_dump($data['C_APPROVERS']);
    // return;
    $this->load->view('modules/partials/_my_holiday_work_modal', $data);
  }

  function get_holiday_work_approval($id)
  {
    $data['HOLIDAY_WORK'] = $this->selfservices_model->GET_HOLIDAY_WORK_STATUS($id);
    $row_data               = $this->selfservices_model->GET_ROW_DATA('tbl_holidaywork', $id);
    $data['C_APPROVERS']    = array();
    if ($row_data->approver5) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver5, $row_data->approver5_date, $row_data->status, 'Pending 5', '0000-00-00 00:00:00');
    }
    if ($row_data->approver4) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver4, $row_data->approver4_date, $row_data->status, 'Pending 4', $row_data->approver5_date);
    }
    if ($row_data->approver3) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver3, $row_data->approver3_date, $row_data->status, 'Pending 3', $row_data->approver4_date);
    }
    if ($row_data->approver2) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver2, $row_data->approver2_date, $row_data->status, 'Pending 2', $row_data->approver3_date);
    }
    if ($row_data->approver1) {
      $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($row_data->approver1, $row_data->approver1_date, $row_data->status, 'Pending 1', $row_data->approver2_date);
    }
    $data['row_data']   = $row_data;
    $data['DATE_FORMAT']                   = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $data['userId']     = $this->session->userdata('SESS_USER_ID');
    $this->load->view('modules/partials/_holiday_work_approval_modal', $data);
  }

  function my_payslips()
  {

    $dateFilter                               = $this->input->get('date');
    $user_id                                  = $this->session->userdata('SESS_USER_ID');
    $data['C_ROW_DISPLAY']                    =  [25, 50, 100];

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    if ($row == null) {
      $row = 25;
    }
    if ($page  == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);

    $payslips                               = $this->selfservices_model->GET_ALL_MY_PAYSPLIP($user_id, $offset, $row);

    $data['C_DATA_COUNT']                   = count($this->selfservices_model->GET_COUNT_MY_PAYSPLIP($user_id));
    $data['DISP_PAYROLL_SCHED']               = $this->selfservices_model->MOD_DISP_PAY_SCHED();
    $employees                                = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC($user_id);
    $positions                                = $this->selfservices_model->GET_SPECIFIC_POSITION();
    $types                                    = $this->selfservices_model->GET_SPECIFIC_EMPLOYEE_TYPE();
    $currentDateTime                          = date("Y-m-d H:i:s");

    $payslips_data = [];
    $index = 0;
    // echo 'test'; die();
    if ($payslips) {
      foreach ($payslips as $payslip) {
        // var_dump($payslip->payslip_sched );
        if ($currentDateTime > $payslip->payslip_sched) {

          $payslips_data[$index]['id']            = $payslip->id;
          $payslips_data[$index]['cmid']          = $payslip->col_empl_cmid;
          $payslips_data[$index]['empl_id']       = $payslip->employee_id;
          $payslips_data[$index]['cutoff_period'] = $payslip->cutoff_period;
          $payslips_data[$index]['payslip_sched'] = $payslip->payslip_sched;
          $lastnameSuffix = $payslip->col_last_name;

          if ($payslip->col_suffix) {
            $lastnameSuffix = $payslip->col_last_name . ' ' . $payslip->col_suffix;
          }

          $fullname = $lastnameSuffix . ', ' . $payslip->col_frst_name;
          if ($payslip->col_midl_name) {
            $fullname = $fullname . ' ' . strtoupper(substr($payslip->col_midl_name, 0, 1)) . '.';
          }

          $payslips_data[$index]['fullname']   = $fullname;

          foreach ($positions as $position) {
            if ($position->id == $payslip->col_empl_posi) {
              $payslips_data[$index]['position'] = $position->name;
            }
          }

          foreach ($types as $type) {
            if ($type->id == $payslip->col_empl_type) {
              $payslips_data[$index]['type']    = $type->name;
            }
          }
          $index += 1;
        }
      }
    }

    $data['DISP_PAYSLIPS']                    = $payslips_data;

    $navbar_val                                 = $this->selfservices_model->get_value_navbar();
    if (file_exists(FCPATH . 'assets_system/images/' . $navbar_val)) {
      $data['DISP_NAV'] = $navbar_val;
    } else if (file_exists(FCPATH . 'assets_system/images/default_logo.png')) {
      $data['DISP_NAV'] = 'default_logo.png';
    } else {
      $data['DISP_NAV'] = null;
    }

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_payslips_views', $data);
  }


  function getPayslipData($id, $empl_id)
  {
    $payslip                    = $this->selfservices_model->GET_PAYSLIP_DATA($id);
    $password                   = $this->selfservices_model->GET_USER_PASSWORD($empl_id);

    $employee_loans             = $this->selfservices_model->GET_ALL_PAYROLL_PAYSLIP_LOAN_DATA($id);
    $payroll_taxable            = $this->selfservices_model->GET_ALL_PAYROLL_TAXABLE_DATA($id);
    $payroll_nontaxable         = $this->selfservices_model->GET_ALL_PAYROLL_NONTAXABLE_DATA($id);

    $employee_loans_payslip = [];
    if (!empty($employee_loans)) {
      foreach ($employee_loans as $employee_loan) {
        $dateTime                           = new DateTime($employee_loan->start);
        $employee_loan->loan_date           = $dateTime->format('m/d/y');
        $employee_loans_payslip[]           = $employee_loan;
      }
    }

    if ($payslip && $password) {
      $mergedData = array(
        'payslip' => $payslip,
        'password' => $password,
        'loans' => $employee_loans_payslip,
        'taxable' => $payroll_taxable,
        'nontaxable' => $payroll_nontaxable,
      );
      echo json_encode($mergedData);
    }
  }

  function delete_payslip()
  {
    $payslip_ids                              = $this->input->post('payslip_ids');
    $array_id                                 = explode(",", $payslip_ids);

    $res = $this->payrolls_model->DELETE_PAYSLIP_DATA($array_id);
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_PAYROLL', 'Deleted Successfully!');
    redirect('payrolls/payslip_generator');
  }

  function my_support_requests()
  {
    $user                                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]                        = $view_type    = ['user', 'employee_id', $user];
    $data["module_name"]                      = $module       = 'selfservices';
    $data["page_name"]                        = $page_name    = 'my_support_requests';
    $data["model_name"]                       = $model        = "main_table_02_model";
    $data["table_name"]                       = $table        = "tbl_hr_supports";
    $data["module"]                           = [base_url() . $module, "Self Services", "Supports"];
    $data["id_prefix"]                        = "SUP";
    $data["excel_import"]                     = [false];
    $data["excel_output"]                     = [true, "supports.xlsx"];
    $data["add_button"]                       = [true, "Add Supports"];
    $data["status_text"]                      = ["Active", "Inactive", "", ""];
    $data["C_ROW_DISPLAY"]                    = $filter_row = [25, 50, 100];
    $c_data_tab                               = array(
      array("Active",   "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active", "btn technos-button-green shadow-none rounded bulk-button"),
      array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive", "btn btn-danger shadow-none rounded bulk-button")

    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 10, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("employee_id", "EMPLOYEE", "user", "self", 0, 10, 1, 1, 1, 1, 0, 1),
        array("title", "TITLE", "text-row", "0", 1, 25, 1, 1, 1, 1, 1, 1),
        array("description", "DESCRIPTION", "text-area", "0", 1, 25, 1, 1, 1, 1, 1, 1),
        array("feedback", "FEEDBACK", "text-area", "0", 1, 25, 1, 1, 1, 1, 1, 1),
        array("attachment", "ATTACHMENT", "attachment", "0", 0, 0, 1, 1, 1, 1, 1, 1),

      );

    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";

    $search                                  = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                     = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]                = $this->$model->GET_EMPL_NAME();
    $data["C_ARRAY_1"]                       = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
    $data["C_ARRAY_2"]                       = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
    $data["C_ARRAY_3"]                       = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
    $data["C_ARRAY_4"]                       = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
    $data["C_ARRAY_5"]                       = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

    $page                                    = $this->input->get('page');
    $row                                     = $this->input->get('row');
    $tab                                     = $this->input->get('tab');
    $tab_filter                              = $this->input->get('tab_filter');

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
      $data["C_DATA_TABLE"]                  = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]                  = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]                  = $this->$model->get_specific_with_empl_data_2($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]                  = count($this->$model->get_specific_with_empl_data_2($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                     = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                      = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_support_request_views', $data);
  }

  function request_support()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/request_support_views');
  }

  function add_new_support()
  {
    $user                                     = $this->session->userdata('SESS_USER_ID');
    $input_data                               = $this->input->post();
    // $attachment                               = $_FILES['attachment']['name'];
    // $file_info                                = pathinfo($attachment);
    $input_data['create_date']                = date('Y-m-d H:i:s');
    $input_data['edit_date']                  = date('Y-m-d H:i:s');
    $input_data['edit_user']                  =   $user;
    $employee                                 = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['employee_id']);
    // $input_data['attachment']                 =    $attachment;


    // if (!empty($attachment)) {
    //   $config['upload_path']              = './assets_user/files/selfservices';
    //   $config['max_size']                 = 10000;
    //   $config['overwrite']                = 'TRUE';
    //   $this->load->library('upload', $config);

    //   if (!$this->upload->do_upload('attachment')) {
    //     $error                      = array('error' => $this->upload->display_errors());
    //     $this->session->set_flashdata('ERR', $error['error']);
    //     redirect('selfservices/request_support');
    //     return;
    //   }
    // }
    $res = $this->selfservices_model->ADD_DATA('tbl_hr_supports', $input_data);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added support request');
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('selfservices/request_support');
      return;
    }
    redirect('selfservices/my_support_requests');
  }
  function edit_support($id)
  {
    $data['SUPPORT']    = $this->selfservices_model->GET_SUPPORT($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    // echo '<pre>';
    // var_dump($data['SUPPORT']);
    // return;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/edit_support_views', $data);
  }
  function show_support($id)
  {
    $data['SUPPORT']    = $this->selfservices_model->GET_SUPPORT($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/show_support_views', $data);
  }
  function update_support($id)
  {
    $input_data = $this->input->post();
    $input_data['test'] = 'test data';
    echo '<pre>';
    if (!$input_data) {
      redirect('selfservices/my_support_requests');
    }
    $validKeys = [
      'title',
      'description',
      'feedback',
      'attachment',
      'status'
    ];
    $input_data             = array_intersect_key($input_data, array_flip($validKeys));
    $input_data['edit_date'] = date('Y-m-d H:i:s');
    $input_data['edit_user'] = $this->session->userdata('SESS_USER_ID');
    $res = $this->selfservices_model->UPDATE_SUPPORT($input_data, $id);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated support request');
      $this->session->set_flashdata('SUCC', 'Successfully updated');
    }
    redirect('selfservices/my_support_requests');
    //   var_dump($input_data);
  }
  function my_complaints()
  {
    $user                                    = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]                       = $view_type    = ['user', 'employee_id', $user];
    $data["module_name"]                     = $module       = 'selfservices';
    $data["page_name"]                       = $page_name    = 'my_complaints';
    $data["model_name"]                      = $model        = "main_table_02_model";
    $data["table_name"]                      = $table        = "tbl_hr_complaints";
    $data["module"]                          = [base_url() . $module, "Self Services", "Complaints"];
    $data["id_prefix"]                       = "CMP";
    $data["excel_import"]                    = [false];
    $data["excel_output"]                    = [true, "complaints.xlsx"];
    $data["add_button"]                      = [true, "Add Complaints"];
    $data["status_text"]                     = ["Active", "Inactive", "", ""];
    $data["C_ROW_DISPLAY"]                   = $filter_row = [25, 50, 100];
    $c_data_tab                              = array(
      array("Active",   "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active", "btn technos-button-green shadow-none rounded bulk-button"),
      array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive", "btn btn-danger shadow-none rounded bulk-button")
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 10, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("employee_id", "EMPLOYEE", "user", "self", 0, 10, 1, 1, 1, 1, 0, 1),
        array("title", "TITLE", "text-row", "0", 1, 25, 1, 1, 1, 1, 1, 1),
        array("description", "DESCRIPTION", "text-area", "0", 1, 25, 1, 1, 1, 1, 1, 1),
        array("feedback", "FEEDBACK", "text-area", "0", 1, 25, 1, 1, 1, 1, 1, 1),
        array("attachment", "ATTACHMENT", "attachment", "0", 0, 0, 1, 1, 1, 1, 1, 1),

      );

    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";


    $search                                    = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                       = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]                  = $this->$model->GET_EMPL_NAME();
    $data["C_ARRAY_1"]                         = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
    $data["C_ARRAY_2"]                         = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
    $data["C_ARRAY_3"]                         = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
    $data["C_ARRAY_4"]                         = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
    $data["C_ARRAY_5"]                         = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

    $page                                      = $this->input->get('page');
    $row                                       = $this->input->get('row');
    $tab                                       = $this->input->get('tab');
    $tab_filter                                = $this->input->get('tab_filter');

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
      $data["C_DATA_TABLE"]                   = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]                   = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]                   = $this->$model->get_specific_with_empl_data_2($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]                   = count($this->$model->get_specific_with_empl_data_2($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                       = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_complaint_views', $data);
  }

  function add_complaint()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/add_complaint_views');
  }

  function add_new_complaint()
  {
    $input_data                               = $this->input->post();
    // $attachment                               = $_FILES['attachment']['name'];
    // $file_info                                = pathinfo($attachment);
    $input_data['create_date']                = date('Y-m-d H:i:s');
    $input_data['edit_date']                  = date('Y-m-d H:i:s');
    $employee                                 = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
    // $input_data['attachment']                 = $attachment;

    // if (!empty($attachment)) {
    //   $res                                    = $this->upload_file('./assets_user/files/selfservices');
    //   if (!$res) {
    //     redirect('selfservices/add_complaint');
    //     return;
    //   }
    // }
    $res = $this->selfservices_model->ADD_DATA('tbl_hr_complaints', $input_data);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added complaint');
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('selfservices/add_complaint');
      return;
    }
    redirect('selfservices/my_complaints');
  }
  function edit_complaint($id)
  {
    $data['COMPLAINT']             = $this->selfservices_model->GET_COMPLAINT($id);
    $data['DATE_FORMAT']           = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/edit_complaint_views', $data);
  }
  function show_complaint($id)
  {
    $data['COMPLAINT']             = $this->selfservices_model->GET_COMPLAINT($id);
    $data['DATE_FORMAT']           = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/show_complaint_views', $data);
  }
  function update_complaint($id)
  {
    $input_data = $this->input->post();
    $input_data['test'] = 'test data';
    echo '<pre>';
    if (!$input_data) {
      redirect('selfservices/my_complaints');
    }
    $validKeys = [
      'title',
      'description',
      'feedback',
      'attachment',
      'status'
    ];
    $input_data             = array_intersect_key($input_data, array_flip($validKeys));
    $input_data['edit_date'] = date('Y-m-d H:i:s');
    $input_data['edit_user'] = $this->session->userdata('SESS_USER_ID');
    $res = $this->selfservices_model->UPDATE_COMPLAINT($input_data, $id);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated complaint');
      $this->session->set_flashdata('SUCC', 'Successfully updated');
    }
    redirect('selfservices/my_complaints');
  }
  function upload_file($path)
  {
    $config['upload_path']             = $path;
    $config['max_size']                = 10000;
    $config['allowed_types']           = 'gif';
    $config['overwrite']               = 'TRUE';
    $this->load->library('upload', $config);
    if (!$this->upload->do_upload('attachment')) {
      $error                      = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('ERR', $error['error']);


      return false;
    }
    return true;
  }

  function my_warnings()
  {

    $user                                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]                        = $view_type    = ['user', 'employee_id', $user];
    $data["module_name"]                      = $module       = 'selfservices';
    $data["page_name"]                        = $page_name    = 'my_warnings';
    $data["model_name"]                       = $model        = "main_table_02_model";
    $data["table_name"]                       = $table        = "tbl_hr_warnings";
    $data["module"]                           = [base_url() . $module, "Self Services", "Warnings"];
    $data["id_prefix"]                        = "WRN";
    $data["excel_import"]                     = [false];
    $data["excel_output"]                     = [true, "warnings.xlsx"];
    $data["add_button"]                       = [true, "Add Warnings"];
    $data["status_text"]                      = ["Active", "Inactive", "", ""];
    $data["C_ROW_DISPLAY"]                    = $filter_row = [25, 50, 100];
    $c_data_tab                               = array(
      array("Active",   "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active", "btn technos-button-green shadow-none rounded bulk-button"),
      array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive", "btn btn-danger shadow-none rounded bulk-button")
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 10, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("employee_id", "EMPLOYEE", "user", "self", 0, 0, 1, 1, 1, 1, 0, 1),
        array("title", "TITLE", "text-row", "0", 1, 25, 1, 1, 1, 1, 1, 1),
        array("description", "DESCRIPTION", "text-area", "0", 1, 25, 1, 1, 1, 1, 1, 1),
        array("feedback", "FEEDBACK", "text-area", "0", 1, 25, 1, 1, 1, 1, 1, 1),
        array("attachment", "ATTACHMENT", "attachment", "0", 0, 0, 1, 1, 1, 1, 1, 1),

      );

    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";


    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                      = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]                 = $this->$model->GET_EMPL_NAME();
    $data["C_ARRAY_1"]                        = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
    $data["C_ARRAY_2"]                        = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
    $data["C_ARRAY_3"]                        = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
    $data["C_ARRAY_4"]                        = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
    $data["C_ARRAY_5"]                        = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    $tab                                      = $this->input->get('tab');
    $tab_filter                               = $this->input->get('tab_filter');

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
      $data["C_DATA_TABLE"]                   = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]                   = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]                   = $this->$model->get_specific_with_empl_data_2($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]                   = count($this->$model->get_specific_with_empl_data_2($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }

    $data["C_DATA_TAB"]                       = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_warnings_views', $data);
  }

  function add_warning()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/add_warning_views');
  }

  function add_new_warning()
  {
    $input_data                               = $this->input->post();
    // $attachment                               = $_FILES['attachment']['name'];
    // $file_info = pathinfo($attachment);
    $input_data['create_date']                = date('Y-m-d H:i:s');
    $input_data['edit_date']                  = date('Y-m-d H:i:s');
    $employee                                 = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['employee_id']);
    // $input_data['attachment']                 = $attachment;


    // if (!empty($attachment)) {
    //   $res = $this->upload_file('./assets_user/files/selfservices');
    //   if (!$res) {
    //     redirect('selfservices/add_warning');
    //     return;
    //   }
    // }
    $res = $this->selfservices_model->ADD_DATA('tbl_hr_warnings', $input_data);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added warning');
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('selfservices/add_warning');
      return;
    }
    redirect('selfservices/my_warnings');
  }
  function edit_warning($id)
  {
    $data['WARNING'] = $this->selfservices_model->GET_WARNING($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/edit_warning_views', $data);
  }
  function show_warning($id)
  {
    $data['WARNING']           = $this->selfservices_model->GET_WARNING($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/show_warning_views', $data);
  }
  function update_warning($id)
  {
    $input_data = $this->input->post();
    $input_data['test'] = 'test data';
    if (!$input_data) {
      redirect('selfservices/my_warnings');
    }
    $validKeys = [
      'title',
      'description',
      'feedback',
      'attachment',
      'status'
    ];
    $input_data             = array_intersect_key($input_data, array_flip($validKeys));
    $input_data['edit_date'] = date('Y-m-d H:i:s');
    $input_data['edit_user'] = $this->session->userdata('SESS_USER_ID');
    $res = $this->selfservices_model->UPDATE_WARNING($input_data, $id);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated warning');
      $this->session->set_flashdata('SUCC', 'Successfully updated');
    }
    redirect('selfservices/my_warnings');
  }
  function my_trainings()
  {
    $user                                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]                        = $view_type    = ['user', 'edit_user', $user];
    $data["module_name"]                      = $module       = 'selfservices';
    $data["page_name"]                        = $page_name    = 'my_trainings';
    $data["model_name"]                       = $model        = "main_table_02_model";
    $data["table_name"]                       = $table        = "tbl_employee_allowanceassign";
    $data["module"]                           = [base_url() . $module, "Self Services", "My Trainings"];
    $data["id_prefix"]                        = "TRN";
    $data["excel_import"]                     = [false];
    $data["excel_output"]                     = [true, "my_trainings.xlsx"];
    $data["add_button"]                       = [true, "Add My Trainings"];
    $data["status_text"]                      = ["Active", "Inactive", "", ""];
    $data["C_ROW_DISPLAY"]                    = $filter_row = [25, 50, 100];
    $c_data_tab                               = array(
      array("Active",   "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]      = array(
      array(true, "btn_mark_active",   "far fa-check-circle", "Mark as Active",   "status", "Active"),
      array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
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
    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                      = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]                 = $this->$model->get_empl_name();
    $data["C_ARRAY_1"]                        = $this->$model->get_allowance_name();
    $data["C_ARRAY_2"]                        = [];
    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    $tab                                      = $this->input->get('tab');
    $tab_filter                               = $this->input->get('tab_filter');

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
      $data["C_DATA_TABLE"]                   = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]                   = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]                   = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]                   = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                       = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_views', $data);
  }

  function my_surveys()
  {
    $user                                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]                        = $view_type    = ['user', 'edit_user', $user];
    $data["module_name"]                      = $module       = 'selfservices';
    $data["page_name"]                        = $page_name    = 'my_surveys';
    $data["model_name"]                       = $model        = "main_table_02_model";
    $data["table_name"]                       = $table        = "tbl_employee_allowanceassign";
    $data["module"]                           = [base_url() . $module, "Self Services", "My Surveys"];
    $data["id_prefix"]                        = "SRV";
    $data["excel_import"]                     = [false];
    $data["excel_output"]                     = [true, "my_surveys.xlsx"];
    $data["add_button"]                       = [true, "Add My Surveys"];
    $data["status_text"]                      = ["Active", "Inactive", "", ""];
    $data["C_ROW_DISPLAY"]                    = $filter_row = [25, 50, 100];
    $c_data_tab                               = array(
      array("Active",   "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),
      array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
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

    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"]                      = $filter_row[0];
    $data["C_DATA_EMPL_NAME"]                 = $this->$model->get_empl_name();
    $data["C_ARRAY_1"]                        = $this->$model->get_allowance_name();
    $data["C_ARRAY_2"]                        = [];
    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    $tab                                      = $this->input->get('tab');
    $tab_filter                               = $this->input->get('tab_filter');

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
      $data["C_DATA_TABLE"]                  = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]                  = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]                  = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]                  = $this->$model->GET_DATA_COUNT($table, $tab, $tab_filter, $view_type);
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                     = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                      = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_views', $data);
  }

  function get_data_all_list()
  {
    $model                                    = $this->input->post('model_name');
    $table                                    = $this->input->post('table_name');
    $modal_id                                 = $this->input->post('modal_id');
    $data = $this->$model->get_data_row($table, $modal_id);
    echo (json_encode($data));
  }

  function show_data()
  {
    $data["model_name"]                       = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"]                 = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_show', $data);
  }

  function edit_data()
  {
    $data["model_name"]                       = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"]                 = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_edit', $data);
  }

  function add_data()
  {
    $data["model_name"]                       = $model  = "main_table_01_model";
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_add', $data);
  }

  function edit_row()
  {
    $edit_user                                = $this->session->userdata('SESS_USER_ID');
    $input_data                               = $this->input->get();
    $set_array                                = array();
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
    $set_array['edit_user']                   = $edit_user;
    $this->main_table_01_model->edit_table_row($table, $id, $set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }

  function add_row()
  {
    $edit_user                                = $this->session->userdata('SESS_USER_ID');
    $input_data                               = $this->input->get();
    $set_array                                = array();
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
    $set_array['edit_user']                 = $edit_user;
    $this->main_table_01_model->add_table_row($table, $set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }

  function delete_row()
  {
    $edit_user                                = $this->session->userdata('SESS_USER_ID');
    $id                                       = $this->input->get('delete_id');
    $table                                    = $this->input->get('table');
    $module_name                              = $this->input->get('module');
    $page_name                                = $this->input->get('page');
    $this->main_table_01_model->delete_table_row($id, $table, $edit_user);
    $this->session->set_userdata('delete', 'Deleted Successfully!');
    redirect($module_name . "/" . $page_name);
  }

  function edit_bulk_status()
  {
    $edit_user                                = $this->session->userdata('SESS_USER_ID');
    $status                                   = $this->input->post('modal_title');
    $ids                                      = $this->input->post('list_mark_ids');
    $ids_int                                  = array_map('intval', explode(',', $ids));
    $module_name                              = $this->input->get('module');
    $page_name                                = $this->input->get('page_name');
    $table                                    = $this->input->get('table');
    $page                                     = $this->input->get('page');
    $row_url                                  = '&row=';
    $row                                      = $this->input->get('row');
    $tab                                      = $this->input->get('tab');
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

  function insrt_skill()
  {
    $employee_id                             = $this->input->post('SKILL_EMPL_ID');
    $skill                                   = $this->input->post('INSRT_SKILL_NAME');
    $level                                   = $this->input->post('INSRT_SKILL_LEVEL');
    $this->selfservices_model->MOD_INSRT_SKILL($employee_id, $skill, $level);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added new skill');
    $this->session->set_userdata('SESS_SUCC_INSRT_SKILL', 'Skill Added Successfully!');
    redirect('profile');
  }

  function edit_employee_info()
  {
    $employee_key                            = $this->input->post('EDIT_EMPL_ID');
    $employee_id                             = $this->input->post('UPDT_EMPL_ID');
    $lastname                                = $this->input->post('UPDT_EMPL_LNAME');
    $middlename                              = $this->input->post('UPDT_EMPL_MNAME');
    $firstname                               = $this->input->post('UPDT_EMPL_FNAME');
    $birthday                                = $this->input->post('UPDT_EMPL_BIRTHDAY');
    $gender                                  = $this->input->post('UPDT_EMPL_GENDER');
    $marital_status                          = $this->input->post('UPDT_EMPL_MRTL_STAT');
    $shirt_size                              = $this->input->post('UPDT_EMPL_SHIRT_SIZE');
    $nationality                             = $this->input->post('UPDT_EMPL_NATIONALITY');
    $home_address                            = $this->input->post('UPDT_EMPL_HOME_ADDR');
    $current_address                         = $this->input->post('UPDT_EMPL_CURR_ADDR');
    $this->selfservices_model->MOD_UPDT_EMPLOYEE_INFO($employee_id, $lastname, $middlename, $firstname, $birthday, $gender, $marital_status, $shirt_size, $nationality, $home_address, $current_address, $employee_key);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated employee info');
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_INFO', 'Updated Successfully!');
    redirect('profile');
  }

  function edit_employee_contact()
  {
    $employee_key                            = $this->input->post('EDIT_EMPL_ID');
    $work_email                              = $this->input->post('UPDT_EMPL_WORK_EMAIL');
    $personal_email                          = $this->input->post('UPDT_EMPL_PERS_EMAIL');
    $work_number                             = $this->input->post('UPDT_EMPL_WORK_NUMBER');
    $personal_number                         = $this->input->post('UPDT_EMPL_PERS_NUMBER');
    $this->selfservices_model->MOD_UPDT_EMPLOYEE_CONTACT($work_email, $personal_email, $work_number, $personal_number, $employee_key);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated employee contact');
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_CONTACT', 'Contacts Updated Successfully!');
    redirect('profile');
  }

  function edit_employee_education()
  {
    $education_id                            = $this->input->post('UPDT_EDUC_ID');
    $employee_id                             = $this->input->post('UPDT_EDUC_EMPL_ID');
    $school                                  = $this->input->post('UPDT_EDUC_SCHOOL');
    $degree                                  = $this->input->post('UPDT_EDUC_DEGREE');
    $from_year                               = $this->input->post('UPDT_EDUC_FROM_YEAR');
    $to_year                                 = $this->input->post('UPDT_EDUC_TO_YEAR');
    $grade                                   = $this->input->post('UPDT_EDUC_GRADE');
    $this->selfservices_model->MOD_UPDT_EDUCATION($school, $degree, $from_year, $to_year, $grade, $employee_id, $education_id);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_EDUC', 'Education Background Updated Successfully!');
    redirect('profile');
  }

  function delete_employee_education()
  {
    $education_id                           = $this->input->get('delete_id');
    $employee_id                            = $this->input->get('employee_id');
    $this->selfservices_model->MOD_DLT_EDUCATION($education_id);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted education record');
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_EDUC', 'Education Background Deleted');
    redirect('profile');
  }

  function getEducationData()
  {
    $education_id                           = $this->input->post('education_id');
    $data                                   = $this->selfservices_model->MOD_GET_EDUCATION_DATA($education_id);
    echo (json_encode($data));
  }

  function edit_employee_certification()
  {
    $certification_id                       = $this->input->post('UPDT_CERT_ID');
    $employee_id                            = $this->input->post('UPDT_CERT_EMPL_ID');
    $certificate_name                       = $this->input->post('UPDT_CERT_NAME');
    $issuer                                 = $this->input->post('UPDT_CERT_ISSUER');
    $issued_on                              = $this->input->post('UPDT_CERT_ISSUED_ON');
    $expires_on                             = $this->input->post('UPDT_CERT_EXPIRE');
    $this->selfservices_model->MOD_UPDT_LICENSE($certificate_name, $issuer, $issued_on, $expires_on, $employee_id, $certification_id);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_CERT', 'Certification Updated Successfully!');
    redirect('profile');
  }

  function delete_employee_certification()
  {
    $certification_id                       = $this->input->get('delete_id');
    $employee_id                            = $this->input->get('employee_id');
    $this->selfservices_model->MOD_DLT_LICENSE($certification_id);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted certification');
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_CERT', 'Certification Deleted!');
    redirect('profile');
  }

  function getCertificationData()
  {
    $certification_id                       = $this->input->post('certification_id');
    $data                                   = $this->selfservices_model->MOD_GET_LICENSE_DATA($certification_id);
    echo (json_encode($data));
  }

  function edit_employee_skill()
  {
    $skill_id                               = $this->input->post('UPDT_SKILL_ID');
    $employee_id                            = $this->input->post('UPDT_SKILL_EMPL_ID');
    $skill_name                             = $this->input->post('UPDT_SKILL_NAME');
    $level                                  = $this->input->post('UPDT_SKILL_LEVEL');
    $this->selfservices_model->MOD_UPDT_SKILL($skill_name, $level, $employee_id, $skill_id);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_SKILL', 'SKILL Updated Successfully!');
    redirect('profile');
  }

  function delete_employee_skill()
  {
    $skill_id                               = $this->input->get('delete_id');
    $employee_id                            = $this->input->get('employee_id');
    $this->selfservices_model->MOD_DLT_SKILL($skill_id);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted skill');
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_SKILL', 'Certification Deleted!');
    redirect('profile');
  }

  function getSkillData()
  {
    $skill_id                               = $this->input->post('skill_id');
    $data                                   = $this->selfservices_model->MOD_GET_SKILL_DATA($skill_id);
    echo (json_encode($data));
  }

  function update_employee_id()
  {
    $employee_id                            = htmlentities($this->input->post('UPDT_EMP_ID'));
    $sss                                    = htmlentities($this->input->post('UPDT_ID_SSS'));
    $hdmf                                   = htmlentities($this->input->post('UPDT_ID_HDMF'));
    $philhealth                             = htmlentities($this->input->post('UPDT_ID_PHIL'));
    $tin                                    = htmlentities($this->input->post('UPDT_ID_TIN'));
    $drivers_license                        = htmlentities($this->input->post('UPDT_ID_DRV'));
    $national_id                            = htmlentities($this->input->post('UPDT_ID_NAT'));
    $passport                               = htmlentities($this->input->post('UPDT_ID_PSSP'));
    $this->selfservices_model->MOD_UPDT_EMPLOYEE_ID($sss, $hdmf, $philhealth, $tin, $drivers_license, $national_id, $passport, $employee_id);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated employee ID');
    $this->session->set_userdata('SESS_SUCC_UPDT', 'Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/ids'</script>";
  }

  function edit_employee_job()
  {
    $employee_id                            = $this->input->post('UPDT_EMPL_ID');
    $hired_on                               = $this->input->post('UPDT_JOB_HIRE_ON');
    $end_on                                 = $this->input->post('UPDT_JOB_END_ON');
    $this->selfservices_model->MOD_UPDT_JOB($hired_on, $end_on, $employee_id);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_JOB', 'Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/job'</script>";
  }

  function edit_employment_details()
  {
    $user_id                                = $this->input->post('EMPL_ID');
    $emp_type                               = $this->input->post('emp_type');
    $position                               = $this->input->post('position');
    $department                             = $this->input->post('department');
    $groups                                 = $this->input->post('groups');
    $line                                   = $this->input->post('line');
    $section                                = $this->input->post('section');
    $hmo                                    = $this->input->post('hmo');
    $hmo_number                             = $this->input->post('hmo_number');
    $this->selfservices_model->MOD_UPDT_EMPL_DETAILS($emp_type, $position, $department, $section, $groups, $line, $hmo, $hmo_number, $user_id);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_JOB', 'Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/job'</script>";
  }

  function edit_employee_salary_rate()
  {
    $salary_rate                            = $this->input->post('salary_rate');
    $salary_type                            = $this->input->post('salary_type');
    $user_id                                = $this->input->post('EMPL_ID');
    $this->selfservices_model->MOD_UPDT_EMPL_SALARY_RATE($salary_rate, $salary_type, $user_id);
    $this->session->set_userdata('SESS_SUCC_UPDT_EMPL_JOB', 'Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/job'</script>";
  }

  function add_employee_document()
  {
    $employee_id                            = $this->input->post('INSRT_DOC_EMPL_ID');
    $document_name                          = $_FILES['employee_file']['name'];
    $config['upload_path']                  = './employee_files/';
    $config['allowed_types']                = 'docx|xlsx|pdf|pptx';
    $config['max_size']                     = '50000';
    $config['file_name']                    = $employee_id . '_' . $document_name;
    $config['overwrite']                    = 'TRUE';
    $this->load->library('upload', $config);
    if ($_FILES['employee_file']['size'] != 0) {
      if ($this->upload->do_upload('employee_file')) {
        $data_upload                        = array('employee_file' => $this->upload->data());
        $document_file                      = $data_upload['employee_file']['file_name'];
        $this->selfservices_model->MOD_INSRT_DOC($document_file, $document_name, $employee_id);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added employee document');
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
    $document_id                            = $this->input->get('id');
    $file                                   = $this->input->get('file');
    $employee_id                            = $this->input->get('employee_id');
    $filestring = PUBPATH . 'employee_files/' . $file;
    if (file_exists($filestring)) {
      unlink($filestring);
      $this->selfservices_model->MOD_DLT_DOCU($document_id);
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted employee document');
      $this->session->set_userdata('SESS_SUCC_DLT_EMPL_DOC', 'Document Deleted Successfully!');
      echo "<script>window.location.href='" . base_url() . "employees/documents?id=" . $employee_id . "'</script>";
    } else {
      $this->session->set_userdata('SESS_ERR_DLT_EMPL_DOC', 'File not found');
      echo "<script>window.location.href='" . base_url() . "profile/documents'</script>";
    }
  }

  function add_employee_asset()
  {
    $assign_to                              = $this->input->post('INSRT_ASSET_EMPL_ID');
    $user_id                                = $this->input->post('INSRT_ASSET_USER_ID');
    $issued_on                              = $this->input->post('INSRT_ASSET_ISSUED_ON');
    $asset_id                               = $this->input->post('INSRT_ASSET_NAME');
    $asset_list                             = $this->selfservices_model->MOD_DISP_ASSET_INFO($asset_id);
    $status                                 = $asset_list[0]->col_asset_status;
    if (($status == '') || ($status == 'in-stockroom')) {
      $this->selfservices_model->MOD_INSRT_ASSET_LOGS($assign_to, $user_id, $issued_on, $asset_id);
      $this->selfservices_model->MOD_UPDT_ASSET_STATUS_TRANSFER($assign_to, $issued_on, $user_id, $asset_id);
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added employee asset');
      $this->session->set_userdata('SESS_SUCC_MSG_TRANSFER_TO_EMPLOYEE', 'Assigned Successfully!');
      echo "<script>window.location.href='" . base_url() . "profile/assets'</script>";
    } else if ($status == 'in-use') {
      $issued_on_key                        = $asset_list[0]->col_asset_issued_on;
      $assigned_to_key                      = $asset_list[0]->col_asset_assigned_to;
      $this->selfservices_model->MOD_UPDT_ASSET_STATUS_TRANSFER($assign_to, $issued_on, $user_id, $asset_id);
      $this->selfservices_model->MOD_UPDT_ASSET_LOGS($issued_on_key, $asset_id, $assigned_to_key);
      $this->selfservices_model->MOD_INSRT_ASSET_LOGS($assign_to, $user_id, $issued_on, $asset_id);
      $this->session->set_userdata('SESS_SUCC_MSG_TRANSFER_ASSET', 'Transferred Successfully!');
      echo "<script>window.location.href='" . base_url() . "profile/assets'</script>";
    }
  }

  function insert_emergency()
  {
    $INSRT_EMER_EMPID                       = $this->input->post('INSRT_EMER_EMPID');
    $INSRT_EMER_NAME                        = $this->input->post('INSRT_EMER_NAME');
    $INSRT_EMER_RELA                        = $this->input->post('INSRT_EMER_RELA');
    $INSRT_EMER_MNUM                        = $this->input->post('INSRT_EMER_MNUM');
    $INSRT_EMER_WPHN                        = $this->input->post('INSRT_EMER_WPHN');
    $INSRT_EMER_HPHN                        = $this->input->post('INSRT_EMER_HPHN');
    $INSRT_EMER_ADDR                        = $this->input->post('INSRT_EMER_ADDR');
    $this->selfservices_model->MOD_INSRT_EMERGENCY(
      $INSRT_EMER_EMPID,
      $INSRT_EMER_NAME,
      $INSRT_EMER_RELA,
      $INSRT_EMER_MNUM,
      $INSRT_EMER_WPHN,
      $INSRT_EMER_HPHN,
      $INSRT_EMER_ADDR
    );
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added emergency contact');
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_EMERGENCY', 'Emergency Contact Added Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/emergency'</script>";
  }

  function delete_emergency()
  {
    $DATA_ID                                = $this->input->get('delete_id');
    $employee_id                            = $this->input->get('employee_id');
    $this->selfservices_model->MOD_DLT_EMERGENCY($DATA_ID);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted emergency contact');
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_EMERGENCY', 'Emergency Contact Deleted Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/emergency'</script>";
  }

  function get_emergency_data()
  {
    $DATA_ID                                = $this->input->post('DATA_ID');
    $data                                   = $this->selfservices_model->MOD_GET_EMERGENCY_DATA($DATA_ID);
    echo (json_encode($data));
  }

  function update_emergency()
  {
    $UPDT_EMER_EMPID                        = $this->input->post('UPDT_EMER_EMPID');
    $UPDT_EMER_NAME                         = $this->input->post('UPDT_EMER_NAME');
    $UPDT_EMER_RELA                         = $this->input->post('UPDT_EMER_RELA');
    $UPDT_EMER_MNUM                         = $this->input->post('UPDT_EMER_MNUM');
    $UPDT_EMER_WPHN                         = $this->input->post('UPDT_EMER_WPHN');
    $UPDT_EMER_HPHN                         = $this->input->post('UPDT_EMER_HPHN');
    $UPDT_EMER_ADDR                         = $this->input->post('UPDT_EMER_ADDR');
    $DATA_ID                                = $this->input->post('UPDT_EMER_ID');
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
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated emergency contact');
    $this->session->set_userdata('SESS_SUCC_MSG_UPDT_EMERGENCY', 'Emergency Contact Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/emergency'</script>";
  }

  function insert_dependents()
  {
    $INSRT_DEPT_EMPID                     = $this->input->post('INSRT_DEPT_EMPID');
    $INSRT_DEPT_NAME                        = $this->input->post('INSRT_DEPT_NAME');
    $INSRT_DEPT_BDAY                        = $this->input->post('INSRT_DEPT_BDAY');
    $INSRT_DEPT_GNDR                        = $this->input->post('INSRT_DEPT_GNDR');
    $INSRT_DEPT_RELA                        = $this->input->post('INSRT_DEPT_RELA');
    $this->selfservices_model->MOD_INSRT_DEPENDENTS($INSRT_DEPT_EMPID, $INSRT_DEPT_NAME, $INSRT_DEPT_BDAY, $INSRT_DEPT_GNDR, $INSRT_DEPT_RELA);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added dependent');
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_DEPENDENTS', 'Dependents Added Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/dependents'</script>";
  }

  function delete_dependents()
  {
    $DATA_ID                                = $this->input->post('delete_id');
    $employee_id                            = $this->input->post('employee_id');
    $this->selfservices_model->MOD_DLT_DEPENDENTS($DATA_ID);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted dependent');
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_DEPENDENTS', 'Dependents Deleted Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/dependents'</script>";
  }

  function get_dependents_data()
  {
    $DATA_ID = $this->input->post('DATA_ID');
    $data    = $this->selfservices_model->MOD_GET_DEPENDENTS_DATA($DATA_ID);
    echo (json_encode($data));
  }

  function update_dependents()
  {
    $UPDT_DEPT_EMPID                        = $this->input->post('UPDT_DEPT_EMPID');
    $UPDT_DEPT_NAME                         = $this->input->post('UPDT_DEPT_NAME');
    $UPDT_DEPT_BDAY                         = $this->input->post('UPDT_DEPT_BDAY');
    $UPDT_DEPT_GNDR                         = $this->input->post('UPDT_DEPT_GNDR');
    $UPDT_DEPT_RELA                         = $this->input->post('UPDT_DEPT_RELA');
    $DATA_ID                                = $this->input->post('UPDT_DEPT_ID');
    $this->selfservices_model->MOD_UPDT_DEPENDENTS($UPDT_DEPT_EMPID, $UPDT_DEPT_NAME, $UPDT_DEPT_BDAY, $UPDT_DEPT_GNDR, $UPDT_DEPT_RELA, $DATA_ID);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated dependent');
    $this->session->set_userdata('SESS_SUCC_MSG_UPDT_DEPENDENTS', 'Dependents Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/dependents'</script>";
  }

  function insert_notes()
  {
    $INSRT_NOTE_CRBY                        = $this->input->post('INSRT_NOTE_CRBY');
    $INSRT_NOTE_CRDT                        = $this->input->post('INSRT_NOTE_CRDT');
    $INSRT_NOTE_DESC                        = $this->input->post('INSRT_NOTE_DESC');
    $INSRT_NOTE_EMID                        = $this->input->post('INSRT_NOTE_EMID');
    $this->selfservices_model->MOD_INSRT_NOTES($INSRT_NOTE_CRBY, $INSRT_NOTE_CRDT, $INSRT_NOTE_DESC, $INSRT_NOTE_EMID);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added notes');
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_NOTES', 'Note Added Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/notes'</script>";
  }

  function delete_notes()
  {
    $DATA_ID                            = $_GET['delete_id'];
    $this->selfservices_model->MOD_DLT_NOTES($DATA_ID);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted notes');
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_NOTES', 'Note Deleted Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/notes'</script>";
  }

  function get_notes_data()
  {
    $DATA_ID                                = $this->input->post('DATA_ID');
    $data                                   = $this->selfservices_model->MOD_GET_NOTES_DATA($DATA_ID);
    echo (json_encode($data));
  }

  function update_notes()
  {
    $UPDT_NOTE_CRBY                         = $this->input->post('UPDT_NOTE_CRBY');
    $UPDT_NOTE_CRDT                         = $this->input->post('UPDT_NOTE_CRDT');
    $UPDT_NOTE_DESC                         = $this->input->post('UPDT_NOTE_DESC');
    $UPDT_NOTE_EMID                         = $this->input->post('UPDT_NOTE_EMID');
    $DATA_ID                                = $this->input->post('UPDT_NOTE_ID');
    $this->selfservices_model->MOD_UPDT_NOTES($UPDT_NOTE_CRBY, $UPDT_NOTE_CRDT, $UPDT_NOTE_DESC, $UPDT_NOTE_EMID, $DATA_ID);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated notes');
    $this->session->set_userdata('SESS_SUCC_MSG_UPDT_NOTES', 'Note Updated Successfully!');
    echo "<script>window.location.href='" . base_url() . "profile/notes'</script>";
  }

  function get_my_team()
  {
    $user                                   = $this->session->userdata('SESS_USER_ID');
    $empl_name                              = $this->selfservices_model->GET_POSITION();
    $res                                    = $this->selfservices_model->GET_MY_TEAM($user);

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

  function edit_image()
  {

    $get_image_name                         = $_FILES['employee_image']['name'];
    $userID                                 = $this->input->post('INSRT_EMPL_ID');
    $url_directory                          = $this->input->post('URL_DIRECTORY');
    $employee                               = $this->selfservices_model->GET_EMPLOYEE_SPECIFIC($userID);

    $employee = $employee ? $employee[0] : redirect('selfservices/my_profile_personal');
    $config['upload_path']                  = './assets_user/user_profile';
    $config['allowed_types']                = '*';
    $config['max_size']                     = '5000';
    $config['file_name']                    = $employee->col_empl_cmid;
    $config['overwrite']                    = 'TRUE';
    $this->load->library('upload', $config);
    if ($_FILES['employee_image']['size'] != 0) {
      if ($this->upload->do_upload('employee_image')) {
        $data_upload                        = array('employee_image' => $this->upload->data());
        $user_img                           = $data_upload['employee_image']['file_name'];
        $this->selfservices_model->INSERT_EMPLOYEE_IMAGE($user_img, $userID);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated profile photo');
        $this->session->set_userdata('SESS_SUCC_UPDT_IMG', 'Profile Updated!');
      } else {
        $error                              = array('error' => $this->upload->display_errors());
        // var_dump($error);
      }
    } else {
      echo 'fail to change profile image';
      $this->session->set_userdata('SESS_ERR_IMAGE', 'No employee photo was selected');
    }
    redirect('selfservices/my_profile_personal', 'refresh');
  }

  function withdraw_leave()
  {

    $id = $this->input->post('rowId');
    $status = "Withdrawn";
    $res = $this->selfservices_model->MOD_UPDATE_LEAVE_STATUS($id, $status);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Withdrew leave request');
    $this->session->set_flashdata('SUCC', 'Withdraw Leave Updated Successfully!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function cancel_approved_leave()
  {
    $id = $this->input->post('rowId');
    $remarks = $this->input->post('remarks');
    $status = "Withdrawn";
    $res = $this->selfservices_model->MOD_UPDATE_LEAVE_STATUS($id, $remarks, $status);
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Cancelled leave request');
    $this->session->set_flashdata('SUCC', 'Withdraw Leave Updated Successfully!');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function get_reporting_to_directives()
  {
    $response['errorMessage'] = 'Failed Fetching Data';
    try {
      $json_data = file_get_contents('php://input');
      $data = json_decode($json_data, true);
      $updatedData = $data['employeeId'];
      if (!isset($updatedData) || !$updatedData) {
        $response = array('error_message' => 'Invalid Id');
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
        return;
      }

      $res = $this->selfservices_model->GET_REPORTING_TO_DIRECTS($updatedData);
      if ($res) {
        $response['errorMessage'] = null;
        $response['data'] = $res;
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($response));
    } catch (Exception $e) {
      $response['errorMessage'] = 'Error Fetching Data data: ' . $e->getMessage();
      $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }

  function convert_time_to_float($time, $type)
  {

    if (!empty($time)) {

      $split_time_in            = explode(":", $time);
      if ($type == 'minute') {
        $converted_time         = ((float)$split_time_in[0] * 60) + (float)$split_time_in[1];
      } else {
        $converted_time         = (float)$split_time_in[0] + ((float)$split_time_in[1] / 60);
      }
      return (float)$converted_time;
    }
    return;
  }

  function my_assets()
  {
    $id                         = $this->session->userdata('SESS_USER_ID');

    $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                     = $limit * ($page - 1);
    $status                     = $this->input->get('tab') ? $this->input->get('tab') : 'Active';

    $search_query               = $this->input->get('all');
    $row                        = $this->input->get('row');

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

    $data['ACTIVES']            = count($this->selfservices_model->get_all_assets_info($limit, $offset, 'Active', $search_query, $row, $id));
    $data['INACTIVES']          = count($this->selfservices_model->get_all_assets_info($limit, $offset, 'Inactive', $search_query, $row, $id));
    $total_count                = $this->selfservices_model->GET_ASSETS_COUNT($status, $id, $search_query);
    $excess                     = $total_count % $limit;
    $data['C_DATA_COUNT']       = $total_count;
    $data['PAGES_COUNT']        = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']               = $page;
    $data['ROW']                = $limit;
    $data['C_ROW_DISPLAY']      = array(10, 25, 50);
    $data['TAB']                = $status;
    $data['DATE_FORMAT']        = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $data['DISP_ASSETS_INFO']   =   $this->selfservices_model->get_all_assets_info($limit, $offset, $status, $search_query, $row, $id);


    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_assets_views', $data);
  }

  function show_asset($id)
  {
    $id                             =   $this->session->userdata('SESS_USER_ID');
    $data['DISP_ASSET']        =   $this->selfservices_model->MOD_DISP_ASSET($id);
    $data['DATE_FORMAT']        = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/asset_show_views', $data);
  }


  function GET_SHIFT_ASSIGN()
  {
    $date                         = json_decode(file_get_contents('php://input'), true);
    $empl_id                      =  $this->session->userdata('SESS_USER_ID');

    $shift_id   = $this->selfservices_model->GET_ATTENDACE_SHIFT_ASSIGN($empl_id, $date);
    $result     = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE_SHIFT($shift_id);
    $attendance = $this->selfservices_model->GET_SPECIFIC_ATTENDANCE($empl_id, $date);

    $final_result = (object) array_merge((array) $result, (array) $attendance);
    echo json_encode($final_result);
  }

  function my_shifts_assignment()
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

    $data['DISP_EMPLOYEES']                   = $this->selfservices_model->GET_ALL_EMPLOYEE();
    $data['DISP_SHIFT']                       = $this->selfservices_model->GET_MY_SHIFT_APPROVALS($user_id);
    $data['C_DATA_COUNT']                     = 0;
    $data['FILTER']                           = $this->input->get('employee');

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/my_shift_assignment_views', $data);
  }

  function requested_shift($empl_id, $cutoff_period)
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

    $data['page'] = $this->input->get('page');
    $data['row'] = $this->input->get('row');
    $data['row_id'] = $this->input->get('row_id');

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/requested_shift_views', $data);
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
    $this->load->view('modules/selfservices/my_requested_shift_views', $data);
  }

  function assign_shift_data($dates, $holidays)
  {
    $data_arr = array();
    $index = 0;
    foreach ($dates as $date) {
      $data_arr[$index]["Date"] = $date;
      $is_found = FALSE;
      $is_match = FALSE;
      $current_date = $date->format("Y-m-d");
      foreach ($holidays as $holiday) {
        if ($holiday->col_holi_date == $current_date) {
          if ($holiday->col_holi_type == "Regular Holiday") {
            $data_arr[$index]["holi_type"] = "LEGAL";
          } else {
            $data_arr[$index]["holi_type"] = "SPECIAL";
          }
          $is_found = TRUE;
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


  function shift_request_approval()
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
    $data['DISP_SHIFT']                       = $this->selfservices_model->GET_SHIFT_APPROVALS($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team);
    $data['C_DATA_COUNT']                     = count($this->selfservices_model->GET_SHIFT_APPROVALS_COUNT($user_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team));
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

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/shift_request_approval_views', $data);
  }

  function bulk_approve_shifts()
  {
    header('Content-Type: application/json');
    try {
      $data = json_decode(file_get_contents('php://input'), true);
      $ids = $data['ids'];
      $status = $data['status'];
      $editUser = $this->session->userdata('SESS_USER_ID');

      if (empty($ids) || !is_array($ids)) {
        throw new Exception('Invalid request data');
      }

      foreach ($ids as $id) {
        $this->selfservices_model->update_shift_approval($id, $status, $editUser);
      }
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk approved shift requests');

      echo json_encode(['success_message' => 'Shift Requests Successfully Updated!']);
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(['warning_message' => 'Error: ' . $e->getMessage()]);
    }
  }

  function bulk_reject_shifts()
  {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    $ids = $data['ids'];
    $status = $data['status'];
    $userId = $this->session->userdata('SESS_USER_ID');

    try {
      foreach ($ids as $id) {
        $this->selfservices_model->update_shift_approval($id, $status, $userId);
      }
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk rejected shift requests');

      $response = ['success_message' => 'Shift Requests Rejected Successfully!'];
    } catch (Exception $e) {
      $response = ['warning_message' => 'Error during rejection: ' . $e->getMessage()];
    }

    echo json_encode($response);
  }

  function view_shifts()
  {
    $empl_id                        = $this->session->userdata('SESS_USER_ID');
    $period = $this->input->get('period');

    $data['CUTOFF_PERIODS'] = $this->selfservices_model->GET_CUTOFF_LIST();
    if (isset($period)) {
      // $date_period = $this->selfservices_model->GET_CUTOFF($period);
      $payroll_period =  $this->selfservices_model->GET_PAYROLL_PERIOD($period);
    } else {
      // $date_period = $this->selfservices_model->GET_CUTOFF($data['CUTOFF_PERIODS'][0]->id);
      $payroll_period =  $this->selfservices_model->GET_PAYROLL_PERIOD($data['CUTOFF_PERIODS'][0]->id);
    }
    $data['PERIOD'] = $period;
    // $payroll_period =  $this->selfservices_model->GET_PAYROLL_PERIOD($cutoff_period);

    $data['DISP_EMP_LIST_DATA'] =  $this->selfservices_model->GET_EMPLOYEELIST_DATA($empl_id);

    $begin = new DateTime($payroll_period->date_from);
    $end = new DateTime($payroll_period->date_to);
    $holidays = $this->selfservices_model->GET_HOLIDAY();
    $end = $end->modify('+1 day');
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval, $end);
    $data['SHIFT_DATA_DATERANGE'] = $this->selfservices_model->GET_SHIFT_DATA_DATERANGE_SELF($empl_id, $payroll_period->date_from, $payroll_period->date_to);
    $data['SHIFT_DATA'] = $this->selfservices_model->GET_SHIFT_ALL_DATA();
    $data["DATE_RANGE"] = $this->assign_shift_data($daterange, $holidays);


    $data['page'] = $this->input->get('page');
    $data['row'] = $this->input->get('row');

    $this->load->view('templates/header');
    $this->load->view('modules/selfservices/view_shifts_views', $data);
  }

  function update_shift_approval()
  {
    $data         = json_decode(file_get_contents('php://input'), true);
    $approveId    = $data['approveId'];
    $status       = $data['status'];
    $empl_id      = $data['empl_id'];
    $date_from    = $data['date_from'];
    $date_to      = $data['date_to'];

    try {
      $this->selfservices_model->update_shift_approval($approveId, $status, $this->session->userdata('SESS_USER_ID'));

      if ($status == 'Approved') {
        $result = $this->selfservices_model->transfer_data_to_main_attendance_assign($empl_id, $date_from, $date_to, $this->session->userdata('SESS_USER_ID'));
      }

      $response = array('success_message' => 'Data updated successfully');
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
    }
    echo json_encode($response);
  }





  function get_changeshift_approval($id)
  {

    $data['CHANGESHIFT']     = $this->selfservices_model->GET_CHANGESHIFT_APPROVAL_STATUS($id);

    $data['userId']     = $empl_id = $this->session->userdata('SESS_USER_ID');
    // $data['LEAVE'] = $this->selfservices_model->GET_LEAVE_APPROVAL_STATUS($id);
    $offset                  = $this->selfservices_model->GET_ROW_DATA('tbl_attendance_changeshift', $id);
    $data['C_APPROVERS']    = array();

    if ($offset->approver5 || $offset->approver5_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver5, $offset->approver5_date, $offset->status, 'Pending 5');
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver5_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_5);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver4 || $offset->approver4_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver4, $offset->approver4_date, $offset->status, 'Pending 4', $offset->approver5_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver4_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_4);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver3 || $offset->approver3_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver3, $offset->approver3_date, $offset->status, 'Pending 3', $offset->approver4_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver3_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_3);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver2 || $offset->approver2_b) {
      // $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($offset->approver2, $offset->approver2_date, $offset->status, 'Pending 2', $offset->approver3_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver2, $offset->approver2_date, $offset->status, 'Pending 2', $offset->approver3_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver2_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_2);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver1 || $offset->approver1_b) {
      // $data['C_APPROVERS'][] = $this->selfservices_model->GET_APPROVER_DATA($offset->approver1, $offset->approver1_date, $offset->status, 'Pending 1', $offset->approver2_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver1, $offset->approver1_date, $offset->status, 'Pending 1', $offset->approver2_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver1_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_1);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }

    $data['btn_status'] = '';
    if ($offset->status == 'Approved' || $offset->status == 'Rejected') {
      $data['btn_status'] = 'disabled';
    }
    if (($offset->approver1 || $offset->approver1_b) && !$offset->approved_by_1 && ($offset->approver2 == $empl_id || $offset->approver2_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }
    if (($offset->approved_by_1 == $empl_id) && ($offset->approver1 == $empl_id || $offset->approver1_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }

    $data['tableData'] = $this->selfservices_model->GET_CHANGESHIFT_APPROVAL_TABLE_DATA($id);
    $data['hours'] = $this->selfservices_model->GET_LEAVE_APPROVAL_HOURS($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $data['days'] = count($data['tableData']);
    $data['row_data']   = $offset;


    $this->load->view('modules/partials/_changeshift_approval_modal_content', $data);
  }

  function get_changeshift_approval_status($id)
  {

    $data['CHANGESHIFT']     = $this->selfservices_model->GET_CHANGESHIFT_APPROVAL_STATUS($id);

    $data['userId']     = $empl_id = $this->session->userdata('SESS_USER_ID');
    // $data['LEAVE'] = $this->selfservices_model->GET_LEAVE_APPROVAL_STATUS($id);
    $offset                  = $this->selfservices_model->GET_ROW_DATA('tbl_attendance_changeshift', $id);
    $data['C_APPROVERS']    = array();

    if ($offset->approver5 || $offset->approver5_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver5, $offset->approver5_date, $offset->status, 'Pending 5');
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver5_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_5);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver4 || $offset->approver4_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver4, $offset->approver4_date, $offset->status, 'Pending 4', $offset->approver5_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver4_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_4);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver3 || $offset->approver3_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver3, $offset->approver3_date, $offset->status, 'Pending 3', $offset->approver4_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver3_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_3);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver2 || $offset->approver2_b) {
      // $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($offset->approver2, $offset->approver2_date, $offset->status, 'Pending 2', $offset->approver3_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver2, $offset->approver2_date, $offset->status, 'Pending 2', $offset->approver3_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver2_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_2);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver1 || $offset->approver1_b) {
      // $data['C_APPROVERS'][] = $this->selfservices_model->GET_APPROVER_DATA($offset->approver1, $offset->approver1_date, $offset->status, 'Pending 1', $offset->approver2_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver1, $offset->approver1_date, $offset->status, 'Pending 1', $offset->approver2_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver1_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_1);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }

    $data['btn_status'] = '';
    if ($offset->status == 'Approved' || $offset->status == 'Rejected') {
      $data['btn_status'] = 'disabled';
    }
    if (($offset->approver1 || $offset->approver1_b) && !$offset->approved_by_1 && ($offset->approver2 == $empl_id || $offset->approver2_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }
    if (($offset->approved_by_1 == $empl_id) && ($offset->approver1 == $empl_id || $offset->approver1_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }

    $data['tableData'] = $this->selfservices_model->GET_CHANGESHIFT_APPROVAL_TABLE_DATA($id);
    $data['hours'] = $this->selfservices_model->GET_LEAVE_APPROVAL_HOURS($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $data['days'] = count($data['tableData']);
    $data['row_data']   = $offset;


    $this->load->view('modules/partials/_changeshift_approval_modal_content_status', $data);
  }



  function get_changeoff_approval($id)
  {

    $data['CHANGEOFF']     = $this->selfservices_model->GET_CHANGEOFF_APPROVAL_STATUS($id);

    $data['userId']     = $empl_id = $this->session->userdata('SESS_USER_ID');
    // $data['LEAVE'] = $this->selfservices_model->GET_LEAVE_APPROVAL_STATUS($id);
    $offset                  = $this->selfservices_model->GET_ROW_DATA('tbl_attendance_changeoff', $id);
    $data['C_APPROVERS']    = array();

    if ($offset->approver5 || $offset->approver5_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver5, $offset->approver5_date, $offset->status, 'Pending 5');
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver5_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_5);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver4 || $offset->approver4_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver4, $offset->approver4_date, $offset->status, 'Pending 4', $offset->approver5_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver4_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_4);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver3 || $offset->approver3_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver3, $offset->approver3_date, $offset->status, 'Pending 3', $offset->approver4_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver3_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_3);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver2 || $offset->approver2_b) {
      // $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($offset->approver2, $offset->approver2_date, $offset->status, 'Pending 2', $offset->approver3_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver2, $offset->approver2_date, $offset->status, 'Pending 2', $offset->approver3_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver2_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_2);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver1 || $offset->approver1_b) {
      // $data['C_APPROVERS'][] = $this->selfservices_model->GET_APPROVER_DATA($offset->approver1, $offset->approver1_date, $offset->status, 'Pending 1', $offset->approver2_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver1, $offset->approver1_date, $offset->status, 'Pending 1', $offset->approver2_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver1_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_1);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }

    $data['btn_status'] = '';
    if ($offset->status == 'Approved' || $offset->status == 'Rejected') {
      $data['btn_status'] = 'disabled';
    }
    if (($offset->approver1 || $offset->approver1_b) && !$offset->approved_by_1 && ($offset->approver2 == $empl_id || $offset->approver2_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }
    if (($offset->approved_by_1 == $empl_id) && ($offset->approver1 == $empl_id || $offset->approver1_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }

    $data['tableData'] = $this->selfservices_model->GET_CHANGESHIFT_APPROVAL_TABLE_DATA($id);
    $data['hours'] = $this->selfservices_model->GET_LEAVE_APPROVAL_HOURS($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $data['days'] = count($data['tableData']);
    $data['row_data']   = $offset;


    $this->load->view('modules/partials/_changeoff_approval_modal_content', $data);
  }


  function get_changeoff_approval_status($id)
  {

    $data['CHANGEOFF']     = $this->selfservices_model->GET_CHANGEOFF_APPROVAL_STATUS($id);

    $data['userId']     = $empl_id = $this->session->userdata('SESS_USER_ID');
    // $data['LEAVE'] = $this->selfservices_model->GET_LEAVE_APPROVAL_STATUS($id);
    $offset                  = $this->selfservices_model->GET_ROW_DATA('tbl_attendance_changeoff', $id);
    $data['C_APPROVERS']    = array();

    if ($offset->approver5 || $offset->approver5_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver5, $offset->approver5_date, $offset->status, 'Pending 5');
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver5_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_5);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver4 || $offset->approver4_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver4, $offset->approver4_date, $offset->status, 'Pending 4', $offset->approver5_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver4_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_4);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver3 || $offset->approver3_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver3, $offset->approver3_date, $offset->status, 'Pending 3', $offset->approver4_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver3_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_3);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver2 || $offset->approver2_b) {
      // $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($offset->approver2, $offset->approver2_date, $offset->status, 'Pending 2', $offset->approver3_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver2, $offset->approver2_date, $offset->status, 'Pending 2', $offset->approver3_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver2_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_2);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($offset->approver1 || $offset->approver1_b) {
      // $data['C_APPROVERS'][] = $this->selfservices_model->GET_APPROVER_DATA($offset->approver1, $offset->approver1_date, $offset->status, 'Pending 1', $offset->approver2_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($offset->approver1, $offset->approver1_date, $offset->status, 'Pending 1', $offset->approver2_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($offset->approver1_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($offset->approved_by_1);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }

    $data['btn_status'] = '';
    if ($offset->status == 'Approved' || $offset->status == 'Rejected') {
      $data['btn_status'] = 'disabled';
    }
    if (($offset->approver1 || $offset->approver1_b) && !$offset->approved_by_1 && ($offset->approver2 == $empl_id || $offset->approver2_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }
    if (($offset->approved_by_1 == $empl_id) && ($offset->approver1 == $empl_id || $offset->approver1_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }

    $data['tableData'] = $this->selfservices_model->GET_CHANGESHIFT_APPROVAL_TABLE_DATA($id);
    $data['hours'] = $this->selfservices_model->GET_LEAVE_APPROVAL_HOURS($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    $data['days'] = count($data['tableData']);
    $data['row_data']   = $offset;


    $this->load->view('modules/partials/_changeoff_approval_modal_content_status', $data);
  }


  function get_undertime_approval($id)
  {

    $data['CHANGEOFF']     = $this->selfservices_model->GET_UNDERTIME_APPROVAL_STATUS($id);

    $data['userId']     = $empl_id = $this->session->userdata('SESS_USER_ID');
    // $data['LEAVE'] = $this->selfservices_model->GET_LEAVE_APPROVAL_STATUS($id);
    $request                  = $this->selfservices_model->GET_ROW_DATA('tbl_attendance_undertime', $id);
    $data['C_APPROVERS']    = array();

    if ($request->approver5 || $request->approver5_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($request->approver5, $request->approver5_date, $request->status, 'Pending 5');
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($request->approver5_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($request->approved_by_5);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($request->approver4 || $request->approver4_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($request->approver4, $request->approver4_date, $request->status, 'Pending 4', $request->approver5_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($request->approver4_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($request->approved_by_4);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($request->approver3 || $request->approver3_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($request->approver3, $request->approver3_date, $request->status, 'Pending 3', $request->approver4_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($request->approver3_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($request->approved_by_3);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($request->approver2 || $request->approver2_b) {
      // $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($request->approver2, $request->approver2_date, $request->status, 'Pending 2', $request->approver3_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($request->approver2, $request->approver2_date, $request->status, 'Pending 2', $request->approver3_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($request->approver2_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($request->approved_by_2);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($request->approver1 || $request->approver1_b) {
      // $data['C_APPROVERS'][] = $this->selfservices_model->GET_APPROVER_DATA($request->approver1, $request->approver1_date, $request->status, 'Pending 1', $request->approver2_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($request->approver1, $request->approver1_date, $request->status, 'Pending 1', $request->approver2_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($request->approver1_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($request->approved_by_1);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }

    $data['btn_status'] = '';
    if ($request->status == 'Approved' || $request->status == 'Rejected') {
      $data['btn_status'] = 'disabled';
    }
    if (($request->approver1 || $request->approver1_b) && !$request->approved_by_1 && ($request->approver2 == $empl_id || $request->approver2_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }
    if (($request->approved_by_1 == $empl_id) && ($request->approver1 == $empl_id || $request->approver1_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }

    // $data['tableData'] = $this->selfservices_model->GET_CHANGESHIFT_APPROVAL_TABLE_DATA($id);
    // $data['hours'] = $this->selfservices_model->GET_LEAVE_APPROVAL_HOURS($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    // $data['days'] = count($data['tableData']);
    $data['row_data']   = $request;


    $this->load->view('modules/partials/_undertime_approval_modal_content', $data);
  }


  function get_exempt_undertime_approval($id)
  {

    $data['REQUEST_DATA']     = $this->selfservices_model->GET_EXEMPT_UNDERTIME_APPROVAL_STATUS($id);

    $data['userId']     = $empl_id = $this->session->userdata('SESS_USER_ID');
    // $data['LEAVE'] = $this->selfservices_model->GET_LEAVE_APPROVAL_STATUS($id);
    $request                  = $this->selfservices_model->GET_ROW_DATA('tbl_attendance_undertimerequest', $id);
    $data['C_APPROVERS']    = array();

    if ($request->approver5 || $request->approver5_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($request->approver5, $request->approver5_date, $request->status, 'Pending 5');
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($request->approver5_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($request->approved_by_5);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($request->approver4 || $request->approver4_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($request->approver4, $request->approver4_date, $request->status, 'Pending 4', $request->approver5_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($request->approver4_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($request->approved_by_4);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($request->approver3 || $request->approver3_b) {
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($request->approver3, $request->approver3_date, $request->status, 'Pending 3', $request->approver4_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($request->approver3_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($request->approved_by_3);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($request->approver2 || $request->approver2_b) {
      // $data['C_APPROVERS'][]  = $this->selfservices_model->GET_APPROVER_DATA($request->approver2, $request->approver2_date, $request->status, 'Pending 2', $request->approver3_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($request->approver2, $request->approver2_date, $request->status, 'Pending 2', $request->approver3_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($request->approver2_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($request->approved_by_2);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }
    if ($request->approver1 || $request->approver1_b) {
      // $data['C_APPROVERS'][] = $this->selfservices_model->GET_APPROVER_DATA($request->approver1, $request->approver1_date, $request->status, 'Pending 1', $request->approver2_date);
      $obj1 = $this->selfservices_model->GET_APPROVER_DATA($request->approver1, $request->approver1_date, $request->status, 'Pending 1', $request->approver2_date);
      $obj2 = $this->selfservices_model->GET_APPROVER_DATA_2($request->approver1_b);
      $obj3 = $this->selfservices_model->GET_APPROVED_BY($request->approved_by_1);
      $data['C_APPROVERS'][] = $this->merge_object($obj1, $obj2, $obj3);
    }

    $data['btn_status'] = '';
    if ($request->status == 'Approved' || $request->status == 'Rejected') {
      $data['btn_status'] = 'disabled';
    }
    if (($request->approver1 || $request->approver1_b) && !$request->approved_by_1 && ($request->approver2 == $empl_id || $request->approver2_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }
    if (($request->approved_by_1 == $empl_id) && ($request->approver1 == $empl_id || $request->approver1_b == $empl_id)) {
      $data['btn_status'] = 'disabled';
    }

    // $data['tableData'] = $this->selfservices_model->GET_CHANGESHIFT_APPROVAL_TABLE_DATA($id);
    // $data['hours'] = $this->selfservices_model->GET_LEAVE_APPROVAL_HOURS($id);
    $data['DATE_FORMAT']       = $this->selfservices_model->GET_SYSTEM_SETTING("date_format");
    // $data['days'] = count($data['tableData']);
    $data['row_data']   = $request;


    $this->load->view('modules/partials/_exempt_undertime_approval_modal_content', $data);
  }








} // class selfservices extends CI_Controller ENDS HERE =========================


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
function profile_image($file_name)
{
  if (file_exists(FCPATH . 'assets_user/user_profile/' . $file_name) && !empty($file_name)) {
    return base_url() . 'assets_user/user_profile/' . $file_name;
  } else {
    return base_url() . 'assets_system/images/default_user.jpg';
  }
}
function parseJsonData($rawData)
{
  $jsonData = json_decode($rawData, true);
  if (!is_array($jsonData) || json_last_error() !== JSON_ERROR_NONE) {
    throw new Exception('Invalid JSON data');
  }
  return $jsonData;
  $modules = array_unique($modules, SORT_REGULAR);
  return $modules;
}

function returnString($array, $name, $id)
{
  $string = '';
  foreach ($array as $item) {
    if ($item->id == $id) {
      $string = $item->$name;
      break;
    };
  }
  return $string;
}
