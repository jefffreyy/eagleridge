<style>
    div.dataTables_wrapper div.dataTables_paginate{
        display: flex;
    }
  .btn-group .btn{
    padding: 0px 12px;
  }
  .page-title{
    font-weight: 600;
    color: #424F5C;
    font-size: 33px;
  }
  th,td{
    font-size: 13px !important;
    border-top: none !important;
  }
  label.required::after{
    content:" *";
    color: red;
  }
  .card-body{
    padding: 15px 20px !important;
  }

  #tab_pills_container li a.active{
    border-bottom: 1px solid #dee2e6;
    border-bottom-left-radius: .25rem;
    border-bottom-right-radius: .25rem;
    background-color: #0f67a3 !important;
    color: #fff !important;
  }

  #tab_pills_container li a:not(.active):hover{
    background-color: #ccc !important;
  }

  .approval_card{
    cursor: pointer;
    border-bottom: 1px solid #dadada;
  }
  .approval_card img{
    width: 40px;
    height: 40px;
  }
  .approval_card p{
    font-size: 10px;
  }
  .approval_card a:not(.btn){
    font-size: 10px;
  }
  .approval_card:hover{
    background-color: #E0F2FF;
  }

  .view_overtime_details:hover{
    background-color: #E0F2FF;
  }

  .view_adjustment_details:hover{
    background-color: #E0F2FF;
  }

  .btn-primary-inactive{
    background-color: #bfe3fb;
    color: #0D74BC !important;
  }

  .btn-primary-inactive:hover{
    background-color: #76c4f8;
    color: #fff !important;
  }
