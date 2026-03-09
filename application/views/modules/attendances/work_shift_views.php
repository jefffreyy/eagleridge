<html>
<?php $this->load->view('templates/css_link'); ?>


<head>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css"> -->
    <link rel="stylesheet" href="<?= base_url() ?>assets_system/css/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.38.0/css/tempusdominus-bootstrap-4.min.css"> -->

</head>

<?php
$id_code      = "SHF";
$search_data  = $this->input->get('all');
$search_data  = str_replace("_", " ", $search_data ?? '');
$current_page = $PAGE;
$next_page    = $PAGE + 1;
$prev_page    = $PAGE - 1;
$last_page    = $PAGES_COUNT;
$row          = $ROW;
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
    .checkbox-lg .form-check-input {
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

    .filter-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease-out;
    }

    .filter-container form {
        margin: 0;
    }

    .filter-container.visible {
        max-height: 1000px;
        transition: max-height 0.5s ease-in-out;
    }
</style>

<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'attendances'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                    </a>&nbsp;Work&nbsp;Shifts<h1>
            </div>

            <div class="col-md-6 button-title d-flex justify-content-end">
                <a href="#" class="btn btn-primary shadow-none mr-2 " id="btn_export"><img class="mb-1" src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">
                    </i>&nbsp;Export XLSX</a>
                <a class="btn btn-primary shadow-none rounded" title="Add" href="#" data-toggle="modal" data-target="#modal_add_work_shift" id="add"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
                    Add Work Shift</a>
            </div>
        </div>

        <hr>
        <div class="card border-0 p-0 m-0">
            <div class="card border-0 pt-1 m-0">
                <div class="card-header p-0">
                    <div class="row">
                        <div class="col-xl-8">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link head-tab  <?= $TAB == 'Active' ? 'active' : '' ?> " href="?page=1&row=<?= $row ?>&tab=Active" id="tab-Active" style='cursor:pointer'>
                                        Active
                                        <span class="ml-2 badge badge-pill badge-secondary"> <?= $ACTIVES ?> </span>
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

                        <!-- <div class="col-xl-4">
                            <div class="input-group pb-1">
                                <?php
                                if ($search_data) { ?>
                                    <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
                                <?php } else { ?>
                                    <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                                <?php } ?>
                                <input type="text" class="form-control" placeholder="Search..." value="<?= ($search_data) ? $search_data : "" ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="p-2">
                    <div>
                        <div class="justify-content-between">
                            <div class=" row mt-3 py-1 justify-content-between">
                                <div class="col-12 col-lg-3 d-flex justify-content-lg-start justify-content-center">
                                    <button style="height: 36px;" class="mr-1 btn technos-button-green shadow-none rounded bulk-button" id="bulk_mark_active"><img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-check-solid_mark.svg') ?>" alt="">
                                        Mark as Active</button>

                                    <button style="height: 36px;" class="btn btn-danger shadow-none rounded bulk-button" id="bulk_mark_inactive"><img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-x-solid_mark_as.svg') ?>" alt="">
                                        Mark as Inactive</button>
                                </div>

                                <div class="col-12 col-lg-7 d-lg-flex d-none justify-content-lg-end">
                                    <div class="col-12 col-lg-6 ml-auto my-2 my-lg-0 row">

                                        <div class="d-inline d-flex col-12 col-lg-8 justify-content-lg-end justify-content-center align-items-center">
                                            <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                                        </div>

                                        <div class="d-lg-inline col-12 col-lg-4 d-flex justify-content-lg-end justify-content-center ">
                                            <ul class="pagination ml-0 ml-lg-4 m-0 p-0">
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
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 col-md-2 col-lg-2  d-none d-lg-flex align-items-center justify-content-center justify-content-lg-end mr-lg-0 mr-2">
                                    <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                                    <select id="row_dropdown" class="custom-select" style="width: auto;">
                                        <?php
                                        foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                                            <option value=<?= $C_ROW_DISPLAY_ROW ?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>





                    </div>
                </div>

                <div class="table-responsive border-danger">
                    <table class="table table-hover table-bordered mb-0" id="TableToExport">
                        <thead class="text-uppercase">
                            <th class="text-center"><input type="checkbox" name="check_all" id="check_all"></th>
                            <th>SHIFT ID</th>
                            <th>SHIFT&nbsp;CODE</th>
                            <th>SHIFT&nbsp;NAME</th>
                            <th>SHIFT&nbsp;TIME&nbsp;IN&nbsp;</th>
                            <th>SHIFT&nbsp;TIME&nbsp;OUT&nbsp;</th>
                            <th class="text-center">COLOR</th>
                            <th>STATUS</th>
                            <th class="text-center">ACTION</th>
                        </thead>

                        <tbody>
                            <?php
                            if ($DISP_WRK_SHFT_INFO) {
                                foreach ($DISP_WRK_SHFT_INFO as $ROW_WRK_SHFT_INFO) {
                                    $application_id = $id_code . str_pad($ROW_WRK_SHFT_INFO->id, 5, '0', STR_PAD_LEFT);
                            ?>
                                    <tr>
                                        <td class="text-center" id="select_item">
                                        <?php if ($ROW_WRK_SHFT_INFO->id != 1): ?>
                                            <input type="checkbox" name="approval_name" class="check_single" row_id="<?= $ROW_WRK_SHFT_INFO->id ?>" value="<?= $ROW_WRK_SHFT_INFO->id ?>" >
                                        <?php endif; ?>

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
                                            <!-- <?php echo ($ROW_WRK_SHFT_INFO->time_in == "00:00:00" || $ROW_WRK_SHFT_INFO->time_in == "00:00:00" ? '-' : $ROW_WRK_SHFT_INFO->time_in) ?> -->
                                            <?php echo ($ROW_WRK_SHFT_INFO->time_regular_start == null || $ROW_WRK_SHFT_INFO->time_regular_start == "00:00:00" ? '-' : $ROW_WRK_SHFT_INFO->time_regular_start) ?>
                                        </td>
                                        <td>
                                            <!-- <?php echo ($ROW_WRK_SHFT_INFO->time_in == "00:00:00" ? '-' :  $ROW_WRK_SHFT_INFO->time_out) ?> -->
                                            <?php echo ($ROW_WRK_SHFT_INFO->time_regular_end == null || $ROW_WRK_SHFT_INFO->time_regular_end == "00:00:00" ? '-' :  $ROW_WRK_SHFT_INFO->time_regular_end) ?>
                                        </td>

                                        <td>
                                            <?php if (!$ROW_WRK_SHFT_INFO->fixed) { ?>
                                                <center>
                                                    <p style="width: 50px; height 50px; background-color: <?= $ROW_WRK_SHFT_INFO->color ?>;">
                                                        &nbsp;</p>
                                                </center>
                                            <?php  } ?>
                                        </td>

                                        <td><?= $ROW_WRK_SHFT_INFO->status ?></td>
                                        <td class="text-center">
                                            <?php if ($ROW_WRK_SHFT_INFO->id != 1): ?>
                                                <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                                    <a class="btn btn-sm indigo lighten-2 edit_workshift" href="<?= base_url() ?>attendances/edit_work_shift/<?= $ROW_WRK_SHFT_INFO->id ?>" work_shift_id="<?= $ROW_WRK_SHFT_INFO->id ?>" title="Edit" data-toggle="modal" data-target="#modal_edit_work_shift">
                                                        <img src="<?= base_url('assets_system/icons/pen-to-square-solid.svg') ?>" alt="" id="edit">
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            
                                        </td>
                                    </tr>

                                <?php
                                }
                            } else { ?>

                                <tr class="table-active">
                                    <td colspan="9">
                                        <center>No Records</center>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-12 col-lg-7 d-lg-none d-flex justify-content-lg-end">
                    <div class="col-12 col-lg-6 ml-auto my-2 my-lg-0 row">

                        <div class="d-inline d-flex col-12 col-lg-8 justify-content-lg-end justify-content-center align-items-center">
                            <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                        </div>

                        <div class="d-lg-inline col-12 col-lg-4 d-flex d-lg-none justify-content-lg-end justify-content-center ">
                            <ul class="pagination ml-0 ml-lg-4 m-0 p-0">
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
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 col-md-2 col-lg-2  d-flex d-lg-none align-items-center justify-content-center justify-content-lg-start mr-lg-0 mr-2 mb-2">
                    <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                    <select id="row_dropdown" class="custom-select" style="width: auto;">
                        <?php
                        foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                            <option value=<?= $C_ROW_DISPLAY_ROW ?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>
                        <?php
                        } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<aside class="control-sidebar control-sidebar-dark"></aside>
