<html>
<?php $this->load->view('templates/css_link'); ?>

<style>
  .action_btn {
    display: flex !important;
    flex-direction: row !important;
    justify-content: center !important;
    align-items: center !important;
    margin: 0 auto;
    width: 100%;
  }

  .button-title {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: 4px;
  }
  
  .img-circle {
    border-radius: 50% !important;
    width: 100px !important;
    height: 100px !important;
    object-fit: scale-down;
  }

  .image_profile::after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    width: 1px;
    /* Width of the vertical line */
    background-color: #000;
    /* Line color */
    border-left: 1px dashed #000;
    /* Dashed line style */
  }
</style>
<style>
  .hover {
    cursor: pointer;
  }
</style>
<style>
  .main {
    overflow: hidden;
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
$this->load->library('session');

$url_count          = $this->uri->total_segments();
$url_directory      = $this->uri->segment($url_count);
function technos_encrypt($input)
{
  $ciphering = "AES-128-CTR";
  $iv_length = openssl_cipher_iv_length($ciphering);
  $options = 0;
  $encryption_iv = '6234564891013126';
  $encryption_key = "Technos";
  $result_raw = openssl_encrypt($input, $ciphering, $encryption_key, $options, $encryption_iv);
  $result = str_replace("/", "&", $result_raw);
  return $result;
}
?>
<?php
$search_data = $this->input->get('search');

$filter = $this->input->get('filter');

$search_data = str_replace("_", " ", $search_data ?? '');
$company_data   = $this->input->get('company');
$branch_data    = $this->input->get('branch');
$dept_data      = $this->input->get('dept');
$div_data       = $this->input->get('div');
$clubhouse_data = $this->input->get('clubhouse');
$section_data   = $this->input->get('section');
$group_data     = $this->input->get('group');
$team_data      = $this->input->get('team');
$line_data      = $this->input->get('line');
$id_prefix = 'LEA';
// $PAGE=1;
// $C_DATA_COUNT =0;
// $PAGES_COUNT=0;
$TAB = 'active';
$ACTIVES = 0;
$INACTIVES = 0;
// $ROW=25;

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
<html>

<body>
  <div class="content-wrapper">
    <div class="container-fluid p-4">

      <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('requests') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
            </a>&nbsp;Leave Requests<h1>
        </div>

        <div class="col-md-6 button-title d-flex justify-content-center justify-content-lg-end">
          <?php if ($multiple_request == 1) { ?>
            `<a href="<?= base_url('requests/leave_recommendation') ?>" class=" btn btn-primary shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
              &nbsp;Recommendation</a>
            <a href="<?= base_url('requests/leave_lists_multi') ?>" class=" btn btn-primary shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
              &nbsp;Multi Request</a> <?php } ?>
          <a href="<?= base_url('requests/request_leave') ?>" class=" btn btn-primary shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
            &nbsp;Add Request</a>

          <!-- <a id="btn_export" class=" btn technos-button-green shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">
              &nbsp;Export XLSX</a> -->
        </div>

      </div>
      <hr>

      <div class="filter-container <?= $filter ? 'visible' : '' ?>">
        <!-- filter starts -->
        <div class="row mb-4">
          <div class="col-md-2 <?= $DISP_VIEW_COMPANY == '0' ? 'd-none' : '' ?>">
            <p class="mb-1 text-secondary ">Company</p>
            <select name="dept" id="filter_by_company" class="filter_select form-control">
              <option value="">All Companies </option>
              <?php foreach ($COMPANIES as $row_data) : ?>
                <option value="<?= $row_data->id ?>" <?= $company_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="col-md-2 <?= $DISP_VIEW_BRANCH == '0' ? 'd-none' : '' ?>">
            <p class="mb-1 text-secondary ">Branch</p>
            <select name="dept" id="filter_by_branch" class="filter_select form-control">
              <option value="">All Branches</option>
              <?php foreach ($BRANCHES as $row_data) : ?>
                <option value="<?= $row_data->id ?>" <?= $branch_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="col-md-2 <?= $DISP_VIEW_DEPARTMENT == '0' ? 'd-none' : '' ?>">
            <p class="mb-1 text-secondary ">Department</p>
            <select name="dept" id="filter_by_department" class="filter_select form-control">
              <option value="">All Departments</option>
              <?php foreach ($DEPARTMENTS as $row_data) : ?>
                <option value="<?= $row_data->id ?>" <?= $dept_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="col-md-2 <?= $DISP_VIEW_DIVISION == '0' ? 'd-none' : '' ?>">
            <p class="mb-1 text-secondary ">Division</p>
            <select name="dept" id="filter_by_division" class="filter_select form-control">
              <option value="">All Divisions</option>
              <?php foreach ($DIVISIONS as $row_data) : ?>
                <option value="<?= $row_data->id ?>" <?= $div_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="col-md-2 <?= $DISP_VIEW_CLUBHOUSE == '0' ? 'd-none' : '' ?>">
            <p class="mb-1 text-secondary ">Clubhouse</p>
            <select name="dept" id="filter_by_clubhouse" class="filter_select form-control">
              <option value="">All Clubhouse</option>
              <?php foreach ($CLUBHOUSE as $row_data) : ?>
                <option value="<?= $row_data->id ?>" <?= $clubhouse_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="col-md-2 <?= $DISP_VIEW_SECTION == '0' ? 'd-none' : '' ?>">
            <p class="mb-1 text-secondary ">Section</p>
            <select name="section" id="filter_by_section" class="filter_select form-control">
              <option value="">All Sections</option>
              <?php foreach ($SECTIONS as $row_data) : ?>
                <option value="<?= $row_data->id ?>" <?= $section_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="col-md-2 <?= $DISP_VIEW_GROUP == '0' ? 'd-none' : '' ?>">
            <p class="mb-1 text-secondary ">Group</p>
            <select name="group" id="filter_by_group" class="filter_select form-control">
              <option value="">All Groups</option>
              <?php foreach ($GROUPS as $row_data) : ?>
                <option value="<?= $row_data->id ?>" <?= $group_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="col-md-2 <?= $DISP_VIEW_TEAM == '0' ? 'd-none' : '' ?>">
            <p class="mb-1 text-secondary ">Team</p>
            <select name="dept" id="filter_by_team" class="filter_select form-control">
              <option value="">All Teams</option>
              <?php foreach ($TEAMS as $row_data) : ?>
                <option value="<?= $row_data->id ?>" <?= $team_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="col-md-2 <?= $DISP_VIEW_LINE == '0' ? 'd-none' : '' ?>">
            <p class="mb-1 text-secondary ">Line</p>
            <select name="line" id="filter_by_line" class="filter_select form-control">
              <option value="">All Lines</option>
              <?php foreach ($LINES as $row_data) : ?>
                <option value="<?= $row_data->id ?>" <?= $line_data == $row_data->id ? 'selected' : '' ?>><?= $row_data->name ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="col-md-2">
            <p class="mb-1 text-secondary ">Status</p>
            <select class="form-control leave_status">
              <option value="">All</option>
              <?php foreach ($STATUSES as $status) { ?>
                <option value="<?= $status ?>" <?= $status == $STATUS ? 'selected' : '' ?>><?= $status ?></option>
              <?php } ?>
            </select>
          </div>
          <!-- <div class="col-md-2">
              <p class="mb-1 text-secondary ">Action</p>
              <a href="<?= base_url('leaves/leave_lists') ?>" id="btn_clear_filter" class="btn technos-button-green mx-1">Clear Filter</a>
            </div> -->
        </div>
        <!-- filter divs ends -->

      </div>



      <div class="card border-0 p-0 m-0">
        <div class="card border-0 m-0">
          <div class="p-2">

            <div class="justify-content-between">
              <div class="row">
                <div class="col-md-12 col-lg-12">
                  <div class="d-flex row justify-content-between align-items-center">
                    <div class="row d-flex justify-content-center justify-content-lg-start col-12 col-md-5 col-lg-5 mx-1">
                      <label class="col-md-12 mb-1 text-secondary">Employee</label>

                      <select class="px-1 col-12 col-lg-6 employee_select form-control w-50 " id="search_data" style="min-width:300px;width:max-content">
                        <option value=''>All</option>
                        <?php foreach ($EMPLOYEES as $employee) {
                          $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
                          if (!empty($employee->col_suffix)) $name = $name . ' ' . $employee->col_suffix;
                          if (!empty($employee->col_frst_name)) $name = $name . ', ' . $employee->col_frst_name;
                          if (!empty($employee->col_midl_name)) $name = $name . ' ' . $employee->col_midl_name[0] . '.';
                        ?>
                          <option value="<?= $employee->id ?>" <?= $search_data == $employee->id ? 'selected' : '' ?>>
                            <?= $name ?></option>
                        <?php } ?>
                      </select>
                      <button id="btnFilter" class="my-1 my-lg-0 btn btn-primary shadow-none rounded ml-1" onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg') ?>" style="margin-bottom: 1px" alt="" />&nbsp;Advance Filter</button>
                      <a href="<?= base_url('requests/leave_lists') ?>" id="btn_clear_filter" class="my-1 my-lg-0 btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="" />&nbsp;Clear</a>
                    </div>
                    <div class="d-none d-lg-flex col-sm-7 col-md-10 col-md-5 col-lg-5 justify-content-lg-end justify-content-center my-lg-0 my-2">
                      <div class="col-12 col-lg-7 d-flex justify-content-lg-end  justify-content-center align-items-center mx-2">
                        <div class="d-flex align-items-center row">

                          <div class="d-inline col-12 col-lg-6">
                            <p class="p-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                          </div>

                          <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                            <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                              <li><a <?php if ($current_page > 1) echo " class='paginate' href='?page=$prev_page&row=$row&search=$search_data'"; ?>>
                                  < </a>
                              </li>
                              <li><a class="paginate" href="?status=<?= $STATUS ?>&page=1&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                              <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                              <li><a class="paginate" href="?status=<?= $STATUS ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                              <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                              <li><a class="paginate" href="?status=<?= $STATUS ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                              <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                              <li><a class="paginate" href="?status=<?= $STATUS ?>&page=<?= $last_page ?>&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                              <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page) echo "class='paginate'  href='?status=$STATUS&page=$next_page&row=$row&search=$search_data'"; ?>>> </a></li>
                            </ul>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-1 d-none d-lg-flex justify-content-center align-items-center">
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

          <div class="table-responsive">

            <table class="table table-bordered m-0" id="table_main" style="width:100%">
              <thead>

                <th class="text-center" style="width:5%" hidden><input type="checkbox" name="check_all" id="check_all">
                </th>
                <th style='width:10%;text-align: left;'>LEAVE ID</th>
                <!-- <th style='width:10%;text-align: center;'>ASSIGNED BY</th> -->
                <th style='width:10%;text-align: left;'>EMPLOYEE</th>
                <th style='width:10%;text-align: left;'>LEAVE DATE</th>
                <th style='width:10%;text-align: left;'>TYPE</th>

                <!-- <th style='width:15%;text-align: center;'>Time Range</th>
                  <th style='width:10%;text-align: center;'>Leave Duration (Hours)</th> -->

                <th style='text-align: left;'>REASON</th>
                <th style='width:10%;text-align: center;'>STATUS</th>
                <th style="width:10%" class="text-center">ACTION</th>
              </thead>
              <tbody id="tbl_application_container">
                <?php if ($LEAVES) {  ?>
                  <?php foreach ($LEAVES as $leave) { ?>
                    <tr>
                      <td class="text-center" id="select_item" hidden>
                          <input type="checkbox" name="brand" class="check_single" row_id="56">
                      </td>
                      <td class="text-left"><?= $id_prefix . str_pad($leave->id, 5, '0', STR_PAD_LEFT) ?></td>
                      <!-- <td class="text-center hover td-directs text-primary " style="width:10%" data-empl_id="<?= $leave->assigned_table_id ?>">
                          <?= $leave->assigned_by ?>
                      </td> -->
                      <td class="text-left hover td-directs text-primary " data-empl_id="<?= $leave->employee_table_id ?>" style="width:10%">
                          <?= $leave->employee ?>
                      </td>

                      <td class="text-left"><?= date(($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y", strtotime($leave->leave_date)) ?></td>
                      <td class="text-left"><?= $leave->type ?></td>
                      <!-- <td class="text-center" style="width:15%"><?= $leave->leave_range ?></td>
                      <td class="text-center" style="width:10%"><?= $leave->duration ?></td> -->
                      <td class="text-left"><?= $leave->reason ?></td>
                      <td class="text-center">
                          <?php
                          if ($leave->status == "Approved") { ?>
                              <div class=' technos-button-green p-2 rounded disabled m-auto' style="width:100px"><?= $leave->status ?></div>
                          <?php } elseif ($leave->status == "Rejected") { ?>
                              <div class='bg-danger p-2 rounded disabled m-auto' style="width:100px"><?= $leave->status ?></div>
                          <?php } elseif ($leave->status == "Withdrawn") { ?>
                              <div class='bg-secondary p-2 rounded disabled m-auto' style="width:100px"><?= $leave->status ?></div>
                          <?php } elseif ($leave->status == "Nurse") { ?>
                              <div class='bg-warning p-2 rounded disabled m-auto' style="width:100px"><?= $leave->status ?></div>
                          <?php } else { ?>
                              <div class='bg-warning  p-2 rounded disabled m-auto' style="width:100px">Pending</div>
                          <?php } ?>
                      </td>

                      <td class="text-center">
                          <a class="select_row p-2" style="color: gray; cursor: pointer; !important" row_id="56" data-leave_id="<?= $leave->id ?>" data-toggle="modal" data-target="#modal_approval">
                              <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="">
                          </a>

                          <?php if ($leave->status != "Withdrawn"): ?>
                              <a class="btn btn-sm indigo lighten-2 edit_workshift" href="<?= base_url() ?>leaves/edit_leave_request/<?= $leave->id ?>">
                                  <img src="<?= base_url('assets_system/icons/pen-to-square-solid.svg') ?>" alt="" id="edit">
                              </a>
                          <?php endif; ?>
                      </td>
                  </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr class="table-active">
                    <td colspan="12">
                      <center>No Records</center>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="d-flex d-lg-none col-sm-7 col-md-10 col-lg-6 mx-auto justify-content-center my-lg-0 my-2">
            <div class="col-12 col-lg-7 d-flex justify-content-lg-end  justify-content-center align-items-center mx-2">
              <div class="d-flex align-items-center row">

                <div class="d-inline col-12 col-lg-6">
                  <p class="p-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                </div>

                <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                  <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                    <li><a <?php if ($current_page > 1) echo " class='paginate' href='?page=$prev_page&row=$row&search=$search_data'"; ?>>
                        < </a>
                    </li>
                    <li><a class="paginate" href="?status=<?= $STATUS ?>&page=1&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                    <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                    <li><a class="paginate" href="?status=<?= $STATUS ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                    <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                    <li><a class="paginate" href="?status=<?= $STATUS ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                    <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                    <li><a class="paginate" href="?status=<?= $STATUS ?>&page=<?= $last_page ?>&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                    <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page) echo "class='paginate'  href='?status=$STATUS&page=$next_page&row=$row&search=$search_data'"; ?>>> </a></li>
                  </ul>
                </div>

              </div>
            </div>
          </div>
          <div class="col-12 col-lg-1 d-flex d-lg-none justify-content-center align-items-center my-2">
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






  <div class="modal fade" id="modal_approval" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="approval_modal_content">
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
                  <img class="img-circle rounded-circle avatar m-3  elevation-2"  onerror="setDefaultImage(this)" id="employee_img" style="cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Profile Image" src="<?= base_url() ?>/assets_system/images/default_user.jpg">
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
                  <p class="mb-1" style="font-weight:500">Directs:</p>
                  <div id="directsParent" class="mx-2">(No Directs)
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php $this->load->view('templates/jquery_link'); ?>
  <?php
  if ($this->session->userdata('success')) {
  ?>
    <script>
      Swal.fire('<?php echo $this->session->userdata('success'); ?>', '', 'success')
    </script>
  <?php $this->session->unset_userdata('success');
  }
  ?>
  <?php
  if ($this->session->flashdata('SUCC')) {
  ?>
    <!-- <script>Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>','','success')</script> -->
    <script>
      $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success!',
        subtitle: 'close',
        body: '<?php echo $this->session->flashdata('SUCC'); ?>',
        onHidden: function() {
          alert('test toast callback');
          // location.reload();
        }
      })
    </script>
  <?php
  }
  ?>
  <?php
  if ($this->session->flashdata('ERR')) {
  ?>
    <!-- <script>Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',
                '',
                'error'
            )
        </script> -->
    <script>
      $(document).Toasts('create', {
        class: 'bg-warning toast_width',
        title: 'Warning!',
        subtitle: 'close',
        body: '<?php echo $this->session->flashdata('ERR'); ?>'
      })
    </script>
  <?php
  }
  ?>


  <script>
    $(document).ready(function() {
      $('.select-employee').select2();
      $(document).on('click', 'button.btn_withdraw', function() {
        let id = $(this).data('id');
        $.post("<?= base_url('leaves/withdraw_leave') ?>", {
          'rowId': id
        }, function(res) {
          window.location.reload();
        })
      })
      $('#modal_approval').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var leave_id = button.data('leave_id');
        $.get("<?= base_url('selfservices/get_leave_approval_status') ?>" + '/' + leave_id, function(res) {
          $('#approval_modal_content').html(res)
        })
        // fetch()
        // .then(res=>res)
        // .then(data=>{
        //     console.log(data)
        // })
      });
      // $('#search_btn').on('click',function(){
      //     reloadPage();
      // })
      $('.select-employee,#search_data').on('change', function() {
        reloadPage();
      })
      $('.leave_status,#row_dropdown').on('change', function() {
        reloadPage();
      })
      $('.filter_select').on('change', function() {
        reloadPage()
      })
      $('a.paginate').on('click', function() {
        var status = $('.leave_status').val();
        var row = $('#row_dropdown').val();
        var page = "<?= $PAGE ?>";
        var search = $('#search_data').val();
        var company = $('#filter_by_company').val();
        var branch = $('#filter_by_branch').val();
        var department = $('#filter_by_department').val();
        var division = $('#filter_by_division').val();
        var clubhouse = $('#filter_by_clubhouse').val();
        var section = $('#filter_by_section').val();
        var group = $('#filter_by_group').val();
        var team = $('#filter_by_team').val();
        var line = $('#filter_by_line').val();
        var filter_url = '&company=' + company + '&branch=' + branch + '&dept=' + department + '&div=' + division + '&section=' + section + '&group=' + group + '&team=' + team + '&line=' + line;
        if (document.querySelector('.filter-container').classList.contains('visible')) {
          filter_url = "&filter=1";
        }
        window.location.href = "<?= base_url('requests/leave_lists') ?>" + $(this).attr('href') + filter_url;
        return false;
      })

      function reloadPage() {
        var status = $('.leave_status').val();
        var row = $('#row_dropdown').val();
        var page = "<?= $PAGE ?>";
        var search = $('#search_data').val();
        var company = $('#filter_by_company').val();
        var branch = $('#filter_by_branch').val();
        var department = $('#filter_by_department').val();
        var division = $('#filter_by_division').val();
        var clubhouse = $('#filter_by_clubhouse').val();
        var section = $('#filter_by_section').val();
        var group = $('#filter_by_group').val();
        var team = $('#filter_by_team').val();
        var line = $('#filter_by_line').val();
        var filter_url = '&company=' + company + '&branch=' + branch + '&dept=' + department + '&div=' + division + '&clubhouse=' + clubhouse + '&section=' + section + '&group=' + group + '&team=' + team + '&line=' + line;
        if (document.querySelector('.filter-container').classList.contains('visible')) {
          filter_url = filter_url + "&filter=1";
        }
        window.location.href = "<?= base_url('requests/leave_lists') ?>" + "?status=" + status + "&page=" + page + "&row=" + row + '&search=' + search + filter_url;
      }

      $(document).on('click', '.cancel_form', function() {
    $('#modal_approval').modal('hide');

    // Store reference to the clicked button's parent form
    var $form = $(this).closest('form');  // ← capture the form HERE

    Swal.fire({
        icon: 'warning',
        title: "Are you sure you want to withdraw the request?",
        input: "textarea",
        inputLabel: "Add Reason",
        inputPlaceholder: "Type your reason here...",
        inputAttributes: {
            "aria-label": "Type your reason here"
        },
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, confirm!",
        cancelButtonText: "No, exit!",
        inputValidator: (value) => {
            if (!value) {
                return "You need to provide a reason!";
            }
        },
        preConfirm: async (e) => {
            $form.find('.remarks_withdrawn').val(e);  // ← use class, scoped to form
        },
    }).then((result) => {
        if (result.isConfirmed) {
            $form.submit();  // ← submit the correct form
        }
    });
});

    })
  </script>
  <!-------------------- Export ----------------->

  <!-- For employee modal information -->
  <script>
    function setDefaultImage(img) {
      img.src = "<?= base_url() ?>/assets_system/images/default_user.jpg";
      img.alt = 'Default Image';
    }
  </script>

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
    $('.td-directs').on('click', function(e) {
      e.stopPropagation();
      let empl_id = $(this).data('empl_id')
      directs(empl_id);
    })
    const directs = async (employeeId) => {
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

            let employeeLastNameSuffix = result.data.employeeInfo?.col_last_name;
            if (result.data.employeeInfo?.col_suffix) employeeLastNameSuffix = `${result.data.employeeInfo?.col_last_name} ${result.data.employeeInfo?.col_suffix}`;
            let employeeFullName = employeeLastNameSuffix;
            if (result.data.employeeInfo?.col_frst_name) employeeFullName = `${employeeFullName}, ${result.data.employeeInfo?.col_frst_name}`;
            if (result.data.employeeInfo?.col_midl_name) employeeFullName = `${employeeFullName} ${result.data.employeeInfo?.col_midl_name.charAt(0)}.`;
            if (employeeFullName) {
              document.getElementById("employeeFullName").textContent = employeeFullName;
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

            let reportingToLastNameSuffix = result.data.reportingTo?.col_last_name;
            if (result.data.reportingTo?.col_suffix) reportingToLastNameSuffix = `${reportingToLastNameSuffix} ${result.data.reportingTo?.col_suffix}`;
            let reportingToFullName = reportingToLastNameSuffix;
            if (result.data.reportingTo?.col_frst_name) reportingToFullName = `${reportingToFullName}, ${result.data.reportingTo?.col_frst_name}`;
            if (result.data.reportingTo?.col_midl_name) reportingToFullName = `${reportingToFullName} ${result.data.reportingTo?.col_midl_name?.charAt(0)}.`;

            let reportingToImage = "<?= base_url() ?>/assets_system/images/default_user.jpg";
            if (result.data.reportingTo?.col_imag_path)
              reportingToImage = `${baseUrl}/assets_user/user_profile/${result.data.reportingTo.col_imag_path}`;

            if (reportingToFullName) {
              document.getElementById("reportingToContainer").textContent = "";
              document.getElementById("reportingToContainer").innerHTML =
                `<img class="img-circle rounded-circle avatar elevation-2" onerror="setDefaultImage(this)"
                        style="cursor: pointer;width:50px !important;height:50px !important" data-toggle="tooltip" 
                        data-placement="right" title="Reporting To" 
                        src="${reportingToImage}">
                      <div class="mx-2">
                        <p class="p-0 m-0" style="line-height: 1;font: size 13px;font-weight:500;">${reportingToFullName}</p>
                      </div>`;
            } else {
              document.getElementById("reportingToContainer").innerHTML = '(No Redirect To)'
            }
            var directsParent = document.getElementById("directsParent");

            // console.log('directs condition', Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0)
            if (Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0) {
              directsParent.innerHTML = '';
              result.data.directsTo.forEach(function(user) {

                directLastNameSuffix = user.col_last_name;
                if (user.col_suffix) directLastNameSuffix = `${directLastNameSuffix} ${user.col_suffix}`;
                let directFullName = directLastNameSuffix;
                if (user.col_frst_name) directFullName = `${directFullName}, ${user.col_frst_name}`;
                if (user.col_midl_name) directFullName = `${directFullName} ${user.col_midl_name.charAt(0)}.`;

                let directImage = `${baseUrl}/assets_system/images/default_user.jpg`;
                if (user.col_imag_path) {
                  directImage = `${baseUrl}/assets_user/user_profile/${user.col_imag_path}`;
                }
                var div = document.createElement("div");
                div.className = "d-flex align-items-center";
                div.innerHTML = `
                        <div  class="d-flex align-items-center mb-2">
                          <img class="img-circle rounded-circle avatar elevation-2" onerror="setDefaultImage(this)"
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
  <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"> </script> -->
  <!-- <script src="<?= base_url() ?>assets_system/js/xlsx.full.min.js"> </script>
    
    <script >
        document.getElementById("btn_export").addEventListener('click', function() {
          /* Create worksheet from HTML DOM TABLE */
          var wb = XLSX.utils.table_to_book(document.getElementById("table_main"));
          /* Export to file (start a download) */
          XLSX.writeFile(wb, "<?php echo 'leave_list.xlsx' ?>");
        });
    </script> -->

  <script>
    function toggleFilter() {
      document.querySelector('.filter-container').classList.toggle('visible');
    }
  </script>

  <script>
    var filter = <?php echo json_encode($this->input->get('filter')); ?>;
    // console.log('filter', filter);
  </script>

</body>

</html>