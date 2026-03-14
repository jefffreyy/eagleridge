<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class home extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    
    $this->load->model('home/home_model');
    $this->load->library('system_functions');
    $this->load->library('logger');
    $this->load->model('modules/leaves_model');
    $this->load->model('modules/administrators_model');

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

    $maintenance = $this->login_model->GET_MAINTENANCE();
    $isAdmin = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }

  function index()
  {
    $user_id = $this->session->userdata('SESS_USER_ID');

    $data['HOME_ANNOUNCEMENT']                          = $this->administrators_model->get_system_setup_by_setting('home_announcement');
    $data['HOME_CELEBRATION']                           = $this->administrators_model->get_system_setup_by_setting('home_celebration');
    $data['HOME_LEAVE_INFO']                            = $this->administrators_model->get_system_setup_by_setting('home_leave_info');
    $data['HOME_NEW_MEMBER']                            = $this->administrators_model->get_system_setup_by_setting('home_new_member');
    $data['HOME_HOLIDAY']                               = $this->administrators_model->get_system_setup_by_setting('home_upcoming_holidays');
  

    $data['LEAVE_SETTINGS']                         = $this->leaves_model->GET_ALL_LEAVE_SETTING();
    $data["CURRENT_TIME"]                           = date("D, M d, Y");
    $data["WELCOME_MESSAGE"]                        = $this->home_model->GET_WELCOME_MESSAGE();
    // $data["WELCOME_MESSAGE"]                        = 'testcontroller';
    $data["ANNOUNCEMENT_STATUS"]                    = $this->home_model->GET_HOME_ANNOUNCEMENT();
    $data["CELEB_STATUS"]                           = $this->home_model->GET_HOME_CELEBRATION();
    $data["DATE_STATUS"]                            = $this->home_model->GET_HOME_DATE();
    $data["LEAVE_STATUS"]                           = $this->home_model->GET_HOME_LEAVE();
    $data["TEAM_MEMBERS_STATUS"]                    = $this->home_model->GET_SYSTEM_SETUP('home_team_members');
    $data["WHOS_OUT_STATUS"]                        = $this->home_model->GET_HOME_WHOS_OUT();
    $data["HOLIDAY_STATUS"]                         = $this->home_model->GET_SYSTEM_SETUP('home_holiday');
    $data["START_GUIDE_STATUS"]                     = $this->home_model->GET_HOME_START_GUIDE();
    $data["NEW_MEMBER_STATUS"]                      = $this->home_model->GET_HOME_NEW_MEMBER();
    $data["MYTIME_RECORD_STATUS"]                   = $this->home_model->GET_MYTIME_RECORD_STATUS();
    $data["MYATTENDACE_SUMMARY_STATUS"]             = $this->home_model->GET_MYATTENDACE_SUMMARY_STATUS();
    $data["HOME_REQUEST_STATUS"]                    = $this->home_model->GET_HOME_REQUEST_STATUS();
    $data["HOME_APPROVAL_STATUS"]                    = $this->home_model->GET_HOME_APPROVAL_STATUS();
    $data["HOME_UPCOMING_HOLIDAYS_STATUS"]                    = $this->home_model->GET_HOME_UPCOMING_HOLIDAYS_STATUS();

    $data['isholiday']                              = $this->home_model->MOD_DISP_HOLIDAY_BASED_DATE(date('Y-m-d'));
    $data['DISP_USER_INFO']                         = $this->home_model->MOD_DISP_HOME($user_id);
    $data['DISP_ANNOUNCEMENTS_INFO']                = $this->home_model->MOD_DISP_ANNOUNCEMENTS(2);
    $data['DISP_EMPOLYEE_INFO']                     = $this->home_model->MOD_DISP_ALL_EMPLOYEES_BY_DATE();

    $data['DISP_ON_LEAVE']                          = $this->home_model->MOD_DISP_ON_LEAVE();
    $data['desktop_logo']                           = $this->home_model->GET_DESKTOP_LOGO()['value'];
    $data['mobile_logo']                            = $this->home_model->GET_MOBILE_LOGO()['value'];
    $data['DISP_NEW_EMP']                           = $this->home_model->DISP_NEW_EMP_MONTH();
    $data['DISP_HOLIDAYS']                          = $this->home_model->GET_HOLIDAYS();
    $data['C_POSITIONS']                            = $this->home_model->GET_POSITION();

    $data['NOTIFICATIONS_COUNT']                    = $this->home_model->NOTIFICATION_COUNT($user_id);
    $data['PENDINGLEAVE_COUNT']                     = $this->home_model->LEAVE_PENDING_COUNT($user_id);
    $data['PENDINGOT_COUNT']                        = $this->home_model->OVERTIME_PENDING_COUNT($user_id);
    //$data['PENDINGAPPROVAL_COUNT']                  = $this->home_model->OVERTIMEAPPROVAL_COUNT($user_id) + $this->home_model->LEAVEAPPROVAL_COUNT($user_id) + $this->home_model->ADJUSTMENTAPPROVAL_COUNT($user_id) + $this->home_model->HOLIDAYAPPROVAL_COUNT($user_id);

    $data['PENDING_LEAVE_APPROVAL_COUNT']           = $this->home_model->LEAVEAPPROVAL_COUNT($user_id);
    $data['PENDING_OVERTIME_APPROVAL_COUNT']        = $this->home_model->OVERTIMEAPPROVAL_COUNT($user_id);
    $data['PENDING_CHNAGESHIFT_APPROVAL_COUNT']     = $this->home_model->CHANGESHIFTAPPROVAL_COUNT($user_id);
    $data['PENDING_CHNAGEOFF_APPROVAL_COUNT']       = $this->home_model->CHANGEOFFAPPROVAL_COUNT($user_id);
    $data['PENDING_OFFSET_APPROVAL_COUNT']          = $this->home_model->OFFSETAPPROVAL_COUNT($user_id);

    $data['REMAINING_SIL_HOURS']                    = $this->home_model->REMAINING_SIL_HOURS($user_id)      - $this->home_model->USED_SIL_HOURS($user_id);
    $data['REMAINING_VACATION_HOURS']               = $this->home_model->REMAINING_VACATION_HOURS($user_id) - $this->home_model->USED_VACATION_HOURS($user_id);
    $data['REMAINING_SICK_HOURS']                   = $this->home_model->REMAINING_SICK_HOURS($user_id)     - $this->home_model->USED_SICK_HOURS($user_id);
    // $data['REMAINING_SICK_HOURS']                   = $this->home_model->REMAINING_SICK_HOURS($user_id);
    $data['REMAINING_OFFSET_HOURS']                 = $this->home_model->OFFSET_APPROVED_COUNT($user_id);

    // Biometrics In/out starts
    $empl_id = $this->session->userdata('SESS_USER_ID');
    $shift_assign = $this->home_model->GET_ATTENDANCE_SHIFT_ASSIGN_ID_TODAY_BY_EMP_ID($empl_id);
    $shiftIn = null;
    $shiftOut = null;
    $punchIn = null;
    $punchOut = null;

    $period_date_start = '';
    $target_date_start = '';
    $period_date_end = '';
    $target_date_end = '';
    $cutOffPeriod  = '';
    $shift_specific = $this->home_model->GET_ATTENDANCE_SHIFT_BY_ID(!empty($shift_assign[1]['shift_id']) ? $shift_assign[1]['shift_id'] : null);
    $data['recordsTodayZKTECO'] = null;
    if ($shift_specific) {
      if (!empty($shift_specific[0]['time_regular_start']) && ($timestamp = strtotime($shift_specific[0]['time_regular_start'])) !== false) {
        $shiftIn = date('g:ia', $timestamp);
      }
      if (!empty($shift_specific[0]['time_regular_end']) && ($timestamp = strtotime($shift_specific[0]['time_regular_end'])) !== false) {
        $shiftOut = date('g:ia', $timestamp);
      }
      if ((!empty($shift_specific[0]['time_regular_end']) && ($timestampend = strtotime($shift_specific[0]['time_regular_end'])) !== false) &&
        (!empty($shift_specific[0]['time_regular_start']) && ($timestampstart = strtotime($shift_specific[0]['time_regular_start'])) !== false) &&
        $timestampend > $timestampstart
        ) {
          $dateToday = date("Y-m-d");
          $recordsInTodayZKTECO = $this->home_model->GET_ATTENDANCE_RECORD_DATE_BY_ID_ZKTECO($empl_id, $dateToday, 0);
          $recordsOutTodayZKTECO = $this->home_model->GET_ATTENDANCE_RECORD_DATE_BY_ID_ZKTECO($empl_id, $dateToday, 1);
          $data['recordsInTodayZKTECO'] = $recordsInTodayZKTECO;
          $data['recordsOutTodayZKTECO'] = $recordsOutTodayZKTECO;
          $recordsToday = $this->home_model->GET_ATTENDANCE_RECORD_TODAY_BY_ID_DATE($empl_id, $dateToday);

          if (!empty($recordsInTodayZKTECO['punch_time']) && ($timestamp = strtotime($recordsInTodayZKTECO['punch_time'])) !== false) {
              $punchIn = date('g:ia', $timestamp);
          } else if ($recordsToday) {
            if (!empty($recordsToday['time_in']) && ($timestamp = strtotime($recordsToday['time_in'])) !== false) {
              $punchIn = date('g:ia', $timestamp);
            }
          }

          if (!empty($recordsOutTodayZKTECO['punch_time']) && ($timestamp = strtotime($recordsOutTodayZKTECO['punch_time'])) !== false) {
            $punchOut = date('g:ia', $timestamp);
          } else if ($recordsToday) {
            if (!empty($recordsToday['time_out']) && ($timestamp = strtotime($recordsToday['time_out'])) !== false) {
              $punchOut = date('g:ia', $timestamp);
            }
          }

      }else{
        $dateToday = date("Y-m-d");
        $yesterday = date("Y-m-d", strtotime("yesterday"));

        $recordsInTodayZKTECO = $this->home_model->GET_ATTENDANCE_RECORD_DATE_BY_ID_ZKTECO($empl_id, $yesterday, 0);
        $recordsOutTodayZKTECO = $this->home_model->GET_ATTENDANCE_RECORD_DATE_BY_ID_ZKTECO($empl_id, $dateToday, 1);

        $recordsToday = $this->home_model->GET_ATTENDANCE_RECORD_TODAY_BY_ID_DATE($empl_id, $dateToday);
        $recordsYesterday = $this->home_model->GET_ATTENDANCE_RECORD_TODAY_BY_ID_DATE($empl_id, $yesterday);
        
        if (!empty($recordsInTodayZKTECO['punch_time']) && ($timestamp = strtotime($recordsInTodayZKTECO['punch_time'])) !== false) {
          $punchIn = date('g:ia', $timestamp);
        } else if ($recordsYesterday) {
          if (!empty($recordsYesterday['time_in']) && ($timestamp = strtotime($recordsYesterday['time_in'])) !== false) {
            $punchIn = date('g:ia', $timestamp);
          }
        }

        if (!empty($recordsOutTodayZKTECO['punch_time']) && ($timestamp = strtotime($recordsOutTodayZKTECO['punch_time'])) !== false) {
          $punchOut = date('g:ia', $timestamp);
        } else if ($recordsToday) {
          if (!empty($recordsToday['time_out']) && ($timestamp = strtotime($recordsToday['time_out'])) !== false) {
            $punchOut = date('g:ia', $timestamp);
          }
        }
      }
    }

    if($shiftIn == "12:00am"){
      $shiftIn = "No Schedule";
    }
    if($shiftOut == "12:00am"){
      $shiftOut = "No Schedule";
    }

    $data['BIOMETRICS_SHIFT_IN']                       =  $shiftIn;
    $data['BIOMETRICS_SHIFT_OUT']                      =  $shiftOut;
    $data['BIOMETRICS_PUNCH_IN']                       =  $punchIn;
    $data['BIOMETRICS_PUNCH_OUT']                      =  $punchOut;

   
    // Biometrics In/out ends

    // Time Keeping Summary Starts
    $date_yesterday                 = date('Y-m-d', strtotime('yesterday'));
    $latest_payroll_period_2        = $this->home_model->GET_LATEST_PAYROLL_PERIOD_2($date_yesterday);

    if(isset($latest_payroll_period_2->date_from)){
      $period_date_start = $latest_payroll_period_2->date_from;
      $target_date_start = $latest_payroll_period_2->date_from;
    }
    else{
      $period_date_start = date("Y-m-d");
    }

    if(isset($latest_payroll_period_2->date_to)){
      $period_date_end = $latest_payroll_period_2->date_to;
      $target_date_end = $date_yesterday;
      $cutOffPeriod = date('M j', strtotime($period_date_start)) . ' - ' . date('M j, Y', strtotime($period_date_end));
      $dateCoverage = date('M j', strtotime($target_date_start)) . ' - ' . date('M j, Y', strtotime($target_date_end));
    }
    else{
      $period_date_end = date("Y-m-d");
      $target_date_end = date("Y-m-d");
      $cutOffPeriod = "No current cut-off period set";
      $dateCoverage = "No current cut-off period set";
    }
 
  
    $team = $this->home_model->TEAMMEMBERS_LIST($user_id);

    foreach($team as $row){

      $empl_id_row = $row->id;
      $shift_assign = $this->home_model->GET_ATTENDANCE_SHIFT_ASSIGN_ID_TODAY_BY_EMP_ID($empl_id_row);
      $leave_status = $this->home_model->CHECK_LEAVE($empl_id_row);
      $shiftIn = null;
      $shiftOut = null;
      $punchIn = null;
      $punchOut = null;
      $period_date_start = '';
      $target_date_start = '';
      $period_date_end = '';
      $target_date_end = '';
      $cutOffPeriod  = '';
      $shift_specific = $this->home_model->GET_ATTENDANCE_SHIFT_BY_ID(!empty($shift_assign[1]['shift_id']) ? $shift_assign[1]['shift_id'] : null);
      $data['recordsTodayZKTECO'] = null;
      if ($shift_specific) {
        if (!empty($shift_specific[0]['time_regular_start']) && ($timestamp = strtotime($shift_specific[0]['time_regular_start'])) !== false) {
          $shiftIn = date('g:ia', $timestamp);
        }
        if (!empty($shift_specific[0]['time_regular_end']) && ($timestamp = strtotime($shift_specific[0]['time_regular_end'])) !== false) {
          $shiftOut = date('g:ia', $timestamp);
        }
        if ((!empty($shift_specific[0]['time_regular_end']) && ($timestampend = strtotime($shift_specific[0]['time_regular_end'])) !== false) &&
          (!empty($shift_specific[0]['time_regular_start']) && ($timestampstart = strtotime($shift_specific[0]['time_regular_start'])) !== false) &&
          $timestampend > $timestampstart
          ) {
            $dateToday = date("Y-m-d");
            $recordsInTodayZKTECO = $this->home_model->GET_ATTENDANCE_RECORD_DATE_BY_ID_ZKTECO($empl_id_row, $dateToday, 0);
            $recordsOutTodayZKTECO = $this->home_model->GET_ATTENDANCE_RECORD_DATE_BY_ID_ZKTECO($empl_id_row, $dateToday, 1);
            $data['recordsInTodayZKTECO'] = $recordsInTodayZKTECO;
            $data['recordsOutTodayZKTECO'] = $recordsOutTodayZKTECO;
            $recordsToday = $this->home_model->GET_ATTENDANCE_RECORD_TODAY_BY_ID_DATE($empl_id_row, $dateToday);
  
            if (!empty($recordsInTodayZKTECO['punch_time']) && ($timestamp = strtotime($recordsInTodayZKTECO['punch_time'])) !== false) {
                $punchIn = date('g:ia', $timestamp);
            } else if ($recordsToday) {
              if (!empty($recordsToday['time_in']) && ($timestamp = strtotime($recordsToday['time_in'])) !== false) {
                $punchIn = date('g:ia', $timestamp);
              }
            }
  
            if (!empty($recordsOutTodayZKTECO['punch_time']) && ($timestamp = strtotime($recordsOutTodayZKTECO['punch_time'])) !== false) {
              $punchOut = date('g:ia', $timestamp);
            } else if ($recordsToday) {
              if (!empty($recordsToday['time_out']) && ($timestamp = strtotime($recordsToday['time_out'])) !== false) {
                $punchOut = date('g:ia', $timestamp);
              }
            }
  
        }else{
          $dateToday = date("Y-m-d");
          $yesterday = date("Y-m-d", strtotime("yesterday"));
  
          $recordsInTodayZKTECO = $this->home_model->GET_ATTENDANCE_RECORD_DATE_BY_ID_ZKTECO($empl_id_row, $yesterday, 0);
          $recordsOutTodayZKTECO = $this->home_model->GET_ATTENDANCE_RECORD_DATE_BY_ID_ZKTECO($empl_id_row, $dateToday, 1);
  
          $recordsToday = $this->home_model->GET_ATTENDANCE_RECORD_TODAY_BY_ID_DATE($empl_id_row, $dateToday);
          $recordsYesterday = $this->home_model->GET_ATTENDANCE_RECORD_TODAY_BY_ID_DATE($empl_id_row, $yesterday);
          
          if (!empty($recordsInTodayZKTECO['punch_time']) && ($timestamp = strtotime($recordsInTodayZKTECO['punch_time'])) !== false) {
            $punchIn = date('g:ia', $timestamp);
          } else if ($recordsYesterday) {
            if (!empty($recordsYesterday['time_in']) && ($timestamp = strtotime($recordsYesterday['time_in'])) !== false) {
              $punchIn = date('g:ia', $timestamp);
            }
          }
  
          if (!empty($recordsOutTodayZKTECO['punch_time']) && ($timestamp = strtotime($recordsOutTodayZKTECO['punch_time'])) !== false) {
            $punchOut = date('g:ia', $timestamp);
          } else if ($recordsToday) {
            if (!empty($recordsToday['time_out']) && ($timestamp = strtotime($recordsToday['time_out'])) !== false) {
              $punchOut = date('g:ia', $timestamp);
            }
          }
        }
      }

      $pic_status = 0;
      if($punchIn){
        $pic_status = 1;
      }
      else{
        if($leave_status){
          $pic_status = 2;
        }
        else{
          $pic_status = 3;
        }
      }
      $row->pic_status = $pic_status;
    }

    $data['TEAM_MEMBERS']                 = $team;


    $data['CUT_OFF_PERIOD']                 = $cutOffPeriod;
    $data['DATE_COVERAGE']                  = $dateCoverage;
    $data['DATE_FORMAT']           			    = $this->home_model->GET_SYSTEM_SETTING("date_format");

  

    $this->load->view('templates/header');
    $this->load->view('home/home_views', $data);
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
  function home_2()
  {
    $user_id = $this->session->userdata('SESS_USER_ID');

    $data["ANNOUNCEMENT_STATUS"]                    = $this->home_model->GET_HOME_ANNOUNCEMENT();
    $data["CELEB_STATUS"]                           = $this->home_model->GET_HOME_CELEBRATION();
    $data["DATE_STATUS"]                            = $this->home_model->GET_HOME_DATE();
    $data["LEAVE_STATUS"]                           = $this->home_model->GET_HOME_LEAVE();
    $data["WHOS_OUT_STATUS"]                        = $this->home_model->GET_HOME_WHOS_OUT();
    $data["START_GUIDE_STATUS"]                     = $this->home_model->GET_HOME_START_GUIDE();
    $data["NEW_MEMBER_STATUS"]                      = $this->home_model->GET_HOME_NEW_MEMBER();

    $data['isholiday']                              = $this->home_model->MOD_DISP_HOLIDAY_BASED_DATE(date('Y-m-d'));
    $data['DISP_USER_INFO']                         = $this->home_model->MOD_DISP_HOME($user_id);
    $data['DISP_ANNOUNCEMENTS_INFO']                = $this->home_model->MOD_DISP_ANNOUNCEMENTS(2);
    $data['DISP_EMPOLYEE_INFO']                     = $this->home_model->MOD_DISP_ALL_EMPLOYEES_BY_DATE();

    $data['DISP_ON_LEAVE']                          = $this->home_model->MOD_DISP_ON_LEAVE();
    $data['desktop_logo']                           = $this->home_model->GET_DESKTOP_LOGO()['value'];
    $data['mobile_logo']                            = $this->home_model->GET_MOBILE_LOGO()['value'];
    $data['DISP_NEW_EMP']                           = $this->home_model->DISP_NEW_EMP_MONTH();
    $data['C_POSITIONS']                            = $this->home_model->GET_POSITION();

    $leave_app_val = $data['LEAVE_APPROVED_COUNT']  = $this->home_model->LEAVE_APPROVED_COUNT($user_id);
    $leave_rej_val = $data['LEAVE_REJECTED_COUNT']  = $this->home_model->LEAVE_REJECTED_COUNT($user_id);
    $data['LEAVE_REJECTED_COUNT2']                  = $this->home_model->LEAVE_REJECTED_COUNT($user_id);
    $data['LEAVE_PENDING_COUNT']                    = $this->home_model->LEAVE_ALL_COUNT($user_id);

    $data['HOLIDAYWORK_APPROVED_COUNT']             = $this->home_model->HOLIDAYWORK_APPROVED_COUNT($user_id);
    $data['HOLIDAYWORK_REJECTED_COUNT']             = $this->home_model->HOLIDAYWORK_REJECTED_COUNT($user_id);
    $data['HOLIDAYWORK_PENDING_COUNT']              = $this->home_model->HOLIDAYWORK_ALL_COUNT($user_id);

    $ot_app_val = $data['OVERTIME_APPROVED_COUNT']  = $this->home_model->OVERTIME_APPROVED_COUNT($user_id);
    $ot_rej_val = $data['OVERTIME_REJECTED_COUNT']  = $this->home_model->OVERTIME_REJECTED_COUNT($user_id);
    $data['OVERTIME_PENDING_COUNT']                 = $this->home_model->OVERTIME_ALL_COUNT($user_id);

    $time_app_val = $data['TIME_APPROVED_COUNT']    = $this->home_model->TIME_APPROVED_COUNT($user_id);
    $time_rej_val = $data['TIME_REJECTED_COUNT']    = $this->home_model->TIME_REJECTED_COUNT($user_id);
    $data['TIME_PENDING_COUNT']                     = $this->home_model->TIME_ALL_COUNT($user_id);


    $data['HOLIDAYWORK_APPROVALS']                  = $this->home_model->GET_HOLIDAYWORK_APPROVALS($user_id);
    $data['LEAVE_APPROVALS']                        = $this->home_model->GET_LEAVE_FOR_APPROVALS($user_id);
    $data['OVERTIME_APPROVALS']                     = $this->home_model->GET_OVERTIME_APPROVALS($user_id);
    $data['TIME_ADJUSTMENT']                        = $this->home_model->GET_TIME_ADJUSTMENT_APPROVALS($user_id);
    $data['LEAVES']                                 = $this->home_model->GET_LEAVES($user_id);
    $data['HOLIDAYWORKS']                           = $this->home_model->GET_HOLIDAYWORK($user_id);
    $data['OVERTIMES']                              = $this->home_model->GET_OVERTIME($user_id);
    $data['TIME_ADJUSTMENTS']                       = $this->home_model->GET_TIME_ADJUSTMENTS($user_id);
    // echo '<pre>';
    // var_dump( $data['DISP_ANNOUNCEMENTS_INFO']);
    // return;
    $this->load->view('templates/header');
    $this->load->view('home/home_views_2', $data);
  }
  // function approve_leave($id){
  //     $response=$this->home_model->update_leaveStatus($id,'Approved');
  //     redirect('/home');
  // }
  // function reject_leave($id){
  //     $response=$this->home_model->update_leaveStatus($id,'Rejected');
  //     redirect('/home');
  // }
  // function approve_overtime($id){
  //     $response=$this->home_model->update_overtimeStatus($id,'Approved');
  //     redirect('/home');
  // }
  // function reject_overtime($id){
  //     $response=$this->home_model->update_overtimeStatus($id,'Rejected');
  //     redirect('/home');
  // }
  // function approve_time_adjustment($id){
  //     $response=$this->home_model->update_timeAdjustmentStatus($id,'Approved');
  //     redirect('/home');
  // }
  // function reject_time_adjustment($id){
  //     $response=$this->home_model->update_timeAdjustmentStatus($id,'Rejected');
  //     redirect('/home');
  // }

  function download_file($id)
  {
    $this->load->helper('download');
    $filepath                                   = $this->home_model->GET_FILE_PATH($id);
    $path                                       = file_get_contents(base_url() . "assets_user/files/hressentials/" . $filepath);
    $file                                       = 'Eyebox/' . $filepath;
    force_download($file, $path);
  }


  function update_leave_assign()
  {
    $id                 = $this->input->post('id');
    if (!$id) {
      redirect('home');
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved leave request [LEA' . str_pad($id, 5, '0', STR_PAD_LEFT) . ']');
    $leave_assign       = $this->home_model->GET_LEAVE_ASSIGN($id);
    $approvers          = $this->home_model->GET_USER_APPROVERS($leave_assign->empl_id, 'tbl_approvers');
    $date_created       = date('Y-m-d H:i:s');
    $emp_id             = $this->session->userdata('SESS_USER_ID');
    $approver           = $this->home_model->GET_EMPOYEE($emp_id);
    $approver_name      = $this->system_functions->fomatName($approver->col_last_name,$approver->col_frst_name,$approver->col_midl_name);
    if ($leave_assign->status == 'Pending 1') {
      $status = 'Pending 2';
      $this->home_model->UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id);
      $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $leave_assign->empl_id, 'type' => 'leave',
        'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
      );

      $this->home_model->ADD_NOTIFICATION($notif_data);
      $notif_data['empl_id']      = $approvers->approver_2a;
      $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $approvers->employee . " has been requested";
      $notif_data['location']     = "selfservices/leave_approval";
      $this->home_model->ADD_NOTIFICATION($notif_data);
    }
    if ($leave_assign->status == 'Pending 2') {
      $status = 'Pending 3';
      $this->home_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id);
      $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $leave_assign->empl_id, 'type' => 'leave',
        'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
      );

      $this->home_model->ADD_NOTIFICATION($notif_data);
      $notif_data['empl_id']      = $approvers->approver_3a;
      $notif_data['description']  = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $approvers->employee . " has been requested";
      $notif_data['location']     = "selfservices/leave_approval";
      $this->home_model->ADD_NOTIFICATION($notif_data);
    }
    if ($leave_assign->status == 'Pending 3') {
      $status = 'Approved';
      $this->home_model->UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id);
      $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $leave_assign->empl_id, 'type' => 'leave',
        'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
      );
      $this->home_model->ADD_NOTIFICATION($notif_data);
    }
    $this->session->set_userdata('succ_approved', 'Leave request has been approved!');
    redirect('/home');
  }

  function reject_leave_assign()
  {
    $id                 = $this->input->post('id');
    if (!$id) {
      redirect('home');
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected leave request [LEA' . str_pad($id, 5, '0', STR_PAD_LEFT) . ']');
    $leave_assign       = $this->home_model->GET_LEAVE_ASSIGN($id);
    $approvers          = $this->home_model->GET_USER_APPROVERS($leave_assign->empl_id, 'tbl_approvers');
    $status             = 'Rejected';
    $date_created       = date('Y-m-d H:i:s');
    $emp_id             = $this->session->userdata('SESS_USER_ID');
    $approver           = $this->home_model->GET_EMPOYEE($emp_id);
    $approver_name      = $this->system_functions->fomatName($approver->col_last_name,$approver->col_frst_name,$approver->col_midl_name);
    if ($leave_assign->status == 'Pending 1') {
      $this->home_model->UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id);
    } elseif ($leave_assign->status == 'Pending 2') {
      $this->home_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id);
    } elseif ($leave_assign->status == 'Pending 3') {
      $this->home_model->UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id);
    }
    $description = "Leave Application Review for [LEA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
    $notif_data = array(
      'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $leave_assign->empl_id, 'type' => 'leave',
      'content_id' => $id, 'location' => 'selfservices/my_leaves', 'description' => $description
    );
    $this->home_model->ADD_NOTIFICATION($notif_data);
    $this->session->set_userdata('succ_approved', 'Leave request has been rejected!');
    redirect('/home');
  }




  function update_holidaywork_assign()
  {
    $id                 = $this->input->post('id');
    if (!$id) {
      redirect('home');
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved holiday work request [HDW' . str_pad($id, 5, '0', STR_PAD_LEFT) . ']');

    $holiday_work                             = $this->home_model->GET_HOLIDAYWORK_ASSIGN($id);
    $approvers                                = $this->home_model->GET_USER_APPROVERS($holiday_work->empl_id, 'tbl_approvers');
    $emp_id                                   = $this->session->userdata('SESS_USER_ID');
    $approver           = $this->home_model->GET_EMPOYEE($emp_id);
    $approver_name      = $this->system_functions->fomatName($approver->col_last_name,$approver->col_frst_name,$approver->col_midl_name);
    
    if ($holiday_work->status == 'Pending 1') {
      $status = 'Pending 2';
      $date_created                         = date('Y-m-d H:i:s');
      $this->home_model->UPDATE_HOLIDAYWORK_ASSIGN($status, $emp_id, $date_created, $id);
      $description = "Holiday Work Application Review for [HWA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $holiday_work->empl_id, 'type' => 'holiday work',
        'content_id' => $id, 'location' => 'selfservices/my_holiday_work',
        'description' => $description
      );
      $this->home_model->ADD_NOTIFICATION($notif_data);
      $notif_data['empl_id']      = $approvers->approver_2a;
      $notif_data['description']  = "Holiday Work Application Review for [HWA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $approvers->employee . " has been requested";
      $notif_data['location']     = "selfservices/holidaywork_approval";
      $this->home_model->ADD_NOTIFICATION($notif_data);
    }

    if ($holiday_work->status == 'Pending 2') {
      $status = 'Pending 3';
      $date_created                         = date('Y-m-d H:i:s');
      $this->home_model->UPDATE_HOLIDAYWORK_ASSIGN2($status, $emp_id, $date_created, $id);
      $description  = "Holiday Work Application Review for [HWA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $notif_data   = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $holiday_work->empl_id, 'type' => 'holiday work',
        'content_id' => $id, 'location' => 'selfservices/my_holiday_work',
        'description' => $description
      );
      $this->home_model->ADD_NOTIFICATION($notif_data);
      $notif_data['empl_id']      = $approvers->approver_3a;
      $notif_data['description']  = "Holiday Work Application Review for [HWA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $approvers->employee . " has been requested";
      $notif_data['location']     = "selfservices/holidaywork_approval";
      $this->home_model->ADD_NOTIFICATION($notif_data);
    }

    if ($holiday_work->status == 'Pending 3') {
      $status                               = 'Approved';
      $date_created                         = date('Y-m-d H:i:s');
      $this->home_model->UPDATE_HOLIDAYWORK_ASSIGN3($status, $emp_id, $date_created, $id);
      $description = "Holiday Work Application Review for [MHW" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $holiday_work->empl_id, 'type' => 'holiday work',
        'content_id' => $id, 'location' => 'selfservices/my_holiday_work',
        'description' => $description
      );
      $this->home_model->ADD_NOTIFICATION($notif_data);
    }

    $this->session->set_userdata('succ_approved', 'Holiday work request has been approved!');
    redirect('home');
  }


  function reject_holidaywork_assign()
  {
    $id                 = $this->input->post('id');
    if (!$id) {
      redirect('home');
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected holiday work request [HDW' . str_pad($id, 5, '0', STR_PAD_LEFT) . ']');
    $holiday_work                          = $this->home_model->GET_HOLIDAYWORK_ASSIGN($id);
    $approvers                          = $this->home_model->GET_USER_APPROVERS($holiday_work->empl_id, 'tbl_approvers');
    $emp_id                                   = $this->session->userdata('SESS_USER_ID');
    $approver           = $this->home_model->GET_EMPOYEE($emp_id);
    $approver_name      = $this->system_functions->fomatName($approver->col_last_name,$approver->col_frst_name,$approver->col_midl_name);
    
    if ($holiday_work->status == 'Pending 1') {
      $status                               = 'Rejected';
      $date_created                         = date('Y-m-d H:i:s');
      $emp_id                               = $this->session->userdata('SESS_USER_ID');
      $this->home_model->UPDATE_HOLIDAYWORK_ASSIGN($status, $emp_id, $date_created, $id);
    }

    if ($holiday_work->status == 'Pending 2') {
      $status                               = 'Rejected';
      $date_created                         = date('Y-m-d H:i:s');
      $emp_id                               = $this->session->userdata('SESS_USER_ID');
      $this->home_model->UPDATE_HOLIDAYWORK_ASSIGN2($status, $emp_id, $date_created, $id);
    }

    if ($holiday_work->status == 'Pending 3') {
      $status                               = 'Rejected';
      $date_created                         = date('Y-m-d H:i:s');
      $emp_id                               = $this->session->userdata('SESS_USER_ID');
      $this->home_model->UPDATE_HOLIDAYWORK_ASSIGN3($status, $emp_id, $date_created, $id);
    }
    $description = "Holiday Work Application Review for [MHW" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
    $notif_data = array(
      'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $holiday_work->empl_id, 'type' => 'holiday work',
      'content_id' => $id, 'location' => 'selfservices/my_holiday_work', 'description' => $description
    );
    $this->home_model->ADD_NOTIFICATION($notif_data);
    $this->session->set_userdata('succ_approved', 'Holiday work request has been rejected!');
    redirect('home');
  }


  function update_overtime_assign()
  {
    $id                 = $this->input->post('id');
    if (!$id) {
      redirect('home');
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved overtime request [OVT' . str_pad($id, 5, '0', STR_PAD_LEFT) . ']');
    $overtime_assign        = $this->home_model->GET_OVERTIME_ASSIGN($id);
    $approvers              = $this->home_model->GET_USER_APPROVERS($overtime_assign->empl_id, 'tbl_approvers');

    $date_created           = date('Y-m-d H:i:s');
    $emp_id                 = $this->session->userdata('SESS_USER_ID');
    $approver               = $this->home_model->GET_EMPOYEE($emp_id);
    $approver_name          = $this->system_functions->fomatName($approver->col_last_name,$approver->col_frst_name,$approver->col_midl_name);
    
    if ($overtime_assign->status == 'Pending 1') {
      $status = 'Pending 2';
      $this->home_model->UPDATE_OVERTIME_ASSIGN($status, $emp_id, $date_created, $id);
      $description = "Leave Application Review for [OVT" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $overtime_assign->empl_id, 'type' => 'overtime',
        'content_id' => $id, 'location' => 'selfservices/my_overtimes',
        'description' => $description
      );
      $this->home_model->ADD_NOTIFICATION($notif_data);
      $notif_data['empl_id']      = $approvers->approver_2a;
      $notif_data['description']  = "Overtime Application Review for [OVA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $approvers->employee . " has been requested";
      $notif_data['location']     = "selfservices/overtime_approval";
      $this->home_model->ADD_NOTIFICATION($notif_data);
    }

    if ($overtime_assign->status == 'Pending 2') {
      $status = 'Pending 3';
      $this->home_model->UPDATE_OVERTIME_ASSIGN2($status, $emp_id, $date_created, $id);
      $description = "Leave Application Review for [OVT" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $overtime_assign->empl_id, 'type' => 'overtime',
        'content_id' => $id, 'location' => 'selfservices/my_overtimes',
        'description' => $description
      );
      $this->home_model->ADD_NOTIFICATION($notif_data);
      $notif_data['empl_id']      = $approvers->approver_3a;
      $notif_data['description']  = "Overtime Application Review for [OVA" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $approvers->employee . " has been requested";
      $notif_data['location']     = "selfservices/overtime_approval";
      $this->selfservices_model->ADD_NOTIFICATION($notif_data);
    }

    if ($overtime_assign->status == 'Pending 3') {
      $status = 'Approved';
      $this->home_model->UPDATE_OVERTIME_ASSIGN3($status, $emp_id, $date_created, $id);
      $description = "Leave Application Review for [OVT" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $overtime_assign->empl_id, 'type' => 'overtime',
        'content_id' => $id, 'location' => 'selfservices/my_overtimes',
        'description' => $description
      );
      $this->home_model->ADD_NOTIFICATION($notif_data);
    }
    $this->session->set_userdata('succ_approved', 'Overtime request has been approved!');
    redirect('home');
  }


  function reject_overtime_assign()
  {
    $id                 = $this->input->post('id');
    if (!$id) {
      redirect('home');
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected overtime request [OVT' . str_pad($id, 5, '0', STR_PAD_LEFT) . ']');
    $overtime_assign                    = $this->home_model->GET_OVERTIME_ASSIGN($id);
    $date_created                       = date('Y-m-d H:i:s');
    $status                             = 'Rejected';
    $approvers                          = $this->home_model->GET_USER_APPROVERS($overtime_assign->empl_id, 'tbl_approvers');
    $emp_id                 = $this->session->userdata('SESS_USER_ID');
    $approver               = $this->home_model->GET_EMPOYEE($emp_id);
    $approver_name          = $this->system_functions->fomatName($approver->col_last_name,$approver->col_frst_name,$approver->col_midl_name);
    
    if ($overtime_assign->status == 'Pending 1') {
      $this->home_model->UPDATE_OVERTIME_ASSIGN($status, $emp_id, $date_created, $id);
    }

    if ($overtime_assign->status == 'Pending 2') {
      $this->home_model->UPDATE_OVERTIME_ASSIGN2($status, $emp_id, $date_created, $id);
    }

    if ($overtime_assign->status == 'Pending 3') {
      $this->home_model->UPDATE_OVERTIME_ASSIGN3($status, $emp_id, $date_created, $id);
    }
    $description = "Overtime Application Review for [OVT" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
    $notif_data = array(
      'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $overtime_assign->empl_id, 'type' => 'holiday work',
      'content_id' => $id, 'location' => 'selfservices/my_holiday_work', 'description' => $description
    );
    $this->home_model->ADD_NOTIFICATION($notif_data);
    $this->session->set_userdata('succ_approved', 'Overtime request has been rejected!');
    redirect('/home');
  }


  function approve_time_adj_assign()
  {
    $id                 = $this->input->post('id');
    if (!$id) {
      redirect('home');
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Approved time adjustment request [TAD' . str_pad($id, 5, '0', STR_PAD_LEFT) . ']');
    $time_adjustment_assign             = $this->home_model->GET_TIME_ADJUSTMENT_ASSIGN($id);
    $approvers                          = $this->home_model->GET_USER_APPROVERS($time_adjustment_assign->empl_id, 'tbl_approvers');
    $date_created = date('Y-m-d H:i:s');
    $emp_id                 = $this->session->userdata('SESS_USER_ID');
    $approver               = $this->home_model->GET_EMPOYEE($emp_id);
    $approver_name          = $this->system_functions->fomatName($approver->col_last_name,$approver->col_frst_name,$approver->col_midl_name);

    if ($time_adjustment_assign->status == 'Pending 1') {
      $status = 'Pending 2';
      $this->home_model->UPDATE_TIME_ADJ_ASSIGN($status, $emp_id, $date_created, $id);
      $description = "Time Ajustment Application Review for [ADJ" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " .  $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $time_adjustment_assign->empl_id, 'type' => 'time adjustment',
        'content_id' => $id, 'location' => 'selfservices/my_time_adjustments',
        'description' => $description
      );
      $this->home_model->ADD_NOTIFICATION($notif_data);
      $notif_data['empl_id']      = $approvers->approver_2a;
      $notif_data['description']  = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $approvers->employee . " has been requested";
      $notif_data['location']     = "selfservices/time_adjustment_approval";
      $this->home_model->ADD_NOTIFICATION($notif_data);
    }

    if ($time_adjustment_assign->status == 'Pending 2') {
      $status = 'Pending 3';
      $this->home_model->UPDATE_TIME_ADJ_ASSIGN2($status, $emp_id, $date_created, $id);
      $description = "Time Ajustment Application Review for [ADJ" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " .  $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $time_adjustment_assign->empl_id, 'type' => 'time adjustment',
        'content_id' => $id, 'location' => 'selfservices/my_time_adjustments',
        'description' => $description
      );
      $this->home_model->ADD_NOTIFICATION($notif_data);
      $notif_data['empl_id']      = $approvers->approver_3a;
      $notif_data['description']  = "Time Adjustment Application Review for [TAD" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] by " . $approvers->employee . " has been requested";
      $notif_data['location']     = "selfservices/time_adjustment_approval";
      $this->home_model->ADD_NOTIFICATION($notif_data);
    }

    if ($time_adjustment_assign->status == 'Pending 3') {
      $status = 'Approved';
      $this->home_model->UPDATE_TIME_ADJ_ASSIGN3($status, $emp_id, $date_created, $id);
      $description = "Time Ajustment Application Review for [ADJ" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " .  $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'),
        'empl_id' => $time_adjustment_assign->empl_id, 'type' => 'time adjustment',
        'content_id' => $id, 'location' => 'selfservices/my_time_adjustments',
        'description' => $description
      );
      $this->home_model->ADD_NOTIFICATION($notif_data);
      $this->insert_approved_time_adjustment($id);
    }
    $this->session->set_userdata('succ_approved', 'Time Adjustment request has been approved!');
    redirect('home');
  }


  function reject_time_adj_assign()
  {
    $id                 = $this->input->post('id');
    if (!$id) {
      redirect('home');
    }
    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Rejected time adjustment request [TAD' . str_pad($id, 5, '0', STR_PAD_LEFT) . ']');
    $time_adjustment_assign             = $this->home_model->GET_TIME_ADJUSTMENT_ASSIGN($id);
    $approvers                          = $this->home_model->GET_USER_APPROVERS($time_adjustment_assign->empl_id, 'tbl_approvers');
    $approver_name                      = "";
    $status = 'Rejected';
    $date_created = date('Y-m-d H:i:s');
    $emp_id = $this->session->userdata('SESS_USER_ID');
    $approver               = $this->home_model->GET_EMPOYEE($emp_id);
    $approver_name          = $this->system_functions->fomatName($approver->col_last_name,$approver->col_frst_name,$approver->col_midl_name);
    
    if ($time_adjustment_assign->status == 'Pending 1') {
      $this->home_model->UPDATE_TIME_ADJ_ASSIGN($status, $emp_id, $date_created, $id);
    }

    if ($time_adjustment_assign->status == 'Pending 2') {
      $this->home_model->UPDATE_TIME_ADJ_ASSIGN2($status, $emp_id, $date_created, $id);
      
    }

    if ($time_adjustment_assign->status == 'Pending 3') {
      $this->home_model->UPDATE_TIME_ADJ_ASSIGN3($status, $emp_id, $date_created, $id);
      
    }
    $description = "Time Adjustment Application Review for [ADJ" . str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
    $notif_data = array(
      'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $time_adjustment_assign->empl_id, 'type' => 'time adjustment',
      'content_id' => $id, 'location' => 'selfservices/my_time_adjustments', 'description' => $description
    );
    $this->home_model->ADD_NOTIFICATION($notif_data);
    $this->session->set_userdata('succ_approved', 'Time Adjustment request has been rejected!');
    redirect('/home');
  }


  function insert_approved_time_adjustment($id)
  {

    $time_adj                                   = $this->home_model->GET_APPROVED_TIME_ADJUSTMENT($id);
    $attendance_shift                           = $this->home_model->GET_ATTENDANCE_SHIFT($time_adj->shift_type);

    $shift_id                                   = $attendance_shift->id;

    $date                                       = $time_adj->date_adjustment;
    $empl_id                                    = $time_adj->empl_id;
    $timeIn1                                    = $time_adj->time_in_1;
    $timeOut1                                   = $time_adj->time_out_1;
    $timeIn2                                    = $time_adj->time_in_2;
    $timeOut2                                   = $time_adj->time_out_2;

    $result                                     = $this->home_model->IS_DUPLICATE_TIME_ADDJ($empl_id, $date);
    $att_shift_result                           = $this->home_model->IS_DUPLICATE_ATTENDANCE_SHIFTASSIGN($empl_id, $date);

    if ($result <= 0) {
      $this->home_model->INSERT_TIME_ADJUSTMENT($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date);
    } else {
      $this->home_model->UPDATE_TIME_ADJUSTMENT($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date);
    }

    if ($att_shift_result <= 0) {
      $this->home_model->INSERT_ATTENDANCE_SHIFT_ASSIGN($shift_id, $empl_id, $date);
    } else {
      $this->home_model->UPDATE_ATTENDANCE_SHIFT_ASSIGN($shift_id, $empl_id, $date);
    }

    return;
  }
}
