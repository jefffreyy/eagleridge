  <html>
  <?php $this->load->view('templates/css_link'); ?>
  <style>
    
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
    table td, 
    table th {
        white-space: wrap !important;
        
    }
  </style>
  <?php
  $search_data = $this->input->get('all');
  $search_data = str_replace("_", " ", $search_data);

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
  <div class="content-wrapper">
    <div class="container-fluid p-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url() ?>attendances">Attendance</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Overtime Approval Route
          </li>
        </ol>
      </nav>
      <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title">Approval Route - Overtime / Time Adjustment<h1>
        </div>
        <div class="col-md-6 button-title">
          <!-- <a href="<?= base_url() . 'attendances/add_approval' ?>" class=" btn technos-button-green shadow-none rounded" id=""><i class="fas fa-plus-circle"></i>&nbsp;Add Approval</a> -->
          <a href="<?= base_url() . 'attendances/csv_import' ?>" class=" btn technos-button-green shadow-none rounded" id=""><i class="fas fa-file-import"></i>&nbsp;Bulk Import</a>
          <a href="#" class=" btn technos-button-gray shadow-none rounded" id="btn_export"><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>
        </div>
      </div>
      <hr>



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
          <a href=<?= base_url() . "attendances/approval_routes" ?> id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
        </div>

      </div> <!-- filter divs ends -->
      <div class="card border-0 p-0 m-0">
        <div class="p-1">
          <!-- <div class="card-header p-0">
            <ul class="nav nav-tabs">

              <li class="nav-item">
                <a class="nav-link head-tab " id="" href="">Active<span class="ml-2 badge badge-pill badge-secondary">7</span></a>
              </li>

            </ul>
          </div> -->
          <div class="col-md-4 pl-0">
            <div class="input-group p-1 pt-2">
              <?php 
                if($search_data){ ?>
                  <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
              <?php } else{?>
                  <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
              <?php } ?>
              
              <input type="text" class="form-control" placeholder="Search" value="<?= ($search_data) ? $search_data : ""; ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
            </div>
          </div>
         
        </div>

        <div class="card border-0 p-0 m-0">

          <div class="p-2">
            <a href="#" class=" btn technos-button-gray shadow-none rounded" id="approval" data-toggle="modal" data-target="#modal_assign_approver"><i class="far fa-check-circle"></i>&nbsp;Update Approvers</a>
            <div class="float-right ">

              <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
              <ul class="d-inline pagination m-0 p-0 ">
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
          <div class="table-responsive">
            <table class="table table-bordered m-0" id="TableToExport" style="width:100%">
              <thead>
                <tr>
                  <th rowspan="2" class="text-center chk"><input type="checkbox" name="check_all" id="check_all"></th>
                  <th rowspan="2" class="text-center emp col-6">Employee</th>
                  <th colspan="2" class="text-center ">Approver 1</th>
                  <th colspan="2" class="text-center ">Approver 2</th>
                  <th colspan="2" class="text-center">Approver 3</th>
                  <!-- <th rowspan="2" class="text-center" style="vertical-align: middle; border-bottom: 1px solid #e1e1e1 !important;">Action</th> -->

                </tr>
                <tr>
                  <th class="text-center std">Approver 1A</th>
                  <th class="text-center std">Approver 1B</th>
                  <th class="text-center std">Approver 2A</th>
                  <th class="text-center std">Approver 2B</th>
                  <th class="text-center std">Approver 3A</th>
                  <th class="text-center std">Approver 3B</th>
                </tr>
              </thead>
              <tbody id="tbl_application_container">


                <?php if ($DISP_APPROVER) {
                  foreach ($DISP_APPROVER as $DISP_APPROVER_ROW) { ?>
                    <tr>
                      <td class="text-center" id="select_item">
                        <input type="checkbox" name="approval_name" class="check_single" approval_id="<?= convert_cmid($DISP_EMPLOYEES, $DISP_APPROVER_ROW["id"]) ?>" row_id="" value="<?= $DISP_APPROVER_ROW["id"] ?>">
                      </td>


                      <td>
                      <?= convert_cmid($DISP_EMPLOYEES, $DISP_APPROVER_ROW["id"]) . " - " . convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["id"]) ?> 
                      </td>

                      <td><a><?= convert_cmid($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver1A"]) . " - " . convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver1A"]) ?></a></td>
                      <td><a><?= convert_cmid($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver1B"]) . " - " . convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver1B"]) ?></a></td>
                      <td><a><?= convert_cmid($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver2A"]) . " - " . convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver2A"]) ?></a></td>
                      <td><a><?= convert_cmid($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver2B"]) . " - " . convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver2B"]) ?></a></td>
                      <td><a><?= convert_cmid($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver3A"]) . " - " . convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver3A"]) ?></a></td>
                      <td><a><?= convert_cmid($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver3B"]) . " - " . convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver3B"]) ?></a></td>

                      <!-- <td style="width:15%" class="text-center">
                        <a class="select_row p-2" href="" style="color: gray; " row_id=""><i class="far fa-eye"></i></a>
                        <a class="select_edit_row p-2" href="" style="color: gray; " row_id=""><i class="far fa-edit"></i></a>
                        <a class="delete_data p-2 " style="color: gray !important" delete_key=""><i class="far fa-trash-alt" hidden></i></a>
                      </td> -->
                    </tr>
                  <?php
                  }
                } else {
                  ?>
                  <tr class="table-active">
                    <td colspan="12">
                      <center>No Data</center>
                    </td>
                  </tr>
                <?php  } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- ================================================================ new design End here ======================================================= -->

  <aside class="control-sidebar control-sidebar-dark">
  </aside>


  <div class="modal fade  class_modal_approval_list" id="modal_assign_approver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h4 class="modal-title ml-1" id="exampleModalLabel">Update Approvers
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>
        <form action="<?php echo base_url('attendances/assign_approvers_ot_adj'); ?>" id="FORM_REJECT_LEAVE" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <ul id="approval_list_id" class="row" style="background: #e7f4e4;"></ul>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="required " for="UPDT_APPROVER1a">Approver 1-A
                  </label>
                  <select name="UPDT_APPROVER1a" id="updt_approver_1a" class="form-control" style="width: 100%;" required>
                    <!-- <option value="">Choose Approver 1-A...</option> -->
                    <option value="0">N/A</option>
                    <?php
                    if ($DISP_EMPLOYEES_NONFILTERED) {
                      foreach ($DISP_EMPLOYEES_NONFILTERED as $DISP_EMPLOYEES_ROW) {
                    ?>
                        <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required " for="UPDT_APPROVER1b">Approver 1-B
                  </label>
                  <select name="UPDT_APPROVER1b" id="updt_approver_1b" class="form-control" style="width: 100%;" required>
                    <!-- <option value="">Choose Approver 1-B...</option> -->
                    <option value="0">N/A</option>
                    <?php
                    if ($DISP_EMPLOYEES_NONFILTERED) {
                      foreach ($DISP_EMPLOYEES_NONFILTERED as $DISP_EMPLOYEES_ROW) {
                    ?>
                        <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required " for="UPDT_APPROVER_2a">Approver 2-A
                  </label>
                  <select name="UPDT_APPROVER2a" id="updt_approver_2a" class="form-control" style="width: 100%;" required>
                    <!-- <option value="">Choose Approver 2-A...</option> -->
                    <option value="0">N/A</option>
                    <?php
                    if ($DISP_EMPLOYEES_NONFILTERED) {
                      foreach ($DISP_EMPLOYEES_NONFILTERED as $DISP_EMPLOYEES_ROW) {
                    ?>
                        <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required " for="UPDT_APPROVER2b">Approver 2-B
                  </label>
                  <select name="UPDT_APPROVER2b" id="updt_approver_2b" class="form-control" style="width: 100%;" required>
                    <!-- <option value="">Choose Approver 2-B...</option> -->
                    <option value="0">N/A</option>
                    <?php
                    if ($DISP_EMPLOYEES_NONFILTERED) {
                      foreach ($DISP_EMPLOYEES_NONFILTERED as $DISP_EMPLOYEES_ROW) {
                    ?>
                        <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required " for="UPDT_APPROVER3a">Approver 3-A
                  </label>
                  <select name="UPDT_APPROVER3a" id="updt_approver_3a" class="form-control" style="width: 100%;" required>
                    <!-- <option value="">Choose Approver 3-A...</option> -->
                    <option value="0">N/A</option>
                    <?php
                    if ($DISP_EMPLOYEES_NONFILTERED) {
                      foreach ($DISP_EMPLOYEES_NONFILTERED as $DISP_EMPLOYEES_ROW) {
                    ?>
                        <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label class="required " for="UPDT_APPROVER3b">Approver 3-B
                  </label>
                  <select name="UPDT_APPROVER3b" id="updt_approver_3b" class="form-control" style="width: 100%;" required>
                    <!-- <option value="">Choose Approver 3-B...</option> -->
                    <option value="0">N/A</option>
                    <?php
                    if ($DISP_EMPLOYEES_NONFILTERED) {
                      foreach ($DISP_EMPLOYEES_NONFILTERED as $DISP_EMPLOYEES_ROW) {
                    ?>
                        <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
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
            <input type="hidden" name="APPROVAL_ID" id="APPROVAL_ID">
            <button type="submit" class='btn btn-primary text-light' id="save_button">&nbsp; Save
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
          <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout
          </a>
        </div>
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
      $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_CSV'); ?>'
      })
    </script>
  <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_CSV');
  }
  ?>


  <?php
  // if ($this->session->userdata('SESS_SUCC_MSG_INSRT_CSV')) {
  // ?>
  //   <script>
  //     Swal.fire(
  //       '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_CSV'); ?>',
  //       '',
  //       'success'
  //     )
  //   </script>
  // <?php
  //   $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_CSV');
  // }
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

      $('#filter_by_branch').select2();
      $('#filter_by_department').select2();
      $('#filter_by_division').select2();
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

      $('#approval').click(function() {
        let selected_id = [];
        let selected_att_id = [];
        $('#APPROVAL_ID').empty();
        $('#approval_list_id').empty();
        $('#select_item input[type=checkbox]:checked').each(function() {
          let selected_item = $(this).val();
          let att_approval_id = $(this).attr('approval_id');
          selected_id.push(selected_item);
          selected_att_id.push(att_approval_id);
        })

        if (selected_id.length > 0) {
          $('.class_modal_approval_list').prop('id', 'modal_assign_approver');
          let approval_ids = selected_id.join(',');
          $('#APPROVAL_ID').val(approval_ids);
          selected_att_id.forEach(function(data) {
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
        let section = $("#filter_by_section").find(":selected").val();
        let group = $("#filter_by_group").find(":selected").val();
        let team = $("#filter_by_team").find(":selected").val();
        let line = $("#filter_by_line").find(":selected").val();

        let status = $("#filter_by_status").find(":selected").val();

        window.location = base_url + "attendances/approval_routes" + page_row + "&branch=" + branch +
          "&dept=" + department + "&division=" + division +
          "&section=" + section + "&group=" + group +
          "&team=" + team + "&line=" + line;
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
      // Get & Display Data to Edit Modal Using Async JS function
      var url = '<?php echo base_url(); ?>attendances/get_approval_route_ot_adj';
      $('#APPROVAL_UPDT').click(function() {
        get_approval_route_ot_adj(url, $(this).attr('approval_id')).then(data => {
          if (data.length > 0) {
            data.forEach((x) => {
              $('#UPDT_APPROVAL_ID').val(x.id);
              $('#UPDT_APPROVER1a').val(x.approver_1a);
              $('#UPDT_APPROVER1b').val(x.approver_1b);
              $('#UPDT_APPROVER2a').val(x.approver_2a);
              $('#UPDT_APPROVER2b').val(x.approver_2b);
              $('#UPDT_APPROVER3a').val(x.approver_3a);
              $('#UPDT_APPROVER3b').val(x.approver_3b);
            });
          }
        });
      })
      async function get_approval_route_ot_adj(url, approval_id) {
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
  <!-------------------- Export ----------------->
  <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function() {
      /* Create worksheet from HTML DOM TABLE */
      var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
      /* Export to file (start a download) */
      XLSX.writeFile(wb, "Approval Route - Overtime / Time Adjustment.xlsx");
    });
  </script>
  </body>

  </html>