<?php $this->load->view('templates/css_link'); ?>

<style>
  /* * {
    outline: 1px solid blue;
  } */

  th.std {
    min-width: 135px;
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
    padding: 10px !important;
    font-size: 13px !important;
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

  @media (max-width: 780px) {
    .shift {
      margin-top: 20px;
    }
  }
</style>

<?php
if (isset($_GET['year'])) {
  $year = $_GET['year'];
} else {
  $year = $YEAR_INITIAL;
}

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


?>

<body>
  <!-- Content Starts -->
  <div class="content-wrapper">
    <div class="container-fluid p-4">

      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url() ?>leaves">Leaves
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Leave Entitlement
          </li>
        </ol>
      </nav>

      <div class="row  pt-1">
        <!-- Title Text -->
        <div class="col-md-6">
          <h1 class="page-title">Leave Entitlement</h1>
        </div>
        <!-- Title Button -->

        <div class="col-md-6 button-title">
          <!-- <a href="<?= base_url() . 'leaves/shift_import_csv'; ?>" id="btn_application" class="btn btn-primary shadow-none"><i class="fas fa-file-import"></i>Import CSV</a> -->
          <!-- <a href="<?= base_url() . 'leaves/bulk_import'; ?>" id="btn_application" class="btn technos-button-green shadow-none"><i class="fas fa-file-import"></i>Bulk Import</a>-->
          <!-- <a href="#" id="btn_export" class="btn technos-button-gray shadow-none rounded"><i class="fas fa-file-export"></i>Export XLSX</a>  -->
          <!-- <a href="#" id="btn_application" data-toggle="modal" data-target="#modal_attendance_records" class="btn btn-primary shadow-none"><i class="fas fa-file-export"></i>Export CSV</a> -->
          

        </div>
      </div>

      <hr>
      <div class="row mb-4">

        <div class="col-md-2">
          <p class="mb-1 text-secondary ">Year</p>
          <select name="filter_year" id="filter_year" class="form-control">
            <?php
            // var_dump($DISP_YEARS);
            if ($DISP_YEARS) {
              foreach ($DISP_YEARS as $DISP_YEARS_ROW) {
            ?>
                <option value="<?= $DISP_YEARS_ROW->id ?>" <?php echo ($year == $DISP_YEARS_ROW->id ? 'selected' : '') ?>>
                  <?= $DISP_YEARS_ROW->name ?>
                </option>
            <?php
              }
            }
            ?>
          </select>
        </div>

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
          <a href=<?= base_url() . "leaves/entitlements" ?> id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
        </div>

      </div> <!-- filter divs ends -->
      <?php
      $search_data = $this->input->get('all');
      $search_data = str_replace("_", " ", $search_data);
      
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
      // $last_page = intval($C_DATA_COUNT / $row);
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
            <a href="#" class=" btn technos-button-gray shadow-none rounded" id="update" data-toggle="modal" data-target="#modela_update"><i class="far fa-check-circle"></i>&nbsp;Bulk Entitlement Assign</a>

            <div class="float-right ">
              <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
              <ul class="d-inline pagination m-0 p-0 ">

                <li><a class="page_row" <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>  < </a> </li>
                <li><a class="page_row" href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                <li><a class="page_row" href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                <li><a class="page_row" href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page||$last_page<=0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                <li><a class="page_row" style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>

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

          <div class="table-responsive">
            <table class="table table-bordered m-0" id="TableToExport" style="width:100%">
              <thead>
                <th class="text-center"><input type="checkbox" name="check_all" id="check_all"></th>
                <th class="text-center emp">Employee</th>
                <!-- <th>Date</th> -->
                <?php foreach ($DISP_LEAVE_TYPES as $DISP_LEAVE_TYPES_ROW) { ?>
                  <th class="text-center std"><?= $DISP_LEAVE_TYPES_ROW->name ?></th>
                <?php } ?>
              </thead>
              <tbody id="cutoff_container">
                <?php if ($DISP_EMP_LIST) {
                  foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) { ?>
                    <tr>
                      <td class="text-center" id="select_item">
                        <input type="checkbox" name="brand" class="check_single" empl_name="<?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name ?>" value="<?= $DISP_EMP_LIST_ROW->id ?>">
                      </td>
                      <td>
                        <?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ' ' . $DISP_EMP_LIST_ROW->col_frst_name ?>
                      </td>
                      <?php
                      foreach ($DISP_LEAVE_TYPES as $DISP_LEAVE_TYPES_ROW) {
                        $entitlement_value = 0;
                        if ($DISP_ENTITLEMENT) {
                          foreach ($DISP_ENTITLEMENT as $DISP_ENTITLEMENT_ROW) {
                            $entitlement_value = 0;
                            if ($DISP_ENTITLEMENT_ROW->empl_id == $DISP_EMP_LIST_ROW->id && $DISP_LEAVE_TYPES_ROW->name == $DISP_ENTITLEMENT_ROW->type) {
                              $entitlement_value = $DISP_ENTITLEMENT_ROW->value;
                              break;
                            }
                          }
                        }
                      ?>

                        <td style="padding: 1px !important;">
                          <form class="bg-transparent">
                            <input type="hidden" id="employee_data" name="employee_data" value="<?= $DISP_EMP_LIST_ROW->id ?>">
                            <input type="hidden" id="type_data" name="type_data" value=<?= $DISP_LEAVE_TYPES_ROW->name  ?>>
                            <input type="number" class="form-control entitlement_val" id="entitlement_val" name="entitlement_val" pattern="[0-9]*" value=<?= $entitlement_value ?> style="width:100%;">
                          </form>
                        </td>
                      <?php }
                      ?>
                    </tr>
                  <?php }
                } else {
                  ?>
                  <tr class="table-active">
                    <td colspan="12">
                      <center>No Data</center>
                    </td>
                  </tr>
                <?php  } ?>
                <!-- Message if no entries -->

              </tbody>
            </table>
            <div class="w-100 text-center">
              <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
            </div>
          </div>
        </div>
      </div>
    </div><!--End fluid-->
  </div>

  <!-- /.control-sidebar -->
  <!-- LOGOUT MODAL -->

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
  </div>

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
          <h4 class="modal-title ml-1" id="exampleModalLabel">Update Bulk
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>
        <form action="<?= base_url() . 'leaves/update_leave_entitlement'; ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <ul id="update_list_id" class="row" style="background: #e7f4e4;"></ul>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">

                <div class="form-group">
                  <label class="required" for="UPDT_ENTITLEMENT_TYPE">Leave Type</label>

                  <input type="hidden" name="UPDT_ENTITLEMENT_YEAR" id="UPDT_ENTITLEMENT_YEAR" value=<?= $year ?>>
                  <select name="UPDT_ENTITLEMENT_TYPE" id="updt_entitlement_type" class="form-control" style='width:100%'>
                    <?php
                    foreach ($DISP_LEAVE_TYPES as $DISP_LEAVE_TYPES_ROW) {
                    ?>
                      <option value="<?= $DISP_LEAVE_TYPES_ROW->name ?>"><?= $DISP_LEAVE_TYPES_ROW->name; ?></option>
                    <?php
                    }

                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required" for="UPDT_ENTITLEMENT_VAL">Value</label>
                  <input class="form-control" type="number" class="UPDT_ENTITLEMENT_VAL" id="updt_entitlement_val" name="UPDT_ENTITLEMENT_VAL" pattern="[0-9]*">
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <input type="hidden" name="DATE_FROM" id="DATE_FROM" value=<?= $DATE_FROM ?>>
            <input type="hidden" name="DATE_TO" id="DATE_TO" value=<?= $DATE_TO ?>>
            <!-- <input type="hidden" name="COUNT_DATE" id="COUNT_DATE" value=<?= $count_date ?>> -->
            <input type="hidden" name="YEAR" id="YEAR" value="<?= $year ?>">
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

