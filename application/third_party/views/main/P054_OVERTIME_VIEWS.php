<style>
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
</style>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-md-6">
                <h1><b>Overtime</b>
                    <h1>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <div class="btn-group mr-2">
                    <a href="<?= base_url() ?>employees/new_employee" type="button" data-toggle="modal" data-target="#modal_application_overtime" class="btn btn-primary shadow-none"><i class="fas fa-plus"></i> Application for Overtime</a>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="background-color: white;"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search by name, email or phone number" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
            <div style="overflow-x:auto;">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>Application ID</td>
                            <td>Application Date</td>
                            <td>Overtime Date</td>
                            <td>Time Out</td>
                            <td>No. of Hours</td>
                            <td>Reason</td>
                            <td>Status</td>
                            <td>Comment</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if($DISP_OVERTIME){
                                foreach($DISP_OVERTIME as $DISP_OVERTIME_ROW){
                                    $application_id = 'OT'.str_pad($DISP_OVERTIME_ROW->id, 5, '0', STR_PAD_LEFT);
                                    $db_time_out = explode(':',$DISP_OVERTIME_ROW->time_out);
                                    $time_out = $db_time_out[0].':'.$db_time_out[1];
                                ?>
                                    <tr>
                                        <td><?= $application_id ?></td>
                                        <td><?= $DISP_OVERTIME_ROW->date_created ?></td>
                                        <td><?= $DISP_OVERTIME_ROW->date_ot ?></td>
                                        <td><?= $time_out ?></td>
                                        <td><?= $DISP_OVERTIME_ROW->hours ?></td>
                                        <td><?= $DISP_OVERTIME_ROW->reason ?></td>
                                        <td><?= $DISP_OVERTIME_ROW->status ?></td>
                                        <td></td>
                                    </tr>
                                <?php
                                }
                            }
                        ?>
                        <!-- <tr>
                            <td>OT00001</td>
                            <td>07/03/2021</td>
                            <td>07/04/2021</td>
                            <td>18:00</td>
                            <td>2.0</td>
                            <td>Maintenance Activity</td>
                            <td>Pending</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>OT00002</td>
                            <td>07/03/2021</td>
                            <td>07/04/2021</td>
                            <td>18:00</td>
                            <td>3.0</td>
                            <td>Maintenance Activity</td>
                            <td>Rejected</td>
                            <td>Duplicated Application</td>
                        </tr>
                        <tr>
                            <td>OT00002</td>
                            <td>07/04/2021</td>
                            <td>07/05/2021</td>
                            <td>18:00</td>
                            <td>1.0</td>
                            <td>Maintenance Activity</td>
                            <td>Approved</td>
                            <td></td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- =============== Application Overtime ================= -->
<div class="modal fade" id="modal_application_overtime" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Application for Overtime
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;
                    </span>
                </button>
            </div>
            <form action="<?php echo base_url('attendance/insrt_overtime'); ?>" id="form_add_overtime" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required " for="OVERTIME_INPF_OVRTIME_DATE">Overtime Date
                                </label>
                                <input type="date" name="overtime_date" id="overtime_date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="required " for="OVERTIME_INPF_OVRTIME_DATE">Time Out
                                </label>
                                <div class="input-group date" id="timepicker" data-target-input="nearest" style="width: 100% !important;">
                                    <input type="text" class="form-control datetimepicker-input time_text mr-0" data-target="#timepicker" id="time_out" placeholder="hr:min" required>
                                    <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="required " for="reason">No. of Hours
                                </label>
                                <input type="number" name="num_hours" id="num_hours" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="required " for="reason">Reason
                                </label>
                                <textarea name="reason" id="reason" class="form-control" cols="30" rows="03"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="time_out" id="time_out_formatted">
                    <a class='btn btn-primary text-light' id="btn_apply_overtime">&nbsp; Apply
                    </a>
                </div>
            </form>
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
<!-- InputMask (Required for Timepicker)-->
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_OVERTIME')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_OVERTIME'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_OVERTIME');
}
?>
<?php
if ($this->session->userdata('SESS_ERR_MSG_INSRT_OVERTIME')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_OVERTIME'); ?>',
            '',
            'error'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_ERR_MSG_INSRT_OVERTIME');
}
?>
<script>
    $(document).ready(function() {
        //Timepicker
        $('#timepicker').datetimepicker({
            stepping: 30,
            format: 'LT'
        })

        $('#btn_apply_overtime').click(function(e) {
            var overtime_date = $('#overtime_date').val();
            var time_out = $('#time_out').val();
            var num_hours = $('#num_hours').val();
            var reason = $('#reason').val();
            var hasErr = 0;

            var time_out_formatted = moment(time_out, "LT").format("HH:mm");
            $('#time_out_formatted').val(time_out_formatted);

            if (!overtime_date) {
                hasErr++;
                $('#overtime_date').addClass('is-invalid');
            }
            if (!time_out) {
                hasErr++;
                $('#time_out').addClass('is-invalid');
            }
            if (!num_hours) {
                hasErr++;
                $('#num_hours').addClass('is-invalid');
            }
            if (!reason) {
                hasErr++;
                $('#reason').addClass('is-invalid');
            }

            if (!hasErr) {
                $('#form_add_overtime').submit();
            } else {
                e.preventDefault();
            }
        })

        $('#overtime_date').change(function() {
            $('#overtime_date').removeClass('is-invalid');
        })

        $('#time_out').blur(function() {
            $('#time_out').removeClass('is-invalid');
        })

        $('#num_hours').keyup(function() {
            $('#num_hours').removeClass('is-invalid');
        })

        $('#num_hours').change(function() {
            $('#num_hours').removeClass('is-invalid');
        })

        $('#reason').keyup(function() {
            $('#reason').removeClass('is-invalid');
        })
    })
</script>
</body>

</html>