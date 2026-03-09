<html>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?= base_url('assets_system/css/handsontable14.css') ?>" />

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
      max-width: 100px !important;
      max-height: 100px !important;
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
          <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('requests/leave_lists') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
            </a>&nbsp;Leave Requests<h1>
        </div>

          <div class="col-md-6 button-title">
          <a href="<?= base_url('requests/leave_lists') ?>" class=" btn btn-primary"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
              &nbsp;Normal Request</a>
            <!-- <a href="#" class=" btn technos-button-gray shadow-none rounded" id="btn_export"><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a> -->
            <button class=" btn btn-primary" id="btn-update"><i class="far fa-check-circle"></i>&nbsp;Update Changes</button>
            <a href="<?= base_url('requests/new_request_leave_direct') ?>" class=" btn btn-primary"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">&nbsp;Add Request</a>
          </div>



      </div>
      <hr>

      <div class="filter-container <?= $filter? 'visible': ''?>">
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
              <select class="form-control leave_status" >
                <option value="">All</option>
                <?php foreach ($STATUSES as $status) { ?>
                  <option value="<?= $status ?>" <?= $status == $STATUS ? 'selected' : '' ?>><?= $status ?></option>
                <?php } ?>
              </select>
            </div>
            <!-- <div class="col-md-2">
              <p class="mb-1 text-secondary ">Action</p>
              <a href="<?= base_url('leaves/leave_lists_multi') ?>" id="btn_clear_filter" class="btn technos-button-green mx-1">Clear Filter</a>
            </div> -->
          </div> 
        <!-- filter divs ends -->

      </div>



      <div class="card border-0 p-0 m-0">
        <div class="card border-0 m-0">
          <div class="p-2">
            <div class="d-flex justify-content-between align-items-end">
              <div class="mx-1">
                <p class="mb-1 text-secondary ">Employee</p>
                <div class="d-flex">
                    <select class="select-employee form-control" id="search_data" style="min-width:300px;width:max-content">
                      <option value=''>All</option>
                      <?php foreach ($EMPLOYEES as $employee) {
                        $name = $employee->col_empl_cmid . '-' . $employee->col_last_name;
                        if (!empty($employee->col_suffix)) $name = $name . ' ' . $employee->col_suffix;
                        if (!empty($employee->col_frst_name)) $name = $name . ', ' . $employee->col_frst_name;
                        if (!empty($employee->col_midl_name)) $name = $name . ' ' . $employee->col_midl_name[0] . '.';
                      ?>
                        <option value="<?= $employee->id ?>" <?= $search_data == $employee->id ? 'selected' : '' ?>>
                        <?= $name?></option>
                      <?php } ?>
                    </select>
                    <button id="btnFilter" class="btn btn-primary shadow-none rounded ml-1" onclick="toggleFilter()"><img src="<?= base_url('assets_system/icons/advance_filter.svg')?>" style="margin-bottom: 1px" alt=""/>&nbsp;Advance Filter</button>
                    <a href="<?= base_url('requests/leave_lists_multi') ?>" id="btn_clear_filter" class="btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg')?>" alt=""/>&nbsp;Clear</a>
                </div>
                
              </div>
              
              <div class="float-right ">
                <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                <ul class="d-inline pagination m-0 p-0 ">
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

            <div class="row">
              <div class="col">
                <div class="">
                  <div id="table_data_new"> </div>
                </div>
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
                    <img class="img-circle rounded-circle avatar m-3  elevation-2"  id="employee_img" style="cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Profile Image" src="<?= base_url() ?>/assets_system/images/default_user.jpg" onerror="setDefaultImage(this)">
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
  <!-- <script>
    var LEAVES = <?php echo json_encode($LEAVES); ?>;
    console.log('LEAVES', LEAVES);
  </script> -->

  <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
  <script type="text/javascript" src="<?= base_url('assets_system/js/handsontable14.js') ?>"></script>
  <script>
    var data = <?php echo json_encode($LEAVES); ?>;
    console.log('data',data);
    <?php if($isLeaveHours == 0){?> 
        data.forEach(item=>{
          let dividedValue;
          if (item.duration < 8) {
              dividedValue = item.duration >= 4 ? 0.5 : 0;
          } else {
              dividedValue = Math.floor(item.duration / 8);
              if (item.duration % 8 >= 4) {
                  dividedValue += 0.5;
              }
          }
          item.duration = dividedValue;
        })
    <?php } ?>
    var leaveTypesRaw = <?php echo json_encode($leaveTypes); ?>;
  
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
    const leaveTypes = leaveTypesRaw.map(item=>item.name);
    console.log('leaveTypes', leaveTypes);
    console.log('leaveTypesRaw', leaveTypesRaw);
    console.log('data', data);

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
          ['id', 'LEAVE ID', 'EMPLOYEE',
            'LEAVE DATE', 'LEAVE TYPE', 'LEAVE DURATION',
            'REMARKS',
          ],
        ],
        rowHeaders: true,
        height: window.innerHeight- container.getBoundingClientRect().top - 30,
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
            readOnly: false,
            type: 'dropdown',
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
            data: 'type',
            readOnly: false,
            type: 'dropdown',
            source: leaveTypes,
            width: 200,
            wordWrap: false
          },
          {
            data: 'duration',
            readOnly: false,
            validator: function(value, callback) {
              <?php if($isLeaveHours == 1){?>
                if (value > 0) {
                callback(true);
                } else {
                  callback(false, 'Value must be greater than 0');
                }
              <?php } ?>

              <?php if($isLeaveHours == 0){?>
                if (value == 1 || value == 0.5 || value == .5) {
                callback(true);
                } else {
                  callback(false, 'Value must be 1 or 0.5');
                }
              <?php } ?>

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
        // if (changes[i].employee) {
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
          // balik
          if (!(!isNaN(changes[i].duration) && Number(changes[i].duration) > 0)) {
            changesLeavesInvalid.push(changes[i].c_id);
            continue;
          }
          <?php if($isLeaveHours == 1){?>
            if (!(!isNaN(changes[i].duration) && Number(changes[i].duration) > 0)) {
              changesLeavesInvalid.push(changes[i].c_id);
              continue;
            }
          <?php } ?>

          <?php if($isLeaveHours == 0){?>
            if (!(!isNaN(changes[i].duration) && (Number(changes[i].duration) == 1 || Number(changes[i].duration) == 0.5))) {
              changesLeavesInvalid.push(changes[i].c_id);
              continue;
            }
          <?php } ?>
          
          const typeObject = leaveTypesRaw.find(obj => obj.name === changes[i].type);
          if (!typeObject) {
            changesLeavesInvalid.push(changes[i].c_id);
            continue;
          }
          temp.type = typeObject.id;
          if (valid) {
            changesFinal.push(temp);
            changesLeaves.push(changes[i].c_id);
          }
        // }

      }

      console.log('changesLeaves', changesLeaves)
      console.log('changesLeavesInvalid', changesLeavesInvalid)
      console.log('changes', changes)
      console.log('changesFinal', changesFinal)
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
      <?php if($isLeaveHours == 0){?>
        changesFinal.forEach(item=>{
          item.duration = item.duration * 8;
        })
      <?php } ?>
      // console.log('changesfinal', changesFinal);

      var url = '<?= base_url() ?>';
      const apiUrl = url + 'leaves/update_leaves_direct';
      console.log('changesFinal', changesFinal);
      fetch(apiUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(changesFinal)
        })
        .then(response => response.json())
        .then(result => {
          console.log('result', result);
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
        $.get("<?= base_url('leaves/get_leave_approval_status') ?>" + '/' + leave_id, function(res) {
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
        var section = $('#filter_by_section').val();
        var group = $('#filter_by_group').val();
        var team = $('#filter_by_team').val();
        var line = $('#filter_by_line').val();
        var filter_url = '&company=' + company + '&branch=' + branch + '&dept=' + department + '&div=' + division + '&section=' + section + '&group=' + group + '&team=' + team + '&line=' + line;
        if (document.querySelector('.filter-container').classList.contains('visible')) {
          filter_url ="&filter=1";
        }
        window.location.href = "<?= base_url('requests/leave_lists_multi') ?>" + $(this).attr('href') + filter_url;
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
        var section = $('#filter_by_section').val();
        var group = $('#filter_by_group').val();
        var team = $('#filter_by_team').val();
        var line = $('#filter_by_line').val();
        var filter_url = '&company=' + company + '&branch=' + branch + '&dept=' + department + '&div=' + division + '&section=' + section + '&group=' + group + '&team=' + team + '&line=' + line;
        if (document.querySelector('.filter-container').classList.contains('visible')) {
          filter_url =filter_url+"&filter=1";
        }
        window.location.href = "<?= base_url('requests/leave_lists_multi') ?>" + "?status=" + status + "&page=" + page + "&row=" + row + '&search=' + search + filter_url;
      }

    })
  </script>
  <!-------------------- Export ----------------->

  <script>
    
    function toggleFilter() {
      document.querySelector('.filter-container').classList.toggle('visible');
    }
  </script>

<script>
        var filter = <?php echo json_encode($this->input->get('filter')); ?>;
        console.log('filter',filter);
    </script>

</body>

</html>