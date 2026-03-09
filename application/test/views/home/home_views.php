
<html>
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/home_style'); ?>
<?php
$fullname = '';
$User_access = '';
$Username = '';
$Group = '';
if ($DISP_USER_INFO) {
    foreach ($DISP_USER_INFO as $DISP_USER_INFO_ROW) {
        $fullname = $DISP_USER_INFO_ROW->col_frst_name . ' ' . $DISP_USER_INFO_ROW->col_last_name;
        $User_access = $DISP_USER_INFO_ROW->col_user_access;
        $Username = $DISP_USER_INFO_ROW->col_user_name;
        $Group = $DISP_USER_INFO_ROW->col_empl_group;
    }
}
?>
<?php
$user_id = '';
$user_image = '';
$employee_id = '';
$lastname = '';
$middlename = '';
$firstname = '';
$full_name = '';
$company_number = '';
$company_email = '';
$hired_on = '';
$employment_type = '';
$position = '';
$section = '';
$department = '';
$division = '';
$reporting_to = '';
if ($DISP_USER_INFO) {
    foreach ($DISP_USER_INFO as $DISP_USER_INFO_ROW) {
        $user_image = $DISP_USER_INFO_ROW->col_imag_path;
        $lastname = $DISP_USER_INFO_ROW->col_last_name;
        $middlename = $DISP_USER_INFO_ROW->col_midl_name;
        $firstname = $DISP_USER_INFO_ROW->col_frst_name;
        if ($middlename) {
            $full_name = $lastname . ', ' . $firstname . ' ' . $middlename;
        } else {
            $full_name = $lastname . ', ' . $firstname;
        }
        $position = $DISP_USER_INFO_ROW->col_empl_posi;
        
    }
}
?>
<style>
    li.approval-nav a.active{
        background-color:#7AC68B !important;
    }
    h6 {
        font-size: 14px !important;
    }
    .img-circle_sm{
        border-radius: 50% !important;
        width:30px !important;
        height:30px !important;
        object-fit: scale-down;
        background-color: #b0b0b0;
    }
    .img-circle {
        border-radius: 50% !important;
        height: 65px !important;
        object-fit: scale-down;
    }
    .img-circle-new-emp {
        border-radius: 50% !important;
        width:80px !important;
        height:80px !important;
        object-fit: scale-down;
    }