<div class="modal fade" id="modal_add_work_shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Add Work Shifts </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times; </span>
                </button>
            </div>

            <form action="<?php echo base_url('attendances/insrt_work_shift'); ?>" id="WRK_SHFT_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required" for="WRK_SHFT_INPF_NAME">Shift Code</label>
                                <input required class="form-control form-control " type="text" name="code" id="wrk_shft_inpf_code">
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="required" for="WRK_SHFT_INPF_NAME">Shift Name
                                        </label>
                                        <input required class="form-control form-control " type="text" name="name" id="wrk_shft_inpf_name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="mb-1 mt-2" for="">Color</label>
                                        <div class="input-group ">
                                            <!-- <input type="text" name="color" style="z-index:1" id="shift_color" class="form-control shift_color colorpicker">
                                            <div class="input-group-append" data-target="#shift_color" data-toggle="colorpicker">
                                                <span class="input-group-text"><i class="fas fa-square color_data" style="font-size: 20px"></i></span>
                                            </div> -->

                                            <select class="form-control " id="shift_color_assign" name="color" >
                                            <option value="" class="option-color"></option>
                                                <option value="#FFCCFF" class="option-color">#FFCCFF</option>
                                                <option value="#66CCFF" class="option-color">#66CCFF</option>
                                                <option value="#99CCFF" class="option-color">#99CCFF</option>
                                                <option value="#99FF99" class="option-color">#99FF99</option>
                                                <option value="#CCCCFF" class="option-color">#CCCCFF</option>
                                                <option value="#CCECFF" class="option-color">#CCECFF</option>
                                                <option value="#CCFF99" class="option-color">#CCFF99</option>
                                                <option value="#CCFFCC" class="option-color">#CCFFCC</option>
                                                <option value="#CCFFFF" class="option-color">#CCFFFF</option>
                                                <option value="#EAEAEA" class="option-color">#EAEAEA</option>
                                                <option value="#FF9999" class="option-color">#FF9999</option>
                                                <option value="#FF99CC" class="option-color">#FF99CC</option>
                                                <option value="#FFCC99" class="option-color">#FFCC99</option>
                                                <option value="#FFCCCC" class="option-color">#FFCCCC</option>
                                                <option value="#FFFF99" class="option-color">#FFFF99</option>
                                                <option value="#FFFFCC" class="option-color">#FFFFCC</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-2">
                            <section>
                                <div class="form-check checkbox-lg mb-3">
                                    <input class="form-check-input enable_checkbox" type="checkbox" name="time_regular_enable" value="1">
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

                                    <div class="col-6">
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
                                                <input type="text" value='0' class="reg_hours_dif hours_dif form-control bg-light" name="time_regular_reg" id="time_regular_reg" readonly>
                                                <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class=" " for="WRK_SHFT_INPF_TIME_IN">Night Differential</label>
                                            <div class="input-group" style="width: 100% !important;">
                                                <input type="text" value='0' class="form-control bg-light" name="time_regular_nd" id="time_regular_nd" readonly>
                                                <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <div class="row" <?= ($DISP_INOUT_TYPE == '1') ? 'hidden' : '' ?>>
                                <div class="col-6"> </div>
                                <div class="col-6"></div>
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
                                            <input name="time_break_isexcluded"  type="hidden" value="0" />
                                            <input class="form-check-input exclude_breaktime_checkbox" name="time_break_isexcluded" id="exclude_breaktime_checkbox" type="checkbox" value="1" />
                                            <label class="form-check-label text-bold" for="checkbox-2">Excluded to Regular Work Hours</label>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group" id="exclude_breaktime" style="display:none">
                                            <label class=" " for="WRK_SHFT_INPF_TIME_IN">Break Time</label>
                                            <div class="input-group" style="width: 100% !important;">
                                                <input type="text" name="time_break_hours" value='0' class="break_time_hours form-control bg-light" id="break_time_hours" readonly>
                                                <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </section>
                            <hr class="my-2">

                            <section>
                                <div class="form-check checkbox-lg mb-3">
                                    <input class="form-check-input enable_checkbox" name="time_overtime_enable" type="checkbox" value="1" id="defaultCheck1">
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

                                    <div class="col-6">
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
                                                <input type="text" name="time_overtime_ot" value='0' class="hours_dif form-control bg-light" id="overtime_time_ot">
                                                <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class=" " for="WRK_SHFT_INPF_TIME_IN">OT with Night Differential</label>
                                            <div class="input-group" style="width: 100% !important;">
                                                <input type="text" name="time_overtime_nd" value='0' class="form-control bg-light " id="overtime_time_ndot">
                                                <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <hr class="my-2">
                            <section>
                                <div class="form-check checkbox-lg mb-3">
                                    <input class="form-check-input" name="disregard_undertime" type="checkbox" id="disregard_undertime">
                                    <label class="form-check-label text-bold" for="disregard_undertime">
                                        Disregard Undertime
                                    </label>
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

