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
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
  input[type=number] {
    -moz-appearance: textfield;
  }
</style>
<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Color Picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<!-- Include Editor style. -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<div class="content-wrapper">
  <div class="p-3">
    <div class="flex-fill">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?=base_url()?>settings">Settings
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Work Shifts
          </li>
        </ol>
      </nav>
      <div class="row pr-3 mb-2">
        <div class="col">
          <h1 class="page-title">Work Shifts
          </h1>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col">
          <form class="new_q" id="new_q" action="#" accept-charset="UTF-8" method="get">
            <div class="form-row align-items-center">
              <div class="col mb-1">
                <input autofocus="autofocus" class="form-control" placeholder="Search..." type="search" name="work_pattern_search" id="work_pattern_search">
              </div>
            </div>
          </form> 
        </div>
        <div class="col ml-auto">
          <a class="btn btn-primary float-right" title="Add" href="#" data-toggle="modal" data-target="#modal_add_work_shift">
            <i class="fas fa-fw fa-plus">
            </i> Add
          </a>
        </div>
      </div>
      <div class="card">
        <table class="table table-hover table-xs">
          <thead>
            <tr>
              <th>Shift Code
              </th>
              <th>Shift Name
              </th>
              <th>Shift Time In
              </th>
              <th>Shift Time Out
              </th>
              <th>Shift Time Out with OT
              </th>
              <th>Next Day
              </th>
              <th class="text-center">Color
              </th>
              <th>Has Break
              </th>
              <th>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
