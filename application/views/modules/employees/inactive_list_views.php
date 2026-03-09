<html>
<?php $this->load->view('templates/css_link'); ?>
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
$prev_page  = $current_page - 1;
$next_page  = $current_page + 1;
$last_page  = intval($C_DATA_COUNT / $row);
$excess     = $C_DATA_COUNT % $row;
if ($excess > 0) {
  $last_page += 1;
}

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
  .img-circle {
    border-radius: 50% !important;
    width: 30px !important;
    height: 30px !important;
    object-fit: scale-down;
    background-color: #b0b0b0;
  }

  .hide {
    display: none;
  }

  .missing_count {
    display: inline-block;
    margin: 5px 1px 0 1px;
    width: 20px;
    height: 20px;
    background: #f56767;
    color: white;
    border-radius: 50%;
    padding: 1px;
    text-align: center;
    font-size: 12px;
    font-weight: 500;
  }

  .complete_count {
    margin: 5px 1px 0 1px;
    width: 20px;
    height: 20px;
    background: #46cf6a;
    color: white;
    border-radius: 50%;
    padding: 3px;
    text-align: center;
    font-size: 10px;
  }
</style>

<body>

  <div class="content-wrapper">
    <div class="container-fluid p-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url() ?>employees/directories">Inactive Employee</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Employee Directory
          </li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-md-6">
          <h1 class="page-title"><a href="<?= base_url() . 'employees/directories'; ?>"> <img style="width: 24px; height: 24px; margin-bottom: 5px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Inactive Employee List</h1>
        </div>
      </div>
      <hr>
      
      <?php
      (isset($_GET['dept']) ? $dept = $_GET['dept'] : $dept = "");
      (isset($_GET['sec']) ? $sec = $_GET['sec'] : $sec = "");
      (isset($_GET['group']) ? $group = $_GET['group'] : $group = "");
      (isset($_GET['line']) ? $line = $_GET['line'] : $line = "");
      (isset($_GET['team']) ? $team = $_GET['team'] : $team = "");
      (isset($_GET['division']) ? $division = $_GET['division'] : $division = "");
      (isset($_GET['branch']) ? $branch = $_GET['branch'] : $branch = "");
      (isset($_GET['company']) ? $company = $_GET['company'] : $company = "");
      (isset($_GET['status']) ? $status = $_GET['status'] : $status = "");
      (isset($_GET['all']) ? $all = $_GET['all'] : $all = "");
      ?>

      <?php
      if (isset($_GET['branch'])) {
        $param_branch = $_GET['branch'];
      } else {
        $param_branch = "";
      }
      if (isset($_GET['company'])) {
        $param_company = $_GET['company'];
      } else {
        $param_company = "";
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
      if (isset($_GET['search'])) {
        $search = $_GET['search'];
      } else {
        $search = "";
      }
      ?>
 
      <div class="col-md-2 col-3" <?php echo (true ? "" : "hidden") ?>>
        <label class="mb-0 text-secondary ">Search Employee</label>
        <select id="search_select" class="form-control">
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
      </div>

      <div class="row mt-4">
        <div class="col-md-2 " <?php echo ($DISP_VIEW_COMPANY ? "" : "hidden") ?>>
          <p class="mb-1 text-secondary ">Company</p>
          <select id="filter_by_company" class="form-control filter_by">
            <?php
            if ($C_COMPANIES) {
            ?>
              <option value="" <?php foreach ($C_COMPANIES as $Row) {
                                  if ($Row->name == '') {
                                    echo 'selected';
                                  }
                                } ?>>All Company</option>
              <?php
              foreach ($C_COMPANIES as $Row) {
                if ($Row->name != '') {
              ?>
                  <option value="<?= $Row->id ?>" <?= ($Row->id == $company) ? 'Selected' : ''; ?>><?= $Row->name ?></option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>

        <div class="col-md-2 " <?php echo ($DISP_VIEW_BRANCH ? "" : "hidden") ?>>
          <p class="mb-1 text-secondary ">Branch</p>
          <select id="filter_by_branch" class="form-control filter_by">
            <?php
            if ($C_BRANCH) {
            ?>
              <option value="" <?php foreach ($C_BRANCH as $C_BRANCH_ROW_1) {
                                  if ($C_BRANCH_ROW_1->name == '') {
                                    echo 'selected';
                                  }
                                } ?>>All Branch</option>
              <?php
              foreach ($C_BRANCH as $C_BRANCH_ROW) {
                if ($C_BRANCH_ROW->name != '') {
              ?>
                  <option value="<?= $C_BRANCH_ROW->id ?>" <?= ($C_BRANCH_ROW->id == $branch) ? 'Selected' : ''; ?>><?= $C_BRANCH_ROW->name ?></option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>

        <div class="col-md-2 " <?php echo ($DISP_VIEW_DEPARTMENT ? "" : "hidden") ?>>
          <p class="mb-1 text-secondary ">Department</p>
          <select id="filter_by_department" class="form-control filter_by">
            <?php
            if ($C_DEPARTMENTS) {
            ?>
              <option value="" <?php foreach ($C_DEPARTMENTS as $DISP_DISTINCT_DEPARTMENT_ROW_1) {
                                  if ($DISP_DISTINCT_DEPARTMENT_ROW_1->name == '') {
                                    echo 'selected';
                                  }
                                } ?>>All Departments</option>
              <?php
              foreach ($C_DEPARTMENTS as $DISP_DISTINCT_DEPARTMENT_ROW) {
                if ($DISP_DISTINCT_DEPARTMENT_ROW->name != '') {
              ?>
                  <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->id ?>" <?= ($DISP_DISTINCT_DEPARTMENT_ROW->id == $dept) ?  "selected" : ''; ?>><?= $DISP_DISTINCT_DEPARTMENT_ROW->name ?></option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>

        <div class="col-md-2 " <?php echo ($DISP_VIEW_DIVISION ? "" : "hidden") ?>>
          <p class="mb-1 text-secondary ">Division</p>
          <select id="filter_by_division" class="form-control filter_by">
            <?php
            if ($C_DIVISIONS) {
            ?>
              <option value="" <?php foreach ($C_DIVISIONS as $C_DIVISIONS_ROW_1) {
                                  if ($C_DIVISIONS_ROW_1->name == '') {
                                    echo 'selected';
                                  }
                                } ?>>All Division</option>
              <?php
              foreach ($C_DIVISIONS as $C_DIVISIONS_ROW) {
                if ($C_DIVISIONS_ROW->name != '') {
              ?>
                  <option value="<?= $C_DIVISIONS_ROW->id ?>" <?= ($C_DIVISIONS_ROW->id == $division) ? 'Selected' : ''; ?>><?= $C_DIVISIONS_ROW->name ?></option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>

        <div class="col-md-2 " <?php echo ($DISP_VIEW_SECTION ? "" : "hidden") ?>>
          <p class="mb-1 text-secondary ">Section</p>
          <select id="filter_by_section" class="form-control filter_by">
            <?php
            if ($C_SECTIONS) {
            ?>
              <option value="" <?php foreach ($C_SECTIONS as $DISP_DISTINCT_SECTION_ROW_1) {
                                  if ($DISP_DISTINCT_SECTION_ROW_1->name == '') {
                                    echo 'selected';
                                  }
                                } ?>>All Sections</option>
              <?php
              foreach ($C_SECTIONS as $DISP_DISTINCT_SECTION_ROW) {
                if ($DISP_DISTINCT_SECTION_ROW->name != '') {
              ?>
                  <option value="<?= $DISP_DISTINCT_SECTION_ROW->id ?>" <?= ($DISP_DISTINCT_SECTION_ROW->id == $sec) ?  "selected" : ''; ?>><?= $DISP_DISTINCT_SECTION_ROW->name ?></option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>

        <div class="col-md-2 " <?php echo ($DISP_VIEW_GROUP ? "" : "hidden") ?>>
          <p class="mb-1 text-secondary ">Group</p>
          <select id="filter_by_group" class="form-control filter_by">
            <?php
            if ($C_GROUPS) {
            ?>
              <option value="" <?php foreach ($C_GROUPS as $DISP_Group_ROW_1) {
                                  if ($DISP_Group_ROW_1->name == '') {
                                    echo 'selected';
                                  }
                                } ?>>All Groups</option>
              <?php
              foreach ($C_GROUPS as $DISP_Group_ROW) {
                if ($DISP_Group_ROW->name != '') {
              ?>
                  <option value="<?= $DISP_Group_ROW->id ?>" <?= ($DISP_Group_ROW->id == $group) ? 'Selected' : ""; ?>><?= $DISP_Group_ROW->name ?></option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>

        <div class="col-md-2 " <?php echo ($DISP_VIEW_TEAM ? "" : "hidden") ?>>
          <p class="mb-1 text-secondary ">Team</p>
          <select id="filter_by_team" class="form-control filter_by">
            <?php
            if ($C_TEAMS) {
            ?>
              <option value="" <?php foreach ($C_TEAMS as $C_TEAMS_ROW_1) {
                                  if ($C_TEAMS_ROW_1->name == '') {
                                    echo 'selected';
                                  }
                                } ?>>All Team</option>
              <?php
              foreach ($C_TEAMS as $C_TEAMS_ROW) {
                if ($C_TEAMS_ROW->name != '') {
              ?>
                  <option value="<?= $C_TEAMS_ROW->id ?>" <?= ($C_TEAMS_ROW->id == $team) ? 'Selected' : ''; ?>><?= $C_TEAMS_ROW->name ?></option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>

        <div class="col-md-2 " <?php echo ($DISP_VIEW_LINE ? "" : "hidden") ?>>
          <p class="mb-1 text-secondary ">Line</p>
          <select id="filter_by_line" class="form-control filter_by">
            <?php
            if ($C_LINES) {
            ?>
              <option value="" <?php foreach ($C_LINES as $DISP_Line_ROW_1) {
                                  if ($DISP_Line_ROW_1->name == '') {
                                    echo 'selected';
                                  }
                                } ?>>All Lines</option>
              <?php
              foreach ($C_LINES as $DISP_Line_ROW) {
                if ($DISP_Line_ROW->name != '') {
              ?>
                  <option value="<?= $DISP_Line_ROW->id ?>" <?= ($DISP_Line_ROW->id == $line) ? 'Selected' : ''; ?>><?= $DISP_Line_ROW->name ?></option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>

        <div class="col-md-0 mx-1">
          <p class="mb-1 text-secondary ">Action</p>
          <a href="#" id="btn_clear_filter" class="col btn btn-primary mx-1"><img style="height: 1rem; width: 1rem;" src="<?= base_url('assets_system/icons/clear_filter.svg')?>" alt=""/>&nbsp;Clear Filter</a>
        </div>
      </div>

      <div class="card border-0 mt-4" style="padding: 0px; margin: 0px">
        <div class="p-2">
          <div>
            <div class='justify-content-between'>
              <div class='row'>
                <div class="col d-flex justify-content-end align-items-center">
                  <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                  <ul class="d-inline pagination m-0 p-0 ">
                    <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&dept=$dept&sec=$sec&group=$group&line=$line&division=$division&status=$status'"; ?>>< </a>  </li>
                    <li><a href="?page=1&row=<?= $row ?>&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&status=<?= $status ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                    <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                    <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&status=<?= $status ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                    <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                    <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&status=<?= $status ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                    <li><a <?php if ($current_page >= $last_page - 1 || $last_page == 3)  echo "hidden"; ?>>... </a></li>
                    <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&status=<?= $status ?>" <?php if ($current_page == $last_page || $last_page == 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                    <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&dept=$dept&sec=$sec&group=$group&line=$line&division=$division&status=$status'"; ?>>> </a></li>
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
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="table-responsive" style='max-height:75vh;'>
              <table class="table table-hover table-bordered mb-0" id="TableToExport">
                <thead style='position:sticky;top:-1px'>
                  <tr>
                    <th class="th-lg">EMPLOYEE&nbsp;ID</th>
                    <th class="th-xl">FULL&nbsp;NAME</th>
                    <th class="th-sm">INFO COUNT</th>
                    <th class="th-lg">EMPLOYMENT&nbsp;TYPE</th>
                    <th class="th-lg">POSITION</th>
                    <th class="th-lg" <?php echo ($DISP_VIEW_COMPANY ? "" : "hidden") ?>>COMPANY</th>
                    <th class="th-lg" <?php echo ($DISP_VIEW_BRANCH ? "" : "hidden") ?>>BRANCH</th>
                    <th class="th-lg" <?php echo ($DISP_VIEW_DEPARTMENT ? "" : "hidden") ?>>DEPARTMENT</th>
                    <th class="th-lg" <?php echo ($DISP_VIEW_DIVISION ? "" : "hidden") ?>>DIVISION</th>
                    <th class="th-lg" <?php echo ($DISP_VIEW_SECTION ? "" : "hidden") ?>>SECTION</th>
                    <th class="th-lg" <?php echo ($DISP_VIEW_GROUP ? "" : "hidden") ?>>GROUP</th>
                    <th class="th-lg" <?php echo ($DISP_VIEW_TEAM ? "" : "hidden") ?>>TEAM</th>
                    <th class="th-lg" <?php echo ($DISP_VIEW_LINE ? "" : "hidden") ?>>LINE</th>
                  </tr>
                </thead>

                <tbody id="table_container">
                  <?php
                  if ($DISP_EMP_LIST) {
                    foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) {
                      if (!empty($DISP_EMP_LIST_ROW->col_midl_name)) {
                        $midl_ini = $DISP_EMP_LIST_ROW->col_midl_name[0] . '.';
                      } else {
                        $midl_ini = '';
                      } ?>
                      <tr>
                       
                        <td><?= $DISP_EMP_LIST_ROW->col_empl_cmid ?></td>
                        <td class="empl_img">

                          <a href="<?= base_url() ?>employees/personal?id=<?= $DISP_EMP_LIST_ROW->id ?>">
                            <img width="30px" height='30px' class=" rounded-circle avatar elevation-2" style="object-fit:scale-down" src="
                            <?php if ($DISP_EMP_LIST_ROW->col_imag_path) {
                              echo base_url() . 'assets_user/user_profile/' . $DISP_EMP_LIST_ROW->col_imag_path;
                            } else {
                              echo base_url() . 'assets_system/images/default_user.jpg';
                            } ?>">&nbsp;&nbsp;<?= $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name . ' ' . $midl_ini ?>
                          </a>
                        </td>

                        <td> <?php if (get_document_count($C_ALL_DOCUMENTS, $DISP_EMP_LIST_ROW->id) + get_emergency_count($C_ALL_EMERGENCY, $DISP_EMP_LIST_ROW->id) + get_dependents_count($C_ALL_DEPENDENTS, $DISP_EMP_LIST_ROW->id) + get_count($DISP_EMP_LIST, $DISP_EMP_LIST_ROW->id) > 0) { ?>
                            <span class="missing_count">
                              <?= (get_document_count($C_ALL_DOCUMENTS, $DISP_EMP_LIST_ROW->id) +  get_emergency_count($C_ALL_EMERGENCY, $DISP_EMP_LIST_ROW->id) + get_dependents_count($C_ALL_DEPENDENTS, $DISP_EMP_LIST_ROW->id) + get_count($DISP_EMP_LIST, $DISP_EMP_LIST_ROW->id)); ?></span>
                          <?php } else { ?>
                            <span><i class="fa-solid fa-circle-check fa-xl" style="color: #00e004;"></i></span>
                          <?php } ?>
                        </td>
                        <td><?= convert_id2name($C_TYPE, $DISP_EMP_LIST_ROW->col_empl_type)  ?></td>
                        <td><?= convert_id2name($C_POSITIONS, $DISP_EMP_LIST_ROW->col_empl_posi) ?></td>
                        <td <?php echo ($DISP_VIEW_COMPANY ? "" : "hidden") ?>><?= convert_id2name($C_COMPANIES, $DISP_EMP_LIST_ROW->col_empl_company) ?></td>
                        <td <?php echo ($DISP_VIEW_BRANCH ? "" : "hidden") ?>><?= convert_id2name($C_BRANCH, $DISP_EMP_LIST_ROW->col_empl_branch) ?></td>
                        <td <?php echo ($DISP_VIEW_DEPARTMENT ? "" : "hidden") ?>><?= convert_id2name($C_DEPARTMENTS, $DISP_EMP_LIST_ROW->col_empl_dept) ?></td>
                        <td <?php echo ($DISP_VIEW_DIVISION ? "" : "hidden") ?>><?= convert_id2name($C_DIVISIONS, $DISP_EMP_LIST_ROW->col_empl_divi) ?></td>
                        <td <?php echo ($DISP_VIEW_SECTION ? "" : "hidden") ?>><?= convert_id2name($C_SECTIONS, $DISP_EMP_LIST_ROW->col_empl_sect) ?></td>
                        <td <?php echo ($DISP_VIEW_GROUP ? "" : "hidden") ?>><?= convert_id2name($C_GROUPS, $DISP_EMP_LIST_ROW->col_empl_group) ?></td>
                        <td <?php echo ($DISP_VIEW_TEAM ? "" : "hidden") ?>><?= convert_id2name($C_TEAMS, $DISP_EMP_LIST_ROW->col_empl_team) ?></td>
                        <td <?php echo ($DISP_VIEW_LINE ? "" : "hidden") ?>><?= convert_id2name($C_LINES, $DISP_EMP_LIST_ROW->col_empl_line) ?></td>
                      </tr>
                    <?php
                    }
                  } else { ?>
                    <tr class="table-active">
                      <td colspan="12">
                        <center>No Records</center>
                      </td>
                    </tr>
                  <?php }
                  ?>
                </tbody>
              </table>

              <div class="w-100 text-center">
                <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <aside class="control-sidebar control-sidebar-dark"></aside>
  <div class="modal fade class_modal_approve" id="modal_bulk_activate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h4 class="modal-title ml-1" id="exampleModalLabel">Bulk Activate </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>

        <form action="<?php echo base_url(); ?>employees/employee_bulk_activate" id="form_bulk_activate" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <ul id="approve_list_id" class="row" style="background: #e7f4e4;"></ul>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <input type="hidden" name="EMPLOYEE_ID" id="EMPLOYEE_ID">
            <input type="hidden" name="ACTIVATE" id="ACTIVATE" value="0">
            <a type="submit" id="submit_bulk_approve" class='btn btn-primary text-light'>&nbsp; Save</a>
            <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade class_modal_reject" id="modal_bulk_deactivate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h4 class="modal-title ml-1" id="exampleModalLabel">Bulk Deactivate </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>

        <form action="<?php echo base_url(); ?>employees/employee_bulk_deactivate" id="form_bulk_deactivate" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <ul id="reject_list_id" class="row" style="background: #e7f4e4;"></ul>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <input type="hidden" name="EMPLOYEE_DEACTIVATE_ID" id="EMPLOYEE_DEACTIVATE_ID">
            <input type="hidden" name="ACTIVATE" id="ACTIVATE" value="1">
            <a type="submit" id="submit_bulk_reject" class='btn btn-primary text-light'>&nbsp; Save</a>
            <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_show_termination_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header pb-0" style="border-bottom: none;">
          <h4 class="modal-title ml-1" id="exampleModalLabel">Termination Details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <hr>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Date</label>
                <p class="mb-0" id="termination_date"></p>
              </div>

              <div class="form-group">
                <label>Type</label>
                <p class="mb-0" id="termination_type"></p>
              </div>

              <div class="form-group">
                <label>Reason</label>
                <p class="mb-0" id="termination_reason"></p>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button class='btn btn-primary text-light' data-dismiss="modal" aria-label="Close">&nbsp; Remove</button>
        </div>
      </div>
    </div>
  </div>

  <?php
  $page_count = $DISP_ROW_COUNT / 10;
  if (($DISP_ROW_COUNT % 10) != 0) {
    $page_count = $page_count++;
  }
  $page_count = ceil($page_count);
  ?>
  <input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT ?>">
  <input type="hidden" id="page_count" value="<?= $page_count ?>">
  <input type="hidden" id="current_page" value="">
  <script>
    $(function() {
      $('[data-toggle="tooltip"]').tooltip()
    })
  </script>

  <?php $this->load->view('templates/jquery_link'); ?>

  <?php
  if ($this->session->userdata('SESS_ERR_IMAGE')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_ERR_IMAGE'); ?>',
        '',
        'warning'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_ERR_IMAGE');
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
  if ($this->session->userdata('SESS_WARN_MSG_INSRT_CSV')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_WARN_MSG_INSRT_CSV'); ?>',
        '',
        'warning'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_WARN_MSG_INSRT_CSV');
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
  if ($this->session->userdata('SESS_SUCC_INSRT')) {
  ?>
    <script>
      $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('SESS_SUCC_INSRT'); ?>'
      })
    </script>
  <?php
    $this->session->unset_userdata('SESS_SUCC_INSRT');
  }
  ?>

  <?php
  if ($this->session->userdata('SESS_ERROR_INSRT')) {
  ?>
    <script>
      $(document).Toasts('create', {
        class: 'bg-danger toast_width',
        title: 'Unable to Register!',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('SESS_ERROR_INSRT'); ?>'
      })
    </script>
  <?php
    $this->session->unset_userdata('SESS_ERROR_INSRT');
  }
  ?>

  <?php function convert_id2name($array, $pos)
  {
    $name = "";
    foreach ($array as $e) {
      if ($e->id == $pos) {
        $name = $e->name;
      }
    }
    if ($name == "") {
      $name = "";
    }
    return $name;
  }

  function get_document_count($array, $id)
  {
    $count = 0;

    foreach ($array as $x) {
      if ($x->col_empl_id == $id) {
        ($x->col_empl_id) ? $count++ : '';
      }
    }

    if ($count == 0) {
      return 1;
    } else {
      return 0;
    }
  }

  function get_emergency_count($array, $id)
  {
    $count = 0;

    foreach ($array as $x) {
      if ($x->empid == $id) {
        ($x->empid) ? $count++ : '';
      }
    }

    if ($count == 0) {
      return 1;
    } else {
      return 0;
    }
  }

  function get_dependents_count($array, $id)
  {
    $count = 0;

    foreach ($array as $x) {
      if ($x->col_depe_empid == $id) {
        ($x->col_depe_empid) ? $count++ : '';
      }
    }

    if ($count == 0) {
      return 1;
    } else {
      return 0;
    }
  }

  function get_count($array, $id)
  {
    $count = 0;
    foreach ($array as $x) {
      if ($x->id == $id) {
        (!$x->col_empl_cmid) ? $count++ : '';
        (!$x->col_frst_name) ? $count++ : '';
        (!$x->col_last_name) ? $count++ : '';
        (!$x->col_mart_stat) ? $count++ : '';
        (!$x->col_birt_date) ? $count++ : '';
        (!$x->col_empl_gend) ? $count++ : '';
        (!$x->col_empl_nati) ? $count++ : '';
        (!$x->col_shir_size) ? $count++ : '';
        (!$x->col_mobl_numb) ? $count++ : '';
        (!$x->col_home_addr) ? $count++ : '';
        (!$x->col_curr_addr) ? $count++ : '';
        (!$x->col_hire_date) ? $count++ : '';
        (!$x->col_empl_type) ? $count++ : '';
        (!$x->col_empl_posi) ? $count++ : '';
        (!$x->col_empl_sssc) ? $count++ : '';
        (!$x->col_empl_phil) ? $count++ : '';
        (!$x->col_empl_btin) ? $count++ : '';
        (!$x->col_empl_hdmf) ? $count++ : '';
        (!$x->bank_name) ? $count++ : '';
        (!$x->account_type) ? $count++ : '';
        (!$x->account_number) ? $count++ : '';
        (!$x->branch_name) ? $count++ : '';
        (!$x->payment_type) ? $count++ : '';
      }
    }
    return $count;
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
      console.log('search_select', search_select);
      if (!search_select) return;
      if (search_select == 'all') {
        filter_clear();
      } else {
        window.location.href = "?search=" + search_select.replace(/\s/g, '_');
      }
    }

    function filter_clear() {
      document.location.href = "inactive_list";
    }
  </script>
  <script>
    $(document).ready(function() {

      $('#filter_by_branch').select2();
      $('#filter_by_company').select2();
      $('#filter_by_department').select2();
      $('#filter_by_division').select2();
      $('#filter_by_section').select2();
      $('#filter_by_group').select2();
      $('#filter_by_team').select2();
      $('#filter_by_line').select2();

      var base_url                         = '<?= base_url() ?>';
      var department;
      var section;
      var group;
      var line;
      var status;
      var department_arr;
      var section_arr;
      var group_arr;
      var line_arr;
      var url_get_filter_data              = '<?= base_url() ?>employees/get_filter_data';
      var url_get_filter_data_department   = '<?= base_url() ?>employees/get_filter_data_department';
      var url_get_filter_data_section      = '<?= base_url() ?>employees/get_filter_data_section';
      var url_get_filter_data_group        = '<?= base_url() ?>employees/get_filter_data_group';
      var url_get_filter_data_line         = '<?= base_url() ?>employees/get_filter_data_line';
      var url_get_all_filter_data          = '<?= base_url() ?>employees/get_all_filter_data';
      var url_filter_by_department         = '<?= base_url() ?>attendance/get_employee_data_filter_by_dept';
      var url_filter_section_by_department = '<?= base_url() ?>attendance/get_employee_section_data_filter_by_dept';
      var url_filter_by_section            = '<?= base_url() ?>attendance/get_employee_data_filter_by_sect';
      var url_get_all_empl_data            = '<?= base_url() ?>employees/get_all_employee_data';
      var url_filter_by_group              = '<?= base_url() ?>attendance/get_employee_data_filter_by_group';
      var url_filter_by_line               = '<?= base_url() ?>attendance/get_employee_data_filter_by_line';
      var url_filter_by_status             = '<?= base_url() ?>attendance/get_employee_data_filter_by_status';
      var url_get_employee                 = '<?php echo base_url(); ?>employees/get_all_employee';
      jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "formatted-num-pre": function(a) {
          a = (a === "-" || a === "") ? 0 : a.replace(/[^\d\-\.]/g, "");
          return parseFloat(a);
        },
        "formatted-num-asc": function(a, b) {
          return a - b;
        },
        "formatted-num-desc": function(a, b) {
          return b - a;
        }
      });

      $('#employee_tbl_filter').parent().parent().hide();
      $('#employee_tbl_info').parent().parent().hide();
      $('select.filter_by').on('change', function() {
        var filter_dept       = $("#filter_by_department").val();
        var filter_sec        = $("#filter_by_section").val();
        var filter_group      = $("#filter_by_group").val();
        var filter_line       = $("#filter_by_line").val();
        var filter_team       = $("#filter_by_team").val();
        var filter_branch     = $("#filter_by_branch").val();
        var filter_by_company = $("#filter_by_company").val();
        var filter_division   = $("#filter_by_division").val();
        var filter_status     = $("#filter_by_status").val();
        console.log(filter_dept)
        document.location.href = "inactive_list?page=<?= $current_page ?>&row=<?= $row ?>" + "&dept=" + filter_dept + '&sec=' + filter_sec + '&group=' + filter_group + '&line=' + filter_line + '&division=' +
          filter_division + '&status=1' + '&branch=' + filter_branch + '&team=' + filter_team + '&company=' + filter_by_company;
      })

      $('#btn_clear_filter').click(function() {
        $("#filter_by_division").val("");
        $("#filter_by_branch").val("");
        $("#filter_by_company").val("");
        $("#filter_by_team").val("");
        $("#filter_by_status").val("");
        $("#filter_by_line").val("");
        $("#filter_by_group").val("");
        $("#filter_by_section").val("");
        $("#filter_by_department").val("");
        document.location.href = "inactive_list";
      })

      $("#clear_search_btn").on("click", function() {
        var url = window.location.href.split("?")[0];
        window.location = url
      });

      $("#search_btn").on("click", function() {
        search_data();
      });

      $("#search_data").on("keypress", function(e) {
        if (e.which === 13) {
          search_data();
        }
      });

      function search_data() {
        $('#search_data').val();
        $("#filter_by_division").val("");
        $("#filter_by_branch").val("");
        $("#filter_by_company").val("");
        $("#filter_by_team").val("");
        $("#filter_by_status").val("");
        $("#filter_by_line").val("");
        $("#filter_by_group").val("");
        $("#filter_by_section").val("");
        $("#filter_by_department").val("");
        var optionValue = $('#search_data').val();
        document.location.href = "inactive_list?" + "all=" + optionValue.replace(/\s/g, '_') + "&status=1";
      }

      function search(search_val) {
        var url_get_searched_employee = '<?php echo base_url(); ?>employees/get_searched_employee';
        $('#table_container').html('');
        get_searched_employee(url_get_searched_employee, search_val).then(function(data) {
          Array.from(data).forEach(function(e) {
            console.log(e)
            var empl_image = "<?= base_url() ?>user_images/default_profile_img3.png";
            if (e.col_imag_path) {
              var empl_image = "<?= base_url() ?>user_images/" + e.col_imag_path;
            }
            if (e.col_midl_name) {
              var midl_ini = e.col_midl_name + '.';
            } else {
              var midl_ini = '';
            }
            var empl_name = e.col_last_name + ', ' + e.col_frst_name + ' ' + midl_ini;
            $('#table_container').append(`
                            <tr class="bank_row" data-toggle="modal" data-target="#modal_edit_bank" empl_cmid="` + e.col_empl_cmid + `">
                                <td>` + e.col_empl_cmid + `</td>
                                <td>
                                    <a href = "<?= base_url() ?>employees/personal?id=` + e.id + `">
                                        <img class="rounded-circle avatar " width="35" height="35" src="` + empl_image + `">&nbsp;&nbsp;` + empl_name + `
                                    </a>
                                </td>
                                <td>` + e.col_empl_type + `</td>
                                <td>` + e.col_empl_posi + `</td>
                                <td>` + e.col_empl_dept + `</td>
                                <td>` + e.col_empl_sect + `</td>
                                <td>` + e.col_empl_group + `</td>
                                <td>` + e.col_empl_line + `</td>
                            </tr>
                        `)
          })
        })
      }

      function reset_table() {
        $('#table_container').html('');
        var row_count = $('#row_count').val();
        var page_count = $('#page_count').val();
        var page_num = 1;
        if ($('#current_page').val()) {
          var page_num = $('#current_page').val();
        }
        get_employee(url_get_employee, page_num).then(function(data) {
          Array.from(data).forEach(function(e) {
            console.log(e)
            var empl_image = "<?= base_url() ?>user_images/default_profile_img3.png";
            if (e.col_imag_path) {
              var empl_image = "<?= base_url() ?>user_images/" + e.col_imag_path;
            }
            if (e.col_midl_name) {
              var midl_ini = e.col_midl_name + '.';
            } else {
              var midl_ini = '';
            }
            var empl_name = e.col_last_name + ', ' + e.col_frst_name + ' ' + midl_ini;
            $('#table_container').append(`
                            <tr class="bank_row" data-toggle="modal" data-target="#modal_edit_bank" empl_cmid="` + e.col_empl_cmid + `">
                                <td>` + e.col_empl_cmid + `</td>
                                <td>
                                    <a href = "<?= base_url() ?>employees/personal?id=` + e.id + `">
                                        <img class="rounded-circle avatar " width="35" height="35" src="` + empl_image + `">&nbsp;&nbsp;` + empl_name + `
                                    </a>
                                </td>
                                <td>` + e.col_empl_type + `</td>
                                <td>` + e.col_empl_posi + `</td>
                                <td>` + e.col_empl_dept + `</td>
                                <td>` + e.col_empl_sect + `</td>
                                <td>` + e.col_empl_group + `</td>
                                <td>` + e.col_empl_line + `</td>
                            </tr>
                        `)
          })
        })
      }

      async function get_searched_employee(url, search) {
        var formData = new FormData();
        formData.append('search', search);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      function display_filtered_empl_status(department, section, line, group, status) {
        $('#loader_gif').show();
        $('#table_container').html('');
        if (status == 0) {
          get_filter_data(url_get_filter_data, department, line, group, section, status).then(function(data) {
            if (data.length > 0) {
              Array.from(data).forEach(function(x) {
                var user_image = '';
                if (x.col_imag_path) {
                  user_image = base_url + 'user_images/' + x.col_imag_path;
                } else {
                  user_image = base_url + 'user_images/default_profile_img3.png';
                }
                var fullname = '';
                if ((x.col_frst_name) && (x.col_last_name)) {
                  if (x.col_midl_name) {
                    fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + x.col_midl_name[0] + '.';
                  } else {
                    fullname = x.col_last_name + ', ' + x.col_frst_name;
                  }
                }
                $('#loader_gif').hide();
                $('#table_container').append(`
                                    <tr>
                                        <td>` + x.col_empl_cmid + `</td>
                                        <td><a href = "<?= base_url() ?>employees/personal?id=` + x.id + `">
                                            <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                                        </td>
                                        <td>` + x.col_empl_type + `</td>
                                        <td>` + x.col_empl_posi + `</td>
                                        <td>` + x.col_empl_dept + `</td>
                                        <td>` + x.col_empl_sect + `</td>
                                        <td>` + x.col_empl_group + `</td>
                                        <td>` + x.col_empl_line + `</td>
                                    </tr>
                                `);
              })
            } else {
              $('#loader_gif').hide();
              $('#table_container').append(`
                                    <td colspan="7">No Employees Detected</td>
                            `);
            }
            $('#total_employees').text($('#table_container tr').length);
          })
        } else {
          get_filter_data(url_get_filter_data, department, line, group, section, status).then(function(data) {
            if (data.length > 0) {
              Array.from(data).forEach(function(x) {
                var user_image = '';
                if (x.col_imag_path) {
                  user_image = base_url + 'user_images/' + x.col_imag_path;
                } else {
                  user_image = base_url + 'user_images/default_profile_img3.png';
                }
                var fullname = '';
                if ((x.col_frst_name) && (x.col_last_name)) {
                  if (x.col_midl_name) {
                    fullname = x.col_last_name + ', ' + x.col_frst_name + ' ' + x.col_midl_name[0] + '.';
                  } else {
                    fullname = x.col_last_name + ', ' + x.col_frst_name;
                  }
                }
                $('#loader_gif').hide();
                $('#table_container').append(`
                                    <tr data-toggle="modal" data-target="#modal_show_termination_details" style="cursor:pointer">
                                        <td>` + x.col_empl_cmid + `</td>
                                        <td><a href = "<?= base_url() ?>employees/personal?id=` + x.id + `">
                                            <img class="rounded-circle avatar " width="35" height="35" src="` + user_image + `">&nbsp;&nbsp;` + fullname + `</a>
                                        </td>
                                        <td>` + x.col_empl_type + `</td>
                                        <td>` + x.col_empl_posi + `</td>
                                        <td>` + x.col_empl_dept + `</td>
                                        <td>` + x.col_empl_sect + `</td>
                                        <td>` + x.col_empl_group + `</td>
                                        <td>` + x.col_empl_line + `</td>
                                    </tr>
                                `);
              })
            } else {
              $('#loader_gif').hide();
              $('#table_container').append(`
                                    <td colspan="7">No Employees Detected</td>
                            `);
            }
            $('#total_employees').text($('#table_container tr').length);
          })
        }
      }

      function capitalizeFirstLetter(word) {
        var newStr = word.split('');
        return newStr[0].toUpperCase();
      }
 
      var row_count  = $('#row_count').val();
      var page_count = $('#page_count').val();


      $('#submit_bulk_approve').click(function() {
        $('#form_bulk_activate').submit();
      })

      $('#submit_bulk_reject').click(function() {
        $('#form_bulk_deactivate').submit();
      })


      $('#bulk_activate').click(function() {
        let selected_id      = [];
        let selected_empl_id = [];
        let selected_row_id  = [];

        $('#approve_list_id').empty();
        $('#select_item input[type=checkbox]:checked').each(function() {
          let selected_item = $(this).val();
          let att_empl_id = $(this).attr('employee_id');
          let att_row_id = $(this).attr('row_id');

          selected_id.push(selected_item);
          selected_empl_id.push(att_empl_id);
          selected_row_id.push(att_row_id);
        })

        if (selected_id.length > 0) {
          $('.class_modal_approve').prop('id', 'modal_bulk_activate');
          let empl_ids = selected_empl_id.join(',');
          $('#EMPLOYEE_ID').val(empl_ids);
          selected_row_id.forEach(function(data) {
            $('#approve_list_id').append(`<li class="col-md-6">ID : <strong>EMPLOYEE ID : ${data}</strong></li>`);
          })
        } else {
          $('.class_modal_approve').prop('id', '');
          Swal.fire(
            'Please Select Employee!',
            '',
            'warning'
          )
        }
      })

      $('#bulk_deactivate').click(function() {
        let selected_id      = [];
        let selected_empl_id = [];
        let selected_row_id  = [];
        $('#APPROVAL_ID').empty();
        $('#reject_list_id').empty();
        $('#select_item input[type=checkbox]:checked').each(function() {
          let selected_item = $(this).val();
          let att_empl_id   = $(this).attr('employee_id');
          let att_row_id    = $(this).attr('row_id');
          selected_id.push(selected_item);
          selected_empl_id.push(att_empl_id);
          selected_row_id.push(att_row_id);
        })
        if (selected_id.length > 0) {
          $('.class_modal_reject').prop('id', 'modal_bulk_deactivate');
          let empl_ids = selected_empl_id.join(',');
          $('#EMPLOYEE_DEACTIVATE_ID').val(empl_ids);
          selected_row_id.forEach(function(data) {
            $('#reject_list_id').append(`<li class="col-md-6">ID : <strong>EMPLOYEE ID : ${data}</strong></li>`);
          })
        } else {
          $('.class_modal_reject').prop('id', '');
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

      $('#row_dropdown').on('change', function() {
        var row_val = $(this).val();
        document.location.href = base_url + "employees/inactive_list?page=1&row=" + row_val + "&dept=<?= $dept ?>&sec=<?= $sec ?>&group=<?= $group ?>&line=<?= $line ?>&division=<?= $division ?>&status=<?= $status ?>";
      });

      async function get_employee(url, page_num) {
        var formData = new FormData();
        formData.append('page_num', page_num);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      async function update_status_remarks(url, date, empl_id, status, remarks) {
        var formData = new FormData();
        formData.append('date', date);
        formData.append('empl_id', empl_id);
        formData.append('status', status);
        formData.append('remarks', remarks);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      async function get_all_employee_data(url) {
        var formData = new FormData();
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      async function get_employee_section_data_filter_by_dept(url, department) {
        var formData = new FormData();
        formData.append('department', department);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      async function get_employee_data_filter_by_group(url, group) {
        var formData = new FormData();
        formData.append('group', group);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      async function get_employee_data_filter_by_line(url, line) {
        var formData = new FormData();
        formData.append('line', line);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      async function get_employee_data_filter_by_status(url, status) {
        var formData = new FormData();
        formData.append('status', status);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      async function get_employee_data_filter_by_sect(url, section) {
        var formData = new FormData();
        formData.append('section', section);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      async function get_employee_data_filter_by_dept(url, department) {
        var formData = new FormData();
        formData.append('department', department);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      async function get_filter_data(url, department, line, group, section, status) {
        var formData = new FormData();
        formData.append('department', department);
        formData.append('line', line);
        formData.append('group', group);
        formData.append('section', section);
        formData.append('status', status);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }

      async function get_all_filter_data(url) {
        var formData = new FormData();
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }
    })
  </script>

  <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function() {
      var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
      XLSX.writeFile(wb, "Employee Directory.xlsx");
    });
  </script> -->
</body>

</html>