<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class overtimes extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('modules/overtimes_model');
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
      //array("title" => "Overtime Request",     "value" => "Overtime-Overtime Request",      "icon" => "clock-nine-duotone.svg",            "info" => "Lets you view and initiate an overtime request for hours worked beyond their regular work schedule. ",      "url" => "overtimes/overtime",         "access" => "Overtime", "id" => "overtime_overtime"),
      array("title" => "Holiday Work", "value" => "Overtime-Holiday Work",          "icon" => "calendar-xmark-duotone-2xl.svg",    "info" => "Lets you view and initiate a holiday work overtime request for hours worked on a recognized holiday. ",      "url" => "overtimes/holiday_works",    "access" => "Overtime", "id" => "overtime_holidaywork"),
    );



    $data["overtime_pending_count"]         = $this->overtimes_model->GET_PENDING_OVERTIME_COUNT();
    $data["holiday_work_pending_count"]     = $this->overtimes_model->GET_PENDING_HOLIDAY_WORK_COUNT();
    $data['settings']                       = "overtimes/setting_general";
    $data['settings']                       = "overtimes/overtime_step";

    $data["title_page"]                     = "Overtime Management";
    $data["title_description"]              = "Allows you to oversee and administer overtime policies, and ensure compliance with company regulations";
    $user_access_id                         = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE']          = $this->main_nav_model->GET_USER_ACCESS_PAGE($user_access_id['col_user_access']);
    $array_page                             = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
    $data["maiya_theme"]                    = $this->overtimes_model->GET_MAYA_THEME();
    $data['Modules']                        = filter_array($data["Modules"], $array_page);
    $this->load->view('templates/header');
    $this->load->view('templates/main_container', $data);
  }

  function setting_general()
  {
    $data['employee_list'] = $this->overtimes_model->GET_SYSTEM_SETTING("employee_list");
    // var_dump($data); die();
    $this->load->view('templates/header');
    $this->load->view('modules/overtimes/setting_general_views', $data);
  }

  function update_setting_employee_list()
  {
    $input_data = $this->input->post();
    $validKeys = [
      'employee_list',
    ];
    $input_data             = array_intersect_key($input_data, array_flip($validKeys));
    // var_dump($input_data); die();
    // echo '<pre>';
    // var_dump($input_data);die();
    // return;
    // $settings= array_keys($input_data);
    $res = $this->overtimes_model->update_settings($input_data);
    // var_dump($res);die();
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Overtime Settings Successfully updated');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated overtime employee list settings');
    } else {
      $this->session->set_flashdata('ERR', 'Overtime Settings Unable to update');
    }
    redirect($this->input->server('HTTP_REFERER'));
  }

  function overtime_step()
  {
    $data['DATA_LIST'] = json_encode($this->overtimes_model->GET_DEPARTMENTS2());

    $this->load->view('templates/header');
    $this->load->view('modules/overtimes/overtime_step_views', $data);
  }

  function update_departments()
  {
    $data                 = json_decode(file_get_contents('php://input'), true);
    try {
      $updatedData          = $data['updatedData'];
      $edit_user                         = $this->session->userdata('SESS_USER_ID');
      $failedInsert = 0;
      $inserted = 0;
      $failedUpdate = 0;
      $updated = 0;
      $unexpted = 0;
      foreach ($updatedData as $updatedData_row) {
        $res = $this->overtimes_model->update_departments($updatedData_row, $edit_user);
        if ($res == 'failedInsert') {
          $failedInsert++;
        } else if ($res == 'inserted') {
          $inserted++;
        } else if ($res == 'failedUpdate') {
          $failedUpdate++;
        } else if ($res == 'updated') {
          $updated++;
        } else {
          $unexpted++;
        }
      }
      $response           = array(
        'success_message' => 'Data updated successfully',
        'failedInsert' => $failedInsert,
        'inserted' => $inserted,
        'failedUpdate' => $failedUpdate,
        'updated' => $updated,
        'unexpted' => $unexpted,
      );
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated overtime departments');
    } catch (Exception $e) {
      $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
    }
    echo json_encode($response);
  }

  function overtime_hours()
  {

    $data['disable_overtime_hours']                     = $this->overtimes_model->get_system_setup_by_setting2('disable_overtime_hours', '0');

    $this->load->view('templates/header');
    $this->load->view('modules/overtimes/overtime_hours_views', $data);
  }

  function update_overtime_hours()
  {
    $input_data = $this->input->post();
    $validKeys = [
      'disable_overtime_hours',
    ];
    $input_data             = array_intersect_key($input_data, array_flip($validKeys));
    // echo '<pre>';
    // var_dump($input_data);
    // return;
    // $settings= array_keys($input_data);
    $res = $this->overtimes_model->update_system_setup($input_data);
    // var_dump($res);die();
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Overtime Settings Successfully Updated');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated overtime hours settings');
    } else {
      $this->session->set_flashdata('ERR', 'Overtime Settings Unable to Update');
    }
    redirect($this->input->server('HTTP_REFERER'));
  }

  // function overtime()
  // {
  //   $data['TABLE_DATA']                     =  array();
  //   $data['DATE_FORMAT']                    = $this->overtimes_model->GET_SYSTEM_SETTING("date_format");
  //   $status                                 =  $this->input->get('status');
  //   $limit                                  =  $this->input->get('row') ? $this->input->get('row')  : 50;
  //   $page                                   =  $this->input->get('page') ? $this->input->get('page') : 1;
  //   $offset                                 =  $limit * ($page - 1);
  //   $search                                 = $this->input->get('search');
  //   $user_id                                = $this->session->userdata('SESS_USER_ID');
  //   $filter_arr                             = array();
  //   $filter_arr['company']                  = $this->input->get('company');
  //   $filter_arr['branch']                   = $this->input->get('branch');
  //   $filter_arr['dept']                     = $this->input->get('dept');
  //   $filter_arr['div']                      = $this->input->get('div');
  //   $filter_arr['clubhouse']                = $this->input->get('clubhouse');
  //   $filter_arr['section']                  = $this->input->get('section');
  //   $filter_arr['group']                    = $this->input->get('group');
  //   $filter_arr['team']                     = $this->input->get('team');
  //   $filter_arr['line']                     = $this->input->get('line');

  //   // echo "<pre>";
  //   // echo "search";
  //   // echo "<br>";
  //   // print_r($search);
  //   // echo "<pre>"; die();

  //   $data['TABLE_DATA']                     = $this->overtimes_model->GET_OVERTIMES($status, $search, $limit, $offset, $filter_arr, $user_id);
  //   $total_count                            = $this->overtimes_model->GET_OVERTIMES_COUNT($status, $search, $filter_arr, $user_id);


  //   $data['STATUS']                         = $status;
  //   $data['STATUSES']                       = array('Pending', 'Approved', 'Rejected', 'Withdrawed', 'Cancelled');
  //   // $data['TABLE_DATA']                     = $this->overtimes_model->GET_OVERTIMES($status, $search, $limit, $offset, $filter_arr,$user_id);
  //   // $total_count                            = $this->overtimes_model->GET_OVERTIMES_COUNT($status, $search, $filter_arr,$user_id);
  //   $excess                                 = $total_count % $limit;
  //   $data['C_DATA_COUNT']                   = $total_count;
  //   $data['PAGES_COUNT']                    = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
  //   $data['PAGE']                           = $page;
  //   $data['ROW']                            = $limit;
  //   $data['C_ROW_DISPLAY']                  = array(50);

  //   $data['DEPARTMENTS']                    = $this->overtimes_model->GET_STD_DATA('tbl_std_departments');
  //   $data['COMPANIES']                      =   $this->overtimes_model->GET_STD_DATA('tbl_std_companies');
  //   $data['BRANCHES']                       =   $this->overtimes_model->GET_STD_DATA('tbl_std_branches');
  //   $data['DIVISIONS']                      =   $this->overtimes_model->GET_STD_DATA('tbl_std_divisions');
  //   $data['CLUBHOUSE']                      =   $this->overtimes_model->GET_STD_DATA('tbl_std_clubhouse');
  //   $data['SECTIONS']                       =   $this->overtimes_model->GET_STD_DATA('tbl_std_sections');
  //   $data['GROUPS']                         =   $this->overtimes_model->GET_STD_DATA('tbl_std_groups');
  //   $data['TEAMS']                          =   $this->overtimes_model->GET_STD_DATA('tbl_std_teams');
  //   $data['LINES']                          =   $this->overtimes_model->GET_STD_DATA('tbl_std_lines');

  //   // $data['DISP_VIEW_COMPANY']              = $this->overtimes_model->GET_SYSTEM_SETTING("com_company");
  //   // $data['DISP_VIEW_BRANCH']               = $this->overtimes_model->GET_SYSTEM_SETTING("com_branch");
  //   // $data['DISP_VIEW_DEPARTMENT']           = $this->overtimes_model->GET_SYSTEM_SETTING("com_Department");
  //   $data['DISP_VIEW_COMPANY']              = $this->overtimes_model->GET_SYSTEM_SETTING("com_company");
  //   $data['DISP_VIEW_BRANCH']               = $this->overtimes_model->GET_SYSTEM_SETTING("com_branch");
  //   $data['DISP_VIEW_DEPARTMENT']           = $this->overtimes_model->GET_SYSTEM_SETTING("com_Department");
  //   $data['DISP_VIEW_DIVISION']             = $this->overtimes_model->GET_SYSTEM_SETTING("com_division");
  //   $data['DISP_VIEW_CLUBHOUSE']             = $this->overtimes_model->GET_SYSTEM_SETTING("com_clubhouse");
  //   $data['DISP_VIEW_SECTION']              = $this->overtimes_model->GET_SYSTEM_SETTING("com_section");
  //   $data['DISP_VIEW_GROUP']                = $this->overtimes_model->GET_SYSTEM_SETTING("com_group");
  //   $data['DISP_VIEW_TEAM']                 = $this->overtimes_model->GET_SYSTEM_SETTING("com_team");
  //   $data['DISP_VIEW_LINE']                 = $this->overtimes_model->GET_SYSTEM_SETTING("com_line");
  //   // $data['EMPLOYEES']                      = $this->overtimes_model->GET_EMPLOYEES($user_id);
  //   $data['EMPLOYEES']                      = $this->overtimes_model->GET_EMPLOYEES_ALL();

  //   $data['multiple_request']                     = $this->overtimes_model->get_system_setup_by_setting('multiple_request', '0');

  //   $this->load->view('templates/header');
  //   $this->load->view('modules/overtimes/ovt_overtime_views', $data);
  // }
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
    $this->load->view('modules/overtimes/ovt_overtime_recommendation_views', $data);
  }
  function add_recommendation_overtime()
  {
    $input_data   = $this->input->post();
    $attendance   = $this->overtimes_model->GET_ROW_ATTENDANCE($input_data['attendance_id']);
    $user_id                                = $this->session->userdata('SESS_USER_ID');
    $is_enable_approvers                    = $this->overtimes_model->GET_SYSTEM_SETUP('requireApprovers');
    $input_data['create_date']              = date('Y-m-d H:i:s');
    $input_data['edit_date']                = date('Y-m-d H:i:s');
    $input_data['status']                   = 'Pending 1';
    $input_data['assigned_by']              = $user_id;
    $approvers                              = $this->overtimes_model->GET_USER_APPROVERS($input_data['empl_id']);
    $input_data['approver1'] = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers && $approvers->approver_2a ? $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers && $approvers->approver_3a ? $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers && $approvers->approver_4a ? $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers && $approvers->approver_5a ? $approvers->approver_5a : 0;
    $input_data['hours']    = $attendance->hours;
    $input_data['date_ot']  = $attendance->date_ot;
    unset($input_data['attendance_id']);
    // $input_data['reason']                   = $input_data['reason'];

    $approver                               = $approvers->approver_1a ? $approvers->approver_1a : 0;
    if ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0)
      && (!$approvers || $approvers->approver_3a == 0) && (!$approvers || $approvers->approver_4a == 0)
      && (!$approvers || $approvers->approver_5a == 0)
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
    $this->session->set_flashdata('SUCC', 'Successfully added');
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added recommendation overtime');
    }
    // if ($is_enable_approvers == 0) {
    //   redirect('overtimes/overtime');
    //   return;
    // }
    if ($res && $input_data['status'] != 'Approved') {
      $requestor      = $this->overtimes_model->GET_REQUESTOR('overtime', $res);
      $description    = "Overtime Application Review for [OVA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $input_data['approver1'], 'type' => 'overtime',
        'content_id' => $res, 'location' => 'selfservices/overtime_approval', 'description' => $description
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
        'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $input_data['approver1'], 'type' => 'overtime_approval',
        'content_id' => $res, 'location' => 'selfservices/overtime_approval', 'description' => $description
      );
      $notif_data['approve'] = 'approvals/approve_request?token=' . urlencode($encrypted_token);
      $notif_data['reject'] = 'approvals/reject_request?token=' . urlencode($encrypted_token);
      $notif = $this->overtimes_model->ADD_NOTIFICATION($notif_data);

      redirect('overtimes/overtime_recommendations');
      return;
    }
    redirect('overtimes/overtime_recommendations');
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
    $this->load->view('modules/overtimes/ovt_overtime_multi_views', $data);
  }

  function insert_overtimes_direct()
  {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    $updatedRequests = [];
    $notUpdatedRequests = [];
    $is_duplicate = null;
    // $resArray = [];
    // $data_rowArray = [];
    foreach ($data as $data_row) {
      $modified_data_row = $data_row;

      $modified_data_row['empl_id'] = $this->overtimes_model->GET_EMPLOYEE_TABLE_ID($data_row['employee']);

      if ($modified_data_row['empl_id'] === null) {
        $notUpdatedRequests[] = $data_row['employee'] . ' with Date ' . $data_row['date_ot'] . '(ID Not Found)';
        continue;
      }
      $date = $modified_data_row['date_ot'];
      $empl_id = $modified_data_row['empl_id'];
      $is_duplicate = $this->overtimes_model->GET_OVERTIME_IS_DUPLICATE_DATE($date, $empl_id);
      if ($is_duplicate < 0) {
        $notUpdatedRequests[] = $data_row['employee'] . ' with Date ' . $data_row['date_ot'] . '(Duplicate Employee and Date)';
        continue;
      }

      unset($modified_data_row['id']);
      unset($modified_data_row['employee']);
      $modified_data_row['edit_user'] = $this->session->userdata('SESS_USER_ID');
      $modified_data_row['create_date'] = date('Y-m-d H:i:s');
      $modified_data_row['edit_date'] = date('Y-m-d H:i:s');
      $modified_data_row['status'] = 'Approved';
      $res = $this->overtimes_model->ADD_OVERTIME_REQUEST($modified_data_row);
      $resArray[] = $res;

      if ($res) {
        $updatedRequests[] = $data_row['employee'] . ' with Date ' . $data_row['date_ot'];
      } else {
        $notUpdatedRequests[] = $data_row['employee'] . ' with Date ' . $data_row['date_ot'];
      }
      // $data_rowArray[] = $modified_data_row;
    }
    $joinedupdatedLeaves = '';
    $joinednotUpdatedLeaves = '';
    if (count($updatedRequests) > 0 && count($notUpdatedRequests) < 1) {
      $joinedupdatedLeaves = implode(', ', $updatedRequests);
      $this->session->set_flashdata('SUCC', 'Successfully added: ' . $joinedupdatedLeaves);
    } else {
      $joinednotUpdatedLeaves = implode(', ', $notUpdatedRequests);
      $joinedupdatedLeaves = implode(', ', $updatedRequests);
      if ($joinedupdatedLeaves) {
        $this->session->set_flashdata('ERR', 'Successfully added: ' . $joinedupdatedLeaves . '. But failed to add: ' . $joinednotUpdatedLeaves);
      } else {
        $this->session->set_flashdata('ERR', 'Unable to add: ' . $joinednotUpdatedLeaves);
      }
    }
    $response = array(
      'reload' => true,
      'joinedupdatedLeaves' => $joinedupdatedLeaves,
      'joinednotUpdatedLeaves' => $joinednotUpdatedLeaves,
      // 'resArray' => $resArray,
      // 'data_rowArray' => $data_rowArray,
      'date' => $date,
      'empl_id' => $empl_id,
      '$is_duplicate' => $is_duplicate,
    );

    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Inserted overtime directly');
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }
  function insert_holiday_work_direct()
  {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    $updatedRequests = [];
    $notUpdatedRequests = [];
    $is_duplicate = null;
    // $resArray = [];
    // $data_rowArray = [];
    foreach ($data as $data_row) {
      $modified_data_row = $data_row;

      $modified_data_row['empl_id'] = $this->overtimes_model->GET_EMPLOYEE_TABLE_ID($data_row['employee']);

      if ($modified_data_row['empl_id'] === null) {
        $notUpdatedRequests[] = $data_row['employee'] . ' with Date ' . $data_row['date'] . '(ID Not Found)';
        continue;
      }
      $date = $modified_data_row['date'];
      $empl_id = $modified_data_row['empl_id'];
      $is_duplicate = $this->overtimes_model->GET_HOLIDAY_WORK_IS_DUPLICATE_DATE_EMPL_ID($date, $empl_id);
      if ($is_duplicate > 0) {
        $notUpdatedRequests[] = $data_row['employee'] . ' with Date ' . $data_row['date'] . '(Duplicate Employee and Date)';
        continue;
      }

      unset($modified_data_row['id']);
      unset($modified_data_row['employee']);
      $modified_data_row['edit_user'] = $this->session->userdata('SESS_USER_ID');
      $modified_data_row['create_date'] = date('Y-m-d H:i:s');
      $modified_data_row['edit_date'] = date('Y-m-d H:i:s');
      $modified_data_row['status'] = 'Approved';
      $res = $this->overtimes_model->ADD_HOLIDAY_WORK_REQUEST($modified_data_row);
      $resArray[] = $res;

      if ($res) {
        $updatedRequests[] = $data_row['employee'] . ' with Date ' . $data_row['date'];
      } else {
        $notUpdatedRequests[] = $data_row['employee'] . ' with Date ' . $data_row['date'];
      }
      // $data_rowArray[] = $modified_data_row;
    }
    $joinedupdatedRequests = '';
    $joinednotUpdatedRequests = '';
    if (count($updatedRequests) > 0 && count($notUpdatedRequests) < 1) {
      $joinedupdatedRequests = implode(', ', $updatedRequests);
      $this->session->set_flashdata('SUCC', 'Successfully added: ' . $joinedupdatedRequests);
    } else {
      $joinednotUpdatedRequests = implode(', ', $notUpdatedRequests);
      $joinedupdatedRequests = implode(', ', $updatedRequests);
      if ($joinedupdatedRequests) {
        $this->session->set_flashdata('ERR', 'Successfully added: ' . $joinedupdatedRequests . '. But failed to add: ' . $joinednotUpdatedRequests);
      } else {
        $this->session->set_flashdata('ERR', 'Unable to add: ' . $joinednotUpdatedRequests);
      }
    }
    $response = array(
      'reload' => true,
      'joinedupdatedRequests' => $joinedupdatedRequests,
      'joinednotUpdatedRequests' => $joinednotUpdatedRequests,
      // 'resArray' => $resArray,
      // 'data_rowArray' => $data_rowArray,
      'date' => $date,
      'empl_id' => $empl_id,
      '$is_duplicate' => $is_duplicate,
    );

    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Inserted holiday work directly');
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }

  function new_request_overtime_direct()
  {
    $data['DISP_EMPLOYEES_NONFILTERED']     = $this->overtimes_model->GET_EMPLOYEES_ALL();
    $this->load->view('templates/header');
    $this->load->view('modules/overtimes/new_overtime_request_direct_views', $data);
  }

  function new_holiday_work_request_direct()
  {
    $data['DISP_EMPLOYEES_NONFILTERED']     = $this->overtimes_model->GET_EMPLOYEES_ALL();
    $this->load->view('templates/header');
    $this->load->view('modules/overtimes/new_holiday_work_request_direct_views', $data);
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
    $this->load->view('modules/overtimes/add_overtime_views', $data);
  }


  public function check_holiday()
  {
    $selectedDate = $this->input->post('date');
    $isHoliday = $this->overtimes_model->MOD_DISP_HOLIDAY_BASED_DATE($selectedDate);
    $response = array(
      'isHoliday' => !empty($isHoliday),
      'holidayType' => (!empty($isHoliday)) ? $isHoliday[0]->col_holi_type : null
    );
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }

  function update_overtimes_direct()
  {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    // $res = $this->employees_model->UPDATE_WORK_HISTORY_ALL($data_row,$this->session->userdata('SESS_USER_ID'));

    $updatedRequests = [];
    $notUpdatedRequests = [];
    $is_duplicate = null;
    // $resArray = [];
    // $data_rowArray = [];
    foreach ($data as $data_row) {
      $modified_data_row = $data_row;

      $modified_data_row['edit_date'] = date('Y-m-d H:i:s');
      $modified_data_row['empl_id'] = $this->overtimes_model->GET_EMPLOYEE_TABLE_ID($data_row['employee']);

      if ($modified_data_row['empl_id'] === null) {
        $notUpdatedRequests[] = $data_row['c_id'] . '(ID Not Found)';
        continue;
      }
      $date = $modified_data_row['date_ot'];
      $empl_id = $modified_data_row['empl_id'];
      $id = $modified_data_row['id'];

      $is_duplicate = $this->overtimes_model->GET_OVERTIME_IS_DUPLICATE_DATE_BY_ID($date, $empl_id, $id);
      if ($is_duplicate < 0) {
        $notUpdatedRequests[] = $data_row['c_id'] . '(Duplicate Employee and Date)';
        continue;
      }
      unset($modified_data_row['id']);
      unset($modified_data_row['employee']);
      unset($modified_data_row['assigned_by_tb_id']);
      unset($modified_data_row['employee_tb_id']);
      $modified_data_row['edit_user'] = $this->session->userdata('SESS_USER_ID');
      $res = $this->overtimes_model->UPDATE_OVERTIME($modified_data_row, $id);
      $resArray[] = $res;

      if ($res) {
        $updatedRequests[] = $data_row['c_id'];
      } else {
        $notUpdatedRequests[] = $data_row['c_id'];
      }
      // $data_rowArray[] = $modified_data_row;
    }
    $joinedupdatedRequests = '';
    $joinednotUpdatedRequests = '';
    if (count($updatedRequests) > 0 && count($notUpdatedRequests) < 1) {
      $joinedupdatedRequests = implode(', ', $updatedRequests);
      // $this->session->set_flashdata('SUCC', 'Successfully updated: ' . $joinedupdatedRequests);
      $message = 'Successfully updated: ' . $joinedupdatedRequests;
      $success = true;
    } else {
      $joinednotUpdatedRequests = implode(', ', $notUpdatedRequests);
      $joinedupdatedRequests = implode(', ', $updatedRequests);
      if ($joinedupdatedRequests) {
        // $this->session->set_flashdata('ERR', 'Successfully updated: ' . $joinedupdatedRequests . '. But failed to update: ' . $joinednotUpdatedRequests);
        $message = 'Successfully updated: ' . $joinedupdatedRequests . '. But failed to update: ' . $joinednotUpdatedRequests;
        $success = false;
      } else {
        // $this->session->set_flashdata('ERR', 'Unable to update: ' . $joinednotUpdatedRequests);
        $message =  'Unable to update: ' . $joinednotUpdatedRequests;
        $success = false;
      }
    }
    $response = array(
      'success' => $success,
      'message' => $message,
      'joinedupdatedRequests' => $joinedupdatedRequests,
      'joinednotUpdatedRequests' => $joinednotUpdatedRequests,
      // 'resArray' => $resArray,
      // 'data_rowArray' => $data_rowArray,
      'date' => $date,
      'empl_id' => $empl_id,
      'id' => $id,
      '$is_duplicate' => $is_duplicate,
    );

    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated overtime directly');
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }

  function update_holiday_works_direct()
  {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    // $res = $this->employees_model->UPDATE_WORK_HISTORY_ALL($data_row,$this->session->userdata('SESS_USER_ID'));

    $updatedRequests = [];
    $notUpdatedRequests = [];
    $is_duplicate = null;
    // $resArray = [];
    // $data_rowArray = [];
    foreach ($data as $data_row) {
      $modified_data_row = $data_row;

      $modified_data_row['edit_date'] = date('Y-m-d H:i:s');
      $modified_data_row['empl_id'] = $this->overtimes_model->GET_EMPLOYEE_TABLE_ID($data_row['employee']);

      if ($modified_data_row['empl_id'] === null) {
        $notUpdatedRequests[] = $data_row['c_id'] . '(ID Not Found)';
        continue;
      }
      $date = $modified_data_row['date'];
      $empl_id = $modified_data_row['empl_id'];
      $id = $modified_data_row['id'];

      $is_duplicate = $this->overtimes_model->GET_HOLIDAY_WORKS_IS_DUPLICATE_DATE_BY_ID($date, $empl_id, $id);
      if ($is_duplicate > 0) {
        $notUpdatedRequests[] = $data_row['c_id'] . '(Duplicate Employee and Date)';
        continue;
      }
      unset($modified_data_row['id']);
      unset($modified_data_row['employee']);
      unset($modified_data_row['assigned_by_tb_id']);
      unset($modified_data_row['employee_tb_id']);
      $modified_data_row['edit_user'] = $this->session->userdata('SESS_USER_ID');
      $res = $this->overtimes_model->UPDATE_HOLIDAY_WORKS($modified_data_row, $id);
      $resArray[] = $res;

      if ($res) {
        $updatedRequests[] = $data_row['c_id'];
      } else {
        $notUpdatedRequests[] = $data_row['c_id'];
      }
      // $data_rowArray[] = $modified_data_row;
    }
    $joinedupdatedRequests = '';
    $joinednotUpdatedRequests = '';
    if (count($updatedRequests) > 0 && count($notUpdatedRequests) < 1) {
      $joinedupdatedRequests = implode(', ', $updatedRequests);
      // $this->session->set_flashdata('SUCC', 'Successfully updated: ' . $joinedupdatedRequests);
      $message = 'Successfully updated: ' . $joinedupdatedRequests;
      $success = true;
    } else {
      $joinednotUpdatedRequests = implode(', ', $notUpdatedRequests);
      $joinedupdatedRequests = implode(', ', $updatedRequests);
      if ($joinedupdatedRequests) {
        // $this->session->set_flashdata('ERR', 'Successfully updated: ' . $joinedupdatedRequests . '. But failed to update: ' . $joinednotUpdatedRequests);
        $message = 'Successfully updated: ' . $joinedupdatedRequests . '. But failed to update: ' . $joinednotUpdatedRequests;
        $success = false;
      } else {
        // $this->session->set_flashdata('ERR', 'Unable to update: ' . $joinednotUpdatedRequests);
        $message =  'Unable to update: ' . $joinednotUpdatedRequests;
        $success = false;
      }
    }
    $response = array(
      'success' => $success,
      'message' => $message,
      'joinedupdatedRequests' => $joinedupdatedRequests,
      'joinednotUpdatedRequests' => $joinednotUpdatedRequests,
      // 'resArray' => $resArray,
      // 'data_rowArray' => $data_rowArray,
      'date' => $date,
      'empl_id' => $empl_id,
      'id' => $id,
      '$is_duplicate' => $is_duplicate,
    );

    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated holiday work directly');
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
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

    // $input_data['reason']                   = $input_data['reason'];

    $approver                               = $approvers->approver_1a ? $approvers->approver_1a : 0;

    $autoApprovedEnabled  = $this->overtimes_model->getApprovalAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('overtimes/request_overtime');
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
    $this->session->set_flashdata('SUCC', 'Successfully added');
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added overtime request');
    }
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

      redirect('overtimes/overtime');
      return;

    }
    redirect('overtimes/overtime');

    // if ($res) {
    //   $this->session->set_flashdata('SUCC', 'Successfully added');
    // } else {
    //   $this->session->set_flashdata('ERR', 'Fail to add new data');
    //   redirect('attendances/add_overtime');
    //   return;
    // }
    // redirect('overtimes/overtime');
  }

  function cancel_overtime()
  {
    $input_data   = $this->input->post();
    $user_id      = $this->session->userdata('SESS_USER_ID');
    $res          = $this->overtimes_model->CANCEL_OT($input_data['id'], $user_id);
    $this->session->set_flashdata('SUCC', 'Withdraw Overtime Successfully Updated!');
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Cancelled overtime request');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function cancel_approved_overtime()
  {
    $input_data   = $this->input->post();
    $user_id      = $this->session->userdata('SESS_USER_ID');
    $res          = $this->overtimes_model->CANCEL_APPROVED_OT($input_data['id'], $user_id, $input_data['comment']);
    $this->session->set_flashdata('SUCC', 'Withdraw Overtime Successfully Updated!');
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Cancelled approved overtime');
    redirect($this->input->server('HTTP_REFERER'));
  }

  function get_shift_type()
  {
    $input_data = $this->input->post();
    $data = $this->overtimes_model->GET_SHIFT_TYPE($input_data['empl'], $input_data['date']);
    echo json_encode($data);
  }

  function get_attendance_record()
{
    $input_data = $this->input->post();
    $data['attendance'] = $attendances = $this->overtimes_model->GET_ATTENDANCE_RECORD($input_data['empl'], $input_data['date']);
    $data['shift'] = $shifts = $this->overtimes_model->GET_SHIFT_TYPE($input_data['empl'], $input_data['date']);

    $night_diff_hours = 0;
    $overtime = 0;

    if ($attendances && $shifts) {
        $date = strtotime($input_data['date']);
        
        $time_regular_start = strtotime($shifts->time_regular_start, $date);
        $time_regular_end = strtotime($shifts->time_regular_end, $date);
        $time_in = strtotime($attendances->time_in, $date);
        $time_out = strtotime($attendances->time_out, $date);

        // Adjust times if they cross midnight
        if ($time_out <= $time_in) {
            $time_out = strtotime('+1 day', $time_out);
        }

        if ($time_regular_end <= $time_regular_start) {
            $time_regular_end = strtotime('+1 day', $time_regular_end);
        }

        // Define night differential period (10pm to 6am next day)
        $night_start = strtotime('22:00:00', $date);
        $night_end = strtotime('06:00:00', strtotime('+1 day', $date));

        // Calculate overtime hours
        if ($time_out > $time_regular_end) {
            $overtime_start = $time_regular_end;
            $overtime_end = $time_out;
            
            $total_overtime_seconds = $overtime_end - $overtime_start;
            
            // Calculate overlap between overtime and night differential period (10pm-6am)
            $ot_night_start = max($overtime_start, $night_start);
            $ot_night_end = min($overtime_end, $night_end);
            
            if ($ot_night_end > $ot_night_start) {
                // NDOT hours (overtime during 10pm-6am)
                $night_diff_hours = ($ot_night_end - $ot_night_start) / 3600;
                
                // Regular OT hours (overtime outside 10pm-6am)
                $overtime = ($total_overtime_seconds / 3600) - $night_diff_hours;
            } else {
                // All overtime is outside night diff period
                $overtime = $total_overtime_seconds / 3600;
            }
        }

        // Calculate night differential during regular hours (if any)
        $regular_work_end = min($time_out, $time_regular_end);
        
        $regular_night_start = max($time_in, $night_start);
        $regular_night_end = min($regular_work_end, $night_end);
        
        if ($regular_night_end > $regular_night_start) {
            $regular_nd_hours = ($regular_night_end - $regular_night_start) / 3600;
            $night_diff_hours += $regular_nd_hours;
        }

        // Round to avoid floating point issues
        $overtime = round($overtime, 2);
        $night_diff_hours = round($night_diff_hours, 2);
        
        // Zero out if less than 1 hour
        if ($overtime < 1) {
            $overtime = 0;
        }
        
        if ($night_diff_hours < 1) {
            $night_diff_hours = 0;
        }
    }

    $data['overtime_hours'] = $overtime;
    $data['ndot'] = $night_diff_hours;

    echo json_encode($data);
}

  function get_shift_out()
  {
    $input_data = $this->input->post();

    $data = $this->overtimes_model->GET_SHIFT_OUT($input_data['empl'], $input_data['date']);
    echo json_encode($data);
  }

  function get_department_min_hour()
  {
    $input_data = $this->input->post();
    $data = $this->overtimes_model->GET_DEPARTMENT_MIN_HOUR($input_data['empl']);
    echo json_encode($data);
  }

  function holiday_works()
  {
    $data['TABLE_DATA']                     = array();
    $data['DATE_FORMAT']                    = $this->overtimes_model->GET_SYSTEM_SETTING("date_format");
    $status                                 = $this->input->get('status');
    $limit                                  = $this->input->get('row') ? $this->input->get('row')  : 25;
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

    $data['TABLE_DATA']                     = $this->overtimes_model->GET_HOLIDAY_WORKS($status, $search, $limit, $offset, $filter_arr);
    $total_count                            = $this->overtimes_model->GET_HOLIDAY_WORKS_COUNT($search, $status, $filter_arr);

    $excess                                 = $total_count % $limit;
    $data['C_DATA_COUNT']                   = $total_count;
    $data['PAGES_COUNT']                    = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                           = $page;
    $data['ROW']                            = $limit;
    $data['C_ROW_DISPLAY']                  = array(10, 25, 50);

    $data['DEPARTMENTS']                    = $this->overtimes_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES']                      = $this->overtimes_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES']                       = $this->overtimes_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS']                      = $this->overtimes_model->GET_STD_DATA('tbl_std_divisions');
    $data['CLUBHOUSE']                      = $this->overtimes_model->GET_STD_DATA('tbl_std_clubhouse');
    $data['SECTIONS']                       = $this->overtimes_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS']                         = $this->overtimes_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS']                          = $this->overtimes_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES']                          = $this->overtimes_model->GET_STD_DATA('tbl_std_lines');

    $data['DISP_VIEW_COMPANY']              = $this->overtimes_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']               = $this->overtimes_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']           = $this->overtimes_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']             = $this->overtimes_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE']             = $this->overtimes_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION']              = $this->overtimes_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                = $this->overtimes_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                 = $this->overtimes_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                 = $this->overtimes_model->GET_SYSTEM_SETTING("com_line");

    $data['EMPLOYEES']                      = $this->overtimes_model->GET_EMPLOYEES_ALL();
    $data['multiple_request']               = $this->overtimes_model->get_system_setup_by_setting('multiple_request', '0');

    $this->load->view('templates/header');
    $this->load->view('modules/overtimes/ovt_holiday_work_views', $data);
  }
  function holiday_works_multi()
  {
    $data['TABLE_DATA']                                     = array();
    $status                                 = $this->input->get('status');
    $limit                                  = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                   = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                 =  $limit * ($page - 1);
    $search                                 = $this->input->get('search');

    $filter_arr                             = array();
    $filter_arr['company']                  = $this->input->get('company');
    $filter_arr['branch']                   = $this->input->get('branch');
    $filter_arr['dept']                     = $this->input->get('dept');
    $filter_arr['div']                      = $this->input->get('div');
    $filter_arr['section']                  = $this->input->get('section');
    $filter_arr['group']                    = $this->input->get('group');
    $filter_arr['team']                     = $this->input->get('team');
    $filter_arr['line']                     = $this->input->get('line');

    $data['STATUS']                         = $status;
    $data['STATUSES']                       = array('Pending', 'Approved', 'Rejected');

    $data['TABLE_DATA']                     = $this->overtimes_model->GET_HOLIDAY_WORKS_DIRECT($status, $search, $limit, $offset, $filter_arr);
    $total_count                            = $this->overtimes_model->GET_HOLIDAY_WORKS_COUNT($search, $status, $filter_arr);

    $excess                                 = $total_count % $limit;
    $data['C_DATA_COUNT']                   = $total_count;
    $data['PAGES_COUNT']                    = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                           = $page;
    $data['ROW']                            = $limit;
    $data['C_ROW_DISPLAY']                  = array(10, 25, 50);

    $data['DEPARTMENTS']                    = $this->overtimes_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES']                      = $this->overtimes_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES']                       = $this->overtimes_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS']                      = $this->overtimes_model->GET_STD_DATA('tbl_std_divisions');
    $data['SECTIONS']                       = $this->overtimes_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS']                         = $this->overtimes_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS']                          = $this->overtimes_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES']                          = $this->overtimes_model->GET_STD_DATA('tbl_std_lines');

    $data['DISP_VIEW_COMPANY']              = $this->overtimes_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']               = $this->overtimes_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']           = $this->overtimes_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']             = $this->overtimes_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION']              = $this->overtimes_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']                = $this->overtimes_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                 = $this->overtimes_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                 = $this->overtimes_model->GET_SYSTEM_SETTING("com_line");

    $data['EMPLOYEES']                      = $this->overtimes_model->GET_EMPLOYEES_ALL();

    $this->load->view('templates/header');
    $this->load->view('modules/overtimes/ovt_holiday_work_multi_views', $data);
  }

  function request_holiday_work()
  {
    $data['C_EMPLOYEES']                    = $this->overtimes_model->GET_EMPLOYEELIST();
    $this->load->view('templates/header');
    $this->load->view('modules/overtimes/add_holiday_work_views', $data);
  }

  function add_new_holiday_work()
  {
    $input_data                             = $this->input->post();
    $input_data['status']                   = 'Pending 1';
    $input_data['create_date']              = date('Y-m-d H:i:s');
    $input_data['edit_date']                = date('Y-m-d H:i:s');
    $approvers                              = $this->overtimes_model->GET_USER_APPROVERS($input_data['empl_id']);
    if (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0))) {
      $input_data['status'] = 'Approved';
    }
    $input_data['approver1'] = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $input_data['approver2'] = $approvers && $approvers->approver_2a ? $approvers->approver_2a : 0;
    $input_data['approver3'] = $approvers && $approvers->approver_3a ? $approvers->approver_3a : 0;
    $input_data['approver4'] = $approvers && $approvers->approver_4a ? $approvers->approver_4a : 0;
    $input_data['approver5'] = $approvers && $approvers->approver_5a ? $approvers->approver_5a : 0;
    $res                                    = $this->overtimes_model->ADD_DATA('tbl_holidaywork', $input_data);
    if ($res) {
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added holiday work request');
    }
    if ($res && $input_data['status'] != 'Approved') {
      $requestor                    = $this->overtimes_model->GET_REQUESTOR('holiday work', $res);
      $description                  = "Holiday Work Application Review for [HDW" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
      $notif_data                   = array(
        'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $input_data['approver1'], 'type' => 'holiday_work_approval',
        'content_id' => $res, 'location' => 'selfservices/holidaywork_approval', 'description' => $description
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

      $notif = $this->overtimes_model->ADD_NOTIFICATION($notif_data);
      $this->session->set_flashdata('SUCC', 'Successfully added');
    }
    redirect('overtimes/holiday_works');
  }

  function upload_file($path)
  {
    $config['upload_path']                  = $path;
    $config['max_size']                     = 10000;
    $config['allowed_types']                = '*';
    $config['overwrite']                    = 'TRUE';
    $this->load->library('upload', $config);
    if (!$this->upload->do_upload('attachment')) {
      $error = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('ERR', $error['error']);

      return false;
    }
    return true;
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

      $res = $this->overtimes_model->GET_REPORTING_TO_DIRECTS($updatedData);
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
