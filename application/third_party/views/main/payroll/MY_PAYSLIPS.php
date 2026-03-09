<style>
    #pages2{
        cursor: not-allowed;
    }
    ul.pagination li a{
        color: black;
        font-weight: lighter;
    }
    ul.pagination li.active a{
        color: white;
        font-weight: 600;
    }
    .card{
        padding: 20px;
    }
    li a{
        color: #0D74BC;
    }
    a:hover{
        text-decoration: none;
    }
    .activity td{
        padding: 6.8px 20px;
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
    li a{
        font-size: 14px;
    }
    .header-elements a{
        font-size: 14px;
    }
    .list-icons a{
        font-size: 11.2px;
        color: #197fc7;
    }
    .profile{
        padding: 20px 0px 0px;
    }
    .profile-img{
        display: inline-block;
        padding-right: 20px;
    }
    .profile-disc{
        margin-left: 100px;
    }
    .profile-name{
        font-weight: bold;
        font-size:16px;
        color: black;
    }
    .position{
        font-weight: bold;
        font-size: 15px;
        color: #B0B0B0;
    }
    .divider{
        margin-top: 50px;
    }
    .social-div a{
        padding: 10px 15px;
        color: #6a6a6a;
        font-size: 15px;
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
    /*table {*/
    /*border-collapse: collapse;*/
    /*border-spacing: 0;*/
    /*width: 100%;*/
   
    /*}*/
    /*th, td {*/
    /*text-align: left;*/
    /*padding: 8px;*/
    /*font-size: 14px;*/
    /*font-weight: normal;*/
    /*}*/
    .page-title{
    font-weight: 600;
    color: #424F5C;
    font-size: 33px;
  }
  th,td{
    font-size: 13px !important;
  }
    
</style>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Pagination -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">
<!-- Datatable -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">

<div class="content-wrapper">
	<div class="container-fluid p-4">
        <div class="row">
            <div class="col-md-6">
                <h1 class="page-title">My Payslips</h1>
            </div>
           
        </div>
        <hr>
 
        <div class = "card border-0 mt-2" style = "padding: 0px; margin: 0px">
            <table class="table table-hover" id="tbl_payslip">
                <thead>
                    <th>Employee Id</th>
                    <th>Full Name</th>
                    <th>Employment Type</th>
                    <th>Position</th>
                    <th>Cut-off Period</th>
                    <th>Amount</th>
                    <th>File</th>
                </thead>
                <tbody>
                    <?php 
                        if($DISP_PAYROLL_DATA){
                            foreach($DISP_PAYROLL_DATA as $DISP_PAYROLL_DATA_ROW){
                                $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_PAYROLL_DATA_ROW->empl_id);
                                $payroll_period = $this->p175_payschedule_mod->MOD_GET_PAY_SCHED_DATA($DISP_PAYROLL_DATA_ROW->payroll_period);

                                $db_payout = $payroll_period[0]->payout;
                                $payout = date('F d, Y', strtotime($db_payout));

                                

                                // GET LEAVE USED
                                $db_cutoff_period = $payroll_period[0]->db_name;
                                $split_date = explode(" - ",$db_cutoff_period);
                                $date1 = $split_date[0];
                                $date2 = $split_date[1];

                                $start_date = date("Y-m-d", strtotime($date1));
                                $end_date =  date("Y-m-d", strtotime($date2));

                                $leave_data = $this->p070_leave_mod->MOD_DISP_USED_LEAVE($DISP_PAYROLL_DATA_ROW->empl_id, $start_date, $end_date);
                                $used_vacation_leave = 0;
                                $used_sick_leave = 0;

                                if(count($leave_data)){
                                    foreach($leave_data as $leave_data_row){
                                        if($leave_data_row->col_leave_type == 'Vacation Leave'){
                                            $used_vacation_leave = $used_vacation_leave + $leave_data_row->col_leave_duration;
                                        }

                                        if($leave_data_row->col_leave_type == 'Sick Leave'){
                                            $used_sick_leave = $used_sick_leave + $leave_data_row->col_leave_duration;
                                        }
                                    }
                                }

                                // ================== GET SSS LOAN BALANCE =====================

                                // GET PAID LOANS (USED LOANS - IN PAYSLIP)
                                $loan_data = $this->p080_payroll_mod->MOD_DISP_PAID_LOAN_BASED_EMPL_AND_CUTOFF($payroll_period[0]->name, $employee[0]->col_empl_cmid);
                                $loan_amount_paid = 0;
                                if($loan_data){
                                    foreach($loan_data as $loan_data_row){
                                        if(($loan_data_row->loan_type == 'SSS Salary Loan') || ($loan_data_row->loan_type == 'SSS Calamity Loan')){
                                            // if($loan_data_row->status == 'Paid'){
                                                $loan_amount_paid = $loan_amount_paid + $loan_data_row->installment;
                                            // }
                                        }
                                    }
                                }

                                // GET SSS LOAN BALANCE 
                                $loan_balance_data = $this->p080_payroll_mod->MOD_DISP_LOAN_SSS_BALANCE($employee[0]->col_empl_cmid);
                                $loan_balance_amount = 0;
                                if($loan_balance_data){
                                    foreach($loan_balance_data as $loan_balance_data_row){
                                        $loan_balance_amount = $loan_balance_amount + $loan_balance_data_row->installment;
                                    }
                                }

                                // ================== GET HDMF LOAN BALANCE =====================

                                // GET PAID LOANS (USED LOANS - IN PAYSLIP)
                                $pagibig_loan_data = $this->p080_payroll_mod->MOD_DISP_PAID_LOAN_BASED_EMPL_AND_CUTOFF($payroll_period[0]->name, $employee[0]->col_empl_cmid);
                                $pagibig_loan_amount_paid = 0;
                                if($pagibig_loan_data){
                                    foreach($pagibig_loan_data as $pagibig_loan_data_row){
                                        if(($pagibig_loan_data_row->loan_type == 'Pag-ibig Salary Loan') || ($pagibig_loan_data_row->loan_type == 'Pag-ibig Calamity Loan')){
                                            // if($pagibig_loan_data_row->status == 'Paid'){
                                                $pagibig_loan_amount_paid = $pagibig_loan_amount_paid + $pagibig_loan_data_row->installment;
                                            // }
                                        }
                                    }
                                }

                                // GET PAGIBIG LOAN BALANCE 
                                $pagibig_loan_balance_data = $this->p080_payroll_mod->MOD_DISP_LOAN_PAGIBIG_BALANCE($employee[0]->col_empl_cmid);
                                $pagibig_loan_balance_amount = 0;
                                if($pagibig_loan_balance_data){
                                    foreach($pagibig_loan_balance_data as $pagibig_loan_balance_data_row){
                                        $pagibig_loan_balance_amount = $pagibig_loan_balance_amount + $pagibig_loan_balance_data_row->installment;
                                    }
                                }


                                $current_date = date('Y-m-d');

                                if($db_payout <= $current_date){
                                    if(!empty($employee[0]->col_midl_name)){
                                        $midl_ini = $employee[0]->col_midl_name[0].'.';
                                    }else{
                                        $midl_ini = '';
                                    }
                                    ?>
                                        <tr class="payslip_row">
                                            <td><?= $employee[0]->col_empl_cmid ?></td>
                                            <td><a href = "#">
                                                <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $employee[0]->col_last_name.', '.$employee[0]->col_frst_name.' '.$midl_ini?></a>
                                            </td>
                                            
                                            <td><?= $employee[0]->col_empl_type ?></td>
                                            <td><?= $employee[0]->col_empl_posi ?></td>
                                            <td payroll_period="<?= $payroll_period[0]->name ?>"><?= $payroll_period[0]->name ?></td>
                                            <td><?php echo number_format((float)$DISP_PAYROLL_DATA_ROW->net_pay, 2, '.', ''); ?></td>
                                            <td>
                                                <center>
                                                    <a class="download_pdf" href="#" pagibig_loan_balance_amount="<?= $pagibig_loan_amount_paid ?>" pagibig_loan_amount_paid="<?= $DISP_PAYROLL_DATA_ROW->loan_pagibig_salary + $DISP_PAYROLL_DATA_ROW->loan_pagibig_calamity ?>" sss_loan_balance_amount="<?= $loan_balance_amount ?>" sss_loan_amount_paid="<?= $DISP_PAYROLL_DATA_ROW->loan_sss_salary + $DISP_PAYROLL_DATA_ROW->loan_sss_calamity ?>" used_sick_leave="<?= $used_sick_leave ?>" used_vacation_leave="<?= $used_vacation_leave ?>" payout="<?= $payout ?>" payroll_period_name="<?= $payroll_period[0]->name ?>" db_payroll_period="<?= $payroll_period[0]->db_name ?>" payslip_id="<?= $DISP_PAYROLL_DATA_ROW->id ?>" empl_sect="<?= $employee[0]->col_empl_sect ?>" empl_dept="<?= $employee[0]->col_empl_dept ?>">
                                                        <img src="<?= base_url() ?>images/pdf_icon.png" class="pdf_img" alt="pdf icon" style="width: 30px;">&nbsp;&nbsp;<!-- <a href="<?= base_url() ?>reference_data/payroll.pdf" id="<?= $employee[0]->id.'pdf' ?>" download>sdf.pdf</a> -->
                                                        <div class="spinner-border text-danger loading_indicator" style="display:none;"></div>
                                                    </a>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php
                                }
                            
                            }
                        } else {
                        ?>
                            <tr class="table-active">
                                <td colspan="7"><center>No Payslips Yet</center></td>
                            </tr>
                        <?php
                        }
                    ?>
                </tbody>
            </table>
            <?php
                $page = ((isset($_GET['page'])) && ($_GET['page'] != ''))? $_GET['page'] : 1;
                $page_limit = 20;
                $row_count = $DISP_PAYROLL_DATA_COUNT;
                $ends_count = 1;
                $middle_count = 2;
                $total_pages = ceil($row_count / $page_limit);
                $dots = false;
                echo "<center><ul class='pagination mr-auto ml-auto'>";
                    // if ($page > 1)
                        $show = 0;
                        
                        if($page > 1)
                        {
                            echo "<li><a id='pages' href='".base_url()."payroll/my_payslips?page=".($page - 1)."' class='button'>&lt;</a></li>";
                        }

                        if($total_pages >= 1 && $page == 1)
                        {
                            ?><li disabled><a id='pages2' class='text-secondary button'>&lt;</a></li><?php
                        }
                        elseif($page == 3)
                        {
                            ?><li><a id="pages" href="<?php echo base_url();?>payroll/my_payslips?page=<?php echo 1; ?>"><?php echo 1; ?></a></li><?php
                        }
                        elseif($page == 4)
                        {
                            ?><li><a id='pages' href="<?php echo base_url();?>payroll/my_payslips?page=<?php echo 1; ?>"><?php echo 1; ?></a></li><?php
                            ?><li><a style="color: #23527c;">&hellip;</a></li><?php
                            ?><li><a id='pages' href="<?php echo base_url();?>payroll/my_payslips?page=<?php echo 2; ?>"><?php echo 2; ?></a></li><?php
                        }
                        elseif($page >= 5)
                        {
                            ?><li><a id='pages' href="<?php echo base_url();?>payroll/my_payslips?page=<?php echo 1; ?>"><?php echo 1; ?></a></li><?php
                            ?><li><a style="color: #23527c;">&hellip;</a></li><?php
                            ?><li><a id='pages' href="<?php echo base_url();?>payroll/my_payslips?page=<?php echo 3; ?>"><?php echo 3; ?></a></li><?php
                        }

                        for ($i = $page; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                if($page != 1)
                                {
                                    ?><li><a id='pages' href="<?php echo base_url();?>payroll/my_payslips?page=<?php echo $i-1; ?>"><?php echo $i-1; ?></a></li><?php
                                    ?><li class="active"><a href="#"><?php echo $i; ?></a></li><?php
                                }
                                else{
                                    ?><li class="active"><a href="#"><?php echo $i; ?></a></li><?php
                                }
                                $dots = true;
                            } else {
                                if ($i <= $ends_count || ($page && $i >= $page - $middle_count && $i <= $page + $middle_count) || $i > $total_pages - $ends_count) { 
                                    ?><li><a id='pages' href="<?php echo base_url();?>payroll/my_payslips?page=<?php echo $i; ?>"><?php echo $i; ?></a></li><?php
                                    $dots = true;
                                }elseif ($dots) {
                                    ?><li><a style="color: #23527c;">&hellip;</a></li><?php
                                    $dots = false;
                                }
                            }
                        }
                    
                    if($total_pages == 1 || $page == $total_pages)
                    {
                        ?><li disabled><a id='pages2' class='text-secondary button'>&gt;</a></li><?php
                    }
                    
                    if ($total_pages > $page)
                    {
                        echo "<li><a id='pages' href='".base_url()."payroll/my_payslips?page=".($page + 1)."' class='button'>&gt;</a></li>";
                    }
                    if($DISP_PAYROLL_DATA == null){
                        echo "<li><a id='pages2' class='text-secondary button'>&lt;</a></li>";
                        echo "<li class='active'><a href='#'>1</a></li>";
                        echo "<li><a id='pages2' class='text-secondary button'>&gt;</a></li>";
                    }
                echo "</ul></center>";
            ?>
        </div>
    </div>
