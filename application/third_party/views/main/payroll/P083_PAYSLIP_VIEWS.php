<style>
    ul.pagination li a {
        color: black;
        font-weight: lighter;
    }

    ul.pagination li.active a {
        color: white;
        font-weight: 600;
    }

    /* ul.pagination
    {
        position: relative;
        float: right;
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: .25rem;
    }

    ul.pagination li
    {
        float: left;
    }

    ul.pagination li a
    {
        display: block;
        color: white;
        text-align: center;
        padding: 16px;
        text-decoration: none;
        position: relative;
        display: block;
        margin-left: -1px;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }

    ul.pagination li a:hover
    {
        color: #0056b3;
        text-decoration: none;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    ul.pagination li.active
    {
        display: block;
        text-align: center;
        padding: 14px;
        text-decoration: none;
        position: relative;
        display: block;
        margin-left: -1px;
        color: #fff;
        background-color: #007bff;
        border: 1px solid #007bff;
    }

    ul.pagination li.dot
    {
        display: block;
        color: white;
        text-align: center;
        padding: 16px;
        text-decoration: none;
    } */

    .card {
        padding: 20px;
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

    .profile {
        padding: 20px 0px 0px;
    }

    .profile-img {
        display: inline-block;
        padding-right: 20px;
    }

    .profile-disc {
        margin-left: 100px;
    }

    .profile-name {
        font-weight: bold;
        font-size: 16px;
        color: black;
    }

    .position {
        font-weight: bold;
        font-size: 15px;
        color: #B0B0B0;
    }

    .divider {
        margin-top: 50px;
    }

    .social-div a {
        padding: 10px 15px;
        color: #6a6a6a;
        font-size: 15px;
    }

    .label-note {
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

    th,
    td {
        text-align: left;
        padding: 8px;
        font-size: 14px;
        font-weight: normal;
    }

    .page-title {
        font-weight: 600;
        color: #424F5C;
        font-size: 33px;
    }
</style>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Pagination -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">

<div class="content-wrapper">
    <div class="container-fluid p-4">
        <form action="<?php echo base_url('payroll/generator'); ?>" id="payslip_period" method="post" accept-charset="utf-8" autocomplete='off' >
            <div class="row">
                <div class="col-md-6">
                    <h1 class="page-title">Payroll<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">

                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6">
                    <div class="d-flex">
                        <div style="width: 150px;">
                            <p class="text-bold mb-2 pt-2">Cut-off Period: </p>
                        </div>
                        <div class="flex-fill" style="width: auto;">
                            <!-- <p>June 1, 2021 - June 15, 2021</p> -->
                            <select name="date_period" class="form-control" id="date_period" required>
                                <?php
                                $date = ((isset($_GET['date'])) && ($_GET['date'] != '')) ? $_GET['date'] : '';

                                $db_cutoff_id = '';
                                if ($DISP_PAYROLL_SCHED) {
                                    $isCutoff_today = false;

                                    foreach ($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW) {
                                        $current_date = date('Y-m-d');
                                        $db_date_period = $DISP_PAYROLL_SCHED_ROW->db_name;
                                        $split_date_period = explode(' - ', $db_date_period);
                                        $db_start_date = $split_date_period[0];
                                        $db_end_date = $split_date_period[1];

                                        $start_date = date('Y-m-d', strtotime($db_start_date));
                                        $end_date = date('Y-m-d', strtotime($db_end_date));

                                        $db_payout = $DISP_PAYROLL_SCHED_ROW->payout;
                                        $payout = date('F d Y', strtotime($db_payout));

                                        if ($DISP_PAYROLL_SCHED_ROW->id == $date) {
                                            $selected = "selected";
                                        } else {
                                            $selected = '';
                                        }

                                        if (($current_date >= $start_date) && ($current_date <= $end_date)) {
                                            $schedule_id = $DISP_PAYROLL_SCHED_ROW->id;
                                            $db_cutoff_id = $schedule_id;
                                            $isCutoff_today = true;
                                ?>
                                            <option value="<?= $schedule_id ?>" db_date="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>" payout="<?= $payout ?>"><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                                        <?php
                                        } else {

                                        ?>
                                            <option <?php echo $selected; ?> value="<?= $DISP_PAYROLL_SCHED_ROW->id ?>" db_date="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>" payout="<?= $payout ?>"><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                                <?php
                                        }
                                    }

                                    if ($isCutoff_today) {
                                        $db_cutoff_id = $DISP_PAYROLL_SCHED[0]->id;
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-primary float-right ml-3"><i class="fa fa-plus"></i>&nbsp;&nbsp; Enroll New</button>
                    <a href="#" cutoff_id="<?= $db_cutoff_id ?>" class="btn btn-primary float-right" id="download_csv">Export to CSV</a>
                    <div class="spinner-border text-success float-right mt-1" style="width: 25px !important; height: 25px !important; display: none;" id="export_csv_loading_indicator"></div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <div class="card" style="background-color: #00897b; color: white;">
                        <div style="padding: 10px 1px;">
                            <text style="font-size: 20px; margin-bottom: -15px;">
                                <?php
                                $employee = $this->p020_emplist_mod->MOD_DISP_ALL_EMPLOYEES();
                                echo count($employee);
                                ?>
                            </text><br>
                            <text><b>Current Employees Count</b></text>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="background-color: #5e35b1; color: white;">
                        <div style="padding: 10px 1px;">
                            <text style="font-size: 20px; margin-bottom: -15px;" id="generated_payslip_count">
                                <?php
                                echo count($DISP_PAYROLL_DATA);
                                ?>
                            </text><br>
                            <text><b>Generated Payslips</b></text>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="background-color: #3382b1; color: white;">
                        <div style="padding: 10px 1px;">
                            <text style="font-size: 20px; margin-bottom: -15px;" id="label_ready_for_payslip">

                            </text><br>
                            <text><b>Employees Ready for Payslip</b></text>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="background-color: #635249; color: white;">
                        <div style="padding: 10px 1px;">
                            <text style="font-size: 20px; margin-bottom: -15px;" id="label_not_ready_for_payslip">

                            </text><br>
                            <text><b>Employees Not Ready for Payslip</b></text>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-4">
                <p class="my-4 text-bold text-danger" style="font-size: 18px;">Total Generated Salary: &nbsp;&nbsp;&#8369;
                    <span id="total_generated_salary">
                        <?php
                        if (count($DISP_PAYROLL_DATA_TOTAL) > 0) {
                            foreach ($DISP_PAYROLL_DATA_TOTAL as $DISP_PAYROLL_DATA_TOTAL_ROW) {
                                echo number_format($DISP_PAYROLL_DATA_TOTAL_ROW->net_pay, 2, ".", " ");
                            }
                            // print_r($DISP_PAYROLL_DATA_TOTAL);
                        } else {
                            echo 0.00;
                        }
                        ?>
                    </span>
                </p>
            </div>
        </div>
        <ul class="nav nav-tabs border-0">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#employees_with_payslip">With Payslips</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#employees_ready_for_payslip">Ready for Payslip</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#employees_not_ready_for_payslip">Not Ready for Payslip</a>
            </li>
        </ul>

        <button class="btn btn-info float-right text-white" id="generate_all_pdf" style="margin-top: -40px; margin-right: 90px;" disabled>Generate PDF By 3s</button>
        <a class="btn btn-danger float-right text-white ml-3" id="delete_all_payslips" style="margin-top: -40px;">Delete All</a>

        <div class="tab-content">
            <div class="card border-0 mt-2 tab-pane active p-2" id="employees_with_payslip" style="margin-top: -1px !important; border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
                <div style="overflow-x:auto;">
                    <table class="table table-hover" id="tbl_payslip">
                        <thead>
                            <tr>
                                <td style="border-top: none !important;">Employee Id</td>
                                <td style="border-top: none !important;">Full Name</td>
                                <td style="border-top: none !important;">Employment Type</td>
                                <td style="border-top: none !important;">Position</td>
                                <td style="border-top: none !important; display: none;">Cut-off Period</td>
                                <td style="border-top: none !important;">Amount</td>
                                <td style="border-top: none !important;" class="text-center">File</td>
                                <td style="border-top: none !important;" class="text-center">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($DISP_PAYROLL_DATA) > 0) {
                                foreach ($DISP_PAYROLL_DATA as $DISP_PAYROLL_DATA_ROW) {
                                    $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_PAYROLL_DATA_ROW->empl_id);
                                    if ($employee) {
                                        $payroll_period = $this->p175_payschedule_mod->MOD_GET_PAY_SCHED_DATA($DISP_PAYROLL_DATA_ROW->payroll_period);

                                        // GET LEAVE USED
                                        $db_cutoff_period = $payroll_period[0]->db_name;
                                        $split_date = explode(" - ", $db_cutoff_period);
                                        $date1 = $split_date[0];
                                        $date2 = $split_date[1];

                                        $start_date = date("Y-m-d", strtotime($date1));
                                        $end_date =  date("Y-m-d", strtotime($date2));

                                        $leave_data = $this->p070_leave_mod->MOD_DISP_USED_LEAVE($DISP_PAYROLL_DATA_ROW->empl_id, $start_date, $end_date);
                                        $used_vacation_leave = 0;
                                        $used_sick_leave = 0;

                                        if (count($leave_data)) {
                                            foreach ($leave_data as $leave_data_row) {
                                                if ($leave_data_row->col_leave_type == 'Vacation Leave') {
                                                    $used_vacation_leave = $used_vacation_leave + $leave_data_row->col_leave_duration;
                                                }

                                                if ($leave_data_row->col_leave_type == 'Sick Leave') {
                                                    $used_sick_leave = $used_sick_leave + $leave_data_row->col_leave_duration;
                                                }
                                            }
                                        }


                                        // ================== GET SSS LOAN BALANCE =====================

                                        // GET PAID LOANS (USED LOANS - IN PAYSLIP)
                                        $loan_data = $this->p080_payroll_mod->MOD_DISP_PAID_LOAN_BASED_EMPL_AND_CUTOFF($payroll_period[0]->name, $employee[0]->col_empl_cmid);
                                        $loan_amount_paid = 0;
                                        $loan_installment_paid = 0;
                                        if ($loan_data) {
                                            foreach ($loan_data as $loan_data_row) {
                                                if (($loan_data_row->loan_type == 'SSS Salary Loan') || ($loan_data_row->loan_type == 'SSS Calamity Loan')) {
                                                    // if($loan_data_row->status == 'Paid'){
                                                    $loan_amount_paid = $loan_amount_paid + (float)$loan_data_row->installment;
                                                    if ($loan_data_row->installment) {
                                                        $loan_installment_paid = $loan_data_row->installment;
                                                    }
                                                    // }
                                                }
                                            }
                                        }

                                        // GET SSS LOAN BALANCE 
                                        $loan_balance_data = $this->p080_payroll_mod->MOD_DISP_LOAN_SSS_BALANCE($employee[0]->col_empl_cmid);
                                        $loan_balance_amount = 0;
                                        if ($loan_balance_data) {
                                            foreach ($loan_balance_data as $loan_balance_data_row) {
                                                $loan_balance_amount = $loan_balance_amount + (float)$loan_balance_data_row->installment;
                                            }
                                        }

                                        // ================== GET HDMF LOAN BALANCE =====================

                                        // GET PAID LOANS (USED LOANS - IN PAYSLIP)
                                        $pagibig_loan_data = $this->p080_payroll_mod->MOD_DISP_PAID_LOAN_BASED_EMPL_AND_CUTOFF($payroll_period[0]->name, $employee[0]->col_empl_cmid);
                                        $pagibig_loan_amount_paid = 0;
                                        if ($pagibig_loan_data) {
                                            foreach ($pagibig_loan_data as $pagibig_loan_data_row) {
                                                if (($pagibig_loan_data_row->loan_type == 'Pag-ibig Salary Loan') || ($pagibig_loan_data_row->loan_type == 'Pag-ibig Calamity Loan')) {
                                                    // if($pagibig_loan_data_row->status == 'Paid'){
                                                    $pagibig_loan_amount_paid = $pagibig_loan_amount_paid + (float)$pagibig_loan_data_row->installment;
                                                    // }
                                                }
                                            }
                                        }

                                        // GET PAGIBIG LOAN BALANCE 
                                        $pagibig_loan_balance_data = $this->p080_payroll_mod->MOD_DISP_LOAN_PAGIBIG_BALANCE($employee[0]->col_empl_cmid);
                                        $pagibig_loan_balance_amount = 0;
                                        if ($pagibig_loan_balance_data) {
                                            foreach ($pagibig_loan_balance_data as $pagibig_loan_balance_data_row) {
                                                $pagibig_loan_balance_amount = $pagibig_loan_balance_amount + (float)$pagibig_loan_balance_data_row->installment;
                                                $pagibig_loan_installment_paid = $pagibig_loan_data_row->installment;
                                            }
                                        }
                            ?>
                                        <tr class="payslip_row">
                                            <td empl_id="<?= $employee[0]->id ?>"><?= $employee[0]->col_empl_cmid ?></td>
                                            <td vacation_leave_balance="<?= $employee[0]->col_leave_vacation ?>" sick_leave_balance="<?= $employee[0]->col_leave_sick ?>" empl_name="<?= $employee[0]->col_frst_name . ' ' . $employee[0]->col_last_name ?>"><a href="#">
                                                    <!-- <img class="rounded-circle avatar " width="35" height="35" src="<?php //if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}
                                                                                                                            ?>"> -->
                                                    &nbsp;&nbsp;<?= $employee[0]->col_frst_name . ' ' . $employee[0]->col_last_name ?>
                                                </a>
                                            </td>

                                            <td><?= $employee[0]->col_empl_type ?></td>
                                            <td><?= $employee[0]->col_empl_posi ?></td>
                                            <td payroll_period="<?= $payroll_period[0]->name ?>" style="display: none;"></td>
                                            <td db_net_pay="<?= $DISP_PAYROLL_DATA_ROW->net_pay ?>"><?php echo number_format((float)$DISP_PAYROLL_DATA_ROW->net_pay, 2, '.', ''); ?></td>
                                            <td>
                                                <center>
                                                    <a href="#" pagibig_loan_balance_amount="<?= $pagibig_loan_balance_amount ?>" pagibig_loan_amount_paid="<?= $DISP_PAYROLL_DATA_ROW->loan_pagibig_salary + $DISP_PAYROLL_DATA_ROW->loan_pagibig_calamity ?>" sss_loan_balance_amount="<?= $loan_balance_amount ?>" sss_loan_amount_paid="<?= $DISP_PAYROLL_DATA_ROW->loan_sss_salary + $DISP_PAYROLL_DATA_ROW->loan_sss_calamity ?>" used_sick_leave="<?= $used_sick_leave ?>" used_vacation_leave="<?= $used_vacation_leave ?>" payslip_id="<?= $DISP_PAYROLL_DATA_ROW->id ?>" empl_sect="<?= $employee[0]->col_empl_sect ?>" empl_dept="<?= $employee[0]->col_empl_dept ?>" class="download_pdf">
                                                        <p class="btn btn-success">
                                                            <!-- <i class="fas fa-file-pdf"></i> -->
                                                            View
                                                        </p>
                                                        <!-- <img src="<?= base_url() ?>images/pdf_icon.png" alt="pdf icon" style="width: 30px;"> -->
                                                        <!-- <a href="<?= base_url() ?>reference_data/payroll.pdf" id="<?= $employee[0]->id . 'pdf' ?>" download>sdf.pdf</a> -->
                                                        <div class="spinner-border text-danger loading_indicator" style="display:none;"></div>
                                                    </a>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <!-- <a href="#" class="btn btn-primary btn_export_payroll mr-2" payroll_id="<?= $DISP_PAYROLL_DATA_ROW->id ?>">Export</a> -->
                                                    <a href="#" class="btn btn-danger btn_delete_payslip" empl_cmid="<?= $employee[0]->col_empl_cmid ?>" payslip_id="<?= $DISP_PAYROLL_DATA_ROW->id ?>">Delete</a>
                                                </center>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                            } else {
                                ?>
                                <td colspan=7>
                                    <center>No Payslips Yet</center>
                                </td>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    $page = ((isset($_GET['page'])) && ($_GET['page'] != '')) ? $_GET['page'] : 1;
                    $date = ((isset($_GET['date'])) && ($_GET['date'] != '')) ? $_GET['date'] : '';
                    $date = "?date=" . $date;
                    // $filter = "current=stock&";
                    // print_r ("Count of Rows: ".$status);//. $filter;
                    // print_r ("<br>Count of Rows: ".$DISP_PRODUCT_INFO2_COUNT);//. $filter;
                    $page_limit = 20;
                    // $total_records = $DISP_PRODUCT_INFO2_COUNT;
                    $row_count = $DISP_PAYROLL_DATA_COUNT;
                    $ends_count = 1;
                    $middle_count = 2;
                    $total_pages = ceil($row_count / $page_limit);
                    $dots = false;
                    echo "<center><ul class='pagination mr-auto ml-auto'>";
                    // if ($page > 1)
                    $show = 0;

                    if ($page > 1) {
                        echo "<li><a id='pages' href='" . base_url() . "payroll" . $date . "&page=" . ($page - 1) . "' class='button'>&lt;</a></li>";
                    }

                    if ($total_pages >= 1 && $page == 1) {
                    ?><li disabled><a id='pages' class='text-muted button'>&lt;</a></li><?php
                                                                                                        } elseif ($page == 3) {
                                                                                                            ?><li><a id="pages" href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo 1; ?>"><?php echo 1; ?></a></li><?php
                                                                                                                                                                    } elseif ($page == 4) {
                                                                                                                                                                        ?><li><a id='pages' href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo 1; ?>"><?php echo 1; ?></a></li><?php
                                                                                                                                                                        ?><li><a style="color: #23527c;">&hellip;</a></li><?php
                                                                                            ?><li><a id='pages' href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo 2; ?>"><?php echo 2; ?></a></li><?php
                                                                                                                                                                    } elseif ($page >= 5) {
                                                                                                                                                                        ?><li><a id='pages' href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo 1; ?>"><?php echo 1; ?></a></li><?php
                                                                                                                                                                        ?><li><a style="color: #23527c;">&hellip;</a></li><?php
                                                                                            ?><li><a id='pages' href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo 3; ?>"><?php echo 3; ?></a></li><?php
                                                                                                                                                                    }

                                                                                                                                                                    for ($i = $page; $i <= $total_pages; $i++) {
                                                                                                                                                                        if ($i == $page) {
                                                                                                                                                                            if ($page != 1) {
                                                                                                                                                                        ?><li><a id='pages' href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo $i - 1; ?>"><?php echo $i - 1; ?></a></li><?php
                                                                                                                                                                                    ?><li class="active"><a href="#"><?php echo $i; ?></a></li><?php
                                                                                                                                                                            } else {
                                                                                                            ?><li class="active"><a href="#"><?php echo $i; ?></a></li><?php
                                                                                                                                                                            }
                                                                                                                                                                            $dots = true;
                                                                                                                                                                        } else {
                                                                                                                                                                            if ($i <= $ends_count || ($page && $i >= $page - $middle_count && $i <= $page + $middle_count) || $i > $total_pages - $ends_count) {
                                                                                                            ?><li><a id='pages' href="<?php echo base_url(); ?>payroll<?php echo $date; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li><?php
                                                                                                                                                                                $dots = true;
                                                                                                                                                                            } elseif ($dots) {
                                                                                                                                                                                ?><li><a style="color: #23527c;">&hellip;</a></li><?php
                                                                                                                                                                                $dots = false;
                                                                                                                                                                            }
                                                                                                                                                                        }
                                                                                                                                                                    }

                                                                                                                                                                    if ($total_pages == 1 || $page == $total_pages) {
                                                                                                    ?><li disabled><a id='pages' class='text-muted button'>&gt;</a></li><?php
                                                                                                                                                                    }

                                                                                                                                                                    if ($total_pages > $page) {
                                                                                                                                                                        echo "<li><a id='pages' href='" . base_url() . "payroll" . $date . "&page=" . ($page + 1) . "' class='button'>&gt;</a></li>";
                                                                                                                                                                    }
                                                                                                                                                                    echo "</ul></center>";
                                                                                                        ?>
                </div>
            </div>
            <div class="card border-0 mt-2 tab-pane p-2" id="employees_ready_for_payslip" style="margin-top: -1px !important; border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
                <div style="overflow-x:auto;">
                    <table class="table table-hover" id="tbl_employees_ready_for_payslip">
                        <thead>
                            <tr>
                                <td style="border-top: none !important;">Employee Id</td>
                                <td style="border-top: none !important;">Full Name</td>
                                <td style="border-top: none !important;">Employment Type</td>
                                <td style="border-top: none !important;">Position</td>
                                <td style="border-top: none !important; display: none">Cut-off Period</td>
                                <!-- <td style="border-top: none !important;" class="text-center">Action</td> -->
                            </tr>
                        </thead>
                        <tbody id="container_employees_ready_for_payslip">

                        </tbody>
                    </table>
                </div>

                <!-- <ul id="btn_pagination" class="pagination"></ul> -->
            </div>
            <div class="card border-0 mt-2 tab-pane p-2" id="employees_not_ready_for_payslip" style="margin-top: -1px !important; border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
                <div style="overflow-x:auto;">
                    <table class="table table-hover" id="tbl_employees_not_ready_for_payslip">
                        <thead>
                            <tr>
                                <td style="border-top: none !important;">Employee Id</td>
                                <td style="border-top: none !important;">Full Name</td>
                                <td style="border-top: none !important;">Employment Type</td>
                                <td style="border-top: none !important;">Position</td>
                                <td style="border-top: none !important; display: none">Cut-off Period</td>
                                <!-- <td style="border-top: none !important;" class="text-center">Action</td> -->
                            </tr>
                        </thead>
                        <tbody id="container_employees_not_ready_for_payslip">

                        </tbody>
                    </table>
                </div>

                <!-- <ul id="btn_pagination" class="pagination"></ul> -->
            </div>
        </div>
    </div>
</div>

<table style="display:none;" id="tbl_payroll_data">
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Department</th>
            <th>Section</th>
            <th>Position</th>
            <th>Salary Type</th>
            <th>Salary Rate</th>
            <th>Work Rate</th>
            <th>Daily Salary</th>
            <th>Hourly Salary</th>
            <th>Payroll Period</th>
            <th>Payroll Type</th>
            <th>Working Days</th>
            <th>Hours of Work</th>
            <th>Basic Salary (Days)</th>
            <th>Absences (Days)</th>
            <th>No Time In/Time Out (Days)</th>
            <th>Tardiness (Hours)</th>
            <th>Half Day (Hours)</th>
            <th>Undertime (Hours)</th>
            <th>Rest Day (Hours)</th>
            <th>Rest + Special Hol (Hours)</th>
            <th>Legal Holiday (Hours)</th>
            <th>Rest + Legal Hol (Hours)</th>
            <th>Regular OT (Hours)</th>
            <th>Night Diff OT (Hours)</th>
            <th>Night Diff (Hours)</th>
            <th>Paid Leave (Hours)</th>
            <th>De Minimis Multiplier</th>
            <th>Rest + OT</th>
            <th>Rest + ND + OT</th>
            <th>Total Basic Salary</th>
            <th>Total Absences</th>
            <th>Total No Time In/Time Out</th>
            <th>Total Tardiness</th>
            <th>Total Half Day</th>
            <th>Total Undertime</th>
            <th>Total Rest Day</th>
            <th>Total Rest + Special Hol</th>
            <th>Total Legal Holiday</th>
            <th>Total Rest + Legal Hol</th>
            <th>Total Regular OT</th>
            <th>Total Night Diff OT</th>
            <th>Total Night Diff</th>
            <th>Total Paid Leave</th>
            <th>Total De Minimis</th>
            <th>Total Rest + OT</th>
            <th>Total Rest + ND + OT</th>
            <th id="SIL_csv_label">SIL 2020</th>
            <th>Meal Allowance</th>
            <th>Gov't Contribution</th>
            <th>Others</th>
            <th>Gross Taxable Income</th>
            <th>SSS Contribution (Employee)</th>
            <th>Philhealth Contribution (Employee)</th>
            <th>Pagibig Contribution (Employee)</th>
            <th>Total Contribution (Employee)</th>
            <th>SSS Contribution (Employer)</th>
            <th>SSS Contribution EC (Employer)</th>
            <th>Philhealth Contribution (Employer)</th>
            <th>Pagibig Contribution (Employer)</th>
            <th>Total Contribution (Employer)</th>
            <th>Load Allowance</th>
            <th>Transportation Allowance</th>
            <th>Skill Allowance</th>
            <th>Pioneer Allowance</th>
            <th>Total Allowance</th>
            <th>Total Taxable Allowance</th>
            <th>Witholding Tax</th>
            <th>Loan SSS Salary</th>
            <th>Loan SSS Calamity</th>
            <th>Loan Pagibig Salary</th>
            <th>Loan Pagibig Calamity</th>
            <th>Loan Emergency</th>
            <th>Loan Total</th>
            <th>Tax Refund</th>
            <th>Salary Advance</th>
            <th>Uniform Deduction</th>
            <th>Total Deduction</th>
            <th>Net Pay</th>
        </tr>
    </thead>
    <tbody id="payroll_data_container">
        <tr>
            <td id="empl_id"></td>
            <td id="empl_name"></td>
            <td id="empl_dept"></td>
            <td id="empl_sect"></td>
            <td id="empl_posi"></td>
            <td id="salary_type"></td>
            <td id="salary_rate"></td>
            <td id="work_rate"></td>
            <td id="daily_salary"></td>
            <td id="hourly_salary"></td>
            <td id="payroll_period"></td>
            <td id="payroll_type"></td>
            <td id="working_days"></td>
            <td id="hours_of_work"></td>
            <td id="ti_basic_sal_mul"></td>
            <td id="ti_absent_mul"></td>
            <td id="ti_no_ti_to_mul"></td>
            <td id="ti_tard_mul"></td>
            <td id="ti_half_mul"></td>
            <td id="ti_undertime_mul"></td>
            <td id="ti_rest_mul"></td>
            <td id="ti_rest_sp_hol_mul"></td>
            <td id="ti_legal_hol_mul"></td>
            <td id="ti_rest_legal_hol_mul"></td>
            <td id="ti_reg_ot_mul"></td>
            <td id="ti_nd_ot_mul"></td>
            <td id="ti_nd_mul"></td>
            <td id="ti_leave_mul"></td>
            <td id="ti_de_minimis_mul"></td>
            <td id="ti_basic_sal_total"></td>
            <td id="ti_absent_total"></td>
            <td id="ti_no_ti_to_total"></td>
            <td id="ti_tard_total"></td>
            <td id="ti_half_total"></td>
            <td id="ti_undertime_total"></td>
            <td id="ti_rest_total"></td>
            <td id="ti_rest_sp_hol_total"></td>
            <td id="ti_legal_hol_total"></td>
            <td id="ti_rest_legal_hol_total"></td>
            <td id="ti_reg_ot_total"></td>
            <td id="ti_nd_ot_total"></td>
            <td id="ti_nd_total"></td>
            <td id="ti_leave_total"></td>
            <td id="ti_de_minimis_total"></td>
            <td id="ti_sil_2020"></td>
            <td id="ti_meal"></td>
            <td id="ti_gov_cont"></td>
            <td id="ti_others"></td>
            <td id="ti_gross"></td>
            <td id="gov_sss_ee"></td>
            <td id="gov_philhealth_ee"></td>
            <td id="gov_pagibig_ee"></td>
            <td id="gov_total_ee"></td>
            <td id="comp_cont_sss"></td>
            <td id="comp_cont_sss_ec"></td>
            <td id="comp_cont_philhealth"></td>
            <td id="comp_cont_pagibig"></td>
            <td id="comp_cont_total"></td>
            <td id="ta_load"></td>
            <td id="ta_transportation"></td>
            <td id="ta_skill"></td>
            <td id="ta_pioneer"></td>
            <td id="ta_allowance"></td>
            <td id="ta_total"></td>
            <td id="wtax"></td>
            <td id="loan_sss_salary"></td>
            <td id="loan_sss_calamity"></td>
            <td id="loan_pagibig_salary"></td>
            <td id="loan_pagibig_calamity"></td>
            <td id="loan_emergency"></td>
            <td id="loan_total"></td>
            <td id="tax_refund"></td>
            <td id="salary_advance"></td>
            <td id="uniform_deduction"></td>
            <td id="ded_total"></td>
            <td id="net_pay"></td>
        </tr>
    </tbody>
</table>

<!-- =============== Application Overtime ================= -->
<div class="modal fade" id="modal_select_empl_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Select 3 Employees for Payslip
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="select_empl_1">Employee 1</label>
                            <select name="select_empl_1" id="select_empl_1" class="form-control">

                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="select_empl_2">Employee 2</label>
                            <select name="select_empl_2" id="select_empl_2" class="form-control">

                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="select_empl_3">Employee 3</label>
                            <select name="select_empl_3" id="select_empl_3" class="form-control">

                            </select>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="spinner-border text-info" id="generate_all_payslip_loading" style="display: none; width: 25px !important; height: 25px !important; margin-right: 10px"></div>
                <a class='btn btn-primary text-light' id="btn_generate_payslip_by_3s">&nbsp; Generate</a>
            </div>
        </div>
    </div>
</div>




<aside class="control-sidebar control-sidebar-dark">
</aside>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
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
<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<!-- JsPDF -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.debug.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<!-- Pagination -->
<script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>

<?php
if ($this->session->userdata('SESS_SUCC_MSG_ADD_PAYROLL')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_ADD_PAYROLL'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_ADD_PAYROLL');
}
?>

<?php
if ($this->session->userdata('SESS_SUCC_MSG_DLT_PAYROLL')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_PAYROLL'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_DLT_PAYROLL');
}
?>

<script>
    $(document).ready(function() {
        window.jsPDF = window.jspdf.jsPDF;

        // for async data - fetch count of employees with no payslip
        var base_url = '<?= base_url() ?>';
        var url_get_employee_not_ready_for_payslip = '<?= base_url() ?>payroll/get_employee_not_ready_for_payslip';
        var url_generated_payslip_count = '<?= base_url() ?>payroll/generated_payslip_count';
        var url3 = '<?= base_url() ?>payroll/getEmployeeData';
        var url4 = '<?= base_url() ?>payroll/get_payslip_data';
        var url_payroll_data_based_period = '<?= base_url() ?>payroll/get_payslip_data_based_on_period';
        var url_get_employees_ready_for_payslip = '<?= base_url() ?>payroll/get_employees_ready_for_payslip';

        var payroll_id = $('#date_period').val();
        var cut_off_period_text = $('#date_period option:selected').text();
        var cutoff_period_db_name = $('#date_period option:selected').attr('db_date');

        var url_get_employee_all_ampl_data = '<?= base_url() ?>attendance/get_employee_all_ampl_data';

        var url_get_all_payroll_data_by_3s = '<?= base_url() ?>payroll/get_all_payroll_data_by_3s';

        var global_generate_all_pdf_object = [];



        // CHECK CUTOFF PERIOD
        var db_date_name = $('#date_period option:selected').attr('db_date');
        var split_db_date_name = db_date_name.split('/');
        var initial_cutoff_year = split_db_date_name[4];

        var SIL_year = parseInt(initial_cutoff_year);
        var SIL_label = 'SIL ' + (initial_cutoff_year - 1);
        console.log('SIL ' + (initial_cutoff_year - 1));

        $('#SIL_csv_label').html(SIL_label);



        $("#date_period").on("change", function() {
            var optionValue = $(this).val();
            // window.history.replaceState(null, null, '?date='+optionValue+'');
            // console.log('?date='+optionValue+'');

            var url = window.location.href.split("?")[0];
            if (window.location.href.indexOf("?") > 0) {
                window.location = url + "?date=" + optionValue;
            } else {
                window.location = url + "?date=" + optionValue;
            }
        })

        // =================================== LOAD INITIAL RECORDS =====================================
        // Diplay initial count based on current value of cutoff period

        get_employees_ready_for_payslip(url_get_employees_ready_for_payslip, cutoff_period_db_name, payroll_id).then(data => {
            $('#label_ready_for_payslip').html(data.count);
        })

        get_employee_not_ready_for_payslip(url_get_employee_not_ready_for_payslip, cutoff_period_db_name, payroll_id).then(data => {
            $('#label_not_ready_for_payslip').html(data.count);
        })

        // Diplay initial payslip count based on current value of cutoff period
        generated_payslip_count(url_generated_payslip_count, payroll_id).then(data => {
            $('#generated_payslip_count').html(data);
        })

        // get the length of displayed tr
        var length = $('#tbl_payslip .payslip_row').filter(function() {
            return $(this).css('display') !== 'none';
        }).length;

        if (length == 0) {
            $('#employee_without_payslip').html('0');
            $('#generated_payslip_count').html('0');
        }


        // GET EMPLOYESS READY FOR PAYSLIP
        get_employees_ready_for_payslip(url_get_employees_ready_for_payslip, cutoff_period_db_name, payroll_id).then(data => {

            $('#container_employees_ready_for_payslip').html('');

            data.empl_ready_for_payslip.forEach(function(id) {

                getEmployeeData(url3, id).then(data1 => {
                    data1.employee_data.forEach(function(x) {
                        var empl_img = 'default_profile_img3.png';
                        if (x.col_imag_path) {
                            empl_img = x.col_imag_path;
                        }
                        $('#container_employees_ready_for_payslip').append(`
                                <tr class="payslip_row">
                                    <td>` + x.col_empl_cmid + `</td>
                                    <td><a href = "#">
                                        ` + x.col_frst_name + ' ' + x.col_last_name + `</a>
                                    </td>
                                    <td>` + x.col_empl_type + `</td>
                                    <td>` + x.col_empl_posi + `</td>
                                    <td style="display:none;">` + cut_off_period_text + `</td>
                                    
                                </tr>
                            `); //<img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`/user_images/`+empl_img+`">&nbsp;&nbsp;
                    })
                })
            })
        })



        // GET EMPLOYEES NOT READY FOR PAYSLIP
        get_employee_not_ready_for_payslip(url_get_employee_not_ready_for_payslip, cutoff_period_db_name, payroll_id).then(data => {

            $('#container_employees_not_ready_for_payslip').html('');

            data.empl_not_ready_for_payslip.forEach(function(id) {
                getEmployeeData(url3, id).then(data1 => {
                    data1.employee_data.forEach(function(x) {
                        var empl_img = 'default_profile_img3.png';
                        if (x.col_imag_path) {
                            empl_img = x.col_imag_path;
                        }
                        $('#container_employees_not_ready_for_payslip').append(`
                                <tr class="payslip_row">
                                    <td>` + x.col_empl_cmid + `</td>
                                    <td><a href = "#">&nbsp;&nbsp;` + x.col_frst_name + ' ' + x.col_last_name + `</a>
                                    </td>
                                    <td>` + x.col_empl_type + `</td>
                                    <td>` + x.col_empl_posi + `</td>zzz
                                    <td style="display:none;">` + cut_off_period_text + `</td>
                                    
                                </tr>
                            `); //<img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`/user_images/`+empl_img+`">
                    })
                })
            })
        })



        // Generate current employees initially
        // var date_period_value = $('#date_period option:selected').text();
        // var amount_arr = [];
        // var tr_cutoff = $('#tbl_payslip .payslip_row');
        // if(date_period_value){
        //     var total_generated_salary = 0;

        //     Array.from(tr_cutoff).forEach(function(tr){
        //         const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
        //         const db_net_pay = $(tr.childNodes[11]).attr('db_net_pay');
        //         if(date_period_value == cut_off_period){
        //             tr.style.display = "";
        //             total_generated_salary += parseFloat(db_net_pay);
        //         } else {
        //             // tr.style.display = 'none';
        //         }
        //     })

        //     $('#total_generated_salary').text((total_generated_salary).toFixed(2));
        // }
















        // Sort by cut-off period
        $('#date_period').change(function(e) {
            var date_period_id_value = $(this).val();
            var date_db_name = $('#date_period option:selected').attr('db_date');
            var date_period_text = $('#date_period option:selected').text();
            $('#generate_all_pdf').prop('disabled', true);

            $('#download_csv').attr('cutoff_id', date_period_id_value);

            // clear container before appending
            $('#container_employees_ready_for_payslip').html('');
            $('#container_employees_not_ready_for_payslip').html('');
            $('#payroll_data_container').html('');

            // GET EMPLOYESS READY FOR PAYSLIP
            get_employees_ready_for_payslip(url_get_employees_ready_for_payslip, date_db_name, date_period_id_value).then(data => {
                $('#container_employees_ready_for_payslip').html('');

                data.empl_ready_for_payslip.forEach(function(id) {

                    getEmployeeData(url3, id).then(data1 => {
                        data1.employee_data.forEach(function(x) {
                            var empl_img = 'default_profile_img3.png';
                            if (x.col_imag_path) {
                                empl_img = x.col_imag_path;
                            }
                            $('#container_employees_ready_for_payslip').append(`
                                    <tr class="payslip_row">
                                        <td>` + x.col_empl_cmid + `</td>
                                        <td><a href = "#">
                                            ` + x.col_frst_name + ' ' + x.col_last_name + `</a>
                                        </td>
                                        <td>` + x.col_empl_type + `</td>
                                        <td>` + x.col_empl_posi + `</td>
                                        <td style="display:none;">` + cut_off_period_text + `</td>
                                        
                                    </tr>
                                `); //<img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`/user_images/`+empl_img+`">&nbsp;&nbsp;
                        })
                    })
                })

                $('#label_ready_for_payslip').html(data.count);
            })


            // GET EMPLOYEES NOT READY FOR PAYSLIP
            get_employee_not_ready_for_payslip(url_get_employee_not_ready_for_payslip, date_db_name, date_period_id_value).then(data => {

                $('#container_employees_not_ready_for_payslip').html('');

                data.empl_not_ready_for_payslip.forEach(function(id) {
                    getEmployeeData(url3, id).then(data1 => {
                        data1.employee_data.forEach(function(x) {
                            var empl_img = 'default_profile_img3.png';
                            if (x.col_imag_path) {
                                empl_img = x.col_imag_path;
                            }
                            $('#container_employees_not_ready_for_payslip').append(`
                                    <tr class="payslip_row">
                                        <td>` + x.col_empl_cmid + `</td>
                                        <td><a href = "#">
                                            ` + x.col_frst_name + ' ' + x.col_last_name + `</a>
                                        </td>
                                        <td>` + x.col_empl_type + `</td>
                                        <td>` + x.col_empl_posi + `</td>
                                        <td style="display:none;">` + cut_off_period_text + `</td>
                                        
                                    </tr>
                                `); //<img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`/user_images/`+empl_img+`">&nbsp;&nbsp;
                        })
                    })
                })

                $('#label_not_ready_for_payslip').html(data.count);
            })


            // GET EMPLOYEES WITH PAYSLIPS
            // var tr_cutoff = $('#tbl_payslip .payslip_row');
            // var total_generated_salary = 0;

            // Array.from(tr_cutoff).forEach(function(tr){
            //     const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
            //     const db_net_pay = $(tr.childNodes[11]).attr('db_net_pay');
            //     if(date_period_text == cut_off_period){
            //         tr.style.display = "";
            //         total_generated_salary += parseFloat(db_net_pay);

            //     } else {
            //         // tr.style.display = 'none';
            //     }
            // })

            // $('#total_generated_salary').text((total_generated_salary).toFixed(2));


            generated_payslip_count(url_generated_payslip_count, date_period_id_value).then(data => {
                $('#generated_payslip_count').html(data);
            })



            get_payslip_data_based_on_period(url_payroll_data_based_period, date_period_id_value).then(function(data) {
                Array.from(data).forEach(function(x) {

                    var obj = findObjectByKey(empl_info_arr, 'id', "" + x.empl_id + "");

                    // console.log(x.empl_id);

                    var employee_id = '';

                    if (obj) {
                        employee_id = obj.col_empl_cmid;
                    }

                    var empl_id = employee_id;

                    // console.log('empl_id: ' + empl_id);

                    var empl_name = x.empl_name;
                    var salary_type = x.salary_type;
                    var salary_rate = x.salary_rate;
                    var work_rate = x.work_rate;
                    var daily_salary = x.daily_salary;
                    var hourly_salary = x.hourly_salary;
                    var payroll_period = x.payroll_period;
                    var payroll_type = x.payroll_type;
                    var working_days = x.working_days;
                    var hours_of_work = x.hours_of_work;
                    var ti_basic_sal_mul = x.ti_basic_sal_mul;
                    var ti_absent_mul = x.ti_absent_mul;
                    var ti_no_ti_to_mul = x.ti_no_ti_to_mul;
                    var ti_tard_mul = x.ti_tard_mul;
                    var ti_half_mul = x.ti_half_mul;
                    var ti_undertime_mul = x.ti_undertime_mul;
                    var ti_rest_mul = x.ti_rest_mul;
                    var ti_rest_sp_hol_mul = x.ti_rest_sp_hol_mul;
                    var ti_legal_hol_mul = x.ti_legal_hol_mul;
                    var ti_rest_legal_hol_mul = x.ti_rest_legal_hol_mul;
                    var ti_reg_ot_mul = x.ti_reg_ot_mul;
                    var ti_nd_ot_mul = x.ti_nd_ot_mul;
                    var ti_nd_mul = x.ti_nd_mul;
                    var ti_leave_mul = x.ti_leave_mul;
                    var ti_de_minimis_mul = x.ti_de_minimis_mul;
                    var ti_rest_ot_mul = x.ti_rest_ot_mul;
                    var ti_rest_nd_ot_mul = x.ti_rest_nd_ot_mul;
                    var ti_basic_sal_total = x.ti_basic_sal_total;
                    var ti_absent_total = x.ti_absent_total;
                    var ti_no_ti_to_total = x.ti_no_ti_to_total;
                    var ti_tard_total = x.ti_tard_total;
                    var ti_half_total = x.ti_half_total;
                    var ti_undertime_total = x.ti_undertime_total;
                    var ti_rest_total = x.ti_rest_total;
                    var ti_rest_sp_hol_total = x.ti_rest_sp_hol_total;
                    var ti_legal_hol_total = x.ti_legal_hol_total;
                    var ti_rest_legal_hol_total = x.ti_rest_legal_hol_total;
                    var ti_reg_ot_total = x.ti_reg_ot_total;
                    var ti_nd_ot_total = x.ti_nd_ot_total;
                    var ti_nd_total = x.ti_nd_total;
                    var ti_leave_total = x.ti_leave_total;
                    var ti_de_minimis_total = x.ti_de_minimis_total;
                    var ti_rest_ot_total = x.ti_rest_ot_total;
                    var ti_rest_nd_ot_total = x.ti_rest_nd_ot_total;
                    var ti_sil_2020 = x.ti_sil_2020;
                    var ti_meal = x.ti_meal;
                    var ti_gov_cont = x.ti_gov_cont;
                    var ti_others = x.ti_others;
                    var ti_gross = x.ti_gross;
                    var gov_sss_ee = x.gov_sss_ee;
                    var gov_philhealth_ee = x.gov_philhealth_ee;
                    var gov_pagibig_ee = x.gov_pagibig_ee;
                    var gov_total_ee = x.gov_total_ee;
                    var comp_cont_sss = x.comp_cont_sss;
                    var comp_cont_sss_ec = x.comp_cont_sss_ec;
                    var comp_cont_philhealth = x.comp_cont_philhealth;
                    var comp_cont_pagibig = x.comp_cont_pagibig;
                    var comp_cont_total = x.comp_cont_total;
                    var ta_load = x.ta_load;
                    var ta_transportation = x.ta_transportation;
                    var ta_skill = x.ta_skill;
                    var ta_pioneer = x.ta_pioneer;
                    var ta_allowance = x.ta_allowance;
                    var ta_total = x.ta_total;
                    var wtax = x.wtax;
                    var loan_sss_salary = x.loan_sss_salary;
                    var loan_sss_calamity = x.loan_sss_calamity;
                    var loan_pagibig_salary = x.loan_pagibig_salary;
                    var loan_pagibig_calamity = x.loan_pagibig_calamity;
                    var loan_emergency = x.loan_emergency;
                    var loan_total = x.loan_total;
                    var tax_refund = x.tax_refund;
                    var salary_advance = x.salary_advance;
                    var uniform_deduction = x.uniform_deduction;
                    var ded_total = x.ded_total;
                    var net_pay = x.net_pay;

                    $('#payroll_data_container').append(`
                            <tr>
                                <td>` + empl_id + `</td>
                                <td>` + empl_name + `</td>
                                <td>` + salary_type + `</td>
                                <td>` + salary_rate + `</td>
                                <td>` + work_rate + `</td>
                                <td>` + daily_salary + `</td>
                                <td>` + hourly_salary + `</td>
                                <td>` + payroll_period + `</td>
                                <td>` + payroll_type + `</td>
                                <td>` + working_days + `</td>
                                <td>` + hours_of_work + `</td>
                                <td>` + ti_basic_sal_mul + `</td>
                                <td>` + ti_absent_mul + `</td>
                                <td>` + ti_no_ti_to_mul + `</td>
                                <td>` + ti_tard_mul + `</td>
                                <td>` + ti_half_mul + `</td>
                                <td>` + ti_undertime_mul + `</td>
                                <td>` + ti_rest_mul + `</td>
                                <td>` + ti_rest_sp_hol_mul + `</td>
                                <td>` + ti_legal_hol_mul + `</td>
                                <td>` + ti_rest_legal_hol_mul + `</td>
                                <td>` + ti_reg_ot_mul + `</td>
                                <td>` + ti_nd_ot_mul + `</td>
                                <td>` + ti_nd_mul + `</td>
                                <td>` + ti_leave_mul + `</td>
                                <td>` + ti_de_minimis_mul + `</td>
                                <td>` + ti_rest_ot_mul + `</td>
                                <td>` + ti_rest_nd_ot_mul + `</td>
                                <td>` + ti_basic_sal_total + `</td>
                                <td>` + ti_absent_total + `</td>
                                <td>` + ti_no_ti_to_total + `</td>
                                <td>` + ti_tard_total + `</td>
                                <td>` + ti_half_total + `</td>
                                <td>` + ti_undertime_total + `</td>
                                <td>` + ti_rest_total + `</td>
                                <td>` + ti_rest_sp_hol_total + `</td>
                                <td>` + ti_legal_hol_total + `</td>
                                <td>` + ti_rest_legal_hol_total + `</td>
                                <td>` + ti_reg_ot_total + `</td>
                                <td>` + ti_nd_ot_total + `</td>
                                <td>` + ti_nd_total + `</td>
                                <td>` + ti_leave_total + `</td>
                                <td>` + ti_de_minimis_total + `</td>
                                <td>` + ti_rest_ot_total + `</td>
                                <td>` + ti_rest_nd_ot_total + `</td>
                                <td>` + ti_sil_2020 + `</td>
                                <td>` + ti_meal + `</td>
                                <td>` + ti_gov_cont + `</td>
                                <td>` + ti_others + `</td>
                                <td>` + ti_gross + `</td>
                                <td>` + gov_sss_ee + `</td>
                                <td>` + gov_philhealth_ee + `</td>
                                <td>` + gov_pagibig_ee + `</td>
                                <td>` + gov_total_ee + `</td>
                                <td>` + comp_cont_sss + `</td>
                                <td>` + comp_cont_sss_ec + `</td>
                                <td>` + comp_cont_philhealth + `</td>
                                <td>` + comp_cont_pagibig + `</td>
                                <td>` + comp_cont_total + `</td>
                                <td>` + ta_load + `</td>
                                <td>` + ta_transportation + `</td>
                                <td>` + ta_skill + `</td>
                                <td>` + ta_pioneer + `</td>
                                <td>` + ta_allowance + `</td>
                                <td>` + ta_total + `</td>
                                <td>` + wtax + `</td>
                                <td>` + loan_sss_salary + `</td>
                                <td>` + loan_sss_calamity + `</td>
                                <td>` + loan_pagibig_salary + `</td>
                                <td>` + loan_pagibig_calamity + `</td>
                                <td>` + loan_emergency + `</td>
                                <td>` + loan_total + `</td>
                                <td>` + tax_refund + `</td>
                                <td>` + salary_advance + `</td>
                                <td>` + uniform_deduction + `</td>
                                <td>` + ded_total + `</td>
                                <td>` + net_pay + `</td>
                            </tr>
                        `)
                })
            })




            var loop_and_match = setInterval(() => {
                compare_generated_payslips();
            }, 100);

            function compare_generated_payslips() {
                var generated_payroll = $('#payroll_data_container tr').length;
                var generated_payslip_count = $('#generated_payslip_count').text();

                if ((generated_payroll != 0) && (generated_payslip_count != 0) && (generated_payroll == generated_payslip_count)) {
                    // console.log('Ready for Generate All PDFs');
                    $('#generate_all_pdf').removeAttr('title');
                    $('#generate_all_pdf').removeAttr('data-toggle');
                    $('#generate_all_pdf').prop('disabled', false);

                    clearInterval(loop_and_match);



                    // APPEND DATA TO OBJECT
                    // console.log($('#employees_with_payslip .payslip_row').length);

                    var payslip_data_obj = [];
                    $('#select_empl_1').html(`
                            <option value="">Select Employee 1</option>
                        `);
                    $('#select_empl_2').html(`
                            <option value="">Select Employee 2</option>
                        `);
                    $('#select_empl_3').html(`
                            <option value="">Select Employee 3</option>
                        `);

                    // APPEND PAYSLIP DATA TO OBJECT
                    Array.from($('#employees_with_payslip .payslip_row')).forEach(function(parent) {
                        if ($(parent).is(":visible")) {

                            var empl_id = $(parent.childNodes[1]).attr('empl_id');
                            var empl_cmid = $(parent.childNodes[1]).text();
                            var empl_name = $(parent.childNodes[3]).attr('empl_name');
                            var employment_type = $(parent.childNodes[5]).text();
                            var position = $(parent.childNodes[7]).text();
                            var net_pay = $(parent.childNodes[11]).attr('db_net_pay');
                            var td_btn_pdf = parent.childNodes[13];
                            var download_pdf_btn = $(td_btn_pdf).find('a');

                            var payslip_id = $(download_pdf_btn).attr('payslip_id');
                            var empl_sect = $(download_pdf_btn).attr('empl_sect');
                            var empl_dept = $(download_pdf_btn).attr('empl_dept');
                            var used_sick_leave = $(download_pdf_btn).attr('used_sick_leave');
                            var used_vacation_leave = $(download_pdf_btn).attr('used_vacation_leave');
                            var loan_balance_amount = $(download_pdf_btn).attr('sss_loan_balance_amount');
                            var loan_amount_paid = $(download_pdf_btn).attr('sss_loan_amount_paid');
                            var pagibig_loan_balance_amount = $(download_pdf_btn).attr('pagibig_loan_balance_amount');
                            var pagibig_loan_amount_paid = $(download_pdf_btn).attr('pagibig_loan_amount_paid');

                            var vacation_leave_balance = $(parent.childNodes[3]).attr('vacation_leave_balance');
                            var sick_leave_balance = $(parent.childNodes[3]).attr('sick_leave_balance');

                            used_sick_leave = parseFloat(used_sick_leave).toFixed(2);
                            used_vacation_leave = parseFloat(used_vacation_leave).toFixed(2);

                            loan_balance_amount = parseFloat(loan_balance_amount).toFixed(2);
                            loan_amount_paid = parseFloat(loan_amount_paid).toFixed(2);

                            pagibig_loan_balance_amount = parseFloat(pagibig_loan_balance_amount).toFixed(2);
                            pagibig_loan_amount_paid = parseFloat(pagibig_loan_amount_paid).toFixed(2);

                            $('#select_empl_1').append(`
                                    <option select_empl_cmid_1="` + empl_cmid + `" value="` + empl_id + `">` + empl_cmid + ` - ` + empl_name + `</option>
                                `)
                            $('#select_empl_2').append(`
                                    <option select_empl_cmid_2="` + empl_cmid + `" value="` + empl_id + `">` + empl_cmid + ` - ` + empl_name + `</option>
                                `)
                            $('#select_empl_3').append(`
                                    <option select_empl_cmid_3="` + empl_cmid + `" value="` + empl_id + `">` + empl_cmid + ` - ` + empl_name + `</option>
                                `)

                            var payslip_data = {

                                net_pay: net_pay,
                                empl_cmid: empl_cmid,
                                empl_name: empl_name,
                                employment_type: employment_type,
                                position: position,
                                payslip_id: payslip_id,
                                empl_sect: empl_sect,
                                empl_dept: empl_dept,
                                used_sick_leave: used_sick_leave,
                                used_vacation_leave: used_vacation_leave,
                                loan_balance_amount: loan_balance_amount,
                                loan_amount_paid: loan_amount_paid,
                                pagibig_loan_balance_amount: pagibig_loan_balance_amount,
                                pagibig_loan_amount_paid: pagibig_loan_amount_paid,
                                vacation_leave_balance: vacation_leave_balance,
                                sick_leave_balance: sick_leave_balance

                            };

                            payslip_data_obj.push(payslip_data);
                        }

                    });

                    // Append Payslip PDF to global obj;
                    global_generate_all_pdf_object = payslip_data_obj;
                    // console.log(payslip_data_obj);


                }
            }

        })



        $('#btn_export_payroll_data').click(function() {
            var table_id = 'tbl_payroll_data';
            var separator = ',';

            // Select rows from table_id
            var rows = document.querySelectorAll('table#' + table_id + ' tr');
            // Construct csv
            var csv = [];
            for (var i = 0; i < rows.length; i++) {
                var row = [],
                    cols = rows[i].querySelectorAll('td, th');
                for (var j = 0; j < cols.length; j++) {
                    // Clean innertext to remove multiple spaces and jumpline (break csv)
                    var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                    // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
                    data = data.replace(/"/g, '""');
                    // Push escaped string
                    row.push('"' + data + '"');
                }
                csv.push(row.join(separator));
            }
            var csv_string = csv.join('\n');

            // Download it
            var filename = 'Export_Payroll_Data.csv';
            var link = document.createElement('a');
            link.style.display = 'none';
            link.setAttribute('target', '_blank');
            link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
            link.setAttribute('download', filename);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        })





        // DELETE PAYSLIP
        $('.btn_delete_payslip').click(function(e) {
            e.preventDefault();

            var payslip_id = $(this).attr('payslip_id');
            var empl_cmid = $(this).attr('empl_cmid');
            var date_period = $('#date_period option:selected').text();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url(); ?>payroll/delete_payslip_data?payslip_id=" + payslip_id + "&date_period=" + date_period + "&empl_cmid=" + empl_cmid;
                }
            })

        })




        // get empl leave url
        var url_get_leave = '<?= base_url() ?>leave/get_empl_leave_data';

        $('.download_pdf').click(function(e) {
            // // console.log('ti_rest_ot_mul: ' + '1');
            // // console.log('ti_rest_nd_ot_mul: ' + '1');
            // // console.log('ti_rest_ot_total: ' + '1');
            // // console.log('ti_rest_nd_ot_total: ' + '1');

            e.preventDefault();

            var download_btn = $(this);
            $(download_btn).find('.loading_indicator').show();
            $(download_btn).find('p').hide();

            var payslip_id = $(this).attr('payslip_id');
            var empl_sect = $(this).attr('empl_sect');
            var empl_dept = $(this).attr('empl_dept');
            var parent_tr = $(this).parent().parent().parent();

            var used_sick_leave = $(this).attr('used_sick_leave');
            var used_vacation_leave = $(this).attr('used_vacation_leave');
            var loan_balance_amount = $(this).attr('sss_loan_balance_amount');
            var loan_amount_paid = $(this).attr('sss_loan_amount_paid');
            var pagibig_loan_balance_amount = $(this).attr('pagibig_loan_balance_amount');
            var pagibig_loan_amount_paid = $(this).attr('pagibig_loan_amount_paid');

            used_sick_leave = parseFloat(used_sick_leave).toFixed(2);
            used_vacation_leave = parseFloat(used_vacation_leave).toFixed(2);

            loan_balance_amount = parseFloat(loan_balance_amount).toFixed(2);
            loan_amount_paid = parseFloat(loan_amount_paid).toFixed(2);

            pagibig_loan_balance_amount = parseFloat(pagibig_loan_balance_amount).toFixed(2);
            pagibig_loan_amount_paid = parseFloat(pagibig_loan_amount_paid).toFixed(2);

            var parent_element = Array.from(parent_tr)[0];
            var employment_type = $(parent_element.childNodes[5]).text();
            var position = $(parent_element.childNodes[7]).text();
            // var net_pay = $(parent_element.childNodes[11]).text();

            get_payslip_data(url4, payslip_id).then(function(data) {
                // // console.log('data fetched!');

                var employee_id = data.payslip_data[0].empl_id;
                var employee_name = data.payslip_data[0].empl_name;

                var working_days = data.payslip_data[0].working_days;
                var absences = data.payslip_data[0].abs_mul;

                var salary_rate = parseFloat(data.payslip_data[0].salary_rate).toFixed(2);
                var db_salary_type = data.payslip_data[0].salary_type;
                var hours_of_work = parseFloat(data.payslip_data[0].hours_of_work);
                var daily_salary = parseFloat(data.payslip_data[0].daily_salary);
                var hourly_salary = parseFloat(data.payslip_data[0].hourly_salary);
                var days_present = parseFloat(data.payslip_data[0].ti_basic_sal_mul);

                var payroll_period = $('#date_period option:selected').text();
                var db_payroll_period = $('#date_period option:selected').attr('db_date');
                var payout = $('#date_period option:selected').attr('payout');

                // CHECK CUTOFF PERIOD
                var split_db_date_name = db_payroll_period.split('/');
                var initial_cutoff_year = split_db_date_name[4];

                var SIL_year = parseInt(initial_cutoff_year);
                var SIL_label = 'SIL ' + (initial_cutoff_year - 1);

                // =================== database data ===================
                // multipliers
                var ti_basic_sal_mul = parseFloat(data.payslip_data[0].ti_basic_sal_mul).toFixed(2);
                var ti_absent_mul = parseFloat(data.payslip_data[0].ti_absent_mul).toFixed(2);
                var ti_no_ti_to_mul = parseFloat(data.payslip_data[0].ti_no_ti_to_mul).toFixed(2);
                var ti_tard_mul = parseFloat(data.payslip_data[0].ti_tard_mul).toFixed(2);
                var ti_half_mul = parseFloat(data.payslip_data[0].ti_half_mul).toFixed(2);
                var ti_undertime_mul = parseFloat(data.payslip_data[0].ti_undertime_mul).toFixed(2);
                var ti_rest_mul = parseFloat(data.payslip_data[0].ti_rest_mul).toFixed(2);
                var ti_rest_sp_hol_mul = parseFloat(data.payslip_data[0].ti_rest_sp_hol_mul).toFixed(2);
                var ti_legal_hol_mul = parseFloat(data.payslip_data[0].ti_legal_hol_mul).toFixed(2);
                var ti_rest_legal_hol_mul = parseFloat(data.payslip_data[0].ti_rest_legal_hol_mul).toFixed(2);
                var ti_reg_ot_mul = parseFloat(data.payslip_data[0].ti_reg_ot_mul).toFixed(2);
                var ti_nd_ot_mul = parseFloat(data.payslip_data[0].ti_nd_ot_mul).toFixed(2);
                var ti_nd_mul = parseFloat(data.payslip_data[0].ti_nd_mul).toFixed(2);
                var ti_leave_mul = parseFloat(data.payslip_data[0].ti_leave_mul).toFixed(2);
                var ti_de_minimis_mul = parseFloat(data.payslip_data[0].ti_de_minimis_mul).toFixed(2);
                var ti_rest_ot_mul = parseFloat(data.payslip_data[0].ti_rest_ot_mul).toFixed(2);
                var ti_rest_nd_ot_mul = parseFloat(data.payslip_data[0].ti_rest_nd_ot_mul).toFixed(2);

                // totals
                var ti_basic_sal_total = parseFloat(data.payslip_data[0].ti_basic_sal_total).toFixed(2);
                var ti_absent_total = parseFloat(data.payslip_data[0].ti_absent_total).toFixed(2);
                var ti_no_ti_to_total = parseFloat(data.payslip_data[0].ti_no_ti_to_total).toFixed(2);
                var ti_tard_total = parseFloat(data.payslip_data[0].ti_tard_total).toFixed(2);
                var ti_half_total = parseFloat(data.payslip_data[0].ti_half_total).toFixed(2);
                var ti_undertime_total = parseFloat(data.payslip_data[0].ti_undertime_total).toFixed(2);
                var ti_rest_total = parseFloat(data.payslip_data[0].ti_rest_total).toFixed(2);
                var ti_rest_sp_hol_total = parseFloat(data.payslip_data[0].ti_rest_sp_hol_total).toFixed(2);
                var ti_legal_hol_total = parseFloat(data.payslip_data[0].ti_legal_hol_total).toFixed(2);
                var ti_rest_legal_hol_total = parseFloat(data.payslip_data[0].ti_rest_legal_hol_total).toFixed(2);
                var ti_reg_ot_total = parseFloat(data.payslip_data[0].ti_reg_ot_total).toFixed(2);
                var ti_nd_ot_total = parseFloat(data.payslip_data[0].ti_nd_ot_total).toFixed(2);
                var ti_nd_total = parseFloat(data.payslip_data[0].ti_nd_total).toFixed(2);
                var ti_leave_total = parseFloat(data.payslip_data[0].ti_leave_total).toFixed(2);
                var ti_de_minimis_total = parseFloat(data.payslip_data[0].ti_de_minimis_total).toFixed(2);
                var ti_rest_ot_total = parseFloat(data.payslip_data[0].ti_rest_ot_total).toFixed(2);
                var ti_rest_nd_ot_total = parseFloat(data.payslip_data[0].ti_rest_nd_ot_total).toFixed(2);

                // console.log('ti_rest_ot_mul: ' + data.payslip_data[0].ti_rest_ot_mul);
                // console.log('ti_rest_nd_ot_mul: ' + data.payslip_data[0].ti_rest_nd_ot_mul);
                // console.log('ti_rest_ot_total: ' + data.payslip_data[0].ti_rest_ot_total);
                // console.log('ti_rest_nd_ot_total: ' + data.payslip_data[0].ti_rest_nd_ot_total);

                // no multilpliers
                var ti_sil_2020 = parseFloat(data.payslip_data[0].ti_sil_2020).toFixed(2);
                var ti_meal = parseFloat(data.payslip_data[0].ti_meal).toFixed(2);
                var ti_gov_cont = parseFloat(data.payslip_data[0].ti_gov_cont).toFixed(2);
                var ti_others = parseFloat(data.payslip_data[0].ti_others).toFixed(2);
                var ti_gross = parseFloat(data.payslip_data[0].ti_gross).toFixed(2);

                // taxes
                var gov_sss_ee = parseFloat(data.payslip_data[0].gov_sss_ee).toFixed(2);
                var gov_philhealth_ee = parseFloat(data.payslip_data[0].gov_philhealth_ee).toFixed(2);
                var gov_pagibig_ee = parseFloat(data.payslip_data[0].gov_pagibig_ee).toFixed(2);
                var gov_total_ee = parseFloat(data.payslip_data[0].gov_total_ee).toFixed(2);
                var comp_cont_sss = parseFloat(data.payslip_data[0].comp_cont_sss).toFixed(2);
                var comp_cont_sss_ec = parseFloat(data.payslip_data[0].comp_cont_sss_ec).toFixed(2);
                var comp_cont_philhealth = parseFloat(data.payslip_data[0].comp_cont_philhealth).toFixed(2);
                var comp_cont_pagibig = parseFloat(data.payslip_data[0].comp_cont_pagibig).toFixed(2);
                var comp_cont_total = parseFloat(data.payslip_data[0].comp_cont_total).toFixed(2);

                // taxable allowance
                var ta_load = parseFloat(data.payslip_data[0].ta_load).toFixed(2);
                var ta_transportation = parseFloat(data.payslip_data[0].ta_transportation).toFixed(2);
                var ta_skill = parseFloat(data.payslip_data[0].ta_skill).toFixed(2);
                var ta_pioneer = parseFloat(data.payslip_data[0].ta_pioneer).toFixed(2);
                var ta_daily_allowance = parseFloat(data.payslip_data[0].ta_daily_allowance).toFixed(2);
                var ta_allowance = parseFloat(data.payslip_data[0].ta_allowance).toFixed(2);
                ta_allowance = parseFloat(ta_allowance) - parseFloat(ta_daily_allowance);

                // total taxable allowance + witholding tax
                var ta_total = parseFloat(data.payslip_data[0].ta_total).toFixed(2);
                var wtax = parseFloat(data.payslip_data[0].wtax).toFixed(2);

                // loans
                var loan_sss_salary = parseFloat(data.payslip_data[0].loan_sss_salary).toFixed(2);
                var loan_sss_calamity = parseFloat(data.payslip_data[0].loan_sss_calamity).toFixed(2);
                var loan_pagibig_salary = parseFloat(data.payslip_data[0].loan_pagibig_salary).toFixed(2);
                var loan_pagibig_calamity = parseFloat(data.payslip_data[0].loan_pagibig_calamity).toFixed(2);
                var loan_emergency = parseFloat(data.payslip_data[0].loan_emergency).toFixed(2);
                var loan_total = parseFloat(data.payslip_data[0].loan_total).toFixed(2);

                // refund
                var tax_refund = parseFloat(data.payslip_data[0].tax_refund).toFixed(2);

                // deductions
                var salary_advance = parseFloat(data.payslip_data[0].salary_advance).toFixed(2);
                var uniform_deduction = parseFloat(data.payslip_data[0].uniform_deduction).toFixed(2);
                var ded_total = parseFloat(data.payslip_data[0].ded_total).toFixed(2);

                // net pay
                var net_pay = parseFloat(data.payslip_data[0].net_pay).toFixed(2);

                // modified db variables
                var ti_meal_earning = 0;
                var ti_gov_cont_earning = 0;
                var ti_others_earning = 0;
                var tax_refund_earning = 0;

                var ti_meal_deduction = 0;
                var ti_gov_cont_deduction = 0;
                var ti_others_deduction = 0;
                var tax_refund_deduction = 0;

                var sss_loan = 0;
                var pagibig_loan = 0;




                if (ti_meal > 0) {
                    ti_meal_earning = Math.abs(parseFloat(ti_meal));
                }
                if (ti_gov_cont < 0) {
                    ti_gov_cont_earning = Math.abs(parseFloat(ti_gov_cont));
                }
                if (ti_others > 0) {
                    ti_others_earning = Math.abs(parseFloat(ti_others));
                }
                if (tax_refund > 0) {
                    tax_refund_earning = Math.abs(parseFloat(tax_refund));
                }

                if (ti_meal < 0) {
                    ti_meal_deduction = Math.abs(parseFloat(ti_meal));
                }
                if (ti_gov_cont > 0) {
                    ti_gov_cont_deduction = Math.abs(parseFloat(ti_gov_cont));
                }
                if (ti_others < 0) {
                    ti_others_deduction = Math.abs(parseFloat(ti_others));
                }
                if (tax_refund < 0) {
                    tax_refund_deduction = Math.abs(parseFloat(tax_refund));
                }

                if (net_pay == 0) {
                    net_pay = '-';
                }

                // for modified db variables
                if (sss_loan > 0) {
                    sss_loan,
                    sss_loan = (parseFloat(loan_sss_salary) + parseFloat(loan_sss_calamity)).toFixed(2);
                }
                if (pagibig_loan > 0) {
                    pagibig_loan,
                    pagibig_loan = (parseFloat(loan_pagibig_salary) + parseFloat(loan_pagibig_calamity)).toFixed(2);
                }





                // total_earnings =  parseFloat(ti_rest_sp_hol_total) + parseFloat(ti_basic_sal_total) + parseFloat(ti_leave_total) + parseFloat(ta_allowance) + parseFloat(ti_legal_hol_total) + parseFloat(ti_reg_ot_total) + parseFloat(ti_rest_total) + parseFloat(ti_nd_total) + parseFloat(ti_nd_ot_total) + parseFloat(ti_de_minimis_total) + parseFloat(ti_sil_2020) + parseFloat(ti_meal_earning) + parseFloat(ti_gov_cont_earning) + parseFloat(ti_others_earning) + parseFloat(tax_refund_earning);
                total_earnings = parseFloat(ti_rest_sp_hol_total) + parseFloat(ti_basic_sal_total) + parseFloat(ti_leave_total) + parseFloat(ta_daily_allowance) + parseFloat(ta_allowance) + parseFloat(ti_legal_hol_total) + parseFloat(ti_reg_ot_total) + parseFloat(ti_rest_total) + parseFloat(ti_nd_total) + parseFloat(ti_nd_ot_total) + parseFloat(ti_de_minimis_total) + parseFloat(ti_rest_ot_total) + parseFloat(ti_rest_nd_ot_total) + parseFloat(ti_sil_2020) + parseFloat(ti_meal_earning) + parseFloat(ti_gov_cont_earning) + parseFloat(ti_others_earning) + parseFloat(tax_refund_earning);
                // total_earnings =  parseFloat(ti_rest_sp_hol_total) + parseFloat(ti_basic_sal_total) + parseFloat(ti_leave_total) + parseFloat(ta_daily_allowance) + parseFloat(ta_allowance) + parseFloat(ti_legal_hol_total) + parseFloat(ti_reg_ot_total) + parseFloat(ti_rest_total) + parseFloat(ti_nd_total) + parseFloat(ti_nd_ot_total) + parseFloat(ti_de_minimis_total) + parseFloat(ti_rest_ot_total) + parseFloat(ti_rest_nd_ot_total) + parseFloat(ti_meal_earning) + parseFloat(ti_gov_cont_earning) + parseFloat(ti_others_earning) + parseFloat(tax_refund_earning);
                total_deductions = parseFloat(wtax) + parseFloat(gov_sss_ee) + parseFloat(gov_philhealth_ee) + parseFloat(gov_pagibig_ee) + parseFloat(loan_amount_paid) + parseFloat(pagibig_loan_amount_paid) + parseFloat(ti_absent_total) + parseFloat(ti_tard_total) + parseFloat(ti_undertime_total) + parseFloat(ti_no_ti_to_total) + parseFloat(ti_half_total) + parseFloat(salary_advance) + parseFloat(uniform_deduction) + parseFloat(ti_meal_deduction) + parseFloat(ti_gov_cont_deduction) + parseFloat(ti_others_deduction) + parseFloat(tax_refund_deduction);

                total_earnings = parseFloat(total_earnings).toFixed(2);
                total_deductions = parseFloat(total_deductions).toFixed(2);

                if (ti_meal_earning <= 0) {
                    ti_meal_earning = '-';
                }
                if (ti_gov_cont_earning <= 0) {
                    ti_gov_cont_earning = '-';
                }
                if (ti_others_earning <= 0) {
                    ti_others_earning = '-';
                }
                if (tax_refund_earning <= 0) {
                    tax_refund_earning = '-';
                }
                if (ti_meal_deduction <= 0) {
                    ti_meal_deduction = '-';
                }
                if (ti_gov_cont_deduction <= 0) {
                    ti_gov_cont_deduction = '-';
                }
                if (ti_others_deduction <= 0) {
                    ti_others_deduction = '-';
                }
                if (tax_refund_deduction <= 0) {
                    tax_refund_deduction = '-';
                }

                if (sss_loan <= 0) {
                    sss_loan = '-';
                }
                if (pagibig_loan <= 0) {
                    pagibig_loan = '-';
                }

                if (ti_basic_sal_mul <= 0) {
                    ti_basic_sal_mul = '-';
                }
                if (ti_absent_mul <= 0) {
                    ti_absent_mul = '-';
                }
                if (ti_no_ti_to_mul <= 0) {
                    ti_no_ti_to_mul = '-';
                }
                if (ti_tard_mul <= 0) {
                    ti_tard_mul = '-';
                }
                if (ti_half_mul <= 0) {
                    ti_half_mul = '-';
                }
                if (ti_undertime_mul <= 0) {
                    ti_undertime_mul = '-';
                }
                if (ti_rest_mul <= 0) {
                    ti_rest_mul = '-';
                }
                if (ti_rest_sp_hol_mul <= 0) {
                    ti_rest_sp_hol_mul = '-';
                }
                if (ti_legal_hol_mul <= 0) {
                    ti_legal_hol_mul = '-';
                }
                if (ti_rest_legal_hol_mul <= 0) {
                    ti_rest_legal_hol_mul = '-';
                }
                if (ti_reg_ot_mul <= 0) {
                    ti_reg_ot_mul = '-';
                }
                if (ti_nd_ot_mul <= 0) {
                    ti_nd_ot_mul = '-';
                }
                if (ti_nd_mul <= 0) {
                    ti_nd_mul = '-';
                }
                if (ti_rest_ot_mul <= 0) {
                    ti_rest_ot_mul = '-';
                }
                if (ti_rest_nd_ot_mul <= 0) {
                    ti_rest_nd_ot_mul = '-';
                }

                if (ti_basic_sal_total <= 0) {
                    ti_basic_sal_total = '-';
                }
                if (ti_absent_total <= 0) {
                    ti_absent_total = '-';
                }
                if (ti_no_ti_to_total <= 0) {
                    ti_no_ti_to_total = '-';
                }
                if (ti_tard_total <= 0) {
                    ti_tard_total = '-';
                }
                if (ti_half_total <= 0) {
                    ti_half_total = '-';
                }
                if (ti_undertime_total <= 0) {
                    ti_undertime_total = '-';
                }
                if (ti_rest_total <= 0) {
                    ti_rest_total = '-';
                }
                if (ti_rest_sp_hol_total <= 0) {
                    ti_rest_sp_hol_total = '-';
                }
                if (ti_legal_hol_total <= 0) {
                    ti_legal_hol_total = '-';
                }
                if (ti_rest_legal_hol_total <= 0) {
                    ti_rest_legal_hol_total = '-';
                }
                if (ti_reg_ot_total <= 0) {
                    ti_reg_ot_total = '-';
                }
                if (ti_nd_ot_total <= 0) {
                    ti_nd_ot_total = '-';
                }
                if (ti_nd_total <= 0) {
                    ti_nd_total = '-';
                }
                if (ti_leave_total <= 0) {
                    ti_leave_total = '-';
                }
                if (ti_de_minimis_total <= 0) {
                    ti_de_minimis_total = '-';
                }
                if (ti_rest_ot_total <= 0) {
                    ti_rest_ot_total = '-';
                }
                if (ti_rest_nd_ot_total <= 0) {
                    ti_rest_nd_ot_total = '-';
                }

                if (ti_sil_2020 <= 0) {
                    ti_sil_2020 = '-';
                }
                if (ti_meal <= 0) {
                    ti_meal = '-';
                }
                if (ti_gov_cont <= 0) {
                    ti_gov_cont = '-';
                }
                if (ti_others <= 0) {
                    ti_others = '-';
                }
                if (ti_gross <= 0) {
                    ti_gross = '-';
                }
                if (gov_sss_ee <= 0) {
                    gov_sss_ee = '-';
                }
                if (gov_philhealth_ee <= 0) {
                    gov_philhealth_ee = '-';
                }
                if (gov_pagibig_ee <= 0) {
                    gov_pagibig_ee = '-';
                }
                if (gov_total_ee <= 0) {
                    gov_total_ee = '-';
                }
                if (comp_cont_sss <= 0) {
                    comp_cont_sss = '-';
                }
                if (comp_cont_sss_ec <= 0) {
                    comp_cont_sss_ec = '-';
                }
                if (comp_cont_philhealth <= 0) {
                    comp_cont_philhealth = '-';
                }
                if (comp_cont_pagibig <= 0) {
                    comp_cont_pagibig = '-';
                }
                if (comp_cont_total <= 0) {
                    comp_cont_total = '-';
                }
                if (ta_load <= 0) {
                    ta_load = '-';
                }
                if (ta_transportation <= 0) {
                    ta_transportation = '-';
                }
                if (ta_skill <= 0) {
                    ta_skill = '-';
                }
                if (ta_pioneer <= 0) {
                    ta_pioneer = '-';
                }
                if (ta_daily_allowance == 0) {
                    ta_daily_allowance = '-';
                }
                if (ta_allowance <= 0) {
                    ta_allowance = '-';
                }
                if (ta_total <= 0) {
                    ta_total = '-';
                }
                if (wtax <= 0) {
                    wtax = '-';
                }
                if (loan_sss_salary <= 0) {
                    loan_sss_salary = '-';
                }
                if (loan_sss_calamity <= 0) {
                    loan_sss_calamity = '-';
                }
                if (loan_pagibig_salary <= 0) {
                    loan_pagibig_salary = '-';
                }
                if (loan_pagibig_calamity <= 0) {
                    loan_pagibig_calamity = '-';
                }
                if (loan_emergency <= 0) {
                    loan_emergency = '-';
                }
                if (loan_total <= 0) {
                    loan_total = '-';
                }
                if (tax_refund <= 0) {
                    tax_refund = '-';
                }
                if (salary_advance <= 0) {
                    salary_advance = '-';
                }
                if (uniform_deduction <= 0) {
                    uniform_deduction = '-';
                }
                if (ded_total <= 0) {
                    ded_total = '-';
                }
                if (net_pay <= 0) {
                    net_pay = '-';
                }
                if (ti_leave_mul <= 0) {
                    ti_leave_mul = '-';
                }

                if (loan_amount_paid <= 0) {
                    loan_amount_paid = '-';
                }
                if (pagibig_loan_amount_paid <= 0) {
                    pagibig_loan_amount_paid = '-';
                }



                // // console.log(ti_leave_mul)


                getEmployeeData(url3, employee_id).then(function(x) {
                    var employee_cmid = x.employee_data[0].col_empl_cmid;
                    var vacation_leave_balance = x.employee_data[0].col_leave_vacation;
                    var sick_leave_balance = x.employee_data[0].col_leave_sick;

                    var doc = new jsPDF();

                    get_empl_leave_data(url_get_leave, employee_id).then(function(leave) {

                        Array.from(leave).forEach(function(employee_data) {



                            // You'll need to make your image into a Data URL
                            // Use http://dataurl.net/#dataurlmaker
                            // SETTINGS
                            var imgData = 'data:image/jpeg;base64,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AAAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAA4QklNBAAAAAAAAAIAAThCSU0EAgAAAAAABAAAAAA4QklNBDAAAAAAAAIBAThCSU0ELQAAAAAABgABAAAAAjhCSU0ECAAAAAAAEAAAAAEAAAJAAAACQAAAAAA4QklNBB4AAAAAAAQAAAAAOEJJTQQaAAAAAANJAAAABgAAAAAAAAAAAAAAeQAAANcAAAAKAFUAbgB0AGkAdABsAGUAZAAtADIAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAANcAAAB5AAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAEAAAAAEAAAAAAABudWxsAAAAAgAAAAZib3VuZHNPYmpjAAAAAQAAAAAAAFJjdDEAAAAEAAAAAFRvcCBsb25nAAAAAAAAAABMZWZ0bG9uZwAAAAAAAAAAQnRvbWxvbmcAAAB5AAAAAFJnaHRsb25nAAAA1wAAAAZzbGljZXNWbExzAAAAAU9iamMAAAABAAAAAAAFc2xpY2UAAAASAAAAB3NsaWNlSURsb25nAAAAAAAAAAdncm91cElEbG9uZwAAAAAAAAAGb3JpZ2luZW51bQAAAAxFU2xpY2VPcmlnaW4AAAANYXV0b0dlbmVyYXRlZAAAAABUeXBlZW51bQAAAApFU2xpY2VUeXBlAAAAAEltZyAAAAAGYm91bmRzT2JqYwAAAAEAAAAAAABSY3QxAAAABAAAAABUb3AgbG9uZwAAAAAAAAAATGVmdGxvbmcAAAAAAAAAAEJ0b21sb25nAAAAeQAAAABSZ2h0bG9uZwAAANcAAAADdXJsVEVYVAAAAAEAAAAAAABudWxsVEVYVAAAAAEAAAAAAABNc2dlVEVYVAAAAAEAAAAAAAZhbHRUYWdURVhUAAAAAQAAAAAADmNlbGxUZXh0SXNIVE1MYm9vbAEAAAAIY2VsbFRleHRURVhUAAAAAQAAAAAACWhvcnpBbGlnbmVudW0AAAAPRVNsaWNlSG9yekFsaWduAAAAB2RlZmF1bHQAAAAJdmVydEFsaWduZW51bQAAAA9FU2xpY2VWZXJ0QWxpZ24AAAAH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UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAyMS0wOC0xMFQwOToyNDo1MCswODowMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAyMS0wOC0xMFQwOToyNDo1MCswODowMCIgeG1wOk1vZGlmeURhdGU9IjIwMjEtMDgtMTBUMDk6MjQ6NTArMDg6MDAiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NTQyNEZDQzE3OUY5RUIxMUFGOENBMEMyQjc0ODU5QTkiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NTMyNEZDQzE3OUY5RUIxMUFGOENBMEMyQjc0ODU5QTkiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo1MzI0RkNDMTc5RjlFQjExQUY4Q0EwQzJCNzQ4NTlBOSIgZGM6Zm9ybWF0PSJpbWFnZS9qcGVnIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIj4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY3JlYXRlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo1MzI0RkNDMTc5RjlFQjExQUY4Q0EwQzJCNzQ4NTlBOSIgc3RFdnQ6d2hlbj0iMjAyMS0wOC0xMFQwOToyNDo1MCswODowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjU0MjRGQ0MxNzlGOUVCMTFBRjhDQTBDMkI3NDg1OUE5IiBzdEV2dDp3aGVuPSIyMDIxLTA4LTEwVDA5OjI0OjUwKzA4OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPD94cGFja2V0IGVuZD0idyI/Pv/uAA5BZG9iZQBkQAAAAAH/2wCEAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQECAgICAgICAgICAgMDAwMDAwMDAwMBAQEBAQEBAQEBAQICAQICAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDA//AABEIAHkA1wMBEQACEQEDEQH/3QAEABv/xAGiAAAABgIDAQAAAAAAAAAAAAAHCAYFBAkDCgIBAAsBAAAGAwEBAQAAAAAAAAAAAAYFBAMHAggBCQAKCxAAAgEDBAEDAwIDAwMCBgl1AQIDBBEFEgYhBxMiAAgxFEEyIxUJUUIWYSQzF1JxgRhikSVDobHwJjRyChnB0TUn4VM2gvGSokRUc0VGN0djKFVWVxqywtLi8mSDdJOEZaOzw9PjKThm83UqOTpISUpYWVpnaGlqdnd4eXqFhoeIiYqUlZaXmJmapKWmp6ipqrS1tre4ubrExcbHyMnK1NXW19jZ2uTl5ufo6er09fb3+Pn6EQACAQMCBAQDBQQEBAYGBW0BAgMRBCESBTEGACITQVEHMmEUcQhCgSORFVKhYhYzCbEkwdFDcvAX4YI0JZJTGGNE8aKyJjUZVDZFZCcKc4OTRnTC0uLyVWV1VjeEhaOzw9Pj8ykalKS0xNTk9JWltcXV5fUoR1dmOHaGlqa2xtbm9md3h5ent8fX5/dIWGh4iJiouMjY6Pg5SVlpeYmZqbnJ2en5KjpKWmp6ipqqusra6vr/2gAMAwEAAhEDEQA/AN/j37r3Xvfuvde9+691737r3Xvfuvde9+691737r3XvfuvdcDIgbTqGr66fzb+tv6e/de6xipjOr9foYqbow5Fybcc/T37r3ST3rvja2wdtZbeO7s3j9vbbwVHJX5XLZWdaSkpaWFWeRnllZFaQjhE/UzGwBJt7917quD45fzR+lvkd3Znends4PcGLlNXWQbP3HPTyPR7qgoA71NUYoYNeI1pH5YlmtqiILlW9Hv3XurQqaojkZBGfIoRrym97qwX6EAkMfz+R7917qWZkAuSQLX5BFrkgXv8AQ8fT37r3WRSGAYcgi4Pv3Xuu/fuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3X/9Df49+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3TVUeCJjWujmRAyKE1FmNz6VUcEn/ePfuvdAz3p8gOs/j319luxu0Ny0OAw+Li1wUbzwtlstWuCtLisTjzItTX5CqkNljReACxsqkj3XutVvu/5HfJb+aV21H1515iclgepMPWzVtPt9amajwGFw0EhD7t7EyySCjeempyrgSHxwyERxh5CC/uvdM+9+7etviDteq6Y+J+Wo9w9m1sD4ztL5FRRRGvld0C1m3euZ1802IxYmDCWpikYSaUOokK6+691a3/Lo+XfbOC6Umz3y4zFDt7qujqKTEde9l7yr/wCH7j3JV1E0MSY+KOohNTuHHQoSf4gWJQxkMzrdk917q7TG5egzuLxuUxks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e6b+3viF8aO/M7j9zdy9M7G7Gz+Kxgw2Oyu6cNBk6ykxgnlqhRQyzAlIRPMzW/qffuvdBK38sz4Et9fit0//ALDalD/0b7917pY7P+BPwx2FWxZLanxl6YxWQgcSQVy7A25VVkEgIOuGprKConha4B9LDn37r3RpqPD4zHUsNFj6GmoaOnRY4KWjhjpqeGNBZY4oYVSNIwP7IFvfuvdIfs/p/rTujZ9ZsDtLZ+I3vszIVFHV1+3M9AazFVtRj6mOtonq6V28dQKashSVVcFRIita4Fvde6B/rD4QfE3pfd9Fv3qzobrrY+8sbTVtHQbiwO36SjylJTZGA01bFT1SqZIhUU5KMQQSrEfk3917o0ngj44PF+AzAc/kgEAn/X/p7917pEdgdXde9rbXyGyuyNn7f3ttTKoY8jgNy4yky2Mq1NiPLS1kUsZZSLq1tSkXBB9+690XrYnwB+G3WO78Hv7YHx5632lvHbVX99gdw4TBQ0OSxVWUMbTUdRCVaFnjbS1uGHBv7917pUdufDX4v987kpt39xdK7G7E3NR4uLCUua3RiIsnX0+JgqKqrhx8M892jpYqisldUFgC5/wt7r3QidRdHdTdCbYqNmdO7E2915taqy1TnajB7ZoYsfQTZisgpaWqyEkMYs1TNTUMMbMedESj6Ae/de6Fa3Fvx9Pfuvdf/9bf49+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvdf/Z';
                            var doc = new jsPDF()


                            doc.setFontSize(8);

                            // HEADER
                            doc.text(5, 5, 'BANDAI WIREHARNESS PHILIPPINES INC');

                            doc.text(10, 13, 'Employee ID:');
                            doc.text(10, 16.5, 'Employee Name:');
                            doc.text(10, 20, 'Position:');
                            doc.text(10, 23.5, 'Department:');
                            doc.text(10, 27, 'Section:');

                            doc.text(65, 13, "" + employee_cmid + "");
                            doc.text(65, 16.5, employee_name);
                            doc.text(65, 20, position);
                            doc.text(65, 23.5, empl_dept);
                            doc.text(65, 27, empl_sect);

                            doc.text(115, 5, 'Payroll Pay-out:');
                            doc.text(115, 9, 'Payroll Cut-Off:');

                            doc.text(115, 16.5, 'Salary Type:');
                            doc.text(115, 20, 'Salary:');
                            doc.text(115, 23.5, 'Working Days:');
                            doc.text(115, 27, 'Absences:');

                            doc.text(170, 5, payout);
                            doc.text(170, 9, payroll_period);

                            doc.text(170, 16.5, "" + db_salary_type + "");
                            doc.text(170, 20, "" + salary_rate + "");
                            doc.text(170, 23.5, "" + days_present + "");
                            doc.text(170, 27, "" + ti_absent_mul + "");

                            // SALARY TABLE
                            //--- Table Design ----
                            doc.setLineWidth(0.8)
                            doc.rect(10, 30, 190, 88);
                            doc.setLineWidth(0.5)
                            doc.line(10, 35, 200, 35) // horizontal line
                            doc.line(10, 110, 200, 110) // horizontal line
                            doc.line(160, 55, 200, 55) // horizontal line
                            doc.line(160, 60, 200, 60) // horizontal line
                            doc.line(160, 105, 200, 105) // horizontal line
                            doc.line(40, 30, 40, 35) // vertical
                            doc.line(58, 30, 58, 35) // vertical
                            doc.line(115, 30, 115, 35) // vertical
                            doc.line(133, 30, 133, 35) // vertical

                            doc.line(85, 30, 85, 118) // vertical
                            doc.line(160, 30, 160, 118) // vertical
                            //doc.line(10, 90, 190, 90) // horizontal line
                            //doc.line(10, 95, 190, 95) // horizontal line

                            doc.text(16, 33.5, 'DESCRIPTION');
                            doc.text(41, 33.5, 'DAYS/HRS');
                            doc.text(67, 33.5, 'AMOUNT');

                            doc.text(91, 33.5, 'DESCRIPTION');
                            doc.text(116, 33.5, 'DAYS/HRS');
                            doc.text(142, 33.5, 'AMOUNT');

                            doc.text(169, 33.5, 'LEAVE BALANCES');
                            doc.text(169, 58.5, 'LOAN BALANCES');
                            doc.setFontSize(7);
                            doc.setFont(undefined, 'bold');
                            doc.text(12, 38, 'EARNINGS');
                            doc.setFont(undefined, 'normal');
                            doc.text(14, 42, 'Basic Salary');
                            doc.text(14, 45.5, 'Paid Leave');
                            doc.text(14, 49, 'Daily Allowance');
                            doc.text(14, 52.5, 'Total Allowance');
                            doc.text(14, 56, 'Regular/Legal Holiday');
                            doc.text(14, 59.5, 'Regular OT');
                            doc.text(14, 63, 'Rest Day> 6 Hrs');
                            doc.text(14, 66.5, 'Rest Day OT');
                            doc.text(14, 70, 'Night Differential');
                            doc.text(14, 73.5, 'OT Night Differential');
                            doc.text(14, 77, 'Rest Day ND OT');
                            doc.text(14, 80.5, 'Meal Allowance');
                            // doc.text(14,84,'SIL 2020');
                            doc.text(14, 84, SIL_label);
                            if (ti_rest_sp_hol_mul != 0) {
                                doc.text(14, 87.5, 'Rest + Special Holiday');
                            }
                            doc.setFont(undefined, 'bold');
                            doc.text(12, 91, 'ADJUSTMENTS');
                            doc.setFont(undefined, 'normal');
                            doc.text(14, 94.5, 'Meal Allowance');
                            doc.text(14, 98, 'Govt. Conributions');
                            doc.text(14, 101, 'Others');
                            doc.text(14, 104.5, '13th Month Pay');
                            doc.text(14, 108, 'Tax Refund');

                            doc.text(56, 42, "" + ti_basic_sal_mul + "", {
                                align: 'right'
                            }); //Basic Salary
                            doc.text(56, 45.5, "" + ti_leave_mul + "", {
                                align: 'right'
                            }); //Paid Leave
                            if (ta_daily_allowance > 0) {
                                doc.text(56, 49, "" + ti_basic_sal_mul + "", {
                                    align: 'right'
                                }); //Daily Allowance
                            } else {
                                doc.text(56, 49, "-", {
                                    align: 'right'
                                }); //Daily Allowance
                            }

                            doc.text(56, 56, "" + ti_legal_hol_mul + "", {
                                align: 'right'
                            }); //Regular/Legal Holiday
                            doc.text(56, 59.5, "" + ti_reg_ot_mul + "", {
                                align: 'right'
                            }); //Regular OT
                            doc.text(56, 63, "" + ti_rest_mul + "", {
                                align: 'right'
                            }); //Rest Day> 6 Hrs
                            doc.text(56, 66.5, "" + ti_rest_ot_mul + "", {
                                align: 'right'
                            }); //Rest Day OT
                            doc.text(56, 70, "" + ti_nd_mul + "", {
                                align: 'right'
                            }); //Night Differential
                            doc.text(56, 73.5, "" + ti_nd_ot_mul + "", {
                                align: 'right'
                            }); //OT Night Differential
                            doc.text(56, 77, "" + ti_rest_nd_ot_mul + "", {
                                align: 'right'
                            }); //Rest Day ND OT
                            doc.text(56, 80.5, "" + ti_de_minimis_mul + "", {
                                align: 'right'
                            }); //Meal Allowance
                            doc.text(56, 84, '-', {
                                align: 'right'
                            }); //SIL 2020
                            if (ti_rest_sp_hol_mul != 0) {
                                doc.text(56, 87.5, "" + ti_rest_sp_hol_mul + "", {
                                    align: 'right'
                                });
                            }

                            doc.text(80, 42, "" + ti_basic_sal_total + "", {
                                align: 'right'
                            }); // Basic Salary
                            doc.text(80, 45.5, "" + ti_leave_total + "", {
                                align: 'right'
                            }); // Paid Leave
                            doc.text(80, 49, "" + ta_daily_allowance + "", {
                                align: 'right'
                            }); // Daily Allowance
                            doc.text(80, 52.5, "" + ta_allowance + "", {
                                align: 'right'
                            }); // Total Allowance
                            doc.text(80, 56, "" + ti_legal_hol_total + "", {
                                align: 'right'
                            }); // Regular/Legal Holiday
                            doc.text(80, 59.5, "" + ti_reg_ot_total + "", {
                                align: 'right'
                            }); // Regular OT
                            doc.text(80, 63, "" + ti_rest_total + "", {
                                align: 'right'
                            }); // Rest Day> 6 Hrs
                            doc.text(80, 66.5, "" + ti_rest_ot_total + "", {
                                align: 'right'
                            }); // Rest Day OT
                            doc.text(80, 70, "" + ti_nd_total + "", {
                                align: 'right'
                            }); // Night Differential
                            doc.text(80, 73.5, "" + ti_nd_ot_total + "", {
                                align: 'right'
                            }); // OT Night Differential
                            doc.text(80, 77, "" + ti_rest_nd_ot_total + "", {
                                align: 'right'
                            }); // Rest Day ND OT
                            doc.text(80, 80.5, "" + ti_de_minimis_total + "", {
                                align: 'right'
                            }); // Meal Allowance
                            doc.text(80, 84, "" + ti_sil_2020 + "", {
                                align: 'right'
                            }); // SIL 2020
                            if (ti_rest_sp_hol_mul != 0) {
                                doc.text(80, 87.5, "" + ti_rest_sp_hol_total + "", {
                                    align: 'right'
                                }); // Rest + Special Holiday
                            }

                            doc.text(80, 94.5, "" + ti_meal_earning + "", {
                                align: 'right'
                            }); //Meal Allowance
                            doc.text(80, 98, "" + ti_gov_cont_earning + "", {
                                align: 'right'
                            }); //Govt. Conributions
                            doc.text(80, 101.5, "" + ti_others_earning + "", {
                                align: 'right'
                            }); //Others
                            doc.text(80, 105, "-", {
                                align: 'right'
                            }); //13th Month Pay
                            doc.text(80, 108.5, "" + tax_refund_earning + "", {
                                align: 'right'
                            }); //Tax Refund

                            doc.setFont(undefined, 'bold');
                            doc.text(87, 38, 'DEDUCTIONS');
                            doc.setFont(undefined, 'normal');
                            doc.text(89, 42, 'Withholding Tax');
                            doc.text(89, 45.5, 'SSS EE Share');
                            doc.text(89, 49, 'PHIC EE Share');
                            doc.text(89, 52.5, 'HDMF EE Share');
                            doc.text(89, 56, 'SSS Loan');
                            doc.text(89, 59.5, 'HDMF Loan');
                            doc.text(89, 63, 'Absences');
                            doc.text(89, 66.5, 'Tardines');
                            doc.text(89, 70, 'Undertime');
                            doc.text(89, 73.5, 'No TI/TO');
                            doc.text(89, 77, 'Half day');
                            doc.text(89, 80.5, 'Advances to Employees ');
                            doc.text(89, 84, 'Uniform');
                            doc.setFont(undefined, 'bold');
                            doc.text(87, 91, 'ADJUSTMENTS');
                            doc.setFont(undefined, 'normal');
                            doc.text(89, 94.5, 'Meal Allowance');
                            doc.text(89, 98, 'Govt. Conributions');
                            doc.text(89, 101.5, 'Others');
                            doc.text(89, 105, '13th Month Pay');
                            doc.text(89, 108.5, 'Tax Refund');

                            doc.text(131, 63, "" + ti_absent_mul + "", {
                                align: 'right'
                            });
                            doc.text(131, 66.5, "" + ti_tard_mul + "", {
                                align: 'right'
                            });
                            doc.text(131, 70, "" + ti_undertime_mul + "", {
                                align: 'right'
                            });
                            doc.text(131, 73.5, "" + ti_no_ti_to_mul + "", {
                                align: 'right'
                            });

                            doc.text(155, 42, "" + wtax + "", {
                                align: 'right'
                            });
                            doc.text(155, 45.5, "" + gov_sss_ee + "", {
                                align: 'right'
                            });
                            doc.text(155, 49, "" + gov_philhealth_ee + "", {
                                align: 'right'
                            });
                            doc.text(155, 52.5, "" + gov_pagibig_ee + "", {
                                align: 'right'
                            });
                            doc.text(155, 56, "" + loan_amount_paid + "", {
                                align: 'right'
                            });
                            doc.text(155, 59.5, "" + pagibig_loan_amount_paid + "", {
                                align: 'right'
                            });
                            doc.text(155, 63, "" + ti_absent_total + "", {
                                align: 'right'
                            });
                            doc.text(155, 66.5, "" + ti_tard_total + "", {
                                align: 'right'
                            });
                            doc.text(155, 70, "" + ti_undertime_total + "", {
                                align: 'right'
                            });
                            doc.text(155, 73.5, "" + ti_no_ti_to_total + "", {
                                align: 'right'
                            });
                            doc.text(155, 77, "" + ti_half_total + "", {
                                align: 'right'
                            });
                            doc.text(155, 80.5, "" + salary_advance + "", {
                                align: 'right'
                            });
                            doc.text(155, 84, "" + uniform_deduction + "", {
                                align: 'right'
                            });

                            doc.text(155, 94.5, "" + ti_meal_deduction + "", {
                                align: 'right'
                            });
                            doc.text(155, 98, "" + ti_gov_cont_deduction + "", {
                                align: 'right'
                            });
                            doc.text(155, 101.5, "" + ti_others_deduction + "", {
                                align: 'right'
                            });
                            doc.text(155, 105, "-", {
                                align: 'right'
                            });
                            doc.text(155, 108.5, "" + tax_refund_deduction + "", {
                                align: 'right'
                            });

                            doc.text(174, 39, 'USED');
                            doc.text(190, 39, 'BAL');
                            doc.text(162, 42.5, 'VL');
                            doc.text(162, 46, 'SL');
                            doc.text(181, 42.5, "" + used_vacation_leave + "", {
                                align: 'right'
                            });
                            doc.text(181, 46, "" + used_sick_leave + "", {
                                align: 'right'
                            });
                            doc.text(198, 42.5, "" + vacation_leave_balance + "", {
                                align: 'right'
                            });
                            doc.text(198, 46, "" + sick_leave_balance + "", {
                                align: 'right'
                            });

                            doc.text(174, 63, 'USED');
                            doc.text(190, 63, 'BAL');
                            doc.text(162, 66.5, 'SSS');
                            doc.text(162, 70, 'HDMF');
                            doc.text(181, 66.5, "" + loan_amount_paid + "", {
                                align: 'right'
                            });
                            doc.text(181, 70, "" + pagibig_loan_amount_paid + "", {
                                align: 'right'
                            });
                            // doc.text(198,66.5,""+loan_balance_amount+"",{align:'right'});
                            // doc.text(198,70,""+pagibig_loan_balance_amount+"",{align:'right'});
                            doc.text(198, 66.5, "-", {
                                align: 'center'
                            });
                            doc.text(198, 70, "-", {
                                align: 'center'
                            });

                            doc.setFont(undefined, 'bold');
                            doc.text(12, 115, 'TOTAL EARNINGS');
                            doc.setFont(undefined, 'normal');
                            doc.text(80, 115, "" + total_earnings + "", {
                                align: 'right'
                            });

                            doc.setFont(undefined, 'bold');
                            doc.text(87, 115, 'TOTAL DEDUCTIONS');
                            doc.setFont(undefined, 'normal');
                            doc.text(155, 115, "" + total_deductions + "", {
                                align: 'right'
                            });

                            doc.text(175, 108, 'NET PAY');
                            doc.setFont(undefined, 'bold');
                            doc.text(180, 115, "" + net_pay + "", {
                                align: 'center'
                            });
                            doc.setFont(undefined, 'normal');

                            doc.text(15, 125, 'Received By:');
                            doc.line(35, 125, 85, 125) // horizontal line
                            doc.text(15, 130, 'Date:');
                            doc.line(35, 130, 85, 130);


                            doc.save(employee_name + " - Payslip.pdf");

                            $(download_btn).find('.loading_indicator').hide();
                            $(download_btn).find('p').show();
                        })
                    })

                })

            })
        })













        var empl_id_arr = [];
        var empl_info_arr = [];

        get_employee_all_ampl_data(url_get_employee_all_ampl_data, 'test').then(function(data) {
            empl_info_arr = data;
        })

        function findObjectByKey(array, key, value) {
            for (var i = 0; i < array.length; i++) {
                if (array[i][key] === value) {
                    return array[i];
                }
            }
            return null;
        }


        var isReadyForDownload = false;

        $('#download_csv').click(function() {
            $('#export_csv_loading_indicator').show();
            $(this).hide();

            $('#payroll_data_container').html('');

            // // console.log(empl_info_arr);
            var cutoff_id = $('#date_period').val();
            console.log(cutoff_id);

            get_payslip_data_based_on_period(url_payroll_data_based_period, cutoff_id).then(function(data) {
                $('#payroll_data_container').html('');
                // // console.log(data.length);

                Array.from(data).forEach(function(x) {

                    var obj = findObjectByKey(empl_info_arr, 'id', "" + x.empl_id + "");

                    // console.log(x.empl_id);

                    var employee_id = '';
                    var empl_dept = '';
                    var empl_sect = '';
                    var empl_posi = '';

                    if (obj) {
                        employee_id = obj.col_empl_cmid;
                        empl_dept = obj.col_empl_dept;
                        empl_sect = obj.col_empl_sect;
                        empl_posi = obj.col_empl_posi;
                    }

                    var empl_id = employee_id;

                    // console.log('empl_id: ' + empl_id);

                    var empl_name = x.empl_name;
                    var salary_type = x.salary_type;
                    var salary_rate = x.salary_rate;
                    var work_rate = x.work_rate;
                    var daily_salary = x.daily_salary;
                    var hourly_salary = x.hourly_salary;
                    var payroll_period = x.payroll_period;
                    var payroll_type = x.payroll_type;
                    var working_days = x.working_days;
                    var hours_of_work = x.hours_of_work;
                    var ti_basic_sal_mul = x.ti_basic_sal_mul;
                    var ti_absent_mul = x.ti_absent_mul;
                    var ti_no_ti_to_mul = x.ti_no_ti_to_mul;
                    var ti_tard_mul = x.ti_tard_mul;
                    var ti_half_mul = x.ti_half_mul;
                    var ti_undertime_mul = x.ti_undertime_mul;
                    var ti_rest_mul = x.ti_rest_mul;
                    var ti_rest_sp_hol_mul = x.ti_rest_sp_hol_mul;
                    var ti_legal_hol_mul = x.ti_legal_hol_mul;
                    var ti_rest_legal_hol_mul = x.ti_rest_legal_hol_mul;
                    var ti_reg_ot_mul = x.ti_reg_ot_mul;
                    var ti_nd_ot_mul = x.ti_nd_ot_mul;
                    var ti_nd_mul = x.ti_nd_mul;
                    var ti_leave_mul = x.ti_leave_mul;
                    var ti_de_minimis_mul = x.ti_de_minimis_mul;
                    var ti_rest_ot_mul = x.ti_rest_ot_mul;
                    var ti_rest_nd_ot_mul = x.ti_rest_nd_ot_mul;
                    var ti_basic_sal_total = x.ti_basic_sal_total;
                    var ti_absent_total = x.ti_absent_total;
                    var ti_no_ti_to_total = x.ti_no_ti_to_total;
                    var ti_tard_total = x.ti_tard_total;
                    var ti_half_total = x.ti_half_total;
                    var ti_undertime_total = x.ti_undertime_total;
                    var ti_rest_total = x.ti_rest_total;
                    var ti_rest_sp_hol_total = x.ti_rest_sp_hol_total;
                    var ti_legal_hol_total = x.ti_legal_hol_total;
                    var ti_rest_legal_hol_total = x.ti_rest_legal_hol_total;
                    var ti_reg_ot_total = x.ti_reg_ot_total;
                    var ti_nd_ot_total = x.ti_nd_ot_total;
                    var ti_nd_total = x.ti_nd_total;
                    var ti_leave_total = x.ti_leave_total;
                    var ti_de_minimis_total = x.ti_de_minimis_total;
                    var ti_rest_ot_total = x.ti_rest_ot_total;
                    var ti_rest_nd_ot_total = x.ti_rest_nd_ot_total;
                    var ti_sil_2020 = x.ti_sil_2020;
                    var ti_meal = x.ti_meal;
                    var ti_gov_cont = x.ti_gov_cont;
                    var ti_others = x.ti_others;
                    var ti_gross = x.ti_gross;
                    var gov_sss_ee = x.gov_sss_ee;
                    var gov_philhealth_ee = x.gov_philhealth_ee;
                    var gov_pagibig_ee = x.gov_pagibig_ee;
                    var gov_total_ee = x.gov_total_ee;
                    var comp_cont_sss = x.comp_cont_sss;
                    var comp_cont_sss_ec = x.comp_cont_sss_ec;
                    var comp_cont_philhealth = x.comp_cont_philhealth;
                    var comp_cont_pagibig = x.comp_cont_pagibig;
                    var comp_cont_total = x.comp_cont_total;
                    var ta_load = x.ta_load;
                    var ta_transportation = x.ta_transportation;
                    var ta_skill = x.ta_skill;
                    var ta_pioneer = x.ta_pioneer;
                    var ta_allowance = x.ta_allowance;
                    var ta_total = x.ta_total;
                    var wtax = x.wtax;
                    var loan_sss_salary = x.loan_sss_salary;
                    var loan_sss_calamity = x.loan_sss_calamity;
                    var loan_pagibig_salary = x.loan_pagibig_salary;
                    var loan_pagibig_calamity = x.loan_pagibig_calamity;
                    var loan_emergency = x.loan_emergency;
                    var loan_total = x.loan_total;
                    var tax_refund = x.tax_refund;
                    var salary_advance = x.salary_advance;
                    var uniform_deduction = x.uniform_deduction;
                    var ded_total = x.ded_total;
                    var net_pay = x.net_pay;

                    $('#payroll_data_container').append(`
                            <tr>
                                <td>` + empl_id + `</td>
                                <td>` + empl_name + `</td>
                                <td>` + empl_dept + `</td>
                                <td>` + empl_sect + `</td>
                                <td>` + empl_posi + `</td>
                                <td>` + salary_type + `</td>
                                <td>` + salary_rate + `</td>
                                <td>` + work_rate + `</td>
                                <td>` + daily_salary + `</td>
                                <td>` + hourly_salary + `</td>
                                <td>` + payroll_period + `</td>
                                <td>` + payroll_type + `</td>
                                <td>` + working_days + `</td>
                                <td>` + hours_of_work + `</td>
                                <td>` + ti_basic_sal_mul + `</td>
                                <td>` + ti_absent_mul + `</td>
                                <td>` + ti_no_ti_to_mul + `</td>
                                <td>` + ti_tard_mul + `</td>
                                <td>` + ti_half_mul + `</td>
                                <td>` + ti_undertime_mul + `</td>
                                <td>` + ti_rest_mul + `</td>
                                <td>` + ti_rest_sp_hol_mul + `</td>
                                <td>` + ti_legal_hol_mul + `</td>
                                <td>` + ti_rest_legal_hol_mul + `</td>
                                <td>` + ti_reg_ot_mul + `</td>
                                <td>` + ti_nd_ot_mul + `</td>
                                <td>` + ti_nd_mul + `</td>
                                <td>` + ti_leave_mul + `</td>
                                <td>` + ti_de_minimis_mul + `</td>
                                <td>` + ti_rest_ot_mul + `</td>
                                <td>` + ti_rest_nd_ot_mul + `</td>
                                <td>` + ti_basic_sal_total + `</td>
                                <td>` + ti_absent_total + `</td>
                                <td>` + ti_no_ti_to_total + `</td>
                                <td>` + ti_tard_total + `</td>
                                <td>` + ti_half_total + `</td>
                                <td>` + ti_undertime_total + `</td>
                                <td>` + ti_rest_total + `</td>
                                <td>` + ti_rest_sp_hol_total + `</td>
                                <td>` + ti_legal_hol_total + `</td>
                                <td>` + ti_rest_legal_hol_total + `</td>
                                <td>` + ti_reg_ot_total + `</td>
                                <td>` + ti_nd_ot_total + `</td>
                                <td>` + ti_nd_total + `</td>
                                <td>` + ti_leave_total + `</td>
                                <td>` + ti_de_minimis_total + `</td>
                                <td>` + ti_rest_ot_total + `</td>
                                <td>` + ti_rest_nd_ot_total + `</td>
                                <td>` + ti_sil_2020 + `</td>
                                <td>` + ti_meal + `</td>
                                <td>` + ti_gov_cont + `</td>
                                <td>` + ti_others + `</td>
                                <td>` + ti_gross + `</td>
                                <td>` + gov_sss_ee + `</td>
                                <td>` + gov_philhealth_ee + `</td>
                                <td>` + gov_pagibig_ee + `</td>
                                <td>` + gov_total_ee + `</td>
                                <td>` + comp_cont_sss + `</td>
                                <td>` + comp_cont_sss_ec + `</td>
                                <td>` + comp_cont_philhealth + `</td>
                                <td>` + comp_cont_pagibig + `</td>
                                <td>` + comp_cont_total + `</td>
                                <td>` + ta_load + `</td>
                                <td>` + ta_transportation + `</td>
                                <td>` + ta_skill + `</td>
                                <td>` + ta_pioneer + `</td>
                                <td>` + ta_allowance + `</td>
                                <td>` + ta_total + `</td>
                                <td>` + wtax + `</td>
                                <td>` + loan_sss_salary + `</td>
                                <td>` + loan_sss_calamity + `</td>
                                <td>` + loan_pagibig_salary + `</td>
                                <td>` + loan_pagibig_calamity + `</td>
                                <td>` + loan_emergency + `</td>
                                <td>` + loan_total + `</td>
                                <td>` + tax_refund + `</td>
                                <td>` + salary_advance + `</td>
                                <td>` + uniform_deduction + `</td>
                                <td>` + ded_total + `</td>
                                <td>` + net_pay + `</td>
                            </tr>
                        `)
                })

                isReadyForDownload = true;

            })


        })








        setInterval(() => {
            if (isReadyForDownload) {
                var table_id = 'tbl_payroll_data';
                var separator = ',';

                // Select rows from table_id
                var rows = document.querySelectorAll('table#' + table_id + ' tr');
                // Construct csv
                var csv = [];
                for (var i = 0; i < rows.length; i++) {
                    var row = [],
                        cols = rows[i].querySelectorAll('td, th');
                    for (var j = 0; j < cols.length; j++) {
                        // Clean innertext to remove multiple spaces and jumpline (break csv)
                        var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                        // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
                        data = data.replace(/"/g, '""');
                        // Push escaped string
                        row.push('"' + data + '"');
                    }
                    csv.push(row.join(separator));
                }
                var csv_string = csv.join('\n');

                // Download it
                var filename = 'Export_Payroll_Data.csv';
                var link = document.createElement('a');
                link.style.display = 'none';
                link.setAttribute('target', '_blank');
                link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
                link.setAttribute('download', filename);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);



                $('#export_csv_loading_indicator').hide();
                $('#download_csv').show();


                isReadyForDownload = false;
            }
        }, 200);






        $('#delete_all_payslips').click(function(e) {
            e.preventDefault();
            var cutoff_period_id = $('#date_period').val();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url(); ?>payroll/delete_all_payslip?cutoff_period_id=" + cutoff_period_id;
                }
            })
        })

        // var loop_and_match = setInterval(() => {
        //     compare_generated_payslips();
        // }, 100);

        // function compare_generated_payslips(){
        //     var generated_payroll = $('#payroll_data_container tr').length;
        //     var generated_payslip_count = $('#generated_payslip_count').text();

        //     if((generated_payroll != 0) && (generated_payslip_count != 0) && (generated_payroll == generated_payslip_count)){
        //         // console.log('Ready for Generate All PDFs');
        //         $('#generate_all_pdf').removeAttr('title');
        //         $('#generate_all_pdf').removeAttr('data-toggle');
        //         $('#generate_all_pdf').prop('disabled',false);
        //         clearInterval(loop_and_match);
        //     }
        // }







        function payslip_object(selector) {
            // console.log($(selector).length);

            var payslip_data_obj = [];

            $('#select_empl_1').html(`
                    <option value="">Select Employee 1</option>
                `);
            $('#select_empl_2').html(`
                    <option value="">Select Employee 2</option>
                `);
            $('#select_empl_3').html(`
                    <option value="">Select Employee 3</option>
                `);

            // APPEND PAYSLIP DATA TO OBJECT
            Array.from($(selector)).forEach(function(parent) {
                if ($(parent).is(":visible")) {

                    var empl_id = $(parent.childNodes[1]).attr('empl_id');
                    var empl_cmid = $(parent.childNodes[1]).text();
                    var empl_name = $(parent.childNodes[3]).attr('empl_name');
                    var employment_type = $(parent.childNodes[5]).text();
                    var position = $(parent.childNodes[7]).text();
                    var td_btn_pdf = parent.childNodes[13];
                    var download_pdf_btn = $(td_btn_pdf).find('a');

                    var payslip_id = $(download_pdf_btn).attr('payslip_id');
                    var empl_sect = $(download_pdf_btn).attr('empl_sect');
                    var empl_dept = $(download_pdf_btn).attr('empl_dept');
                    var used_sick_leave = $(download_pdf_btn).attr('used_sick_leave');
                    var used_vacation_leave = $(download_pdf_btn).attr('used_vacation_leave');
                    var loan_balance_amount = $(download_pdf_btn).attr('sss_loan_balance_amount');
                    var loan_amount_paid = $(download_pdf_btn).attr('sss_loan_amount_paid');
                    var pagibig_loan_balance_amount = $(download_pdf_btn).attr('pagibig_loan_balance_amount');
                    var pagibig_loan_amount_paid = $(download_pdf_btn).attr('pagibig_loan_amount_paid');

                    used_sick_leave = parseFloat(used_sick_leave).toFixed(2);
                    used_vacation_leave = parseFloat(used_vacation_leave).toFixed(2);

                    loan_balance_amount = parseFloat(loan_balance_amount).toFixed(2);
                    loan_amount_paid = parseFloat(loan_amount_paid).toFixed(2);

                    pagibig_loan_balance_amount = parseFloat(pagibig_loan_balance_amount).toFixed(2);
                    pagibig_loan_amount_paid = parseFloat(pagibig_loan_amount_paid).toFixed(2);


                    $('#select_empl_1').append(`
                            <option select_empl_cmid_1="` + empl_cmid + `" value="` + empl_id + `">` + empl_cmid + ` - ` + empl_name + `</option>
                        `)
                    $('#select_empl_2').append(`
                            <option select_empl_cmid_2="` + empl_cmid + `" value="` + empl_id + `">` + empl_cmid + ` - ` + empl_name + `</option>
                        `)
                    $('#select_empl_3').append(`
                            <option select_empl_cmid_3="` + empl_cmid + `" value="` + empl_id + `">` + empl_cmid + ` - ` + empl_name + `</option>
                        `)

                    var payslip_data = {

                        empl_cmid: empl_cmid,
                        empl_name: empl_name,
                        employment_type: employment_type,
                        position: position,
                        payslip_id: payslip_id,
                        empl_sect: empl_sect,
                        empl_dept: empl_dept,
                        used_sick_leave: used_sick_leave,
                        used_vacation_leave: used_vacation_leave,
                        loan_balance_amount: loan_balance_amount,
                        loan_amount_paid: loan_amount_paid,
                        pagibig_loan_balance_amount: pagibig_loan_balance_amount,
                        pagibig_loan_amount_paid: pagibig_loan_amount_paid,

                    };

                    payslip_data_obj.push(payslip_data);
                }

            });

            // console.log(payslip_data_obj);
        }

















        function generate_pdf_bulk(doc, payroll_period, payout, employment_type, position, empl_sect, empl_dept, used_sick_leave, used_vacation_leave, loan_balance_amount, loan_amount_paid, pagibig_loan_balance_amount, pagibig_loan_amount_paid, payslip_id) {

            // You'll need to make your image into a Data URL
            // Use http://dataurl.net/#dataurlmaker
            // SETTINGS


            var imgData = 'data:image/jpeg;base64,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AAAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAA4QklNBAAAAAAAAAIAAThCSU0EAgAAAAAABAAAAAA4QklNBDAAAAAAAAIBAThCSU0ELQAAAAAABgABAAAAAjhCSU0ECAAAAAAAEAAAAAEAAAJAAAACQAAAAAA4QklNBB4AAAAAAAQAAAAAOEJJTQQaAAAAAANJAAAABgAAAAAAAAAAAAAAeQAAANcAAAAKAFUAbgB0AGkAdABsAGUAZAAtADIAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAANcAAAB5AAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAEAAAAAEAAAAAAABudWxsAAAAAgAAAAZib3VuZHNPYmpjAAAAAQAAAAAAAFJjdDEAAAAEAAAAAFRvcCBsb25nAAAAAAAAAABMZWZ0bG9uZwAAAAAAAAAAQnRvbWxvbmcAAAB5AAAAAFJnaHRsb25nAAAA1wAAAAZzbGljZXNWbExzAAAAAU9iamMAAAABAAAAAAAFc2xpY2UAAAASAAAAB3NsaWNlSURsb25nAAAAAAAAAAdncm91cElEbG9uZwAAAAAAAAAGb3JpZ2luZW51bQAAAAxFU2xpY2VPcmlnaW4AAAANYXV0b0dlbmVyYXRlZAAAAABUeXBlZW51bQAAAApFU2xpY2VUeXBlAAAAAEltZyAAAAAGYm91bmRzT2JqYwAAAAEAAAAAAABSY3QxAAAABAAAAABUb3AgbG9uZwAAAAAAAAAATGVmdGxvbmcAAAAAAAAAAEJ0b21sb25nAAAAeQAAAABSZ2h0bG9uZwAAANcAAAADdXJsVEVYVAAAAAEAAAAAAABudWxsVEVYVAAAAAEAAAAAAABNc2dlVEVYVAAAAAEAAAAAAAZhbHRUYWdURVhUAAAAAQAAAAAADmNlbGxUZXh0SXNIVE1MYm9vbAEAAAAIY2VsbFRleHRURVhUAAAAAQAAAAAACWhvcnpBbGlnbmVudW0AAAAPRVNsaWNlSG9yekFsaWduAAAAB2RlZmF1bHQAAAAJdmVydEFsaWduZW51bQAAAA9FU2xpY2VWZXJ0QWxpZ24AAAAH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UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAyMS0wOC0xMFQwOToyNDo1MCswODowMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAyMS0wOC0xMFQwOToyNDo1MCswODowMCIgeG1wOk1vZGlmeURhdGU9IjIwMjEtMDgtMTBUMDk6MjQ6NTArMDg6MDAiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NTQyNEZDQzE3OUY5RUIxMUFGOENBMEMyQjc0ODU5QTkiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NTMyNEZDQzE3OUY5RUIxMUFGOENBMEMyQjc0ODU5QTkiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo1MzI0RkNDMTc5RjlFQjExQUY4Q0EwQzJCNzQ4NTlBOSIgZGM6Zm9ybWF0PSJpbWFnZS9qcGVnIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIj4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY3JlYXRlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo1MzI0RkNDMTc5RjlFQjExQUY4Q0EwQzJCNzQ4NTlBOSIgc3RFdnQ6d2hlbj0iMjAyMS0wOC0xMFQwOToyNDo1MCswODowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjU0MjRGQ0MxNzlGOUVCMTFBRjhDQTBDMkI3NDg1OUE5IiBzdEV2dDp3aGVuPSIyMDIxLTA4LTEwVDA5OjI0OjUwKzA4OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPD94cGFja2V0IGVuZD0idyI/Pv/uAA5BZG9iZQBkQAAAAAH/2wCEAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQECAgICAgICAgICAgMDAwMDAwMDAwMBAQEBAQEBAQEBAQICAQICAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDA//AABEIAHkA1wMBEQACEQEDEQH/3QAEABv/xAGiAAAABgIDAQAAAAAAAAAAAAAHCAYFBAkDCgIBAAsBAAAGAwEBAQAAAAAAAAAAAAYFBAMHAggBCQAKCxAAAgEDBAEDAwIDAwMCBgl1AQIDBBEFEgYhBxMiAAgxFEEyIxUJUUIWYSQzF1JxgRhikSVDobHwJjRyChnB0TUn4VM2gvGSokRUc0VGN0djKFVWVxqywtLi8mSDdJOEZaOzw9PjKThm83UqOTpISUpYWVpnaGlqdnd4eXqFhoeIiYqUlZaXmJmapKWmp6ipqrS1tre4ubrExcbHyMnK1NXW19jZ2uTl5ufo6er09fb3+Pn6EQACAQMCBAQDBQQEBAYGBW0BAgMRBCESBTEGACITQVEHMmEUcQhCgSORFVKhYhYzCbEkwdFDcvAX4YI0JZJTGGNE8aKyJjUZVDZFZCcKc4OTRnTC0uLyVWV1VjeEhaOzw9Pj8ykalKS0xNTk9JWltcXV5fUoR1dmOHaGlqa2xtbm9md3h5ent8fX5/dIWGh4iJiouMjY6Pg5SVlpeYmZqbnJ2en5KjpKWmp6ipqqusra6vr/2gAMAwEAAhEDEQA/AN/j37r3Xvfuvde9+691737r3Xvfuvde9+691737r3XvfuvdcDIgbTqGr66fzb+tv6e/de6xipjOr9foYqbow5Fybcc/T37r3ST3rvja2wdtZbeO7s3j9vbbwVHJX5XLZWdaSkpaWFWeRnllZFaQjhE/UzGwBJt7917quD45fzR+lvkd3Znends4PcGLlNXWQbP3HPTyPR7qgoA71NUYoYNeI1pH5YlmtqiILlW9Hv3XurQqaojkZBGfIoRrym97qwX6EAkMfz+R7917qWZkAuSQLX5BFrkgXv8AQ8fT37r3WRSGAYcgi4Pv3Xuu/fuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3X/9Df49+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3TVUeCJjWujmRAyKE1FmNz6VUcEn/ePfuvdAz3p8gOs/j319luxu0Ny0OAw+Li1wUbzwtlstWuCtLisTjzItTX5CqkNljReACxsqkj3XutVvu/5HfJb+aV21H1515iclgepMPWzVtPt9amajwGFw0EhD7t7EyySCjeempyrgSHxwyERxh5CC/uvdM+9+7etviDteq6Y+J+Wo9w9m1sD4ztL5FRRRGvld0C1m3euZ1802IxYmDCWpikYSaUOokK6+691a3/Lo+XfbOC6Umz3y4zFDt7qujqKTEde9l7yr/wCH7j3JV1E0MSY+KOohNTuHHQoSf4gWJQxkMzrdk917q7TG5egzuLxuUxks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'

            doc.setFontSize(6);

            // HEADER
            doc.text(5, 5, 'BANDAI WIREHARNESS PHILIPPINES INC');

            doc.text(10, 9.5, 'Employee ID:');
            doc.text(10, 12.1, 'Employee Name:');
            doc.text(10, 14.6, 'Position:');
            doc.text(10, 17.1, 'Department:');
            doc.text(10, 19.6, 'Section:');

            doc.text(65, 9.5, "333");
            doc.text(65, 12.1, "ANA EVANGELINE GUARIN");
            doc.text(65, 14.6, "Human Resource");
            doc.text(65, 17.1, "HR Department");
            doc.text(65, 19.6, "Planning Section");

            doc.text(115, 5, 'Payroll Pay-out:');
            doc.text(115, 7.6, 'Payroll Cut-Off:');

            doc.text(115, 12, 'Salary Type:');
            doc.text(115, 14.6, 'Salary:');
            doc.text(115, 17.2, 'Working Days:');
            doc.text(115, 19.8, 'Absences:');

            doc.text(170, 5, "Oct. 25, 2021");
            doc.text(170, 7.6, "Oct. 1, 2021 - Oct. 15, 2021");

            doc.text(170, 12, "Monthly");
            doc.text(170, 14.6, "15000");
            doc.text(170, 17.2, "15");
            doc.text(170, 19.8, "11");

            // SALARY TABLE
            //--- Table Design ----
            doc.setLineWidth(0.8)
            doc.rect(10, 24, 190, 73);
            doc.setLineWidth(0.5)
            doc.line(10, 30, 200, 30) // horizontal line
            doc.line(10, 90, 200, 90) // horizontal line
            doc.line(160, 45, 200, 45) // horizontal line
            doc.line(160, 50, 200, 50) // horizontal line
            doc.line(160, 85, 200, 85) // horizontal line
            doc.line(40, 24.5, 40, 30) // vertical
            doc.line(58, 24.5, 58, 30) // vertical
            doc.line(115, 24.5, 115, 30) // vertical
            doc.line(133, 24.5, 133, 30) // vertical

            doc.line(85, 24.5, 85, 97.5) // vertical
            doc.line(160, 24.5, 160, 97.5) // vertical
            //doc.line(10, 90, 190, 90) // horizontal line
            //doc.line(10, 95, 190, 95) // horizontal line

            doc.text(18, 28, 'DESCRIPTION');
            doc.text(43, 28, 'DAYS/HRS');
            doc.text(67, 28, 'AMOUNT');

            doc.text(93, 28, 'DESCRIPTION');
            doc.text(118, 28, 'DAYS/HRS');
            doc.text(142, 28, 'AMOUNT');

            doc.text(171, 28, 'LEAVE BALANCES');
            doc.text(171, 53.5, 'LOAN BALANCES');
            doc.setFontSize(6);
            doc.setFont(undefined, 'bold');
            doc.text(12, 34, 'EARNINGS');
            doc.setFont(undefined, 'normal');
            doc.text(14, 37, 'Basic Salary');
            doc.text(14, 39.5, 'Paid Leave');
            doc.text(14, 42, 'Daily Allowance');
            doc.text(14, 44.5, 'Total Allowance');
            doc.text(14, 47, 'Regular/Legal Holiday');
            doc.text(14, 49.5, 'Regular OT');
            doc.text(14, 52, 'Rest Day> 6 Hrs');
            doc.text(14, 54.5, 'Rest Day OT');
            doc.text(14, 57, 'Night Differential');
            doc.text(14, 59.5, 'OT Night Differential');
            doc.text(14, 62, 'Rest Day ND OT');
            doc.text(14, 64.5, 'Meal Allowance');
            doc.text(14, 67, 'SIL 2020');
            doc.text(14, 69.5, 'Rest + Special Holiday');

            doc.setFont(undefined, 'bold');
            doc.text(12, 75, 'ADJUSTMENTS');
            doc.setFont(undefined, 'normal');
            doc.text(14, 77.5, 'Meal Allowance');
            doc.text(14, 80, 'Govt. Conributions');
            doc.text(14, 82.5, 'Others');
            doc.text(14, 85, '13th Month Pay');
            doc.text(14, 87.5, 'Tax Refund');

            doc.text(56, 37, "0"); //Basic Salary
            doc.text(56, 39.5, "0"); //Paid Leave
            doc.text(56, 42, "0"); //Daily Allowance
            doc.text(56, 47, "0"); //Regular/Legal Holiday
            doc.text(56, 49.5, "0"); //Regular OT
            doc.text(56, 52, "0"); //Rest Day> 6 Hrs
            doc.text(56, 54.5, "-"); //Rest Day OT
            doc.text(56, 57, "0"); //Night Differential
            doc.text(56, 59.5, "0"); //OT Night Differential
            doc.text(56, 62, "-"); //Rest Day ND OT
            doc.text(56, 64.5, "0"); //Meal Allowance
            doc.text(56, 67, '-'); //SIL 2020
            doc.text(56, 69.5, "0"); // Rest + Special Holiday

            doc.text(80, 37, "0"); // Basic Salary
            doc.text(80, 39.5, "0"); // Paid Leave
            doc.text(80, 42, "0"); // Daily Allowance
            doc.text(80, 44.5, "0"); // Total Allowance
            doc.text(80, 47, "0"); // Regular/Legal Holiday
            doc.text(80, 49.5, "0"); // Regular OT
            doc.text(80, 52, "-"); // Rest Day> 6 Hrs
            doc.text(80, 54.5, "0"); // Rest Day OT
            doc.text(80, 57, "0"); // Night Differential
            doc.text(80, 59.5, "-"); // OT Night Differential
            doc.text(80, 62, "0"); // Rest Day ND OT
            doc.text(80, 64.5, "0"); // Meal Allowance
            doc.text(80, 67, "0"); // SIL 2020
            doc.text(80, 69.5, "0"); // Rest + Special Holiday

            doc.text(80, 77.5, "0"); //Meal Allowance
            doc.text(80, 80, "0"); //Govt. Conributions
            doc.text(80, 82.5, "0"); //Others
            doc.text(80, 85, "-"); //13th Month Pay
            doc.text(80, 87.5, "0"); //Tax Refund

            doc.setFont(undefined, 'bold');
            doc.text(87, 34, 'DEDUCTIONS');
            doc.setFont(undefined, 'normal');
            doc.text(89, 37, 'Withholding Tax');
            doc.text(89, 39.5, 'SSS EE Share');
            doc.text(89, 42, 'PHIC EE Share');
            doc.text(89, 44.5, 'HDMF EE Share');
            doc.text(89, 47, 'SSS Loan');
            doc.text(89, 49.5, 'HDMF Loan');
            doc.text(89, 52, 'Absences');
            doc.text(89, 54.5, 'Tardines');
            doc.text(89, 57, 'Undertime');
            doc.text(89, 59.5, 'Half day');
            doc.text(89, 62, 'Advances to Employees ');
            doc.text(89, 64.5, 'Uniform');
            doc.setFont(undefined, 'bold');
            doc.text(87, 70, 'ADJUSTMENTS');
            doc.setFont(undefined, 'normal');
            doc.text(89, 72.5, 'Meal Allowance');
            doc.text(89, 75, 'Govt. Conributions');
            doc.text(89, 77.5, 'Others');
            doc.text(89, 80, '13th Month Pay');
            doc.text(89, 82.5, 'Tax Refund');

            doc.text(131, 52, "0");
            doc.text(131, 54.5, "0");
            doc.text(131, 57, "0");

            doc.text(155, 37, "0");
            doc.text(155, 39.5, "0");
            doc.text(155, 42, "0");
            doc.text(155, 44.5, "0");
            doc.text(155, 47, "0");
            doc.text(155, 49.5, "0");
            doc.text(155, 52, "0");
            doc.text(155, 54.5, "0");
            doc.text(155, 57, "0");
            doc.text(155, 59.4, "0");

            doc.text(155, 72.5, "0");
            doc.text(155, 75, "0");
            doc.text(155, 77.5, "0");
            doc.text(155, 80, "-");
            doc.text(155, 82.5, "0");

            doc.text(174, 34, 'USED');
            doc.text(190, 34, 'BAL');
            doc.text(162, 37.5, 'VL');
            doc.text(162, 41, 'SL');
            doc.text(180, 37.5, "0");
            doc.text(180, 41, "0");
            doc.text(196, 37.5, "0");
            doc.text(196, 41, "0");

            doc.text(174, 58, 'USED');
            doc.text(190, 58, 'BAL');
            doc.text(162, 61.5, 'SSS');
            doc.text(162, 65, 'HDMF');
            doc.text(180, 61.5, "0");
            doc.text(180, 65, "0");
            doc.text(196, 61.5, "0");
            doc.text(196, 65, "0");

            doc.setFont(undefined, 'bold');
            doc.text(12, 94.5, 'TOTAL EARNINGS');
            doc.setFont(undefined, 'normal');
            doc.text(80, 94.5, "0");

            doc.setFont(undefined, 'bold');
            doc.text(87, 94.5, 'TOTAL DEDUCTIONS');
            doc.setFont(undefined, 'normal');
            doc.text(155, 94.5, "0");

            doc.text(175, 88.5, 'NET PAY');
            doc.setFont(undefined, 'bold');
            doc.text(180, 94.5, "0");
            doc.setFont(undefined, 'normal');

            doc.text(15, 103, 'Received By:');
            doc.line(35, 103, 85, 103) // horizontal line
            doc.text(100, 103.5, 'Date:');
            doc.line(110, 103.5, 160, 103.5);

            doc.setLineWidth(0.5);
            doc.line(0, 106.5, 300, 106.5);

            // =============================================================================

            doc.text(5, 111, 'BANDAI WIREHARNESS PHILIPPINES INC');

            doc.text(10, 115.5, 'Employee ID:');
            doc.text(10, 118.1, 'Employee Name:');
            doc.text(10, 120.6, 'Position:');
            doc.text(10, 123.1, 'Department:');
            doc.text(10, 125.6, 'Section:');

            doc.text(65, 115.5, "333");
            doc.text(65, 118.1, "ANA EVANGELINE GUARIN");
            doc.text(65, 120.6, "Human Resource");
            doc.text(65, 123.1, "HR Department");
            doc.text(65, 125.6, "Planning Section");

            doc.text(115, 111, 'Payroll Pay-out:');
            doc.text(115, 113.6, 'Payroll Cut-Off:');

            doc.text(115, 118, 'Salary Type:');
            doc.text(115, 120.6, 'Salary:');
            doc.text(115, 123.2, 'Working Days:');
            doc.text(115, 125.8, 'Absences:');

            doc.text(170, 111, "Oct. 25, 2021");
            doc.text(170, 113.6, "Oct. 1, 2021 - Oct. 15, 2021");

            doc.text(170, 118, "Monthly");
            doc.text(170, 120.6, "15000");
            doc.text(170, 123.2, "15");
            doc.text(170, 125.8, "11");

            // ------------------------------------------

            // SALARY TABLE
            //--- Table Design ----
            doc.setLineWidth(0.8)
            doc.rect(10, 130, 190, 73);
            doc.setLineWidth(0.5)
            doc.line(10, 136, 200, 136) // horizontal line
            doc.line(10, 196, 200, 196) // horizontal line
            doc.line(160, 151, 200, 151) // horizontal line
            doc.line(160, 156, 200, 156) // horizontal line
            doc.line(160, 191, 200, 191) // horizontal line
            doc.line(40, 130.5, 40, 136) // vertical
            doc.line(58, 130.5, 58, 136) // vertical
            doc.line(115, 130.5, 115, 136) // vertical
            doc.line(133, 130.5, 133, 136) // vertical

            doc.line(85, 130.5, 85, 203.5) // vertical
            doc.line(160, 130.5, 160, 203.5) // vertical
            //doc.line(10, 90, 190, 90) // horizontal line
            //doc.line(10, 95, 190, 95) // horizontal line

            doc.text(18, 134, 'DESCRIPTION');
            doc.text(43, 134, 'DAYS/HRS');
            doc.text(67, 134, 'AMOUNT');

            doc.text(93, 134, 'DESCRIPTION');
            doc.text(118, 134, 'DAYS/HRS');
            doc.text(142, 134, 'AMOUNT');

            doc.text(171, 134, 'LEAVE BALANCES');
            doc.text(171, 159.5, 'LOAN BALANCES');
            doc.setFontSize(6);
            doc.setFont(undefined, 'bold');
            doc.text(12, 140, 'EARNINGS');
            doc.setFont(undefined, 'normal');
            doc.text(14, 143, 'Basic Salary');
            doc.text(14, 145.5, 'Paid Leave');
            doc.text(14, 148, 'Daily Allowance');
            doc.text(14, 150.5, 'Total Allowance');
            doc.text(14, 153, 'Regular/Legal Holiday');
            doc.text(14, 155.5, 'Regular OT');
            doc.text(14, 158, 'Rest Day> 6 Hrs');
            doc.text(14, 160.5, 'Rest Day OT');
            doc.text(14, 163, 'Night Differential');
            doc.text(14, 165.5, 'OT Night Differential');
            doc.text(14, 168, 'Rest Day ND OT');
            doc.text(14, 170.5, 'Meal Allowance');
            doc.text(14, 173, 'SIL 2020');
            doc.text(14, 175.5, 'Rest + Special Holiday');

            doc.setFont(undefined, 'bold');
            doc.text(12, 181, 'ADJUSTMENTS');
            doc.setFont(undefined, 'normal');
            doc.text(14, 183.5, 'Meal Allowance');
            doc.text(14, 186, 'Govt. Conributions');
            doc.text(14, 188.5, 'Others');
            doc.text(14, 191, '13th Month Pay');
            doc.text(14, 193.5, 'Tax Refund');

            doc.text(56, 138, "0"); //Basic Salary
            doc.text(56, 145.5, "0"); //Paid Leave
            doc.text(56, 148, "0"); //Daily Allowance
            doc.text(56, 153, "0"); //Regular/Legal Holiday
            doc.text(56, 155.5, "0"); //Regular OT
            doc.text(56, 158, "0"); //Rest Day> 6 Hrs
            doc.text(56, 160.5, "-"); //Rest Day OT
            doc.text(56, 163, "0"); //Night Differential
            doc.text(56, 165.5, "0"); //OT Night Differential
            doc.text(56, 168, "-"); //Rest Day ND OT
            doc.text(56, 170.5, "0"); //Meal Allowance
            doc.text(56, 173, '-'); //SIL 2020
            doc.text(56, 175.5, "0"); // Rest + Special Holiday

            doc.text(80, 148, "0"); // Basic Salary
            doc.text(80, 145.5, "0"); // Paid Leave
            doc.text(80, 148, "0"); // Daily Allowance
            doc.text(80, 150.5, "0"); // Total Allowance
            doc.text(80, 153, "0"); // Regular/Legal Holiday
            doc.text(80, 155.5, "0"); // Regular OT
            doc.text(80, 158, "-"); // Rest Day> 6 Hrs
            doc.text(80, 160.5, "0"); // Rest Day OT
            doc.text(80, 163, "0"); // Night Differential
            doc.text(80, 165.5, "-"); // OT Night Differential
            doc.text(80, 168, "0"); // Rest Day ND OT
            doc.text(80, 170.5, "0"); // Meal Allowance
            doc.text(80, 173, "0"); // SIL 2020
            doc.text(80, 175.5, "0"); // Rest + Special Holiday

            doc.text(80, 183.5, "0"); //Meal Allowance
            doc.text(80, 186, "0"); //Govt. Conributions
            doc.text(80, 188.5, "0"); //Others
            doc.text(80, 191, "-"); //13th Month Pay
            doc.text(80, 193.5, "0"); //Tax Refund

            doc.setFont(undefined, 'bold');
            doc.text(87, 140, 'DEDUCTIONS');
            doc.setFont(undefined, 'normal');
            doc.text(89, 143, 'Withholding Tax');
            doc.text(89, 145.5, 'SSS EE Share');
            doc.text(89, 148, 'PHIC EE Share');
            doc.text(89, 150.5, 'HDMF EE Share');
            doc.text(89, 153, 'SSS Loan');
            doc.text(89, 155.5, 'HDMF Loan');
            doc.text(89, 158, 'Absences');
            doc.text(89, 160.5, 'Tardines');
            doc.text(89, 163, 'Undertime');
            doc.text(89, 165.5, 'Half day');
            doc.text(89, 168, 'Advances to Employees ');
            doc.text(89, 170.5, 'Uniform');
            doc.setFont(undefined, 'bold');
            doc.text(87, 176, 'ADJUSTMENTS');
            doc.setFont(undefined, 'normal');
            doc.text(89, 178.5, 'Meal Allowance');
            doc.text(89, 181, 'Govt. Conributions');
            doc.text(89, 183.5, 'Others');
            doc.text(89, 186, '13th Month Pay');
            doc.text(89, 188.5, 'Tax Refund');

            doc.text(131, 158, "0");
            doc.text(131, 160.5, "0");
            doc.text(131, 163, "0");

            doc.text(155, 143, "0");
            doc.text(155, 145.5, "0");
            doc.text(155, 148, "0");
            doc.text(155, 150.5, "0");
            doc.text(155, 153, "0");
            doc.text(155, 155.5, "0");
            doc.text(155, 158, "0");
            doc.text(155, 160.5, "0");
            doc.text(155, 163, "0");
            doc.text(155, 165.4, "0");

            doc.text(155, 178.5, "0");
            doc.text(155, 181, "0");
            doc.text(155, 183.5, "0");
            doc.text(155, 186, "-");
            doc.text(155, 188.5, "0");

            doc.text(174, 140, 'USED');
            doc.text(190, 140, 'BAL');
            doc.text(162, 143.5, 'VL');
            doc.text(162, 147, 'SL');
            doc.text(180, 143.5, "0");
            doc.text(180, 147, "0");
            doc.text(196, 143.5, "0");
            doc.text(196, 150, "0");

            doc.text(174, 164, 'USED');
            doc.text(190, 164, 'BAL');
            doc.text(162, 167.5, 'SSS');
            doc.text(162, 171, 'HDMF');
            doc.text(180, 167.5, "0");
            doc.text(180, 171, "0");
            doc.text(196, 167.5, "0");
            doc.text(196, 171, "0");

            doc.setFont(undefined, 'bold');
            doc.text(12, 200.5, 'TOTAL EARNINGS');
            doc.setFont(undefined, 'normal');
            doc.text(80, 200.5, "0");

            doc.setFont(undefined, 'bold');
            doc.text(87, 200.5, 'TOTAL DEDUCTIONS');
            doc.setFont(undefined, 'normal');
            doc.text(155, 200.5, "0");

            doc.text(175, 194.5, 'NET PAY');
            doc.setFont(undefined, 'bold');
            doc.text(180, 200.5, "0");
            doc.setFont(undefined, 'normal');

            doc.text(15, 209, 'Received By:');
            doc.line(35, 209, 85, 209) // horizontal line
            doc.text(100, 209.5, 'Date:');
            doc.line(110, 209.5, 160, 209.5);

            doc.setLineWidth(0.5);
            doc.line(0, 213, 300, 213);



            // ================================================================




            doc.text(5, 218, 'BANDAI WIREHARNESS PHILIPPINES INC');

            doc.text(10, 221.5, 'Employee ID:');
            doc.text(10, 224.1, 'Employee Name:');
            doc.text(10, 226.6, 'Position:');
            doc.text(10, 229.1, 'Department:');
            doc.text(10, 231.6, 'Section:');

            doc.text(65, 221.5, "333");
            doc.text(65, 224.1, "ANA EVANGELINE GUARIN");
            doc.text(65, 226.6, "Human Resource");
            doc.text(65, 229.1, "HR Department");
            doc.text(65, 231.6, "Planning Section");

            doc.text(115, 217, 'Payroll Pay-out:');
            doc.text(115, 219.6, 'Payroll Cut-Off:');

            doc.text(115, 224, 'Salary Type:');
            doc.text(115, 226.6, 'Salary:');
            doc.text(115, 229.2, 'Working Days:');
            doc.text(115, 231.8, 'Absences:');

            doc.text(170, 217, "Oct. 25, 2021");
            doc.text(170, 219.6, "Oct. 1, 2021 - Oct. 15, 2021");

            doc.text(170, 224, "Monthly");
            doc.text(170, 226.6, "15000");
            doc.text(170, 229.2, "15");
            doc.text(170, 231.8, "11");

            // ------------------------------------------

            // SALARY TABLE
            //--- Table Design ----
            doc.setLineWidth(0.8)
            doc.rect(10, 236, 190, 73);
            doc.setLineWidth(0.5)
            doc.line(10, 242, 200, 242) // horizontal line
            doc.line(10, 302, 200, 302) // horizontal line
            doc.line(160, 257, 200, 257) // horizontal line
            doc.line(160, 262, 200, 262) // horizontal line
            doc.line(160, 297, 200, 297) // horizontal line
            doc.line(40, 236.5, 40, 241) // vertical
            doc.line(58, 236.5, 58, 241) // vertical
            doc.line(115, 236.5, 115, 241) // vertical
            doc.line(133, 236.5, 133, 241) // vertical

            doc.line(85, 236.5, 85, 308.5) // vertical
            doc.line(160, 236.5, 160, 308.5) // vertical
            //doc.line(10, 90, 190, 90) // horizontal line
            //doc.line(10, 95, 190, 95) // horizontal line

            doc.text(18, 240, 'DESCRIPTION');
            doc.text(43, 240, 'DAYS/HRS');
            doc.text(67, 240, 'AMOUNT');

            doc.text(93, 240, 'DESCRIPTION');
            doc.text(118, 240, 'DAYS/HRS');
            doc.text(142, 240, 'AMOUNT');

            doc.text(171, 240, 'LEAVE BALANCES');
            doc.text(171, 265.5, 'LOAN BALANCES');
            doc.setFontSize(6);
            doc.setFont(undefined, 'bold');
            doc.text(12, 246, 'EARNINGS');
            doc.setFont(undefined, 'normal');
            doc.text(14, 249, 'Basic Salary');
            doc.text(14, 251.5, 'Paid Leave');
            doc.text(14, 254, 'Daily Allowance');
            doc.text(14, 256.5, 'Total Allowance');
            doc.text(14, 259, 'Regular/Legal Holiday');
            doc.text(14, 261.5, 'Regular OT');
            doc.text(14, 264, 'Rest Day> 6 Hrs');
            doc.text(14, 266.5, 'Rest Day OT');
            doc.text(14, 269, 'Night Differential');
            doc.text(14, 271.5, 'OT Night Differential');
            doc.text(14, 274, 'Rest Day ND OT');
            doc.text(14, 276.5, 'Meal Allowance');
            doc.text(14, 279, 'SIL 2020');
            doc.text(14, 277.5, 'Rest + Special Holiday');

            doc.setFont(undefined, 'bold');
            doc.text(12, 287, 'ADJUSTMENTS');
            doc.setFont(undefined, 'normal');
            doc.text(14, 289.5, 'Meal Allowance');
            doc.text(14, 292, 'Govt. Conributions');
            doc.text(14, 294.5, 'Others');
            doc.text(14, 297, '13th Month Pay');
            doc.text(14, 299.5, 'Tax Refund');

            doc.text(56, 249, "0"); //Basic Salary
            doc.text(56, 251.5, "0"); //Paid Leave
            doc.text(56, 254, "0"); //Daily Allowance
            doc.text(56, 259, "0"); //Regular/Legal Holiday
            doc.text(56, 261.5, "0"); //Regular OT
            doc.text(56, 264, "0"); //Rest Day> 6 Hrs
            doc.text(56, 266.5, "-"); //Rest Day OT
            doc.text(56, 269, "0"); //Night Differential
            doc.text(56, 271.5, "0"); //OT Night Differential
            doc.text(56, 274, "-"); //Rest Day ND OT
            doc.text(56, 276.5, "0"); //Meal Allowance
            doc.text(56, 279, '-'); //SIL 2020
            doc.text(56, 281.5, "0"); // Rest + Special Holiday

            doc.text(80, 249, "0"); // Basic Salary
            doc.text(80, 251.5, "0"); // Paid Leave
            doc.text(80, 254, "0"); // Daily Allowance
            doc.text(80, 256.5, "0"); // Total Allowance
            doc.text(80, 259, "0"); // Regular/Legal Holiday
            doc.text(80, 261.5, "0"); // Regular OT
            doc.text(80, 264, "-"); // Rest Day> 6 Hrs
            doc.text(80, 266.5, "0"); // Rest Day OT
            doc.text(80, 269, "0"); // Night Differential
            doc.text(80, 271.5, "-"); // OT Night Differential
            doc.text(80, 274, "0"); // Rest Day ND OT
            doc.text(80, 276.5, "0"); // Meal Allowance
            doc.text(80, 279, "0"); // SIL 2020
            doc.text(80, 281.5, "0"); // Rest + Special Holiday

            doc.text(80, 289.5, "0"); //Meal Allowance
            doc.text(80, 292, "0"); //Govt. Conributions
            doc.text(80, 294.5, "0"); //Others
            doc.text(80, 297, "-"); //13th Month Pay
            doc.text(80, 299.5, "0"); //Tax Refund

            doc.setFont(undefined, 'bold');
            doc.text(87, 246, 'DEDUCTIONS');
            doc.setFont(undefined, 'normal');
            doc.text(89, 249, 'Withholding Tax');
            doc.text(89, 249.5, 'SSS EE Share');
            doc.text(89, 254, 'PHIC EE Share');
            doc.text(89, 256.5, 'HDMF EE Share');
            doc.text(89, 259, 'SSS Loan');
            doc.text(89, 261.5, 'HDMF Loan');
            doc.text(89, 264, 'Absences');
            doc.text(89, 266.5, 'Tardines');
            doc.text(89, 269, 'Undertime');
            doc.text(89, 271.5, 'Half day');
            doc.text(89, 274, 'Advances to Employees ');
            doc.text(89, 276.5, 'Uniform');
            doc.setFont(undefined, 'bold');
            doc.text(87, 282, 'ADJUSTMENTS');
            doc.setFont(undefined, 'normal');
            doc.text(89, 284.5, 'Meal Allowance');
            doc.text(89, 287, 'Govt. Conributions');
            doc.text(89, 289.5, 'Others');
            doc.text(89, 292, '13th Month Pay');
            doc.text(89, 294.5, 'Tax Refund');

            doc.text(131, 264, "0");
            doc.text(131, 266.5, "0");
            doc.text(131, 269, "0");

            doc.text(155, 249, "0");
            doc.text(155, 251.5, "0");
            doc.text(155, 254, "0");
            doc.text(155, 256.5, "0");
            doc.text(155, 259, "0");
            doc.text(155, 261.5, "0");
            doc.text(155, 264, "0");
            doc.text(155, 266.5, "0");
            doc.text(155, 269, "0");
            doc.text(155, 271.4, "0");

            doc.text(155, 284.5, "0");
            doc.text(155, 287, "0");
            doc.text(155, 289.5, "0");
            doc.text(155, 292, "-");
            doc.text(155, 294.5, "0");

            doc.text(174, 246, 'USED');
            doc.text(190, 246, 'BAL');
            doc.text(162, 249.5, 'VL');
            doc.text(162, 253, 'SL');
            doc.text(180, 249.5, "0");
            doc.text(180, 253, "0");
            doc.text(196, 249.5, "0");
            doc.text(196, 256, "0");

            doc.text(174, 270, 'USED');
            doc.text(190, 270, 'BAL');
            doc.text(162, 273.5, 'SSS');
            doc.text(162, 277, 'HDMF');
            doc.text(180, 273.5, "0");
            doc.text(180, 277, "0");
            doc.text(196, 273.5, "0");
            doc.text(196, 277, "0");

            doc.setFont(undefined, 'bold');
            doc.text(12, 306.5, 'TOTAL EARNINGS');
            doc.setFont(undefined, 'normal');
            doc.text(80, 306.5, "0");

            doc.setFont(undefined, 'bold');
            doc.text(87, 306.5, 'TOTAL DEDUCTIONS');
            doc.setFont(undefined, 'normal');
            doc.text(155, 306.5, "0");

            doc.text(175, 300.5, 'NET PAY');
            doc.setFont(undefined, 'bold');
            doc.text(180, 306.5, "0");
            doc.setFont(undefined, 'normal');

            doc.text(15, 315, 'Received By:');
            doc.line(35, 315, 85, 315) // horizontal line
            doc.text(100, 315.5, 'Date:');
            doc.line(110, 315.5, 160, 315.5);


        }





        // BUTTON GENERATE PDF BY 3s
        $('#btn_generate_payslip_by_3s').click(function(e) {
            $(this).hide();
            $('#generate_all_payslip_loading').show();


            var select_empl_1 = $('#select_empl_1').val();
            var select_empl_2 = $('#select_empl_2').val();
            var select_empl_3 = $('#select_empl_3').val();

            var select_empl_cmid_1 = $('#select_empl_1 option:selected').attr('select_empl_cmid_1');
            var select_empl_cmid_2 = $('#select_empl_2 option:selected').attr('select_empl_cmid_2');
            var select_empl_cmid_3 = $('#select_empl_3 option:selected').attr('select_empl_cmid_3');

            // console.log('select_empl_1: ' + select_empl_1);
            // console.log('select_empl_2: ' + select_empl_2);
            // console.log('select_empl_3: ' + select_empl_3);

            const selected_empl_arr = [select_empl_1, select_empl_2, select_empl_3];
            selected_empl_arr.sort(function(a, b) {
                return a - b
            });

            const selected_empl_cmid_arr = [select_empl_cmid_1, select_empl_cmid_2, select_empl_cmid_3];
            selected_empl_cmid_arr.sort(function(a, b) {
                return a - b
            });

            // var payroll_id1 = global_generate_all_pdf_object[pdf1].payslip_id;
            var payroll_info1 = findObjectByKey(global_generate_all_pdf_object, 'empl_cmid', "" + selected_empl_cmid_arr[0] + "");
            var payroll_info2 = findObjectByKey(global_generate_all_pdf_object, 'empl_cmid', "" + selected_empl_cmid_arr[1] + "");
            var payroll_info3 = findObjectByKey(global_generate_all_pdf_object, 'empl_cmid', "" + selected_empl_cmid_arr[2] + "");

            var payroll_id1 = payroll_info1.payslip_id;
            var payroll_id2 = payroll_info2.payslip_id;
            var payroll_id3 = payroll_info3.payslip_id;

            var payroll_net_pay1 = payroll_info1.net_pay;
            var payroll_net_pay2 = payroll_info2.net_pay;
            var payroll_net_pay3 = payroll_info3.net_pay;

            // console.log('payroll_id1: ' + payroll_id1);
            // console.log('payroll_id2: ' + payroll_id2);
            // console.log('payroll_id3: ' + payroll_id3);

            const selected_payroll_id_arr = [parseInt(payroll_id1), parseInt(payroll_id2), parseInt(payroll_id3)];
            selected_payroll_id_arr.sort(function(a, b) {
                return a - b
            });

            const selected_payroll_netpay_arr = [payroll_net_pay1, payroll_net_pay2, payroll_net_pay3];
            selected_payroll_netpay_arr.sort(function(a, b) {
                return a - b
            });



            get_all_payroll_data_by_3s(url_get_all_payroll_data_by_3s, payroll_id1, payroll_id2, payroll_id3).then(function(data) {

                console.log(data.data0);
                console.log(data.data1);
                console.log(data.data2);

                var doc = new jsPDF('p', 'mm', [215, 330])


                // PAYSLIP 1 HEADER

                var employee_id = payroll_info1.empl_cmid;
                var employee_cmid = payroll_info1.empl_cmid;
                var employee_name = payroll_info1.empl_name;
                var employment_type = payroll_info1.employment_type;
                var position = payroll_info1.position;
                var payslip_id = payroll_info1.payslip_id;
                var empl_sect = payroll_info1.empl_sect;
                var empl_dept = payroll_info1.empl_dept;
                var used_sick_leave = payroll_info1.used_sick_leave;
                var used_vacation_leave = payroll_info1.used_vacation_leave;
                var loan_balance_amount = payroll_info1.loan_balance_amount;
                var loan_amount_paid = payroll_info1.loan_amount_paid;
                var pagibig_loan_balance_amount = payroll_info1.pagibig_loan_balance_amount;
                var pagibig_loan_amount_paid = payroll_info1.pagibig_loan_amount_paid;
                var vacation_leave_balance = payroll_info1.vacation_leave_balance;
                var sick_leave_balance = payroll_info1.sick_leave_balance;

                var payroll_period = $('#date_period option:selected').text();
                var db_payroll_period = $('#date_period option:selected').attr('db_date');
                var payout = $('#date_period option:selected').attr('payout');

                // CHECK CUTOFF PERIOD
                var split_db_date_name = db_payroll_period.split('/');
                var initial_cutoff_year = split_db_date_name[4];

                var SIL_year = parseInt(initial_cutoff_year);
                var SIL_label = 'SIL ' + (initial_cutoff_year - 1);


                // PAYSLIP 2 HEADER

                var employee_id1 = payroll_info2.empl_cmid;
                var employee_cmid1 = payroll_info2.empl_cmid;
                var employee_name1 = payroll_info2.empl_name;
                var employment_type1 = payroll_info2.employment_type;
                var position1 = payroll_info2.position;
                var payslip_id1 = payroll_info2.payslip_id;
                var empl_sect1 = payroll_info2.empl_sect;
                var empl_dept1 = payroll_info2.empl_dept;
                var used_sick_leave1 = payroll_info2.used_sick_leave;
                var used_vacation_leave1 = payroll_info2.used_vacation_leave;
                var loan_balance_amount1 = payroll_info2.loan_balance_amount;
                var loan_amount_paid1 = payroll_info2.loan_amount_paid;
                var pagibig_loan_balance_amount1 = payroll_info2.pagibig_loan_balance_amount;
                var pagibig_loan_amount_paid1 = payroll_info2.pagibig_loan_amount_paid;
                var vacation_leave_balance1 = payroll_info2.vacation_leave_balance;
                var sick_leave_balance1 = payroll_info2.sick_leave_balance;

                var payroll_period1 = $('#date_period option:selected').text();
                var payout1 = $('#date_period option:selected').attr('payout');




                // PAYSLIP 3 HEADER

                var employee_id2 = payroll_info3.empl_cmid;
                var employee_cmid2 = payroll_info3.empl_cmid;
                var employee_name2 = payroll_info3.empl_name;
                var employment_type2 = payroll_info3.employment_type;
                var position2 = payroll_info3.position;
                var payslip_id2 = payroll_info3.payslip_id;
                var empl_sect2 = payroll_info3.empl_sect;
                var empl_dept2 = payroll_info3.empl_dept;
                var used_sick_leave2 = payroll_info3.used_sick_leave;
                var used_vacation_leave2 = payroll_info3.used_vacation_leave;
                var loan_balance_amount2 = payroll_info3.loan_balance_amount;
                var loan_amount_paid2 = payroll_info3.loan_amount_paid;
                var pagibig_loan_balance_amount2 = payroll_info3.pagibig_loan_balance_amount;
                var pagibig_loan_amount_paid2 = payroll_info3.pagibig_loan_amount_paid;
                var vacation_leave_balance2 = payroll_info3.vacation_leave_balance;
                var sick_leave_balance2 = payroll_info3.sick_leave_balance;

                var payroll_period2 = $('#date_period option:selected').text();
                var payout2 = $('#date_period option:selected').attr('payout');








                // =============================== PAYLSIP 1 =============================================

                var working_days = data.data0[0].working_days;
                var absences = data.data0[0].abs_mul;

                var salary_rate = parseFloat(data.data0[0].salary_rate).toFixed(2);
                var db_salary_type = data.data0[0].salary_type;
                var hours_of_work = parseFloat(data.data0[0].hours_of_work);
                var daily_salary = parseFloat(data.data0[0].daily_salary);
                var hourly_salary = parseFloat(data.data0[0].hourly_salary);
                var days_present = parseFloat(data.data0[0].ti_basic_sal_mul);

                // =================== database data ===================
                // multipliers
                var ti_basic_sal_mul = parseFloat(data.data0[0].ti_basic_sal_mul).toFixed(2);
                var ti_absent_mul = parseFloat(data.data0[0].ti_absent_mul).toFixed(2);
                var ti_no_ti_to_mul = parseFloat(data.data0[0].ti_no_ti_to_mul).toFixed(2);
                var ti_tard_mul = parseFloat(data.data0[0].ti_tard_mul).toFixed(2);
                var ti_half_mul = parseFloat(data.data0[0].ti_half_mul).toFixed(2);
                var ti_undertime_mul = parseFloat(data.data0[0].ti_undertime_mul).toFixed(2);
                var ti_rest_mul = parseFloat(data.data0[0].ti_rest_mul).toFixed(2);
                var ti_rest_sp_hol_mul = parseFloat(data.data0[0].ti_rest_sp_hol_mul).toFixed(2);
                var ti_legal_hol_mul = parseFloat(data.data0[0].ti_legal_hol_mul).toFixed(2);
                var ti_rest_legal_hol_mul = parseFloat(data.data0[0].ti_rest_legal_hol_mul).toFixed(2);
                var ti_reg_ot_mul = parseFloat(data.data0[0].ti_reg_ot_mul).toFixed(2);
                var ti_nd_ot_mul = parseFloat(data.data0[0].ti_nd_ot_mul).toFixed(2);
                var ti_nd_mul = parseFloat(data.data0[0].ti_nd_mul).toFixed(2);
                var ti_leave_mul = parseFloat(data.data0[0].ti_leave_mul).toFixed(2);
                var ti_de_minimis_mul = parseFloat(data.data0[0].ti_de_minimis_mul).toFixed(2);
                var ti_rest_ot_mul = parseFloat(data.data0[0].ti_rest_ot_mul).toFixed(2);
                var ti_rest_nd_ot_mul = parseFloat(data.data0[0].ti_rest_nd_ot_mul).toFixed(2);

                // totals
                var ti_basic_sal_total = parseFloat(data.data0[0].ti_basic_sal_total).toFixed(2);
                var ti_absent_total = parseFloat(data.data0[0].ti_absent_total).toFixed(2);
                var ti_no_ti_to_total = parseFloat(data.data0[0].ti_no_ti_to_total).toFixed(2);
                var ti_tard_total = parseFloat(data.data0[0].ti_tard_total).toFixed(2);
                var ti_half_total = parseFloat(data.data0[0].ti_half_total).toFixed(2);
                var ti_undertime_total = parseFloat(data.data0[0].ti_undertime_total).toFixed(2);
                var ti_rest_total = parseFloat(data.data0[0].ti_rest_total).toFixed(2);
                var ti_rest_sp_hol_total = parseFloat(data.data0[0].ti_rest_sp_hol_total).toFixed(2);
                var ti_legal_hol_total = parseFloat(data.data0[0].ti_legal_hol_total).toFixed(2);
                var ti_rest_legal_hol_total = parseFloat(data.data0[0].ti_rest_legal_hol_total).toFixed(2);
                var ti_reg_ot_total = parseFloat(data.data0[0].ti_reg_ot_total).toFixed(2);
                var ti_nd_ot_total = parseFloat(data.data0[0].ti_nd_ot_total).toFixed(2);
                var ti_nd_total = parseFloat(data.data0[0].ti_nd_total).toFixed(2);
                var ti_leave_total = parseFloat(data.data0[0].ti_leave_total).toFixed(2);
                var ti_de_minimis_total = parseFloat(data.data0[0].ti_de_minimis_total).toFixed(2);
                var ti_rest_ot_total = parseFloat(data.data0[0].ti_rest_ot_total).toFixed(2);
                var ti_rest_nd_ot_total = parseFloat(data.data0[0].ti_rest_nd_ot_total).toFixed(2);

                // no multilpliers
                var ti_sil_2020 = parseFloat(data.data0[0].ti_sil_2020).toFixed(2);
                var ti_meal = parseFloat(data.data0[0].ti_meal).toFixed(2);
                var ti_gov_cont = parseFloat(data.data0[0].ti_gov_cont).toFixed(2);
                var ti_others = parseFloat(data.data0[0].ti_others).toFixed(2);
                var ti_gross = parseFloat(data.data0[0].ti_gross).toFixed(2);

                // taxes
                var gov_sss_ee = parseFloat(data.data0[0].gov_sss_ee).toFixed(2);
                var gov_philhealth_ee = parseFloat(data.data0[0].gov_philhealth_ee).toFixed(2);
                var gov_pagibig_ee = parseFloat(data.data0[0].gov_pagibig_ee).toFixed(2);
                var gov_total_ee = parseFloat(data.data0[0].gov_total_ee).toFixed(2);
                var comp_cont_sss = parseFloat(data.data0[0].comp_cont_sss).toFixed(2);
                var comp_cont_sss_ec = parseFloat(data.data0[0].comp_cont_sss_ec).toFixed(2);
                var comp_cont_philhealth = parseFloat(data.data0[0].comp_cont_philhealth).toFixed(2);
                var comp_cont_pagibig = parseFloat(data.data0[0].comp_cont_pagibig).toFixed(2);
                var comp_cont_total = parseFloat(data.data0[0].comp_cont_total).toFixed(2);

                // taxable allowance
                var ta_load = parseFloat(data.data0[0].ta_load).toFixed(2);
                var ta_transportation = parseFloat(data.data0[0].ta_transportation).toFixed(2);
                var ta_skill = parseFloat(data.data0[0].ta_skill).toFixed(2);
                var ta_pioneer = parseFloat(data.data0[0].ta_pioneer).toFixed(2);
                var ta_daily_allowance = parseFloat(data.data0[0].ta_daily_allowance).toFixed(2);
                var ta_allowance = parseFloat(data.data0[0].ta_allowance).toFixed(2);
                ta_allowance = parseFloat(ta_allowance) - parseFloat(ta_daily_allowance);

                // total taxable allowance + witholding tax
                var ta_total = parseFloat(data.data0[0].ta_total).toFixed(2);
                var wtax = parseFloat(data.data0[0].wtax).toFixed(2);

                // loans
                var loan_sss_salary = parseFloat(data.data0[0].loan_sss_salary).toFixed(2);
                var loan_sss_calamity = parseFloat(data.data0[0].loan_sss_calamity).toFixed(2);
                var loan_pagibig_salary = parseFloat(data.data0[0].loan_pagibig_salary).toFixed(2);
                var loan_pagibig_calamity = parseFloat(data.data0[0].loan_pagibig_calamity).toFixed(2);
                var loan_emergency = parseFloat(data.data0[0].loan_emergency).toFixed(2);
                var loan_total = parseFloat(data.data0[0].loan_total).toFixed(2);

                // refund
                var tax_refund = parseFloat(data.data0[0].tax_refund).toFixed(2);

                // deductions
                var salary_advance = parseFloat(data.data0[0].salary_advance).toFixed(2);
                var uniform_deduction = parseFloat(data.data0[0].uniform_deduction).toFixed(2);
                var ded_total = parseFloat(data.data0[0].ded_total).toFixed(2);

                // net pay
                var net_pay = parseFloat(data.data0[0].net_pay).toFixed(2);

                // modified db variables
                var ti_meal_earning = 0;
                var ti_gov_cont_earning = 0;
                var ti_others_earning = 0;
                var tax_refund_earning = 0;

                var ti_meal_deduction = 0;
                var ti_gov_cont_deduction = 0;
                var ti_others_deduction = 0;
                var tax_refund_deduction = 0;

                var sss_loan = 0;
                var pagibig_loan = 0;




                if (ti_meal > 0) {
                    ti_meal_earning = Math.abs(parseFloat(ti_meal));
                }
                if (ti_gov_cont < 0) {
                    ti_gov_cont_earning = Math.abs(parseFloat(ti_gov_cont));
                }
                if (ti_others > 0) {
                    ti_others_earning = Math.abs(parseFloat(ti_others));
                }
                if (tax_refund > 0) {
                    tax_refund_earning = Math.abs(parseFloat(tax_refund));
                }

                if (ti_meal < 0) {
                    ti_meal_deduction = Math.abs(parseFloat(ti_meal));
                }
                if (ti_gov_cont > 0) {
                    ti_gov_cont_deduction = Math.abs(parseFloat(ti_gov_cont));
                }
                if (ti_others < 0) {
                    ti_others_deduction = Math.abs(parseFloat(ti_others));
                }
                if (tax_refund < 0) {
                    tax_refund_deduction = Math.abs(parseFloat(tax_refund));
                }

                if (net_pay == 0) {
                    net_pay = '-';
                }

                // for modified db variables
                if (sss_loan > 0) {
                    sss_loan,
                    sss_loan = (parseFloat(loan_sss_salary) + parseFloat(loan_sss_calamity)).toFixed(2);
                }
                if (pagibig_loan > 0) {
                    pagibig_loan,
                    pagibig_loan = (parseFloat(loan_pagibig_salary) + parseFloat(loan_pagibig_calamity)).toFixed(2);
                }

                // total_earnings =  parseFloat(ti_rest_sp_hol_total) + parseFloat(ti_basic_sal_total) + parseFloat(ti_leave_total) + parseFloat(ta_allowance) + parseFloat(ti_legal_hol_total) + parseFloat(ti_reg_ot_total) + parseFloat(ti_rest_total) + parseFloat(ti_nd_total) + parseFloat(ti_nd_ot_total) + parseFloat(ti_de_minimis_total) + parseFloat(ti_sil_2020) + parseFloat(ti_meal_earning) + parseFloat(ti_gov_cont_earning) + parseFloat(ti_others_earning) + parseFloat(tax_refund_earning);
                total_earnings = parseFloat(ti_rest_sp_hol_total) + parseFloat(ti_basic_sal_total) + parseFloat(ti_leave_total) + parseFloat(ta_daily_allowance) + parseFloat(ta_allowance) + parseFloat(ti_legal_hol_total) + parseFloat(ti_reg_ot_total) + parseFloat(ti_rest_total) + parseFloat(ti_nd_total) + parseFloat(ti_nd_ot_total) + parseFloat(ti_de_minimis_total) + parseFloat(ti_rest_ot_total) + parseFloat(ti_rest_nd_ot_total) + parseFloat(ti_sil_2020) + parseFloat(ti_meal_earning) + parseFloat(ti_gov_cont_earning) + parseFloat(ti_others_earning) + parseFloat(tax_refund_earning);
                // total_earnings =  parseFloat(ti_rest_sp_hol_total) + parseFloat(ti_basic_sal_total) + parseFloat(ti_leave_total) + parseFloat(ta_daily_allowance) + parseFloat(ta_allowance) + parseFloat(ti_legal_hol_total) + parseFloat(ti_reg_ot_total) + parseFloat(ti_rest_total) + parseFloat(ti_nd_total) + parseFloat(ti_nd_ot_total) + parseFloat(ti_de_minimis_total) + parseFloat(ti_rest_ot_total) + parseFloat(ti_rest_nd_ot_total) + parseFloat(ti_meal_earning) + parseFloat(ti_gov_cont_earning) + parseFloat(ti_others_earning) + parseFloat(tax_refund_earning);
                total_deductions = parseFloat(wtax) + parseFloat(gov_sss_ee) + parseFloat(gov_philhealth_ee) + parseFloat(gov_pagibig_ee) + parseFloat(loan_amount_paid) + parseFloat(pagibig_loan_amount_paid) + parseFloat(ti_absent_total) + parseFloat(ti_tard_total) + parseFloat(ti_undertime_total) + parseFloat(ti_half_total) + parseFloat(salary_advance) + parseFloat(uniform_deduction) + parseFloat(ti_meal_deduction) + parseFloat(ti_gov_cont_deduction) + parseFloat(ti_others_deduction) + parseFloat(tax_refund_deduction);

                total_earnings = parseFloat(total_earnings).toFixed(2);
                total_deductions = parseFloat(total_deductions).toFixed(2);

                if (ti_meal_earning <= 0) {
                    ti_meal_earning = '-';
                }
                if (ti_gov_cont_earning <= 0) {
                    ti_gov_cont_earning = '-';
                }
                if (ti_others_earning <= 0) {
                    ti_others_earning = '-';
                }
                if (tax_refund_earning <= 0) {
                    tax_refund_earning = '-';
                }
                if (ti_meal_deduction <= 0) {
                    ti_meal_deduction = '-';
                }
                if (ti_gov_cont_deduction <= 0) {
                    ti_gov_cont_deduction = '-';
                }
                if (ti_others_deduction <= 0) {
                    ti_others_deduction = '-';
                }
                if (tax_refund_deduction <= 0) {
                    tax_refund_deduction = '-';
                }

                if (sss_loan <= 0) {
                    sss_loan = '-';
                }
                if (pagibig_loan <= 0) {
                    pagibig_loan = '-';
                }

                if (ti_basic_sal_mul <= 0) {
                    ti_basic_sal_mul = '-';
                }
                if (ti_absent_mul <= 0) {
                    ti_absent_mul = '-';
                }
                if (ti_no_ti_to_mul <= 0) {
                    ti_no_ti_to_mul = '-';
                }
                if (ti_tard_mul <= 0) {
                    ti_tard_mul = '-';
                }
                if (ti_half_mul <= 0) {
                    ti_half_mul = '-';
                }
                if (ti_undertime_mul <= 0) {
                    ti_undertime_mul = '-';
                }
                if (ti_rest_mul <= 0) {
                    ti_rest_mul = '-';
                }
                if (ti_rest_sp_hol_mul <= 0) {
                    ti_rest_sp_hol_mul = '-';
                }
                if (ti_legal_hol_mul <= 0) {
                    ti_legal_hol_mul = '-';
                }
                if (ti_rest_legal_hol_mul <= 0) {
                    ti_rest_legal_hol_mul = '-';
                }
                if (ti_reg_ot_mul <= 0) {
                    ti_reg_ot_mul = '-';
                }
                if (ti_nd_ot_mul <= 0) {
                    ti_nd_ot_mul = '-';
                }
                if (ti_nd_mul <= 0) {
                    ti_nd_mul = '-';
                }
                if (ti_rest_ot_mul <= 0) {
                    ti_rest_ot_mul = '-';
                }
                if (ti_rest_nd_ot_mul <= 0) {
                    ti_rest_nd_ot_mul = '-';
                }

                if (ti_basic_sal_total <= 0) {
                    ti_basic_sal_total = '-';
                }
                if (ti_absent_total <= 0) {
                    ti_absent_total = '-';
                }
                if (ti_no_ti_to_total <= 0) {
                    ti_no_ti_to_total = '-';
                }
                if (ti_tard_total <= 0) {
                    ti_tard_total = '-';
                }
                if (ti_half_total <= 0) {
                    ti_half_total = '-';
                }
                if (ti_undertime_total <= 0) {
                    ti_undertime_total = '-';
                }
                if (ti_rest_total <= 0) {
                    ti_rest_total = '-';
                }
                if (ti_rest_sp_hol_total <= 0) {
                    ti_rest_sp_hol_total = '-';
                }
                if (ti_legal_hol_total <= 0) {
                    ti_legal_hol_total = '-';
                }
                if (ti_rest_legal_hol_total <= 0) {
                    ti_rest_legal_hol_total = '-';
                }
                if (ti_reg_ot_total <= 0) {
                    ti_reg_ot_total = '-';
                }
                if (ti_nd_ot_total <= 0) {
                    ti_nd_ot_total = '-';
                }
                if (ti_nd_total <= 0) {
                    ti_nd_total = '-';
                }
                if (ti_leave_total <= 0) {
                    ti_leave_total = '-';
                }
                if (ti_de_minimis_total <= 0) {
                    ti_de_minimis_total = '-';
                }
                if (ti_rest_ot_total <= 0) {
                    ti_rest_ot_total = '-';
                }
                if (ti_rest_nd_ot_total <= 0) {
                    ti_rest_nd_ot_total = '-';
                }

                if (ti_sil_2020 <= 0) {
                    ti_sil_2020 = '-';
                }
                if (ti_meal <= 0) {
                    ti_meal = '-';
                }
                if (ti_gov_cont <= 0) {
                    ti_gov_cont = '-';
                }
                if (ti_others <= 0) {
                    ti_others = '-';
                }
                if (ti_gross <= 0) {
                    ti_gross = '-';
                }
                if (gov_sss_ee <= 0) {
                    gov_sss_ee = '-';
                }
                if (gov_philhealth_ee <= 0) {
                    gov_philhealth_ee = '-';
                }
                if (gov_pagibig_ee <= 0) {
                    gov_pagibig_ee = '-';
                }
                if (gov_total_ee <= 0) {
                    gov_total_ee = '-';
                }
                if (comp_cont_sss <= 0) {
                    comp_cont_sss = '-';
                }
                if (comp_cont_sss_ec <= 0) {
                    comp_cont_sss_ec = '-';
                }
                if (comp_cont_philhealth <= 0) {
                    comp_cont_philhealth = '-';
                }
                if (comp_cont_pagibig <= 0) {
                    comp_cont_pagibig = '-';
                }
                if (comp_cont_total <= 0) {
                    comp_cont_total = '-';
                }
                if (ta_load <= 0) {
                    ta_load = '-';
                }
                if (ta_transportation <= 0) {
                    ta_transportation = '-';
                }
                if (ta_skill <= 0) {
                    ta_skill = '-';
                }
                if (ta_pioneer <= 0) {
                    ta_pioneer = '-';
                }
                if (ta_daily_allowance == 0) {
                    ta_daily_allowance = '-';
                }
                if (ta_allowance <= 0) {
                    ta_allowance = '-';
                }
                if (ta_total <= 0) {
                    ta_total = '-';
                }
                if (wtax <= 0) {
                    wtax = '-';
                }
                if (loan_sss_salary <= 0) {
                    loan_sss_salary = '-';
                }
                if (loan_sss_calamity <= 0) {
                    loan_sss_calamity = '-';
                }
                if (loan_pagibig_salary <= 0) {
                    loan_pagibig_salary = '-';
                }
                if (loan_pagibig_calamity <= 0) {
                    loan_pagibig_calamity = '-';
                }
                if (loan_emergency <= 0) {
                    loan_emergency = '-';
                }
                if (loan_total <= 0) {
                    loan_total = '-';
                }
                if (tax_refund <= 0) {
                    tax_refund = '-';
                }
                if (salary_advance <= 0) {
                    salary_advance = '-';
                }
                if (uniform_deduction <= 0) {
                    uniform_deduction = '-';
                }
                if (ded_total <= 0) {
                    ded_total = '-';
                }
                if (net_pay <= 0) {
                    net_pay = '-';
                }
                if (ti_leave_mul <= 0) {
                    ti_leave_mul = '-';
                }


                if (loan_amount_paid <= 0) {
                    loan_amount_paid = '-';
                }
                if (pagibig_loan_amount_paid <= 0) {
                    pagibig_loan_amount_paid = '-';
                }








                // =============================== PAYLSIP 2 =============================================

                var working_days1 = data.data1[0].working_days;
                var absences1 = data.data1[0].abs_mul;

                var salary_rate1 = parseFloat(data.data1[0].salary_rate).toFixed(2);
                var db_salary_type1 = data.data1[0].salary_type;
                var hours_of_work1 = parseFloat(data.data1[0].hours_of_work);
                var daily_salary1 = parseFloat(data.data1[0].daily_salary);
                var hourly_salary1 = parseFloat(data.data1[0].hourly_salary);
                var days_present1 = parseFloat(data.data1[0].ti_basic_sal_mul);

                // =================== database data ===================
                // multipliers
                var ti_basic_sal_mul1 = parseFloat(data.data1[0].ti_basic_sal_mul).toFixed(2);
                var ti_absent_mul1 = parseFloat(data.data1[0].ti_absent_mul).toFixed(2);
                var ti_no_ti_to_mul1 = parseFloat(data.data1[0].ti_no_ti_to_mul).toFixed(2);
                var ti_tard_mul1 = parseFloat(data.data1[0].ti_tard_mul).toFixed(2);
                var ti_half_mul1 = parseFloat(data.data1[0].ti_half_mul).toFixed(2);
                var ti_undertime_mul1 = parseFloat(data.data1[0].ti_undertime_mul).toFixed(2);
                var ti_rest_mul1 = parseFloat(data.data1[0].ti_rest_mul).toFixed(2);
                var ti_rest_sp_hol_mul1 = parseFloat(data.data1[0].ti_rest_sp_hol_mul).toFixed(2);
                var ti_legal_hol_mul1 = parseFloat(data.data1[0].ti_legal_hol_mul).toFixed(2);
                var ti_rest_legal_hol_mul1 = parseFloat(data.data1[0].ti_rest_legal_hol_mul).toFixed(2);
                var ti_reg_ot_mul1 = parseFloat(data.data1[0].ti_reg_ot_mul).toFixed(2);
                var ti_nd_ot_mul1 = parseFloat(data.data1[0].ti_nd_ot_mul).toFixed(2);
                var ti_nd_mul1 = parseFloat(data.data1[0].ti_nd_mul).toFixed(2);
                var ti_leave_mul1 = parseFloat(data.data1[0].ti_leave_mul).toFixed(2);
                var ti_de_minimis_mul1 = parseFloat(data.data1[0].ti_de_minimis_mul).toFixed(2);
                var ti_rest_ot_mul1 = parseFloat(data.data1[0].ti_rest_ot_mul).toFixed(2);
                var ti_rest_nd_ot_mul1 = parseFloat(data.data1[0].ti_rest_nd_ot_mul).toFixed(2);

                // totals
                var ti_basic_sal_total1 = parseFloat(data.data1[0].ti_basic_sal_total).toFixed(2);
                var ti_absent_total1 = parseFloat(data.data1[0].ti_absent_total).toFixed(2);
                var ti_no_ti_to_total1 = parseFloat(data.data1[0].ti_no_ti_to_total).toFixed(2);
                var ti_tard_total1 = parseFloat(data.data1[0].ti_tard_total).toFixed(2);
                var ti_half_total1 = parseFloat(data.data1[0].ti_half_total).toFixed(2);
                var ti_undertime_total1 = parseFloat(data.data1[0].ti_undertime_total).toFixed(2);
                var ti_rest_total1 = parseFloat(data.data1[0].ti_rest_total).toFixed(2);
                var ti_rest_sp_hol_total1 = parseFloat(data.data1[0].ti_rest_sp_hol_total).toFixed(2);
                var ti_legal_hol_total1 = parseFloat(data.data1[0].ti_legal_hol_total).toFixed(2);
                var ti_rest_legal_hol_total1 = parseFloat(data.data1[0].ti_rest_legal_hol_total).toFixed(2);
                var ti_reg_ot_total1 = parseFloat(data.data1[0].ti_reg_ot_total).toFixed(2);
                var ti_nd_ot_total1 = parseFloat(data.data1[0].ti_nd_ot_total).toFixed(2);
                var ti_nd_total1 = parseFloat(data.data1[0].ti_nd_total).toFixed(2);
                var ti_leave_total1 = parseFloat(data.data1[0].ti_leave_total).toFixed(2);
                var ti_de_minimis_total1 = parseFloat(data.data1[0].ti_de_minimis_total).toFixed(2);
                var ti_rest_ot_total1 = parseFloat(data.data1[0].ti_rest_ot_total).toFixed(2);
                var ti_rest_nd_ot_total1 = parseFloat(data.data1[0].ti_rest_nd_ot_total).toFixed(2);

                // no multilpliers
                var ti_sil_20201 = parseFloat(data.data1[0].ti_sil_2020).toFixed(2);
                var ti_meal1 = parseFloat(data.data1[0].ti_meal).toFixed(2);
                var ti_gov_cont1 = parseFloat(data.data1[0].ti_gov_cont).toFixed(2);
                var ti_others1 = parseFloat(data.data1[0].ti_others).toFixed(2);
                var ti_gross1 = parseFloat(data.data1[0].ti_gross).toFixed(2);

                // taxes
                var gov_sss_ee1 = parseFloat(data.data1[0].gov_sss_ee).toFixed(2);
                var gov_philhealth_ee1 = parseFloat(data.data1[0].gov_philhealth_ee).toFixed(2);
                var gov_pagibig_ee1 = parseFloat(data.data1[0].gov_pagibig_ee).toFixed(2);
                var gov_total_ee1 = parseFloat(data.data1[0].gov_total_ee).toFixed(2);
                var comp_cont_sss1 = parseFloat(data.data1[0].comp_cont_sss).toFixed(2);
                var comp_cont_sss_ec1 = parseFloat(data.data1[0].comp_cont_sss_ec).toFixed(2);
                var comp_cont_philhealth1 = parseFloat(data.data1[0].comp_cont_philhealth).toFixed(2);
                var comp_cont_pagibig1 = parseFloat(data.data1[0].comp_cont_pagibig).toFixed(2);
                var comp_cont_total1 = parseFloat(data.data1[0].comp_cont_total).toFixed(2);

                // taxable allowance
                var ta_load1 = parseFloat(data.data1[0].ta_load).toFixed(2);
                var ta_transportation1 = parseFloat(data.data1[0].ta_transportation).toFixed(2);
                var ta_skill1 = parseFloat(data.data1[0].ta_skill).toFixed(2);
                var ta_pioneer1 = parseFloat(data.data1[0].ta_pioneer).toFixed(2);
                var ta_daily_allowance1 = parseFloat(data.data1[0].ta_daily_allowance).toFixed(2);
                var ta_allowance1 = parseFloat(data.data1[0].ta_allowance).toFixed(2);
                ta_allowance1 = parseFloat(ta_allowance1) - parseFloat(ta_daily_allowance1);

                // total taxable allowance + witholding tax
                var ta_total1 = parseFloat(data.data1[0].ta_total).toFixed(2);
                var wtax1 = parseFloat(data.data1[0].wtax).toFixed(2);

                // loans
                var loan_sss_salary1 = parseFloat(data.data1[0].loan_sss_salary).toFixed(2);
                var loan_sss_calamity1 = parseFloat(data.data1[0].loan_sss_calamity).toFixed(2);
                var loan_pagibig_salary1 = parseFloat(data.data1[0].loan_pagibig_salary).toFixed(2);
                var loan_pagibig_calamity1 = parseFloat(data.data1[0].loan_pagibig_calamity).toFixed(2);
                var loan_emergency1 = parseFloat(data.data1[0].loan_emergency).toFixed(2);
                var loan_total1 = parseFloat(data.data1[0].loan_total).toFixed(2);

                // refund
                var tax_refund1 = parseFloat(data.data1[0].tax_refund).toFixed(2);

                // deductions
                var salary_advance1 = parseFloat(data.data1[0].salary_advance).toFixed(2);
                var uniform_deduction1 = parseFloat(data.data1[0].uniform_deduction).toFixed(2);
                var ded_total1 = parseFloat(data.data1[0].ded_total).toFixed(2);

                // net pay
                var net_pay1 = parseFloat(data.data1[0].net_pay).toFixed(2);

                // modified db variables
                var ti_meal_earning1 = 0;
                var ti_gov_cont_earning1 = 0;
                var ti_others_earning1 = 0;
                var tax_refund_earning1 = 0;

                var ti_meal_deduction1 = 0;
                var ti_gov_cont_deduction1 = 0;
                var ti_others_deduction1 = 0;
                var tax_refund_deduction1 = 0;

                var sss_loan1 = 0;
                var pagibig_loan1 = 0;

                if (ti_meal1 > 0) {
                    ti_meal_earning1 = Math.abs(parseFloat(ti_meal1));
                }
                if (ti_gov_cont1 < 0) {
                    ti_gov_cont_earning1 = Math.abs(parseFloat(ti_gov_cont1));
                }
                if (ti_others1 > 0) {
                    ti_others_earning1 = Math.abs(parseFloat(ti_others1));
                }
                if (tax_refund1 > 0) {
                    tax_refund_earning1 = Math.abs(parseFloat(tax_refund1));
                }

                if (ti_meal1 < 0) {
                    ti_meal_deduction1 = Math.abs(parseFloat(ti_meal1));
                }
                if (ti_gov_cont1 > 0) {
                    ti_gov_cont_deduction1 = Math.abs(parseFloat(ti_gov_cont1));
                }
                if (ti_others1 < 0) {
                    ti_others_deduction1 = Math.abs(parseFloat(ti_others1));
                }
                if (tax_refund1 < 0) {
                    tax_refund_deduction1 = Math.abs(parseFloat(tax_refund1));
                }

                if (net_pay1 == 0) {
                    net_pay1 = '-';
                }

                // for modified db variables
                if (sss_loan1 > 0) {
                    sss_loan1,
                    sss_loan1 = (parseFloat(loan_sss_salary1) + parseFloat(loan_sss_calamity1)).toFixed(2);
                }
                if (pagibig_loan1 > 0) {
                    pagibig_loan1,
                    pagibig_loan1 = (parseFloat(loan_pagibig_salary1) + parseFloat(loan_pagibig_calamity1)).toFixed(2);
                }

                // total_earnings =  parseFloat(ti_rest_sp_hol_total) + parseFloat(ti_basic_sal_total) + parseFloat(ti_leave_total) + parseFloat(ta_allowance) + parseFloat(ti_legal_hol_total) + parseFloat(ti_reg_ot_total) + parseFloat(ti_rest_total) + parseFloat(ti_nd_total) + parseFloat(ti_nd_ot_total) + parseFloat(ti_de_minimis_total) + parseFloat(ti_sil_2020) + parseFloat(ti_meal_earning) + parseFloat(ti_gov_cont_earning) + parseFloat(ti_others_earning) + parseFloat(tax_refund_earning);
                total_earnings1 = parseFloat(ti_rest_sp_hol_total1) + parseFloat(ti_basic_sal_total1) + parseFloat(ti_leave_total1) + parseFloat(ta_daily_allowance1) + parseFloat(ta_allowance1) + parseFloat(ti_legal_hol_total1) + parseFloat(ti_reg_ot_total1) + parseFloat(ti_rest_total1) + parseFloat(ti_nd_total1) + parseFloat(ti_nd_ot_total1) + parseFloat(ti_de_minimis_total1) + parseFloat(ti_rest_ot_total1) + parseFloat(ti_rest_nd_ot_total1) + parseFloat(ti_sil_20201) + parseFloat(ti_meal_earning1) + parseFloat(ti_gov_cont_earning1) + parseFloat(ti_others_earning1) + parseFloat(tax_refund_earning1);
                // total_earnings1 =  parseFloat(ti_rest_sp_hol_total1) + parseFloat(ti_basic_sal_total1) + parseFloat(ti_leave_total1) + parseFloat(ta_daily_allowance1) + parseFloat(ta_allowance1) + parseFloat(ti_legal_hol_total1) + parseFloat(ti_reg_ot_total1) + parseFloat(ti_rest_total1) + parseFloat(ti_nd_total1) + parseFloat(ti_nd_ot_total1) + parseFloat(ti_de_minimis_total1) + parseFloat(ti_rest_ot_total1) + parseFloat(ti_rest_nd_ot_total1) + parseFloat(ti_meal_earning1) + parseFloat(ti_gov_cont_earning1) + parseFloat(ti_others_earning1) + parseFloat(tax_refund_earning1);

                total_deductions1 = parseFloat(wtax1) + parseFloat(gov_sss_ee1) + parseFloat(gov_philhealth_ee1) + parseFloat(gov_pagibig_ee1) + parseFloat(loan_amount_paid1) + parseFloat(pagibig_loan_amount_paid1) + parseFloat(ti_absent_total1) + parseFloat(ti_tard_total1) + parseFloat(ti_undertime_total1) + parseFloat(ti_half_total1) + parseFloat(salary_advance1) + parseFloat(uniform_deduction1) + parseFloat(ti_meal_deduction1) + parseFloat(ti_gov_cont_deduction1) + parseFloat(ti_others_deduction1) + parseFloat(tax_refund_deduction1);
                total_earnings1 = parseFloat(total_earnings1).toFixed(2);
                total_deductions1 = parseFloat(total_deductions1).toFixed(2);

                if (ti_meal_earning1 <= 0) {
                    ti_meal_earning1 = '-';
                }
                if (ti_gov_cont_earning1 <= 0) {
                    ti_gov_cont_earning1 = '-';
                }
                if (ti_others_earning1 <= 0) {
                    ti_others_earning1 = '-';
                }
                if (tax_refund_earning1 <= 0) {
                    tax_refund_earning1 = '-';
                }
                if (ti_meal_deduction1 <= 0) {
                    ti_meal_deduction1 = '-';
                }
                if (ti_gov_cont_deduction1 <= 0) {
                    ti_gov_cont_deduction1 = '-';
                }
                if (ti_others_deduction1 <= 0) {
                    ti_others_deduction1 = '-';
                }
                if (tax_refund_deduction1 <= 0) {
                    tax_refund_deduction1 = '-';
                }

                if (sss_loan1 <= 0) {
                    sss_loan1 = '-';
                }
                if (pagibig_loan1 <= 0) {
                    pagibig_loan1 = '-';
                }

                if (ti_basic_sal_mul1 <= 0) {
                    ti_basic_sal_mul1 = '-';
                }
                if (ti_absent_mul1 <= 0) {
                    ti_absent_mul1 = '-';
                }
                if (ti_no_ti_to_mul1 <= 0) {
                    ti_no_ti_to_mul1 = '-';
                }
                if (ti_tard_mul1 <= 0) {
                    ti_tard_mul1 = '-';
                }
                if (ti_half_mul1 <= 0) {
                    ti_half_mul1 = '-';
                }
                if (ti_undertime_mul1 <= 0) {
                    ti_undertime_mul1 = '-';
                }
                if (ti_rest_mul1 <= 0) {
                    ti_rest_mul1 = '-';
                }
                if (ti_rest_sp_hol_mul1 <= 0) {
                    ti_rest_sp_hol_mul1 = '-';
                }
                if (ti_legal_hol_mul1 <= 0) {
                    ti_legal_hol_mul1 = '-';
                }
                if (ti_rest_legal_hol_mul1 <= 0) {
                    ti_rest_legal_hol_mul1 = '-';
                }
                if (ti_reg_ot_mul1 <= 0) {
                    ti_reg_ot_mul1 = '-';
                }
                if (ti_nd_ot_mul1 <= 0) {
                    ti_nd_ot_mul1 = '-';
                }
                if (ti_nd_mul1 <= 0) {
                    ti_nd_mul1 = '-';
                }
                if (ti_rest_ot_mul1 <= 0) {
                    ti_rest_ot_mul1 = '-';
                }
                if (ti_rest_nd_ot_mul1 <= 0) {
                    ti_rest_nd_ot_mul1 = '-';
                }

                if (ti_basic_sal_total1 <= 0) {
                    ti_basic_sal_total1 = '-';
                }
                if (ti_absent_total1 <= 0) {
                    ti_absent_total1 = '-';
                }
                if (ti_no_ti_to_total1 <= 0) {
                    ti_no_ti_to_total1 = '-';
                }
                if (ti_tard_total1 <= 0) {
                    ti_tard_total1 = '-';
                }
                if (ti_half_total1 <= 0) {
                    ti_half_total1 = '-';
                }
                if (ti_undertime_total1 <= 0) {
                    ti_undertime_total1 = '-';
                }
                if (ti_rest_total1 <= 0) {
                    ti_rest_total1 = '-';
                }
                if (ti_rest_sp_hol_total1 <= 0) {
                    ti_rest_sp_hol_total1 = '-';
                }
                if (ti_legal_hol_total1 <= 0) {
                    ti_legal_hol_total1 = '-';
                }
                if (ti_rest_legal_hol_total1 <= 0) {
                    ti_rest_legal_hol_total1 = '-';
                }
                if (ti_reg_ot_total1 <= 0) {
                    ti_reg_ot_total1 = '-';
                }
                if (ti_nd_ot_total1 <= 0) {
                    ti_nd_ot_total1 = '-';
                }
                if (ti_nd_total1 <= 0) {
                    ti_nd_total1 = '-';
                }
                if (ti_leave_total1 <= 0) {
                    ti_leave_total1 = '-';
                }
                if (ti_de_minimis_total1 <= 0) {
                    ti_de_minimis_total1 = '-';
                }
                if (ti_rest_ot_total1 <= 0) {
                    ti_rest_ot_total1 = '-';
                }
                if (ti_rest_nd_ot_total1 <= 0) {
                    ti_rest_nd_ot_total1 = '-';
                }

                if (ti_sil_20201 <= 0) {
                    ti_sil_20201 = '-';
                }
                if (ti_meal1 <= 0) {
                    ti_meal1 = '-';
                }
                if (ti_gov_cont1 <= 0) {
                    ti_gov_cont1 = '-';
                }
                if (ti_others1 <= 0) {
                    ti_others1 = '-';
                }
                if (ti_gross1 <= 0) {
                    ti_gross1 = '-';
                }
                if (gov_sss_ee1 <= 0) {
                    gov_sss_ee1 = '-';
                }
                if (gov_philhealth_ee1 <= 0) {
                    gov_philhealth_ee1 = '-';
                }
                if (gov_pagibig_ee1 <= 0) {
                    gov_pagibig_ee1 = '-';
                }
                if (gov_total_ee1 <= 0) {
                    gov_total_ee1 = '-';
                }
                if (comp_cont_sss1 <= 0) {
                    comp_cont_sss1 = '-';
                }
                if (comp_cont_sss_ec1 <= 0) {
                    comp_cont_sss_ec1 = '-';
                }
                if (comp_cont_philhealth1 <= 0) {
                    comp_cont_philhealth1 = '-';
                }
                if (comp_cont_pagibig1 <= 0) {
                    comp_cont_pagibig1 = '-';
                }
                if (comp_cont_total1 <= 0) {
                    comp_cont_total1 = '-';
                }
                if (ta_load1 <= 0) {
                    ta_load1 = '-';
                }
                if (ta_transportation1 <= 0) {
                    ta_transportation1 = '-';
                }
                if (ta_skill1 <= 0) {
                    ta_skill1 = '-';
                }
                if (ta_pioneer1 <= 0) {
                    ta_pioneer1 = '-';
                }
                if (ta_daily_allowance1 == 0) {
                    ta_daily_allowance1 = '-';
                }
                if (ta_allowance1 <= 0) {
                    ta_allowance1 = '-';
                }
                if (ta_total1 <= 0) {
                    ta_total1 = '-';
                }
                if (wtax1 <= 0) {
                    wtax1 = '-';
                }
                if (loan_sss_salary1 <= 0) {
                    loan_sss_salary1 = '-';
                }
                if (loan_sss_calamity1 <= 0) {
                    loan_sss_calamity1 = '-';
                }
                if (loan_pagibig_salary1 <= 0) {
                    loan_pagibig_salary1 = '-';
                }
                if (loan_pagibig_calamity1 <= 0) {
                    loan_pagibig_calamity1 = '-';
                }
                if (loan_emergency1 <= 0) {
                    loan_emergency1 = '-';
                }
                if (loan_total1 <= 0) {
                    loan_total1 = '-';
                }
                if (tax_refund1 <= 0) {
                    tax_refund1 = '-';
                }
                if (salary_advance1 <= 0) {
                    salary_advance1 = '-';
                }
                if (uniform_deduction1 <= 0) {
                    uniform_deduction1 = '-';
                }
                if (ded_total1 <= 0) {
                    ded_total1 = '-';
                }
                if (net_pay1 <= 0) {
                    net_pay1 = '-';
                }
                if (ti_leave_mul1 <= 0) {
                    ti_leave_mul1 = '-';
                }

                if (loan_amount_paid1 <= 0) {
                    loan_amount_paid1 = '-';
                }
                if (pagibig_loan_amount_paid1 <= 0) {
                    pagibig_loan_amount_paid1 = '-';
                }








                // ================================ PAYSLIP 3 ==================================
                var working_days2 = data.data2[0].working_days;
                var absences2 = data.data2[0].abs_mul;

                var salary_rate2 = parseFloat(data.data2[0].salary_rate).toFixed(2);
                var db_salary_type2 = data.data2[0].salary_type;
                var hours_of_work2 = parseFloat(data.data2[0].hours_of_work);
                var daily_salary2 = parseFloat(data.data2[0].daily_salary);
                var hourly_salary2 = parseFloat(data.data2[0].hourly_salary);
                var days_present2 = parseFloat(data.data2[0].ti_basic_sal_mul);

                // =================== database data ===================
                // multipliers
                var ti_basic_sal_mul2 = parseFloat(data.data2[0].ti_basic_sal_mul).toFixed(2);
                var ti_absent_mul2 = parseFloat(data.data2[0].ti_absent_mul).toFixed(2);
                var ti_no_ti_to_mul2 = parseFloat(data.data2[0].ti_no_ti_to_mul).toFixed(2);
                var ti_tard_mul2 = parseFloat(data.data2[0].ti_tard_mul).toFixed(2);
                var ti_half_mul2 = parseFloat(data.data2[0].ti_half_mul).toFixed(2);
                var ti_undertime_mul2 = parseFloat(data.data2[0].ti_undertime_mul).toFixed(2);
                var ti_rest_mul2 = parseFloat(data.data2[0].ti_rest_mul).toFixed(2);
                var ti_rest_sp_hol_mul2 = parseFloat(data.data2[0].ti_rest_sp_hol_mul).toFixed(2);
                var ti_legal_hol_mul2 = parseFloat(data.data2[0].ti_legal_hol_mul).toFixed(2);
                var ti_rest_legal_hol_mul2 = parseFloat(data.data2[0].ti_rest_legal_hol_mul).toFixed(2);
                var ti_reg_ot_mul2 = parseFloat(data.data2[0].ti_reg_ot_mul).toFixed(2);
                var ti_nd_ot_mul2 = parseFloat(data.data2[0].ti_nd_ot_mul).toFixed(2);
                var ti_nd_mul2 = parseFloat(data.data2[0].ti_nd_mul).toFixed(2);
                var ti_leave_mul2 = parseFloat(data.data2[0].ti_leave_mul).toFixed(2);
                var ti_de_minimis_mul2 = parseFloat(data.data2[0].ti_de_minimis_mul).toFixed(2);
                var ti_rest_ot_mul2 = parseFloat(data.data2[0].ti_rest_ot_mul).toFixed(2);
                var ti_rest_nd_ot_mul2 = parseFloat(data.data2[0].ti_rest_nd_ot_mul).toFixed(2);

                // totals
                var ti_basic_sal_total2 = parseFloat(data.data2[0].ti_basic_sal_total).toFixed(2);
                var ti_absent_total2 = parseFloat(data.data2[0].ti_absent_total).toFixed(2);
                var ti_no_ti_to_total2 = parseFloat(data.data2[0].ti_no_ti_to_total).toFixed(2);
                var ti_tard_total2 = parseFloat(data.data2[0].ti_tard_total).toFixed(2);
                var ti_half_total2 = parseFloat(data.data2[0].ti_half_total).toFixed(2);
                var ti_undertime_total2 = parseFloat(data.data2[0].ti_undertime_total).toFixed(2);
                var ti_rest_total2 = parseFloat(data.data2[0].ti_rest_total).toFixed(2);
                var ti_rest_sp_hol_total2 = parseFloat(data.data2[0].ti_rest_sp_hol_total).toFixed(2);
                var ti_legal_hol_total2 = parseFloat(data.data2[0].ti_legal_hol_total).toFixed(2);
                var ti_rest_legal_hol_total2 = parseFloat(data.data2[0].ti_rest_legal_hol_total).toFixed(2);
                var ti_reg_ot_total2 = parseFloat(data.data2[0].ti_reg_ot_total).toFixed(2);
                var ti_nd_ot_total2 = parseFloat(data.data2[0].ti_nd_ot_total).toFixed(2);
                var ti_nd_total2 = parseFloat(data.data2[0].ti_nd_total).toFixed(2);
                var ti_leave_total2 = parseFloat(data.data2[0].ti_leave_total).toFixed(2);
                var ti_de_minimis_total2 = parseFloat(data.data2[0].ti_de_minimis_total).toFixed(2);
                var ti_rest_ot_total2 = parseFloat(data.data2[0].ti_rest_ot_total).toFixed(2);
                var ti_rest_nd_ot_total2 = parseFloat(data.data2[0].ti_rest_nd_ot_total).toFixed(2);

                // no multilpliers
                var ti_sil_20202 = parseFloat(data.data2[0].ti_sil_2020).toFixed(2);
                var ti_meal2 = parseFloat(data.data2[0].ti_meal).toFixed(2);
                var ti_gov_cont2 = parseFloat(data.data2[0].ti_gov_cont).toFixed(2);
                var ti_others2 = parseFloat(data.data2[0].ti_others).toFixed(2);
                var ti_gross2 = parseFloat(data.data2[0].ti_gross).toFixed(2);

                // taxes
                var gov_sss_ee2 = parseFloat(data.data2[0].gov_sss_ee).toFixed(2);
                var gov_philhealth_ee2 = parseFloat(data.data2[0].gov_philhealth_ee).toFixed(2);
                var gov_pagibig_ee2 = parseFloat(data.data2[0].gov_pagibig_ee).toFixed(2);
                var gov_total_ee2 = parseFloat(data.data2[0].gov_total_ee).toFixed(2);
                var comp_cont_sss2 = parseFloat(data.data2[0].comp_cont_sss).toFixed(2);
                var comp_cont_sss_ec2 = parseFloat(data.data2[0].comp_cont_sss_ec).toFixed(2);
                var comp_cont_philhealth2 = parseFloat(data.data2[0].comp_cont_philhealth).toFixed(2);
                var comp_cont_pagibig2 = parseFloat(data.data2[0].comp_cont_pagibig).toFixed(2);
                var comp_cont_total2 = parseFloat(data.data2[0].comp_cont_total).toFixed(2);

                // taxable allowance
                var ta_load2 = parseFloat(data.data2[0].ta_load).toFixed(2);
                var ta_transportation2 = parseFloat(data.data2[0].ta_transportation).toFixed(2);
                var ta_skill2 = parseFloat(data.data2[0].ta_skill).toFixed(2);
                var ta_pioneer2 = parseFloat(data.data2[0].ta_pioneer).toFixed(2);
                var ta_daily_allowance2 = parseFloat(data.data2[0].ta_daily_allowance).toFixed(2);
                var ta_allowance2 = parseFloat(data.data2[0].ta_allowance).toFixed(2);
                ta_allowance2 = parseFloat(ta_allowance2) - parseFloat(ta_daily_allowance2);

                // total taxable allowance + witholding tax
                var ta_total2 = parseFloat(data.data2[0].ta_total).toFixed(2);
                var wtax2 = parseFloat(data.data2[0].wtax).toFixed(2);

                // loans
                var loan_sss_salary2 = parseFloat(data.data2[0].loan_sss_salary).toFixed(2);
                var loan_sss_calamity2 = parseFloat(data.data2[0].loan_sss_calamity).toFixed(2);
                var loan_pagibig_salary2 = parseFloat(data.data2[0].loan_pagibig_salary).toFixed(2);
                var loan_pagibig_calamity2 = parseFloat(data.data2[0].loan_pagibig_calamity).toFixed(2);
                var loan_emergency2 = parseFloat(data.data2[0].loan_emergency).toFixed(2);
                var loan_total2 = parseFloat(data.data2[0].loan_total).toFixed(2);

                // refund
                var tax_refund2 = parseFloat(data.data2[0].tax_refund).toFixed(2);

                // deductions
                var salary_advance2 = parseFloat(data.data2[0].salary_advance).toFixed(2);
                var uniform_deduction2 = parseFloat(data.data2[0].uniform_deduction).toFixed(2);
                var ded_total2 = parseFloat(data.data2[0].ded_total).toFixed(2);

                // net pay
                var net_pay2 = parseFloat(data.data2[0].net_pay).toFixed(2);

                // modified db variables
                var ti_meal_earning2 = 0;
                var ti_gov_cont_earning2 = 0;
                var ti_others_earning2 = 0;
                var tax_refund_earning2 = 0;

                var ti_meal_deduction2 = 0;
                var ti_gov_cont_deduction2 = 0;
                var ti_others_deduction2 = 0;
                var tax_refund_deduction2 = 0;

                var sss_loan2 = 0;
                var pagibig_loan2 = 0;




                if (ti_meal2 > 0) {
                    ti_meal_earning2 = Math.abs(parseFloat(ti_meal2));
                }
                if (ti_gov_cont2 < 0) {
                    ti_gov_cont_earning2 = Math.abs(parseFloat(ti_gov_cont2));
                }
                if (ti_others2 > 0) {
                    ti_others_earning2 = Math.abs(parseFloat(ti_others2));
                }
                if (tax_refund2 > 0) {
                    tax_refund_earning2 = Math.abs(parseFloat(tax_refund2));
                }

                if (ti_meal2 < 0) {
                    ti_meal_deduction2 = Math.abs(parseFloat(ti_meal2));
                }
                if (ti_gov_cont2 > 0) {
                    ti_gov_cont_deduction2 = Math.abs(parseFloat(ti_gov_cont2));
                }
                if (ti_others2 < 0) {
                    ti_others_deduction2 = Math.abs(parseFloat(ti_others2));
                }
                if (tax_refund2 < 0) {
                    tax_refund_deduction2 = Math.abs(parseFloat(tax_refund2));
                }

                if (net_pay2 == 0) {
                    net_pay2 = '-';
                }

                // for modified db variables
                if (sss_loan2 > 0) {
                    sss_loan2,
                    sss_loan2 = (parseFloat(loan_sss_salary2) + parseFloat(loan_sss_calamity2)).toFixed(2);
                }
                if (pagibig_loan2 > 0) {
                    pagibig_loan2,
                    pagibig_loan2 = (parseFloat(loan_pagibig_salary2) + parseFloat(loan_pagibig_calamity2)).toFixed(2);
                }





                // total_earnings =  parseFloat(ti_rest_sp_hol_total) + parseFloat(ti_basic_sal_total) + parseFloat(ti_leave_total) + parseFloat(ta_allowance) + parseFloat(ti_legal_hol_total) + parseFloat(ti_reg_ot_total) + parseFloat(ti_rest_total) + parseFloat(ti_nd_total) + parseFloat(ti_nd_ot_total) + parseFloat(ti_de_minimis_total) + parseFloat(ti_sil_2020) + parseFloat(ti_meal_earning) + parseFloat(ti_gov_cont_earning) + parseFloat(ti_others_earning) + parseFloat(tax_refund_earning);
                total_earnings2 = parseFloat(ti_rest_sp_hol_total2) + parseFloat(ti_basic_sal_total2) + parseFloat(ti_leave_total2) + parseFloat(ta_daily_allowance2) + parseFloat(ta_allowance2) + parseFloat(ti_legal_hol_total2) + parseFloat(ti_reg_ot_total2) + parseFloat(ti_rest_total2) + parseFloat(ti_nd_total2) + parseFloat(ti_nd_ot_total2) + parseFloat(ti_de_minimis_total2) + parseFloat(ti_rest_ot_total2) + parseFloat(ti_rest_nd_ot_total2) + parseFloat(ti_sil_20202) + parseFloat(ti_meal_earning2) + parseFloat(ti_gov_cont_earning2) + parseFloat(ti_others_earning2) + parseFloat(tax_refund_earning2);
                // total_earnings2 =  parseFloat(ti_rest_sp_hol_total2) + parseFloat(ti_basic_sal_total2) + parseFloat(ti_leave_total2) + parseFloat(ta_daily_allowance2) + parseFloat(ta_allowance2) + parseFloat(ti_legal_hol_total2) + parseFloat(ti_reg_ot_total2) + parseFloat(ti_rest_total2) + parseFloat(ti_nd_total2) + parseFloat(ti_nd_ot_total2) + parseFloat(ti_de_minimis_total2) + parseFloat(ti_rest_ot_total2) + parseFloat(ti_rest_nd_ot_total2) + parseFloat(ti_meal_earning2) + parseFloat(ti_gov_cont_earning2) + parseFloat(ti_others_earning2) + parseFloat(tax_refund_earning2);
                total_deductions2 = parseFloat(wtax2) + parseFloat(gov_sss_ee2) + parseFloat(gov_philhealth_ee2) + parseFloat(gov_pagibig_ee2) + parseFloat(loan_amount_paid2) + parseFloat(pagibig_loan_amount_paid2) + parseFloat(ti_absent_total2) + parseFloat(ti_tard_total2) + parseFloat(ti_undertime_total2) + parseFloat(ti_half_total2) + parseFloat(salary_advance2) + parseFloat(uniform_deduction2) + parseFloat(ti_meal_deduction2) + parseFloat(ti_gov_cont_deduction2) + parseFloat(ti_others_deduction2) + parseFloat(tax_refund_deduction2);

                total_earnings2 = parseFloat(total_earnings2).toFixed(2);
                total_deductions2 = parseFloat(total_deductions2).toFixed(2);

                if (ti_meal_earning2 <= 0) {
                    ti_meal_earning2 = '-';
                }
                if (ti_gov_cont_earning2 <= 0) {
                    ti_gov_cont_earning2 = '-';
                }
                if (ti_others_earning2 <= 0) {
                    ti_others_earning2 = '-';
                }
                if (tax_refund_earning2 <= 0) {
                    tax_refund_earning2 = '-';
                }
                if (ti_meal_deduction2 <= 0) {
                    ti_meal_deduction2 = '-';
                }
                if (ti_gov_cont_deduction2 <= 0) {
                    ti_gov_cont_deduction2 = '-';
                }
                if (ti_others_deduction2 <= 0) {
                    ti_others_deduction2 = '-';
                }
                if (tax_refund_deduction2 <= 0) {
                    tax_refund_deduction2 = '-';
                }

                if (sss_loan2 <= 0) {
                    sss_loan2 = '-';
                }
                if (pagibig_loan2 <= 0) {
                    pagibig_loan2 = '-';
                }

                if (ti_basic_sal_mul2 <= 0) {
                    ti_basic_sal_mul2 = '-';
                }
                if (ti_absent_mul2 <= 0) {
                    ti_absent_mul2 = '-';
                }
                if (ti_no_ti_to_mul2 <= 0) {
                    ti_no_ti_to_mul2 = '-';
                }
                if (ti_tard_mul2 <= 0) {
                    ti_tard_mul2 = '-';
                }
                if (ti_half_mul2 <= 0) {
                    ti_half_mul2 = '-';
                }
                if (ti_undertime_mul2 <= 0) {
                    ti_undertime_mul2 = '-';
                }
                if (ti_rest_mul2 <= 0) {
                    ti_rest_mul2 = '-';
                }
                if (ti_rest_sp_hol_mul2 <= 0) {
                    ti_rest_sp_hol_mul2 = '-';
                }
                if (ti_legal_hol_mul2 <= 0) {
                    ti_legal_hol_mul2 = '-';
                }
                if (ti_rest_legal_hol_mul2 <= 0) {
                    ti_rest_legal_hol_mul2 = '-';
                }
                if (ti_reg_ot_mul2 <= 0) {
                    ti_reg_ot_mul2 = '-';
                }
                if (ti_nd_ot_mul2 <= 0) {
                    ti_nd_ot_mul2 = '-';
                }
                if (ti_nd_mul2 <= 0) {
                    ti_nd_mul2 = '-';
                }
                if (ti_rest_ot_mul2 <= 0) {
                    ti_rest_ot_mul2 = '-';
                }
                if (ti_rest_nd_ot_mul2 <= 0) {
                    ti_rest_nd_ot_mul2 = '-';
                }

                if (ti_basic_sal_total2 <= 0) {
                    ti_basic_sal_total2 = '-';
                }
                if (ti_absent_total2 <= 0) {
                    ti_absent_total2 = '-';
                }
                if (ti_no_ti_to_total2 <= 0) {
                    ti_no_ti_to_total2 = '-';
                }
                if (ti_tard_total2 <= 0) {
                    ti_tard_total2 = '-';
                }
                if (ti_half_total2 <= 0) {
                    ti_half_total2 = '-';
                }
                if (ti_undertime_total2 <= 0) {
                    ti_undertime_total2 = '-';
                }
                if (ti_rest_total2 <= 0) {
                    ti_rest_total2 = '-';
                }
                if (ti_rest_sp_hol_total2 <= 0) {
                    ti_rest_sp_hol_total2 = '-';
                }
                if (ti_legal_hol_total2 <= 0) {
                    ti_legal_hol_total2 = '-';
                }
                if (ti_rest_legal_hol_total2 <= 0) {
                    ti_rest_legal_hol_total2 = '-';
                }
                if (ti_reg_ot_total2 <= 0) {
                    ti_reg_ot_total2 = '-';
                }
                if (ti_nd_ot_total2 <= 0) {
                    ti_nd_ot_total2 = '-';
                }
                if (ti_nd_total1 <= 0) {
                    ti_nd_total2 = '-';
                }
                if (ti_leave_total2 <= 0) {
                    ti_leave_total2 = '-';
                }
                if (ti_de_minimis_total2 <= 0) {
                    ti_de_minimis_total2 = '-';
                }
                if (ti_rest_ot_total2 <= 0) {
                    ti_rest_ot_total2 = '-';
                }
                if (ti_rest_nd_ot_total2 <= 0) {
                    ti_rest_nd_ot_total2 = '-';
                }

                if (ti_sil_20202 <= 0) {
                    ti_sil_20202 = '-';
                }
                if (ti_meal2 <= 0) {
                    ti_meal2 = '-';
                }
                if (ti_gov_cont2 <= 0) {
                    ti_gov_cont2 = '-';
                }
                if (ti_others2 <= 0) {
                    ti_others2 = '-';
                }
                if (ti_gross2 <= 0) {
                    ti_gross2 = '-';
                }
                if (gov_sss_ee2 <= 0) {
                    gov_sss_ee2 = '-';
                }
                if (gov_philhealth_ee2 <= 0) {
                    gov_philhealth_ee2 = '-';
                }
                if (gov_pagibig_ee2 <= 0) {
                    gov_pagibig_ee2 = '-';
                }
                if (gov_total_ee2 <= 0) {
                    gov_total_ee2 = '-';
                }
                if (comp_cont_sss2 <= 0) {
                    comp_cont_sss2 = '-';
                }
                if (comp_cont_sss_ec2 <= 0) {
                    comp_cont_sss_ec2 = '-';
                }
                if (comp_cont_philhealth2 <= 0) {
                    comp_cont_philhealth2 = '-';
                }
                if (comp_cont_pagibig2 <= 0) {
                    comp_cont_pagibig2 = '-';
                }
                if (comp_cont_total2 <= 0) {
                    comp_cont_total2 = '-';
                }
                if (ta_load2 <= 0) {
                    ta_load2 = '-';
                }
                if (ta_transportation2 <= 0) {
                    ta_transportation2 = '-';
                }
                if (ta_skill2 <= 0) {
                    ta_skill2 = '-';
                }
                if (ta_pioneer2 <= 0) {
                    ta_pioneer2 = '-';
                }
                if (ta_daily_allowance2 == 0) {
                    ta_daily_allowance2 = '-';
                }
                if (ta_allowance2 <= 0) {
                    ta_allowance2 = '-';
                }
                if (ta_total2 <= 0) {
                    ta_total2 = '-';
                }
                if (wtax2 <= 0) {
                    wtax2 = '-';
                }
                if (loan_sss_salary2 <= 0) {
                    loan_sss_salary2 = '-';
                }
                if (loan_sss_calamity2 <= 0) {
                    loan_sss_calamity2 = '-';
                }
                if (loan_pagibig_salary2 <= 0) {
                    loan_pagibig_salary2 = '-';
                }
                if (loan_pagibig_calamity2 <= 0) {
                    loan_pagibig_calamity2 = '-';
                }
                if (loan_emergency2 <= 0) {
                    loan_emergency2 = '-';
                }
                if (loan_total2 <= 0) {
                    loan_total2 = '-';
                }
                if (tax_refund2 <= 0) {
                    tax_refund2 = '-';
                }
                if (salary_advance2 <= 0) {
                    salary_advance2 = '-';
                }
                if (uniform_deduction2 <= 0) {
                    uniform_deduction2 = '-';
                }
                if (ded_total2 <= 0) {
                    ded_total2 = '-';
                }
                if (net_pay2 <= 0) {
                    net_pay2 = '-';
                }
                if (ti_leave_mul2 <= 0) {
                    ti_leave_mul2 = '-';
                }

                if (loan_amount_paid2 <= 0) {
                    loan_amount_paid2 = '-';
                }
                if (pagibig_loan_amount_paid2 <= 0) {
                    pagibig_loan_amount_paid2 = '-';
                }






                // // console.log();

                // // console.log(ti_leave_mul)


                // You'll need to make your image into a Data URL
                // Use http://dataurl.net/#dataurlmaker
                // SETTINGS
                var imgData = 'data:image/jpeg;base64,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AAAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAA4QklNBAAAAAAAAAIAAThCSU0EAgAAAAAABAAAAAA4QklNBDAAAAAAAAIBAThCSU0ELQAAAAAABgABAAAAAjhCSU0ECAAAAAAAEAAAAAEAAAJAAAACQAAAAAA4QklNBB4AAAAAAAQAAAAAOEJJTQQaAAAAAANJAAAABgAAAAAAAAAAAAAAeQAAANcAAAAKAFUAbgB0AGkAdABsAGUAZAAtADIAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAANcAAAB5AAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAEAAAAAEAAAAAAABudWxsAAAAAgAAAAZib3VuZHNPYmpjAAAAAQAAAAAAAFJjdDEAAAAEAAAAAFRvcCBsb25nAAAAAAAAAABMZWZ0bG9uZwAAAAAAAAAAQnRvbWxvbmcAAAB5AAAAAFJnaHRsb25nAAAA1wAAAAZzbGljZXNWbExzAAAAAU9iamMAAAABAAAAAAAFc2xpY2UAAAASAAAAB3NsaWNlSURsb25nAAAAAAAAAAdncm91cElEbG9uZwAAAAAAAAAGb3JpZ2luZW51bQAAAAxFU2xpY2VPcmlnaW4AAAANYXV0b0dlbmVyYXRlZAAAAABUeXBlZW51bQAAAApFU2xpY2VUeXBlAAAAAEltZyAAAAAGYm91bmRzT2JqYwAAAAEAAAAAAABSY3QxAAAABAAAAABUb3AgbG9uZwAAAAAAAAAATGVmdGxvbmcAAAAAAAAAAEJ0b21sb25nAAAAeQAAAABSZ2h0bG9uZwAAANcAAAADdXJsVEVYVAAAAAEAAAAAAABudWxsVEVYVAAAAAEAAAAAAABNc2dlVEVYVAAAAAEAAAAAAAZhbHRUYWdURVhUAAAAAQAAAAAADmNlbGxUZXh0SXNIVE1MYm9vbAEAAAAIY2VsbFRleHRURVhUAAAAAQAAAAAACWhvcnpBbGlnbmVudW0AAAAPRVNsaWNlSG9yekFsaWduAAAAB2RlZmF1bHQAAAAJdmVydEFsaWduZW51bQAAAA9FU2xpY2VWZXJ0QWxpZ24AAAAH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UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAyMS0wOC0xMFQwOToyNDo1MCswODowMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAyMS0wOC0xMFQwOToyNDo1MCswODowMCIgeG1wOk1vZGlmeURhdGU9IjIwMjEtMDgtMTBUMDk6MjQ6NTArMDg6MDAiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NTQyNEZDQzE3OUY5RUIxMUFGOENBMEMyQjc0ODU5QTkiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NTMyNEZDQzE3OUY5RUIxMUFGOENBMEMyQjc0ODU5QTkiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo1MzI0RkNDMTc5RjlFQjExQUY4Q0EwQzJCNzQ4NTlBOSIgZGM6Zm9ybWF0PSJpbWFnZS9qcGVnIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIj4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY3JlYXRlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo1MzI0RkNDMTc5RjlFQjExQUY4Q0EwQzJCNzQ4NTlBOSIgc3RFdnQ6d2hlbj0iMjAyMS0wOC0xMFQwOToyNDo1MCswODowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjU0MjRGQ0MxNzlGOUVCMTFBRjhDQTBDMkI3NDg1OUE5IiBzdEV2dDp3aGVuPSIyMDIxLTA4LTEwVDA5OjI0OjUwKzA4OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPD94cGFja2V0IGVuZD0idyI/Pv/uAA5BZG9iZQBkQAAAAAH/2wCEAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQECAgICAgICAgICAgMDAwMDAwMDAwMBAQEBAQEBAQEBAQICAQICAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDA//AABEIAHkA1wMBEQACEQEDEQH/3QAEABv/xAGiAAAABgIDAQAAAAAAAAAAAAAHCAYFBAkDCgIBAAsBAAAGAwEBAQAAAAAAAAAAAAYFBAMHAggBCQAKCxAAAgEDBAEDAwIDAwMCBgl1AQIDBBEFEgYhBxMiAAgxFEEyIxUJUUIWYSQzF1JxgRhikSVDobHwJjRyChnB0TUn4VM2gvGSokRUc0VGN0djKFVWVxqywtLi8mSDdJOEZaOzw9PjKThm83UqOTpISUpYWVpnaGlqdnd4eXqFhoeIiYqUlZaXmJmapKWmp6ipqrS1tre4ubrExcbHyMnK1NXW19jZ2uTl5ufo6er09fb3+Pn6EQACAQMCBAQDBQQEBAYGBW0BAgMRBCESBTEGACITQVEHMmEUcQhCgSORFVKhYhYzCbEkwdFDcvAX4YI0JZJTGGNE8aKyJjUZVDZFZCcKc4OTRnTC0uLyVWV1VjeEhaOzw9Pj8ykalKS0xNTk9JWltcXV5fUoR1dmOHaGlqa2xtbm9md3h5ent8fX5/dIWGh4iJiouMjY6Pg5SVlpeYmZqbnJ2en5KjpKWmp6ipqqusra6vr/2gAMAwEAAhEDEQA/AN/j37r3Xvfuvde9+691737r3Xvfuvde9+691737r3XvfuvdcDIgbTqGr66fzb+tv6e/de6xipjOr9foYqbow5Fybcc/T37r3ST3rvja2wdtZbeO7s3j9vbbwVHJX5XLZWdaSkpaWFWeRnllZFaQjhE/UzGwBJt7917quD45fzR+lvkd3Znends4PcGLlNXWQbP3HPTyPR7qgoA71NUYoYNeI1pH5YlmtqiILlW9Hv3XurQqaojkZBGfIoRrym97qwX6EAkMfz+R7917qWZkAuSQLX5BFrkgXv8AQ8fT37r3WRSGAYcgi4Pv3Xuu/fuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3X/9Df49+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3TVUeCJjWujmRAyKE1FmNz6VUcEn/ePfuvdAz3p8gOs/j319luxu0Ny0OAw+Li1wUbzwtlstWuCtLisTjzItTX5CqkNljReACxsqkj3XutVvu/5HfJb+aV21H1515iclgepMPWzVtPt9amajwGFw0EhD7t7EyySCjeempyrgSHxwyERxh5CC/uvdM+9+7etviDteq6Y+J+Wo9w9m1sD4ztL5FRRRGvld0C1m3euZ1802IxYmDCWpikYSaUOokK6+691a3/Lo+XfbOC6Umz3y4zFDt7qujqKTEde9l7yr/wCH7j3JV1E0MSY+KOohNTuHHQoSf4gWJQxkMzrdk917q7TG5egzuLxuUxks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e6b+3viF8aO/M7j9zdy9M7G7Gz+Kxgw2Oyu6cNBk6ykxgnlqhRQyzAlIRPMzW/qffuvdBK38sz4Et9fit0//ALDalD/0b7917pY7P+BPwx2FWxZLanxl6YxWQgcSQVy7A25VVkEgIOuGprKConha4B9LDn37r3RpqPD4zHUsNFj6GmoaOnRY4KWjhjpqeGNBZY4oYVSNIwP7IFvfuvdIfs/p/rTujZ9ZsDtLZ+I3vszIVFHV1+3M9AazFVtRj6mOtonq6V28dQKashSVVcFRIita4Fvde6B/rD4QfE3pfd9Fv3qzobrrY+8sbTVtHQbiwO36SjylJTZGA01bFT1SqZIhUU5KMQQSrEfk3917o0ngj44PF+AzAc/kgEAn/X/p7917pEdgdXde9rbXyGyuyNn7f3ttTKoY8jgNy4yky2Mq1NiPLS1kUsZZSLq1tSkXBB9+690XrYnwB+G3WO78Hv7YHx5632lvHbVX99gdw4TBQ0OSxVWUMbTUdRCVaFnjbS1uGHBv7917pUdufDX4v987kpt39xdK7G7E3NR4uLCUua3RiIsnX0+JgqKqrhx8M892jpYqisldUFgC5/wt7r3QidRdHdTdCbYqNmdO7E2915taqy1TnajB7ZoYsfQTZisgpaWqyEkMYs1TNTUMMbMedESj6Ae/de6Fa3Fvx9Pfuvdf/9bf49+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvdf/Z';
                // var doc = new jsPDF();


                doc.setFontSize(6);

                // HEADER
                doc.text(5, 5, 'BANDAI WIREHARNESS PHILIPPINES INC');

                doc.text(10, 9.5, 'Employee ID:');
                doc.text(10, 12.1, 'Employee Name:');
                doc.text(10, 14.6, 'Position:');
                doc.text(10, 17.1, 'Department:');
                doc.text(10, 19.6, 'Section:');

                doc.text(65, 9.5, "" + employee_cmid + "");
                doc.text(65, 12.1, employee_name);
                doc.text(65, 14.6, position);
                doc.text(65, 17.1, empl_dept);
                doc.text(65, 19.6, empl_sect);

                doc.text(115, 5, 'Payroll Pay-out:');
                doc.text(115, 7.6, 'Payroll Cut-Off:');

                doc.text(115, 12, 'Salary Type:');
                doc.text(115, 14.6, 'Salary:');
                doc.text(115, 17.2, 'Working Days:');
                doc.text(115, 19.8, 'Absences:');

                doc.text(170, 5, payout);
                doc.text(170, 7.6, payroll_period);

                doc.text(170, 12, "" + db_salary_type + "");
                doc.text(170, 14.6, "" + salary_rate + "");
                doc.text(170, 17.2, "" + days_present + "");
                doc.text(170, 19.8, "" + ti_absent_mul + "");

                // SALARY TABLE
                //--- Table Design ----
                doc.setLineWidth(0.8);
                doc.rect(10, 24, 190, 73);
                doc.setLineWidth(0.5);
                doc.line(10, 30, 200, 30); // horizontal line
                doc.line(10, 90, 200, 90); // horizontal line
                doc.line(160, 45, 200, 45); // horizontal line
                doc.line(160, 50, 200, 50); // horizontal line
                doc.line(160, 85, 200, 85); // horizontal line
                doc.line(40, 24.5, 40, 30); // vertical
                doc.line(58, 24.5, 58, 30); // vertical
                doc.line(115, 24.5, 115, 30); // vertical
                doc.line(133, 24.5, 133, 30); // vertical

                doc.line(85, 24.5, 85, 97.5); // vertical
                doc.line(160, 24.5, 160, 97.5); // vertical
                //doc.line(10, 90, 190, 90) // horizontal line
                //doc.line(10, 95, 190, 95) // horizontal line

                doc.text(18, 28, 'DESCRIPTION');
                doc.text(43, 28, 'DAYS/HRS');
                doc.text(67, 28, 'AMOUNT');

                doc.text(93, 28, 'DESCRIPTION');
                doc.text(118, 28, 'DAYS/HRS');
                doc.text(142, 28, 'AMOUNT');

                doc.text(171, 28, 'LEAVE BALANCES');
                doc.text(171, 53.5, 'LOAN BALANCES');
                doc.setFontSize(6);
                doc.setFont(undefined, 'bold');
                doc.text(12, 34, 'EARNINGS');
                doc.setFont(undefined, 'normal');
                doc.text(14, 37, 'Basic Salary');
                doc.text(14, 39.5, 'Paid Leave');
                doc.text(14, 42, 'Daily Allowance');
                doc.text(14, 44.5, 'Total Allowance');
                doc.text(14, 47, 'Regular/Legal Holiday');
                doc.text(14, 49.5, 'Regular OT');
                doc.text(14, 52, 'Rest Day> 6 Hrs');
                doc.text(14, 54.5, 'Rest Day OT');
                doc.text(14, 57, 'Night Differential');
                doc.text(14, 59.5, 'OT Night Differential');
                doc.text(14, 62, 'Rest Day ND OT');
                doc.text(14, 64.5, 'Meal Allowance');
                // doc.text(14,67,'SIL 2020');
                doc.text(14, 67, SIL_label);
                if (ti_rest_sp_hol_mul != 0) {
                    doc.text(14, 69.5, 'Rest + Special Holiday');
                }
                doc.setFont(undefined, 'bold');
                doc.text(12, 75, 'ADJUSTMENTS');
                doc.setFont(undefined, 'normal');
                doc.text(14, 77.5, 'Meal Allowance');
                doc.text(14, 80, 'Govt. Conributions');
                doc.text(14, 82.5, 'Others');
                doc.text(14, 85, '13th Month Pay');
                doc.text(14, 87.5, 'Tax Refund');

                doc.text(56, 37, "" + ti_basic_sal_mul + "", {
                    align: 'right'
                }); //Basic Salary
                doc.text(56, 39.5, "" + ti_leave_mul + "", {
                    align: 'right'
                }); //Paid Leave
                if (ta_daily_allowance > 0) {
                    doc.text(56, 42, "" + ti_basic_sal_mul + "", {
                        align: 'right'
                    }); //Daily Allowance
                } else {
                    doc.text(56, 42, "-"); //Daily Allowance
                }
                doc.text(56, 47, "" + ti_legal_hol_mul + "", {
                    align: 'right'
                }); //Regular/Legal Holiday
                doc.text(56, 49.5, "" + ti_reg_ot_mul + "", {
                    align: 'right'
                }); //Regular OT
                doc.text(56, 52, "" + ti_rest_mul + "", {
                    align: 'right'
                }); //Rest Day> 6 Hrs
                doc.text(56, 54.5, "" + ti_rest_ot_mul + "", {
                    align: 'right'
                }); //Rest Day OT
                doc.text(56, 57, "" + ti_nd_mul + "", {
                    align: 'right'
                }); //Night Differential
                doc.text(56, 59.5, "" + ti_nd_ot_mul + "", {
                    align: 'right'
                }); //OT Night Differential
                doc.text(56, 62, "" + ti_rest_nd_ot_mul + "", {
                    align: 'right'
                }); //Rest Day ND OT
                doc.text(56, 64.5, "" + ti_de_minimis_mul + "", {
                    align: 'right'
                }); //Meal Allowance
                doc.text(56, 67, '-'); //SIL 2020
                if (ti_rest_sp_hol_mul != 0) {
                    doc.text(56, 69.5, "" + ti_rest_sp_hol_mul + "", {
                        align: 'right'
                    }); // Rest + Special Holiday
                }
                doc.text(80, 37, "" + ti_basic_sal_total + "", {
                    align: 'right'
                }); // Basic Salary
                doc.text(80, 39.5, "" + ti_leave_total + "", {
                    align: 'right'
                }); // Paid Leave
                doc.text(80, 42, "" + ta_daily_allowance + "", {
                    align: 'right'
                }); // Daily Allowance
                doc.text(80, 44.5, "" + ta_allowance + "", {
                    align: 'right'
                }); // Total Allowance
                doc.text(80, 47, "" + ti_legal_hol_total + "", {
                    align: 'right'
                }); // Regular/Legal Holiday
                doc.text(80, 49.5, "" + ti_reg_ot_total + "", {
                    align: 'right'
                }); // Regular OT
                doc.text(80, 52, "" + ti_rest_total + "", {
                    align: 'right'
                }); // Rest Day> 6 Hrs
                doc.text(80, 54.5, "" + ti_rest_ot_total + "", {
                    align: 'right'
                }); // Rest Day OT
                doc.text(80, 57, "" + ti_nd_total + "", {
                    align: 'right'
                }); // Night Differential
                doc.text(80, 59.5, "" + ti_nd_ot_total + "", {
                    align: 'right'
                }); // OT Night Differential
                doc.text(80, 62, "" + ti_rest_nd_ot_total + "", {
                    align: 'right'
                }); // Rest Day ND OT
                doc.text(80, 64.5, "" + ti_de_minimis_total + "", {
                    align: 'right'
                }); // Meal Allowance
                doc.text(80, 67, "" + ti_sil_2020 + "", {
                    align: 'right'
                }); // SIL 2020
                if (ti_rest_sp_hol_mul != 0) {
                    doc.text(80, 69.5, "" + ti_rest_sp_hol_total + "", {
                        align: 'right'
                    }); // Rest + Special Holiday
                }
                doc.text(80, 77.5, "" + ti_meal_earning + "", {
                    align: 'right'
                }); //Meal Allowance
                doc.text(80, 80, "" + ti_gov_cont_earning + "", {
                    align: 'right'
                }); //Govt. Conributions
                doc.text(80, 82.5, "" + ti_others_earning + "", {
                    align: 'right'
                }); //Others
                doc.text(80, 85, "-", {
                    align: 'right'
                }); //13th Month Pay
                doc.text(80, 87.5, "" + tax_refund_earning + "", {
                    align: 'right'
                }); //Tax Refund

                doc.setFont(undefined, 'bold');
                doc.text(87, 34, 'DEDUCTIONS');
                doc.setFont(undefined, 'normal');
                doc.text(89, 37, 'Withholding Tax');
                doc.text(89, 39.5, 'SSS EE Share');
                doc.text(89, 42, 'PHIC EE Share');
                doc.text(89, 44.5, 'HDMF EE Share');
                doc.text(89, 47, 'SSS Loan');
                doc.text(89, 49.5, 'HDMF Loan');
                doc.text(89, 52, 'Absences');
                doc.text(89, 54.5, 'Tardines');
                doc.text(89, 57, 'Undertime');
                doc.text(89, 59.5, 'Half day');
                doc.text(89, 62, 'Advances to Employees ');
                doc.text(89, 64.5, 'Uniform');
                doc.setFont(undefined, 'bold');
                doc.text(87, 70, 'ADJUSTMENTS');
                doc.setFont(undefined, 'normal');
                doc.text(89, 72.5, 'Meal Allowance');
                doc.text(89, 75, 'Govt. Conributions');
                doc.text(89, 77.5, 'Others');
                doc.text(89, 80, '13th Month Pay');
                doc.text(89, 82.5, 'Tax Refund');

                doc.text(131, 52, "" + ti_absent_mul + "", {
                    align: 'right'
                });
                doc.text(131, 54.5, "" + ti_tard_mul + "", {
                    align: 'right'
                });
                doc.text(131, 57, "" + ti_undertime_mul + "", {
                    align: 'right'
                });

                doc.text(155, 37, "" + wtax + "", {
                    align: 'right'
                });
                doc.text(155, 39.5, "" + gov_sss_ee + "", {
                    align: 'right'
                });
                doc.text(155, 42, "" + gov_philhealth_ee + "", {
                    align: 'right'
                });
                doc.text(155, 44.5, "" + gov_pagibig_ee + "", {
                    align: 'right'
                });
                doc.text(155, 47, "" + loan_amount_paid + "", {
                    align: 'right'
                });
                doc.text(155, 49.5, "" + pagibig_loan_amount_paid + "", {
                    align: 'right'
                });
                doc.text(155, 52, "" + ti_absent_total + "", {
                    align: 'right'
                });
                doc.text(155, 54.5, "" + ti_tard_total + "", {
                    align: 'right'
                });
                doc.text(155, 57, "" + ti_undertime_total + "", {
                    align: 'right'
                });
                doc.text(155, 59.5, "" + ti_half_total + "", {
                    align: 'right'
                });
                doc.text(155, 62, "" + salary_advance + "", {
                    align: 'right'
                });
                doc.text(155, 645, "" + uniform_deduction + "", {
                    align: 'right'
                });

                doc.text(155, 72.5, "" + ti_meal_deduction + "", {
                    align: 'right'
                });
                doc.text(155, 75, "" + ti_gov_cont_deduction + "", {
                    align: 'right'
                });
                doc.text(155, 77.5, "" + ti_others_deduction + "", {
                    align: 'right'
                });
                doc.text(155, 80, "-", {
                    align: 'right'
                });
                doc.text(155, 82.5, "" + tax_refund_deduction + "", {
                    align: 'right'
                });

                doc.text(174, 34, 'USED');
                doc.text(190, 34, 'BAL');
                doc.text(162, 37.5, 'VL');
                doc.text(162, 41, 'SL');
                doc.text(180, 37.5, "" + used_vacation_leave + "", {
                    align: 'right'
                });
                doc.text(180, 41, "" + used_sick_leave + "", {
                    align: 'right'
                });
                doc.text(196, 37.5, "" + vacation_leave_balance + "", {
                    align: 'right'
                });
                doc.text(196, 41, "" + sick_leave_balance + "", {
                    align: 'right'
                });

                doc.text(174, 58, 'USED');
                doc.text(190, 58, 'BAL');
                doc.text(162, 61.5, 'SSS');
                doc.text(162, 65, 'HDMF');
                doc.text(180, 61.5, "" + loan_amount_paid + "", {
                    align: 'right'
                });
                doc.text(180, 65, "" + pagibig_loan_amount_paid + "", {
                    align: 'right'
                });
                doc.text(196, 61.5, "-", {
                    align: 'center'
                });
                doc.text(196, 65, "-", {
                    align: 'center'
                });

                doc.setFont(undefined, 'bold');
                doc.text(12, 94.5, 'TOTAL EARNINGS');
                doc.setFont(undefined, 'normal');
                doc.text(80, 94.5, "" + total_earnings + "", {
                    align: 'right'
                });

                doc.setFont(undefined, 'bold');
                doc.text(87, 94.5, 'TOTAL DEDUCTIONS');
                doc.setFont(undefined, 'normal');
                doc.text(155, 94.5, "" + total_deductions + "", {
                    align: 'right'
                });

                doc.text(175, 88.5, 'NET PAY');
                doc.setFont(undefined, 'bold');
                doc.text(180, 94.5, "" + net_pay + "", {
                    align: 'center'
                });
                doc.setFont(undefined, 'normal');

                doc.text(15, 103, 'Received By:');
                doc.line(35, 103, 85, 103) // horizontal line
                doc.text(100, 103.5, 'Date:');
                doc.line(110, 103.5, 160, 103.5);

                doc.setLineWidth(0.5);
                doc.line(0, 106.5, 300, 106.5);





                // ===================================================== PAYSLIP 2 =====================================

                doc.text(5, 111, 'BANDAI WIREHARNESS PHILIPPINES INC');

                doc.text(10, 115.5, 'Employee ID:');
                doc.text(10, 118.1, 'Employee Name:');
                doc.text(10, 120.6, 'Position:');
                doc.text(10, 123.1, 'Department:');
                doc.text(10, 125.6, 'Section:');

                doc.text(65, 115.5, "" + employee_cmid1 + "");
                doc.text(65, 118.1, employee_name1);
                doc.text(65, 120.6, position1);
                doc.text(65, 123.1, empl_dept1);
                doc.text(65, 125.6, empl_sect1);

                doc.text(115, 111, 'Payroll Pay-out:');
                doc.text(115, 113.6, 'Payroll Cut-Off:');

                doc.text(115, 118, 'Salary Type:');
                doc.text(115, 120.6, 'Salary:');
                doc.text(115, 123.2, 'Working Days:');
                doc.text(115, 125.8, 'Absences:');

                doc.text(170, 111, payout1);
                doc.text(170, 113.6, payroll_period1);

                doc.text(170, 118, "" + db_salary_type1 + "");
                doc.text(170, 120.6, "" + salary_rate1 + "");
                doc.text(170, 123.2, "" + days_present1 + "");
                doc.text(170, 125.8, "" + ti_absent_mul1 + "");

                // ------------------------------------------

                // SALARY TABLE
                //--- Table Design ----
                doc.setLineWidth(0.8)
                doc.rect(10, 130, 190, 73);
                doc.setLineWidth(0.5)
                doc.line(10, 136, 200, 136) // horizontal line
                doc.line(10, 196, 200, 196) // horizontal line
                doc.line(160, 151, 200, 151) // horizontal line
                doc.line(160, 156, 200, 156) // horizontal line
                doc.line(160, 191, 200, 191) // horizontal line
                doc.line(40, 130.5, 40, 136) // vertical
                doc.line(58, 130.5, 58, 136) // vertical
                doc.line(115, 130.5, 115, 136) // vertical
                doc.line(133, 130.5, 133, 136) // vertical

                doc.line(85, 130.5, 85, 203.5) // vertical
                doc.line(160, 130.5, 160, 203.5) // vertical
                //doc.line(10, 90, 190, 90) // horizontal line
                //doc.line(10, 95, 190, 95) // horizontal line

                doc.text(18, 134, 'DESCRIPTION');
                doc.text(43, 134, 'DAYS/HRS');
                doc.text(67, 134, 'AMOUNT');

                doc.text(93, 134, 'DESCRIPTION');
                doc.text(118, 134, 'DAYS/HRS');
                doc.text(142, 134, 'AMOUNT');

                doc.text(171, 134, 'LEAVE BALANCES');
                doc.text(171, 159.5, 'LOAN BALANCES');
                doc.setFontSize(6);
                doc.setFont(undefined, 'bold');
                doc.text(12, 140, 'EARNINGS');
                doc.setFont(undefined, 'normal');
                doc.text(14, 143, 'Basic Salary');
                doc.text(14, 145.5, 'Paid Leave');
                doc.text(14, 148, 'Daily Allowance');
                doc.text(14, 150.5, 'Total Allowance');
                doc.text(14, 153, 'Regular/Legal Holiday');
                doc.text(14, 155.5, 'Regular OT');
                doc.text(14, 158, 'Rest Day> 6 Hrs');
                doc.text(14, 160.5, 'Rest Day OT');
                doc.text(14, 163, 'Night Differential');
                doc.text(14, 165.5, 'OT Night Differential');
                doc.text(14, 168, 'Rest Day ND OT');
                doc.text(14, 170.5, 'Meal Allowance');
                // doc.text(14,173,'SIL 2020');
                doc.text(14, 173, SIL_label);
                if (ti_rest_sp_hol_mul1 != 0) {
                    doc.text(14, 175.5, 'Rest + Special Holiday');
                }

                doc.setFont(undefined, 'bold');
                doc.text(12, 181, 'ADJUSTMENTS');
                doc.setFont(undefined, 'normal');
                doc.text(14, 183.5, 'Meal Allowance');
                doc.text(14, 186, 'Govt. Conributions');
                doc.text(14, 188.5, 'Others');
                doc.text(14, 191, '13th Month Pay');
                doc.text(14, 193.5, 'Tax Refund');

                doc.text(56, 143, "" + ti_basic_sal_mul1 + "", {
                    align: 'right'
                }); //Basic Salary
                doc.text(56, 145.5, "" + ti_leave_mul1 + "", {
                    align: 'right'
                }); //Paid Leave
                if (ta_daily_allowance > 0) {
                    doc.text(56, 148, "" + ti_basic_sal_mul + "", {
                        align: 'right'
                    }); //Daily Allowance
                } else {
                    doc.text(56, 148, "-", {
                        align: 'right'
                    }); //Daily Allowance
                }
                doc.text(56, 153, "" + ti_legal_hol_mul1 + "", {
                    align: 'right'
                }); //Regular/Legal Holiday
                doc.text(56, 155.5, "" + ti_reg_ot_mul1 + "", {
                    align: 'right'
                }); //Regular OT
                doc.text(56, 158, "" + ti_rest_mul1 + "", {
                    align: 'right'
                }); //Rest Day> 6 Hrs
                doc.text(56, 160.5, "" + ti_rest_ot_mul1 + "", {
                    align: 'right'
                }); //Rest Day OT
                doc.text(56, 163, "" + ti_nd_mul1 + "", {
                    align: 'right'
                }); //Night Differential
                doc.text(56, 165.5, "" + ti_nd_ot_mul1 + "", {
                    align: 'right'
                }); //OT Night Differential
                doc.text(56, 168, "" + ti_rest_nd_ot_mul1 + "", {
                    align: 'right'
                }); //Rest Day ND OT
                doc.text(56, 170.5, "" + ti_de_minimis_mul1 + "", {
                    align: 'right'
                }); //Meal Allowance
                doc.text(56, 173, '-', {
                    align: 'right'
                }); //SIL 2020
                if (ti_rest_sp_hol_mul1 != 0) {
                    doc.text(56, 175.5, "" + ti_rest_sp_hol_mul1 + "", {
                        align: 'right'
                    }); // Rest + Special Holiday
                }


                doc.text(80, 143, "" + ti_basic_sal_total1 + "", {
                    align: 'right'
                }); // Basic Salary
                doc.text(80, 145.5, "" + ti_leave_total1 + "", {
                    align: 'right'
                }); // Paid Leave
                doc.text(80, 148, "" + ta_daily_allowance1 + "", {
                    align: 'right'
                }); // Daily Allowance
                doc.text(80, 150.5, "" + ta_allowance1 + "", {
                    align: 'right'
                }); // Total Allowance
                doc.text(80, 153, "" + ti_legal_hol_total1 + "", {
                    align: 'right'
                }); // Regular/Legal Holiday
                doc.text(80, 155.5, "" + ti_reg_ot_total1 + "", {
                    align: 'right'
                }); // Regular OT
                doc.text(80, 158, "" + ti_rest_total1 + "", {
                    align: 'right'
                }); // Rest Day> 6 Hrs
                doc.text(80, 160.5, "" + ti_rest_ot_total1 + "", {
                    align: 'right'
                }); // Rest Day OT
                doc.text(80, 163, "" + ti_nd_total1 + "", {
                    align: 'right'
                }); // Night Differential
                doc.text(80, 165.5, "" + ti_nd_ot_total1 + "", {
                    align: 'right'
                }); // OT Night Differential
                doc.text(80, 168, "" + ti_rest_nd_ot_total1 + "", {
                    align: 'right'
                }); // Rest Day ND OT
                doc.text(80, 170.5, "" + ti_de_minimis_total1 + "", {
                    align: 'right'
                }); // Meal Allowance
                doc.text(80, 173, "" + ti_sil_20201 + "", {
                    align: 'right'
                }); // SIL 2020
                if (ti_rest_sp_hol_mul1 != 0) {
                    doc.text(80, 175.5, "0", {
                        align: 'right'
                    }); // Rest + Special Holiday
                }
                doc.text(80, 183.5, "" + ti_meal_earning1 + "", {
                    align: 'right'
                }); //Meal Allowance
                doc.text(80, 186, "" + ti_gov_cont_earning1 + "", {
                    align: 'right'
                }); //Govt. Conributions
                doc.text(80, 188.5, "" + ti_others_earning1 + "", {
                    align: 'right'
                }); //Others
                doc.text(80, 191, "" + '-' + "", {
                    align: 'right'
                }); //13th Month Pay
                doc.text(80, 193.5, "" + tax_refund_earning1 + "", {
                    align: 'right'
                }); //Tax Refund

                doc.setFont(undefined, 'bold');
                doc.text(87, 140, 'DEDUCTIONS');
                doc.setFont(undefined, 'normal');
                doc.text(89, 143, 'Withholding Tax');
                doc.text(89, 145.5, 'SSS EE Share');
                doc.text(89, 148, 'PHIC EE Share');
                doc.text(89, 150.5, 'HDMF EE Share');
                doc.text(89, 153, 'SSS Loan');
                doc.text(89, 155.5, 'HDMF Loan');
                doc.text(89, 158, 'Absences');
                doc.text(89, 160.5, 'Tardines');
                doc.text(89, 163, 'Undertime');
                doc.text(89, 165.5, 'Half day');
                doc.text(89, 168, 'Advances to Employees ');
                doc.text(89, 170.5, 'Uniform');
                doc.setFont(undefined, 'bold');
                doc.text(87, 176, 'ADJUSTMENTS');
                doc.setFont(undefined, 'normal');
                doc.text(89, 178.5, 'Meal Allowance');
                doc.text(89, 181, 'Govt. Conributions');
                doc.text(89, 183.5, 'Others');
                doc.text(89, 186, '13th Month Pay');
                doc.text(89, 188.5, 'Tax Refund');

                doc.text(131, 158, "" + ti_absent_mul1 + "", {
                    align: 'right'
                });
                doc.text(131, 160.5, "" + ti_tard_mul1 + "", {
                    align: 'right'
                });
                doc.text(131, 163, "" + ti_undertime_mul1 + "", {
                    align: 'right'
                });

                doc.text(155, 143, "" + wtax1 + "", {
                    align: 'right'
                });
                doc.text(155, 145.5, "" + gov_sss_ee1 + "", {
                    align: 'right'
                });
                doc.text(155, 148, "" + gov_philhealth_ee1 + "", {
                    align: 'right'
                });
                doc.text(155, 150.5, "" + gov_pagibig_ee1 + "", {
                    align: 'right'
                });
                doc.text(155, 153, "" + loan_amount_paid1 + "", {
                    align: 'right'
                });
                doc.text(155, 155.5, "" + pagibig_loan_amount_paid1 + "", {
                    align: 'right'
                });
                doc.text(155, 158, "" + ti_absent_total1 + "", {
                    align: 'right'
                });
                doc.text(155, 160.5, "" + ti_tard_total1 + "", {
                    align: 'right'
                });
                doc.text(155, 163, "" + ti_undertime_total1 + "", {
                    align: 'right'
                });
                doc.text(155, 165.5, "" + ti_half_total1 + "", {
                    align: 'right'
                });
                doc.text(155, 168, "" + salary_advance1 + "", {
                    align: 'right'
                });
                doc.text(155, 170.5, "" + uniform_deduction1 + "", {
                    align: 'right'
                });

                doc.text(155, 178.5, "" + ti_meal_deduction1 + "", {
                    align: 'right'
                });
                doc.text(155, 181, "" + ti_gov_cont_deduction1 + "", {
                    align: 'right'
                });
                doc.text(155, 183.5, "" + ti_others_deduction1 + "", {
                    align: 'right'
                });
                doc.text(155, 186, "-", {
                    align: 'right'
                });
                doc.text(155, 188.5, "" + tax_refund_deduction1 + "", {
                    align: 'right'
                });

                doc.text(174, 140, 'USED');
                doc.text(190, 140, 'BAL');
                doc.text(162, 143.5, 'VL');
                doc.text(162, 147, 'SL');
                doc.text(180, 143.5, "" + used_vacation_leave1 + "", {
                    align: 'right'
                });
                doc.text(180, 147, "" + used_sick_leave1 + "", {
                    align: 'right'
                });
                doc.text(196, 143.5, "" + vacation_leave_balance1 + "", {
                    align: 'right'
                });
                doc.text(196, 150, "" + sick_leave_balance1 + "", {
                    align: 'right'
                });

                doc.text(174, 164, 'USED');
                doc.text(190, 164, 'BAL');
                doc.text(162, 167.5, 'SSS');
                doc.text(162, 171, 'HDMF');
                doc.text(180, 167.5, "" + loan_amount_paid1 + "", {
                    align: 'right'
                });
                doc.text(180, 171, "" + pagibig_loan_amount_paid1 + "", {
                    align: 'right'
                });
                doc.text(196, 167.5, "-", {
                    align: 'center'
                });
                doc.text(196, 171, "-", {
                    align: 'center'
                });

                doc.setFont(undefined, 'bold');
                doc.text(12, 200.5, 'TOTAL EARNINGS');
                doc.setFont(undefined, 'normal');
                doc.text(80, 200.5, "" + total_earnings1 + "", {
                    align: 'right'
                });

                doc.setFont(undefined, 'bold');
                doc.text(87, 200.5, 'TOTAL DEDUCTIONS');
                doc.setFont(undefined, 'normal');
                doc.text(155, 200.5, "" + total_deductions1 + "", {
                    align: 'right'
                });

                doc.text(175, 194.5, 'NET PAY');
                doc.setFont(undefined, 'bold');
                doc.text(180, 200.5, "" + net_pay1 + "", {
                    align: 'right'
                });
                doc.setFont(undefined, 'normal');

                doc.text(15, 209, 'Received By:');
                doc.line(35, 209, 85, 209) // horizontal line
                doc.text(100, 209.5, 'Date:');
                doc.line(110, 209.5, 160, 209.5);

                doc.setLineWidth(0.5);
                doc.line(0, 213, 300, 213);



                // ============================ PAYSLIP 3 ====================================




                doc.text(5, 218, 'BANDAI WIREHARNESS PHILIPPINES INC');

                doc.text(10, 221.5, 'Employee ID:');
                doc.text(10, 224.1, 'Employee Name:');
                doc.text(10, 226.6, 'Position:');
                doc.text(10, 229.1, 'Department:');
                doc.text(10, 231.6, 'Section:');

                doc.text(65, 221.5, "" + employee_cmid2 + "");
                doc.text(65, 224.1, employee_name2);
                doc.text(65, 226.6, position2);
                doc.text(65, 229.1, empl_dept2);
                doc.text(65, 231.6, empl_sect2);

                doc.text(115, 217, 'Payroll Pay-out:');
                doc.text(115, 219.6, 'Payroll Cut-Off:');

                doc.text(115, 224, 'Salary Type:');
                doc.text(115, 226.6, 'Salary:');
                doc.text(115, 229.2, 'Working Days:');
                doc.text(115, 231.8, 'Absences:');

                doc.text(170, 217, payout2);
                doc.text(170, 219.6, payroll_period2);

                doc.text(170, 224, "" + db_salary_type2 + "");
                doc.text(170, 226.6, "" + salary_rate2 + "");
                doc.text(170, 229.2, "" + days_present2 + "");
                doc.text(170, 231.8, "" + ti_absent_mul2 + "");

                // ------------------------------------------

                // SALARY TABLE
                //--- Table Design ----
                doc.setLineWidth(0.8)
                doc.rect(10, 236, 190, 73);
                doc.setLineWidth(0.5)
                doc.line(10, 242, 200, 242) // horizontal line
                doc.line(10, 302, 200, 302) // horizontal line
                doc.line(160, 257, 200, 257) // horizontal line
                doc.line(160, 262, 200, 262) // horizontal line
                doc.line(160, 297, 200, 297) // horizontal line
                doc.line(40, 236.5, 40, 241) // vertical
                doc.line(58, 236.5, 58, 241) // vertical
                doc.line(115, 236.5, 115, 241) // vertical
                doc.line(133, 236.5, 133, 241) // vertical

                doc.line(85, 236.5, 85, 308.5) // vertical
                doc.line(160, 236.5, 160, 308.5) // vertical
                //doc.line(10, 90, 190, 90) // horizontal line
                //doc.line(10, 95, 190, 95) // horizontal line

                doc.text(18, 240, 'DESCRIPTION');
                doc.text(43, 240, 'DAYS/HRS');
                doc.text(67, 240, 'AMOUNT');

                doc.text(93, 240, 'DESCRIPTION');
                doc.text(118, 240, 'DAYS/HRS');
                doc.text(142, 240, 'AMOUNT');

                doc.text(171, 240, 'LEAVE BALANCES');
                doc.text(171, 265.5, 'LOAN BALANCES');
                doc.setFontSize(6);
                doc.setFont(undefined, 'bold');
                doc.text(12, 246, 'EARNINGS');
                doc.setFont(undefined, 'normal');
                doc.text(14, 249, 'Basic Salary');
                doc.text(14, 251.5, 'Paid Leave');
                doc.text(14, 254, 'Daily Allowance');
                doc.text(14, 256.5, 'Total Allowance');
                doc.text(14, 259, 'Regular/Legal Holiday');
                doc.text(14, 261.5, 'Regular OT');
                doc.text(14, 264, 'Rest Day> 6 Hrs');
                doc.text(14, 266.5, 'Rest Day OT');
                doc.text(14, 269, 'Night Differential');
                doc.text(14, 271.5, 'OT Night Differential');
                doc.text(14, 274, 'Rest Day ND OT');
                doc.text(14, 276.5, 'Meal Allowance');
                // doc.text(14,279,'SIL 2020');
                doc.text(14, 279, SIL_label);
                if (ti_rest_sp_hol_mul2 != 0) {
                    doc.text(14, 281.5, 'Rest + Special Holiday');
                }
                doc.setFont(undefined, 'bold');
                doc.text(12, 287, 'ADJUSTMENTS');
                doc.setFont(undefined, 'normal');
                doc.text(14, 289.5, 'Meal Allowance');
                doc.text(14, 292, 'Govt. Conributions');
                doc.text(14, 294.5, 'Others');
                doc.text(14, 297, '13th Month Pay');
                doc.text(14, 299.5, 'Tax Refund');

                doc.text(56, 249, "" + ti_basic_sal_mul2 + "", {
                    align: 'right'
                }); //Basic Salary
                doc.text(56, 251.5, "" + ti_leave_mul2 + "", {
                    align: 'right'
                }); //Paid Leave
                if (ta_daily_allowance2 > 0) {
                    doc.text(56, 254, "" + ti_basic_sal_mul2 + "", {
                        align: 'right'
                    }); //Daily Allowance
                } else {
                    doc.text(56, 254, "-", {
                        align: 'right'
                    }); //Daily Allowance
                }
                doc.text(56, 259, "" + ti_legal_hol_mul2 + "", {
                    align: 'right'
                }); //Regular/Legal Holiday
                doc.text(56, 261.5, "" + ti_reg_ot_mul2 + "", {
                    align: 'right'
                }); //Regular OT
                doc.text(56, 264, "" + ti_rest_mul2 + "", {
                    align: 'right'
                }); //Rest Day> 6 Hrs
                doc.text(56, 266.5, "" + ti_rest_ot_mul2 + "", {
                    align: 'right'
                }); //Rest Day OT
                doc.text(56, 269, "" + ti_nd_mul2 + "", {
                    align: 'right'
                }); //Night Differential
                doc.text(56, 271.5, "" + ti_nd_ot_mul2 + "", {
                    align: 'right'
                }); //OT Night Differential
                doc.text(56, 274, "" + ti_rest_nd_ot_mul2 + "", {
                    align: 'right'
                }); //Rest Day ND OT
                doc.text(56, 276.5, "" + ti_de_minimis_mul2 + "", {
                    align: 'right'
                }); //Meal Allowance
                doc.text(56, 279, "-"); //SIL 2020
                if (ti_rest_sp_hol_mul2 != 0) {
                    doc.text(56, 281.5, "" + ti_rest_sp_hol_mul2 + "", {
                        align: 'right'
                    }); // Rest + Special Holiday
                }
                doc.text(80, 249, "" + ti_basic_sal_total2 + "", {
                    align: 'right'
                }); // Basic Salary
                doc.text(80, 251.5, "" + ti_leave_total2 + "", {
                    align: 'right'
                }); // Paid Leave
                doc.text(80, 254, "" + ta_daily_allowance2 + "", {
                    align: 'right'
                }); // Daily Allowance
                doc.text(80, 256.5, "" + ta_allowance2 + "", {
                    align: 'right'
                }); // Total Allowance
                doc.text(80, 259, "" + ti_legal_hol_total2 + "", {
                    align: 'right'
                }); // Regular/Legal Holiday
                doc.text(80, 261.5, "" + ti_reg_ot_total2 + "", {
                    align: 'right'
                }); // Regular OT
                doc.text(80, 264, "" + ti_rest_total2 + "", {
                    align: 'right'
                }); // Rest Day> 6 Hrs
                doc.text(80, 266.5, "" + ti_rest_ot_total2 + "", {
                    align: 'right'
                }); // Rest Day OT
                doc.text(80, 269, "" + ti_nd_total2 + "", {
                    align: 'right'
                }); // Night Differential
                doc.text(80, 271.5, "" + ti_nd_ot_total2 + "", {
                    align: 'right'
                }); // OT Night Differential
                doc.text(80, 274, "" + ti_rest_nd_ot_total2 + "", {
                    align: 'right'
                }); // Rest Day ND OT
                doc.text(80, 276.5, "" + ti_de_minimis_total2 + "", {
                    align: 'right'
                }); // Meal Allowance
                doc.text(80, 279, "" + ti_sil_20202 + "", {
                    align: 'right'
                }); // SIL 2020
                if (ti_rest_sp_hol_mul2 != 0) {
                    doc.text(80, 281.5, "" + ti_rest_sp_hol_total2 + "", {
                        align: 'right'
                    }); // Rest + Special Holiday
                }


                doc.text(80, 289.5, "" + ti_meal_earning2 + "", {
                    align: 'right'
                }); //Meal Allowance
                doc.text(80, 292, "" + ti_gov_cont_earning2 + "", {
                    align: 'right'
                }); //Govt. Conributions
                doc.text(80, 294.5, "" + ti_others_earning2 + "", {
                    align: 'right'
                }); //Others
                doc.text(80, 297, "-"); //13th Month Pay
                doc.text(80, 299.5, "" + tax_refund_earning2 + "", {
                    align: 'right'
                }); //Tax Refund

                doc.setFont(undefined, 'bold');
                doc.text(87, 246, 'DEDUCTIONS');
                doc.setFont(undefined, 'normal');
                doc.text(89, 249, 'Withholding Tax');
                doc.text(89, 251.5, 'SSS EE Share');
                doc.text(89, 254, 'PHIC EE Share');
                doc.text(89, 256.5, 'HDMF EE Share');
                doc.text(89, 259, 'SSS Loan');
                doc.text(89, 261.5, 'HDMF Loan');
                doc.text(89, 264, 'Absences');
                doc.text(89, 266.5, 'Tardines');
                doc.text(89, 269, 'Undertime');
                doc.text(89, 271.5, 'Half day');
                doc.text(89, 274, 'Advances to Employees ');
                doc.text(89, 276.5, 'Uniform');
                doc.setFont(undefined, 'bold');
                doc.text(87, 282, 'ADJUSTMENTS');
                doc.setFont(undefined, 'normal');
                doc.text(89, 284.5, 'Meal Allowance');
                doc.text(89, 287, 'Govt. Conributions');
                doc.text(89, 289.5, 'Others');
                doc.text(89, 292, '13th Month Pay');
                doc.text(89, 294.5, 'Tax Refund');

                doc.text(131, 264, "" + ti_absent_mul2 + "", {
                    align: 'right'
                });
                doc.text(131, 266.5, "" + ti_tard_mul2 + "", {
                    align: 'right'
                });
                doc.text(131, 269, "" + ti_undertime_mul2 + "", {
                    align: 'right'
                });

                doc.text(155, 249, "" + wtax2 + "", {
                    align: 'right'
                });
                doc.text(155, 251.5, "" + gov_sss_ee2 + "", {
                    align: 'right'
                });
                doc.text(155, 254, "" + gov_philhealth_ee2 + "", {
                    align: 'right'
                });
                doc.text(155, 256.5, "" + gov_pagibig_ee2 + "", {
                    align: 'right'
                });
                doc.text(155, 259, "" + loan_amount_paid2 + "", {
                    align: 'right'
                });
                doc.text(155, 261.5, "" + pagibig_loan_amount_paid2 + "", {
                    align: 'right'
                });
                doc.text(155, 264, "" + ti_absent_total2 + "", {
                    align: 'right'
                });
                doc.text(155, 266.5, "" + ti_tard_total2 + "", {
                    align: 'right'
                });
                doc.text(155, 269, "" + ti_undertime_total2 + "", {
                    align: 'right'
                });
                doc.text(155, 271.5, "" + ti_half_total2 + "", {
                    align: 'right'
                });
                doc.text(155, 274, "" + salary_advance2 + "", {
                    align: 'right'
                });
                doc.text(155, 276.5, "" + uniform_deduction2 + "", {
                    align: 'right'
                });

                doc.text(155, 284.5, "" + ti_meal_deduction2 + "", {
                    align: 'right'
                });
                doc.text(155, 287, "" + ti_gov_cont_deduction2 + "", {
                    align: 'right'
                });
                doc.text(155, 289.5, "" + ti_others_deduction2 + "", {
                    align: 'right'
                });
                doc.text(155, 292, "-", {
                    align: 'right'
                });
                doc.text(155, 294.5, "" + tax_refund_deduction2 + "", {
                    align: 'right'
                });

                doc.text(174, 246, 'USED');
                doc.text(190, 246, 'BAL');
                doc.text(162, 249.5, 'VL');
                doc.text(162, 253, 'SL');
                doc.text(180, 249.5, "" + used_vacation_leave2 + "", {
                    align: 'right'
                });
                doc.text(180, 253, "" + used_sick_leave2 + "", {
                    align: 'right'
                });
                doc.text(196, 249.5, "" + vacation_leave_balance2 + "", {
                    align: 'right'
                });
                doc.text(196, 256, "" + sick_leave_balance2 + "", {
                    align: 'right'
                });

                doc.text(174, 270, 'USED');
                doc.text(190, 270, 'BAL');
                doc.text(162, 273.5, 'SSS');
                doc.text(162, 277, 'HDMF');
                doc.text(180, 273.5, "" + loan_amount_paid2 + "", {
                    align: 'right'
                });
                doc.text(180, 277, "" + pagibig_loan_amount_paid2 + "", {
                    align: 'right'
                });
                doc.text(196, 273.5, "-", {
                    align: 'center'
                });
                doc.text(196, 277, "-", {
                    align: 'center'
                });

                doc.setFont(undefined, 'bold');
                doc.text(12, 306.5, 'TOTAL EARNINGS');
                doc.setFont(undefined, 'normal');
                doc.text(80, 306.5, "" + total_earnings2 + "", {
                    align: 'right'
                });

                doc.setFont(undefined, 'bold');
                doc.text(87, 306.5, 'TOTAL DEDUCTIONS');
                doc.setFont(undefined, 'normal');
                doc.text(155, 306.5, "" + total_deductions2 + "", {
                    align: 'right'
                });

                doc.text(175, 300.5, 'NET PAY');
                doc.setFont(undefined, 'bold');
                doc.text(180, 306.5, "" + net_pay2 + "", {
                    align: 'center'
                });
                doc.setFont(undefined, 'normal');

                doc.text(15, 315, 'Received By:');
                doc.line(35, 315, 85, 315) // horizontal line
                doc.text(100, 315.5, 'Date:');
                doc.line(110, 315.5, 160, 315.5);

                doc.save(employee_name + " " + employee_name1 + " " + employee_name2 + " - Payslip.pdf");

                $('#btn_generate_payslip_by_3s').show();
                $('#generate_all_payslip_loading').hide();
                // })
            })

        })



        // BUTTON TOGGLE GENERATE PDF MODAL
        $('#generate_all_pdf').click(function(e) {
            e.preventDefault();

            $('#modal_select_empl_pdf').modal('toggle');

        })







        async function get_all_payroll_data_by_3s(url, payroll_id1, payroll_id2, payroll_id3) {
            var formData = new FormData();

            formData.append('payroll_id1', payroll_id1);
            formData.append('payroll_id2', payroll_id2);
            formData.append('payroll_id3', payroll_id3);

            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }


        async function get_payslip_data_based_on_period(url, cutoff_id) {
            var formData = new FormData();
            formData.append('cutoff_id', cutoff_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_empl_leave_data(url, empl_id) {
            var formData = new FormData();
            formData.append('empl_id', empl_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_payslip_data(url, payroll_id) {
            var formData = new FormData();
            formData.append('payroll_id', payroll_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function generated_payslip_count(url, payroll_id) {
            var formData = new FormData();
            formData.append('payroll_id', payroll_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function getEmployeeData(url, employee_id) {
            var formData = new FormData();
            formData.append('employee_id', employee_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }



        // ============================ display empl with payslips, ready for payslip, not ready for payslip =============================

        async function get_employees_ready_for_payslip(url, payroll_date, payroll_id) {
            var formData = new FormData();
            formData.append('payroll_date', payroll_date);
            formData.append('payroll_id', payroll_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_employee_not_ready_for_payslip(url, payroll_date, payroll_id) {
            var formData = new FormData();
            formData.append('payroll_date', payroll_date);
            formData.append('payroll_id', payroll_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_employee_all_ampl_data(url, employee_id) {
            var formData = new FormData();
            formData.append('employee_id', employee_id);
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