<div class="modal fade" id="modal_edit_work_shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Work Shifts</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
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
                                            <!-- <input type="text" name="color" id="shift_color_upt" class="form-control shift_color colorpicker_upt">
                                            <div class="input-group-append" data-target="#shift_color_upt" data-toggle="colorpicker">
                                                <span class="input-group-text"><i class="fas fa-square color_data" style="font-size: 20px"></i></span>
                                            </div> -->

                                            <select class="form-control " id="shift_color_upt" name="color" >
                                                <option value="#FFCCFF" class="option-color">#FFCCFF</option>
                                                <option value="#66CCFF" class="option-color">#66CCFF</option>
                                                <option value="#99CCFF" class="option-color">#99CCFF</option>
                                                <option value="#99FF99" class="option-color">#99FF99</option>
                                                <option value="#CCCCFF" class="option-color">#CCCCFF</option>
                                                <option value="#CCECFF" class="option-color">#CCECFF</option>
                                                <option value="#CCFF99" class="option-color">#CCFF99</option>
                                                <option value="#CCFFCC" class="option-color">#CCFFCC</option>
                                                <option value="#CCFFFF" class="option-color">#CCFFFF</option>
                                                <option value="#EAEAEA" class="option-color">#EAEAEA</option>
                                                <option value="#FF9999" class="option-color">#FF9999</option>
                                                <option value="#FF99CC" class="option-color">#FF99CC</option>
                                                <option value="#FFCC99" class="option-color">#FFCC99</option>
                                                <option value="#FFCCCC" class="option-color">#FFCCCC</option>
                                                <option value="#FFFF99" class="option-color">#FFFF99</option>
                                                <option value="#FFFFCC" class="option-color">#FFFFCC</option>
                                            </select>

                                            <!-- <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-square color_data_upt" style="font-size: 20px"></i></span>
                                                </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2">

                    <section>
                        <div class="form-check checkbox-lg mb-3">
                            <input class="form-check-input enable_checkbox" type="checkbox" id="time_regular_enable_upt" checked name="time_regular_enable" value="1">
                            <label class="form-check-label text-bold" for="defaultCheck1">
                                Regular
                            </label>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="required" for="WRK_SHFT_INPF_TIME_IN">Shift Time In</label>
                                    <div class="input-group date time_picker  " id="shift_time_in_upt" data-target-input="nearest" style="width: 100% !important;">
                                        <input type="text" required class=" shift_time_in form-control datetimepicker-input time_text mr-0" id="time_regular_start_upt" name="time_regular_start" data-target=".time_picker_in1" placeholder="hr:min">
                                        <div class="input-group-append" data-target="#shift_time_in_upt" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="required" for="WRK_SHFT_INPF_TIME_OUT">Shift Time Out</label>
                                    <div class="input-group date time_picker" id="shift_time_out_upt" data-target-input="nearest" style="width: 100% !important;">
                                        <input type="text" required class="time_in form-control shift_time_out datetimepicker-input time_text mr-0" id="time_regular_end_upt" name="time_regular_end" data-target=".time_picker_out1" placeholder="hr:min">
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
                                        <input type="text" value='0' class="form-control bg-light" id="time_regular_reg_upt" name="time_regular_reg" readonly>
                                        <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class=" " for="WRK_SHFT_INPF_TIME_IN">Night Differential</label>
                                    <div class="input-group" style="width: 100% !important;">
                                        <input type="text" value='0' class="form-control bg-light" id="time_regular_nd_upt" name="time_regular_nd" readonly>
                                        <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="row" <?= ($DISP_INOUT_TYPE == '1') ? 'hidden' : '' ?>>
                        <div class="col-6"> </div>
                        <div class="col-6"></div>
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
                                        <input type="text" class=" form-control datetimepicker-input time_text mr-0" name="time_break_end" id="time_break_end_upt" data-target=".lunch_break_end" placeholder="hr:min">
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
                                    <input class="form-check-input exclude_breaktime_checkbox" id="time_break_isexcluded_upt" name="time_break_isexcluded" type="checkbox" value="1" />
                                    <label class="form-check-label text-bold" for="checkbox-2">Excluded to Regular Work Hours</label>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group" id="exclude_breaktime_upt" style="display:none">
                                    <label class=" " for="WRK_SHFT_INPF_TIME_IN">Break Time</label>
                                    <div class="input-group" style="width: 100% !important;">
                                        <input type="text" id="time_break_hours_upt" name="time_break_hours" value='0' class="form-control bg-light" readonly>
                                        <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <hr class="my-2">

                    <section>
                        <div class="form-check checkbox-lg mb-3">
                            <input class="form-check-input enable_checkbox" id="time_overtime_enable_upt" name="time_overtime_enable" checked type="checkbox" value="1" id="defaultCheck1">
                            <label class="form-check-label text-bold" for="defaultCheck1">
                                Shift Overtime
                            </label>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="" for="WRK_SHFT_INPF_TIME_IN">Overtime Start</label>
                                    <div class="input-group date time_picker" id="overtime_picker_in_upt" data-target-input="nearest" style="width: 100% !important;">
                                        <input type="text" class=" form-control datetimepicker-input time_text mr-0" id="time_overtime_start_upt" name="time_overtime_start" data-target=".time_picker_in1" placeholder="hr:min">
                                        <div class="input-group-append" data-target="#overtime_picker_in_upt" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="" for="WRK_SHFT_INPF_TIME_OUT">Overtime End</label>
                                    <div class="input-group date time_picker" id="overtime_picker_out_upt" data-target-input="nearest" style="width: 100% !important;">
                                        <input type="text" class=" form-control datetimepicker-input time_text mr-0" id="time_overtime_end_upt" name="time_overtime_end" data-target=".time_picker_out1" placeholder="hr:min">
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
                                        <input type="text" id="time_overtime_ot_upt" name="time_overtime_ot" value='0' class="form-control bg-light">
                                        <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class=" " for="WRK_SHFT_INPF_TIME_IN">Night Differential</label>
                                    <div class="input-group" style="width: 100% !important;">
                                        <input type="text" id="time_overtime_nd_upt" name="time_overtime_nd" value='0' class="form-control bg-light ">
                                        <span class="border-0 input-group-text bg-transparent" id="basic-addon2">Hour/s</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <hr class="my-2">
                    <section>
                        <div class="form-check checkbox-lg mb-3">
                            <input class="form-check-input" name="disregard_undertime" type="checkbox" id="disregard_undertime_edit">
                            <label class="form-check-label text-bold" for="disregard_undertime_edit">
                                Disregard Undertime
                            </label>
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

