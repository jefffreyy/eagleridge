<?php
// $this->load->model('templates/header_model');
$header = $this->header_model->get_header_content();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="<?= base_url() ?>assets_system/images/favicon.ico" type="image/x-icon">
    <title>Eyebox HRMS</title>
    <link rel="preconnect" href="https://fonts.gstatic.com"> <!-- For Font Lato initialization -->
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet"> <!-- For Font Lato initialization -->
    <link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/plugins/fontawesome-free/css/all.min.css"><!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"><!-- overlayScrollbars -->
    <link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/dist/css/adminlte.min.css"><!-- Theme style -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"><!-- Bootstrap -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> <!-- Ionicons -->
    <link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"><!-- Sweet Alert -->
    <link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/plugins/toastr/toastr.min.css"><!-- Toastr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/plugins/icheck-bootstrap/icheck-bootstrap.min.css"><!-- iCheck bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://technos-systems.com/_eyeboxroot/plugins/jquery/jquery.min.js"></script>
    <!-- STANDARD 3: TECHNOS SYSTEMS EXTERNAL CSS, DO NOT CHANGE -->
    <link href="https://technos-systems.com/_eyeboxroot/css/head_styles.css" rel="stylesheet">
    <!-- button class 
    btn-primary:  blue button design -->
</head>
<style>
    .inactive {
        display: none;
    }
    .numberCircle {
        border-radius: 50%;
        width: 25px;
        height: 25px;
        background: #FF335A;
        color: #fff;
        text-align: center;
        vertical-align: middle;
        font: 10px Arial, sans-serif;
    }
    .numberCircle span {
        justify-content: center;
        line-height: 27px;
    }
    .os-scrollbar-handle {
        background-color: #D4D1D1 !important;
    }
    .firebase_dropdown {
        transition: 0.5s;
        cursor: pointer;
    }
    .firebase_dropdown_open {
        transition: 0.5s;
        cursor: pointer;
    }
    .settings_button {
        transition: 0.4s;
    }
    .settings_button:hover {
        transition: 0.4s;
        -ms-transform: rotate(40deg);
        /* IE 9 */
        transform: rotate(80deg);
        border-radius: 50px;
    }
    @media only screen and (max-width: 1010px) {
        .navbar_full_width {
            display: none;
        }
        .profile_name {
            display: none;
        }
    }
    /* Erovoutika Internal CSS */
    @media only screen and (max-width: 992px) {
        .sms_buttons {
            width: 100% !important;
            text-align: center !important;
            margin-top: 10px;
        }
        .sms_length {
            width: 100% !important;
            text-align: center !important;
            margin-top: 5px !important;
        }
        .sms_length_container {
            margin-top: 10px !important;
        }
        .quick_section_right {
            padding: 0px !important;
        }
        .message_counter {
            display: block;
        }
        .main-header.navbar.navbar-expand.navbar-white.navbar-light {
            height: 55px !important;
        }
    }
    @media only screen and (max-width: 500px) {
        #sidebar-overlay {
            z-index: 1000 !important;
        }
        #username_nav {
            display: none;
        }
        .dropdown-toggle {
            right: 8px;
            top: 20px;
            font-size: 29px;
        }
        .dropdown-menu {
            top: 13px !important;
            font-size: 18px !important;
        }
        .main-header.navbar.navbar-expand.navbar-white.navbar-light {
            height: 55px !important;
        }
    }
    .guides {
        padding: 10px;
    }
    .guides:hover {
        color: #0D74BC !important;
        background-color: #eaeaea !important;
        border-radius: 8px;
    }
    .spinner-border {
        width: 10px;
        height: 10px;
    }
    #btn_notif i:hover {
        color: #0D74BC !important;
    }
    .head-icon {
        padding-left: 5px;
    }
    li a i:not(.right) {
        margin-right: 0px !important;
    }
    a:hover.nav-link {
        color: #008037 !important;
    }
    a:hover.nav-link.active {
        color: #ffffff !important;
    }
    .nav-link.active {
        background-color: #008037 !important;
        color: #ffffff !important;
    }
    .nav-link.active.firebase_dropdown_open {
        background-color: #E5E5E5 !important;
        color: #212529 !important;
    }
    .nav-link.active.firebase_dropdown {
        background-color: #E5E5E5 !important;
        color: #212529 !important;
    }
    .nav-link.main.active {
        color: #212529 !important;
    }
    .nav-link.main {
        color: #212529 !important;
    }
    .nav-link.main.active {
        color: #ffffff !important;
    }
    .nav-link.soon {
        color: #6c757d !important;
    }
    .nav-link.home {
        color: #212529 !important;
    }
    .nav-link.home.active {
        color: #ffffff !important;
    }
    @media screen and (min-width: 800px) {
        .mob-footer {
            display: none;
        }
    }
    a.emger:hover #top-header {
        background: #E6E6E6;
    }
    #header {
        background: none;
        padding-top: 0px;
        margin-top: 50px;
    }
    .em-standard {
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
    }
    .em-featured {
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
    }
    @media (max-width: 500px) {
        .em-featured {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
        }
    }
    #top-header {
        background: white;
        position: fixed;
        width: 100%;
        z-index: 9000;
        left: 0;
        top: 0;
        border-top: 0;
    }
    #emergency-response-opt {
        max-width: 1140px;
        margin: 0 auto;
        padding: 10px 20px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        border-radius: 20px;
        font-family: 'arial';
    }
    #emergency-response-opt .txt {
        display: flex;
        align-items: center;
    }
    #emergency-response-opt p {
        font-size: 14px;
        margin-bottom: 0;
        color: #181818;
        line-height: 20px;
        margin-right: 10px;
    }
    #emergency-response-opt span {
        color: #E70052;
        font-weight: bold;
        border: 1px solid #E70052;
        padding: 5px 10px;
        border-radius: 8px;
        white-space: nowrap;
    }
    #emergency-response-opt p:last-of-type {
        margin-bottom: 0;
        padding-bottom: 0;
        margin-top: 0;
    }
    #emergency-response-opt .emergency_header {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
    @media (max-width: 500px) {
        #emergency-response-opt .emergency_header {
            text-align: center;
        }
    }
    #emergency-response-opt img {
        width: 100%;
        height: auto;
    }
    #emergency-response-opt .emgergency-image {
        width: 35%;
        margin-right: 20px;
    }
    @media (max-width: 500px) {
        #emergency-response .emgergency-image {
            width: 100%;
            margin-bottom: 20px;
        }
    }
    #emergency-response-opt .txt.full {
        width: 65%;
    }
    @media (max-width: 500px) {
        #emergency-response .txt.full {
            width: 100%;
        }
    }
    #emergency-response-opt .btn {
        text-transform: uppercase;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: bold;
        letter-spacing: 1px;
        display: inline-block;
        margin-top: 15px;
    }
    #emergency-response-opt .btn-donate {
        color: white;
        background: #ff1d34;
    }
    #emergency-response-opt .circle {
        margin-right: 15px;
    }
    #emergency-response-opt .circle .circle-wrapper {
        height: 12px;
        width: 12px;
        background: #0C884A;
        border-radius: 50px;
        display: block;
    }
    .pulsate-fwd {
        -webkit-animation: pulsate-fwd 1.5s ease-in-out infinite both;
        animation: pulsate-fwd 1.5s ease-in-out infinite both;
    }
    /* ----------------------------------------------
 * Generated by Animista on 2018-10-2 10:34:8
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */
    /**
 * ----------------------------------------
 * animation pulsate-fwd
 * ----------------------------------------
 */
    @-webkit-keyframes pulsate-fwd {
        0% {
            -webkit-transform: scale(1);
            transform: scale(1);
        }
        50% {
            -webkit-transform: scale(2);
            transform: scale(2);
        }
        100% {
            -webkit-transform: scale(1.4);
            transform: scale(1.4);
        }
    }
    @keyframes pulsate-fwd {
        0% {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-box-shadow: 0 0 0 0 rgba(12, 136, 74, 0.6);
        }
        50% {
            -webkit-transform: scale(1.4);
            transform: scale(1.4);
            -webkit-box-shadow: 0 0 0 10px rgba(12, 136, 74, 0);
        }
        100% {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-box-shadow: 0 0 0 0 rgba(12, 136, 74, 0);
        }
    }
    .carousel-caption .btn-success {
        background: #0c884a;
    }
    @media (max-width: 767px) {
        .intro .jumbotron h1 {
            color: #e70052;
            max-width: 100%;
        }
    }
    @media (max-width: 768px) {
        #emergency-response-opt p span {
            color: #E70052;
            font-weight: bold;
            border: 1px solid #E70052;
            padding: 4px 8px;
            border-radius: 8px;
            margin-top: 4px;
            display: inline-block;
        }
        #header {
            margin-top: 70px;
        }
        #emergency-response-opt p {
            font-size: 15px;
        }
        #emergency-response-opt {
            padding: 10px;
        }
    }
    @media (max-width: 450px) {
        #emergency-response-opt p {
            font-size: 11px;
        }
        #emergency-response-opt {
            padding: 10px 15px;
        }
        #header {
            margin-top: 70px;
        }
    }
    @media (max-width: 320px) {
        #header {
            margin-top: 90px;
        }
    }
