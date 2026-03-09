<html>

<?php $this->load->view('templates/css_link'); ?>
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

  @media (min-width: 1920px) {
   #entryCount{
    white-space: text; 
   }
   #search_data{
    width: 400px;
   }
  }

  @media (min-width: 1280px) {
    #entryCount{
      overflow-wrap: break-word !important;
      word-wrap: break-word !important;
    }
    #search_data{
    width: 25%;
   }
  }
</style>

<?php

$this->load->library('session');



$url_count = $this->uri->total_segments();

$url_directory = $this->uri->segment($url_count);

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

$company_data = $this->input->get('company');

$branch_data = $this->input->get('branch');

$dept_data = $this->input->get('dept');

$div_data = $this->input->get('div');

$clubhouse_data = $this->input->get('clubhouse');

$section_data = $this->input->get('section');

$group_data = $this->input->get('group');

$team_data = $this->input->get('team');

$line_data = $this->input->get('line');

$id_prefix = 'HDW';

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


$filter = $this->input->get('filter');
?>

<html>

<body>

  <div class="content-wrapper">

    <div class="container-fluid p-4">

      <div class="row pt-1">

        <div class="col-md-6">

          <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('overtimes') ?>"><img
                style="width: 24px; height: 24px; margin-bottom: 3px;"
                src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
            </a>&nbsp;Holiday Work<h1>

        </div>

        <div class="col-md-6 button-title">
          <?php if ($multiple_request == 1) { ?>
            <a href="<?= base_url('overtimes/holiday_works_multi') ?>" class=" btn btn-primary shadow-none rounded"><img
                class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
              &nbsp;Multi Request</a> <?php } ?>
          <a href="<?= base_url('overtimes/request_holiday_work') ?>" class=" btn btn-primary shadow-none rounded"><img
              class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">&nbsp;Add Request</a>

          <a id="btn_export" class=" btn btn-primary text-light shadow-none rounded"><img class="mb-1"
              src="<?= base_url('assets_system/icons/file-export-solid.svg') ?>" alt="">&nbsp;Export XLSX</a>
        </div>

      </div>

      <hr>

      <div class="filter-container <?= $filter ? 'visible' : '' ?>">
        <div class="row mb-4   d-flex">

          <div class="col-md-2 <?= $DISP_VIEW_COMPANY == '0' ? 'd-none' : '' ?>">

            <p class="mb-1 text-secondary ">Company</p>

            <select name="dept" id="filter_by_company" class="filter_select form-control">

              <option value="">All Companies</option>

              <?php foreach ($COMPANIES as $row_data): ?>

                <option value="<?= $row_data->id ?>" <?= $company_data == $row_data->id ? 'selected' : '' ?>>
                  <?= $row_data->name ?></option>

              <?php endforeach ?>

            </select>

          </div>

          <div class="col-md-2 <?= $DISP_VIEW_BRANCH == '0' ? 'd-none' : '' ?>">

            <p class="mb-1 text-secondary ">Branch</p>

            <select name="dept" id="filter_by_branch" class="filter_select form-control">

              <option value="">All Branches</option>

              <?php foreach ($BRANCHES as $row_data): ?>

                <option value="<?= $row_data->id ?>" <?= $branch_data == $row_data->id ? 'selected' : '' ?>>
                  <?= $row_data->name ?></option>

              <?php endforeach ?>

            </select>

          </div>

          <div class="col-md-2 <?= $DISP_VIEW_DEPARTMENT == '0' ? 'd-none' : '' ?>">

            <p class="mb-1 text-secondary ">Department</p>

            <select name="dept" id="filter_by_department" class="filter_select form-control">

              <option value="">All Departments</option>

              <?php foreach ($DEPARTMENTS as $row_data): ?>

                <option value="<?= $row_data->id ?>" <?= $dept_data == $row_data->id ? 'selected' : '' ?>>
                  <?= $row_data->name ?></option>

              <?php endforeach ?>

            </select>

          </div>

          <div class="col-md-2 <?= $DISP_VIEW_DIVISION == '0' ? 'd-none' : '' ?>">

            <p class="mb-1 text-secondary ">Division</p>

            <select name="dept" id="filter_by_division" class="filter_select form-control">

              <option value="">All Divisions</option>

              <?php foreach ($DIVISIONS as $row_data): ?>

                <option value="<?= $row_data->id ?>" <?= $div_data == $row_data->id ? 'selected' : '' ?>>
                  <?= $row_data->name ?></option>

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

              <?php foreach ($SECTIONS as $row_data): ?>

                <option value="<?= $row_data->id ?>" <?= $section_data == $row_data->id ? 'selected' : '' ?>>
                  <?= $row_data->name ?></option>

              <?php endforeach ?>

            </select>

          </div>

          <div class="col-md-2 <?= $DISP_VIEW_GROUP == '0' ? 'd-none' : '' ?>">

            <p class="mb-1 text-secondary ">Group</p>

            <select name="group" id="filter_by_group" class="filter_select form-control">

              <option value="">All Groups</option>

              <?php foreach ($GROUPS as $row_data): ?>

                <option value="<?= $row_data->id ?>" <?= $group_data == $row_data->id ? 'selected' : '' ?>>
                  <?= $row_data->name ?></option>

              <?php endforeach ?>

            </select>

          </div>

          <div class="col-md-2 <?= $DISP_VIEW_TEAM == '0' ? 'd-none' : '' ?>">

            <p class="mb-1 text-secondary ">Team</p>

            <select name="dept" id="filter_by_team" class="filter_select form-control">

              <option value="">All Teams</option>

              <?php foreach ($TEAMS as $row_data): ?>

                <option value="<?= $row_data->id ?>" <?= $team_data == $row_data->id ? 'selected' : '' ?>>
                  <?= $row_data->name ?></option>

              <?php endforeach ?>

            </select>

          </div>

          <div class="col-md-2 <?= $DISP_VIEW_LINE == '0' ? 'd-none' : '' ?>">

            <p class="mb-1 text-secondary ">Line</p>

            <select name="line" id="filter_by_line" class="filter_select form-control">

              <option value="">All Lines</option>

              <?php foreach ($LINES as $row_data): ?>

                <option value="<?= $row_data->id ?>" <?= $line_data == $row_data->id ? 'selected' : '' ?>>
                  <?= $row_data->name ?></option>

              <?php endforeach ?>

            </select>

          </div>

          <!-- <div class="col-md-2">

            <p class="mb-1 text-secondary ">Action</p>

            <a href="<?= base_url('overtimes/holiday_works') ?>" id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>

          </div> -->
          <div class=" col-md-2 ">

            <p class="mb-1 text-secondary ">Status</p>

            <select class="form-control leave_status">

              <option value="">All</option>

              <?php foreach ($STATUSES as $status) { ?>

                <option value="<?= $status ?>" <?= $status == $STATUS ? 'selected' : '' ?>><?= $status ?></option>

              <?php } ?>

            </select>

          </div>
        </div>



      </div> <!-- filter divs ends -->


      <div class="card border-0 p-0 m-0">

        <div class="card border-0" style="margin: 0px !important">


          <div class="p-2">
            <!-- <div class="card-header btn-filter d-flex justify-content-end">
              <div class="">
                <button id="btnFilter" class="mt-3 mt-lg-0 btn btn-primary shadow-none rounded ml-1" onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg') ?>" style="margin-bottom: 1px" alt="" />&nbsp;Advance Filter</button>
                <a href="<?= base_url('overtimes/holiday_works') ?>" id="btn_clear_filter" class="mt-3 mt-lg-0 btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="" />&nbsp;Clear</a>
              </div>
            </div> -->

            <div class="card-header p-0">

              <div class="">
                <div class="d-flex row  align-items-center">
                  <div class="col-12 col-xl-6 d-flex">
                    <div class="input-group my-2 d-flex justify-content-center" style="width:max-content">

                      <div class="input-group-prepend">
                        <button id="search_btn"
                          class="input-group-prepend btn btn-primary shadow-none d-flex align-items-center"><img
                            src="<?= base_url('assets_system/icons/magnifying-glass-solid.svg') ?>" alt="">
                          &nbsp;Search</button>
                      </div>

                      <select class="select-employee d-block" id="search_data"
                         style="min-width:300px;width:max-content">
                        <option value=''>All</option>
                        <?php foreach ($EMPLOYEES as $employee) { ?>
                          <option value="<?= $employee->id ?>" <?= $search_data == $employee->id ? 'selected' : '' ?>>
                            <?= $employee->col_empl_cmid . "-" . $this->system_functions->fomatName($employee->col_last_name, $employee->col_frst_name, $employee->col_midl_name) ?>
                          </option>
                        <?php } ?>
                      </select>
                      <button id="btnFilter" class="mt-3 mt-lg-0 btn btn-primary shadow-none rounded ml-1 filter-btn"
                        onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg') ?>"
                          style="margin-bottom: 1px" alt="" />&nbsp;Advance Filter</button>
                      <a href="<?= base_url('overtimes/holiday_works') ?>" id="btn_clear_filter"
                        class="mt-3 mt-lg-0 btn btn-primary mx-1 filter-btn"><img
                          src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="" />&nbsp;Clear</a>
                    </div>
                  </div>

                  <div class="col-12 col-xl-6 row d-none d-lg-flex justify-content-around">
                    <div class="col-12 col-xl-6 d-flex  justify-content-center align-items-center mx-2">
                      <div class="d-flex align-items-center row">
                        <div class="d-inline col-12 col-xl-6">
                          <p class="p-0 m-0 mx-auto text-center text-nowrap " style="color: gray" id="entryCount">Showing <?= $low_limit ?> to
                            <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                        </div>
                      </div>

                      <div class="d-lg-inline d-flex col-12 col-xl-4 justify-content-center justify-content-lg-end">
                        <ul class="pagination ml-0 ml-lg-4 m-0 p-0">

                          <li><a <?php if ($current_page > 1)
                            echo " class='paginate' href='?page=$prev_page&row=$row&search=$search_data'"; ?>>

                              < </a>

                          </li>

                          <li><a class="paginate"
                              href="?status=<?= $STATUS ?>&page=1&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page == 1)
                                      echo "hidden"; ?>>1 </a></li>

                          <li><a <?php if ($current_page <= 2)
                            echo "hidden"; ?>>... </a></li>

                          <li><a class="paginate"
                              href="?status=<?= $STATUS ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>&search=<?= $search_data ?>"
                              <?php if ($current_page <= 2)
                                echo "hidden"; ?>><?= $prev_page ?></a></li>

                          <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a>
                          </li>

                          <li><a class="paginate"
                              href="?status=<?= $STATUS ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>&search=<?= $search_data ?>"
                              <?php if ($current_page >= $last_page - 1)
                                echo "hidden"; ?>><?= $next_page ?> </a></li>

                          <li><a <?php if ($current_page >= $last_page - 1)
                            echo "hidden"; ?>>... </a></li>

                          <li><a class="paginate"
                              href="?status=<?= $STATUS ?>&page=<?= $last_page ?>&row=<?= $row ?>&search=<?= $search_data ?>"
                              <?php if ($current_page == $last_page || $last_page <= 0)
                                echo "hidden"; ?>><?= $last_page ?>
                            </a></li>

                          <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)
                            echo "class='paginate'  href='?status=$STATUS&page=$next_page&row=$row&search=$search_data'"; ?>>> </a></li>

                        </ul>
                      </div>
                    </div>
                    <div class="col-12 col-xl-1 d-none d-lg-flex justify-content-center align-items-center">
                      <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>

                      <select id="row_dropdown" class="custom-select" style="width: 100px;">

                        <?php

                        foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>

                          <option value=<?= $C_ROW_DISPLAY_ROW ?>   <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>

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
            <table class="table table-hover table-bordered m-0" id="table_main" style="width:100%">

              <thead>

                <th class="text-left" style="width:10%">ID</th>

                <th class="text-left" style="width:15%">EMPLOYEE</th>

                <th class="text-left" style="width:10%">DATE</th>

                <th class="text-left" style="width:10%">TYPE</th>

                <th class="text-left" style="width:10%">HOURS</th>

                <th class="text-left">REASON</th>

                <th class="text-center" style="width:10%">STATUS</th>

                <th class="text-center" style="width:10%">ACTION</th>

              </thead>

              <tbody id="tbl_application_container">

                <?php if ($TABLE_DATA) { ?>

                  <?php foreach ($TABLE_DATA as $row_data) { ?>

                    <tr class="hover" data-id="<?= $row_data->id ?>" data-toggle="modal" data-target="#modal_approval">

                      <td><?= $id_prefix . str_pad($row_data->id, 5, '0', STR_PAD_LEFT) ?></td>

                      <!-- <td class="text-center text-primary td-directs" data-empl_id="<?= $row_data->assigned_by_tb_id ?>"><?= $row_data->assigned_by ?></td> -->

                      <td class="text-left text-primary td-directs2 " data-empl_id="<?= $row_data->employee_tb_id ?>">
                        <?= $row_data->employee ?></td>

                      <!-- <td class="text-left"><?= date_format(date_create($row_data->date), $DATE_FORMAT) ?></td> -->
                      <td class="text-left"> <?= date(($DATE_FORMAT) ? $DATE_FORMAT: "d/m/Y", strtotime($row_data->date)) ?></td>

                      <td class="text-left"><?= $row_data->type ?></td>

                      <td class="text-left"><?= $row_data->hours ?></td>

                      <td class="text-left"><?= $row_data->reason ?></td>

                      <td class="text-center">

                        <?php

                        if ($row_data->status == "Approved") { ?>

                          <div class=' technos-button-green p-2 rounded disabled m-auto' style="width:100px">
                            <?= $row_data->status ?></div>

                        <?php } elseif ($row_data->status == "Rejected") { ?>

                          <div class='bg-danger p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?>
                          </div>

                        <?php } elseif ($row_data->status == "Withdrawed") { ?>

                          <div class='bg-secondary p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?>
                          </div>

                        <?php } else { ?>

                          <div class='bg-warning  p-2 rounded disabled m-auto' style="width:100px">Pending</div>

                        <?php } ?>

                      </td>

                      <!-- <td class="text-center"><?= $row_data->comment ?></td> -->

                      <td class="text-center">

                        <!-- <a class = "select_row p-2"  style ="color: gray; cursor: pointer; !important"  row_id="56" data-id="<?= $row_data->id ?>"  data-toggle="modal" data-target="#modal_approval"> -->
                        <a class="select_row p-2" style="color: gray; cursor: pointer; !important" row_id="56">

                          <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="">
                        </a>

                        <?php if ($row_data->status == 'Pending 1' || $row_data->status == 'Pending 2' || $row_data->status == 'Pending 3'): ?>

                          <!--<a class = "select_edit_row p-2 edit_data_id"  href="<?= base_url('attendances/edit_holiday_work/' . $row_data->id) ?>"  style ="color: gray; cursor: pointer; !important" row_id="56">-->

                          <!--     <i class="far fa-edit" id="edit"></i></a> -->

                        <?php endif ?>

                      </td>

                    </tr>

                  <?php } ?>

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
          <div class="col-12 col-lg-6 row d-flex d-lg-none justify-content-center">
            <div class="col-12 col-lg-6 d-flex justify-content-lg-end justify-content-center align-items-center mx-2">
              <div class="d-flex align-items-center row">
                <div class="d-inline col-12 col-lg-6">
                  <p class="p-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to
                    <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                </div>
                <div class="d-lg-inline d-flex col-12 col-lg-4 justify-content-center justify-content-lg-end">
                  <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">

                    <li><a <?php if ($current_page > 1)
                      echo " class='paginate' href='?page=$prev_page&row=$row&search=$search_data'"; ?>>

                        < </a>

                    </li>

                    <li><a class="paginate"
                        href="?status=<?= $STATUS ?>&page=1&row=<?= $row ?>&search=<?= $search_data ?>" <?php if ($current_page == 1)
                                echo "hidden"; ?>>1 </a></li>

                    <li><a <?php if ($current_page <= 2)
                      echo "hidden"; ?>>... </a></li>

                    <li><a class="paginate"
                        href="?status=<?= $STATUS ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>&search=<?= $search_data ?>"
                        <?php if ($current_page <= 2)
                          echo "hidden"; ?>><?= $prev_page ?></a></li>

                    <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>

                    <li><a class="paginate"
                        href="?status=<?= $STATUS ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>&search=<?= $search_data ?>"
                        <?php if ($current_page >= $last_page - 1)
                          echo "hidden"; ?>><?= $next_page ?> </a></li>

                    <li><a <?php if ($current_page >= $last_page - 1)
                      echo "hidden"; ?>>... </a></li>

                    <li><a class="paginate"
                        href="?status=<?= $STATUS ?>&page=<?= $last_page ?>&row=<?= $row ?>&search=<?= $search_data ?>"
                        <?php if ($current_page == $last_page || $last_page <= 0)
                          echo "hidden"; ?>><?= $last_page ?> </a>
                    </li>

                    <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)
                      echo "class='paginate'  href='?status=$STATUS&page=$next_page&row=$row&search=$search_data'"; ?>>> </a></li>

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

                <option value=<?= $C_ROW_DISPLAY_ROW ?>   <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>

                <?php

              } ?>

            </select>
          </div>

        </div>

      </div>

    </div>

  </div>



  <!-- modal reporting to, directs start-->
  <div class="modal fade vertical-centered" id="modalDirects" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="d-flex justify-content-end">
          <button type="button" class="close pr-3 pt-2" data-dismiss="modal" aria-label="Close"
            style="font-size: 34px;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modalLoading" class="modal-body pt-0"
          style="position:absolute;height:100%;width:100%;background:white;z-index:1000;display:none;">
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
                    <img class="img-circle2 rounded-circle avatar m-3  elevation-2" onerror="setDefaultImage(this)"
                      id="employee_img" style="cursor: pointer;" data-toggle="tooltip" data-placement="right"
                      title="Profile Image" src="<?= base_url() ?>/assets_system/images/default_user.jpg">
                  </div>
                  <div class="basic-profile p-2">
                    <div class="d-flex align-items-center">
                      <div class="stats" id="employeeNumber" style="line-height:1;">(No Employee Number)</div>
                    </div>
                    <div class="d-flex align-items-center">
                      <text style="font-size:15px;" class="emp-name text-bold m-0" id="employeeFullName">(No Full
                        Name)</text>
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
  </div>
  </div>
  <!-- modal reporting to, directs end-->





  <!-- Set SSA -->

  <div class="modal fade" id="modal_approval" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg" id="approval_modal_content">

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
      })
    </script>

    <?php

  }

  ?>

  <?php

  if ($this->session->flashdata('ERR')) {

    ?>
    <script>
      $(document).Toasts('create', {
        class: 'bg-warning toast_width',
        title: 'Warning!',
        subtitle: 'close',
        body: '<?php echo $this->session->flashdata('ERR'); ?>'
      })
    </script>
    <!-- <script>Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',

                '',

                'error'

            )

        </script> -->

    <?php

  }

  ?>

  <script>
    var TABLE_DATA = <?php echo json_encode($TABLE_DATA); ?>;
    console.log('TABLE_DATA', TABLE_DATA);
  </script>

  <script>
    $(document).ready(function () {


      $('.select-employee').select2();
      $('#modal_approval').on('show.bs.modal', function (e) {

        var button = $(e.relatedTarget);

        var id = button.data('id');

        $.get("<?= base_url('selfservices/get_holiday_work_status') ?>" + '/' + id, function (res) {

          $('#approval_modal_content').html(res)

        })

        // fetch()

        // .then(res=>res)

        // .then(data=>{

        //     console.log(data)

        // })

      });

      $('#search_btn').on('click', function () {

        reloadPage();

      })

      $('a.paginate').on('click', function () {

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
          filter_url = filter_url + '&filter=1';
        }

        window.location.href = "<?= base_url('overtimes/holiday_works') ?>" + $(this).attr('href') + filter_url;

        return false;

      })



      $('.leave_status,#row_dropdown').on('change', function () {

        reloadPage();

      })

      $('.filter_select').on('change', function () {

        reloadPage()

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

        window.location.href = "<?= base_url('overtimes/holiday_works') ?>" + "?status=" + status + "&page=" + page + "&row=" + row + '&search=' + search + filter_url;

      }

    })
  </script>


  <!-- Modal Reporting to, Directs Starts -->

  <script>
    function setDefaultImage(img) {
      img.src = "<?= base_url() ?>/assets_system/images/default_user.jpg";
      img.alt = 'Default Image';
    }
  </script>

  <script>
    // var jsVar = <?php echo json_encode($TABLE_DATA); ?>;
    // console.log('jsVar', jsVar)
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
    $('.td-directs').on('click', function (e) {
      e.stopPropagation();
      let employee_id = $(this).data('empl_id')
      directs(employee_id)
    })
    $('.td-directs2').on('click', function (e) {
      e.stopPropagation();
      let employee_id = $(this).data('empl_id')
      directs(employee_id)
    })
    const directs = async (employeeId) => {
      // directsParent.innerHTML = 'No';
      document.getElementById("modalLoading").style.display = "block";
      $('#modalDirects').modal('show');
      const apiUrl = baseUrl + 'selfservices/get_reporting_to_directives';
      const data = {
        employeeId
      };
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
              `<img class="img-circle2 rounded-circle avatar elevation-2" onerror="setDefaultImage(this)"
                style="cursor: pointer;width:50px !important;height:50px !important" data-toggle="tooltip" 
                data-placement="right" title="Reporting To" 
                src="${reportingToImage}">
              <div class="mx-2">
                <p class="p-0 m-0" style="line-height: 1;font: size 13px;font-weight:500;">${reportingFullName}</p>
              </div>`;
          } else {
            document.getElementById("reportingToContainer").innerHTML = '(No Reporting To)'
          }
          var directsParent = document.getElementById("directsParent");

          console.log('directs condition', Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0)
          if (Array.isArray(result.data.directsTo) && result.data.directsTo.length > 0) {
            directsParent.innerHTML = '';
            result.data.directsTo.forEach(function (user) {
              let directMiddleInitial = `${user.col_midl_name.charAt(0)}.`
              if (!directMiddleInitial) directMiddleInitial = null;
              const directFullName = `${user.col_last_name}, ${user.col_frst_name} ${directMiddleInitial}`;
              let directImage = `${baseUrl}/assets_system/images/default_user.jpg`;
              if (result.data.directsTo[0].col_imag_path) {
                directImage = `${baseUrl}/assets_user/user_profile/${user.col_imag_path}`;
              }
              var div = document.createElement("div");
              div.className = "d-flex align-items-center";
              div.innerHTML = `
                <div  class="d-flex align-items-center mb-2">
                  <img class="img-circle2 rounded-circle avatar elevation-2" onerror="setDefaultImage(this)"
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
    }
  </script>
  <!-- Modal Reporting to, Directs Ends-->
  <!-------------------- Export ----------------->
  <!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->
  <script src="<?= base_url() ?>assets_system/js/xlsx.full.min.js"></script>
  <script>
    document.getElementById("btn_export").addEventListener('click', function () {

      /* Create worksheet from HTML DOM TABLE */

      var wb = XLSX.utils.table_to_book(document.getElementById("table_main"));

      /* Export to file (start a download) */

      XLSX.writeFile(wb, "<?php echo 'holiday_work_list.xlsx' ?>");

    });
  </script>

  <script>
    function toggleFilter() {
      document.querySelector('.filter-container').classList.toggle('visible');
    }
  </script>

</body>

</html>