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
        font-size: 13px !important;
    }

    .page-title {
        font-weight: 600;
        color: #424F5C;
        font-size: 33px;
    }

    .bank_row:hover {
        cursor: pointer;
    }

    /* .pagination{
        display: none !important;
    } */
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
                <h1 class="page-title">Bank Details</h1>
            </div>
            <div class="col-md-6" style="text-align: right;">

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
        <div class="row">
            <div class="col-md-5">
                <label for="">Filter by Department</label>
                <select id="filter_by_department" class="form-control">
                    <option value="">All Departments</option>
                    <?php
                    if ($DISP_DISTINCT_DEPARTMENT) {
                        foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW) {
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
                    if ($DISP_DISTINCT_SECTION) {
                        foreach ($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW) {
                    ?>
                            <option value="<?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?>"><?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
            <table class="table table-hover" id="employee_tbl">
                <thead>
                    <tr>
                        <td>Employee Id</td>
                        <td>Full Name</td>
                        <td>Bank Name</td>
                        <td>Branch Name</td>
                        <td>Account Number</td>
                        <td>Account Type</td>
                        <td>Payment Type</td>
                    </tr>
                </thead>
                <tbody id="table_container">
                    <?php
                    if ($DISP_EMP_LIST) {
                        foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) {
                            if (!empty($DISP_EMP_LIST_ROW->col_midl_name)) {
                                $midl_ini =  $DISP_EMP_LIST_ROW->col_midl_name[0] . '.';
                            } else {
                                $midl_ini = '';
                            } ?>
                            <tr class="bank_row" data-toggle="modal" data-target="#modal_edit_bank" empl_cmid="<?= $DISP_EMP_LIST_ROW->col_empl_cmid ?>">
                                <td><?= $DISP_EMP_LIST_ROW->col_empl_cmid ?></td>
                                <td><a href="#">
                                        <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($DISP_EMP_LIST_ROW->col_imag_path) {
                                                                                                            echo base_url() . 'user_images/' . $DISP_EMP_LIST_ROW->col_imag_path;
                                                                                                        } else {
                                                                                                            echo base_url() . 'user_images/default_profile_img3.png';
                                                                                                        } ?>">&nbsp;&nbsp;<?= $DISP_EMP_LIST_ROW->col_last_name . ' ' . $DISP_EMP_LIST_ROW->col_frst_name . ' ' . $midl_ini ?></a>
                                </td>
                                <td><?= $DISP_EMP_LIST_ROW->bank_name ?></td>
                                <td><?= $DISP_EMP_LIST_ROW->branch_name ?></td>
                                <td><?= $DISP_EMP_LIST_ROW->account_number ?></td>
                                <td><?= $DISP_EMP_LIST_ROW->account_type ?></td>
                                <td><?= $DISP_EMP_LIST_ROW->payment_type ?></td>
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
            <center>
                <ul id="btn_pagination" class="pagination mr-auto ml-auto"></ul>
            </center>
        </div>
    </div>
</div>

<!-- =============== TIME ADJUSTMENT MODAL ================= -->
<div class="modal fade" id="modal_edit_bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Update Bank Details
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;
                    </span>
                </button>
            </div>
            <form action="<?php echo base_url('payroll/update_bank_details'); ?>" id="form_update_bank" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="w-100 text-center">
                                        <img class="rounded-circle avatar" id="modal_profile_img" style="width: 180px;">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Employee ID</label>
                                            <p id="empl_id"></p>
                                            <label for="">Employee Name</label>
                                            <p id="empl_name"></p>
                                            <label for="">Position</label>
                                            <p id="empl_position"></p>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Department</label>
                                            <p id="empl_department"></p>
                                            <label for="">Section</label><br>
                                            <p id="empl_section"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required " for="bank_name">Bank Name
                                        </label>
                                        <input type="text" name="bank_name" id="bank_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required " for="branch_name">Branch Name
                                        </label>
                                        <input type="text" name="branch_name" id="branch_name" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required " for="account_number">Account Number
                                        </label>
                                        <input type="text" name="account_number" id="account_number" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required " for="account_type">Account Type
                                        </label>
                                        <input type="text" name="account_type" id="account_type" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="required " for="payment_type">Payment Type
                                    </label>
                                    <input type="text" name="payment_type" id="payment_type" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="employee_id" id="key_employee_id">
                    <button class='btn btn-primary text-light' id="btn_edit_bank">Save
                    </button>
                    <button type="button" data-dismiss="modal" class='btn btn-secondary text-light'>&nbsp; Close
                    </button>
                </div>
            </form>
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
<!-- SESSION MESSAGES -->
<?php
if ($this->session->userdata('SESS_SUCC_MSG_UPDT_BANK')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_BANK'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_UPDT_BANK');
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
    $(document).ready(function() {

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

                    $('#table_container').append(`
                            <tr class="bank_row" data-toggle="modal" data-target="#modal_edit_bank" empl_cmid="` + e.col_empl_cmid + `">
                                <td>` + e.col_empl_cmid + `</td>
                                <td>
                                    <a href = "<?= base_url() ?>employees/personal?id=` + e.id + `">
                                        <img class="rounded-circle avatar " width="35" height="35" src="` + empl_image + `">&nbsp;&nbsp;` + empl_name + `
                                    </a>
                                </td>
                                <td>` + e.bank_name + `</td>
                                <td>` + e.branch_name + `</td>
                                <td>` + e.account_number + `</td>
                                <td>` + e.account_type + `</td>
                                <td>` + e.payment_type + `</td>
                            </tr>
                        `)
                    var url_get_employee_data = '<?= base_url() ?>payroll/get_employees_data_based_cmid';
                    $('.bank_row').click(function(e) {
                        var empl_cmid = $(this).attr('empl_cmid');
                        get_employees_data_based_cmid(url_get_employee_data, empl_cmid).then(function(data) {
                            Array.from(data).forEach((x) => {
                                if (x.col_imag_path) {
                                    $('#modal_profile_img').attr('src', base_url + 'user_images/' + x.col_imag_path);
                                } else {
                                    $('#modal_profile_img').attr('src', base_url + 'user_images/default_profile_img3.png');
                                }

                                $('#key_employee_id').val(x.id);

                                $('#empl_id').text(x.col_empl_cmid);
                                $('#empl_name').text(x.col_frst_name + ' ' + x.col_last_name);
                                $('#empl_position').text(x.col_empl_posi);
                                $('#empl_department').text(x.col_empl_dept);
                                $('#empl_section').text(x.col_empl_sect);

                                $('#bank_name').val(x.bank_name);
                                $('#branch_name').val(x.branch_name);
                                $('#account_number').val(x.account_number);
                                $('#account_type').val(x.account_type);
                                $('#payment_type').val(x.payment_type);

                            })
                        })
                    })
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

                    $('#table_container').append(`
                            <tr class="bank_row" data-toggle="modal" data-target="#modal_edit_bank" empl_cmid="` + e.col_empl_cmid + `">
                                <td>` + e.col_empl_cmid + `</td>
                                <td>
                                    <a href = "<?= base_url() ?>employees/personal?id=` + e.id + `">
                                        <img class="rounded-circle avatar " width="35" height="35" src="` + empl_image + `">&nbsp;&nbsp;` + empl_name + `
                                    </a>
                                </td>
                                <td>` + e.bank_name + `</td>
                                <td>` + e.branch_name + `</td>
                                <td>` + e.account_number + `</td>
                                <td>` + e.account_type + `</td>
                                <td>` + e.payment_type + `</td>
                            </tr>
                        `)
                    var url_get_employee_data = '<?= base_url() ?>payroll/get_employees_data_based_cmid';
                    $('.bank_row').click(function(e) {
                        var empl_cmid = $(this).attr('empl_cmid');
                        get_employees_data_based_cmid(url_get_employee_data, empl_cmid).then(function(data) {
                            Array.from(data).forEach((x) => {
                                if (x.col_imag_path) {
                                    $('#modal_profile_img').attr('src', base_url + 'user_images/' + x.col_imag_path);
                                } else {
                                    $('#modal_profile_img').attr('src', base_url + 'user_images/default_profile_img3.png');
                                }

                                $('#key_employee_id').val(x.id);

                                $('#empl_id').text(x.col_empl_cmid);
                                $('#empl_name').text(x.col_frst_name + ' ' + x.col_last_name);
                                $('#empl_position').text(x.col_empl_posi);
                                $('#empl_department').text(x.col_empl_dept);
                                $('#empl_section').text(x.col_empl_sect);

                                $('#bank_name').val(x.bank_name);
                                $('#branch_name').val(x.branch_name);
                                $('#account_number').val(x.account_number);
                                $('#account_type').val(x.account_type);
                                $('#payment_type').val(x.payment_type);

                            })
                        })
                    })
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



        var base_url = '<?= base_url() ?>';

        // ======================= FILTER BY SECTION ================================
        var url_filter_by_section = '<?= base_url() ?>attendance/get_employee_data_filter_by_sect';
        var url_get_all_empl_data = '<?= base_url() ?>employees/get_all_employee_data';
        $('#filter_by_section').change(function() {
            var section = $(this).val();
            if (section) {
                $('#table_container').html('');
                get_employee_data_filter_by_sect(url_filter_by_section, section).then(function(data) {
                    Array.from(data).forEach(function(x) {

                        var user_image = '';
                        if (x.col_imag_path) {
                            user_image = base_url + 'user_images/' + x.col_imag_path;
                        } else {
                            user_image = base_url + 'user_images/default_profile_img3.png';
                        }

                        var fullname = '';
                        if ((x.col_frst_name) && (x.col_last_name)) {
                            if (x.col_midl_name) {
                                $midl_ini = x.col_midl_name.charAt(0) + '.';
                            } else {
                                $midl_ini = '';
                            }
                            fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + $midl_ini;
                        }
                        $('#table_container').append(`
                        <tr>
                            <td>` + x.col_empl_cmid + `</td>
                            <td><a href = "#">
                                <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                            </td>
                            <td>` + x.bank_name + `</td>
                            <td>` + x.branch_name + `</td>
                            <td>` + x.account_number + `</td>
                            <td>` + x.account_type + `</td>
                            <td>` + x.payment_type + `</td>
                        </tr>
                    `);
                    })
                })
            } else {
                $('#table_container').html('');
                get_all_employee_data(url_get_all_empl_data).then(function(data) {
                    Array.from(data).forEach(function(x) {
                        var user_image = '';
                        if (x.col_imag_path) {
                            user_image = base_url + 'user_images/' + x.col_imag_path;
                        } else {
                            user_image = base_url + 'user_images/default_profile_img3.png';
                        }

                        var fullname = '';
                        if ((x.col_frst_name) && (x.col_last_name)) {
                            if (x.col_midl_name) {
                                $midl_ini = x.col_midl_name.charAt(0) + '.';
                            } else {
                                $midl_ini = '';
                            }
                            fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + $midl_ini;
                        }
                        $('#table_container').append(`
                        <tr>
                            <td>` + x.col_empl_cmid + `</td>
                            <td><a href = "#">
                                <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                            </td>
                            <td>` + x.bank_name + `</td>
                            <td>` + x.branch_name + `</td>
                            <td>` + x.account_number + `</td>
                            <td>` + x.account_type + `</td>
                            <td>` + x.payment_type + `</td>
                        </tr>
                    `);
                    })
                })
            }
        })

        // ======================= FILTER BY DEPARTMENT ================================
        var url_filter_by_department = '<?= base_url() ?>attendance/get_employee_data_filter_by_dept';
        var url_filter_section_by_department = '<?= base_url() ?>attendance/get_employee_section_data_filter_by_dept';
        $('#filter_by_department').change(function() {
            var department = $(this).val();
            if (department) {
                // change employee dropdown
                $('#table_container').html('');
                get_employee_data_filter_by_dept(url_filter_by_department, department).then(function(data) {
                    Array.from(data).forEach(function(x) {
                        var user_image = '';
                        if (x.col_imag_path) {
                            user_image = base_url + 'user_images/' + x.col_imag_path;
                        } else {
                            user_image = base_url + 'user_images/default_profile_img3.png';
                        }

                        var fullname = '';
                        if ((x.col_frst_name) && (x.col_last_name)) {
                            if (x.col_midl_name) {
                                $midl_ini = x.col_midl_name.charAt(0) + '.';
                            } else {
                                $midl_ini = '';
                            }
                            fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + $midl_ini;
                        }

                        $('#table_container').append(`
                        <tr>
                            <td>` + x.col_empl_cmid + `</td>
                            <td><a href = "#">
                                <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                            </td>
                            <td>` + x.bank_name + `</td>
                            <td>` + x.branch_name + `</td>
                            <td>` + x.account_number + `</td>
                            <td>` + x.account_type + `</td>
                            <td>` + x.payment_type + `</td>
                        </tr>
                    `);
                    })
                })
            } else {
                $('#table_container').html('');
                get_all_employee_data(url_get_all_empl_data).then(function(data) {
                    Array.from(data).forEach(function(x) {
                        var user_image = '';
                        if (x.col_imag_path) {
                            user_image = base_url + 'user_images/' + x.col_imag_path;
                        } else {
                            user_image = base_url + 'user_images/default_profile_img3.png';
                        }

                        var fullname = '';
                        if ((x.col_frst_name) && (x.col_last_name)) {
                            if (x.col_midl_name) {
                                $midl_ini = x.col_midl_name.charAt(0) + '.';
                            } else {
                                $midl_ini = '';
                            }
                            fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + $midl_ini;
                        }

                        $('#table_container').append(`
                        <tr>
                            <td>` + x.col_empl_cmid + `</td>
                            <td><a href = "#">
                                <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                            </td>
                            <td>` + x.bank_name + `</td>
                            <td>` + x.branch_name + `</td>
                            <td>` + x.account_number + `</td>
                            <td>` + x.account_type + `</td>
                            <td>` + x.payment_type + `</td>
                        </tr>
                    `);
                    })
                })
            }
        })














        var url_get_employee_data = '<?= base_url() ?>payroll/get_employees_data_based_cmid';
        $('.bank_row').click(function(e) {
            var empl_cmid = $(this).attr('empl_cmid');
            get_employees_data_based_cmid(url_get_employee_data, empl_cmid).then(function(data) {
                Array.from(data).forEach((x) => {
                    if (x.col_imag_path) {
                        $('#modal_profile_img').attr('src', base_url + 'user_images/' + x.col_imag_path);
                    } else {
                        $('#modal_profile_img').attr('src', base_url + 'user_images/default_profile_img3.png');
                    }

                    $('#key_employee_id').val(x.id);

                    $('#empl_id').text(x.col_empl_cmid);
                    $('#empl_name').text(x.col_frst_name + ' ' + x.col_last_name);
                    $('#empl_position').text(x.col_empl_posi);
                    $('#empl_department').text(x.col_empl_dept);
                    $('#empl_section').text(x.col_empl_sect);

                    $('#bank_name').val(x.bank_name);
                    $('#branch_name').val(x.branch_name);
                    $('#account_number').val(x.account_number);
                    $('#account_type').val(x.account_type);
                    $('#payment_type').val(x.payment_type);

                })
            })
        })







        var url_get_employee = '<?php echo base_url(); ?>payroll/get_all_employee';

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

                        $('#table_container').append(`
                            <tr class="bank_row" data-toggle="modal" data-target="#modal_edit_bank" empl_cmid="` + e.col_empl_cmid + `">
                                <td>` + e.col_empl_cmid + `</td>
                                <td>
                                    <a href = "#">
                                        <img class="rounded-circle avatar " width="35" height="35" src="` + empl_image + `">&nbsp;&nbsp;` + empl_name + `
                                    </a>
                                </td>
                                <td>` + e.bank_name + `</td>
                                <td>` + e.branch_name + `</td>
                                <td>` + e.account_number + `</td>
                                <td>` + e.account_type + `</td>
                                <td>` + e.payment_type + `</td>
                            </tr>
                        `)

                        var url_get_employee_data = '<?= base_url() ?>payroll/get_employees_data_based_cmid';
                        $('.bank_row').click(function(e) {
                            var empl_cmid = $(this).attr('empl_cmid');
                            get_employees_data_based_cmid(url_get_employee_data, empl_cmid).then(function(data) {
                                Array.from(data).forEach((x) => {
                                    if (x.col_imag_path) {
                                        $('#modal_profile_img').attr('src', base_url + 'user_images/' + x.col_imag_path);
                                    } else {
                                        $('#modal_profile_img').attr('src', base_url + 'user_images/default_profile_img3.png');
                                    }

                                    $('#key_employee_id').val(x.id);

                                    $('#empl_id').text(x.col_empl_cmid);
                                    $('#empl_name').text(x.col_frst_name + ' ' + x.col_last_name);
                                    $('#empl_position').text(x.col_empl_posi);
                                    $('#empl_department').text(x.col_empl_dept);
                                    $('#empl_section').text(x.col_empl_sect);

                                    $('#bank_name').val(x.bank_name);
                                    $('#branch_name').val(x.branch_name);
                                    $('#account_number').val(x.account_number);
                                    $('#account_type').val(x.account_type);
                                    $('#payment_type').val(x.payment_type);

                                })
                            })
                        })
                    })
                })

            }
        });


        async function get_employee(url, page_num) {
            var formData = new FormData();
            formData.append('page_num', page_num);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }














        async function get_employees_data_based_cmid(url, employee_cmid) {
            var formData = new FormData();
            formData.append('employee_cmid', employee_cmid);
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

        async function get_employee_section_data_filter_by_dept(url, department) {
            var formData = new FormData();
            formData.append('department', department);
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

        async function get_all_employee_data(url) {
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