<?php
if ($this->session->userdata('SESS_SUCCESS')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('SESS_SUCCESS'); ?>'
      })
</script>
<?php
$this->session->unset_userdata('SESS_SUCCESS');
}
?>

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
  <script>
    $(document).ready(function() {

      $('#filter_year').select2();
      $('#filter_by_branch').select2();
      $('#filter_by_department').select2();
      $('#filter_by_division').select2();
      $('#filter_by_section').select2();
      $('#filter_by_group').select2();
      $('#filter_by_team').select2();
      $('#filter_by_line').select2();

      $('#updt_entitlement_type').select2();
      

      var base_url = '<?= base_url(); ?>';

      $('#row_dropdown').on('change', function (e) {
        e.preventDefault()
        var row_val = $(this).val(); 
        let data = "?page=1&row=" + row_val;
        filter_data(data);
      });

      $('.page_row').on('click',function(e){
        e.preventDefault()
        let page_row = $(this).attr('href');
        filter_data(page_row);
      })


      $("#filter_year").on("change", function() {
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
        if(page_row == null || page_row == ""){
          page_row ='?page='+"<?=$current_page?>"+'&row='+"<?=$row?>"
        }
        let year = $("#filter_year").find(":selected").val();

        let branch = $("#filter_by_branch").find(":selected").val();
        let department = $("#filter_by_department").find(":selected").val();
        let division = $("#filter_by_division").find(":selected").val();
        let section = $("#filter_by_section").find(":selected").val();
        let group = $("#filter_by_group").find(":selected").val();
        let team = $("#filter_by_team").find(":selected").val();
        let line = $("#filter_by_line").find(":selected").val();



        window.location = base_url + "leaves/entitlements"+page_row+"&branch=" + branch +
          "&dept=" + department + "&division=" + division +
          "&section=" + section + "&group=" + group +
          "&team=" + team + "&line=" + line +
          "&year=" + year;
      }


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



      $('.entitlement_val').on('change', function() {
        let employee = $(this).siblings("#employee_data").val();
        let type = $(this).siblings("#type_data").val();
        let entitlement_val = $(this).val();
        let year = $("#filter_year").find(":selected").val();

        window.location = base_url + "leaves/process_assigning/" + employee + "/" + entitlement_val + "/" + year + "/" + type;
        
      })
      

      $('.entitlement_val').on('keydown', function(event) {
          if (event.key === "Enter") {
              event.preventDefault(); 

              let employee = $(this).siblings("#employee_data").val();
              let type = $(this).siblings("#type_data").val();
              let entitlement_val = $(this).val();
              let year = $("#filter_year").find(":selected").val();

              window.location = base_url + "leaves/process_assigning/" + employee + "/" + entitlement_val + "/" + year + "/" + type; 
          }
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
      XLSX.writeFile(wb, "Leave Entitlement.xlsx");
    });
  </script>
</body>

</html>
<!-- SELECT * FROM `tbl_empl_info` WHERE id='1000004' OR id='1000022' OR id='1134' OR id='1149' OR id='1150' OR id='1270' OR id='1429' -->