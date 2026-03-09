<style>
    label{
        font-weight: 500 !important:
    }

    li a {
        color: #0D74BC;
    }

    a:hover {
        text-decoration: none;
    }

    .activity td {
        padding: 6.8px 20px;
    }

    .page-item .active {
        background-color: #0D74BC !important;
    }

    label.required:after {
        content: " *";
    }

    label.required:after {
        content: " *";
        color: red;
    }

    li a {
        font-size: 14px;
    }

    .header-elements a {
        font-size: 14px;
    }

    .list-icons a {
        font-size: 11.2px;
        color: #197fc7;
    }

    td {
        width: 100%;
    }

    .shortcuts{
        /* background-color: #23ace0; */
        background: rgb(36,86,184);
        background: linear-gradient(0deg, rgba(36,86,184,1) 2%, rgba(86,143,233,1) 86%);
        color: #fff;
        padding: 18px 5px 10px 5px;
        margin: auto;
        width: 90px;
        height: 90px;
        border-radius: 15px;
        margin: 10px;
    }

    .shortcuts:hover{
        transition: 0.3s;
        /* background-color: #2e7dd6; */
        opacity: 0.8;
        cursor: pointer;
    }

    .shortcut_container{
        /* padding-left: 100px;
        padding-right: 100px; */
        padding-left: 50px;
        padding-right: 50px;
    }

    .shortcuts i{
        font-size: 30px;
    }

    .shortcuts p{
        font-size:12px;
        margin-top: 8px;
        margin-bottom: 0px;
        line-height: 12px;
        height: 24px;
    }

    .announcements{
        padding: 18px 0px 10px !important;
    }

    .shortcuts .single_line_text{
        margin-top: 12px;
    }

    @media screen and (max-width: 1500px) {
        .shortcut_container{
            padding-left: 20px !important;
            padding-right: 20px !important;
        }

        .shortcuts{
            /* background-color: #23ace0; */
            background: rgb(36,86,184);
            background: linear-gradient(0deg, rgba(36,86,184,1) 2%, rgba(86,143,233,1) 86%);
            color: #fff;
            padding: 14px 5px 10px 5px;
            margin: auto;
            width: 80px;
            height: 80px;
            border-radius: 15px;
        }

        .shortcuts p{
            font-size:12px;
            margin-top: 5px;
            margin-bottom: 0px;
            line-height: 12px;
            height: 24px;
        }

        .announcements{
            padding: 14px 0px 10px !important;
            font-size: 11px;
        }
    }

    @media screen and (max-width: 500px) {
        .col-sm-2{
            width: 50% !important;
            margin-top: 10px;
        }

        #current_date{
            text-align: center;
            font-size: 20px !important;
        }

        #check_holiday{
            text-align: center;
        }

        #current_time{
            margin-top: 10px;
            font-size: 30px !important;
            font-weight: 500 !important:
        }

        #current_phase{
            margin-top: 15px !important;
        }

        .time_container{
            float: none !important;
            width: 100%;
            text-align: center !important;
            margin-left: auto;
            margin-right: auto;
        }

        .categories{
            text-align: center;
            margin-top: 10px;
        }

        .categories_header{
            text-align: center;
        }
    }
    
    
</style>

<?php
$fullname = '';
$User_access='';
$Username='';
$Group='';
if ($DISP_USER_INFO) {
    foreach ($DISP_USER_INFO as $DISP_USER_INFO_ROW) {
        $fullname = $DISP_USER_INFO_ROW->col_frst_name . ' ' . $DISP_USER_INFO_ROW->col_last_name;
        $User_access = $DISP_USER_INFO_ROW->col_user_access;
        $Username = $DISP_USER_INFO_ROW->col_user_name;
        $Group = $DISP_USER_INFO_ROW->col_empl_group;
    }
}
?>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">