</style>
<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Datatables -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Pagination -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">
<div class="content-wrapper">
  <div class="Container-fluid p-4">
      <div class="row">
        <div class="col-md-6">
          <h1 class="page-title">Leave Applications</h1>
        </div>
        <div class="col-md-6" style = "text-align: right;">
          <a href="<?= base_url() ?>approval/approval_list_time_adjustment" class="btn btn-primary shadow-none" style="text-decoration: none;"><i class="fas fa-wrench"></i>&nbsp; &nbsp; Time Adjustment</a>
          <a href="<?= base_url() ?>approval/approval_list_overtime" class="btn btn-primary shadow-none" style="text-decoration: none;"><i class="fas fa-history"></i>&nbsp; &nbsp; Overtime</a>
          <a href="#" class="btn btn-primary shadow-none" style="text-decoration: none;"><i class="fas fa-door-open"></i>&nbsp; &nbsp; Leave</a>
        </div>
      </div>
      <hr>
      
      <a href = "#" id="reject_all" type ="button" class = "btn btn-danger shadow-none float-right mr-3" approve_type='Reject'>Reject All Selected</a>
      <a href = "#" id="approve_all" type ="button" class = "btn btn-primary shadow-none float-right mr-3" approve_type='Approve'>Approve All Selected</a>

      <ul class="nav nav-tabs border-0" id="tab_pills_container">
          <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#for_approval">For Approval</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#approved">Approved</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#rejected">Rejected</a>
          </li>
      </ul>
      <div class="tab-content mt-3">
        <div class="tab-pane active" id="for_approval">
          <div class="row" >
            <div class="col-md-3">
              <div class="card">
                <div class="card-header">
                  <div class="card-title w-100 text-center mb-0" style="font-size: 13.5px;">For Approval</div>
                </div>

                <?php
                  if($DISP_LEAVES_FOR_APPROVAL){
                    foreach($DISP_LEAVES_FOR_APPROVAL as $DISP_LEAVES_FOR_APPROVAL_ROW){
                      $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_LEAVES_FOR_APPROVAL_ROW->col_empl_id);
                      $db_date_from = $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_from;
                      $date_from = date('l, F j, Y',strtotime($db_date_from));

                      // get approval route
                      $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_LEAVE();

                      // loop through the approval routes
                      foreach($approval_route as $approval_route_row){
                        // check if you are a approver then show the list of requests you can only approve
                        $my_user_id = $this->session->userdata('SESS_USER_ID');
                        if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id) || ($approval_route_row->approver7 == $my_user_id)){

                          if((($DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_status1 != 'Rejected') && ($DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_status2 != 'Rejected') && ($DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_status3 != 'Rejected')) && (($DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_status1 == 'Pending Approval') || ($DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_status2 == 'Pending Approval') || ($DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_status3 == 'Pending Approval'))){
                            if(!empty($employee_id[0]->col_midl_name)){
                              $midl_ini = $employee_id[0]->col_midl_name[0].'.';
                            }else{
                                $midl_ini = '';
                            }
                          ?>
                            <div class="card-body approval_card for_approval_details" data-toggle="modal" data-target="#modal_for_approval_details" leave_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>" employee_id='<?= $employee_id[0]->id?>'>
                                <div class="d-flex">
                                  <img src="<?= base_url() ?>user_images/<?php echo $employee_id[0]->col_imag_path ? $employee_id[0]->col_imag_path : 'default_profile_img3.png'; ?>"  class="rounded-circle avatar mt-2">
                                  <div class="ml-2 mt-1">
                                      <a href="#" style="font-size: 11px; color: #1993D7;"><?= $employee_id[0]->col_last_name.', '.$employee_id[0]->col_frst_name.' '.$midl_ini ?></a>
                                      <p class="mb-1 text-secondary"><?= $employee_id[0]->col_empl_posi ?></p>
                                      <p class="mb-0">Leave Date:  <?= $db_date_from ?></p>
                                  </div>
                                  <div class="ml-4">
                                      <div class="w-100 mt-2">
                                          <div class="float-right text-center" style="height: 100%; width: 80px;">
                                              <p class="mb-0">Leave Type:</p>
                                              <label style="color: #687CED;font-size: 11px;"><?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?></label>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            <?php
                          }
                        }
                      }
                    }
                  }
                ?>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <div class="card-header">
                  <div class="card-title w-100 mb-0" style="font-size: 13.5px;">
                  <a href='#' id="check_all_appr_1" class="float-right" style="font-weight: 500; text-decoration: none; margin-bottom: -20px;">Check All</a>
                    Approver 1
                  </div>
                </div>

                <?php
                  if($DISP_LEAVES_FOR_APPROVAL){
                    foreach($DISP_LEAVES_FOR_APPROVAL as $DISP_LEAVES_FOR_APPROVAL_ROW){
                      $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_LEAVES_FOR_APPROVAL_ROW->col_empl_id);
                      $db_date_from = $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_from;
                      $date_from = date('l, F j, Y',strtotime($db_date_from));

                      $status1 = $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_status1;

                      switch ($DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type) {
                        case 'Vacation Leave':
                            $leave_balance = $employee_id[0]->col_leave_vacation;
                            break;
                        case 'Sick Leave':
                            $leave_balance = $employee_id[0]->col_leave_sick;
                            break;
                        case 'Maternity Leave':
                            $leave_balance = $employee_id[0]->col_leave_maternity;
                            break;
                        case 'Parental Leave':
                            $leave_balance = $employee_id[0]->col_leave_parental;
                            break;
                        case 'Paternity Leave':
                            $leave_balance = $employee_id[0]->col_leave_paternal;
                            break;
                        case 'Service Incentive Leave':
                            $leave_balance = $employee_id[0]->col_leave_service_incentive;
                            break;
                        case 'Solo Incentive Leave':
                            $leave_balance = $employee_id[0]->col_leave_solo_incentive;
                            break;
                        default:
                        $leave_balance = '';
                      }
                      
                      $empl_group = 'No Group';
                      $empl_id = '';
                      if(count($employee_id) > 0 ){
                        $empl_group = $employee_id[0]->col_empl_group;
                        $empl_id = $employee_id[0]->id;
                      }

                      // get approval route
                      // $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
                      $approval_route = $this->approval_route_mod->MOD_DISP_GROUP_APPROVERS($empl_group);

                      // loop through the approval routes
                      foreach($approval_route as $approval_route_row){
                        // check if you are a approver then show the list of requests you can only approve
                        $my_user_id = $this->session->userdata('SESS_USER_ID');
                        if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)){

                          if($status1 == 'Pending Approval'){
                            if(!empty($employee_id[0]->col_midl_name)){
                              $midl_ini = $employee_id[0]->col_midl_name[0].'.';
                            }else{
                                $midl_ini = '';
                            }
                          ?>
                          <div class="card-body approval_card appr_details" data-toggle="modal" data-target="#modal_appr_details" appr_num="appr_1" leave_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>" employee_id='<?= $employee_id[0]->id?>'  approve_key='<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>' leave_balance='<?= $leave_balance ?>' leave_duration='<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_duration ?>' leave_type="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?>">
                              <div class="d-flex">
                                <img src="<?= base_url() ?>user_images/<?php echo $employee_id[0]->col_imag_path ? $employee_id[0]->col_imag_path : 'default_profile_img3.png'; ?>"  class="rounded-circle avatar mt-2">
                                <div class="ml-2 mt-1">
                                    <a href="#" style="font-size: 11px; color: #1993D7;"><?= $employee_id[0]->col_last_name.' '.$employee_id[0]->col_frst_name.' '.$midl_ini?></a>
                                    <p class="mb-1 text-secondary"><?= $employee_id[0]->col_empl_posi ?></p>
                                    <p class="mb-0">Leave Date:  <?= $db_date_from ?></p>
                                </div>
                                <div class="flex-fill">
                                    <div class="w-100 mt-2">
                                        <div class="float-right text-center" style="height: 100%; width: 80px;">
                                            <p class="mb-0">Leave Type:</p>
                                            <label style="color: #687CED;font-size: 11px;"><?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?></label>
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="d-flex flex-row-reverse mt-3">
                                  <a href="#" class="btn_fast_reject btn btn-danger" style="font-size: 12px !important;" reject_key="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>" appr_num="appr_1" leave_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>" employee_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>"><i class="fas fa-times"></i> &nbsp; Reject</a>
                                  <a href="#" class="btn_fast_approve btn btn-primary mr-1" style="font-size: 12px !important;" hidden_appr_num="appr_1" hidden_approve_key="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>" hidden_leave_balance="<?= $leave_balance ?>" hidden_leave_duration="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_duration ?>" hidden_leave_type="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?>" hidden_employee_id="<?= $employee_id[0]->id?>"><i class="fas fa-check"></i> &nbsp; Approve</a>
                              </div>
                            </div>
                            <div class="form-group ml-2 mb-0 mr-auto" style="margin-top: -40px; margin-left: 20px;">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" class="selected_application selected_application_appr_1" id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>" empl_id="<?= $empl_id ?>"  appr_num="appr_1" leave_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>" employee_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_empl_id ?>" leave_balance="<?= $leave_balance ?>" leave_duration="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_duration ?>" leave_type="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?>">
                                    <label for="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>"></label>
                                </div>
                            </div>
                          <?php
                          }
                        }
                      }
                    }
                  }
                ?>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <div class="card-header">
                  <div class="card-title w-100 mb-0" style="font-size: 13.5px;">
                    <a href='#' id="check_all_appr_2" class="float-right" style="font-weight: 500; text-decoration: none; margin-bottom: -20px;">Check All</a>
                    Approver 2
                  </div>
                </div>

                <?php
                  if($DISP_LEAVES_FOR_APPROVAL){
                    foreach($DISP_LEAVES_FOR_APPROVAL as $DISP_LEAVES_FOR_APPROVAL_ROW){
                      $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_LEAVES_FOR_APPROVAL_ROW->col_empl_id);
                      $db_date_from = $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_from;
                      $date_from = date('l, F j, Y',strtotime($db_date_from));

                      $status1 = $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_status1;
                      $status2 = $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_status2;
                      $status3 = $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_status3;

                      switch ($DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type) {
                        case 'Vacation Leave':
                            $leave_balance = $employee_id[0]->col_leave_vacation;
                            break;
                        case 'Sick Leave':
                            $leave_balance = $employee_id[0]->col_leave_sick;
                            break;
                        case 'Maternity Leave':
                            $leave_balance = $employee_id[0]->col_leave_maternity;
                            break;
                        case 'Parental Leave':
                            $leave_balance = $employee_id[0]->col_leave_parental;
                            break;
                        case 'Paternity Leave':
                            $leave_balance = $employee_id[0]->col_leave_paternal;
                            break;
                        case 'Service Incentive Leave':
                            $leave_balance = $employee_id[0]->col_leave_service_incentive;
                            break;
                        case 'Solo Incentive Leave':
                            $leave_balance = $employee_id[0]->col_leave_solo_incentive;
                            break;
                        default:
                        $leave_balance = '';
                      }

                      $empl_group = 'No Group';
                      $empl_id = '';
                      if(count($employee_id) > 0 ){
                        $empl_group = $employee_id[0]->col_empl_group;
                        $empl_id = $employee_id[0]->id;
                      }

                      // get approval route
                      $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_LEAVE();

                      // loop through the approval routes
                      foreach($approval_route as $approval_route_row){
                        // check if you are a approver then show the list of requests you can only approve
                        $my_user_id = $this->session->userdata('SESS_USER_ID');
                        if(($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id)){
                          
                          if(($status1 == 'Approved') && ($status2 == 'Pending Approval')){
                            if(!empty($employee_id[0]->col_midl_name)){
                              $midl_ini = $employee_id[0]->col_midl_name[0].'.';
                            }else{
                                $midl_ini = '';
                            }
                          ?>
                          <div class="card-body approval_card appr_details" data-toggle="modal" data-target="#modal_appr_details" appr_num="appr_2" leave_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>" employee_id='<?= $employee_id[0]->id?>'  approve_key='<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>' leave_balance='<?= $leave_balance ?>' leave_duration='<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_duration ?>' leave_type="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?>">
                              <div class="d-flex">
                                <img src="<?= base_url() ?>user_images/<?php echo $employee_id[0]->col_imag_path ? $employee_id[0]->col_imag_path : 'default_profile_img3.png'; ?>"  class="rounded-circle avatar mt-2">
                                <div class="ml-2 mt-1">
                                    <a href="#" style="font-size: 11px; color: #1993D7;"><?= $employee_id[0]->col_last_name.' '.$employee_id[0]->col_frst_name.' '.$midl_ini ?></a>
                                    <p class="mb-1 text-secondary"><?= $employee_id[0]->col_empl_posi ?></p>
                                    <p class="mb-0">Leave Date:  <?= $db_date_from ?></p>
                                </div>
                                <div class="flex-fill">
                                    <div class="w-100 mt-2">
                                        <div class="float-right text-center" style="height: 100%; width: 80px;">
                                            <p class="mb-0">Leave Type:</p>
                                            <label style="color: #687CED;font-size: 11px;"><?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?></label>
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="d-flex flex-row-reverse mt-3">
                                  <a href="#" class="btn_fast_reject btn btn-danger" style="font-size: 12px !important;" reject_key="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>" appr_num="appr_2" leave_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>" employee_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>"><i class="fas fa-times"></i> &nbsp; Reject</a>
                                  <a href="#" class="btn_fast_approve btn btn-primary mr-1" style="font-size: 12px !important;" hidden_appr_num="appr_2" hidden_approve_key="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>" hidden_leave_balance="<?= $leave_balance ?>" hidden_leave_duration="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_duration ?>" hidden_leave_type="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?>" hidden_employee_id="<?= $employee_id[0]->id?>"><i class="fas fa-check"></i> &nbsp; Approve</a>
                              </div>
                            </div>
                            <div class="form-group ml-2 mb-0 mr-auto" style="margin-top: -40px; margin-left: 20px;">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" class="selected_application selected_application_appr_2" id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>" empl_id="<?= $empl_id ?>"  appr_num="appr_2" leave_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>" employee_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_empl_id ?>" leave_balance="<?= $leave_balance ?>" leave_duration="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_duration ?>" leave_type="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?>">
                                    <label for="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>"></label>
                                </div>
                            </div>
                          <?php
                          }
                        }
                      }
                    }
                  }
                ?>
                
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <div class="card-header">
                  <div class="card-title w-100 text-center mb-0" style="font-size: 13.5px;">
                  <a href='#' id="check_all_appr_3" class="float-right" style="font-weight: 500; text-decoration: none; margin-bottom: -20px;">Check All</a>
                    Approver 3
                  </div>
                </div>

                <?php
                  if($DISP_LEAVES_FOR_APPROVAL){
                    foreach($DISP_LEAVES_FOR_APPROVAL as $DISP_LEAVES_FOR_APPROVAL_ROW){

                        $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_LEAVES_FOR_APPROVAL_ROW->col_empl_id);
                        $empl_id = '';  
                      
                        if($employee_id){

                          if(($employee_id[0]->col_empl_group == 'STAFF') || ($employee_id[0]->col_empl_group == 'Staff') || ($employee_id[0]->col_empl_group == 'staff')){
                            $empl_id = $employee_id[0]->id;

                            $db_date_from = $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_from;
                            $date_from = date('l, F j, Y',strtotime($db_date_from));

                            $status1 = $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_status1;
                            $status2 = $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_status2;
                            $status3 = $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_status3;

                            switch ($DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type) {
                              case 'Vacation Leave':
                                  $leave_balance = $employee_id[0]->col_leave_vacation;
                                  break;
                              case 'Sick Leave':
                                  $leave_balance = $employee_id[0]->col_leave_sick;
                                  break;
                              case 'Maternity Leave':
                                  $leave_balance = $employee_id[0]->col_leave_maternity;
                                  break;
                              case 'Parental Leave':
                                  $leave_balance = $employee_id[0]->col_leave_parental;
                                  break;
                              case 'Paternity Leave':
                                  $leave_balance = $employee_id[0]->col_leave_paternal;
                                  break;
                              case 'Service Incentive Leave':
                                  $leave_balance = $employee_id[0]->col_leave_service_incentive;
                                  break;
                              case 'Solo Incentive Leave':
                                  $leave_balance = $employee_id[0]->col_leave_solo_incentive;
                                  break;
                              default:
                              $leave_balance = '';
                            }

                            // get approval route
                            $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_LEAVE();

                            // loop through the approval routes
                            foreach($approval_route as $approval_route_row){
                              // check if you are a approver then show the list of requests you can only approve
                              $my_user_id = $this->session->userdata('SESS_USER_ID');
                              if(($approval_route_row->approver6 == $my_user_id) || ($approval_route_row->approver7 == $my_user_id)){
                                
                                if(($status2 == 'Approved') && ($status3 == 'Pending Approval')){
                                  if(!empty($employee_id[0]->col_midl_name)){
                                    $midl_ini = $employee_id[0]->col_midl_name[0].'.';
                                  }else{
                                      $midl_ini = '';
                                  }
                                ?>
                                <div class="card-body approval_card appr_details" data-toggle="modal" data-target="#modal_appr_details" appr_num="appr_3" leave_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>" employee_id='<?= $employee_id[0]->id?>'  approve_key='<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>' leave_balance='<?= $leave_balance ?>' leave_duration='<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_duration ?>' leave_type="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?>">
                                    <div class="d-flex">
                                      <img src="<?= base_url() ?>user_images/<?php echo $employee_id[0]->col_imag_path ? $employee_id[0]->col_imag_path : 'default_profile_img3.png'; ?>"  class="rounded-circle avatar mt-2">
                                      <div class="ml-2 mt-1">
                                          <a href="#" style="font-size: 11px; color: #1993D7;"><?= $employee_id[0]->col_last_name.' '.$employee_id[0]->col_frst_name.' '.$midl_ini ?></a>
                                          <p class="mb-1 text-secondary"><?= $employee_id[0]->col_empl_posi ?></p>
                                          <p class="mb-0">Leave Date:  <?= $db_date_from ?></p>
                                      </div>
                                      <div class="flex-fill">
                                          <div class="w-100 mt-2">
                                              <div class="float-right text-center" style="height: 100%; width: 80px;">
                                                  <p class="mb-0">Leave Type:</p>
                                                  <label style="color: #687CED;font-size: 11px;"><?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?></label>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex flex-row-reverse">
                                        <a href="#" class="btn_fast_reject btn btn-danger" style="font-size: 12px !important;" reject_key="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>" appr_num="appr_3" leave_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>" employee_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>"><i class="fas fa-times"></i> &nbsp; Reject</a>
                                        <a href="#" class="btn_fast_approve btn btn-primary mr-1" style="font-size: 12px !important;" hidden_appr_num="appr_3" hidden_approve_key="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id?>" hidden_leave_balance="<?= $leave_balance ?>" hidden_leave_duration="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_duration ?>" hidden_leave_type="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?>" hidden_employee_id="<?= $employee_id[0]->id?>"><i class="fas fa-check"></i> &nbsp; Approve</a>
                                    </div>
                                  </div>
                                  <div class="form-group ml-2 mb-0 mr-auto" style="margin-top: -40px; margin-left: 20px;">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="selected_application selected_application_appr_3" id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>" empl_id="<?= $empl_id ?>"  appr_num="appr_3" leave_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>" employee_id="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_empl_id ?>" leave_balance="<?= $leave_balance ?>" leave_duration="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_duration ?>" leave_type="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->col_leave_type ?>">
                                        <label for="<?= $DISP_LEAVES_FOR_APPROVAL_ROW->id ?>"></label>
                                    </div>
                                </div>
                                <?php
                                }
                              }
                            }

                          }
                          
                        }
                    }
                  }
                ?>
                
              </div>
            </div>
          </div>
        </div>

        <div class="card p-4 tab-pane" id="approved" style="border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
          <table class="table table-hover table-xs mb-0" id="approved_tbl">
              <thead>
                  <th>Application ID</th>
                  <th>Application Date</th>
                  <th>Assigned By</th>
                  <th>Employee</th>
                  <th>Date</th>
                  <th>Leave Type</th>
                  <th>Reason for leave</th>
                  <th>Duration (Day/s)</th>
                  <th>Status</th>
              </thead>
              <tbody style="font-weight: 500 !important;">
                  <?php 
                      if($DISP_LEAVES_APPROVED){
                        foreach($DISP_LEAVES_APPROVED as $DISP_LEAVES_APPROVED_ROW){
                          $application_id = 'LV'.str_pad($DISP_LEAVES_APPROVED_ROW->id, 5, '0', STR_PAD_LEFT);
                          $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_LEAVES_APPROVED_ROW->col_empl_id);
                          $assigned_by = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_LEAVES_APPROVED_ROW->col_assigned_by);
                          $db_date_from = $DISP_LEAVES_APPROVED_ROW->col_leave_from;
                          $date_from = date('l, F j, Y',strtotime($db_date_from));


                          // check if leave balance has value (leave balance is the difference of current leave balance and duration)
                          if($DISP_LEAVES_APPROVED_ROW->col_leave_balance != 0){
                            $leave_balance = $DISP_LEAVES_APPROVED_ROW->col_leave_balance;
                          }

                          // get approval route
                          $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_LEAVE();

                          // loop through the approval routes
                          foreach($approval_route as $approval_route_row){

                            // check if you are a approver then show the list of requests you can only approve
                            $my_user_id = $this->session->userdata('SESS_USER_ID');

                            if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id) || ($approval_route_row->approver7 == $my_user_id)){
                              
                              if(!empty($assigned_by[0]->col_midl_name)){
                                  $midl_ini = $assigned_by[0]->col_midl_name[0].'.';
                              }else{
                                  $midl_ini = '';
                              }
                              if(!empty($employee_id[0]->col_midl_name)){
                                  $midl_ini2 = $employee_id[0]->col_midl_name[0].'.';
                              }else{
                                  $midl_ini2 = '';
                              }
                              
                              ?>
                                <tr>
                                    <td><?= $application_id ?></td>
                                    <td><?= $DISP_LEAVES_APPROVED_ROW->col_date_created ?></td>
                                    <td>
                                      <a href = "<?=base_url()?>employees/personal?id=<?= $assigned_by[0]->id ?>">
                                          <img class="rounded-circle avatar " width="35" height="35" src="<?php if($assigned_by[0]->col_imag_path){echo base_url().'user_images/'.$assigned_by[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $assigned_by[0]->col_last_name.', '.$assigned_by[0]->col_frst_name.' '.$midl_ini?>
                                      </a>
                                    </td>
                                    <td>
                                      <a href = "<?=base_url()?>employees/personal?id=<?= $employee_id[0]->id ?>">
                                          <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee_id[0]->col_imag_path){echo base_url().'user_images/'.$employee_id[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $employee_id[0]->col_last_name.', '.$employee_id[0]->col_frst_name.' '.$midl_ini2?>
                                      </a>
                                    </td>
                                    <td><?= $date_from ?></td>
                                    <td><?= $DISP_LEAVES_APPROVED_ROW->col_leave_type ?></td>
                                    <td><?= $DISP_LEAVES_APPROVED_ROW->col_leave_comments ?></td>
                                    <td><?= $DISP_LEAVES_APPROVED_ROW->col_leave_duration ?></td>
                                    <td><?= $DISP_LEAVES_APPROVED_ROW->col_leave_status1 ?></td>
                                </tr>
                              <?php
                            }
                          }
                        }
                      } else {
                        ?>
                          <tr>
                            <td class="p-4" colspan="6">No approved leave application yet</td>
                          </tr>
                        <?php
                      }
                  ?>
              </tbody>
          </table>
        </div>
        <div class="card p-4 tab-pane" id="rejected" style="border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
          <table class="table table-hover table-xs mb-0" id="rejected_tbl">
              <thead>
                  <th>Application ID</th>
                  <th>Application Date</th>
                  <th>Assigned By</th>
                  <th>Employee</th>
                  <th>Date</th>
                  <th>Leave Type</th>
                  <th>Reason for rejection</th>
                  <th>Duration (Day/s)</th>
                  <th>Status</th>
              </thead>
              <tbody style="font-weight: 500 !important;">
                  <?php 
                      if($DISP_LEAVES_REJECTED){
                          foreach($DISP_LEAVES_REJECTED as $DISP_LEAVES_REJECTED_ROW){
                            $application_id = 'LV'.str_pad($DISP_LEAVES_REJECTED_ROW->id, 5, '0', STR_PAD_LEFT);
                            $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_LEAVES_REJECTED_ROW->col_empl_id);
                            $assigned_by = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_LEAVES_REJECTED_ROW->col_assigned_by);
                            $db_date_from = $DISP_LEAVES_REJECTED_ROW->col_leave_from;
                            $date_from = date('l, F j, Y',strtotime($db_date_from));

                            // get approval route
                            $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_LEAVE();

                            // loop through the approval routes
                            foreach($approval_route as $approval_route_row){

                              // check if you are a approver then show the list of requests you can only approve
                              $my_user_id = $this->session->userdata('SESS_USER_ID');

                              if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id) || ($approval_route_row->approver7 == $my_user_id)){
                                
                              if(!empty($assigned_by[0]->col_midl_name)){
                                  $midl_ini = $assigned_by[0]->col_midl_name[0].'.';
                              }else{
                                  $midl_ini = '';
                              }
                              if(!empty($employee_id[0]->col_midl_name)){
                                  $midl_ini2 = $employee_id[0]->col_midl_name[0].'.';
                              }else{
                                  $midl_ini2 = '';
                              }
                            
                                ?>
                                  <tr>
                                      <td><?= $application_id ?></td>
                                      <td><?= $DISP_LEAVES_REJECTED_ROW->col_date_created ?></td>
                                      <td>
                                        <a href = "<?=base_url()?>employees/personal?id=<?= $assigned_by[0]->id ?>">
                                            <img class="rounded-circle avatar " width="35" height="35" src="<?php if($assigned_by[0]->col_imag_path){echo base_url().'user_images/'.$assigned_by[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $assigned_by[0]->col_last_name.', '.$assigned_by[0]->col_frst_name.' '.$midl_ini?>
                                        </a>
                                      </td>
                                      <td>
                                        <a href = "<?=base_url()?>employees/personal?id=<?= $employee_id[0]->id ?>">
                                            <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee_id[0]->col_imag_path){echo base_url().'user_images/'.$employee_id[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $employee_id[0]->col_last_name.', '.$employee_id[0]->col_frst_name.' '.$midl_ini2?>
                                        </a>
                                      </td>
                                      <td><?= $date_from ?></td>
                                      <td><?= $DISP_LEAVES_REJECTED_ROW->col_leave_type ?></td>
                                      <td><?= $DISP_LEAVES_REJECTED_ROW->col_reason_rejection ?></td>
                                      <td><?= $DISP_LEAVES_REJECTED_ROW->col_leave_duration ?></td>
                                      <td>Rejected</td>
                                  </tr>
                                <?php
                                
                                
                              }
                            }
                          }
                      } else {
                        ?>
                          <tr>
                            <td class="p-4" colspan="6">No rejected leave application yet</td>
                          </tr>
                        <?php
                      }
                  ?>
              </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- flex-fill -->
  </div>
  <!-- p-3 -->
