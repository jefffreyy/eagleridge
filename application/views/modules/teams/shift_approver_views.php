<html>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?= base_url('assets_system/css/handsontable14.css') ?>" />

<style>
  .hover {
    cursor: pointer;
  }

  .img-circle {
    border-radius: 50% !important;
    width: 100px !important;
    height: 100px !important;
    object-fit: scale-down;
  }
</style>
<style>
  .check_approved {
    color: #3ec769;
    font-size: 18px;
  }

  th.std {
    min-width: 350px;
    font-size: 12px !important;
  }

  th.emp {
    min-width: 350px;
    font-size: 12px !important;
  }

  th.chk {
    min-width: 30px;
    font-size: 12px !important;
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

<body>

  <div class="content-wrapper">
    <div class="container-fluid p-4">
      <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'teams'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
            </a>&nbsp;Shift Approval Route <h1>
        </div>
        <div class="col-md-6 button-title d-flex justify-content-end">
          <button href="#" class=" btn btn-primary text-light shadow-none rounded mr-1" onclick="exportToExcel()" id="btn_export"><img style="margin-bottom: 5px;" src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">
            </i>Export XLSX</button>
          <button class=" btn btn-primary" id="btn-update"><img style="width: 16px; height: 16px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />
            Update</button>
        </div>
      </div>
      <hr>
      <div class="pb-1">

      </div>
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


      ?>

      <?php

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


      <div class=" filter-container <?= $filter ? 'visible' : '' ?>">
        <div class=" mb-4 d-flex row">
          <div class="col-md-2" <?php echo ($DISP_VIEW_BRANCH ? "" : "hidden") ?>>
            <p class="mb-1 text-secondary ">Branch</p>
            <select name="dept" id="filter_by_branch" class="form-control">
              <?php
              if ($DISP_DISTINCT_BRANCH) {
              ?>
                <option value="">All Branches</option>
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
                <option value="" <?php foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW_1) {
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
                <option value="" <?php foreach ($DISP_DISTINCT_DIVISION as $DISP_DISTINCT_DIVISION_ROW_1) {
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
                                <option value="" <?php foreach ($DISP_DISTINCT_CLUBHOUSE as $DISP_DISTINCT_CLUBHOUSE_ROW_1) {
                                                        if ($DISP_DISTINCT_CLUBHOUSE_ROW_1->name == '') {
                                                            echo 'selected';
                                                        }
                                                    } ?>>All Clubhouse</option>
                                <?php
                                foreach ($DISP_DISTINCT_CLUBHOUSE as $DISP_DISTINCT_CLUBHOUSE_ROW_1) {
                                    if ($DISP_DISTINCT_CLUBHOUSE_ROW_1->name != '') {
                                ?>
                                        <option value="<?= $DISP_DISTINCT_CLUBHOUSE_ROW_1->id ?>" <?php echo $param_clubhouse == $DISP_DISTINCT_CLUBHOUSE_ROW_1->id ? 'selected' : '' ?>>
                                            <?= $DISP_DISTINCT_CLUBHOUSE_ROW_1->name ?>
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
                <option value="" <?php foreach ($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW_1) {
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
                <option value="" <?php foreach ($DISP_DISTINCT_GROUP as $DISP_DISTINCT_GROUP_ROW_1) {
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
                <option value="" <?php foreach ($DISP_DISTINCT_TEAM as $DISP_DISTINCT_TEAM_ROW_1) {
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
                <option value="" <?php foreach ($DISP_DISTINCT_LINE as $DISP_DISTINCT_LINE_ROW_1) {
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
            <a href=<?= base_url() . "employees/approval_routes" ?> id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
          </div> -->
        </div>
      </div>

      <div class="card border-0 p-0 m-0">



        <div class="card border-0 p-0 m-0">
          <div class="p-2">
            <div class="">
              <div class="justify-content-between">
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <div class="d-flex row justify-content-between align-items-center">
                      <div class="row d-flex justify-content-center justify-content-lg-start col-12 col-lg-6 mx-1">
                        <label class="col-md-12 mb-1 p-0 text-secondary">Search Employee</label>
                        <select id="search_select" class="px-1 col-12 col-lg-4 employee_select form-control w-100 w-lg-50">
                          <?php
                          if ($DISP_EMP_LIST_SEARCH) {
                          ?>
                            <option value="all" <?php foreach ($DISP_EMP_LIST_SEARCH as $DISP_EMP_LIST_SEARCH_ROW_1) {
                                                  if ($DISP_EMP_LIST_SEARCH_ROW_1->name == '') {
                                                    echo 'selected';
                                                  }
                                                } ?>>All </option>
                            <?php
                            foreach ($DISP_EMP_LIST_SEARCH as $DISP_EMP_LIST_SEARCH_ROW) {
                              if ($DISP_EMP_LIST_SEARCH_ROW->name != '') {
                            ?>
                                <option value="<?= $DISP_EMP_LIST_SEARCH_ROW->id ?>" <?php echo $search == $DISP_EMP_LIST_SEARCH_ROW->id ? 'selected' : '' ?>>
                                  <?= $DISP_EMP_LIST_SEARCH_ROW->name ?>
                                </option>
                          <?php
                              }
                            }
                          }
                          ?>
                        </select>
                        <button id="btnFilter" class="btn btn-primary shadow-none rounded ml-1" onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg') ?>" style="margin-bottom: 1px" alt="" />&nbsp;Advance Filter</button>
                        <a href="<?= base_url('teams/shift_approver') ?>" id="btn_clear_filter" class="btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="" />&nbsp;Clear</a>
                      </div>


                    </div>

                  </div>

                </div>



              </div>
            </div>



          </div>

          <div class="row">
            <div class="col">
              <div class="table-responsive">
                <div  id="table_data_new"> </div>
                <!-- <div id="table_data" > </div> -->

              </div>
              <div class="d-block d-lg-none col-sm-7 col-md-10 col-lg-5 justify-content-lg-end justify-content-center my-lg-0 my-2">
                <div class="col-12 col-lg-7 d-flex justify-content-lg-end align-items-center mx-2">
                  <div class="d-flex align-items-center row">
                    <div class="d-inline col-12 col-lg-6">
                      <p class="p-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                    </div>
                    <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                      <ul class="pagination ml-0 ml-lg-4 m-0 p-0">
                        <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
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

              </div>

              <div class="col-12 col-lg-1 d-flex d-lg-none justify-content-center align-items-center">
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
    </div>

  </div>
  <!-- Content Ends -->

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
  <div class="modal fade class_modal_approval_list" id="modal_assign_approver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h4 class="modal-title ml-1" id="exampleModalLabel">Assign Approvers
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>
        <form action="<?php echo base_url(); ?>employees/assign_approvers_leave" id="form_updt_approvers" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <ul id="approval_list_id" class="row" style="background: #e7f4e4;"></ul>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="required " for="UPDT_APPROVER_1A">Approver 1-A
                  </label>
                  <select style='width:100%' class="form-control" name="approver_1a" id="updt_approver_1a">
                    <!-- <option value="">Choose Approver 1-A...</option> -->
                    <option value="0">N/A</option>
                    <?php
                    if ($DISP_EMPLOYEES_NONFILTERED) {
                      foreach ($DISP_EMPLOYEES_NONFILTERED as $DISP_EMPLOYEES_ROW) {
                    ?>
                        <option value="<?= isset($DISP_EMPLOYEES_ROW->id) ? $DISP_EMPLOYEES_ROW->id : '' ?>">
                            <?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?>
                        </option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required " for="UPDT_APPROVER_1B">Approver 1-B
                  </label>
                  <select name="approver_1b" id="updt_approver_1b" class="form-control" style='width:100%'>
                    <!-- <option value="">Choose Approver 1-B...</option> -->
                    <option value="0">N/A</option>
                    <?php
                    if ($DISP_EMPLOYEES_NONFILTERED) {
                      foreach ($DISP_EMPLOYEES_NONFILTERED as $DISP_EMPLOYEES_ROW) {
                    ?>
                        <option value="<?= isset($DISP_EMPLOYEES_ROW->id) ? $DISP_EMPLOYEES_ROW->id : '' ?>">
                            <?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?>
                        </option>                   
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required " for="UPDT_APPROVER_2A">Approver 2-A
                  </label>
                  <select name="approver_2a" id="updt_approver_2a" class="form-control" style='width:100%'>
                    <!-- <option value="">Choose Approver 2-A...</option> -->
                    <option value="0">N/A</option>
                    <?php
                    if ($DISP_EMPLOYEES_NONFILTERED) {
                      foreach ($DISP_EMPLOYEES_NONFILTERED as $DISP_EMPLOYEES_ROW) {
                    ?>
                        <option value="<?= isset($DISP_EMPLOYEES_ROW->id) ? $DISP_EMPLOYEES_ROW->id : '' ?>">
                            <?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?>
                        </option>                     
                     <?php
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group d-none">
                  <label class="required " for="UPDT_APPROVER_2B">Approver 2-B
                  </label>
                  <select name="approver_2b" id="updt_approver_2b" class="form-control" style='width:100%'>
                    <!-- <option value="">Choose Approver 2-B...</option> -->
                    <option value="0">N/A</option>
                    <?php
                    if ($DISP_EMPLOYEES_NONFILTERED) {
                      foreach ($DISP_EMPLOYEES_NONFILTERED as $DISP_EMPLOYEES_ROW) {
                        ?>
                        <option value="<?= isset($DISP_EMPLOYEES_ROW->id) ? $DISP_EMPLOYEES_ROW->id : '' ?>">
                            <?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?>
                        </option>                     
                     <?php
                      }
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="UPDT_APPROVER_3A">Approver 3-A
                  </label>
                  <select name="approver_3a" id="updt_approver_3a" class="form-control" style='width:100%'>
                    <!-- <option value="">Choose Approver 3-A...</option> -->
                    <option value="0">N/A</option>
                    <?php
                    if ($DISP_EMPLOYEES_NONFILTERED) {
                      foreach ($DISP_EMPLOYEES_NONFILTERED as $DISP_EMPLOYEES_ROW) {
                        ?>
                        <option value="<?= isset($DISP_EMPLOYEES_ROW->id) ? $DISP_EMPLOYEES_ROW->id : '' ?>">
                            <?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?>
                        </option>                     
                     <?php
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="UPDT_APPROVER_3B">Approver 3-B
                  </label>
                  <select name="approver_3b" id="updt_approver_3b" class="form-control" style='width:100%'>
                    <!-- <option value="">Choose Approver 3-B...</option> -->
                    <option value="0">N/A</option>
                    <?php
                    if ($DISP_EMPLOYEES_NONFILTERED) {
                      foreach ($DISP_EMPLOYEES_NONFILTERED as $DISP_EMPLOYEES_ROW) {
                        ?>
                        <option value="<?= isset($DISP_EMPLOYEES_ROW->id) ? $DISP_EMPLOYEES_ROW->id : '' ?>">
                            <?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?>
                        </option>                     
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
            <input type="hidden" name="empl_id" id="EMPLOYEE_ID">
            <input type="submit" id="" class='btn btn-primary text-light' value="Save">
            <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
          </div>
        </form>

      </div>
    </div>
  </div>


  <!-- jQuery -->
  <?php $this->load->view('templates/jquery_link'); ?>


  <!-- SESSION MESSAGES -->

  <?php
  if ($this->session->userdata('SESS_SUCC_MSG_INSRT_APPROVER')) {
  ?>
    <script>
      $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_APPROVER'); ?>'
      })
    </script>
  <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_APPROVER');
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
  <?php
  if ($this->session->userdata('SESS_ERR_MSG_INSRT_APPROVER')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_APPROVER'); ?>',
        '',
        'error'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_ERR_MSG_INSRT_APPROVER');
  }
  ?>


  <?php
  if ($this->session->userdata('SESS_ERR_MSG_UPDT_APPROVER')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_ERR_MSG_UPDT_APPROVER'); ?>',
        '',
        'success'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_ERR_MSG_UPDT_APPROVER');
  }
  ?>
  <?php
  if ($this->session->userdata('SESS_ERR_MSG_DLT_APPROVER')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_ERR_MSG_DLT_APPROVER'); ?>',
        '',
        'success'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_ERR_MSG_DLT_APPROVER');
  }
  ?>
  <?php
  if ($this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE'); ?>',
        '',
        'success'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_REJECT_LEAVE');
  }
  ?>
  <?php
  if ($this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE'); ?>',
        '',
        'success'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_APPROVE_LEAVE');
  }
  ?>

  <?php

  function convert_data($array, $id)
  {
    $name = "";
    if ($id != "N/A") {
      foreach ($array as $row) {
        if ($row->id == $id) {
          $name = $row->col_last_name . ' ' . $row->col_frst_name . ' ' . $row->col_midl_name;
        } elseif ($id == 0) {
          $name = "";
        }
      }
    } else {
      $name = "";
    }
    return $name;
  }

  function convert_img($array, $id)
  {
    $img = "";
    foreach ($array as $row) {
      if ($row->id == $id) {
        $img = $row->col_imag_path;
      }
    }
    return $img;
  }

  function convert_cmid($array, $id)
  {
    $cmid = "";
    foreach ($array as $row) {
      if ($row->id == $id) {
        $cmid = $row->col_empl_cmid;
      }
    }
    return $cmid;
  }



  ?>

  <script>
    $(document).ready(function() {
      $('#search_select').select2();
      $("#search_select").on("change", function() {
        search();
      });
    });

    function search() {
      let search_select = $("#search_select").find(":selected").val();
    //   console.log('search_select', search_select);
      if (!search_select) return;
      if (search_select == 'all') {
        filter_clear();
      } else {
        if (document.querySelector('.filter-container').classList.contains('visible')) {
          window.location.href = "?search=" + search_select.replace(/\s/g, '_') + '&filter=1';
        } else {
          window.location.href = "?search=" + search_select.replace(/\s/g, '_');
        }

      }
    }

    function filter_clear() {
      document.location.href = "approval_routes";
    }
  </script>

  <script>
    $(document).ready(function() {




      $('#approval').click(function() {
        let selected_id = [];
        let selected_att_id = [];
        let selected_empl_id = [];
        $('#APPROVAL_ID').empty();
        $('#approval_list_id').empty();
        $('#select_item input[type=checkbox]:checked').each(function() {
          let selected_item = $(this).val();
          let att_approval_id = $(this).attr('approval_id');
          let att_empl_id = $(this).attr('employee_id');
          selected_id.push(selected_item);
          selected_att_id.push(att_approval_id);
          selected_empl_id.push(att_empl_id);
        })

        if (selected_id.length > 0) {
          $('.class_modal_approval_list').prop('id', 'modal_assign_approver');
          let approval_ids = selected_id.join(',');
          let empl_ids = selected_empl_id.join(',');
          $('#APPROVAL_ID').val(approval_ids);
          $('#EMPLOYEE_ID').val(empl_ids);
          selected_empl_id.forEach(function(data) {
            $('#approval_list_id').append(`<li class="col-md-6">Employee ID: <strong>${data}</strong></li>`);
          })
        } else {
          $('.class_modal_approval_list').prop('id', '');
          Swal.fire(
            'Please Select Employee!',
            '',
            'warning'
          )
        }

      })

      $('#filter_by_department').select2();
      $('#filter_by_division').select2();
      $('#filter_by_clubhouse').select2();
      $('#filter_by_section').select2();
      $('#filter_by_group').select2();
      $('#filter_by_team').select2();
      $('#filter_by_line').select2();

      $('#updt_approver_1a').select2();
      $('#updt_approver_1b').select2();
      $('#updt_approver_2a').select2();
      $('#updt_approver_2b').select2();
      $('#updt_approver_3a').select2();
      $('#updt_approver_3b').select2();




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


      // $("#search_btn").on("click", function() {
      //   $('#search_data').val();
      //   var optionValue = $('#search_data').val();
      //   var url = window.location.href.split("?")[0];
      //   if (window.location.href.indexOf("?") > 0) {
      //     window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
      //   } else {
      //     window.location = url + "?page=1&all=" + optionValue.replace(/\s/g, '_');
      //   }
      // })

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


      var base_url = '<?= base_url(); ?>';

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


      function filter_data(page_row) {
        if (page_row == null || page_row == "") {
          page_row = '?page=' + "<?= $current_page ?>" + '&row=' + "<?= $row ?>"
        }
        let cut_off = $("#cutoff_period").find(":selected").val();

        let branch = $("#filter_by_branch").find(":selected").val();
        let department = $("#filter_by_department").find(":selected").val();
        let division = $("#filter_by_division").find(":selected").val();
        let clubhouse = $("#filter_by_clubhouse").find(":selected").val();
        let section = $("#filter_by_section").find(":selected").val();
        let group = $("#filter_by_group").find(":selected").val();
        let team = $("#filter_by_team").find(":selected").val();
        let line = $("#filter_by_line").find(":selected").val();

        let status = $("#filter_by_status").find(":selected").val();

        filterUrl = page_row + "&branch=" + branch +
          "&dept=" + department + "&division=" + division + "&clubhouse=" + clubhouse +
          "&section=" + section + "&group=" + group +
          "&team=" + team + "&line=" + line;

        if (document.querySelector('.filter-container').classList.contains('visible')) {
          filterUrl = filterUrl + '&filter=1';
        }

        window.location = base_url + "teams/shift_approver" + filterUrl;
      }




      setTimeout(() => {
        // ===================== ACTIVATE DATATABLE PLUGIN =======================
        var empl_tbl = $('#for_approval_tbl').DataTable({
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
        $('#for_approval_tbl_filter').parent().parent().hide();
      }, 1500);

      // $("#filter_by_status").change(function() {
      //     var filter_stat = document.getElementById("filter_by_status");
      //     document.location.href = "approval_routes?"+ "status=" + filter_stat.value;
      // })

      $('#btn_clear_filter').click(function() {

        $("#filter_by_division").val("");
        $("#filter_by_clubhouse").val("");
        $("#filter_by_branch").val("");
        $("#filter_by_team").val("");
        $("#filter_by_status").val("");
        $("#filter_by_line").val("");
        $("#filter_by_group").val("");
        $("#filter_by_section").val("");
        $("#filter_by_department").val("");
        document.location.href = "approval_routes";
      })


      // Get & Display Data to Edit Modal Using Async JS function
      var url_get_approval_route_leave = '<?php echo base_url(); ?>approval/get_approval_route_leave';
      var url_save_group_approvers_leave = '<?php echo base_url(); ?>approval/save_group_approvers_leave';
      $('#APPROVAL_UPDT').click(function() {
        get_approval_route_leave(url_get_approval_route_leave, $(this).attr('approval_id')).then(data => {
          if (data.length > 0) {
            data.forEach((x) => {
              $('#UPDT_APPROVAL_ID').val(x.id);
              $('#UPDT_APPROVER_1A').val(x.approver_1a);
              $('#UPDT_APPROVER_1B').val(x.approver_1b);
              $('#UPDT_APPROVER_2A').val(x.approver_2a);
              $('#UPDT_APPROVER_2B').val(x.approver_2b);
              $('#UPDT_APPROVER_3A').val(x.approver_3a);
              $('#UPDT_APPROVER_3B').val(x.approver_3b);
            });
          }
        });
      })
      $('#btn_save_group_approvers').click(function() {
        $('#btn_save_group_approvers').hide();
        $('.loading_indicator').show();
        var count = 0;
        Array.from($('.row_group_approvers')).forEach(function(e) {
          var group_name = $(e).find('.group_name').text();
          var appr1_id = $(e).find('.group_approver1').val();
          var appr2_id = $(e).find('.group_approver2').val();
          save_group_approvers_leave(url_save_group_approvers_leave, group_name, appr1_id, appr2_id).then(function(data) {
            // console.log(data);
            count++;
            if (count == $('.row_group_approvers').length) {
              location.reload();
            }
          })
        })
      })
      $('#updt_approval_route').click(function() {
        $('#updt_approval_route').hide();
        $('.loading_indicator_appr2_appr3').show();
        $('#form_updt_approvers').submit();
      })
      async function save_group_approvers_leave(url, group_name, appr1_id, appr2_id) {
        var formData = new FormData();
        formData.append('group_name', group_name);
        formData.append('appr1_id', appr1_id);
        formData.append('appr2_id', appr2_id);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }
      async function get_approval_route_leave(url, approval_id) {
        var formData = new FormData();
        formData.append('approval_id', approval_id);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }
      // Delete Position
      $('.APPROVAL_DLT').click(function(e) {
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
            window.location.href = "<?= base_url(); ?>approval/dlt_approval_route?delete_id=" + user_deleteKey;
          }
        })
      })
    })
  </script>
  <!--modal basic info reporting, directs starts  -->
  <script>
    var baseUrl = '<?= base_url() ?>';
    let companyHide = false;
    var companySettings = <?php echo json_encode($DISP_VIEW_COMPANY); ?>;
    var companySettingsNumber = parseInt(companySettings);
    if (!isNaN(companySettingsNumber) && companySettingsNumber < 1) companyHide = true;
    let branchHide = false;
    var branchSettings = <?php echo json_encode($DISP_VIEW_BRANCH); ?>;
    var branchSettingsNumber = parseInt(branchSettings);
    if (!isNaN(branchSettingsNumber) && branchSettingsNumber < 1) branchHide = true;
    let departmentHide = false;
    var departmentSettings = <?php echo json_encode($DISP_VIEW_DEPARTMENT); ?>;
    var departmentSettingsNumber = parseInt(departmentSettings);
    if (!isNaN(departmentSettingsNumber) && departmentSettingsNumber < 1) departmentHide = true;
    async function directs(employeeId) {
      if (employeeId) {
        document.getElementById("modalLoading").style.display = "block";
        $('#modalDirects').modal('show');
        const apiUrl = baseUrl + 'selfservices/get_reporting_to_directives';
        const data = {
          employeeId
        };
        // console.log('data', data);
        fetch(apiUrl, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
          })
          .then(response => response.json())
          .then(result => {
            // console.log('result', result)
            document.getElementById("modalLoading").style.display = "none";
            document.getElementById("employeeCompany").style.display = 'block';
            document.getElementById("employeeBranchDepartment").style.display = 'block';
            let employeeImage = `${baseUrl}/assets_user/user_profile/${result.data.employeeInfo?.col_imag_path}`;
            if (!result.data.employeeInfo?.col_imag_path) employeeImage = `${baseUrl}/assets_system/images/default_user.jpg`;
            document.getElementById('employee_img').src = employeeImage;
            let employeeMiddleInitial = result.data.employeeInfo?.col_midl_name?.charAt(0);
            if (employeeMiddleInitial) {
              `${employeeMiddleInitial}.`
            } else {
              employeeMiddleInitial = '';
            }
            let employeeFirstName = result.data.employeeInfo?.col_frst_name;
            if (!employeeFirstName) employeeFirstName = '';
            let employeeLastName = result.data.employeeInfo?.col_last_name;
            if (!employeeLastName) employeeLastName = '';
            if (employeeLastName || employeeFirstName || employeeMiddleInitial) {
              document.getElementById("employeeFullName").textContent = `${employeeLastName}, ${employeeFirstName} ${employeeMiddleInitial}`;
            } else {
              document.getElementById("employeeFullName").textContent = '(No Full Name)'
            }
            if (result.data.employeeInfo?.col_empl_cmid) {
              document.getElementById("employeeNumber").textContent = `${result.data.employeeInfo.col_empl_cmid}`;
            } else {
              document.getElementById("employeeNumber").textContent = '(No Employee Number)'
            }
            if (result.data.employeeInfo?.col_empl_posi) {
              document.getElementById("employeePosition").textContent = `${result.data.employeeInfo.col_empl_posi}`;
            } else {
              document.getElementById("employeePosition").textContent = '(No Position)'
            }
            if (result.data.employeeInfo?.col_empl_company) {
              document.getElementById("employeeCompany").textContent = `${result.data.employeeInfo.col_empl_company}`;
            } else {
              document.getElementById("employeeCompany").textContent = '(No Company)'
            }
            if (companyHide) document.getElementById("employeeCompany").style.display = 'none';
            branch = result.data.employeeInfo?.col_empl_branch;
            inBetween = ` \\ `;
            department = result.data.employeeInfo?.col_empl_dept;
            if (!branch || branchHide) branch = '';
            if (!department || departmentHide) department = '';
            if (branchHide || departmentHide || !branch || !department) inBetween = '';
            if (branch || department) {
              document.getElementById("employeeBranchDepartment").textContent = `${branch}${inBetween}${department}`;
            } else {
              if (branchHide && !departmentHide) {
                document.getElementById("employeeBranchDepartment").textContent = '(No Department)';
              } else if (departmentHide && !branchHide) {
                document.getElementById("employeeBranchDepartment").textContent = '(No Branch)';
              } else if (!branchHide && !departmentHide) {
                document.getElementById("employeeBranchDepartment").textContent = '(No Branch / No Department)';
              } else {
                document.getElementById("employeeBranchDepartment").textContent = ''
              }
            }
            if (result.data.employeeInfo?.col_comp_emai) {
              document.getElementById("employeeEmail").textContent = `${result.data.employeeInfo.col_comp_emai}`;
            } else {
              document.getElementById("employeeEmail").textContent = '(No Email)'
            }
            let reportingToMiddleInitial = result.data.reportingTo?.col_midl_name?.charAt(0);
            if (reportingToMiddleInitial) {
              reportingToMiddleInitial = `${reportingToMiddleInitial}.`;
            } else {
              reportingToMiddleInitial = '';
            }
            let reportingToLastName = result.data.reportingTo?.col_last_name;
            if (!reportingToLastName) reportingToLastName = '';
            let reportingToFirstName = result.data.reportingTo?.col_frst_name;
            if (!reportingToFirstName) reportingToFirstName = '';
            let reportingToImage = "<?= base_url() ?>/assets_system/images/default_user.jpg";
            if (result.data.reportingTo?.col_imag_path)
              reportingToImage = `${baseUrl}/assets_user/user_profile/${result.data.reportingTo.col_imag_path}`;
            if (reportingToLastName || reportingToFirstName) {
              let reportingFullName = `${reportingToLastName}, ${reportingToFirstName} ${reportingToMiddleInitial}`;
              document.getElementById("reportingToContainer").textContent = "";
              document.getElementById("reportingToContainer").innerHTML =
                `<img class="img-circle rounded-circle avatar elevation-2" 
                style="cursor: pointer;width:50px !important;height:50px !important" data-toggle="tooltip" 
                data-placement="right" title="Reporting To" 
                src="${reportingToImage}">
              <div class="mx-2">
                <p class="p-0 m-0" style="line-height: 1;font: size 13px;font-weight:500;">${reportingFullName}</p>
              </div>`;
            } else {
              document.getElementById("reportingToContainer").innerHTML = '(No Redirect To)'
            }
            var directsParent = document.getElementById("directsParent");

            // console.log('directs condition', Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0)
            if (Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0) {
              directsParent.innerHTML = '';
              result.data.directsTo.forEach(function(user) {
                let directMiddleInitial = `${user.col_midl_name.charAt(0)}.`
                if (!directMiddleInitial) directMiddleInitial = null;
                const directFullName = `${user.col_last_name}, ${user.col_frst_name} ${directMiddleInitial}`;
                let directImage = `${baseUrl}/assets_system/images/default_user.jpg`;
                if (user.col_imag_path) {
                  directImage = `${baseUrl}/assets_user/user_profile/${user.col_imag_path}`;
                }
                var div = document.createElement("div");
                div.className = "d-flex align-items-center";
                div.innerHTML = `
                <div  class="d-flex align-items-center mb-2">
                  <img class="img-circle rounded-circle avatar elevation-2" 
                    id="directsToPhoto" style="cursor: pointer;width:50px !important;height:50px !important" 
                    data-toggle="tooltip" data-placement="right" title="Reporting To" 
                    src="${directImage}">
                  <div class="mx-2">
                    <p id="direcstToName" class="p-0 m-0" style="line-height: 1;font: size 13px;">${directFullName}</p>
                  </div>
                </div>
                `;
                directsParent.appendChild(div);
              });
            } else {
              directsParent.innerHTML = '(No Directs)';
            }
            if (result.errorMessage) {
              $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: 'Unexpected Error Occured Fetching Data'
              })
            }
          })
          .catch(error => {
            document.getElementById("modalLoading").style.display = "none";
            $(document).Toasts('create', {
              class: 'bg-warning toast_width',
              title: 'Warning!',
              subtitle: 'close',
              body: 'Unexpected Error Occured Fetching Data..'
            })
            console.error('Data update error:', error);
          });

        // document.getElementById('employee_img').src = `${baseUrl}/assets_system/images/default_user.jpg`;
        // assets_user/user_profile/' . $user_image;
      } else {
        $('#modalDirects').modal('show');
        document.getElementById('employee_img').src = `${baseUrl}/assets_system/images/default_user.jpg`;
        document.getElementById("employeeFullName").textContent = '(No Full Name)';
        document.getElementById("employeeNumber").textContent = '(No Employee Number)';
        document.getElementById("employeePosition").textContent = '(No Position)';
        document.getElementById("employeeCompany").style.display = 'none';
        document.getElementById("employeeBranchDepartment").style.display = 'none';
        document.getElementById("employeeEmail").textContent = '(No Email)';
        document.getElementById("reportingToContainer").innerHTML = '(No Redirect To)';
        document.getElementById("directsParent").innerHTML = '(No Directs)';
      }
    }
  </script>
  <!--modal basic info reporting, directs ends  -->

  <!-- HandsonTable starts -->
  <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
  <script type="text/javascript" src="<?= base_url('assets_system/js/handsontable14.js') ?>"></script>

  <script>
    var url                 = '<?= base_url() ?>';
    var data_approvers      = <?php echo json_encode($DISP_APPROVERS); ?>;
    var employeeList        = <?php echo json_encode($DISP_EMPLOYEES_NONFILTERED); ?>;
    var departments        = <?php echo json_encode($DISP_DEPARTMENTS); ?>;

    // console.log('data_approvers ', data_approvers);   
    var nestedHeaders = [];
    hiddenColumns = {};

    let department = departments.map(function(item){
    return item.name;
  });
    // (function() {

      let employeeIdsCopywithCMID = [];

      const employeeIds = employeeList.map(obj => {
        let employeeNameWithCMID = '';
        if (obj.col_empl_cmid) employeeNameWithCMID = `${obj.col_empl_cmid}`;
        if (obj.col_last_name) employeeNameWithCMID = `${obj.col_empl_cmid}-${obj.col_last_name}`;
        if (obj.col_suffix) employeeNameWithCMID = `${employeeNameWithCMID} ${obj.col_suffix}`;
        if (obj.col_frst_name) employeeNameWithCMID = `${employeeNameWithCMID}, ${obj.col_frst_name}`;
        if (obj.col_midl_name) employeeNameWithCMID = `${employeeNameWithCMID} ${obj.col_midl_name[0]}.`;
        // let employeeNameWithCMID = `${lastnameSuffix}, ${obj.col_suffix}`;
        // const employeeNameWithCMID = `${obj.col_empl_cmid}-${obj.col_last_name}, ${obj.col_frst_name} ${obj.col_midl_name.charAt(0).padEnd(2, '.')}`
        employeeIdsCopywithCMID.push({
          employeeNameWithCMID: employeeNameWithCMID,
          cmid: obj.col_empl_cmid
        })
        return employeeNameWithCMID;
      });
         
    let employeeIdswithCMID = employeeIdsCopywithCMID.map(function(item){
        return item.employeeNameWithCMID;
    });

    let data = [{
        id: '',
        col_empl_cmid: '',
        fullname: '',
        prepared_by: '',
        checked_by: '',
        noted_by: '',
    }];
    
    var combinedData = employeeList.map(function(employee) {

        var data_approver = data_approvers.find(function (item) {
           
            return item.id === employee.id;
        });
        
        return {
        id: employee.id,
        col_empl_cmid: employee.col_empl_cmid,
        fullname: employee.fullname,
        prepared_by: data_approver ? data_approver.prepared_by : '',
        checked_by: data_approver ? data_approver.checked_by : '',
        noted_by: data_approver ? data_approver.noted_by : '',
        };
    });


      // console.log('employeeIds',employeeIds);
      // console.log('employeeIdsCopywithCMID',employeeIdsCopywithCMID);
      const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.whiteSpace = 'nowrap';
        td.style.overflow = 'hidden';
        td.style.backgroundColor = '#f9f9f9'; 

      };
      const customCheckboxRenderer = function(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.CheckboxRenderer.apply(this, arguments);
        td.style.textAlign = 'center';
        td.style.verticalAlign = 'middle';
      };

      let headerTable = [];
      let subHeaderTable = ['id', 'Employee', 'Auto Approve'];
      let columnTable = [];


    if (combinedData && Array.isArray(combinedData) && combinedData.length > 0) {
        data = combinedData;
    }

    const container = document.querySelector('#table_data_new');
    hot = new Handsontable(container, {
        data,
        colHeaders: ['ID', 'Employee ID', 'Employee Name', 'Prepared by', 'Checked by', 'Noted by'],
        readOnly: false,
        rowHeaders: true,
        height: window.innerHeight - container.getBoundingClientRect().top - 30,
        outsideClickDeselects: false,
        selectionMode: 'multiple',
        licenseKey: 'non-commercial-and-evaluation',
        renderer: customStyleRenderer_new,
        hiddenColumns: {
            columns: [0],
        },
        stretchH: 'all',
        columns: [
            { data: 'id', readOnly: true },
            { data: 'col_empl_cmid', readOnly: true },
            { data: 'fullname', readOnly: true },
            { data: 'prepared_by',  type: 'dropdown', source: employeeIdswithCMID },
            { data: 'checked_by',  type: 'dropdown', source: employeeIdswithCMID },
            { data: 'noted_by',  type: 'dropdown', source: employeeIdswithCMID },
     
        ],

    });         
   
      
      var update_data = document.getElementById('btn-update');
      update_data.addEventListener('click', function() {
        const confirmed = confirm('Are you sure you want to update the data?');
        if (!confirmed) {
          return;
        }
        let invalidId = false;
        const updatedData = hot.getData();

        updatedData.map((item) => {
          if (item[3]) {
            const check = employeeIdsCopywithCMID.find(obj => obj.employeeNameWithCMID === item[3]);
            if (check) {
              item[3] = check.cmid;
            } else {
              invalidId = true
            }
          }
          if (item[4]) {
            const check = employeeIdsCopywithCMID.find(obj => obj.employeeNameWithCMID === item[4]);
            if (check) {
              item[4] = check.cmid;
            } else {
              invalidId = true
            }
          }
          if (item[5]) {
            const check = employeeIdsCopywithCMID.find(obj => obj.employeeNameWithCMID === item[5]);
            if (check) {
              item[5] = check.cmid;
            } else {
              invalidId = true
            }
          }

        })

        if (invalidId) {
          return $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: 'Invalid ID Detected, check Approvers in Red Font'
          })
        }

        // console.log('updatedData', updatedData); return;
        const apiUrl = url + 'teams/update_shift_approval';
        const data = {
          updatedData,
        };
        // console.log('data', data);
        fetch(apiUrl, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
          })
          .then(response => response.json())
          .then(result => {
            //   console.log('result', result);
            //   return;
            if (result.success_message) {
              $(document).Toasts('create', {
                class: 'bg-success toast_width',
                title: 'Success!',
                subtitle: 'close',
                body: result.success_message,
                onHidden: function() {
                  alert('test toast callback');
                  // location.reload();
                }
              })
            }
            if (result.error_message) {
              $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: result.error_message
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
    // })();
  </script>
  <!-- HandsonTable ends -->

  <!-------------------- Export ----------------->
  <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function() {
      /* Create worksheet from HTML DOM TABLE */
      var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
      /* Export to file (start a download) */
      XLSX.writeFile(wb, "Approval_Route.xlsx");
    });
  </script> -->
  <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
  <script src="<?= base_url() ?>assets_system/js/xlsx.full.min.js"></script>
  <script>
    function exportToExcel() {
    //   console.log('nestedHeaders', nestedHeaders);
      const allHeaders = nestedHeaders[1];
      const visibleColumnIndices = allHeaders
        .map((_, index) => index)
        .filter(index => !hiddenColumns.columns.includes(index) && index !== 0);

      const visibleHeaders = visibleColumnIndices.map(index => allHeaders[index]);

      const visibleData = hot.getData().map(row =>
        row.filter((_, colIndex) => !hiddenColumns.columns.includes(colIndex) && colIndex !== 0)
      );
      var wb = XLSX.utils.book_new();
      // var ws = XLSX.utils.aoa_to_sheet(data);
      // console.log('visibleHeaders', visibleHeaders);
      var currentDate = new Date();
      var monthNames = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
      ];
      var formattedDate = currentDate.getDate() + '-' + monthNames[currentDate.getMonth()] + '-' + currentDate.getFullYear();
    //   console.log(formattedDate);

      const ws = XLSX.utils.aoa_to_sheet([visibleHeaders, ...visibleData]);
      XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
      XLSX.writeFile(wb, `approvers_${formattedDate}.xlsx`);
    }
  </script>

  <script>
    function toggleFilter() {
      document.querySelector('.filter-container').classList.toggle('visible');
    }
  </script>
</body>

</html>