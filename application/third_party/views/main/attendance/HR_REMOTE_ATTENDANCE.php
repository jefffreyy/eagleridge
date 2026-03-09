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

    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;

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
            <div class="col-md-6">
                <h1 class="page-title">Remote Attendance</h1>

            </div>
            <div class="col-md-6" style="text-align: right;">
                <!-- <a href = "#" id="save_user_access" type ="button" class = "btn btn-primary shadow-none">Save Changes</a>
                    <div class="spinner-border text-primary" style="display: none;" id="loading_indicator_user_access"></div> -->
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="background-color: white;"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search by name, email or phone number" id="filter_employee" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>


        <div class="row mt-4">
            <div class="col-md-2">
                <label for="">Filter by Department</label>
                <select id="filter_by_department" class="form-control">
                    <?php
                    if ($DISP_DISTINCT_DEPARTMENT) {
                    ?>
                        <option value="" <?php foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW_1) {
                                                if ($DISP_DISTINCT_DEPARTMENT_ROW_1->col_empl_dept == '') {
                                                    echo 'selected';
                                                }
                                            } ?>>All Departments</option>
                        <?php
                        foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW) {
                            if ($DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept != '') {
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
                    if ($DISP_DISTINCT_SECTION) {
                    ?>
                        <option value="" <?php foreach ($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW_1) {
                                                if ($DISP_DISTINCT_SECTION_ROW_1->col_empl_sect == '') {
                                                    echo 'selected';
                                                }
                                            } ?>>All Sections</option>
                        <?php
                        foreach ($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW) {
                            if ($DISP_DISTINCT_SECTION_ROW->col_empl_sect != '') {
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
                    if ($DISP_Group) {
                    ?>
                        <option value="" <?php foreach ($DISP_Group as $DISP_Group_ROW_1) {
                                                if ($DISP_Group_ROW_1->col_empl_group == '') {
                                                    echo 'selected';
                                                }
                                            } ?>>All Groups</option>
                        <?php
                        foreach ($DISP_Group as $DISP_Group_ROW) {
                            if ($DISP_Group_ROW->col_empl_group != '') {
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
                    if ($DISP_Line) {
                    ?>
                        <option value="" <?php foreach ($DISP_Line as $DISP_Line_ROW_1) {
                                                if ($DISP_Line_ROW_1->col_empl_line == '') {
                                                    echo 'selected';
                                                }
                                            } ?>>All Lines</option>
                        <?php
                        foreach ($DISP_Line as $DISP_Line_ROW) {
                            if ($DISP_Line_ROW->col_empl_line != '') {
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
                <label for="">Attendance Type</label>
                <select id="filter_by_attendance_status" class="form-control">
                    <option value="3">All Types</option>
                    <option value="1">Remote</option>
                    <option value="0">Onsite</option>
                </select>
            </div>
            <div class="col-md-2">
                <br>
                <a href="#" id="btn_clear_filter" class="btn btn-primary float-right">Clear Filter</a>
            </div>
        </div>

        <br>

        <div class="row mt-4">
            <div class="col-6">
                <div class="card p-2" style="background-color: #00897b; color: white;">
                    <div style="padding: 10px 1px;" class="text-center">
                        <text style="font-size: 20px; margin-bottom: -15px;" id="total_empl_remote">
                            0
                        </text><br>
                        <text><b>Remote </b></text>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card p-2" style="background-color: #5E35B1; color: white;">
                    <div style="padding: 10px 1px;" class="text-center">
                        <text style="font-size: 20px; margin-bottom: -15px;" id="total_empl_onsite">
                            0
                        </text><br>
                        <text class="text-bold">Onsite</text>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <a href="#" class="btn btn-primary" id="check_all">Check All</a>
        <a href="#" id="disable_remote_attendance" type="button" class="btn btn-danger shadow-none float-right" remote_attendance="0">Disable Remote Attendance</a>
        <a href="#" id="enable_remote_attendance" type="button" class="btn btn-success shadow-none float-right mr-3" remote_attendance="1">Enable Remote Attendance</a>

        <div class="spinner-border text-primary float-right" style="display: none;" id="loading_indicator_user_access"></div>

        <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
            <table class="table table-hover" id="employee_tbl">
                <thead>
                    <tr>
                        <th></th>
                        <th>Employee Id</th>
                        <th>Full Name</th>
                        <th>Position</th>
                        <th>Attendance Type</th>
                    </tr>
                </thead>
                <tbody id="table_container">
                    <?php
                    if ($DISP_EMP_LIST) {
                        foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) {
                            if ($DISP_EMP_LIST_ROW->col_empl_cmid != "999998") {

                                $chk_id = 'chk_id' . $DISP_EMP_LIST_ROW->id;

                                $type = '';
                                if ($DISP_EMP_LIST_ROW->remote_att > 0) {
                                    $type = 'Remote';
                                } else {
                                    $type = 'Onsite';
                                }

                                if (!empty($DISP_EMP_LIST_ROW->col_midl_name)) {
                                    $midl_ini = $DISP_EMP_LIST_ROW->col_midl_name[0] . '.';
                                } else {
                                    $midl_ini = '';
                                }
                    ?>
                                <tr class="empl_row" empl_id="<?= $DISP_EMP_LIST_ROW->id ?>">
                                    <td>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" class="selected_empl" id="<?= $chk_id ?>" empl_id="<?= $DISP_EMP_LIST_ROW->id ?>">
                                                <label for="<?= $chk_id ?>"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= $DISP_EMP_LIST_ROW->col_empl_cmid ?></td>
                                    <td><a href="<?= base_url() ?>employees/personal?id=<?= $DISP_EMP_LIST_ROW->id ?>">
                                            <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($DISP_EMP_LIST_ROW->col_imag_path) {
                                                                                                                echo base_url() . 'user_images/' . $DISP_EMP_LIST_ROW->col_imag_path;
                                                                                                            } else {
                                                                                                                echo base_url() . 'user_images/default_profile_img3.png';
                                                                                                            } ?>">&nbsp;&nbsp;<?= $DISP_EMP_LIST_ROW->col_last_name . ' ' . $DISP_EMP_LIST_ROW->col_frst_name . ' ' . $midl_ini ?></a>
                                    </td>
                                    <td><?= $DISP_EMP_LIST_ROW->col_empl_posi ?></td>
                                    <!-- <td>
                                            <select name="user_access" id="user_access" class="form-control">
                                                <option value="0" <?php if ($DISP_EMP_LIST_ROW->remote_att == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Disabled</option>
                                                <option value="1" <?php if ($DISP_EMP_LIST_ROW->remote_att == 1) {
                                                                        echo 'selected';
                                                                    } ?>>Enabled</option>
                                            </select>
                                        </td> -->
                                    <td><?= $type ?></td>
                                    <!-- <td>
                                            <input type="date" name="sched_remote" id="sched_remote" class="form-control">
                                        </td> -->
                                </tr>
                        <?php
                            }
                        }
                    } else { ?>
                        <tr>
                            <td colspan=6>No Employee Yet</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <center>
                <ul id="btn_pagination" class="pagination mr-auto ml-auto"></ul>
            </center>
            <div class="w-100 text-center">
                <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
            </div>
        </div>
    </div>
</div>

<?php
$page_count = $DISP_ROW_COUNT / 20;

if (($DISP_ROW_COUNT % 20) != 0) {
    $page_count = $page_count++;
}

$page_count = ceil($page_count);
?>

<input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT ?>">
<input type="hidden" id="page_count" value="<?= $page_count ?>">
<input type="hidden" id="current_page" value="">

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
<!-- Pagination -->
<script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>
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
    var url_get_employee_list = '<?= base_url() ?>attendance/get_employee_list';

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
            $('#table_container').html('');

            var row_count = $('#row_count').val();
            var page_count = $('#page_count').val();
            // console.log(e.current);
            var page_num = e.current;

            // console.log(page_num);

            get_employee_list(url_get_employee_list, page_num).then(function(entitle) {
                Array.from(entitle).forEach(function(e) {
                    var empl_id = e.col_empl_cmid;
                    if (e.col_midl_name) {
                        var midl_ini = e.col_midl_name + '.';
                    } else {
                        var midl_ini = '';
                    }
                    var empl_name = e.col_last_name + ', ' + e.col_frst_name + ' ' + midl_ini;
                    var id = e.id;

                    var empl_image = '<?= base_url() ?>user_images/default_profile_img3.png';
                    if (e.col_imag_path) {
                        empl_image = "<?= base_url() ?>user_images/" + e.col_imag_path;
                    }

                    var chk_id = 'chk_id' + id;

                    var type = '';
                    if (e.remote_att > 0) {
                        type = 'Remote';
                    } else {
                        type = 'Onsite';
                    }

                    $('#table_container').append(`
                        <tr class="empl_row" empl_id="` + id + `">
                            <td>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="selected_empl" id="` + chk_id + `" empl_id="` + id + `">
                                        <label for="` + chk_id + `"></label>
                                    </div>
                                </div>
                            </td>
                            <td>` + empl_id + `</td>
                            <td><a href = "<?= base_url() ?>employees/personal?id=` + id + `">
                                <img class="rounded-circle avatar " width="35" height="35" src="` + empl_image + `">&nbsp;&nbsp;` + empl_name + `</a>
                            </td>
                            <td>` + e.col_empl_posi + `</td>
                            <td>` + type + `</td>
                        </tr>
                    `)
                })
            })

        }
    });


    async function get_employee_list(url, page_num) {
        var formData = new FormData();
        formData.append('page_num', page_num);
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        return response.json();
    }
</script>
















<script>
    $(document).ready(function() {

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

        var url_get_filter_data_by_remote_status = '<?= base_url() ?>attendance/get_filter_data_by_remote_status';
        var url_count_remote_attendance = '<?= base_url() ?>attendance/count_remote_attendance';
        var url_reset_empl_password = '<?= base_url() ?>admin/reset_empl_password';
        var url_update_empl_user_access = '<?= base_url() ?>admin/update_empl_user_access';
        var url_update_empl_remote_attendance = '<?= base_url() ?>attendance/update_empl_remote_attendance';
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


        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "formatted-num-pre": function(a) {
                a = (a === "-" || a === "") ? 0 : a.replace(/[^\d\-\.]/g, "");
                return parseFloat(a);
            },

            "formatted-num-asc": function(a, b) {
                return a - b;
            },

            "formatted-num-desc": function(a, b) {
                return b - a;
            }
        });

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

        // $('#employee_tbl_filter').parent().parent().hide();
        // $('#employee_tbl_info').parent().parent().hide();

        $('#filter_employee').on('keyup', function() {
            // empl_tbl.search( this.value ).draw();
            var search_val = $(this).val();
            // console.log(search_val)
            if (search_val != '') {
                search(search_val);
            } else {
                reset_table()
            }
        });

        // ============== SEARCH =================================================================================================
        function search(search_val) {
            var url_get_searched_employee = '<?php echo base_url(); ?>employees/get_searched_employee';
            $('#table_container').html('');
            get_searched_employee(url_get_searched_employee, search_val).then(function(data) {
                Array.from(data).forEach(function(e) {
                    console.log(e)
                    var empl_image = "<?= base_url() ?>user_images/default_profile_img3.png";
                    if (e.col_imag_path) {
                        var empl_image = "<?= base_url() ?>user_images/" + e.col_imag_path;
                    }

                    if (e.col_midl_name) {
                        var midl_ini = e.col_midl_name.charAt(0) + '.';
                    } else {
                        var midl_ini = '';
                    }

                    var empl_name = e.col_last_name + ', ' + e.col_frst_name + ' ' + midl_ini;

                    var chk_id = 'chk_id' + e.id;

                    var type = '';
                    if (e.remote_att > 0) {
                        type = 'Remote';
                    } else {
                        type = 'Onsite';
                    }
                    $('#table_container').append(`
                            <tr class="empl_row" empl_id="` + e.id + `">
                                <td>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" class="selected_empl" id="` + chk_id + `" empl_id="` + e.id + `">
                                            <label for="` + chk_id + `"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>` + e.col_empl_cmid + `</td>
                                <td>
                                    <a href = "<?= base_url() ?>employees/personal?id=` + e.id + `">
                                        <img class="rounded-circle avatar " width="35" height="35" src="` + empl_image + `">&nbsp;&nbsp;` + empl_name + `
                                    </a>
                                </td>
                                <td>` + e.col_empl_posi + `</td>
                                <td>` + type + `</td>
                            </tr>
                        `)
                })
            })
        }

        function reset_table() {
            $('#table_container').html('');
            var row_count = $('#row_count').val();
            var page_count = $('#page_count').val();
            var page_num = 1;
            if ($('#current_page').val()) {
                var page_num = $('#current_page').val();
            }
            get_employee(url_get_employee, page_num).then(function(data) {
                Array.from(data).forEach(function(e) {
                    console.log(e)
                    var empl_image = "<?= base_url() ?>user_images/default_profile_img3.png";
                    if (e.col_imag_path) {
                        var empl_image = "<?= base_url() ?>user_images/" + e.col_imag_path;
                    }

                    if (e.col_midl_name) {
                        var midl_ini = e.col_midl_name.charAt(0) + '.';
                    } else {
                        var midl_ini = '';
                    }

                    var empl_name = e.col_last_name + ', ' + e.col_frst_name + ' ' + midl_ini;

                    var chk_id = 'chk_id' + e.id;

                    var type = '';
                    if (e.remote_att > 0) {
                        type = 'Remote';
                    } else {
                        type = 'Onsite';
                    }
                    $('#table_container').append(`
                            <tr class="empl_row" empl_id="` + e.id + `">
                                <td>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" class="selected_empl" id="` + chk_id + `" empl_id="` + e.id + `">
                                            <label for="` + chk_id + `"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>` + e.col_empl_cmid + `</td>
                                <td>
                                    <a href = "<?= base_url() ?>employees/personal?id=` + e.id + `">
                                        <img class="rounded-circle avatar " width="35" height="35" src="` + empl_image + `">&nbsp;&nbsp;` + empl_name + `
                                    </a>
                                </td>
                                <td>` + e.col_empl_posi + `</td>
                                <td>` + type + `</td>
                            </tr>
                        `)
                })
            })
        }

        async function get_searched_employee(url, search) {
            var formData = new FormData();
            formData.append('search', search);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_employee(url, page_num) {
            var formData = new FormData();
            formData.append('page_num', page_num);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }



        function display_filtered_empl(department, section, line, group, status) {
            $('#loader_gif').show();

            // change employee dropdown
            $('#table_container').html('');

            get_filter_data(url_get_filter_data, department, line, group, section, status).then(function(data) {

                if (data.length > 0) {

                    var count_remote = 0;
                    var count_onsite = 0;

                    Array.from(data).forEach(function(x) {
                        var staffIsSelected = '';
                        var HRIsSelected = '';
                        var AccountingIsSelected = '';
                        var AdminIsSelected = '';
                        var IsRemote = '';

                        var user_image = '';
                        var chk_id = '';
                        var empl_id = '';

                        if (x.id) {
                            chk_id = 'chk_id' + x.id;
                            empl_id = x.id;
                        }

                        if (x.col_imag_path) {
                            user_image = base_url + 'user_images/' + x.col_imag_path;

                        } else {
                            user_image = base_url + 'user_images/default_profile_img3.png';
                        }

                        var fullname = '';
                        if ((x.col_frst_name) && (x.col_last_name)) {
                            if (x.col_midl_name) {
                                var middlename = x.col_midl_name.charAt(0);
                                fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + middlename + '.';
                            } else {
                                fullname = x.col_last_name + ', ' + x.col_frst_name;
                            }

                        }

                        $('#loader_gif').hide();

                        if (x.col_user_access == 0) {
                            staffIsSelected = 'selected';
                        } else if (x.col_user_access == 2) {
                            HRIsSelected = 'selected';
                        } else if (x.col_user_access == 3) {
                            AccountingIsSelected = 'selected';
                        } else if (x.col_user_access == 4) {
                            AdminIsSelected = 'selected';
                        }

                        if (x.remote_att == 1) {
                            IsRemote = 'selected';
                        }

                        var type = '';
                        if (x.remote_att > 0) {
                            type = 'Remote';
                            count_remote++;
                        } else {
                            type = 'Onsite';
                            count_onsite++;
                        }

                        $('#table_container').append(`
                                <tr class="empl_row" empl_id="` + x.id + `">
                                    <td>
                                        <td>
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" class="selected_empl" id="chk_id` + x.id + `" empl_id="` + x.id + `">
                                                    <label for="chk_id` + x.id + `"></label>
                                                </div>
                                            </div>
                                        </td>
                                    </td>
                                    <td>` + x.col_empl_cmid + `</td>
                                    <td><a href = "<?= base_url() ?>employees/personal?id=` + x.id + `">
                                        <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                                    </td>
                                    <td>` + x.col_empl_posi + `</td>
                                    <td>` + type + `</td>
                                </tr>
                            `);
                    })

                    $('#total_empl_remote').text(count_remote);
                    $('#total_empl_onsite').text(count_onsite);


                } else {
                    $('#loader_gif').hide();

                    $('#table_container').append(`
                            <td colspan="7">No Employees Detected</td>
                        `);
                }

            })

            $('#check_all').click(function(e) {
                var label = $(this).text();
                console.log(label);
                var ischecked = true;

                // kabaligtara ng click function sa labas
                if (label == 'Uncheck All') {
                    ischecked = true;
                } else {
                    ischecked = false;
                }

                Array.from($('.empl_row')).forEach(function(e) {
                    var td_checkbox = e.childNodes[1];
                    var checkbox_parent = td_checkbox.childNodes[1];
                    var checkbox = $(checkbox_parent).find('.selected_empl');

                    $('.selected_empl').prop('checked', ischecked);
                })
            })
        }


        function display_filtered_empl_remote_status(department, section, line, group, remote_status, status) {
            $('#loader_gif').show();

            // change employee dropdown
            $('#table_container').html('');

            get_filter_data_by_remote_status(url_get_filter_data_by_remote_status, department, line, group, section, remote_status, status).then(function(data) {

                console.log(data);

                if (data.length > 0) {

                    var count_remote = 0;
                    var count_onsite = 0;

                    Array.from(data).forEach(function(x) {
                        var staffIsSelected = '';
                        var HRIsSelected = '';
                        var AccountingIsSelected = '';
                        var AdminIsSelected = '';
                        var IsRemote = '';

                        var user_image = '';
                        var chk_id = '';
                        var empl_id = '';

                        if (x.id) {
                            chk_id = 'chk_id' + x.id;
                            empl_id = x.id;
                        }

                        if (x.col_imag_path) {
                            user_image = base_url + 'user_images/' + x.col_imag_path;

                        } else {
                            user_image = base_url + 'user_images/default_profile_img3.png';
                        }

                        var fullname = '';
                        if ((x.col_frst_name) && (x.col_last_name)) {
                            if (x.col_midl_name) {
                                var middlename = x.col_midl_name.charAt(0);
                                fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + middlename + '.';
                            } else {
                                fullname = x.col_last_name + ', ' + x.col_frst_name;
                            }

                        }

                        $('#loader_gif').hide();

                        if (x.col_user_access == 0) {
                            staffIsSelected = 'selected';
                        } else if (x.col_user_access == 2) {
                            HRIsSelected = 'selected';
                        } else if (x.col_user_access == 3) {
                            AccountingIsSelected = 'selected';
                        } else if (x.col_user_access == 4) {
                            AdminIsSelected = 'selected';
                        }

                        if (x.remote_att == 1) {
                            IsRemote = 'selected';
                        }

                        var type = '';
                        if (x.remote_att > 0) {
                            type = 'Remote';
                            count_remote++;
                        } else {
                            type = 'Onsite';
                            count_onsite++;
                        }

                        $('#table_container').append(`
                                <tr class="empl_row" empl_id="` + x.id + `">
                                    <td>
                                        <td>
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" class="selected_empl" id="chk_id` + x.id + `" empl_id="` + x.id + `">
                                                    <label for="chk_id` + x.id + `"></label>
                                                </div>
                                            </div>
                                        </td>
                                    </td>
                                    <td>` + x.col_empl_cmid + `</td>
                                    <td><a href = "<?= base_url() ?>employees/personal?id=` + x.id + `">
                                        <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                                    </td>
                                    <td>` + x.col_empl_posi + `</td>
                                    <td>` + type + `</td>
                                </tr>
                            `);
                    })

                    $('#total_empl_remote').text(count_remote);
                    $('#total_empl_onsite').text(count_onsite);


                } else {
                    $('#loader_gif').hide();

                    $('#table_container').append(`
                            <td colspan="7">No Employees Detected</td>
                        `);
                }

            })

            $('#check_all').click(function(e) {
                var label = $(this).text();
                console.log(label);
                var ischecked = true;

                // kabaligtara ng click function sa labas
                if (label == 'Uncheck All') {
                    ischecked = true;
                } else {
                    ischecked = false;
                }

                Array.from($('.empl_row')).forEach(function(e) {
                    var td_checkbox = e.childNodes[1];
                    var checkbox_parent = td_checkbox.childNodes[1];
                    var checkbox = $(checkbox_parent).find('.selected_empl');

                    $('.selected_empl').prop('checked', ischecked);
                })
            })
        }


        // ======================= FILTER BY DEPARTMENT ================================
        $('#filter_by_department').change(function() {

            department = $(this).val();
            section = $('#filter_by_section').val();
            line = $('#filter_by_line').val();
            group = $('#filter_by_group').val();
            status = $('#filter_by_status').val();

            display_filtered_empl(department, section, line, group, 0);

            get_filter_data(url_get_filter_data_section, department, line, group, section, 0).then(function(data) {
                if (!section) {
                    $('#filter_by_section').html('');
                    $('#filter_by_section').append(`<option value="">All Sections</option>`);
                }
                Array.from(data).forEach(function(x) {
                    if (x.col_empl_sect != '') {
                        $('#filter_by_section').append(`
                                <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                            `);
                    }
                })
            })
            get_filter_data(url_get_filter_data_group, department, line, group, section, 0).then(function(data) {
                if (!group) {
                    $('#filter_by_group').html('');
                    $('#filter_by_group').append(`<option value="">All Groups</option>`);
                }
                Array.from(data).forEach(function(x) {
                    if (x.col_empl_group != '') {
                        $('#filter_by_group').append(`
                                <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                            `);
                    }
                })
            })
            get_filter_data(url_get_filter_data_line, department, line, group, section, 0).then(function(data) {
                if (!line) {
                    $('#filter_by_line').html('');
                    $('#filter_by_line').append(`<option value="">All Lines</option>`);
                }
                Array.from(data).forEach(function(x) {
                    if (x.col_empl_line != '') {
                        $('#filter_by_line').append(`
                                <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                            `);
                    }
                })
            })


        })

        // ======================= FILTER BY SECTION ================================
        $('#filter_by_section').change(function() {
            department = $('#filter_by_department').val();
            section = $(this).val();
            line = $('#filter_by_line').val();
            group = $('#filter_by_group').val();
            status = $('#filter_by_status').val();

            display_filtered_empl(department, section, line, group, 0);

            get_filter_data(url_get_filter_data_department, department, line, group, section, 0).then(function(data) {
                if (!department) {
                    $('#filter_by_department').html('');
                    $('#filter_by_department').append(`<option value="">All Departments</option>`);
                }
                Array.from(data).forEach(function(x) {
                    if (x.col_empl_dept != '') {
                        $('#filter_by_department').append(`
                                <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                            `);
                    }
                })
            })
            get_filter_data(url_get_filter_data_group, department, line, group, section, 0).then(function(data) {
                if (!group) {
                    $('#filter_by_group').html('');
                    $('#filter_by_group').append(`<option value="">All Groups</option>`);
                }
                Array.from(data).forEach(function(x) {
                    if (x.col_empl_group != '') {
                        $('#filter_by_group').append(`
                                <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                            `);
                    }
                })
            })
            get_filter_data(url_get_filter_data_line, department, line, group, section, 0).then(function(data) {
                if (!line) {
                    $('#filter_by_line').html('');
                    $('#filter_by_line').append(`<option value="">All Lines</option>`);
                }
                Array.from(data).forEach(function(x) {
                    if (x.col_empl_line != '') {
                        $('#filter_by_line').append(`
                                <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                            `);
                    }
                })
            })
        })


        // ======================= FILTER BY GROUP ================================
        $('#filter_by_group').change(function() {
            department = $('#filter_by_department').val();
            section = $('#filter_by_section').val();
            line = $('#filter_by_line').val();
            group = $(this).val();
            status = $('#filter_by_status').val();

            display_filtered_empl(department, section, line, group, 0);

            get_filter_data(url_get_filter_data_department, department, line, group, section, 0).then(function(data) {
                if (!department) {
                    $('#filter_by_department').html('');
                    $('#filter_by_department').append(`<option value="">All Departments</option>`);
                }
                Array.from(data).forEach(function(x) {
                    if (x.col_empl_dept != '') {
                        $('#filter_by_department').append(`
                                <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                            `);
                    }
                })
            })
            get_filter_data(url_get_filter_data_section, department, line, group, section, 0).then(function(data) {
                if (!section) {
                    $('#filter_by_section').html('');
                    $('#filter_by_section').append(`<option value="">All Sections</option>`);
                }
                Array.from(data).forEach(function(x) {
                    if (x.col_empl_sect != '') {
                        $('#filter_by_section').append(`
                                <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                            `);
                    }
                })
            })
            get_filter_data(url_get_filter_data_line, department, line, group, section, 0).then(function(data) {
                if (!line) {
                    $('#filter_by_line').html('');
                    $('#filter_by_line').append(`<option value="">All Lines</option>`);
                }
                Array.from(data).forEach(function(x) {
                    if (x.col_empl_line != '') {
                        $('#filter_by_line').append(`
                                <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                            `);
                    }
                })
            })


        })


        // ======================= FILTER BY LINE ================================
        $('#filter_by_line').change(function() {
            department = $('#filter_by_department').val();
            section = $('#filter_by_section').val();
            line = $(this).val();
            group = $('#filter_by_group').val();
            status = $('#filter_by_status').val();

            display_filtered_empl(department, section, line, group, 0);

            get_filter_data(url_get_filter_data_department, department, line, group, section, 0).then(function(data) {
                if (!department) {
                    $('#filter_by_department').html('');
                    $('#filter_by_department').append(`<option value="">All Departments</option>`);
                }
                Array.from(data).forEach(function(x) {
                    if (x.col_empl_dept != '') {
                        $('#filter_by_department').append(`
                                <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                            `);
                    }
                })
            })
            get_filter_data(url_get_filter_data_section, department, line, group, section, 0).then(function(data) {
                if (!section) {
                    $('#filter_by_section').html('');
                    $('#filter_by_section').append(`<option value="">All Sections</option>`);
                }
                Array.from(data).forEach(function(x) {
                    if (x.col_empl_sect != '') {
                        $('#filter_by_section').append(`
                                <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                            `);
                    }
                })
            })
            get_filter_data(url_get_filter_data_group, department, line, group, section, 0).then(function(data) {
                if (!group) {
                    $('#filter_by_group').html('');
                    $('#filter_by_group').append(`<option value="">All Groups</option>`);
                }

                Array.from(data).forEach(function(x) {
                    if (x.col_empl_group != '') {
                        $('#filter_by_group').append(`
                                <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                            `);
                    }
                })
            })
        })

        // ======================= FILTER BY LINE ================================
        $('#filter_by_attendance_status').change(function() {
            department = $('#filter_by_department').val();
            section = $('#filter_by_section').val();
            line = $('#filter_by_line').val();
            group = $('#filter_by_group').val();
            status = $('#filter_by_status').val();

            remote_status = $(this).val();

            console.log('remote_status: ' + remote_status);

            display_filtered_empl_remote_status(department, section, line, group, remote_status, 0);

        })






        // ================================ CLEAR FILTER ==================================
        $('#btn_clear_filter').click(function() {
            $('#loader_gif').show();

            $('#filter_by_group').val('');
            $('#filter_by_section').val('');
            $('#filter_by_department').val('');
            $('#filter_by_line').val('');

            $('#table_container').html('');
            get_all_employee_data(url_get_all_empl_data).then(function(data) {
                Array.from(data).forEach(function(x) {
                    var staffIsSelected = '';
                    var HRIsSelected = '';
                    var AccountingIsSelected = '';
                    var AdminIsSelected = '';
                    var IsRemote = '';

                    var user_image = '';
                    if (x.col_imag_path) {
                        user_image = base_url + 'user_images/' + x.col_imag_path;
                    } else {
                        user_image = base_url + 'user_images/default_profile_img3.png';
                    }

                    var fullname = '';
                    if ((x.col_frst_name) && (x.col_last_name)) {
                        if (x.col_midl_name) {
                            var middlename = x.col_midl_name.charAt(0);
                            fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + middlename + '.';
                        } else {
                            fullname = x.col_last_name + ', ' + x.col_frst_name;
                        }

                    }

                    $('#loader_gif').hide();

                    if (x.col_user_access == 0) {
                        staffIsSelected = 'selected';
                    } else if (x.col_user_access == 2) {
                        HRIsSelected = 'selected';
                    } else if (x.col_user_access == 3) {
                        AccountingIsSelected = 'selected';
                    } else if (x.col_user_access == 4) {
                        AdminIsSelected = 'selected';
                    }

                    if (x.remote_att == 1) {
                        IsRemote = 'selected';
                    }

                    var type = '';
                    if (x.remote_att > 0) {
                        type = 'Remote';
                    } else {
                        type = 'Onsite';
                    }

                    $('#table_container').append(`
                            <tr class="empl_row" empl_id="` + x.id + `">
                                <td>` + x.col_empl_cmid + `</td>
                                <td><a href = "<?= base_url() ?>employees/personal?id=` + x.id + `">
                                    <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                                </td>
                                <td>` + x.col_empl_posi + `</td>
                                <td>
                                    <input type="date" class="form-control" id="sched_remote" name="sched_remote">
                                </td>
                                <td>` + type + `</td>
                            </tr>
                        `);
                })
            })
            get_all_filter_data(url_get_all_filter_data).then(function(data) {

                $('#filter_by_group').html('');
                $('#filter_by_section').html('');
                $('#filter_by_department').html('');
                $('#filter_by_line').html('');

                $('#filter_by_group').append('<option value="">All Groups</option>');
                $('#filter_by_section').append('<option value="">All Sections</option>');
                $('#filter_by_department').append('<option value="">All Departments</option>');
                $('#filter_by_line').append('<option value="">All Lines</option>');

                Array.from(data.DISP_Group).forEach(function(x) {
                    if (x.col_empl_group != '') {
                        $('#filter_by_group').append(`
                                <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                            `)
                    }
                })
                Array.from(data.DISP_DISTINCT_SECTION).forEach(function(x) {
                    if (x.col_empl_sect != '') {
                        $('#filter_by_section').append(`
                                <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                            `)
                    }
                })
                Array.from(data.DISP_DISTINCT_DEPARTMENT).forEach(function(x) {
                    if (x.col_empl_dept != '') {
                        $('#filter_by_department').append(`
                                <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                            `)
                    }
                })
                Array.from(data.DISP_Line).forEach(function(x) {
                    if (x.col_empl_line != '') {
                        $('#filter_by_line').append(`
                                <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                            `)
                    }
                })
            })

        })






























        // =============================================================== UPDATE REMOTE ATTENDANCE =======================================================
        function save_user_access(remote_attendance_status) {
            if ($('.selected_empl:checked').length > 0) {
                Array.from($('.selected_empl:checked')).forEach(function(e) {

                    // var td_remote_attendance = e.childNodes[7];
                    // var remote_attendance_dropdown = td_remote_attendance.childNodes[1];
                    // var remote_attendance = $(remote_attendance_dropdown).val();

                    // var td_sched_remote = e.childNodes[7];
                    // var sched_remote_dropdown = td_sched_remote.childNodes[1];
                    // var sched_remote = $(sched_remote_dropdown).val();

                    var empl_id = $(e).attr('empl_id');

                    update_empl_remote_attendance(url_update_empl_remote_attendance, remote_attendance_status, empl_id).then(function(data) {
                        console.log(empl_id + ' - ' + data);
                    })
                })

                Swal.fire(
                    'Changes Saved',
                    '',
                    'success'
                )

                setTimeout(() => {
                    window.location.href = '<?= base_url() ?>attendance/remote_attendance';
                }, 500);

            } else {
                Swal.fire(
                    'No Employee Selected',
                    'Please check the box to select',
                    'warning'
                )
            }

        }

        $('#check_all').click(function(e) {
            var label = $(this).text();
            console.log(label);

            var ischecked = false;
            if (label == 'Check All') {
                ischecked = true;
                $(this).text('Uncheck All');
            } else {
                ischecked = false;
                $(this).text('Check All');
            }

            Array.from($('.empl_row')).forEach(function(e) {
                var td_checkbox = e.childNodes[1];
                var checkbox_parent = td_checkbox.childNodes[1];
                var checkbox = $(checkbox_parent).find('.selected_empl');

                $(checkbox).prop('checked', ischecked);
            })
        })

        $('#enable_remote_attendance').click(function() {
            var remote_attendance_status = $(this).attr('remote_attendance');

            Swal.fire({
                title: 'Enable Remote Attendance?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Enable'
            }).then((result) => {
                if (result.isConfirmed) {
                    save_user_access(remote_attendance_status);
                }
            })

        })

        $('#disable_remote_attendance').click(function() {
            var remote_attendance_status = $(this).attr('remote_attendance');

            Swal.fire({
                title: 'Disable Remote Attendance?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Disable'
            }).then((result) => {
                if (result.isConfirmed) {
                    save_user_access(remote_attendance_status);
                }
            })
        })




        count_remote_attendance(url_count_remote_attendance, 1).then(function(data) {
            console.log(data);
            $('#total_empl_remote').text(data);
        })

        count_remote_attendance(url_count_remote_attendance, 0).then(function(data) {
            console.log(data);
            $('#total_empl_onsite').text(data);
        })
        // total_empl_remote
        // total_empl_onsite














        // ========================================================== RESET PASSWORD =================================================
        $('.btn_reset_pass').click(function() {
            var parent_tr = $(this).parent().parent();
            var empl_id = $(parent_tr).attr('empl_id');


            Swal.fire({
                title: 'Reset Password for this Employee?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Reset'
            }).then((result) => {
                if (result.isConfirmed) {
                    reset_empl_password(url_reset_empl_password, empl_id).then(function(data) {
                        Swal.fire(
                            data,
                            '',
                            'success'
                        )
                    })
                }
            })
        })




































        async function count_remote_attendance(url, remote_attendance) {
            var formData = new FormData();
            formData.append('remote_attendance', remote_attendance);
            // formData.append('sched_remote', sched_remote);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function update_empl_remote_attendance(url, remote_attendance_status, empl_id) {
            var formData = new FormData();
            formData.append('empl_id', empl_id);
            formData.append('remote_attendance', remote_attendance_status);
            // formData.append('sched_remote', sched_remote);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function update_status_remarks(url, date, empl_id, status, remarks) {
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

        async function get_all_employee_data(url) {
            var formData = new FormData();
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        // ==================================================== FILTER ========================================================

        async function get_employee_section_data_filter_by_dept(url, department) {
            var formData = new FormData();
            formData.append('department', department);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_employee_data_filter_by_group(url, group) {
            var formData = new FormData();
            formData.append('group', group);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_employee_data_filter_by_line(url, line) {
            var formData = new FormData();
            formData.append('line', line);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_employee_data_filter_by_status(url, status) {
            var formData = new FormData();
            formData.append('status', status);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_employee_data_filter_by_sect(url, section) {
            var formData = new FormData();
            formData.append('section', section);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_employee_data_filter_by_dept(url, department) {
            var formData = new FormData();
            formData.append('department', department);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }


        // ================================ ASYNC FILTER ===================================

        async function get_filter_data(url, department, line, group, section, status) {
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

        async function get_filter_data_by_remote_status(url, department, line, group, section, remote_status, status) {
            var formData = new FormData();
            formData.append('department', department);
            formData.append('line', line);
            formData.append('group', group);
            formData.append('section', section);
            formData.append('remote_status', remote_status);
            formData.append('status', status);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_all_filter_data(url) {
            var formData = new FormData();
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }


        // ================================ UPDATE USER ACCESS ===================================
        async function update_empl_user_access(url, empl_id, user_access, remote_attendance) {
            var formData = new FormData();
            formData.append('empl_id', empl_id);
            formData.append('user_access', user_access);
            formData.append('remote_attendance', remote_attendance);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }


        // ================================== RESET PASSWORD ======================================
        async function reset_empl_password(url, empl_id) {
            var formData = new FormData();
            formData.append('empl_id', empl_id);
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