</div>













<!-- Selected Approved Applications Details Hidden Container -->
<form action="<?php echo base_url('approval/approve_all_leave'); ?>" id="form_approve_all" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
    
</form>


<!-- Selected Rejected Applications Details Hidden Container -->
<form action="<?php echo base_url('approval/reject_all_leave'); ?>" id="form_reject_all" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
    
</form>


















<!-- content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>

<!-- View For Approval Details -->
<div class="modal fade" id="modal_for_approval_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title mt-0 ml-1">Leave Details
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pb-5">
        <div class="row">
          <div class="col-md-4">
            <div class="w-100 text-center pt-4">
              <img id="modal_employee_img" class="rounded-circle" alt="" style="width: 150px; height: 150px;">
            </div>
            <div class="pl-3 mt-3">
              <p class="text-bold mb-1">Name:</p>
              <p class="mb-4" id="employee_name"></p>
              <p class="text-bold mb-1">Position:</p>
              <p class="mb-4" id="employee_position"></p>
              <p class="text-bold mb-1">Department:</p>
              <p class="mb-4" id="employee_department"></p>
            </div>
          </div>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Date Requested:</p>
                  <p class="mb-4" id="leave_date_requested"></p>
                  <p class="text-bold mb-1">Request Leave On:</p>
                  <p class="mb-4" id="leave_on_date"></p>
                  <p class="text-bold mb-1">Leave Type:</p>
                  <p class="mb-4" id="leave_type"></p> 
                </div>
              </div>
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Reason:</p>
                  <p class="mb-4"id="leave_reason"></p>
                  <p class="text-bold mb-1">Duration:</p>
                  <p class="mb-4"id="leave_duration"></p>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <p class="text-bold mb-1">Status:</p>
                <p class="mb-4"id="leave_status1"></p>
              </div>
              <div class="col-md-4">
                <p class="text-bold mb-1">Status:</p>
                <p class="mb-4"id="leave_status2"></p>
              </div>
              <div class="col-md-4">
                <p class="text-bold mb-1">Status:</p>
                <p class="mb-4"id="leave_status3"></p>
              </div>
            </div>
            
            <hr>
            <div class="row">
                <div class="col-md-12">
                  <p class="text-bold mb-1">Photo Attachments:</p>
                  <a id="leave_attachment_link" target="_blank">
                    <img id="leave_attachment" alt="" src="<?= base_url() ?>user_images/11017face-10.jpg" style="width: 100px;cursor:pointer" class="w3-hover-opacity">
                  </a>
                  <p style="display:none" class="text-muted" id="empty_attachment">No photo attached</p>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- View Leave Details for Approver -->
