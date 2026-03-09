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

<?php 
    //get the url
    $url_count = $this->uri->total_segments();
    $url_directory = $this->uri->segment($url_count);
?>

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
                <div class = "col-md-6">
                    <h1 class="page-title">Assign Time Adjustment</h1>
                </div>
                <div class = "col-md-6" style = "text-align: right;">
                    <a href = "<?=base_url()?>employees/new_employee" type ="button" data-toggle="modal" data-target="#modal_application_adjustment" class = "btn btn-primary shadow-none"><i class="fas fa-plus"></i> Application for Time Adjustment</a>
                </div>
            </div>
            <hr>
            <div class = "card border-0 mt-2 p-4" style = "padding: 0px; margin: 0px">
                <div style="overflow-x:auto;">
                    <table class = "table table-hover">
                        <thead>
                                <th>Application ID</th>
                                <th>Application Date</th>
                                <th>Assigned By</th>
                                <th>Employee</th>
                                <th>Adjustment Date</th>
                                <th>Type</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th class="text-center">Reason</th>
                                <th>Status <br> (Approver 1)</th>
                                <th>Status <br> (Approver 2)</th>
                                <!-- <th>Status <br> (Approver 3)</th> -->
                        </thead>
                        <tbody id="tbl_application_container">
                            <?php
                                if($DISP_TIME_ADJUSTMENT){
                                    foreach($DISP_TIME_ADJUSTMENT as $DISP_TIME_ADJUSTMENT_ROW){

                                        $application_id = 'ADJ'.str_pad($DISP_TIME_ADJUSTMENT_ROW->id, 5, '0', STR_PAD_LEFT);

                                        $date_created = date('l F j, Y',strtotime($DISP_TIME_ADJUSTMENT_ROW->date_created));
                                        $date_adjustment = date('l F j, Y',strtotime($DISP_TIME_ADJUSTMENT_ROW->date_adjustment));

                                        $db_time_in = explode(':',$DISP_TIME_ADJUSTMENT_ROW->time_in);
                                        $time_in = $db_time_in[0].':'.$db_time_in[1];

                                        $db_time_out = explode(':',$DISP_TIME_ADJUSTMENT_ROW->time_out);
                                        $time_out = $db_time_out[0].':'.$db_time_out[1];

                                        $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TIME_ADJUSTMENT_ROW->empl_id);
                                        $assigned_by = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TIME_ADJUSTMENT_ROW->assigned_by);

                                        // get approval route
                                        $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();

                                        $empl_id = '';
                                        $empl_img = '';
                                        $empl_fullname = '';
                                        $empl_position = '';
                                        if(count($employee) > 0){
                                            $empl_id = $employee[0]->id;
                                            $empl_img = $employee[0]->col_imag_path;
                                            if(!empty($employee[0]->col_midl_name)){
                                                $midl_ini = $employee[0]->col_midl_name[0].'.';
                                            }else{
                                                $midl_ini = '';
                                            }
                                            $empl_fullname = $employee[0]->col_last_name . ', ' .$employee[0] ->col_frst_name.' '. $midl_ini;
                                        }

                                        $assigned_by_empl_id = '';
                                        $assigned_by_empl_img = '';
                                        $assigned_by_empl_fullname = '';
                                        if(count($assigned_by) > 0){
                                            if(!empty($employee[0]->col_midl_name)){
                                                $midl_ini2 = $employee[0]->col_midl_name[0].'.';
                                            }else{
                                                $midl_ini2 = '';
                                            }
                                            $assigned_by_empl_id = $assigned_by[0]->id;
                                            $assigned_by_empl_img = $assigned_by[0]->col_imag_path;
                                            $assigned_by_empl_fullname = $assigned_by[0]->col_last_name . ', ' .$assigned_by[0] ->col_frst_name.' '.$midl_ini2;
                                        }
                                        

                                        // loop through the approval routes
                                        foreach($approval_route as $approval_route_row){
                                            // check if you are a approver then show the list of requests you can only approve
                                            $my_user_id = $this->session->userdata('SESS_USER_ID');
                                            if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id || $my_user_id == 999999)){
                                                ?>
                                                    <tr>
                                                        <td><?= $application_id ?></td>
                                                        <td><?= $date_created ?></td>
                                                        <td>
                                                            <a style="text-transform: capitalize;" href = "<?=base_url()?>employees/personal?id=<?= $assigned_by_empl_id ?>">
                                                                <img class="rounded-circle avatar " width="35" height="35" src="<?php if($assigned_by_empl_img){echo base_url().'user_images/'.$assigned_by_empl_img;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= strtolower($assigned_by_empl_fullname)?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a style="text-transform: capitalize;" href = "<?=base_url()?>employees/personal?id=<?= $empl_id ?>">
                                                                <img class="rounded-circle avatar " width="35" height="35" src="<?php if($empl_img){echo base_url().'user_images/'.$empl_img;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= strtolower($empl_fullname)?>
                                                            </a>
                                                        </td>
                                                        <td><?= $date_adjustment ?></td>
                                                        <td><?= $DISP_TIME_ADJUSTMENT_ROW->shift_type ?></td>
                                                        <td><?= $time_in ?></td>
                                                        <td><?= $time_out ?></td>
                                                        <td><?= $DISP_TIME_ADJUSTMENT_ROW->reason ?></td>
                                                        <td><?= $DISP_TIME_ADJUSTMENT_ROW->status1 ?></td>
                                                        <td><?= $DISP_TIME_ADJUSTMENT_ROW->status2 ?></td>
                                                        <!-- <td><?= $DISP_TIME_ADJUSTMENT_ROW->status3 ?></td> -->
                                                    </tr>
                                                <?php
                                            }
                                        }
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
                <form action="<?php echo base_url('attendance/insrt_assign_time_adjustment'); ?>" id="form_time_adjustment" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required " for="EMPLOYEE">Employee ID
                                    </label>
                                    <select name="EMPLOYEE" id="EMPLOYEE" class="form-control" required>
                                        <option value="">Choose Employee...</option>
                                        <?php 
                                        foreach($DISP_EMPL_INFO as $DISP_EMPL_INFO_ROW){
                                            
                                            $empl_group = 'No Group';
                                            if($DISP_EMPL_INFO_ROW->col_empl_group){
                                                $empl_group = $DISP_EMPL_INFO_ROW->col_empl_group;
                                            }

                                            $group_approver = $this->approval_route_mod->MOD_DISP_GROUP_APPROVERS($empl_group);

                                            // get approval route
                                            $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();

                                            
                                            // loop through the approval routes
                                            foreach($approval_route as $approval_route_row){
                                                // check if you are a approver then show the list of requests you can only approve
                                                $my_user_id = $this->session->userdata('SESS_USER_ID');
                                                if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id) || ($my_user_id == 999999)){
                                                    if(!empty($DISP_EMPL_INFO_ROW->col_midl_name)){
                                                        $midl_ini = $DISP_EMPL_INFO_ROW->col_midl_name[0].'.';
                                                    }else{
                                                        $midl_ini = '';
                                                    }
                                                    ?>
                                                        <option value="<?= $DISP_EMPL_INFO_ROW->id ?>"><?= $DISP_EMPL_INFO_ROW->col_empl_cmid.' - '.$DISP_EMPL_INFO_ROW->col_last_name.', '.$DISP_EMPL_INFO_ROW->col_frst_name.' '.$midl_ini ?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required " for="date_adjustment">Adjustment Date
                                    </label>
                                    <input type="date" name="date_adjustment" id="date_adjustment" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="required " for="shift_type">Shift
                                    </label>
                                    <select name="shift_type" id="shift_type" class="form-control" required>
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
                                    <div class="input-group date" id="timepicker" data-target-input="nearest" style="width: 100% !important;" required>
                                        <input type="text" class="form-control datetimepicker-input time_in_text mr-0" name="time_in_text" data-target="#timepicker" id="time_in_text" placeholder="hr:min" required>
                                        <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="required " for="ADJUSTMENT_INPF_TIME_OUT">Time Out
                                    </label>
                                    <div class="input-group date" id="timepicker2" data-target-input="nearest" style="width: 100% !important;" required>
                                        <input type="text" class="form-control datetimepicker-input time_out_text mr-0" name="time_out_text" data-target="#timepicker2" id="time_out_text" placeholder="hr:min" required>
                                        <div class="input-group-append" data-target="#timepicker2" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="required " for="ADJUSTMENT_INPF_REASON">Reason
                                    </label>
                                    <textarea name="reason" id="reason" class="form-control" cols="30" rows="03" required></textarea>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="ADJUSTMENT_INPF_REASON">Attachment</label>
                                    <div class="row px-3">
                                        <div class="col-nd-6">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input fileficker" id="TIME_ADJUSTMENT_FILE" name="TIME_ADJUSTMENT_FILE" multiple="" accept=".jpg, .jpeg, .png" required>
                                                    <label class="custom-file-label" for="TIME_ADJUSTMENT_FILE">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        $page_count = $DISP_ROW_COUNT/20;
        
        if(($DISP_ROW_COUNT % 20) != 0){
            $page_count = $page_count++;
        }

        $page_count = ceil($page_count);
    ?>
    <input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT ?>">
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
            var url_get_assign_time_adjustment = '<?= base_url() ?>attendance/get_assign_time_adjustment';
            var url_get_approval_route = '<?= base_url() ?>attendance/get_approval_route';
            var url_get_assign_by = '<?= base_url() ?>attendance/getEmployeeData';
            var url_get_employee_by = '<?= base_url() ?>attendance/getEmployeeData';
            var base_url = '<?= base_url() ?>';
            var user_id = '<?= $this->session->userdata('SESS_USER_ID') ?>';


            function previewFileName(uploader) {
                if (uploader.files && uploader.files[0]) {
                    $('.custom-file-label').text(uploader.files[0].name);
                }
            }
            $(".fileficker").change(function() {
                previewFileName(this);
            });

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



            // PAGINATION
            $('#btn_pagination').pagination();

            var row_count = $('#row_count').val();
            var page_count = $('#page_count').val();

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
                
                    get_assign_time_adjustment(url_get_assign_time_adjustment,page_num).then(function(data){
                        Array.from(data).forEach(function(e){
                            var emplo_id= e.empl_id;
                            var assign_id= e.assigned_by;
                            get_assign_by(url_get_assign_by,assign_id).then(function(assign_by){
                                Array.from(assign_by).forEach(function(assign_by){
                                    var assign_by_id = assign_by.id;
                                    if(assign_by.col_imag_path){
                                        var assign_by_img_path = `<?= base_url() ?>user_images/`+assign_by.col_imag_path+``;
                                    } else {
                                        var assign_by_img_path = `<?= base_url() ?>user_images/default_profile_img3.png`;
                                    }
                                    if(assign_by.col_midl_name){
                                        var assign_by_name = assign_by.col_last_name+', '+assign_by.col_frst_name+' '+assign_by.col_midl_name[0]+'.';
                                    }else{
                                        var assign_by_name = assign_by.col_last_name+', '+assign_by.col_frst_name;
                                    }
                                    get_employee_by(url_get_employee_by,emplo_id).then(function(employee_by){
                                        Array.from(employee_by).forEach(function(employee_by){
                                            var employee_by_id = employee_by.id;
                                            if(employee_by.col_imag_path){
                                                var employee_by_img_path = `<?= base_url() ?>user_images/`+employee_by.col_imag_path+``;
                                            } else {
                                                var employee_by_img_path = `<?= base_url() ?>user_images/default_profile_img3.png`;
                                            }
                                            if(employee_by.col_midl_name){
                                                var employee_by_name = employee_by.col_last_name+', '+employee_by.col_frst_name+' '+employee_by.col_midl_name[0]+'.';
                                            }else{
                                                var employee_by_name = employee_by.col_last_name+', '+employee_by.col_frst_name;
                                            }
                                            var my_user_id = `<?= $this->session->userdata('SESS_USER_ID') ?>`;
                                            get_approval_route(url_get_approval_route).then(function(approval_route){
                                                Array.from(approval_route).forEach(function(approval_route){
                                                    if((approval_route.approver1 == my_user_id) || (approval_route.approver2 == my_user_id) || (approval_route.approver3 == my_user_id) || (approval_route.approver4 == my_user_id) || (approval_route.approver5 == my_user_id) || (my_user_id == 999999)){
                                                        var application_id = 'ADJ'+(e.id).padStart(5,0);
                                                        var application_date = new Date(e.date_created).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"});
                                                        var date_adjustment = new Date(e.date_adjustment).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"});
                                                        var time_in = e.time_in;
                                                        var time_in = time_in.split(':');
                                                        var time_in = time_in[0]+':'+time_in[1];
                                                        var time_out = e.time_out;
                                                        var time_out = time_out.split(':');
                                                        var time_out = time_out[0]+':'+time_out[1];
                                                        
                                                        $('#tbl_application_container').append(`
                                                            <tr class="view_leave_details" style="cursor: pointer;" data-toggle="modal" data-target="#modal_leave_details" employee_id="`+e.col_empl_id+`" leave_id="`+e.id+`">
                                                                <td>`+application_id+`</td>
                                                                <td>`+application_date+`</td>
                                                                <td>
                                                                    <a style="text-transform: capitalize;" href = "<?=base_url()?>employees/personal?id=`+assign_by_id+`">
                                                                        <img class="rounded-circle avatar " width="35" height="35" src="`+assign_by_img_path+`">&nbsp;&nbsp;`+assign_by_name.toLowerCase()+`
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a style="text-transform: capitalize;" href = "<?=base_url()?>employees/personal?id=`+employee_by_id+`">
                                                                        <img class="rounded-circle avatar " width="35" height="35" src="`+employee_by_img_path+`">&nbsp;&nbsp;`+employee_by_name.toLowerCase()+`
                                                                    </a>
                                                                </td>
                                                                <td>`+date_adjustment+`</td>
                                                                <td>`+e.shift_type+`</td>
                                                                <td>`+time_in+`</td>
                                                                <td>`+time_out+`</td>
                                                                <td>`+e.reason+`</td>
                                                                <td>`+e.status1+`</td>
                                                                <td>`+e.status2+`</td>
                                                            </tr>
                                                        `)
                                                    }
                                                })
                                            })
                                        })
                                    })
                                })
                            })
                        })
                    })
                }
            });


            async function get_assign_time_adjustment(url,page_num){
                var formData = new FormData();
                formData.append('page_num', page_num);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }

            async function get_approval_route(url){
                var formData = new FormData();
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }

            async function get_assign_by(url,assign_id){
                var formData = new FormData();
                formData.append('employee_id', assign_id);
                const response = await fetch(url, {
                method: 'POST',
                body: formData
                });
                return response.json();
            }

            async function get_employee_by(url,emplo_id){
                var formData = new FormData();
                formData.append('employee_id', emplo_id);
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