if($DISP_WRK_SHFT_INFO){
foreach($DISP_WRK_SHFT_INFO as $ROW_WRK_SHFT_INFO){ ?>
            <tr>
              <td>
                <?=$ROW_WRK_SHFT_INFO->code?>
              </td>
              <td>
                <?=$ROW_WRK_SHFT_INFO->name?>
              </td>
              <td>
                <?=$ROW_WRK_SHFT_INFO->time_in?>
              </td>
              <td>
                <?=$ROW_WRK_SHFT_INFO->time_out?>
              </td>
              <td>
                <?=$ROW_WRK_SHFT_INFO->time_out_ot?>
              </td>
              <td>
                <?php if($ROW_WRK_SHFT_INFO->next_day == 'true'){echo 'Yes';} else {echo 'No';} ?>
              </td>
              <td>
                <center>
                  <p style="width: 50px; height 50px; background-color: <?= $ROW_WRK_SHFT_INFO->color?>;">&nbsp;</p>
                </center>
              </td>
              <td>
                <?php if($ROW_WRK_SHFT_INFO->has_break == 'true'){echo 'Yes';} else {echo 'No';} ?>
              </td>
              <td class="">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                  <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                    <a class="btn btn-sm indigo lighten-2" work_shift_id="<?=$ROW_WRK_SHFT_INFO->id?>" title="Edit" data-toggle="modal" data-target="#modal_edit_work_shift" >
                      <i class="fas fa-edit">
                      </i>
                    </a>
                    <a class="btn btn-sm indigo lighten-2 text-danger WRK_SHFT_BTN_DLT" delete_key="<?=$ROW_WRK_SHFT_INFO->id?>">
                      <i class="fas fa-trash">
                      </i>
                    </a>
                  </div>
                </div>
              </td>
            </tr>
            <?php
}
} else { ?>
            <tr>
              <td colspan='3'>No Data Yet
              </td>
            </tr>
            <?php
}
?>
          </tbody>
        </table>
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
<!-- Add position -->
<div class="modal fade" id="modal_add_work_shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Add Work Shifts
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('settings/insrt_work_shift'); ?>" id="WRK_SHFT_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="WRK_SHFT_INPF_NAME">Shift Code
                </label>
                <input class="form-control form-control " type="text" name="WRK_SHFT_INPF_CODE" id="WRK_SHFT_INPF_CODE" required>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label class="required " for="WRK_SHFT_INPF_NAME">Shift Name
                    </label>
                    <input class="form-control form-control " type="text" name="WRK_SHFT_INPF_NAME" id="WRK_SHFT_INPF_NAME" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label class="mb-1 mt-2" for="WRK_SHFT_INPF_TIME_OUT">Color
                    </label>
                    <div class="input-group my-colorpicker2">
                      <input type="text" name="shift_color" id="shift_color" class="form-control">
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-square" style="font-size: 20px;"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label class="required " for="WRK_SHFT_INPF_WORKING_HOURS">No. of Working Hours
                    </label>
                    <input class="form-control form-control " type="text" name="WRK_SHFT_INPF_WORKING_HOURS" id="WRK_SHFT_INPF_WORKING_HOURS">
                  </div>
                </div>
              </div> -->
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label class="required " for="WRK_SHFT_INPF_TIME_IN">Shift Time In
                    </label>
                    <div class="input-group date" id="timepicker" data-target-input="nearest" style="width: 100% !important;">
                      <input type="text" class="form-control datetimepicker-input time_text mr-0" name="WRK_SHFT_INPF_TIME_IN" data-target="#timepicker" id="time_text" placeholder="hr:min" required>
                      <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label class="required " for="WRK_SHFT_INPF_TIME_OUT">Shift Time Out
                    </label>
                    <div class="input-group date" id="timepicker2" data-target-input="nearest" style="width: 100% !important;">
                      <input type="text" class="form-control datetimepicker-input time_text mr-0" name="WRK_SHFT_INPF_TIME_OUT" data-target="#timepicker2" id="time_text2" placeholder="hr:min" required>
                      <div class="input-group-append" data-target="#timepicker2" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="" for="WRK_SHFT_INPF_TIME_OUT">Shift Time Out with OT
                    </label>
                    <div class="input-group date" id="timepicker7" data-target-input="nearest" style="width: 100% !important;">
                      <input type="text" class="form-control datetimepicker-input time_text mr-0" name="WRK_SHFT_INPF_TIME_OUT_W_OT" data-target="#timepicker7" id="time_text7" placeholder="hr:min">
                      <div class="input-group-append" data-target="#timepicker7" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="d-flex">
                    <div class="icheck-primary mb-0 mr-3" style="font-size: 14px; display: block;">
                        <input type="checkbox" id="break_time" value="true" name="has_break_time">
                        <label class="mb-2" for="break_time">
                            1 Hour Break-time
                        </label>
                    </div>
                    <div class="icheck-primary d-inline float-left">
                      <input type="checkbox" id="auto-generate" value="true" name="has_next_day"> 
                      <label class="mb-2" for="auto-generate">
                          Next Day
                      </label>
                    </div>
                  </div>
                </div>
              </div>


              <hr>

              <div class="mb-4" style="margin-left: -4px;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Auto Overtime and Night Differential Inclusion</h4>
              </div>
              

              <div class="row">
                <div class="col-6">
                  <!-- <div class="form-group mb-0">
                    <label class="required " for="WRK_SHFT_INPF_NAME">Day Shift
                    </label>
                    <div class="d-flex">
                      <div class="flex-fill">
                        <input class="form-control form-control " type="number" value="0" name="day_shift" id="day_shift" step="0.01" required>
                      </div>
                      <div class="ml-2 mb-2 pt-2" style="width: 80px">
                        Day/s
                      </div>
                    </div>
                  </div> -->
                  <div class="form-group mb-0">
                    <label class="required " for="WRK_SHFT_INPF_NAME">Night Differential
                    </label>
                    <div class="d-flex">
                      <div class="flex-fill">
                        <input class="form-control form-control " type="number" value="0" name="night_shift" id="night_shift" step="0.01" required>
                      </div>
                      <div class="ml-2 mb-2 pt-2" style="width: 80px;">
                        Hour/s
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-0">
                    <label class="required " for="WRK_SHFT_INPF_NAME">Working Hours
                    </label>
                    <div class="d-flex">
                      <div class="flex-fill">
                        <input class="form-control form-control " type="number" value="0" name="work_hours" id="work_hours" step="0.01" required>
                      </div>
                      <div class="ml-2 mb-2 pt-2" style="width: 80px;">
                        Hour/s
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row pt-0 mt-0">
                <div class="col-6">
                </div>
                <div class="col-6">
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-6">
                  <div class="form-group mb-0">
                    <label class="required " for="WRK_SHFT_INPF_NAME">Regular Overtime
                    </label>
                    <div class="d-flex">
                      <div class="flex-fill">
                        <input class="form-control form-control " type="number" value="0" name="day_shift_OT" id="day_shift_OT" step="0.01" required>
                      </div>
                      <div class="ml-2 mb-2 pt-2" style="width: 80px">
                        Hour/s
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-0">
                    <label class="required " for="WRK_SHFT_INPF_NAME">Night Shift Overtime
                    </label>
                    <div class="d-flex">
                      <div class="flex-fill">
                        <input class="form-control form-control " type="number" value="0" name="night_shift_OT" id="night_shift_OT" step="0.01" required>
                      </div>
                      <div class="ml-2 mb-2 pt-2" style="width: 80px;">
                        Hour/s
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class='btn btn-primary text-light' id="WRK_SHFT_BTN_SAVE">&nbsp; Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit position -->
<div class="modal fade" id="modal_edit_work_shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Work Shifts
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('settings/updt_work_shift'); ?>" id="WRK_SHFT_FORM_UPDT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="WRK_SHFT_INPF_NAME">Shift Code
                </label>
                <input class="form-control form-control " type="text" name="UPDT_WRK_SHFT_INPF_CODE" id="UPDT_WRK_SHFT_INPF_CODE" required>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label class="required " for="WRK_SHFT_INPF_NAME">Shift Name
                    </label>
                    <input class="form-control form-control " type="text" name="UPDT_WRK_SHFT_INPF_NAME" id="UPDT_WRK_SHFT_INPF_NAME" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label class="mb-1 mt-2" for="UPDT_WRK_SHFT_INPF_TIME_OUT">Color
                    </label>
                    <div class="input-group updt-my-colorpicker2">
                      <input type="text" name="updt_shift_color" id="updt_shift_color" class="form-control">
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-square" style="font-size: 20px;"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label class="required " for="WRK_SHFT_INPF_TIME_IN">Shift Time In
                    </label>
                    <div class="input-group date" id="updt_timepicker" data-target-input="nearest" style="width: 100% !important;">
                      <input type="text" class="form-control datetimepicker-input time_text mr-0" name="UPDT_WRK_SHFT_INPF_TIME_IN" data-target="#updt_timepicker" id="updt_time_text" placeholder="hr:min" required>
                      <div class="input-group-append" data-target="#updt_timepicker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label class="required " for="WRK_SHFT_INPF_TIME_OUT">Shift Time Out
                    </label>
                    <div class="input-group date" id="updt_timepicker2" data-target-input="nearest" style="width: 100% !important;">
                      <input type="text" class="form-control datetimepicker-input time_text mr-0" name="UPDT_WRK_SHFT_INPF_TIME_OUT" data-target="#updt_timepicker2" id="updt_time_text2" placeholder="hr:min" required>
                      <div class="input-group-append" data-target="#updt_timepicker2" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="" for="WRK_SHFT_INPF_TIME_OUT">Shift Time Out with OT
                    </label>
                    <div class="input-group date" id="updt_timepicker7" data-target-input="nearest" style="width: 100% !important;">
                      <input type="text" class="form-control datetimepicker-input time_text mr-0" name="UPDT_WRK_SHFT_INPF_TIME_OUT_W_OT" data-target="#updt_timepicker7" id="updt_time_text7" placeholder="hr:min">
                      <div class="input-group-append" data-target="#updt_timepicker7" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="d-flex">
                    <div class="icheck-primary mb-0 mr-3" style="font-size: 14px; display: block;">
                        <input type="checkbox" id="updt_break_time" value="true" name="updt_has_break_time">
                        <label class="mb-2" for="updt_break_time">
                            1 Hour Break-time
                        </label>
                    </div>
                    <div class="icheck-primary mb-0 mr-3"  style="font-size: 14px; display: block;">
                      <input type="checkbox" id="updt_next_day" value="true" name="updt_has_next_day"> 
                      <label class="mb-2" for="updt_next_day">
                          Next Day
                      </label>
                    </div>
                  </div>
                </div>
              </div>


              <hr>

              <div class="mb-4" style="margin-left: -4px;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Auto Overtime and Night Differential Inclusion</h4>
              </div>


              <div class="row">
                <div class="col-6">
                  <!-- <div class="form-group mb-0">
                    <label class="required " for="WRK_SHFT_INPF_NAME">Day Shift
                    </label>
                    <div class="d-flex">
                      <div class="flex-fill">
                        <input class="form-control form-control " type="number" value="0" name="updt_day_shift" id="updt_day_shift" step="0.01" required>
                      </div>
                      <div class="ml-2 mb-2 pt-2" style="width: 80px">
                        Day/s
                      </div>
                    </div>
                  </div> -->
                  <div class="form-group mb-0">
                    <label class="required " for="WRK_SHFT_INPF_NAME">Night Differential
                    </label>
                    <div class="d-flex">
                      <div class="flex-fill">
                        <input class="form-control form-control " type="number" name="updt_night_shift" id="updt_night_shift" step="0.01" required>
                      </div>
                      <div class="ml-2 mb-2 pt-2" style="width: 80px;">
                        Hour/s
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-0">
                    <label class="required " for="WRK_SHFT_INPF_NAME">Working Hours
                    </label>
                    <div class="d-flex">
                      <div class="flex-fill">
                        <input class="form-control form-control " type="number" name="updt_work_hours" id="updt_work_hours" step="0.01" required>
                      </div>
                      <div class="ml-2 mb-2 pt-2" style="width: 80px;">
                        Hour/s
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row pt-0 mt-0">
                <div class="col-6">
                </div>
                <div class="col-6">
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-6">
                  <div class="form-group mb-0">
                    <label class="required " for="WRK_SHFT_INPF_NAME">Regular Overtime
                    </label>
                    <div class="d-flex">
                      <div class="flex-fill">
                        <input class="form-control form-control " type="number" value="0" name="updt_day_shift_OT" id="updt_day_shift_OT" step="0.01" required>
                      </div>
                      <div class="ml-2 mb-2 pt-2" style="width: 80px">
                        Hour/s
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-0">
                    <label class="required " for="WRK_SHFT_INPF_NAME">Night Shift Overtime
                    </label>
                    <div class="d-flex">
                      <div class="flex-fill">
                        <input class="form-control form-control " type="number" value="0" name="updt_night_shift_OT" id="updt_night_shift_OT" step="0.01" required>
                      </div>
                      <div class="ml-2 mb-2 pt-2" style="width: 80px;">
                        Hour/s
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="UPDT_WRK_SHFT_INPF_ID" name="UPDT_WRK_SHFT_INPF_ID">
          <button class='btn btn-primary text-light' id="UPDT_WRK_SHFT_BTN_SAVE">&nbsp; Save
          </button>
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
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js">
</script>
<!-- InputMask (Required for Timepicker)-->
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url(); ?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/js/froala_editor.pkgd.min.js">
</script>
<!-- Initialize the editor. -->
<script>
  $(function() {
    $('div#froala-editor').froalaEditor({
      // Set custom buttons with separator between them.
      toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting','html'],
      toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic','html']
    }
                                       )
    $('i.fa.fa-rotate-left').attr('class')
  }
   );
