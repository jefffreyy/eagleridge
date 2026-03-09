<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<?php
$id_code = "SHF";
$search_data = $this->input->get('all');
$search_data = str_replace("_", " ", $search_data);

$current_page = $PAGE;
$next_page = $PAGE + 1;
$prev_page = $PAGE - 1;
$last_page = $PAGES_COUNT;
$row = $ROW;
if ($C_DATA_COUNT == 0) {
  $low_limit = 0;
} else {
  $low_limit = $row * ($current_page - 1) + 1;
}
if ($current_page * $row > $C_DATA_COUNT) {
  $high_limit = $C_DATA_COUNT;
} else {
  $high_limit = $row * ($current_page);
}
?>
<style>
    .checkbox-lg .form-check-input{
     top: .8rem;
     scale: 1.4;
     margin-right: 0.7rem;
     }
    
    .checkbox-lg .form-check-label {
     padding-top: 13px;
     }
    
    .checkbox-xl .form-check-input {
     top: 1.2rem;
     scale: 1.7;
     margin-right: 0.8rem;
     }
    
    .checkbox-xl .form-check-label {
     padding-top: 19px;
     }
</style>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title">&nbsp;Work&nbsp;Shifts<h1>
            </div>
            <div class="col-md-6 button-title">
                <a href="#" class="btn technos-button-green shadow-none mr-2" id="btn_export"><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>
                <a class="btn technos-button-green shadow-none rounded" title="Add" href="#" data-toggle="modal" data-target="#modal_add_work_shift" id="add"><i class="fas fa-fw fa-plus"></i>Add Work Shift</a>
                <!-- <a href="" id="btn_new" class=" btn technos-button-green shadow-none rounded"><i class="fas fa-plus"></i>&nbsp;Add New Loan</a> -->
                <!--<a href="" id="bulk_import" class=" btn technos-button-green shadow-none rounded" ><i class="fas fa-file-import"></i>&nbsp;Bulk Import</a>-->
                <!--<a id="btn_export" class=" btn technos-button-gray shadow-none rounded" ><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>-->
            </div>

        </div>

        <div class="card border-0 p-0 m-0">
            <div class="card border-0 p-1 m-0">
                <div class="card-header p-0">
                    <div class="row">
                        <div class="col-xl-8">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                            <a class="nav-link head-tab  <?= $TAB == 'Active' ? 'active' : '' ?> " href="?page=1&row=<?= $row ?>&tab=Active" id="tab-Active" style='cursor:pointer'>
                                Active
                                <span class="ml-2 badge badge-pill badge-secondary">  <?= $ACTIVES ?> </span>
                            </a>
                            </li>
                            <li class="nav-item">
                            <a href="?page=1&row=<?= $row ?>&tab=Inactive" class="nav-link head-tab <?= $TAB == 'Inactive' ? 'active' : '' ?>" id="tab-Inactive" style='cursor:pointer'>
                                Inactive
                                <span class="ml-2 badge badge-pill badge-secondary"> <?= $INACTIVES ?> </span>
                            </a>
                            </li>

                        </ul>
                        </div>
                        <div class="col-xl-4">
                        <div class="input-group pb-1">
                            <?php 
                                if($search_data){ ?>
                                <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
                            <?php } else{?>
                                <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                            <?php } ?>
                            <input type="text" class="form-control" placeholder="Search..." value="<?= ($search_data) ? $search_data : ""?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        </div>
                    </div>
                </div>
                <div class="p-2">
                    <div>
                        <button class="btn technos-button-gray shadow-none rounded bulk-button" data-toggle="modal" data-target="#modal_mark_active" id="bulk_mark_active"><i class="far fa-check-circle"></i>&nbsp;Mark as Active</button>
                        <button class="btn technos-button-gray shadow-none rounded bulk-button" data-toggle="modal" data-target="#modal_mark_inactive" id="bulk_mark_inactive"><i class="far fa-times-circle"></i>&nbsp;Mark as Inactive</button>
                        
                        <div class="float-right ">
                            <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                            <ul class="d-inline pagination m-0 p-0 ">
                                <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                                    < </a>
                                </li>
                                <li><a href="?page=1&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                                <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                                <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                                <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                                <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                                <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                                <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?= $TAB ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                                <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&tab=$TAB'"; ?>>> </a></li>
                            </ul>
                            <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                            <select id="row_dropdown" class="custom-select" style="width: auto;">
                                <?php
                                    foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) {?>
                                        <option value=<?= $C_ROW_DISPLAY_ROW?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW?> </option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
    
                <div class="table-responsive border-danger">
                    <table class="table table-hover table-bordered mb-0" id="TableToExport">
                        <thead class="text-uppercase">
                            <!-- Table Headers -->
                            <th class="text-center"><input type="checkbox" name="check_all" id="check_all"></th>
                            <th>Shift ID</th>
                            <th>Shift&nbsp;Code</th>
                            <th>Shift&nbsp;Name</th>
                            <th>Shift&nbsp;Time&nbsp;In&nbsp;</th>
                            <th>Shift&nbsp;Time&nbsp;Out&nbsp;</th>
                            <!-- <th <?= ($DISP_INOUT_TYPE == '1')? 'hidden': '' ?>>Shift&nbsp;Time&nbsp;In&nbsp;2</th>
                            <th <?= ($DISP_INOUT_TYPE == '1')? 'hidden': '' ?>>Shift&nbsp;Time&nbsp;Out&nbsp;2</th> -->
                            <!--<th>Next&nbsp;Day</th>-->
                            <th class="text-center">Color</th>
                            <!--<th>Lunch&nbsp;Break&nbsp;Start</th>-->
                            <!--<th>Lunch&nbsp;Break&nbsp;End</th>-->
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </thead>
                        <tbody>
                            <?php
                            if ($DISP_WRK_SHFT_INFO) {
                                foreach ($DISP_WRK_SHFT_INFO as $ROW_WRK_SHFT_INFO) {
                                    $application_id = $id_code . str_pad($ROW_WRK_SHFT_INFO->id, 5, '0', STR_PAD_LEFT);
                            ?>
                                    <tr>
                                        <td class="text-center" id="select_item">
                                            <input type="checkbox" name="approval_name" class="check_single" row_id="<?= $ROW_WRK_SHFT_INFO->id ?>"  value="<?= $ROW_WRK_SHFT_INFO->id ?>" <?php echo ($ROW_WRK_SHFT_INFO->code == "REST" ? 'hidden' : '') ?>>
                                        </td>
                                        <td>
                                            <?= $application_id ?>
                                        </td>
                                        <td>
                                            <?= $ROW_WRK_SHFT_INFO->code ?>
                                        </td>
                                        <td>
                                            <?= $ROW_WRK_SHFT_INFO->name ?>
                                        </td>
                                        <td>
                                            <?php echo ($ROW_WRK_SHFT_INFO->time_in == "00:00:00" ? '-' : $ROW_WRK_SHFT_INFO->time_in) ?>
                                        </td>
                                        <td>
                                            <?php echo ($ROW_WRK_SHFT_INFO->time_in == "00:00:00" ? '-' :  $ROW_WRK_SHFT_INFO->time_out) ?>
                                        </td>
                                        <!-- <td <?= ($DISP_INOUT_TYPE == '1')? 'hidden': 'hidden' ?>>
                                            <?php echo ($ROW_WRK_SHFT_INFO->fixed ? '' :  $ROW_WRK_SHFT_INFO->time_in_2) ?>
                                        </td>
                                        <td <?= ($DISP_INOUT_TYPE == '1')? 'hidden': 'hidden' ?>>
                                            <?php echo ($ROW_WRK_SHFT_INFO->fixed ? '' :  $ROW_WRK_SHFT_INFO->time_out_2) ?>
                                        </td>
                                         -->
                                        <td>
                                            <?php if (!$ROW_WRK_SHFT_INFO->fixed) { ?>
                                                <center>
                                                    <p style="width: 50px; height 50px; background-color: <?= $ROW_WRK_SHFT_INFO->color ?>;">
                                                        &nbsp;</p>
                                                </center>
                                            <?php  } ?>
                                        </td>
                                        <td><?=$ROW_WRK_SHFT_INFO->status?></td>
                                        <td class="text-center" >
                                            <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group" <?php echo ($ROW_WRK_SHFT_INFO->code == "REST" ? 'hidden' : '') ?>>
                                                <a class="btn btn-sm indigo lighten-2 edit_workshift" href="<?= base_url() ?>attendances/edit_work_shift/<?= $ROW_WRK_SHFT_INFO->id ?>" work_shift_id="<?= $ROW_WRK_SHFT_INFO->id ?>" title="Edit" data-toggle="modal" data-target="#modal_edit_work_shift">
                                                    <i class="fas fa-edit" id="edit">
                                                    </i>
                                                </a>
                                                <!-- <a class="btn btn-sm indigo lighten-2 text-danger WRK_SHFT_BTN_DLT" delete_key="<?= $ROW_WRK_SHFT_INFO->id ?>">
                                                    <i class="fas fa-trash" id="trash">
                                                    </i>
                                                </a> -->
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else { ?>

                                <!-- Message if no entries -->
                                <tr class="table-active">
                                    <td colspan="9">
                                        <center>No Data Yet</center>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div><!-- table responsive end -->

            </div> <!-- card end -->
        </div> <!-- card end -->
    </div>
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
            <form action="<?php echo base_url('attendances/insrt_work_shift'); ?>" id="WRK_SHFT_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required" for="WRK_SHFT_INPF_NAME">Shift Code</label>
                                <input required class="form-control form-control "  type="text" name="code" id="wrk_shft_inpf_code">
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="required" for="WRK_SHFT_INPF_NAME">Shift Name
                                        </label>
                                        <input required  class="form-control form-control " type="text" name="name" id="wrk_shft_inpf_name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="mb-1 mt-2" for="">Color</label>
                                        <div class="input-group ">
                                            <input type="text" name="color" style="z-index:1" id="shift_color" class="form-control shift_color colorpicker">
                                            <div class="input-group-append" data-target="#shift_color" data-toggle="colorpicker">
                                                <span class="input-group-text"><i class="fas fa-square color_data" style="font-size: 20px"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-2">
                            <section>
                                <div class="form-check checkbox-lg mb-3">
                                  <input class="form-check-input enable_checkbox" type="checkbox"name="time_regular_enable" value="1" >
                                  <label class="form-check-label text-bold" for="defaultCheck1">
                                    Regular
                                  </label>
                                </div>
                                <div class="row" style="display:none">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="required" for="WRK_SHFT_INPF_TIME_IN">Shift Time In</label>
                                            <div class="input-group date time_picker" id="timepicker_regular_start" data-target-input="nearest" style="width: 100% !important;">
                                                <input type="text" required class="timer_in form-control datetimepicker-input time_text mr-0" name="time_regular_start" placeholder="hr:min" id="time_regular_start_add">
                                                <div class="input-group-append" data-target="#timepicker_regular_start" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6" >
                                        <div class="form-group">
                                            <label class="required" for="WRK_SHFT_INPF_TIME_OUT">Shift Time Out</label>
                                            <div class="input-group date time_picker" id="timepicker2" data-target-input="nearest" style="width: 100% !important;">
                                                <input type="text" required class="timer_out form-control datetimepicker-input time_text mr-0" name="time_regular_end" data-target=".time_picker_out1" id="time_regular_end_add" placeholder="hr:min">
                                                <div class="input-group-append" data-target="#timepicker2" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="display:none">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class=" " for="WRK_SHFT_INPF_TIME_IN">Regular Work Hours</label>
                                            <div class="input-group" style="width: 100% !important;">
                                                <input type="text"  value='0' class="reg_hours_dif hours_dif form-control bg-light" name="time_regular_reg" id= "time_regular_reg" >
                                                <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class=" " for="WRK_SHFT_INPF_TIME_IN">Night Differential</label>
                                            <div class="input-group" style="width: 100% !important;">
                                                <input type="text"  value='0' class="form-control bg-light" name="time_regular_nd" id= "time_regular_nd">
                                                <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           </section>
                            <div class="row" <?= ($DISP_INOUT_TYPE == '1')? 'hidden': '' ?>>
                                <div class="col-6">
                                    <!--<div class="form-group">-->
                                    <!--    <label class=" " for="break_start">Break Start</label>-->
                                    <!--    <div class="input-group date time_picker" id="timepicker_in_2" data-target-input="nearest" style="width: 100% !important;">-->
                                    <!--        <input type="text" class=" form-control datetimepicker-input time_text mr-0" name="break_start" data-target=".time_picker_in2" placeholder="hr:min" id="time_text_in2">-->
                                    <!--        <div class="input-group-append" data-target="#timepicker_in_2" data-toggle="datetimepicker">-->
                                    <!--            <div class="input-group-text"><i class="far fa-clock"></i></div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>

                                <div class="col-6">
                                    <!--<div class="form-group">-->
                                    <!--    <label class="" for="WRK_SHFT_INPF_TIME_OUT_2">Shift Time Out 2</label>-->
                                    <!--    <div class="input-group date time_picker" id="timepicker_out_2" data-target-input="nearest" style="width: 100% !important;">-->
                                    <!--        <input type="text" class=" form-control datetimepicker-input time_text mr-0" name="WRK_SHFT_INPF_TIME_OUT_2" data-target=".time_picker_out2" id="time_text_out2" placeholder="hr:min">-->
                                    <!--        <div class="input-group-append" data-target="#timepicker_out_2" data-toggle="datetimepicker">-->
                                    <!--            <div class="input-group-text"><i class="far fa-clock"></i></div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>
                            </div>
                             <hr class="my-2">
                            <section>
                                <div class="form-check checkbox-lg mb-3">
                                  <input class="form-check-input enable_checkbox" name="time_break_enable" type="checkbox" value="1" id="defaultCheck1">
                                  <label class="form-check-label text-bold" for="defaultCheck1">
                                    Shift Break
                                  </label>
                                </div>
                                <div class="row" style="display:none">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class=" " for="WRK_SHFT_INPF_LUNCH_BREAK_START"> Break Start</label>
                                            <div class="input-group date time_picker" id="timepicker_lunch_break_start" data-target-input="nearest" style="width: 100% !important;">
                                                <input type="text" class="break_time_in form-control datetimepicker-input time_text mr-0" name="time_break_start" data-target=".lunch_break_start" placeholder="hr:min" id="lunch_break_start_text">
                                                <div class="input-group-append" data-target="#timepicker_lunch_break_start" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="" for="WRK_SHFT_INPF_LUNCH_BREAK_END">Break End</label>
                                            <div class="input-group date time_picker" id="timepicker_lunch_break_end" data-target-input="nearest" style="width: 100% !important;">
                                                <input type="text" class="break_time_out form-control datetimepicker-input time_text mr-0" name="time_break_end" data-target=".lunch_break_end" id="lunch_break_end_text" placeholder="hr:min">
                                                <div class="input-group-append" data-target="#timepicker_lunch_break_end" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="display:none">
                                    <div class=" col-6">
                                        <div class="form-check checkbox-lg">
                                          <input class="form-check-input exclude_breaktime_checkbox" name="time_break_isexcluded" id="exclude_breaktime_checkbox" type="checkbox" value="" />
                                          <label class="form-check-label text-bold" for="checkbox-2">Excluded to Regular Work Hours</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="exclude_breaktime" style="display:none">
                                            <label class=" " for="WRK_SHFT_INPF_TIME_IN">Break Time</label>
                                            <div class="input-group" style="width: 100% !important;">
                                                <input type="text" name="time_break_hours" value='0' class="break_time_hours form-control bg-light" id = "break_time_hours" >
                                                <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <hr class="my-2">
                            <section>
                                <div class="form-check checkbox-lg mb-3">
                                  <input class="form-check-input enable_checkbox" name="time_overtime_enable" type="checkbox" value="1"  id="defaultCheck1">
                                  <label class="form-check-label text-bold" for="defaultCheck1">
                                    Shift Overtime
                                  </label>
                                </div>
                                <div class="row" style="display:none">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="" for="WRK_SHFT_INPF_TIME_IN">Overtime Start</label>
                                            <div class="input-group date time_picker" id="timepicker" data-target-input="nearest" style="width: 100% !important;">
                                                <input type="text" class="overtime_time_in form-control datetimepicker-input time_text mr-0" name="time_overtime_start" data-target=".time_picker_in1" placeholder="hr:min" id="overtime_start_text">
                                                <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="col-6" >
                                        <div class="form-group">
                                            <label class="" for="WRK_SHFT_INPF_TIME_OUT">Overtime End</label>
                                            <div class="input-group date time_picker" id="time_overtime_end" data-target-input="nearest" style="width: 100% !important;">
                                                <input type="text" class="overtime_time_out form-control datetimepicker-input time_text mr-0" name="time_overtime_end" data-target=".time_picker_out1" id="overtime_end_text" placeholder="hr:min">
                                                <div class="input-group-append" data-target="#time_overtime_end" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row" style="display:none">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class=" " for="WRK_SHFT_INPF_TIME_IN">Regular Overtime</label>
                                            <div class="input-group" style="width: 100% !important;">
                                                <input type="text" name="time_overtime_ot" value='0' class="hours_dif form-control bg-light"  id = "overtime_time_ot">
                                                <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class=" " for="WRK_SHFT_INPF_TIME_IN">OT with Night Differential</label>
                                            <div class="input-group" style="width: 100% !important;">
                                                <input type="text" name="time_overtime_nd" value='0' class="form-control bg-light " id = "overtime_time_ndot">
                                                <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                    

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
            <form action="<?php echo base_url('attendances/updt_work_shift'); ?>" id="WRK_SHFT_FORM_UPDT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="" for="WRK_SHFT_INPF_NAME">Shift Code</label>
                                <input class="form-control form-control " type="text" name="code" id="WRK_SHFT_INPF_CODE_upt">
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="" for="WRK_SHFT_INPF_NAME">Shift Name
                                        </label>
                                        <input class="form-control form-control " type="text" name="name" id="WRK_SHFT_INPF_NAME_upt">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="mb-1 mt-2" for="">Color</label>
                                        <div class="input-group ">
                                            <input type="text" name="color" id="shift_color_upt" class="form-control shift_color colorpicker_upt">
                                            <div class="input-group-append" data-target="#shift_color_upt" data-toggle="colorpicker">
                                                <span class="input-group-text"><i class="fas fa-square color_data" style="font-size: 20px"></i></span>
                                            </div>
                                            <!-- <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div> -->
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-square color_data_upt" style="font-size: 20px"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2">
                    <section>
                        <div class="form-check checkbox-lg mb-3">
                          <input class="form-check-input enable_checkbox" type="checkbox" id="time_regular_enable_upt" checked name="time_regular_enable" value="1" >
                          <label class="form-check-label text-bold" for="defaultCheck1">
                            Regular
                          </label>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="required" for="WRK_SHFT_INPF_TIME_IN">Shift Time In</label>
                                    <div class="input-group date time_picker" id="shift_time_in_upt"  data-target-input="nearest" style="width: 100% !important;">
                                        <input type="text" required class=" shift_time_in form-control datetimepicker-input time_text mr-0" id="time_regular_start_upt" name="time_regular_start" data-target=".time_picker_in1" placeholder="hr:min" >
                                        <div class="input-group-append" data-target="#shift_time_in_upt" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6" >
                                <div class="form-group">
                                    <label class="required" for="WRK_SHFT_INPF_TIME_OUT">Shift Time Out</label>
                                    <div class="input-group date time_picker" id="shift_time_out_upt" data-target-input="nearest" style="width: 100% !important;">
                                        <input type="text" required class=" form-control shift_time_out datetimepicker-input time_text mr-0" id="time_regular_end_upt" name="time_regular_end" data-target=".time_picker_out1"  placeholder="hr:min">
                                        <div class="input-group-append" data-target="#shift_time_out_upt" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class=" " for="WRK_SHFT_INPF_TIME_IN">Regular Work Hours</label>
                                    <div class="input-group" style="width: 100% !important;">
                                        <input type="text"  value='0' class="form-control bg-light" id="time_regular_reg_upt" name="time_regular_reg" >
                                        <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class=" " for="WRK_SHFT_INPF_TIME_IN">Night Differential</label>
                                    <div class="input-group" style="width: 100% !important;">
                                        <input type="text"  value='0' class="form-control bg-light" id="time_regular_nd_upt" name="time_regular_nd" >
                                        <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </section>
                           
                            <div class="row" <?= ($DISP_INOUT_TYPE == '1')? 'hidden': '' ?>>
                                <div class="col-6">
                                    <!--<div class="form-group">-->
                                    <!--    <label class=" " for="break_start">Break Start</label>-->
                                    <!--    <div class="input-group date time_picker" id="timepicker_in_2" data-target-input="nearest" style="width: 100% !important;">-->
                                    <!--        <input type="text" class=" form-control datetimepicker-input time_text mr-0" name="break_start" data-target=".time_picker_in2" placeholder="hr:min" id="time_text_in2">-->
                                    <!--        <div class="input-group-append" data-target="#timepicker_in_2" data-toggle="datetimepicker">-->
                                    <!--            <div class="input-group-text"><i class="far fa-clock"></i></div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>

                                <div class="col-6">
                                    <!--<div class="form-group">-->
                                    <!--    <label class="" for="WRK_SHFT_INPF_TIME_OUT_2">Shift Time Out 2</label>-->
                                    <!--    <div class="input-group date time_picker" id="timepicker_out_2" data-target-input="nearest" style="width: 100% !important;">-->
                                    <!--        <input type="text" class=" form-control datetimepicker-input time_text mr-0" name="WRK_SHFT_INPF_TIME_OUT_2" data-target=".time_picker_out2" id="time_text_out2" placeholder="hr:min">-->
                                    <!--        <div class="input-group-append" data-target="#timepicker_out_2" data-toggle="datetimepicker">-->
                                    <!--            <div class="input-group-text"><i class="far fa-clock"></i></div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>
                            </div>
                             <hr class="my-2">
                            <section>
                                <div class="form-check checkbox-lg mb-3">
                                  <input class="form-check-input enable_checkbox" id="time_break_enable_upt" name="time_break_enable" checked type="checkbox" value="1" id="defaultCheck1">
                                  <label class="form-check-label text-bold" for="defaultCheck1">
                                    Shift Break
                                  </label>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class=" " for="WRK_SHFT_INPF_LUNCH_BREAK_START"> Break Start</label>
                                            <div class="input-group date time_picker" id="time_break_in_upt" data-target-input="nearest" style="width: 100% !important;">
                                                <input type="text" class=" form-control datetimepicker-input time_text mr-0" id="time_break_start_upt" name="time_break_start" data-target=".lunch_break_start" placeholder="hr:min">
                                                <div class="input-group-append" data-target="#time_break_in_upt" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="" for="WRK_SHFT_INPF_LUNCH_BREAK_END">Break End</label>
                                            <div class="input-group date time_picker" id="time_break_out_upt" data-target-input="nearest" style="width: 100% !important;">
                                                <input type="text" class=" form-control datetimepicker-input time_text mr-0" name="time_break_end" id="time_break_end_upt" data-target=".lunch_break_end"  placeholder="hr:min">
                                                <div class="input-group-append" data-target="#time_break_out_upt" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-check checkbox-lg">
                                          <input class="form-check-input exclude_breaktime_checkbox" id="time_break_isexcluded_upt" name="time_break_isexcluded"  type="checkbox" value="1" />
                                          <label class="form-check-label text-bold" for="checkbox-2">Excluded to Regular Work Hours</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="exclude_breaktime_upt" style="display:none">
                                            <label class=" " for="WRK_SHFT_INPF_TIME_IN">Break Time</label>
                                            <div class="input-group" style="width: 100% !important;">
                                                <input type="text" id="time_break_hours_upt" name="time_break_hours" value='0' class="form-control bg-light"  >
                                                <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <hr class="my-2">
                            <section>
                                <div class="form-check checkbox-lg mb-3">
                                  <input class="form-check-input enable_checkbox" id="time_overtime_enable_upt" name="time_overtime_enable" checked type="checkbox" value="1"  id="defaultCheck1">
                                  <label class="form-check-label text-bold" for="defaultCheck1">
                                    Shift Overtime
                                  </label>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="" for="WRK_SHFT_INPF_TIME_IN">Overtime Start</label>
                                            <div class="input-group date time_picker" id="overtime_picker_in_upt" data-target-input="nearest" style="width: 100% !important;">
                                                <input type="text" class=" form-control datetimepicker-input time_text mr-0" id="time_overtime_start_upt" name="time_overtime_start" data-target=".time_picker_in1" placeholder="hr:min" >
                                                <div class="input-group-append" data-target="#overtime_picker_in_upt" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="col-6" >
                                        <div class="form-group">
                                            <label class="" for="WRK_SHFT_INPF_TIME_OUT">Overtime End</label>
                                            <div class="input-group date time_picker" id="overtime_picker_out_upt" data-target-input="nearest" style="width: 100% !important;">
                                                <input type="text" class=" form-control datetimepicker-input time_text mr-0"  id="time_overtime_end_upt" name="time_overtime_end" data-target=".time_picker_out1" placeholder="hr:min">
                                                <div class="input-group-append" data-target="#overtime_picker_out_upt" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class=" " for="WRK_SHFT_INPF_TIME_IN">Overtime Hours</label>
                                            <div class="input-group" style="width: 100% !important;">
                                                <input type="text" id="time_overtime_ot_upt" name="time_overtime_ot" value='0' class="form-control bg-light"  >
                                                <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class=" " for="WRK_SHFT_INPF_TIME_IN">Night Differential</label>
                                            <div class="input-group" style="width: 100% !important;">
                                                <input type="text" id="time_overtime_nd_upt" name="time_overtime_nd" value='0' class="form-control bg-light " >
                                                <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                    <div class="d-flex justify-content-end">
                        <input type="hidden" id="UPDT_WRK_SHFT_INPF_ID" name="id">
                        <button class='btn btn-primary text-light' id="UPDT_WRK_SHFT_BTN_SAVE">&nbsp;
                            Update</button>
                    </div>

                </div>
        </div>
    </div>

    </form>
</div>
</div>


<div class="modal fade class_modal_approve" id="modal_mark_active" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
            <h4 class="modal-title ml-1" id="exampleModalLabel">Mark as Active
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
            </button>
        </div>
        <form action="<?php echo base_url(); ?>attendances/workshift_mark_active" id="form_bulk_approve" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                <ul id="approve_list_id" class="row" style="background: #e7f4e4;"></ul>
                </div>

            </div>
            </div>
            <div class="modal-footer">
            <input type="hidden" name="EMPLOYEE_ID" id="EMPLOYEE_ID">
            <input type="hidden" name="APPROVE_ID" id="APPROVE_ID">
            <a type="submit" id="submit_bulk_approve" class='btn btn-primary text-light'>&nbsp; Save</a>
            <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal fade class_modal_reject" id="modal_mark_inactive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
            <h4 class="modal-title ml-1" id="exampleModalLabel">Mark as Inactive
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
            </button>
        </div>
        <form action="<?php echo base_url(); ?>attendances/workshift_mark_inactive" id="form_bulk_reject" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                <ul id="reject_list_id" class="row" style="background: #e7f4e4;"></ul>
                </div>

            </div>
            </div>
            <div class="modal-footer">
            <input type="hidden" name="REJECT_EMPLOYEE_ID" id="REJECT_EMPLOYEE_ID">
            <input type="hidden" name="WORKSHIFT_ID" id="WORKSHIFT_ID">
            <a type="submit" id="submit_bulk_reject" class='btn btn-primary text-light'>&nbsp; Save</a>
            <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
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
                <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout
                </a>
            </div>
        </div>
    </div>
</div>



<!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
<?php $this->load->view('templates/jquery_link'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js">
</script>
<!-- Initialize the editor. -->
<script>
    $(function() {
        $('div#froala-editor').froalaEditor({
            // Set custom buttons with separator between them.
            toolbarButtons: ['undo', 'redo', '|', 'bold', 'italic', 'strikeThrough', 'subscript',
                'superscript', 'outdent', 'indent', 'clearFormatting', 'html'
            ],
            toolbarButtonsXS: ['undo', 'redo', '-', 'bold', 'italic', 'html']
        })
        $('i.fa.fa-rotate-left').attr('class')
    });
</script>
<!-- SESSION MESSAGES -->

<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_WRK_SHFT')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_WRK_SHFT'); ?>'
      })
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_INSRT_WRK_SHFT');
}
?>


<?php
if ($this->session->flashdata('SESS_SUCC_MSG_UPDT_WRK_SHFT')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->flashdata('SESS_SUCC_MSG_UPDT_WRK_SHFT'); ?>'
      })
