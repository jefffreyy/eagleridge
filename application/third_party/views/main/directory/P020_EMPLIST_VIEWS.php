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
    .page-title{
    font-weight: 600;
    color: #424F5C;
    font-size: 33px;
  }
  th,td{
    font-size: 13px !important;
  }
    .col-xs-15,
    .col-sm-15,
    .col-md-15,
    .col-lg-15 {
        position: relative;
        min-height: 1px;
        padding-right: 10px;
        padding-left: 10px;
        width: 100%;
    }
    @media (min-width: 768px) {
    .col-sm-15 {
            width: 20%;
            float: left;
        }
    }
    @media (min-width: 992px) {
        .col-lg-15 {
            width: 50%;
            float: left;
        }
    }
    @media (min-width: 1300px) {
        .col-lg-15 {
            width: 20%;
            float: left;
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
    <!-- Pagination -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">

	<div class="content-wrapper">
		<div class="container-fluid p-4">
            <div class="row">
                <div class = "col-md-6">
                    <h1 class="page-title">Employee List</h1>
                </div>
                <div class = "col-md-6" style = "text-align: right;">
                        <a href = "<?=base_url()?>employees/new_employee" type ="button" class = "btn btn-primary shadow-none"><i class="fas fa-plus"></i> Add Employee</a>
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

            
            <div class = "row mt-4">
                <div class = "col-12">
                    <div class = "card p-2" style = "background-color: #00897b; color: white;">
                        <div style = "padding: 10px 1px;" class="text-center">
                            <text style = "font-size: 20px; margin-bottom: -15px;" id="total_employees">
                                <?= $DISP_ROW_COUNT ?>
                            </text><br>
                            <text><b>Total Employees </b></text>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mt-4">
                <div class="col-md-2">
                    <label for="">Filter by Department</label>
                    <select id="filter_by_department" class="form-control">
                        <?php 
                            if($DISP_DISTINCT_DEPARTMENT){
                                ?>
                                <option value="" <?php foreach($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW_1){ if($DISP_DISTINCT_DEPARTMENT_ROW_1->col_empl_dept == ''){echo 'selected';} } ?>>All Departments</option>
                                <?php
                                foreach($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW){
                                    if($DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept != ''){
                                        ?>
                                            <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?>"><?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?></option>
                                        <?php
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="">Filter by Section</label>
                    <select id="filter_by_section" class="form-control">
                        <?php 
                            if($DISP_DISTINCT_SECTION){
                                ?>
                                <option value="" <?php foreach($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW_1){ if($DISP_DISTINCT_SECTION_ROW_1->col_empl_sect == ''){echo 'selected';} } ?>>All Sections</option>
                                <?php
                                foreach($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW){
                                    if($DISP_DISTINCT_SECTION_ROW->col_empl_sect != ''){
                                        ?>
                                            <option value="<?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?>"><?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?></option>
                                        <?php
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="">Filter by Group</label>
                    <select id="filter_by_group" class="form-control">
                        <?php 
                            if($DISP_Group){
                                ?>
                                <option value="" <?php foreach($DISP_Group as $DISP_Group_ROW_1){ if($DISP_Group_ROW_1->col_empl_group == ''){echo 'selected';} } ?>>All Groups</option>
                                <?php
                                foreach($DISP_Group as $DISP_Group_ROW){
                                    if($DISP_Group_ROW->col_empl_group != ''){
                                        ?>
                                            <option value="<?= $DISP_Group_ROW->col_empl_group ?>"><?= $DISP_Group_ROW->col_empl_group ?></option>
                                        <?php
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="">Filter by Line</label>
                    <select id="filter_by_line" class="form-control">
                        <option value="">All Lines</option>
                        <?php 
                            if($DISP_Line){
                                ?>
                                <option value="" <?php foreach($DISP_Line as $DISP_Line_ROW_1){ if($DISP_Line_ROW_1->col_empl_line == ''){echo 'selected';} } ?>>All Lines</option>
                                <?php
                                foreach($DISP_Line as $DISP_Line_ROW){
                                    if($DISP_Line_ROW->col_empl_line != ''){
                                        ?>
                                            <option value="<?= $DISP_Line_ROW->col_empl_line ?>"><?= $DISP_Line_ROW->col_empl_line ?></option>
                                        <?php
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="">Filter by Status</label>
                    <select id="filter_by_status" class="form-control">
                        <option value="0">Active</option>
                        <option value="1">Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <br>
                    <a href="#" id="btn_clear_filter" class="btn btn-primary float-right">Clear Filter</a>
                </div>
            </div>

            <div class = "card border-0 mt-4" style = "padding: 0px; margin: 0px">
                <table class = "table table-hover" id="employee_tbl">
                    <thead>
                        <tr>
                            <th>Employee Id</th>
                            <th>Full Name</th>
                            <th>Employment Type</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Section</th>
                            <th>Group</th>
                            <th>Line</th>
                        </tr>
                    </thead>
                    <tbody id="table_container">
                        <?php 
                            if($DISP_EMP_LIST){
                                foreach($DISP_EMP_LIST as $DISP_EMP_LIST_ROW){ 
                                    if(!empty($DISP_EMP_LIST_ROW->col_midl_name)){
                                        $midl_ini = $DISP_EMP_LIST_ROW->col_midl_name[0].'.';
                                    }else{
                                        $midl_ini = '';
                                    }?>
                                    <tr>
                                        <td><?= $DISP_EMP_LIST_ROW->col_empl_cmid ?></td>
                                        <td><a href = "<?=base_url()?>employees/personal?id=<?= $DISP_EMP_LIST_ROW->id ?>">
                                            <img class="rounded-circle avatar " width="35" height="35" src="<?php if($DISP_EMP_LIST_ROW->col_imag_path){echo base_url().'user_images/'.$DISP_EMP_LIST_ROW->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $DISP_EMP_LIST_ROW->col_last_name.', '.$DISP_EMP_LIST_ROW->col_frst_name.' '.$midl_ini?></a>
                                        </td>
                                        <td><?= $DISP_EMP_LIST_ROW->col_empl_type ?></td>
                                        <td><?= $DISP_EMP_LIST_ROW->col_empl_posi ?></td>
                                        <td><?= $DISP_EMP_LIST_ROW->col_empl_dept ?></td>
                                        <td><?= $DISP_EMP_LIST_ROW->col_empl_sect ?></td>
                                        <td><?= $DISP_EMP_LIST_ROW->col_empl_group ?></td>
                                        <td><?= $DISP_EMP_LIST_ROW->col_empl_line ?></td>
                                    </tr>
                        <?php
                                    
                                }
                            } else { ?>
                                <tr>
                                    <td colspan=6>No Employee Yet</td>
                                </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
                    <center><ul id="btn_pagination" class="pagination mr-auto ml-auto"></ul></center>
                <div class="w-100 text-center">
                    <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
                </div>
            </div>
        </div>
	</div>

	<aside class="control-sidebar control-sidebar-dark"></aside>

    <!-- Resign/Terminate Employee Modal -->
    <div class="modal fade" id="modal_show_termination_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Termination Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <p class="mb-0" id="termination_date"></p>
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <p class="mb-0" id="termination_type"></p>
                            </div>
                            <div class="form-group">
                                <label>Reason</label>
                                <p class="mb-0" id="termination_reason"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class='btn btn-primary text-light' data-dismiss="modal" aria-label="Close">&nbsp; Remove</button>
                </div>
            </div>
        </div>
    </div>



    <?php 
        $page_count = $DISP_ROW_COUNT/20;
        
        if(($DISP_ROW_COUNT % 20) != 0){
            $page_count = $page_count++;
        }

        $page_count = ceil($page_count);
    ?>

    <input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT ?>">
    <input type="hidden" id="page_count" value="<?= $page_count ?>">
    <input type="hidden" id="current_page" value="">

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
    <!-- Pagination -->
    <script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>
    <?php
    if($this->session->userdata('SESS_SUCC_INSRT')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_INSRT'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_INSRT');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_ERR_IMAGE')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_ERR_IMAGE'); ?>',
            '',
            'warning'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_ERR_IMAGE');
    }
    ?>
    <!-- SESSION MESSAGES -->
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

    
    <?php
    if ($this->session->userdata('SESS_WARN_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_WARN_MSG_INSRT_CSV'); ?>',
                '',
                'warning'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_WARN_MSG_INSRT_CSV');
    }
    ?>

    <?php
    if ($this->session->userdata('SESS_ERR_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_CSV'); ?>',
                '',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_ERR_MSG_INSRT_CSV');
    }
    ?>






















    <script>
        $(document).ready(function(){

            var base_url = '<?= base_url() ?>';
            var department;
            var section;
            var group;
            var line;
            var status;

            var department_arr;
            var section_arr;
            var group_arr;
            var line_arr;

            var url_get_filter_data = '<?= base_url() ?>employees/get_filter_data';
            var url_get_filter_data_department = '<?= base_url() ?>employees/get_filter_data_department';
            var url_get_filter_data_section = '<?= base_url() ?>employees/get_filter_data_section';
            var url_get_filter_data_group = '<?= base_url() ?>employees/get_filter_data_group';
            var url_get_filter_data_line = '<?= base_url() ?>employees/get_filter_data_line';
            var url_get_all_filter_data = '<?= base_url() ?>employees/get_all_filter_data';

            var url_filter_by_department = '<?= base_url() ?>attendance/get_employee_data_filter_by_dept';
            var url_filter_section_by_department = '<?= base_url() ?>attendance/get_employee_section_data_filter_by_dept';
            var url_filter_by_section = '<?= base_url() ?>attendance/get_employee_data_filter_by_sect';
            var url_get_all_empl_data = '<?= base_url() ?>employees/get_all_employee_data';
            var url_filter_by_group = '<?= base_url() ?>attendance/get_employee_data_filter_by_group';
            var url_filter_by_line = '<?= base_url() ?>attendance/get_employee_data_filter_by_line';
            var url_filter_by_status = '<?= base_url() ?>attendance/get_employee_data_filter_by_status';
            var url_get_employee = '<?php echo base_url(); ?>employees/get_all_employee';

            jQuery.extend( jQuery.fn.dataTableExt.oSort, {
                "formatted-num-pre": function ( a ) {
                    a = (a === "-" || a === "") ? 0 : a.replace( /[^\d\-\.]/g, "" );
                    return parseFloat( a );
                },
            
                "formatted-num-asc": function ( a, b ) {
                    return a - b;
                },
            
                "formatted-num-desc": function ( a, b ) {
                    return b - a;
                }
            } );

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

            $('#filter_employee').on( 'keyup', function () {
                // empl_tbl.search( this.value ).draw();
                var search_val = $(this).val();
                console.log(search_val)
                if(search_val != ''){
                    search(search_val);
                }else{
                    reset_table()
                }
            } );


            function search(search_val){
                var url_get_searched_employee = '<?php echo base_url(); ?>employees/get_searched_employee';
                $('#table_container').html('');
                get_searched_employee(url_get_searched_employee,search_val).then(function(data){
                    Array.from(data).forEach(function(e){
                        console.log(e)
                        var empl_image = "<?= base_url() ?>user_images/default_profile_img3.png";
                        if(e.col_imag_path){
                            var empl_image = "<?= base_url() ?>user_images/"+e.col_imag_path;
                        }

                        if(e.col_midl_name){
                            var midl_ini = e.col_midl_name + '.';
                        }else{
                            var midl_ini = '';
                        }
                        
                        var empl_name = e.col_last_name + ', ' + e.col_frst_name + ' ' + midl_ini;

                        $('#table_container').append(`
                            <tr class="bank_row" data-toggle="modal" data-target="#modal_edit_bank" empl_cmid="`+e.col_empl_cmid+`">
                                <td>`+e.col_empl_cmid+`</td>
                                <td>
                                    <a href = "<?=base_url()?>employees/personal?id=`+e.id+`">
                                        <img class="rounded-circle avatar " width="35" height="35" src="`+empl_image+`">&nbsp;&nbsp;`+empl_name+`
                                    </a>
                                </td>
                                <td>`+e.col_empl_type+`</td>
                                <td>`+e.col_empl_posi+`</td>
                                <td>`+e.col_empl_dept+`</td>
                                <td>`+e.col_empl_sect+`</td>
                                <td>`+e.col_empl_group+`</td>
                                <td>`+e.col_empl_line+`</td>
                            </tr>
                        `)
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
                get_employee(url_get_employee,page_num).then(function(data){
                    Array.from(data).forEach(function(e){
                        console.log(e)
                        var empl_image = "<?= base_url() ?>user_images/default_profile_img3.png";
                        if(e.col_imag_path){
                            var empl_image = "<?= base_url() ?>user_images/"+e.col_imag_path;
                        }

                        if(e.col_midl_name){
                            var midl_ini = e.col_midl_name + '.';
                        }else{
                            var midl_ini = '';
                        }
                        
                        var empl_name = e.col_last_name + ', ' + e.col_frst_name + ' ' + midl_ini;

                        $('#table_container').append(`
                            <tr class="bank_row" data-toggle="modal" data-target="#modal_edit_bank" empl_cmid="`+e.col_empl_cmid+`">
                                <td>`+e.col_empl_cmid+`</td>
                                <td>
                                    <a href = "<?=base_url()?>employees/personal?id=`+e.id+`">
                                        <img class="rounded-circle avatar " width="35" height="35" src="`+empl_image+`">&nbsp;&nbsp;`+empl_name+`
                                    </a>
                                </td>
                                <td>`+e.col_empl_type+`</td>
                                <td>`+e.col_empl_posi+`</td>
                                <td>`+e.col_empl_dept+`</td>
                                <td>`+e.col_empl_sect+`</td>
                                <td>`+e.col_empl_group+`</td>
                                <td>`+e.col_empl_line+`</td>
                            </tr>
                        `)
                    })
                })
            }

            async function get_searched_employee(url,search){
                var formData = new FormData();
                formData.append('search', search);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }





            function display_filtered_empl(department, section, line, group, status){
                $('#loader_gif').show();

                // change employee dropdown
                $('#table_container').html('');

                get_filter_data(url_get_filter_data, department, line, group, section, status).then(function(data){
                    
                    if(data.length > 0){
                        Array.from(data).forEach(function(x){
                            var user_image = '';
                            if(x.col_imag_path){
                                user_image = base_url+'user_images/'+x.col_imag_path;
                            } else {
                                user_image = base_url+'user_images/default_profile_img3.png';
                            }

                            var fullname = '';
                            if((x.col_frst_name) && (x.col_last_name)){
                                if(x.col_midl_name){
                                    fullname = x.col_last_name+', '+x.col_frst_name+' '+x.col_midl_name[0]+'.';
                                } else {
                                    fullname = x.col_last_name+', '+x.col_frst_name;
                                }
                            
                            }

                            $('#loader_gif').hide();

                            $('#table_container').append(`
                                <tr>
                                    <td>`+x.col_empl_cmid+`</td>
                                    <td><a href = "<?=base_url()?>employees/personal?id=`+x.id+`">
                                        <img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;`+fullname+`</a>
                                    </td>
                                    <td>`+x.col_empl_type+`</td>
                                    <td>`+x.col_empl_posi+`</td>
                                    <td>`+x.col_empl_dept+`</td>
                                    <td>`+x.col_empl_sect+`</td>
                                    <td>`+x.col_empl_group+`</td>
                                    <td>`+x.col_empl_line+`</td>
                                </tr>
                            `);
                        })
                    } else {
                        $('#loader_gif').hide();

                        $('#table_container').append(`
                                <td colspan="7">No Employees Detected</td>
                        `);
                    }

                    $('#total_employees').text($('#table_container tr').length);
                }) 
            }
            
            
            
            function display_filtered_empl_status(department, section, line, group, status){
                $('#loader_gif').show();

                // change employee dropdown
                $('#table_container').html('');

                if(status == 0){
                    get_filter_data(url_get_filter_data, department, line, group, section, status).then(function(data){
                        if(data.length > 0){
                            Array.from(data).forEach(function(x){
                                var user_image = '';
                                if(x.col_imag_path){
                                    user_image = base_url+'user_images/'+x.col_imag_path;
                                } else {
                                    user_image = base_url+'user_images/default_profile_img3.png';
                                }

                                var fullname = '';
                                if((x.col_frst_name) && (x.col_last_name)){
                                    if(x.col_midl_name){
                                        fullname = x.col_last_name+', '+x.col_frst_name+' '+x.col_midl_name[0]+'.';
                                    } else {
                                        fullname = x.col_last_name+', '+x.col_frst_name;
                                    }
                            
                                }

                                $('#loader_gif').hide();

                                $('#table_container').append(`
                                    <tr>
                                        <td>`+x.col_empl_cmid+`</td>
                                        <td><a href = "<?=base_url()?>employees/personal?id=`+x.id+`">
                                            <img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;`+fullname+`</a>
                                        </td>
                                        <td>`+x.col_empl_type+`</td>
                                        <td>`+x.col_empl_posi+`</td>
                                        <td>`+x.col_empl_dept+`</td>
                                        <td>`+x.col_empl_sect+`</td>
                                        <td>`+x.col_empl_group+`</td>
                                        <td>`+x.col_empl_line+`</td>
                                    </tr>
                                `);
                            })
                        } else {
                            $('#loader_gif').hide();

                            $('#table_container').append(`
                                    <td colspan="7">No Employees Detected</td>
                            `);
                        }

                        $('#total_employees').text($('#table_container tr').length);
                    }) 
                } else {
                    get_filter_data(url_get_filter_data, department, line, group, section, status).then(function(data){
                        if(data.length > 0){
                            Array.from(data).forEach(function(x){
                                var user_image = '';
                                if(x.col_imag_path){
                                    user_image = base_url+'user_images/'+x.col_imag_path;
                                } else {
                                    user_image = base_url+'user_images/default_profile_img3.png';
                                }

                                var fullname = '';
                                if((x.col_frst_name) && (x.col_last_name)){
                                    if(x.col_midl_name){
                                        fullname = x.col_last_name+', '+x.col_frst_name+' '+x.col_midl_name[0]+'.';
                                    } else {
                                        fullname = x.col_last_name+', '+x.col_frst_name;
                                    }
                            
                                }

                                $('#loader_gif').hide();

                                $('#table_container').append(`
                                    <tr data-toggle="modal" data-target="#modal_show_termination_details" style="cursor:pointer">
                                        <td>`+x.col_empl_cmid+`</td>
                                        <td><a href = "<?=base_url()?>employees/personal?id=`+x.id+`">
                                            <img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;`+fullname+`</a>
                                        </td>
                                        <td>`+x.col_empl_type+`</td>
                                        <td>`+x.col_empl_posi+`</td>
                                        <td>`+x.col_empl_dept+`</td>
                                        <td>`+x.col_empl_sect+`</td>
                                        <td>`+x.col_empl_group+`</td>
                                        <td>`+x.col_empl_line+`</td>
                                    </tr>
                                `);
                            })
                        } else {
                            $('#loader_gif').hide();

                            $('#table_container').append(`
                                    <td colspan="7">No Employees Detected</td>
                            `);
                        }

                        $('#total_employees').text($('#table_container tr').length);
                    }) 
                }
            }
            

            // ======================= FILTER BY DEPARTMENT ================================
            $('#filter_by_department').change(function(){
                
                department = $(this).val();
                section = $('#filter_by_section').val();
                line = $('#filter_by_line').val();
                group = $('#filter_by_group').val();
                status = $('#filter_by_status').val();

                display_filtered_empl( department, section, line, group, status);

                get_filter_data(url_get_filter_data_section, department, line, group, section, status).then(function(data){
                    if(!section){
                        $('#filter_by_section').html('');
                        $('#filter_by_section').append(`<option value="">All Sections</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_sect != ''){
                            $('#filter_by_section').append(`
                                <option value="`+x.col_empl_sect+`">`+x.col_empl_sect+`</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_group, department, line, group, section, status).then(function(data){
                    if(!group){
                        $('#filter_by_group').html('');
                        $('#filter_by_group').append(`<option value="">All Groups</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_group != ''){
                            $('#filter_by_group').append(`
                                <option value="`+x.col_empl_group+`">`+x.col_empl_group+`</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_line, department, line, group, section, status).then(function(data){
                    if(!line){
                        $('#filter_by_line').html('');
                        $('#filter_by_line').append(`<option value="">All Lines</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_line != ''){
                            $('#filter_by_line').append(`
                                <option value="`+x.col_empl_line+`">`+x.col_empl_line+`</option>
                            `);
                        }
                    })
                })

                
            })

            // ======================= FILTER BY SECTION ================================
            $('#filter_by_section').change(function(){
                department = $('#filter_by_department').val();
                section = $(this).val();
                line = $('#filter_by_line').val();
                group = $('#filter_by_group').val();
                status = $('#filter_by_status').val();

                display_filtered_empl(department, section, line, group, status);

                get_filter_data(url_get_filter_data_department, department, line, group, section, status).then(function(data){
                    if(!department){
                        $('#filter_by_department').html('');
                        $('#filter_by_department').append(`<option value="">All Departments</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_dept != ''){
                            $('#filter_by_department').append(`
                                <option value="`+x.col_empl_dept+`">`+x.col_empl_dept+`</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_group, department, line, group, section, status).then(function(data){
                    if(!group){
                        $('#filter_by_group').html('');
                        $('#filter_by_group').append(`<option value="">All Groups</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_group != ''){
                            $('#filter_by_group').append(`
                                <option value="`+x.col_empl_group+`">`+x.col_empl_group+`</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_line, department, line, group, section, status).then(function(data){
                    if(!line){
                        $('#filter_by_line').html('');
                        $('#filter_by_line').append(`<option value="">All Lines</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_line != ''){
                            $('#filter_by_line').append(`
                                <option value="`+x.col_empl_line+`">`+x.col_empl_line+`</option>
                            `);
                        }
                    })
                })
            })

            
            // ======================= FILTER BY GROUP ================================
            $('#filter_by_group').change(function(){
                department = $('#filter_by_department').val();
                section = $('#filter_by_section').val();
                line = $('#filter_by_line').val();
                group = $(this).val();
                status = $('#filter_by_status').val();

                display_filtered_empl(department, section, line, group, status);
                
                get_filter_data(url_get_filter_data_department, department, line, group, section, status).then(function(data){
                    if(!department){
                        $('#filter_by_department').html('');
                        $('#filter_by_department').append(`<option value="">All Departments</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_dept != ''){
                            $('#filter_by_department').append(`
                                <option value="`+x.col_empl_dept+`">`+x.col_empl_dept+`</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_section, department, line, group, section, status).then(function(data){
                    if(!section){
                        $('#filter_by_section').html('');
                        $('#filter_by_section').append(`<option value="">All Sections</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_sect != ''){
                            $('#filter_by_section').append(`
                                <option value="`+x.col_empl_sect+`">`+x.col_empl_sect+`</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_line, department, line, group, section, status).then(function(data){
                    if(!line){
                        $('#filter_by_line').html('');
                        $('#filter_by_line').append(`<option value="">All Lines</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_line != ''){
                            $('#filter_by_line').append(`
                                <option value="`+x.col_empl_line+`">`+x.col_empl_line+`</option>
                            `);
                        }
                    })
                })

                
            })

            
            // ======================= FILTER BY LINE ================================
            $('#filter_by_line').change(function(){
                department = $('#filter_by_department').val();
                section = $('#filter_by_section').val();
                line = $(this).val();
                group = $('#filter_by_group').val();
                status = $('#filter_by_status').val();

                display_filtered_empl(department, section, line, group, status);

                get_filter_data(url_get_filter_data_department, department, line, group, section, status).then(function(data){
                    if(!department){
                        $('#filter_by_department').html('');
                        $('#filter_by_department').append(`<option value="">All Departments</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_dept != ''){
                            $('#filter_by_department').append(`
                                <option value="`+x.col_empl_dept+`">`+x.col_empl_dept+`</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_section, department, line, group, section, status).then(function(data){
                    if(!section){
                        $('#filter_by_section').html('');
                        $('#filter_by_section').append(`<option value="">All Sections</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_sect != ''){
                            $('#filter_by_section').append(`
                                <option value="`+x.col_empl_sect+`">`+x.col_empl_sect+`</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_group, department, line, group, section, status).then(function(data){
                    if(!group){
                        $('#filter_by_group').html('');
                        $('#filter_by_group').append(`<option value="">All Groups</option>`);
                    }

                    Array.from(data).forEach(function(x){
                        if(x.col_empl_group != ''){
                            $('#filter_by_group').append(`
                                <option value="`+x.col_empl_group+`">`+x.col_empl_group+`</option>
                            `);
                        }
                    })
                })
            })

            // ======================= FILTER BY STATUS ================================
            $('#filter_by_status').change(function(){
                department = $('#filter_by_department').val();
                section = $('#filter_by_section').val();
                line = $('#filter_by_line').val();
                group = $('#filter_by_group').val();
                status = $(this).val();

                // $('#filter_by_department').empty();
                // $('#filter_by_section').empty();
                // $('#filter_by_group').empty();
                // $('#filter_by_line').empty();

                display_filtered_empl(department, section, line, group, status);

                get_filter_data(url_get_filter_data_department, department, line, group, section, status).then(function(data){
                    if(!department){
                        $('#filter_by_department').html('');
                        $('#filter_by_department').append(`<option value="">All Departments</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_dept != ''){
                            $('#filter_by_department').append(`
                                <option value="`+x.col_empl_dept+`">`+x.col_empl_dept+`</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_section, department, line, group, section, status).then(function(data){
                    if(!section){
                        $('#filter_by_section').html('');
                        $('#filter_by_section').append(`<option value="">All Sections</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_sect != ''){
                            $('#filter_by_section').append(`
                                <option value="`+x.col_empl_sect+`">`+x.col_empl_sect+`</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_group, department, line, group, section, status).then(function(data){
                    if(!group){
                        $('#filter_by_group').html('');
                        $('#filter_by_group').append(`<option value="">All Groups</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_group != ''){
                            $('#filter_by_group').append(`
                                <option value="`+x.col_empl_group+`">`+x.col_empl_group+`</option>
                            `);
                        }
                    })
                })
                get_filter_data(url_get_filter_data_line, department, line, group, section, status).then(function(data){
                    if(!line){
                        $('#filter_by_line').html('');
                        $('#filter_by_line').append(`<option value="">All Lines</option>`);
                    }
                    Array.from(data).forEach(function(x){
                        if(x.col_empl_line != ''){
                            $('#filter_by_line').append(`
                                <option value="`+x.col_empl_line+`">`+x.col_empl_line+`</option>
                            `);
                        }
                    })
                })
            })
            

            // ================================ CLEAR FILTER ==================================
            $('#btn_clear_filter').click(function(){
                $('#loader_gif').show();

                $('#filter_by_group').val('');
                $('#filter_by_section').val('');
                $('#filter_by_department').val('');
                $('#filter_by_line').val('');
                $('#filter_by_status').val('0');



                $('#table_container').html('');
                get_all_employee_data(url_get_all_empl_data).then(function(data){
                    Array.from(data).forEach(function(x){
                        var user_image = '';
                        if(x.col_imag_path){
                            user_image = base_url+'user_images/'+x.col_imag_path;
                        } else {
                            user_image = base_url+'user_images/default_profile_img3.png';
                        }

                        var fullname = '';
                        if((x.col_frst_name) && (x.col_last_name)){
                            if(x.col_midl_name){
                                fullname = x.col_last_name+', '+x.col_frst_name+' '+x.col_midl_name[0]+'.';
                            } else {
                                fullname = x.col_last_name+', '+x.col_frst_name;
                            }
                        
                        }

                        $('#loader_gif').hide();
                        
                        $('#table_container').append(`
                            <tr>
                                <td>`+x.col_empl_cmid+`</td>
                                <td><a href = "<?=base_url()?>employees/personal?id=`+x.id+`">
                                    <img class="rounded-circle avatar " width="35" height="35" src="`+user_image+`">&nbsp;&nbsp;`+fullname+`</a>
                                </td>
                                <td>`+x.col_empl_type+`</td>
                                <td>`+x.col_empl_posi+`</td>
                                <td>`+x.col_empl_dept+`</td>
                                <td>`+x.col_empl_sect+`</td>
                                <td>`+x.col_empl_group+`</td>
                                <td>`+x.col_empl_line+`</td>
                            </tr>
                        `);
                    })
                })
                get_all_filter_data(url_get_all_filter_data).then(function(data){

                    $('#filter_by_group').html('');
                    $('#filter_by_section').html('');
                    $('#filter_by_department').html('');
                    $('#filter_by_line').html('');

                    $('#filter_by_group').append('<option value="">All Groups</option>');
                    $('#filter_by_section').append('<option value="">All Sections</option>');
                    $('#filter_by_department').append('<option value="">All Departments</option>');
                    $('#filter_by_line').append('<option value="">All Lines</option>');

                    Array.from(data.DISP_Group).forEach(function(x){
                        if(x.col_empl_group != ''){
                            $('#filter_by_group').append(`
                                <option value="`+x.col_empl_group+`">`+x.col_empl_group+`</option>
                            `)
                        }
                    })
                    Array.from(data.DISP_DISTINCT_SECTION).forEach(function(x){
                        if(x.col_empl_sect != ''){
                            $('#filter_by_section').append(`
                                <option value="`+x.col_empl_sect+`">`+x.col_empl_sect+`</option>
                            `)
                        }
                    })
                    Array.from(data.DISP_DISTINCT_DEPARTMENT).forEach(function(x){
                        if(x.col_empl_dept != ''){
                            $('#filter_by_department').append(`
                                <option value="`+x.col_empl_dept+`">`+x.col_empl_dept+`</option>
                            `)
                        }
                    })
                    Array.from(data.DISP_Line).forEach(function(x){
                        if(x.col_empl_line != ''){
                            $('#filter_by_line').append(`
                                <option value="`+x.col_empl_line+`">`+x.col_empl_line+`</option>
                            `)
                        }
                    })
                })
                setTimeout(function(){
                    $('#total_employees').text($('#table_container tr').length);
                }, 200);
            })
            
            function capitalizeFirstLetter(word) {
              var newStr = word.split('');
              return newStr[0].toUpperCase();
            }














            $('#btn_pagination').pagination();
            var row_count = $('#row_count').val();
            var page_count = $('#page_count').val();

            console.log(row_count);
            console.log(page_count);

            $('#btn_pagination').pagination({

                // the number of entries
                total: row_count,

                // current page
                current: 1, 

                // the number of entires per page
                length: 20, 

                // pagination size
                size: 2,

                // Prev/Next text
                prev: "&lt;", 
                next: "&gt;", 

                // fired on each click
                click: function (e) {
                    $('#table_container').html('');

                    var row_count = $('#row_count').val();
                    var page_count = $('#page_count').val();
                    // console.log(e.current);
                    var page_num = e.current;
                    $('#current_page').val(page_num);
                    
                    // console.log(page_num);

                    get_employee(url_get_employee,page_num).then(function(data){
                        Array.from(data).forEach(function(e){
                            console.log(e)
                            var empl_image = "<?= base_url() ?>user_images/default_profile_img3.png";
                            if(e.col_imag_path){
                                var empl_image = "<?= base_url() ?>user_images/"+e.col_imag_path;
                            }

                            if(e.col_midl_name){
                                var midl_ini = e.col_midl_name + '.';
                            }else{
                                var midl_ini = '';
                            }
                            
                            var empl_name = e.col_last_name + ', ' + e.col_frst_name + ' ' + midl_ini;

                            $('#table_container').append(`
                                <tr class="bank_row" data-toggle="modal" data-target="#modal_edit_bank" empl_cmid="`+e.col_empl_cmid+`">
                                    <td>`+e.col_empl_cmid+`</td>
                                    <td>
                                        <a href = "<?=base_url()?>employees/personal?id=`+e.id+`">
                                            <img class="rounded-circle avatar " width="35" height="35" src="`+empl_image+`">&nbsp;&nbsp;`+empl_name+`
                                        </a>
                                    </td>
                                    <td>`+e.col_empl_type+`</td>
                                    <td>`+e.col_empl_posi+`</td>
                                    <td>`+e.col_empl_dept+`</td>
                                    <td>`+e.col_empl_sect+`</td>
                                    <td>`+e.col_empl_group+`</td>
                                    <td>`+e.col_empl_line+`</td>
                                </tr>
                            `)
                        })
                    })
                }
            });


            async function get_employee(url,page_num){
                var formData = new FormData();
                formData.append('page_num', page_num);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }




























            async function update_status_remarks(url, date, empl_id, status, remarks){
            var formData = new FormData();
            formData.append('date', date);
            formData.append('empl_id', empl_id);
            formData.append('status', status);
            formData.append('remarks', remarks);
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









            // ==================================================== FILTER ========================================================

            async function get_employee_section_data_filter_by_dept(url, department){
            var formData = new FormData();
            formData.append('department', department);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_employee_data_filter_by_group(url, group){
            var formData = new FormData();
            formData.append('group', group);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_employee_data_filter_by_line(url, line){
            var formData = new FormData();
            formData.append('line', line);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_employee_data_filter_by_status(url, status){
            var formData = new FormData();
            formData.append('status', status);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_employee_data_filter_by_sect(url, section){
            var formData = new FormData();
            formData.append('section', section);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_employee_data_filter_by_dept(url, department){
            var formData = new FormData();
            formData.append('department', department);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }


            // ================================ ASYNC FILTER ===================================

            async function get_filter_data(url, department, line, group, section, status){
            var formData = new FormData();
            formData.append('department', department);
            formData.append('line', line);
            formData.append('group', group);
            formData.append('section', section);
            formData.append('status', status);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_all_filter_data(url){
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
