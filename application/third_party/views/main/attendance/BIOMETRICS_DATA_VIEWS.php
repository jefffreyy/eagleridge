<style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron&display=swap');

    .card {
        padding: 15px;
    }

    li a {
        color: #0D74BC;
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
        font-size: 14px !important;
        font-weight: normal;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .badge {
        border-radius: 5px !important;
        font-weight: bold;
        padding: 8px 10px;
    }

    .icon {
        width: 140px;
        height: 140px;
        border-radius: 8px 8px 8px 8px;
        -webkit-transform-origin: 50% 10%;
        transform-origin: 50% 10%;
    }

    .icon:hover,
    .icon:focus {
        -webkit-animation: swing 0.6s ease-out;
        animation: swing 0.6s ease-out;
    }

    .time_container {
        transform: translateY(25%) !important;
    }

    @-webkit-keyframes swing {
        0% {
            -webkit-transform: rotate(0deg) skewY(0deg);
        }

        20% {
            -webkit-transform: rotate(12deg) skewY(4deg);
        }

        60% {
            -webkit-transform: rotate(-9deg) skewY(-3deg);
        }

        80% {
            -webkit-transform: rotate(6deg) skewY(-2deg);
        }

        100% {
            -webkit-transform: rotate(0deg) skewY(0deg);
        }
    }

    @keyframes swing {
        0% {
            transform: rotate(0deg) skewY(0deg);
        }

        20% {
            transform: rotate(12deg) skewY(4deg);
        }

        60% {
            transform: rotate(-9deg) skewY(-3deg);
        }

        80% {
            transform: rotate(6deg) skewY(-2deg);
        }

        100% {
            transform: rotate(0deg) skewY(0deg);
        }
    }

    @media screen and (max-width: 500px) {

        #current_time,
        #current_phase {
            text-align: center;
        }

        .time_container {
            transform: translateY(25%) !important;
        }

        #btn_time_in,
        #btn_time_out {
            width: 100%;
            margin-bottom: 10px;
            padding: 20px 20px;
        }
    }

    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px) {

        /* Force table to not be like tables anymore */
        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        tr {
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }

        td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50% !important;
            text-align: right;
        }

        td:before {
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
            color: #5c5b5b;
            text-transform: capitalize;
            text-align: left !important;
        }

        .modal_head {
            margin-top: 15px;
            padding-bottom: 10px;
            color: #007BFF;
        }

        /* Labels the sliced thead of the table */
        td:nth-of-type(1):before {
            content: "Date";
        }

        td:nth-of-type(2):before {
            content: "Shift";
        }

        td:nth-of-type(3):before {
            content: "Time In";
        }

        td:nth-of-type(4):before {
            content: "Time Out";
        }

        /* Add as you add content to the thead */
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
                <h1 class="page-title">Biometrics Record</h1>
            </div>
        </div>
        <hr>

        <div class="row mb-2">
            <div class="col">
                <form class="new_q" id="new_q" action="#" accept-charset="UTF-8" method="get">
                    <div class="form-row align-items-center">
                        <div class="col-md-6">
                            <label for="filter_by_date">Filter by date</label>
                            <!-- CHECK IF BIOMETRICS DATA IS FILTERED BY DATE -->
                            <?php
                            $url_date = $this->input->get('date');
                            if ($url_date) {
                            ?>
                                <input type="date" name="filtered_date" id="filter_by_date" class="url_date form-control" value="<?= $url_date ?>">
                            <?php
                            } else {
                            ?>
                                <input type="date" name="filter_by_date" id="filter_by_date" class="form-control" value="<?= date('Y-m-d') ?>">
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <br>
        <div class = "card border-0 mt-2" style = "padding: 0px; margin: 0px">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="display: none;">ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Time In / Time Out</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody id="tbl_biometrics_data">
                    <?php
                    if ($DISP_BIOMETRICS_DATA) {
                        // echo count($DISP_BIOMETRICS_DATA);
                        foreach ($DISP_BIOMETRICS_DATA as $DISP_BIOMETRICS_DATA_ROW) {
                            $full_name = '';
                            $empl_cmid = $DISP_BIOMETRICS_DATA_ROW->userid;
                            $check_type = '';

                            $current_date = date('n/j/Y');

                            $employee_id = '';

                            $empl_info = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE_BASED_CMID($empl_cmid);
                            if (count($empl_info) > 0) {
                                if (!empty($empl_info[0]->col_midl_name)) {
                                    $midl_ini = $empl_info[0]->col_midl_name[0] . '.';
                                } else {
                                    $midl_ini = '';
                                }
                                $full_name = $empl_info[0]->col_last_name . ', ' . $empl_info[0]->col_frst_name . ' ' . $midl_ini;
                                $employee_id = $empl_info[0]->col_empl_cmid;
                            } else {
                                $full_name = 'Unknown';
                            }

                            if ($DISP_BIOMETRICS_DATA_ROW->checktype == 'O') {
                                $check_type = 'Time Out';
                            } else if ($DISP_BIOMETRICS_DATA_ROW->checktype == 'I') {
                                $check_type = 'Time In';
                            }

                            $split_date_time = explode(' ', $DISP_BIOMETRICS_DATA_ROW->checktime);
                            if (count($split_date_time) > 2) {
                                $date = $split_date_time[0];
                                $time = $split_date_time[1] . ' ' . $split_date_time[2];

                                // if($date == $current_date){
                    ?>
                                <tr>
                                    <td style="display: none;"><?= $DISP_BIOMETRICS_DATA_ROW->id ?></td>
                                    <td><?= $date ?></td>
                                    <td><?= $time ?></td>
                                    <td><?= $check_type ?></td>
                                    <td><?= $empl_cmid ?></td>
                                    <td><?= $full_name ?></td>
                                </tr>
                    <?php
                                // }
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
            <center>
                <ul id="example" class="pagination mr-auto ml-auto"></ul>
            </center>
        </div>

        <input type="hidden" name="curr_date" id="curr_date" value="<?= date('n/j/Y'); ?>">
        <input type="hidden" name="curr_date" id="curr_date_ymd_format" value="<?= date('Y-m-d'); ?>">
    </div>

    <!-- <div class="row">
        <?php
        if ($DISP_ROW_COUNT) {
            foreach ($DISP_ROW_COUNT as $DISP_ROW_COUNT_ROW) {
                $count_start = 1;
                for ($i = 0; $i < $DISP_ROW_COUNT_ROW->biom_count; $i += 20) {
        ?>
                            <a href="#" style="display:inline;" class="btn btn-primary"><?= $count_start ?></a>
                        <?php
                        $count_start++;
                    }
                }
            }
                        ?>
    </div> -->

    <?php
    $page_count = $DISP_ROW_COUNT[0]->biom_count / 20;
    if (($DISP_ROW_COUNT[0]->biom_count % 20) != 0) {
        $page_count = $page_count++;
    }
    ?>

    <input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT[0]->biom_count ?>">
    <input type="hidden" id="page_count" value="<?= $page_count ?>">

</div>


<aside class="control-sidebar control-sidebar-dark">
</aside>

<div id="sidebar-overlay"></div>
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
if ($this->session->userdata('success')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('success'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('success');
}
?>

<?php
if ($this->session->userdata('error')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('error'); ?>',
            '',
            'error'
        )
    </script>
<?php
    $this->session->unset_userdata('error');
}
?>




<script>
    $(document).ready(function() {

        var url_get_biometrics_data = '<?= base_url() ?>attendance/get_biometrics_data';
        var url_get_employee_data_via_cmid = '<?= base_url() ?>attendance/get_employee_data_via_cmid';
        var url_get_employee_all_ampl_data = '<?= base_url() ?>attendance/get_employee_all_ampl_data';
        var current_date = '';
        var check_type = '';
        var db_date = '';

        var empl_info = [];


        // setTimeout(() => {
        //     console.log('table length: ' + $('#tbl_biometrics_data tr').length);
        // }, 4000);


        var empl_id_arr = [];
        var empl_info_arr = [];

        get_employee_all_ampl_data(url_get_employee_all_ampl_data, 'test').then(function(data) {

            var obj = findObjectByKey(data, 'col_empl_cmid', '10');
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





        function load_biometrics_data() {
            var date = $('#filter_by_date').val();
            console.log(date);

            var url_date = $('.url_date').length;
            var url_date_val = $('.url_date').val();

            if (url_date_val == curr_date_ymd_format) {
                get_biometrics_data(url_get_biometrics_data, 'test', date, 1).then(function(data) {
                    // console.log(data.length);
                    if (data.length > 0) {
                        var date_arr = [];
                        current_date = $('#curr_date').val();

                        // console.log(data);

                        Array.from(data).forEach(function(obj_val) {
                            var split = (obj_val.checktime).split(' ');
                            var split_date = split[0];
                            if (split_date == current_date) {
                                date_arr.push(split_date);
                            }
                        })

                        // console.log('db_length: ' + date_arr.length);
                        // console.log('tbl_length: ' + $('#tbl_biometrics_data tr').length);

                        if ($('#tbl_biometrics_data tr').length < date_arr.length) {
                            $('#tbl_biometrics_data').html('');
                            Array.from(data).forEach(function(x) {

                                var obj = findObjectByKey(empl_info_arr, 'col_empl_cmid', "" + x.userid + "");

                                var full_name = '';
                                var employee_id = '';

                                if (obj) {
                                    full_name = obj.col_frst_name + ' ' + obj.col_last_name;
                                    employee_id = obj.col_empl_cmid;
                                } else {
                                    full_name = 'Unknown';
                                }

                                current_date = $('#curr_date').val();


                                if (x.checktype == 'O') {
                                    check_type = 'Time Out';
                                } else if (x.checktype == 'I') {
                                    check_type = 'Time In';
                                }

                                var split_checktime = (x.checktime).split(' ');
                                db_date = split_checktime[0];
                                db_time = split_checktime[1] + ' ' + split_checktime[2];

                                if (db_date == current_date) {
                                    $('#tbl_biometrics_data').append(`
                                        <tr>
                                            <td style="display:none;">` + x.id + `</td>
                                            <td>` + db_date + `</td>
                                            <td>` + db_time + `</td>
                                            <td>` + check_type + `</td>
                                            <td>` + x.userid + `</td>
                                            <td>` + full_name + `</td>
                                        </tr>
                                    `);
                                }
                            })
                        }


                        setTimeout(() => {
                            if ($('#tbl_biometrics_data tr').length == 0) {
                                $('#tbl_biometrics_data').html(`
                                    <tr>
                                        <td colspan="5">No Data Yet</td>
                                    </tr>
                                `);
                            };
                        }, 500);

                    } else {
                        $('#tbl_biometrics_data').html(`
                            <tr>
                                <td colspan="5">No Data Yet</td>
                            </tr>
                        `);
                    }
                })
            }

        }



        var biom_interval = setInterval(load_biometrics_data, 1000);




        $('#filter_by_date').change(function() {

            var filter_date = $(this).val();

            window.location.href = '<?= base_url() ?>attendance/biometrics_data?date=' + filter_date;












            // clearInterval(biom_interval);
            // current_date = $('#curr_date').val();
            // var date = $(this).val();
            // var split_date = date.split('-');

            // var year = Number(split_date[0]);
            // var month = Number(split_date[1]);
            // var day = Number(split_date[2]);

            // var new_date = String(month) +'/'+ String(day) +'/'+ String(year);
            // // console.log('filtered date: ' + new_date);
            // // console.log('current_date: ' + current_date);

            // if(new_date == current_date){
            //     $('#tbl_biometrics_data').html('');
            //     get_biometrics_data(url_get_biometrics_data, 'test', date, 1).then(function(data){
            //         Array.from(data).forEach(function(tbl_child){
            //             var split = (tbl_child.checktime).split(' ');
            //             var split_date = split[0];
            //             if(split_date == current_date){
            //                 $('#tbl_biometrics_data').append(`
            //                     <tr style="display: none;">
            //                         <td></td>
            //                         <td></td>
            //                         <td></td>
            //                         <td></td>
            //                         <td></td>
            //                         <td></td>
            //                     </tr>
            //                 `);
            //             }

            //         })
            //         $('#tbl_biometrics_data').children().last().remove();
            //         setTimeout(() => {
            //             biom_interval = setInterval(load_biometrics_data, 1000);
            //         }, 500);

            //     })

            // } else {
            //     load_biometrics_data_by_date(new_date);
            // }

        })




        function load_biometrics_data_by_date(param_date) {

            var date = $('#filter_by_date').val();

            clearInterval(biom_interval);
            get_biometrics_data(url_get_biometrics_data, 'test', date, 1).then(function(data) {
                if (data.length > 0) {
                    $('#tbl_biometrics_data').html('');
                    Array.from(data).forEach(function(x) {

                        var obj = findObjectByKey(empl_info_arr, 'col_empl_cmid', "" + x.userid + "");
                        var full_name = '';
                        var employee_id = '';

                        if (obj) {
                            full_name = obj.col_frst_name + ' ' + obj.col_last_name;
                            employee_id = obj.col_empl_cmid;
                        } else {
                            full_name = 'Unknown';
                        }

                        current_date = $('#curr_date').val();

                        if (x.checktype == 'O') {
                            check_type = 'Time Out';
                        } else if (x.checktype == 'I') {
                            check_type = 'Time In';
                        }

                        var split_checktime = (x.checktime).split(' ');
                        db_date = split_checktime[0];
                        db_time = split_checktime[1] + ' ' + split_checktime[2];

                        if (db_date == param_date) {
                            $('#tbl_biometrics_data').append(`
                                <tr>
                                    <td style="display:none;">` + x.id + `</td>
                                    <td>` + db_date + `</td>
                                    <td>` + db_time + `</td>
                                    <td>` + check_type + `</td>
                                    <td>` + x.userid + `</td>
                                    <td>` + full_name + `</td>
                                </tr>
                            `);
                        }

                    })


                    setTimeout(() => {
                        if ($('#tbl_biometrics_data tr').length == 0) {
                            $('#tbl_biometrics_data').html(`
                                <tr>
                                    <td colspan="5">No Data Yet</td>
                                </tr>
                            `);
                        };
                    }, 500);
                } else {
                    $('#tbl_biometrics_data').html(`
                        <tr>
                            <td colspan="5">No Data Yet</td>
                        </tr>
                    `);
                }
            })
        }

        $('#example').pagination();

        var row_count = $('#row_count').val();
        var page_count = $('#page_count').val();

        console.log(row_count);
        console.log(page_count);

        $('#example').pagination({

            // the number of entries
            total: row_count,

            // current page
            current: 1,

            // the number of entires per page
            length: page_count,

            // pagination size
            size: 2,

            // Prev/Next text
            prev: "&lt;",
            next: "&gt;",

            // fired on each click
            click: function(e) {
                var row_count = $('#row_count').val();
                var page_count = $('#page_count').val();
                // console.log(e.current);
                var page_num = e.current;
                var date = $('#filter_by_date').val();

                get_biometrics_data(url_get_biometrics_data, 'test', date, page_num).then(function(data) {
                    console.log(data.length);
                    $('#tbl_biometrics_data').html(``);
                    Array.from(data).forEach(function(x) {

                        var obj = findObjectByKey(empl_info_arr, 'col_empl_cmid', "" + x.userid + "");
                        var full_name = '';
                        var employee_id = '';

                        if (obj) {
                            full_name = obj.col_frst_name + ' ' + obj.col_last_name;
                            employee_id = obj.col_empl_cmid;
                        } else {
                            full_name = 'Unknown';
                        }

                        current_date = $('#curr_date').val();

                        if (x.checktype == 'O') {
                            check_type = 'Time Out';
                        } else if (x.checktype == 'I') {
                            check_type = 'Time In';
                        }

                        var split_checktime = (x.checktime).split(' ');
                        db_date = split_checktime[0];
                        db_time = split_checktime[1] + ' ' + split_checktime[2];

                        $('#tbl_biometrics_data').append(`
                            <tr>
                                <td style="display:none;">` + x.id + `</td>
                                <td>` + db_date + `</td>
                                <td>` + db_time + `</td>
                                <td>` + check_type + `</td>
                                <td>` + x.userid + `</td>
                                <td>` + full_name + `</td>
                            </tr>
                        `);
                    })
                })

            }
        });



        async function get_employee_all_ampl_data(url, empl_id) {
            var formData = new FormData();
            formData.append('empl_cmid', empl_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_employee_data_via_cmid(url, empl_id) {
            var formData = new FormData();
            formData.append('empl_cmid', empl_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_biometrics_data(url, sample_var, date, page_num) {
            var formData = new FormData();
            formData.append('sample_var', sample_var);
            formData.append('date', date);
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