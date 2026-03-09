<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />

<style>
  th.std {
    min-width: 70px;
    font-size: 12px !important;
  }

  th.emp {
    min-width: 200px;
    font-size: 12px !important;
  }

  th.chk {
    min-width: 30px;
    font-size: 12px !important;
  }

  th.bg-light-green {
    background-color: #b8f9b8;
  }

  th.bg-light-orange {
    background-color: #ffd196;
  }

  th.bg-light-blue {
    background-color: #a0cfff;
  }

  td {
    padding: 5px !important;
    font-size: 12px !important;
  }

  th.bg-light-regular {
    background-color: #FEFFED;
  }

  th.bg-light-rest {
    background-color: #FFF4F2;
  }

  th.bg-light-legal {
    background-color: #DEF0FE;
  }

  th.bg-light-special {
    background-color: #F5E9FF;
  }

  .shift_data {
    font-size: 12px !important;
  }

  .active-page {
    background-color: #007bff !important;
    color: white !important;
    cursor: 'default';
  }

  @media (max-width: 780px) {
    .shift {
      margin-top: 20px;
    }
  }
</style>
<?php
// $current_page=$PAGE;
// $next_page=$PAGE+1;
// $prev_page=$PAGE-1;
// $last_page=ceil($PAGES_COUNT);
// $row=$ROW;

?>
<?php


if (isset($_GET['branch'])) {$param_branch = $_GET['branch']; } else { $param_branch = ""; }
if (isset($_GET['dept'])) {$param_dept = $_GET['dept']; } else { $param_dept = ""; }
if (isset($_GET['division'])) {$param_division = $_GET['division']; } else { $param_division = ""; }
if (isset($_GET['section'])) {$param_section = $_GET['section']; } else { $param_section = ""; }
if (isset($_GET['group'])) {$param_group = $_GET['group']; } else { $param_group = ""; }
if (isset($_GET['team'])) {$param_team = $_GET['team']; } else { $param_team = ""; }
if (isset($_GET['line'])) {$param_line = $_GET['line']; } else { $param_line = ""; }

$search_data = $this->input->get('all');
$search_data = str_replace("_", " ", $search_data);

if(isset($_GET['yearmonth_from'])){
  $yearmonth_from = $_GET['yearmonth_from'];
}
else{
  $yearmonth_from = date('Y-m-01');
}

if(isset($_GET['yearmonth_to'])){
  $yearmonth_to = $_GET['yearmonth_to'];
}
else{
  $yearmonth_to = date('Y-m-t');
}

if (isset($_GET['row'])) {
  $row = $_GET['row'];
} else {
  $row = 25;
}

if (isset($_GET['page'])) {
  $current_page = $_GET['page'];
} else {
  $current_page = 1;
}

$prev_page = $current_page - 1;
$next_page = $current_page + 1;
// $last_page = intval($C_DATA_COUNT / $row) + 1;
$last_page_initial = ceil($C_DATA_COUNT / $row);
$last_page = ($last_page_initial == 0 || $last_page_initial == 1) ? 1 : $last_page_initial;

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