</div>


	<aside class="control-sidebar control-sidebar-dark">
	</aside>

	<script>
        $(function () {
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
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Pagination -->
    <script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>
    <!-- Data table -->
    <script src="<?=base_url();?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url();?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

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
        $(document).ready(function(){
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


            



            // get empl leave url
            var url_get_leave = '<?= base_url() ?>leave/get_empl_leave_data';

            $('.download_pdf').click(function(){
                var download_btn = $(this);
                $(download_btn).find('.loading_indicator').show();
                $(download_btn).find('img').hide();

                var payslip_id = $(this).attr('payslip_id');
                var empl_sect = $(this).attr('empl_sect');
                var empl_dept = $(this).attr('empl_dept');
                // var payout = $(this).attr('payout');
                // var payroll_period = $(this).attr('payroll_period_name');
                var payroll_period = $(this).attr('payroll_period_name');
                var db_payroll_period = $(this).attr('db_payroll_period');
                var payout = $(this).attr('payout');

                // CHECK CUTOFF PERIOD
                var split_db_date_name = db_payroll_period.split('/');
                var initial_cutoff_year = split_db_date_name[4];

                var SIL_year = parseInt(initial_cutoff_year);
                var SIL_label = 'SIL ' + (initial_cutoff_year - 1);
                
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

                get_payslip_data(url4, payslip_id).then(function(data){
                    
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
                    
                    if(ti_meal > 0){ti_meal_earning = Math.abs(parseFloat(ti_meal));}
                    if(ti_gov_cont < 0){ti_gov_cont_earning = Math.abs(parseFloat(ti_gov_cont));}
                    if(ti_others > 0){ti_others_earning = Math.abs(parseFloat(ti_others));}
                    if(tax_refund > 0){tax_refund_earning = Math.abs(parseFloat(tax_refund));}
                    
                    if(ti_meal < 0){ti_meal_deduction = Math.abs(parseFloat(ti_meal));}
                    if(ti_gov_cont > 0){ti_gov_cont_deduction = Math.abs(parseFloat(ti_gov_cont));}
                    if(ti_others < 0){ti_others_deduction = Math.abs(parseFloat(ti_others));}
                    if(tax_refund < 0){tax_refund_deduction = Math.abs(parseFloat(tax_refund));}

                    if(net_pay == 0){net_pay = '-';}

                    // for modified db variables
                    if(sss_loan > 0){sss_loan,sss_loan = (parseFloat(loan_sss_salary) + parseFloat(loan_sss_calamity)).toFixed(2);}
                    if(pagibig_loan > 0){pagibig_loan,pagibig_loan = (parseFloat(loan_pagibig_salary) + parseFloat(loan_pagibig_calamity)).toFixed(2);}





                    // total_earnings =  parseFloat(ti_rest_sp_hol_total) + parseFloat(ti_basic_sal_total) + parseFloat(ti_leave_total) + parseFloat(ta_allowance) + parseFloat(ti_legal_hol_total) + parseFloat(ti_reg_ot_total) + parseFloat(ti_rest_total) + parseFloat(ti_nd_total) + parseFloat(ti_nd_ot_total) + parseFloat(ti_de_minimis_total) + parseFloat(ti_sil_2020) + parseFloat(ti_meal_earning) + parseFloat(ti_gov_cont_earning) + parseFloat(ti_others_earning) + parseFloat(tax_refund_earning);
                    total_earnings =  parseFloat(ti_rest_sp_hol_total) + parseFloat(ti_basic_sal_total) + parseFloat(ti_leave_total) + parseFloat(ta_daily_allowance) + parseFloat(ta_allowance) + parseFloat(ti_legal_hol_total) + parseFloat(ti_reg_ot_total) + parseFloat(ti_rest_total) + parseFloat(ti_nd_total) + parseFloat(ti_nd_ot_total) + parseFloat(ti_de_minimis_total) + parseFloat(ti_rest_ot_total) + parseFloat(ti_rest_nd_ot_total) + parseFloat(ti_sil_2020) + parseFloat(ti_meal_earning) + parseFloat(ti_gov_cont_earning) + parseFloat(ti_others_earning) + parseFloat(tax_refund_earning);
                    // total_earnings =  parseFloat(ti_rest_sp_hol_total) + parseFloat(ti_basic_sal_total) + parseFloat(ti_leave_total) + parseFloat(ta_daily_allowance) + parseFloat(ta_allowance) + parseFloat(ti_legal_hol_total) + parseFloat(ti_reg_ot_total) + parseFloat(ti_rest_total) + parseFloat(ti_nd_total) + parseFloat(ti_nd_ot_total) + parseFloat(ti_de_minimis_total) + parseFloat(ti_rest_ot_total) + parseFloat(ti_rest_nd_ot_total) + parseFloat(ti_meal_earning) + parseFloat(ti_gov_cont_earning) + parseFloat(ti_others_earning) + parseFloat(tax_refund_earning);
                    total_deductions = parseFloat(wtax) + parseFloat(gov_sss_ee) + parseFloat(gov_philhealth_ee) + parseFloat(gov_pagibig_ee) + parseFloat(loan_amount_paid) + parseFloat(pagibig_loan_amount_paid) + parseFloat(ti_absent_total) + parseFloat(ti_tard_total) + parseFloat(ti_undertime_total) + parseFloat(ti_no_ti_to_total) + parseFloat(ti_half_total) + parseFloat(salary_advance) + parseFloat(uniform_deduction) + parseFloat(ti_meal_deduction) + parseFloat(ti_gov_cont_deduction) + parseFloat(ti_others_deduction) + parseFloat(tax_refund_deduction);
                    
                    total_earnings = parseFloat(total_earnings).toFixed(2);
                    total_deductions = parseFloat(total_deductions).toFixed(2);

                    if (ti_meal_earning <= 0){ti_meal_earning = '-';}
                    if (ti_gov_cont_earning <= 0){ti_gov_cont_earning = '-';}
                    if (ti_others_earning <= 0){ti_others_earning = '-';}
                    if (tax_refund_earning <= 0){tax_refund_earning = '-';}
                    if (ti_meal_deduction <= 0){ti_meal_deduction = '-';}
                    if (ti_gov_cont_deduction <= 0){ti_gov_cont_deduction = '-';}
                    if (ti_others_deduction <= 0){ti_others_deduction = '-';}
                    if (tax_refund_deduction <= 0){tax_refund_deduction = '-';}

                    if (sss_loan<= 0){sss_loan = '-';}
                    if (pagibig_loan<= 0){pagibig_loan = '-';}

                    if (ti_basic_sal_mul<= 0){ti_basic_sal_mul = '-';}
                    if (ti_absent_mul<= 0){ti_absent_mul = '-';}
                    if (ti_no_ti_to_mul<= 0){ti_no_ti_to_mul = '-';}
                    if (ti_tard_mul<= 0){ti_tard_mul = '-';}
                    if (ti_half_mul<= 0){ti_half_mul = '-';}
                    if (ti_undertime_mul<= 0){ti_undertime_mul = '-';}
                    if (ti_rest_mul<= 0){ti_rest_mul = '-';}
                    if (ti_rest_sp_hol_mul<= 0){ti_rest_sp_hol_mul = '-';}
                    if (ti_legal_hol_mul<= 0){ti_legal_hol_mul = '-';}
                    if (ti_rest_legal_hol_mul<= 0){ti_rest_legal_hol_mul = '-';}
                    if (ti_reg_ot_mul<= 0){ti_reg_ot_mul = '-';}
                    if (ti_nd_ot_mul<= 0){ti_nd_ot_mul = '-';}
                    if (ti_nd_mul<= 0){ti_nd_mul = '-';}
                    if (ti_rest_ot_mul<= 0){ti_rest_ot_mul = '-';}
                    if (ti_rest_nd_ot_mul<= 0){ti_rest_nd_ot_mul = '-';}
                    if (ti_basic_sal_total<= 0){ti_basic_sal_total = '-';}
                    if (ti_absent_total<= 0){ti_absent_total = '-';}
                    if (ti_no_ti_to_total<= 0){ti_no_ti_to_total = '-';}
                    if (ti_tard_total<= 0){ti_tard_total = '-';}
                    if (ti_half_total<= 0){ti_half_total = '-';}
                    if (ti_undertime_total<= 0){ti_undertime_total = '-';}
                    if (ti_rest_total<= 0){ti_rest_total = '-';}
                    if (ti_rest_sp_hol_total<= 0){ti_rest_sp_hol_total = '-';}
                    if (ti_legal_hol_total<= 0){ti_legal_hol_total = '-';}
                    if (ti_rest_legal_hol_total<= 0){ti_rest_legal_hol_total = '-';}
                    if (ti_reg_ot_total<= 0){ti_reg_ot_total = '-';}
                    if (ti_nd_ot_total<= 0){ti_nd_ot_total = '-';}
                    if (ti_nd_total<= 0){ti_nd_total = '-';}
                    if (ti_leave_total<= 0){ti_leave_total = '-';}
                    if (ti_de_minimis_total<= 0){ti_de_minimis_total = '-';}
                    if (ti_rest_ot_total <= 0){ti_rest_ot_total = '-';}
                    if (ti_rest_nd_ot_total <= 0){ti_rest_nd_ot_total = '-';}

                    if (ti_sil_2020<= 0){ti_sil_2020 = '-';}
                    if (ti_meal<= 0){ti_meal = '-';}
                    if (ti_gov_cont<= 0){ti_gov_cont = '-';}
                    if (ti_others<= 0){ti_others = '-';}
                    if (ti_gross<= 0){ti_gross = '-';}
                    if (gov_sss_ee<= 0){gov_sss_ee = '-';}
                    if (gov_philhealth_ee<= 0){gov_philhealth_ee = '-';}
                    if (gov_pagibig_ee<= 0){gov_pagibig_ee = '-';}
                    if (gov_total_ee<= 0){gov_total_ee = '-';}
                    if (comp_cont_sss<= 0){comp_cont_sss = '-';}
                    if (comp_cont_sss_ec<= 0){comp_cont_sss_ec = '-';}
                    if (comp_cont_philhealth<= 0){comp_cont_philhealth = '-';}
                    if (comp_cont_pagibig<= 0){comp_cont_pagibig = '-';}
                    if (comp_cont_total<= 0){comp_cont_total = '-';}
                    if (ta_load<= 0){ta_load = '-';}
                    if (ta_transportation<= 0){ta_transportation = '-';}
                    if (ta_skill<= 0){ta_skill = '-';}
                    if (ta_pioneer<= 0){ta_pioneer = '-';}
                    if (ta_daily_allowance == 0){ta_daily_allowance = '-';}
                    if (ta_allowance<= 0){ta_allowance = '-';}
                    if (ta_total<= 0){ta_total = '-';}
                    if (wtax<= 0){wtax = '-';}
                    if (loan_sss_salary<= 0){loan_sss_salary = '-';}
                    if (loan_sss_calamity<= 0){loan_sss_calamity = '-';}
                    if (loan_pagibig_salary<= 0){loan_pagibig_salary = '-';}
                    if (loan_pagibig_calamity<= 0){loan_pagibig_calamity = '-';}
                    if (loan_emergency<= 0){loan_emergency = '-';}
                    if (loan_total<= 0){loan_total = '-';}
                    if (tax_refund<= 0){tax_refund = '-';}
                    if (salary_advance<= 0){salary_advance = '-';}
                    if (uniform_deduction<= 0){uniform_deduction = '-';}
                    if (ded_total<= 0){ded_total = '-';}
                    if (net_pay<= 0){net_pay = '-';}
                    if (ti_leave_mul<= 0){ti_leave_mul = '-';}

                    if (loan_amount_paid<= 0){loan_amount_paid = '-';}
                    if (pagibig_loan_amount_paid<= 0){pagibig_loan_amount_paid = '-';}

                    
                    
                    // // console.log(ti_leave_mul)


                    getEmployeeData(url3, employee_id).then(function(x){
                        var employee_cmid = x.employee_data[0].col_empl_cmid;
                        var vacation_leave_balance = x.employee_data[0].col_leave_vacation;
                        var sick_leave_balance = x.employee_data[0].col_leave_sick;

                        var doc = new jsPDF();

                        get_empl_leave_data(url_get_leave, employee_id).then(function(leave){
                            
                            Array.from(leave).forEach(function(employee_data){
                                


                                // You'll need to make your image into a Data URL
                                // Use http://dataurl.net/#dataurlmaker
                                // SETTINGS
                                var imgData = 'data:image/jpeg;base64,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AAAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAA4QklNBAAAAAAAAAIAAThCSU0EAgAAAAAABAAAAAA4QklNBDAAAAAAAAIBAThCSU0ELQAAAAAABgABAAAAAjhCSU0ECAAAAAAAEAAAAAEAAAJAAAACQAAAAAA4QklNBB4AAAAAAAQAAAAAOEJJTQQaAAAAAANJAAAABgAAAAAAAAAAAAAAeQAAANcAAAAKAFUAbgB0AGkAdABsAGUAZAAtADIAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAANcAAAB5AAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAEAAAAAEAAAAAAABudWxsAAAAAgAAAAZib3VuZHNPYmpjAAAAAQAAAAAAAFJjdDEAAAAEAAAAAFRvcCBsb25nAAAAAAAAAABMZWZ0bG9uZwAAAAAAAAAAQnRvbWxvbmcAAAB5AAAAAFJnaHRsb25nAAAA1wAAAAZzbGljZXNWbExzAAAAAU9iamMAAAABAAAAAAAFc2xpY2UAAAASAAAAB3NsaWNlSURsb25nAAAAAAAAAAdncm91cElEbG9uZwAAAAAAAAAGb3JpZ2luZW51bQAAAAxFU2xpY2VPcmlnaW4AAAANYXV0b0dlbmVyYXRlZAAAAABUeXBlZW51bQAAAApFU2xpY2VUeXBlAAAAAEltZyAAAAAGYm91bmRzT2JqYwAAAAEAAAAAAABSY3QxAAAABAAAAABUb3AgbG9uZwAAAAAAAAAATGVmdGxvbmcAAAAAAAAAAEJ0b21sb25nAAAAeQAAAABSZ2h0bG9uZwAAANcAAAADdXJsVEVYVAAAAAEAAAAAAABudWxsVEVYVAAAAAEAAAAAAABNc2dlVEVYVAAAAAEAAAAAAAZhbHRUYWdURVhUAAAAAQAAAAAADmNlbGxUZXh0SXNIVE1MYm9vbAEAAAAIY2VsbFRleHRURVhUAAAAAQAAAAAACWhvcnpBbGlnbmVudW0AAAAPRVNsaWNlSG9yekFsaWduAAAAB2RlZmF1bHQAAAAJdmVydEFsaWduZW51bQAAAA9FU2xpY2VWZXJ0QWxpZ24AAAAH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UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAyMS0wOC0xMFQwOToyNDo1MCswODowMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAyMS0wOC0xMFQwOToyNDo1MCswODowMCIgeG1wOk1vZGlmeURhdGU9IjIwMjEtMDgtMTBUMDk6MjQ6NTArMDg6MDAiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NTQyNEZDQzE3OUY5RUIxMUFGOENBMEMyQjc0ODU5QTkiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NTMyNEZDQzE3OUY5RUIxMUFGOENBMEMyQjc0ODU5QTkiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo1MzI0RkNDMTc5RjlFQjExQUY4Q0EwQzJCNzQ4NTlBOSIgZGM6Zm9ybWF0PSJpbWFnZS9qcGVnIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIj4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY3JlYXRlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo1MzI0RkNDMTc5RjlFQjExQUY4Q0EwQzJCNzQ4NTlBOSIgc3RFdnQ6d2hlbj0iMjAyMS0wOC0xMFQwOToyNDo1MCswODowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjU0MjRGQ0MxNzlGOUVCMTFBRjhDQTBDMkI3NDg1OUE5IiBzdEV2dDp3aGVuPSIyMDIxLTA4LTEwVDA5OjI0OjUwKzA4OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPD94cGFja2V0IGVuZD0idyI/Pv/uAA5BZG9iZQBkQAAAAAH/2wCEAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQECAgICAgICAgICAgMDAwMDAwMDAwMBAQEBAQEBAQEBAQICAQICAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDA//AABEIAHkA1wMBEQACEQEDEQH/3QAEABv/xAGiAAAABgIDAQAAAAAAAAAAAAAHCAYFBAkDCgIBAAsBAAAGAwEBAQAAAAAAAAAAAAYFBAMHAggBCQAKCxAAAgEDBAEDAwIDAwMCBgl1AQIDBBEFEgYhBxMiAAgxFEEyIxUJUUIWYSQzF1JxgRhikSVDobHwJjRyChnB0TUn4VM2gvGSokRUc0VGN0djKFVWVxqywtLi8mSDdJOEZaOzw9PjKThm83UqOTpISUpYWVpnaGlqdnd4eXqFhoeIiYqUlZaXmJmapKWmp6ipqrS1tre4ubrExcbHyMnK1NXW19jZ2uTl5ufo6er09fb3+Pn6EQACAQMCBAQDBQQEBAYGBW0BAgMRBCESBTEGACITQVEHMmEUcQhCgSORFVKhYhYzCbEkwdFDcvAX4YI0JZJTGGNE8aKyJjUZVDZFZCcKc4OTRnTC0uLyVWV1VjeEhaOzw9Pj8ykalKS0xNTk9JWltcXV5fUoR1dmOHaGlqa2xtbm9md3h5ent8fX5/dIWGh4iJiouMjY6Pg5SVlpeYmZqbnJ2en5KjpKWmp6ipqqusra6vr/2gAMAwEAAhEDEQA/AN/j37r3Xvfuvde9+691737r3Xvfuvde9+691737r3XvfuvdcDIgbTqGr66fzb+tv6e/de6xipjOr9foYqbow5Fybcc/T37r3ST3rvja2wdtZbeO7s3j9vbbwVHJX5XLZWdaSkpaWFWeRnllZFaQjhE/UzGwBJt7917quD45fzR+lvkd3Znends4PcGLlNXWQbP3HPTyPR7qgoA71NUYoYNeI1pH5YlmtqiILlW9Hv3XurQqaojkZBGfIoRrym97qwX6EAkMfz+R7917qWZkAuSQLX5BFrkgXv8AQ8fT37r3WRSGAYcgi4Pv3Xuu/fuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3X/9Df49+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3TVUeCJjWujmRAyKE1FmNz6VUcEn/ePfuvdAz3p8gOs/j319luxu0Ny0OAw+Li1wUbzwtlstWuCtLisTjzItTX5CqkNljReACxsqkj3XutVvu/5HfJb+aV21H1515iclgepMPWzVtPt9amajwGFw0EhD7t7EyySCjeempyrgSHxwyERxh5CC/uvdM+9+7etviDteq6Y+J+Wo9w9m1sD4ztL5FRRRGvld0C1m3euZ1802IxYmDCWpikYSaUOokK6+691a3/Lo+XfbOC6Umz3y4zFDt7qujqKTEde9l7yr/wCH7j3JV1E0MSY+KOohNTuHHQoSf4gWJQxkMzrdk917q7TG5egzuLxuUxks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e6b+3viF8aO/M7j9zdy9M7G7Gz+Kxgw2Oyu6cNBk6ykxgnlqhRQyzAlIRPMzW/qffuvdBK38sz4Et9fit0//ALDalD/0b7917pY7P+BPwx2FWxZLanxl6YxWQgcSQVy7A25VVkEgIOuGprKConha4B9LDn37r3RpqPD4zHUsNFj6GmoaOnRY4KWjhjpqeGNBZY4oYVSNIwP7IFvfuvdIfs/p/rTujZ9ZsDtLZ+I3vszIVFHV1+3M9AazFVtRj6mOtonq6V28dQKashSVVcFRIita4Fvde6B/rD4QfE3pfd9Fv3qzobrrY+8sbTVtHQbiwO36SjylJTZGA01bFT1SqZIhUU5KMQQSrEfk3917o0ngj44PF+AzAc/kgEAn/X/p7917pEdgdXde9rbXyGyuyNn7f3ttTKoY8jgNy4yky2Mq1NiPLS1kUsZZSLq1tSkXBB9+690XrYnwB+G3WO78Hv7YHx5632lvHbVX99gdw4TBQ0OSxVWUMbTUdRCVaFnjbS1uGHBv7917pUdufDX4v987kpt39xdK7G7E3NR4uLCUua3RiIsnX0+JgqKqrhx8M892jpYqisldUFgC5/wt7r3QidRdHdTdCbYqNmdO7E2915taqy1TnajB7ZoYsfQTZisgpaWqyEkMYs1TNTUMMbMedESj6Ae/de6Fa3Fvx9Pfuvdf/9bf49+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvde9+691737r3Xvfuvdf/Z';
                                var doc = new jsPDF()
                                

                                doc.setFontSize(8);

                                // HEADER
                                doc.text(5,5, 'BANDAI WIREHARNESS PHILIPPINES INC');

                                doc.text(10,13,'Employee ID:');
                                doc.text(10,16.5,'Employee Name:');
                                doc.text(10,20,'Position:');
                                doc.text(10,23.5,'Department:');
                                doc.text(10,27,'Section:');

                                doc.text(65,13,""+employee_cmid+"");
                                doc.text(65,16.5,employee_name);
                                doc.text(65,20,position);
                                doc.text(65,23.5,empl_dept);
                                doc.text(65,27,empl_sect);

                                doc.text(115,5,'Payroll Pay-out:');
                                doc.text(115,9,'Payroll Cut-Off:');

                                doc.text(115,16.5,'Salary Type:');
                                doc.text(115,20,'Salary:');
                                doc.text(115,23.5,'Working Days:');
                                doc.text(115,27,'Absences:');

                                doc.text(170,5,payout);
                                doc.text(170,9,payroll_period);

                                doc.text(170,16.5,""+db_salary_type+"");
                                doc.text(170,20,""+salary_rate+"");
                                doc.text(170,23.5,""+days_present+"");
                                doc.text(170,27,""+ti_absent_mul+"");

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

                                doc.text(16,33.5, 'DESCRIPTION');
                                doc.text(41,33.5, 'DAYS/HRS');
                                doc.text(67,33.5, 'AMOUNT');

                                doc.text(91,33.5, 'DESCRIPTION');
                                doc.text(116,33.5, 'DAYS/HRS');
                                doc.text(142,33.5, 'AMOUNT');

                                doc.text(169,33.5, 'LEAVE BALANCES');
                                doc.text(169,58.5, 'LOAN BALANCES');
                                doc.setFontSize(7);
                                doc.setFont(undefined, 'bold');
                                doc.text(12,38,'EARNINGS');
                                doc.setFont(undefined, 'normal');
                                doc.text(14,42,'Basic Salary');
                                doc.text(14,45.5,'Paid Leave');
                                doc.text(14,49,'Daily Allowance');
                                doc.text(14,52.5,'Total Allowance');
                                doc.text(14,56,'Regular/Legal Holiday');
                                doc.text(14,59.5,'Regular OT');
                                doc.text(14,63,'Rest Day> 6 Hrs');
                                doc.text(14,66.5,'Rest Day OT');
                                doc.text(14,70,'Night Differential');
                                doc.text(14,73.5,'OT Night Differential');
                                doc.text(14,77,'Rest Day ND OT');
                                doc.text(14,80.5,'Meal Allowance');
                                // doc.text(14,84,'SIL 2020');
                                doc.text(14,84,SIL_label);
                                if(ti_rest_sp_hol_mul != 0){
                                    doc.text(14,87.5,'Rest + Special Holiday');
                                }
                                doc.setFont(undefined, 'bold');
                                doc.text(12,91,'ADJUSTMENTS');
                                doc.setFont(undefined, 'normal');
                                doc.text(14,94.5,'Meal Allowance');
                                doc.text(14,98,'Govt. Conributions');
                                doc.text(14,101,'Others');
                                doc.text(14,104.5,'13th Month Pay');
                                doc.text(14,108,'Tax Refund');

                                doc.text(56,42,""+ti_basic_sal_mul+"",{align:'right'}); //Basic Salary
                                doc.text(56,45.5,""+ti_leave_mul+"",{align:'right'}); //Paid Leave
                                if(ta_daily_allowance > 0){
                                    doc.text(56,49,""+ti_basic_sal_mul+"",{align:'right'}); //Daily Allowance
                                } else {
                                    doc.text(56,49,"-",{align:'right'}); //Daily Allowance
                                }
                                
                                doc.text(56,56,""+ti_legal_hol_mul+"",{align:'right'}); //Regular/Legal Holiday
                                doc.text(56,59.5,""+ti_reg_ot_mul+"",{align:'right'}); //Regular OT
                                doc.text(56,63,""+ti_rest_mul+"",{align:'right'}); //Rest Day> 6 Hrs
                                doc.text(56,66.5,""+ti_rest_ot_mul+"",{align:'right'}); //Rest Day OT
                                doc.text(56,70,""+ti_nd_mul+"",{align:'right'}); //Night Differential
                                doc.text(56,73.5,""+ti_nd_ot_mul+"",{align:'right'}); //OT Night Differential
                                doc.text(56,77,""+ti_rest_nd_ot_mul+"",{align:'right'}); //Rest Day ND OT
                                doc.text(56,80.5,""+ti_de_minimis_mul+"",{align:'right'}); //Meal Allowance
                                doc.text(56,84,'-',{align:'right'}); //SIL 2020
                                if(ti_rest_sp_hol_mul != 0){
                                    doc.text(56,87.5,""+ti_rest_sp_hol_mul+"",{align:'right'});
                                }

                                doc.text(80,42,""+ti_basic_sal_total+"",{align:'right'}); // Basic Salary
                                doc.text(80,45.5,""+ti_leave_total+"",{align:'right'}); // Paid Leave
                                doc.text(80,49,""+ta_daily_allowance+"",{align:'right'}); // Daily Allowance
                                doc.text(80,52.5,""+ta_allowance+"",{align:'right'}); // Total Allowance
                                doc.text(80,56,""+ti_legal_hol_total+"",{align:'right'}); // Regular/Legal Holiday
                                doc.text(80,59.5,""+ti_reg_ot_total+"",{align:'right'}); // Regular OT
                                doc.text(80,63,""+ti_rest_total+"",{align:'right'}); // Rest Day> 6 Hrs
                                doc.text(80,66.5,""+ti_rest_ot_total+"",{align:'right'}); // Rest Day OT
                                doc.text(80,70,""+ti_nd_total+"",{align:'right'}); // Night Differential
                                doc.text(80,73.5,""+ti_nd_ot_total+"",{align:'right'}); // OT Night Differential
                                doc.text(80,77,""+ti_rest_nd_ot_total+"",{align:'right'}); // Rest Day ND OT
                                doc.text(80,80.5,""+ti_de_minimis_total+"",{align:'right'}); // Meal Allowance
                                doc.text(80,84,""+ti_sil_2020+"",{align:'right'}); // SIL 2020
                                if(ti_rest_sp_hol_mul != 0){
                                    doc.text(80,87.5,""+ti_rest_sp_hol_total+"",{align:'right'});  // Rest + Special Holiday
                                }

                                doc.text(80,94.5,""+ti_meal_earning+"",{align:'right'}); //Meal Allowance
                                doc.text(80,98,""+ti_gov_cont_earning+"",{align:'right'}); //Govt. Conributions
                                doc.text(80,101.5,""+ti_others_earning+"",{align:'right'}); //Others
                                doc.text(80,105,"-",{align:'right'}); //13th Month Pay
                                doc.text(80,108.5,""+tax_refund_earning+"",{align:'right'}); //Tax Refund

                                doc.setFont(undefined, 'bold');
                                doc.text(87,38,'DEDUCTIONS');
                                doc.setFont(undefined, 'normal');
                                doc.text(89,42,'Withholding Tax');
                                doc.text(89,45.5,'SSS EE Share');
                                doc.text(89,49,'PHIC EE Share');
                                doc.text(89,52.5,'HDMF EE Share');
                                doc.text(89,56,'SSS Loan');
                                doc.text(89,59.5,'HDMF Loan');
                                doc.text(89,63,'Absences');
                                doc.text(89,66.5,'Tardines');
                                doc.text(89,70,'Undertime');
                                doc.text(89,73.5,'No TI/TO');
                                doc.text(89,77,'Half day');
                                doc.text(89,80.5,'Advances to Employees ');
                                doc.text(89,84,'Uniform');
                                doc.setFont(undefined, 'bold');
                                doc.text(87,91,'ADJUSTMENTS');
                                doc.setFont(undefined, 'normal');
                                doc.text(89,94.5,'Meal Allowance');
                                doc.text(89,98,'Govt. Conributions');
                                doc.text(89,101.5,'Others');
                                doc.text(89,105,'13th Month Pay');
                                doc.text(89,108.5,'Tax Refund');

                                doc.text(131,63,""+ti_absent_mul+"",{align:'right'});
                                doc.text(131,66.5,""+ti_tard_mul+"",{align:'right'});
                                doc.text(131,70,""+ti_undertime_mul+"",{align:'right'});
                                doc.text(131,73.5,""+ti_no_ti_to_mul+"",{align:'right'});

                                doc.text(155,42,""+wtax+"",{align:'right'});
                                doc.text(155,45.5,""+gov_sss_ee+"",{align:'right'});
                                doc.text(155,49,""+gov_philhealth_ee+"",{align:'right'});
                                doc.text(155,52.5,""+gov_pagibig_ee+"",{align:'right'});
                                doc.text(155,56,""+loan_amount_paid+"",{align:'right'});
                                doc.text(155,59.5,""+pagibig_loan_amount_paid+"",{align:'right'});
                                doc.text(155,63,""+ti_absent_total+"",{align:'right'});
                                doc.text(155,66.5,""+ti_tard_total+"",{align:'right'});
                                doc.text(155,70,""+ti_undertime_total+"",{align:'right'});
                                doc.text(155,73.5,""+ti_no_ti_to_total+"",{align:'right'});
                                doc.text(155,77,""+ti_half_total+"",{align:'right'});
                                doc.text(155,80.5,""+salary_advance+"",{align:'right'});
                                doc.text(155,84,""+uniform_deduction+"",{align:'right'});
    
                                doc.text(155,94.5,""+ti_meal_deduction+"",{align:'right'});
                                doc.text(155,98,""+ti_gov_cont_deduction+"",{align:'right'});
                                doc.text(155,101.5,""+ti_others_deduction+"",{align:'right'});
                                doc.text(155,105,"-",{align:'right'});
                                doc.text(155,108.5,""+tax_refund_deduction+"",{align:'right'});

                                doc.text(174,39,'USED');
                                doc.text(190,39,'BAL');
                                doc.text(162,42.5,'VL');
                                doc.text(162,46,'SL');
                                doc.text(181,42.5,""+used_vacation_leave+"",{align:'right'});
                                doc.text(181,46,""+used_sick_leave+"",{align:'right'});
                                doc.text(198,42.5,""+vacation_leave_balance+"",{align:'right'});
                                doc.text(198,46,""+sick_leave_balance+"",{align:'right'});

                                doc.text(174,63,'USED');
                                doc.text(190,63,'BAL');
                                doc.text(162,66.5,'SSS');
                                doc.text(162,70,'HDMF');
                                doc.text(181,66.5,""+loan_amount_paid+"",{align:'right'});
                                doc.text(181,70,""+pagibig_loan_amount_paid+"",{align:'right'});
                                // doc.text(198,66.5,""+loan_balance_amount+"",{align:'right'});
                                // doc.text(198,70,""+pagibig_loan_balance_amount+"",{align:'right'});
                                doc.text(198,66.5,"-",{align:'center'});
                                doc.text(198,70,"-",{align:'center'});

                                doc.setFont(undefined, 'bold');
                                doc.text(12,115,'TOTAL EARNINGS');
                                doc.setFont(undefined, 'normal');
                                doc.text(80,115,""+total_earnings+"",{align:'right'});

                                doc.setFont(undefined, 'bold');
                                doc.text(87,115,'TOTAL DEDUCTIONS');
                                doc.setFont(undefined, 'normal');
                                doc.text(155,115,""+total_deductions+"",{align:'right'});

                                doc.text(175,108,'NET PAY');
                                doc.setFont(undefined, 'bold');
                                doc.text(180,115,""+net_pay+"",{align:'center'});
                                doc.setFont(undefined, 'normal');

                                doc.text(15,125, 'Received By:');
                                doc.line(35, 125, 85, 125) // horizontal line
                                doc.text(15, 130, 'Date:');
                                doc.line(35, 130, 85, 130);


                                doc.save(employee_name + " - Payslip.pdf");

                                $(download_btn).find('.loading_indicator').hide();
                                $(download_btn).find('img').show();
                            })
                        })

                    })

                })
            })





            async function get_payslip_data_based_on_period(url, cutoff_id){
                var formData = new FormData();
                formData.append('cutoff_id', cutoff_id);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            
            async function get_empl_leave_data(url, empl_id){
                var formData = new FormData();
                formData.append('empl_id', empl_id);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            
            async function get_payslip_data(url, payroll_id){
                var formData = new FormData();
                formData.append('payroll_id', payroll_id);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }
            
            async function generated_payslip_count(url,payroll_id) {
                var formData = new FormData();
                formData.append('payroll_id', payroll_id);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }
            
            async function getEmployeeData(url,employee_id) {
                var formData = new FormData();
                formData.append('employee_id', employee_id);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }



            // ============================ display empl with payslips, ready for payslip, not ready for payslip =============================
            
            async function get_employees_ready_for_payslip(url,payroll_date, payroll_id) {
                var formData = new FormData();
                formData.append('payroll_date', payroll_date);
                formData.append('payroll_id', payroll_id);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }

            async function get_employee_not_ready_for_payslip(url,payroll_date,payroll_id) {
                var formData = new FormData();
                formData.append('payroll_date', payroll_date);
                formData.append('payroll_id', payroll_id);
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