<div class="modal fade class_modal_set_ssa" id="modal_set_ssa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Set Status to <span class="work_shift_status_label"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?php echo base_url('attendances/workshift_mark_active_inactive'); ?>" method="post">
                <div class="modal-body px-5 pb-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <p class="">Set the following work shift to <span class="work_shift_status_label"></span></p>
                                </div>
                                <div class="col-md-12">
                                    <ul id="list_mark" class="row"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="work_shift_status" name="work_shift_status">
                    <input type="hidden" id="list_mark_ids" name="list_mark_ids">
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>


</div>




<?php $this->load->view('templates/jquery_link'); ?>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.38.0/js/tempusdominus-bootstrap-4.min.js"></script> -->

<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script> -->
<script src="<?= base_url() ?>assets_system/js/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js"></script> -->





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

<script>
    var selectElement = document.getElementById("shift_color_upt");
    var shiftColorAssign = document.getElementById("shift_color_assign");

    shiftColorAssign.addEventListener("click", function() {
        // Loop through options and set background color
        for (var i = 0; i < this.options.length; i++) {
            var option = this.options[i];
            option.style.backgroundColor = option.value;
        }
    });
    
    selectElement.addEventListener("click", function() {
        // Loop through options and set background color
        for (var i = 0; i < this.options.length; i++) {
            var option = this.options[i];
            option.style.backgroundColor = option.value;
        }
    });

    shiftColorAssign.addEventListener("change", function() {
        var selectedColor = this.options[this.selectedIndex].value;
        this.style.backgroundColor = selectedColor;
    });

    selectElement.addEventListener("change", function() {
        var selectedColor = this.options[this.selectedIndex].value;
        this.style.backgroundColor = selectedColor;
    });
    
    
