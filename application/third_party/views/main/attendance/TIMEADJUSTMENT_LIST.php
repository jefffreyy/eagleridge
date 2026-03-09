<style>
  .btn-group .btn{
    padding: 0px 12px;
  }
  .page-title{
    font-weight: 600;
    color: #424F5C;
    font-size: 33px;
  }
  th,td{
    font-size: 13px !important;
  }
  label.required::after{
    content:" *";
    color: red;
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

    <?php
        $url_count = $this->uri->total_segments();
        $url_directory = $this->uri->segment($url_count);
    ?>

	<div class="content-wrapper">
		<div class="container-fluid p-4">
            <div class="row">
                <div class = "col-md-6">
                    <h1 class="page-title">Time Adjustment<h1>
                </div>
                <div class = "col-md-6" style = "text-align: right;">
                    <a href = "<?=base_url()?>employees/new_employee" type ="button" data-toggle="modal" data-target="#modal_application_adjustment" class = "btn btn-primary shadow-none"><i class="fas fa-plus"></i> Application for Time Adjustment</a>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-3">
                    <label for="filter_employee">Filter by Employees</label>
                    <select name="filter_employee" id="filter_employee" class="form-control">
                        <option value="">All Employees</option>
                        <?php 
                            if($DISP_ALL_EMPLOYEES){
                                foreach($DISP_ALL_EMPLOYEES as $DISP_ALL_EMPLOYEES_ROW){
                                ?>
                                    <option value="<?= $DISP_ALL_EMPLOYEES_ROW->id ?>"><?= $DISP_ALL_EMPLOYEES_ROW->col_empl_cmid.' - '.$DISP_ALL_EMPLOYEES_ROW->col_frst_name.' '.$DISP_ALL_EMPLOYEES_ROW->col_last_name ?></option>
                                <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filter_cutoff_period">Filter by cutoff period</label>
                    <select name="filter_cutoff_period" id="filter_cutoff_period" class="form-control">
                        <option value="">All Cut-off Period</option>
                        <?php
                            if($DISP_ALL_CUTOFF_PERIOD){
                                foreach($DISP_ALL_CUTOFF_PERIOD as $DISP_ALL_CUTOFF_PERIOD_ROW){
                                ?>
                                    <option value="<?= $DISP_ALL_CUTOFF_PERIOD_ROW->db_name ?>"><?= $DISP_ALL_CUTOFF_PERIOD_ROW->name ?></option>
                                <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <br>
            <div class = "card border-0 mt-2" style = "padding: 0px; margin: 0px">
                <div style="overflow-x:auto;">
                    <table class = "table table-hover" id="tbl_application">
                        <thead>
                            <tr>
                                <th>Application ID</th>
                                <th>Application Date</th>
                                <th>Assigned By</th>
                                <th>Employee</th>
                                <th>Adjustment Date</th>
                                <th>Shift</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Reason</th>
                                <th>Status<br> (Approver 1)</th>
                                <th>Status<br> (Approver 2)</th>
                                <!-- <th>Status<br> (Approver 3)</th> -->
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_application_container">
                            <?php
                                if($DISP_TIME_ADJUSTMENT){
                                    foreach($DISP_TIME_ADJUSTMENT as $DISP_TIME_ADJUSTMENT_ROW){

                                        $application_id = 'ADJ'.str_pad($DISP_TIME_ADJUSTMENT_ROW->id, 5, '0', STR_PAD_LEFT);

                                        $db_time_in = explode(':',$DISP_TIME_ADJUSTMENT_ROW->time_in);
                                        $time_in = $db_time_in[0].':'.$db_time_in[1];

                                        $db_time_out = explode(':',$DISP_TIME_ADJUSTMENT_ROW->time_out);
                                        $time_out = $db_time_out[0].':'.$db_time_out[1];

                                        $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TIME_ADJUSTMENT_ROW->empl_id);
                                        $assigned_by = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TIME_ADJUSTMENT_ROW->assigned_by);
                                        $firstname = '';
                                        $lastname = '';
                                        if(!empty($assigned_by[0]->col_midl_name)){
                                            $midl_ini = $assigned_by[0]->col_midl_name[0].'.';
                                            if(!empty($assigned_by[0]->col_last_name) && !empty($assigned_by[0]->col_frst_name)){
                                                $firstname = $assigned_by[0]->col_frst_name;
                                                $lastname = $assigned_by[0]->col_last_name;
                                            }
                                            $fullname_assign = $lastname.', '.$firstname.' '.$midl_ini;
                                        }else{
                                            if(!empty($assigned_by[0]->col_last_name) && !empty($assigned_by[0]->col_frst_name)){
                                                $firstname = $assigned_by[0]->col_frst_name;
                                                $lastname = $assigned_by[0]->col_last_name;
                                            }
                                            $fullname_assign = $lastname.', '.$firstname;
                                        }
                                        $firstname = '';
                                        $lastname = '';
                                        if(!empty($employee[0]->col_midl_name)){
                                            $midl_ini2 = $employee[0]->col_midl_name[0].'.';
                                            if(!empty($employee[0]->col_last_name) && !empty($employee[0]->col_frst_name)){
                                                $firstname = $employee[0]->col_frst_name;
                                                $lastname = $employee[0]->col_last_name;
                                            }
                                            $fullname_employee = $lastname.', '.$firstname.' '.$midl_ini;
                                        }else{
                                            if(!empty($employee[0]->col_last_name) && !empty($employee[0]->col_frst_name)){
                                                $firstname = $employee[0]->col_frst_name;
                                                $lastname = $employee[0]->col_last_name;
                                            }
                                            $fullname_employee = $lastname.', '.$firstname;
                                        }

                                        ?>
                                            <tr>
                                                <td><?= $application_id ?></td>
                                                <td><?= date('M j, Y',strtotime($DISP_TIME_ADJUSTMENT_ROW->date_created)) ?></td>
                                                <td>
                                                    <a href = "<?=base_url()?>employees/personal?id=<?php if(!empty($assigned_by[0]->id)){echo $assigned_by[0]->id;}else{echo '';} ?>">
                                                        <img class="rounded-circle avatar " width="35" height="35" src="<?php if(!empty($assigned_by[0]->col_imag_path)){echo base_url().'user_images/'.$assigned_by[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $fullname_assign ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href = "<?=base_url()?>employees/personal?id=<?php if(!empty($employee[0]->id)){echo $employee[0]->id;}else{echo '';} ?>">
                                                        <img class="rounded-circle avatar " width="35" height="35" src="<?php if(!empty($employee[0]->col_imag_path)){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?=  $fullname_employee ?>
                                                    </a>
                                                </td>
                                                <td><?= date('M j, Y',strtotime($DISP_TIME_ADJUSTMENT_ROW->date_adjustment)) ?></td>
                                                <td><?= $DISP_TIME_ADJUSTMENT_ROW->shift_type ?></td>
                                                <td><?= $DISP_TIME_ADJUSTMENT_ROW->time_in ?></td>
                                                <td><?= $DISP_TIME_ADJUSTMENT_ROW->time_out ?></td>
                                                <td><?= $DISP_TIME_ADJUSTMENT_ROW->reason ?></td>
                                                <td><?= $DISP_TIME_ADJUSTMENT_ROW->status1 ?></td>
                                                <td><?= $DISP_TIME_ADJUSTMENT_ROW->status2 ?></td>
                                                <!-- <td><?= $DISP_TIME_ADJUSTMENT_ROW->status3 ?></td> -->
                                                <td><?= $DISP_TIME_ADJUSTMENT_ROW->comment ?></td>
                                            </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                        <tr>
                                            <td colspan="10">No Applications Yet</td>
                                        </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <center><ul id="btn_pagination" class="pagination mr-auto ml-auto"></ul></center>
                </div>
            </div>
        </div>
	</div>

    <!-- =============== Application for Time Adjustment ================= -->
    <div class="modal fade" id="modal_application_adjustment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Application for Time Adjustment
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;
                        </span>
                    </button>
                </div>
                <form action="<?php echo base_url('attendance/insrt_assign_time_adjustment'); ?>" id="form_time_adjustment" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required " for="EMPLOYEE">Employee ID
                                    </label>
                                    <select name="EMPLOYEE" id="EMPLOYEE" class="form-control">
                                        <option value="">Choose Employee...</option>
                                        <?php 
                                            foreach($DISP_EMPL_INFO as $DISP_EMPL_INFO_ROW){
                                                ?>
                                                    <option value="<?= $DISP_EMPL_INFO_ROW->id ?>"><?= $DISP_EMPL_INFO_ROW->col_empl_cmid.' - '.$DISP_EMPL_INFO_ROW->col_frst_name.' '.$DISP_EMPL_INFO_ROW->col_last_name ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required " for="date_adjustment">Adjustment Date
                                    </label>
                                    <input type="date" name="date_adjustment" id="date_adjustment" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="required " for="shift_type">Type
                                    </label>
                                    <select name="shift_type" id="shift_type" class="form-control">
                                        <option value="">Choose...</option>
                                        <?php 
                                            if($DISP_WORK_SHIFT){
                                                foreach($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW){
                                                ?>
                                                    <option value="<?= $DISP_WORK_SHIFT_ROW->name ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                                                <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required " for="ADJUSTMENT_INPF_TIME_IN">Time In
                                    </label>
                                    <div class="input-group date" id="timepicker" data-target-input="nearest" style="width: 100% !important;">
                                        <input type="text" class="form-control datetimepicker-input time_in_text mr-0" name="time_in_text" data-target="#timepicker" id="time_in_text" placeholder="hr:min" required>
                                        <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="required " for="ADJUSTMENT_INPF_TIME_OUT">Time Out
                                    </label>
                                    <div class="input-group date" id="timepicker2" data-target-input="nearest" style="width: 100% !important;">
                                        <input type="text" class="form-control datetimepicker-input time_out_text mr-0" name="time_out_text" data-target="#timepicker2" id="time_out_text" placeholder="hr:min" required>
                                        <div class="input-group-append" data-target="#timepicker2" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="required " for="ADJUSTMENT_INPF_REASON">Reason
                                    </label>
                                    <textarea name="reason" id="reason" class="form-control" cols="30" rows="03"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="time_in" id="time_in_formatted">
                        <input type="hidden" name="time_out" id="time_out_formatted">
                        <input type="hidden" name="url_directory" value="<?= $url_directory ?>">
                        <a class='btn btn-primary text-light' id="btn_apply_time_adjustment">&nbsp; Apply
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php 
        $page_count = $DISP_ROW_COUNT[0]->adj_count/20;
        
        if(($DISP_ROW_COUNT[0]->adj_count % 20) != 0){
            $page_count = $page_count++;
        }

        $page_count = ceil($page_count);
    ?>

    <input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT[0]->adj_count ?>">
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
	<!-- AdminLTE App -->
	<script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
	<!-- Full Calendar 2.2.5 -->
	<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
    <!-- Full Calendar -->
	<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
	<!-- Sweet Alert -->
	<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
	<!-- Toastr -->
	<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
    <!-- InputMask (Required for Timepicker)-->
    <script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Pagination -->
    <script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>
    <!-- Data table -->
    <script src="<?=base_url();?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url();?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_INSRT_ADJUSTMENT')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_ADJUSTMENT'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_ADJUSTMENT');
    }
    ?>
    <?php
    if ($this->session->userdata('SESS_ERR_MSG_INSRT_ADJUSTMENT')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_ADJUSTMENT'); ?>',
                '',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_ERR_MSG_INSRT_ADJUSTMENT');
    }
    ?>
    <script>
        $(document).ready(function(){
            var url_get_time_adjustment = '<?= base_url() ?>attendance/get_time_adjustment';
            var url_get_adj_application_data = '<?= base_url() ?>attendance/get_adj_application_data';
            var url_get_all_ampl_data = '<?= base_url() ?>attendance/get_all_ampl_data';
            var base_url = '<?= base_url() ?>';

            //Timepicker time in
            $('#timepicker').datetimepicker({
                // stepping: 30,
                format: 'LT'
            })
            // Timepicker time out
            $('#timepicker2').datetimepicker({
                // stepping: 30,
                format: 'LT'
            })

            $('#btn_apply_time_adjustment').click(function(e) {
                var date_adjustment = $('#date_adjustment').val();
                var shift_type = $('#shift_type').val();
                var time_in_text = $('#time_in_text').val();
                var time_out_text = $('#time_out_text').val();
                var reason = $('#reason').val();
                var hasErr = 0;

                var time_in_formatted = moment(time_in_text, "LT").format("HH:mm");
                $('#time_in_formatted').val(time_in_formatted);
                
                var time_out_formatted = moment(time_out_text, "LT").format("HH:mm");
                $('#time_out_formatted').val(time_out_formatted);

                if (!date_adjustment) {
                    hasErr++;
                    $('#date_adjustment').addClass('is-invalid');
                }
                if (!shift_type) {
                    hasErr++;
                    $('#shift_type').addClass('is-invalid');
                }
                if (!time_in_text) {
                    hasErr++;
                    $('#time_in_text').addClass('is-invalid');
                }
                if (!time_out_text) {
                    hasErr++;
                    $('#time_out_text').addClass('is-invalid');
                }
                if (!reason) {
                    hasErr++;
                    $('#reason').addClass('is-invalid');
                }

                if (!hasErr) {
                    $('#form_time_adjustment').submit();
                } else {
                    e.preventDefault();
                }
            })

            $('#date_adjustment').change(function() {
                $('#date_adjustment').removeClass('is-invalid');
            })

            $('#shift_type').blur(function() {
                $('#shift_type').removeClass('is-invalid');
            })

            $('#time_in_text').keyup(function() {
                $('#time_in_text').removeClass('is-invalid');
            })

            $('#time_out_text').change(function() {
                $('#time_out_text').removeClass('is-invalid');
            })

            $('#reason').keyup(function() {
                $('#reason').removeClass('is-invalid');
            })


























        















            var empl_id_arr = [];
            var empl_info_arr = [];

            get_all_ampl_data(url_get_all_ampl_data, 'test').then(function(data){

                var obj = findObjectByKey(data, 'id', '999999');
                console.log(obj);
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



















            $('#filter_employee').change(function(e){
                var cutoff_period = '';
                if($('#filter_cutoff_period').val()){
                    cutoff_period = $('#filter_cutoff_period').val();
                }
                var empl_id = $(this).val();

                display_application_data(empl_id, cutoff_period);
            })

            $('#filter_cutoff_period').change(function(e){
                var empl_id = '';
                if($('#filter_employee').val()){
                    empl_id = $('#filter_employee').val();
                }
                var cutoff_period = $(this).val();

                display_application_data(empl_id, cutoff_period);
            })



            function display_application_data(empl_id, cutoff_period){

                get_adj_application_data(url_get_adj_application_data,empl_id,cutoff_period,1).then(function(data){
                    $('#tbl_application_container').html('');
                    console.log(data);

                    Array.from(data).forEach(function(e){

                        var adj_id = 'ADJ'+(e.id).padStart(5,0);

                        var date_created = moment(e.date_created).format('MMMM D, YYYY');
                        var assigned_by = e.assigned_by;
                        var empl_id = e.empl_id;
                        var date_adjustment = moment(e.date_adjustment).format('MMMM D, YYYY');
                        var shift_type = e.shift_type;
                        var time_in = e.time_in;
                        var time_out = e.time_out;
                        var reason = e.reason;
                        var status1 = e.status1;
                        var status2 = e.status2;
                        var comment = e.comment;

                        var empl_image = 'default_profile_img3.png';
                        var empl_name = '';
                        var empl_cmid = '';
                        var empl_id = '';
                        var empl_info = findObjectByKey(empl_info_arr, 'id', ""+e.empl_id+"");
                        if(empl_info){
                            if(empl_info.col_imag_path){
                                empl_image = empl_info.col_imag_path;
                            }
                            if(empl_info.col_midl_name){
                                var midl_ini = empl_info.col_midl_name + '.';
                            }else{
                                var midl_ini = '';
                            }
                            
                            empl_name = empl_info.col_last_name + ', ' + empl_info.col_frst_name + ' ' + midl_ini;
                            empl_cmid = empl_info.col_empl_cmid;
                            empl_id = empl_info.id;
                        }

                        var assigned_by_image = 'default_profile_img3.png';
                        var assigned_by_name = '';
                        var assigned_by_cmid = '';
                        var assigned_by_id = '';
                        var assigned_by_info = findObjectByKey(empl_info_arr, 'id', ""+e.assigned_by+"");
                        if(assigned_by_info){
                            if(assigned_by_info.col_imag_path){
                                assigned_by_image = assigned_by_info.col_imag_path;
                            }
                            if(assigned_by_info.col_midl_name){
                                var midl_ini2 = assigned_by_info.col_midl_name + '.';
                            }else{
                                var midl_ini2 = '';
                            }
                            assigned_by_name = assigned_by_info.col_last_name + ', ' + assigned_by_info.col_frst_name + ' ' + midl_ini2;
                            assigned_by_cmid = assigned_by_info.col_empl_cmid;
                            assigned_by_id = assigned_by_info.id;
                        }

                        $('#tbl_application_container').append(`
                            <tr>
                                <td>`+adj_id+`</td>
                                <td>`+date_created+`</td>
                                <td>
                                    <a href = "<?=base_url()?>employees/personal?id=`+empl_id+`">
                                        <img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`user_images/`+empl_image+`">&nbsp;&nbsp;`+empl_name+`
                                    </a>
                                </td>
                                <td>
                                    <a href = "<?=base_url()?>employees/personal?id=`+assigned_by_id+`">
                                        <img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`user_images/`+assigned_by_image+`">&nbsp;&nbsp;`+assigned_by_name+`
                                    </a>
                                </td>
                                <td>`+date_adjustment+`</td>
                                <td>`+shift_type+`</td>
                                <td>`+time_in+`</td>
                                <td>`+time_out+`</td>
                                <td>`+reason+`</td>
                                <td>`+status1+`</td>
                                <td>`+status2+`</td>
                                <td>`+comment+`</td>
                            </tr>
                        `)
                    })
                })
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
                    $('#tbl_application_container').html('');

                    var row_count = $('#row_count').val();
                    var page_count = $('#page_count').val();
                    // console.log(e.current);
                    var page_num = e.current;

                    // console.log(page_num);
                    
                    var employee = $('#filter_employee').val();
                    var cutoff_period = $('#filter_cutoff_period').val();

                    get_time_adjustment(url_get_time_adjustment,employee,cutoff_period,page_num).then(function(data){
                        console.log(data);
                        Array.from(data).forEach(function(e){

                            var adj_id = 'ADJ'+(e.id).padStart(5,0);

                            var date_created = moment(e.date_created).format('MMMM D, YYYY');
                            var assigned_by = e.assigned_by;
                            var empl_id = e.empl_id;
                            var date_adjustment = moment(e.date_adjustment).format('MMMM D, YYYY');
                            var shift_type = e.shift_type;
                            var time_in = e.time_in;
                            var time_out = e.time_out;
                            var reason = e.reason;
                            var status1 = e.status1;
                            var status2 = e.status2;
                            var comment = e.comment;

                            var empl_image = 'default_profile_img3.png';
                            var empl_name = '';
                            var empl_cmid = '';
                            var empl_id = '';
                            var empl_info = findObjectByKey(empl_info_arr, 'id', ""+e.empl_id+"");
                            if(empl_info){
                                if(empl_info.col_imag_path){
                                    empl_image = empl_info.col_imag_path;
                                }
                                if(empl_info.col_midl_name){
                                    var midl_ini = empl_info.col_midl_name + '.';
                                }else{
                                    var midl_ini = '';
                                }
                                
                                empl_name = empl_info.col_last_name + ', ' + empl_info.col_frst_name + ' ' + midl_ini;
                                empl_cmid = empl_info.col_empl_cmid;
                                empl_id = empl_info.id;
                            }

                            var assigned_by_image = 'default_profile_img3.png';
                            var assigned_by_name = '';
                            var assigned_by_cmid = '';
                            var assigned_by_id = '';
                            var assigned_by_info = findObjectByKey(empl_info_arr, 'id', ""+e.assigned_by+"");
                            if(assigned_by_info){
                                if(assigned_by_info.col_imag_path){
                                    assigned_by_image = assigned_by_info.col_imag_path;
                                }
                                if(assigned_by_info.col_midl_name){
                                    var midl_ini2 = assigned_by_info.col_midl_name + '.';
                                }else{
                                    var midl_ini2 = '';
                                }
                                assigned_by_name = assigned_by_info.col_last_name + ', ' + assigned_by_info.col_frst_name + ' ' + midl_ini2;
                                assigned_by_cmid = assigned_by_info.col_empl_cmid;
                                assigned_by_id = assigned_by_info.id;
                            }

                            $('#tbl_application_container').append(`
                                <tr>
                                    <td>`+adj_id+`</td>
                                    <td>`+date_created+`</td>
                                    <td>
                                        <a href = "<?=base_url()?>employees/personal?id=`+empl_id+`">
                                            <img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`user_images/`+empl_image+`">&nbsp;&nbsp;`+empl_name+`
                                        </a>
                                    </td>
                                    <td>
                                        <a href = "<?=base_url()?>employees/personal?id=`+assigned_by_id+`">
                                            <img class="rounded-circle avatar " width="35" height="35" src="`+base_url+`user_images/`+assigned_by_image+`">&nbsp;&nbsp;`+assigned_by_name+`
                                        </a>
                                    </td>
                                    <td>`+date_adjustment+`</td>
                                    <td>`+shift_type+`</td>
                                    <td>`+time_in+`</td>
                                    <td>`+time_out+`</td>
                                    <td>`+reason+`</td>
                                    <td>`+status1+`</td>
                                    <td>`+status2+`</td>
                                    <td>`+comment+`</td>
                                </tr>
                            `)
                        })
                    })

                }
            });








            // SET DATETABLE PLUGIN
            // var table = $('#tbl_application').DataTable({
            //     "order": [[ 0, "desc" ]]
            // });












            async function get_time_adjustment(url,employee,cutoff_period,page_num){
                var formData = new FormData();
                formData.append('employee', employee);
                formData.append('cutoff_period', cutoff_period);
                formData.append('page_num', page_num);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }

            async function get_all_ampl_data(url,empl_id){
                var formData = new FormData();
                formData.append('empl_cmid', empl_id);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }
            
            async function get_adj_application_data(url,empl_id,cutoff_period,page_num) {
                var formData = new FormData();
                formData.append('empl_id', empl_id);
                formData.append('cutoff_period', cutoff_period);
                formData.append('page_num', page_num);
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
