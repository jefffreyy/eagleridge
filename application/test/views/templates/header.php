<?php

$header = $this->header_model->get_header_content();
?>
<?php
$user_access_id = $this->header_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
$modules = $this->header_model->get_user_access_modules($user_access_id['col_user_access']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="<?= base_url() ?>assets_system/images/favicon.ico" type="image/x-icon">
    <title>Eyebox HRMS</title>
    <?php $this->load->view('templates/css_link'); ?>
    <link rel="preconnect" href="https://fonts.gstatic.com"> <!-- For Font Lato initialization -->
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet"> <!-- For Font Lato initialization -->
    <!-- Commented by Benar as its not found -->
    <!-- <link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/plugins/fontawesome-free/css/all.min.css"> -->
    <!-- Font Awesome Icons -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> Font Awesome Icons -->
    <link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"><!-- overlayScrollbars -->
    <!-- Theme style -->
    <!-- Commented by Benar for Test -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <!-- Bootstrap -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> Ionicons -->
    <!-- <link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/plugins/icheck-bootstrap/icheck-bootstrap.min.css">iCheck bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://technos-systems.com/_eyeboxroot/plugins/jquery/jquery.min.js" defer></script>
    <link href="https://technos-systems.com/_eyeboxroot/css/head_styles.css" rel="stylesheet">

    

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
        color: #0f0f0f !important;
        box-shadow: none !important;
    }
    a:hover.nav-link.active {
        color: #0f0f0f !important;

        box-shadow: none !important;
    }
    .nav-link.active {
        background-color: #F2F2F2 !important;
        color: #0f0f0f !important;
        box-shadow: none !important;
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
    .img-circle_md {
        border-radius: 50% !important;
        width: 35px !important;
        height: 35px !important;
        object-fit: scale-down;
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
$data['DISP_MESSAGING_STATUS'] = $this->header_model->get_messaging_status();
$user_id = $this->header_model->get_sadmin_status($this->session->userdata('SESS_USER_ID'));
$DISP_LOGO = $this->header_model->get_logo();
$DISP_NAVBAR = $this->header_model->get_navbar();
$DISP_HEADER = $this->header_model->get_header();
?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" >
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px; width: 100%;border-bottom: 1px solid #e2e2e2; position:fixed" >
        <aside class="main-sidebar sidebar-light-primary elevation-0 " style = "border-right: 1px solid #EEEEEE;">
            <div class="sidebar">
                <div class="w-100 text-center pt-2">
                    <img src="<?= base_url(); ?>assets_system/images/<?= $DISP_NAVBAR['value'] ?>" style="height: auto; width: 170px; !important; padding-top: 10px"> <!-- header_logo.png -->
                </div>
                <hr>
                <div class="text-center">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img class="img-circle_md elevation-2" src="<?= ($User_img != "") ? base_url() . 'assets_user/user_profile/' . $User_img : base_url() . 'assets_system/images/default_user.jpg' ?>">
                        </div>
                        <div class="info">
                            <a href="<?= base_url() ?>selfservices/my_profile_personal" class="d-block"><?= $Fullname ?></a>
                        </div>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item nav-size">
                            <a href="<?= base_url(); ?>home" class='nav-link <?php if ($url_directory == 'home') {
                                                                                    echo 'active';
                                                                                } ?>' style="width: 100% !important;">
                                <i class="nav-icon fa-duotone fa-house"></i>
                                <p>&nbsp;Home</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_STATUS']['value'] == '0' || preg_match("/selfservices_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?> ">
                            <a href="<?= base_url() ?>selfservices" class="nav-link <?php
                                                                                    if (($this->uri->segment(1) == 'selfservices')) {
                                                                                        echo 'active';
                                                                                    } ?>">
                                <i class="nav-icon fa-duotone fa-hand-sparkles"></i>
                                <p>&nbsp;Self-Service</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_COMPANY_STATUS']['value'] == '0' || preg_match("/company_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?> ">
                            <a href="<?= base_url() ?>companies" class="nav-link <?php if (($this->uri->segment(1) == 'companies')) {
                                                                                        echo 'active';
                                                                                    } ?>">
                                <i class="nav-icon fa-duotone fa-building-flag"></i>
                                <p>&nbsp;Company</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_EMPLOYEE_STATUS']['value'] == '0' || preg_match("/employee_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?>   ">
                            <a href="<?= base_url() ?>employees" class="nav-link <?php if (($this->uri->segment(1) == 'employees')) {
                                                                                        echo 'active';
                                                                                    } ?>">
                                <i class="nav-icon fa-duotone fa-users"></i>
                                <p>&nbsp;Employee</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_HR_STATUS']['value'] == '0' || preg_match("/hr_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?>  ">
                            <a href="<?= base_url() ?>hressentials" class="nav-link <?php if (($this->uri->segment(1) == 'hressentials')) {
                                                                                        echo 'active';
                                                                                    } ?>">
                                <i class="nav-icon fa-duotone fa-users-rectangle"></i>
                                <p>&nbsp;HR Essentials</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_ATTENDANCE_STATUS']['value'] == '0' || preg_match("/attendance_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?>  ">
                            <a href="<?= base_url() ?>attendances" class="nav-link <?php if (($this->uri->segment(1) == 'attendances')) {
                                                                                        echo 'active';
                                                                                    } ?>">
                                <i class="nav-icon fa-duotone fa-business-time"></i>
                                <p>&nbsp;Attendance</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_LEAVE_STATUS']['value'] == '0' || preg_match("/leave_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?>   ">
                            <a href="<?= base_url() ?>leaves" class="nav-link <?php if (($this->uri->segment(1) == 'leaves')) {
                                                                                    echo 'active';
                                                                                } ?>">
                                <i class="nav-icon fa-duotone fa-house-person-leave"></i>
                                <p>&nbsp;Leave</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_PAYROLL_STATUS']['value'] == '0' || preg_match("/payroll_modules/i", $modules['user_modules']) == FALSE  ? 'inactive' : '' ?>  ">
                            <a href="<?= base_url() ?>payrolls" class="nav-link <?php if (($this->uri->segment(1) == 'payrolls')) {
                                                                                    echo 'active';
                                                                                } ?>">
                                <i class="nav-icon fa-duotone fa-money-from-bracket"></i>
                                <p>&nbsp;Payroll</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_REC_STATUS']['value'] == '0' || preg_match("/recruitment_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?>  ">
                            <a href="<?= base_url() ?>recruitments" class="nav-link <?php if (($this->uri->segment(1) == 'recruitments')) {
                                                                                        echo 'active';
                                                                                    } ?>">
                                <i class="nav-icon fas fa-network-wired"></i>
                                <p>&nbsp;Recruitment</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_LEARN_STATUS']['value'] == '0' || preg_match("/learn&develop_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?>   ">
                            <a href="<?= base_url() ?>learnanddevelops" class="nav-link <?php if (($this->uri->segment(1) == 'learnanddevelops')) {
                                                                                            echo 'active';
                                                                                        } ?>">
                                <i class="nav-icon far fa-hand-paper"></i>
                                <p>&nbsp;Learn and Develop</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_PERFORMANCE_STATUS']['value'] == '0' || preg_match("/performance_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?> ">
                            <a href="<?= base_url() ?>performances" class="nav-link <?php if (($this->uri->segment(1) == 'performances')) {
                                                                                        echo 'active';
                                                                                    } ?>">
                                <i class="nav-icon fas fa-star"></i>
                                <p>&nbsp;Performance</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_REWARDS_STATUS']['value'] == '0' || preg_match("/rewards_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?>  ">
                            <a href="<?= base_url() ?>rewardsandrecognitions" class="nav-link <?php if (($this->uri->segment(1) == 'rewardsandrecognitions')) {
                                                                                                    echo 'active';
                                                                                                } ?>">
                                <i class="nav-icon fas fa-award"></i>
                                <p>&nbsp;Rewards</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_EXIT_STATUS']['value'] == '0' || preg_match("/exist_management_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?> ">
                            <a href="<?= base_url() ?>exitmanagements" class="nav-link <?php if (($this->uri->segment(1) == 'exitmanagements')) {
                                                                                            echo 'active';
                                                                                        } ?>">
                                <i class="nav-icon fas fa-door-open"></i>
                                <p>&nbsp;Exit Management</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_ASSET_STATUS']['value'] == '0' || preg_match("/asset_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?> ">
                            <a href="<?= base_url() ?>assets" class="nav-link <?php if (($this->uri->segment(1) == 'assets')) {
                                                                                    echo 'active';
                                                                                } ?>">
                                <i class="nav-icon fab fa-dropbox"></i>
                                <p>&nbsp;Asset</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_PROJ_STATUS']['value'] == '0' || preg_match("/project_management_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?> ">
                            <a href="<?= base_url() ?>projectmanagements" class="nav-link <?php if (($this->uri->segment(1) == 'projectmanagements')) {
                                                                                                echo 'active';
                                                                                            } ?>">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>&nbsp;Project Management</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size <?= $data['DISP_ADMIN_STATUS']['value'] == '0' || preg_match("/administrator_modules/i", $modules['user_modules']) == FALSE || $this->session->userdata('SESS_SPE_ACCOUNT') ? 'inactive' : '' ?> ">
                            <a href="<?= base_url() ?>administrators" class="nav-link <?php if (($this->uri->segment(1) == 'administrators')) {
                                                                                            echo 'active';
                                                                                        } ?>">
                                <i class="nav-icon fa-duotone fa-people-roof"></i>
                                <p>&nbsp;Administrator</p>
                            </a>
                        </li>
                        <?php if ($this->session->userdata('SESS_ADMIN')) {       ?>
                            <li class="nav-item nav-size">
                                <a href="<?= base_url() ?>superadministrators" class="nav-link <?php if (($this->uri->segment(1) == 'superadministrators')) {
                                                                                                    echo 'active';
                                                                                                } ?>">
                                    <i class="nav-icon fa-duotone fa-key"></i>
                                    <p>&nbsp;Super Administrator</p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
                <hr>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                       
                        <li class="nav-item nav-size">
                            <a href="https://sonat.com/@admin-f82dc219/eyebox-hrms-operation-manual" class="nav-link">
                            <i class="nav-icon fa-duotone fa-circle-question"></i>
                                <p>User Guide</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size">
                            <a href="<?= base_url() ?>selfservices/change_password" class="nav-link">
                                <i class="nav-icon fa-duotone fa-key"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                        <li class="nav-item nav-size">
                            <a href="<?= base_url() ?>login/sign_out" class="nav-link">
                            <i class="nav-icon fa-duotone fa-arrow-up-left-from-circle"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
    </nav>
</body>
</html>