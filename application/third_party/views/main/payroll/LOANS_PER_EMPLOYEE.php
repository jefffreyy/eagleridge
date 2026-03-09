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

    .bank_row:hover{
        cursor: pointer;
    }
    /* .pagination{
        display: none !important;
    } */

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }

    .loan_row:hover{
        cursor:pointer;
    }
</style>

<?php
    // DISPLAY EMPLOYEE DATA
    $employee_fullname = '';
    $employee_cmid = '';
    $user_img = '';
    if($DISP_EMPLOYEE_BASED_CMID){
        foreach($DISP_EMPLOYEE_BASED_CMID as $DISP_EMPLOYEE_BASED_CMID_ROW){
            $employee_fullname = $DISP_EMPLOYEE_BASED_CMID_ROW->col_frst_name.' '.$DISP_EMPLOYEE_BASED_CMID_ROW->col_last_name;
            $employee_cmid = $DISP_EMPLOYEE_BASED_CMID_ROW->col_empl_cmid;
            $user_img = $DISP_EMPLOYEE_BASED_CMID_ROW->col_imag_path;
        }
    }
    
    // DISPLAY LOAN DATA
    $date_of_loan = '';
    $pay_terms = '';
    $loan_type = '';
    $amount = '';

    if($DISP_SPECIFIC_LOAN){
        foreach($DISP_SPECIFIC_LOAN as $DISP_SPECIFIC_LOAN_ROW){
            $date_of_loan = $DISP_SPECIFIC_LOAN_ROW->date_of_loan;
            $pay_terms = $DISP_SPECIFIC_LOAN_ROW->pay_terms;
            $loan_type = $DISP_SPECIFIC_LOAN_ROW->loan_type;
            $amount = $DISP_SPECIFIC_LOAN_ROW->installment;
        }
    }
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
            <div class="row mb-2">
                <div class = "col-md-6">
                    <h1><b>Loan Payable</b><h1>
                </div>
                <div class = "col-md-6" style = "text-align: right;">
                    
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 mt-2">
                        <div class="row px-5">
                            <div class="col-lg-3 w-100 text-center">
                                <img class="rounded-circle avatar " width="130" height="130" src="<?php if($user_img){echo base_url().'user_images/'.$user_img;} else {echo base_url().'user_images/default_profile_img3.png';}?>">
                            </div>
                            <div class="col-lg-3">
                                <label for="">Employee ID:</label>
                                <p class="text-secondary"><?= $employee_cmid ?></p>
                                <label for="">Employee Name:</label>
                                <p class="text-secondary"><?= $employee_fullname ?></p>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Date of Loan:</label>
                                <p class="text-secondary"><?= $date_of_loan ?></p>
                                <label for="">Loan Type:</label>
                                <p class="text-secondary"><?= $loan_type ?></p>
                                <!-- <label for="">Pay Terms:</label>
                                <p class="text-secondary"><?= $pay_terms ?></p> -->

                            </div>
                            <div class="col-lg-3">
                                
                                <label for="">Amount:</label>
                                <p class="text-secondary">&#8369; <?= $amount ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "card border-0 mt-2" style = "padding: 0px; margin: 0px">
                <table class = "table table-hover" id="employee_tbl">
                    <thead>
                        <tr>
                            <td>Loan Payable ID</td>
                            <td>Cut-off Period</td>
                            <td>Installment Amount</td>
                            <!-- <td>Status</td> -->
                        </tr>
                    </thead>
                    <tbody id="table_container">
                        <?php
                            if($DISP_LOAN_PAYABLE){
                                $number = 0;
                                foreach($DISP_LOAN_PAYABLE as $DISP_LOAN_PAYABLE_ROW){
                                    $number++;
                                    $loan_id = str_pad($DISP_LOAN_PAYABLE_ROW->loan_id, 5, "0", STR_PAD_LEFT);

                                    // $loan_payable_id = $loan_id;
                                    $loan_payable_id = $loan_id;

                                ?>
                                    <tr class="loan_row" data-toggle="modal" data-target="#modal_loan_payable" empl_cmid="<?= $DISP_LOAN_PAYABLE_ROW->empl_cmid ?>" date_of_loan="<?= $DISP_LOAN_PAYABLE_ROW->date_of_loan ?>" loan_id="<?= $DISP_LOAN_PAYABLE_ROW->loan_id ?>" loan_payable_id="<?= $DISP_LOAN_PAYABLE_ROW->id ?>" >
                                        <td><?= $loan_payable_id ?></td>
                                        <td><?= $DISP_LOAN_PAYABLE_ROW->cutoff_period ?></td>
                                        <td><?= $DISP_LOAN_PAYABLE_ROW->installment ?></td>
                                        <!-- <td><?php if($DISP_LOAN_PAYABLE_ROW->status){echo $DISP_LOAN_PAYABLE_ROW->status;}else{ echo 'Not yet paid';} ?></td> -->
                                    </tr>
                                <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
	</div>







    <div class="modal fade" id="modal_loan_payable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Set Cut-off
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;
                    </span>
                    </button>
                </div>
                <form action="<?= base_url() ?>payroll/set_installment_per_cutoff" id="form_add_loan" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required " for="cutoff_period">Cut-off Period
                                    </label>
                                    <select name="cutoff_period" id="cutoff_period" class="form-control" required>
                                        <option value="">Choose...</option>
                                        <?php 
                                            if($DISP_PAYROLL_SCHED){
                                                foreach($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW){ 
                                            ?>
                                                <option value="<?= $DISP_PAYROLL_SCHED_ROW->name ?>"><?= $DISP_PAYROLL_SCHED_ROW->name?></option>
                                            <?php   
                                                } 
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="loan_payable_id" id="loan_payable_id">
                        <input type="hidden" name="empl_cmid" id="empl_cmid">
                        <input type="hidden" name="date_of_loan" id="date_of_loan">
                        <input type="hidden" name="loan_id" id="loan_id">
                        <button type="submit" class='btn btn-primary text-light' id="btn_set">Set</button>
                    </div>
                </form>
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
    <!-- SESSION MESSAGES -->
    <?php
    if ($this->session->userdata('SESS_SUCC_SET_LOAN_CUTOFF')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_SET_LOAN_CUTOFF'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_SET_LOAN_CUTOFF');
    }
    ?>


    <script>
        $(document).ready(function(){

            var empl_tbl = $('#employee_tbl').DataTable({
                "paging": false,
                "searching": false,
                "ordering": true,
                "autoWidth": false,
                "info": false
            })


            $('.loan_row').click(function(){
                var loan_payable_id = $(this).attr('loan_payable_id');
                var empl_cmid = $(this).attr('empl_cmid');
                var date_of_loan = $(this).attr('date_of_loan');
                var loan_id = $(this).attr('loan_id');
            
                $('#loan_payable_id').val(loan_payable_id);
                $('#empl_cmid').val(empl_cmid);
                $('#date_of_loan').val(date_of_loan);
                $('#loan_id').val(loan_id);
            })


        })
        
    </script>
</body>
</html>
