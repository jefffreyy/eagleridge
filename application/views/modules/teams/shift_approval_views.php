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
</style>

<?php

$this->load->library('session');



$url_count          = $this->uri->total_segments();

$url_directory      = $this->uri->segment($url_count);

?>

<?php

$search_data = $this->input->get('search');



$search_data    = str_replace("_", " ", $search_data ?? '');

$company_data   = $this->input->get('company');

$branch_data    = $this->input->get('branch');

$dept_data      = $this->input->get('dept');

$div_data       = $this->input->get('div');

$section_data   = $this->input->get('section');

$group_data     = $this->input->get('group');

$team_data      = $this->input->get('team');

$line_data      = $this->input->get('line');



$id_prefix = 'SHA';

// $PAGE=1;

// $C_DATA_COUNT =0;

// $PAGES_COUNT=0;

$TAB = 'active';

$ACTIVES = 0;

$INACTIVES = 0;

// $ROW=25;

$filter = $this->input->get('filter');

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

          <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('overtimes') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
            </a>&nbsp;Shift Assignment Requests<h1>

        </div>

        



      </div>

      <hr>

    

      <div class="filter-container <?= $filter ? 'visible' : '' ?>">
        <div class="row mb-4  d-flex">

        


          <!-- <div class="col-md-2">

            <p class="mb-1 text-secondary ">Action</p>

            <a href="<?= base_url('overtimes/overtime') ?>" id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>

          </div> -->

          <div class="col-md-2">
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

        <div class="card border-0 pt-1 m-0">

          <!-- <div class="card-header p-0">
            <div class="input-group m-2 ml-auto" style="width:max-content">
                <div class="input-group-prepend">
                   <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i

                    class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
                </div>
                <select class="select-employee d-block" id="search_data" style="min-width:300px;width:max-content">
                    <option value=''>All</option>
                    <?php foreach ($EMPLOYEES as $employee) { ?>
                                        <option value="<?= $employee->id ?>" <?= $search_data == $employee->id ? 'selected' : '' ?>><?= $employee->col_empl_cmid . "-" . $this->system_functions->fomatName($employee->col_last_name, $employee->col_frst_name, $employee->col_midl_name) ?></option>
                    <?php } ?>
                </select>

            </div>

        </div> -->



          <div class="p-2">
            <div class="card-header p-0">
              <div class="">
                <div class="d-flex row align-items-center mx-1">
                  <div class="form-group row d-flex justify-content-center justify-content-lg-start col-12 col-md-3 col-lg-6 ">

                    <label class="col-md-12 mb-1 text-secondary ">Employee</label>
                    <select class="px-1 col-12 col-md-4 employee_select form-control" id="search_data">
                      <option value=''>All</option>
                      <?php foreach ($EMPLOYEES as $employee) {
                        $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
                        if (!empty($employee->col_suffix)) $name = $name . ' ' . $employee->col_suffix;
                        if (!empty($employee->col_frst_name)) $name = $name . ', ' . $employee->col_frst_name;
                        if (!empty($employee->col_midl_name)) $name = $name . ' ' . $employee->col_midl_name[0] . '.';
                      ?>
                        <option value="<?= $employee->id ?>" <?= $search_data == $employee->id ? 'selected' : '' ?>><?= $name
                                                                                                                    // $employee->col_empl_cmid."-".$this->system_functions->fomatName($employee->col_last_name,$employee->col_frst_name,$employee->col_midl_name)
                                                                                                                    ?></option>
                      <?php } ?>
                    </select>
                    <button id="btnFilter" class="mt-2 mt-lg-0 btn btn-primary shadow-none rounded ml-1" onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg') ?>" style="margin-bottom: 1px" alt="" />&nbsp;Advance Filter</button>
                    <a href="<?= base_url('overtimes/overtime') ?>" id="btn_clear_filter" class="mt-2 mt-lg-0 btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="" />&nbsp;Clear</a>



                  </div>

                  <div class="d-none d-lg-flex col-sm-7 col-md-10 col-lg-6 justify-content-center my-lg-0 my-2">
                    <div class="col-12 col-lg-10 d-flex justify-content-end align-items-end ">
                      <div class="d-flex align-items-center row">
                        <div class="d-inline col-12 col-lg-6">
                          <p class="p-0 m-0 mx-auto text-center" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                        </div>
                        <div class="d-lg-inline d-flex col-12 col-lg-6 justify-content-center justify-content-lg-end">
                        <ul class="pagination ml-0 ml-lg-4 m-0 p-0">

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
                    <div class="col-12 col-lg-2 d-none d-lg-flex justify-content-center align-items-center ml-auto">
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
            <table class="table table-hover table-bordered m-0" id="table_main" style="width:100%">
              <thead>

                <th class="text-left" style="width:10%">ID</th>

                <!-- <th class="text-center">ASSIGNED BY</th> -->
                <th class="text-left" style="width:15%">EMPLOYEE</th>

                <th class="text-left" style="width:10%">CUT-OFF PERIOD</th>
                <!-- <th class="text-center" style="width:10%">APPROVER</th> -->


                <th class="text-center" style="width:10%">STATUS</th>

                <!-- <th class="text-center">REMARKS</th> -->

                <th class="text-center" style="width:10%">ACTION</th>

              </thead>

              <tbody id="tbl_application_container">

                <?php if ($TABLE_DATA) {  ?>

                  <?php foreach ($TABLE_DATA as $row_data) { ?>

                    <tr class="hover" data-id="<?= $row_data->id ?>" data-toggle="modal" data-target="#modal_approval">

                      <td><?= $id_prefix . str_pad($row_data->id, 5, '0', STR_PAD_LEFT) ?></td>
                      <td class="text-center text-primary td-directs" data-empl_id="<?= $row_data->assigned_by ?>"><?= $row_data->assigned_by ?></td>
                      <td class="text-left"> <?= date(($DATE_FORMAT) ? $DATE_FORMAT: "m/Y", strtotime($row_data->monthyear)) ?></td>
                      <!-- <td class="text-left"><?= $row_data->approver ?></td> -->

                      <td class="text-center">

                        <?php

                        if ($row_data->status == "Approved") { ?>

                          <div class=' technos-button-green p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>

                        <?php } elseif ($row_data->status == "Rejected") { ?>

                          <div class='bg-danger p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>

                        <?php } elseif ($row_data->status == "Withdrawed" || $row_data->status == "Cancelled") { ?>

                          <div class='bg-secondary p-2 rounded disabled m-auto' style="width:100px"><?= $row_data->status ?></div>

                        <?php } else { ?>

                          <div class='bg-warning  p-2 rounded disabled m-auto' style="width:100px">Pending</div>

                        <?php } ?>

                      </td>

                      <!-- <td class="text-center"><?= $row_data->comment ?></td> -->

                      <td class="text-center">

                        <a class="select_row p-2" style="color: gray; cursor: pointer !important" row_id="56">

                          <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="">
                        </a>

                        

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
                  <p class="pp-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                </div>
                <div class="d-lg-inline d-flex col-12 col-lg-4 justify-content-center justify-content-lg-end">
                  <ul class="pagination ml-0 ml-lg-4 m-0 p-0">

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





  <!-- modal reporting to, directs start-->
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
  </div>
  </div>
  <!-- modal reporting to, directs end-->



  <!-- Set SSA -->

  <div class="modal fade" id="modal_approval" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

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
    var TABLE_DATA = <?php echo json_encode($TABLE_DATA); ?>;
    // console.log('TABLE_DATA', TABLE_DATA);
  </script>

  <script>
    $(document).ready(function() {
      $('.select-employee').select2();
      $(document).on('click', 'button.btn_cancel', function(e) {
        let id = $(this).data('id');
        $.post("<?= base_url('overtimes/cancel_overtime') ?>", {
          'id': id,
          'status': 'Cancelled'
        }, function(res) {
          if (res == 1) {
            window.location.reload();
          }
        })

      })
      $('#modal_approval').on('show.bs.modal', function(e) {

        var button = $(e.relatedTarget);

        var id = button.data('id');

        $.get("<?= base_url('selfservices/get_overtime_status') ?>" + '/' + id, function(res) {

          $('#approval_modal_content').html(res)

        })

        // fetch()

        // .then(res=>res)

        // .then(data=>{

        //     console.log(data)

        // })

      });

      $('a.paginate').on('click', function() {

        var status = $('.leave_status').val();

        var row = $('#row_dropdown').val();

        var page = "<?= $PAGE ?>";

        var search = $('#search_data').val();

        var company = $('#filter_by_company').val();

        var branch = $('#filter_by_branch').val();

        var department = $('#filter_by_department').val();

        var division = $('#filter_by_division').val();

        var section = $('#filter_by_section').val();

        var group = $('#filter_by_group').val();

        var team = $('#filter_by_team').val();

        var line = $('#filter_by_line').val();

        var filter_url = '&company=' + company + '&branch=' + branch + '&dept=' + department + '&div=' + division + '&section=' + section + '&group=' + group + '&team=' + team + '&line=' + line;

        if (document.querySelector('.filter-container').classList.contains('visible')) {
          filter_url = filter_url + '&filter=1';
        }

        window.location.href = "<?= base_url('overtimes/overtime') ?>" + $(this).attr('href') + filter_url;

        return false;

      })

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

      function reloadPage() {

        var status = $('.leave_status').val();

        var row = $('#row_dropdown').val();

        var page = "<?= $PAGE ?>";

        var search = $('#search_data').val();

        var company = $('#filter_by_company').val();

        var branch = $('#filter_by_branch').val();

        var department = $('#filter_by_department').val();

        var division = $('#filter_by_division').val();

        var section = $('#filter_by_section').val();

        var group = $('#filter_by_group').val();

        var team = $('#filter_by_team').val();

        var line = $('#filter_by_line').val();

        var filter_url = '&company=' + company + '&branch=' + branch + '&dept=' + department + '&div=' + division + '&section=' + section + '&group=' + group + '&team=' + team + '&line=' + line;

        if (document.querySelector('.filter-container').classList.contains('visible')) {
          filter_url = filter_url + '&filter=1';
        }

        window.location.href = "<?= base_url('overtimes/overtime') ?>" + "?status=" + status + "&page=" + page + "&row=" + row + '&search=' + search + filter_url;

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
    $('.td-directs').on('click', function(e) {
      e.stopPropagation();
      let employee_id = $(this).data('empl_id')
      directs(employee_id)
    })
    $('.td-directs2').on('click', function(e) {
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
              `<img class="img-circle2 rounded-circle avatar elevation-2" onerror="setDefaultImage(this)"
                style="cursor: pointer;width:50px !important;height:50px !important" data-toggle="tooltip" 
                data-placement="right" title="Reporting To" 
                src="${reportingToImage}">
              <div class="mx-2">
                <p class="p-0 m-0" style="line-height: 1;font: size 13px;font-weight:500;">${reportingToFullName}</p>
              </div>`;
          } else {
            document.getElementById("reportingToContainer").innerHTML = '(No Reporting To)'
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
  <script src="<?= base_url() ?>/assets_system/js/xlsx.full.min.js"></script>

  <script>
    document.getElementById("btn_export").addEventListener('click', function() {

      /* Create worksheet from HTML DOM TABLE */

      var wb = XLSX.utils.table_to_book(document.getElementById("table_main"));

      /* Export to file (start a download) */

      XLSX.writeFile(wb, "<?php echo 'overtime_list.xlsx' ?>");

    });
  </script>

  <script>
    function toggleFilter() {
      document.querySelector('.filter-container').classList.toggle('visible');
    }
  </script>

  <script>
    $(document).ready(function() {

      $('#settingsDropdown').on('change', function() {
        var selectedValue = $(this).val();

        if (selectedValue === 'recommend') {
          window.location.href = '<?= base_url('overtimes/overtime_recommendations') ?>';
        }
        if (selectedValue === 'multi_request') {
          window.location.href = '<?= base_url('overtimes/overtime_multi') ?>';
        }
      });
    });
  </script>

</body>

</html>