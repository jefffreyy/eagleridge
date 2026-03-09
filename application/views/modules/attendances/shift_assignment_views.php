<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?= base_url('assets_system/css/handsontable14.css') ?>" />
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
<?php
?>
<?php
if (isset($_GET['branch'])) {
  $param_branch = $_GET['branch'];
} else {
  $param_branch = "";
}
if (isset($_GET['dept'])) {
  $param_dept = $_GET['dept'];
} else {
  $param_dept = "";
}
if (isset($_GET['division'])) {
  $param_division = $_GET['division'];
} else {
  $param_division = "";
}
if (isset($_GET['clubhouse'])) {
  $param_clubhouse = $_GET['clubhouse'];
} else {
  $param_clubhouse = "";
}
if (isset($_GET['section'])) {
  $param_section = $_GET['section'];
} else {
  $param_section = "";
}
if (isset($_GET['group'])) {
  $param_group = $_GET['group'];
} else {
  $param_group = "";
}
if (isset($_GET['team'])) {
  $param_team = $_GET['team'];
} else {
  $param_team = "";
}
if (isset($_GET['line'])) {
  $param_line = $_GET['line'];
} else {
  $param_line = "";
}
if (isset($_GET['search'])) {
  $search = $_GET['search'];
} else {
  $search = "";
}
$search_data = $this->input->get('search');
$search_data = str_replace("_", " ", $search_data ?? '');
if (isset($_GET['yearmonth_from'])) {
  $yearmonth_from = $_GET['yearmonth_from'];
} else {
  $yearmonth_from = date('Y-m-01');
}
if (isset($_GET['yearmonth_to'])) {
  $yearmonth_to = $_GET['yearmonth_to'];
} else {
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
$filter = $this->input->get('filter');
?>

<body>
  <div class="content-wrapper">
    <div class="container-fluid p-4">
      <div class="row">
        <div class="col-md-6">
          <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'attendances'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
            </a>&nbsp;Shift Assignment</h1>
        </div>
        <div class="col-md-6 button-title d-flex justify-content-end">
          <a href="<?= base_url() . 'attendances/work_shifts'; ?>" id="btn_workshift" class="btn btn-primary shadow-none"><img style="width: 16px; height: 16px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/moon-over-sun-duotone_xs.svg') ?>" alt="" />
            &nbsp;Set Workshift</a>
          <button type="button" class="btn btn-primary ml-1" id="printButton"><img style="width: 16px; height: 16px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/print-duotone_sm.svg') ?>" alt="" />&nbsp;Print</button>
        </div>
      </div>
      <hr>
      <div class="filter-container  <?= $filter ? 'visible' : '' ?>">
        <div class="row ">
          <div class="col-md-3">
            <div style="width: 100%;">
              <p class="text-secondary text-bold" style="font-size: 18px;">Filter Display:</p>
            </div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-md-3">
            <label for="search_employees">Period From</label>
            <input class="custom-select " type="date" id="year-month1" name="start" value="<?= $yearmonth_from ?>">
          </div>
          <div class="col-md-3">
            <label for="search_employees">Period To</label>
            <input class="custom-select " type="date" id="year-month2" name="end" value="<?= $yearmonth_to ?>">
          </div>
        </div>
        <div class=" d-flex row">
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
          <div class="col-md-2" <?php echo ($DISP_VIEW_CLUBHOUSE ? "" : "hidden") ?>>
            <p class="mb-1 text-secondary ">Clubhouse</p>
            <select name="dept" id="filter_by_clubhouse" class="form-control">
              <?php
              if ($DISP_DISTINCT_CLUBHOUSE) {
              ?>
                <option value="all" <?php foreach ($DISP_DISTINCT_CLUBHOUSE as $DISP_DISTINCT_CLUBHOUSE_ROW_1) {
                                      if ($DISP_DISTINCT_CLUBHOUSE_ROW_1->name == '') {
                                        echo 'selected';
                                      }
                                    } ?>>All Clubhouse</option>
                <?php
                foreach ($DISP_DISTINCT_CLUBHOUSE as $DISP_DISTINCT_CLUBHOUSE_ROW) {
                  if ($DISP_DISTINCT_CLUBHOUSE_ROW->name != '') {
                ?>
                    <option value="<?= $DISP_DISTINCT_CLUBHOUSE_ROW->id ?>" <?php echo $param_clubhouse == $DISP_DISTINCT_CLUBHOUSE_ROW->id ? 'selected' : '' ?>>
                      <?= $DISP_DISTINCT_CLUBHOUSE_ROW->name ?>
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
          <!-- <div class="col-md-2">
            <p class="mb-1 text-secondary ">Action</p>
            <a href=<?= base_url() . "attendances/shift_assignment" ?> id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
          </div> -->
        </div>
        <hr>
      </div>
      <div class="card border-0 p-0 m-0">
        <div class="">
          <div class="justify-content-between">
            <div class=" row d-flex justify-content-center justify-content-lg-start col-10 col-lg-7 mx-1 my-1">
              <label class="col-md-12 mb-1 text-secondary" for="search_employees" style="font-weight: 500">Search Employee</label>
              <select name="employee_id" id="employee_id" class="custom-select px-1 col-12 col-lg-5 employee_select form-control w-50 ">
                <option value="">All</option>
                <?php
                if ($DISP_ALL_EMP_LIST_DATA) {
                  foreach ($DISP_ALL_EMP_LIST_DATA as $DISP_EMP_LIST_ROW) {
                    $name = $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name;
                    if ($DISP_EMP_LIST_ROW->col_suffix) $name = $name . ' ' . $DISP_EMP_LIST_ROW->col_suffix;
                    if ($DISP_EMP_LIST_ROW->col_frst_name) $name = $name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name;
                    if ($DISP_EMP_LIST_ROW->col_midl_name) $name = $name . ' ' . $DISP_EMP_LIST_ROW->col_midl_name[0] . '.';
                ?>
                    <option value="<?= $DISP_EMP_LIST_ROW->id ?>" <?= $search_data == $DISP_EMP_LIST_ROW->id ? 'selected' : '' ?>>
                      <?= $name
                      // $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name . ' ' . $midl_ini 
                      ?></option>
                <?php
                  }
                }
                ?>
              </select>
              <button id="btnFilter" class="my-1 my-lg-0 btn btn-primary shadow-none rounded ml-1" onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg') ?>" style="margin-bottom: 1px " alt="">&nbsp;Advance Filter</button>
              <a href="<?= base_url('attendances/shift_assignment') ?>" id="btn_clear_filter" class="my-1 my-lg-0 btn btn-primary mr-1 mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="">&nbsp;Clear</a>
            </div>
          </div>
        </div>
        <div class="card border-0 p-0 m-0">
          <div class='p-2'>
            <div class='d-flex row align-items-center ml-1'>
              <div class='form-group row d-flex justify-content-center justify-content-lg-start col-12 col-md-3 col-lg-6 align-items-end'>
                <a href="#" class="mr-1 btn btn-primary shadow-none rounded" id="update_shift" data-toggle="modal" data-target="#modela_update"><img style="height: 1rem; width: 1rem; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-check-solid_mark.svg') ?>" alt="">
                  </i>&nbsp;Bulk Shift Assign</a>
                <button class="btn btn-primary mr-1" id="btn-update"><img style="width: 16px; height: 16px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />
                  &nbsp;Update</button>
                 <button id="btnToggle" class="btn btn-primary" onclick="toggleOriginal()">
                  <?= isset($_GET["show"]) && $_GET["show"] == 1 ? 'Hide Original Schedule' : 'Show Original Schedule' ?>
                </button>
              </div>
              <div class='d-none d-lg-flex col-sm-7 col-md-10 col-lg-6 justify-content-between my-lg-0 my-2'>
                <div class="col-12 col-lg-7 d-flex justify-content-end align-items-end ">
                  <div class="d-flex align-items-center row">
                    <div class="d-inline col-12 col-lg-6">
                      <p class="p-0 m-0 text-center " style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                    </div>
                    <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                      <ul class="pagination ml-0 ml-lg-4 m-0 p-0">
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
                    </div>
                  </div>
                </div>
                <div class="col-12 col-lg-2 d-none d-lg-flex justify-content-center align-items-center ml-auto">
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
          </div>
          <div class="row">
            <div class="col">
              <div class="pt-2">
                <div id="table_data"></div>
                <div class='col-12 col-lg-7 d-lg-none d-flex justify-content-lg-end'>
                  <div class="col-12 col-lg-6 ml-auto my-2 my-lg-0 row">
                    <div class="d-inline d-flex col-12 col-lg-8 justify-content-lg-end justify-content-center align-items-center">
                      <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                    </div>
                    <div class="d-lg-inline col-12 col-lg-4 d-flex justify-content-lg-end justify-content-center ">
                      <ul class="pagination ml-0 ml-lg-4 m-0 p-0">
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
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 col-md-2 col-lg-2  d-flex d-lg-none align-items-center justify-content-center justify-content-lg-end mr-lg-0 mr-2">
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
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
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
  <div class="modal fade  class_modal_update_list" id="modela_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h4 class="modal-title ml-1" id="exampleModalLabel">Update</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url() . 'attendances/update_shift'; ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <ul id="update_list_id" class="row" style="background: #e7f4e4;"></ul>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-6">
                <label for="search_employees">Period From</label>
                <input class="custom-select " type="date" id="" name="DATE_FROM" value="<?= $yearmonth_from ?>">
              </div>
              <div class="col-md-6">
                <label for="search_employees">Period To</label>
                <input class="custom-select " type="date" id="" name="DATE_TO" value="<?= $yearmonth_to ?>">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <?php
                $daysName = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                $count_date = 1;
                foreach ($daysName as $date) {
                ?>
                  <div class="form-group">
                    <label class="required" for="UPDT_SHIFT_<?= $count_date ?>"><?= $date ?>
                    </label>
                    <select name="UPDT_SHIFT_<?= $count_date ?>" id="updt_shift_<?= $count_date ?>" class="form-control">
                      <?php
                      if ($SHIFT_DATA) {
                        foreach ($SHIFT_DATA as $SHIFT_DATA_ROW) {
                      ?>
                          <option value="<?= $SHIFT_DATA_ROW->id . ',' . $date ?>"><?= $SHIFT_DATA_ROW->name; ?></option>
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
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="COUNT_DATE" id="COUNT_DATE" value=<?= $count_date ?>>
            <input type="hidden" name="UPDATE_ID" id="UPDATE_ID">
            <button type="submit" class='btn btn-primary text-light' id="save_button">&nbsp; Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php $this->load->view('templates/jquery_link'); ?>
  <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
  <script type="text/javascript" src="<?= base_url('assets_system/js/handsontable14.js') ?>"></script>
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
  <!-- <script src='https://printjs-4de6.kxcdn.com/print.min.js'></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script> -->
  <script>
    var url = '<?= base_url() ?>';
    var dispEmpList = <?php echo json_encode($DISP_EMP_LIST_DATA); ?>;
    // console.log('dispEmpList', dispEmpList);
    var dateRange = <?php echo json_encode($DATE_RANGE); ?>;
    var shiftData = <?php echo json_encode($SHIFT_DATA); ?>;
    var shiftDataDateRange = <?php echo json_encode($SHIFT_DATA_DATERANGE); ?>;

    // console.log('shiftDataDateRange', shiftDataDateRange)
    var hot;
    const shiftCode = shiftData.map(item => item.code);
    var combinedDateRange = dateRange.map(function(item) {
      return {
        date: item.Date.date.split(' ')[0],
        holi_type: item.holi_type
      };
    });

    console.log(shiftCode)
    const dateHeaders = combinedDateRange.map(item => item.date);
    const shiftIdToCodeMap = {};
    shiftData.forEach(item => {
      shiftIdToCodeMap[item.id] = item.code;
    });
    const shiftIdToColorMap = {};
    shiftData.forEach(item => {
      shiftIdToColorMap[item.id] = item.color;
    });
    const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
      Handsontable.renderers.TextRenderer.apply(this, arguments);
      td.style.whiteSpace = 'nowrap';
      td.style.overflow = 'hidden';
    };
    var customColorStyleRenderer;
    var combinedData = dispEmpList.map(function(empData) {
      var combinedRow = {
        id: empData.id,
        col_empl_cmid: empData.col_empl_cmid,
        full_name: empData.full_name
      };
      dateHeaders.forEach(function(dateHeader) {
        const shiftDataItem = shiftDataDateRange.find(item => item.date === dateHeader && item.empl_id === empData.id);
        if (shiftDataItem) {
          combinedRow[dateHeader] = shiftIdToCodeMap[shiftDataItem.shift_id];
          customColorStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.whiteSpace = 'nowrap';
            td.style.overflow = 'hidden';
            const dateHeader = dateHeaders[col - 3];
            const empData = dispEmpList[row];
            const shiftDataItem = shiftDataDateRange.find(
              item => item.date === dateHeader && item.empl_id === empData.id
            );
            if (shiftDataItem) {
              const shiftColor = shiftIdToColorMap[shiftDataItem.shift_id];
              if (shiftColor) {
                td.style.backgroundColor = shiftColor;
                // cellProperties.readOnly = true; // shift uneditable
              }
            }
          };
        } else {
          combinedRow[dateHeader] = '';
        }
      });
      return combinedRow;
    });
    const container = document.querySelector('#table_data');
    const colDateHeaders = dateHeaders.map(date => {
      const [year, month, day] = date.split('-');
      const dateObj = new Date(year, month - 1, day);
      const dayOfWeek = dateObj.toLocaleDateString('en-US', {
        weekday: 'short'
      });
      return `${day}/${month}/${year}(${dayOfWeek})`;
    });

    // console.log(combinedData)
    hot = new Handsontable(container, {
      data: combinedData,
      // colHeaders: ['Id', 'Employee Id', 'Name', ...dateHeaders],
      colHeaders: ['Id', 'Employee Id', 'Employee', ...colDateHeaders],
      rowHeaders: true,
      height: window.innerHeight - container.getBoundingClientRect().top - 30,
      rowHeights: 40,
      outsideClickDeselects: false,
      selectionMode: 'multiple',
      licenseKey: 'non-commercial-and-evaluation',
      renderer: customStyleRenderer,
      fixedColumnsStart: 3,
      hiddenColumns: {
        columns: [0, 1],
        indicators: true,
        copyPasteEnabled: false,
      },
      columns: [{
          data: 'id',
          readOnly: true
        },
        {
          data: 'col_empl_cmid',
          readOnly: true
        },
        {
          data: 'full_name',
          readOnly: true,
          width: 200
        },
        ...dateHeaders.map(dateHeader => ({
          data: dateHeader,
          type: 'dropdown',
          source: shiftCode,
          renderer: customColorStyleRenderer,
        }))
      ],
    });
    // hot.updateSettings({
    //   height: window.innerHeight - container.getBoundingClientRect().top - 50,
    // });
    var shift_update = document.getElementById('btn-update');
    hot.updateSettings({
      // height: window.innerHeight - shift_update.getBoundingClientRect().top - 50,
      // height: window.innerHeight - 100,
    });
    const employees = dispEmpList.map(item => item);
    const generatEmployeeWithDate = (employee) => {
      const {
        id,
        col_empl_cmid,
        full_name
      } = employee;
      return [id, col_empl_cmid, full_name, ...dateHeaders];
    };
    const employeeData = employees.map(employee => generatEmployeeWithDate(employee));
    shift_update.addEventListener('click', function() {
      const confirmed = confirm('Are you sure you want to update the data?');
      if (!confirmed) {
        return;
      }
      const updatedData = hot.getData();
      const requestData = {
        updatedData: updatedData,
        employeeData: employeeData
      };
      fetch(url + 'attendances/update_data', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(result => {
          if (result.success_message) {
            $(document).Toasts('create', {
              class: 'bg-success toast_width',
              title: 'Success!',
              subtitle: 'close',
              body: result.success_message
            })
          }
          if (result.warning_message) {
            $(document).Toasts('create', {
              class: 'bg-warning toast_width',
              title: 'Warning!',
              subtitle: 'close',
              body: result.warning_message
            })
          }
          location.reload();
        })
        .catch(error => {
          $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: 'Please provide all required information.'
          })
          console.error('Data update error:', error);
        });
    });
  </script>
  <script>
    $(document).ready(function() {
      $("#printButton").click(function() {
        printTable();
      });

      function printTable() {
        const dateFormat = /\d{4}-\d{2}-\d{2}/;
        // console.log('combinedData', combinedData);
        function segmentArray(array, segmentSize) {
          var segmentedArray = [];
          for (var i = 0; i < array.length; i += segmentSize) {
            segmentedArray.push(array.slice(i, i + segmentSize));
          }
          return segmentedArray;
        }
        var segmentSize = 10;
        var combinedArray = segmentArray(dateHeaders, segmentSize);
        let combinedPrintContents = ``
        combinedArray.forEach((item) => {
            let printTableHeader = ['full_name'];
            printTableHeader = printTableHeader.concat(item);
            // console.log('printTableHeader', printTableHeader);
            const sumOfColspan = printTableHeader.length;
            const currentDate = new Date();
            const months = [
              "January", "February", "March", "April", "May", "June",
              "July", "August", "September", "October", "November", "December"
            ];
            const month = months[currentDate.getMonth()];
            const day = currentDate.getDate();
            const year = currentDate.getFullYear();
            let hours = currentDate.getHours();
            const minutes = currentDate.getMinutes();
            const amOrPm = hours >= 12 ? "PM" : "AM";
            hours = hours % 12 || 12;
            const formattedDateTime = `${month} ${day}, ${year} at ${hours}:${minutes < 10 ? '0' : ''}${minutes} ${amOrPm}`;
            const fromPeriod = item[0];
            const toPeriod = item[item.length - 1];
            const name = `${fromPeriod} - ${toPeriod}`
            var printContents = ` 
                <table>
                    <thead>
                        <tr>
                          <th colspan="${sumOfColspan}">
                            <h5>Shift Assignment</h5>
                            <h6>Period: ${name}</h6>
                            <p>Print Date: ${formattedDateTime}</p>
                          </th>
                        </tr>
                        <tr>
                          ${printTableHeader.map(item => {
                            // if (item === 'col_empl_cmid')return `<th class="bg-gray-ben">ID</th>`
                            if (item === 'full_name')return `<th class="bg-gray-ben" style="width:180px">NAME</th>`
                            // if (dateFormat.test(item))return `<th class="text-vertical bg-gray-ben" >${convertDateFormat(item)}</th>`
                            return `<th class="bg-gray-ben" style="max-width:90px">${item}</th>`
                          }).join('')}
                        </tr>
                    </thead>
                    <tbody>
                      ${combinedData.map(item => `
                        <tr>
                          ${printTableHeader.map(key => {
                            if(!item[key]){
                                return (
                                `<td></td>`
                              )
                            }
                            return (
                              `<td style="max-width:90px">${item[key]}</td>`
          )
        }).join('')
    }
    `).join('')}
                    </tbody>
                </table>
          `; combinedPrintContents += '<div style="">' + printContents + '</div>';
    })
    // Apply styles for printing
    var styleSheet = '<style type="text/css">';
    styleSheet += '@page { margin: 10px 10px; size: landscape; }';
    styleSheet += 'th, td { border: 1px solid #dddddd; text-align: center; font-size: 9px !important}';
    // styleSheet += 'th {background-color: #f2f2f2;}';
    // styleSheet += '.text-vertical{writing-mode: vertical-rl;white-space: nowrap;}';
    styleSheet += '.text-vertical{writing-mode: vertical-rl;white-space: nowrap;transform: rotate(180deg);}';
    styleSheet += '.bg-gray-ben{background: #f2f2f2 !important;-webkit-print-color-adjust: exact;}';
    styleSheet += '</style>';
    scaledContents = styleSheet + combinedPrintContents;
    $("body").html(scaledContents);
    window.print();
    location.reload();
    }

    function convertDateFormat(originalFormat) {
      var dateComponents = originalFormat.split("-");
      var rearrangedFormat = dateComponents[2] + "/" + dateComponents[1] + "/" + dateComponents[0];
      return rearrangedFormat;
    }
    });
  </script>
  <script>

  let showOriginal = <?= isset($_GET["show"]) && $_GET["show"] == 1 ? 'true' : 'false' ?>;

  var base_url = '<?= base_url(); ?>';
// Remove the old toggleOriginal function and replace it with:

function toggleOriginal() {
    // Toggle the state
    showOriginal = !showOriginal;
    
    // Update button text immediately
    const button = document.getElementById('btnToggle');
    button.textContent = showOriginal ? 'Hide Original Schedule' : 'Show Original Schedule';
    
    // Call filter_data with the new state
    filter_data(null, showOriginal ? '1' : '0');
}

// Update the filter_data function to properly handle the show parameter:

function filter_data(page_row, showParam = null) {
    if (!page_row) {
        page_row = '?page=' + "<?= $current_page ?>" + '&row=' + "<?= $row ?>";
    }

    var yearmonth_from = $("#year-month1").val();
    var yearmonth_to = $("#year-month2").val();

    let branch = $("#filter_by_branch").val();
    let department = $("#filter_by_department").val();
    let division = $("#filter_by_division").val();
    let clubhouse = $("#filter_by_clubhouse").val();
    let section = $("#filter_by_section").val();
    let group = $("#filter_by_group").val();
    let team = $("#filter_by_team").val();
    let line = $("#filter_by_line").val();
    let status = $("#filter_by_status").val();
    let employee_id = $("#employee_id").val();

    // Build the filter URL
    let filterUrl = page_row + "&branch=" + branch +
        "&dept=" + department + "&division=" + division + "&clubhouse=" + clubhouse +
        "&section=" + section + "&group=" + group +
        "&team=" + team + "&line=" + line + "&status=" + status +
        "&yearmonth_from=" + yearmonth_from + "&yearmonth_to=" + yearmonth_to +
        "&search=" + employee_id;

    // Add show parameter if provided
    if (showParam !== null) {
        filterUrl += "&show=" + showParam;
    }

    // Redirect to the new URL
    window.location = base_url + "attendances/shift_assignment" + filterUrl;
}

// Also update the button initialization to show correct text based on current state
$(document).ready(function() {
    // Initialize button text based on current show parameter
    const showParam = "<?= isset($_GET['show']) ? $_GET['show'] : '0' ?>";
    const button = document.getElementById('btnToggle');
    button.textContent = showParam === '1' ? 'Hide Original Schedule' : 'Show Original Schedule';
});


    $(document).ready(function() {
      var base_url = '<?= base_url(); ?>';
      $('#btn-print').on('click', function() {
        var table = document.getElementById('TableToExport');
        html2canvas(table).then(function(canvas) {
          printJS({
            printable: canvas.toDataURL(),
            type: 'image',
            style: '@page { size: landscape; }'
          });
        })
      })
      $('#filter_by_branch').select2();
      $('#filter_by_department').select2();
      $('#filter_by_division').select2();
      $('#filter_by_clubhouse').select2();
      $('#filter_by_section').select2();
      $('#filter_by_group').select2();
      $('#filter_by_team').select2();
      $('#filter_by_line').select2();
      $('#employee_id').select2();
      $('#row_dropdown').on('change', function(e) {
        e.preventDefault()
        var row_val = $(this).val();
        let data = "?page=1&row=" + row_val;
        filter_data(data);
      });
      $('.page_row').on('click', function(e) {
        e.preventDefault()
        let page_row = $(this).attr('href');
        filter_data(page_row);
      })
      // $('#year-month1').on('change', function() {
      //   var row_val = $('#row_dropdown').val();
      //   var yearmonth_from = $(this).val();
      //   var yearmonth_to = $('#year-month2').val();
      //   document.location.href = base_url + "selfservices/my_time_records?page=1&row=" + row_val + "&yearmonth_from=" + yearmonth_from + "&yearmonth_to=" + yearmonth_to;
      // })
      // $("#year-month1").on("change", function() {
      //   filter_data();
      // })
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
      $("#filter_by_clubhouse").on("change", function() {
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
      $("#employee_id").on("change", function() {
        filter_data();
      })
      $("#filter_by_status").on("change", function() {
        filter_data();
      })
    
    function filter_data(page_row, showOriginal = false) 
    {

        if (!page_row) {
            page_row = '?page=' + "<?= $current_page ?>" + '&row=' + "<?= $row ?>";
        }

        var yearmonth_from = $("#year-month1").val();
        var yearmonth_to = $("#year-month2").val();

        let branch = $("#filter_by_branch").val();
        let department = $("#filter_by_department").val();
        let division = $("#filter_by_division").val();
        let clubhouse = $("#filter_by_clubhouse").val();
        let section = $("#filter_by_section").val();
        let group = $("#filter_by_group").val();
        let team = $("#filter_by_team").val();
        let line = $("#filter_by_line").val();
        let status = $("#filter_by_status").val();
        let employee_id = $("#employee_id").val();

        let filterUrl = page_row + "&branch=" + branch +
          "&dept=" + department + "&division=" + division + "&clubhouse=" + clubhouse +
          "&section=" + section + "&group=" + group +
          "&team=" + team + "&line=" + line + "&status=" + status +
          "&yearmonth_from=" + yearmonth_from + "&yearmonth_to=" + yearmonth_to +
          "&search=" + employee_id;

        if (showOriginal) {
            filterUrl += '&filter=1';
        }

        window.location = base_url + "attendances/shift_assignment" + filterUrl;
    }
    
      var employee_id = <?= json_encode($DISP_EMP_LIST_DATA) ?>;
      $('#update_shift').click(function() {
        let selected_id = employee_id.map(data => data.id);
        if (selected_id.length > 0) {
          $('.class_modal_update_list').prop('id', 'modela_update');
          $('#UPDATE_ID').val(selected_id);
          att_empl_names.forEach(function(data) {
            $('#update_list_id').append(`<li class="col-md-6"> <strong>${data}</strong></li>`);
          })
        } else {
          $('.class_modal_update_list').prop('id', '');
          Swal.fire(
            'No Active Employee!',
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
        // console.log(url);
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
        let employee = $(this).siblings("#employee_data").val();
        let shift_id = $(this).find(":selected").val();
        let date_data = $(this).siblings("#date_data").val();
        window.location = base_url + "attendances/process_assigning/" + employee + "/" + shift_id + "/" + date_data;
      })
      $("tr.data_table").on('click', function() {})
      $('#datetime').datetimepicker({
        format: 'hh:mm:ss a'
      });
      $('#timepicker').datetimepicker({
        format: 'LT'
      })
      $('#timepicker2').datetimepicker({
        format: 'LT'
      })
      var is_executed = false;
      $("#tbl_attendance").tablesorter();
      var locked_employees_arr = [];
      var unlocked_employees_arr = [];
    })
  </script>
  <script>
    function toggleFilter() {
      document.querySelector('.filter-container').classList.toggle('visible');
    }
  </script>
  <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
  <script></script>
</body>

</html>