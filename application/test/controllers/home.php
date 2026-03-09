<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class home extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->model('home/home_model');

    // $this->session->set_userdata('SESS_USER_ID', 1);
    
    if ($this->session->userdata('SESS_USER_ID') == '') {
      redirect('login/session_expired');
    }



    $maintenance= $this->login_model->GET_MAINTENANCE();
    $isAdmin = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }

  function index()
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
    $this->load->view('home/home_views', $data);
    
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

  function download_file($id){
    $this->load->helper('download');
    $filepath                                   = $this->home_model->GET_FILE_PATH($id);
    $path                                       = file_get_contents(base_url()."assets_user/files/hressentials/".$filepath);
    $file                                       = 'Eyebox/'.$filepath;
    force_download($file, $path);
  }


  function update_leave_assign($id)
  {
    $leave_assign                               = $this->home_model->GET_LEAVE_ASSIGN();

    foreach ($leave_assign as $leave_row) {
      $date_created                             = date('Y-m-d H:i:s');
      $emp_id                                   = $this->session->userdata('SESS_USER_ID');

      if ($leave_row->id == $id && $leave_row->status == 'Pending 1') {
        $status = 'Pending 2';
        $this->home_model->UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id);
      }
      if ($leave_row->id == $id && $leave_row->status == 'Pending 2') {
        $status = 'Pending 3';
        $this->home_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id);
      }
      if ($leave_row->id == $id && $leave_row->status == 'Pending 3') {
        $status = 'Approved';
        $this->home_model->UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Leave request has been approved!');
    redirect('/home');
  }

  function reject_leave_assign($id)
  {
    $leave_assign                              = $this->home_model->GET_LEAVE_ASSIGN();

    foreach ($leave_assign as $leave_row) {

      if ($leave_row->id == $id) {
        $status                                = 'Rejected';
        $date_created                          = date('Y-m-d H:i:s');
        $emp_id                                = $this->session->userdata('SESS_USER_ID');
        if ($leave_row->status == 'Pending 1') {
          $this->home_model->UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id);
        } elseif ($leave_row->status == 'Pending 2') {
          $this->home_model->UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id);
        } elseif ($leave_row->status == 'Pending 3') {
          $this->home_model->UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id);
        }
      }
    }
    $this->session->set_userdata('succ_approved', 'Leave request has been rejected!');
    redirect('/home');
  }




  function update_holidaywork_assign($id)
  {
    $emp_id                                   = $this->session->userdata('SESS_USER_ID');
    // $id = $this->input->get('approved_id');
    $overtime_assign                          = $this->home_model->GET_HOLIDAYWORK_ASSIGN();

    foreach ($overtime_assign as $overtime_row) {
      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 1') {
        $status = 'Pending 2';
        $date_created                         = date('Y-m-d H:i:s');
        $emp_id                               = $this->session->userdata('SESS_USER_ID');
        $this->home_model->UPDATE_HOLIDAYWORK_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 2') {
        $status = 'Pending 3';
        $date_created                         = date('Y-m-d H:i:s');
        $emp_id                               = $this->session->userdata('SESS_USER_ID');
        $this->home_model->UPDATE_HOLIDAYWORK_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 3') {
        $status                               = 'Approved';
        $date_created                         = date('Y-m-d H:i:s');
        $emp_id                               = $this->session->userdata('SESS_USER_ID');
        $this->home_model->UPDATE_HOLIDAYWORK_ASSIGN3($status, $emp_id, $date_created, $id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Holiday work request has been approved!');
    redirect('/home');
  }


  function reject_holidaywork_assign($id)
  {
    // $id = $this->input->get('reject_id');
    $overtime_assign                          = $this->home_model->GET_HOLIDAYWORK_ASSIGN();

    foreach ($overtime_assign as $overtime_row) {
      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 1') {
        $status                               = 'Rejected';
        $date_created                         = date('Y-m-d H:i:s');
        $emp_id                               = $this->session->userdata('SESS_USER_ID');
        $this->home_model->UPDATE_HOLIDAYWORK_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 2') {
        $status                               = 'Rejected';
        $date_created                         = date('Y-m-d H:i:s');
        $emp_id                               = $this->session->userdata('SESS_USER_ID');
        $this->home_model->UPDATE_HOLIDAYWORK_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 3') {
        $status                               = 'Rejected';
        $date_created                         = date('Y-m-d H:i:s');
        $emp_id                               = $this->session->userdata('SESS_USER_ID');
        $this->home_model->UPDATE_HOLIDAYWORK_ASSIGN3($status, $emp_id, $date_created, $id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Holiday work request has been rejected!');
    redirect('/home');
  }


  function update_overtime_assign($id)
  {
    $overtime_assign                          = $this->home_model->GET_OVERTIME_ASSIGN();

    foreach ($overtime_assign as $overtime_row) {

      $date_created                           = date('Y-m-d H:i:s');
      $emp_id                                 = $this->session->userdata('SESS_USER_ID');

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 1') {
        $status = 'Pending 2';
        $this->home_model->UPDATE_OVERTIME_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 2') {
        $status = 'Pending 3';
        $this->home_model->UPDATE_OVERTIME_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 3') {
        $status = 'Approved';
        $this->home_model->UPDATE_OVERTIME_ASSIGN3($status, $emp_id, $date_created, $id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Overtime request has been approved!');
    redirect('/home');
  }


  function reject_overtime_assign($id )
  {
    $overtime_assign                         = $this->home_model->GET_OVERTIME_ASSIGN();

    foreach ($overtime_assign as $overtime_row) {

      $date_created                         = date('Y-m-d H:i:s');
      $emp_id                               = $this->session->userdata('SESS_USER_ID');
      $status                               = 'Rejected';

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 1') {
        $this->home_model->UPDATE_OVERTIME_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 2') {
        $this->home_model->UPDATE_OVERTIME_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($overtime_row->id == $id && $overtime_row->status == 'Pending 3') {
        $this->home_model->UPDATE_OVERTIME_ASSIGN3($status, $emp_id, $date_created, $id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Overtime request has been rejected!');
    redirect('/home');
  }


  function approve_time_adj_assign($id )
  {
    $time_adjustment_assign                     = $this->home_model->GET_TIME_ADJUSTMENT_ASSIGN();

    foreach ($time_adjustment_assign as $time_adjustment_assign_row) {

      $date_created = date('Y-m-d H:i:s');
      $emp_id = $this->session->userdata('SESS_USER_ID');

      if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 1') {
        $status = 'Pending 2';
        $this->home_model->UPDATE_TIME_ADJ_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 2') {
        $status = 'Pending 3';
        $this->home_model->UPDATE_TIME_ADJ_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 3') {
        $status = 'Approved';
        $this->home_model->UPDATE_TIME_ADJ_ASSIGN3($status, $emp_id, $date_created, $id);
        $this->insert_approved_time_adjustment($id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Time Adjustment request has been approved!');
    redirect('/home');
  }


  function reject_time_adj_assign($id)
  {
    $time_adjustment_assign                       = $this->home_model->GET_TIME_ADJUSTMENT_ASSIGN();

    foreach ($time_adjustment_assign as $time_adjustment_assign_row) {

      $status = 'Rejected';
      $date_created = date('Y-m-d H:i:s');
      $emp_id = $this->session->userdata('SESS_USER_ID');

      if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 1') {
        $this->home_model->UPDATE_TIME_ADJ_ASSIGN($status, $emp_id, $date_created, $id);
      }

      if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 2') {
        $this->home_model->UPDATE_TIME_ADJ_ASSIGN2($status, $emp_id, $date_created, $id);
      }

      if ($time_adjustment_assign_row->id == $id && $time_adjustment_assign_row->status == 'Pending 3') {
        $this->home_model->UPDATE_TIME_ADJ_ASSIGN3($status, $emp_id, $date_created, $id);
      }
    }
    $this->session->set_userdata('succ_approved', 'Time Adjustment request has been rejected!');
    redirect('/home');
  }


  function insert_approved_time_adjustment($id){

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
    }else{
      $this->home_model->UPDATE_TIME_ADJUSTMENT($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date);
    }

    if ($att_shift_result <= 0) {
      $this->home_model->INSERT_ATTENDANCE_SHIFT_ASSIGN($shift_id, $empl_id, $date);
    }else{
      $this->home_model->UPDATE_ATTENDANCE_SHIFT_ASSIGN($shift_id, $empl_id, $date);
    }

    return;
  }

  
}
