<style>
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
    table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
   
    }
    th, td {
    text-align: left;
    padding: 8px;
    font-size: 14px;
    font-weight: normal;
    }
    
</style>

<?php 
    $total_sss = '';
    $total_pagibig = '';
    $total_philhealth = '';

    $total_sss_arr = [];
    $total_pagibig_arr = [];
    $total_philhealth_arr = [];

    if($DISP_PAYROLL_DATA){
        foreach($DISP_PAYROLL_DATA as $payroll_data){
            array_push($total_sss_arr, (floatval($payroll_data->comp_cont_sss) + floatval($payroll_data->gov_sss)));
            array_push($total_pagibig_arr, floatval($payroll_data->comp_cont_pagibig));
            array_push($total_philhealth_arr, floatval($payroll_data->comp_cont_philhealth));
        }
    }

    $total_sss = array_sum($total_sss_arr);
    $total_pagibig = array_sum($total_pagibig_arr);
    $total_philhealth = array_sum($total_philhealth_arr);
?>

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

	<div class="content-wrapper">
		<div class="container-fluid p-4">
            <form action="<?php echo base_url('payroll/generator'); ?>" id="payslip_period" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="row">
                    <div class = "col-md-6">
                        <h1><b>Company Contributions</b><h1>
                    </div>
                    <div class = "col-md-6" style = "text-align: right;">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex">
                            <div style="width: 150px;">
                                <p class="text-bold mb-2 pt-2">Cut-off Period:  </p>
                            </div>
                            <div class="flex-fill" style="width: auto;">
                                <!-- <p>June 1, 2021 - June 15, 2021</p> -->
                                <select name="date_period" class="form-control" id="date_period" required>
                                    <?php
                                        if($DISP_PAYROLL_SCHED){
                                            foreach($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW){
                                            ?>
                                                <option value="<?= $DISP_PAYROLL_SCHED_ROW->id ?>" <?php if($DISP_PAYROLL_SCHED_ROW->id == '9'){echo 'selected';} ?>><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                                            <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary float-right"><i class="fas fa-file-csv"></i>&nbsp;&nbsp; Export CSV</button>
                        <button type="submit" class="btn btn-primary float-right mr-2"><i class="fas fa-file-excel"></i>&nbsp;&nbsp; Export Excel</button>
                    </div>
                </div>
                <hr>
                <div class = "row">
                    <div class = "col-md-4">
                        <div class = "card" style = "background-color: #00897b; color: white;">
                            <div style = "padding: 10px 1px;">
                                <text style = "font-size: 20px; margin-bottom: -15px;" id="total_sss">
                                0
                                </text><br>
                                <text><b>SSS</b></text>
                            </div>
                        </div>
                    </div>
                    <div class = "col-md-4">
                        <div class = "card" style = "background-color: #5e35b1; color: white;">
                            <div style = "padding: 10px 1px;">
                                <text style = "font-size: 20px; margin-bottom: -15px;" id="total_pagibig">
                                0
                                </text><br>
                                <text><b>Pagibig</b></text>
                            </div>
                        </div>
                    </div>
                    <div class = "col-md-4">
                        <div class = "card" style = "background-color: #3382b1; color: white;">
                            <div style = "padding: 10px 1px;">
                                <text style = "font-size: 20px; margin-bottom: -15px;" id="total_philhealth">
                                0
                                </text><br>
                                <text><b>Philhealth</b></text>
                            </div>
                        </div>
                    </div>
                    <!-- <div class = "col-md-3">
                        <div class = "card" style = "background-color: #635249; color: white;">
                            <div style = "padding: 10px 1px;">
                                <text style = "font-size: 20px; margin-bottom: -15px;" id="total_amount"></text><br>
                                <text><b>Total Payroll Amount</b></text>
                            </div>
                        </div>
                    </div> -->
                </div>
            </form>
            <ul class="nav nav-tabs border-0">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#cont_list_sss">SSS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#cont_list_pagibig">Pag-Ibig</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#cont_list_philhealth">Philhealth</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class = "card border-0 mt-2 tab-pane active p-2" id="cont_list_sss" style="margin-top: -1px !important; border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
                    <div style="overflow-x:auto;">
                        <table class = "table table-hover" id="tbl_sss">
                            <thead>
                                <tr>
                                    <td style="border-top: none !important;">Employee Id</td>
                                    <td style="border-top: none !important;">Full Name</td>
                                    <td style="border-top: none !important;">Employment Type</td>
                                    <td style="border-top: none !important;">Position</td>
                                    <td style="border-top: none !important; display: none;">Cut-off Period</td>
                                    <td style="border-top: none !important;">SS No.</td>
                                    <td style="border-top: none !important;">Employee's Share <br> (EE)</td>
                                    <td style="border-top: none !important;">Employer's Share <br> (ER)</td>
                                    <td style="border-top: none !important;">Total</td>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if($DISP_PAYROLL_DATA){
                                        foreach($DISP_PAYROLL_DATA as $DISP_PAYROLL_DATA_ROW){
                                            $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_PAYROLL_DATA_ROW->empl_id);
                                            $payroll_period = $this->p175_payschedule_mod->MOD_GET_PAY_SCHED_DATA($DISP_PAYROLL_DATA_ROW->payroll_period);
                                        ?>
                                            <tr class="payslip_row">
                                                <td><?= $employee[0]->col_empl_cmid ?></td>
                                                <td><a href = "<?=base_url()?>employees/personal?id=<?= $DISP_PAYROLL_DATA_ROW->empl_id ?>">
                                                    <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $employee[0]->col_frst_name.' '.$employee[0]->col_last_name?></a>
                                                </td>
                                                
                                                <td><?= $employee[0]->col_empl_type ?></td>
                                                <td><?= $employee[0]->col_empl_posi ?></td>
                                                <td style="display: none;" payroll_period="<?= $payroll_period[0]->name ?>"></td>
                                                <td><?= $employee[0]->col_empl_sssc ?></td>
                                                <td>
                                                    <?php
                                                        echo number_format($DISP_PAYROLL_DATA_ROW->gov_sss,2);
                                                    ?>
                                                </td>
                                                <td><?= number_format($DISP_PAYROLL_DATA_ROW->comp_cont_sss,2) ?></td>
                                                <td sss_total="<?= floatval($DISP_PAYROLL_DATA_ROW->gov_sss) + floatval($DISP_PAYROLL_DATA_ROW->comp_cont_sss) ?>"><?= number_format((floatval($DISP_PAYROLL_DATA_ROW->gov_sss) + floatval($DISP_PAYROLL_DATA_ROW->comp_cont_sss)),2) ?></td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                        ?>
                                            <td colspan=5>No Payslips Yet</td>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class = "card border-0 mt-2 tab-pane p-2" id="cont_list_pagibig" style="margin-top: -1px !important; border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
                    <div style="overflow-x:auto;">
                        <table class = "table table-hover" id="tbl_pagibig">
                            <thead>
                                <tr>
                                    <td style="border-top: none !important;">Employee Id</td>
                                    <td style="border-top: none !important;">Full Name</td>
                                    <td style="border-top: none !important;">Employment Type</td>
                                    <td style="border-top: none !important;">Position</td>
                                    <td style="border-top: none !important; display: none;">Cut-off Period</td>
                                    <td style="border-top: none !important;">Pag-Ibig No.</td>
                                    <td style="border-top: none !important;">Employee's Share <br> (EE)</td>
                                    <td style="border-top: none !important;">Employer's Share <br> (ER)</td>
                                    <td style="border-top: none !important;">Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if($DISP_PAYROLL_DATA){
                                        foreach($DISP_PAYROLL_DATA as $DISP_PAYROLL_DATA_ROW){
                                            $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_PAYROLL_DATA_ROW->empl_id);
                                            $payroll_period = $this->p175_payschedule_mod->MOD_GET_PAY_SCHED_DATA($DISP_PAYROLL_DATA_ROW->payroll_period);
                                        ?>
                                            <tr class="payslip_row">
                                                <td><?= $employee[0]->col_empl_cmid ?></td>
                                                <td><a href = "<?=base_url()?>employees/personal?id=<?= $DISP_PAYROLL_DATA_ROW->empl_id ?>">
                                                    <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $employee[0]->col_frst_name.' '.$employee[0]->col_last_name?></a>
                                                </td>
                                                
                                                <td><?= $employee[0]->col_empl_type ?></td>
                                                <td><?= $employee[0]->col_empl_posi ?></td>
                                                <td style="display: none;" payroll_period="<?= $payroll_period[0]->name ?>"></td>
                                                <td><?= $employee[0]->col_empl_hdmf ?></td>
                                                <td><?= number_format($DISP_PAYROLL_DATA_ROW->gov_pagibig, 2) ?></td>
                                                <td><?= number_format($DISP_PAYROLL_DATA_ROW->comp_cont_pagibig, 2) ?></td>
                                                <td pagibig_total="<?= floatval($DISP_PAYROLL_DATA_ROW->gov_pagibig) + floatval($DISP_PAYROLL_DATA_ROW->comp_cont_pagibig) ?>"><?= number_format((floatval($DISP_PAYROLL_DATA_ROW->gov_pagibig) + floatval($DISP_PAYROLL_DATA_ROW->comp_cont_pagibig)),2) ?></td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                        ?>
                                            <td colspan=5>No Payslips Yet</td>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class = "card border-0 mt-2 tab-pane p-2" id="cont_list_philhealth" style="margin-top: -1px !important; border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
                    <div style="overflow-x:auto;">
                        <table class = "table table-hover" id="tbl_philhealth">
                            <thead>
                                <tr>
                                    <td style="border-top: none !important;">Employee Id</td>
                                    <td style="border-top: none !important;">Full Name</td>
                                    <td style="border-top: none !important;">Employment Type</td>
                                    <td style="border-top: none !important;">Position</td>
                                    <td style="border-top: none !important; display: none;">Cut-off Period</td>
                                    <td style="border-top: none !important;">Philhealth No.</td>
                                    <td style="border-top: none !important;">Employee's Share <br> (EE)</td>
                                    <td style="border-top: none !important;">Employer's Share <br> (ER)</td>
                                    <td style="border-top: none !important;">Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if($DISP_PAYROLL_DATA){
                                        foreach($DISP_PAYROLL_DATA as $DISP_PAYROLL_DATA_ROW){
                                            $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_PAYROLL_DATA_ROW->empl_id);
                                            $payroll_period = $this->p175_payschedule_mod->MOD_GET_PAY_SCHED_DATA($DISP_PAYROLL_DATA_ROW->payroll_period);
                                        ?>
                                            <tr class="payslip_row">
                                                <td><?= $employee[0]->col_empl_cmid ?></td>
                                                <td><a href = "<?=base_url()?>employees/personal?id=<?= $DISP_PAYROLL_DATA_ROW->empl_id ?>">
                                                    <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $employee[0]->col_frst_name.' '.$employee[0]->col_last_name?></a>
                                                </td>
                                                
                                                <td><?= $employee[0]->col_empl_type ?></td>
                                                <td><?= $employee[0]->col_empl_posi ?></td>
                                                <td style="display: none;" payroll_period="<?= $payroll_period[0]->name ?>"></td>
                                                <td><?= $employee[0]->col_empl_phil ?></td>
                                                <td><?= $DISP_PAYROLL_DATA_ROW->gov_philhealth ?></td>
                                                <td><?= $DISP_PAYROLL_DATA_ROW->comp_cont_philhealth ?></td>
                                                <td philhealth_total="<?= floatval($DISP_PAYROLL_DATA_ROW->gov_philhealth) + floatval($DISP_PAYROLL_DATA_ROW->comp_cont_philhealth) ?>"><?= number_format((floatval($DISP_PAYROLL_DATA_ROW->gov_philhealth) + floatval($DISP_PAYROLL_DATA_ROW->comp_cont_philhealth)),2) ?></td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                        ?>
                                            <td colspan=5>No Payslips Yet</td>
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

    <table class = "table table-hover" id="export_table" style="display: none;">
        <thead>
            <tr>
                <td style="border-top: none !important;">Employee Id</td>
                <td style="border-top: none !important;">Full Name</td>
                <td style="border-top: none !important;">Employment Type</td>
                <td style="border-top: none !important;">Position</td>
                <td style="border-top: none !important; display: none;">Cut-off Period</td>
                <td style="border-top: none !important;">SS No.</td>
                <td style="border-top: none !important;">SSS Employee's Share <br> (EE)</td>
                <td style="border-top: none !important;">SSS Employer's Share <br> (ER)</td>
                <td style="border-top: none !important;">SSS Total</td>
                <td style="border-top: none !important;">PagIbig No.</td>
                <td style="border-top: none !important;">PagIbig Employee's Share <br> (EE)</td>
                <td style="border-top: none !important;">PagIbig Employer's Share <br> (ER)</td>
                <td style="border-top: none !important;">PagIbig Total</td>
                <td style="border-top: none !important;">Philhealth No.</td>
                <td style="border-top: none !important;">Philhealth Employee's Share <br> (EE)</td>
                <td style="border-top: none !important;">Philhealth Employer's Share <br> (ER)</td>
                <td style="border-top: none !important;">Philhealth Total</td>
            </tr>
        </thead>
        <tbody>
            <?php 
                if($DISP_PAYROLL_DATA){
                    foreach($DISP_PAYROLL_DATA as $DISP_PAYROLL_DATA_ROW){
                        $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_PAYROLL_DATA_ROW->empl_id);
                        $payroll_period = $this->p175_payschedule_mod->MOD_GET_PAY_SCHED_DATA($DISP_PAYROLL_DATA_ROW->payroll_period);
                    ?>
                        <tr class="payslip_row">
                            <td><?= $employee[0]->col_empl_cmid ?></td>
                            <td><a href = "<?=base_url()?>employees/personal?id=<?= $DISP_PAYROLL_DATA_ROW->empl_id ?>">
                                <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $employee[0]->col_frst_name.' '.$employee[0]->col_last_name?></a>
                            </td>
                            
                            <td><?= $employee[0]->col_empl_type ?></td>
                            <td><?= $employee[0]->col_empl_posi ?></td>
                            <td style="display: none;" payroll_period="<?= $payroll_period[0]->name ?>"></td>
                            <!-- SSS -->
                            <td><?= $employee[0]->col_empl_sssc ?></td>
                            <td><?php echo number_format($DISP_PAYROLL_DATA_ROW->gov_sss,2);?></td>
                            <td><?= number_format($DISP_PAYROLL_DATA_ROW->comp_cont_sss,2) ?></td>
                            <td><?= number_format((floatval($DISP_PAYROLL_DATA_ROW->gov_sss) + floatval($DISP_PAYROLL_DATA_ROW->comp_cont_sss)),2) ?></td>
                            
                            <!-- Pagibig -->
                            <td><?= $employee[0]->col_empl_hdmf ?></td>
                            <td><?php echo number_format($DISP_PAYROLL_DATA_ROW->gov_pagibig,2);?></td>
                            <td><?= number_format($DISP_PAYROLL_DATA_ROW->comp_cont_pagibig,2) ?></td>
                            <td><?= number_format((floatval($DISP_PAYROLL_DATA_ROW->gov_pagibig) + floatval($DISP_PAYROLL_DATA_ROW->comp_cont_pagibig)),2) ?></td>
                            
                            <!-- Philhealth -->
                            <td><?= $employee[0]->col_empl_phil ?></td>
                            <td><?php echo number_format($DISP_PAYROLL_DATA_ROW->gov_philhealth,2);?></td>
                            <td><?= number_format($DISP_PAYROLL_DATA_ROW->comp_cont_philhealth,2) ?></td>
                            <td><?= number_format((floatval($DISP_PAYROLL_DATA_ROW->gov_philhealth) + floatval($DISP_PAYROLL_DATA_ROW->comp_cont_philhealth)),2) ?></td>
                    </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <td colspan=5>No Payslips Yet</td>
                    <?php
                }
            ?>
        </tbody>
    </table>

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
    <!-- Datatables -->
    <script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
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

    <script>
        $(document).ready(function(){

            /* $("#export_table").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)'); */


            // for async data - fetch count of employees with no payslip
            base_url = '<?= base_url() ?>';
            url = '<?= base_url() ?>payroll/get_employee_no_payslip_count';
            url2 = '<?= base_url() ?>payroll/get_payslip_count_based_on_period';
            url3 = '<?= base_url() ?>payroll/getEmployeeData';
            var payroll_id = $('#date_period').val();
            var cut_off_period_text = $('#date_period option:selected').text();

            // ==================================================== INITITAL VALUE ========================================================
            var total_sss_arr = [];
            var total_pagibig_arr = [];
            var total_philhealth_arr = [];
            
            var sss_cutoff = $('#tbl_sss .payslip_row');
            var pagibig_cutoff = $('#tbl_pagibig .payslip_row');
            var philhealth_cutoff = $('#tbl_philhealth .payslip_row');
            
            if(cut_off_period_text){
                Array.from(sss_cutoff).forEach(function(tr){
                    const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                    var sss_total = $(tr.childNodes[17]).attr('sss_total');
                    total_sss_arr.push(parseFloat(sss_total));
                    if(cut_off_period_text == cut_off_period){
                        tr.style.display = "";

                        // get the total sum of array values
                        // append the total sum of arrays to mini cards as texts
                        $('#total_sss').html((total_sss_arr.reduce((a, b) => a + b, 0)).toFixed(2));
                        
                    } else {
                        tr.style.display = 'none';
                        $('#total_sss').html(0);
                    }
                })
                Array.from(pagibig_cutoff).forEach(function(tr){
                    const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                    // total_sss_arr.push(parseFloat($(tr.childNodes[11]).html()));
                    var pagibig_total = $(tr.childNodes[17]).attr('pagibig_total');
                    total_pagibig_arr.push(parseFloat(pagibig_total));
                    if(cut_off_period_text == cut_off_period){
                        tr.style.display = "";

                        // get the total sum of array values
                        // append the total sum of arrays to mini cards as texts
                        $('#total_pagibig').html((total_pagibig_arr.reduce((a, b) => a + b, 0)).toFixed(2));
                        
                    } else {
                        tr.style.display = 'none';
                        $('#total_pagibig').html(0);
                    }
                })
                Array.from(philhealth_cutoff).forEach(function(tr){
                    const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                    var philhealth_total = $(tr.childNodes[17]).attr('philhealth_total');
                    total_philhealth_arr.push(parseFloat(philhealth_total));
                    if(cut_off_period_text == cut_off_period){
                        tr.style.display = "";

                        // get the total sum of array values
                        // append the total sum of arrays to mini cards as texts
                        $('#total_philhealth').html((total_philhealth_arr.reduce((a, b) => a + b, 0)).toFixed(2));
                        
                    } else {
                        tr.style.display = 'none';
                        $('#total_philhealth').html(0);
                    }
                })
            } else {
                Array.from(sss_cutoff).forEach(function(tr){
                    tr.style.display = "";
                })
                Array.from(pagibig_cutoff).forEach(function(tr){
                    tr.style.display = "";
                })
                Array.from(philhealth_cutoff).forEach(function(tr){
                    tr.style.display = "";
                })
            } 




            // Sort by cut-off period
            $('#date_period').change(function(e){
                // clear container before appending
                $('#empl_without_payslip_container').html('');
                var date_period_id_value = $(this).val();
                var date_period_value = $('#date_period option:selected').text();

                var total_sss_arr = [];
                var total_pagibig_arr = [];
                var total_philhealth_arr = [];

                var sss_cutoff = $('#tbl_sss .payslip_row');
                var pagibig_cutoff = $('#tbl_pagibig .payslip_row');
                var philhealth_cutoff = $('#tbl_philhealth .payslip_row');
                
                if(date_period_value){
                    Array.from(sss_cutoff).forEach(function(tr){
                        const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                        var sss_total = $(tr.childNodes[17]).attr('sss_total');
                        total_sss_arr.push(parseFloat(sss_total));
                        if(date_period_value == cut_off_period){
                            tr.style.display = "";

                            // get the total sum of array values
                            // append the total sum of arrays to mini cards as texts
                            $('#total_sss').html((total_sss_arr.reduce((a, b) => a + b, 0)).toFixed(2));
                            
                        } else {
                            tr.style.display = 'none';
                            $('#total_sss').html(0);
                        }
                    })
                    Array.from(pagibig_cutoff).forEach(function(tr){
                        const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                        // total_sss_arr.push(parseFloat($(tr.childNodes[11]).html()));
                        var pagibig_total = $(tr.childNodes[17]).attr('pagibig_total');
                        total_pagibig_arr.push(parseFloat(pagibig_total));
                        if(date_period_value == cut_off_period){
                            tr.style.display = "";

                            // get the total sum of array values
                            // append the total sum of arrays to mini cards as texts
                            $('#total_pagibig').html((total_pagibig_arr.reduce((a, b) => a + b, 0)).toFixed(2));
                            
                        } else {
                            tr.style.display = 'none';
                            $('#total_pagibig').html(0);
                        }
                    })
                    Array.from(philhealth_cutoff).forEach(function(tr){
                        const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                        // total_sss_arr.push(parseFloat($(tr.childNodes[11]).html()));
                        var philhealth_total = $(tr.childNodes[17]).attr('philhealth_total');
                        total_philhealth_arr.push(parseFloat(philhealth_total));
                        if(date_period_value == cut_off_period){
                            tr.style.display = "";

                            // get the total sum of array values
                            // append the total sum of arrays to mini cards as texts
                            $('#total_philhealth').html((total_philhealth_arr.reduce((a, b) => a + b, 0)).toFixed(2));
                            
                        } else {
                            tr.style.display = 'none';
                            $('#total_philhealth').html(0);
                        }
                    })
                } else {
                    Array.from(sss_cutoff).forEach(function(tr){
                        tr.style.display = "";
                    })
                    Array.from(pagibig_cutoff).forEach(function(tr){
                        tr.style.display = "";
                    })
                    Array.from(philhealth_cutoff).forEach(function(tr){
                        tr.style.display = "";
                    })
                } 
            })













            
            
            async function getPayrollData_period(url,payroll_date) {
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
