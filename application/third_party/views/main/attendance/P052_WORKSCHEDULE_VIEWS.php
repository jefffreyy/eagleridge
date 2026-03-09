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
    margin: 0px !important;
    font-size: 13px !important;
    padding: 10px 8px !important;
    border-top: none !important;
  }
  label.required::after{
    content:" *";
    color: red;
  }
  .widget_container{
    width: 100%;
    height: 100px;
    border: 0.5px solid #ccc;
    margin-bottom: 10px;
    border-radius: 10px;
    padding: 6px 4px;
  }
  .widget{
    background-color: #e9eff2;
    /* color: #0D74BC; */
    padding: 5px 15px;
    font-size: 12px !important;
    border-radius: 6px;
    color: #black;
    border: 1px solid #ccc;
    font-weight: 600;
    margin-right: 5px;
  }
  .remove_widget{
    cursor: pointer;
    font-size: 12px !important;
    color: red;
    margin-left: 5px;
    margin-right: -8px;
    margin-top: -5px;
  }
</style>
<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Daterange Picker -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/daterangepicker/daterangepicker.css">
<!-- Tempus Dominus -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Table Sorter -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins\tablesorter-master\dist\css\theme.default.min.css">
<!-- Include Editor style. -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<div class="content-wrapper">
  <div class="p-3">
    <div class="flex-fill">
      <div class="row pr-3 mb-2">
        <div class="col">
          <h1 class="page-title">Work Schedule
          </h1>
        </div>
      </div>
      <hr>
      <p class="text-secondary text-bold" style="font-size: 18px;">Filter Employees By:</p>
      <div class="row mb-4">
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Department</p>
            <select name="filter_department" id="filter_department" class="form-control">
                <option value="">All Departments</option>
                <?php
                    if($DISP_DISTINCT_DEPARTMENT){
                        foreach($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW){
                        ?>
                        <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?>"><?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?></option>
                        <?php
                        }
                    }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Section</p>
            <select name="filter_section" id="filter_section" class="form-control">
                <option value="">All Sections</option>
                <?php
                    if($DISP_DISTINCT_SECTION){
                        foreach($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW){
                        ?>
                        <option value="<?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?>"><?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?></option>
                        <?php
                        }
                    }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Group</p>
            <select name="filter_group" id="filter_group" class="form-control">
                <option value="">All Groups</option>
                <?php
                    if($DISP_Group){
                        foreach($DISP_Group as $DISP_Group_ROW){
                        ?>
                        <option value="<?= $DISP_Group_ROW->col_empl_group ?>"><?= $DISP_Group_ROW->col_empl_group ?></option>
                        <?php
                        }
                    }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Line</p>
            <select name="filter_line" id="filter_line" class="form-control">
                <option value="">All Lines</option>
                <?php
                    if($DISP_Line){
                        foreach($DISP_Line as $DISP_Line_ROW){
                        ?>
                        <option value="<?= $DISP_Line_ROW->col_empl_line ?>"><?= $DISP_Line_ROW->col_empl_line ?></option>
                        <?php
                        }
                    }
                ?>
            </select>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-2">
          <br>
            <a href="#" id="clear_filter" class="btn btn-primary float-right">Clear Filter</a>
        </div>
      </div>
      <hr>
      <p class="text-secondary text-bold" style="font-size: 18px;">Set Workshift:</p>
      <div class="row mb-3">
        <div class="col-3">
            <div style="width: 100px;">
                <label for="search_employees" style="font-weight: 500">Cut-off Period</label>
            </div>
            <div class="flex-fill">
                <select name="cutoff_period" id="cutoff_period" class="form-control">
                    <option value="">Select Period...</option>
                    <?php
                        if($DISP_PAYROLL_SCHED){
                            foreach($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW){
                            ?>
                            <option value="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>"><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-3">
            <div style="width: 100px;">
                <label for="search_employees" style="font-weight: 500">Employee ID</label>
            </div>
            <div class="flex-fill">
                <select name="employee_id" id="employee_id" class="form-control">
                    <option value="1" id="empl_id_name_based" selected>D00001</option>
                    <?php
                        if($DISP_EMP_LIST){
                            foreach($DISP_EMP_LIST as $DISP_EMP_LIST_ROW){
                            ?>
                            <option value="<?= $DISP_EMP_LIST_ROW->id ?>"><?= $DISP_EMP_LIST_ROW->col_empl_cmid.' - '.$DISP_EMP_LIST_ROW->col_frst_name.' '.$DISP_EMP_LIST_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-3">
            <div style="width: 115px;">
                <label for="employee_name" style="font-weight: 500">Employee Name</label>
            </div>
            <div class="flex-fill" id="employee_name_container">
                <label id='employee_fullname'>Wilmer Andre Cruz</label>
            </div>
        </div>
        <div class="col-3">
            <!-- <div class="col-8">
              <a href="<?= base_url() ?>attendance/generate_rows" class="btn btn-primary float-right">Generate 365 rows</a>
            </div> -->
            <br>
            <button href="#" id="apply_template_toggle_modal" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_apply_template" disabled>Apply Shift Template</button>
            <button href="#" id="copy_shift_toggle_modal" class="btn btn-primary float-right mr-3" data-toggle="modal" data-target="#modal_copy_shift" disabled>Copy Shift</button>
        </div>
      </div>
      <div class="card">
        <table class="table table-hover table-xs mb-0" id="tbl_work_sched">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>DOW</th>
                    <th>Employee</th>
                    <th>Day Code</th>
                    <th>Shift for the Day</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="cutoff_container">
              <tr>
                <td colspan="9" class="text-center py-5" style="background-color: #f0f0f0;">No selected cut-off period</td>
              </tr>
            </tbody>
        </table>
        <div class="w-100 text-center">
          <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
        </div>
      </div>
    </div>
    <!-- flex-fill -->
  </div>
  <!-- p-3 -->
</div>
<!-- content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- =============== APPY TEMPLATE ================= -->
<div class="modal fade" id="modal_apply_template" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Apply Shift Template
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="from_date">From Date</label>
              <select id="from_date" class="form-control">
                  
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="to_date">To Date</label>
              <select id="to_date" class="form-control">
                  
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="required " for="ATTENDANCE_INPF_NAME">Shift Name
              </label>
              <select name="work_shift_template" id="work_shift_template" class="form-control">
                  <option value="">Choose Template...</option>
                  <?php
                      if($DISP_SHIFT_TEMPLATE){
                          foreach($DISP_SHIFT_TEMPLATE as $DISP_SHIFT_TEMPLATE_ROW){
                          ?>
                            <option value="<?= $DISP_SHIFT_TEMPLATE_ROW->id ?>"><?= $DISP_SHIFT_TEMPLATE_ROW->name ?></option>
                          <?php
                          }
                      }
                  ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a class='btn btn-primary text-light' id="btn_apply_template">&nbsp; Apply
        </a>
      </div>
    </div>
  </div>
</div>

<!-- =============== SET SHIFT ================= -->
<div class="modal fade" id="modal_set_shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Set Shift
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="required " for="set_shift_name">Shift Name
              </label>
              <select name="set_shift_name" id="set_shift_name" class="form-control" required>
                  <option value="">Choose Template...</option>
                  <?php
                      if($DISP_WORK_SHIFT){
                          foreach($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW){
                          ?>
                            <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                          <?php
                          }
                      }
                  ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="modal_employee_id" name="modal_employee_id" class="form-control">
        <input type="hidden" id="schedule_id" name="schedule_id" class="form-control">
        <button class='btn btn-primary text-light' id="btn_updt_shift">&nbsp; Save
        </button>
      </div>
    </div>
  </div>
</div>




<!-- =============== COPY SHIFT ================= -->
<div class="modal fade" id="modal_copy_shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Copy Shift To
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="mt-2 px-2">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="required" for="filter_by_department">Filter by Department:</label>
                    <div class="input-group">
                      <select name="filter_by_department" id="filter_by_department" class="form-control">
                          <option value="">All Department</option>
                          <?php
                              if($DISP_DISTINCT_DEPARTMENT){
                                  foreach($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW){
                                  ?>
                                  <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?>"><?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?></option>
                                  <?php
                                  }
                              }
                          ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="required" for="filter_by_section">Filter by Section:</label>
                    <div class="input-group">
                      <select name="filter_by_section" id="filter_by_section" class="form-control">
                          <option value="">All Sections</option>
                          <?php
                              if($DISP_DISTINCT_SECTION){
                                  foreach($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW){
                                  ?>
                                  <option value="<?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?>"><?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?></option>
                                  <?php
                                  }
                              }
                          ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="required" for="filter_by_group">Filter by Group:</label>
                    <div class="input-group">
                        <select name="filter_by_group" id="filter_by_group" class="form-control">
                            <option value="">All Groups</option>
                            <?php
                                if($DISP_Group){
                                    foreach($DISP_Group as $DISP_Group_ROW){
                                    ?>
                                    <option value="<?= $DISP_Group_ROW->col_empl_group ?>"><?= $DISP_Group_ROW->col_empl_group ?></option>
                                    <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="required" for="filter_by_line">Filter by Line:</label>
                    <div class="input-group">
                        <select name="filter_by_line" id="filter_by_line" class="form-control">
                            <option value="">All Lines</option>
                            <?php
                                if($DISP_Line){
                                    foreach($DISP_Line as $DISP_Line_ROW){
                                    ?>
                                    <option value="<?= $DISP_Line_ROW->col_empl_line ?>"><?= $DISP_Line_ROW->col_empl_line ?></option>
                                    <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                  </div>
                  <a href="#" id="btn_clear_filter" class="btn btn-primary float-right">Clear Filter</a>
                </div>
              </div>

              <hr>

              <div class="form-group">
                <label class="required" for="modal_employee_id_group">Employee ID</label>
                <div class="input-group">
                  <select name="modal_employee_id_group" id="modal_employee_id_group" class="form-control">
                      <option value="" disabled>Choose Employee...</option>
                      <?php
                          if($DISP_EMP_LIST){
                              foreach($DISP_EMP_LIST as $DISP_EMP_LIST_ROW){
                              ?>
                              <option value="<?= $DISP_EMP_LIST_ROW->id ?>"><?= $DISP_EMP_LIST_ROW->col_empl_cmid.' - '.$DISP_EMP_LIST_ROW->col_frst_name.' '.$DISP_EMP_LIST_ROW->col_last_name ?></option>
                              <?php
                              }
                          }
                      ?>
                  </select>
                  <span class="input-group-append">
                    <button type="button" id="btn_add_widget" class="btn btn-primary">Add</button>
                  </span>
                </div>
              </div>
              <label for="ATTENDANCE_INPF_NAME">Apply Shift Template to Employees:</label>
              <div class="widget_container">

              </div>
            </div>
          </div>
        </div>
      </div>
      
      <form action="<?php echo base_url('attendance/copy_shift_schedule'); ?>" id="form_copy_shift" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-footer">
          <input type="hidden" id="modal_employee_id" name="modal_employee_id" class="form-control">
          <input type="hidden" id="schedule_id" name="schedule_id" class="form-control">
          <div id="widget_input_container">

          </div>
          <div id="date_shift_container">

          </div>
          <a class='btn btn-primary text-light' id="btn_copy_shift">&nbsp; Apply </a>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- LOGOUT MODAL -->
<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?
        </p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <p>Hi are you sure you want to logout?
        </p>
      </div>
      <div class="modal-footer pb-1 pt-1">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
        </button>
        <a href="<?php echo base_url().'login/logout'; ?>" class="btn btn-info">Logout
        </a>
      </div>
    </div>
  </div>
</div>
<!-- jQuery -->
<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js">
</script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js">
</script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js">
</script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js">
</script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js">
</script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
</script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/adminlte.js">
</script>
<!-- Full Calendar 2.2.5 -->
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js">
</script>
<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js">
</script>
<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js">
</script>
<!-- Toastr -->
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js">
</script>
<!-- DateRange Picker -->
<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js">
</script>
<!-- Table Sorter -->
<script type="text/javascript" src="<?= base_url(); ?>plugins/tablesorter-master/dist/js/jquery.tablesorter.min.js"></script>

<?php
if($this->session->userdata('SESS_SUCC_MSG_UPDT_SHIFT')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_SHIFT'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_UPDT_SHIFT');
}
?>

<?php
if($this->session->userdata('success_copy_shift')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('success_copy_shift'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('success_copy_shift');
}
?>

<script>
  $(document).ready(function(){
    var is_executed = false;
    $("#tbl_work_sched").tablesorter();

    // update shift asynchronously
    var url5 = '<?php echo base_url(); ?>attendance/updt_shift_async';

    // get holiday data
    var url_holiday = '<?php echo base_url(); ?>attendance/get_holiday_data';

    // =========================== GENERATE DATES AND DAYS BASED ON CHOSEN PERIOD ====================================
    var url = '<?php echo base_url(); ?>attendance/get_cutoff_schedule_data';
    $('#cutoff_period').change(function(){
        // show loading indicator
        $('#loader_gif').show();

        // disable apply template button
        $('#apply_template_toggle_modal').prop('disabled',false);
        $('#copy_shift_toggle_modal').prop('disabled',false);

        $('#cutoff_container').html('');
        var date = $(this).val();
        var employee_id = $('#employee_id').val();

        get_employee_data(url2, employee_id,date).then(data => {
          if($('#cutoff_period').val()){
            $('#cutoff_container').html('');
            data.cutoff_data.forEach((x) => {
              var cutoff_id = x.id;
              var db_shift_id = x.shift_id;
              var db_date = x.date;
              var db_time_in = x.time_in;
              var db_time_out = x.time_out;
              var db_date = db_date.split(" ");
              var date_period = moment(x.date).format('LL');
              var day_of_work = moment(x.date).format('dddd');

              var empl_arr = [];
              get_employee_data(url2, x.empl_id,$('#cutoff_period').val()).then(data1 => {
                data1.employee_data.forEach((x) => {
                    empl_arr.push(x.col_frst_name+" "+x.col_last_name);
                    empl_arr.push(x.id);
                })

                var holiday_arr = [];
                get_holiday_data(url_holiday).then(data2 => {
                  data2.holiday.forEach((x) => {
                    holiday_arr.push(x.col_holi_date);
                    holiday_arr.push(x.col_holi_type);
                  })

                  var day_code = '';
                  if(holiday_arr.includes(db_date[0])){
                    var holi_index = holiday_arr.indexOf(db_date[0]);
                    holi_index++;

                    day_code = holiday_arr[holi_index];
                  } else {
                    day_code = 'Regular';
                  }

                  var shift_arr = [];
                  get_shift_data(url4, db_shift_id).then(data4 => {

                    data4.forEach((x) => {
                      shift_arr.push(x.code);
                      shift_arr.push(x.time_in);
                      shift_arr.push(x.time_out);
                    })

                    var shift_name = '';
                    if(shift_arr.length > 0){
                      var shift_code = shift_arr[0];
                      var shift_time_in = shift_arr[1];
                      var shift_time_out = shift_arr[2];

                      shift_name = '['+shift_code+']'+' '+shift_time_in+' - '+shift_time_out;
                    }
                    
                    $('#cutoff_container').append(`
                      <tr class="cutoff">
                          <td>`+db_date+`</td>
                          <td>`+day_of_work+`</td>
                          <td empl_id="`+empl_arr[1]+`">`+empl_arr[0]+`</td>
                          <td>`+day_code+`</td>
                          <td sched_id="`+cutoff_id+`" class="shift_num" shift_id="`+db_shift_id+`">`+shift_name+`</td>
                          <td>
                              <center>
                                  <a href="#" class="text-white btn btn-primary BTN_SET_SHIFT" cutoff_id="`+cutoff_id+`" data-toggle="modal" data-target="#modal_set_shift">Set Shift</a>
                              </center>
                          </td>
                      </tr>
                    `);
                    set_shift();
                    is_executed = true;
                  })
                })
              })
            })
          }
          data.employee_data.forEach((x) => {
              $('#employee_fullname').html(x.col_frst_name+" "+x.col_last_name);
          })
        })
    })

    

    // ============================== GET EMPLOYEE DATA BASED ON CHOSEND ID/NAME ====================================
    var url2 = '<?php echo base_url(); ?>attendance/get_employee_data';
    $('#employee_id').change(function(){
        var employee_id = $(this).val();
        var date_period = $('#cutoff_period').val();

        // show loading indicator
        $('#loader_gif').show();

        get_employee_data(url2, employee_id,date_period).then(data => {
          if($('#cutoff_period').val()){
            $('#cutoff_container').html('');
            data.cutoff_data.forEach((x) => {
              var cutoff_id = x.id;
              var db_shift_id = x.shift_id;
              var db_date = x.date;
              var db_time_in = x.time_in;
              var db_time_out = x.time_out;
              var db_date = db_date.split(" ");
              var date_period = moment(x.date).format('LL');
              var day_of_work = moment(x.date).format('dddd');

              var empl_arr = [];
              get_employee_data(url2, x.empl_id,$('#cutoff_period').val()).then(data1 => {
                data1.employee_data.forEach((x) => {
                    empl_arr.push(x.col_frst_name+" "+x.col_last_name);
                    empl_arr.push(x.id);
                })

                var holiday_arr = [];
                get_holiday_data(url_holiday).then(data2 => {
                  data2.holiday.forEach((x) => {
                    holiday_arr.push(x.col_holi_date);
                    holiday_arr.push(x.col_holi_type);
                  })

                  var day_code = '';
                  if(holiday_arr.includes(db_date[0])){
                    var holi_index = holiday_arr.indexOf(db_date[0]);
                    holi_index++;

                    day_code = holiday_arr[holi_index];
                  } else {
                    day_code = 'Regular';
                  }

                  var shift_arr = [];
                  get_shift_data(url4, db_shift_id).then(data4 => {

                    data4.forEach((x) => {
                      shift_arr.push(x.code);
                      shift_arr.push(x.time_in);
                      shift_arr.push(x.time_out);
                    })

                    var shift_name = '';
                    if(shift_arr.length > 0){
                      var shift_code = shift_arr[0];
                      var shift_time_in = shift_arr[1];
                      var shift_time_out = shift_arr[2];

                      shift_name = '['+shift_code+']'+' '+shift_time_in+' - '+shift_time_out;
                    }
                    
                    $('#cutoff_container').append(`
                      <tr class="cutoff">
                          <td>`+db_date+`</td>
                          <td>`+day_of_work+`</td>
                          <td empl_id="`+empl_arr[1]+`">`+empl_arr[0]+`</td>
                          <td>`+day_code+`</td>
                          <td sched_id="`+cutoff_id+`" class="shift_num" shift_id="`+db_shift_id+`">`+shift_name+`</td>
                          <td>
                              <center>
                                  <a href="#" class="text-white btn btn-primary BTN_SET_SHIFT" cutoff_id="`+cutoff_id+`" data-toggle="modal" data-target="#modal_set_shift">Set Shift</a>
                              </center>
                          </td>
                      </tr>
                    `);
                    set_shift();
                    is_executed = true;
                  })
                })
              })
            })
          }
          data.employee_data.forEach((x) => {
              $('#employee_fullname').html(x.col_frst_name+" "+x.col_last_name);
              // $('#empl_name_id_based').val(x.id);
              // $('#employee_name').val(x.id);
          })
        })
    })

    function load_auto_sort(){
      $("#tbl_work_sched").trigger("update");
      if($(".tablesorter-headerUnSorted[data-column=0]").length > 0){
        $(".tablesorter-headerUnSorted[data-column=0]").click();
      }
    }
          
    setInterval(() => {
      if(is_executed == true){
        load_auto_sort();
        is_executed = false;
        $('#cutoff_container').show();
        $('#loader_gif').hide();
      }
    }, 10);



    // ================================= APPLY SHIFT TEMPLATE MODAL =======================================
    $('#apply_template_toggle_modal').click(function(){
      $('#from_date').html(''); // clear date upon clicking toggle modal
      $('#to_date').html(''); // clear date upon clicking toggle modal
      $('#from_date').append(`
        <option value="">Choose Date...</option>
      `); // set inital empty value
      $('#to_date').append(`
        <option value="">Choose Date...</option>
      `); // set inital empty value


      dates = []; // store array of dates from table
      Array.from($('.cutoff')).forEach(function(element){
        var date = $(element.childNodes[1]).text();
        dates.push(date);
      })
      dates.forEach(function(value){
        $('#from_date').append(`
          <option value="`+value+`">`+value+`</option>
        `);
        $('#to_date').append(`
          <option value="`+value+`">`+value+`</option>
        `)
      })
    })


    // get shift template data
    var url3 = '<?php echo base_url(); ?>attendance/get_work_shift_data';
    // get shift data
    var url4 = '<?php echo base_url(); ?>attendance/get_shift_data';
    // ============================== APPLY SHIFT TEMPLATE ====================================
    $('#btn_apply_template').click(function(e){
      e.preventDefault();

      Swal.fire({
        title: 'Do you want to apply this template?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          var template_id = $('#work_shift_template').val();
          get_work_shift_data(url3, template_id).then(data => {
              
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();

            if(from_date && to_date){
              dates = []; // store array of dates from table
              Array.from($('.cutoff')).forEach(function(element){
                var date = $(element.childNodes[1]).text();
                dates.push(date);
              })

              var start = dates.indexOf(from_date); // get the index of date from dates array
              var end = (dates.indexOf(to_date)) + 1; // get the index of date from dates array

              var filtered_dates = dates.slice(start, end); // slice the array with the range beginning with start to end

              Array.from($('.cutoff')).forEach(function(tr){
                filtered_dates.forEach(function(date){
                  console.log(date);
                  var tbl_date = $(tr.childNodes[1]).text();
                  var tbl_dow = $(tr.childNodes[3]).text();
                  if(date.includes(tbl_date)){
                    switch(tbl_dow){
                      case 'Monday':
                        get_shift_data(url4, data[0].monday).then(shift_data => {
                          if(shift_data.length > 0)
                          {
                            shift_data.forEach((x) => {
                              $(tr.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                              var sched_id = $(tr.childNodes[9]).attr('sched_id');
                              var shift_id = x.id;

                              updt_shift_async(url5,shift_id,sched_id).then(data => {
                                // enter code after update
                                console.log(sched_id);
                              })
                            });
                          }
                        })
                        break;
                      case 'Tuesday':
                        get_shift_data(url4, data[0].tuesday).then(shift_data => {
                          if(shift_data.length > 0)
                          {
                            shift_data.forEach((x) => {
                              $(tr.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                              var sched_id = $(tr.childNodes[9]).attr('sched_id');
                              var shift_id = x.id;

                              updt_shift_async(url5,shift_id,sched_id).then(data => {
                                // enter code after update
                                console.log(sched_id);
                              })
                            });
                          }
                        })
                        break;
                      case 'Wednesday':
                        get_shift_data(url4, data[0].wednesday).then(shift_data => {
                          if(shift_data.length > 0)
                          {
                            shift_data.forEach((x) => {
                              $(tr.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                              var sched_id = $(tr.childNodes[9]).attr('sched_id');
                              var shift_id = x.id;

                              updt_shift_async(url5,shift_id,sched_id).then(data => {
                                // enter code after update
                                console.log(sched_id);
                              })
                            });
                          }
                        })
                        break;
                      case 'Thursday':
                        get_shift_data(url4, data[0].thursday).then(shift_data => {
                          if(shift_data.length > 0)
                          {
                            shift_data.forEach((x) => {
                              $(tr.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                              var sched_id = $(tr.childNodes[9]).attr('sched_id');
                              var shift_id = x.id;

                              updt_shift_async(url5,shift_id,sched_id).then(data => {
                                // enter code after update
                                console.log(sched_id);
                              })
                            });
                          }
                        })
                        break;
                      case 'Friday':
                        get_shift_data(url4, data[0].friday).then(shift_data => {
                          if(shift_data.length > 0)
                          {
                            shift_data.forEach((x) => {
                              $(tr.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                              var sched_id = $(tr.childNodes[9]).attr('sched_id');
                              var shift_id = x.id;

                              updt_shift_async(url5,shift_id,sched_id).then(data => {
                                // enter code after update
                                console.log(sched_id);
                              })
                            });
                          }
                        })
                        break;
                      case 'Saturday':
                        get_shift_data(url4, data[0].saturday).then(shift_data => {
                          if(shift_data.length > 0)
                          {
                            shift_data.forEach((x) => {
                              $(tr.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                              var sched_id = $(tr.childNodes[9]).attr('sched_id');
                              var shift_id = x.id;

                              updt_shift_async(url5,shift_id,sched_id).then(data => {
                                // enter code after update
                                console.log(sched_id);
                              })
                            });
                          }
                        })
                        break;
                      case 'Sunday':
                        get_shift_data(url4, data[0].sunday).then(shift_data => {
                          if(shift_data.length > 0)
                          {
                            shift_data.forEach((x) => {
                              $(tr.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                              var sched_id = $(tr.childNodes[9]).attr('sched_id');
                              var shift_id = x.id;

                              updt_shift_async(url5,shift_id,sched_id).then(data => {
                                // enter code after update
                                console.log(sched_id);
                              })
                            });
                          }
                        })
                        break;
                      default:
                      $(tr.childNodes[9]).text('');
                    }
                  }
                })
              })
            } else {
              // console.log('No existing date range');
              Array.from($('.cutoff')).forEach(function(element){
                switch($(element.childNodes[3]).text()){
                  case 'Monday':
                    get_shift_data(url4, data[0].monday).then(data => {
                        data.forEach((x) => {
                          $(element.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                          var sched_id = $(element.childNodes[9]).attr('sched_id');
                          var shift_id = x.id;

                          updt_shift_async(url5,shift_id,sched_id).then(data => {
                            // enter code after update
                            console.log(sched_id);
                          })
                        });
                    })
                    break;
                  case 'Tuesday':
                    get_shift_data(url4, data[0].tuesday).then(data => {
                      if(data.length > 0)
                      {
                        data.forEach((x) => {
                          $(element.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                          var sched_id = $(element.childNodes[9]).attr('sched_id');
                          var shift_id = x.id;

                          updt_shift_async(url5,shift_id,sched_id).then(data => {
                            // enter code after update
                            console.log(sched_id);
                          })
                        });
                      }
                    })
                    break;
                  case 'Wednesday':
                    get_shift_data(url4, data[0].wednesday).then(data => {
                      if(data.length > 0)
                      {
                        data.forEach((x) => {
                          $(element.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                          var sched_id = $(element.childNodes[9]).attr('sched_id');
                          var shift_id = x.id;

                          updt_shift_async(url5,shift_id,sched_id).then(data => {
                            // enter code after update
                            console.log(sched_id);
                          })
                        });
                      }
                    })
                    break;
                  case 'Thursday':
                    get_shift_data(url4, data[0].thursday).then(data => {
                      if(data.length > 0)
                      {
                        data.forEach((x) => {
                          $(element.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                          var sched_id = $(element.childNodes[9]).attr('sched_id');
                          var shift_id = x.id;

                          updt_shift_async(url5,shift_id,sched_id).then(data => {
                            // enter code after update
                            console.log(sched_id);
                          })
                        });
                      }
                    })
                    break;
                  case 'Friday':
                    get_shift_data(url4, data[0].friday).then(data => {
                      if(data.length > 0)
                      {
                        data.forEach((x) => {
                          $(element.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                          var sched_id = $(element.childNodes[9]).attr('sched_id');
                          var shift_id = x.id;

                          updt_shift_async(url5,shift_id,sched_id).then(data => {
                            // enter code after update
                            console.log(sched_id);
                          })
                        });
                      }
                    })
                    break;
                  case 'Saturday':
                    get_shift_data(url4, data[0].saturday).then(data => {
                      if(data.length > 0)
                      {
                        data.forEach((x) => {
                          $(element.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                          var sched_id = $(element.childNodes[9]).attr('sched_id');
                          var shift_id = x.id;

                          updt_shift_async(url5,shift_id,sched_id).then(data => {
                            // enter code after update
                            console.log(sched_id);
                          })
                        });
                      }
                    })
                    break;
                  case 'Sunday':
                    get_shift_data(url4, data[0].sunday).then(data => {
                      if(data.length > 0)
                      {
                        data.forEach((x) => {
                          $(element.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
                          var sched_id = $(element.childNodes[9]).attr('sched_id');
                          var shift_id = x.id;

                          updt_shift_async(url5,shift_id,sched_id).then(data => {
                            // enter code after update
                            console.log(sched_id);
                          })
                        });
                      }
                    })
                    break;
                  default:
                  $(element.childNodes[9]).text('');
                }
              })
            }
            

            // $('.BTN_SET_SHIFT').click(function(e){
            //   e.preventDefault();
            //   var cutoff_id = $(this).attr('cutoff_id');
            //   $('#schedule_id').val(cutoff_id);
            // })
          })
          // $('#modal_apply_template').modal('toggle');
        }
      })
    })

    // Display Shift id in the modal
    function set_shift(){
      $('.BTN_SET_SHIFT').click(function(e){
        e.preventDefault();
        var parent = $(this).parent().parent().parent();
        var parent_container = Array.from(parent)[0];
        var shift_id = $(parent_container.childNodes[9]).attr('shift_id');
        var cutoff_id = $(this).attr('cutoff_id');
        $('#schedule_id').val(cutoff_id);
        $('#set_shift_name').val(shift_id);

        var employee_id = $(parent_container.childNodes[5]).attr('empl_id');
        $('#modal_employee_id').val(employee_id);

        var date_period = $(parent_container.childNodes[1]).attr('empl_id');

      })
    }

    $('#btn_updt_shift').click(function(){
      var schedule_id = $('#schedule_id').val();
      var shift_id = $('#set_shift_name').val();
      
      var selector = 'a[cutoff_id|='+schedule_id+']';
      var parent = $(selector).parent().parent().parent();
      var parent_container = Array.from(parent)[0];
      $(parent_container.childNodes[9]).text(shift_id);

      get_shift_data(url4, shift_id).then(data => {
        if(data.length > 0)
        {
          data.forEach((x) => {
            $(parent_container.childNodes[9]).text('['+x.code+']' + ' ' + x.time_in + ' - ' + x.time_out);
          });
        }
      })

      updt_shift_async(url5,shift_id,schedule_id).then(data => {
        // enter code after update
        console.log(data);
      })

      $('#modal_set_shift').modal('toggle');
    })






































    $('#btn_add_widget').click(function(){
      var employee_id = $('#modal_employee_id_group').val();
      var employee_cmid = $('#modal_employee_id_group option:selected').text();
      $('.widget_container').append(`
        <span empl_id="`+employee_id+`" class="widget">
          `+employee_cmid+`
          <span class="remove_widget">x</span>
        </span>
      `);

      $('#widget_input_container').append(`
        <input type="hidden" id="empl_`+employee_id+`" value="`+employee_id+`" name="employees[]">
      `)

      $('#modal_employee_id_group option[value='+employee_id+']').remove();







      $('.remove_widget').click(function(){
        var remove_empl_id = $(this).parent().attr('empl_id');
        var remove_empl_cmid = $(this).parent().text();
        remove_empl_cmid_new = remove_empl_cmid.replace('x', '');

        $('.widget_container span[empl_id='+remove_empl_id+']').remove();
        $('#widget_input_container input[id=empl_'+remove_empl_id+']').remove();

        if ($('#modal_employee_id_group').find('option[value='+remove_empl_id+']').length == 0) {
          $('#modal_employee_id_group').append(`
            <option value="`+remove_empl_id+`">`+remove_empl_cmid_new.trim()+`</option>
          `)
        }
      })
    })

    

    // ====================== COPY SHIFT TRIGGER MODAL ========================
    $('#copy_shift_toggle_modal').click(function(){
      Array.from($('.cutoff')).forEach(function(element){
        var shift = $(element.childNodes[9]).attr('shift_id');
        var date = $(element.childNodes[1]).text();

        $('#date_shift_container').append(`
          <input type="hidden" value="`+date+` `+shift+`" name="date_shift[]">
        `)
      })
    })

    /* 
     *
     *
     *   ================================ COPY SHIFT FILTER FOR EMPLOYEES ===========================
     *
     *
     */

    // ======================= FILTER BY DEPARTMENT ================================
    var url_filter_by_department = '<?= base_url() ?>attendance/get_employee_data_filter_by_dept';
    var url_filter_section_by_department = '<?= base_url() ?>attendance/get_employee_section_data_filter_by_dept';
    $('#filter_by_department').change(function(){
      var department = $(this).val();
      // var section = $('#filter_by_section').val();
      // if(department && !section){
      if(department){
        // change employee dropdown
        $('#modal_employee_id_group').html('');
        get_employee_data_filter_by_dept(url_filter_by_department, department).then(function(data){
          $('#modal_employee_id_group').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#modal_employee_id_group').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
            `);
          })
        })

        //change section dropdown
        // $('#filter_by_section').html('');
        // get_employee_section_data_filter_by_dept(url_filter_section_by_department, department).then(function(data){
        //   $('#filter_by_section').append(`
        //     <option value="">All Sections</option>
        //   `);
        //   Array.from(data).forEach(function(x){
        //     $('#filter_by_section').append(`
        //       <option value="`+x.col_empl_sect+`">`+x.col_empl_sect+`</option>
        //     `);
        //   })
        // })

        
      // } else if (department && section){
        
      // } else if (!department) {
      } else {
        $('#modal_employee_id_group').html('');
        get_all_employee_data(url_get_all_empl_data).then(function(data){
          $('#modal_employee_id_group').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#modal_employee_id_group').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
            `);
          })
        })
      }
    })

    // ======================= FILTER BY SECTION ================================
    var url_filter_by_section = '<?= base_url() ?>attendance/get_employee_data_filter_by_sect';
    var url_get_all_empl_data = '<?= base_url() ?>employees/get_all_employee_data';
    $('#filter_by_section').change(function(){
      var section = $(this).val();
      if(section){
        $('#modal_employee_id_group').html('');
        get_employee_data_filter_by_sect(url_filter_by_section, section).then(function(data){
          $('#modal_employee_id_group').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#modal_employee_id_group').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
            `);
          })
        })
      } else {
        $('#modal_employee_id_group').html('');
        get_all_employee_data(url_get_all_empl_data).then(function(data){
          $('#modal_employee_id_group').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#modal_employee_id_group').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
            `);
          })
        })
      }
    })

    // ======================= FILTER BY GROUP ================================
    var url_filter_by_group = '<?= base_url() ?>attendance/get_employee_data_filter_by_group';
    $('#filter_by_group').change(function(){
      var group = $(this).val();
      if(group){
        $('#modal_employee_id_group').html('');
        get_employee_data_filter_by_group(url_filter_by_group, group).then(function(data){
          $('#modal_employee_id_group').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#modal_employee_id_group').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
            `);
          })
        })
      } else {
        $('#modal_employee_id_group').html('');
        get_all_employee_data(url_get_all_empl_data).then(function(data){
          $('#modal_employee_id_group').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#modal_employee_id_group').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
            `);
          })
        })
      }
    })

    // ======================= FILTER BY LINE ================================
    var url_filter_by_line = '<?= base_url() ?>attendance/get_employee_data_filter_by_line';
    $('#filter_by_line').change(function(){
      var line = $(this).val();
      if(line){
        $('#modal_employee_id_group').html('');
        get_employee_data_filter_by_line(url_filter_by_line, line).then(function(data){
          $('#modal_employee_id_group').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#modal_employee_id_group').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
            `);
          })
        })
      } else {
        $('#modal_employee_id_group').html('');
        get_all_employee_data(url_get_all_empl_data).then(function(data){
          $('#modal_employee_id_group').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#modal_employee_id_group').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
            `);
          })
        })
      }
    })

    // ========================================== CLEAR FILTER ===============================================
    $('#btn_clear_filter').click(function(){
      $('#filter_by_section').val('');
      $('#filter_by_department').val('');
      $('#filter_by_group').val('');
      $('#filter_by_line').val('');

      $('#modal_employee_id_group').html('');
      get_all_employee_data(url_get_all_empl_data).then(function(data){
        $('#modal_employee_id_group').append(`
          <option value="" disabled>Choose Employee...</option>
        `);
        Array.from(data).forEach(function(x){
          $('#modal_employee_id_group').append(`
            <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
          `);
        })
      })
    })



    /* 
     *
     *
     *   ================================  TOP FILTER FOR EMPLOYEES ===========================
     *
     *
     */

    var url_filter_by_department = '<?= base_url() ?>attendance/get_employee_data_filter_by_dept';
    var url_filter_section_by_department = '<?= base_url() ?>attendance/get_employee_section_data_filter_by_dept';
    var url_filter_by_section = '<?= base_url() ?>attendance/get_employee_data_filter_by_sect';
    var url_get_all_empl_data = '<?= base_url() ?>employees/get_all_employee_data';
    var url_filter_by_group = '<?= base_url() ?>attendance/get_employee_data_filter_by_group';
    var url_filter_by_line = '<?= base_url() ?>attendance/get_employee_data_filter_by_line';

    // =============================== FILTER BY SECTION =================================
    $('#filter_section').change(function(){
      var section = $(this).val();
      if(section){
        $('#employee_id').html('');
        get_employee_data_filter_by_sect(url_filter_by_section, section).then(function(data){
          $('#employee_id').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#employee_id').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
            `);
          })
        })
      } else {
        $('#employee_id').html('');
        get_all_employee_data(url_get_all_empl_data).then(function(data){
          $('#employee_id').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#employee_id').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
            `);
          })
        })
      }
    })

    // =============================== FILTER BY DEPARTMENT =================================
    $('#filter_department').change(function(){
      var department = $(this).val();
      if(department){
        // change employee dropdown
        $('#employee_id').html('');
        get_employee_data_filter_by_dept(url_filter_by_department, department).then(function(data){
          $('#employee_id').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#employee_id').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
            `);
          })
        })
      } else {
        $('#employee_id').html('');
        get_all_employee_data(url_get_all_empl_data).then(function(data){
          $('#employee_id').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#employee_id').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
            `);
          })
        })
      }
    })

    // =============================== FILTER BY GROUP =================================
    $('#filter_group').change(function(){
      var group = $(this).val();
      if(group){
        // change employee dropdown
        $('#employee_id').html('');
        get_employee_data_filter_by_group(url_filter_by_group, group).then(function(data){
          $('#employee_id').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#employee_id').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+' '+x.col_last_name+`</option>
            `);
          })
        })
      } else {
        $('#employee_id').html('');
        get_all_employee_data(url_get_all_empl_data).then(function(data){
          $('#employee_id').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#employee_id').append(`
            <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+' '+x.col_last_name+`</option>
            `);
          })
        })
      }
    })

    // =============================== FILTER BY LINE =================================
    $('#filter_line').change(function(){
      var line = $(this).val();
      if(line){
        // change employee dropdown
        $('#employee_id').html('');
        get_employee_data_filter_by_line(url_filter_by_line, line).then(function(data){
          $('#employee_id').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#employee_id').append(`
              <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+' '+x.col_last_name+`</option>
            `);
          })
        })
      } else {
        $('#employee_id').html('');
        get_all_employee_data(url_get_all_empl_data).then(function(data){
          $('#employee_id').append(`
            <option value="" disabled>Choose Employee...</option>
          `);
          Array.from(data).forEach(function(x){
            $('#employee_id').append(`
            <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+' '+x.col_last_name+`</option>
            `);
          })
        })
      }
    })

    // ========================================== CLEAR FILTER ===============================================
    $('#clear_filter').click(function(){
      $('#filter_section').val('');
      $('#filter_department').val('');
      $('#filter_group').val('');
      $('#filter_line').val('');

      $('#employee_id').html('');
      get_all_employee_data(url_get_all_empl_data).then(function(data){
        $('#employee_id').append(`
          <option value="" disabled>Choose Employee...</option>
        `);
        Array.from(data).forEach(function(x){
          $('#employee_id').append(`
            <option value="`+x.id+`">`+x.col_empl_cmid+` - `+x.col_frst_name+` `+x.col_last_name+`</option>
          `);
        })
      })
    })




    $('#btn_copy_shift').click(function(e){
      e.preventDefault();
      var widget_length = $('.widget').length;
      if(widget_length > 0){
        Swal.fire({
          title: 'Do you want to apply this shift to other employees?',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed){
            $('#form_copy_shift').submit();
          }
        })
      } else {
        Swal.fire(
          'No employees selected',
          'Please select employees where the copied shift will be applied',
          'warning'
        )
      }
    })
































    async function get_employee_section_data_filter_by_dept(url, department){
      var formData = new FormData();
      formData.append('department', department);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_employee_data_filter_by_sect(url, section){
      var formData = new FormData();
      formData.append('section', section);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_employee_data_filter_by_dept(url, department){
      var formData = new FormData();
      formData.append('department', department);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_employee_data_filter_by_group(url, group){
      var formData = new FormData();
      formData.append('group', group);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_employee_data_filter_by_line(url, line){
      var formData = new FormData();
      formData.append('line', line);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_all_employee_data(url){
      var formData = new FormData();
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }



    async function get_work_shift_data(url,template_id) {
      var formData = new FormData();
      formData.append('template_id', template_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_cutoff_schedule_data(url,date) {
      var formData = new FormData();
      formData.append('cutoff_date_period', date);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }
    
    async function get_employee_data(url,employee_id,date_period) {
      var formData = new FormData();
      formData.append('employee_id', employee_id);
      formData.append('date_period', date_period);
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
    
    async function get_holiday_data(url) {
      var formData = new FormData();
      formData.append('shift_id', 'shift');
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function updt_shift_async(url, shift_id, attendance_id){
      var formData = new FormData();
      formData.append('shift_id', shift_id);
      formData.append('attendance_id', attendance_id);
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
