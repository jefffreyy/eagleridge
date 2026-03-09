<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<style>
    .handsontable .wtHolder .wtHider{
        /* margin-bottom: 50px; */
        height: 80vh !important;
        /* overflow-y: auto; */
    }
    .handsontable .wtHolder{
        
    }
</style>
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

      <div class="row  pt-1">
        <!-- Title Text -->
        <div class="col-md-6">
          <h1 class="page-title"><a href="<?= base_url().'offsets';?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Offset Entitlement</h1>
        </div>
        <!-- Title Button -->

        <div class="col-md-6 button-title">
           <a href="<?= base_url() . 'offsets/offset_parameter'; ?>" id="" class="btn btn-primary shadow-none"><i class="fa-duotone fa-gears"></i>&nbsp;Settings</a>
           <!-- <a href="" id="" class="btn btn-primary shadow-none"><i class="fa-duotone fa-gears"></i>&nbsp;Switch Settings</a> -->
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
      $search_data = str_replace("_", " ", $search_data ?? '');
      
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
          <!-- <div class="col-md-4 pl-0">
            <div class="input-group m-2 ml-auto" style="width:max-content">
                <div class="input-group-prepend">
                   <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i

                    class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                </div>
                <select class="select-employee d-block" id="search_data" style="min-width:300px;width:max-content">
                    <option value=''>All</option>
                    <?php foreach($EMPLOYEES as $employee) { 
                      $name = $employee->col_empl_cmid.'-'.$employee->col_last_name;
                      if($employee->col_suffix)$name = $name.' '.$employee->col_suffix;
                      if($employee->col_frst_name)$name = $name.', '.$employee->col_frst_name;
                      if($employee->col_midl_name)$name = $name.' '.$employee->col_midl_name;
                      ?>
                      <option value="<?=$employee->id?>" <?= $search_data==$employee->id ? 'selected' : '' ?>>
                      <?= $name
                      ?></option>
                    <?php } ?>
                </select>
 
            </div>
          </div>
        </div> -->



        <div class="card border-0 p-0 m-0">
        <div class="<?= $SYSTEM_LEAVE_SETTING == '1' ? 'd-none' : '';?>">
          <a href="#" class=" btn technos-button-gray shadow-none rounded" id="update" data-toggle="modal" data-target="#modela_update"><i class="far fa-check-circle"></i>&nbsp;Bulk Entitlement Assign</a>

        </div>
          <div class="p-2 d-flex justify-content-between align-items-end">

          <div class="my-1">
            <p class="mb-1 text-secondary ">Employee</p>
            <select class="select-employee form-control" id="search_data" style="min-width:300px;width:max-content">
                <option value=''>All</option>
                <?php foreach($EMPLOYEES as $employee) { 
                  $name=$employee->col_empl_cmid.'-'.$employee->col_last_name;
                  if(!empty($employee->col_suffix))$name=$name.' '.$employee->col_suffix;
                  if(!empty($employee->col_frst_name))$name=$name.', '.$employee->col_frst_name;
                  if(!empty($employee->col_midl_name))$name=$name.' '.$employee->col_midl_name[0].'.';
                  ?>
                    <option value="<?=$employee->id?>" <?= $search_data==$employee->id ? 'selected' : '' ?>
                    ><?= $name
                    // $employee->col_empl_cmid."-".$this->system_functions->fomatName($employee->col_last_name,$employee->col_frst_name,$employee->col_midl_name)
                    ?></option>
                <?php } ?>
            </select>
          </div>

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

          <div id="auto_table_data" <?= $SYSTEM_LEAVE_SETTING == '1' ? '' : 'hidden';?>></div>
          <!-- <div id="manual_table_data"></div> -->

          <div class="table-responsive" <?= $SYSTEM_LEAVE_SETTING == '0' ? '' : 'hidden';?>>
            <table class="table table-bordered m-0" id="TableToExport" style="width:100%">
              <thead>
                <th class="text-center"><input type="checkbox" name="check_all" id="check_all"></th>
                <th class="text-center emp">Employee</th>
                <!-- <th>Date</th> -->
                <?php foreach ($DISP_OFFSET_TYPES as $DISP_OFFSET_TYPES_ROW) { ?>
                  <th class="text-center std"><?= $DISP_OFFSET_TYPES_ROW->name ?></th>
                <?php } ?>
              </thead>
              <tbody id="cutoff_container">
                <?php if ($DISP_EMP_LIST) {
                  foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) { 
                    $name = $DISP_EMP_LIST_ROW->col_empl_cmid.'-'.$DISP_EMP_LIST_ROW->col_last_name;
                    if($DISP_EMP_LIST_ROW->col_suffix)$name = $name.' '.$DISP_EMP_LIST_ROW->col_suffix;
                    if($DISP_EMP_LIST_ROW->col_frst_name)$name = $name.', '.$DISP_EMP_LIST_ROW->col_frst_name;
                    if($DISP_EMP_LIST_ROW->col_midl_name)$name = $name.' '.$DISP_EMP_LIST_ROW->col_midl_name[0].'.';
                    ?>
                    <tr>
                      <td class="text-center" id="select_item">
                        <input type="checkbox" name="brand" class="check_single" 
                        empl_name="<?= $name
                        // $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name 
                        ?>" 
                        value="<?= $DISP_EMP_LIST_ROW->id ?>">
                      </td>
                      <td>
                        <?= $name
                        // $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ' ' . $DISP_EMP_LIST_ROW->col_frst_name 
                        ?>
                      </td>
                      <?php
                      foreach ($DISP_OFFSET_TYPES as $DISP_OFFSET_TYPES_ROW) {
                          $entitlement_value = 0;
                          $offset_type=$DISP_OFFSET_TYPES_ROW->name;
                        if ($DISP_ENTITLEMENT) {
                          foreach ($DISP_ENTITLEMENT as $DISP_ENTITLEMENT_ROW) {
                            if ($DISP_ENTITLEMENT_ROW->empl_id == $DISP_EMP_LIST_ROW->id && $DISP_OFFSET_TYPES_ROW->name == $DISP_ENTITLEMENT_ROW->type) {
                               
                              $entitlement_value = $DISP_ENTITLEMENT_ROW->value;
                            
                              break;
                            }
                          }
                        }
                      ?>

                        <td style="padding: 1px !important;">
                          <form class="bg-transparent">
                            <input type="hidden" class="employee_data" name="employee_data" value="<?= $DISP_EMP_LIST_ROW->id ?>">
                            <input type="hidden" class="type_data" name="type_data" value="<?=$offset_type?>">
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
        <form action="<?= base_url() . 'offsets/update_offset_entitlement'; ?>" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
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
                    foreach ($DISP_OFFSET_TYPES as $DISP_OFFSET_TYPES_ROW) {
                    ?>
                      <option value="<?= $DISP_OFFSET_TYPES_ROW->name ?>"><?= $DISP_OFFSET_TYPES_ROW->name; ?></option>
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

<!-- modal employee info reporting to, directs -->
  <div class="modal fade vertical-centered" id="modalDirects" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document"> 
      <div class="modal-content">
        <div class="d-flex justify-content-end">
          <button type="button" class="close pr-3 pt-2" data-dismiss="modal" aria-label="Close" style="font-size: 34px;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modalLoading" class="modal-body pt-0" style="position:absolute;height:100%;width:100%;background:white;z-index:1000;display:none;">
          <div class="d-flex w-100 h-100 align-items-center justify-content-center">
            <div class="d-flex align-items-center">
              <div class="spinner-border text-primary" role="status" style="width:20px;height:20px">
                <span class="sr-only">Loading...</span>
              </div>
              <span class="ml-1" style="font-weight: 600;font-size:18px">Fetching Data...</span>
            </div>
          </div>
        </div>
        <div class="modal-body pt-0">
          <div class="col card">
            <div id="modalContentEmployee" class="p-0">
              <div class="d-flex justify-content-between align-items-start">
                  <div class="d-flex  align-items-center">
                      <div class="profile-pic m-0 p-0">
                          <img class="img-circle rounded-circle avatar m-3  elevation-2" 
                          id="employee_img" style="cursor: pointer;" data-toggle="tooltip" 
                          data-placement="right" title="Profile Image" 
                          src="<?= base_url() ?>/assets_system/images/default_user.jpg">
                      </div>
                      <div class="basic-profile p-2">
                          <div class="d-flex align-items-center">
                              <div class="stats" id="employeeNumber" style="line-height:1;">(No Employee Number)</div>
                          </div>
                          <div class="d-flex align-items-center">
                              <text style="font-size:15px;" class="emp-name text-bold m-0" id="employeeFullName">(No Full Name)</text>
                          </div>
                          <div class="emp-stat m-0 d-flex flex-column p-0">
                              <div>
                                  <div class="stats" id="employeePosition">(Position)</div>
                              </div>
                              <div>
                                  <div class="stats" id="employeeCompany">(No Company)</div>
                              </div>
                              <div>
                                  <div class="stats" id="employeeBranchDepartment">(No Branch / No Department)</div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="p-3">
                <div>
                  <p class="mb-1" style="font-weight:500">Contact Information</p>
                  <div class="d-flex align-items-center mx-2">
                    <i class="fa fa-envelope" aria-hidden="true" style="font-size: 16px"></i>
                    <div class="mx-3">
                      <p class="p-0 m-0" style="line-height: 1;font-size: 13px;">Email:</p>
                      <a class="p-0 m-0" id="employeeEmail">(No Email)</a>
                    </div>
                    
                  </div>
              </div>
              </div>
              <div class="px-3 py-1">
                <div>
                  <p class="mb-1" style="font-weight:500">Reporting To:</p>
                  <div id="reportingToContainer" class="d-flex align-items-center mx-2">
                    (No Reporting To)
                  </div>
                </div>
              </div>
              <div class="p-3">
                <div>
                  <p  class="mb-1" style="font-weight:500">Directs:</p>
                  <div id="directsParent" class="mx-2">(No Directs)
                    <!-- <div  class="d-flex align-items-center mx-2 mb-2">
                      <img class="img-circle rounded-circle avatar elevation-2" 
                      id="directsImage" style="cursor: pointer;width:50px !important;height:50px !important" data-toggle="tooltip" 
                      data-placement="right" title="Reporting To" 
                      src="<?= base_url() ?>/assets_system/images/default_user.jpg">
                      <div class="mx-2">
                        <p id="directsName" class="p-0 m-0" style="line-height: 1;font: size 13px;font-weight:500;">Name of Reporting To</p>
                      </div> -->
                    </div>
                  </div>
                  
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- jQuery -->
<?php $this->load->view('templates/jquery_link'); ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

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

    var url = '<?=base_url()?>';
    var empl_list = <?php echo json_encode($DISP_EMP_LIST_TABLE); ?>;

    console.log('empl_list',empl_list)


    const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.whiteSpace = 'nowrap';
        td.style.overflow = 'hidden';
    };



    const container = document.querySelector('#auto_table_data');
    hot = new Handsontable(container, {
        data: empl_list, 
        colHeaders: ["Id","Employee ID","Name","Date Hired","Month Count","Vacation","Sick"],
        rowHeaders: true,
        stretchH: 'all',
        height: 'auto',
        outsideClickDeselects: false,
        selectionMode: 'multiple',
        licenseKey: 'non-commercial-and-evaluation',
        // Custom renderer to prevent text wrapping
        renderer: customStyleRenderer,
        hiddenColumns: {
            columns: [0],
            indicators: true,
        },
        readOnly: true,
        cells: function (row, col, prop) {
        if (col === 2) { 
            this.renderer = customStyleRenderer2;
        }
    },
    });

    function customStyleRenderer2(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.classList.add('hover');
    td.addEventListener('click', function () {
        const id = empl_list[row].id;
        directs(id);
    });
}

  </script>






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
      
        $('.select-employee').select2();
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

      // $("#search_btn").on("click", function() {
      //   search();
      // });

      // $("#search_data").on("keypress", function(e) {
      //   if (e.which === 13) {
      //     search();
      //   }
      // });

      $(".select-employee,#search_data").on("change", function() {
        search();
      });

      // $(".select-employee,#search_data").on("keypress", function(e) {
      //   if (e.which === 13) {
      //     search();
      //   }
      // });

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
        let employee = $(this).siblings(".employee_data").val();
        let type = $(this).siblings(".type_data").val();
        let entitlement_val = $(this).val();
        let year = $("#filter_year").find(":selected").val();
        window.location = base_url + "offsets/process_assigning/" + employee + "/" + entitlement_val + "/" + year + "?type=" + type;
        
      })
      

      $('.entitlement_val').on('keydown', function(event) {
          if (event.key === "Enter") {
              event.preventDefault(); 

              let employee = $(this).siblings(".employee_data").val();
              let type = $(this).siblings(".type_data").val();
              let entitlement_val = $(this).val();
              let year = $("#filter_year").find(":selected").val();
              window.location = base_url + "offsets/process_assigning/" + employee + "/" + entitlement_val + "/" + year + "?type=" + type; 
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

  <script>
    var baseUrl = '<?= base_url() ?>';
    let companyHide = false;
    var companySettings =  <?php echo json_encode($DISP_VIEW_COMPANY); ?>;
    var companySettingsNumber = parseInt(companySettings);
    if (!isNaN(companySettingsNumber) && companySettingsNumber < 1)companyHide=true;
    let branchHide = false;
    var branchSettings =  <?php echo json_encode($DISP_VIEW_BRANCH); ?>;
    var branchSettingsNumber = parseInt(branchSettings);
    if (!isNaN(branchSettingsNumber) && branchSettingsNumber < 1)branchHide=true;
    let departmentHide = false;
    var departmentSettings =  <?php echo json_encode($DISP_VIEW_DEPARTMENT); ?>;
    var departmentSettingsNumber = parseInt(departmentSettings);
    if (!isNaN(departmentSettingsNumber) && departmentSettingsNumber < 1)departmentHide=true;
    async function directs (employeeId){
      if (employeeId) {
        document.getElementById("modalLoading").style.display = "block";
        $('#modalDirects').modal('show');
        const apiUrl = baseUrl + 'selfservices/get_reporting_to_directives';
        const data = {employeeId};
        console.log('data', data);
        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            console.log('result', result)
            document.getElementById("modalLoading").style.display = "none";
            document.getElementById("employeeCompany").style.display = 'block';
            document.getElementById("employeeBranchDepartment").style.display = 'block';
            let employeeImage = `${baseUrl}/assets_user/user_profile/${result.data.employeeInfo?.col_imag_path}`;
            if(!result.data.employeeInfo?.col_imag_path)employeeImage=`${baseUrl}/assets_system/images/default_user.jpg`;
            document.getElementById('employee_img').src = employeeImage;

            // let employeeMiddleInitial = result.data.employeeInfo?.col_midl_name?.charAt(0);
            // if(employeeMiddleInitial){`${employeeMiddleInitial}.`}else{employeeMiddleInitial= '';}
            // let employeeFirstName = result.data.employeeInfo?.col_frst_name;
            // if(!employeeFirstName)employeeFirstName= '';
            // let employeeLastName = result.data.employeeInfo?.col_last_name;
            // if(!employeeLastName)employeeLastName= '';
            // if (employeeLastName || employeeFirstName || employeeMiddleInitial){
            //   document.getElementById("employeeFullName").textContent = `${employeeLastName}, ${employeeFirstName} ${employeeMiddleInitial}`;
            
            let employeeLastNameSuffix = result.data.employeeInfo?.col_last_name;
            if(result.data.employeeInfo?.col_suffix)employeeLastNameSuffix = `${result.data.employeeInfo?.col_last_name} ${result.data.employeeInfo?.col_suffix}`;
            let employeeFullName = employeeLastNameSuffix;
            if(result.data.employeeInfo?.col_frst_name)employeeFullName= `${employeeFullName}, ${result.data.employeeInfo?.col_frst_name}`;
            if(result.data.employeeInfo?.col_midl_name)employeeFullName= `${employeeFullName} ${result.data.employeeInfo?.col_midl_name.charAt(0)}.`;
            if (employeeFullName) {
              document.getElementById("employeeFullName").textContent = employeeFullName;
            } else {
              document.getElementById("employeeFullName").textContent = '(No Full Name)'
            }

            if (result.data.employeeInfo?.col_empl_cmid){
              document.getElementById("employeeNumber").textContent = `${result.data.employeeInfo.col_empl_cmid}`;
            }else{document.getElementById("employeeNumber").textContent = '(No Employee Number)'}
            if(result.data.employeeInfo?.col_empl_posi){
              document.getElementById("employeePosition").textContent = `${result.data.employeeInfo.col_empl_posi}`;
            }else{document.getElementById("employeePosition").textContent = '(No Position)'}
            if(result.data.employeeInfo?.col_empl_company){
              document.getElementById("employeeCompany").textContent = `${result.data.employeeInfo.col_empl_company}`;
            }else{document.getElementById("employeeCompany").textContent = '(No Company)'}
            if(companyHide)document.getElementById("employeeCompany").style.display = 'none';
            branch = result.data.employeeInfo?.col_empl_branch ;
            inBetween = ` \\ `;
            department = result.data.employeeInfo?.col_empl_dept;
            if(!branch || branchHide)branch = '';
            if(!department || departmentHide)department = '';
            if(branchHide || departmentHide || !branch || !department)inBetween='';
            if(branch || department){
              document.getElementById("employeeBranchDepartment").textContent = `${branch}${inBetween}${department}`;
            }else{
              if (branchHide && !departmentHide) {
                document.getElementById("employeeBranchDepartment").textContent = '(No Department)';
              }else if(departmentHide && !branchHide){
                document.getElementById("employeeBranchDepartment").textContent = '(No Branch)';
              }else if(!branchHide && !departmentHide){
                document.getElementById("employeeBranchDepartment").textContent = '(No Branch / No Department)';
              }else{document.getElementById("employeeBranchDepartment").textContent = ''}
            }
            if(result.data.employeeInfo?.col_comp_emai){
              document.getElementById("employeeEmail").textContent = `${result.data.employeeInfo.col_comp_emai}`;
            }else{document.getElementById("employeeEmail").textContent = '(No Email)'}

            // let reportingToMiddleInitial = result.data.reportingTo?.col_midl_name?.charAt(0);
            // if(reportingToMiddleInitial){reportingToMiddleInitial=`${reportingToMiddleInitial}.`;}else{reportingToMiddleInitial='';}
            // let reportingToLastName = result.data.reportingTo?.col_last_name;
            // if(!reportingToLastName)reportingToLastName='';
            // let reportingToFirstName = result.data.reportingTo?.col_frst_name;
            // if(!reportingToFirstName)reportingToFirstName='';

            let reportingToLastNameSuffix = result.data.reportingTo?.col_last_name;
            // console.log('result.data.reportingTo',result.data.reportingTo)
            if (result.data.reportingTo?.col_suffix)reportingToLastNameSuffix= `${reportingToLastNameSuffix} ${result.data.reportingTo?.col_suffix}`;
            // console.log('reportingToLastNameSuffix',reportingToLastNameSuffix)
            let reportingToFullName = reportingToLastNameSuffix;
            if (result.data.reportingTo?.col_frst_name)reportingToFullName = `${reportingToFullName}, ${result.data.reportingTo?.col_frst_name}`;
            if (result.data.reportingTo?.col_midl_name)reportingToFullName = `${reportingToFullName} ${result.data.reportingTo?.col_midl_name?.charAt(0)}.`;

            let reportingToImage = "<?= base_url() ?>/assets_system/images/default_user.jpg";
            if (result.data.reportingTo?.col_imag_path)
              reportingToImage = `${baseUrl}/assets_user/user_profile/${result.data.reportingTo.col_imag_path}`;

            // if (reportingToLastName || reportingToFirstName) {
            //   let reportingFullName = `${reportingToLastName}, ${reportingToFirstName} ${reportingToMiddleInitial}`;
            if (reportingToFullName) {
              document.getElementById("reportingToContainer").textContent = "";
              document.getElementById("reportingToContainer").innerHTML =
              `<img class="img-circle rounded-circle avatar elevation-2" 
                style="cursor: pointer;width:50px !important;height:50px !important" data-toggle="tooltip" 
                data-placement="right" title="Reporting To" 
                src="${reportingToImage}">
              <div class="mx-2">
                <p class="p-0 m-0" style="line-height: 1;font: size 13px;font-weight:500;">${reportingToFullName}</p>
              </div>`;
            }else{document.getElementById("reportingToContainer").innerHTML= '(No Redirect To)'}
            var directsParent = document.getElementById("directsParent");
            
            // console.log('directs condition', Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0)
            if (Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0) {
              directsParent.innerHTML = '';
              result.data.directsTo.forEach(function(user) {

                // let directMiddleInitial = `${user.col_midl_name.charAt(0)}.`
                // if(!directMiddleInitial)directMiddleInitial= null;
                // const directFullName = `${user.col_last_name}, ${user.col_frst_name} ${directMiddleInitial}`;

                let directMiddleInitial = `${user.col_midl_name.charAt(0)}.`
                if (!directMiddleInitial) directMiddleInitial = null;
                let directLastNameSuffix = user.col_last_name;
                if (user.col_suffix)directLastNameSuffix = `${directLastNameSuffix} ${user.col_suffix}`;
                let directFullName = directLastNameSuffix;
                if (user.col_frst_name)directFullName = `${directFullName}, ${user.col_frst_name}`;
                if (user.col_midl_name)directFullName = `${directFullName} ${user.col_midl_name.charAt(0)}.`;

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
            }else{
              directsParent.innerHTML = '(No Directs)';
            }
            if(result.errorMessage){
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
      document.getElementById("reportingToContainer").innerHTML= '(No Redirect To)';
      document.getElementById("directsParent").innerHTML = '(No Directs)';
    }
    }
  </script>

</body>

</html>
<!-- SELECT * FROM `tbl_empl_info` WHERE id='1000004' OR id='1000022' OR id='1134' OR id='1149' OR id='1150' OR id='1270' OR id='1429' -->