<div class="modal fade" id="modal_appr_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title mt-0 ml-1">Leave Details
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pb-5">
        <div class="row">
          <div class="col-md-4">
            <div class="w-100 text-center pt-4">
              <img id="modal_employee_img_appr" class="rounded-circle" alt="" style="width: 150px; height: 150px;">
            </div>
            <div class="pl-3 mt-3">
              <p class="text-bold mb-1">Name:</p>
              <p class="mb-4" id="employee_name_appr"></p>
              <p class="text-bold mb-1">Position:</p>
              <p class="mb-4" id="employee_position_appr"></p>
              <p class="text-bold mb-1">Department:</p>
              <p class="mb-4" id="employee_department_appr"></p>
            </div>
          </div>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Date Requested:</p>
                  <p class="mb-4" id="leave_date_requested_appr"></p>
                  <p class="text-bold mb-1">Request Leave On:</p>
                  <p class="mb-4" id="leave_on_date_appr"></p>
                  <p class="text-bold mb-1">Leave Type:</p>
                  <p class="mb-4" id="leave_type_appr"></p> 
                </div>
              </div>
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Reason:</p>
                  <p class="mb-4"id="leave_reason_appr"></p>
                  <p class="text-bold mb-1">Duration:</p>
                  <p class="mb-4"id="leave_duration_appr"></p>
                  <p class="text-bold mb-1">Status:</p>
                  <p class="mb-4"id="leave_status_appr"></p>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <p class="text-bold mb-1">Status1:</p>
                <p class="mb-4"id="leave_status1_appr"></p>
              </div>
              <div class="col-md-4">
                <p class="text-bold mb-1">Status2:</p>
                <p class="mb-4"id="leave_status2_appr"></p>
              </div>
              <div class="col-md-4">
                <p class="text-bold mb-1">Status3:</p>
                <p class="mb-4"id="leave_status3_appr"></p>
              </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                  <p class="text-bold mb-1">Photo Attachments:</p>
                  <a id="leave_attachment_link_appr" target="_blank">
                    <img id="leave_attachment_appr" alt="" src="" style="width: 100px;cursor:pointer" class="w3-hover-opacity">
                  </a>
                  <p style="display:none" class="text-muted" id="empty_attachment_appr">No photo attached</p>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="hidden_leave_id">
        <input type="hidden" id="hidden_employee_id">
        <input type="hidden" id="hidden_approve_key">
        <input type="hidden" id="hidden_leave_balance">
        <input type="hidden" id="hidden_leave_duration">
        <input type="hidden" id="hidden_leave_type">

        <input type="hidden" id="hidden_appr_num">

        <a class='btn btn-primary text-light' id="btn_approve_leave">&nbsp; Approve</a>
        <a class='btn btn-danger text-light BTN_REJECT_LEAVE' id="btn_reject_leave" data-toggle="modal" data-target="#modal_leave_rejection_reason">&nbsp; Reject</a>
      </div>
    </div>
  </div>
