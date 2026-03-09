<html>
<script>
  function setDefaultImage(img) {
    img.src = "<?= base_url() ?>/assets_system/images/default_user.jpg";
    img.alt = 'Default Image';
  }
</script>
<?php $this->load->view('templates/css_link'); ?>
<?php if ($DISP_VIEW_REQUIREDAPPROVERS == 0) { ?>
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
  <link rel="stylesheet" href="<?= base_url() ?>assets_system/css/handsontable14.css" />
  <style>
    .handsontable .wtHolder .wtHider {
      /* margin-bottom: 50px; */
      height: 54vh !important;
    }
  </style>
<?php } ?>
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

  .modal-title-header {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100%;
  }

  .table-acquired-hours {
    table-layout: fixed;
    width: 100%;
  }

  .table-acquired-hours th,
  .table-acquired-hours td {
    width: 50%;
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

  .img-circle {
    border-radius: 50% !important;
    /* width: 100px !important;
    height: 100px !important; */
    object-fit: scale-down;
  }
</style>
<style>
  .hover {
    cursor: pointer;
  }

  .img-circle2 {
    border-radius: 50% !important;
    width: 100px !important;
    height: 100px !important;
    object-fit: scale-down;
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

  @media (min-width: 1280px) {
    .col-2-xl {
      flex-basis: 16.66667%;
      max-width: 16.66667%;
    }

    #search_data {
      min-width: 200px;
    }
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
$id_prefix = 'OFF';

$filter = $this->input->get('filter');
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
          <h1 class="page-title"><a onclick="afterRenderFunction()" href="<?= base_url('requests') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
            </a>&nbsp;Apply Offsets<h1>
        </div>
        <?php if ($DISP_VIEW_REQUIREDAPPROVERS == 1) { ?>
          <div class="col-md-6 button-title">
            <a onclick="afterRenderFunction()" href="<?= base_url('requests/acquire_offset') ?>" class=" btn btn-primary shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
              &nbsp;Acquire </a>

            <a onclick="afterRenderFunction()" href="<?= base_url('requests/redeemed_offset') ?>" class=" btn btn-primary shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/minus-solid.svg') ?>" alt="">
              &nbsp;Redeemed</a>
            <!-- <a onclick="afterRenderFunction()" href="<?= base_url('teams/request_offset') ?>" class=" btn btn-primary shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
              &nbsp;Add Request</a>
            <a id="btn_export" class=" btn btn-primary text-light shadow-none rounded d-flex align-items-center"><img src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">
              &nbsp;Export XLSX</a> -->
          </div>
        <?php } ?>
        <?php if ($DISP_VIEW_REQUIREDAPPROVERS == 0) { ?>
          <div class="col-md-6 button-title">
            <!-- <a href="#" class=" btn technos-button-gray shadow-none rounded" id="btn_export"><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a> -->
            <!-- <button class=" btn btn-primary" id="btn-update"><i class="far fa-check-circle"></i>&nbsp;Update Changes</button>
            <a href="<?= base_url('teams/new_request_leave_direct') ?>" class=" btn btn-primary text light shadow-none rounded"><i class="fas fa-plus"></i>&nbsp;Add Request</a>
          </div> -->
          <?php } ?>
          </div>
          <hr>
          <div class="filter-container <?= $filter ? 'visible' : '' ?> ">
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
                <select name="clubhouse" id="filter_by_clubhouse" class="filter_select form-control">
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
              <div class="col-md-2 <?php echo ($DISP_VIEW_REQUIREDAPPROVERS == 0) ? 'd-none' : ''; ?>">
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
            <a href="<?= base_url('teams/apply_leaves') ?>" id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
          </div> -->
            </div>
            <!-- filter divs ends -->
            <!-- <div class="py-3 d-flex">
          <div class="mx-1 <?php echo ($DISP_VIEW_REQUIREDAPPROVERS == 0) ? 'd-none' : ''; ?>">
            <p class="mb-1 text-secondary ">Status</p>
            <select class="form-control leave_status" style="min-width:200px;width:max-content">
              <option value="">All</option>
              <?php foreach ($STATUSES as $status) { ?>
                <option value="<?= $status ?>" <?= $status == $STATUS ? 'selected' : '' ?>><?= $status ?></option>
              <?php } ?>
            </select>
          </div>
        </div> -->
          </div>
          <div class="card border-0 p-0 m-0">
            <div class="card border-0 pt-1 m-0">

              <div class="p-2">
                <div class="card-header p-0">
                  <div class="">
                    <div class="d-flex row align-items-end">
                      <div class="'col-12 col-xl-6 d-flex ml-1">
                        <div class="row justify-content-center justify-content-lg-start">
                          <p class="col-11 mb-1 text-secondary ">Employee</p>
                          <select class="col-11 col-md-4 select-employee form-control " id="search_data">
                            <option value=''>All</option>
                            <?php foreach ($EMPLOYEES as $employee) {
                              $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
                              if (!empty($employee->col_suffix)) $name = $name . ' ' . $employee->col_suffix;
                              if (!empty($employee->col_frst_name)) $name = $name . ', ' . $employee->col_frst_name;
                              if (!empty($employee->col_midl_name)) $name = $name . ' ' . $employee->col_midl_name[0] . '.';
                            ?>
                              <option value="<?= $employee->id ?>" <?= $search_data == $employee->id ? 'selected' : '' ?>><?= $name

                                                                                                                          ?></option>
                            <?php } ?>
                          </select>
                          <button id="btnFilter" class="mt-2 mt-lg-0 ml-1 btn btn-primary shadow-none rounded" onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg') ?>" style="margin-bottom: 1px" alt="">&nbsp;Advance Filter</button>
                          <a href="<?= base_url('requests/apply_offsets') ?>" id="btn_clear_filter" class="mt-2 mt-lg-0 btn btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="">&nbsp;Clear</a>
                          <!-- <button type="button" class="btn btn-primary" id="summaryButton" data-bs-toggle="modal" data-bs-target="#summaryModal">
                            Summary
                          </button> -->
                        </div>


                      </div>

                      <div class="col-12 col-xl-6 ml-auto my-2 my-lg-0 row align-items-center d-lg-flex d-none">
                        <div class="d-inline d-flex col-12 col-xl-5 justify-content-lg-end justify-content-center align-items-center mb-1">


                          <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                        </div>
                        <div class="d-lg-inline col-12 col-xl-5 d-flex justify-content-lg-end justify-content-center mb-1">
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
                        <div class="col-sm-3 col-md-2 col-xl-1 col-2-xl d-none d-lg-flex align-items-center justify-content-center justify-content-lg-end mr-lg-0 mr-2 mb-1">
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
              <?php if ($DISP_VIEW_REQUIREDAPPROVERS == 1) { ?>
                <div class="table-responsive">
                  <table class="table table-bordered m-0" id="table_main" style="width:100%">
                    <thead>
                      <th class="text-center" style="width:5%" hidden><input type="checkbox" name="check_all" id="check_all">
                      </th>
                      <th style='width:10%;text-align: left;'>ID</th>
                      <th style='width:10%;text-align: left;'>EMPLOYEE</th>
                      <th style='width:10%;text-align: left;'>DATE</th>
                      <!-- <th style='width:10%;text-align: left;'>TIME RANGE</th> -->
                      <th style='width:10%;text-align: left;'>TYPE</th>
                      <th style='width:10%;text-align: left;'>HOURS</th>
                      <th style='text-align: left;'>REASON</th>
                      <th style='width:10%;text-align: center;'>STATUS</th>
                      <th style="width:10%" class="text-center">ACTION</th>
                    </thead>
                    <tbody id="tbl_application_container">
                      <?php if ($TABLE_DATA) {
                        $currentDate = new DateTime();
                      ?>
                        <?php foreach ($TABLE_DATA as $row_data) {
                          // $dataDate = new DateTime($row_data->offset_date);
                          // $interval = $currentDate->diff($dataDate);
                          // if (!(($row_data->status == "Pending 1" || $row_data->status == 'Pending 2' || $row_data->status == 'Pending 3') && ($interval->m + ($interval->y * 12) > 2))) {
                        ?>
                          <tr data-id="<?= $row_data->id ?>" data-toggle="modal" data-target="#modal_approval">
                            <td><?= $id_prefix . str_pad($row_data->id, 5, '0', STR_PAD_LEFT) ?></td>
                            <td><?= $row_data->employee ?></td>
                            <td><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($row_data->offset_date)) ?></td>
                            <!-- <td><?= $row_data->time_range ?></td> -->
                            <td><?= $row_data->offset_type ?></td>
                            <td><?= $row_data->duration ?></td>
                            <td><?= $row_data->reason ?></td>
                            <td class="text-center">
                              <?php
                              if ($row_data->status == "Approved") { ?>
                                <div class='technos-button-green p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>
                              <?php } elseif ($row_data->status == "Rejected") { ?>
                                <div class='bg-danger p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>
                              <?php } elseif ($row_data->status == "Withdrawn") { ?>
                                <div class='bg-secondary p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>
                              <?php } else { ?>
                                <div class='bg-warning p-2 rounded disabled m-auto' style="width:100px">Pending</div>
                              <?php } ?>
                            </td>
                            <td class="text-center">
                              <a class="select_row p-2" style="color: gray; cursor: pointer; !important" row_id="56" data-id="<?= $row_data->id ?>" data-toggle="modal" data-target="#modal_approval">
                                <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="">
                              </a>
                              <?php if ($row_data->status == 'Pending 1' || $row_data->status == 'Pending 2' || $row_data->status == 'Pending 3') : ?>
                              <?php endif ?>
                            </td>
                          </tr>
                        <?php
                          // }
                        } ?>
                      <?php } else { ?>
                        <tr class="table-active">
                          <td colspan="10">
                            <center>No Records</center>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              <?php } ?>
              <?php if ($DISP_VIEW_REQUIREDAPPROVERS == 0) { ?>
                <div class="row">
                  <div class="col">
                    <div class="">
                      <div id="table_data_new"> </div>
                      <!-- <div id="table_data" > </div> -->

                    </div>

                  </div>
                </div>
              <?php } ?>
              <div class="d-lg-none d-block">
                <div class="col-12 col-lg-4 ml-auto my-2 my-lg-0 row align-items-center ">
                  <div class="d-inline d-flex col-12 col-lg-8 justify-content-lg-end justify-content-center align-items-center">

                    <p class="p-0 m-0 text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                  </div>
                  <div class="d-lg-inline col-12 col-lg-4 d-flex justify-content-lg-end justify-content-center ">
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
                <div class="col-sm-3 col-md-2 col-lg-1 d-flex align-items-center justify-content-center justify-content-lg-end mr-lg-0 my-2">
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
                      <img class="img-circle2 rounded-circle avatar m-3  elevation-2" onerror="setDefaultImage(this)" id="employee_img" style="cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Profile Image" src="<?= base_url() ?>/assets_system/images/default_user.jpg">
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

    <!-- Summary Modal -->
    <div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title-header" id="summaryModalLabel">Acquired Hours Summary</h4>
          </div>
          <div class="modal-body">
            <h5>Total Acquired Hours: <span id="totalAcquiredHours">0</span></h5>
            <div class="table-responsive">
              <table class="table-acquired-hours table table-bordered mt-2">
                <thead>
                  <tr>
                    <th>EMPLOYEE</th>
                    <th>TOTAL ACQUIRED HOURS</th>
                  </tr>
                </thead>
                <tbody id="acquiredHoursTable">
                  <!-- Table Data -->
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
      var LEAVES = <?php echo json_encode($LEAVES); ?>;
      // console.log('LEAVES', LEAVES);
    </script>
    <?php if ($DISP_VIEW_REQUIREDAPPROVERS == 0) { ?>
      <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
      <script type="text/javascript" src="<?= base_url() ?>assets_system/js/handsontable14.js"></script>
      <script>
        var data = <?php echo json_encode($LEAVES); ?>;
        // console.log('LEAVES', LEAVES);
        var dataCopy = JSON.parse(JSON.stringify(data));

        function compareObjects(obj1, obj2) {
          for (var key in obj1) {
            if (obj1.hasOwnProperty(key)) {
              if (obj1[key] !== obj2[key]) {
                return false;
              }
            }
          }
          return true;
        }
        var employeeList = <?php echo json_encode($DISP_EMPLOYEES_NONFILTERED); ?>;
        // console.log('data',data);
        // console.log('employeeList',employeeList);
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
        const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
          Handsontable.renderers.TextRenderer.apply(this, arguments);
          td.style.whiteSpace = 'nowrap';
          td.style.overflow = 'hidden';
        };
        initializeHandsontable(data);

        function initializeHandsontable(data) {
          const container = document.querySelector('#table_data_new');
          hot = new Handsontable(container, {
            data,
            readOnly: true,
            nestedHeaders: [
              ['id', 'Loan ID', 'Employee',
                'Leave Date', 'Leave Duration',
                'Remarks',
              ],
            ],
            rowHeaders: true,
            height: 'auto',
            outsideClickDeselects: false,
            selectionMode: 'multiple',
            licenseKey: 'non-commercial-and-evaluation',
            // Custom renderer to prevent text wrapping
            renderer: customStyleRenderer_new,
            // readOnly: false,
            hiddenColumns: {
              columns: [0],
              // indicators: true,
            },
            stretchH: 'all',
            columns: [{
                data: 'id',
                readOnly: true
              },
              {
                data: 'c_id',
                readOnly: true
              },
              {
                data: 'employee',
                readOnly: true,
                source: employeeIds,
                width: 200,
                wordWrap: false
              },
              {
                data: 'leave_date',
                readOnly: false,
                type: 'date',
                dateFormat: 'DD/MM/YYYY',
                correctFormat: false
              },
              {
                data: 'duration',
                readOnly: false,
                validator: function(value, callback) {
                  if (value > 0) {
                    callback(true);
                  } else {
                    callback(false, 'Value must be greater than 0');
                  }
                }
              },
              {
                data: 'remarks',
                readOnly: false,
                width: 340
              },
            ],
          });
        }
        var update_data = document.getElementById('btn-update');
        update_data.addEventListener('click', function() {
          var changes = [];
          for (var i = 0; i < data.length; i++) {
            if (!compareObjects(data[i], dataCopy[i])) {
              changes.push(data[i]);
            }
          }
          // console.log('changes', changes)
          if (changes.length < 1) {
            $(document).Toasts('create', {
              class: 'bg-warning toast_width',
              title: 'Warning!',
              subtitle: 'close',
              body: 'No Changes'
            })
            return;
          }
          var changesFinal = [];
          var changesLeaves = [];
          var changesLeavesInvalid = [];

          function isValidDateFormat(dateString) {
            const dateFormatRegex = /^\d{2}\/\d{2}\/\d{4}$/;
            return dateFormatRegex.test(dateString);
          }
          for (var i = 0; i < changes.length; i++) {
            var temp = {
              ...changes[i]
            };
            let valid = true;
            if (changes[i].employee) {
              const check = employeeIdsCopywithCMID.find(obj => obj.employeeNameWithCMID === changes[i].employee);
              if (check) {
                temp.employee = check.cmid;
              } else {
                valid = false;
                changesLeavesInvalid.push(changes[i].c_id);
                continue;
              }
              if (isValidDateFormat(changes[i].leave_date)) {
                const parts = changes[i].leave_date.split('/');
                const mysqlDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                temp.leave_date = mysqlDate;
              } else {
                changesLeavesInvalid.push(changes[i].c_id);
                continue;
              }
              if (!(!isNaN(changes[i].duration) && Number(changes[i].duration) > 0)) {
                changesLeavesInvalid.push(changes[i].c_id);
                continue;
              }
              if (valid) {
                changesFinal.push(temp);
                changesLeaves.push(changes[i].c_id);
              }
            }
          }
          // console.log('changesLeaves', changesLeaves)
          // console.log('changesLeavesInvalid', changesLeavesInvalid)
          // console.log('changes', changes)
          // console.log('changesFinal', changesFinal)
          const changesLeavesInvalidString =
            changesLeavesInvalid.length > 0 ? `Leave${changesLeavesInvalid.length > 1? 's': ''} ${changesLeavesInvalid.join(', ')} ${changesLeavesInvalid.length > 1? 'have': 'has'} invalid input and will not be updated` :
            '';
          if (changesFinal.length < 1 && changesLeavesInvalidString) {
            $(document).Toasts('create', {
              class: 'bg-warning toast_width',
              title: 'Warning!',
              subtitle: 'close',
              body: `No Valid Changes. ${changesLeavesInvalidString}`
            })
            return;
          }
          const confirmed = confirm(`Are you sure you want to update ${changesLeaves.join(', ')} ? ${changesLeavesInvalidString? changesLeavesInvalidString : '' }`);
          if (!confirmed) {
            return;
          }
          var url = '<?= base_url() ?>';
          const apiUrl = url + 'leaves/update_leaves_direct';
          // console.log('changesFinal', changesFinal);
          fetch(apiUrl, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify(changesFinal)
            })
            .then(response => response.json())
            .then(result => {
              // console.log('result', result);
              alert('test');
              if (result.reload) {
                location.reload();
              } else if (result.success_message) {
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
              } else if (result.error_message) {
                $(document).Toasts('create', {
                  class: 'bg-warning toast_width',
                  title: 'Warning!',
                  subtitle: 'close',
                  body: result.error_message
                })
              } else if (result.warning_message) {
                $(document).Toasts('create', {
                  class: 'bg-warning toast_width',
                  title: 'Warning!',
                  subtitle: 'close',
                  body: result.warning_message
                })
              } else {
                $(document).Toasts('create', {
                  class: 'bg-warning toast_width',
                  title: 'Warning!',
                  subtitle: 'close',
                  body: 'Please provide all required information.'
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
      </script>
    <?php } ?>
    <script>
      $(document).ready(function() {
        $('.select-employee').select2();
        $(document).on('click', 'button.btn_withdraw', function() {
          let id = $(this).data('id');
          $.post("<?= base_url('teams/withdraw_leave') ?>", {
            'rowId': id
          }, function(res) {
            window.location.reload();
          })
        })
        $('#modal_approval').on('show.bs.modal', function(e) {
          var button = $(e.relatedTarget);
          var offset = button.data('id');
          $.get("<?= base_url('selfservices/get_offset_status') ?>" + '/' + offset, function(res) { //get_leave_approval_status
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
          var filter_url = '&company=' + company + '&branch=' + branch + '&dept=' + department + '&div=' + division + '&clubhouse=' + clubhouse + '&section=' + section + '&group=' + group + '&team=' + team + '&line=' + line;
          window.location.href = "<?= base_url('requests/apply_offsets') ?>" + $(this).attr('href') + filter_url;
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
            filter_url = filter_url + '&filter=1';
          }
          window.location.href = "<?= base_url('requests/apply_offsets') ?>" + "?status=" + status + "&page=" + page + "&row=" + row + '&search=' + search + filter_url;
        }
      })
    </script>
    <!-------------------- Export ----------------->
    <?php if ($DISP_VIEW_REQUIREDAPPROVERS == 1) { ?>
      <!-- For employee modal information -->
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
                    if (result.data.directsTo[0].col_imag_path) {
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
      <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>  -->
      <script src="<?= base_url() ?>assets_system/js/xlsx.full.min.js"></script>

      <script>
        document.getElementById("btn_export").addEventListener('click', function() {
          /* Create worksheet from HTML DOM TABLE */
          var wb = XLSX.utils.table_to_book(document.getElementById("table_main"));
          /* Export to file (start a download) */
          XLSX.writeFile(wb, "<?php echo 'leave_list.xlsx' ?>");
        });
      </script>
    <?php } ?>
    <script>
      // console.log('filter_by_branch', $('.filter_by_branch').val())
      if ($('.leave_status').val() ||
        $('#filter_by_branch').val() || $('#filter_by_department').val() || $('#filter_by_division').val() || $('#filter_by_clubhouse').val() || $('#filter_by_section').val() ||
        $('#filter_by_group').val() || $('#filter_by_team').val() || $('#filter_by_line').val() || $('#leave_status').val() || $('#filter_by_company').val()
      ) {
        // console.log(true)
        document.querySelector('.filter-container').classList.add('visible');
        document.querySelector('#btnFilter').textContent = 'Hide Filter';
      } else {
        // console.log(false);
        const formContainer = document.querySelector('.filter-container');
        formContainer.classList.remove('visible');
        // document.querySelector('#btnFilter').textContent = 'Hide Filter';
      }

      function toggleFilter() {
        const formContainer = document.querySelector('.filter-container');
        const button = document.querySelector('#btnFilter');
        formContainer.classList.toggle('visible');
      }
    </script>

    <script>
      $(document).on('click', '#summaryButton', function() {
        $.ajax({
          url: '<?= base_url("teams/get_acquired_hours_summary"); ?>',
          type: 'POST',
          dataType: 'json',
          success: function(response) {
            console.log(response);

            $('#totalAcquiredHours').text(response.total_acquired_offset || 0);

            const tableBody = $('#acquiredHoursTable');
            tableBody.empty();

            if (response.employee_data.length > 0) {
              response.employee_data.forEach((item) => {
                tableBody.append(`
            <tr>
              <td>${item.employee_name}</td>
              <td>${item.total_hours}</td>
            </tr>
          `);
              });
            } else {
              tableBody.append(`
          <tr>
            <td colspan="2" class="text-center">No Records</td>
          </tr>
        `);
            }

            var myModal = new bootstrap.Modal(document.getElementById('summaryModal'));
            myModal.show();

            document.querySelector('[data-bs-dismiss="modal"]').addEventListener('click', function() {
              myModal.hide();
            });
          },
          error: function(error) {
            console.error('Error fetching data:', error);
          }
        });
      });
    </script>

</body>

</html>