<body>
  <!-- Content Starts -->
  <div class="content-wrapper">
    <div class="container-fluid p-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url() ?>attendances">Attendance
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Shift Assignment
          </li>
        </ol>
      </nav>
      <div class="row">
        <!-- Title Text -->
        <div class="col-md-6">
          <h1 class="page-title">Shift Assignment</h1>
        </div>
        <!-- Title Button -->

        <div class="col-md-6 button-title">
          <!-- <a href="<?= base_url() . 'attendances/shift_import_csv'; ?>" id="btn_application" class="btn btn-primary shadow-none"><i class="fas fa-file-import"></i>Import CSV</a> -->
          <a href="<?= base_url() . 'attendances/work_shifts'; ?>" id="btn_workshift" class="btn btn-warning shadow-none"><i class="fa-duotone fa-moon-over-sun"></i>&nbsp;Set Workshift</a>
          <!-- <a href="#" id="btn_export" class="btn btn-primary shadow-none"><i class="fas fa-file-export"></i>Export XLSX</a> -->
          <!-- <a href="#" id="btn_application" data-toggle="modal" data-target="#modal_attendance_records" class="btn btn-primary shadow-none"><i class="fas fa-file-export"></i>Export CSV</a> -->
          <!-- <a href="<?= base_url() . 'attendances/bulk_import'; ?>" id="bulk_assign" class="btn btn-primary shadow-none"><i class="fas fa-file-import"></i>&nbsp;Bulk Import</a> -->
        </div>
      </div>

      <!-- Export Employee Modal -->
      <div class="modal fade" id="modal_attendance_records" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;">
              <h4 class="modal-title ml-1" id="exampleModalLabel">Export Employee Attendance Record
              </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;
                </span>
              </button>
            </div>
            <form action="" id="form_add_overtime" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="required " for="EMPLOYEE">Employee ID</label>
                      <?php
                      if ($DISP_ATTENDANCE_RECORD) {
                        foreach ($DISP_ATTENDANCE_RECORD as $DISP_ATTENDANCE_RECORD_ROW) {
                          $datas = $DISP_ATTENDANCE_RECORD_ROW->empl_id;
                        }
                      } ?>
                      <select name="EMPLOYEE" id="EMPLOYEE" class="form-control">
                        <?php

                        if ($DISP_EMP_LIST) {
                          foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) {
                            if ($DISP_EMP_LIST_ROW->col_midl_name) {
                              $midl_ini = $DISP_EMP_LIST_ROW->col_midl_name[0] . '.';
                            } else {
                              $midl_ini = '';
                            }
                        ?>

                            <option value="<?= $DISP_EMP_LIST_ROW->id ?>"><?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name . ' ' . $midl_ini ?></option>





                          <?php   } ?>

                        <?php
                        }
                        ?>

                      </select>

                      <input type="text" value=<?= $datas ?>>

                    </div>
                    <div class="form-group">
                      <label class="required " for="overtime_date">Duration</label>
                      <select name="attendance_record1" id="attendance_record" class="form-control" required>
                        <option value="Yearly">Yearly</option>
                        <option value="Monthly">Monthly</option>

                      </select>
                    </div>
                    <div class="form-group">
                      <select name="attendance_record2" id="attendance_record" class="form-control" required>
                        <?php
                        $current_year = date('Y');

                        for ($i = $current_year; $i >= 2019; $i--) { ?>
                          <option value="Year"><?= $i ?></option>
                        <?php }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="time_out" id="time_out_formatted">
                <a class='btn btn-primary text-light' id=""><i class="fas fa-file-export"></i> &nbsp; Export CSV
                </a>
              </div>
            </form>
          </div>
        </div>

        <hr>
        <div class="row">
          <div class="col-md-3">
            <div style="width: 100%;">
              <p class="text-secondary text-bold" style="font-size: 18px;">Filter Display:</p>
            </div>
         </div>
        </div>
        <div class="row mb-4">
          <div class="col-md-3">
            <label for="search_employees">Period From</label>
             <input class = "custom-select " type="date" id="year-month1" name="start" value="<?=$yearmonth_from?>">

          </div>
          <div class="col-md-3">
           
            <label for="search_employees">Period To</label>
             <input class = "custom-select " type="date" id="year-month2" name="end" value="<?=$yearmonth_to?>">

          </div>
        </div>
        <div class="row mb-4">
          <div class="col-md-2" <?php echo ($DISP_VIEW_BRANCH ? "" : "hidden") ?>>
            <p class="mb-1 text-secondary ">Branch</p>
            <select name="dept" id="filter_by_branch" class="form-control">
              <?php
              if ($DISP_DISTINCT_BRANCH) {
              ?>
                <option value="all">All Branches</option>
                <?php
                foreach ($DISP_DISTINCT_BRANCH as $DISP_DISTINCT_BRANCH_ROW) {
                  if ($DISP_DISTINCT_BRANCH_ROW->name != '') {
                ?>
                    <option value="<?= $DISP_DISTINCT_BRANCH_ROW->id ?>" <?php echo $param_branch == $DISP_DISTINCT_BRANCH_ROW->id ? 'selected' : '' ?>>
                      <?= $DISP_DISTINCT_BRANCH_ROW->name ?>
                    </option>
              <?php
                  }
                }
              }
              ?>
            </select>
          </div>
          <div class="col-md-2" <?php echo ($DISP_VIEW_DEPARTMENT ? "" : "hidden") ?>>
            <p class="mb-1 text-secondary ">Department</p>
            <select name="dept" id="filter_by_department" class="form-control">
              <?php
              if ($DISP_DISTINCT_DEPARTMENT) {
              ?>
                <option value="all" <?php foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW_1) {
                                      if ($DISP_DISTINCT_DEPARTMENT_ROW_1->name == '') {
                                        echo 'selected';
                                      }
                                    } ?>>All Departments</option>
                <?php
                foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW) {
                  if ($DISP_DISTINCT_DEPARTMENT_ROW->name != '') {
                ?>
                    <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->id ?>" <?php echo $param_dept == $DISP_DISTINCT_DEPARTMENT_ROW->id ? 'selected' : '' ?>>
                      <?= $DISP_DISTINCT_DEPARTMENT_ROW->name ?>
                    </option>
              <?php
                  }
                }
              }
              ?>
            </select>
          </div>
          <div class="col-md-2" <?php echo ($DISP_VIEW_DIVISION ? "" : "hidden") ?>>
            <p class="mb-1 text-secondary ">Division</p>
            <select name="dept" id="filter_by_division" class="form-control">
              <?php
              if ($DISP_DISTINCT_DIVISION) {
              ?>
                <option value="all" <?php foreach ($DISP_DISTINCT_DIVISION as $DISP_DISTINCT_DIVISION_ROW_1) {
                                      if ($DISP_DISTINCT_DIVISION_ROW_1->name == '') {
                                        echo 'selected';
                                      }
                                    } ?>>All Divisions</option>
                <?php
                foreach ($DISP_DISTINCT_DIVISION as $DISP_DISTINCT_DIVISION_ROW) {
                  if ($DISP_DISTINCT_DIVISION_ROW->name != '') {
                ?>
                    <option value="<?= $DISP_DISTINCT_DIVISION_ROW->id ?>" <?php echo $param_division == $DISP_DISTINCT_DIVISION_ROW->id ? 'selected' : '' ?>>
                      <?= $DISP_DISTINCT_DIVISION_ROW->name ?>
                    </option>
              <?php
                  }
                }
              }
              ?>
            </select>
          </div>
          <div class="col-md-2" <?php echo ($DISP_VIEW_SECTION ? "" : "hidden") ?>>
            <p class="mb-1 text-secondary ">Section</p>
            <select name="section" id="filter_by_section" class="form-control">
              <?php
              if ($DISP_DISTINCT_SECTION) {
              ?>
                <option value="all" <?php foreach ($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW_1) {
                                      if ($DISP_DISTINCT_SECTION_ROW_1->name == '') {
                                        echo 'selected';
                                      }
                                    } ?>>All Sections</option>
                <?php
                foreach ($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW) {
                  if ($DISP_DISTINCT_SECTION_ROW->name != '') {
                ?>
                    <option value="<?= $DISP_DISTINCT_SECTION_ROW->id ?>" <?php echo $param_section == $DISP_DISTINCT_SECTION_ROW->id ? 'selected' : "" ?>>
                      <?= $DISP_DISTINCT_SECTION_ROW->name ?>
                    </option>
              <?php
                  }
                }
              }
              ?>
            </select>
          </div>
          <div class="col-md-2" <?php echo ($DISP_VIEW_GROUP ? "" : "hidden") ?>>
            <p class="mb-1 text-secondary ">Group</p>
            <select name="group" id="filter_by_group" class="form-control">
              <?php
              if ($DISP_DISTINCT_GROUP) {
              ?>
                <option value="all" <?php foreach ($DISP_DISTINCT_GROUP as $DISP_DISTINCT_GROUP_ROW_1) {
                                      if ($DISP_DISTINCT_GROUP_ROW_1->name == '') {
                                        echo 'selected';
                                      }
                                    } ?>>All Groups</option>
                <?php
                foreach ($DISP_DISTINCT_GROUP as $DISP_DISTINCT_GROUP_ROW) {
                  if ($DISP_DISTINCT_GROUP_ROW->name != '') {
                ?>
                    <option value="<?= $DISP_DISTINCT_GROUP_ROW->id ?>" <?php echo $param_group == $DISP_DISTINCT_GROUP_ROW->id ? 'selected' : "" ?>>
                      <?= $DISP_DISTINCT_GROUP_ROW->name ?>
                    </option>
              <?php
                  }
                }
              }
              ?>
            </select>
          </div>
          <div class="col-md-2" <?php echo ($DISP_VIEW_TEAM ? "" : "hidden") ?>>
            <p class="mb-1 text-secondary ">Team</p>
            <select name="dept" id="filter_by_team" class="form-control">
              <?php
              if ($DISP_DISTINCT_TEAM) {
              ?>
                <option value="all" <?php foreach ($DISP_DISTINCT_TEAM as $DISP_DISTINCT_TEAM_ROW_1) {
                                      if ($DISP_DISTINCT_TEAM_ROW_1->name == '') {
                                        echo 'selected';
                                      }
                                    } ?>>All Teams</option>
                <?php
                foreach ($DISP_DISTINCT_TEAM as $DISP_DISTINCT_TEAM_ROW) {
                  if ($DISP_DISTINCT_TEAM_ROW->name != '') {
                ?>
                    <option value="<?= $DISP_DISTINCT_TEAM_ROW->id ?>" <?php echo $param_team == $DISP_DISTINCT_TEAM_ROW->id ? 'selected' : '' ?>>
                      <?= $DISP_DISTINCT_TEAM_ROW->name ?>
                    </option>
              <?php
                  }
                }
              }
              ?>
            </select>
          </div>
          <div class="col-md-2" <?php echo ($DISP_VIEW_LINE ? "" : "hidden") ?>>
            <p class="mb-1 text-secondary ">Line</p>
            <select name="line" id="filter_by_line" class="form-control">
              <?php
              if ($DISP_DISTINCT_LINE) {
              ?>
                <option value="all" <?php foreach ($DISP_DISTINCT_LINE as $DISP_DISTINCT_LINE_ROW_1) {
                                      if ($DISP_DISTINCT_LINE_ROW_1->name == '') {
                                        echo 'selected';
                                      }
                                    } ?>>All Lines</option>
                <?php
                foreach ($DISP_DISTINCT_LINE as $DISP_DISTINCT_LINE_ROW) {
                  if ($DISP_DISTINCT_LINE_ROW->name != '') {
                ?>
                    <option value="<?= $DISP_DISTINCT_LINE_ROW->id ?>" <?php echo $param_line == $DISP_DISTINCT_LINE_ROW->id ? 'selected' : '' ?>><?= $DISP_DISTINCT_LINE_ROW->name ?></option>
              <?php
                  }
                }
              }
              ?>
            </select>
          </div>
          <div class="col-md-2">
            <p class="mb-1 text-secondary ">Action</p>
            <a href=<?= base_url() . "attendances/shift_assignment" ?> id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
          </div>

        </div>
        <hr>

        <div class="card border-0 p-0 m-0">
          <div class="p-1">
            <div class="col-md-4 pl-0">
              <div class="input-group p-1 pt-2">
                <?php
                if ($search_data) { ?>
                  <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
                <?php } else { ?>
                  <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                <?php } ?>

                <input type="text" class="form-control" placeholder="Search" value="<?= ($search_data) ? $search_data : ""; ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
              </div>
            </div>
          </div>

          <div class="card border-0 p-0 m-0">
            <div class='p-2'>
              <div class='row align-items-center'>
                <div class='col col-md-4'>
                  <a href="#" class=" btn technos-button-gray shadow-none rounded" id="update" data-toggle="modal" data-target="#modela_update"><i class="far fa-check-circle"></i>&nbsp;Bulk Shift Assign</a>
                  <button id='btn-print' class='btn technos-button-gray shadow-none rounded'><i class="fa fa-print"></i>&nbsp; Print</button>
                </div>
                <div class='col d-flex justify-content-end align-items-center'>
                  <ul class="d-inline pagination m-0 p-0 ">
                    <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                    <ul class="d-inline pagination m-0 p-0 ">
                      <li><a class="page_row" <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                          < </a>
                      </li>
                      <li><a class="page_row" href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                      <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                      <li><a class="page_row" href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                      <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                      <li><a class="page_row" href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                      <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                      <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?> </a></li>
                      <li><a class="page_row" style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                    </ul>
                    <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>

                    <select id="row_dropdown" class="custom-select m-0" style="width: auto;">
                      <?php
                      foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                        <option value=<?= $C_ROW_DISPLAY_ROW ?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>
                      <?php } ?>
                    </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="p-2">
                    <div id="table_data" ></div>
                </div>
                <!-- <div class="table-responsive" >
                  <table class="table table-bordered table-xs mb-0 hover-highlight" id="TableToExport"> 
                    <thead>

                      <th class="text-center"><input type="checkbox" name="check_all" id="check_all"></th>
                      <th class="emp" style='min-width:300px'>Employee</th>
                      <?php foreach ($DATE_RANGE as $date) {
                        if ($date['holi_type'] == 'REGULAR') {
                          $th_color = 'bg-light-regular';
                        } elseif ($date['holi_type'] == 'LEGAL') {
                          $th_color = 'bg-light-legal';
                        } else {
                          $th_color = 'bg-light-special';
                        }
                      ?>
                        <th class="std <?= $th_color ?>"><?= $date["Date"]->format("m/d (D)") ?></th>
                      <?php } ?>

                    </thead>
                     <tbody id="cutoff_container">
                      <?php foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) { ?>
                        <tr>
                          <td class="text-center" id="select_item">
                            <input type="checkbox" name="brand" class="check_single" empl_name="<?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name ?>" value="<?= $DISP_EMP_LIST_ROW->id ?>">
                          </td>
                          <td>
                            <?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ' ' . $DISP_EMP_LIST_ROW->col_frst_name ?>
                          </td>

                          <?php foreach ($DATE_RANGE as $date) {

                            $workshift = 0;
                            foreach ($SHIFT_DATA_DATERANGE as $SHIFT_DATA_DATERANGE_ROW) {
                              $date_val = $date["Date"]->format("Y-m-d");
                              $empl_id  = $DISP_EMP_LIST_ROW->id;

                              if ($SHIFT_DATA_DATERANGE_ROW->empl_id == $empl_id && $SHIFT_DATA_DATERANGE_ROW->date == $date_val) {
                                $workshift = $SHIFT_DATA_DATERANGE_ROW->shift_id;
                                break;
                              }
                            }
                            $shift_color = "#EEEEEE";
                            foreach ($DISP_WORK_SHIFT_DATA as $DISP_WORK_SHIFT_DATA_VAL) {
                              if ($DISP_WORK_SHIFT_DATA_VAL->id == $workshift) {
                                $shift_color = $DISP_WORK_SHIFT_DATA_VAL->color;
                              }
                            }

                          ?>

                            <td style="width:50px !important; padding:0px !important; background-color: <?= $shift_color ?>">
                              <form action="<?= base_url() ?>attendances/process_assigning/<?= $DISP_USER_ID ?>" class="bg-transparent">
                                <input type="hidden" id="employee_data" value="<?= $DISP_EMP_LIST_ROW->id ?>">
                                <input type="hidden" id="date_data" value="<?= $date["Date"]->format("Y-m-d") ?>">
                                <select name="shift_id" class="form-control bg-transparent shift_data" style="border: none; padding: 0px!important;" id="shift">
                                  <?php if ($workshift == 0) { ?>
                                    <option value="">&#10071;</option>
                                  <?php } ?>
                                  <?php foreach ($DISP_WORK_SHIFT_DATA as $DISP_WORK_SHIFT_DATA_VAL) { ?>
                                    <option <?= $DISP_WORK_SHIFT_DATA_VAL->id == $workshift ? 'selected' : '' ?> value='<?= $DISP_WORK_SHIFT_DATA_VAL->id ?>'><?= $DISP_WORK_SHIFT_DATA_VAL->code ?></option>
                                  <?php } ?>
                                </select>
                              </form>
                            <?php }
                            ?>
                            </td>
                        </tr>
                      <?php } ?>
        

                    </tbody>
                  </table>
                  <div class="w-100 text-center">
                    <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
                  </div>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div><!--End fluid-->
    </div>
  </div>
  <!-- /.control-sidebar -->
  <!-- LOGOUT MODAL -->


  <!-- =============== APPY TEMPLATE ================= -->
  <!-- Modal -->
  <div class="modal fade" id="assign_shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container" style="margin:100px">
            <div style="position: relative">

              <!-- Include input field with id so
                that we can use it in JavaScript
                to set attributes.-->
              <input class="form-control" type="text" id="datetime" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- =============== APPY TEMPLATE ================= -->

  <div class="modal fade  class_modal_update_list" id="modela_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h4 class="modal-title ml-1" id="exampleModalLabel">Update
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>
        <form action="<?= base_url() . 'attendances/update_shift'; ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <ul id="update_list_id" class="row" style="background: #e7f4e4;"></ul>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                
                <?php
                $count_date = 1;
                foreach ($DATE_RANGE as $date) { 
                 $days = (int)$date["Date"]->format('w');
                 $isWeekday = ($days >= 1 && $days <= 5);
                ?>
                  <div class="form-group">
                    <label class="required" for="UPDT_SHIFT_<?= $count_date ?>"><?= $date["Date"]->format("m/d (D)") ?>
                    </label>
            
                    <select name="UPDT_SHIFT_<?= $count_date ?>" id="updt_shift_<?= $count_date ?>" class="form-control">
                      <?php
                      if ($SHIFT_DATA) {
                        foreach ($SHIFT_DATA as $SHIFT_DATA_ROW) {
                      ?>
                          <option value="<?= $SHIFT_DATA_ROW->id ?>" <?= ($isWeekday && $SHIFT_DATA_ROW->code == 'DS 8-5') ? 'selected' : ""; ?>><?= $SHIFT_DATA_ROW->name; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                <?php
                  $count_date++;
                } ?>

              </div>
            </div
          </div>
          <div class="modal-footer">
            <input type="hidden" name="DATE_FROM" id="DATE_FROM" value=<?= $DATE_FROM ?>>
            <input type="hidden" name="DATE_TO" id="DATE_TO" value=<?= $DATE_TO ?>>
            <input type="hidden" name="COUNT_DATE" id="COUNT_DATE" value=<?= $count_date ?>>
            <input type="hidden" name="UPDATE_ID" id="UPDATE_ID">
            <button type="submit" class='btn btn-primary text-light' id="save_button">&nbsp; Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- =============== ATTENDANCE SUMMARY ================= -->

  <!-- jQuery -->
  <?php $this->load->view('templates/jquery_link'); ?>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>


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
  <?php
  if ($this->session->userdata('success_copy_shift')) {
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
  <script src='https://printjs-4de6.kxcdn.com/print.min.js'></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>

  <script>
 
    var dispEmpList = <?php echo json_encode($DISP_EMP_LIST_DATA); ?>;
    var dateRange = <?php echo json_encode($DATE_RANGE); ?>;
    var shiftData = <?php echo json_encode($SHIFT_DATA); ?>;

    const shiftCode = shiftData.map(item => item.code);
    // console.log(dateRange)
    var combinedDateRange = dateRange.map(function(item) {
      return {
        date: item.Date.date.split(' ')[0], // Extract only the date part
        holi_type: item.holi_type
      };
    });
    console.log(dispEmpList)
    const dateHeaders = combinedDateRange.map(item => item.date);
    console.log(dateHeaders)

    const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.whiteSpace = 'nowrap';
        td.style.overflow = 'hidden';
    };

     // Create a new array that combines dispEmpList and dateHeaders
     var combinedData = dispEmpList.map(function(empData) {
        var combinedRow = {
            id: empData.id,
            col_empl_cmid: empData.col_empl_cmid,
            full_name: empData.full_name
        };
        
        dateHeaders.forEach(function(dateHeader) {
            // Use dateHeader as the property name and set the value from dateRange
            combinedRow[dateHeader] = dateRange.find(item => item.Date.date.split(' ')[0] === dateHeader)?.Date.date || '';
        });

        return combinedRow;
    });

    console.log(combinedData)

    const container = document.querySelector('#table_data');
        hot = new Handsontable(container, {
            data: combinedData,
            colHeaders: ['Id', 'Employee Id', 'Name', ...dateHeaders],
            rowHeaders: true,
            // stretchH: 'all',
            height: 'auto',
            rowHeights: 40,
            outsideClickDeselects: false,
            selectionMode: 'multiple',
            licenseKey: 'non-commercial-and-evaluation',
            renderer: customStyleRenderer,
            hiddenColumns: {
                columns: [0],
                indicators: true,
                // exclude hidden columns from copying and pasting
                copyPasteEnabled: false,
            },
            columns: [ {data:'id'}, {data:'col_empl_cmid'},{data:'full_name'},
            ...dateHeaders.map(dateHeader => ({
                // data: dateHeader,
                type: 'dropdown',
                source: shiftCode
            }))
            ],
            
        });

  </script>


  <script>
    $(document).ready(function() {
      var base_url = '<?= base_url(); ?>';
      // TableToExport
      $('#btn-print').on('click', function() {
        var table = document.getElementById('TableToExport');
        html2canvas(table).then(function(canvas) {
          printJS({
            printable: canvas.toDataURL(),
            type: 'image',
            style: '@page { size: landscape; }'
          });
        })
        // win.close();
      })

      $('#filter_by_branch').select2();
      $('#filter_by_department').select2();
      $('#filter_by_division').select2();
      $('#filter_by_section').select2();
      $('#filter_by_group').select2();
      $('#filter_by_team').select2();
      $('#filter_by_line').select2();

      $('#row_dropdown').on('change', function(e) {
        e.preventDefault()
        var row_val = $(this).val();
        let data = "?page=1&row=" + row_val;
        filter_data(data);
        // document.location.href = base_url + "employees/taxable_allowance_assign?page=1&row=" + row_val ; 
      });

      $('.page_row').on('click', function(e) {
        e.preventDefault()
        let page_row = $(this).attr('href');
        filter_data(page_row);
      })

      $('#year-month1').on('change',function(){
      var row_val =$('#row_dropdown').val();
   
      var yearmonth_from  = $(this).val();
      var yearmonth_to =$('#year-month2').val();
      document.location.href = base_url + "selfservices/my_time_records?page=1&row=" + row_val+"&yearmonth_from="+ yearmonth_from + "&yearmonth_to="+ yearmonth_to; 
      })

      $("#year-month1").on("change", function() {
        
        filter_data();
      })
      $("#year-month2").on("change", function() {
        
        filter_data();
      })

      $("#filter_by_branch").on("change", function() {
        filter_data();
      })
      $("#filter_by_department").on("change", function() {
        filter_data();
      })
      $("#filter_by_division").on("change", function() {
        filter_data();
      })
      $("#filter_by_section").on("change", function() {
        filter_data();
      })
      $('#filter_by_group').on("change", function() {
        filter_data();
      })
      $("#filter_by_team").on("change", function() {
        filter_data();
      })
      $("#filter_by_line").on("change", function() {
        filter_data();
      })

      $("#filter_by_status").on("change", function() {
        filter_data();
      })


      function filter_data(page_row) {
        if (page_row == null || page_row == "") {
          page_row = '?page=' + "<?= $current_page ?>" + '&row=' + "<?= $row ?>"
        }
        var yearmonth_from  =$("#year-month1").val();
        var yearmonth_to  =$("#year-month2").val();
        let row = $("#row_dropdown").val();
        let branch = $("#filter_by_branch").find(":selected").val();
        let department = $("#filter_by_department").find(":selected").val();
        let division = $("#filter_by_division").find(":selected").val();
        let section = $("#filter_by_section").find(":selected").val();
        let group = $("#filter_by_group").find(":selected").val();
        let team = $("#filter_by_team").find(":selected").val();
        let line = $("#filter_by_line").find(":selected").val();
        let status = $("#filter_by_status").find(":selected").val();

        window.location = base_url + "attendances/shift_assignment" + page_row + "&branch=" + branch +
          "&dept=" + department + "&division=" + division +
          "&section=" + section + "&group=" + group +
          "&team=" + team + "&line=" + line + "&status=" + status +
          "&yearmonth_from=" + yearmonth_from + "&yearmonth_to=" + yearmonth_to;
      }



      $('#update').click(function() {
        let selected_id = [];
        let att_empl_names = [];
        $('#UPDATE_ID').empty();
        $('#update_list_id').empty();
        $('#select_item input[type=checkbox]:checked').each(function() {
          let selected_item = $(this).val();
          let att_empl_name = $(this).attr('empl_name')
          selected_id.push(selected_item);
          att_empl_names.push(att_empl_name);
        })

        if (selected_id.length > 0) {
          $('.class_modal_update_list').prop('id', 'modela_update');
          $('#UPDATE_ID').val(selected_id);
          att_empl_names.forEach(function(data) {
            $('#update_list_id').append(`<li class="col-md-6"> <strong>${data}</strong></li>`);
          })
        } else {
          $('.class_modal_update_list').prop('id', '');
          Swal.fire(
            'Please Select Employee!',
            '',
            'warning'
          )
        }


      });



      $(document).on('click', '#check_all', function() {
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
        var optionValue = $('#search_data').val();
        var url = window.location.href.split("?")[0];
        if (window.location.href.indexOf("?") > 0) {
          window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
        } else {
          window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
        }
      }


      $("select.shift_data").on('change', function() {
        // let path =$(this).siblings("#link").val();
        let employee = $(this).siblings("#employee_data").val();
        let shift_id = $(this).find(":selected").val();
        let date_data = $(this).siblings("#date_data").val();
        window.location = base_url + "attendances/process_assigning/" + employee + "/" + shift_id + "/" + date_data;
      })
      $("tr.data_table").on('click', function() {
        console.log($(this));
      })
      $('#datetime').datetimepicker({
        format: 'hh:mm:ss a'
      });
      //Timepicker time in
      $('#timepicker').datetimepicker({
        // stepping: 30,
        format: 'LT'
      })
      // Timepicker time out
      $('#timepicker2').datetimepicker({
        format: 'LT'
      })


      var is_executed = false;
      $("#tbl_attendance").tablesorter();
      // $("#TableToExport").tablesorter();
      var locked_employees_arr = [];
      var unlocked_employees_arr = [];

    })
  </script>

  <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function() {
      /* Create worksheet from HTML DOM TABLE */
      var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
      /* Export to file (start a download) */
      XLSX.writeFile(wb, "Shift Assignment.xlsx");
    });
  </script>
</body>

</html>