</div>

<!-- View Overtime Details -->
<div class="modal fade" id="modal_overtime_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title mt-0 ml-1">Overtime Details
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body pb-5">
        <div class="row">
          <div class="col-md-4">
            <div class="w-100 text-center pt-4">
              <img id="ot_modal_employee_img" class="rounded-circle" alt="" style="width: 150px; height: 150px;">
            </div>
            <div class="pl-3 mt-3">
              <p class="text-bold mb-1">Name:</p>
              <p class="mb-4" id="ot_employee_name"></p>
              <p class="text-bold mb-1">Position:</p>
              <p class="mb-4" id="ot_employee_position"></p>
              <p class="text-bold mb-1">Department:</p>
              <p class="mb-4" id="ot_employee_department"></p>
            </div>
          </div>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Application Date:</p>
                  <p class="mb-4" id="ot_application_date"></p>
                  <p class="text-bold mb-1">Overtime Date:</p>
                  <p class="mb-4" id="ot_overtime_date"></p>
                  <p class="text-bold mb-1">Time Out:</p>
                  <p class="mb-4" id="ot_time_out"></p> 
                </div>
              </div>
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">No. of Hours:</p>
                  <p class="mb-4"id="ot_num_hours"></p>
                  <p class="text-bold mb-1">Reason:</p>
                  <p class="mb-4"id="ot_reason"></p>
                  <p class="text-bold mb-1">Status:</p>
                  <p class="mb-4"id="ot_status"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a type="submit" class='btn btn-primary text-light' id="btn_approve_ot">&nbsp; Approve</a>
        <a type="submit" class='btn btn-danger text-light BTN_REJECT_OVERTIME' id="btn_reject_ot" data-toggle="modal" data-target="#modal_overtime_rejection_reason">&nbsp; Reject</a>
      </div>
    </div>
  </div>
</div>

<!-- View Time Adjustment Details -->
<div class="modal fade" id="modal_adjustment_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title mt-0 ml-1">Time Adjustment Details
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body pb-5">
        <div class="row">
          <div class="col-md-4">
            <div class="w-100 text-center pt-4">
              <img id="adj_modal_employee_img" class="rounded-circle" alt="" style="width: 150px; height: 150px;">
            </div>
            <div class="pl-3 mt-3">
              <p class="text-bold mb-1">Name:</p>
              <p class="mb-4" id="adj_employee_name"></p>
              <p class="text-bold mb-1">Position:</p>
              <p class="mb-4" id="adj_employee_position"></p>
              <p class="text-bold mb-1">Department:</p>
              <p class="mb-4" id="adj_employee_department"></p>
            </div>
          </div>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Application Date:</p>
                  <p class="mb-4" id="adj_application_date"></p>
                  <p class="text-bold mb-1">Adjustment Date:</p>
                  <p class="mb-4" id="adj_adjustment_date"></p>
                  <p class="text-bold mb-1">Shift Type:</p>
                  <p class="mb-4"id="adj_shift_type"></p>
                  
                </div>
              </div>
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Time In:</p>
                  <p class="mb-4" id="adj_time_in"></p> 
                  <p class="text-bold mb-1">Time Out:</p>
                  <p class="mb-4" id="adj_time_out"></p> 
                  <p class="text-bold mb-1">Status:</p>
                  <p class="mb-4"id="adj_status"></p>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <p class="text-bold mb-1">Reason:</p>
                  <p class="mb-4"id="adj_reason"></p>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a type="submit" class='btn btn-primary text-light' id="btn_approve_adj">&nbsp; Approve</a>
        <a type="submit" class='btn btn-danger text-light BTN_REJECT_ADJUSTMENT' id="btn_reject_adj" data-toggle="modal" data-target="#modal_adjustment_rejection_reason">&nbsp; Reject</a>
      </div>
    </div>
  </div>
</div>



