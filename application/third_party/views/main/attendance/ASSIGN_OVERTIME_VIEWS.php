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
                <h1 class="page-title">Assign Overtime</h1>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() ?>employees/new_employee" type="button" data-toggle="modal" data-target="#modal_application_overtime" class="btn btn-primary shadow-none"><i class="fas fa-plus"></i> Application for Overtime</a>
            </div>
        </div>
        <hr>
        <div class = "card border-0 mt-2" style = "padding: 0px; margin: 0px">
            <div style="overflow-x:auto;">
                <table class="table table-hover">
                    <thead>
                            <th>Application ID</th>
                            <th>Application Date</th>
                            <th>Assigned By</th>
                            <th>Employee</th>
                            <th>Overtime Date</th>
                            <th>Type</th>
                            <th>Time Out</th>
                            <th>No. of Hours</th>
                            <th class="text-center">Reason</th>
                            <th>Status <br> (Approver 1)</th>
                            <th>Status <br> (Approver 2)</th>
                            <!-- <th>Status <br> (Approver 3)</th> -->
                    </thead>
                    <tbody id="tbl_application_container">
                        <?php 
                            if($DISP_ALL_OVERTIME){
                                foreach($DISP_ALL_OVERTIME as $DISP_ALL_OVERTIME_ROW){
                                    $application_id = 'OT'.str_pad($DISP_ALL_OVERTIME_ROW->id, 5, '0', STR_PAD_LEFT);
                                    $db_time_out = explode(':',$DISP_ALL_OVERTIME_ROW->time_out);
                                    $time_out = $db_time_out[0].':'.$db_time_out[1];
                                    $application_date = date('l F j, Y',strtotime($DISP_ALL_OVERTIME_ROW->date_created));
                                    $date_ot = date('l F j, Y',strtotime($DISP_ALL_OVERTIME_ROW->date_ot));
                                    $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ALL_OVERTIME_ROW->empl_id);
                                    $assigned_by = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_ALL_OVERTIME_ROW->assigned_by);

                                    // get approval route
                                    $approval_route = $this->approval_route_mod->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();

                                    // loop through the approval routes
                                    foreach($approval_route as $approval_route_row){
                                        // check if you are a approver then show the list of requests you can only approve
                                        $my_user_id = $this->session->userdata('SESS_USER_ID');
                                        if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id) || ($my_user_id = 999999)){
                                                if(!empty($assigned_by[0]->col_frst_name)){
                                                    $midl_ini = $assigned_by[0]->col_frst_name[0].'.';
                                                }else{
                                                    $midl_ini = '';
                                                }
                                                if(!empty($employee[0]->col_frst_name)){
                                                    $midl_ini2 = $employee[0]->col_frst_name[0].'.';
                                                }else{
                                                    $midl_ini2 = '';
                                                }?>
                                                <tr>
                                                    <td><?= $application_id ?></td>
                                                    <td><?= $application_date ?></td>
                                                    <td>
                                                        <a style="text-transform: capitalize;" href = "<?=base_url()?>employees/personal?id=<?= $assigned_by[0]->id ?>">
                                                            <img class="rounded-circle avatar " width="35" height="35" src="<?php if($assigned_by[0]->col_imag_path){echo base_url().'user_images/'.$assigned_by[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= strtolower($assigned_by[0]->col_last_name.', '.$assigned_by[0]->col_frst_name.' '.$midl_ini)?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a style="text-transform: capitalize;" href = "<?=base_url()?>employees/personal?id=<?= $employee[0]->id ?>">
                                                            <img class="rounded-circle avatar " width="35" height="35" src="<?php if($employee[0]->col_imag_path){echo base_url().'user_images/'.$employee[0]->col_imag_path;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp;<?= strtolower($employee[0]->col_last_name.', '.$employee[0]->col_frst_name.' '.$midl_ini2)?>
                                                        </a>
                                                    </td>
                                                    <td><?= $date_ot ?></td>
                                                    <td><?= $DISP_ALL_OVERTIME_ROW->type ?></td>
                                                    <td><?= $time_out ?></td>
                                                    <td><?= $DISP_ALL_OVERTIME_ROW->hours ?></td>
                                                    <td><?= $DISP_ALL_OVERTIME_ROW->reason ?></td>
                                                    <td><?= $DISP_ALL_OVERTIME_ROW->status1 ?></td>
                                                    <td><?= $DISP_ALL_OVERTIME_ROW->status2 ?></td>
                                                    <!-- <td><?= $DISP_ALL_OVERTIME_ROW->status3 ?></td> -->
                                                </tr>
                                            <?php
                                        } else {
                                            ?>
                                                <tr class="table-active">
                                                    <td colspan="11"><center>No Applications Yet</center></td>
                                                </tr>
                                            <?php
                                            break 2;
                                        }
                                    }
                                }
                            } else {
                                ?>
                                    <tr class="table-active">
                                        <td colspan="11"><center>No Applications Yet</center></td>
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
            <form action="<?php echo base_url('attendance/insrt_assign_overtime'); ?>" id="form_add_overtime" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required " for="EMPLOYEE_ID">Employee ID
                                </label>
                                <select name="EMPLOYEE_ID" id="EMPLOYEE_ID" class="form-control">
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
                                                if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id) || ($my_user_id = 999999)){
                                                    ?>
                                                        <option value="<?= $DISP_EMPL_INFO_ROW->id ?>"><?= $DISP_EMPL_INFO_ROW->col_empl_cmid.' - '.$DISP_EMPL_INFO_ROW->col_frst_name.' '.$DISP_EMPL_INFO_ROW->col_last_name ?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="required " for="OVERTIME_INPF_OVRTIME_DATE">Overtime Date
                                </label>
                                <input type="date" name="overtime_date" id="overtime_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="required " for="overtime_type">Type</label>
                                <!-- <input type="date" name="overtime_type" id="overtime_type" class="form-control"> -->
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
                                <input type="number" name="num_hours" id="num_hours" class="form-control" required>
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
                    <input type="hidden" name="url_directory" value="<?= $url_directory ?>">
                    <a class='btn btn-primary text-light' id="btn_apply_overtime">&nbsp; Apply
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
<script src="<?=base_url();?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
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


        var url_get_all_overtime = '<?= base_url() ?>attendance/get_assign_overtime';

        var url_get_assign_by = '<?= base_url() ?>attendance/getEmployeeData';
        var url_get_employee_by = '<?= base_url() ?>attendance/getEmployeeData';

        var url_get_approval_route = '<?= base_url() ?>attendance/get_approval_route';
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

                get_all_overtime(url_get_all_overtime,page_num).then(function(data){
                    Array.from(data).forEach(function(e){
                        var assign_id = e.assigned_by;
                        var emplo_id = e.empl_id;
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
                                                    var application_id = 'OT'+(e.id).padStart(5,0);
                                                    var application_date = new Date(e.date_created).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"});
                                                    var date_ot = new Date(e.date_ot).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"});
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
                                                            <td>`+date_ot+`</td>
                                                            <td>`+e.type+`</td>
                                                            <td>`+time_out+`</td>
                                                            <td>`+e.hours+`</td>
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


        async function get_all_overtime(url,page_num){
            var formData = new FormData();
            formData.append('page_num', page_num);
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

        async function get_assign_group(url,empl_group){
            var formData = new FormData();
            formData.append('group', empl_group);
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
    })
</script>
</body>

</html>