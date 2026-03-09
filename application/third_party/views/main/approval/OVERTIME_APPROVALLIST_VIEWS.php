<style>
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
    font-size: 11px;
  }
  .approval_card a{
    font-size: 12px;
    color: #1993D7;
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
<div class="content-wrapper">
    <div class="container-fluid p-4">
      <div class="row">
        <div class="col-md-6">
          <h1 class="page-title">Overtime Applications</h1>
        </div>
        <div class="col-md-6" style = "text-align: right;">
          <a href="<?= base_url() ?>approval/approval_list_time_adjustment" class="btn btn-primary shadow-none" style="text-decoration: none;"><i class="fas fa-wrench"></i>&nbsp; &nbsp; Time Adjustment</a>
          <a href="#" class="btn btn-primary shadow-none"  style="text-decoration: none;"><i class="fas fa-history"></i>&nbsp; &nbsp; Overtime</a>
          <a href="<?= base_url() ?>approval/approval_list" class="btn btn-primary shadow-none" style="text-decoration: none;"><i class="fas fa-door-open"></i>&nbsp; &nbsp; Leave</a>
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
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <div class="card-title w-100 mb-0" style="font-size: 13.5px;">For Approval</div>
                </div>

                <?php 
                  if($DISP_OVERTIME_FOR_APPROVAL){
                    foreach($DISP_OVERTIME_FOR_APPROVAL as $DISP_OVERTIME_FOR_APPROVAL_ROW){
                      $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_OVERTIME_FOR_APPROVAL_ROW->empl_id);

                      // get approval route
                      $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();

                      $empl_cmid = '';
                      $empl_image = '';
                      $empl_fullname = '';
                      $empl_position = '';
                      if(count($employee) > 0){
                        $empl_cmid = $employee[0]->col_empl_cmid;
                        $empl_image = $employee[0]->col_imag_path;
                        if(!empty($employee[0]->col_midl_name)){
                            $midl_ini = $employee[0]->col_midl_name[0].'.';
                        }else{
                            $midl_ini = '';
                        }
                        $empl_fullname = $employee[0]->col_last_name . ', ' . $employee[0]->col_frst_name.' '.$midl_ini;
                        $empl_position = $employee[0]->col_empl_posi;
                      }

                      // loop through the approval routes
                      foreach($approval_route as $approval_route_row){
                        // check if you are a approver then show the list of requests you can only approve
                        $my_user_id = $this->session->userdata('SESS_USER_ID');
                        if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id)){

                            if((($DISP_OVERTIME_FOR_APPROVAL_ROW->status1 != 'Rejected') && ($DISP_OVERTIME_FOR_APPROVAL_ROW->status2 != 'Rejected')) && (($DISP_OVERTIME_FOR_APPROVAL_ROW->status1 == 'Pending') || ($DISP_OVERTIME_FOR_APPROVAL_ROW->status2 == 'Pending'))){
                              ?>
                                  <div class="card-body approval_card for_approval_details" data-toggle="modal" data-target="#modal_for_approval_overtime_details" employee_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->empl_id ?>" overtime_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->id ?>">
                                    
                                    <div class="d-flex">
                                        <img src="<?= base_url() ?>user_images/<?php echo $empl_image ? $empl_image : 'default_profile_img3.png'; ?>"  class="rounded-circle avatar mt-2">
                                        <div class="ml-2 mt-2">
                                            <a href="#" ><?= $empl_cmid.' - '.$empl_fullname ?></a>
                                            <p class="mb-1 text-secondary" ><?= $empl_position; ?></p>
                                            <p class="mb-0">OT Date:  <?= $DISP_OVERTIME_FOR_APPROVAL_ROW->date_ot ?></p>
                                        </div>
                                        <div class="flex-fill">
                                            <div class="w-100 mt-2">    
                                                <div class="float-right text-center" style="height: 100%; width: 100px;">
                                                    <p class="mb-0">No. of Hours:</p>
                                                    <label style="color: #687CED;font-size: 11px;"><?= $DISP_OVERTIME_FOR_APPROVAL_ROW->hours ?> hrs</label>
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
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <div class="card-title w-100 mb-0" style="font-size: 13.5px;"> 
                  <a href='#' id="check_all_appr_1" class="float-right" style="font-weight: 500; text-decoration: none; margin-bottom: -20px;">Check All</a>
                    Approver 1
                  </div>
                </div>

                <?php 
                  if($DISP_OVERTIME_FOR_APPROVAL){
                    foreach($DISP_OVERTIME_FOR_APPROVAL as $DISP_OVERTIME_FOR_APPROVAL_ROW){
                      $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_OVERTIME_FOR_APPROVAL_ROW->empl_id);

                        // get approval route
                      $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();

                      $empl_id = '';
                      $empl_cmid = '';
                      $empl_image = '';
                      $empl_fullname = '';
                      $empl_position = '';
                      if(count($employee) > 0){
                        $empl_id = $employee[0]->id;
                        $empl_cmid = $employee[0]->col_empl_cmid;
                        $empl_image = $employee[0]->col_imag_path;
                        if(!empty($employee[0]->col_midl_name)){
                            $midl_ini = $employee[0]->col_midl_name[0].'.';
                        }else{
                            $midl_ini = '';
                        }
                        $empl_fullname = $employee[0]->col_last_name . ', ' . $employee[0]->col_frst_name.' '.$midl_ini;
                        $empl_position = $employee[0]->col_empl_posi;
                      }

                      // loop through the approval routes
                      foreach($approval_route as $approval_route_row){
                        // check if you are a approver then show the list of requests you can only approve
                        $my_user_id = $this->session->userdata('SESS_USER_ID');
                        if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id)){

                            if(($DISP_OVERTIME_FOR_APPROVAL_ROW->status1 == 'Pending')){
                                ?>
                                    <div class="card-body approval_card appr_details" data-toggle="modal" data-target="#modal_appr_overtime_details" appr_num="appr_1" employee_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->empl_id ?>" overtime_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->id ?>">
                                        <div class="d-flex">
                                          <img src="<?= base_url() ?>user_images/<?php echo $empl_image ? $empl_image : 'default_profile_img3.png'; ?>"  class="rounded-circle avatar mt-2">
                                          <div class="ml-2 mt-2">
                                              <a href="#" ><?= $empl_cmid.' - '.$empl_fullname ?></a>
                                              <p class="mb-1 text-secondary" ><?= $empl_position; ?></p>
                                              <p class="mb-0">OT Date:  <?= $DISP_OVERTIME_FOR_APPROVAL_ROW->date_ot ?></p>
                                          </div>
                                          <div class="flex-fill">
                                              <div class="w-100 mt-2">    
                                                  <div class="float-right text-center" style="height: 100%; width: 100px;">
                                                      <p class="mb-0">No. of Hours:</p>
                                                      <label class="checkbox" style="color: #687CED;font-size: 11px;"><?= $DISP_OVERTIME_FOR_APPROVAL_ROW->hours ?> hrs</label>
                                                  </div>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="d-flex flex-row-reverse mt-3">
                                            <a href="#" class="text-white btn_fast_reject btn btn-danger" style="font-size: 12px !important;" overtime_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->id ?>" appr_num="appr_1" ><i class="fas fa-times"></i> &nbsp; Reject</a>
                                            <a href="#" class="text-white btn_fast_approve btn btn-primary mr-1" style="font-size: 12px !important;" appr_num="appr_1" overtime_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->id ?>" employee_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->empl_id ?>"><i class="fas fa-check"></i> &nbsp; Approve</a>
                                        </div>
                                    </div>
                                    <div class="form-group ml-2 mb-0 mr-auto" style="margin-top: -40px; margin-left: 20px;">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" class="selected_application selected_application_appr_1" id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->id ?>" empl_id="<?= $empl_id ?>"  appr_num="appr_1" overtime_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->id ?>" employee_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->empl_id ?>">
                                            <label for="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->id ?>"></label>
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
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <div class="card-title w-100 mb-0" style="font-size: 13.5px;"> 
                    <a href='#' id="check_all_appr_2" class="float-right" style="font-weight: 500; text-decoration: none; margin-bottom: -20px;">Check All</a>
                    Approver 2
                  </div>
                </div>

                <?php 
                  if($DISP_OVERTIME_FOR_APPROVAL){
                    foreach($DISP_OVERTIME_FOR_APPROVAL as $DISP_OVERTIME_FOR_APPROVAL_ROW){
                      $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_OVERTIME_FOR_APPROVAL_ROW->empl_id);

                        // get approval route
                      $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();

                      $empl_cmid = '';
                      $empl_image = '';
                      $empl_fullname = '';
                      $empl_position = '';
                      if(count($employee) > 0){
                        $empl_cmid = $employee[0]->col_empl_cmid;
                        $empl_image = $employee[0]->col_imag_path;
                        if(!empty($employee[0]->col_midl_name)){
                            $midl_ini = $employee[0]->col_midl_name[0].'.';
                        }else{
                            $midl_ini = '';
                        }
                        $empl_fullname = $employee[0]->col_last_name . ', ' . $employee[0]->col_frst_name.' '.$midl_ini;
                        $empl_position = $employee[0]->col_empl_posi;
                      }

                      // loop through the approval routes
                      foreach($approval_route as $approval_route_row){
                        // check if you are a approver then show the list of requests you can only approve
                        $my_user_id = $this->session->userdata('SESS_USER_ID');
                        if(($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id)){

                            if(($DISP_OVERTIME_FOR_APPROVAL_ROW->status1 == 'Approved') && ($DISP_OVERTIME_FOR_APPROVAL_ROW->status2 == 'Pending')){
                                ?>
                                    <div class="card-body approval_card appr_details"  data-toggle="modal" data-target="#modal_appr_overtime_details" appr_num="appr_2" employee_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->empl_id ?>" overtime_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->id ?>">
                                        <div class="d-flex">
                                          <img src="<?= base_url() ?>user_images/<?php echo $empl_image ? $empl_image : 'default_profile_img3.png'; ?>"  class="rounded-circle avatar mt-2">
                                          <div class="ml-2 mt-2">
                                              <a href="#" ><?= $empl_cmid . ' - ' . $empl_fullname ?></a>
                                              <p class="mb-1 text-secondary" ><?= $empl_position; ?></p>
                                              <p class="mb-0">OT Date:  <?= $DISP_OVERTIME_FOR_APPROVAL_ROW->date_ot ?></p>
                                          </div>
                                          <div class="flex-fill">
                                              <div class="w-100 mt-2">    
                                                  <div class="float-right text-center" style="height: 100%; width: 100px;">
                                                      <p class="mb-0">No. of Hours:</p>
                                                      <label style="color: #687CED;font-size: 11px;"><?= $DISP_OVERTIME_FOR_APPROVAL_ROW->hours ?> hrs</label>
                                                  </div>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="d-flex flex-row-reverse mt-3">
                                            <a href="#" class="text-white btn_fast_reject btn btn-danger" style="font-size: 12px !important;" overtime_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->id ?>" appr_num="appr_2" ><i class="fas fa-times"></i> &nbsp; Reject</a>
                                            <a href="#" class="text-white btn_fast_approve btn btn-primary mr-1" style="font-size: 12px !important;" appr_num="appr_2" overtime_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->id ?>" employee_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->empl_id ?>"><i class="fas fa-check"></i> &nbsp; Approve</a>
                                        </div>
                                    </div>
                                    <div class="form-group ml-2 mb-0 mr-auto" style="margin-top: -40px; margin-left: 20px;">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" class="selected_application selected_application_appr_2" id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->id ?>" appr_num="appr_2" overtime_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->id ?>" employee_id="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->empl_id ?>">
                                            <label for="<?= $DISP_OVERTIME_FOR_APPROVAL_ROW->id ?>"></label>
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


          </div>
        </div>

        <div class="card p-4 tab-pane" id="approved" style="border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
          <table class="table table-hover table-xs mb-0" id="approved_tbl">
              <thead>
                  <th>Application ID</th>
                  <th>Application Date</th>
                  <th>Assigned By</th>
                  <th>Employee</th>
                  <th>Overtime Date</th>
                  <th>No. of Hours</th>
                  <th>Reason</th>
                  <th>Status</th>
              </thead>
              <tbody style="font-weight: 500 !important;">
                  <?php 
                      if($DISP_APPROVED_OT){
                        foreach($DISP_APPROVED_OT as $DISP_APPROVED_OT_ROW){
                            $application_id = 'OT'.str_pad($DISP_APPROVED_OT_ROW->id, 5, '0', STR_PAD_LEFT);
                            $db_time_out = explode(':',$DISP_APPROVED_OT_ROW->time_out);
                            $time_out = $db_time_out[0].':'.$db_time_out[1];

                            $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVED_OT_ROW->empl_id);
                            $assigned_by = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVED_OT_ROW->assigned_by);
                            if(!empty($assigned_by[0]->col_midl_name)){
                                $midl_ini = $assigned_by[0]->col_midl_name[0].'.';
                            }else{
                                $midl_ini = '';
                            }
                            if(!empty($employee[0]->col_midl_name)){
                                $midl_ini2 = $employee[0]->col_midl_name[0].'.';
                            }else{
                                $midl_ini2 = '';
                            }
                          ?>
                          <tr>
                            <td><?= $application_id ?></td>
                            <td><?= $DISP_APPROVED_OT_ROW->date_created ?></td>
                            <td>
                                <a href = "<?=base_url()?>employees/personal?id=<?= $assigned_by[0]->id ?>">
                                    <img class="rounded-circle avatar " width="35" height="35" src="<?php if($assigned_by[0]->col_imag_path){echo base_url().'user_images/'.$assigned_by[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $assigned_by[0]->col_last_name.', '.$assigned_by[0]->col_frst_name.' '.$midl_ini?>
                                </a>
                            </td>
                            <td>
                                <a href = "<?=base_url()?>employees/personal?id=<?= $employee[0]->id ?>">
                                    <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $employee[0]->col_last_name.' '.$employee[0]->col_frst_name.' '.$midl_ini2?>
                                </a>
                            </td>
                            <td><?= $DISP_APPROVED_OT_ROW->date_ot ?></td>
                            <td><?= $DISP_APPROVED_OT_ROW->hours ?></td>
                            <td><?= $DISP_APPROVED_OT_ROW->reason ?></td>
                            <td><?= $DISP_APPROVED_OT_ROW->status1 ?></td>
                          </tr>
                            
                          <?php
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
                  <th>Overtime Date</th>
                  <th>No. of Hours</th>
                  <th>Reason</th>
                  <th>Status</th>
              </thead>
              <tbody style="font-weight: 500 !important;">
                  <?php 
                      if($DISP_REJECTED_OT){
                        foreach($DISP_REJECTED_OT as $DISP_REJECTED_OT_ROW){
                            $application_id = 'OT'.str_pad($DISP_REJECTED_OT_ROW->id, 5, '0', STR_PAD_LEFT);
                            $db_time_out = explode(':',$DISP_REJECTED_OT_ROW->time_out);
                            $time_out = $db_time_out[0].':'.$db_time_out[1];

                            $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_REJECTED_OT_ROW->empl_id);
                            $assigned_by = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_REJECTED_OT_ROW->assigned_by);
                            if(!empty($assigned_by[0]->col_midl_name)){
                                $midl_ini = $assigned_by[0]->col_midl_name[0].'.';
                            }else{
                                $midl_ini = '';
                            }
                            if(!empty($employee[0]->col_midl_name)){
                                $midl_ini2 = $employee[0]->col_midl_name[0].'.';
                            }else{
                                $midl_ini2 = '';
                            }
                          ?>
                          <tr>
                            <td><?= $application_id ?></td>
                            <td><?= $DISP_REJECTED_OT_ROW->date_created ?></td>
                            <td>
                                <a href = "<?=base_url()?>employees/personal?id=<?= $assigned_by[0]->id ?>">
                                    <img class="rounded-circle avatar " width="35" height="35" src="<?php if($assigned_by[0]->col_imag_path){echo base_url().'user_images/'.$assigned_by[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $assigned_by[0]->col_last_name.', '.$assigned_by[0]->col_frst_name.' '.$midl_ini?>
                                </a>
                            </td>
                            <td>
                                <a href = "<?=base_url()?>employees/personal?id=<?= $employee[0]->id ?>">
                                    <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $employee[0]->col_last_name.', '.$employee[0]->col_frst_name.' '.$midl_ini2?>
                                </a>
                            </td>
                            <td><?= $DISP_REJECTED_OT_ROW->date_ot ?></td>
                            <td><?= $DISP_REJECTED_OT_ROW->hours ?></td>
                            <td><?= $DISP_REJECTED_OT_ROW->reason ?></td>
                            <td>Rejected</td>
                          </tr>
                            
                          <?php
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
      </div>
    </div>
    <!-- flex-fill -->
  </div>
  <!-- p-3 -->
</div>






<!-- Selected Approved Applications Details Hidden Container -->
<form action="<?php echo base_url('approval/approve_all_overtime'); ?>" id="form_approve_all" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
    
</form>


<!-- Selected Rejected Applications Details Hidden Container -->
<form action="<?php echo base_url('approval/reject_all_overtime'); ?>" id="form_reject_all" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
    
</form>









<!-- content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>


<!-- View For Approval Overtime Details -->
<div class="modal fade" id="modal_for_approval_overtime_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <p class="text-bold mb-1">Type:</p>
                  <p class="mb-4"id="ot_type"></p>
                  <p class="text-bold mb-1">No. of Hours:</p>
                  <p class="mb-4"id="ot_num_hours"></p>
                  <p class="text-bold mb-1">Reason:</p>
                  <p class="mb-4"id="ot_reason"></p>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <p class="text-bold mb-1">Status1:</p>
                    <p class="mb-4"id="ot_status1"></p>
                </div>
                <div class="col-md-4">
                    <p class="text-bold mb-1">Status2:</p>
                    <p class="mb-4"id="ot_status2"></p>
                </div>
                <!-- <div class="col-md-4">
                    <p class="text-bold mb-1">Status3:</p>
                    <p class="mb-4"id="ot_status3"></p>
                </div> -->
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <a type="submit" class='btn btn-primary text-light' id="btn_approve_ot">&nbsp; Approve</a>
        <a type="submit" class='btn btn-danger text-light BTN_REJECT_OVERTIME' id="btn_reject_ot" data-toggle="modal" data-target="#modal_overtime_rejection_reason">&nbsp; Reject</a>
      </div> -->
    </div>
  </div>
</div>

<!-- View For Approval Overtime Details -->
<div class="modal fade" id="modal_appr_overtime_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <img id="appr_ot_modal_employee_img" class="rounded-circle" alt="" style="width: 150px; height: 150px;">
            </div>
            <div class="pl-3 mt-3">
              <p class="text-bold mb-1">Name:</p>
              <p class="mb-4" id="appr_ot_employee_name"></p>
              <p class="text-bold mb-1">Position:</p>
              <p class="mb-4" id="appr_ot_employee_position"></p>
              <p class="text-bold mb-1">Department:</p>
              <p class="mb-4" id="appr_ot_employee_department"></p>
            </div>
          </div>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Application Date:</p>
                  <p class="mb-4" id="appr_ot_application_date"></p>
                  <p class="text-bold mb-1">Overtime Date:</p>
                  <p class="mb-4" id="appr_ot_overtime_date"></p>
                  <p class="text-bold mb-1">Time Out:</p>
                  <p class="mb-4" id="appr_ot_time_out"></p> 
                </div>
              </div>
              <div class="col-md-6">
                <div class="mt-3">
                  <p class="text-bold mb-1">Type:</p>
                  <p class="mb-4"id="appr_ot_type"></p>
                  <p class="text-bold mb-1">No. of Hours:</p>
                  <p class="mb-4"id="appr_ot_num_hours"></p>
                  <p class="text-bold mb-1">Reason:</p>
                  <p class="mb-4"id="appr_ot_reason"></p>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <p class="text-bold mb-1">Status1:</p>
                    <p class="mb-4"id="appr_ot_status1"></p>
                </div>
                <div class="col-md-4">
                    <p class="text-bold mb-1">Status2:</p>
                    <p class="mb-4"id="appr_ot_status2"></p>
                </div>
                <!-- <div class="col-md-4">
                    <p class="text-bold mb-1">Status3:</p>
                    <p class="mb-4"id="appr_ot_status3"></p>
                </div> -->
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="hidden_employee_id" id="hidden_employee_id">
          <input type="hidden" name="hidden_overtime_id" id="hidden_overtime_id">
          <input type="hidden" name="hidden_appr_num" id="hidden_appr_num">
        <a type="submit" class='btn btn-primary text-light' id="btn_approve_ot">&nbsp; Approve</a>
        <a type="submit" class='btn btn-danger text-light BTN_REJECT_OVERTIME' id="btn_reject_ot" data-toggle="modal" data-target="#modal_overtime_rejection_reason">&nbsp; Reject</a>
      </div>
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
                <textarea class="form-control" name="INSRT_REASON_FOR_REJECTION_OVERTIME" id="INSRT_REASON_FOR_REJECTION_OVERTIME" cols="30" rows="3" required></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="reject_overtime_id" id="reject_overtime_id">
          <input type="hidden" name="reject_appr_num" id="reject_appr_num">
          <button type="submit" class='btn btn-primary text-light' id="BTN_OVERTIME_REJECT">&nbsp; Reject
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








    // OVERTIME APPLICATION
    var url_get_overtime_data = '<?php echo base_url(); ?>approval/get_overtime_data';
    $('.for_approval_details').click(function(){
        var modal_employee_id = $(this).attr('employee_id');
        var modal_overtime_id = $(this).attr('overtime_id');
        

        get_overtime_data(url_get_overtime_data,modal_employee_id,modal_overtime_id).then(data => {
            data.overtime_data.forEach((overtimeData) => {
                var application_date = overtimeData.date_created;
                var overtime_date = overtimeData.date_ot;
                var time_out = overtimeData.time_out;
                var type = overtimeData.type;
                var hours = overtimeData.hours;
                var reason = overtimeData.reason;
                var status1 = overtimeData.status1;
                var status2 = overtimeData.status2;
                // var status3 = overtimeData.status3;
                

                $('#ot_application_date').text(application_date);
                $('#ot_overtime_date').text(overtime_date);
                $('#ot_time_out').text(time_out);
                $('#ot_type').text(type);
                $('#ot_num_hours').text(hours+' hrs');
                $('#ot_reason').text(reason);
                $('#ot_status1').text(status1);
                $('#ot_status2').text(status2);
                // $('#ot_status3').text(status3);
                
            })
            data.employee_data.forEach((employeeData) => {
                $('#ot_employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
                $('#ot_employee_position').text(employeeData.col_empl_posi);
                $('#ot_employee_department').text(employeeData.col_empl_dept);

                if(employeeData.col_imag_path){
                  $('#ot_modal_employee_img').attr('src',base_url + 'user_images/' + employeeData.col_imag_path);
                } else {
                  $('#ot_modal_employee_img').attr('src',base_url + 'user_images/' + 'default_profile_img3.png');
                }
                
            })
        })
    })

    $('.appr_details').click(function(e){
      
      // if($(e.target).attr('class') != ''){
      //   $('#modal_appr_overtime_details').modal('toggle');
      //   console.log(e.currentTarget);
      // } else {
      //   console.log($(e.target).attr('class'));
      // }

        var modal_employee_id = $(this).attr('employee_id');
        var modal_overtime_id = $(this).attr('overtime_id');
        var modal_appr_num = $(this).attr('appr_num');

        $('#hidden_employee_id').val(modal_employee_id);
        $('#hidden_overtime_id').val(modal_overtime_id);
        $('#hidden_appr_num').val(modal_appr_num);

        $('#btn_reject_ot').attr('overtime_id', modal_overtime_id);
        $('#btn_reject_ot').attr('appr_num', modal_appr_num);

        get_overtime_data(url_get_overtime_data,modal_employee_id,modal_overtime_id).then(data => {
            data.overtime_data.forEach((overtimeData) => {
                var application_date = overtimeData.date_created;
                var overtime_date = overtimeData.date_ot;
                var time_out = overtimeData.time_out;
                var type = overtimeData.type;
                var hours = overtimeData.hours;
                var reason = overtimeData.reason;
                var status1 = overtimeData.status1;
                var status2 = overtimeData.status2;
                // var status3 = overtimeData.status3;

                $('#appr_ot_application_date').text(application_date);
                $('#appr_ot_overtime_date').text(overtime_date);
                $('#appr_ot_time_out').text(time_out);
                $('#appr_ot_type').text(type);
                $('#appr_ot_num_hours').text(hours+' hrs');
                $('#appr_ot_reason').text(reason);
                $('#appr_ot_status1').text(status1);
                $('#appr_ot_status2').text(status2);
                // $('#appr_ot_status3').text(status3);
            })
            data.employee_data.forEach((employeeData) => {
                $('#appr_ot_employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
                $('#appr_ot_employee_position').text(employeeData.col_empl_posi);
                $('#appr_ot_employee_department').text(employeeData.col_empl_dept);

                if(employeeData.col_imag_path){
                  $('#appr_ot_modal_employee_img').attr('src',base_url + 'user_images/' + employeeData.col_imag_path);
                } else {
                  $('#appr_ot_modal_employee_img').attr('src',base_url + 'user_images/' + 'default_profile_img3.png');
                }
                
            })
        })
    })

    // Approve OT
    $('#btn_approve_ot').click(function(e){
      e.preventDefault();
      var modal_employee_id = $('#hidden_employee_id').val();
      var modal_overtime_id = $('#hidden_overtime_id').val();
      
      var appr_num = $('#hidden_appr_num').val();
      Swal.fire({
        title: 'Approve this overtime application?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url(); ?>approval/approve_overtime?employee_id="+modal_employee_id+'&overtime_id='+modal_overtime_id+'&appr_num='+appr_num;
        }
      })
    })
    
    // Reject OT
    $('.BTN_REJECT_OVERTIME').click(function(){
      var overtime_id = $(this).attr('overtime_id');
      var appr_num = $(this).attr('appr_num');
      
      $('#reject_overtime_id').val(overtime_id);
      $('#reject_appr_num').val(appr_num);

    })









    $('.btn_fast_reject').click(function(e){
      e.stopPropagation();
      var overtime_id = $(this).attr('overtime_id');
      var appr_num = $(this).attr('appr_num');
      
      $('#reject_overtime_id').val(overtime_id);
      $('#reject_appr_num').val(appr_num);

      $('#modal_overtime_rejection_reason').modal('toggle'); 
    })

    $('.btn_fast_approve').click(function(e){
      e.stopPropagation();
      var employee_id = $(this).attr('employee_id');
      var overtime_id = $(this).attr('overtime_id');
      var appr_num = $(this).attr('appr_num');

      Swal.fire({
        title: 'Approve this overtime application?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url(); ?>approval/approve_overtime?employee_id="+employee_id+'&overtime_id='+overtime_id+'&appr_num='+appr_num;
        }
      })

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











    $('.selected_application').click(function(e){

      e.stopPropagation();

      var appr_num = $(this).attr('appr_num');
      var employee_id = $(this).attr('employee_id')
      var overtime_id = $(this).attr('overtime_id');

      console.log('appr_num: ' + appr_num);
      console.log('employee_id: ' + employee_id);
      console.log('overtime_id: ' + overtime_id);

    })







    $('#approve_all').click(function(){
      $('#form_approve_all').html('');

      if($('.selected_application:checked').length > 0){
        Array.from($('.selected_application:checked')).forEach(function(e){
          var appr_num = $(e).attr('appr_num');
          var employee_id = $(e).attr('employee_id')
          var overtime_id = $(e).attr('overtime_id');

          var appr_details_compressed = appr_num + '/' + employee_id + '/' + overtime_id;

          $('#form_approve_all').append(`
            <input name="appl_details_compressed[]" value="`+appr_details_compressed+`">
          `)
        })
      }

      Swal.fire({
        title: 'Approve this overtime application?',
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






    $('#approve_all').click(function(){
      $('#form_approve_all').html('');

      if($('.selected_application:checked').length > 0){
        Array.from($('.selected_application:checked')).forEach(function(e){
          var appr_num = $(e).attr('appr_num');
          var employee_id = $(e).attr('employee_id')
          var overtime_id = $(e).attr('overtime_id');

          var appr_details_compressed = appr_num + '/' + employee_id + '/' + overtime_id;

          $('#form_approve_all').append(`
            <input name="appl_details_compressed[]" value="`+appr_details_compressed+`">
          `)
        })
      }

      Swal.fire({
        title: 'Approve these overtime applications?',
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
          var overtime_id = $(e).attr('overtime_id');

          var appr_details_compressed = appr_num + '/' + overtime_id;

          $('#form_reject_all').append(`
            <input name="appl_details_compressed[]" value="`+appr_details_compressed+`">
          `)
        })
      }

      Swal.fire({
        title: 'Reject these overtime applications?',
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





    // function save_user_access(remote_attendance_status){
    //     if($('.selected_empl:checked').length > 0){
    //         Array.from($('.selected_empl:checked')).forEach(function(e){
            
    //             // var td_remote_attendance = e.childNodes[7];
    //             // var remote_attendance_dropdown = td_remote_attendance.childNodes[1];
    //             // var remote_attendance = $(remote_attendance_dropdown).val();
                
    //             // var td_sched_remote = e.childNodes[7];
    //             // var sched_remote_dropdown = td_sched_remote.childNodes[1];
    //             // var sched_remote = $(sched_remote_dropdown).val();

    //             var empl_id = $(e).attr('empl_id');

    //             update_empl_remote_attendance(url_update_empl_remote_attendance, remote_attendance_status, empl_id).then(function(data){
    //                 console.log(empl_id + ' - ' + data);
    //             })
    //         })

    //         Swal.fire(
    //             'Changes Saved',
    //             '',
    //             'success'
    //         )

    //         setTimeout(() => {
    //             window.location.href = '<?= base_url() ?>attendance/remote_attendance';
    //         }, 500);
            
    //     } else {
    //         Swal.fire(
    //             'No Employee Selected',
    //             'Please check the box to select',
    //             'warning'
    //         )
    //     }
        
    // }











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





  })
</script>
</body>
</html>