<!-- REASON FOR LEAVE REJECTION MODAL -->
<div class="modal fade" id="modal_leave_rejection_reason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Reject Leave Request
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('approval/reject_leave'); ?>" id="FORM_REJECT_LEAVE" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="INSRT_REASON_FOR_REJECTION">Please enter the reason for rejection
                </label>
                <textarea class="form-control" name="INSRT_REASON_FOR_REJECTION" id="INSRT_REASON_FOR_REJECTION" cols="30" rows="3" required></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="REJECT_LEAVE_ID" id="REJECT_LEAVE_ID">
          <input type="hidden" name="appr_num" id="Reject_appr_num">
          <button type="submit" class='btn btn-primary text-light' id="BTN_REJECT">&nbsp; Reject</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- REASON FOR REJECTION MODAL -->
<div class="modal fade" id="modal_overtime_rejection_reason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Reject Overtime Request
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('approval/reject_overtime'); ?>" id="FORM_REJECT_OVERTIME" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="INSRT_REASON_FOR_REJECTION_OVERTIME">Please enter the reason for rejection
                </label>
                <textarea class="form-control" name="INSRT_REASON_FOR_REJECTION" id="INSRT_REASON_FOR_REJECTION_OVERTIME" cols="30" rows="3" required></textarea>
              </div>
            </div>
            <input type="hidden" name="REJECT_OVERTIME_ID" id="REJECT_OVERTIME_ID">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class='btn btn-primary text-light' id="BTN_OVERTIME_REJECT">&nbsp; Reject
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- REASON FOR REJECTION MODAL -->
<div class="modal fade" id="modal_adjustment_rejection_reason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Reject Time Adjustment Request
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('approval/reject_time_adjustment'); ?>" id="FORM_REJECT_ADJUSTMENT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="INSRT_REASON_FOR_REJECTION_ADJUSTMENT">Please enter the reason for rejection
                </label>
                <textarea class="form-control" name="INSRT_REASON_FOR_REJECTION" id="INSRT_REASON_FOR_REJECTION_ADJUSTMENT" cols="30" rows="3" required></textarea>
              </div>
            </div>
            <input type="hidden" name="REJECT_ADJUSTMENT_ID" id="REJECT_ADJUSTMENT_ID">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class='btn btn-primary text-light' id="BTN_ADJUSTMENT_REJECT">&nbsp; Reject
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- /.control-sidebar -->
<!-- LOGOUT MODAL -->
<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?
        </p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <p>Hi are you sure you want to logout?
        </p>
      </div>
      <div class="modal-footer pb-1 pt-1">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
        </button>
        <a href="<?php echo base_url().'login/logout'; ?>" class="btn btn-info">Logout
        </a>
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js">
</script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js">
</script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js">
</script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js">
</script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js">
</script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
</script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/adminlte.js">
</script>
<!-- Full Calendar 2.2.5 -->
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js">
</script>
<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js">
</script>
<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js">
</script>
<!-- Toastr -->
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js">
</script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js">
</script>
<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/js/froala_editor.pkgd.min.js">
</script>
<!-- Pagination -->
<script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>
<!-- Datatables -->
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Initialize the editor. -->
<script>
  $(function() {
    $('div#froala-editor').froalaEditor({
      // Set custom buttons with separator between them.
      toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting','html'],
      toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic','html']
    }
                                       )
    $('i.fa.fa-rotate-left').attr('class')
  }
   );
</script>
<!-- SESSION MESSAGES -->
<?php
if($this->session->userdata('SESS_SUCC_MSG_INSRT_APPLY_LEAVE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_APPLY_LEAVE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_INSRT_APPLY_LEAVE');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_UPDT_APPLY_LEAVE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_APPLY_LEAVE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_UPDT_APPLY_LEAVE');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_CANCEL_LEAVE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_CANCEL_LEAVE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_CANCEL_LEAVE');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_REJECT_LEAVE');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_APPROVE_LEAVE');
}
?>
<?php
if($this->session->userdata('SESS_ERR_MSG_APPROVE_LEAVE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_ERR_MSG_APPROVE_LEAVE'); ?>',
    '',
    'error'
  )
