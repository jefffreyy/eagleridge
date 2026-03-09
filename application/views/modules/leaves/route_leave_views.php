<html>
<?php $this->load->view('templates/css_link'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
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
  .check_approved{
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
</style>
<body>

  <div class="content-wrapper">
    <div class="container-fluid p-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url() ?>leaves">Leave</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Approval Route - Leave
          </li>
        </ol>
      </nav>
      <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title"><a href="<?= base_url().'leaves';?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Approval Route - Leave <h1>
        </div>
        <div class="col-md-6 button-title">
          <!-- <a href="<?= base_url() . 'leaves/add_approval' ?>" class=" btn technos-button-green shadow-none rounded" id="" style="display:none"><i class="fas fa-plus"></i>&nbsp;Add Approval</a> -->
          <a href="<?= base_url() . 'leaves/csv_import' ?>" class=" btn technos-button-green shadow-none rounded" id="import_csv"><i class="fas fa-file-import"></i>&nbsp;Bulk Import</a>
          <a href="#" class=" btn technos-button-gray shadow-none rounded" id="btn_export"><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>
        </div>
      </div>
      <hr>
      <div class="pb-1">

      </div>
      <?php
        if (isset($_GET['branch'])) {$param_branch = $_GET['branch']; } else { $param_branch = ""; }
        if (isset($_GET['dept'])) {$param_dept = $_GET['dept']; } else { $param_dept = ""; }
        if (isset($_GET['division'])) {$param_division = $_GET['division']; } else { $param_division = ""; }
        if (isset($_GET['section'])) {$param_section = $_GET['section']; } else { $param_section = ""; }
        if (isset($_GET['group'])) {$param_group = $_GET['group']; } else { $param_group = ""; }
        if (isset($_GET['team'])) {$param_team = $_GET['team']; } else { $param_team = ""; }
        if (isset($_GET['line'])) {$param_line = $_GET['line']; } else { $param_line = ""; }


      ?>

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

      <div class="row mb-4">
          <div class="col-md-2" <?php echo($DISP_VIEW_BRANCH ? "" :"hidden") ?>>
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

          <div class="col-md-2" <?php echo($DISP_VIEW_DEPARTMENT ? "" :"hidden") ?>>
            <p class="mb-1 text-secondary ">Department</p>
            <select name="dept" id="filter_by_department" class="form-control">
              <?php
              if ($DISP_DISTINCT_DEPARTMENT) {
              ?>
                <option value="all" <?php foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW_1) {
                                      if ($DISP_DISTINCT_DEPARTMENT_ROW_1->name == '') {echo 'selected'; }
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

          <div class="col-md-2" <?php echo($DISP_VIEW_DIVISION ? "" :"hidden") ?>>
            <p class="mb-1 text-secondary ">Division</p>
            <select name="dept" id="filter_by_division" class="form-control">
              <?php
              if ($DISP_DISTINCT_DIVISION) {
              ?>
                <option value="all" <?php foreach ($DISP_DISTINCT_DIVISION as $DISP_DISTINCT_DIVISION_ROW_1) {
                                      if ($DISP_DISTINCT_DIVISION_ROW_1->name == '') {echo 'selected'; }
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
        
          <div class="col-md-2" <?php echo($DISP_VIEW_SECTION ? "" :"hidden") ?>>
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

          <div class="col-md-2" <?php echo($DISP_VIEW_GROUP ? "" :"hidden") ?>>
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

          <div class="col-md-2" <?php echo($DISP_VIEW_TEAM ? "" :"hidden") ?>>
            <p class="mb-1 text-secondary ">Team</p>
            <select name="dept" id="filter_by_team" class="form-control">
              <?php
              if ($DISP_DISTINCT_TEAM) {
              ?>
                <option value="all" <?php foreach ($DISP_DISTINCT_TEAM as $DISP_DISTINCT_TEAM_ROW_1) {
                                      if ($DISP_DISTINCT_TEAM_ROW_1->name == '') {echo 'selected'; }
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

          <div class="col-md-2" <?php echo($DISP_VIEW_LINE ? "" :"hidden") ?>>
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
        

        <!-- <div class="col-md-2  pb-2" >
          <label for="">Status</label>
          <select id="filter_by_status" class="form-control">
            <option value="">All Status</option>
            <option value="0" <?= ($status == '0') ? 'Selected' : ''; ?>>Active</option>
            <option value="1" <?= ($status == '1') ? 'Selected' : ''; ?>>Inactive</option>
          </select>
        </div>
        <div class="col-md-2  pb-2">
          <label for="">Action</label>
          <a href="#" id="btn_clear_filter" class="btn technos-button-gray" style="width: 100%">Clear Filter</a>
        </div> -->

        <div class="col-md-2">
            <p class="mb-1 text-secondary ">Action</p>
            <a href=<?= base_url() ."leaves/approval_routes"?> id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
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
                <th rowspan="2" class="text-center emp">Employee</th>
                <th colspan="2" class="text-center">Approver 1</th>
                <th colspan="2" class="text-center">Approver 2</th>
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
                        <input type="checkbox" name="approval_name" class="check_single" approval_id="<?= $DISP_APPROVER_ROW['id']?>" employee_id="<?= $DISP_APPROVER_ROW['id']; ?>" value="<?= $DISP_APPROVER_ROW['id'] ?>">
                      </td>
                      <td
                      onclick="directs(<?= $DISP_APPROVER_ROW['id']?>)" class="hover"
                      ><?= convert_cmid($DISP_EMPLOYEES, $DISP_APPROVER_ROW["id"]) . " - ". convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["id"])?> </td>
                   
                   <td><a><?= convert_cmid($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver1A"]) . " - ". convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver1A"]) ?></a></td>
                   <td><a><?= convert_cmid($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver1B"]) . " - ". convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver1B"]) ?></a></td>
                   <td><a><?= convert_cmid($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver2A"]) . " - ". convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver2A"]) ?></a></td>
                   <td><a><?= convert_cmid($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver2B"]) . " - ". convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver2B"]) ?></a></td>
                   <td><a><?= convert_cmid($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver3A"]) . " - ". convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver3A"]) ?></a></td>
                   <td><a><?= convert_cmid($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver3B"]) . " - ". convert_data($DISP_EMPLOYEES_NONFILTERED, $DISP_APPROVER_ROW["approver3B"]) ?></a></td>

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
        <form action="<?php echo base_url(); ?>leaves/assign_approvers_leave" id="form_updt_approvers" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <ul id="approval_list_id" class="row" style="background: #e7f4e4;"></ul>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="required " for="UPDT_APPROVER_1A">Approver 1-A
                  </label>
                  <select style='width:100%' class="form-control" name="UPDT_APPROVER_1A" id="updt_approver_1a" >
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
                  <label class="required " for="UPDT_APPROVER_1B">Approver 1-B
                  </label>
                  <select name="UPDT_APPROVER_1B" id="updt_approver_1b" class="form-control" style='width:100%'>
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
                  <label class="required " for="UPDT_APPROVER_2A">Approver 2-A
                  </label>
                  <select name="UPDT_APPROVER_2A" id="updt_approver_2a" class="form-control" style='width:100%'>
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
                  <label class="required " for="UPDT_APPROVER_2B">Approver 2-B
                  </label>
                  <select name="UPDT_APPROVER_2B" id="updt_approver_2b" class="form-control" style='width:100%'>
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
                  <label for="UPDT_APPROVER_3A">Approver 3-A
                  </label>
                  <select name="UPDT_APPROVER_3A" id="updt_approver_3a" class="form-control" style='width:100%'>
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
                  <label for="UPDT_APPROVER_3B">Approver 3-B
                  </label>
                  <select name="UPDT_APPROVER_3B" id="updt_approver_3b" class="form-control" style='width:100%'>
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
          <input type="hidden" name="EMPLOYEE_ID" id="EMPLOYEE_ID">
            <input type="hidden" name="APPROVAL_ID" id="APPROVAL_ID">
            <input type="submit" id="" class='btn btn-primary text-light' value="Save">
            <div class="spinner-border text-primary loading_indicator_appr2_appr3" style="display: none;"></div>
          </div>
        </form>

      </div>
    </div>
  </div>
  <div class="modal fade" id="modal_groups_approver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h4 class="modal-title ml-1" id="exampleModalLabel">Approvers Per Section
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>
        <form action="<?php echo base_url(); ?>leaves/assign_approvers_leave" id="FORM_REJECT_LEAVE" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <table class="table table-hover mb-0">
                  <thead>
                    <tr>
                      <th>Sections</th>
                      <th class="text-center">Approver 1 - A</th>
                      <th class="text-center">Approver 1 - B</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($C_SECTIONS) {
                      foreach ($C_SECTIONS as $C_SECTIONS_ROW) {
                        // if($DISP_GROUP_ROW->col_empl_group != ''){
                    ?>
                        <tr class="row_group_approvers">
                          <td class="group_name"><?php if ($C_SECTIONS_ROW->name != '') {
                                                    echo $C_SECTIONS_ROW->name;
                                                  } else {
                                                    echo 'No Group';
                                                  } ?>
                          </td>
                          <td>
                            <select name="group_approver1" class="form-control group_approver1">
                              <option value="">Choose Approver 1 - A</option>
                              <?php
                              if ($DISP_EMPLOYEES) {
                                foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
                                  $group_approver_data = $this->leaves_model->MOD_CHK_GROUP_APPROVERS_EXIST($DISP_GROUP_ROW->col_empl_group);
                                  $isSelected = '';
                                  if ($group_approver_data[0]->approver1 == $DISP_EMPLOYEES_ROW->id) {
                                    $isSelected = 'selected';
                                  }
                              ?>
                                  <option value="<?= $DISP_EMPLOYEES_ROW->id ?>" <?= $isSelected ?>><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                              <?php
                                }
                              }
                              ?>
                            </select>
                          </td>
                          <td>
                            <select name="group_approver2" class="form-control group_approver2">
                              <option value="">Choose Approver 1 - B</option>
                              <?php
                              if ($DISP_EMPLOYEES) {
                                foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
                                  $group_approver_data = $this->leaves_model->MOD_CHK_GROUP_APPROVERS_EXIST($DISP_GROUP_ROW->col_empl_group);
                                  $isSelected = '';
                                  if ($group_approver_data[0]->approver2 == $DISP_EMPLOYEES_ROW->id) {
                                    $isSelected = 'selected';
                                  }
                              ?>
                                  <option value="<?= $DISP_EMPLOYEES_ROW->id ?>" <?= $isSelected ?>><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                              <?php
                                }
                              }
                              ?>
                            </select>
                          </td>
                        </tr>
                    <?php
                        // }
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class='btn btn-primary text-light' id="btn_save_group_approvers">&nbsp; Save </a>
            <div class="spinner-border text-primary loading_indicator" style="display: none;"></div>
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
  if($id != "N/A"){
    foreach ($array as $row) {
      if ($row->id == $id) {
        $name = $row->col_last_name . ' ' . $row->col_frst_name . ' ' . $row->col_midl_name;
      }elseif($id == 0){
        $name = "";
      }
    }
  }
  else{
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

      
      

      $('#approval').click(function() {
        let selected_id = [];
        let selected_att_id = [];
        let selected_empl_id = [];
        $('#APPROVAL_ID').empty();
        $('#approval_list_id').empty();
        $('#select_item input[type=checkbox]:checked').each(function() {
          let selected_item = $(this).val();
          let att_approval_id = $(this).attr('approval_id');
          let att_empl_id= $(this).attr('employee_id');
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

        window.location = base_url + "leaves/approval_routes" + page_row + "&branch=" + branch +
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

        // $("#filter_by_status").change(function() {
        //     var filter_stat = document.getElementById("filter_by_status");
        //     document.location.href = "approval_routes?"+ "status=" + filter_stat.value;
        // })

        $('#btn_clear_filter').click(function(){
          
            $("#filter_by_division").val("");
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
            console.log(data);
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
  <!--modal basic info reporting, directs  -->
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
            let employeeMiddleInitial = result.data.employeeInfo?.col_midl_name?.charAt(0);
            if(employeeMiddleInitial){`${employeeMiddleInitial}.`}else{employeeMiddleInitial= '';}
            let employeeFirstName = result.data.employeeInfo?.col_frst_name;
            if(!employeeFirstName)employeeFirstName= '';
            let employeeLastName = result.data.employeeInfo?.col_last_name;
            if(!employeeLastName)employeeLastName= '';
            if (employeeLastName || employeeFirstName || employeeMiddleInitial){
              document.getElementById("employeeFullName").textContent = `${employeeLastName}, ${employeeFirstName} ${employeeMiddleInitial}`;
            }else{document.getElementById("employeeFullName").textContent ='(No Full Name)'}
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
            let reportingToMiddleInitial = result.data.reportingTo?.col_midl_name?.charAt(0);
            if(reportingToMiddleInitial){reportingToMiddleInitial=`${reportingToMiddleInitial}.`;}else{reportingToMiddleInitial='';}
            let reportingToLastName = result.data.reportingTo?.col_last_name;
            if(!reportingToLastName)reportingToLastName='';
            let reportingToFirstName = result.data.reportingTo?.col_frst_name;
            if(!reportingToFirstName)reportingToFirstName='';
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
            }else{document.getElementById("reportingToContainer").innerHTML= '(No Redirect To)'}
            var directsParent = document.getElementById("directsParent");
            
            // console.log('directs condition', Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0)
            if (Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0) {
              directsParent.innerHTML = '';
              result.data.directsTo.forEach(function(user) {
                let directMiddleInitial = `${user.col_midl_name.charAt(0)}.`
                if(!directMiddleInitial)directMiddleInitial= null;
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
  <!-------------------- Export ----------------->
  <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function() {
      /* Create worksheet from HTML DOM TABLE */
      var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
      /* Export to file (start a download) */
      XLSX.writeFile(wb, "Route Leave.xlsx");
    });
  </script>
</body>

</html>