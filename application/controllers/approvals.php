<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class approvals extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('technos_encryption');
        $this->load->library('system_functions');
        $this->load->library('logger');
        $this->load->model('modules/approval_model');
        // auto login starts
        $this->load->model('admin_model');
        $auto_login = $this->admin_model->get_system_setup_by_setting2('auto_login', '0');
        if ($auto_login == '1' && empty($this->session->userdata('SESS_USER_ID'))) {
          $this->session->set_userdata('SESS_USER_ID', 1);
        }
        // auto login ends
    }
    function approve_request(){
        $token      = $this->input->get('token');
        $decrypted_token    = $this->technos_encryption->decryptData($token);
        $str_json           = json_decode($decrypted_token);
        $decrypted_data     = json_decode($str_json);
        // $token   = $this->approval_model->GET_TOKEN($token);
        // var_dump($token);  
        // return;
        if($decrypted_data){
            $table              = $decrypted_data->table;
            if($table=='tbl_leaves_assign'){
                $notif_text                 = "Leave Application Review for [LEA";
                $request                    =  $this->approval_model->GET_REQUEST_ASSIGN($table,$decrypted_data->id);
                $approval_type              =  'leave_approval';
                $approval_empl_type         =  'leave';
                $employee_notif_location    =  'selfservices/my_leaves';
                $approver_notif_location    =  'selfservices/leave_approval' ;
                $approver_id                =  $decrypted_data->approver_id;
                // echo '<pre>';
                // var_dump($decrypted_data);
                // return;
                $res=$this->request_action_approve($decrypted_data,$request,$approver_id,$notif_text,$approval_type,
                                            $approval_empl_type,$employee_notif_location,$approver_notif_location);
                $decrypted_data = $res;
            }
            else if($table=='tbl_overtimes'){
                $notif_text                 = "Overtime Application Review for [OVT";
                $request                    =  $this->approval_model->GET_REQUEST_ASSIGN($table,$decrypted_data->id);
                $approval_type              =  'overtime_approval';
                $approval_empl_type         =  'overtime';
                $employee_notif_location    =  'selfservices/my_overtimes';
                $approver_notif_location    =  'selfservices/overtime_approval' ;
                $approver_id                =  $decrypted_data->approver_id;
                // echo '<pre>';
                // var_dump($decrypted_data);
                // return;
                $res=$this->request_action_approve($decrypted_data,$request,$approver_id,$notif_text,$approval_type,
                                            $approval_empl_type,$employee_notif_location,$approver_notif_location);
                $decrypted_data = $res;
            }
            else if($table=='tbl_attendance_adjustments'){
                $notif_text                 = "Time Adjustment Application Review for [TAD";
                $request                    =  $this->approval_model->GET_REQUEST_ASSIGN($table,$decrypted_data->id);
                $approval_type              =  'time_adjustment_approval';
                $approval_empl_type         =  'time_adjustment';
                $employee_notif_location    =  'selfservices/my_time_adjustments';
                $approver_notif_location    =  'selfservices/time_adjustment_approval' ;
                $approver_id                =  $decrypted_data->approver_id;
                // echo '<pre>';
                // var_dump($decrypted_data);
                // return;
                $res=$this->request_action_approve($decrypted_data,$request,$approver_id,$notif_text,$approval_type,
                                            $approval_empl_type,$employee_notif_location,$approver_notif_location);
                $decrypted_data = $res;
            }
            else if($table=='tbl_holidaywork'){
                $notif_text                 = "Holiday Work Application Review for [HDW";
                $request                    =  $this->approval_model->GET_REQUEST_ASSIGN($table,$decrypted_data->id);
                $approval_type              =  'holiday_work_approval';
                $approval_empl_type         =  'holiday_work';
                $employee_notif_location    =  'selfservices/my_holiday_work';
                $approver_notif_location    =  'selfservices/holidaywork_approval' ;
                $approver_id                =  $decrypted_data->approver_id;
                // echo '<pre>';
                // var_dump($decrypted_data);
                // return;
                $res=$this->request_action_approve($decrypted_data,$request,$approver_id,$notif_text,$approval_type,
                                            $approval_empl_type,$employee_notif_location,$approver_notif_location);
                $decrypted_data = $res;
            }
            // echo '<pre>';
            // var_dump($decrypted_data->table);
            // $res=$this->approval_model->APPROVE_REQUEST($decrypted_data->table,$decrypted_data->id,$decrypted_data->approver,
            // $decrypted_data->approver_date_col,$decrypted_data->approver_id);
        
            // if($res){
            //     $in_avtivate_token=$this->approval_model->UPDATE_TOKEN_STATUS($token->id,'Inactive');
            //     echo "You've successfully approve the request";
            // }
        }
        if( $decrypted_data &&  $decrypted_data->status=='Inactive'){
            echo 'This request has already been processed';
            return;
        }
        echo 'Invalid token';
        
    }
    function reject_request(){
        $token      = $this->input->get('token');
        $decrypted_token    = $this->technos_encryption->decryptData($token);
        $str_json           = json_decode($decrypted_token);
        $decrypted_data     = json_decode($str_json);
        // $token   = $this->approval_model->GET_TOKEN($token);
        // var_dump($token);  
        // return;
        if($decrypted_data){
            $table              = $decrypted_data->table;
            if($table=='tbl_leaves_assign'){
                $notif_text                 = "Leave Application Review for [LEA";
                $request                    =  $this->approval_model->GET_REQUEST_ASSIGN($table,$decrypted_data->id);
                $approval_empl_type         =  'leave';
                $employee_notif_location    =  'selfservices/my_leaves';
                $approver_id                =  $decrypted_data->approver_id;
                $res=$this->request_action_reject($decrypted_data,$approver_id,$request,$notif_text,
                                            $approval_empl_type,$employee_notif_location);
                $decrypted_data = $res;
            }
            
            else if($table=='tbl_overtimes'){
                $notif_text                 = "Overtime Application Review for [OVT";
                $request                    =  $this->approval_model->GET_REQUEST_ASSIGN($table,$decrypted_data->id);
                $approval_empl_type         =  'overtime';
                $employee_notif_location    =  'selfservices/my_overtimes';
                $approver_id                =  $decrypted_data->approver_id;
                $res=$this->request_action_reject($decrypted_data,$approver_id,$request,$notif_text,
                                            $approval_empl_type,$employee_notif_location);
                $decrypted_data = $res;
            }
             else if($table=='tbl_attendance_adjustments'){
                $notif_text                 = "Time Adjustment Application Review for [TAD";
                $request                    =  $this->approval_model->GET_REQUEST_ASSIGN($table,$decrypted_data->id);
                $approval_empl_type         =  'time_adjustment';
                $employee_notif_location    =  'selfservices/my_time_adjustments';
                $approver_id                =  $decrypted_data->approver_id;
                $res=$this->request_action_reject($decrypted_data,$approver_id,$request,$notif_text,
                                            $approval_empl_type,$employee_notif_location);
                $decrypted_data = $res;
            }
            else if($table=='tbl_holidaywork'){
                $notif_text                 = "Holiday Work Application Review for [HDW";
                $request                    =  $this->approval_model->GET_REQUEST_ASSIGN($table,$decrypted_data->id);
                $approval_empl_type         =  'holiday_work';
                $employee_notif_location    =  'selfservices/my_holiday_work';
                $approver_id                =  $decrypted_data->approver_id;
                $res=$this->request_action_reject($decrypted_data,$approver_id,$request,$notif_text,
                                            $approval_empl_type,$employee_notif_location);
                $decrypted_data = $res;
            }
        }
        if( $decrypted_data &&  $decrypted_data->status=='Inactive'){
            echo 'This request has already been processed';
            return;
        }
        echo 'Invalid token';
    }
    private function request_action_approve($decrypted_data,$request,$approver_id,$notif_text,$approval_type,
                                            $approval_empl_type,$employee_notif_location,$approver_notif_location){
    $is_already_approve = $this->approval_model->CHECK_STATUS($decrypted_data->table,$decrypted_data->approver_date_col,$decrypted_data->id);
    if($is_already_approve==0){
        // $this->approval_model->UPDATE_TOKEN_STATUS($decrypted_data->id,'Inactive');
        $decrypted_data->status='Inactive';
        return $decrypted_data;
    }

    $user_id              = $approver_id; 
    $approver             = $this->approval_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_list        = array();
    $approver_list[]      = $this->approval_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver1);
    $approver_list[]      = $this->approval_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver2);
    $approver_list[]      = $this->approval_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver3);
    $approver_list[]      = $this->approval_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver4);
    $approver_list[]      = $this->approval_model->GET_EMPLOYEE_SPECIFIC_ROW($request->approver5);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $date_created         = date('Y-m-d H:i:s');
    $token['type']          = 'approval';
    $token['table']         = $decrypted_data->table;
    $token['id']            = $request->id;
    $token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));
    if ($request->status == 'Pending 1') {
        $status         = 'Pending 2';
        $description    = $notif_text. str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
        if(!$approver_list[1]){
            $status = 'Approved';
            $description = $notif_text. str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
        }
        //   if ($empl_approvers->approver_2a == 0 && $empl_approvers->approver_3a == 0) {
        //     $status = 'Approved';
        //     $description = $notif_text. str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
        //   }
    //   $this->approval_model->UPDATE_OVERTIME_ASSIGN($status, $emp_id, $date_created, $request->id);
      $res=$this->approval_model->APPROVE_REQUEST($decrypted_data->table,$decrypted_data->id,$decrypted_data->approver,
                                                    $decrypted_data->approver_id,$decrypted_data->approver_date_col,$status);
      $this->logger->log_activity($approver_id, 'Approved ' . $approval_empl_type . ' request [' . str_pad($request->id, 5, '0', STR_PAD_LEFT) . '] - Status: ' . $status);
      $notif_data     = array(
        'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => $approval_empl_type,
        'content_id' => $request->id, 'location' => $employee_notif_location, 'description' => $description
      );
      $this->approval_model->ADD_NOTIFICATION($notif_data);
      if ($status == 'Pending 2') {
        $token['approver']              = 'approver2';
        $token['approver_id']           = $request->approver2;
        $token['approver_date_col']     = 'approver2_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $res=$this->approval_model->SAVE_TOKEN(array('create_date'=>date('Y-m-d H:i:s'),
                                                    'edit_date'=>date('Y-m-d H:i:s'),
                                                    'empl_id'=>$request->approver2,
                                                    'code'=>$encrypted_token,
                                                    'expiration'=>$token['expiration'],
                                                    'status'=>'Active'));
        if($res){
            $notif_data['approve']='approvals/approve_request?token='.urlencode($encrypted_token);
            $notif_data['reject']='approvals/reject_request?token='.urlencode($encrypted_token);
        }
        $notif_data['type']         = $approval_type;
        $notif_data['empl_id']      = $request->approver2;
        $notif_data['description']  = $notif_text. str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = $approver_notif_location;
        $this->approval_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($request->status == 'Pending 2') {
      $status       = 'Pending 3';
      $description = $notif_text. str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
        if(!$approver_list[2]){
            $status = 'Approved';
            $description = $notif_text. str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
        }
    //   if ($empl_approvers->approver_3a == 0) {
    //     $status = 'Approved';
    //     $description = $notif_text. str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
      $res=$this->approval_model->APPROVE_REQUEST($decrypted_data->table,$decrypted_data->id,$decrypted_data->approver,
                                                    $decrypted_data->approver_id,$decrypted_data->approver_date_col,$status);
      $this->logger->log_activity($approver_id, 'Approved ' . $approval_empl_type . ' request [' . str_pad($request->id, 5, '0', STR_PAD_LEFT) . '] - Status: ' . $status);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => $approval_empl_type,
        'content_id' => $request->id, 'location' => $employee_notif_location, 'description' => $description
      );
      $this->approval_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 3') {
        $token['approver']              = 'approver3';
        $token['approver_id']           = $request->approver3;
        $token['approver_date_col']     = 'approver3_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $notif_data['approve']='approvals/approve_request?token='.urlencode($encrypted_token);
        $notif_data['reject']='approvals/reject_request?token='.urlencode($encrypted_token);
        $notif_data['type']         = $approval_type;
        $notif_data['empl_id']      = $request->approver3;
        $notif_data['description']  = $notif_text. str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = $approver_notif_location;
        $this->approval_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($request->status == 'Pending 3') {
      $status       = 'Pending 4';
      $description = $notif_text. str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
        if(!$approver_list[3]){
            $status = 'Approved';
            $description = $notif_text. str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
        }
    //   if ($empl_approvers->approver_3a == 0) {
    //     $status = 'Approved';
    //     $description = $notif_text. str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
      $res=$this->approval_model->APPROVE_REQUEST($decrypted_data->table,$decrypted_data->id,$decrypted_data->approver,
                                                    $decrypted_data->approver_id,$decrypted_data->approver_date_col,$status);
      $this->logger->log_activity($approver_id, 'Approved ' . $approval_empl_type . ' request [' . str_pad($request->id, 5, '0', STR_PAD_LEFT) . '] - Status: ' . $status);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => $approval_empl_type,
        'content_id' => $request->id, 'location' => $employee_notif_location, 'description' => $description
      );
      $this->approval_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 4') {
        $token['approver']              = 'approver4';
        $token['approver_id']           = $request->approver4;
        $token['approver_date_col']     = 'approver4_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $res=$this->approval_model->SAVE_TOKEN(array('create_date'=>date('Y-m-d H:i:s'),
                                                    'edit_date'=>date('Y-m-d H:i:s'),
                                                    'empl_id'=>$request->approver4,
                                                    'code'=>$encrypted_token,
                                                    'expiration'=>$token['expiration'],
                                                    'status'=>'Active'));
        if($res){
            $notif_data['approve']='approvals/approve_request?token='.urlencode($encrypted_token);
            $notif_data['reject']='approvals/reject_request?token='.urlencode($encrypted_token);
        }
        $notif_data['type']         = $approval_type;
        $notif_data['empl_id']      = $request->approver4;
        $notif_data['description']  = $notif_text. str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = $approver_notif_location;
        $this->approval_model->ADD_NOTIFICATION($notif_data);
      }
    }
    if ($request->status == 'Pending 4') {
      $status       = 'Pending 5';
      $description = $notif_text. str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been partially approved by " . $approver_name;
        if(!$approver_list[4]){
            $status = 'Approved';
            $description = $notif_text. str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
        }
    //   if ($empl_approvers->approver_3a == 0) {
    //     $status = 'Approved';
    //     $description = $notif_text. str_pad($id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
    //   }
      $res=$this->approval_model->APPROVE_REQUEST($decrypted_data->table,$decrypted_data->id,$decrypted_data->approver,
                                                    $decrypted_data->approver_id,$decrypted_data->approver_date_col,$status);
      $this->logger->log_activity($approver_id, 'Approved ' . $approval_empl_type . ' request [' . str_pad($request->id, 5, '0', STR_PAD_LEFT) . '] - Status: ' . $status);
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => $approval_empl_type,
        'content_id' => $request->id, 'location' => $employee_notif_location, 'description' => $description
      );
      $this->approval_model->ADD_NOTIFICATION($notif_data);

      if ($status == 'Pending 5') {
        $token['approver']              = 'approver5';
        $token['approver_id']           = $request->approver5;
        $token['approver_date_col']     = 'approver5_date';
        $json_token                     =  json_encode($token);
        $encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
        $res=$this->approval_model->SAVE_TOKEN(array('create_date'=>date('Y-m-d H:i:s'),
                                                    'edit_date'=>date('Y-m-d H:i:s'),
                                                    'empl_id'=>$request->approver5,
                                                    'code'=>$encrypted_token,
                                                    'expiration'=>$token['expiration'],
                                                    'status'=>'Active'));
        if($res){
            $notif_data['approve']='approvals/approve_request?token='.urlencode($encrypted_token);
            $notif_data['reject']='approvals/reject_request?token='.urlencode($encrypted_token);
        }
        $notif_data['type']         = $approval_type;
        $notif_data['empl_id']      = $request->approver5;
        $notif_data['description']  = $notif_text. str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] by " . $request->employee . " has been requested";
        $notif_data['location']     = $approver_notif_location;
        $this->approval_model->ADD_NOTIFICATION($notif_data);
      }
    }
    
    if ($request->status == 'Pending 5') {
      $status       = 'Approved';
      $res=$this->approval_model->APPROVE_REQUEST($decrypted_data->table,$decrypted_data->id,$decrypted_data->approver,
                                                    $decrypted_data->approver_id,$decrypted_data->approver_date_col,$status);
      $this->logger->log_activity($approver_id, 'Approved ' . $approval_empl_type . ' request [' . str_pad($request->id, 5, '0', STR_PAD_LEFT) . '] - Status: ' . $status);
      $description = $notif_text. str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been fully approved by " . $approver_name;
      $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => $approval_empl_type,
        'content_id' => $request->id, 'location' => $employee_notif_location, 'description' => $description
      ); 

      $this->approval_model->ADD_NOTIFICATION($notif_data);
    }
  }
  private function  request_action_reject($decrypted_data,$approver_id,$request,$notif_text,$approval_empl_type,$employee_notif_location){
    $is_already_approve = $this->approval_model->CHECK_STATUS($decrypted_data->table,$decrypted_data->approver_date_col,$decrypted_data->id);
    if($is_already_approve==0){
        // $this->approval_model->UPDATE_TOKEN_STATUS($decrypted_data->id,'Inactive');
        $decrypted_data->status='Inactive';
        return $decrypted_data;
    }
    $user_id              = $approver_id; 
    $approver             = $this->approval_model->GET_EMPLOYEE_SPECIFIC_ROW($user_id);
    $approver_name        = $this->system_functions->fomatName($approver->col_last_name, $approver->col_frst_name, $approver->col_midl_name);
    $date_created         = date('Y-m-d H:i:s');
    $status               = 'Rejected';
    $description = $notif_text . str_pad($request->id, 5, '0', STR_PAD_LEFT) . "] has been rejected by " . $approver_name;
    $notif_data = array(
        'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $request->empl_id, 'type' => $approval_empl_type,
        'content_id' =>$request->id, 'location' => $approval_empl_type, 'description' => $description
    );
    $res=$this->approval_model->APPROVE_REQUEST($decrypted_data->table,$decrypted_data->id,$decrypted_data->approver,
                                                    $decrypted_data->approver_id,$decrypted_data->approver_date_col,$status);
    $this->logger->log_activity($approver_id, 'Rejected ' . $approval_empl_type . ' request [' . str_pad($request->id, 5, '0', STR_PAD_LEFT) . ']');
    $this->approval_model->ADD_NOTIFICATION($notif_data);
  }
    
}