</script>






<script>
    // Ensure the document is ready before executing the script
    $(document).ready(function() {
        // Check if jQuery is properly loaded
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded');
            return;
        }

        // Check if Bootstrap is properly loaded
        if (typeof $.fn.modal === 'undefined') {
            console.error('Bootstrap is not loaded');
            return;
        }

        // Check if Moment.js is properly loaded
        if (typeof moment === 'undefined') {
            console.error('Moment.js is not loaded');
            return;
        }

        // Check if Tempus Dominus is properly loaded
        if (typeof $.fn.datetimepicker === 'undefined') {
            console.error('Tempus Dominus is not loaded');
            return;
        }

        // // Initialize Tempus Dominus for regular shift time in
        // $('#shift_time_in_upt').datetimepicker({
        //     format: 'HH:mm',
        //     useCurrent: false,
        // }); 

        // Initialize Tempus Dominus for regular shift time in
        $('#time_regular_start_upt').datetimepicker({
            format: 'HH:mm',
            useCurrent: false,
        });

        // // Initialize Tempus Dominus for regular shift time out
        // $('#shift_time_out_upt').datetimepicker({
        //     format: 'HH:mm',
        //     useCurrent: false,
        // }); 

        // Initialize Tempus Dominus for regular shift time out
        $('#time_regular_end_upt').datetimepicker({
            format: 'HH:mm',
            useCurrent: false,
        }); 

        // Initialize Tempus Dominus for break time start
        $('#time_break_start_upt').datetimepicker({
            format: 'HH:mm',
            useCurrent: false,
        });

        // Initialize Tempus Dominus for break time end
        $('#time_break_end_upt').datetimepicker({
            format: 'HH:mm',
            useCurrent: false,
        });

        // Initialize Tempus Dominus for overtime start
        $('#time_overtime_start_upt').datetimepicker({
            format: 'HH:mm',
            useCurrent: false,
        });

        // Initialize Tempus Dominus for overtime end
        $('#time_overtime_end_upt').datetimepicker({
            format: 'HH:mm',
            useCurrent: false,
        });
    });
</script>


