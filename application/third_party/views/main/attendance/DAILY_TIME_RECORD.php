<style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron&display=swap');
    div.dataTables_wrapper div.dataTables_paginate{
        display: flex;
    }
    .card{
        padding: 15px;
    }
    li a{
        color: #0D74BC;
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

    .badge{
        border-radius: 5px !important;
        font-weight: bold;
        padding: 8px 10px;
    }

    .icon{
        width: 140px;
        height: 140px;
        border-radius: 8px 8px 8px 8px;
        -webkit-transform-origin: 50% 10%;
        transform-origin: 50% 10%;
    }

    .icon:hover, .icon:focus
    {
        -webkit-animation: swing 0.6s ease-out;
        animation: swing 0.6s ease-out;
    }

    .time_container{
        transform: translateY(25%) !important;
    }

    @-webkit-keyframes swing {
        0%   { -webkit-transform: rotate(0deg)  skewY(0deg); }
        20%  { -webkit-transform: rotate(12deg) skewY(4deg); }
        60%  { -webkit-transform: rotate(-9deg) skewY(-3deg); }
        80%  { -webkit-transform: rotate(6deg)  skewY(-2deg); }
        100% { -webkit-transform: rotate(0deg)  skewY(0deg); }
    }

    @keyframes swing {
        0%   { transform: rotate(0deg)  skewY(0deg); }
        20%  { transform: rotate(12deg) skewY(4deg); }
        60%  { transform: rotate(-9deg) skewY(-3deg); }
        80%  { transform: rotate(6deg)  skewY(-2deg); }
        100% { transform: rotate(0deg)  skewY(0deg); }
    }

    @media screen and (max-width: 500px){
        #current_time,#current_phase{
            text-align: center;
        }
        .time_container{
            transform: translateY(25%) !important;
        }
        #btn_time_in,#btn_time_out{
            width: 100%;
            margin-bottom: 10px;
            padding: 20px 20px;
        }
    }

    @media 
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {
		
        /* Force table to not be like tables anymore */
        table, thead, tbody, th, td, tr { 
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
        
        td{ 
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

        .modal_head{
            margin-top: 15px;
            padding-bottom: 10px;
            color: #007BFF;
        }
        
        /* Labels the sliced thead of the table */
        td:nth-of-type(1):before { content: "Date"; }
        td:nth-of-type(2):before { content: "Shift"; }
        td:nth-of-type(3):before { content: "Time In"; }
        td:nth-of-type(4):before { content: "Time Out"; }
        /* Add as you add content to the thead */
	}

    /* .badge-success{

    }

    .badge-danger{

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
    <div class="flex-fill p-4">
        <div class="row">
            <div class="col-md-6">
                <h1 class="page-title">Daily Time Record</h1>
            </div>
            <div class="col-md-6">
               
            </div>
        </div>
        
        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <input type="date" class="form-control" name="att_date" id="att_date" value="<?= $DISP_DATE ?>">
                    </div>
                    <div class="col-md-6">
                        <select name="employee" class="form-control" id="employee">
                            <option value="">Choose Employee</option>
                            <?php
                                if($DISP_ALL_TIME_RECORD_DATA){
                                    foreach($DISP_ALL_TIME_RECORD_DATA as $DISP_ALL_TIME_RECORD_DATA_ROW){
                                        $empl_data = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ALL_TIME_RECORD_DATA_ROW->empl_id);
                                        $user_img = '';
                                        $fullname = '';
                                        $empl_group = 'No Group';
                                        $empl_id = '';
                                        $empl_cmid = '';
                                        if($empl_data){
                                            foreach($empl_data as $empl_data_row){
                                                if(!empty( $empl_data_row->col_midl_name)){
                                                    $midl_ini =  $empl_data_row->col_midl_name[0].'.';
                                                }else{
                                                    $midl_ini = '';
                                                }
                                                $fullname = $empl_data_row->col_last_name.', '. $empl_data_row->col_frst_name.' '.$midl_ini;
                                                if($empl_data_row->col_imag_path){
                                                    $user_img = $empl_data_row->col_imag_path;
                                                } else {
                                                    $user_img = 'default_profile_img2.png';
                                                }

                                                if($empl_data_row->col_empl_group){
                                                    $empl_group = $empl_data_row->col_empl_group;
                                                }

                                                if($empl_data_row->id){
                                                    $empl_id = $empl_data_row->id;
                                                }

                                                if($empl_data_row->col_empl_cmid){
                                                    $empl_cmid = $empl_data_row->col_empl_cmid;
                                                }
                                            }
                                        }

                                        $group_approver = $this->approval_route_mod->MOD_DISP_GROUP_APPROVERS($empl_group);
                                        $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
                                        $my_user_id = $this->session->userdata('SESS_USER_ID');

                                        foreach($approval_route as $approval_route_row){
                                            if(($group_approver[0]->approver1 == $my_user_id) || ($group_approver[0]->approver2 == $my_user_id) || ($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id) || ($approval_route_row->approver7 == $my_user_id) || ($my_user_id == 999999)){
                                                if(($empl_cmid != '8888') && ($empl_cmid != '9999')){
                                                    ?>
                                                        <option value="<?= $empl_id ?>" <?php if($DISP_EMPL){if($DISP_EMPL == $empl_id){echo 'selected';}} ?>><?= $empl_cmid.' - '.$fullname ?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                } 
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
                <div class="card">
                    <div>
                        <table class="table table-striped mb-0" id="attendance_tbl">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Shift</th>
                                    <th>Employee</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                </tr>
                            </thead>
                            <tbody id="time_record_container">
                                <?php
                                    if($DISP_ALL_TIME_RECORD_DATA){
                                        foreach($DISP_ALL_TIME_RECORD_DATA as $DISP_ALL_TIME_RECORD_DATA_ROW){
                                            

                                            $shift_data = $this->p171_workshifts_mod->MOD_GET_WRK_SHFT_DATA($DISP_ALL_TIME_RECORD_DATA_ROW->shift_id);
                                            $shift_name = '';
                                            if($shift_data){
                                                foreach($shift_data as $shift_data_row){
                                                    $shift_name = '['.$shift_data_row->code.']' . ' ' . $shift_data_row->time_in . ' - ' . $shift_data_row->time_out;
                                                }
                                            }

                                            $empl_data = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ALL_TIME_RECORD_DATA_ROW->empl_id);
                                            $user_img = '';
                                            $fullname = '';
                                            $empl_group = 'No Group';
                                            $empl_id = '';
                                            $empl_cmid = '';
                                            if($empl_data){
                                                foreach($empl_data as $empl_data_row){
                                                    if(!empty( $empl_data_row->col_midl_name)){
                                                        $midl_ini =  $empl_data_row->col_midl_name[0].'.';
                                                    }else{
                                                        $midl_ini = '';
                                                    }
                                                    $fullname = $empl_data_row->col_last_name.', '. $empl_data_row->col_frst_name.' '.$midl_ini;
                                                    if($empl_data_row->col_imag_path){
                                                        $user_img = $empl_data_row->col_imag_path;
                                                    } else {
                                                        $user_img = 'default_profile_img2.png';
                                                    }
                                                    

                                                    if($empl_data_row->col_empl_group){
                                                    $empl_group = $empl_data_row->col_empl_group;
                                                    }

                                                    if($empl_data_row->id){
                                                        $empl_id = $empl_data_row->id;
                                                    }
                                                    $empl_cmid = $empl_data_row->col_empl_cmid;
                                                }
                                            }

                                            $time_in = '';
                                            $time_out = '';
                                            $time_in_design = '';
                                            $time_out_design = '';

                                            if($DISP_ALL_TIME_RECORD_DATA_ROW->time_in == '00:00:00'){
                                                $time_in = 'NO TIME IN';
                                            } else {
                                                $time_in = $DISP_ALL_TIME_RECORD_DATA_ROW->time_in;
                                            }
                        
                                            if($DISP_ALL_TIME_RECORD_DATA_ROW->time_out == '00:00:00'){
                                                $time_out = 'NO TIME OUT';
                                            } else {
                                                $time_out = $DISP_ALL_TIME_RECORD_DATA_ROW->time_out;
                                            }

                                            if($time_in == 'NO TIME IN'){
                                                $time_in_design = 'style="background-color: #ccc !important;"';
                                            }
                                            if($time_out == 'NO TIME OUT'){
                                                $time_out_design = 'style="background-color: #ccc !important;"';
                                            }

                                            $group_approver = $this->approval_route_mod->MOD_DISP_GROUP_APPROVERS($empl_group);
                                            $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
                                            $my_user_id = $this->session->userdata('SESS_USER_ID');

                                            foreach($approval_route as $approval_route_row){
                                                if(($group_approver[0]->approver1 == $my_user_id) || ($group_approver[0]->approver2 == $my_user_id) || ($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id) || ($approval_route_row->approver7 == $my_user_id) || ($my_user_id == 999999)){
                                                    if(($empl_cmid != '8888') && ($empl_cmid != '9999') && ($DISP_ALL_TIME_RECORD_DATA_ROW->empl_id != '3')){
                                                        if($DISP_EMPL){
                                                            if($DISP_EMPL == $empl_id){
                                                                ?>
                                                                    <tr>
                                                                        <td><?= $DISP_ALL_TIME_RECORD_DATA_ROW->date ?></td>
                                                                        <td><?= $shift_name ?></td>
                                                                        <td><a href = "<?= base_url() ?>employees/personal?id=<?= $DISP_ALL_TIME_RECORD_DATA_ROW->empl_id ?>">
                                                                            <img class="rounded-circle avatar " width="35" height="35" src="<?= base_url() ?>user_images/<?= $user_img ?>">&nbsp;&nbsp;<?= $fullname ?></a>
                                                                        </td>
                                                                        <td><span class="badge badge-success" <?= $time_in_design ?>> <?= $time_in ?></span> </td>
                                                                        <td><span class="badge badge-danger" <?= $time_out_design ?>> <?= $time_out ?></span> </td>
                                                                    </tr>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                                <tr>
                                                                    <td><?= $DISP_ALL_TIME_RECORD_DATA_ROW->date ?></td>
                                                                    <td><?= $shift_name ?></td>
                                                                    <td><a href = "<?= base_url() ?>employees/personal?id=<?= $DISP_ALL_TIME_RECORD_DATA_ROW->empl_id ?>">
                                                                        <img class="rounded-circle avatar " width="35" height="35" src="<?= base_url() ?>user_images/<?= $user_img ?>">&nbsp;&nbsp;<?= $fullname ?></a>
                                                                    </td>
                                                                    <td><span class="badge badge-success" <?= $time_in_design ?>> <?= $time_in ?></span> </td>
                                                                    <td><span class="badge badge-danger" <?= $time_out_design ?>> <?= $time_out ?></span> </td>
                                                                </tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } 
                                ?>
                            </tbody>
                        </table>
                        <!-- <center><ul id="btn_pagination" class="pagination mr-auto ml-auto"></ul></center> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    // $page_count = $DISP_ROW_COUNT/20;
    
    // if(($DISP_ROW_COUNT % 20) != 0){
    //     $page_count = $page_count++;
    // }

    // $page_count = ceil($page_count);
?>

<!-- <input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT ?>">
<input type="hidden" id="page_count" value="<?= $page_count ?>"> -->


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
if($this->session->userdata('session_error_time_in')){
?>
<script>
  Swal.fire(
    'Oops',
    '<?php echo $this->session->userdata('session_error_time_in'); ?>',
    'error'
  )
</script>
<?php
$this->session->unset_userdata('session_error_time_in');
}
?>

<?php
if($this->session->userdata('session_success_time_in')){
?>
<script>
  Swal.fire(
    'Success',
    '<?php echo $this->session->userdata('session_success_time_in'); ?>',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('session_success_time_in');
}
?>

<?php
if($this->session->userdata('session_success_time_out')){
?>
<script>
  Swal.fire(
    'Success',
    '<?php echo $this->session->userdata('session_success_time_out'); ?>',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('session_success_time_out');
}
?>

<?php
if($this->session->userdata('session_error_time_out')){
?>
<script>
  Swal.fire(
    'Oops!',
    '<?php echo $this->session->userdata('session_error_time_out'); ?>',
    'error'
  )
</script>
<?php
$this->session->unset_userdata('session_error_time_out');
}
?>




<script>

    $(document).ready(function(){

        var url_get_all_daily_time_record_data = '<?= base_url() ?>attendance/get_all_daily_time_record_data';
        var url_get_shift_data = '<?php echo base_url(); ?>attendance/get_shift_data';
        var url_get_specific_employee_data = '<?php echo base_url(); ?>attendance/get_specific_employee_data';
        var url_check_if_under_supervisory = '<?php echo base_url(); ?>attendance/check_if_under_supervisory';

        var base_url = '<?= base_url() ?>';

        setTimeout(() => {
            // ===================== ACTIVATE DATATABLE PLUGIN =======================
            var empl_tbl = $('#attendance_tbl').DataTable({
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
            $('#filter_employee').on( 'keyup', function () {
                empl_tbl.search( this.value ).draw();
            } );
            $('#attendance_tbl_filter').parent().parent().hide();
        }, 1500);
        




        // var url_get_daily_time_record = '<?= base_url() ?>attendance/get_daily_time_record';
        // var url_get_shift_data = '<?= base_url() ?>attendance/get_shift_data';
        // var url_get_group_approver = '<?= base_url() ?>attendance/get_group_approver';
        // var url_get_approver_list = '<?= base_url() ?>attendance/get_approver_list';

        // $('#btn_pagination').pagination();

        // var row_count = $('#row_count').val();
        // var page_count = $('#page_count').val();

        // console.log(row_count);
        // console.log(page_count);

        // $('#btn_pagination').pagination({

        //     // the number of entries
        //     total: row_count,

        //     // current page
        //     current: 1, 

        //     // the number of entires per page
        //     length: 20, 

        //     // pagination size
        //     size: 2,

        //     // Prev/Next text
        //     prev: "&lt;", 
        //     next: "&gt;", 

        //     // fired on each click
        //     click: function (e) {
        //         $('#time_record_container').html('');

        //         var row_count = $('#row_count').val();
        //         var page_count = $('#page_count').val();
        //         // console.log(e.current);
        //         var page_num = e.current;

        //         // console.log(page_num);
                
        //         get_daily_time_record(url_get_daily_time_record,page_num).then(function(data){
        //             Array.from(data).forEach(function(time_rec){
        //                 var shift_id = '';
        //                 if(shift_id){
        //                     shift_id = time_rec.shift_id;
        //                 }
        //                 var empl_id = time_rec.empl_id;
        //                 var date = time_rec.date;
        //                 var time_in = '';
        //                 var time_out = '';
        //                 var time_in_design = '';
        //                 var time_out_design = '';
        //                 if(time_rec.time_in == '00:00:00'){
        //                     time_in = 'NO TIME IN';
        //                 } else {
        //                     time_in = time_rec.time_in;
        //                 }
        //                 if(time_rec.time_out == '00:00:00'){
        //                     time_out = 'NO TIME OUT';
        //                 } else {
        //                     time_out = time_rec.time_out;
        //                 }
        //                 if(time_rec.time_in == 'NO TIME IN'){
        //                     time_in_design = 'style="background-color: #ccc !important;"';
        //                 }
        //                 if(time_rec.time_out == 'NO TIME OUT'){
        //                     time_out_design = 'style="background-color: #ccc !important;"';
        //                 }
        //                 get_shift_data(url_get_shift_data,shift_id).then(function(data){
        //                     Array.from(data).forEach(function(shift){
        //                         var shift_name = '';
        //                         if(shift){
        //                             shift_name = '['+shift.code+']' + ' ' + shift.time_in + ' - ' + shift.time_out;
        //                         }
        //                         get_specific_employee_data(url_get_specific_employee_data,empl_id).then(function(entitle){
        //                             Array.from(entitle).forEach(function(empl){
        //                                 if(empl){
        //                                     if(empl.col_midl_name){
        //                                         var midl_ini =  empl.col_midl_name.charAt(0)+'.';
        //                                     }else{
        //                                         var midl_ini = '';
        //                                     }
        //                                     var fullname = empl.col_last_name+', '+ empl+col_frst_name+' '+midl_ini;
        //                                     if(empl.col_imag_path){
        //                                         var user_img = '<?= base_url() ?>user_images/'+empl.col_imag_path;
        //                                     } else {
        //                                         var user_img = '<?= base_url() ?>user_images/default_profile_img2.png';
        //                                     }
        //                                     if(empl.col_empl_group){
        //                                         var empl_group = empl.col_empl_group;
        //                                     }
        //                                     // var empl_id = empl.id;
        //                                     var empl_cmid = empl.col_empl_cmid;
        //                                 }
        //                                 get_group_approver(url_get_group_approver,empl_group).then(function(empl){
        //                                     Array.from(empl).forEach(function(group_approver){
        //                                         get_approver_list(url_get_approver_list).then(function(approver){
        //                                             Array.from(approver).forEach(function(approver_list){
        //                                                 var my_user_id = <?= $this->session->userdata('SESS_USER_ID')?>;
        //                                                 // if((group_approver.approver1 == my_user_id) || (group_approver.approver2 == my_user_id) || (approver_list.approver1 == my_user_id) || (approver_list.approver2 == my_user_id) || (approver_list.approver3 == my_user_id) || (approver_list.approver4 == my_user_id) || (approver_list.approver5 == my_user_id) || (approver_list.approver6 == my_user_id) || (approver_list.approver7 == my_user_id) || (my_user_id == 999999)){
        //                                                 //     if((empl_cmid != '8888') && (empl_cmid != '9999') && (empl_id != '3')){
                                                                
        //                                                         $('#time_record_container').append(`
        //                                                             <tr>
        //                                                                 <td>`+date+`</td>
        //                                                                 <td>`+shift_name+`</td>
        //                                                                 <td><a href = "<?= base_url() ?>employees/personal?id=`+empl_id+`">
        //                                                                     <img class="rounded-circle avatar " width="35" height="35" src="`+user_img+`">&nbsp;&nbsp;`+$fullname+`</a>
        //                                                                 </td>
        //                                                                 <td><span class="badge badge-success" `+time_in_design+`> `+time_in+`</span> </td>
        //                                                                 <td><span class="badge badge-danger" `+time_out_design+`> `+time_out+`</span> </td>
        //                                                             </tr>
        //                                                         `)
        //                                                 //     }
        //                                                 // }
        //                                             })
        //                                         })
        //                                     })
        //                                 })
        //                             })
        //                         })
        //                     })
        //                 })
        //             })
        //         })

        //     }
        // });

        // async function get_daily_time_record(url,page_num){
        //     var formData = new FormData();
        //     formData.append('page_num', page_num);
        //     const response = await fetch(url, {
        //     method: 'POST',
        //     body: formData
        //     });
        //     return response.json();
        // }

        // async function get_shift_data(url,shift_id){
        //     var formData = new FormData();
        //     formData.append('shift_id', shift_id);
        //     const response = await fetch(url, {
        //     method: 'POST',
        //     body: formData
        //     });
        //     return response.json();
        // }

        // async function get_group_approver(url,empl_group){
        //     var formData = new FormData();
        //     formData.append('empl_group', empl_group);
        //     const response = await fetch(url, {
        //     method: 'POST',
        //     body: formData
        //     });
        //     return response.json();
        // }

        // async function get_approver_list(url){
        //     var formData = new FormData();
        //     const response = await fetch(url, {
        //     method: 'POST',
        //     body: formData
        //     });
        //     return response.json();
        // }


        // // ===================== DISPLAY TIME RECORD BASED ON CUTOFF PERIOD =======================
        var date = $('#att_date').val();
        var employee = $('#employee').val();

        $('#att_date').change(function(){
            var att_date = $(this).val();
            employee = $('#employee').val();
            window.location.href = "<?= base_url() ?>attendance/daily_time_record?date="+att_date+"&empl_id="+employee;
        })

        $('#employee').change(function(){
            var employee = $(this).val();
            date = $('#att_date').val();
            window.location.href = "<?= base_url() ?>attendance/daily_time_record?date="+date+"&empl_id="+employee;
        })





        async function get_all_daily_time_record_data(url,date){
            var formData = new FormData();
            formData.append('date', date);
            const response = await fetch(url, {
            method: 'POST',
            body: formData
            });
            return response.json();
        }

        async function get_shift_data(url,shift_id) {
            var formData = new FormData();
            formData.append('shift_id', shift_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function get_specific_employee_data(url,empl_id) {
            var formData = new FormData();
            formData.append('empl_id', empl_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }

        async function check_if_under_supervisory(url,empl_id) {
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