</style>
<div class="content-wrapper">
    <div class="flex-fill p-4">
        <div class="row">
            <div class="col-md-6 col-12">
                <?php if ($LEAVE_STATUS["value"] == '1') { ?>
                    <div class="card card-widget widget-user-2 <?= $this->session->userdata('SESS_SPE_ACCOUNT')? 'd-none' :'d-static' ?>">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header " style="background-color:#FFFFFF  !important;">
                            <div class="widget-user-image">
                                <img class="img-circle elevation-2" src="<?php if (file_exists(FCPATH.'assets_user/user_profile/' . $user_image)&&!empty( $user_image)) {
                                                                                echo base_url() . 'assets_user/user_profile/' . $user_image;
                                                                            } else {
                                                                                echo base_url() . 'assets_system/images/default_user.jpg';
                                                                            } ?>" alt="User Avatar">
                            </div>
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username "><?= $full_name ?></h3>
                            <h5 class="widget-user-desc"><?= convert_id2name($C_POSITIONS,$position) ?></h5>
                        </div>

                        <div class="card-footer p-0  accordion">
                            <ul class="nav flex-column">
                                <li class="nav-item" id="leave_request">
                                    <a href="<?php echo base_url('selfservices/my_leaves') ?>" class="nav-link">
                                        Leave Requests
                                        <span class="float-right badge text-white bg-danger m-1"><?= $LEAVE_REJECTED_COUNT2 ?></span>
                                        <span class="float-right badge text-white bg-success m-1"><?= $LEAVE_APPROVED_COUNT ?></span>
                                        </span><span class="float-right badge text-white bg-warning m-1"><?= $LEAVE_PENDING_COUNT ?></span>
                                    </a>
                                </li>
                                
                                <li class="nav-item" >
                                    <table class='bg-white' >
                                        <tbody>
                                            <?php foreach($LEAVES as $leave) { ?>
                                            <tr class='row'>
                                                <td class='col-md-3 text-center'><?=$leave->date?></td>
                                                <td class='col-md-3  text-center'><?=$leave->type?></td>
                                                <td class='col-md-3  text-center'><?=$leave->duration?> hours</td>
                                                <td class=' col-md text-center'><?=$leave->status?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </li>


                                <li class="nav-item" id="holidaywork_request">
                                    <a href="<?php echo base_url('selfservices/my_holiday_work') ?>" class="nav-link">
                                        Holiday Work
                                        <span class="float-right badge text-white bg-danger m-1"><?= $HOLIDAYWORK_REJECTED_COUNT ?></span>
                                        <span class="float-right badge text-white bg-success m-1"><?= $HOLIDAYWORK_APPROVED_COUNT ?></span>
                                        </span><span class="float-right badge text-white bg-warning m-1"><?= $HOLIDAYWORK_PENDING_COUNT ?></span>
                                    </a>
                                </li>
                                
                                <li class="nav-item" >
                                    <table class='bg-white'>
                                        <tbody>
                                            <?php foreach($HOLIDAYWORKS as $holidaywork) { ?>
                                            <tr class='row'>
                                                <td class='col-md-3 text-center'><?=$holidaywork->date?></td>
                                                <td class='col-md-3  text-center'><?=$holidaywork->type?></td>
                                                <td class='col-md-3  text-center'><?=$holidaywork->duration?> hours</td>
                                                <td class=' col-md text-center'><?=$holidaywork->status?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </li>




                                <li class="nav-item" id="overtime_request"> 
                                    <a href="<?php echo base_url('selfservices/my_overtimes') ?>" class="nav-link">
                                        Overtime Requests
                                        <span class="float-right badge text-white bg-danger m-1"><?= $OVERTIME_REJECTED_COUNT ?></span>
                                        <span class="float-right badge text-white bg-success m-1"><?= $OVERTIME_APPROVED_COUNT ?></span>
                                        <span class="float-right badge text-white bg-warning m-1"><?= $OVERTIME_PENDING_COUNT ?></span>
                                    </a>
                                </li>
                                 <li class="nav-item" >
                                    <table class='bg-white'>
                                        <tbody>
                                            <?php foreach($OVERTIMES as $overtime) { ?>
                                            <tr class='row'>
                                                <td class='col-md-3 text-center'><?=$overtime->date?></td>
                                                <td class='col-md-3 text-center'><?=$overtime->type?></td>
                                                <td class='col-md-3 text-center'><?=$overtime->duration?> hours</td>
                                                <td class='col text-center'><?=$overtime->status?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </li>
                                <li class="nav-item" id="time_record_correction_request">
                                    <a href="<?php echo base_url('selfservices/my_time_adjustments') ?>" class="nav-link">
                                        Time Record Correction Request
                                        <span class="float-right badge text-white bg-danger m-1"><?= $TIME_REJECTED_COUNT ?></span>
                                        <span class="float-right badge text-white bg-success m-1"><?= $TIME_APPROVED_COUNT ?></span>
                                        <span class="float-right badge text-white bg-warning m-1"><?= $TIME_PENDING_COUNT ?></span>
                                    </a>
                                </li>
                                                                 <li class="nav-item" >
                                    <table class='bg-white'>
                                        <tbody>
                                            <?php foreach($TIME_ADJUSTMENTS as $time_adjustment) { ?>
                                            <tr class='row'>
                                                <td class='col-md-4 text-center'><?=$time_adjustment->date?></td>
                                                <td class='col-md-4 text-center'><?=$time_adjustment->type?></td>
                                                <td class='col text-center'><?=$time_adjustment->status?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
                <!-- Nav tabs -->
                <div class='card'>
                    <div class="card-header bg-white" style="background-color: #FFFFFF !important">
                            <h6 class="card-title flex-grow-1 mb-0" style="font-weight: 600 !important;">
                                <i class="fas fa-bullhorn mr-2" style="color: #008037"></i>Approvals
                            </h6>
                    </div>
                    <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
                      <li class="nav-item approval-nav">
                        <a class="nav-link active" id="leave-tab" data-toggle="tab" href="#leave" role="tab" aria-controls="leave" aria-selected="true">Leave</a>
                      </li>
                      <li class="nav-item approval-nav">
                        <a class="nav-link" id="holidaywork-tab" data-toggle="tab" href="#holidaywork" role="tab" aria-controls="holidaywork" aria-selected="false">Holiday Work</a>
                      </li>
                      <li class="nav-item approval-nav">
                        <a class="nav-link" id="overtime-tab" data-toggle="tab" href="#overtime" role="tab" aria-controls="overtime" aria-selected="false">Overtime</a>
                      </li>
                      <li class="nav-item approval-nav">
                        <a class="nav-link" id="time_adjustment-tab" data-toggle="tab" href="#time_adjustment" role="tab" aria-controls="time_adjustment" aria-selected="false">Time Adjustment</a>
                      </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class=" tab-content p-0 ">
                      <div class="tab-pane active p-0 m-0 table-responsive" id="leave" role="tabpanel" aria-labelledby="leave-tab">
                          <?php if(!empty($LEAVE_APPROVALS)){ ?>
                          <table class='table table-bordered mt-3 mb-0 '>
                              <thead>
                                  <tr>
                                      <th style="min-width: 110px !important;">Employee&nbsp;Name</th>
                                      <th style="min-width: 110px !important;">Type</th>
                                      <th style="min-width: 110px !important;">Duration</th>
                                      <th style="min-width: 110px !important;">Status</th>
                                      <th style="min-width: 110px !important;">Date</th>
                                      <th style="min-width: 110px !important;">Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php foreach($LEAVE_APPROVALS as $leave) {?>
                                  <tr>
                                      <td>
                                          <?=$leave->col_last_name.' '.$leave->col_frst_name?>
                                      </td>
                                      <td>
                                               <?=$leave->leave_type?>
                                      </td>
                                      <td><?=$leave->duration?> Hours</td>
                                      <td><?=$leave->status?></td>
                                      <td><?=$leave->leave_date?></td>
                                      <td style='width:max-content'>
                                          <a href='<?='home/update_leave_assign/'.$leave->id?>' style='font-size:12px' class='btn technos-button-green shadow-none p-1 rounded d-block w-100 m-1'>Approve</a>
                                          <a href='<?='home/reject_leave_assign/'.$leave->id?>'  style='font-size:12px' class='btn technos-button-blue shadow-none p-1 rounded d-block w-100 m-1'>Reject</a>
                                      </td>
                                  </tr>
                                <?php } ?>
                              </tbody>
                          </table>
                          <?php } else {?>
                          <p class='text-center text-secondary p-2 my-3 technos-button-blue'>No data</p>
                          <?php } ?>
                      </div>

                      <div class="tab-pane table-responsive" id="holidaywork" role="tabpanel" aria-labelledby="holidaywork-tab">
                          <?php if(!empty($HOLIDAYWORK_APPROVALS)){ ?>
                          <table class='table table-bordered mt-3 mb-0 '>
                              <thead>
                                  <tr>
                                      <th style="min-width: 110px !important;">Employee&nbsp;Name</th>
                                      <th style="min-width: 110px !important;">Type</th>
                                      <th style="min-width: 110px !important;">Hour</th>
                                      <th style="min-width: 110px !important;">Status</th>
                                      <th style="min-width: 110px !important;">Date</th>
                                      <th style="min-width: 110px !important;">Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php foreach($HOLIDAYWORK_APPROVALS as $holidaywork) {?>
                                  <tr>
                                      <td class='text-wrap'><?=$holidaywork->col_last_name.' '.$holidaywork->col_frst_name?></td>
                                      <td class='text-wrap'><?=$holidaywork->type?></td>
                                      <td ><?=$holidaywork->hours?> hours</td>
                                      <td><?=$holidaywork->status?></td>
                                      <td><?=$holidaywork->date?></td>
                                      <td>
                                          <a href='<?='home/update_holidaywork_assign/'.$holidaywork->id?>' style='font-size:12px' class='btn technos-button-green shadow-none p-1 rounded d-block w-100 m-1'>Approve</a>
                                          <a href='<?='home/reject_holidaywork_assign/'.$holidaywork->id?>'  style='font-size:12px' class='btn technos-button-blue shadow-none p-1 rounded d-block w-100 m-1'>Reject</a>
                                      </td>
                                  </tr>
                                <?php } ?>
                              </tbody>
                          </table>
                          <?php } else {?>
                          <p class='text-center text-secondary p-2 my-3 technos-button-blue'>No data</p>
                          <?php } ?>
                      </div>




                      <div class="tab-pane table-responsive" id="overtime" role="tabpanel" aria-labelledby="overtime-tab">
                          <?php if(!empty($OVERTIME_APPROVALS)){ ?>
                          <table class='table table-bordered mt-3 mb-0 ' >
                              <thead>
                                  <tr>
                                      <th style="min-width: 110px !important;">Employee&nbsp;Name</th>
                                      <th style="min-width: 110px !important;">Type</th>
                                      <th style="min-width: 110px !important;">Hour</th>
                                      <th style="min-width: 110px !important;">Status</th>
                                      <th style="min-width: 110px !important;">Date OT</th>
                                      <th style="min-width: 110px !important;">Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php foreach($OVERTIME_APPROVALS as $overtime) {?>
                                  <tr>
                                      <td class='text-wrap'><?=$overtime->col_last_name.' '.$overtime->col_frst_name?></td>
                                      <td class='text-wrap'><?=$overtime->type?></td>
                                      <td ><?=$overtime->hours?> hours</td>
                                      <td><?=$overtime->status?></td>
                                      <td><?=$overtime->date_ot?></td>
                                      <td>
                                          <a href='<?='home/update_overtime_assign/'.$overtime->id?>' style='font-size:12px' class='btn technos-button-green shadow-none p-1 rounded d-block w-100 m-1'>Approve</a>
                                          <a href='<?='home/reject_overtime_assign/'.$overtime->id?>'  style='font-size:12px' class='btn technos-button-blue shadow-none p-1 rounded d-block w-100 m-1'>Reject</a>
                                      </td>
                                  </tr>
                                <?php } ?>
                              </tbody>
                          </table>
                          <?php } else {?>
                          <p class='text-center text-secondary p-2 my-3 technos-button-blue'>No data</p>
                          <?php } ?>
                      </div>


                      <div class="tab-pane table-responsive" id="time_adjustment" role="tabpanel" aria-labelledby="time_adjustment-tab">
                           <?php if(!empty($TIME_ADJUSTMENT)){ ?>
                          <table class='table table-bordered mt-3 mb-0 '>
                              <thead>
                                  <tr>
                                      <th>Employee&nbsp;Name</th>
                                      <!-- <th>Shift&nbsp;Type</th> -->
                                      <th>Date</th>
                                      <th>Time&nbsp;In&nbsp;1</th>
                                      <th>Time&nbsp;Out&nbsp;1</th>
                                      <th>Time&nbsp;In&nbsp;2</th>
                                      <th>Time&nbsp;Out&nbsp;2</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php foreach($TIME_ADJUSTMENT as $time_adjustment) {?>
                                  <tr>
                                      <td ><?=$time_adjustment->col_last_name.' '.$time_adjustment->col_frst_name?></td>
                                      <!-- <td ><?=$time_adjustment->shift_type?></td> -->
                                      <td><?=$time_adjustment->date_adjustment?></td>
                                      <td><?=$time_adjustment->time_in_1?></td>
                                      <td><?=$time_adjustment->time_out_1?></td>
                                      <td><?=$time_adjustment->time_in_2?></td>
                                      <td><?=$time_adjustment->time_out_2?></td>
                                      <td><?=$time_adjustment->status?></td>
                                      <td>
                                          <a href='<?='home/approve_time_adj_assign/'.$time_adjustment->id?>' style='font-size:12px' class='btn technos-button-green shadow-none p-1 rounded d-block w-100 m-1'>Approve</a>
                                          <a href='<?='home/reject_time_adj_assign/'.$time_adjustment->id?>'  style='font-size:12px' class='btn technos-button-blue shadow-none p-1 rounded d-block w-100 m-1'>Reject</a>
                                      </td>
                                  </tr>
                                <?php } ?>
                              </tbody>
                          </table>
                          <?php } else {?>
                          <p class='text-center text-secondary p-2 my-3 technos-button-blue'>No data</p>
                          <?php } ?>
                      </div>
                    </div>
                </div>
                <?php if ($ANNOUNCEMENT_STATUS["value"] == '1') { ?>
                    <div class="card elevation-1">
                        <div class="card-header bg-white" style="background-color: #FFFFFF !important">
                            <h6 class="card-title flex-grow-1 mb-0" style="font-weight: 600 !important;" id="announcement"><i class="fas fa-bullhorn mr-2" style="color: #008037"></i>Announcements</h6>
                        </div>
                        <div>
                            <div id="tbl_announcement">
                                <?php if ($DISP_ANNOUNCEMENTS_INFO) {
                                    $count = 0;
                                    foreach ($DISP_ANNOUNCEMENTS_INFO as $ROW_ANNOUNCEMENTS_INFO) {
                                        // $employee_info = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($ROW_ANNOUNCEMENTS_INFO->col_empl_id);
                                        $employee_info = $this->home_model->employeInfo($ROW_ANNOUNCEMENTS_INFO->edit_user);
                                        $db_date_time = strtotime($ROW_ANNOUNCEMENTS_INFO->create_date);
                                        $date_time = date('M d Y H:i', $db_date_time);
                                ?>
                                        <div class="p-3">
                                            
                                            <div>
                                                <a class="announcement_title"><?= $ROW_ANNOUNCEMENTS_INFO->title ?></a>
                                                <div class="author_name mb-2 mt-1">
                                                    <a>
                                                        <img width="30px" height="30px" class="rounded-circle mr-1  elevation-2" loading="lazy"
                                                        style="object-fit:scale-down"
                                                        src="<?= file_exists(FCPATH.'assets_user/user_profile/'.$employee_info[0]->col_imag_path) &&!empty($employee_info[0]->col_imag_path) && isset($employee_info[0]->col_imag_path) ? base_url('assets_user/user_profile/'.$employee_info[0]->col_imag_path) : base_url('assets_system/images/default_user.jpg') ?>">
                                                    </a>
                                                    <a class="author_name"><?= isset($employee_info[0]->col_frst_name) ?  $employee_info[0]->col_frst_name. ' ' . $employee_info[0]->col_last_name : ''; ?></a>
                                                    <span class="text-muted ml-1 author_date">
                                                        <?= $date_time ?>
                                                    </span>
                                                </div>
                                             
                                        
                                                <?php 
                                                    $ext = pathinfo($ROW_ANNOUNCEMENTS_INFO->attachment ?? "", PATHINFO_EXTENSION);
                                                    $imgExtArr = ['jpg', 'jpeg', 'png'];
                                                    if(in_array($ext, $imgExtArr)){
                                                ?>
                                                        
                                                <div class="plain_text text-justify" style="overflow: hidden;  text-overflow: ellipsis !important; ">
                                                    <p class="my-2"><?= $ROW_ANNOUNCEMENTS_INFO->description ?></p>
                                                    <img class="pe-auto w-100 d-block" src="<?= base_url() ?>assets_user/files/hressentials/<?= $ROW_ANNOUNCEMENTS_INFO->attachment ?>" alt="">
                                                </div>

                                                <?php    
                                                    }else{?>
                                                    <p>Download File :<a href="<?= base_url().'home/download_file/'.$ROW_ANNOUNCEMENTS_INFO->id; ?> "> <?= $ROW_ANNOUNCEMENTS_INFO->attachment ?></a></p> 
                                                        
                                                <?php    }
                                                ?>
                                                
                                            </div>
                                        </div>
                                    <?php
                                    }
                                } else { ?>
                                    <div>
                                        <div colspan='3' class='p-3 d-flex flex-wrap text-muted small mb-1'>No Data Yet</div>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php if ($DISP_ANNOUNCEMENTS_INFO && !$this->session->userdata('SESS_SPE_ACCOUNT') ) { ?>
                                    <a href="<?=base_url()?>companies/announcements" class="m-3 d-block text-info " style="cursor:pointer;">SEE MORE</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($CELEB_STATUS["value"] == '1') { ?>
                    <div class="card elevation-1">
                        <div class="card-header bg-white" style="background-color: #FFFFFF !important">
                            <div class="form-inline">
                                <h6 class="card-title mb-0 float-left flex-grow-1 " style="font-weight: 600 !important;"><i class="fas fa-glass-cheers  mr-2" style="color: #008037"></i> Celebrations</h6>
                                <div class="header-elements float-right">
                                    <div class="list-icons small">
                                        <a href="#" class="ml-0">7 days</a>
                                        <a class="list-icons-item" data-toggle="collapse"  data-target="#celebration_card_container" aria-expanded="false" aria-controls="celebration_card_container" style='cursor:pointer'><i class="fas fa-chevron-circle-down p-0 ml-2" style="font-size: 17px; color: grey;"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="collapse show" id="celebration_card_container">
                            <table class="table table-xs mb-0">
                                <tbody>
                                    <?php
                                    $birthday_employee = '';
                                    if ($DISP_EMPOLYEE_INFO) {
                                        foreach ($DISP_EMPOLYEE_INFO as $DISP_EMPOLYEE_INFO_ROW) { ?>
                                            <tr class="activity-birthday">
                                                <td>
                                                    <div class="text-muted small mb-1">
                                                        <div class="author_name mb-2 mt-1">
                                                            <a>
                                                            <?php if ($DISP_EMPOLYEE_INFO_ROW->col_imag_path != "") {
                                                                    $user_img = base_url()."assets_user/user_profile/".$DISP_EMPOLYEE_INFO_ROW->col_imag_path;
                                                                } else {
                                                                    $user_img = base_url(). "assets_system/images/default_user.jpg";
                                                                } 
                                                           ?>
                                                                <img width="30px" height="30px" class="rounded-circle mr-1 elevation-2"  style="object-fit:scale-down" src="<?= $user_img ?>">
                                                            </a>
                                                            <a class="author_name">
                                                                <?= $DISP_EMPOLYEE_INFO_ROW->col_frst_name . ' ' . $DISP_EMPOLYEE_INFO_ROW->col_last_name ?></a> - <?= $DISP_EMPOLYEE_INFO_ROW->Birthday ?> &nbsp;&nbsp;&nbsp;<?php if ($DISP_EMPOLYEE_INFO_ROW->Birthday == date('F d')) { ?><i class="fas fa-gift text-info"></i><?php } ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($WHOS_OUT_STATUS["value"] == '1') { ?>
                    <div class="card elevation-1">
                        <div class="card-header bg-white" style="background-color: #FFFFFF !important">
                            <div class="form-inline">
                                <h6 class="card-title mb-0 float-left flex-grow-1" style="font-weight: 600 !important;"><i class="fas fa-calendar-times  mr-2" style="color: #008037"></i> Who's Out Today</h6>
                            </div>
                        </div>
                        <table class="table table-xs mb-0" id="whos_out_card">
                            <tbody>
                                <tr class="activity-birthday" x-show="true">
                                    <td>
                                        <?php
                                        if ($DISP_ON_LEAVE) {
                                            foreach ($DISP_ON_LEAVE as $DISP_ON_LEAVE_ROW) {
                                                if ($DISP_ON_LEAVE_ROW->empl_id) {
                                                    $employee_info = $this->home_model->employeInfo($DISP_ON_LEAVE_ROW->empl_id);
                                                    $leave_type = $this->home_model->leave_type($DISP_ON_LEAVE_ROW->type);
                                                    // var_dump($employee_info);
                                                    $empl_id = '';
                                                    $empl_image = '';
                                                    $empl_fullname = '';
                                                    if (count($employee_info) > 0) {
                                                        $empl_id = $employee_info[0]->id;
                                                        $empl_image = $employee_info[0]->col_imag_path;
                                                        $empl_fullname = $employee_info[0]->col_frst_name . ' ' . $employee_info[0]->col_last_name;
                                                    }
                                        ?>          
                                                    
                                                    <div class="author_name mb-2 mt-1">
                                                        <?php
                                                        if (($User_access == 2) || ($User_access == 4)) {
                                                        ?>
                                                            <a><img width="30px" height="30px"  style="object-fit:scale-down" class="rounded-circle mr-1 elevation-2" src="<?= base_url()?><?= ($empl_image) ? 'assets_user/user_profile/'.$empl_image : 'assets_system/images/default_user.jpg'?>"></a>
                                                            <a ><?= $empl_fullname ?></a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a><img  width="30px" height="30px"   style="object-fit:scale-down" class="rounded-circle mr-1  elevation-2" src="<?= base_url()?><?= ($empl_image) ? 'assets_user/user_profile/'.$empl_image : 'assets_system/images/default_user.jpg'?>"></a>
                                                            <a><?= $empl_fullname ?></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div >
                                                        <p>Leave Type : <?= $leave_type ?></p>  
                                                        <p>Leave Date : <?= date('M d Y', strtotime($DISP_ON_LEAVE_ROW->leave_date) ); ?></p> 
                                                    </div>
                                                    
                                            <?php
                                                }
                                            }
                                        } else {
                                            ?>
                                            <div class="d-flex flex-wrap text-muted small mb-1">Nobody out today</div>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
            <!-- 2nd column -->
            <div class="col-md-6 col-12">
                <?php if ($DATE_STATUS["value"] == '1') { ?>
                    <div class="card elevation-1 py-4 px-3" style="background-image: url(<?= base_url(); ?>assets_system/images/time_background.png); background-repeat: no-repeat; background-size: cover;">
                        <div class="row">
                            <div class="col-lg-12">
                                <h2 id="current_date" class="w-100">Mon, June 15, 2021</h2>
                                <?php
                                if ($isholiday) {
                                    foreach ($isholiday as $holiday_row) {
                                ?>
                                        <h5 class="text-muted mb-0" style="font-size: 18px;" id="check_holiday">
                                            <?= 'Holiday - ' . $holiday_row->name ?>
                                        </h5>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <h5 class="text-muted mb-0" style="font-size: 18px;" id="check_holiday">
                                        <?= 'Regular Day' ?>
                                    </h5>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                
                <?php if ($START_GUIDE_STATUS["value"] == '1') { ?>
                    <div class="card elevation-1">
                        <div class="card-header bg-white" style="background-color: #FFFFFF !important">
                            <h6 class="card-title flex-grow-1 mb-0" style="font-weight: 600 !important;"><i class="fas fa-route mr-2" style="color: #008037"></i>Starter Guide</h6>
                        </div>
                        <div class="p-2" id = "starter_guide">
                            <p style="font-size: 20px; font-weight: bold;">&nbsp;&nbsp;Welcome to EyeBox HRMS 👋</p>
                            <a href="https://sonat.com/@admin-f82dc219/eyebox-hrms-operation-manual" target="_blank"> 
                                <img src="<?= base_url(); ?>assets_system/images/user_onboarding.jpg" style="width: 100%">
                            </a>
                        </div>
                    </div>
                <?php } ?>
                <!-- USERS LIST -->
                <?php if ($NEW_MEMBER_STATUS['value'] == '1') { ?>
                    <div class="card elevation-1">
                        <div class="card-header bg-white" style="background-color: #FFFFFF !important"  id = "new_member_this_month">
                            <h6 class="card-title " style="font-weight: 600 !important;"><i class="fas fa-rss mr-2" style="color: #008037"></i>New Members this month</h6>
                        </div>
                        <div class="card-body p-0">
                            <ul class="users-list clearfix">
                                <?php if ($DISP_NEW_EMP) {
                                    foreach ($DISP_NEW_EMP as $ROW_DISP_NEW_EMP) {  ?>
                                        <li>
                                            <img class="img-circle-new-emp elevation-2" src="<?php if (file_exists(FCPATH . 'assets_user/user_profile/' . $ROW_DISP_NEW_EMP->col_imag_path) && !empty($ROW_DISP_NEW_EMP->col_imag_path)) {
                                                                                        echo base_url() . 'assets_user/user_profile/' . $ROW_DISP_NEW_EMP->col_imag_path;
                                                                                    } else {
                                                                                        echo base_url() . 'assets_system/images/default_user.jpg';
                                                                                    } ?>">
                                            <a class="users-list-name pt-2" href="#" style="font-size: 12px !important"><?= $ROW_DISP_NEW_EMP->col_last_name . '<br>' . $ROW_DISP_NEW_EMP->col_frst_name ?></a>
                                        </li>
                                    <?php
                                    }
                                } else { ?>
                                    <div class="d-flex flex-wrap text-muted small mb-1">No new members this month</div>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
                <!--/.card -->
            </div>
        </div>
    </div>
</div>
<aside class="control-sidebar control-sidebar-dark">
</aside>
<!-- Request Time off -->
<div class="modal fade" id="modal_request_time_off" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Time Off Request</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url('contacts/update_contact'); ?>" id="update_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required" for="leave_request_employee_leave_type_id">Leave Type</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div data-controller="none" data-none-cache-value="1622704009">
                                            <select class="form-control custom-select" required name="leave_request[employee_leave_type_id]" id="leave_request_employee_leave_type_id">
                                                <option value="">-- Select --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div data-controller="none" data-none-cache-value="1622704009">
                                            <input type="date" class="form-control" name="date" id="date" placeholder="DD.MM.YYYY - DD.MM.YYYY">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-bold mb-1 mt-2">Note</p>
                            <textarea class="form-control form-control" name="leave_request[description]" id="leave_request_description"></textarea>
                            <small class="form-text text-muted">
                                Here you can leave some extra information about your leave request such as reason.
                            </small>
                        </div>
                        <input type="hidden" name="contact_id" id="contact_number">
                    </div>
                </div>
                <div class="modal-footer">
                    <a class='btn btn-primary text-light' id="btn_updateContact">&nbsp; Save</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        Modal content
        <div class="modal-content hero-image" style="border-radius: 15px; border : none;">
            <div class="modal-body ">
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="width: fit-content; margin: 0 auto; background: transparent; border: none;">Remind me later</button>
</div> -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Welcome Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Welcome Body Here...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- LOGOUT MODAL -->
<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Hi are you sure you want to logout?</p>
            </div>
            <div class="modal-footer pb-1 pt-1">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout</a>
            </div>
        </div>
    </div>
</div>
<!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
<?php $this->load->view('templates/jquery_link'); ?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_LOGIN')) {
?>
    <script>
        $('#myModal').modal('show');
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_LOGIN');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_DLT_ANNOUNCEMENT')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_ANNOUNCEMENT'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_DLT_ANNOUNCEMENT');
}
?>

<?php
if ($this->session->userdata('succ_approved')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('succ_approved'); ?>'
      })
</script>
<?php
$this->session->unset_userdata('succ_approved');
}
?>



<?php function convert_id2name($array,$pos){
    $name = "";
    foreach($array as $e){
        if($e->id == $pos){

            $name = $e->name;
        }
    }

    if($name == ""){
        $name = "error: can't be found";
    }
    return $name;
}

?>
<script>

    $(document).ready(function() {
        // $('#myModal').modal('show');
        $('a.btn').on('click',function(e){
            e.preventDefault();
            
            let url =$(this).attr('href');
            let action=$(this).text();
            Swal.fire({
              title: 'Confirmation',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: action==='Approve'? '#008037': '#3085d6' ,
              cancelButtonColor: '#d33',
              confirmButtonText: action==='Approve'? 'Approve': 'Reject'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        })
        var url_getChartData = '<?= base_url() ?>home/getChartData';
        setInterval(() => {
            var moment_current_date_time = moment.tz("Asia/Manila").format('llll');
            var split_moment_current_date_time = moment_current_date_time.split(' ');
            var date = split_moment_current_date_time[0] + ' ' + split_moment_current_date_time[1] + ' ' + split_moment_current_date_time[2] + ' ' + split_moment_current_date_time[3];
            var time = moment.tz("Asia/Manila").format('h:mm:ss');;
            var phase = split_moment_current_date_time[5];
            $('#current_date').text(date);
            $('#current_time').text(time);
            $('#current_phase').text(phase);
        }, 10);
        var celebration_tbl_length = $('#celebration_card tbody tr').length;
        var approved_tbl_length = $('#approved_tbl tbody tr').length;
        var rejected_tbl_length = $('#rejected_tbl tbody tr').length;
        if (celebration_tbl_length == 0) {
            $('#celebration_card tbody').append("<tr><td><div class='text-muted small mb-1'>No Incoming Celebrations</div></td></tr>");
        }
        if (approved_tbl_length == 0) {
            $('#approved_tbl tbody').append("<tr><td colspan='6' class='p-4'>No leave application approved under your supervision</td></tr>");
        }
        if (rejected_tbl_length == 0) {
            $('#rejected_tbl tbody').append("<tr><td colspan='6' class='p-4'>No leave application rejected under your supervision</td></tr>");
        }
    })
</script>
</body>
</html>