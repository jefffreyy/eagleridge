<!-- 
  
TECHNOS SYSTEM ENGINEERING INC.
EyeBox HRMS

@author     Technos Developers
@datetime   12 October 2022
@purpose    My Overtime

-->

<!--------------------------------------------------------- A. STYLESHEETS  ----------------------------------------------------->
<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Daterange Picker -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/daterangepicker/daterangepicker.css">
<!-- Tempus Dominus -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Pagination -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">
<!-- Datatable -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">

<!------------------------------------------------------------- B. CSS  --------------------------------------------------------->
<style>
  /* Technos Standard: For Desktop: */
  .btn-group .btn {
    padding: 0px 12px;
  }

  .page-title {
    font-weight: 600;
    color: #424F5C;
    font-size: 33px;
  }

  .button-title {
    text-align: right;
  }

  th,
  td {
    font-size: 13px !important;
  }

  label.required::after {
    content: " *";
    color: red;
  }

  /* Technos Standard: For mobile phones: */
  @media only screen and (max-width: 768px) {

    .page-title {
      font-weight: 600;
      color: #424F5C;
      font-size: 22px;

    }

    .button-title {
      text-align: left;
      margin-top: 5px;
    }
  }
</style>


<?php
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

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="page-title">My Overtime<h1>
                </div>
                <div class="col-md-6 button-title">
                    <a href="#" id="btn_application" data-toggle="modal" data-target="#modal_application_overtime" class="btn btn-primary shadow-none"><i class="fas fa-plus"></i> Overtime Request</a>
                </div>
            </div>
            <hr>

            <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th>Overtime&nbsp;ID</th>
                                    <th>Application&nbsp;Date</th>
                                    <th>Employee</th>
                                    <th>Overtime&nbsp;Date</th>
                                    <th>Type</th>
                                    <th>Time Out</th>
                                    <th>Duration&nbsp;(Hours)</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </thead>
                                <tbody id="tbl_application_container">
                                    <?php
                                    if ($DISP_OVERTIME) {
                                        foreach ($DISP_OVERTIME as $DISP_OVERTIME_ROW) {
                                            $application_id = 'OT' . str_pad($DISP_OVERTIME_ROW->id, 5, '0', STR_PAD_LEFT);
                                            $db_time_out = explode(':', $DISP_OVERTIME_ROW->time_out);
                                            $time_out = $db_time_out[0] . ':' . $db_time_out[1];
                                            $application_date = date('l, F j, Y', strtotime($DISP_OVERTIME_ROW->date_created));
                                            $date_ot = date('l, F j, Y', strtotime($DISP_OVERTIME_ROW->date_ot));

                                            $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_OVERTIME_ROW->empl_id);
                                            if (!empty($employee[0]->col_midl_name)) {
                                                $midl_ini = $employee[0]->col_midl_name[0] . '.';
                                            } else {
                                                $midl_ini = '';
                                            }
                                    ?>
                                            <tr class="ot_row" style="cursor: pointer;" data-toggle="modal" data-target="#modal_overtime_details" employee_id="<?= $DISP_OVERTIME_ROW->empl_id ?>" overtime_id="<?= $DISP_OVERTIME_ROW->id ?>">
                                                <td><?= $application_id ?></td>
                                                <td><?= $application_date ?></td>
                                                <td>
                                                    <a href="#">
                                                        <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($employee[0]->col_imag_path) {
                                                                                                                            echo base_url() . 'user_images/' . $employee[0]->col_imag_path;
                                                                                                                        } else {
                                                                                                                            echo base_url() . 'user_images/default_profile_img3.png';
                                                                                                                        } ?>">&nbsp;&nbsp;<?= $employee[0]->col_last_name . ', ' . $employee[0]->col_frst_name . ' ' . $midl_ini ?>
                                                    </a>
                                                </td>
                                                <td><?= $date_ot ?></td>
                                                <td><?= $DISP_OVERTIME_ROW->type ?></td>
                                                <td><?= $time_out ?></td>
                                                <td><?= $DISP_OVERTIME_ROW->hours ?></td>
                                                <td><?= $DISP_OVERTIME_ROW->reason ?></td>
                                                <td>
                                                    <?php
                                                    if (($DISP_OVERTIME_ROW->status1 == 'Rejected') || ($DISP_OVERTIME_ROW->status2 == 'Rejected')) {
                                                        echo 'Rejected';
                                                    } else if (($DISP_OVERTIME_ROW->status1 == 'Approved') && ($DISP_OVERTIME_ROW->status2 == 'Approved')) {
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
                                            <td colspan="9">
                                                <center>You haven't submitted any overtime application yet</center>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
      <!-- Pagination -->
      <right>
        <ul id="btn_pagination" class="pagination mr-auto ml-auto"></ul>
      </right>
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
                <form action="<?php echo base_url('attendance/insrt_my_overtime'); ?>" id="form_add_overtime" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required " for="EMPLOYEE">Employee ID</label>
                                    <select name="EMPLOYEE" id="EMPLOYEE" class="form-control" disabled>
                                        <?php
                                        $user_data = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($this->session->userdata('SESS_USER_ID'));
                                        if (!empty($user_data[0]->col_midl_name)) {
                                            $midl_ini = $user_data[0]->col_midl_name[0] . '.';
                                        } else {
                                            $midl_ini = '';
                                        }
                                        ?>
                                        <option value=""><?= $user_data[0]->col_empl_cmid . ' - ' . $user_data[0]->col_last_name . ' ' . $user_data[0]->col_frst_name . ' ' . $midl_ini; ?></option>
                                        <?php
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required " for="overtime_date">Overtime Date</label>
                                    <input type="date" name="overtime_date" id="overtime_date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="required " for="overtime_type">Type</label>
                                    <select name="overtime_type" id="overtime_type" class="form-control" required>
                                        <option value="">Choose Type...</option>
                                        <option value="Regular OT">Regular OT</option>
                                        <option value="Night Shift OT">Night Shift OT</option>
                                        <option value="Rest OT">Rest OT</option>
                                    </select>
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
                                    <input type="number" name="num_hours" step="0.5" id="num_hours" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="required " for="reason">Reason
                                    </label>
                                    <textarea name="reason" id="reason" class="form-control" cols="30" rows="03" required></textarea>
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



    <!-- View For Approval Overtime Details -->
    <div class="modal fade" id="modal_overtime_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <h4 class="modal-title mt-0 ml-1">Overtime Details
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
                                <img id="ot_modal_employee_img" class="rounded-circle" alt="" style="width: 150px; height: 150px;">
                            </div>
                            <div class="pl-3 mt-3">
                                <p class="text-bold mb-1">Name:</p>
                                <p class="mb-4" id="ot_employee_name"></p>
                                <p class="text-bold mb-1">Position:</p>
                                <p class="mb-4" id="ot_employee_position"></p>
                                <p class="text-bold mb-1">Department:</p>
                                <p class="mb-4" id="ot_employee_department"></p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mt-3">
                                        <p class="text-bold mb-1">Application Date:</p>
                                        <p class="mb-4" id="ot_application_date"></p>
                                        <p class="text-bold mb-1">Overtime Date:</p>
                                        <p class="mb-4" id="ot_overtime_date"></p>
                                        <p class="text-bold mb-1">Time Out:</p>
                                        <p class="mb-4" id="ot_time_out"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mt-3">
                                        <p class="text-bold mb-1">Type:</p>
                                        <p class="mb-4" id="ot_type"></p>
                                        <p class="text-bold mb-1">No. of Hours:</p>
                                        <p class="mb-4" id="ot_num_hours"></p>
                                        <p class="text-bold mb-1">Reason:</p>
                                        <p class="mb-4" id="ot_reason"></p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-bold mb-1">Status:</p>
                                    <p id="ot_status" class="text-success"></p>
                                </div>
                                <div class="col-md-6" id="reason_rejection">
                                    <p class="text-bold mb-1 text-danger">Reason for Rejection:</p>
                                    <p id="ot_rejection_comment"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="current_date" id="current_date" value="<?= date('Y-m-d') ?>" class="form-control">

    <?php
    $page_count = $DISP_ROW_COUNT[0]->mot_count / 20;

    if (($DISP_ROW_COUNT[0]->mot_count % 20) != 0) {
        $page_count = $page_count++;
    }

    $page_count = ceil($page_count);
    ?>

    <input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT[0]->mot_count ?>">
    <input type="hidden" id="page_count" value="<?= $page_count ?>">

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
    <!-- Pagination -->
    <script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>
    <!-- Data table -->
    <script src="<?= base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

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
            var url_get_my_overtime_data = '<?= base_url() ?>attendance/get_my_overtime_data';
            var url_get_overtime_data = '<?php echo base_url(); ?>approval/get_overtime_data';
            var base_url = '<?= base_url() ?>';

            //Timepicker
            $('#timepicker').datetimepicker({
                // stepping: 30,
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











            // SHOW OVERTIME DETAILS
            $('.ot_row').click(function() {
                var modal_employee_id = $(this).attr('employee_id');
                var modal_overtime_id = $(this).attr('overtime_id');


                get_overtime_data(url_get_overtime_data, modal_employee_id, modal_overtime_id).then(data => {
                    data.overtime_data.forEach((overtimeData) => {
                        var application_id = 'OT' + (e.id).padStart(5, 0);
                        var application_date = overtimeData.date_created;
                        var overtime_date = overtimeData.date_ot;
                        var time_out = overtimeData.time_out;
                        var type = overtimeData.type;
                        var hours = overtimeData.hours;
                        var reason = overtimeData.reason;
                        var status1 = overtimeData.status1;
                        var status2 = overtimeData.status2;
                        // var status3 = overtimeData.status3;


                        $('#ot_application_date').text(application_date);
                        $('#ot_overtime_date').text(overtime_date);
                        $('#ot_time_out').text(time_out);
                        $('#ot_type').text(type);
                        $('#ot_num_hours').text(hours + ' hrs');
                        $('#ot_reason').text(reason);
                        // $('#ot_status1').text(status1);
                        // $('#ot_status2').text(status2);
                        // $('#ot_status3').text(status3);

                        if ((status1 == "Approved") && (status2 == "Approved")) {
                            $('#ot_status').attr('class', 'text-bold text-success');
                            $('#ot_status').text('Approved');
                        } else if ((status1 == "Pending") || (status2 == "Pending")) {
                            $('#ot_status').attr('class', 'text-bold text-secondary');
                            $('#ot_status').text('Pending');
                        } else if ((status1 == "Rejected") || (status2 == "Rejected")) {
                            $('#ot_status').attr('class', 'text-bold text-danger');
                            $('#ot_status').text('Rejected');
                        }

                        if (overtimeData.comment) {
                            $('#reason_rejection').show();
                            $('#ot_rejection_comment').text(overtimeData.comment);
                        } else {
                            $('#ot_rejection_comment').text('');
                            $('#reason_rejection').hide();
                        }

                    })
                    data.employee_data.forEach((employeeData) => {
                        $('#ot_employee_name').text(employeeData.col_frst_name + ' ' + employeeData.col_last_name);
                        $('#ot_employee_position').text(employeeData.col_empl_posi);
                        $('#ot_employee_department').text(employeeData.col_empl_dept);

                        if (employeeData.col_imag_path) {
                            $('#ot_modal_employee_img').attr('src', base_url + 'user_images/' + employeeData.col_imag_path);
                        } else {
                            $('#ot_modal_employee_img').attr('src', base_url + 'user_images/' + 'default_profile_img3.png');
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
                click: function(e) {
                    $('#tbl_application_container').html('');

                    var row_count = $('#row_count').val();
                    var page_count = $('#page_count').val();
                    // console.log(e.current);
                    var page_num = e.current;

                    // console.log(page_num);

                    get_my_overtime_data(url_get_my_overtime_data, page_num).then(function(data) {
                        console.log(data);
                        Array.from(data).forEach(function(e) {
                            var application_id = 'OT' + (e.id).padStart(5, 0);
                            var application_date = e.date_created;
                            var overtime_date = e.date_ot;
                            var time_out = e.time_out;
                            var type = e.type;
                            var hours = e.hours;
                            var reason = e.reason;
                            var empl_id = e.empl_id;
                            var status1 = e.status1;
                            var status2 = e.status2;

                            var application_date = new Date(application_date).toLocaleDateString('en-us', {
                                weekday: "long",
                                year: "numeric",
                                month: "short",
                                day: "numeric"
                            });
                            var overtime_date = new Date(overtime_date).toLocaleDateString('en-us', {
                                weekday: "long",
                                year: "numeric",
                                month: "short",
                                day: "numeric"
                            });

                            if ((status1 == "Approved") && (status2 == "Approved")) {
                                status = "Approved";
                            } else if ((status1 == "Pending") || (status2 == "Pending")) {
                                status = "Pending";
                            } else if ((status1 == "Rejected") || (status2 == "Rejected")) {
                                status = "Rejected";
                            }
                            var time_out = time_out.split(':');
                            var time_out = time_out[0] + ':' + time_out[1];
                            $('#tbl_application_container').append(`
                            <tr  class="ot_row" style="cursor: pointer;" data-toggle="modal" data-target="#modal_overtime_details" employee_id="` + empl_id + `" overtime_id="` + application_id + `">
                                <td>` + application_id + `</td>
                                <td>` + application_date + `</td>
                                <td>
                                            <a href = "#">
                                                <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($employee[0]->col_imag_path) {
                                                                                                                    echo base_url() . 'user_images/' . $employee[0]->col_imag_path;
                                                                                                                } else {
                                                                                                                    echo base_url() . 'user_images/default_profile_img3.png';
                                                                                                                } ?>">&nbsp;&nbsp;<?= $employee[0]->col_last_name . ', ' . $employee[0]->col_frst_name . ' ' . $midl_ini ?>
                                            </a>
                                </td>
                                <td>` + overtime_date + `</td>
                                <td>` + type + `</td>
                                <td>` + time_out + `</td>
                                <td>` + hours + `</td>
                                <td>` + reason + `</td>
                                <td>` + status + `</td>
                            </tr>
                        `)
                        })
                    })

                }
            });


            async function get_my_overtime_data(url, page_num) {
                var formData = new FormData();
                formData.append('page_num', page_num);
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                return response.json();
            }


















            // $('#btn_application').click(function(){
            //     var current_date = $('#current_date').val();
            //     var date_of_overtime = $(this).attr('date_of_overtime');
            //     var pending_ot_application_length = $(this).attr('pending_ot_application_length');
            //     var approved_ot_application_length = $(this).attr('approved_ot_application_length');


            //     console.log(date_of_overtime);
            //     console.log(pending_ot_application_length);
            //     console.log(approved_ot_application_length);

            //     if(parseInt(pending_ot_application_length) > 0){
            //         Swal.fire(
            //             'Please wait for your application approval.',
            //             'You still have pending application',
            //             'error'
            //         )
            //     } else {
            //         if(current_date == date_of_overtime){
            //             // console.log('Your overtime application is already approved. Please try again tomorrow');
            //             Swal.fire(
            //                 'Please try again tomorrow.',
            //                 'Your overtime application for today is already approved.',
            //                 'error'
            //             )
            //         } else {
            //             $('#modal_application_overtime').modal('toggle');
            //         }

            //     }
            // })

















            async function get_overtime_data(url, employee_id, overtime_id) {
                var formData = new FormData();
                formData.append('employee_id', employee_id);
                formData.append('overtime_id', overtime_id);
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