<script>
    $(document).ready(function() {

        $('.enable_checkbox').on('change', function() {
            var parent = $(this).parent();
            if (this.checked) {
                parent.siblings().find('input').prop('required', true);
                parent.siblings().show();
                return;
            }
            parent.siblings().find('input').prop('required', false);
            parent.siblings().hide();
        })
        $('.exclude_breaktime_checkbox').on('change', function() {
            var elem = $(this).parent().parent().siblings().children();
            if (this.checked) {
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
            // console.log('bulk_mark_active');
            let selected_id = [];
            // let selected_att_id = [];
            // let selected_empl_id = [];
            // let selected_row_id = [];
            // $('#APPROVAL_ID').empty();
            // $('#approve_list_id').empty();
            $('#select_item input[type=checkbox]:checked').each(function() {
                let selected_item = $(this).val();
                // let att_approval_id = $(this).attr('approval_id');
                // let att_empl_id = $(this).attr('employee_id');
                // let att_row_id = $(this).attr('row_id');
                selected_id.push(selected_item);
                // selected_att_id.push(att_approval_id);
                // selected_empl_id.push(att_empl_id);
                // selected_row_id.push(att_row_id);
            })
            var elements = document.getElementsByClassName("work_shift_status_label");
            for (var i = 0; i < elements.length; i++) {
                elements[i].textContent = "Active";
            }
            $('#work_shift_status').val("Active");
            $('#list_mark').empty();
            if (selected_id.length > 0) {
                // $('.class_modal_approve').prop('id', 'modal_mark_active');
                // let approval_ids = selected_id.join(',');
                // let empl_ids = selected_empl_id.join(',');
                // let row_ids = selected_row_id.join(',');
                // $('#APPROVE_ID').val(row_ids);
                // $('#APPROVAL_ID').val(approval_ids);
                // $('#EMPLOYEE_ID').val(empl_ids);
                $('.class_modal_set_ssa').prop('id', 'modal_set_ssa');
                var list_mark_ids = selected_id.join(",");
                $('#list_mark_ids').val(list_mark_ids);
                // console.log('list_mark_ids', list_mark_ids);
                // selected_row_id.forEach(function(data) {
                selected_id.forEach(function(data) {
                    // $('#approve_list_id').append(`<li class="col-md-6">ID : <strong>SHF${data.padStart(5, '0')}</strong></li>`);
                    $('#list_mark').append(`<li class="col-md-6">SHF${String(data).padStart(5, '0')}</li>`)
                })
                $('#modal_set_ssa').modal('show');
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
            // let selected_att_id = [];
            // let selected_empl_id = [];
            // let selected_row_id = [];
            // $('#APPROVAL_ID').empty();
            // $('#reject_list_id').empty();
            $('#select_item input[type=checkbox]:checked').each(function() {
                let selected_item = $(this).val();
                // let att_approval_id = $(this).attr('approval_id');
                // let att_empl_id = $(this).attr('employee_id');
                // let att_row_id = $(this).attr('row_id');
                selected_id.push(selected_item);
                // selected_att_id.push(att_approval_id);
                // selected_empl_id.push(att_empl_id);
                // selected_row_id.push(att_row_id);
            })
            var elements = document.getElementsByClassName("work_shift_status_label");
            for (var i = 0; i < elements.length; i++) {
                elements[i].textContent = "Inactive";
            }
            $('#work_shift_status').val("Inactive");
            $('#list_mark').empty();
            if (selected_id.length > 0) {
                // $('.class_modal_reject').prop('id', 'modal_mark_inactive');
                // let approval_ids = selected_id.join(',');
                // let empl_ids = selected_empl_id.join(',');
                // let row_ids = selected_row_id.join(',');
                // $('#WORKSHIFT_ID').val(row_ids);
                // $('#REJECT_EMPLOYEE_ID').val(empl_ids);
                $('.class_modal_set_ssa').prop('id', 'modal_set_ssa');
                var list_mark_ids = selected_id.join(",");
                $('#list_mark_ids').val(list_mark_ids);
                // console.log('list_mark_ids', list_mark_ids);
                // selected_row_id.forEach(function(data) {
                selected_id.forEach(function(data) {
                    // $('#reject_list_id').append(`<li class="col-md-6">ID : <strong>SHF${data.padStart(5, '0')}</strong></li>`);
                    // $('#list_mark').append(`<li class="col-md-6">` + String("00000000" + data).slice(-8) + `</li>`)
                    $('#list_mark').append(`<li class="col-md-6">SHF${String(data).padStart(5, '0')}</li>`)
                })
                $('#modal_set_ssa').modal('show');
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
                window.location = url + "?page=1&tab=" + tab + "&all=" + optionValue.replace(/\s/g, '_');
            } else {
                window.location = url + "?page=1&tab=" + tab + "&all=" + optionValue.replace(/\s/g, '_');
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

        function toggle_container(elem) {
            var parent = $(elem).parent();
            if ($(elem).prop('checked')) {
                parent.siblings().show();
                return;
            }
            parent.siblings().hide();
        }

        function set_value(val) {
            if (val == '' || val == '00:00:00') {
                return '';
            }
            return val;
        }
        $('.timer_in').on('input', function() {
            reg_time();
        });
        $('.timer_out').on('input', function() {
            reg_time();
        });
        $('.break_time_in').on('input', function() {
            reg_time();
        });
        $('.break_time_out').on('input', function() {
            reg_time();
        });
        $('.overtime_time_in').on('input', function() {
            reg_time();
        });
        $('.overtime_time_out').on('input', function() {
            reg_time();
        });
        $('.exclude_breaktime_checkbox').on('input', function() {
            reg_time();
        });

        $('input#time_regular_end_upt').on('input', function() {
            edit_reg_time();
        })
        $('input#time_regular_start_upt').on('input', function() {
            edit_reg_time();
        })
        $('input#time_break_start_upt').on('input', function() {
            edit_reg_time();
        })
        $('input#time_break_end_upt').on('input', function() {
            edit_reg_time();
        })
        $('#time_break_isexcluded_upt').on('change', function() {
            edit_reg_time();
        })

        function compute_time_difference(startTime, endTime) {
            if (startTime.isValid() && endTime.isValid()) {
                // If end time is less than start time, it means we crossed midnight
                if (endTime.isBefore(startTime)) {
                    endTime.add(1, 'day');
                }
                
                var duration = moment.duration(endTime.diff(startTime));
                var hours = Math.floor(duration.asHours());
                var minutes = Math.floor(duration.minutes() / 15) * 0.25;
                const total_time = hours + minutes;
                return total_time;
            }
            return 0;
        }

        function edit_reg_time() {

            let shift_time_in = $('#time_regular_start_upt').val();
            let shift_time_out = $('#time_regular_end_upt').val();
            let break_time_in = $('#time_break_start_upt').val();
            let break_time_out = $('#time_break_end_upt').val();
            let isExcluded = $('#time_break_isexcluded_upt').prop('checked');
            let shift_startTime = moment(shift_time_in, 'HH:mm A');
            let shift_endTime = moment(shift_time_out, 'HH:mm A');
            let break_startTime = moment(break_time_in, 'HH:mm A');
            let break_endTime = moment(break_time_out, 'HH:mm A');
            let break_diff = compute_time_difference(break_startTime, break_endTime)

            if (isExcluded === false) {
                break_diff = 0
            }

            let shift_diff = compute_time_difference(shift_startTime, shift_endTime) - break_diff;

            $('#time_regular_reg_upt').val(shift_diff);
            $('#time_break_hours_upt').val(break_diff)

        }

        function reg_time() {

            var reg_time_in = document.getElementById("time_regular_start_add").value;
            var reg_time_out = document.getElementById("time_regular_end_add").value;
            var break_time_in = document.getElementById("lunch_break_start_text").value;
            var break_time_out = document.getElementById("lunch_break_end_text").value;
            var overtime_time_in = document.getElementById("overtime_start_text").value;
            var overtime_time_out = document.getElementById("overtime_end_text").value;
            var myCheckbox = document.getElementById("exclude_breaktime_checkbox");
            var isChecked = myCheckbox.checked;

            var reg_time_in_float = convertTimeToFloat(reg_time_in);
            var reg_time_out_float = convertTimeToFloat(reg_time_out);
            var break_time_in_float = convertTimeToFloat(break_time_in);
            var break_time_out_float = convertTimeToFloat(break_time_out);
            var overtime_time_in_float = convertTimeToFloat(overtime_time_in);
            var overtime_time_out_float = convertTimeToFloat(overtime_time_out);

            const varObject = {
                reg_time_in,
                reg_time_out,
                break_time_in,
                break_time_out,
                overtime_time_in,
                overtime_time_out,
                isChecked,
                reg_time_in_float,
                reg_time_out_float,
                break_time_in_float,
                break_time_out_float,
                overtime_time_in_float,
                overtime_time_out_float,

            }


            var nd_1 = 0;
            var nd_2 = 0;
            var nd = 0;
            var overtime_time_diff = 0;
            var ot_nd_1 = 0;
            var ot_nd_2 = 0;
            var ot_nd = 0;

     
            if (isChecked) {
                break_time_diff = checkNaN(break_time_out_float - break_time_in_float);
            }else{
                break_time_diff = 0;
            }
            


            if (reg_time_in_float <= reg_time_out_float) {
                reg_time_diff = checkNaN(reg_time_out_float - reg_time_in_float);

                if (reg_time_in_float <= 22 && reg_time_out_float >= 22) {
                    nd_1 = reg_time_out_float - 22;
                    nd_2 = 0;
                } else if (reg_time_in_float <= 6 && reg_time_out_float > 6) {
                    nd_1 = 0;
                    nd_2 = 6 - reg_time_in_float;
                } else if (reg_time_in_float <= 6 && reg_time_out_float <= 6) {
                    nd_1 = 0;
                    nd_2 = reg_time_out_float - reg_time_in_float;
                } else {
                    nd_1 = 0;
                    nd_2 = 0;
                }
            } else {
                reg_time_diff = checkNaN((24 - reg_time_in_float) + reg_time_out_float);

                if (reg_time_in_float <= 22) {
                    nd_1 = 2;
                } else {
                    nd_1 = 24 - reg_time_in_float;
                }

                if (reg_time_out_float >= 6) {
                    nd_2 = 6;
                } else {
                    nd_2 = reg_time_out_float;
                }
            }


            if (overtime_time_in_float <= overtime_time_out_float) {
                overtime_time_diff = checkNaN(overtime_time_out_float - overtime_time_in_float);
                if (overtime_time_in_float <= 22 && overtime_time_out_float >= 22) {
                    ot_nd_1 = overtime_time_out_float - 22;
                    ot_nd_2 = 0;
                } else if (overtime_time_in_float <= 6 && overtime_time_out_float > 6) {
                    ot_nd_1 = 0;
                    ot_nd_2 = 6 - overtime_time_in_float;
                } else if (overtime_time_in_float <= 6 && overtime_time_out_float <= 6) {
                    ot_nd_1 = 0;
                    ot_nd_2 = overtime_time_out_float - overtime_time_in_float;
                } else {
                    ot_nd_1 = 0;
                    ot_nd_2 = 0;
                }

            } else {
                overtime_time_diff = checkNaN((24 - overtime_time_in_float) + overtime_time_out_float);

                if (overtime_time_in_float <= 22) {
                    ot_nd_1 = 2;
                } else {
                    ot_nd_1 = 24 - overtime_time_in_float;
                }

                if (overtime_time_out_float >= 6) {
                    ot_nd_2 = 6;
                } else {
                    ot_nd_2 = overtime_time_out_float;
                }
            }

            // if (!isChecked) {
            //     break_time_diff = 1;
            // }

            nd = checkNaN(nd_1 + nd_2);
            ot_nd = checkNaN(ot_nd_1 + ot_nd_2);

            const time_regular_reg = document.getElementById("time_regular_reg");
            const time_regular_nd = document.getElementById("time_regular_nd");
            const time_break = document.getElementById("break_time_hours");
            const overtime_time_ot = document.getElementById("overtime_time_ot");
            const overtime_time_ndot = document.getElementById("overtime_time_ndot");

            time_regular_reg.value = reg_time_diff - break_time_diff;
            time_regular_nd.value = nd;
            time_break.value = break_time_diff;
            overtime_time_ot.value = overtime_time_diff - ot_nd;
            overtime_time_ndot.value = ot_nd;
        }

        function convertTimeToFloat(timeString) {
            var timeAMPM = timeString.split(" ");
            var AMPM = timeAMPM[1];
            var timeParts = timeString.split(":");
            var hours = parseInt(timeParts[0]);
            var minutes = parseInt(timeParts[1]);

            if (hours == 12 && AMPM == "AM") {
                hours = 0;
            }
            if (hours == 12 && AMPM == "PM") {
                hours = 12;
            } else if (hours != 12 && AMPM == "PM") {
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

        $('.edit_workshift').on('click', function() {
            let url = $(this).attr('href');
            fetch(url)
                .then((res) => res.json())
                .then((data) => {

                    $('#WRK_SHFT_INPF_CODE_upt').val(data['code']);
                    $('#WRK_SHFT_INPF_NAME_upt').val(data['name']);
                    $('#shift_color_upt').val(data['color']);
                    var selectedColor = $('#shift_color_upt').val();
                    $('#shift_color_upt').css('background-color', selectedColor);
                    $('.color_data').css("color", data['color']);
                    if (data['time_regular_enable'] == 1) {
                        $('#time_regular_enable_upt').prop('checked', true);
                        toggle_container('#time_regular_enable_upt')
                    } else {
                        $('#time_regular_enable_upt').prop('checked', false);
                        toggle_container('#time_regular_enable_upt');
                    }
                    $('#time_regular_start_upt').val(data['time_regular_start']);
                    $('#time_regular_end_upt').val(data['time_regular_end']);
                    $('#time_regular_reg_upt').val(data['time_regular_reg']);
                    $('#time_regular_nd_upt').val(data['time_regular_nd']);
                    if (data['time_break_enable'] == 1) {
                        $('#time_break_enable_upt').prop('checked', true);
                        toggle_container('#time_break_enable_upt');
                    } else {
                        $('#time_break_enable_upt').prop('checked', false);
                        toggle_container('#time_break_enable_upt');
                    }
                    if (data['time_break_isexcluded'] == 1) {
                        $('#time_break_isexcluded_upt').prop('checked', true);
                        $('#exclude_breaktime_upt').show();
                    } else {
                        $('#time_break_isexcluded_upt').prop('checked', false);
                        $('#exclude_breaktime_upt').hide();
                    }
                    $('#time_break_start_upt').val(set_value(data['time_break_start']));
                    $('#time_break_end_upt').val(set_value(data['time_break_end']));
                    $('#time_break_hours_upt').val(set_value(data['time_break_hours']))
                    if (data['time_overtime_enable'] == 1) {
                        $('#time_overtime_enable_upt').prop('checked', true);
                        toggle_container('#time_overtime_enable_upt');
                    } else {
                        $('#time_overtime_enable_upt').prop('checked', false);
                        toggle_container('#time_overtime_enable_upt');
                    }
                    if (data['disregard_undertime'] == 1) {
                        document.getElementById("disregard_undertime_edit").checked = true;
                    } else {
                        document.getElementById("disregard_undertime_edit").checked = false;
                    }
                    $('#time_overtime_start_upt').val(set_value(data['time_overtime_start']));
                    $('#time_overtime_end_upt').val(set_value(data['time_overtime_end']));
                    $('#time_overtime_ot_upt').val(set_value(data['time_overtime_ot']));
                    $('#time_overtime_nd_upt').val(set_value(data['time_overtime_nd']));
                    $('#UPDT_WRK_SHFT_INPF_ID').val(data['id']);

                })
                .catch((err) => {
                    console.log(err)
                })
        })
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

<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script>
    document.getElementById("btn_export").addEventListener('click', function() {
        var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
        XLSX.writeFile(wb, "Workshift.xlsx");
    });
</script>

</body>

</html>
