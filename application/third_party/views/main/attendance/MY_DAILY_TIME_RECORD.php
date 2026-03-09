<style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron&display=swap');

    .card{
        padding: 15px;
    }
    li a{
        color: #0D74BC;
    }
    .page-item .active{
        background-color: #0D74BC !important;
    }
    label.required:after {
        content: " *";
    }

    label.required:after {
        content: " *";
        color: red;
    }
    
    .label-note{
        background-color: #fde6d8;
        padding: 5px 10px;
        border-radius: 30px;
        color: #c46632;
        font-weight: bold;
        text-align: center;
        line-height: normal;
    }
    table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
   
    }
    th, td {
    text-align: left;
    padding: 8px;
    font-size: 14px !important;
    font-weight: normal;
    }

    #cutoff_container th, #cutoff_container td{
        margin: 0px !important;
        font-size: 10px !important;
        padding: 10px 8px !important;
        border-top: none !important;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }

    .badge{
        border-radius: 5px !important;
        font-weight: bold;
        padding: 8px 10px;
    }

    .icon{
        width: 140px;
        height: 140px;
        border-radius: 8px 8px 8px 8px;
        -webkit-transform-origin: 50% 10%;
        transform-origin: 50% 10%;
    }

    .icon:hover, .icon:focus
    {
        -webkit-animation: swing 0.6s ease-out;
        animation: swing 0.6s ease-out;
    }

    .time_container{
        transform: translateY(25%) !important;
    }

    @-webkit-keyframes swing {
        0%   { -webkit-transform: rotate(0deg)  skewY(0deg); }
        20%  { -webkit-transform: rotate(12deg) skewY(4deg); }
        60%  { -webkit-transform: rotate(-9deg) skewY(-3deg); }
        80%  { -webkit-transform: rotate(6deg)  skewY(-2deg); }
        100% { -webkit-transform: rotate(0deg)  skewY(0deg); }
    }

    @keyframes swing {
        0%   { transform: rotate(0deg)  skewY(0deg); }
        20%  { transform: rotate(12deg) skewY(4deg); }
        60%  { transform: rotate(-9deg) skewY(-3deg); }
        80%  { transform: rotate(6deg)  skewY(-2deg); }
        100% { transform: rotate(0deg)  skewY(0deg); }
    }

    @media screen and (max-width: 500px){
        #current_time,#current_phase{
            text-align: center;
        }
        .time_container{
            transform: translateY(25%) !important;
        }
        #btn_time_in,#btn_time_out{
            width: 100%;
            margin-bottom: 10px;
            padding: 20px 20px;
        }
    }

    @media 
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {
		
        /* Force table to not be like tables anymore */
        table, thead, tbody, th, td, tr { 
            display: block; 
        }
        
        /* Hide table headers (but not display: none;, for accessibility) */
        thead tr { 
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
        
        tr { 
            border: 1px solid #ccc;
            margin-bottom: 20px; 
        }
        
        td{ 
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee; 
            position: relative;
            padding-left: 50% !important;
            text-align: right;
        }
        
        td:before { 
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%; 
            padding-right: 10px; 
            white-space: nowrap;
            color: #5c5b5b;
            text-transform: capitalize;
            text-align: left !important;
        }

        .modal_head{
            margin-top: 15px;
            padding-bottom: 10px;
            color: #007BFF;
        }
        
        /* Labels the sliced thead of the table */
        td:nth-of-type(1):before { content: "Date"; }
        td:nth-of-type(2):before { content: "Shift"; }
        td:nth-of-type(3):before { content: "Time In"; }
        td:nth-of-type(4):before { content: "Time Out"; }
        /* Add as you add content to the thead */
	}

      /* Technos Standard: For mobile phones: */
  @media only screen and (max-width: 768px) {

.page-title {
  font-weight: 600;
  color: #424F5C;
  font-size: 22px;

}

.button-title {
  text-align: left;
  margin-top: 5px;
}
}
</style>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Datatables -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<?php

    $month = date('F');
    $day = date('d');
    $day_of_week = date('l');

    $date = date('Y-m-d');
    $user_id = $this->session->userdata('SESS_USER_ID');
    $employee_dtr = $this->p050_attendance_mod->MOD_DISP_CURRENT_EMPLOYEE_ATTENDANCE($date, $user_id);
    $has_time_in = '';
    $has_time_out = '';

    $time_in = '';
    $time_out = '';
    $shift_name = '';
    $shift_color = '';

    $prev_shift_id = '';
    $prev_date = date('Y-m-d', strtotime("-1 day", strtotime($date)));
    $employee_dtr_prev = $this->p050_attendance_mod->MOD_DISP_CURRENT_EMPLOYEE_ATTENDANCE($prev_date, $user_id);
    $shift_yesterday = '';
    $shift_name_yesterday = '';
    $prev_has_time_in = '';
    $prev_has_time_out = '';
    $db_time_out_prev = '';
    $db_time_in_prev = '';

    if($employee_dtr_prev){
        if($employee_dtr_prev[0]->shift_id){
            $prev_shift_id = $employee_dtr_prev[0]->shift_id;
            $prev_shift_data = $this->p171_workshifts_mod->MOD_GET_WRK_SHFT_DATA($prev_shift_id);
    
            $prev_has_next_day = '';
            if($prev_shift_id){
                $prev_has_next_day = $prev_shift_data[0]->next_day;
            }
        
            $shift_yesterday = '['.$prev_shift_data[0]->code.'] '.$prev_shift_data[0]->time_in.' - '.$prev_shift_data[0]->time_out;
    
    
    
            if($prev_has_next_day == 'true'){
                $prev_date = date('Y-m-d', strtotime("-1 day", strtotime($date)));
                $db_time_out_prev = $this->p050_attendance_mod->MOD_GET_TIME_OUT($prev_date,$user_id);
                $db_time_in_prev = $this->p050_attendance_mod->MOD_GET_TIME_IN($prev_date,$user_id);
        
        
                $db_time_out_today = $this->p050_attendance_mod->MOD_GET_TIME_OUT($date,$user_id);
                $db_time_in_today = $this->p050_attendance_mod->MOD_GET_TIME_IN($date,$user_id);
        
                if(($db_time_out_prev[0]->time_out != "00:00:00") && ($db_time_in_prev[0]->time_in != "00:00:00")){
                    $prev_has_time_in = 'true';
                    $prev_has_time_out = 'true';
                    
                } else if (($db_time_in_prev[0]->time_in == "00:00:00") && ($db_time_out_prev[0]->time_out == "00:00:00")){
                    $prev_has_time_in = 'false';
                    $prev_has_time_out = 'false';
        
                } else if (($db_time_in_prev[0]->time_in == "00:00:00") && ($db_time_out_prev[0]->time_out != "00:00:00")){
                    $prev_has_time_in = 'false';
                    $prev_has_time_out = 'true';
        
                } else if (($db_time_in_prev[0]->time_in != "00:00:00") && ($db_time_out_prev[0]->time_out == "00:00:00")) {
                    $prev_has_time_in = 'true';
                    $prev_has_time_out = 'false';
                    $shift_name_yesterday = $shift_yesterday;
                }
                
                $time_in_prev = $db_time_in_prev[0]->time_in;
                $time_out_prev = $db_time_out_prev[0]->time_out;
                $time_in_prev = date('h:i A', strtotime($time_in_prev));
                $time_out_prev = date('h:i A', strtotime($time_out_prev));
        
            } else {
                
                $prev_has_time_in = '';
                $prev_has_time_out = '';
                
            }
    
    
        }
    }
    

    if(count($employee_dtr) > 0){
        foreach($employee_dtr as $employee_dtr_row){

            $time_in = $employee_dtr_row->time_in;
            $time_out = $employee_dtr_row->time_out;

            $time_in = date('h:i A', strtotime($time_in));
            $time_out = date('h:i A', strtotime($time_out));

            if($employee_dtr_row->time_in == '00:00:00'){
                $has_time_in = 'false';
            } else {
                $has_time_in = 'true';
            }

            if($employee_dtr_row->time_out == '00:00:00'){
                $has_time_out = 'false';
            } else {
                $has_time_out = 'true';
            }

            $shift_id = $employee_dtr_row->shift_id;
            if($shift_id){
                $shift_data = $this->p171_workshifts_mod->MOD_GET_WRK_SHFT_DATA($shift_id);
                $shift_name = '['.$shift_data[0]->code.'] '.$shift_data[0]->time_in.' - '.$shift_data[0]->time_out;
                $shift_color = $shift_data[0]->color;
            } else {
                $shift_name = 'Unassigned';
                $shift_color = '#6C757D';
            }
            
        }
    } else {
        $has_time_in = 'false';
        $has_time_out = 'false';
    }


    

?>

<div class="content-wrapper">
    <div class="flex-fill p-4">
        <div class="row">
            <div class="col-md-6">
                <h1 class="page-title">My Time Record</h1>
            </div>
            <div class="col-md-6 button-title">
                <button id="btn_att_summary" data-toggle="modal" data-target="#modal_attendance_summary" class="btn btn-primary shadow-none" disabled>View Summary</button>
            </div>
        </div>
        
        <hr>

        <div class="row">
            <div class="col-md-6">
                <div class="card" style="padding: 20px; ">
                    <p class="text-secondary text-bold text-center mb-0" style="font-size: 20px;">SHIFT TODAY</p>
                    <p class="text-secondary text-bold text-center mb-2" style="font-size: 17px;"><span style="font-size: 17px !important; color:<?= $shift_color ?>"><?= $shift_name ?></span></p>
                    
                    <?php 
                        if($shift_name_yesterday){
                            ?>
                                <p class="text-muted text-bold text-center mb-0" style="font-size: 15px;">Shift Yesterday</p>
                                <p class="text-muted text-bold text-center mb-0" style="font-size: 12px;"><span class="text-danger" style="font-size: 12px !important;"><?= $shift_name_yesterday ?></span></p>
                            <?php
                        } 
                    ?>
                    
                    <hr>
                    <div class="row pb-5 pt-4">
                        <div class="col-md-6 text-center">
                            <div class="icon elevation-1 mx-auto my-3">
                                <p id="icon_month" class="mb-0 text-center text-white" style="padding: 5.6px 0px; background-color: #FD9F1B;border-radius: 8px 8px 0px 0px;"><?= $month ?></p>
                                <p id="day" class="mb-0 text-bold text-center" style="font-size: 49px;"><?= $day ?></p>
                                <p id="today" class="mb-0 text-center pt-2" style="color: #FD9F1B; height: 25%; border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;"><?= $day_of_week ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="time_container" style="transform: translateY(40%);">
                                <p class="mb-0" style="font-size: 30px; font-family: 'Orbitron'" id="current_time"> </p>
                                <p class="mb-0" style="font-size: 30px; font-family: 'Orbitron'" id="current_phase"></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        
                        <?php 
                            $empl_data = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($this->session->userdata('SESS_USER_ID'));
                            if($empl_data[0]->remote_att == 1){
                        ?>

                                <?php 
                                    if($has_time_in == 'false'){
                                        if($prev_has_time_in && $prev_has_time_out){
                                            if((($prev_has_time_in == 'false') && ($prev_has_time_out == 'true')) || (($prev_has_time_in == 'true') && ($prev_has_time_out == 'true')) || (($prev_has_time_in == 'false') && ($prev_has_time_out == 'false'))){
                                                
                                                ?>
                                                    <div class="col-md-6 text-center" style="<?php if(($shift_name == 'Unassigned') || ($shift_name == '')){echo 'display:none';} ?>">
                                                        <a href="#" id="btn_time_in" class="btn btn-success">Time In</a>
                                                    </div>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                                <div class="col-md-6 text-center" style="<?php if(($shift_name == 'Unassigned') || ($shift_name == '')){echo 'display:none';} ?>">
                                                    <a href="#" id="btn_time_in" class="btn btn-success">Time In</a>
                                                </div>
                                            <?php
                                        }
                                    }
                                ?>

                                <?php 
                                    
                                    if($prev_has_time_in && $prev_has_time_out){
                                        if(($prev_has_time_in == 'true') && ($prev_has_time_out == 'false')){
                                            ?>
                                                <div class="col-md-6 text-center" style="<?php if(($shift_name == 'Unassigned') || ($shift_name == '')){echo 'display:none';} ?>">
                                                    <p class="text-success text-bold mb-1">TIME IN</p>
                                                    <p class="text-success text-bold "><?= $time_in_prev ?></p>
                                                </div>
                                            <?php
                                        } else if (($has_time_in == 'true') && ($has_time_out == 'false') || ($has_time_in == 'true') && ($has_time_out == 'true')){
                                            ?>
                                                <div class="col-md-6 text-center" style="<?php if(($shift_name == 'Unassigned') || ($shift_name == '')){echo 'display:none';} ?>">
                                                    <p class="text-success text-bold mb-1">TIME IN</p>
                                                    <p class="text-success text-bold "><?= $time_in ?></p>
                                                </div>
                                            <?php
                                        }
                                    } else {
                                        if($has_time_in == 'true'){
                                        ?>
                                            <div class="col-md-6 text-center" style="<?php if(($shift_name == 'Unassigned') || ($shift_name == '')){echo 'display:none';} ?>">
                                                <p class="text-success text-bold mb-1">TIME IN</p>
                                                <p class="text-success text-bold "><?= $time_in ?></p>
                                            </div> 
                                        <?php
                                        }
                                    }
                                ?>

                                <?php 
                                    if($prev_has_time_in && $prev_has_time_out){
                                        if((($has_time_in == 'true') && ($has_time_out == 'false')) || ($prev_has_time_in == 'true') && ($prev_has_time_out == 'false')){
                                            ?>
                                                <div class="col-md-6 text-center" style="<?php if(($shift_name == 'Unassigned') || ($shift_name == '')){echo 'display:none';} ?>">
                                                    <a href="#" id="btn_time_out" class="btn btn-danger">Time Out</a>
                                                </div>
                                            <?php
                                        } 
                                    } else {
                                        if(($has_time_in == 'true') && ($has_time_out == 'false')){
                                            ?>
                                                <div class="col-md-6 text-center" style="<?php if(($shift_name == 'Unassigned') || ($shift_name == '')){echo 'display:none';} ?>">
                                                    <a href="#" id="btn_time_out" class="btn btn-danger">Time Out</a>
                                                </div>
                                            <?php
                                        }
                                    }
                                ?>

                                <?php 
                                    if(($has_time_in == 'true') && ($has_time_out == 'true')){
                                        ?>
                                            <div class="col-md-6 text-center" style="<?php if(($shift_name == 'Unassigned') || ($shift_name == '')){echo 'display:none';} ?>">
                                                <p class="text-danger text-bold mb-1">TIME OUT</p>
                                                <p class="text-danger text-bold "><?= $time_out ?></p>
                                            </div>
                                        <?php
                                    }
                                ?>

                                <?php 
                                    if($shift_name == 'Unassigned'){
                                        ?>
                                            <div style="height: 48px;"></div>
                                        <?php
                                    }
                                ?>

                        <?php
                            }
                        ?>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="text-secondary text-bold">Daily Time Record</p>
                        </div>
                        <div class="col-sm-6">
                            <select name="cutoff_period" class="form-control" id="cutoff_period">
                                <?php
                                    if($DISP_PAYROLL_SCHED){
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
                                                $schedule_id = $DISP_PAYROLL_SCHED_ROW->id
                                        ?>
                                            <option value="<?= $schedule_id ?>" db_date="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>" payout="<?= $payout ?>" selected><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                                        <?php
                                            }
                                        ?>
                                            <option value="<?= $DISP_PAYROLL_SCHED_ROW->id ?>" db_date="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>" payout="<?= $payout ?>" ><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                                        <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" id="user_id" value="<?= $this->session->userdata('SESS_USER_ID') ?>">
                    <div style="height: 390px; overflow-y: scroll; overflow-x: hidden;">
                        <table class="table table-striped mb-0" id="attendance_tbl">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Shift</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                </tr>
                            </thead>
                            <tbody id="time_record_container">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="card" style="display: none;">
            <table class="table table-hover table-xs mb-0 hover-highlight" id="tbl_attendance" style="display: none;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>DOW</th>
                        <th style="display: none;">Employee</th>
                        <th>Day Code</th>
                        <th>Shift for the Day</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Status</th>
                        <th style="display: none;">Remarks</th>
                        <th>WD</th>
                        <th>NO TI/TO</th>
                        <th>RD_SP</th>
                        <th>REG_HOL</th>
                        <th>RD+REG_HOL</th>
                        <th>RD+SP</th>
                        <th>ABS</th>
                        <th>TARD</th>
                        <th>UT</th>
                        <th>REG_OT</th>
                        <th>ND</th>
                        <th>ND_OT</th>
                        <th>PD_L</th>
                        <th>Half</th>
                        <th>REST OT</th>
                        <th>REST ND OT</th>
                    </tr>
                </thead>
                <tbody id="cutoff_container">
                <tr>
                    <td colspan="23" class="text-center py-5" style="background-color: #f0f0f0;">No selected cut-off period</td>
                </tr>
                </tbody>
            </table>
            <div class="w-100 text-center">
            <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
            </div>
        </div>

    </div>
</div>

<form action="<?php echo base_url('attendance/employee_time_in'); ?>" id="form_time_in" method="post" accept-charset="utf-8" autocomplete='off'>
    <input type="hidden" name="empl_time_in" id="empl_time_in">
    <!-- get employee name -->
    <?php 
        if($DISP_EMPLOYEE_INFO){
            foreach($DISP_EMPLOYEE_INFO as $DISP_EMPLOYEE_INFO_ROW){
                ?>
                    <input type="hidden" name="empl_name" id="empl_name" value="<?= $DISP_EMPLOYEE_INFO_ROW->col_frst_name.' '.$DISP_EMPLOYEE_INFO_ROW->col_last_name ?>">
                <?php
            }
        }
    ?>
</form>
<form action="<?php echo base_url('attendance/employee_time_out'); ?>" id="form_time_out" method="post" accept-charset="utf-8" autocomplete='off'>
    <input type="hidden" name="empl_time_out" id="empl_time_out">
    <!-- get employee info and current date -->
    <?php 
        
            if($DISP_EMPLOYEE_INFO){
                foreach($DISP_EMPLOYEE_INFO as $DISP_EMPLOYEE_INFO_ROW2){
                
                    ?>
                        <input type="hidden" name="empl_id" id="out_empl_id" value="<?= $DISP_EMPLOYEE_INFO_ROW2->id ?>">
                        <input type="hidden" name="date" id="out_date" value="<?= date('Y-m-d') ?>">
                        <input type="hidden" name="prev_has_next_day" id="out_date" value="<?php if($employee_dtr_prev){if($employee_dtr_prev[0]->shift_id){echo $prev_has_next_day;}}  ?>">
                    <?php
                }
            }
    ?>
</form>


















<!-- =============== ATTENDANCE SUMMARY ================= -->
<div class="modal fade" id="modal_attendance_summary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Attendance Summary
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">

            <div class="row">
              <div class="col-lg-12">
                <div class="w-100 text-center">
                  <img src="<?= base_url() ?>user_images/default_profile_img3.png" id="employee_img_sum" class="rounded-circle avatar" style="width: 180px; margin-bottom: -60px; position:relative; z-index: 55;">
                  <div class="card mx-auto" style="height: 200px; width: 70%;position:relative; z-index: 2;">
                    <div style="padding-top: 60px;" class="pl-5 pr-5 ">
                      <p class="text-bold mb-0" style="font-size: 20px;" id="employee_name_sum">HrCare User</p>
                      <p class="text-primary text-bold" id="employee_position_sum">Employee</p>
                    </div>
                    <div class="pt-3 bg-secondary">
                      <label class="mb-2">Cut-off Period</label>
                      <p id="cutoff_period_sum">0</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <br>
            
            <div class="row justify-content-center mb-4 px-3">
              <div class="col-md-4 w-100 text-center">
                <p class="text-white px-3 py-1 mb-0 bg-success display_total" style="font-size: 15px;border-radius: 8px;">Working Days: &nbsp;<span id="total_working_days"></span></p>
              </div>
              <div class="col-md-4 w-100 text-center">
                <p class="text-white px-3 py-1 mb-0 bg-secondary display_total" style="font-size: 15px;border-radius: 8px;">Rest Days: &nbsp;<span id="total_rest_day"></span></p>
              </div>
              <div class="col-md-4 w-100 text-center">
                <p class="text-white px-3 py-1 mb-0 bg-danger display_total" style="font-size: 15px;border-radius: 8px;">Unassigned Shifts: &nbsp;<span id="total_unassigned_shift"></span></p>
              </div>
            </div>

            <div class="row justify-content-center mb-4 px-3">
              <div class="col-md-4 w-100 text-center">
                <p class="mb-0 px-3 py-1 mb-2 text-white bg-primary display_total" style="font-size: 15px;border-radius: 8px;"> Days Present: &nbsp;<span id="total_present"></span></p>
              </div>
              <div class="col-md-4 w-100 text-center">
                <p class="mb-0 px-3 py-1 mb-2 text-white bg-primary display_total" style="font-size: 15px;border-radius: 8px;">Days Absent: &nbsp;<span id="total_absent"></span></p>
              </div>
              <div class="col-md-4 w-100 text-center">
                <p class="mb-0 px-3 py-1 mb-2 text-white bg-primary display_total" style="font-size: 15px;border-radius: 8px;">Days Late: &nbsp;<span id="total_late"></span></p>
              </div>
            </div>
            
            

            <div id="attendance_count_container">

              <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px;">
                <span class="pl-3" style="font-size: 14px !important;">Basic</span>
              </div>
              <div class="card p-3">
                <div class="row px-3">
                  <div class="col-md-6">
                    <div class="row"><div class="col-9"><p>Actual Working days (Daily):</p></div>                 <div class="col-3">     <p class="float-right" id="work_days_sum">0</p>              </div></div>
                    <div class="row"><div class="col-9"><p>Special Holiday (Hourly):</p></div>                     <div class="col-3">     <p class="float-right" id="sp_hol_sum">0</p>             </div></div>
                    <div class="row"><div class="col-9"><p>Regular Holiday (Hourly):</p></div>                     <div class="col-3">     <p class="float-right" id="reg_hol_sum">0</p>           </div></div>
                    <div class="row"><div class="col-9"><p>Rest + OT (Hourly):</p></div>                           <div class="col-3">     <p class="float-right" id="rest_ot_sum">0</p>           </div></div>
                  </div>
                  <div class="col-md-6">
                    <div class="row"><div class="col-9"><p>No Time in / Time Out (Daily):</p></div>               <div class="col-3">     <p class="float-right" id="no_ti_to_sum">0</p>           </div></div>
                    <div class="row"><div class="col-9"><p>Rest + Special Holiday (Hourly):</p></div>              <div class="col-3">     <p class="float-right" id="rest_sp_hol_sum">0</p>          </div></div>
                    <div class="row"><div class="col-9"><p>Rest + Regular Holiday (Hourly):</p></div>              <div class="col-3">     <p class="float-right" id="rest_reg_hol_sum">0</p>        </div></div>
                    <div class="row"><div class="col-9"><p>Rest + Night Diff + OT (Hourly):</p></div>              <div class="col-3">     <p class="float-right" id="rest_nd_ot_sum">0</p>        </div></div>
                  </div>
                </div>
              </div>

              <br>
              
              <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px;">
                <span class="pl-3" style="font-size: 14px !important;">Absences /Tardiness /Undertime /Leave /Half Day</span>
              </div>
              <div class="card p-3">
                <div class="row px-3">
                  <div class="col-md-6">
                    <div class="row"><div class="col-9"><p>Absences (Daily):</p></div>        <div class="col-3">     <p class="float-right" id="absences_sum">0</p>              </div></div>
                    <div class="row"><div class="col-9"><p>Tardiness (Hourly):</p></div>       <div class="col-3">     <p class="float-right" id="tard_sum">0</p>                  </div></div>
                    <div class="row"><div class="col-9"><p>Paid Leave (Daily):</p></div>      <div class="col-3">     <p class="float-right" id="leave_sum">0</p>                  </div></div>
                  </div>
                  <div class="col-md-6">
                    <div class="row"><div class="col-9"><p>Undertime (Hourly):</p></div>       <div class="col-3">     <p class="float-right" id="undertime_sum">0</p>             </div></div>
                    <div class="row"><div class="col-9"><p>Half Day (Hourly):</p></div>        <div class="col-3">     <p class="float-right" id="half_day_sum">0</p>             </div></div>
                  </div>
                  <div class="col-md-4">
                    
                  </div>
                </div>
              </div>

              <br>
              
              <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px;">
                <span class="pl-3" style="font-size: 14px !important;">Calculated Night Differential & Overtime</span>
              </div>
              <div class="card p-3">
                <div class="row px-3">
                  <div class="col-md-4">
                    <div class="row"><div class="col-9"><p>Night Diff (Hourly):</p></div>                  <div class="col-3">     <p class="float-right" id="night_diff_sum">0</p>              </div></div>
                  </div>
                  <div class="col-md-4">
                    <div class="row"><div class="col-9"><p>Regular OT (Hourly):</p></div>                  <div class="col-3">     <p class="float-right" id="reg_ot_sum">0</p>           </div></div>
                  </div>
                  <div class="col-md-4">
                    <div class="row"><div class="col-9"><p>Night Shift OT (Hourly):</p></div>              <div class="col-3">     <p class="float-right" id="ns_ot_sum">0</p>        </div></div>
                  </div>
                </div>
              </div>

              <br>
              
              <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px;">
                <span class="pl-3" style="font-size: 14px !important;">Approved Night Differential & Overtime</span>
              </div>
              <div class="card p-3">
                <div class="row px-3">
                  <div class="col-md-4">
                    <div class="row"><div class="col-9"><p>Night Diff (Hourly):</p></div>                  <div class="col-3">     <p class="float-right" id="approved_night_diff_sum">0</p>              </div></div>
                  </div>
                  <div class="col-md-4">
                    <div class="row"><div class="col-9"><p>Regular OT (Hourly):</p></div>                  <div class="col-3">     <p class="float-right" id="approved_reg_ot_sum">0</p>           </div></div>
                  </div>
                  <div class="col-md-4">
                    <div class="row"><div class="col-9"><p>Night Shift OT (Hourly):</p></div>              <div class="col-3">     <p class="float-right" id="approved_ns_ot_sum">0</p>        </div></div>
                  </div>
                </div>
              </div>

              

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>














<aside class="control-sidebar control-sidebar-dark">
</aside>

<div id="sidebar-overlay"></div>
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
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
<!-- Full Calendar 2.2.5 -->
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>


<?php
if($this->session->userdata('session_error_time_in')){
?>
<script>
  Swal.fire(
    'Oops',
    '<?php echo $this->session->userdata('session_error_time_in'); ?>',
    'error'
  )
</script>
<?php
$this->session->unset_userdata('session_error_time_in');
}
?>

<?php
if($this->session->userdata('session_success_time_in')){
?>
<script>
  Swal.fire(
    'Success',
    '<?php echo $this->session->userdata('session_success_time_in'); ?>',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('session_success_time_in');
}
?>

<?php
if($this->session->userdata('session_success_time_out')){
?>
<script>
  Swal.fire(
    'Success',
    '<?php echo $this->session->userdata('session_success_time_out'); ?>',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('session_success_time_out');
}
?>

<?php
if($this->session->userdata('session_error_time_out')){
?>
<script>
  Swal.fire(
    'Oops!',
    '<?php echo $this->session->userdata('session_error_time_out'); ?>',
    'error'
  )
</script>
<?php
$this->session->unset_userdata('session_error_time_out');
}
?>




<script>
    setInterval(() => {
        var moment_current_date_time = moment().format('llll');
        var split_moment_current_date_time = moment_current_date_time.split(' ');
        var date = split_moment_current_date_time[0] + ' ' + split_moment_current_date_time[1] + ' ' + split_moment_current_date_time[2] + ' ' + split_moment_current_date_time[3];
        var time = moment().format('h:mm:ss');;
        var phase = split_moment_current_date_time[5];

        $('#current_time').text(time);
        $('#current_phase').text(phase);
    }, 10);

    $(document).ready(function(){

        var url_get_my_time_record_data = '<?= base_url() ?>attendance/get_my_time_record_data';
        var url_get_shift_data = '<?php echo base_url(); ?>attendance/get_shift_data';

        // ======================================= ATTENDANCE SUMMARY URL AJAX =================================
        var url_holiday = '<?php echo base_url(); ?>attendance/get_holiday_data';
        var url_update_status_remarks = '<?php echo base_url(); ?>attendance/update_status_remarks';
        var url_get_ready_for_payslip = '<?php echo base_url(); ?>attendance/get_ready_for_payslip';
        var url_get_not_ready_for_payslip = '<?php echo base_url(); ?>attendance/get_not_ready_for_payslip';
        var url_get_employee_data_via_cmid = '<?php echo base_url(); ?>attendance/get_employee_data_via_cmid';
        var url3 = '<?php echo base_url(); ?>attendance/get_work_shift_data';
        var url4 = '<?php echo base_url(); ?>attendance/get_shift_data';

        

        setTimeout(() => {
            // ===================== ACTIVATE DATATABLE PLUGIN =======================
            var empl_tbl = $('#attendance_tbl').DataTable({
                "paging": false,
                "searching": true,
                "ordering": true,
                "autoWidth": false,
                "info": false
            })
            $('#filter_employee').on( 'keyup', function () {
                empl_tbl.search( this.value ).draw();
            } );
            $('#attendance_tbl_filter').parent().parent().hide();
        }, 1500);


        function display_time_record(period){
            $('#time_record_container').html('');
            get_my_time_record_data(url_get_my_time_record_data, period).then(function(data){
                Array.from(data).forEach(function(x){
                    var date = x.date;
                    var time_in = x.time_in;
                    var time_out = x.time_out;
                    var shift_id = x.shift_id;

                    if(time_in == '00:00:00'){
                        time_in = 'NO TIME IN';
                    }

                    if(time_out == '00:00:00'){
                        time_out = 'NO TIME OUT';
                    }

                    if(shift_id){
                        get_shift_data(url_get_shift_data, shift_id).then(data1 => {
                            data1.forEach((x) => {
                                var shift_name = '['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out;
                                $('#time_record_container').append(`
                                    <tr>
                                        <td>`+date+`</td>
                                        <td>`+shift_name+`</td>` + 
                                        (time_in == 'NO TIME IN' ? `<td><span class="badge badge-light">` : `<td><span class="badge badge-success">`) +time_in+`</span></td>` +                          
                                        (time_out == 'NO TIME OUT' ? `<td><span class="badge badge-light">` : `<td><span class="badge badge-danger">`) +time_out+`</span></td>
                                    </tr>
                                `);
                            })
                        })
                    } else {
                        $('#time_record_container').append(`
                            <tr>
                                <td>`+date+`</td>` +
                                `<td>`+shift_id+`</td>` + 
                                (time_in == 'NO TIME IN' ? `<td><span class="badge badge-light">` : `<td><span class="badge badge-success">`) +time_in+`</span></td>` +                          
                                (time_out == 'NO TIME OUT' ? `<td><span class="badge badge-light">` : `<td><span class="badge badge-danger">`) +time_out+`</span></td>
                            </tr>
                        `);
                    }
                    
                })
            })
        }


        // ===================== DISPLAY TIME RECORD BASED ON CUTOFF PERIOD =======================
        var period = $('#cutoff_period option:selected').attr('db_date');
        display_time_record(period);

        $('#cutoff_period').change(function(){
            var date_period = $(this).find('option:selected').attr('db_date');
            $('#time_record_container').html('');

            display_time_record(date_period);
        })


        // ========================================= TIME IN ========================================
        $('#btn_time_in').click(function(){
            var time_in = moment().format('LTS');

            $('#empl_time_in').val(time_in);
            Swal.fire({
                title: 'Do you want to time in?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28A745',
                cancelButtonColor: '#DC3545',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_time_in').submit();
                }
            })
        })




        // ========================================= TIME OUT ========================================
        $('#btn_time_out').click(function(){
            var time_out = moment().format('LTS');

            $('#empl_time_out').val(time_out);
            Swal.fire({
                title: 'Do you want to time out?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28A745',
                cancelButtonColor: '#DC3545',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_time_out').submit();
                }
            })
        })











        // ================================== DISPLAY ATTENDANCE RECORD (HIDDEN) =====================================
        
        function load_attendance_data(employee_id, date_period){
            $('#btn_att_summary').prop('disabled', true);
            var url2 = '<?php echo base_url(); ?>attendance/get_employee_data';

            get_employee_data(url2, employee_id,date_period).then(data => {
                if($('#cutoff_period option:selected').attr('db_date')){
                $('#cutoff_container').html('');
                data.cutoff_data.forEach((x) => {
                    var status_color = '';
                    var remarks_color = '';
                    var cutoff_id = x.id;
                    var db_date = x.date;
                    var db_date = db_date.split(" ");
                    var date_period = moment(x.date).format('LL');
                    var day_of_work = moment(x.date).format('dddd');

                    var work_day = '';
                    var no_ti_to = '';
                    var rd_sp = '';
                    var reg_hol = '';
                    var rd_reg = '';
                    var rd_add_sp = '';
                    var abs = '';
                    var tard = '';
                    var ut = '';
                    var nd = '';
                    var reg_ot = '';
                    var ns_ot = '';
                    var paid_leave = '';
                    var half_day = '';
                    var rest_ot = '';
                    var rest_nd_ot = '';
                    var tr_bg_color = '';

                    var approved_night_diff = x.appr_night_diff;
                    var approved_reg_ot = x.appr_reg_ot;
                    var approved_ns_ot = x.appr_ns_ot;

                    var isApprove = x.approved;

                    if(x.work_day != 0){work_day = x.work_day;}
                    if(x.no_ti_to != 0){no_ti_to = x.no_ti_to;}
                    if(x.bp_sp_hol != 0){rd_sp = x.bp_sp_hol;}
                    if(x.bp_reg_hol != 0){reg_hol = x.bp_reg_hol;}
                    if(x.bp_reg_hol_rest != 0){rd_reg = x.bp_reg_hol_rest;}
                    if(x.bp_sp_rest != 0){rd_add_sp = x.bp_sp_rest;}
                    if(x.absent != 0){abs = x.absent;}
                    if(x.late != 0){tard = x.late;}
                    if(x.undertime != 0){ut = x.undertime;}

                    if((x.bp_reg_ns != 0) || (x.appr_night_diff != 0)){
                    nd = parseFloat(x.appr_night_diff).toFixed(2)+' ('+parseFloat(x.bp_reg_ns).toFixed(2)+')';
                    }
                    if((x.ot_reg != 0) || (x.appr_reg_ot != 0)){
                    reg_ot = parseFloat(x.appr_reg_ot).toFixed(2)+' ('+parseFloat(x.ot_reg).toFixed(2)+')';
                    }
                    if((x.ot_reg_ns != 0) || (x.appr_ns_ot != 0)){
                    ns_ot = parseFloat(x.appr_ns_ot).toFixed(2)+' ('+parseFloat(x.ot_reg_ns).toFixed(2)+')';
                    }

                    if(x.paid_leave != 0){paid_leave = x.paid_leave;}
                    if(x.half_day != 0){half_day = x.half_day;}
                    if(x.rest_ot != 0){rest_ot = x.rest_ot;}
                    if(x.rest_nd_ot != 0){rest_nd_ot = x.rest_nd_ot;}

                    

                    if(x.row_color){
                    tr_bg_color = x.row_color;
                    } else {
                    tr_bg_color = '#fff';
                    }

                    var db_shift_id = '';
                    if(x.shift_id){
                    db_shift_id = x.shift_id;
                    }

                    var db_shift_id = '';
                    if(x.shift_id){
                    db_shift_id = x.shift_id;
                    }

                    var db_status = '';
                    var db_remarks = '';
                    if(x.status){
                    db_status = x.status;
                    if(x.status == 'Present'){
                        status_color = 'black';
                    } else if (x.status == 'Absent'){
                        status_color = 'black';
                    } else if (x.status == 'Rest'){
                        status_color = 'black';
                    }
                    }
                    if(x.remarks){
                    db_remarks = x.remarks;
                    if(x.remarks == 'Late'){
                        remarks_color = 'black';
                    }
                    }

                    var db_time_in = '';
                    var db_time_out = '';

                    if(x.time_in != '00:00:00'){
                    db_time_in = x.time_in;
                    }

                    if(x.time_out != '00:00:00'){
                    db_time_out = x.time_out;
                    }

                    var empl_arr = [];
                    get_employee_data(url2, x.empl_id,$('#cutoff_period option:selected').attr('db_date')).then(data1 => {
                    data1.employee_data.forEach((x) => {
                        empl_arr.push(x.col_frst_name+" "+x.col_last_name);
                        empl_arr.push(x.id);
                    })

                    var holiday_arr = [];
                    get_holiday_data(url_holiday).then(data2 => {
                        data2.holiday.forEach((x) => {
                        holiday_arr.push(x.col_holi_date);
                        holiday_arr.push(x.col_holi_type);
                        })

                        var day_code = '';
                        if(holiday_arr.includes(db_date[0])){
                        var holi_index = holiday_arr.indexOf(db_date[0]);
                        holi_index++;

                        day_code = holiday_arr[holi_index];
                        } else {
                        day_code = 'Regular';
                        }

                        var shift_arr = [];
                        get_shift_data(url4, db_shift_id).then(data4 => {

                        data4.forEach((x) => {
                            shift_arr.push(x.code);
                            shift_arr.push(x.time_in);
                            shift_arr.push(x.time_out);
                            shift_arr.push(x.color);
                            shift_arr.push(x.next_day);
                            shift_arr.push(x.has_break);
                            shift_arr.push(x.night_shift);
                            shift_arr.push(x.day_shift_OT);
                            shift_arr.push(x.night_shift_OT);
                            shift_arr.push(x.work_hours);
                            shift_arr.push(x.time_out_ot);
                            shift_arr.push(x.id);
                        })

                        var shift_name = '';
                        if(shift_arr.length > 0){
                            var shift_code = shift_arr[0];
                            var shift_time_in = shift_arr[1];
                            var shift_time_out = shift_arr[2];
                            var shift_color = shift_arr[3];
                            var shift_next_day = shift_arr[4];
                            var shift_has_break = shift_arr[5];
                            var night_shift = shift_arr[6];
                            var day_shift_OT = shift_arr[7];
                            var night_shift_OT = shift_arr[8];
                            var work_hours = shift_arr[9];
                            var time_out_ot = shift_arr[10];
                            var shift_id = shift_arr[11];

                            shift_name = '['+shift_code+']'+' '+shift_time_in+' - '+shift_time_out;
                        }

                        $('#cutoff_container').append(`
                            <tr class="cutoff" style="cursor: pointer;background-color: `+tr_bg_color+`" data-toggle="modal" data-target="#modal_time_adjustment" att_shift_id="`+shift_id+`" approved="`+isApprove+`" att_id="`+cutoff_id+`" att_date="`+db_date+`" dow="`+day_of_work+`" att_empl_id="`+empl_arr[1]+`" att_empl_name="`+empl_arr[0]+`" att_shift="`+shift_name+`" att_shift_color="`+shift_color+`" att_time_in="`+db_time_in+`" att_time_out="`+db_time_out+`"  att_status="`+db_status+`" att_remarks="`+db_remarks+`">
                                <td attendance_date="`+db_date+`">`+db_date+`</td>
                                <td>`+day_of_work+`</td>
                                <td style="display: none;" empl_id="`+empl_arr[1]+`">`+empl_arr[0]+`</td>
                                <td>`+day_code+`</td>
                                <td class="shift_num" time_out_ot="`+time_out_ot+`" work_hours="`+work_hours+`" night_shift="`+night_shift+`" day_shift_OT="`+day_shift_OT+`" night_shift_OT="`+night_shift_OT+`" has_break="`+shift_has_break+`" next_day="`+shift_next_day+`" time_in="`+shift_time_in+`" time_out="`+shift_time_out+`" shift_id="`+db_shift_id+`">`+shift_name+`</td>
                                <td class="db_time_in" row_id="`+cutoff_id+`" >`+db_time_in+`</td>
                                <td class="db_time_out" row_id="`+cutoff_id+`" >`+db_time_out+`</td>
                                <td  style="font-weight: 600; color:`+status_color+`">`+db_status+`</td>
                                <td  style=" display:none; font-weight: 600; color:`+remarks_color+`">`+db_remarks+`</td>
                                <td >`+work_day+`</td>
                                <td >`+no_ti_to+`</td>
                                <td >`+rd_sp+`</td>
                                <td >`+reg_hol+`</td>
                                <td >`+rd_reg+`</td>
                                <td >`+rd_add_sp+`</td>
                                <td >`+abs+`</td>
                                <td >`+tard+`</td>
                                <td >`+ut+`</td>
                                <td  approved_reg_ot="`+approved_reg_ot+`">`+reg_ot+`</td>
                                <td  approved_night_diff="`+approved_night_diff+`">`+nd+`</td>
                                <td  approved_ns_ot="`+approved_ns_ot+`">`+ns_ot+`</td>
                                <td >`+paid_leave+`</td>
                                <td >`+half_day+`</td>
                                <td >`+rest_ot+`</td>
                                <td >`+rest_nd_ot+`</td>
                            </tr>
                        `);
                        is_executed = true;

                        // check if attendance calculation is already approved. If yes, disable calc and view button
                        if(isApprove > 0){
                            $('#btn_disapprove_attendance').prop('disabled', false);
                            $('#btn_calculate_attendance').prop('disabled', true);
                            $('#btn_approve_attendance').prop('disabled', true);
                            $('#copy_shift_toggle_modal').prop('disabled', true);
                            $('#apply_template_toggle_modal').prop('disabled', true);
                            $('.cutoff').each(function(){
                            $(this).attr('data-toggle','');
                            })
                        } else {
                            $('#btn_approve_attendance').prop('disabled', false);
                            $('#btn_disapprove_attendance').prop('disabled', true);
                            $('#btn_calculate_attendance').prop('disabled', false);
                            $('#copy_shift_toggle_modal').prop('disabled', false);
                            $('#apply_template_toggle_modal').prop('disabled', false);
                            $('.cutoff').each(function(){
                            $(this).attr('data-toggle','modal');
                            })
                        }
                        $('#btn_att_summary').prop('disabled', false);

                        
                        })
                    })
                    })
                })
                }
            })
        }

        $('#cutoff_period').change(function(){
            var employee_id = $('#user_id').val();
            var cutoff_period = $('#cutoff_period option:selected').attr('db_date');
            load_attendance_data(employee_id, cutoff_period);
        })

        //======================== AUTO LOAD ATTENDANCE RECORD (HIDDEN) - INITIAL =========================
        var initial_employee_id = $('#user_id').val();
        var initial_cutoff_period = $('#cutoff_period option:selected').attr('db_date');
        load_attendance_data(initial_employee_id, initial_cutoff_period); 
        

        












        var base_url = '<?= base_url(); ?>';
        var url2 = '<?php echo base_url(); ?>attendance/get_employee_data';
        // ======================================= VIEW ATTENDANCE SUMMARY -================================
        $('#btn_att_summary').click(function(){
            var empl_id = $('#user_id').val();
            var cutoff_period = $('#cutoff_period option:selected').attr('db_date');
            var split_cutoff_period = cutoff_period.split(' - ');

            // clear current values
            $('#total_working_days').html(0);
            $('#total_rest_day').html(0);
            $('#total_unassigned_shift').html(0);
            $('#total_present').html(0);
            $('#total_absent').html(0);
            $('#total_late').html(0);

            // count total working days
            var total_working_days_arr = [];
            var total_rest_day_arr = [];
            var total_unassigned_shift_arr = [];
            var total_present_arr = [];
            var total_absent_arr = [];
            var total_late_arr = [];

            if(split_cutoff_period[0] && split_cutoff_period[1] && empl_id){
                get_employee_data(url2, empl_id,cutoff_period).then(data => {

                // DEFINE ARRAY VARIABLES
                var work_days_arr = [];
                var sp_hol_arr = [];
                var reg_hol_arr = [];
                var no_ti_to_arr = [];
                var rest_sp_hol_arr = [];
                var rest_reg_hol_arr = [];
                var night_diff_arr = [];
                var reg_ot_arr = [];
                var ns_ot_arr = [];
                var absences_arr = [];
                var tard_arr = [];
                var undertime_arr = [];
                
                var appr_reg_ot_arr = [];
                var appr_night_diff_arr = [];
                var appr_nd_ot_arr = [];

                var leave_arr = [];
                var half_day_arr = [];

                var rest_ot_arr = [];
                var rest_nd_ot_arr = [];

                data.cutoff_data.forEach((x) => {
                    // PUSH VALUES TO ARRAY
                    work_days_arr.push(parseFloat(x.work_day));
                    sp_hol_arr.push(parseFloat(x.bp_sp_hol));
                    reg_hol_arr.push(parseFloat(x.bp_reg_hol));
                    no_ti_to_arr.push(parseFloat(x.no_ti_to));
                    rest_sp_hol_arr.push(parseFloat(x.bp_sp_rest));
                    rest_reg_hol_arr.push(parseFloat(x.bp_reg_hol_rest));
                    night_diff_arr.push(parseFloat(x.bp_reg_ns));
                    reg_ot_arr.push(parseFloat(x.ot_reg));
                    ns_ot_arr.push(parseFloat(x.ot_reg_ns));
                    absences_arr.push(parseFloat(x.absent));
                    tard_arr.push(parseFloat(x.late));
                    undertime_arr.push(parseFloat(x.undertime));

                    appr_reg_ot_arr.push(parseFloat(x.appr_reg_ot));
                    appr_night_diff_arr.push(parseFloat(x.appr_night_diff));
                    appr_nd_ot_arr.push(parseFloat(x.appr_ns_ot));

                    leave_arr.push(parseFloat(x.paid_leave));
                    half_day_arr.push(parseFloat(x.half_day));

                    rest_ot_arr.push(parseFloat(x.rest_ot));
                    rest_nd_ot_arr.push(parseFloat(x.rest_nd_ot));
                })

                // ADD ARRAY VALUES
                var work_days_total = work_days_arr.reduce(add_array_values);
                var sp_hol_total = sp_hol_arr.reduce(add_array_values);
                var reg_hol_total = reg_hol_arr.reduce(add_array_values);
                var no_ti_to_total = no_ti_to_arr.reduce(add_array_values);
                var rest_sp_hol_total = rest_sp_hol_arr.reduce(add_array_values);
                var rest_reg_hol_total = rest_reg_hol_arr.reduce(add_array_values);
                var night_diff_total = night_diff_arr.reduce(add_array_values);
                var reg_ot_total = reg_ot_arr.reduce(add_array_values);
                var ns_ot_total = ns_ot_arr.reduce(add_array_values);
                var absences_total = absences_arr.reduce(add_array_values);
                var tard_total = tard_arr.reduce(add_array_values);
                var undertime_total = undertime_arr.reduce(add_array_values);

                var appr_reg_ot_total = appr_reg_ot_arr.reduce(add_array_values);
                var appr_night_diff_total = appr_night_diff_arr.reduce(add_array_values);
                var appr_nd_ot_total = appr_nd_ot_arr.reduce(add_array_values);

                var leave_total = leave_arr.reduce(add_array_values);
                var half_day_total = half_day_arr.reduce(add_array_values);

                var rest_ot_total = rest_ot_arr.reduce(add_array_values);
                var rest_nd_ot_total = rest_nd_ot_arr.reduce(add_array_values);

                // APPEND TO TEXTS
                $('#work_days_sum').text(work_days_total.toFixed(2));
                $('#sp_hol_sum').text(sp_hol_total.toFixed(2));
                $('#reg_hol_sum').text(reg_hol_total.toFixed(2));
                $('#no_ti_to_sum').text(no_ti_to_total.toFixed(2));
                $('#rest_sp_hol_sum').text(rest_sp_hol_total.toFixed(2));
                $('#rest_reg_hol_sum').text(rest_reg_hol_total.toFixed(2));
                $('#night_diff_sum').text(night_diff_total.toFixed(2));
                $('#reg_ot_sum').text(reg_ot_total.toFixed(2));
                $('#ns_ot_sum').text(ns_ot_total.toFixed(2));
                $('#absences_sum').text(absences_total.toFixed(2));
                $('#tard_sum').text(tard_total.toFixed(2));
                $('#undertime_sum').text(undertime_total.toFixed(2));

                $('#approved_night_diff_sum').text(appr_night_diff_total.toFixed(2));
                $('#approved_reg_ot_sum').text(appr_reg_ot_total.toFixed(2));
                $('#approved_ns_ot_sum').text(appr_nd_ot_total.toFixed(2));

                $('#leave_sum').text(leave_total.toFixed(2));
                $('#half_day_sum').text(half_day_total.toFixed(2));

                $('#rest_ot_sum').text(rest_ot_total.toFixed(2));
                $('#rest_nd_ot_sum').text(rest_nd_ot_total.toFixed(2));

                data.employee_data.forEach((x) => {
                    $('#employee_name_sum').html(x.col_frst_name+" "+x.col_last_name);
                    $('#employee_position_sum').html(x.col_empl_posi);
                    $('#cutoff_period_sum').html(cutoff_period);
                    if(x.col_imag_path){
                        $('#employee_img_sum').attr('src',base_url+'user_images/'+x.col_imag_path);
                    } else {
                        $('#employee_img_sum').attr('src',base_url+'user_images/default_profile_img3.png');
                    }
                })
                
                $('.cutoff').each(function(){
                    // console.log($(this).children());

                    var status_data = $($(this).children()[7]).text();
                    var remarks_data = $($(this).children()[8]).text();
                    var shift_data = $($(this).children()[4]).text();
                    var split_shift_data = shift_data.split(' ');
                    var shift_code = split_shift_data[0];
                    var replace_str1 = shift_code.replace('[','');
                    var shift_code = replace_str1.replace(']','');

                    // count total working days
                    if((shift_code != 'REST') && (shift_code != 'NWS') && (shift_code != '')){
                    total_working_days_arr.push(1);
                    $('#total_working_days').text(total_working_days_arr.reduce(add_array_values));
                    };

                    // count total days on REST
                    if((shift_code == 'REST') || (shift_code == 'NWS')){
                    total_rest_day_arr.push(1);
                    $('#total_rest_day').text(total_rest_day_arr.reduce(add_array_values));
                    }

                    // count total unassigned shifts
                    if((shift_data == '') || (shift_data == ' ') || (shift_data == null)){
                    total_unassigned_shift_arr.push(1);
                    $('#total_unassigned_shift').text(total_unassigned_shift_arr.reduce(add_array_values));
                    }

                    // count days present
                    if(status_data == 'Present'){
                    total_present_arr.push(1);
                    $('#total_present').text(total_present_arr.reduce(add_array_values));
                    }

                    //count days absent
                    if(status_data == 'Absent'){
                    total_absent_arr.push(1);
                    $('#total_absent').text(total_absent_arr.reduce(add_array_values));
                    }

                    //count days absent
                    if(remarks_data == 'Late'){
                    total_late_arr.push(1);
                    $('#total_late').text(total_late_arr.reduce(add_array_values));
                    }
                })

                $('#total_working_days').text();
                })
            }
        })

        function add_array_values(a, b) {
        return a + b;
        }










        async function get_my_time_record_data(url,date_period){
            var formData = new FormData();
            formData.append('date_period', date_period);
            const response = await fetch(url, {
            method: 'POST',
            body: formData
            });
            return response.json();
        }

        async function get_shift_data(url,shift_id) {
            var formData = new FormData();
            formData.append('shift_id', shift_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }


        // =================================== STTENDANCE RECORD (HIDDEN) - ASYNC ================================================
        async function get_work_shift_data(url,template_id) {
            var formData = new FormData();
            formData.append('template_id', template_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_holiday_data(url) {
        var formData = new FormData();
        formData.append('shift_id', 'shift');
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        return response.json();
        }
        
        async function get_employee_data_via_cmid(url, empl_cmid) {
        var formData = new FormData();
        formData.append('empl_cmid', empl_cmid);
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        return response.json();
        }
        
        async function get_work_shift_data(url,template_id) {
        var formData = new FormData();
        formData.append('template_id', template_id);
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        return response.json();
        }

        async function get_cutoff_schedule_data(url,date) {
        var formData = new FormData();
        formData.append('cutoff_date_period', date);
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        return response.json();
        }
        
        async function get_employee_data(url,employee_id,date_period){
        var formData = new FormData();
        formData.append('employee_id', employee_id);
        formData.append('date_period', date_period);
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        return response.json();
        }

        
        async function get_attendance_data_based_id(url, attendance_id){
        var formData = new FormData();
        formData.append('attendance_id', attendance_id);
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