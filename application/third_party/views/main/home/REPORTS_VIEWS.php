<style>
    div.dataTables_wrapper div.dataTables_paginate {
        display: flex;
    }

    .card {
        padding: 0px !important;
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

    .page-title {
        font-weight: 600;
        color: #424F5C;
        font-size: 33px;
    }

    th,
    td {
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

    @media (min-width: 500px) {
        .col-lg-15 {
            width: 50%;
            float: left;
        }
    }

    @media (min-width: 992px) {
        .col-lg-15 {
            width: 30%;
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
<!-- Daterange Picker -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/daterangepicker/daterangepicker.css">

<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-md-6">
                <h1 class="page-title">Attendance Reports</h1>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <div class="btn-group mr-2">
                    <a href="#" id="btn_export" type="button" class="btn btn-primary shadow-none">Export Records</a>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <label>Cut-off Period</label>
                <select name="cutoff_period" id="cutoff_period" class="form-control">
                    <?php
                    $initial_cutoff_period = '';
                    if ($DISP_PAYROLL_SCHED) {

                        $cutoff_period = $this->input->get('cutoff');

                        foreach ($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW) {
                            $initial_cutoff_period = $DISP_PAYROLL_SCHED_ROW->db_name;
                    ?>
                            <option value="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>" db_date="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>" <?php if ($cutoff_period == $DISP_PAYROLL_SCHED_ROW->db_name) {
                                                                                                                                            echo 'selected';
                                                                                                                                        } ?>><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label>Specific Date Period</label>
                <div class="input-group mb-3">
                    <input class="form-control form-control " type="text" name="date_period" id="date_period">
                    <input class="form-control form-control " type="hidden" name="date_range" id="date_range">
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-lg-15">
                <div class="card p-3">
                    <div class="card-header">
                        <p class="text-bold text-success mb-1">Present</p>
                    </div>
                    <div class="card-body p-3">
                        <h3 id="display_all_present" class="text-success">0</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-15">
                <div class="card p-3">
                    <div class="card-header">
                        <p class="text-bold text-danger mb-1">Absent</p>
                    </div>
                    <div class="card-body p-3">
                        <h3 id="display_all_absent" class="text-danger">0</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-15">
                <div class="card p-3">
                    <div class="card-header">
                        <p class="text-bold mb-1" style="color: #f75831">Late</p>
                    </div>
                    <div class="card-body p-3">
                        <h3 id="display_all_late" style="color: #f75831">0</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-15">
                <div class="card p-3">
                    <div class="card-header">
                        <p class="text-bold mb-1" style="color: #ff8040">Undertime</p>
                    </div>
                    <div class="card-body p-3">
                        <h3 id="display_all_undertime" style="color: #ff8040">0</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-15">
                <div class="card p-3">
                    <div class="card-header">
                        <p class="text-bold mb-1">On Leave</p>
                    </div>
                    <div class="card-body p-3">
                        <h3 id="display_all_leave">0</h3>
                    </div>
                </div>
            </div>

        </div>


        <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
            <table id="tbl_employees" class="table table-hover">
                <thead>
                    <tr>
                        <th>Cut-off Period</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Group</th>
                        <th>Position</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Late</th>
                        <th>Undertime</th>
                        <th>On Leave</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $all_present = 0;
                    $all_absent = 0;
                    $all_late = 0;
                    $all_undertime = 0;
                    $all_leave = 0;

                    if ($DISP_DISTINCT_EMPL_ATT) {

                        foreach ($DISP_DISTINCT_EMPL_ATT as $DISP_DISTINCT_EMPL_ATT_ROW) {
                            $empl_id = $DISP_DISTINCT_EMPL_ATT_ROW->empl_id;

                            $cutoff = $this->input->get('cutoff');

                            if (!$cutoff) {
                                $cutoff = $initial_cutoff_period;
                            }

                            $split_date = explode(' - ', $cutoff);
                            $date1 = $split_date[0];
                            $date2 = $split_date[1];
                            $start_date = date('Y-m-d', strtotime($date1));
                            $end_date = date('Y-m-d', strtotime($date2));

                            $display_start_date = date('M d, Y', strtotime($date1));
                            $display_end_date = date('M d, Y', strtotime($date2));
                            $cutoff_period = $display_start_date . ' - ' . $display_end_date;

                            $attendance_data = $this->p010_home_mod->MOD_DISP_ATTENDANCE_DATA($start_date, $end_date, $empl_id);
                            $employee_data = $this->p010_home_mod->MOD_DISP_EMPLOYEE_INFO($empl_id);

                            $empl_name = '';
                            $empl_cmid = '';
                            $empl_posi = '';
                            $empl_group = '';

                            $present = 0;
                            $absent = 0;
                            $late = 0;
                            $undertime = 0;
                            $leave = 0;

                            foreach ($employee_data as $employee_data_row) {
                                if (!empty($employee_data_row->col_midl_name)) {
                                    $midl_ini = $employee_data_row->col_midl_name[0] . '.';
                                } else {
                                    $midl_ini = '';
                                }
                                $empl_name = $employee_data_row->col_last_name . ', ' . $employee_data_row->col_frst_name . ' ' . $midl_ini;
                                $empl_cmid = $employee_data_row->col_empl_cmid;
                                $empl_posi = $employee_data_row->col_empl_posi;
                                $empl_group = $employee_data_row->col_empl_group;
                            }

                            foreach ($attendance_data as $attendance_data_row) {

                                if ($attendance_data_row->status == 'Present') {
                                    $present++;
                                }
                                if ($attendance_data_row->status == 'Absent') {
                                    $absent++;
                                }

                                $late += $attendance_data_row->late;
                                $undertime += $attendance_data_row->undertime;
                                $leave += $attendance_data_row->paid_leave;
                            }


                            if (count($employee_data) > 0) {
                                if (($empl_cmid != '9999') && ($empl_cmid != '8888') && ($empl_cmid != '8888') && ($empl_cmid != '999998')) {
                    ?>
                                    <tr>
                                        <td><?= $cutoff_period ?></td>
                                        <td><?= $empl_cmid ?></td>
                                        <td><?= $empl_name ?></td>
                                        <td><?= $empl_group ?></td>
                                        <td><?= $empl_posi ?></td>
                                        <td><?= $present ?></td>
                                        <td><?= $absent ?></td>
                                        <td><?= $late ?></td>
                                        <td><?= $undertime ?></td>
                                        <td><?= $leave ?></td>
                                    </tr>
                        <?php

                                    $all_present += $present;
                                    $all_absent += $absent;
                                    $all_late += $late;
                                    $all_undertime += $undertime;
                                    $all_leave += $leave;
                                }
                            }
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="10">No Record Yet</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
<!-- 
            <div class="w-100 text-center">
                <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
            </div> -->

        </div>

    </div>
</div>

<aside class="control-sidebar control-sidebar-dark"></aside>

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
<!-- DateRange Picker -->
<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>


<?php
if ($this->session->userdata('SESS_SUCC_INSRT')) {
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
if ($this->session->userdata('SESS_ERR_IMAGE')) {
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
    $(document).ready(function() {


        // var table = setTimeout(() => {
        table()

        function table() {
            // ===================== ACTIVATE DATATABLE PLUGIN =======================
            var empl_tbl = $('#tbl_employees').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "autoWidth": false,
                "info": false,
                language: {
                    'paginate': {
                        'previous': '&lt;</span>',
                        'next': '&gt;</span>'
                    }
                }
            })
            $('#tbl_employees_filter').parent().parent().hide();
        }
        // }, 1500);
        var url_get_report_data = '<?= base_url() ?>home/get_report_data';

        $('#display_all_present').text('<?= $all_present ?>');
        $('#display_all_absent').text('<?= $all_absent ?>');
        $('#display_all_late').text('<?= $all_late ?>');
        $('#display_all_undertime').text('<?= $all_undertime ?>');
        $('#display_all_leave').text('<?= $all_leave ?>');


        $('#date_period').daterangepicker();

        $('#date_period').on('apply.daterangepicker', function(ev, picker) {
            var cutoff_period = $(this).val();
            console.log(cutoff_period);


            $('#loader_gif').show();

            $('#tbl_employees tbody').html('');

            get_report_data(url_get_report_data, cutoff_period).then(function(data) {
                console.log(data);
                // $('#tbl_employees tbody').html(data.att_info);

                var all_present = 0;
                var all_absent = 0;
                var all_late = 0;
                var all_undertime = 0;
                var all_leave = 0;

                Array.from($('#tbl_employees tbody tr')).forEach(function(e) {
                    var td_present = $(e).children()[5];
                    var td_absent = $(e).children()[6];
                    var td_late = $(e).children()[7];
                    var td_undertime = $(e).children()[8];
                    var td_leave = $(e).children()[9];

                    all_present += parseInt($(td_present).text());
                    all_absent += parseInt($(td_absent).text());
                    all_late += parseInt($(td_late).text());
                    all_undertime += parseInt($(td_undertime).text());
                    all_leave += parseInt($(td_leave).text());
                })

                $('#display_all_present').text(all_present);
                $('#display_all_absent').text(all_absent);
                $('#display_all_late').text(all_late);
                $('#display_all_undertime').text(all_undertime);
                $('#display_all_leave').text(all_leave);

                $('#loader_gif').hide();


            })
        });



        $('#cutoff_period').change(function(e) {
            var cutoff_period = $(this).find('option:selected').val();
            console.log(cutoff_period);



            $('#loader_gif').show();

            $('#tbl_employees tbody').html('');

            get_report_data(url_get_report_data, cutoff_period).then(function(data) {

                var report_data = JSON.parse(data);

                var att_rec_info = report_data.att_rec_info;
                var all_present = report_data.all_present;
                var all_absent = report_data.all_absent;
                var all_late = report_data.all_late;
                var all_undertime = report_data.all_undertime;
                var all_leave = report_data.all_leave;


                $('#tbl_employees tbody').html(att_rec_info);

                Array.from($('#tbl_employees tbody tr')).forEach(function(e) {

                    // console.log($(e).children());

                    var td_present = $(e).children()[5];
                    var td_absent = $(e).children()[6];
                    var td_late = $(e).children()[7];
                    var td_undertime = $(e).children()[8];
                    var td_leave = $(e).children()[9];

                    // all_present += parseInt($(td_present).text());
                    // all_absent += parseInt($(td_absent).text());
                    // all_late += parseInt($(td_late).text());
                    // all_undertime += parseInt($(td_undertime).text());
                    // all_leave += parseInt($(td_leave).text());

                    // console.log('all_present: ' + all_present);
                    // console.log('all_absent: ' + all_absent);
                    // console.log('all_late: ' + all_late);
                    // console.log('all_undertime: ' + all_undertime);
                    // console.log('all_leave: ' + all_leave);
                })

                $('#display_all_present').text(all_present);
                $('#display_all_absent').text(all_absent);
                $('#display_all_late').text(all_late);
                $('#display_all_undertime').text(all_undertime);
                $('#display_all_leave').text(all_leave);

                $('#loader_gif').hide();


            })


        })


        // Quick and simple export target #table_id into a csv
        $('#btn_export').click(function() {
            var table_id = 'tbl_employees';
            var separator = ',';

            // Select rows from table_id
            var rows = document.querySelectorAll('table#' + table_id + ' tr');
            // Construct csv
            var csv = [];
            for (var i = 0; i < rows.length; i++) {
                var row = [],
                    cols = rows[i].querySelectorAll('td, th');
                for (var j = 0; j < cols.length; j++) {
                    // Clean innertext to remove multiple spaces and jumpline (break csv)
                    var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                    // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
                    data = data.replace(/"/g, '""');
                    // Push escaped string
                    row.push('"' + data + '"');
                }
                csv.push(row.join(separator));
            }
            var csv_string = csv.join('\n');


            // Download it
            var filename = 'Export_Employee_Data.csv';
            var link = document.createElement('a');
            link.style.display = 'none';
            link.setAttribute('target', '_blank');
            link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
            link.setAttribute('download', filename);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        })




        // ================================ ASYNC FILTER ===================================

        async function get_report_data(url, cutoff) {
            var formData = new FormData();
            formData.append('cutoff', cutoff);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.text();
        }

    })
</script>
</body>

</html>