<div class="content-wrapper">
    <div class="flex-fill p-4">
        <div class="row">
            <div class="col-lg-7 col-xs-12">
                <div class="card elevation-1 py-4 px-3">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="card-title"><i class="fas fa-chart-bar text-success"></i>&nbsp;&nbsp; Attendance Report</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="#" id="view_reports" class="float-right">View Reports</a>
                        </div>
                    
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <select name="cutoff_period" id="cutoff_period" class="form-control form-control-sm" required>
                                <?php

                                    $db_cutoff_id = '';
                                    if($DISP_PAYROLL_SCHED){
                                        $isCutoff_today = false;

                                        foreach($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW){
                                            $current_date = date('Y-m-d');
                                            $db_date_period = $DISP_PAYROLL_SCHED_ROW->db_name;
                                            $split_date_period = explode(' - ',$db_date_period);
                                            $db_start_date = $split_date_period[0];
                                            $db_end_date = $split_date_period[1];

                                            $start_date = date('Y-m-d', strtotime($db_start_date));
                                            $end_date = date('Y-m-d', strtotime($db_end_date));

                                            $db_payout = $DISP_PAYROLL_SCHED_ROW->payout;
                                            $payout = date('F d Y', strtotime($db_payout));

                                            if(($current_date >= $start_date) && ($current_date <= $end_date)){
                                                $schedule_id = $DISP_PAYROLL_SCHED_ROW->id;
                                                $db_cutoff_id = $schedule_id;
                                                $isCutoff_today = true;
                                        ?>
                                            <option value="<?= $schedule_id ?>" db_date="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>" payout="<?= $payout ?>" selected><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                                        <?php
                                            } else {
                                                
                                        ?>
                                            <option value="<?= $DISP_PAYROLL_SCHED_ROW->id ?>" db_date="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>" payout="<?= $payout ?>" ><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                                        <?php
                                            }
                                        }

                                        if($isCutoff_today){
                                            $db_cutoff_id = $DISP_PAYROLL_SCHED[0]->id;
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        
                    </div>

                    <div id="myChart">
                        <!-- <canvas ></canvas> -->
                    </div>
                </div>
                
                <br>

                <div class="card elevation-1">
                    <div class="card-header bg-white">
                        <div class="form-inline">
                            <h6 class="card-title mb-0 float-left flex-grow-1"><i class="fas fa-glass-cheers text-success mr-2"></i> Celebrations</h6>

                            <div class="header-elements float-right">
                                <div class="list-icons small">
                                    <a href="#" class="ml-0">7 days</a>

                                    <a class="list-icons-item" data-toggle="collapse" href="#celebration_card"><i class="fas fa-chevron-circle-down p-0 ml-2" style="font-size: 17px; color: grey;"></i> </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <table class="table table-xs mb-0" id="celebration_card">
                        <tbody>
                            <?php 
                                $birthday_employee = '';
                                if($DISP_EMPOLYEE_INFO){
                                    foreach($DISP_EMPOLYEE_INFO as $DISP_EMPOLYEE_INFO_ROW){
                                        $date_today = date('Y-m-d');
                                        $date = strtotime($date_today);
                                
                                        $current_month = date('m', $date);
                                        $current_day = date('d', $date);
                                
                                        $date_7_days = strtotime("+7 day", $date);
                                        $date_7_days =  date('Y-m-d', $date_7_days);
                                        $get_month = date('m' ,strtotime($date_7_days));
                                        $get_day = date('d' ,strtotime($date_7_days));
                                
                                        //echo 'month'.$get_month.'<br>';
                                        //echo 'day'.$get_day.'<br><br>';
                                
                                        $db_date = $DISP_EMPOLYEE_INFO_ROW->col_birt_date;
                                        $get_db_month = date('m' ,strtotime($db_date));
                                        $get_db_day = date('d' ,strtotime($db_date));
                                
                                        if(($get_db_month >= $current_month) && ($get_db_month <= $get_month)){
                                            if(($get_db_day >= $current_day) && ($get_db_day <= $get_day)){
                                                $db_birthday_employee = $DISP_EMPOLYEE_INFO_ROW->col_birt_date;
                                                $birthday_employee = date('F d', strtotime($db_birthday_employee));

                                                ?>
                                                    <tr class="activity-birthday">
                                                        <td>
                                                            <div class="text-muted small mb-1">
                                                                <?php
                                                                    if(date('M d', strtotime($db_birthday_employee)) == date('M d')){
                                                                    ?>
                                                                        <div class="author_name mb-2 mt-1">
                                                                            <?php 
                                                                                if(($User_access == 2) || ($User_access == 4)){
                                                                                    ?>
                                                                                        <a href="<?= base_url() ?>employees/personal?id=<?= $DISP_EMPOLYEE_INFO_ROW->id ?>">
                                                                                            <img width="20" class="rounded-circle mr-1" src="<?=base_url()?>user_images/<?php if($DISP_EMPOLYEE_INFO_ROW->col_imag_path){ echo $DISP_EMPOLYEE_INFO_ROW->col_imag_path;}else{echo 'default_profile_img3.png';} ?>">
                                                                                        </a>                  
                                                                                        <a class="author_name" href="<?= base_url() ?>employees/personal?id=<?= $DISP_EMPOLYEE_INFO_ROW->id ?>"><?= $DISP_EMPOLYEE_INFO_ROW->col_frst_name.' '.$DISP_EMPOLYEE_INFO_ROW->col_last_name ?></a> - <?= ' - Birthday Today' ?> &nbsp;&nbsp;&nbsp;<i class="fas fa-gift text-info"></i>
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                        <a href="#">
                                                                                            <img width="20" class="rounded-circle mr-1" src="<?=base_url()?>user_images/<?php if($DISP_EMPOLYEE_INFO_ROW->col_imag_path){ echo $DISP_EMPOLYEE_INFO_ROW->col_imag_path;}else{echo 'default_profile_img3.png';} ?>">
                                                                                        </a>                  
                                                                                        <a class="author_name" href="#"><?= $DISP_EMPOLYEE_INFO_ROW->col_frst_name.' '.$DISP_EMPOLYEE_INFO_ROW->col_last_name ?></a> - <?= ' - Birthday Today' ?> &nbsp;&nbsp;&nbsp;<i class="fas fa-gift text-info"></i>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <div class="author_name mb-2 mt-1">
                                                                            <?php 
                                                                                if(($User_access == 2) || ($User_access == 4)){
                                                                                    ?>
                                                                                        <a href="<?= base_url() ?>employees/personal?id=<?= $DISP_EMPOLYEE_INFO_ROW->id ?>">
                                                                                            <img width="20" class="rounded-circle mr-1" src="<?=base_url()?>user_images/<?php if($DISP_EMPOLYEE_INFO_ROW->col_imag_path){ echo $DISP_EMPOLYEE_INFO_ROW->col_imag_path;}else{echo 'default_profile_img3.png';} ?>">
                                                                                        </a>                  
                                                                                        <a class="author_name" href="<?= base_url() ?>employees/personal?id=<?= $DISP_EMPOLYEE_INFO_ROW->id ?>"><?= $DISP_EMPOLYEE_INFO_ROW->col_frst_name.' '.$DISP_EMPOLYEE_INFO_ROW->col_last_name ?></a> - <?= ' - Birthday on '.$birthday_employee ?>
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                        <a href="#">
                                                                                            <img width="20" class="rounded-circle mr-1" src="<?=base_url()?>user_images/<?php if($DISP_EMPOLYEE_INFO_ROW->col_imag_path){ echo $DISP_EMPOLYEE_INFO_ROW->col_imag_path;}else{echo 'default_profile_img3.png';} ?>">
                                                                                        </a>                  
                                                                                        <a class="author_name" href="#"><?= $DISP_EMPOLYEE_INFO_ROW->col_frst_name.' '.$DISP_EMPOLYEE_INFO_ROW->col_last_name ?></a> - <?= ' - Birthday on '.$birthday_employee ?>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                            <div class="d-flex flex-wrap"></div>
                                                        </td>
                                                    </tr>
                                                <?php
                                            }
                                        }
                                    }
                                }
                            ?>
                            
                        </tbody>
                    </table>
                </div>

                <br>
                
                <div class="card elevation-1">
                    <div class="card-header bg-white">
                        <div class="form-inline">
                            <h6 class="card-title mb-0 float-left flex-grow-1"><i class="fas fa-calendar-times text-success mr-2"></i> Who's Out</h6>

                            <div class="header-elements float-right">
                                <div class="list-icons small">
                                    <a href="#" class="mb-0" class="text-grey">Today</a>
                                    <a class="list-icons-item" data-toggle="collapse" href="#whos_out_card"><i class="fas fa-chevron-circle-down p-0 ml-2" style="font-size: 17px; color: grey;"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-xs mb-0" id="whos_out_card">
                        <tbody>
                            <tr class="activity-birthday" x-show="true">
                                <td>
                                    <?php 
                                        if($DISP_ON_LEAVE){
                                            foreach($DISP_ON_LEAVE as $DISP_ON_LEAVE_ROW){
                                                if($DISP_ON_LEAVE_ROW->col_empl_id){
                                                    $employee_info = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ON_LEAVE_ROW->col_empl_id);

                                                        $empl_id = '';
                                                        $empl_image = '';
                                                        $empl_fullname = '';
                                                        if(count($employee_info) > 0){
                                                            $empl_id = $employee_info[0]->id;
                                                            $empl_image = $employee_info[0]->col_imag_path;
                                                            $empl_fullname = $employee_info[0]->col_frst_name.' '.$employee_info[0]->col_last_name;
                                                        }
                                                    ?>
                                                        <div class="author_name mb-2 mt-1">
                                                            <?php 
                                                                if(($User_access == 2) || ($User_access == 4)){
                                                                    ?>
                                                                        <a href="<?= base_url() ?>employees/personal?id=<?= $empl_id ?>">
                                                                            <img width="20" class="rounded-circle mr-1" src="<?=base_url()?>user_images/<?= $empl_image ?>">
                                                                        </a>                  
                                                                        <a class="author_name" href="<?= base_url() ?>employees/personal?id=<?= $empl_id ?>"><?= $empl_fullname ?></a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <a href="#">
                                                                            <img width="20" class="rounded-circle mr-1" src="<?=base_url()?>user_images/<?= $empl_image ?>">
                                                                        </a>                  
                                                                        <a class="author_name" href="#"><?= $empl_fullname ?></a>
                                                                    <?php
                                                                }
                                                            ?>
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
            </div>
            <div class="col-lg-5 col-xs-12">

                <div class="card elevation-1 py-4 px-3">
                    <div class="row">
                        <div class="col-lg-7">
                            <h1 id="current_date">Mon, June 15, 2021</h1>
                            <?php
                                $isholiday = $this->p166_holiday_mod->MOD_DISP_HOLIDAY_BASED_DATE(date('Y-m-d'));
                                if($isholiday){
                                    foreach($isholiday as $holiday_row){
                                        ?>
                                            <h5 class="text-muted mb-0" style="font-size: 18px;" id="check_holiday">
                                                <?= 'Holiday - '.$holiday_row->name ?>
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
                        <div class="col-lg-5"> 
                            <center>
                            <h1 class="mb-0 mr-2" id="current_time" style="display:inline;">00:00:00</h1>
                            <h4 class="mb-0 mt-3" id="current_phase" style="display:inline;">AM</h4>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="card elevation-1 py-4 px-3">
                    <p class="categories_header text-bold" style="font-size: 25px;">Shortcuts</p>

                    <?php 
                        if($Username != 'bwpaccounting'){
                            ?>
                                <!-- ALL USERS -->
                                <p class="categories text-bold text-secondary" style="font-size: 15px;"><i class="fas fa-user text-success"></i>&nbsp;&nbsp;Self-Service</p>
                                <div class="row mb-5 shortcut_container" >

                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>profile'">
                                            <i class="far fa-user-circle" ></i><br>
                                            <p class="single_line_text">My Info</p>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-3 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>tasks'">
                                            <i class="fas fa-tasks" ></i><br>
                                            <p class="single_line_text">My Tasks</p>
                                        </div>
                                    </div> -->

                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts announcements" onclick="window.location.href = '<?= base_url()?>attendance/my_daily_time_record'">
                                            <i class="fas fa-user-clock" ></i><br>
                                            <p class="single_line_text">My Time Record</p>
                                        </div>
                                    </div>

                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" <?php if($Group != 'STAFF'){echo 'style="cursor: default !important; background: #ccc !important;"';} ?> onclick="window.location.href = '<?php if($Group == 'STAFF'){echo base_url().'leave/my_leave';}else{echo '#';} ?>'">
                                            <i class="fas fa-door-open" ></i><br>
                                            <p class="single_line_text">My Leave</p>
                                        </div>
                                    </div>

                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" <?php if($Group != 'STAFF'){echo 'style="cursor: default !important; background: #ccc !important;"';} ?> onclick="window.location.href = '<?php if($Group == 'STAFF'){echo base_url().'attendance/my_overtime';}else{echo '#';} ?>'">
                                            <i class="fas fa-history" ></i><br>
                                            <p class="single_line_text">My Overtime</p>
                                        </div>
                                    </div>

                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" <?php if($Group != 'STAFF'){echo 'style="cursor: default !important; background: #ccc !important;"';} ?> onclick="window.location.href = '<?php if($Group == 'STAFF'){echo base_url().'attendance/my_time_adjustment';}else{echo '#';} ?>'">
                                            <i class="fas fa-wrench" ></i><br>
                                            <p>My Time Adjustment</p>
                                        </div>
                                    </div>

                                </div>
                            <?php
                        }
                    ?>
                    
                    <?php 
                        // get approval route
                        $isApprover_ot_adj = $this->login_model->check_if_approver($this->session->userdata('SESS_USER_ID'));
                        $isApprover_leave = $this->login_model->check_if_approver_leave($this->session->userdata('SESS_USER_ID'));
                        $isApprover_leave_group = $this->login_model->check_if_approver_leave_group($this->session->userdata('SESS_USER_ID'));

                        if((count($isApprover_leave_group) > 0) || (count($isApprover_ot_adj) > 0) || (count($isApprover_leave) > 0) || $User_access == 4){
                            ?>
                                <!-- SUPERVISOR -->
                                <p class="categories text-bold text-secondary" style="font-size: 15px;"><i class="fas fa-users text-success"></i>&nbsp;&nbsp;Supervision</p>
                                <div class="row mb-5 shortcut_container" >
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>leave/assign_leave'">
                                            <i class="fas fa-edit" ></i><br>
                                            <p class="single_line_text">Assign Leave</p>
                                        </div>
                                    </div>
                                    <!--<div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">-->
                                    <!--    <div class="text-center shortcuts" onclick="window.location.href = '#'">-->
                                    <!--        <i class="fas fa-history" ></i><br>-->
                                    <!--        <p>Assign Overtime</p>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '#'">
                                            <i class="fas fa-user-clock" ></i><br>
                                            <p >Daily Time Record</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>approval/approval_list'">
                                            <i class="far fa-list-alt" ></i><br>
                                            <p >Approval</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?php echo base_url(); ?>leave/entitlement_list'">
                                            <i class="fas fa-crown" ></i><br>
                                            <p >Entitlement List</p>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                    
                    <?php 
                        if(($User_access == 2) || ($User_access == 4)){
                            ?>
                                <!-- HUMAN RESOURCE -->
                                <p class="categories text-bold text-secondary" style="font-size: 15px;"><i class="fas fa-users-cog text-success"></i>&nbsp;&nbsp;Human Resource</p>
                                <div class="row mb-5 shortcut_container" >
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>employees'">
                                            <i class="fas far fa-address-book" ></i><br>
                                            <p>Employee List</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>attendance/daily_attendance'">
                                            <i class="fas fa-user-clock" ></i><br>
                                            <p>Daily Attendance</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>attendance/attendance_record'">
                                            <i class="fas fa-list-alt" ></i><br>
                                            <p>Attendance Records</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>leave/assign_leave'">
                                            <i class="fas fa-edit" ></i><br>
                                            <p class="single_line_text">Leave</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?php echo base_url(); ?>attendance/overtime'">
                                            <i class="fas fa-history" ></i><br>
                                            <p class="single_line_text">Overtime</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?php echo base_url(); ?>attendance/time_adjustment'">
                                            <i class="fas fa-wrench" ></i><br>
                                            <p>Time Adjustment</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url() ?>payroll/loans'">
                                            <i class="fas fa-money-bill-wave" ></i><br>
                                            <p class="single_line_text">Loans</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '#'">
                                            <i class="fas fa-wallet" ></i><br>
                                            <p class="single_line_text">Allowances</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '#'">
                                            <i class="fas fa-minus-circle" ></i><br>
                                            <p class="single_line_text">Deductions</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>approval/approval_route'">
                                            <i class="fas fa-route" ></i><br>
                                            <p>Approval Route</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>announcements'">
                                            <i class="fas fa-bullhorn" ></i><br>
                                            <p class="single_line_text">Announcements</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>asset'">
                                            <i class="fas fa-cubes" ></i><br>
                                            <p class="single_line_text">Assets</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>csv'">
                                            <i class="far fa-list-alt" ></i><br>
                                            <p>Import Employees</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>csv/import_attendance'">
                                            <i class="fas fa-route" ></i><br>
                                            <p>Import Attendance</p>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>

                    <?php 
                        if(($User_access == 3) || ($User_access == 4)){
                            ?>
                                <!-- ACCOUNTING -->
                                <p class="categories text-bold text-secondary" style="font-size: 15px;"><i class="fas fa-money-bill text-success"></i>&nbsp;&nbsp;Accounting</p>
                                <div class="row mb-5 shortcut_container" >
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?php echo base_url(); ?>payroll'">
                                            <i class="fas fa-file-invoice-dollar" ></i><br>
                                            <p>Payslip Generator</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?php echo base_url(); ?>payroll/company_contributions'">
                                            <i class="fas fa-donate" ></i><br>
                                            <p>Company Contributions</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url() ?>payroll/bank_details'">
                                            <i class="fas fa-university" ></i><br>
                                            <p>Bank Details</p>
                                        </div>
                                    </div>
                                    <div class="pt-3 col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '<?= base_url()?>csv/import_accounting'">
                                            <i class="fas fa-file-csv" ></i><br>
                                            <p>Import CSV</p>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>

                    <?php 
                        if($User_access == 4){
                            ?>
                                <!-- ADMINISTRATOR -->
                                <p class="categories text-bold text-secondary" style="font-size: 15px;"><i class="fas fa-user-tie text-success"></i>&nbsp;&nbsp;Administrator</p>
                                <div class="row mb-5 shortcut_container">
                                    <div class="col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '#'">
                                            <i class="fas fa-file-invoice-dollar" ></i><br>
                                            <p class="single_line_text">User Access</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-4 w-100 text-center pl-0 pr-0">
                                        <div class="text-center shortcuts" onclick="window.location.href = '#'">
                                            <i class="fas fa-file-invoice-dollar" ></i><br>
                                            <p>Account Management</p>
                                        </div>
                                    </div>
                                </div>

                            <?php
                        }
                    ?>
                    
                </div>

                <div class="card elevation-1">
                    <div class="card-header bg-white form-inline">
                        <h6 class="card-title flex-grow-1 mb-0"><i class="fas fa-bullhorn mr-2 text-success"></i>Announcements</h6>
                        <!-- <a class="btn btn-primary" style="color: #fff !important;" href="home/new_announcement"><i class="fas fa-plus mr-1"></i> New Announcement</a> -->
                    </div>
                    <div>
                        <table class="table table-xs">
                            <tbody>
                                <?php if ($DISP_ANNOUNCEMENTS_INFO) {
                                    foreach ($DISP_ANNOUNCEMENTS_INFO as $ROW_ANNOUNCEMENTS_INFO) { 

                                        $employee_info = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($ROW_ANNOUNCEMENTS_INFO->col_empl_id);
                                        $db_date_time = strtotime($ROW_ANNOUNCEMENTS_INFO->col_date_created);
                                        $date_time = date('M d Y H:i', $db_date_time);
                                        ?>
                                        <tr class=" activity activity-announcement">
                                            <td>
                                                <div class="mb-2"></div>
                                                <?php 
                                                    if(($User_access == 2) || ($User_access == 4)){
                                                        ?>
                                                            <a class="announcement_title" href="<?= base_url() ?>announcements/info?id=<?= $ROW_ANNOUNCEMENTS_INFO->id ?>"><?=$ROW_ANNOUNCEMENTS_INFO->name?></a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                            <a class="announcement_title" href="#"><?=$ROW_ANNOUNCEMENTS_INFO->name?></a>
                                                        <?php
                                                    }
                                                ?>
                                                
                                                <div class="author_name mb-2 mt-1">
                                                    <?php 
                                                        if(($User_access == 2) || ($User_access == 4)){
                                                            ?>
                                                                <a href="<?= base_url() ?>employees/personal?id=<?= $ROW_ANNOUNCEMENTS_INFO->col_empl_id ?>">
                                                                    <img width="20" class="rounded-circle mr-1 " loading="lazy" src="<?=base_url()?>user_images/<?= $employee_info[0]->col_imag_path ?>">
                                                                </a>                  
                                                                <a class="author_name" href="<?= base_url() ?>employees/personal?id=<?= $ROW_ANNOUNCEMENTS_INFO->col_empl_id ?>"><?= $employee_info[0]->col_frst_name.' '.$employee_info[0]->col_last_name ?></a>
                                                            <?php
                                                        } else {
                                                            ?>
                                                                <a href="#">
                                                                    <img width="20" class="rounded-circle mr-1 " loading="lazy" src="<?=base_url()?>user_images/<?= $employee_info[0]->col_imag_path ?>">
                                                                </a>                  
                                                                <a class="author_name" href="#"><?= $employee_info[0]->col_frst_name.' '.$employee_info[0]->col_last_name ?></a>
                                                            <?php
                                                        }
                                                    ?>
                                                    
                                                    <span class="text-muted ml-1 author_date">
                                                        <?= $date_time ?>
                                                    </span>
                                                </div>
                                                <div class="plain_text">
                                                    <?=$ROW_ANNOUNCEMENTS_INFO->description?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                } else { ?>
                                    <tr>
                                        <td colspan='3'>No Data Yet
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            


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


<input type="hidden" id="count_present" value="<?= count($DISP_PRESENT) ?>">
<input type="hidden" id="count_abasent" value="<?= count($DISP_ABSENT) ?>">
<input type="hidden" id="count_late" value="<?= count($DISP_LATE) ?>">
<input type="hidden" id="count_undertime" value="<?= count($DISP_UNDERTIME) ?>">
<input type="hidden" id="count_leave" value="<?= count($DISP_LEAVE) ?>">


<!-- jQuery -->
<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
<!-- Full Calendar 2.2.5 -->
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/moment/moment-timezone-with-data.min.js"></script>

<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<!-- Chart JS -->
<script src="<?php echo base_url(); ?>plugins/chart.js/Chart.bundle.min.js"></script>

<?php
if ($this->session->userdata('SESS_SUCC_MSG_LOGIN')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_LOGIN'); ?>',
            '',
            'success'
        )
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

<script>
    $(document).ready(function(){

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

        if(celebration_tbl_length == 0){
        $('#celebration_card tbody').append( "<tr><td><div class='text-muted small mb-1'>No Incoming Celebrations</div></td></tr>" );
        }
        if(approved_tbl_length == 0){
        $('#approved_tbl tbody').append( "<tr><td colspan='6' class='p-4'>No leave application approved under your supervision</td></tr>" );
        }
        if(rejected_tbl_length == 0){
        $('#rejected_tbl tbody').append( "<tr><td colspan='6' class='p-4'>No leave application rejected under your supervision</td></tr>" );
        }











        var db_date = $('#cutoff_period').find('option:selected').attr('db_date');
        
        $.ajax({
            url: '<?= base_url() ?>home/getChartData',
            type: "post",
            data: {
                cutoff_period: db_date
            },
            success: function(data){
                var graph_data = JSON.parse(data);
                var bar_graph = graph_data.bar_graph;
                var count_present = graph_data.count_present;
                var count_abasent = graph_data.count_absent;
                var count_late = graph_data.count_late;
                var count_undertime = graph_data.count_undertime;
                var count_leave = graph_data.count_leave;

                $('#myChart').html(bar_graph);

                $('#graph').chart = new Chart($('#graph'), {
                    type: 'bar',
                    data: {
                        labels: ['Present', 'Absent', 'Late', 'Undertime', 'On Leave'],
                        datasets: [{
                            label: ['Number of employees'],
                            data: [count_present, count_abasent, count_late, count_undertime, count_leave],
                            backgroundColor: [
                                'rgba(63, 218, 11, 0.5)',
                                'rgba(236, 62, 19, 0.4)',
                                'rgba(255, 206, 86, 0.4)',
                                'rgba(75, 192, 192, 0.4)',
                                'rgba(153, 102, 255, 0.4)'
                            ],
                            borderColor: [
                                'rgba(35, 121, 6, 1)',
                                'rgba(165, 44, 13, 1)',
                                'rgba(230, 115, 0, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                boxWidth: 0,
                            },
                        }
                    }
                });
            }
        })









        $('#cutoff_period').change(function(e){
            var db_date = $(this).find('option:selected').attr('db_date');

            $.ajax({
                url: '<?= base_url() ?>home/getChartData',
                type: "post",
                data: {
                    cutoff_period: db_date
                },
                success: function(data){
                    var graph_data = JSON.parse(data);
                    var bar_graph = graph_data.bar_graph;
                    var count_present = graph_data.count_present;
                    var count_abasent = graph_data.count_absent;
                    var count_late = graph_data.count_late;
                    var count_undertime = graph_data.count_undertime;
                    var count_leave = graph_data.count_leave;

                    $('#myChart').html(bar_graph);

                    $('#graph').chart = new Chart($('#graph'), {
                        type: 'bar',
                        data: {
                            labels: ['Present', 'Absent', 'Late', 'Undertime', 'On Leave'],
                            datasets: [{
                                label: ['Number of employees'],
                                data: [count_present, count_abasent, count_late, count_undertime, count_leave],
                                backgroundColor: [
                                    'rgba(63, 218, 11, 0.5)',
                                    'rgba(236, 62, 19, 0.4)',
                                    'rgba(255, 206, 86, 0.4)',
                                    'rgba(75, 192, 192, 0.4)',
                                    'rgba(153, 102, 255, 0.4)'
                                ],
                                borderColor: [
                                    'rgba(35, 121, 6, 1)',
                                    'rgba(165, 44, 13, 1)',
                                    'rgba(230, 115, 0, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    boxWidth: 0,
                                },
                            }
                        },
                    });
                }
            })
        })















        $('#view_reports').click(function(e){
            var db_cutoff_period = $('#cutoff_period').find('option:selected').attr('db_date');
            window.location.href = '<?= base_url() ?>home/reports?cutoff='+db_cutoff_period;
        })
























        async function getChartData(url,cutoff_period){
            var formData = new FormData();
            formData.append('cutoff_period', cutoff_period);
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