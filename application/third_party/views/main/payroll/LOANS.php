<style>
    .dataTables_empty{
        display: hidden !important;
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
    th,td{
    font-size: 13px !important;
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
    .page-title{
    font-weight: 600;
    color: #424F5C;
    font-size: 33px;


  }
</style>

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
    <!-- Datatables -->
    <!-- <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> -->
    <!-- Pagination -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">

	<div class="content-wrapper">
		<div class="container-fluid p-4">
            <div class="row">
                <div class = "col-md-6">
                    <h1 class="page-title">Loans<h1>
                </div>

                <div class = "col-md-6" style = "text-align: right;">
                <a class="btn btn-primary shadow-none" title="Add" href="#" data-toggle="modal" data-target="#modal_add_loan"><i class="fas fa-fw fa-plus mb-0"></i> New </a>
                    <a class="btn btn-primary shadow-none" id="btn_import" title="Add" href="<?= base_url() ?>csv/import_loans"><i class="fas fa-file-import mb-0"></i> Import   </a>
                </div>
            </div>
            <hr>

            <div class = "row mb-3">
                <div class = "col-md-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1" style = "background-color: white;"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search by name, email or phone number" id="filter_employee" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
               
            </div>
            <div class="row">
                <div class="col-md-5">
                    <label for="">Filter by Department</label>
                    <select id="filter_by_department" class="form-control">
                        <option value="">All Departments</option>
                        <?php 
                            if($DISP_DISTINCT_DEPARTMENT){
                                foreach($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW){
                                    ?>
                                        <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?>"><?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="">Filter by Section</label>
                    <select id="filter_by_section" class="form-control">
                        <option value="">All Sections</option>
                        <?php 
                            if($DISP_DISTINCT_SECTION){
                                foreach($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW){
                                    ?>
                                        <option value="<?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?>"><?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class = "card border-0 mt-2" style = "padding: 0px; margin: 0px">
                <table class = "table table-hover" id="employee_tbl">
                    <thead>
                        <tr>
                            <th>Loan ID</th>
                            <th>Loan Type</th>
                            <th>Employee Id</th>
                            <th>Full Name</th>
                            <!-- <th>Pay Terms</th> -->
                            <th>Amount</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_container">
                        <?php 
                            // if($DISP_LOAN){
                            //     foreach($DISP_LOAN as $DISP_LOAN_ROW){ 
                            //         $loan_info = $this->p080_payroll_mod->MOD_DISP_SPECIFIC_LOAN_PAYABLE($DISP_LOAN_ROW->loan_id);
                            //         if($loan_info){
                            //             //get loan data from first row
                            //             $loan_id = $loan_info[0]->loan_id;
                            //             $empl_cmid = $loan_info[0]->empl_cmid;
                            //             $loan_type = $loan_info[0]->loan_type;
                            //             $amount = $loan_info[0]->installment;
                            //             $pay_terms = $loan_info[0]->pay_terms;
                            //             $date_of_loan = $loan_info[0]->date_of_loan;

                            //             $empl_info = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE_BASED_CMID($empl_cmid);
                            //             $empl_name = '';
                            //             if($empl_info){
                            //                 if(!empty($empl_info[0]->col_midl_name)){
                            //                     $midl_ini = $empl_info[0]->col_midl_name[0].'.';
                            //                 }else{
                            //                     $midl_ini = '';
                            //                 }
                            //                 $empl_name = $empl_info[0]->col_last_name.', '.$empl_info[0]->col_frst_name.' '.$midl_ini;
                            //             }
                            //         }
                                ?>
                                    <!-- <tr class="loan_row" empl_cmid="<?= $empl_cmid ?>" date_created="<?= $date_of_loan ?>" loan_id="<?= $loan_id ?>">
                                        <td><?= $loan_id ?></td>
                                        <td><?= $loan_type ?></td>
                                        <td><?= $empl_cmid ?></td>
                                        <td><?= $empl_name ?></td>
                                        <td><?= $pay_terms ?></td>
                                        <td><?= $amount ?></td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-danger btn_delete_loans" loan_id="<?= $DISP_LOAN_ROW->loan_id ?>" empl_cmid="<?= $empl_cmid ?>" date_of_loan="<?= $date_of_loan ?>" >Delete</a>
                                        </td>
                                        
                                    </tr> -->
                                <?php
                            //     }
                            // } else { 
                                ?>
                                <!-- <tr>
                                    <td colspan=7>No Loans Yet</td>
                                </tr> -->
                        <?php //}
                        ?>
                    </tbody>
                </table>

                <ul id="btn_pagination" class="pagination mr-auto ml-auto"></ul>

            </div>
        </div>
	</div>

    <!-- Add loan modal -->
    <div class="modal fade" id="modal_add_loan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Loans
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;
                    </span>
                    </button>
                </div>
                <form action="<?php echo base_url('payroll/insert_loan'); ?>" id="form_add_loan" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required " for="employee_name">Employee Name
                                    </label>
                                    <select name="employee_cmid" id="employee_name" class="form-control" required>
                                        <option value="">Choose...</option>
                                        <?php 
                                            if($DISP_EMP_LIST){
                                                foreach($DISP_EMP_LIST as $DISP_EMP_LIST_ROW){ 
                                            ?>
                                                <option value="<?= $DISP_EMP_LIST_ROW->col_empl_cmid ?>"><?= $DISP_EMP_LIST_ROW->col_empl_cmid.' - '.$DISP_EMP_LIST_ROW->col_frst_name.' '.$DISP_EMP_LIST_ROW->col_last_name ?></option>
                                            <?php   
                                                } 
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required " for="loan_type">Loan Type
                                    </label>
                                    <select name="loan_type" id="loan_type" class="form-control" required>
                                        <option value="">Choose...</option>
                                        <option value="SSS Salary Loan">SSS Salary Loan</option>
                                        <option value="SSS Calamity Loan">SSS Calamity Loan</option>
                                        <option value="Pag-ibig Salary Loan">Pag-ibig Salary Loan</option>
                                        <option value="Pag-ibig Calamity Loan">Pag-ibig Calamity Loan</option>
                                        <option value="Emergency Loan">Emergency Loan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required " for="amount">Amount
                                    </label>
                                    <input class="form-control form-control" type="number" name="amount" id="amount" placeholder="Enter loan amount" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <!-- <div class="form-group">
                                    <label class="required " for="pay_terms">Pay Terms
                                    </label>
                                    <select name="pay_terms" id="pay_terms" class="form-control" required>
                                        <option value="">Choose...</option>
                                        <option value="6">6 months</option>
                                        <option value="12">12 months</option>
                                        <option value="24">24 months</option>
                                    </select>
                                </div> -->
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
                        <button type="submit" class='btn btn-primary text-light' id="btn_save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php 
        $page_count = $COUNT_LOAN/20;
        if(($COUNT_LOAN % 20) != 0){
            $page_count = $page_count++;
        }
    ?>

    <input type="hidden" id="row_count" value="<?= $COUNT_LOAN?>">
    <input type="hidden" id="page_count" value="<?= $page_count ?>">

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
    <!-- <script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script> -->
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
    <!-- Pagination -->
    <script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>



    <!-- SESSION MESSAGES -->
    <?php
    if ($this->session->userdata('SESS_SUCC_INSRT_LOAN')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_INSRT_LOAN'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_INSRT_LOAN');
    }
    ?>
    
    <?php
    if ($this->session->userdata('SESS_ERR_INSRT_LOAN')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_ERR_INSRT_LOAN'); ?>',
                '',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_ERR_INSRT_LOAN');
    }
    ?>
    
    <?php
    if ($this->session->userdata('success_delete_loan')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('success_delete_loan'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('success_delete_loan');
    }
    ?>

    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_CSV'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_CSV');
    }
    ?>


    <script>
        $(document).ready(function(){

            // jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            //     "formatted-num-pre": function ( a ) {
            //         a = (a === "-" || a === "") ? 0 : a.replace( /[^\d\-\.]/g, "" );
            //         return parseFloat( a );
            //     },
            
            //     "formatted-num-asc": function ( a, b ) {
            //         return a - b;
            //     },
            
            //     "formatted-num-desc": function ( a, b ) {
            //         return b - a;
            //     }
            // } );

            // var empl_tbl = $('#employee_tbl').DataTable({
            //     "paging": false,
            //     "searching": true,
            //     "ordering": true,
            //     "autoWidth": false,
            //     "info": true,
            //     columnDefs: [
            //         { type: 'formatted-num', targets: 0 }
            //     ]
            // })

            $('#employee_tbl_filter').parent().parent().hide();
            $('#employee_tbl_info').parent().parent().hide();

            var base_url = '<?= base_url() ?>';
            var url_filter_by_section = '<?= base_url() ?>payroll/get_loan_data_filter_by_sect';
            var url_get_all_empl_data = '<?= base_url() ?>payroll/get_all_employee_data';
            var url_get_loan_data = '<?= base_url() ?>payroll/get_loan_data';
            var url_all_get_loan_data = '<?= base_url() ?>payroll/get_all_loan_data';
            var url_get_employee_data = '<?= base_url() ?>payroll/get_employees_data_based_cmid';
            var url_all_get_loan_limit = '<?= base_url() ?>payroll/get_all_loan_limit';
            var url_all_get_loan_limit2 = '<?= base_url() ?>payroll/get_all_loan_limit2';
            var url_all_get_loan_limit_names = '<?= base_url() ?>payroll/get_all_loan_limit_names';


            var url_get_searched_loan = '<?= base_url() ?>payroll/get_searched_loan';
            
            $('#filter_employee').on( 'keyup', function () {
                // empl_tbl.search( this.value ).draw();
                var search_val = $(this).val();
                // console.log(search_val)
                if(search_val != ''){
                    search(search_val);
                }else{
                    reset_table()
                }
            } );

            function search(search_val){
                var url_get_searched_employee = '<?php echo base_url(); ?>payroll/get_searched_employee';
                $('#table_container').html('');
                get_searched_employee(url_get_searched_employee,search_val).then(function(data){
                    Array.from(data).forEach(function(e){
                        // var empl_image = "<?= base_url() ?>user_images/default_profile_img3.png";
                        // if(e.col_imag_path){
                        //     var empl_image = "<?= base_url() ?>user_images/"+e.col_imag_path;
                        // }
                        if(e.col_midl_name){
                            var middle = e.col_midl_name.charAt(0)+'.';
                        }
                        var fullname = e.col_last_name+', '+e.col_frst_name+' '+middle;
                        var empl_cmid = e.col_empl_cmid;
                        // console.log(fullname)
                        console.log(empl_cmid)
                        get_searched_loan(url_get_searched_loan, empl_cmid).then(function(loan_data){
                            Array.from(loan_data).forEach(function(loan){
                                var employee_cmid = loan.empl_cmid;
                                        $('#table_container').append(`
                                            <tr class="loan_row" empl_cmid="`+loan.empl_cmid+`" date_created="`+loan.date_of_loan+`" loan_id="`+loan.loan_id+`">
                                                <td>`+loan.loan_id+`</td>
                                                <td>`+loan.loan_type+`</td>
                                                <td>`+loan.empl_cmid+`</td>
                                                <td>`+fullname+`</td>
                                                <td>`+loan.installment+`</td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-danger btn_delete_loans" loan_id="`+loan.id+`" empl_cmid="`+loan.empl_cmid+`" date_of_loan="`+loan.date_of_loan+`" >Delete</a>
                                                </td>
                                            </tr>
                                        `);//<img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;

                                        $('.loan_row').click(function(){
                                            var empl_cmid = $(this).attr('empl_cmid');
                                            var date_created = $(this).attr('date_created');
                                            var loan_id = $(this).attr('loan_id');
                                            window.location.href = '<?= base_url() ?>payroll/loans_payment?id='+loan_id+"&date="+date_created+"&empl="+empl_cmid;
                                        })
                            })
                        })
                    })
                })
            }

            function reset_table(){
                $('#table_container').html('');
                var row_count = $('#row_count').val();
                var page_count = $('#page_count').val();
                var page_num = 1;
                if($('#current_page').val()){
                    var page_num = $('#current_page').val();
                }
                get_all_loan_limit2(url_all_get_loan_limit2, page_num).then(function(loan_data){
                    Array.from(loan_data).forEach(function(loan){
                        var employee_cmid = loan.empl_cmid;
                        get_all_loan_limit_names(url_all_get_loan_limit_names, employee_cmid).then(function(names){
                            Array.from(names).forEach(function(names){
                                if(names.col_midl_name){
                                    var middle = names.col_midl_name.charAt(0)+'.';
                                }
                                var fullname = names.col_last_name+', '+names.col_frst_name+' '+middle;
                                $('#table_container').append(`
                                    <tr class="loan_row" empl_cmid="`+loan.empl_cmid+`" date_created="`+loan.date_of_loan+`" loan_id="`+loan.loan_id+`">
                                        <td>`+loan.loan_id+`</td>
                                        <td>`+loan.loan_type+`</td>
                                        <td>`+loan.empl_cmid+`</td>
                                        <td>`+fullname+`</td>
                                        <td>`+loan.installment+`</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-danger btn_delete_loans" loan_id="`+loan.id+`" empl_cmid="`+loan.empl_cmid+`" date_of_loan="`+loan.date_of_loan+`" >Delete</a>
                                        </td>
                                    </tr>
                                `);//<img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;

                                $('.loan_row').click(function(){
                                    var empl_cmid = $(this).attr('empl_cmid');
                                    var date_created = $(this).attr('date_created');
                                    var loan_id = $(this).attr('loan_id');
                                    window.location.href = '<?= base_url() ?>payroll/loans_payment?id='+loan_id+"&date="+date_created+"&empl="+empl_cmid;
                                })
                            })
                        })
                    })
                })
            }

            async function get_searched_employee(url,cmid){
                var formData = new FormData();
                formData.append('search', cmid);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }

            async function get_searched_loan(url,cmid){
                var formData = new FormData();
                formData.append('cmid', cmid);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }

            async function get_all_loan_limit2(url,page_num){
            var formData = new FormData();
            formData.append('page_num', page_num);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            // ======================= FILTER BY SECTION ================================
            $('#filter_by_section').change(function(){
            var section = $(this).val();
                if(section){
                    $('#table_container').html('');
                    get_all_loan_data(url_all_get_loan_data).then(function(loan_data){
                        console.log(loan_data);
                        if(loan_data){
                            Array.from(loan_data).forEach(function(loan){
                                var empl_cmid = loan.empl_cmid;
                                get_employee_data_filter_by_sect(url_filter_by_section, section, empl_cmid).then(function(data1){
                                    Array.from(data1).forEach(function(x){
                                        var user_image = '';
                                        if(x.col_imag_path){
                                            user_image = base_url+'user_images/'+x.col_imag_path;
                                        } else {
                                            user_image = base_url+'user_images/default_profile_img3.png';
                                        }
                                        var fullname = '';
                                        if((x.col_frst_name) && (x.col_last_name)){
                                            if(x.col_midl_name){
                                                var middlename = capitalizeFirstLetter(x.col_midl_name);
                                                fullname = x.col_last_name+', '+x.col_frst_name+' '+middlename+'.';
                                            } else {
                                                fullname = x.col_last_name+', '+x.col_frst_name;
                                            }
                                            
                                        }
                                        var employee_id = x.id;
                                        var pad_id = loan.empl_cmid;
                                        var loan_id = pad_id.padStart(5, '0');
                                        
                                        // $('#table_container').append(`
                                        //     <tr class="loan_row" empl_cmid="`+loan.empl_cmid+`" date_created="`+loan.date_created+`" loan_id="`+loan.id+`">
                                        //         <td>`+loan_id+`</td>
                                        //         <td>`+loan.loan_type+`</td>
                                        //         <td>`+loan.empl_cmid+`</td>
                                        //         <td><a href = "<?=base_url()?>employees/personal?id=`+employee_id+`">
                                        //             <img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;`+fullname+`</a>
                                        //         </td>
                                        //         <td>`+loan.pay_terms+` months</td>
                                        //         <td>`+loan.amount+`</td>
                                        //         <td></td>
                                                
                                        //     </tr>
                                        // `);

                                        $('#table_container').append(`
                                            <tr class="loan_row" empl_cmid="`+loan.empl_cmid+`" date_created="`+loan.date_created+`" loan_id="`+loan.id+`">
                                                <td>`+loan_id+`</td>
                                                <td>`+loan.loan_type+`</td>
                                                <td>`+loan.empl_cmid+`</td>
                                                <td><a href = "<?=base_url()?>employees/personal?id=`+employee_id+`">
                                                    <img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;`+fullname+`</a>
                                                </td>
                                                <td>`+loan.amount+`</td>
                                                <td></td>
                                                
                                            </tr>
                                        `);

                                        $('.loan_row').click(function(){
                                            var empl_cmid = $(this).attr('empl_cmid');
                                            var date_created = $(this).attr('date_created');
                                            var loan_id = $(this).attr('loan_id');
                                            window.location.href = '<?= base_url() ?>payroll/loans_payment?id='+loan_id+"&date"+date_created+"&empl"+empl_cmid;
                                        })
                                    })
                                })
                            })
                        }
                    })
                } else {
                    $('#table_container').html('');
                    get_all_loan_data(url_all_get_loan_data).then(function(loan_data){
                        console.log(loan_data);
                        if(loan_data){
                            Array.from(loan_data).forEach(function(loan){
                                var employee_cmid = loan.empl_cmid;
                                get_employees_data_based_cmid(url_get_employee_data,employee_cmid).then(function(data1){
                                    Array.from(data1).forEach(function(x){
                                        var user_image = '';
                                        if(x.col_imag_path){
                                            user_image = base_url+'user_images/'+x.col_imag_path;
                                        } else {
                                            user_image = base_url+'user_images/default_profile_img3.png';
                                        }
                                        var fullname = '';
                                        if((x.col_frst_name) && (x.col_last_name)){
                                            if(x.col_midl_name){
                                                var middlename = capitalizeFirstLetter(x.col_midl_name);
                                                fullname = x.col_last_name+', '+x.col_frst_name+' '+middlename+'.';
                                            } else {
                                                fullname = x.col_last_name+', '+x.col_frst_name;
                                            }
                                            
                                        }
                                        var employee_id = x.id;
                                        var pad_id = loan.empl_cmid;
                                        var loan_id = pad_id.padStart(5, '0');

                                        $('#table_container').append(`
                                            <tr class="loan_row" empl_cmid="`+loan.empl_cmid+`" date_created="`+loan.date_created+`" loan_id="`+loan.id+`">
                                                <td>`+loan_id+`</td>
                                                <td>`+loan.loan_type+`</td>
                                                <td>`+loan.empl_cmid+`</td>
                                                <td><a href = "<?=base_url()?>employees/personal?id=`+employee_id+`">
                                                    <img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;`+fullname+`</a>
                                                </td>
                                                <td>`+loan.amount+`</td>
                                                <td></td>
                                            </tr>
                                        `);
                                        // $('#table_container').append(`
                                        //     <tr class="loan_row" empl_cmid="`+loan.empl_cmid+`" date_created="`+loan.date_created+`" loan_id="`+loan.id+`">
                                        //         <td>`+loan_id+`</td>
                                        //         <td>`+loan.loan_type+`</td>
                                        //         <td>`+loan.empl_cmid+`</td>
                                        //         <td><a href = "<?=base_url()?>employees/personal?id=`+employee_id+`">
                                        //             <img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;`+fullname+`</a>
                                        //         </td>
                                        //         <td>`+loan.pay_terms+` months</td>
                                        //         <td>`+loan.amount+`</td>
                                        //         <td></td>
                                        //     </tr>
                                        // `);

                                        $('.loan_row').click(function(){
                                            var empl_cmid = $(this).attr('empl_cmid');
                                            var date_created = $(this).attr('date_created');
                                            var loan_id = $(this).attr('loan_id');
                                            window.location.href = '<?= base_url() ?>payroll/loans_payment?id='+loan_id+"&date"+date_created+"&empl"+empl_cmid;
                                        })
                                    })
                                })
                            })
                        }
                    })
                }
            })











            // ======================= FILTER BY DEPARTMENT ================================
            var url_filter_by_dept = '<?= base_url() ?>payroll/get_loan_data_filter_by_dept';
            $('#filter_by_department').change(function(){
            var department = $(this).val();
                if(department){
                    $('#table_container').html('');
                    get_all_loan_data(url_all_get_loan_data).then(function(loan_data){
                        console.log(loan_data);
                        if(loan_data){
                            Array.from(loan_data).forEach(function(loan){
                                var empl_cmid = loan.empl_cmid;
                                get_loan_data_filter_by_dept(url_filter_by_dept, department, empl_cmid).then(function(data1){
                                    Array.from(data1).forEach(function(x){
                                        var user_image = '';
                                        if(x.col_imag_path){
                                            user_image = base_url+'user_images/'+x.col_imag_path;
                                        } else {
                                            user_image = base_url+'user_images/default_profile_img3.png';
                                        }
                                        var fullname = '';
                                        if((x.col_frst_name) && (x.col_last_name)){
                                            if(x.col_midl_name){
                                                var middlename = capitalizeFirstLetter(x.col_midl_name);
                                                fullname = x.col_last_name+', '+x.col_frst_name+' '+middlename+'.';
                                            } else {
                                                fullname = x.col_last_name+', '+x.col_frst_name;
                                            }
                                
                                        }
                                        var employee_id = x.id;
                                        var pad_id = loan.empl_cmid;
                                        var loan_id = pad_id.padStart(5, '0');

                                        $('#table_container').append(`
                                            <tr class="loan_row" empl_cmid="`+loan.empl_cmid+`" date_created="`+loan.date_created+`" loan_id="`+loan.id+`">
                                                <td>`+loan_id+`</td>
                                                <td>`+loan.loan_type+`</td>
                                                <td>`+loan.empl_cmid+`</td>
                                                <td><a href = "<?=base_url()?>employees/personal?id=`+employee_id+`">
                                                    <img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;`+fullname+`</a>
                                                </td>
                                                <td>`+loan.amount+`</td>
                                                <td></td>
                                            </tr>
                                        `);
                                        // $('#table_container').append(`
                                        //     <tr class="loan_row" empl_cmid="`+loan.empl_cmid+`" date_created="`+loan.date_created+`" loan_id="`+loan.id+`">
                                        //         <td>`+loan_id+`</td>
                                        //         <td>`+loan.loan_type+`</td>
                                        //         <td>`+loan.empl_cmid+`</td>
                                        //         <td><a href = "<?=base_url()?>employees/personal?id=`+employee_id+`">
                                        //             <img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;`+fullname+`</a>
                                        //         </td>
                                        //         <td>`+loan.pay_terms+` months</td>
                                        //         <td>`+loan.amount+`</td>
                                        //         <td></td>
                                        //     </tr>
                                        // `);

                                        $('.loan_row').click(function(){
                                            var empl_cmid = $(this).attr('empl_cmid');
                                            var date_created = $(this).attr('date_created');
                                            var loan_id = $(this).attr('loan_id');
                                            window.location.href = '<?= base_url() ?>payroll/loans_payment?id='+loan_id+"&date"+date_created+"&empl"+empl_cmid;
                                        })
                                    })
                                })
                            })
                        }
                    })
                } else {
                    $('#table_container').html('');
                    get_all_loan_data(url_all_get_loan_data).then(function(loan_data){
                        console.log(loan_data);
                        if(loan_data){
                            Array.from(loan_data).forEach(function(loan){
                                var employee_cmid = loan.empl_cmid;
                                get_employees_data_based_cmid(url_get_employee_data,employee_cmid).then(function(data1){
                                    Array.from(data1).forEach(function(x){
                                        var user_image = '';
                                        if(x.col_imag_path){
                                            user_image = base_url+'user_images/'+x.col_imag_path;
                                        } else {
                                            user_image = base_url+'user_images/default_profile_img3.png';
                                        }
                                        var fullname = '';
                                        if((x.col_frst_name) && (x.col_last_name)){
                                            if(x.col_midl_name){
                                                var middlename = capitalizeFirstLetter(x.col_midl_name);
                                                fullname = x.col_last_name+', '+x.col_frst_name+' '+middlename+'.';
                                            } else {
                                                fullname = x.col_last_name+', '+x.col_frst_name;
                                            }
                                            
                                        }
                                        var employee_id = x.id;
                                        var pad_id = loan.empl_cmid;
                                        var loan_id = pad_id.padStart(5, '0');

                                        $('#table_container').append(`
                                            <tr class="loan_row" empl_cmid="`+loan.empl_cmid+`" date_created="`+loan.date_created+`" loan_id="`+loan.id+`">
                                                <td>`+loan_id+`</td>
                                                <td>`+loan.loan_type+`</td>
                                                <td>`+loan.empl_cmid+`</td>
                                                <td><a href = "<?=base_url()?>employees/personal?id=`+employee_id+`">
                                                    <img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;`+fullname+`</a>
                                                </td>
                                                <td>`+loan.amount+`</td>
                                                <td></td>
                                            </tr>
                                        `);
                                        // $('#table_container').append(`
                                        //     <tr class="loan_row" empl_cmid="`+loan.empl_cmid+`" date_created="`+loan.date_created+`" loan_id="`+loan.id+`">
                                        //         <td>`+loan_id+`</td>
                                        //         <td>`+loan.loan_type+`</td>
                                        //         <td>`+loan.empl_cmid+`</td>
                                        //         <td><a href = "<?=base_url()?>employees/personal?id=`+employee_id+`">
                                        //             <img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;`+fullname+`</a>
                                        //         </td>
                                        //         <td>`+loan.pay_terms+` months</td>
                                        //         <td>`+loan.amount+`</td>
                                        //         <td></td>
                                        //     </tr>
                                        // `);

                                        $('.loan_row').click(function(){
                                            var empl_cmid = $(this).attr('empl_cmid');
                                            var date_created = $(this).attr('date_created');
                                            var loan_id = $(this).attr('loan_id');
                                            window.location.href = '<?= base_url() ?>payroll/loans_payment?id='+loan_id+"&date"+date_created+"&empl"+empl_cmid;
                                        })
                                    })
                                })
                            })
                        }
                    })
                }
            })














            

            $('.loan_row').click(function(){
                var empl_cmid = $(this).attr('empl_cmid');
                var date_created = $(this).attr('date_created');
                var loan_id = $(this).attr('loan_id');
                window.location.href = '<?= base_url() ?>payroll/loans_payment?id='+loan_id+"&date="+date_created+"&empl="+empl_cmid;
            })






            $('.btn_delete_loans').click(function(e){
                e.stopPropagation();
                var loan_id = $(this).attr('loan_id');
                var empl_cmid = $(this).attr('empl_cmid');
                var date_of_loan = $(this).attr('date_of_loan');

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
                    window.location.href = "<?= base_url(); ?>payroll/delete_loan_data?loan_id="+loan_id+"&empl_cmid="+empl_cmid+"&date_of_loan="+date_of_loan;
                    }
                })
            })



            $('#btn_pagination').pagination();
        
            var row_count = $('#row_count').val();
            var page_count = $('#page_count').val();
    
            // console.log(row_count);
            // console.log(page_count);
    
            $('#btn_pagination').pagination({
    
                // the number of entries
                total: row_count,
    
                // current page
                current: 1, 
    
                // the number of entires per page
                length: page_count, 
    
                // pagination size
                size: 2,
    
                // Prev/Next text
                prev: "&lt;",
                next: "&gt;",
    
                // fired on each click
                click: function (e) {
                
                    var row_count = $('#row_count').val();
                    var page_count = $('#page_count').val();
                    // console.log(e.current);
                    var page_num = e.current;
                    $('#current_page').val(page_num);
                    
                    $('#table_container').html('');
                    get_all_loan_limit2(url_all_get_loan_limit2, page_num).then(function(loan_data){
                        Array.from(loan_data).forEach(function(loan){
                            var employee_cmid = loan.empl_cmid;
                            get_all_loan_limit_names(url_all_get_loan_limit_names, employee_cmid).then(function(names){
                                Array.from(names).forEach(function(names){
                                    if(names.col_midl_name){
                                        var middle = names.col_midl_name.charAt(0)+'.';
                                    }
                                    var fullname = names.col_last_name+', '+names.col_frst_name+' '+middle;
                                    $('#table_container').append(`
                                        <tr class="loan_row" empl_cmid="`+loan.empl_cmid+`" date_created="`+loan.date_of_loan+`" loan_id="`+loan.loan_id+`">
                                            <td>`+loan.loan_id+`</td>
                                            <td>`+loan.loan_type+`</td>
                                            <td>`+loan.empl_cmid+`</td>
                                            <td>`+fullname+`</td>
                                            <td>`+loan.installment+`</td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-danger btn_delete_loans" loan_id="`+loan.id+`" empl_cmid="`+loan.empl_cmid+`" date_of_loan="`+loan.date_of_loan+`" >Delete</a>
                                            </td>
                                        </tr>
                                    `);//<img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;

                                    $('.loan_row').click(function(){
                                        var empl_cmid = $(this).attr('empl_cmid');
                                        var date_created = $(this).attr('date_created');
                                        var loan_id = $(this).attr('loan_id');
                                        window.location.href = '<?= base_url() ?>payroll/loans_payment?id='+loan_id+"&date="+date_created+"&empl="+empl_cmid;
                                    })
                                })
                            })
                        })
                    })
                }
            });


            get_all_loan_limit(url_all_get_loan_limit).then(function(loan_data){
                // console.log(loan_data);
                Array.from(loan_data).forEach(function(loan){
                    var employee_cmid = loan.empl_cmid;
                    get_all_loan_limit_names(url_all_get_loan_limit_names, employee_cmid).then(function(names){
                        Array.from(names).forEach(function(names){
                            if(names.col_midl_name){
                                var middle = names.col_midl_name.charAt(0)+'.';
                            }
                            var fullname = names.col_last_name+', '+names.col_frst_name+' '+middle;
                            $('#table_container').append(`
                                <tr class="loan_row" empl_cmid="`+loan.empl_cmid+`" date_created="`+loan.date_of_loan+`" loan_id="`+loan.loan_id+`">
                                    <td>`+loan.loan_id+`</td>
                                    <td>`+loan.loan_type+`</td>
                                    <td>`+loan.empl_cmid+`</td>
                                    <td>`+fullname+`</td>
                                    <td>`+loan.installment+`</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-danger btn_delete_loans" loan_id="`+loan.id+`" empl_cmid="`+loan.empl_cmid+`" date_of_loan="`+loan.date_of_loan+`" >Delete</a>
                                    </td>
                                </tr>
                            `);//<img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;

                            $('.loan_row').click(function(){
                                var empl_cmid = $(this).attr('empl_cmid');
                                var date_created = $(this).attr('date_created');
                                var loan_id = $(this).attr('loan_id');
                                window.location.href = '<?= base_url() ?>payroll/loans_payment?id='+loan_id+"&date="+date_created+"&empl="+empl_cmid;
                            })
                        })
                    })
                })
            })



            async function get_all_loan_limit_names(url, id){
            var formData = new FormData();
            formData.append('empid', id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_all_loan_limit(url){
            var formData = new FormData();
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_all_loan_limit2(url,page_num){
            var formData = new FormData();
            formData.append('page_num', page_num);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }


            async function get_all_loan_data(url){
            var formData = new FormData();
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_loan_data(url, employee_cmid){
            var formData = new FormData();
            formData.append('employee_cmid', employee_cmid);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_employees_data_based_cmid(url, employee_cmid){
            var formData = new FormData();
            formData.append('employee_cmid', employee_cmid);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_employee_data_filter_by_sect(url, section, empl_cmid){
            var formData = new FormData();
            formData.append('section', section);
            formData.append('empl_cmid', empl_cmid);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_loan_data_filter_by_dept(url, department, empl_cmid){
            var formData = new FormData();
            formData.append('department', department);
            formData.append('empl_cmid', empl_cmid);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_all_employee_data(url){
            var formData = new FormData();
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