</script>
<?php
$this->session->unset_userdata('SESS_ERR_MSG_APPROVE_LEAVE');
}
?>
<script>
  $(document).ready(function(){
    
    setTimeout(() => {
            // ===================== ACTIVATE DATATABLE PLUGIN =======================
            var empl_tbl = $('#rejected_tbl').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "autoWidth": false,
                "info": false,
                language: {
                    'paginate': {
                    'previous': '&lt;</span>',
                    'next': '&gt;</span>'
                    }
                }
            })
            $('#rejected_tbl_filter').parent().parent().hide();
        }, 1500);
    
    setTimeout(() => {
            // ===================== ACTIVATE DATATABLE PLUGIN =======================
            var empl_tbl = $('#approved_tbl').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "autoWidth": false,
                "info": false,
                language: {
                    'paginate': {
                    'previous': '&lt;</span>',
                    'next': '&gt;</span>'
                    }
                }
            })
            $('#approved_tbl_filter').parent().parent().hide();
        }, 1500);
        
    // var for_approval_tbl_length = $('#for_approval_tbl tbody tr').length;
    var approved_tbl_length = $('#approved_tbl tbody tr').length;
    var rejected_tbl_length = $('#rejected_tbl tbody tr').length;

    /* if(for_approval_tbl_length == 0){
      $('#for_approval_tbl tbody').append( "<tr><td colspan='7' class='p-4'>No leave application for approval yet</td></tr>" );
    } */
    if(approved_tbl_length == 0){
      $('#approved_tbl tbody').append( "<tr><td colspan='6' class='p-4'>No leave application approved under your supervision</td></tr>" );
    }
    if(rejected_tbl_length == 0){
      $('#rejected_tbl tbody').append( "<tr><td colspan='6' class='p-4'>No leave application rejected under your supervision</td></tr>" );
    }

    var base_url = '<?= base_url();?>';

    // AJAX LEAVE
    var url_get_leave_data = '<?php echo base_url(); ?>leave/get_leave_data';
    $('.for_approval_details').click(function(){

      var modal_leave_id = $(this).attr('leave_id');
      var modal_employee_id = $(this).attr('employee_id');

      get_leave_data(url_get_leave_data,modal_leave_id,modal_employee_id).then(data => {
        data.leave_data.forEach((leaveData) => {
          $('#leave_date_requested').text(leaveData.col_date_created);
          if(!leaveData.col_leave_to){
            $('#leave_on_date').text(leaveData.col_leave_from);
          } else {
            var leave_end = leaveData.col_leave_to.split(' ');
            $('#leave_on_date').text(leaveData.col_leave_from + ' to ' + leave_end[0]);
          }
          
          $('#leave_type').text(leaveData.col_leave_type);
          $('#leave_reason').text(leaveData.col_leave_comments);
          $('#leave_duration').text((parseFloat(leaveData.col_leave_duration)).toFixed(2) + " Day/s");
          $('#leave_status1').text(leaveData.col_leave_status1);
          $('#leave_status2').text(leaveData.col_leave_status2);
          $('#leave_status3').text(leaveData.col_leave_status3);
          if(leaveData.col_leave_image){
            $('#leave_attachment').attr('src',base_url + 'assets/files/leave/' + leaveData.col_leave_image);
          } else {
            $('#leave_attachment_link').hide();
            $('#empty_attachment').show();
          }
          $('#leave_attachment_link').attr('href',base_url + 'assets/files/leave/' + leaveData.col_leave_image);
        });
        data.employee_data.forEach((employeeData) => {
          $('#employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
          $('#employee_position').text(employeeData.col_empl_posi);
          $('#employee_department').text(employeeData.col_empl_dept);
          $('#modal_employee_img').attr('src',base_url + 'user_images/' + employeeData.col_imag_path);
        })
      })
    })


    $('.appr_details').click(function(){
      var modal_leave_id = $(this).attr('leave_id');
      var modal_employee_id = $(this).attr('employee_id');

      var modal_approve_key = $(this).attr('approve_key');
      var modal_leave_balanace = $(this).attr('leave_balance');
      var modal_leave_duration = $(this).attr('leave_duration');
      var modal_leave_type = $(this).attr('leave_type');
      var modal_appr_num = $(this).attr('appr_num');

      $('#hidden_leave_id').val(modal_leave_id);
      $('#hidden_employee_id').val(modal_employee_id);
      $('#hidden_approve_key').val(modal_approve_key);
      $('#hidden_leave_balance').val(modal_leave_balanace);
      $('#hidden_leave_duration').val(modal_leave_duration);
      $('#hidden_leave_type').val(modal_leave_type);
      $('#hidden_appr_num').val(modal_appr_num);

      $('#btn_reject_leave').attr('reject_key', modal_leave_id);
      $('#btn_reject_leave').attr('leave_id', modal_leave_id);
      $('#btn_reject_leave').attr('employee_id', modal_employee_id);
      $('#btn_reject_leave').attr('appr_num', modal_appr_num);

      get_leave_data(url_get_leave_data,modal_leave_id,modal_employee_id).then(data => {
        data.leave_data.forEach((leaveData) => {
          $('#leave_date_requested_appr').text(leaveData.col_date_created);
          if(!leaveData.col_leave_to){
            $('#leave_on_date_appr').text(leaveData.col_leave_from);
          } else {
            var leave_end = leaveData.col_leave_to.split(' ');
            $('#leave_on_date_appr').text(leaveData.col_leave_from + ' to ' + leave_end[0]);
          }
          
          $('#leave_type_appr').text(leaveData.col_leave_type);
          $('#leave_reason_appr').text(leaveData.col_leave_comments);
          $('#leave_duration_appr').text((parseFloat(leaveData.col_leave_duration)).toFixed(2) + " Day/s");
          $('#leave_status1_appr').text(leaveData.col_leave_status1);
          $('#leave_status2_appr').text(leaveData.col_leave_status2);
          $('#leave_status3_appr').text(leaveData.col_leave_status3);
          if(leaveData.col_leave_image){
            $('#empty_attachment_appr').hide();
            $('#leave_attachment_appr').attr('src',base_url + 'assets/files/leave/' + leaveData.col_leave_image);
          } else {
            $('#leave_attachment_link_appr').hide();
            $('#empty_attachment_appr').show();
          }
          $('#leave_attachment_link_appr').attr('href',base_url + 'assets/files/leave/' + leaveData.col_leave_image);
        });
        data.employee_data.forEach((employeeData) => {
          $('#employee_name_appr').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
          $('#employee_position_appr').text(employeeData.col_empl_posi);
          $('#employee_department_appr').text(employeeData.col_empl_dept);
          $('#modal_employee_img_appr').attr('src',base_url + 'user_images/' + employeeData.col_imag_path);
        })
      });
    })


    $('.BTN_REJECT_LEAVE').click(function(){
      var leave_id = $(this).attr('leave_id');
      var appr_num = $(this).attr('appr_num');
      
      $('#REJECT_LEAVE_ID').val(leave_id);
      $('#Reject_appr_num').val(appr_num);
    })



































    $('#check_all_appr_1').click(function(e){
        var label = $(this).text();
        console.log(label);

        var ischecked = false;
        if(label == 'Check All'){
            ischecked = true;
            $(this).text('Uncheck All');
        } else {
            ischecked = false;
            $(this).text('Check All');
        }
        
        Array.from($('.selected_application_appr_1')).forEach(function(checkbox){

            $(checkbox).prop('checked',ischecked);
        })
    })







    $('#check_all_appr_2').click(function(e){
        var label = $(this).text();
        console.log(label);

        var ischecked = false;
        if(label == 'Check All'){
            ischecked = true;
            $(this).text('Uncheck All');
        } else {
            ischecked = false;
            $(this).text('Check All');
        }
        
        Array.from($('.selected_application_appr_2')).forEach(function(checkbox){

            $(checkbox).prop('checked',ischecked);
        })
    })






    $('#check_all_appr_3').click(function(e){
        var label = $(this).text();
        console.log(label);

        var ischecked = false;
        if(label == 'Check All'){
            ischecked = true;
            $(this).text('Uncheck All');
        } else {
            ischecked = false;
            $(this).text('Check All');
        }
        
        Array.from($('.selected_application_appr_3')).forEach(function(checkbox){

            $(checkbox).prop('checked',ischecked);
        })
    })










    $('#approve_all').click(function(){
      $('#form_approve_all').html('');

      if($('.selected_application:checked').length > 0){
        Array.from($('.selected_application:checked')).forEach(function(e){
          var appr_num = $(e).attr('appr_num');
          var employee_id = $(e).attr('empl_id')
          var leave_id = $(e).attr('leave_id');
          var leave_balance = $(e).attr('leave_balance');
          var leave_duration = $(e).attr('leave_duration');
          var leave_type = $(e).attr('leave_type');

          var appr_details_compressed = appr_num + '/' + employee_id + '/' + leave_id + '/' + leave_balance + '/' + leave_duration + '/' + leave_type;

          $('#form_approve_all').append(`
            <input name="appl_details_compressed[]" value="`+appr_details_compressed+`">
          `)
        })
      }

      Swal.fire({
        title: 'Approve these leave applications?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#form_approve_all').submit();
        }
      })
    })













    





    $('#reject_all').click(function(e){
      $('#form_reject_all').html('');

      if($('.selected_application:checked').length > 0){
        Array.from($('.selected_application:checked')).forEach(function(e){
          var appr_num = $(e).attr('appr_num');
          var leave_id = $(e).attr('leave_id');

          var appr_details_compressed = appr_num + '/' + leave_id;

          $('#form_reject_all').append(`
            <input name="appl_details_compressed[]" value="`+appr_details_compressed+`">
          `)
        })
      }

      Swal.fire({
        title: 'Reject these leave applicationss?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#form_reject_all').submit();
        }
      })

    })

























































































    var url = '<?php echo base_url(); ?>leave/get_leave_data';
    const openModalButton = document.querySelectorAll('.view_leave_details');

    openModalButton.forEach(button => {
      button.addEventListener('click', (e) => {
        const modal = document.querySelector(button.dataset.target);

        var modal_leave_id = button.getAttribute('leave_id');
        var modal_employee_id = button.getAttribute('employee_id');

        var modal_approve_key = button.getAttribute('approve_key');
        var modal_leave_balanace = button.getAttribute('leave_balance');
        var modal_leave_duration = button.getAttribute('leave_duration');
        var modal_leave_type = button.getAttribute('leave_type');

        $('#hidden_leave_id').val(modal_leave_id);
        $('#hidden_employee_id').val(modal_employee_id);
        $('#hidden_approve_key').val(modal_approve_key);
        $('#hidden_leave_balance').val(modal_leave_balanace);
        $('#hidden_leave_duration').val(modal_leave_duration);
        $('#hidden_leave_type').val(modal_leave_type);

        $('#btn_reject_leave').attr('reject_key', modal_leave_id);
        $('#btn_reject_leave').attr('leave_id', modal_leave_id);
        $('#btn_reject_leave').attr('employee_id', modal_employee_id);

        if(($(button).hasClass('approved')) || ($(button).hasClass('rejected'))){
          $('#btn_approve_leave').hide();
          $('#btn_reject_leave').hide();
        } else {
          $('#btn_approve_leave').show();
          $('#btn_reject_leave').show();
        }
        

        get_leave_data(url,modal_leave_id,modal_employee_id).then(data => {
          data.leave_data.forEach((leaveData) => {
            $('#leave_date_requested').text(leaveData.col_date_created);
            if(!leaveData.col_leave_to){
              $('#leave_on_date').text(leaveData.col_leave_from);
            } else {
              var leave_end = leaveData.col_leave_to.split(' ');
              $('#leave_on_date').text(leaveData.col_leave_from + ' to ' + leave_end[0]);
            }
            
            $('#leave_type').text(leaveData.col_leave_type);
            $('#leave_reason').text(leaveData.col_leave_comments);
            $('#leave_duration').text((parseFloat(leaveData.col_leave_duration)).toFixed(2) + " Day/s");
            $('#leave_status').text(leaveData.col_leave_status1);
            if(leaveData.col_leave_image){
              $('#leave_attachment').attr('src',base_url + 'assets/files/leave/' + leaveData.col_leave_image);
            } else {
              $('#leave_attachment_link').hide();
              $('#empty_attachment').show();
            }
            $('#leave_attachment_link').attr('href',base_url + 'assets/files/leave/' + leaveData.col_leave_image);
          });
          data.employee_data.forEach((employeeData) => {
            $('#employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
            $('#employee_position').text(employeeData.col_empl_posi);
            $('#employee_department').text(employeeData.col_empl_dept);
            $('#modal_employee_img').attr('src',base_url + 'user_images/' + employeeData.col_imag_path);
          })
        });
      });
    });

    // AJAX OVERTIME
    var url2 = '<?php echo base_url(); ?>approval/get_overtime_data';
    const openModalButton2 = document.querySelectorAll('.view_overtime_details');

    openModalButton2.forEach(button => {
      button.addEventListener('click', () => {

        const modal = document.querySelector(button.dataset.target);
        var modal_employee_id = button.getAttribute('employee_id');
        var modal_overtime_id = button.getAttribute('overtime_id');

        get_overtime_data(url2,modal_employee_id,modal_overtime_id).then(data => {
          data.overtime_data.forEach((overtimeData) => {
            var application_date = overtimeData.date_created;
            var overtime_date = overtimeData.date_ot;
            var time_out = overtimeData.time_out;
            var hours = overtimeData.hours;
            var reason = overtimeData.reason;
            var status = overtimeData.status;
          
            $('#ot_application_date').text(application_date);
            $('#ot_overtime_date').text(overtime_date);
            $('#ot_time_out').text(time_out);
            $('#ot_num_hours').text(hours+' hrs');
            $('#ot_reason').text(reason);
            $('#ot_status').text(status);
          });
          data.employee_data.forEach((employeeData) => {
            $('#ot_employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
            $('#ot_employee_position').text(employeeData.col_empl_posi);
            $('#ot_employee_department').text(employeeData.col_empl_dept);
            $('#ot_modal_employee_img').attr('src',base_url + 'user_images/' + employeeData.col_imag_path);
          })
        });
      });
    });

    // AJAX TIME ADJUSTMENT
    var url3 = '<?php echo base_url(); ?>approval/get_time_adjustment_data';
    const openModalButton3 = document.querySelectorAll('.view_adjustment_details');

    openModalButton3.forEach(button => {
      button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        var modal_employee_id = button.getAttribute('employee_id');
        var modal_adjustment_id = button.getAttribute('adjustment_id');

        get_time_adjustment_data(url3,modal_employee_id,modal_adjustment_id).then(data => {
          data.adjustment_data.forEach((adjustment) => {
            var application_date = adjustment.date_created;
            var overtime_date = adjustment.date_adjustment;
            var shift_type = adjustment.shift_type;
            var time_in = adjustment.time_in;
            var time_out = adjustment.time_out;
            var reason = adjustment.reason;
            var status = adjustment.status;
          
            $('#adj_application_date').text(application_date);
            $('#adj_adjustment_date').text(overtime_date);
            $('#adj_shift_type').text(shift_type);
            $('#adj_time_in').text(time_in);
            $('#adj_time_out').text(time_out);
            $('#adj_status').text(reason);
            $('#adj_reason').text(status);
          });
          data.employee_data.forEach((employeeData) => {
            $('#adj_employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
            $('#adj_employee_position').text(employeeData.col_empl_posi);
            $('#adj_employee_department').text(employeeData.col_empl_dept);
            $('#adj_modal_employee_img').attr('src',base_url + 'user_images/' + employeeData.col_imag_path);
          })
        });
      });
    });


    // Display Leave ID in Reject Modal
    const openModalButton5 = document.querySelectorAll('.BTN_REJECT_OVERTIME');
    openModalButton5.forEach(button => {
      button.addEventListener('click', () => {
        $('#modal_overtime_details').modal('toggle');
        $('#REJECT_OVERTIME_ID').val(button.getAttribute('overtime_id'));
      });
    });

    // Display Leave ID in Reject Modal
    const openModalButton6 = document.querySelectorAll('.BTN_REJECT_ADJUSTMENT');
    openModalButton6.forEach(button => {
      button.addEventListener('click', () => {
        $('#modal_adjustment_details').modal('toggle');
        $('#REJECT_ADJUSTMENT_ID').val(button.getAttribute('adjustment_id'));
      });
    });

    // Approve Leave
    $('#btn_approve_leave').click(function(e){
      e.preventDefault();
      var approveKey = $('#hidden_approve_key').val();
      var leave_balance = $('#hidden_leave_balance').val();
      var leave_duration = $('#hidden_leave_duration').val();
      var leave_type = $('#hidden_leave_type').val();
      var employee_id = $('#hidden_employee_id').val();
      
      var appr_num = $('#hidden_appr_num').val();
      Swal.fire({
        title: 'Approve this leave application?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url(); ?>approval/approve_leave?approve_id="+approveKey+'&leave_balance='+leave_balance+'&leave_duration='+leave_duration+'&leave_type='+leave_type+'&employee_id='+employee_id+`&appr_num=`+appr_num;
        }
      })
    })






    $('.btn_fast_approve').click(function(e){
      e.stopPropagation();
      console.log('approve clicked!');

      var appr_num = $(this).attr('hidden_appr_num');
      var approveKey = $(this).attr('hidden_approve_key');
      var leave_balance = $(this).attr('hidden_leave_balance');
      var leave_duration = $(this).attr('hidden_leave_duration');
      var leave_type = $(this).attr('hidden_leave_type');
      var employee_id = $(this).attr('hidden_employee_id');

      Swal.fire({
        title: 'Approve this leave application?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url(); ?>approval/approve_leave?approve_id="+approveKey+'&leave_balance='+leave_balance+'&leave_duration='+leave_duration+'&leave_type='+leave_type+'&employee_id='+employee_id+`&appr_num=`+appr_num;
        }
      })

    })

    $('.btn_fast_reject').click(function(e){
      e.stopPropagation();
      console.log('reject clicked!');

      var leave_id = $(this).attr('leave_id');
      var appr_num = $(this).attr('appr_num');
      
      $('#REJECT_LEAVE_ID').val(leave_id);
      $('#Reject_appr_num').val(appr_num);

      $('#modal_leave_rejection_reason').modal('toggle'); 
    })














    async function get_leave_data(url,leave_id,employee_id) {
      var formData = new FormData();
      formData.append('leave_id', leave_id);
      formData.append('employee_id', employee_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_overtime_data(url,employee_id,overtime_id) {
      var formData = new FormData();
      formData.append('employee_id', employee_id);
      formData.append('overtime_id', overtime_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_time_adjustment_data(url,employee_id,adjustment_id) {
      var formData = new FormData();
      formData.append('employee_id', employee_id);
      formData.append('adjustment_id', adjustment_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }
  })
</script>
</body>
</html>
