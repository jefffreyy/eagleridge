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
    $url_count = $this->uri->total_segments();
    $url_directory = $this->uri->segment($url_count);
?>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Pagination -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">
<!-- Datatable -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">

<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">


<div class="content-wrapper">
	<div class="container-fluid p-4">
        <div class="row">
            <div class="col-md-6">
                <h1 class="page-title">My Time Adjustment</h1>
            </div>
            <div class = "col-md-6" style = "text-align: right;">
                <a href = "<?=base_url()?>employees/new_employee" type ="button" data-toggle="modal" data-target="#modal_application_adjustment" class = "btn btn-primary shadow-none"><i class="fas fa-plus"></i> Application for Time Adjustment</a>
            </div>
        </div>
        <hr>

        <div class = "card border-0 mt-2" style = "padding: 0px; margin: 0px">
            <table class="table table-hover">
                <thead>
                    <th>Application ID</th>
                    <th>Application Date</th>
                    <th>Employee</th>
                    <th>Adjustment Date</th>
                    <th>Shift</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Reason</th>
                    <th>Status</th>
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
                                $application_date = date('l, F j, Y',strtotime($DISP_TIME_ADJUSTMENT_ROW->date_created));
                                $date_adjustment = date('l, F j, Y',strtotime($DISP_TIME_ADJUSTMENT_ROW->date_adjustment));

                                $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_TIME_ADJUSTMENT_ROW->empl_id);
                                if(!empty($employee[0]->col_midl_name)){
                                    $midl_ini = $employee[0]->col_midl_name[0].'.';
                                }else{
                                    $midl_ini = '';
                                }
                            ?>
                                <tr class="adjustment_row" style="cursor: pointer;" data-toggle="modal" data-target="#modal_time_adjustment_details" employee_id="<?= $DISP_TIME_ADJUSTMENT_ROW->empl_id ?>" adjustment_id="<?= $DISP_TIME_ADJUSTMENT_ROW->id ?>">
                                    <td><?= $application_id ?></td>
                                    <td><?= $application_date ?></td>
                                    <td>
                                        <a href = "#">
                                            <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $employee[0]->col_last_name.', '.$employee[0]->col_frst_name.' '.$midl_ini?>
                                        </a>
                                    </td>
                                    <td><?= $date_adjustment ?></td>
                                    <td><?= $DISP_TIME_ADJUSTMENT_ROW->shift_type ?></td>
                                    <td><?= $time_in ?></td>
                                    <td><?= $time_out ?></td>
                                    <td><?= $DISP_TIME_ADJUSTMENT_ROW->reason ?></td>
                                    <td>
                                        <?php 
                                            if(($DISP_TIME_ADJUSTMENT_ROW->status1 == 'Rejected') || ($DISP_TIME_ADJUSTMENT_ROW->status2 == 'Rejected')){
                                                echo 'Rejected';
                                            } else if (($DISP_TIME_ADJUSTMENT_ROW->status1 == 'Approved') && ($DISP_TIME_ADJUSTMENT_ROW->status2 == 'Approved')) {
                                                echo 'Approved';
                                            } else {
                                                echo 'Pending';
                                            }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                                <tr class="table-active">
                                    <td colspan="9"><center>You haven't submitted any time adjustment application yet</center></td>
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
                <form action="<?php echo base_url('attendance/insrt_my_time_adjustment'); ?>" id="form_time_adjustment" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required " for="OVERTIME_INPF_OVRTIME_DATE">Employee ID
                                    </label>
                                    <select name="EMPLOYEE" id="EMPLOYEE" class="form-control" disabled>
                                        <?php 
                                            $user_data = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($this->session->userdata('SESS_USER_ID'));
                                            if(!empty($user_data[0]->col_midl_name)){
                                                $midl_ini = $user_data[0]->col_midl_name[0].'.';
                                            }else{
                                                $midl_ini = '';
                                            }
                                            ?>
                                                <option value="" ><?= $user_data[0]->col_empl_cmid.' - '.$user_data[0]->col_last_name.', '.$user_data[0]->col_frst_name.' '.$midl_ini; ?></option>
                                            <?php
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
                                                    <option value="<?= $DISP_WORK_SHIFT_ROW->name ?>"><?= '['.$DISP_WORK_SHIFT_ROW->code.'] '.$DISP_WORK_SHIFT_ROW->name ?></option>
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
                                    <textarea name="reason" id="reason" class="form-control" cols="30" rows="03" required></textarea>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="ADJUSTMENT_INPF_REASON">Attachment (Optional)</label>
                                    <div class="row px-3">
                                        <div class="col-nd-6">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input fileficker" id="TIME_ADJUSTMENT_FILE" name="TIME_ADJUSTMENT_FILE" multiple="" accept=".jpg, .jpeg, .png">
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
                        <a class='btn btn-primary text-light' id="btn_apply_time_adjustment">&nbsp; Apply
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>



    

    
    <!-- View Time Adjustment Details -->
    <div class="modal fade" id="modal_time_adjustment_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <h4 class="modal-title mt-0 ml-1">Time Adjustment Details
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;
                    </span>
                    </button>
                </div>
                <div class="modal-body pb-5">
                    <div class="row">
                    <div class="col-md-4">
                        <div class="w-100 text-center pt-4">
                        <img id="adj_modal_employee_img" class="rounded-circle" alt="" style="width: 150px; height: 150px;">
                        </div>
                        <div class="pl-3 mt-3">
                        <p class="text-bold mb-1">Name:</p>
                        <p class="mb-4" id="adj_employee_name"></p>
                        <p class="text-bold mb-1">Position:</p>
                        <p class="mb-4" id="adj_employee_position"></p>
                        <p class="text-bold mb-1">Department:</p>
                        <p class="mb-4" id="adj_employee_department"></p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-3">
                                <p class="text-bold mb-1">Application Date:</p>
                                <p class="mb-4" id="adj_application_date"></p>
                                <p class="text-bold mb-1">Adjustment Date:</p>
                                <p class="mb-4" id="adj_adjustment_date"></p>
                                <p class="text-bold mb-1">Shift Type:</p>
                                <p class="mb-4"id="adj_shift_type"></p>
                                
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mt-3">
                                <p class="text-bold mb-1">Time In:</p>
                                <p class="mb-4" id="adj_time_in"></p> 
                                <p class="text-bold mb-1">Time Out:</p>
                                <p class="mb-4" id="adj_time_out"></p> 
                                <p class="text-bold mb-1">Reason:</p>
                                <p class="mb-4"id="adj_reason"></p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-bold mb-1">Status:</p>
                                <p id="adj_status" class="text-success"></p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-bold mb-1">Attachment:</p>
                                <a id="time_adjustment_link_img" target="_blank">
                                    <img id="time_adjustment_img" alt="" src="" style="width: 100px;cursor:pointer" class="w3-hover-opacity">
                                </a>
                                <p style="display:none" class="text-muted" id="empty_attachment">No attachment</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6" id="reason_rejection">
                                <p class="text-bold mb-1 text-danger">Reason for Rejection:</p>
                                <p id="adj_rejection_comment"></p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <a type="submit" class='btn btn-primary text-light' id="btn_approve_adj">&nbsp; Approve</a>
                    <a type="submit" class='btn btn-danger text-light BTN_REJECT_ADJUSTMENT' id="btn_reject_adj" data-toggle="modal" data-target="#modal_adjustment_rejection_reason">&nbsp; Reject</a>
                </div> -->
            </div>
        </div>
    </div>


    <?php 
        $page_count = $DISP_ROW_COUNT[0]->mta_count/20;
        
        if(($DISP_ROW_COUNT[0]->mta_count % 20) != 0){
            $page_count = $page_count++;
        }

        $page_count = ceil($page_count);
    ?>

    <input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT[0]->mta_count ?>">
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
            var url_get_time_adjustment_data = '<?php echo base_url(); ?>approval/get_time_adjustment_data';
            var url_get_mta_data = '<?= base_url() ?>attendance/get_mta_data';
            var base_url = '<?= base_url() ?>';

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
                // if (!time_in_text) {
                //     hasErr++;
                //     $('#time_in_text').addClass('is-invalid');
                // }
                // if (!time_out_text) {
                //     hasErr++;
                //     $('#time_out_text').addClass('is-invalid');
                // }
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

            // $('#time_in_text').keyup(function() {
            //     $('#time_in_text').removeClass('is-invalid');
            // })

            // $('#time_out_text').change(function() {
            //     $('#time_out_text').removeClass('is-invalid');
            // })

            $('#reason').keyup(function() {
                $('#reason').removeClass('is-invalid');
            })



            $('.adjustment_row').click(function(){
                var modal_employee_id = $(this).attr('employee_id');
                var modal_adjustment_id = $(this).attr('adjustment_id');

                get_time_adjustment_data(url_get_time_adjustment_data,modal_employee_id,modal_adjustment_id).then(data => {
                    data.adjustment_data.forEach((adjustment) => {
                        var application_date = adjustment.date_created;
                        var overtime_date = adjustment.date_adjustment;
                        var shift_type = adjustment.shift_type;
                        var time_in = adjustment.time_in;
                        var time_out = adjustment.time_out;
                        var reason = adjustment.reason;
                        var status1 = adjustment.status1;
                        var status2 = adjustment.status2;
                        var attachment = adjustment.attachment;
                        // var status3 = adjustment.status3;
                    
                        $('#adj_application_date').text(application_date);
                        $('#adj_adjustment_date').text(overtime_date);
                        $('#adj_shift_type').text(shift_type);
                        $('#adj_time_in').text(time_in);
                        $('#adj_time_out').text(time_out);
                        $('#adj_reason').text(reason);

                        if((status1 == "Approved") && (status2 == "Approved")){
                            $('#adj_status').attr('class','text-bold text-success');
                            $('#adj_status').text('Approved');
                        } else if ((status1 == "Pending") || (status2 == "Pending")){
                            $('#adj_status').attr('class','text-bold text-secondary');
                            $('#adj_status').text('Pending');
                        } else if ((status1 == "Rejected") || (status2 == "Rejected")){
                            $('#adj_status').attr('class','text-bold text-danger');
                            $('#adj_status').text('Rejected');
                        }

                        if(adjustment.comment){
                            $('#reason_rejection').show();
                            $('#adj_rejection_comment').text(adjustment.comment);
                        } else {
                            $('#adj_rejection_comment').text('');
                            $('#reason_rejection').hide();
                        }

                        if(adjustment.attachment){
                            $('#empty_attachment').hide();
                            $('#time_adjustment_img').attr('src',base_url + 'assets/files/time_adjustment/' + adjustment.attachment);
                        } else {
                            $('#time_adjustment_link_img').hide();
                            $('#empty_attachment').show();
                        }
                        $('#time_adjustment_link_img').attr('href',base_url + 'assets/files/time_adjustment/' + adjustment.attachment);
                    });
                    data.employee_data.forEach((employeeData) => {
                        $('#adj_employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
                        $('#adj_employee_position').text(employeeData.col_empl_posi);
                        $('#adj_employee_department').text(employeeData.col_empl_dept);
                        if(employeeData.col_imag_path){
                            $('#adj_modal_employee_img').attr('src',base_url + 'user_images/' + employeeData.col_imag_path);
                        } else {
                            $('#adj_modal_employee_img').attr('src',base_url + 'user_images/' + 'default_profile_img3.png');
                        }
                        
                    })
                })
            })


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

                get_mta_data(url_get_mta_data,page_num).then(function(data){
                    console.log(data);
                    Array.from(data).forEach(function(e){

                        var mta_id = 'ADJ'+(e.id).padStart(5,0);

                        var date_created = new Date(e.date_created).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"});
                        var date_adjustment = new Date(e.date_adjustment).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"});

                        var adjustment_id = e.id;
                        // var date_created = moment(e.date_created).format('MMMM D, YYYY');
                        var assigned_by = e.assigned_by;
                        var empl_id = e.empl_id;
                        // var date_adjustment = moment(e.date_adjustment).format('MMMM D, YYYY');
                        var shift_type = e.shift_type;
                        var time_in = e.time_in.split(':');
                        var time_in = time_in[0]+':'+time_in[1];
                        var time_out = e.time_out.split(':');
                        var time_out = time_out[0]+':'+time_out[1];
                        var reason = e.reason;
                        var status1 = e.status1;
                        var status2 = e.status2;
                        var comment = e.comment;
                        var attachment = e.attachment;

                        
                        var empl_image = 'default_profile_img3.png';
                        var empl_name = '';
                        var empl_cmid = '';
                        var empl_id = '';
                        var empl_info = e.empl_id;
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
                        var assigned_by_info = e.assigned_by;
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

                        if((status1 == 'Rejected') || (status2 == 'Rejected')){
                            var status = 'Rejected';
                        } else if ((status1 == 'Approved') && (status2 == 'Approved')) {
                            var status = 'Approved';
                        } else {
                            var status = 'Pending';
                        }

                        $('#tbl_application_container').append(`
                            <tr  class="adjustment_row" style="cursor: pointer;" data-toggle="modal" data-target="#modal_time_adjustment_details" employee_id="`+empl_id+`" adjustment_id="`+adjustment_id+`">
                                <td>`+mta_id+`</td>
                                <td>`+date_created+`</td>
                                <td>
                                    <a href = "#">
                                        <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= $employee[0]->col_last_name.', '.$employee[0]->col_frst_name.' '.$midl_ini?>
                                    </a>
                                </td>
                                <td>`+date_adjustment+`</td>
                                <td>`+shift_type+`</td>
                                <td>`+time_in+`</td>
                                <td>`+time_out+`</td>
                                <td>`+reason+`</td>
                                <td>`+status+`</td>
                            </tr>
                        `)
                    })
                })

            }
        });


        async function get_mta_data(url,page_num){
            var formData = new FormData();
            formData.append('page_num', page_num);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_time_adjustment_data(url,employee_id,adjustment_id) {
            var formData = new FormData();
            formData.append('employee_id', employee_id);
            formData.append('adjustment_id', adjustment_id);
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
