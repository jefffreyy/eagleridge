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

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

	<div class="content-wrapper">
		<div class="container-fluid p-4">
            <div class="row">
                <div class = "col-md-6">
                    <h1><b>Time Adjustment</b><h1>
                </div>
                <div class = "col-md-6" style = "text-align: right;">
                    <!-- <div class="btn-group mr-2" role="group" aria-label="First group">
                        <button type="button" class="btn btn-light"><i class="fas fa-bars"></i></button>
                        <button type="button" class="btn btn-light"><i class="fas fa-users"></i></button>
                        <button type="button" class="btn btn-light"><i class="fas fa-project-diagram"></i></button>
                    </div> -->
                    <div class = "btn-group mr-2">
                        <a href = "<?=base_url()?>employees/new_employee" type ="button" data-toggle="modal" data-target="#modal_application_adjustment" class = "btn btn-primary shadow-none"><i class="fas fa-plus"></i> Application for Time Adjustment</a>
                    </div>
                    <!-- <div class = "btn-group">
                      <button type ="button" class = "btn btn-light"><i class="fas fa-ellipsis-v"></i></button>
                    </div> -->
                </div>
            </div>
            <hr>
            <div class = "row">
                <div class = "col-md-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1" style = "background-color: white;"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search by name, email or phone number" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class = "col-md-4">
                    <!-- <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                        <div class="dropdown-menu" style = "width: 500px; padding: 10px 10px;">
                            <div class="form-group">
                                <input type="select-multiple" class="form-control" placeholder="Positions">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Departments">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Division">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Location">
                            </div>
                            <div class="form-group">
                                <select class="form-control">
                                <option selected>Active</option>
                                <option>All</option>
                                <option>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <a href = "#" style = "margin-left: 10px;">Advance</a> -->
                </div>
            </div>
            <div class = "card border-0 mt-2" style = "padding: 0px; margin: 0px">
                <div style="overflow-x:auto;">
                    <table class = "table table-hover">
                        <thead>
                            <tr>
                                <td>Application ID</td>
                                <td>Application Date</td>
                                <td>Adjustment Date</td>
                                <td>Type</td>
                                <td>Time In</td>
                                <td>Time Out</td>
                                <td>Reason</td>
                                <td>Status</td>
                                <td>Comment</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($DISP_TIME_ADJUSTMENT){
                                    foreach($DISP_TIME_ADJUSTMENT as $DISP_TIME_ADJUSTMENT_ROW){

                                        $application_id = 'ADJ'.str_pad($DISP_TIME_ADJUSTMENT_ROW->id, 5, '0', STR_PAD_LEFT);

                                        $db_time_in = explode(':',$DISP_TIME_ADJUSTMENT_ROW->time_in);
                                        $time_in = $db_time_in[0].':'.$db_time_in[1];

                                        $db_time_out = explode(':',$DISP_TIME_ADJUSTMENT_ROW->time_out);
                                        $time_out = $db_time_out[0].':'.$db_time_out[1];
                                    ?>
                                        <tr>
                                            <td><?= $application_id ?></td>
                                            <td><?= $DISP_TIME_ADJUSTMENT_ROW->date_created ?></td>
                                            <td><?= $DISP_TIME_ADJUSTMENT_ROW->date_adjustment ?></td>
                                            <td><?= $DISP_TIME_ADJUSTMENT_ROW->shift_type ?></td>
                                            <td><?= $DISP_TIME_ADJUSTMENT_ROW->time_in ?></td>
                                            <td><?= $DISP_TIME_ADJUSTMENT_ROW->time_out ?></td>
                                            <td><?= $DISP_TIME_ADJUSTMENT_ROW->reason ?></td>
                                            <td><?= $DISP_TIME_ADJUSTMENT_ROW->status ?></td>
                                            <td><?= $DISP_TIME_ADJUSTMENT_ROW->comment ?></td>
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
                <form action="<?php echo base_url('attendance/insrt_time_adjustment'); ?>" id="form_time_adjustment" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
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
                        <a class='btn btn-primary text-light' id="btn_apply_time_adjustment">&nbsp; Apply
                        </a>
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
            //Timepicker time in
            $('#timepicker').datetimepicker({
                stepping: 30,
                format: 'LT'
            })
            // Timepicker time out
            $('#timepicker2').datetimepicker({
                stepping: 30,
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
        })
    </script>

</body>
</html>
