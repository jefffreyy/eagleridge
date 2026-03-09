<!DOCTYPE html>
<html lang="en">
<head>
    <!-- STANDARD 1: EROVOUTIKA HTML STANDARD CODE, DO NOT CHANGE -->
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <link rel="shortcut icon" href="<?=base_url()?>images/HrCare_title_icon.png" type="image/x-icon">
	<title>HRCare</title>


	<!-- STANDARD 2: EROVOUTIKA STANDARD CSS PLUGINS, DO NOT CHANGE -->
    <link rel="preconnect" href="https://fonts.gstatic.com"> <!-- For Font Lato initialization -->
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet"> <!-- For Font Lato initialization -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fontawesome-free/css/all.min.css"><!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> <!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css"><!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?= base_url(); ?>dist/css/adminlte.min.css"><!-- Theme style -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"><!-- Bootstrap --> 
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"><!-- Sweet Alert -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/toastr/toastr.min.css"><!-- Toastr -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css"><!-- iCheck bootstrap -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script> -->
    <script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>

    <!-- STANDARD 3: EROVOUTIKA EXTERNAL CSS, DO NOT CHANGE -->
    <link href="<?= base_url(); ?>css/head_styles.css" rel="stylesheet">

    <!-- button class
    btn-primary:  blue button design -->
</head>

<style>
    .nav-link:not(.nav_pill,.toggle_menu,.btn_notif):hover{
        background-color: rgba(0, 0, 0, 0.1) !important;
        color:#2e4765 !important;
    }

    .nav-link.active{
        background-color: #EEFFEE !important;
        color: #2e4765 !important;
    }

    li a i:not(.right){
        width: 40px !important;
        text-align:center;
        /* padding-right: 30px;
        padding-left: 10px; */
        margin-right:8px !important;
    }

    .firebase_dropdown{
        transition: 0.5s;
        height: 40px !important;
        border-top: 2px solid #2e4765 !important;
        margin-bottom: 0px !important;
        cursor: pointer;
    }
    
    .firebase_dropdown_open{
        transition: 0.5s;
        height: 40px !important;
        border-top: 2px solid #F2F2F2 !important;
        margin-bottom: 0px !important;
        cursor: pointer;
    }

    .badge {
        border-radius: 3.125rem!important;
        font-weight: 500;
        display: inline-block;
        padding: 0.4em 0.71111em;
        font-size: 11.7px !important;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.125rem;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }

    .navbar-badge {
        font-size: 0.8rem !important;
        font-weight: 300 !important;
        padding: 2px 6px !important;
        position: absolute !important;
        right: 5px !important;
        top: 9px !important;
    }

    .numberCircle {
    width: 22px;
    line-height: 22px;
    border-radius: 50%;
    text-align: center;
    font-size: 12px;
    color: white;
    background-color: red !important;
    }
    .nav-text{
        font-size: 16px; 
        color: #2e4765;
        font-weight: bold;
        font-family: Helvetica, sans-serif;
    }

    .light_bg{
        background-color: rgba(255, 255, 255, 0.1) !important;
    }

    .dropdown-toggle{
        cursor: pointer;
    }

    .nav-pills .nav-link{
        border-radius: 0px !important;
        color: #2e4765 !important;
    }

    .menu-open{
        background-color: rgba(255, 255, 255, 0.1) !important;
    }

    .settings_button{
        transition: 0.4s;
    }

    .settings_button:hover{
        transition: 0.4s;
        -ms-transform: rotate(40deg); /* IE 9 */
        transform: rotate(80deg);
        border-radius: 50px;
    }

    @media only screen and (max-width: 1010px){
        .navbar_full_width{
            display: none;
        }
        .profile_name{
            display: none;
        }
    }

    /* Erovoutika Internal CSS */
    @media 
	only screen and (max-width: 992px)
	{ 
		.sms_buttons{
			width: 100% !important;
			text-align: center !important;
			margin-top: 10px;
		}
		.sms_length{
			width: 100% !important;
			text-align: center !important;
			margin-top: 5px !important;
		}
		.sms_length_container{
			margin-top: 10px !important;
		}
		.quick_section_right{
			padding: 0px !important;
		}
		.message_counter{
			display: block;
		}
	} 

    @media 
	only screen and (max-width: 500px)
	{ 
		#sidebar-overlay{
            z-index: 1000 !important;
        }

        #username_nav{
            display: none;
        }

        .dropdown-toggle{
            position: fixed;
            right: 15px;
            top: 13px;
            font-size: 18px;
        }

        .dropdown-menu{
            top: 13px !important;
            font-size: 18px !important;
        }
	} 

    .guides{
        padding: 10px;
    }
    .guides:hover{
        color: #0D74BC !important;
        background-color: #eaeaea !important;
        border-radius: 8px;
    }
    .spinner-border {
        width: 10px; 
        height: 10px;
    }

    #btn_notif i:hover{
        color: #0D74BC !important;
    }

    li a i:not(.right) {
        margin-right: 0px !important;
    }
    .sticky {
    position: -webkit-sticky; /* Safari */
    position: sticky;
    top: 0;
    }
    
</style>

<?php 
    //get the url
    $url_count = $this->uri->total_segments();
    $url_directory = $this->uri->segment($url_count);
    $url_directory_sub = $this->uri->segment($url_count-1);

    $user_info = $this->login_model->get_user_info($this->session->userdata('SESS_USER_ID'));
    $FirstName='';
    $LastName='';
    $Fullname='';
    $User_img='';
    $User_access='';
    $Username='';
    $Group='';
    $User_cmid ='';
    $User_type='';
    $position='';
    
    foreach($user_info as $info)
    {
        $User_img = $info->col_imag_path;
        $FirstName = $info->col_frst_name;
        $LastName = $info->col_last_name;
        $Fullname = $info->col_frst_name.' '.$info->col_last_name;
        $User_access = $info->col_user_access;
        $Username = $info->col_user_name;
        $Group = $info->col_empl_group;
        $User_cmid = $info->col_empl_cmid;
        $User_type = $info->col_user_type;
        $position = $info->col_empl_posi;
    }



    $DISP_PAYROLL_SCHED = $this->login_model->mod_disp_pay_sched();
    $db_cutoff_id = '';
    $cutoff_period = '';
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
                $cutoff_period = $DISP_PAYROLL_SCHED_ROW->db_name;
                // echo $cutoff_period;
            } else {
                
            }
        }

    }








