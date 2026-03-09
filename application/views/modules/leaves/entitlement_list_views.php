<!------------------------------------------------------ A. PAGE INFORMATION  -----------------------------------------------------
TECHNOS SYSTEM ENGINEERING INC.
EyeBox HRMS
@author     Technos Developers
@datetime   11 October 2022
@purpose    My Leave
CONTROLLER FILES:
MODEL FILES:
----------------------------------------------------------- A. STYLESHEETS  ----------------------------------------------------->
<html>
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/companycontribution_style'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<body>
  <!-- Content Starts -->
  <div class="content-wrapper">
    <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>leaves">Leave</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Entitlement List</li>
                </ol>
            </nav>
      <div class="row">
        <!-- Title Text -->
        <div class="col-md-6">
          <h1 class="page-title">Entitlement List</h1>
        </div>
        <!-- Title Button -->
        <div class="col-md-6  button-title">
          <a href="#" data-toggle="modal" data-target="#modal_assign_entitlement" class="btn btn-primary shadow-none"><i class="fas fa-plus"></i> Assign Entitlement</a>
          <a href="#" class="btn btn-primary shadow-none" id="btn_export"><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>
          <a href="<?= base_url() . 'leaves/importLeaveCredits' ?>" class="btn btn-primary shadow-none"><i class="fas fa-file-import"></i> Import Leave Credits </a>
        </div>
      </div>
      <!-- Title Header Line -->
      <hr>
      <div class="card border-0 mt-2" id="for_approval" style="padding: 0px; margin: 0px">
        <div class="row">
          <div class="col">
            <div class="table-responsive">
              <table class="table table-hover" id="TableToExport">
                <thead>
                  <th>Employee</th>
                  <th>Date</th>
                  <th>Leave&nbsp;Type</th>
                  <th>Value&nbsp;(Days)</th>
                  <th style="width: 250px;">New&nbsp;Leave&nbsp;Balance&nbsp;(Days) </th>
                  <th style="width: 250px;">Reason&nbsp;or&nbsp;entitlement </th>
                </thead>
                <tbody id="tbl_application_container">
                  <?php
                  if ($DISP_ENTITLEMENT_INFO) {
                    foreach ($DISP_ENTITLEMENT_INFO as $DISP_ENTITLEMENT_INFO_ROW) {
                  ?>
                      <tr>
                        <td><?= $DISP_ENTITLEMENT_INFO_ROW["employee"][0]->col_last_name . ', ' . $DISP_ENTITLEMENT_INFO_ROW["employee"][0]->col_frst_name  ?></td>
                        <td><?= $DISP_ENTITLEMENT_INFO_ROW["date"] ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                    <?php
                    }
                  } else {
                    ?>
                    <!-- Message if no entries -->
                    <tr class="table-active">
                      <td colspan="9">
                        <center>No Employee Yet</center>
                      </td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Pagination -->
      <right>
        <ul id="btn_pagination" class="pagination mr-auto ml-auto"></ul>
      </right>
    </div>
  </div>
  <aside class="control-sidebar control-sidebar-dark"></aside>
  <!-- /.control-sidebar -->
  <!-- ENTITLE LEAVE MODAL -->
  <div class="modal fade" id="modal_assign_entitlement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title mt-0 ml-1">Leave Entitlement
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
          </button>
        </div>
        <div class="modal-body pb-5">
          <div class="row mb-2">
            <div class="col-3">
              <div class="form-group w-100 float-left">
                <label>Vacation Leave</label>&nbsp;&nbsp;
                <span class="float-right" id="vacation_balance"></span>
              </div>
              <div class="form-group w-100 float-left">
                <label>Sick Leave</label>&nbsp;&nbsp;
                <span class="float-right" id="sick_balance"></span>
              </div>
            </div>
            <div class="col-1"></div>
            <div class="col-3">
              <div class="form-group w-100 float-left">
                <label>Parental Leave</label>&nbsp;&nbsp;
                <span class="float-right" id="parental_balance"></span>
              </div>
              <div class="form-group w-100 float-left">
                <label>Paternity Leave</label>&nbsp;&nbsp;
                <span class="float-right" id="paternal_balance"></span>
              </div>
            </div>
            <div class="col-1"></div>
            <div class="col-3">
              <div class="form-group w-100 float-left">
                <label>Service Incentive Leave</label>&nbsp;&nbsp;
                <span class="float-right" id="service_incentive_balance"></span>
              </div>
              <div class="form-group w-100 float-left">
                <label class="mb-0">Solo Incentive Leave:</label>&nbsp;&nbsp;
                <span class="float-right" id="solo_incentive_balance"></span>
              </div>
            </div>
            <div class="col-1"></div>
          </div>
          <div class="row mb-3">
            <div class="col-12 text-center">
              <div class="form-group w-100 float-left">
                <label>Maternity Leave</label>&nbsp;&nbsp;
                <span id="maternity_balance"></span>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-12">
              <form action="<?php echo base_url(); ?>leaves/insrt_entitlement" id="apply_leave_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="required" for="INSRT_ASSIGN_EMPL">Assign to Employee
                  </label>
                  <select class="form-control" name="INSRT_ASSIGN_EMPL" id="INSRT_ASSIGN_EMPL" required>
                    <option value="">Choose...</option>
                    <?php
                    foreach ($DISP_EMPL_INFO as $DISP_EMPL_INFO_ROW) {
                      if ($DISP_EMPL_INFO_ROW->col_midl_name) {
                        $midl_ini = $DISP_EMPL_INFO_ROW->col_midl_name[0] . '.';
                      } else {
                        $midl_ini = '';
                      }
                    ?>
                      <option value="<?= $DISP_EMPL_INFO_ROW->id ?>"><?= $DISP_EMPL_INFO_ROW->empl_id. ' - ' . $DISP_EMPL_INFO_ROW->col_last_name . ', ' . $DISP_EMPL_INFO_ROW->col_frst_name . ' ' . $midl_ini ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_TYPE">Leave Type
                  </label>
                  <select class="form-control" name="INSRT_LEAVE_TYPE" id="INSRT_LEAVE_TYPE" required>
                    <option value="">Choose...</option>
                    <?php
                    foreach ($DISP_LEAVETYPES_INFO as $DISP_LEAVETYPES_INFO_ROW) {
                    ?>
                      <option value="<?= $DISP_LEAVETYPES_INFO_ROW->name ?>"><?= $DISP_LEAVETYPES_INFO_ROW->name ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group mb-0">
                  <label class="required" for="INSRT_LEAVE_VALUE">Value (Day/s)
                  </label>
                  <input class="form-control" type="number" name="INSRT_LEAVE_VALUE" id="INSRT_LEAVE_VALUE" step="0.1" placeholder="Enter number of day/s" required>
                </div>
                <!-- <small id="valueHelp" class="form-text text-muted">(If you want to include half of a day, just include .5)</small> -->
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="INSRT_LEAVE_COMMENT">Comment
                      </label>
                      <textarea class="form-control" name="INSRT_LEAVE_COMMENT" id="INSRT_LEAVE_COMMENT" cols="30" rows="5"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 w-100">
                    <input type="hidden" name="INSRT_EMPL_LEAVE_BALANCE" id="INSRT_EMPL_LEAVE_BALANCE">
                    <input type="hidden" name="INSRT_ASSIGNED_BY" value="<?= $this->session->userdata('SESS_USER_ID') ?>">
                    <button class="btn btn-primary float-right" id="INSRT_LEAVE_BTN" type="submit">Apply</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
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
  <?php
  $page_count = $DISP_ROW_COUNT / 20;
  if (($DISP_ROW_COUNT % 20) != 0) {
    $page_count = $page_count++;
  }
  $page_count = ceil($page_count);
  ?>
  <input type="hidden" id="row_count" value="<?= $DISP_ROW_COUNT ?>">
  <input type="hidden" id="page_count" value="<?= $page_count ?>">
<!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
<?php $this->load->view('templates/jquery_link'); ?>
  <!-- SESSION MESSAGES -->
  <?php
  if ($this->session->userdata('SESS_SUCC_MSG_INSRT_ENTITLEMENT')) {
  ?>
    <script>
      Swal.fire(
        '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_ENTITLEMENT'); ?>',
        '',
        'success'
      )
    </script>
  <?php
    $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_ENTITLEMENT');
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
  <script>
    $(document).ready(function() {
      var url = '<?php echo base_url(); ?>leave/getEmployeeData';
      $('#INSRT_ASSIGN_EMPL').change(function() {
        var employee_id = $('#INSRT_ASSIGN_EMPL').val();
        console.log(employee_id);
        getEmployeeData(url, employee_id).then(data => {
          if (data.length > 0) {
            data.forEach((x) => {
              document.getElementById('vacation_balance').innerHTML = x.col_leave_vacation;
              document.getElementById('sick_balance').innerHTML = x.col_leave_sick;
              document.getElementById('maternity_balance').innerHTML = x.col_leave_maternity;
              document.getElementById('parental_balance').innerHTML = x.col_leave_parental;
              document.getElementById('paternal_balance').innerHTML = x.col_leave_paternal;
              document.getElementById('service_incentive_balance').innerHTML = x.col_leave_service_incentive;
              document.getElementById('solo_incentive_balance').innerHTML = x.col_leave_solo_incentive;
            });
          }
        });
      })
      async function getEmployeeData(url, employee_id) {
        var formData = new FormData();
        formData.append('employee_id', employee_id);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }
      var url_get_entitlement_list = '<?= base_url() ?>leave/get_entitlement_list';
      var url_get_empl_data = '<?= base_url() ?>leave/get_empl_data';
      var url_get_leave_balance = '<?= base_url() ?>leave/get_leave_balance';
      $('#btn_pagination').pagination();
      var row_count = $('#row_count').val();
      var page_count = $('#page_count').val();
      console.log(row_count);
      console.log(page_count);
      $('#btn_pagination').pagination({
        // the number of entries
        total: row_count,
        // current page
        current: 1,
        // the number of entires per page
        length: 20,
        // pagination size
        size: 2,
        // Prev/Next text
        prev: "&lt;",
        next: "&gt;",
        // fired on each click
        click: function(e) {
          $('#tbl_application_container').html('');
          var row_count = $('#row_count').val();
          var page_count = $('#page_count').val();
          // console.log(e.current);
          var page_num = e.current;
          // console.log(page_num);
          get_entitlement_list(url_get_entitlement_list, page_num).then(function(entitle) {
            Array.from(entitle).forEach(function(e) {
              var empl_id = e.empl_id;
              var leave_type = e.col_leave_type;
              switch (leave_type) {
                case 'Vacation Leave':
                  var db_leave_type = 'col_leave_vacation';
                  break;
                case 'Sick Leave':
                  var db_leave_type = 'col_leave_sick';
                  break;
                case 'Maternity Leave':
                  var db_leave_type = 'col_leave_maternity';
                  break;
                case 'Parental Leave':
                  var db_leave_type = 'col_leave_parental';
                  break;
                case 'Paternity Leave':
                  var db_leave_type = 'col_leave_paternal';
                  break;
                case 'Service Incentive Leave':
                  var db_leave_type = 'col_leave_service_incentive';
                  break;
                case 'Solo Incentive Leave':
                  var db_leave_type = 'col_leave_solo_incentive';
                  break;
                default:
                  var db_leave_type = '';
              }
              get_empl_data(url_get_empl_data, empl_id).then(function(empl) {
                Array.from(empl).forEach(function(x) {
                  var application_date = new Date(e.col_date_created).toLocaleDateString('en-us', {
                    weekday: "long",
                    year: "numeric",
                    month: "short",
                    day: "numeric"
                  });
                  if (x.col_midl_name) {
                    var midl_ini = x.col_midl_name + '.';
                  } else {
                    var midl_ini = '';
                  }
                  var empl_name = x.col_last_name + ', ' + x.col_frst_name + ' ' + midl_ini;
                  var id = x.id;
                  get_leave_balance(url_get_leave_balance, id, db_leave_type).then(function(leave) {
                    Array.from(leave).forEach(function(leave) {
                      $('#tbl_application_container').append(`
                                  <tr>
                                      <td>` + empl_name + `</td>
                                      <td>` + application_date + `</td>
                                      <td>` + e.col_leave_type + `</td>
                                      <td>` + e.col_leave_value + `</td>
                                      <td>` + leave.leave_bal + `</td>
                                      <td>` + e.col_leave_comments + `</td>
                                  </tr>
                                `)
                    })
                  })
                })
              })
            })
          })
        }
      });
      async function get_entitlement_list(url, page_num) {
        var formData = new FormData();
        formData.append('page_num', page_num);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }
      async function get_empl_data(url, id) {
        var formData = new FormData();
        formData.append('empl_id', id);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }
      async function get_leave_balance(url, id, type) {
        var formData = new FormData();
        formData.append('id', id);
        formData.append('type', type);
        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        return response.json();
      }
    })
  </script>
  <!-------------------- Export ----------------->
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script>
document.getElementById("btn_export").addEventListener('click', function() {
  /* Create worksheet from HTML DOM TABLE */
  var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
  /* Export to file (start a download) */
  XLSX.writeFile(wb, "Entitlement List.xlsx");
});
</script>
</body>
</html>