</script>
<!-- SESSION MESSAGES -->
<?php
if($this->session->userdata('SESS_SUCC_MSG_INSRT_WRK_SHFT')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_WRK_SHFT'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_INSRT_WRK_SHFT');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_UPDT_WRK_SHFT')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_WRK_SHFT'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_UPDT_WRK_SHFT');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_DLT_WRK_SHFT')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_WRK_SHFT'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_DLT_WRK_SHFT');
}
?>
<script>
  $(document).ready(function(){
    // Color picker init (add modal)
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    //Timepicker
    $('#timepicker').datetimepicker({
      stepping: 30,
      format: 'LT'
    })
    
    $('#timepicker2').datetimepicker({
      stepping: 30,
      format: 'LT'
    })

    $('#timepicker7').datetimepicker({
      stepping: 30,
      format: 'LT'
    })
    
    // Color picker init (update modal)
    //color picker with addon
    $('.updt-my-colorpicker2').colorpicker()

    $('.updt-my-colorpicker2').on('colorpickerChange', function(event) {
      $('.updt-my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    //Timepicker
    $('#updt_timepicker').datetimepicker({
      stepping: 30,
      format: 'LT'
    })
    
    $('#updt_timepicker2').datetimepicker({
      stepping: 30,
      format: 'LT'
    })

    $('#updt_timepicker7').datetimepicker({
      stepping: 30,
      format: 'LT'
    })



    // Get & Display Data to Edit Modal Using Async JS function
    var url = '<?php echo base_url(); ?>settings/getwrk_shftData';
    const openModalButton = document.querySelectorAll('[data-target]');
    openModalButton.forEach(button => {
      button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        getwrk_shftData(url,button.getAttribute('work_shift_id')).then(data => {
          if(data.length > 0)
          {
            data.forEach((x) => {
              document.getElementById('UPDT_WRK_SHFT_INPF_ID').value = x.id;
              document.getElementById('UPDT_WRK_SHFT_INPF_CODE').value = x.code;
              document.getElementById('UPDT_WRK_SHFT_INPF_NAME').value = x.name;
              document.getElementById('updt_time_text').value = x.time_in;
              document.getElementById('updt_time_text2').value = x.time_out;
              document.getElementById('updt_time_text7').value = x.time_out_ot;
              if(x.next_day == 'true'){
                $('#updt_next_day').prop('checked',true);
              } else {
                $('#updt_next_day').prop('checked',false);
              }
              if(x.has_break == 'true'){
                $('#updt_break_time').prop('checked',true);
              } else {
                $('#updt_break_time').prop('checked',false);
              }
              // document.getElementById('updt_next_day').value = x.next_day;
              // document.getElementById('updt_break_time').value = x.has_break;
              document.getElementById('updt_shift_color').value = x.color;
              
              document.getElementById('updt_night_shift').value = x.night_shift;
              document.getElementById('updt_day_shift_OT').value = x.day_shift_OT;
              document.getElementById('updt_night_shift_OT').value = x.night_shift_OT;
              document.getElementById('updt_work_hours').value = x.work_hours;
            });
          }
        });
      });
    });
    async function getwrk_shftData(url,work_shift_id) {
      var formData = new FormData();
      formData.append('WRK_SHFT_GET_WRK_SHFT_DATA', work_shift_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    // Update Position
    $('#WRK_SHFT_BTN_UPDT').click(function(){
      var work_shift_name = $('#UPDT_WRK_SHFT_INPF_NAME').val();
      var hasErr = 0;
      if(!work_shift_name){
        hasErr++;
      }
      if(hasErr == 0){
        Swal.fire({
          title: 'Do you want to save the following changes?',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
            $('#WRK_SHFT_FORM_EDIT').submit();
          }
        })
      }
      else {
        $('#UPDT_WRK_SHFT_INPF_NAME').addClass('is-invalid');
      }
    })
    $('#UPDT_WRK_SHFT_INPF_NAME').keyup(function(){
      $('#UPDT_WRK_SHFT_INPF_NAME').removeClass('is-invalid');
    })


    // Delete Position
    $('.WRK_SHFT_BTN_DLT').click(function(e){
      e.preventDefault();
      var user_deleteKey = $(this).attr('delete_key');
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url(); ?>settings/dlt_work_shift?delete_id="+user_deleteKey;
        }
      })
    })
  })
</script>
</body>
</html>
​