?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style=" margin-bottom: -50px; width: 100%;border-bottom: 1px solid #e2e2e2;">

            <label for="check">
            </label>
            
            <div style="background-color:#fff !important;">
                <!-- Left top navbar links -->
                <div class="navbar-nav navbar_collapse row " id="sidebar_toggle_btn_container" style="width: 100vw">
                    <div class= "col-2">
                        <a class="nav-link toggle_menu" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </div>
                    <div class= "col-8">
                        <center><img src="<?= base_url(); ?>images/bandai_logo_header.webp" style="height: 40px;"></center>
                    </div>
                    <div class = "col-2">

                        <li class="nav-item dropdown dropdown-user">
                            <a class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                                <span class="font-weight-bold" id="username_nav" style="margin-left: -10px;"><?php if($FirstName){echo $FirstName.' '.$LastName;}else{echo 'Juan';}?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- <a class="dropdown-item" href="<?=base_url()?>profile">
                                    <i class="fa fas fa-user"></i>My Info
                                </a>
                                <div class="dropdown-divider"></div> -->
                                <a class="dropdown-item" href="<?=base_url()?>login/sign_out">
                                    <i class="fa fas fa-power-off"></i>Log Out
                                </a>
                            </div>
                        </li>

                    </div>

                    </div>

                </div>
                
                <!-- Left top navbar links -->
                <ul class="navbar-nav navbar_full_width" style="width: 100vw !important;">
                    <li class="nav-item">
                        <a class="nav-link toggle_menu" data-widget="pushmenu" href="#" style="cursor: default;" role="button"></a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="guides" href="<?= base_url() ?>home/guides">
                            <i class="fas fa-question-circle"></i>View Guides
                        </a>
                    </li>
                    
                    <li class="nav-item mt-2">
                        <a class="guides" href="https://docs.google.com/spreadsheets/u/1/d/e/2PACX-1vTS0KxvdaTaCyIum-OpemmhAaYau8hwr-hCvUVOlVmXQU7Iza365hYfGN22Uwo1yA/pubhtml" target="_blank">
                            <i class="fas fa-cogs"></i>Patch Updates
                        </a>
                    </li>

                    <!-- <li class="nav-item mt-2">
                        <a class="guides" href="<?= base_url() ?>patch">
                            <i class="fas fa-cogs"></i>Patch Updates
                        </a>
                    </li> -->
                    <li class="nav-item p-0">
                        <!-- <img src="<?= base_url(); ?>images/bandai_logo.png" style="heigth: 140px; width: 140px;"> -->
                    </li>
                    <form class="form-inline" style="margin-left: auto; margin-right: 300px;">

                        <!-- NOTIFICATION - APPLICATION -->
                        <!-- Show notif count if application was approved/rejected -->
                        <!-- Add per application request -->

                        <?php

                            $count_notif_appl = 0;
                            $app_notif_info = $this->login_model->mod_disp_application_notif($this->session->userdata('SESS_USER_ID'));
                            if($app_notif_info){
                                foreach($app_notif_info as $app_notif_info_row){
                                    if($app_notif_info_row->notif_status != 1){
                                        if($app_notif_info_row->type == "Leave"){
                                            $my_leave_app_info = $this->login_model->mod_check_leave_application_status($app_notif_info_row->application_id);
                                            if(count($my_leave_app_info) > 0){
                                                $my_leave_appl_status1 = $my_leave_app_info[0]->col_leave_status1;
                                                $my_leave_appl_status2 = $my_leave_app_info[0]->col_leave_status2;
                                                $my_leave_appl_status3 = $my_leave_app_info[0]->col_leave_status3;
    
                                                if( ($my_leave_appl_status1 == "Approved") && ($my_leave_appl_status2 == "Approved") && ($my_leave_appl_status3 == "Approved") ){
                                                    $count_notif_appl++;
                                                }
    
                                                if( ($my_leave_appl_status1 == "Rejected") || ($my_leave_appl_status2 == "Rejected") || ($my_leave_appl_status3 == "Rejected") ){
                                                    $count_notif_appl++;
                                                }
    
                                            }
                                        }
    
                                        if($app_notif_info_row->type == "Overtime"){
                                            $my_ot_app_info = $this->login_model->mod_check_ot_application_status($app_notif_info_row->application_id);
                                            if(count($my_ot_app_info) > 0){
                                                $my_ot_appl_status1 = $my_ot_app_info[0]->status1;
                                                $my_ot_appl_status2 = $my_ot_app_info[0]->status2;
    
                                                if( ($my_ot_appl_status1 == "Approved") && ($my_ot_appl_status2 == "Approved") ){
                                                    $count_notif_appl++;
                                                }
    
                                                if( ($my_ot_appl_status1 == "Rejected") || ($my_ot_appl_status2 == "Rejected") ){
                                                    $count_notif_appl++;
                                                }
                                            }
                                        }
    
                                        if($app_notif_info_row->type == "Time Adjustment"){
                                            $my_adj_app_info = $this->login_model->mod_check_time_adj_application_status($app_notif_info_row->application_id);
                                            if(count($my_adj_app_info) > 0){
                                                $my_adj_appl_status1 = $my_adj_app_info[0]->status1;
                                                $my_adj_appl_status2 = $my_adj_app_info[0]->status2;
    
                                                if( ($my_adj_appl_status1 == "Approved") && ($my_adj_appl_status2 == "Approved") ){
                                                    $count_notif_appl++;
                                                }
    
                                                if( ($my_adj_appl_status1 == "Rejected") || ($my_adj_appl_status2 == "Rejected") ){
                                                    $count_notif_appl++;
                                                }
                                            }
                                        }
                                    }

                                }
                            }
                            
                        ?>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link btn_notif" data-toggle="dropdown" href="#" aria-expanded="false">
                                Applications
                                <i class="far fa-bell" style="font-size: 16px;"></i>
                                <?php
                                    if($count_notif_appl > 0){
                                        ?>
                                            <span class="badge badge-warning navbar-badge"><?= $count_notif_appl ?></span>
                                        <?php
                                    }
                                ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="appl_notif" style="left: inherit; right: 0px;width: 500px;">
                                <span class="dropdown-item dropdown-header "><?= $count_notif_appl ?> Applications</span>

                                <div class="dropdown-divider"></div>

                                <div id="appl_notif_container" style=" max-height: 426px; overflow-y: scroll;">

                                    <?php
                                        if($app_notif_info){
                                            foreach($app_notif_info as $app_notif_info_row){
                                                $application_type = $app_notif_info_row->type;
                                                $date_requested = date('M j,Y g:m A', strtotime($app_notif_info_row->date_created));
                                                
                                                
                                                $empl_info_appl = $this->login_model->get_user_info($app_notif_info_row->empl_id);

                                                $empl_img_appl = '';
                                                $empl_fullname_appl = '';
                                                
                                                if($empl_info_appl){
                                                    $empl_img_appl = $empl_info_appl[0]->col_imag_path;
                                                    $empl_fullname_appl = $empl_info_appl[0]->col_frst_name.' '.$empl_info_appl[0]->col_last_name;
                                                }

                                                $application_status = '';
                                                $application_href = '';

                                                if($app_notif_info_row->type == "Leave"){
                                                    $application_href = base_url().'leave/my_leave';
                                                    $my_leave_app_info = $this->login_model->mod_check_leave_application_status($app_notif_info_row->application_id);
                                                    if(count($my_leave_app_info) > 0){
                                                        $my_leave_appl_status1 = $my_leave_app_info[0]->col_leave_status1;
                                                        $my_leave_appl_status2 = $my_leave_app_info[0]->col_leave_status2;
                                                        $my_leave_appl_status3 = $my_leave_app_info[0]->col_leave_status3;
            
                                                        if( ($my_leave_appl_status1 == "Approved") && ($my_leave_appl_status2 == "Approved") && ($my_leave_appl_status3 == "Approved") ){
                                                            $application_status = 'Approved';
                                                        }
            
                                                        if( ($my_leave_appl_status1 == "Rejected") || ($my_leave_appl_status2 == "Rejected") || ($my_leave_appl_status3 == "Rejected") ){
                                                            $application_status = 'Rejected';
                                                        }
                                                    }
                                                }
            
                                                if($app_notif_info_row->type == "Overtime"){
                                                    $application_href = base_url().'attendance/my_overtime';
                                                    $my_ot_app_info = $this->login_model->mod_check_ot_application_status($app_notif_info_row->application_id);
                                                    if(count($my_ot_app_info) > 0){
                                                        $my_ot_appl_status1 = $my_ot_app_info[0]->status1;
                                                        $my_ot_appl_status2 = $my_ot_app_info[0]->status2;

                                                        if( ($my_ot_appl_status1 == "Approved") && ($my_ot_appl_status2 == "Approved") ){
                                                            $application_status = 'Approved';
                                                        }

                                                        if( ($my_ot_appl_status1 == "Rejected") || ($my_ot_appl_status2 == "Rejected") ){
                                                            $application_status = 'Rejected';
                                                        }
                                                    }
                                                }
            
                                                if($app_notif_info_row->type == "Time Adjustment"){
                                                    $application_href = base_url().'attendance/my_time_adjustment';
                                                    $my_adj_app_info = $this->login_model->mod_check_time_adj_application_status($app_notif_info_row->application_id);
                                                    if(count($my_adj_app_info) > 0){
                                                        $my_adj_appl_status1 = $my_adj_app_info[0]->status1;
                                                        $my_adj_appl_status2 = $my_adj_app_info[0]->status2;

                                                        if( ($my_adj_appl_status1 == "Approved") && ($my_adj_appl_status2 == "Approved") ){
                                                            $application_status = 'Approved';
                                                        }

                                                        if( ($my_adj_appl_status1 == "Rejected") || ($my_adj_appl_status2 == "Rejected") ){
                                                            $application_status = 'Rejected';
                                                        }
                                                    }
                                                }

                                                if(($application_status == "Approved") || ($application_status == "Rejected")){

                                                    if($app_notif_info_row->notif_status != 1){
                                                        ?>
                                                            <a href="<?= $application_href ?>" class="dropdown-item">
                                                                <div class="d-flex" >
                                                                    <div class="mr-2 p-1"  >
                                                                        <img class="rounded-circle avatar " width="32" height="32" src="<?= base_url() ?>user_images/<?= $empl_img_appl ?>">
                                                                    </div>
                                                                    
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-secondary" style="font-size: 12px !important;"><?= $application_type ?> Application: <span class="text-<?php if($application_status == 'Approved'){ echo 'success';} else if($application_status == 'Rejected'){ echo 'danger';} ?>" style="font-size: 12px !important;"><?= $application_status ?></span></p>
                                                                        <span class="text-secondary" style="font-size: 12px !important;">Date Requested: <?= $date_requested ?></span>
                                                                        <!-- <span class="text-secondary" style="font-size: 12px !important;">Leave Type: Vacation (10 Days)</span> -->
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                </div>

                                <a href="#" id="see_all_appl_notif" class="dropdown-item dropdown-footer">See All Applications</a>
                            </div>
                        </li>


                        <!-- NOTIFICATION - APPROVAL -->
                        <!-- Show if Supervisor/HR/Admin -->

                        <?php
                        
                            $count_notif = 0;
                            $notif_info = $this->login_model->mod_disp_notif();
                            if($notif_info){
                                foreach($notif_info as $notif_info_row){
                                    if($notif_info_row->reciever){
                                        $split_notif_reciever = explode(',',$notif_info_row->reciever);
                                        if(in_array($this->session->userdata('SESS_USER_ID'), $split_notif_reciever)){
                                            
                                            $isApprover3 = $this->login_model->mod_check_if_approver3($this->session->userdata('SESS_USER_ID'));

                                            if($notif_info_row->appr_type == "Leave"){
                                                $leave_application_info = $this->login_model->mod_check_leave_application_status($notif_info_row->application_id);
                                                if(count($leave_application_info) > 0){
                                                    $status1 = $leave_application_info[0]->col_leave_status1;
                                                    $status2 = $leave_application_info[0]->col_leave_status2;
                                                    $status3 = $leave_application_info[0]->col_leave_status3;

                                                    if( ($status1 == "Pending Approval") || ($status2 == "Pending Approval") || ($status3 == "Pending Approval") ){
                                                        if( ($status1 == "Rejected") || ($status2 == "Rejected") || ($status3 == "Rejected") ){
                                                            // some action to notif if rejected
                                                        } else {
                                                            if(count($isApprover3) > 0){
                                                                $empl_group = $notif_info_row->empl_group;
                                                                if($empl_group == "STAFF"){
                                                                    $count_notif++;
                                                                }
                                                            } else {
                                                                $count_notif++;
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            if($notif_info_row->appr_type == "Overtime"){
                                                $ot_application_info = $this->login_model->mod_check_ot_application_status($notif_info_row->application_id);
                                                if(count($ot_application_info) > 0){
                                                    $status1 = $ot_application_info[0]->status1;
                                                    $status2 = $ot_application_info[0]->status2;

                                                    if( ($status1 == "Pending") || ($status2 == "Pending") ){
                                                        if( ($status1 == "Rejected") || ($status2 == "Rejected") ){
                                                            // some action to notif if rejected
                                                        } else {
                                                            if(count($isApprover3) > 0){
                                                                $empl_group = $notif_info_row->empl_group;
                                                                if($empl_group == "STAFF"){
                                                                    $count_notif++;
                                                                }
                                                            } else {
                                                                $count_notif++;
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            if($notif_info_row->appr_type == "Time Adjustment"){
                                                $time_adj_application_info = $this->login_model->mod_check_time_adj_application_status($notif_info_row->application_id);
                                                if(count($time_adj_application_info) > 0){
                                                    $status1 = $time_adj_application_info[0]->status1;
                                                    $status2 = $time_adj_application_info[0]->status2;

                                                    if( ($status1 == "Pending") || ($status2 == "Pending") ){
                                                        if( ($status1 == "Rejected") || ($status2 == "Rejected") ){
                                                            // some action to notif if rejected
                                                        } else {
                                                            if(count($isApprover3) > 0){
                                                                $empl_group = $notif_info_row->empl_group;
                                                                if($empl_group == "STAFF"){
                                                                    $count_notif++;
                                                                }
                                                            } else {
                                                                $count_notif++;
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                        }
                                    }
                                }
                            }
                        ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link btn_notif" data-toggle="dropdown" href="#" aria-expanded="false">
                                Approvals
                                <i class="far fa-bell" style="font-size: 16px;"></i>
                                <?php
                                    if($count_notif > 0){
                                        ?>
                                            <span class="badge badge-warning navbar-badge"><?= $count_notif ?></span>
                                        <?php
                                    }
                                ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="approval_notif" style="left: inherit; right: 0px;width: 500px;">
                                <span class="dropdown-item dropdown-header "><?= $count_notif ?> Approval Requests</span>

                                <div class="dropdown-divider"></div>

                                <div id="appr_notif_container" style=" max-height: 426px; overflow-y: scroll;">

                                    <?php
                                        $count_notif = 0;
                                        $notif_info = $this->login_model->mod_disp_notif();
                                        if($notif_info){
                                            foreach($notif_info as $notif_info_row){

                                                $show_notif = false;

                                                if($notif_info_row->reciever){
                                                
                                                    $split_notif_reciever = explode(',',$notif_info_row->reciever);
                                                    if(in_array($this->session->userdata('SESS_USER_ID'), $split_notif_reciever)){
                                                        $isApprover3 = $this->login_model->mod_check_if_approver3($this->session->userdata('SESS_USER_ID'));

                                                        $empl_group = $notif_info_row->empl_group;

                                                        $empl_info = $this->login_model->get_user_info($notif_info_row->empl_id);
                                                        
                                                        $empl_name = '';
                                                        if($empl_info){
                                                            foreach($empl_info as $empl_info_row){
                                                                if($empl_info_row->col_imag_path){
                                                                    $empl_img_requestor = $empl_info_row->col_imag_path;
                                                                }
                                                                if(!empty($empl_info_row->col_midl_name)){
                                                                    $midl_ini = $empl_info_row->col_midl_name[0].'.';
                                                                }else{
                                                                    $midl_ini = '';
                                                                }
                                                                $empl_name = $empl_info_row->col_empl_cmid.' - '.$empl_info_row->col_last_name.', '.$empl_info_row->col_frst_name.' '.$midl_ini;

                                                            }
                                                        }

                                                        $requestor_info = $this->login_model->get_user_info($notif_info_row->requested_by);
                                                        $empl_img_requestor = 'default_profile_img2.png';
                                                        if($requestor_info){
                                                            foreach($requestor_info as $requestor_info_row){
                                                                if($requestor_info_row->col_imag_path){
                                                                    $empl_img_requestor = $requestor_info_row->col_imag_path;
                                                                } 
                                                            }
                                                        }

                                                        $notif_href = '#';
                                                        if($notif_info_row->appr_type == 'Leave'){
                                                            $notif_href = base_url().'approval/approval_list';
                                                            $leave_application_info = $this->login_model->mod_check_leave_application_status($notif_info_row->application_id);
                                                            if(count($leave_application_info) > 0){
                                                                $status1 = $leave_application_info[0]->col_leave_status1;
                                                                $status2 = $leave_application_info[0]->col_leave_status2;
                                                                $status3 = $leave_application_info[0]->col_leave_status3;

                                                                if( ($status1 == "Pending Approval") || ($status2 == "Pending Approval") || ($status3 == "Pending Approval") ){
                                                                    if( ($status1 == "Rejected") || ($status2 == "Rejected") || ($status3 == "Rejected") ){
                                                                        // some action to notif if rejected
                                                                    } else {
                                                                        if(count($isApprover3) > 0){
                                                                            $empl_group = $notif_info_row->empl_group;
                                                                            if($empl_group == "STAFF"){
                                                                                $show_notif = true;
                                                                            }
                                                                        } else {
                                                                            $show_notif = true;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        if($notif_info_row->appr_type == 'Overtime'){
                                                            $notif_href = base_url().'approval/approval_list_overtime';
                                                            $ot_application_info = $this->login_model->mod_check_ot_application_status($notif_info_row->application_id);
                                                            if(count($ot_application_info) > 0){
                                                                $status1 = $ot_application_info[0]->status1;
                                                                $status2 = $ot_application_info[0]->status2;

                                                                if( ($status1 == "Pending") || ($status2 == "Pending") ){
                                                                    if( ($status1 == "Rejected") || ($status2 == "Rejected") ){
                                                                        // some action to notif if rejected
                                                                    } else {
                                                                        if(count($isApprover3) > 0){
                                                                            $empl_group = $notif_info_row->empl_group;
                                                                            if($empl_group == "STAFF"){
                                                                                $show_notif = true;
                                                                            }
                                                                        } else {
                                                                            $show_notif = true;
                                                                        }
                                                                    }
                                                                }

                                                            }
                                                        }
                                                        if($notif_info_row->appr_type == 'Time Adjustment'){
                                                            $notif_href = base_url().'approval/approval_list_time_adjustment';
                                                            $time_adj_application_info = $this->login_model->mod_check_time_adj_application_status($notif_info_row->application_id);
                                                            if(count($time_adj_application_info) > 0){
                                                                $status1 = $time_adj_application_info[0]->status1;
                                                                $status2 = $time_adj_application_info[0]->status2;

                                                                if( ($status1 == "Pending") || ($status2 == "Pending") ){
                                                                    if( ($status1 == "Rejected") || ($status2 == "Rejected") ){
                                                                        // some action to notif if rejected
                                                                    } else {
                                                                        if(count($isApprover3) > 0){
                                                                            $empl_group = $notif_info_row->empl_group;
                                                                            if($empl_group == "STAFF"){
                                                                                $show_notif = true;
                                                                            }
                                                                        } else {
                                                                            $show_notif = true;
                                                                        }
                                                                    }
                                                                }

                                                            }
                                                        }

                                                        if($show_notif){
                                                            ?>
                                                                <a href="<?= $notif_href ?>" class="dropdown-item">
                                                                    <div class="d-flex" >
                                                                        <div class="mr-2 p-1"  >
                                                                            <img class="rounded-circle avatar " width="32" height="32" src="<?= base_url() ?>user_images/<?= $empl_img_requestor ?>">
                                                                        </div>
                                                                        
                                                                        <div class="flex-grow-1">
                                                                            <p class="text-secondary" style="font-size: 12px !important;"><?= $notif_info_row->message ?></p>
                                                                            <span style="font-size: 13px !important;"><?= $empl_name ?></span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                            <?php
                                                        }
                                                            
                                                    }
                                                }
                                            }
                                        }
                                    ?>

                                </div>
                                
                                <a href="#" class="dropdown-item dropdown-footer" id="see_all_appr_notif">See All Requests</a>
                            </div>
                        </li>



                        <li class="nav-item dropdown dropdown-user">
                            
                            <!-- <a class="navbar-nav-link" id="btn_notif" href="#" >
                                <span class="badge badge-danger p-1 text-bold" style="margin-right: -18px; margin-top: -8px; position: absolute; z-index: 99;">67</span>
                                <i class="fas fa-bell text-secondary" style="font-size: 20px;"></i>
                            </a> -->
                            | &nbsp;
                            <a class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                                <span class="font-weight-bold"><?php if($FirstName){echo $FirstName.' '.$LastName;}else{echo 'Session Expired';}?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item mt-3" href="https://docs.google.com/spreadsheets/u/1/d/e/2PACX-1vTS0KxvdaTaCyIum-OpemmhAaYau8hwr-hCvUVOlVmXQU7Iza365hYfGN22Uwo1yA/pubhtml" targat="_blank">
                                    <i class="fas fa-cogs"></i>Patch Updates
                                </a>
                                <a class="dropdown-item mt-3" href="<?=base_url()?>login/sign_out">
                                    <i class="fa fas fa-power-off"></i>Log Out
                                </a>
                            </div>
                        </li>
                    </form>
                </ul>
            </div>
            
            <!-- Main Sidebar Container -->
            <!-- <aside class="main-sidebar elevation-3" style="background-color: #1279bf !important;margin-top: 54px;"> -->
            <aside class="main-sidebar elevation-3" style="background-color: #FFFFFF !important; background-size: contain; background-repeat: no-repeat; background-position-y: 35rem;">
                
                <div class="sidebar os-host os-theme-light os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-scrollbar-vertical-hidden os-host-transition"><div class="os-resize-observer-host observed"><div class="os-resize-observer" style="left: 0px; right: auto;"></div></div><div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer"></div></div><div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 567px;"></div><div class="os-padding"><div class="os-viewport os-viewport-native-scrollbars-invisible"><div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                <div class="w-100 text-center pt-2">
                    <img src="<?= base_url(); ?>images/bandai_logo_header.webp" style="heigth: 140px; width: 140px; !important; padding-top: 10px">
                </div>
                <!-- Sidebar Menu -->
                <nav style="margin-top: 20px;">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        
                        <li class="nav-item">
                            <div class="d-flex" style="border-top: 1px solid #F2F2F2 !important;">
                                <a href="<?=base_url();?>home" class='nav-link <?php if($url_directory == 'home') { echo 'active'; } ?>' style="height: 60px !important;width: 190px !important;">
                                    <div style="transform: translateY(45%);">
                                        <i class='nav-icon fas fa-home mx-0'></i><p class = "nav-text">Home</p>
                                    </div>
                                </a>

                                <?php 
                                    if(($User_access == 2) || ($User_access == 3) || ($User_access == 4)){
                                        ?>
                                            <a href="<?=base_url()?>settings" class="flex-fill p-0 text-center settings_button <?php if(($url_directory == 'settings')) { echo 'light_bg'; } ?>" style="height: auto;font-size: 18px !important;">
                                                <i class="fas fa-cog" style="transform: translateY(100%); margin-right: 0px !important; color: #2e4765 !important;"></i>
                                            </a>
                                        <?php
                                    }
                                ?>
                                
                            </div>
                        </li>

                
                        <!-- <li class="nav-item">
                            <div style="border-top: 1px solid #F2F2F2 !important;">
                                <a href="<?=base_url();?>home" class='nav-link <?php if($url_directory == 'home') { echo 'active'; } ?>' style="height: 60px !important;">
                                    <div style="transform: translateY(45%);">
                                        <i class='nav-icon fas fa-question-circle mx-0'></i><p style="font-size: 16px; color: #2e4765 !important;">Guides</p>
                                    </div>
                                </a>
                            </div>
                        </li> -->


                        <!-- ALL USERS -->
                        <?php
                            if($Username != 'bwpaccounting'){
                                $position_info = $this->login_model->mod_get_position_info($position);
                                if($position_info){
                                    foreach($position_info as $position_info_row){
                                        $user_access = $position_info_row->user_access;
                                        $user_access_arr = explode(',', $user_access);
                                ?>
                                    <li class="nav-item <?php if(($url_directory == 'my_payslips') || ($url_directory == 'my_time_adjustment') || ($url_directory == 'my_leave') || ($url_directory == 'my_daily_time_record') || ($url_directory == 'profile') || ($url_directory == 'my_overtime') || ($url_directory == 'tasks') || ($url_directory == 'company_calendar') || ($url_directory == 'knowledge_base') || ($url_directory_sub == 'profile')) { echo 'menu-open'; } else {echo 'menu-close';} ?> ">
                                        <a class="nav-link dropdown_button pt-2<?php if(($url_directory == 'my_payslips') || ($url_directory == 'my_time_adjustment') || ($url_directory == 'my_leave') || ($url_directory == 'my_daily_time_record') || ($url_directory == 'profile') || ($url_directory == 'my_overtime') || ($url_directory == 'tasks') || ($url_directory == 'company_calendar') || ($url_directory == 'knowledge_base') || ($url_directory_sub == 'profile')) { echo 'firebase_dropdown_open'; } else {echo 'firebase_dropdown';} ?> ">
                                            <p class="ml-0 nav-text"><i class='fas far fa-user'></i>My Account <i class="right fas fa-angle-right mr-1 chevron"></i> </p><br>
                                            <!-- <p class="ml-3" style="font-size: 13px; color: #777777 !important; <?php if(($url_directory == 'my_payslips') || ($url_directory == 'my_time_adjustment') || ($url_directory == 'my_leave') || ($url_directory == 'my_daily_time_record') || ($url_directory == 'profile') || ($url_directory == 'my_overtime') || ($url_directory == 'tasks') || ($url_directory == 'company_calendar') || ($url_directory == 'knowledge_base') || ($url_directory_sub == 'profile')) { echo 'display: none'; }?>">My Info, My Tasks, My Time Re,...</p> -->
                                        </a>
                                        <ul class="nav nav-treeview">


                                            <?php 
                                                

                                                        foreach($user_access_arr as $user_access_arr_row){
                                                            if($user_access_arr_row == "My Info"){
                                                                ?>
                                                                    <li class="nav-item">
                                                                        <a href="<?= base_url()?>profile" class="nav-link <?php if(($url_directory == 'profile') || ($url_directory_sub == 'profile')){echo 'active';} ?>">
                                                                        &nbsp;&nbsp;
                                                                            <i class='nav-icon far fa-user-circle mx-0' style="margin-right: 0px !important;"></i>
                                                                            <p style="font-size: 14px;">My Info</p>
                                                                        </a>
                                                                    </li>
                                                                <?php
                                                            }
                                                            if($user_access_arr_row == "My Time Record"){
                                                                ?>
                                                                    <li class="nav-item">
                                                                        <a href="<?= base_url()?>attendance/my_daily_time_record" class="nav-link <?php if($url_directory == 'my_daily_time_record'){echo 'active';} ?>">
                                                                        &nbsp;&nbsp;
                                                                            <i class='nav-icon fas fa-user-clock mx-0' style="margin-right: 0px !important;"></i>
                                                                            <p style="font-size: 14px;">My Time Record</p>
                                                                        </a>
                                                                    </li>
                                                                <?php
                                                            }
                                                            if($user_access_arr_row == "My Leave"){
                                                                ?>
                                                                    <li class="nav-item">
                                                                        <a href="<?php echo base_url().'leave/my_leave';?>" class="nav-link <?php if($url_directory == 'my_leave') { echo 'active'; } ?>">
                                                                        &nbsp;&nbsp;
                                                                            <i class='nav-icon fas fa-door-open' style="margin-right: 0px !important;"></i>
                                                                            <p style="font-size: 14px;">My Leave</p>
                                                                        </a>
                                                                    </li>
                                                                <?php
                                                            }
                                                            if($user_access_arr_row == "My Overtime"){
                                                                ?>
                                                                    <li class="nav-item">
                                                                        <a href="<?php echo base_url().'attendance/my_overtime'; ?>" class="nav-link <?php if($url_directory == 'my_overtime') { echo 'active'; } ?>">
                                                                        &nbsp;&nbsp;
                                                                            <i class='nav-icon fas fa-history mx-0' style="margin-right: 0px !important;"></i>
                                                                            <p style="font-size: 14px; ">My Overtime</p>
                                                                        </a>
                                                                    </li>
                                                                <?php
                                                            }
                                                            if($user_access_arr_row == "My Time Adjustment"){
                                                                ?>
                                                                    <li class="nav-item">
                                                                        <a href="<?php echo base_url().'attendance/my_time_adjustment' ?>" class="nav-link <?php if($url_directory == 'my_time_adjustment') { echo 'active'; } ?>">
                                                                        &nbsp;&nbsp;
                                                                            <i class="nav-icon fas fa-wrench" style="margin-right: 0px !important;"></i>
                                                                            <p style="font-size: 14px;">My Time Adjustment</p>
                                                                        </a>
                                                                    </li>
                                                                <?php
                                                            }
                                                            if($user_access_arr_row == "My Payslips"){
                                                                ?>
                                                                    <li class="nav-item">
                                                                        <a href="<?php echo base_url(); ?>payroll/my_payslips" class="nav-link <?php if($url_directory == 'my_payslips') { echo 'active'; } ?>">
                                                                        &nbsp;&nbsp;
                                                                            <i class="nav-icon fas fa-file-invoice-dollar" style="margin-right: 0px !important;"></i>
                                                                            <p style="font-size: 14px;">My Payslips</p>
                                                                        </a>
                                                                    </li>
                                                                <?php
                                                            }
                                                        }
                                            ?>



                                            
                                            
                                            
                                            
                                            
                                            
                                        </ul>
                                    </li>
                                <?php
                                }
                            }
                            }
                        ?>

                        <li class="nav-item">
                            <a class="nav-link">
                                <p class="ml-0 nav-text">
                                    <i class="fas fa-users"></i>
                                    Employees 
                                    <!-- <i class="right fas fa-angle-right mr-1 chevron"></i>  -->
                                </p>
                                <span class="right badge badge-warning">SOON</span>
                                <br>
                            </a>
                        </li>       

                        <li class="nav-item">
                            <a class="nav-link">
                                <p class="ml-0 nav-text">
                                    <i class="fas fa-sitemap"></i>
                                    Organization
                                    <!-- <i class="right fas fa-angle-right mr-1 chevron"></i>  -->
                                </p>
                                <span class="right badge badge-warning">SOON</span>
                                <br>
                            </a>
                        </li>       

                        <li class="nav-item">
                            <a class="nav-link">
                                <p class="ml-0 nav-text">
                                    <i class="far fa-clock"></i>
                                    Time Keeping
                                    <i class="right fas fa-angle-right mr-1 chevron"></i> 
                                </p><br>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link">
                                <p class="ml-0 nav-text">
                                    <i class="fas fa-hands-helping"></i>    
                                    Core HR 
                                    <!-- <i class="right fas fa-angle-right mr-1 chevron"></i>  -->
                                </p>
                                <span class="right badge badge-warning">SOON</span>
                                <br>
                            </a>
                        </li>       

                        <li class="nav-item">
                            <a class="nav-link">
                                <p class="ml-0 nav-text">
                                    <i class="fas fa-user-plus"></i>
                                    Benefits
                                    <!-- <i class="right fas fa-angle-right mr-1 chevron"></i>  -->
                                </p>
                                <span class="right badge badge-warning">SOON</span>
                                <br>
                            </a>
                        </li>       

                        <li class="nav-item">
                            <a class="nav-link">
                                <p class="ml-0 nav-text">
                                    <i class="fas fa-file-invoice"></i>
                                    Payroll
                                    <!-- <i class="right fas fa-angle-right mr-1 chevron"></i>  -->
                                </p>
                                <span class="right badge badge-warning">SOON</span>
                                <br>
                            </a>
                        </li>       

                        <li class="nav-item">
                            <a class="nav-link">
                                <p class="ml-0 nav-text">
                                    <i class="fas fa-plane-departure"></i>
                                    Leaves
                                    <!-- <i class="right fas fa-angle-right mr-1 chevron"></i>  -->
                                </p>
                                <span class="right badge badge-warning">SOON</span>
                                <br>
                            </a>
                        </li>       

                        <li class="nav-item">
                            <a class="nav-link">
                                <p class="ml-0 nav-text">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Loans
                                    <!-- <i class="right fas fa-angle-right mr-1 chevron"></i>  -->
                                </p>
                                <span class="right badge badge-warning">SOON</span>
                                <br>
                            </a>
                        </li>       

                        <li class="nav-item">
                            <a class="nav-link">
                                <p class="ml-0 nav-text">
                                    <i class="fas fa-calculator"></i>
                                    Accounting
                                    <!-- <i class="right fas fa-angle-right mr-1 chevron"></i>  -->
                                </p>
                                <span class="right badge badge-warning">SOON</span>
                                <br>
                            </a>
                        </li>       

                        <li class="nav-item">
                            <a class="nav-link">
                                <p class="ml-0 nav-text">
                                    <i class="fas fa-laptop-house"></i>
                                    Assets
                                    <!-- <i class="right fas fa-angle-right mr-1 chevron"></i>  -->
                                </p>
                                <span class="right badge badge-warning">SOON</span>
                                <br>
                            </a>
                        </li>       
                        
                        <li class="nav-item">
                            <a class="nav-link">
                                <p class="ml-0 nav-text">
                                    <i class="fas fa-file-signature"></i>
                                    Reports
                                    <!-- <i class="right fas fa-angle-right mr-1 chevron"></i>  -->
                                </p>
                                <span class="right badge badge-warning">SOON</span>
                                <br>
                            </a>
                        </li>                        
                        
                        <li class="nav-item">
                            <a class="nav-link">
                                <p class="ml-0 nav-text">
                                    <i class="fas fa-file-signature"></i>
                                    Recruitment
                                    <!-- <i class="right fas fa-angle-right mr-1 chevron"></i>  -->
                                </p>
                                <span class="right badge badge-warning">SOON</span>
                                <br>
                            </a>
                        </li>                        
                                               
                        <li class="nav-item">
                            <a class="nav-link">
                                <p class="ml-0 nav-text">
                                    <i class="fas fa-file-signature"></i>
                                    Performance
                                    <!-- <i class="right fas fa-angle-right mr-1 chevron"></i>  -->
                                </p>
                                <span class="right badge badge-warning">SOON</span>
                                <br>
                            </a>
                        </li>                        
                                
                       <?php 
                            if(($User_access == 2) || ($User_access == 4)){
                                ?>
                                    <!-- HUMAN RESOURCE -->
                                    <li class="nav-item <?php if(($url_directory == 'remote_attendance') || ($url_directory == 'reports') || ($url_directory == 'approval_route_leave') || ($url_directory == 'import_deductions') || ($url_directory == 'import_allowances') || ($url_directory == 'entitlement_list') || ($url_directory == 'loans_payment') || ($url_directory == 'deductions') || ($url_directory == 'allowances') || ($url_directory == 'overtime') || ($url_directory == 'leave') || ($url_directory == 'import_attendance') || ($url_directory == 'csv') || ($url_directory == 'daily_attendance') || ($url_directory == 'attendance_record') || ($url_directory == 'time_adjustment') || ($url_directory == 'loans') || ($url_directory == 'announcements') || ($url_directory == 'employees') || ($url_directory == 'biometrics_data') || ($url_directory == 'promotions') || ($url_directory_sub == 'employees')) { echo 'menu-open'; } else {echo 'menu-close';} ?>">
                                        <a class="nav-link dropdown_button pt-2<?php if(($url_directory == 'remote_attendance') || ($url_directory == 'reports') || ($url_directory == 'approval_route_leave') || ($url_directory == 'import_deductions') || ($url_directory == 'import_allowances') || ($url_directory == 'entitlement_list') || ($url_directory == 'loans_payment') || ($url_directory == 'deductions') || ($url_directory == 'allowances') || ($url_directory == 'overtime') || ($url_directory == 'leave') || ($url_directory == 'import_attendance') || ($url_directory == 'csv') || ($url_directory == 'daily_attendance') || ($url_directory == 'attendance_record') || ($url_directory == 'time_adjustment') || ($url_directory == 'loans') || ($url_directory == 'announcements') || ($url_directory == 'employees') || ($url_directory == 'biometrics_data') || ($url_directory == 'promotions') || ($url_directory_sub == 'employees')) { echo 'firebase_dropdown_open'; } else {echo 'firebase_dropdown';} ?>">
                                        <p class="ml-0 nav-text "><i class='fas far fa-user'></i>Human Resource <i class="right fas fa-angle-right mt-2 mr-1 chevron" style="display: none;"></i></p><br>
                                            <!-- <p class="ml-3" style="font-size: 13px; color: #777777 !important; <?php if(($url_directory == 'remote_attendance') || ($url_directory == 'reports') || ($url_directory == 'approval_route_leave') || ($url_directory == 'import_deductions') || ($url_directory == 'import_allowances') || ($url_directory == 'entitlement_list') || ($url_directory == 'loans_payment') || ($url_directory == 'deductions') || ($url_directory == 'allowances') || ($url_directory == 'overtime') || ($url_directory == 'leave') || ($url_directory == 'import_attendance') || ($url_directory == 'csv') || ($url_directory == 'daily_attendance') || ($url_directory == 'attendance_record') || ($url_directory == 'time_adjustment') || ($url_directory == 'loans') || ($url_directory == 'announcements') || ($url_directory == 'employees') || ($url_directory == 'biometrics_data') || ($url_directory == 'promotions') || ($url_directory_sub == 'employees')) { echo 'display: none'; }?>">Employee Info, Daily Attendanc...</p> -->
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <!-- <li class="nav-item">
                                                <a href="<?= base_url()?>testing_controller" class="nav-link <?php if(($url_directory == 'testing_controller')) { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon fas far fa-address-book'></i>
                                                    <p style="font-size: 14px;">Testing <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li> -->
                                            <?php 
                                                if($User_type != "Sub HR"){
                                            ?>
                                                    <li class="nav-item">
                                                        <a href="<?= base_url()?>employees" class="nav-link <?php if(($url_directory == 'employees')) { echo 'active'; } ?>">
                                                        &nbsp;&nbsp;
                                                            <i class='nav-icon fas far fa-address-book'></i>
                                                            <p style="font-size: 14px;">Employee List <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                        </a>
                                                    </li>
                                            <?php 
                                                }
                                            ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>attendance/daily_attendance" class="nav-link <?php if($url_directory == 'daily_attendance') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-user-clock'></i>
                                                    <p style="font-size: 14px;">Daily Attendance <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>attendance/attendance_record" class="nav-link <?php if($url_directory == 'attendance_record') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-list-alt'></i>
                                                    <p style="font-size: 14px;">Attendance Records <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>home/reports?cutoff=<?= $cutoff_period ?>" class="nav-link <?php if(($url_directory == 'reports')) { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class="fas fa-file-medical-alt"></i>
                                                    <p style="font-size: 14px;">Attendance Reports <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>leave" class="nav-link <?php if($url_directory == 'leave') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class="nav-icon fas fa-edit"></i>
                                                    <p style="font-size: 14px;">Leave <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo base_url(); ?>leave/entitlement_list" class="nav-link <?php if($url_directory == 'entitlement_list') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class="nav-icon fas fa-crown"></i>
                                                    <p style="font-size: 14px;">Entitlement List <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>attendance/overtime" class="nav-link <?php if($url_directory == 'overtime') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class="nav-icon fas fa-history"></i>
                                                    <p style="font-size: 14px;">Overtime <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url() ?>attendance/time_adjustment" class="nav-link <?php if($url_directory == 'time_adjustment') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class="nav-icon fas fa-wrench"></i>
                                                    <p style="font-size: 14px;">Time Adjustment <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url() ?>payroll/loans" class="nav-link <?php if(($url_directory == 'loans_payment') || ($url_directory == 'loans')) { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-money-bill-wave'></i>
                                                    <p style="font-size: 14px;">Loans <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            
                                            <?php 
                                                if($User_type != "Sub HR"){
                                            ?>
                                                    <li class="nav-item">
                                                        <a href="<?= base_url() ?>allowances" class="nav-link <?php if(($url_directory == 'allowances')) { echo 'active'; } ?>">
                                                        &nbsp;&nbsp;
                                                            <i class="nav-icon fas fa-wallet"></i>
                                                            <p style="font-size: 14px;">Allowances <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                        </a>
                                                    </li>
                                            <?php 
                                                }
                                            ?>

                                            <li class="nav-item">
                                                <a href="<?= base_url() ?>deductions" class="nav-link <?php if(($url_directory == 'deductions')) { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class="nav-icon fas fa-minus-circle"></i>
                                                    <p style="font-size: 14px;">Deductions <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>approval/approval_route_leave" class="nav-link <?php if($url_directory == 'approval_route_leave') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-route'></i>
                                                    <p style="font-size: 14px;">Approval Route <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url() ?>attendance/remote_attendance" class="nav-link <?php if(($url_directory == 'remote_attendance')) { echo 'active'; } ?>">
                                                    &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-laptop-house'></i>
                                                    <p style="font-size: 14px;">Remote Attendance <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>announcements" class="nav-link <?php if(($url_directory == 'announcements')) { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-bullhorn'></i>
                                                    <p style="font-size: 14px;">Announcements <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>csv" class="nav-link <?php if($url_directory == 'csv') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon far fa-list-alt'></i>
                                                    <p style="font-size: 14px;">Import Employees Data <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>csv/import_attendance" class="nav-link <?php if($url_directory == 'import_attendance') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-route'></i>
                                                    <p style="font-size: 14px;">Import Attendance Record <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>attendance/biometrics_data" class="nav-link <?php if($url_directory == 'biometrics_data') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-fingerprint'></i>
                                                    <p style="font-size: 14px;">Biometrics Data <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>promotions" class="nav-link <?php if($url_directory == 'promotions') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-fingerprint'></i>
                                                    <p style="font-size: 14px;">Promotions <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php
                            }
                       ?>


                        <?php 
                            if(($User_access == 3) || ($User_access == 4)){
                                ?>
                                    <!-- ACCOUNTING -->
                                    <li class="nav-item <?php if(($url_directory == 'asset') || ($url_directory == 'payroll') || ($url_directory == 'company_contributions') || ($url_directory == 'bank_details') || ($url_directory == 'import_accounting')) { echo 'menu-open'; } else {echo 'menu-close';} ?>">
                                        <a class="nav-link dropdown_button pt-2<?php if(($url_directory == 'asset') || ($url_directory == 'payroll') || ($url_directory == 'company_contributions') || ($url_directory == 'bank_details') || ($url_directory == 'import_accounting')) { echo 'firebase_dropdown_open'; } else {echo 'firebase_dropdown';} ?>">
                                        <p class="ml-0 nav-text "><i class='fas far fa-user'></i>Accounting <i class="right fas fa-angle-right mt-2 mr-1 chevron" style="display: none;"></i></p><br>
                                            <!-- <p class="ml-3" style="font-size: 13px; color: #777777 !important; <?php if(($url_directory == 'asset') || ($url_directory == 'payroll') || ($url_directory == 'company_contributions') || ($url_directory == 'bank_details') || ($url_directory == 'import_accounting')) { echo 'display: none'; }?>">Payslip Generator, Company Co...</p> -->
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="<?php echo base_url(); ?>payroll" class="nav-link <?php if(($url_directory == 'payroll')) { echo 'active'; } ?>">
                                                    <i class='nav-icon fas fa-file-invoice-dollar'></i>
                                                    <p style="font-size: 14px;">Payslip Generator <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url() ?>payroll/loans" class="nav-link <?php if(($url_directory == 'loans_payment') || ($url_directory == 'loans')) { echo 'active'; } ?>">
                                                    <i class='nav-icon fas fa-money-bill-wave'></i>
                                                    <p style="font-size: 14px;">Loans <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo base_url(); ?>payroll/company_contributions" class="nav-link <?php if(($url_directory == 'company_contributions')) { echo 'active'; } ?>">
                                                    <i class="nav-icon fas fa-donate"></i>
                                                    <p style="font-size: 14px;">Company Contributions <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>asset" class="nav-link <?php if($url_directory == 'asset') { echo 'active'; } ?>">
                                                    <i class='nav-icon fas fa-cubes'></i>
                                                    <p style="font-size: 14px;">Assets <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url() ?>payroll/bank_details" class="nav-link <?php if(($url_directory == 'bank_details')) { echo 'active'; } ?>">
                                                    <i class="nav-icon fas fa-university"></i>
                                                    <p style="font-size: 14px;">Bank Details <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>csv/import_accounting" class="nav-link <?php if($url_directory == 'import_accounting') { echo 'active'; } ?>">
                                                    <i class="nav-icon fas fa-file-csv"></i>
                                                    <p style="font-size: 14px;">Import CSV <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php
                            }
                        ?>


                        <?php 
                            if($User_access == 4){
                                ?>
                                    <!-- ADMINISTRATOR -->
                                    <li class="nav-item <?php if(($url_directory == 'user_access') || ($url_directory == 'accessibility')) { echo 'menu-open'; } else {echo 'menu-close';} ?>">
                                        <a class="nav-link dropdown_button pt-2<?php if(($url_directory == 'user_access')) { echo 'firebase_dropdown_open'; } else {echo 'firebase_dropdown';} ?>">
                                        <p class="ml-0 nav-text "><i class='fas far fa-user'></i>Administrator <i class="right fas fa-angle-right mt-2 mr-1 chevron" style="display: none;"></i></p><br>
                                            <!-- <p class="ml-3" style="font-size: 13px; color: #777777 !important; <?php if(($url_directory == 'user_access')) { echo 'display: none'; }?>">User Access, Account Managem...</p> -->
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="<?= base_url() ?>admin/user_access" class="nav-link <?php if(($url_directory == 'user_access')) { echo 'active'; } ?>">
                                                    &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-file-invoice-dollar'></i>
                                                    <p style="font-size: 14px;">User Access <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url() ?>admin/accessibility" class="nav-link <?php if(($url_directory == 'accessibility')) { echo 'active'; } ?>">
                                                    &nbsp;&nbsp;
                                                    <i class="far fa-hand-paper"></i>
                                                    <p style="font-size: 14px;">Accessibility <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <!-- <li class="nav-item">
                                                <a href="#" class="nav-link <?php if(($url_directory == 'account_management')) { echo 'active'; } ?>">
                                                    &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-file-invoice-dollar'></i>
                                                    <p style="font-size: 14px;">Account Management</p>
                                                </a>
                                            </li> -->
                                        </ul>
                                    </li>
                                <?php
                            }
                        ?>

<?php 
                            // get approval route
                            $isApprover_ot_adj = $this->login_model->check_if_approver($this->session->userdata('SESS_USER_ID'));
                            $isApprover_leave = $this->login_model->check_if_approver_leave($this->session->userdata('SESS_USER_ID'));
                            $isApprover_leave_group = $this->login_model->check_if_approver_leave_group($this->session->userdata('SESS_USER_ID'));

                            if((count($isApprover_leave_group) > 0) || (count($isApprover_ot_adj) > 0) || (count($isApprover_leave) > 0) || $User_access == 4){
                                if($Username != 'bwpaccounting'){
                                ?>
                                    <!-- SUPERVISOR -->
                                    <li class="nav-item <?php if(($url_directory == 'approval_list_time_adjustment') || ($url_directory == 'approval_list_overtime') || ($url_directory == 'daily_time_record') || ($url_directory == 'assign_time_adjustment') || ($url_directory == 'assign_overtime') || ($url_directory == 'assign_leave') || ($url_directory == 'approval_list')) { echo 'menu-open'; } else {echo 'menu-close';} ?> ">
                                        <a class="nav-link dropdown_button pt-2<?php if(($url_directory == 'approval_list_time_adjustment') || ($url_directory == 'approval_list_overtime') || ($url_directory == 'daily_time_record') || ($url_directory == 'assign_time_adjustment') || ($url_directory == 'assign_overtime') || ($url_directory == 'assign_leave') || ($url_directory == 'approval_list')) { echo 'firebase_dropdown_open'; } else {echo 'firebase_dropdown';} ?>">
                                        <p class="ml-0 nav-text "><i class='fas far fa-user'></i>Supervision <i class="right fas fa-angle-right mt-2 mr-1 chevron" style="display: none;"></i> </p><br>
                                            <!-- <p class="ml-3" style="font-size: 13px; color: #777777 !important; <?php if(($url_directory == 'approval_list_time_adjustment') || ($url_directory == 'approval_list_overtime') || ($url_directory == 'daily_time_record') || ($url_directory == 'assign_time_adjustment') || ($url_directory == 'assign_overtime') || ($url_directory == 'assign_leave') || ($url_directory == 'approval_list')) { echo 'display: none'; }?>">Assign Leave, Assign Overtime ...</p> -->
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>leave/assign_leave" class="nav-link <?php if($url_directory == 'assign_leave') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-edit mx-0' style="margin-right: 0px !important;"></i>
                                                    <p style="font-size: 14px;">Assign Leave <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url() ?>attendance/assign_overtime" class="nav-link <?php if($url_directory == 'assign_overtime') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-history mx-0' style="margin-right: 0px !important;"></i>
                                                    <p style="font-size: 14px;">Assign Overtime <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url() ?>attendance/daily_time_record" class="nav-link <?php if($url_directory == 'daily_time_record') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon fas fa-user-clock mx-0' style="margin-right: 0px !important;"></i>
                                                    <p style="font-size: 14px;">Daily Time Record <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url()?>approval/approval_list" class="nav-link <?php if(($url_directory == 'approval_list_time_adjustment') || ($url_directory == 'approval_list_overtime') || ($url_directory == 'approval_list')) { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class='nav-icon far fa-list-alt' style="margin-right: 0px !important;"></i>
                                                    <p style="font-size: 14px;">Approval <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url() ?>attendance/assign_time_adjustment" class="nav-link <?php if($url_directory == 'assign_time_adjustment') { echo 'active'; } ?>">
                                                &nbsp;&nbsp;
                                                    <i class="nav-icon fas fa-wrench" style="margin-right: 0px !important;"></i>
                                                    <p style="font-size: 14px;">Time Adjustment <div class="spinner-border text-info float-right" style="display: none;"></div></p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php
                                }
                            }

                        ?>
                    </ul>
                    <br>
                </nav>
                
                <!-- /.sidebar-menu -->
                </div></div></div><div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar os-scrollbar-vertical os-scrollbar-unusable os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="height: 100%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar-corner"></div></div>
                <!-- <div class="text-center py-3" style="position: fixed; bottom: 0; height: 60px;width: 250px; background-color: #004280">
                    <img src="<?= base_url() ?>images/HRIS_logo_white.png" style="height:35px;">
                </div> -->
            </aside>
        </nav>
        <div class="d-xl-none fixed-bottom bg-white pt-0 mt-0 " style="height: 50px; box-shadow: 0px -1px 10px rgb(0 0 0 / 15%) !important">
        <div class="row align-items-center pl-2 pr-2">
            <div class="col pt-0 mt-0">
                <a href="<?= base_url(); ?>home" class="text-reset d-block text-center pb-2 pt-2">
                    <i class="fas fa-home fs-15"></i>
                    <span class="d-block"><font size="1">Home</font> </span>
                </a>
            </div>
            <div class="col pt-0 mt-0">
                <a href="<?= base_url() ?>attendance/my_daily_time_record" class="text-reset d-block text-center pb-2 pt-2">
                    <i class="fas fa-clock fs-15"></i>
                    <span class="d-block"><font size="1">Time&nbsp;Record</font> </span>
                </a>
            </div>
            <div class="col pt-0 mt-0">
                <a href="<?= base_url() ?>attendance/my_daily_time_record" class="text-reset d-block text-center pb-2 pt-2">
                    <!-- <i class="fas fa-circle" style = "color: red;"></i> -->
                    <center><div class="numberCircle"><?= $count_notif_appl + $count_notif_appl ?></div></center>
                    <span class="d-block"><font size="1">Notifications</font> </span>
                </a>
            </div>
            <div class="col pt-0 mt-0">
                <a href="<?php echo base_url() . 'leave/my_leave'; ?>" class="text-reset d-block text-center pb-2 pt-2">
                    <span class="d-inline-block position-relative px-2">
                        <i class="fas fa-plane fs-15"></i>
                    </span>
                    <span class="d-block"><font size="1">Leaves</font> </span>
                </a>
            </div>
            <div class="col pt-0 mt-0">
                <a href="<?php echo base_url().'attendance/my_overtime'; ?>" class="text-reset d-block text-center pb-2 pt-2 " >
                    <span class="d-block mx-auto">
                        <i class="fas fa-arrow-up fs-15"></i>
                    </span>
                    <span class ="fs-1"><font size="1">Overtime</font>  </span>
                </a>
            </div>
            <!-- <div class="col">
                <a href="<?php echo base_url(); ?>payroll/my_payslips" class="text-reset d-block text-center pb-2 pt-3 " >
                    <span class="d-block mx-auto">
                        <i class="fas fa-file-invoice-dollar fs-15"></i>
                    </span>
                    <span class ="fs-1"><font size="1">Payslip</font>  </span>
                </a>
            </div> -->
        </div>
    </div>
                        </body>
        <script>

            setInterval(() => {

                $('.firebase_dropdown').click(function(){
                    var parent = $(this).parent();
                    var child_2nd = this.childNodes[4];
                    $(this).find('.chevron').show();

                    $(parent).attr('style','background-color: rgba(255, 255, 255, 0.1) !important;');
                    $(child_2nd).hide();
                    $(this).removeClass('firebase_dropdown');
                    $(this).addClass('firebase_dropdown_open');
                })
                
                if($('.firebase_dropdown_open').length > 0){
                    $('.firebase_dropdown_open').click(function(){
                        var parent = $(this).parent();
                        var child_2nd = this.childNodes[4];
                        $(this).find('.chevron').hide();

                        $(parent).attr('style','');
                        $(child_2nd).show();
                        $(this).removeClass('firebase_dropdown_open');
                        $(this).addClass('firebase_dropdown');
                        
                    })
                }
            }, 200);

            $('.nav-link').click(function(){
                var a = $(this).find('.spinner-border').show();
            })
            

            
        </script>