</style>
<?php
//get the url
$url_count = $this->uri->total_segments();
$url_directory = $this->uri->segment($url_count);
$url_directory_sub = $this->uri->segment($url_count - 1);
$page_myaccount = false;
$page_employees = false;
$page_myaccount_list = array("my_payslips", "my_time_adjustment", "my_leave", "my_daily_time_record", "remote_attendance", "profile", "my_overtime", "tasks", "company_calendar", "knowledge_base");
$page_employees_list = array("employees");
foreach ($page_myaccount_list as $page) {
    $page_myaccount = $page_myaccount || ($url_directory == $page);
}
foreach ($page_employees_list as $page) {
    $page_employees = $page_employees || ($url_directory == $page);
}
$user_info = $this->login_model->get_user_info($this->session->userdata('SESS_USER_ID'));
$FirstName = '';
$LastName = '';
$Fullname = '';
$User_img = '';
$User_access = '';
$Username = '';
$Group = '';
$User_cmid = '';
$User_type = '';
$position = '';
$allowedRemoteAttendance = false;
foreach ($user_info as $info) {
    $User_img = $info->col_imag_path;
    $FirstName = $info->col_frst_name;
    $LastName = $info->col_last_name;
    $Fullname = $info->col_frst_name . ' ' . $info->col_last_name;
    $User_access = $info->col_user_access;
    $Username = $info->col_user_name;
    $Group = $info->col_empl_group;
    $User_cmid = $info->col_empl_cmid;
    $User_type = $info->col_user_type;
    $position = $info->col_empl_posi;
    $allowedRemoteAttendance = $info->remote_att ? true : false;
}
$DISP_PAYROLL_SCHED = $this->login_model->mod_disp_pay_sched();
$db_cutoff_id = '';
$cutoff_period = '';
if ($DISP_PAYROLL_SCHED) {
    $isCutoff_today = false;
    foreach ($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW) {
        $current_date = date('Y-m-d');
        $start_date = $DISP_PAYROLL_SCHED_ROW->date_from;
        $end_date =  $DISP_PAYROLL_SCHED_ROW->date_to;
        $db_payout = $DISP_PAYROLL_SCHED_ROW->payout;
        $payout = date('F d Y', strtotime($db_payout));
        if (($current_date >= $start_date) && ($current_date <= $end_date)) {
            $cutoff_period = $DISP_PAYROLL_SCHED_ROW->db_name;
            // echo $cutoff_period;
        } else {
        }
    }
}
$data['DISP_STATUS'] = $this->header_model->get_status();
$data['DISP_COMPANY_STATUS'] = $this->header_model->get_company_status();
$data['DISP_EMPLOYEE_STATUS'] = $this->header_model->get_employee_status();
$data['DISP_HR_STATUS'] = $this->header_model->get_hr_status();
$data['DISP_ATTENDANCE_STATUS'] = $this->header_model->get_attendance_status();
$data['DISP_LEAVE_STATUS'] = $this->header_model->get_leave_status();
$data['DISP_PAYROLL_STATUS'] = $this->header_model->get_payroll_status();
$data['DISP_REC_STATUS'] = $this->header_model->get_rec_status();
$data['DISP_LEARN_STATUS'] = $this->header_model->get_learn_status();
$data['DISP_PERFORMANCE_STATUS'] = $this->header_model->get_performance_status();
$data['DISP_REWARDS_STATUS'] = $this->header_model->get_rewards_status();
$data['DISP_EXIT_STATUS'] = $this->header_model->get_exit_status();
$data['DISP_ASSET_STATUS'] = $this->header_model->get_asset_status();
$data['DISP_PROJ_STATUS'] = $this->header_model->get_proj_status();
$data['DISP_ADMIN_STATUS'] = $this->header_model->get_admin_status();
$user_id = $this->header_model->get_sadmin_status($this->session->userdata('SESS_USER_ID'));
$DISP_LOGO = $this->header_model->get_logo();
$DISP_NAVBAR = $this->header_model->get_navbar();
$DISP_HEADER = $this->header_model->get_header();
?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style=" margin-bottom: -50px; width: 100%;border-bottom: 1px solid #e2e2e2; position:fixed">
        <div style="background-color:#fff !important; ">
            <!-- Left top navbar links -->
            <div class="navbar-nav navbar_collapse row " id="sidebar_toggle_btn_container" style="width: 100vw; ">
                <div class="col-2">
                    <a class="nav-link toggle_menu" data-widget="pushmenu" href="#" role="button" show><i class="fas fa-bars"></i></a>
                </div>
                <div class="col-8 pt-2">
                    <center><img src="<?= base_url(); ?>assets_system/images/<?=$DISP_HEADER["value"]?>" style="height: 30px;"></center> <!-- login_logo.png -->
                </div>
                <div class="col-2">
                    <li class="nav-item dropdown dropdown-user" >
                        <!-- <a class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                            <span class="font-weight-bold" id="username_nav" style="margin-left: -10px;"><?php if ($FirstName) {
                                                                                                                echo $FirstName . ' ' . $LastName;
                                                                                                            } else {
                                                                                                                echo 'Juan';
                                                                                                            } ?></span>
                        </a> -->
                        <div class="dropdown-menu dropdown-menu-right">
                        <!-- <a class="dropdown-item mt-3" href="https://docs.google.com/spreadsheets/u/1/d/e/2PACX-1vTS0KxvdaTaCyIum-OpemmhAaYau8hwr-hCvUVOlVmXQU7Iza365hYfGN22Uwo1yA/pubhtml" targat="_blank">
                            <i class="pr-2 fas fa-cogs"></i>Patch Updates
                        </a> -->
                            <div class="text-center">
                                <a href="<?=base_url()?>selfservices/my_profile_personal">
                                    <img class="rounded-circle avatar " width="32" height="32" src="<?= ($User_img != "") ? base_url() . 'assets_user/user_profile/' . $User_img : base_url() . 'assets_system/images/default_user.jpg' ?>">
                                    <p class="text-sm text-dark" id="my_profile">My Profile</p>
                                </a>
                            </div>
                            <!--<a class="dropdown-item text-start pl-1" href="">-->
                            <!--    <i class="fas fa-comment-alt p-2" id="message_center"></i>Message Center-->
                            <!--</a>-->
                            <!-- <a class="dropdown-item text-start pl-1" href="<?=base_url()?>selfservices/change_password">
                                <i class="fas fa-lock p-2" id="change_password"></i>Change Password
                            </a> -->
                            <!--<a class="dropdown-item text-start pl-1" href="">-->
                            <!--    <i class="fas fa-question-circle p-2 "id="whats_new"></i>What's New-->
                            <!--</a>-->
                            <!--<a class="dropdown-item text-start pl-1" href="">-->
                            <!--    <i class="fas fa-question-circle p-2" id="help"></i>Help-->
                            <!--</a>-->
                            <!-- <a class="dropdown-item text-start pl-1" href="https://sonat.com/@admin-f82dc219/eyebox-hrms-operation-manual" target="_blank">
                                <i class="fas fa-info-circle p-2" id="user_guide"></i>User Guide
                            </a> -->
                            <a class="dropdown-item text-start pl-1" href="<?= base_url() ?>login/sign_out">
                                <i class="fa fas fa-power-off p-2" id="logout"></i>Log Out
                            </a>
                        </div>
                    </li>
                </div>
            </div>
        </div>
        <!-- Left top navbar links -->
        <ul class="navbar-nav navbar_full_width" style="width: 100vw !important;">
            <div id="emergency-response-opt" class="em-standard" style='margin-left: 0px'>
                <div class="circle">
                    <div class="circle-wrapper pulsate-fwd"></div>
                </div>
                <div class="txt">
                    <p><?= $header["value"] ?></p>
                </div>
                <?php if ($this->session->userdata('SESS_ADMIN')) { ?>
                    <p class="text-right  m-0 ml-4" ><span class="mr-4" style="border-radius: 25px;">Signed as Administrator</span></p>
                <?php } ?>
            </div>
            <li class="nav-item">
                <a class="nav-link toggle_menu" data-widget="pushmenu" href="#" style="cursor: default;" role="button"></a>
            </li>
            <li class="nav-item p-0">
            </li>
            <form class="form-inline" style="margin-left: auto; margin-right: 270px;">
                <li class="nav-item1 dropdown dropdown-user">
                    <!-- <a class="navbar-nav-link" id="btn_notif" href="#" >
                                <span class="badge badge-danger p-1 text-bold" style="margin-right: -18px; margin-top: -8px; position: absolute; z-index: 99;">67</span>
                                <i class="fas fa-bell text-secondary" style="font-size: 20px;"></i>
                            </a> -->
                    &nbsp;
        <?php  if(!$this->session->userdata('SESS_SPE_ACCOUNT')) { ?>
                    <a class="navbar-nav-link dropdown-toggle " data-toggle="dropdown">
                        <img class="rounded-circle avatar " width="32" height="32" src="<?= ($User_img != "") ? base_url() . 'assets_user/user_profile/' . $User_img : base_url() . 'assets_system/images/default_user.jpg' ?>">
                        <span class="font-weight-bold"><?php if ($FirstName) {
                                                            echo $FirstName . ' ' . $LastName;
                                                        } else {
                                                            echo 'SMS Administrator';
                                                        } ?></span>
                    </a>
        <?php } ?>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- <a class="dropdown-item mt-3" href="https://docs.google.com/spreadsheets/u/1/d/e/2PACX-1vTS0KxvdaTaCyIum-OpemmhAaYau8hwr-hCvUVOlVmXQU7Iza365hYfGN22Uwo1yA/pubhtml" targat="_blank">
                            <i class="pr-2 fas fa-cogs"></i>Patch Updates
                        </a> -->
                        <div class="text-center">
                            <a href="<?=base_url()?>selfservices/my_profile_personal">
                                <img class="rounded-circle avatar " width="32" height="32" src="<?= ($User_img != "") ? base_url() . 'assets_user/user_profile/' . $User_img : base_url() . 'assets_system/images/default_user.jpg' ?>">
                                <p class="text-sm text-dark" id="my_profile">My Profile</p>
                            </a>
                        </div>
                        <!--<a class="dropdown-item text-start pl-1" href="">-->
                        <!--    <i class="fas fa-comment-alt p-2" id="message_center"></i>Message Center-->
                        <!--</a>-->
                        <a class="dropdown-item text-start pl-1" href="<?=base_url()?>selfservices/change_password">
                            <i class="fas fa-lock p-2" id ="change_password"></i>Change Password
                        </a>
                        <!--<a class="dropdown-item text-start pl-1" href="">-->
                        <!--    <i class="fas fa-question-circle p-2" id ="whats_new"></i>What's New-->
                        <!--</a>-->
                        <!--<a class="dropdown-item text-start pl-1" href="">-->
                        <!--    <i class="fas fa-question-circle p-2" id ="help"></i>Help-->
                        <!--</a>-->
                        <a class="dropdown-item text-start pl-1" href="https://sonat.com/@admin-f82dc219/eyebox-hrms-operation-manual" target="_blank">
                            <i class="fas fa-info-circle p-2" id ="user_guide"></i>User Guide
                        </a>
                        <a class="dropdown-item text-start pl-1" href="<?= base_url() ?>login/sign_out">
                            <i class="fa fas fa-power-off p-2" id ="logout"></i>Log Out
                        </a>
                    </div>
                </li>
            </form>
        </ul>
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <div class="sidebar">
                <div class="w-100 text-center pt-2">
                    <img src="<?= base_url(); ?>assets_system/images/<?=$DISP_NAVBAR['value']?>" style="height: auto; width: 170px; !important; padding-top: 10px"><!-- header_logo.png -->
                </div>
                <!-- SidebarSearch Form -->
                <!-- <div class="form-inline pt-4">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div> -->
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                      <br><br>

                        <li class="nav-item nav-size <?= $data['DISP_ADMIN_STATUS']['value'] == '0'  ?> ">
                            <a href="<?= base_url() ?>sms_user" class="nav-link active">
                                <i class="nav-icon fa-duotone fa-messages"></i>
                                <p>&nbsp;SMS Messaging</p>
                            </a>
                        </li>

               
                       
                        <?php
                        // get approval route
                        $isApprover_ot_adj = $this->login_model->check_if_approver($this->session->userdata('SESS_USER_ID'));
                        $isApprover_leave = $this->login_model->check_if_approver_leave($this->session->userdata('SESS_USER_ID'));//causing error
                        $isApprover_leave_group = $this->login_model->check_if_approver_leave_group($this->session->userdata('SESS_USER_ID'));
                        ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
    </nav>
    
</body>
<script>
    setInterval(() => {
        $('.firebase_dropdown').click(function() {
            var parent = $(this).parent();
            var child_2nd = this.childNodes[4];
            $(this).find('.chevron').show();
            $(parent).attr('style', 'background-color: rgba(255, 255, 255, 0.1) !important;');
            $(child_2nd).hide();
            $(this).removeClass('firebase_dropdown');
            $(this).addClass('firebase_dropdown_open');
        })
        if ($('.firebase_dropdown_open').length > 0) {
            $('.firebase_dropdown_open').click(function() {
                var parent = $(this).parent();
                var child_2nd = this.childNodes[4];
                $(this).find('.chevron').hide();
                $(parent).attr('style', '');
                $(child_2nd).show();
                $(this).removeClass('firebase_dropdown_open');
                $(this).addClass('firebase_dropdown');
            })
        }
    }, 200);
    $('.nav-link').click(function() {
        var a = $(this).find('.spinner-border').show();
    })
</script>
</html>