</script>
<?php
}
?>


<?php
if ($this->session->flashdata('SESS_ERROR_MSG_UPDT_WRK_SHFT')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-danger toast_width',
        title: 'Unable to Update',
        subtitle: 'close',
        body: '<?php echo $this->session->flashdata('SESS_ERROR_MSG_UPDT_WRK_SHFT'); ?>'
      })
</script>
<?php
}
?>

<?php
if ($this->session->flashdata('SESS_SUCC_MSG_DLT_WRK_SHFT')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->flashdata('SESS_SUCC_MSG_DLT_WRK_SHFT'); ?>'
      })
</script>
<?php
}
?>

<?php
if ($this->session->userdata('succ_approved')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('succ_approved'); ?>'
      })
</script>
<?php
$this->session->unset_userdata('succ_approved');
}
?>

<!-- <?php
if ($this->session->flashdata('SESS_SUCC_MSG_DLT_WRK_SHFT')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->flashdata('SESS_SUCC_MSG_DLT_WRK_SHFT'); ?>',
            '',
            'success'
        )
    </script>
<?php
}
?> -->

<script>
    $(document).ready(function() {

        // $("#search_btn").on("click", function() {
        //     var optionValue = $('#search_data').val();
        //     document.location.href = "work_shifts?all=" + optionValue.replace(/\s/g, '_');
        // })
        $('.enable_checkbox').on('change',function(){
            var parent  = $(this).parent();
            if(this.checked) {
                parent.siblings().find('input').prop('required',true);
                parent.siblings().show();
                return;
            }
            parent.siblings().find('input').prop('required',false);
            parent.siblings().hide(); 
        })
        $('.exclude_breaktime_checkbox').on('change',function(){
            var elem= $(this).parent().parent().siblings().children();
            if(this.checked) {
                elem.show();
                return;
            }
            elem.hide(); 
        })
        $('#check_all').click(function() {
        if (this.checked == true) {
            Array.from($('.check_single')).forEach(function(element) {
                $(element).prop('checked', true);
                $('.check_single').parent().parent().css('background', '#e7f4e4');
            })
            } else {
            Array.from($('.check_single')).forEach(function(element) {
                $(element).prop('checked', false);
                $('.check_single').parent().parent().css('background', '');
            })
            }
        })

        $('.check_single').on('change', function() {
        if (this.checked == true) {
            $(this).parent().parent().css('background', '#e7f4e4');
        } else {
            $(this).parent().parent().css('background', '');
        }
        })

        $('#bulk_mark_active').click(function() {
        let selected_id = [];
        let selected_att_id = [];
        let selected_empl_id = [];
        let selected_row_id = [];
        $('#APPROVAL_ID').empty();
        $('#approve_list_id').empty();
        $('#select_item input[type=checkbox]:checked').each(function() {
            let selected_item = $(this).val();
            let att_approval_id = $(this).attr('approval_id');
            let att_empl_id = $(this).attr('employee_id');
            let att_row_id = $(this).attr('row_id');
            selected_id.push(selected_item);
            selected_att_id.push(att_approval_id);
            selected_empl_id.push(att_empl_id);
            selected_row_id.push(att_row_id);
        })

        if (selected_id.length > 0) {
            $('.class_modal_approve').prop('id', 'modal_mark_active');
            let approval_ids = selected_id.join(',');
            let empl_ids = selected_empl_id.join(',');
            let row_ids = selected_row_id.join(',');
            $('#APPROVE_ID').val(row_ids);
            $('#APPROVAL_ID').val(approval_ids);
            $('#EMPLOYEE_ID').val(empl_ids);
            selected_row_id.forEach(function(data) {
            $('#approve_list_id').append(`<li class="col-md-6">ID : <strong>SHF${data.padStart(5, '0')}</strong></li>`);
            })
        } else {
            $('.class_modal_approve').prop('id', '');
            Swal.fire(
            'Please Select Work Shift!',
            '',
            'warning'
            )
        }
        })

        $('#bulk_mark_inactive').click(function() {
        let selected_id = [];
        let selected_att_id = [];
        let selected_empl_id = [];
        let selected_row_id = [];
        $('#APPROVAL_ID').empty();
        $('#reject_list_id').empty();
        $('#select_item input[type=checkbox]:checked').each(function() {
            let selected_item = $(this).val();
            let att_approval_id = $(this).attr('approval_id');
            let att_empl_id = $(this).attr('employee_id');
            let att_row_id = $(this).attr('row_id');
            selected_id.push(selected_item);
            selected_att_id.push(att_approval_id);
            selected_empl_id.push(att_empl_id);
            selected_row_id.push(att_row_id);
        })

        if (selected_id.length > 0) {
            $('.class_modal_reject').prop('id', 'modal_mark_inactive');
            let approval_ids = selected_id.join(',');
            let empl_ids = selected_empl_id.join(',');
            let row_ids = selected_row_id.join(',');
            $('#WORKSHIFT_ID').val(row_ids);
            $('#REJECT_EMPLOYEE_ID').val(empl_ids);
            selected_row_id.forEach(function(data) {
            $('#reject_list_id').append(`<li class="col-md-6">ID : <strong>SHF${data.padStart(5, '0')}</strong></li>`);
            })
        } else {
            $('.class_modal_reject').prop('id', '');
            Swal.fire(
            'Please Select Work Shift!',
            '',
            'warning'
            )
        }
        })
    
        $('#submit_bulk_approve').click(function() {
        $('#form_bulk_approve').submit();
        })

        $('#submit_bulk_reject').click(function() {
        $('#form_bulk_reject').submit();
        })

        $('#row_dropdown').on('change', function() {
        let row = $(this).val();
        window.location = "<?= base_url() ?>attendances/work_shifts?" + "page=1&row=" + row + '&tab=<?= $TAB ?>';
        });

        $("#clear_search_btn").on("click", function() {
        var url = window.location.href.split("?")[0];
        window.location = url
        });

        $("#search_btn").on("click", function() {
            search();
        });

        $("#search_data").on("keypress", function(e) {
            if (e.which === 13) {
            search();
            }
        });

        function search() {
            var tab = '<?= $TAB ?>';
            var optionValue = $('#search_data').val();
            var url = window.location.href.split("?")[0];
            if (window.location.href.indexOf("?") > 0) {
            window.location = url + "?page=1&tab="+tab+"&all=" + optionValue.replace(/\s/g, '_');
            } else {
            window.location = url + "?page=1&tab="+tab+"&all=" + optionValue.replace(/\s/g, '_');
            }
        }


        $('.shift_color').colorpicker();
        $('.shift_color').on('change', function() {
            $('.color_data').css('color', $(this).val());
        })
  
        $('.time_picker').datetimepicker({
            stepping: 15,
            format: 'LT'
        });
  
        $('.updt-my-colorpicker2').colorpicker()
        $('.updt-my-colorpicker2').on('colorpickerChange', function(event) {
            $('.updt-my-colorpicker2 .fa-square').css('color', event.color.toString());
        });
   
        function toggle_container(elem){
            var parent  = $(elem).parent();
            if($(elem).prop('checked')) {
                // parent.siblings().find('input').prop('required',true);
                parent.siblings().show();
                return;
            }
            // parent.siblings().find('input').prop('required',false);
            parent.siblings().hide(); 
        }
        function set_value(val){
            if(val==''||val=='00:00:00'){
                return '';
            }
            return val;
        }
        $('.timer_in').on('input',function(){
            reg_time();
        });
        $('.timer_out').on('input',function(){
            reg_time();
        });
        $('.break_time_in').on('input',function(){
            reg_time();
        });
        $('.break_time_out').on('input',function(){
            reg_time();
        });
         $('.overtime_time_in').on('input',function(){
            reg_time();
        });
        $('.overtime_time_out').on('input',function(){
            reg_time();
        });
        $('.exclude_breaktime_checkbox').on('input',function(){
            reg_time();
        });
        
        function reg_time(){
            console.log("aw");
            var reg_time_in             = document.getElementById("time_regular_start_add").value;
            var reg_time_out            = document.getElementById("time_regular_end_add").value;
            var break_time_in           = document.getElementById("lunch_break_start_text").value;
            var break_time_out          = document.getElementById("lunch_break_end_text").value;
            var overtime_time_in        = document.getElementById("overtime_start_text").value;
            var overtime_time_out       = document.getElementById("overtime_end_text").value;
            var myCheckbox              = document.getElementById("exclude_breaktime_checkbox");
            var isChecked               = myCheckbox.checked;


            var reg_time_in_float       = convertTimeToFloat(reg_time_in);
            var reg_time_out_float      = convertTimeToFloat(reg_time_out);
            var break_time_in_float     = convertTimeToFloat(break_time_in);
            var break_time_out_float    = convertTimeToFloat(break_time_out);
            var overtime_time_in_float  = convertTimeToFloat(overtime_time_in);
            var overtime_time_out_float = convertTimeToFloat(overtime_time_out);

            var nd_1    = 0;
            var nd_2    = 0;
            var nd      = 0;
            var overtime_time_diff = 0;
            var ot_nd_1    = 0;
            var ot_nd_2    = 0;
            var ot_nd = 0;

            break_time_diff = checkNaN(break_time_out_float - break_time_in_float);

            if(reg_time_in_float <= reg_time_out_float){
                reg_time_diff = checkNaN(reg_time_out_float - reg_time_in_float);

                if(reg_time_in_float <= 22 && reg_time_out_float >= 22){
                    nd_1 = reg_time_out_float - 22;
                    nd_2 = 0;
                }
                else if(reg_time_in_float <= 6 && reg_time_out_float > 6){
                    nd_1 = 0;
                    nd_2 = 6 - reg_time_in_float;
                }
                else if(reg_time_in_float <= 6 && reg_time_out_float <= 6){
                    nd_1 = 0;
                    nd_2 = reg_time_out_float - reg_time_in_float;
                }
                else{
                    nd_1 = 0;
                    nd_2 = 0;
                }
            }
            
            else{
                reg_time_diff = checkNaN((24 - reg_time_in_float) + reg_time_out_float);

                if(reg_time_in_float <= 22){
                    nd_1 = 2;
                }
                else{
                    nd_1 = 24 - reg_time_in_float;
                }

                if(reg_time_out_float >= 6){
                    nd_2 = 6;
                }
                else{
                    nd_2 = reg_time_out_float;
                }
            }

            if(overtime_time_in_float <= overtime_time_out_float){
                overtime_time_diff = checkNaN(overtime_time_out_float - overtime_time_in_float);
                if(overtime_time_in_float <= 22 && overtime_time_out_float >= 22){
                    ot_nd_1 = overtime_time_out_float - 22;
                    ot_nd_2 = 0;
                }
                else if(overtime_time_in_float <= 6 && overtime_time_out_float > 6){
                    ot_nd_1 = 0;
                    ot_nd_2 = 6 - overtime_time_in_float;
                }
                else if(overtime_time_in_float <= 6 && overtime_time_out_float <= 6){
                    ot_nd_1 = 0;
                    ot_nd_2 = overtime_time_out_float - overtime_time_in_float;
                }
                else{
                    ot_nd_1 = 0;
                    ot_nd_2 = 0;
                }
            
            }
            
            else{
                overtime_time_diff = checkNaN((24 - overtime_time_in_float) + overtime_time_out_float);
           
                if(overtime_time_in_float <= 22){
                    ot_nd_1 = 2;
                }
                else{
                    ot_nd_1 = 24 - overtime_time_in_float;
                }

                if(overtime_time_out_float >= 6){
                    ot_nd_2 = 6;
                }
                else{
                    ot_nd_2 = overtime_time_out_float;
                }
            }

            if(!isChecked){
                break_time_diff = 0;
            }

            nd      = checkNaN(nd_1 + nd_2);
            ot_nd   = checkNaN(ot_nd_1 + ot_nd_2);

            const time_regular_reg      = document.getElementById("time_regular_reg");
            const time_regular_nd       = document.getElementById("time_regular_nd");
            const time_break            = document.getElementById("break_time_hours");
            const overtime_time_ot      = document.getElementById("overtime_time_ot");
            const overtime_time_ndot    = document.getElementById("overtime_time_ndot");

            time_regular_reg.value      = reg_time_diff - break_time_diff;
            time_regular_nd.value       = nd;
            time_break.value            = break_time_diff;
            overtime_time_ot.value      = overtime_time_diff - ot_nd;
            overtime_time_ndot.value    = ot_nd;
            // console.log(nd);
        }

        function convertTimeToFloat(timeString){
            var timeAMPM = timeString.split(" ");
            var AMPM = timeAMPM[1];
            var timeParts = timeString.split(":");
            var hours = parseInt(timeParts[0]);
            var minutes = parseInt(timeParts[1]);
          
            if(hours == 12 && AMPM == "AM"){
                hours = 0;
            }
            if(hours == 12 && AMPM == "PM"){
                hours = 12;
            }
            else if(hours != 12 && AMPM == "PM"){
                hours = hours + 12;
            }
                    
            var timeInFloat = hours + parseFloat(minutes / 60);

            return timeInFloat;
        }

        function checkNaN(x) {
            if (isNaN(x)) {
                return 0;
            } else {
                return x;
            }
        }
       
      
        // Get & Display Data to Edit Modal Using Async JS function
        $('.edit_workshift').on('click', function() {
            // console.log("fasfv")
            let url = $(this).attr('href');
            fetch(url)
                .then((res) => res.json())
                .then((data) => {
                    console.log(data)
                    // Todo: add async function for editing data
                    $('#WRK_SHFT_INPF_CODE_upt').val(data['code']);
                    $('#WRK_SHFT_INPF_NAME_upt').val(data['name']);
                    $('#shift_color_upt').val(data['color']);
                    $('.color_data_upt').css("color", data['color']);
                    if(data['time_regular_enable']==1){
                        $('#time_regular_enable_upt').prop('checked',true);
                        toggle_container('#time_regular_enable_upt')
                    }else{
                        $('#time_regular_enable_upt').prop('checked',false);
                        toggle_container('#time_regular_enable_upt');
                    }
                    $('#time_regular_start_upt').val(data['time_regular_start']);
                    $('#time_regular_end_upt').val(data['time_regular_end']);
                    $('#time_regular_reg_upt').val(data['time_regular_reg']);
                    $('#time_regular_nd_upt').val(data['time_regular_nd']);
                    if(data['time_break_enable']==1){
                        $('#time_break_enable_upt').prop('checked',true);
                        toggle_container('#time_break_enable_upt');
                    }
                    else{
                        $('#time_break_enable_upt').prop('checked',false);
                        toggle_container('#time_break_enable_upt');
                    }
                    if(data['time_break_isexcluded']==1){
                        $('#time_break_isexcluded_upt').prop('checked',true);
                        $('#exclude_breaktime_upt').show();
                    }else{
                         $('#time_break_isexcluded_upt').prop('checked',false);
                         $('#exclude_breaktime_upt').hide();
                    }
                    $('#time_break_start_upt').val(set_value(data['time_break_start']));
                    $('#time_break_end_upt').val(set_value(data['time_break_end']));
                    $('#time_break_hours_upt').val(set_value(data['time_break_hours']))
                    if(data['time_overtime_enable']==1){
                        $('#time_overtime_enable_upt').prop('checked',true);
                        toggle_container('#time_overtime_enable_upt');
                    }
                    else{
                        $('#time_overtime_enable_upt').prop('checked',false);
                        toggle_container('#time_overtime_enable_upt');
                    }
                    $('#time_overtime_start_upt').val(set_value(data['time_overtime_start']));
                    $('#time_overtime_end_upt').val(set_value(data['time_overtime_end']));
                    $('#time_overtime_ot_upt').val(set_value(data['time_overtime_ot']));
                    $('#time_overtime_nd_upt').val(set_value(data['time_overtime_nd']));
                    $('#UPDT_WRK_SHFT_INPF_ID').val(data['id']);
                    // $('#shift_time_in_upt_2').val(data['time_in_2']);
                    // $('#shift_timeout_upt_2').val(data['time_out_2']);
                    // $('#shit_ot_out').val(data['time_out_ot']);

                    // $('#lunch_break_start_upt').val(data['lunch_break_start']);
                    // $('#lunch_break_end_upt').val(data['lunch_break_end']);

                    // if (data['has_break']) {
                    //     $('#break_time_upt').prop('checked', true);
                    // }
                    // if (data['next_day'] == "true") {
                    //     $('#next_day_upt').prop('checked', true);
                    // }
                    // else{
                    //     $('#next_day_upt').prop('checked', false);  
                    // }
                  
                    // console.log(data['lunch_break']);

                    // if (data['lunch_break'] == 1) {
                        
                    //     $('#onehourlunch_upt').prop('checked', true);
                    // }
                    // else{
                    //     $('#onehourlunch_upt').prop('checked', false);
                    // }

                    // $('#night_shift_upt')

                })
                .catch((err) => {
                    console.log(err)
                })
        })
        // Update Position
        $('#WRK_SHFT_BTN_UPDT').click(function() {
            var work_shift_name = $('#UPDT_WRK_SHFT_INPF_NAME').val();
            var hasErr = 0;
            if (!work_shift_name) {
                hasErr++;
            }
            if (hasErr == 0) {
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
            } else {
                $('#UPDT_WRK_SHFT_INPF_NAME').addClass('is-invalid');
            }
        })
        $('#UPDT_WRK_SHFT_INPF_NAME').keyup(function() {
            $('#UPDT_WRK_SHFT_INPF_NAME').removeClass('is-invalid');
        })
        // Delete Position
        $('.WRK_SHFT_BTN_DLT').click(function(e) {
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
                    window.location.href =
                        "<?= base_url(); ?>attendances/dlt_work_shift?delete_id=" +
                        user_deleteKey;
                }
            })
        })
    })
</script>
<!-------------------- Export ----------------->
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script>
    document.getElementById("btn_export").addEventListener('click', function() {
        /* Create worksheet from HTML DOM TABLE */
        var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
        /* Export to file (start a download) */
        XLSX.writeFile(wb, "Workshift.xlsx");
    });
</script>
</body>

</html>
​