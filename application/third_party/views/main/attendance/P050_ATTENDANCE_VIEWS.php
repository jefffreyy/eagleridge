<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Daterange Picker -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/daterangepicker/daterangepicker.css">
<!-- Tempus Dominus -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Table Sorter -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins\tablesorter-master\dist\css\theme.ice.min.css">

<style>
  .btn-group .btn {
    padding: 0px 12px;
  }

  .page-title {
    font-weight: 600;
    color: #424F5C;
    font-size: 33px;
  }

  th,
  td {
    margin: 0px !important;
    font-size: 10px !important;
    padding: 10px 8px !important;
    border-top: none !important;
  }

  label.required::after {
    content: " *";
    color: red;
  }

  #btn_show_attendance {
    text-decoration: none;
  }

  #chevron_icon {
    transition: 0.5s;
  }

  .rotate-right {
    transition: 0.5s;
    transform: rotate(90deg);
  }

  .rotate-left {
    transition: 0.5s;
    transform: rotate(180deg);
  }

  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  input[type=number] {
    -moz-appearance: textfield;
  }

  .warning_icon:hover {
    transition: 0.5s;
    color: #ff5c57 !important;
    cursor: pointer;
  }

  .btn-orange {
    background-color: #ed9d13;
    color: #fff;
  }

  .btn-orange:hover {
    background-color: #d18402;
    color: #fff;
  }

  .btn-orange:disabled {
    background-color: #f5b240;
    color: #fff;
  }

  .btn-blue {
    background-color: #00a6ff;
    color: #fff;
  }

  .btn-blue:hover {
    background-color: #009ef2;
    color: #fff;
  }

  .btn-blue:disabled {
    background-color: #42beff;
    color: #fff;
  }

  .widget_container {
    width: 100%;
    height: 100px;
    border: 0.5px solid #ccc;
    margin-bottom: 10px;
    border-radius: 10px;
    padding: 6px 4px;
  }

  .widget {
    background-color: #e9eff2;
    /* color: #0D74BC; */
    padding: 5px 15px;
    font-size: 12px !important;
    border-radius: 6px;
    color: #black;
    border: 1px solid #ccc;
    font-weight: 600;
    margin-right: 5px;
  }

  .remove_widget {
    cursor: pointer;
    font-size: 12px !important;
    color: red;
    margin-left: 5px;
    margin-right: -8px;
    margin-top: -5px;
  }
</style>

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row">
      <div class="col-md-6">
        <h1 class="page-title">Attendance Records</h1>
      </div>
    </div>
    <hr>

    <div class="row mt-4">
      <div class="col-4">
        <div class="card p-2" style="background-color: #00897b; color: white;">
          <div style="padding: 10px 1px;" class="text-center">
            <text style="font-size: 20px; margin-bottom: -15px;" id="total_employees">
              <?= count($DISP_EMP_LIST); ?>
            </text><br>
            <text><b>Total Employees </b></text>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card p-2 card_ready_for_payslip" data-toggle="modal" data-target="#modal_count_empl_ready_for_payslip" style="cursor: pointer; background-color: #5E35B1; color: white;">
          <div style="padding: 10px 1px;" class="text-center">
            <text style="font-size: 20px; margin-bottom: -15px;" id="ready_count">
              0
            </text><br>
            <text class="text-bold">Ready for Payslip</text>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card p-2 card_not_ready_for_payslip" data-toggle="modal" data-target="#modal_count_empl_not_ready_for_payslip" style="cursor: pointer; background-color: #1F566D; color: white;">
          <div style="padding: 10px 1px;" class="text-center">
            <text style="font-size: 20px; margin-bottom: -15px;" id="not_ready_count">
              0
            </text><br>
            <text class="text-bold">Not Ready for Payslip</text>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <p class="text-secondary text-bold" style="font-size: 18px;">Filter Employees By:</p>
    <div class="row mb-4">
      <div class="col-md-2">
        <p class="mb-1 text-secondary ">Department</p>
        <select name="filter_by_department" id="filter_by_department" class="form-control">
          <?php
          if ($DISP_DISTINCT_DEPARTMENT) {
          ?>
            <option value="" <?php foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW_1) {
                                if ($DISP_DISTINCT_DEPARTMENT_ROW_1->col_empl_dept == '') {
                                  echo 'selected';
                                }
                              } ?>>All Departments</option>
            <?php
            foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW) {
              if ($DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept != '') {
            ?>
                <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?>"><?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?></option>
          <?php
              }
            }
          }
          ?>
        </select>
      </div>
      <div class="col-md-2">
        <p class="mb-1 text-secondary ">Section</p>
        <select name="filter_by_section" id="filter_by_section" class="form-control">
          <?php
          if ($DISP_DISTINCT_SECTION) {
          ?>
            <option value="" <?php foreach ($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW_1) {
                                if ($DISP_DISTINCT_SECTION_ROW_1->col_empl_sect == '') {
                                  echo 'selected';
                                }
                              } ?>>All Sections</option>
            <?php
            foreach ($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW) {
              if ($DISP_DISTINCT_SECTION_ROW->col_empl_sect != '') {
            ?>
                <option value="<?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?>"><?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?></option>
          <?php
              }
            }
          }
          ?>
        </select>
      </div>
      <div class="col-md-2">
        <p class="mb-1 text-secondary ">Group</p>
        <select name="filter_by_group" id="filter_by_group" class="form-control">
          <?php
          if ($DISP_Group) {
          ?>
            <option value="" <?php foreach ($DISP_Group as $DISP_Group_ROW_1) {
                                if ($DISP_Group_ROW_1->col_empl_group == '') {
                                  echo 'selected';
                                }
                              } ?>>All Groups</option>
            <?php
            foreach ($DISP_Group as $DISP_Group_ROW) {
              if ($DISP_Group_ROW->col_empl_group != '') {
            ?>
                <option value="<?= $DISP_Group_ROW->col_empl_group ?>"><?= $DISP_Group_ROW->col_empl_group ?></option>
          <?php
              }
            }
          }
          ?>
        </select>
      </div>
      <div class="col-md-2">
        <p class="mb-1 text-secondary ">Line</p>
        <select name="filter_by_line" id="filter_by_line" class="form-control">
          <?php
          if ($DISP_Line) {
          ?>
            <option value="" <?php foreach ($DISP_Line as $DISP_Line_ROW_1) {
                                if ($DISP_Line_ROW_1->col_empl_line == '') {
                                  echo 'selected';
                                }
                              } ?>>All Lines</option>
            <?php
            foreach ($DISP_Line as $DISP_Line_ROW) {
              if ($DISP_Line_ROW->col_empl_line != '') {
            ?>
                <option value="<?= $DISP_Line_ROW->col_empl_line ?>"><?= $DISP_Line_ROW->col_empl_line ?></option>
          <?php
              }
            }
          }
          ?>
        </select>
      </div>
      <div class="col-md-2">
        <p class="mb-1 text-secondary ">Status</p>
        <select name="filter_by_status" id="filter_by_status" class="form-control">
          <option value="">Choose...</option>
          <option value="not_ready">Not Ready for Payslip</option>
          <option value="ready">Ready for Payslip</option>
        </select>
      </div>
      <div class="col-md-2">
        <br>
        <a href="#" id="btn_clear_filter" class="btn btn-primary float-right">Clear Filter</a>
      </div>
    </div>
    <hr>

    <div class="row mb-3">
      <div class="col-3">
        <div style="width: 100%;">
          <p class="text-secondary text-bold" style="font-size: 18px;">Automated Attendance:</p>
          <br>
          <label for="search_employees" style="font-weight: 500">Cut-off Period</label>
        </div>
        <div class="flex-fill">
          <select name="cutoff_period" id="cutoff_period" class="form-control">
            <option value="">Select Period...</option>
            <?php
            if ($DISP_PAYROLL_SCHED) {
              foreach ($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW) {
            ?>
                <option value="<?= $DISP_PAYROLL_SCHED_ROW->db_name ?>"><?= $DISP_PAYROLL_SCHED_ROW->name ?></option>
            <?php
              }
            }
            ?>
          </select>
        </div>
      </div>
      <div class="col-3 px-1">
        <div style="width: 100px;">
          <br><br><br>
          <label for="search_employees" style="font-weight: 500">Employee</label>
        </div>
        <div class="flex-fill d-flex">
          <select name="employee_id" id="employee_id" class="form-control">
            <?php
            if ($DISP_EMP_LIST) {
              foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) {
                if ($DISP_EMP_LIST_ROW->col_midl_name) {
                  $midl_ini = $DISP_EMP_LIST_ROW->col_midl_name[0] . '.';
                } else {
                  $midl_ini = '';
                }
            ?>
                <option value="<?= $DISP_EMP_LIST_ROW->id ?>" position="<?= $DISP_EMP_LIST_ROW->col_empl_posi ?>" group="<?= $DISP_EMP_LIST_ROW->col_empl_group ?>"><?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name . ' ' . $midl_ini ?></option>
            <?php
              }
            }
            ?>
          </select>
          <button class="btn btn-primary ml-2" id="btn_prev" title="Previous Employee"><i class="fas fa-angle-left"></i></button>
          <button class="btn btn-primary ml-1" id="btn_next" title="Next Employee"><i class="fas fa-angle-right"></i></button>
        </div>
      </div>
      <div class="col-6">
        <div class="card mb-0 p-3">
          <div class="row">
            <div class="col-6">
              <p class="mb-2 text-secondary text-bold">Set Shift</p>
              <button href="#" id="copy_shift_toggle_modal" class="btn btn-primary w-100 mb-1" data-toggle="modal" data-target="#modal_copy_shift" disabled>Copy Shift</button>
              <button href="#" id="apply_template_toggle_modal" class="btn btn-primary w-100" data-toggle="modal" data-target="#modal_apply_template" disabled>Apply Shift Template</button>
            </div>
            <div class="col-6">
              <p class="mb-2 text-secondary text-bold">Calculate & Save</p>
              <div class="row">
                <div class="col-6 pr-1 mb-1">
                  <button href="#" id="btn_approve_attendance" class="w-100 btn btn-primary" disabled><i class="fas fa-lock"></i>&nbsp;&nbsp;Lock</button>
                </div>
                <div class="col-6 pl-1">
                  <button href="#" id="btn_calculate_attendance" class="w-100 btn btn-blue" disabled>Calculate</button>

                </div>
              </div>
              <div class="row">
                <div class="col-6 pr-1 mb-1">
                  <button href="#" id="btn_disapprove_attendance" class="w-100 btn btn-primary" disabled><i class="fas fa-unlock-alt"></i>&nbsp;&nbsp;Unlock</button>
                </div>
                <div class="col-6 pl-1">
                  <button href="#" id="btn_view_att_summary" data-toggle="modal" data-target="#modal_attendance_summary" class="w-100 btn btn-orange" disabled>View Summary</button>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="card">
      <table class="table table-hover table-xs mb-0 hover-highlight" id="tbl_attendance">
        <thead>
          <tr>
            <th>Date</th>
            <th>DOW</th>
            <th style="display: none;">Employee</th>
            <th>Day Code</th>
            <th>Shift for the Day</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Status</th>
            <th style="display: none;">Remarks</th>
            <th>WD</th>
            <th>NO TI/TO</th>
            <th>RD_SP</th>
            <th>REG_HOL</th>
            <th>RD+REG_HOL</th>
            <th>RD+SP</th>
            <th>ABS</th>
            <th>TARD</th>
            <th>UT</th>
            <th>REG_OT</th>
            <th>ND</th>
            <th>ND_OT</th>
            <th>PD_L</th>
            <th>Half</th>
            <th>REST OT</th>
            <th>REST ND OT</th>
          </tr>
        </thead>
        <tbody id="cutoff_container">
          <tr>
            <td colspan="23" class="text-center py-5" style="background-color: #f0f0f0;">No selected cut-off period</td>
          </tr>
        </tbody>
      </table>
      <div class="w-100 text-center">
        <img src="<?= base_url() ?>images/loader2.gif" id="loader_gif" style="width: 180px; height: 120px; display: none;">
      </div>
    </div>
  </div>
</div>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

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








<!-- =============== APPY TEMPLATE ================= -->
<div class="modal fade" id="modal_count_empl_ready_for_payslip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Employees Ready for Payslip
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body" style="max-height:80vh; overflow-y:scroll">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Position</th>
              <th>Group</th>
            </tr>
          </thead>
          <tbody id="tbl_count_empl_ready_for_payslip">
            <!-- content here -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


















<!-- =============== APPY TEMPLATE ================= -->
<div class="modal fade" id="modal_count_empl_not_ready_for_payslip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Employees Not Ready for Payslip
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body" style="max-height:80vh; overflow-y:scroll">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Position</th>
              <th>Group</th>
            </tr>
          </thead>
          <tbody id="tbl_count_empl_not_ready_for_payslip">
            <!-- content here -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- =============== APPY TEMPLATE ================= -->
<div class="modal fade" id="modal_apply_template" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Apply Shift Template
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="from_date">From Date</label>
              <select id="from_date" class="form-control">

              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="to_date">To Date</label>
              <select id="to_date" class="form-control">

              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="required " for="ATTENDANCE_INPF_NAME">Shift Name
              </label>
              <select name="work_shift_template" id="work_shift_template" class="form-control">
                <option value="">Choose Template...</option>
                <?php
                if ($DISP_SHIFT_TEMPLATE) {
                  foreach ($DISP_SHIFT_TEMPLATE as $DISP_SHIFT_TEMPLATE_ROW) {
                ?>
                    <option value="<?= $DISP_SHIFT_TEMPLATE_ROW->id ?>"><?= $DISP_SHIFT_TEMPLATE_ROW->name ?></option>
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
        <a class='btn btn-primary text-light' id="btn_apply_template">&nbsp; Apply
        </a>
      </div>
    </div>
  </div>
</div>


<!-- =============== COPY SHIFT ================= -->
<div class="modal fade" id="modal_copy_shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Copy Shift To
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="mt-2 px-2">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="required" for="copy_filter_by_department">Filter by Department:</label>
                    <div class="input-group">
                      <select name="filter_by_department" id="copy_filter_by_department" class="form-control">
                        <option value="">All Department</option>
                        <?php
                        if ($DISP_DISTINCT_DEPARTMENT) {
                          foreach ($DISP_DISTINCT_DEPARTMENT as $DISP_DISTINCT_DEPARTMENT_ROW) {
                        ?>
                            <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?>"><?= $DISP_DISTINCT_DEPARTMENT_ROW->col_empl_dept ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="required" for="copy_filter_by_section">Filter by Section:</label>
                    <div class="input-group">
                      <select name="filter_by_section" id="copy_filter_by_section" class="form-control">
                        <option value="">All Sections</option>
                        <?php
                        if ($DISP_DISTINCT_SECTION) {
                          foreach ($DISP_DISTINCT_SECTION as $DISP_DISTINCT_SECTION_ROW) {
                        ?>
                            <option value="<?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?>"><?= $DISP_DISTINCT_SECTION_ROW->col_empl_sect ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="required" for="copy_filter_by_group">Filter by Group:</label>
                    <div class="input-group">
                      <select name="filter_by_group" id="copy_filter_by_group" class="form-control">
                        <option value="">All Groups</option>
                        <?php
                        if ($DISP_Group) {
                          foreach ($DISP_Group as $DISP_Group_ROW) {
                        ?>
                            <option value="<?= $DISP_Group_ROW->col_empl_group ?>"><?= $DISP_Group_ROW->col_empl_group ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="required" for="copy_filter_by_line">Filter by Line:</label>
                    <div class="input-group">
                      <select name="filter_by_line" id="copy_filter_by_line" class="form-control">
                        <option value="">All Lines</option>
                        <?php
                        if ($DISP_Line) {
                          foreach ($DISP_Line as $DISP_Line_ROW) {
                        ?>
                            <option value="<?= $DISP_Line_ROW->col_empl_line ?>"><?= $DISP_Line_ROW->col_empl_line ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <a href="#" id="btn_copy_clear_filter" class="btn btn-primary float-right">Clear Filter</a>
                </div>
              </div>

              <hr>

              <div class="form-group">
                <label class="required" for="modal_employee_id_group">Employee ID</label>
                <div class="input-group">
                  <select name="modal_employee_id_group" id="modal_employee_id_group" class="form-control">
                    <option value="" disabled>Choose Employee...</option>
                    <?php
                    if ($DISP_EMP_LIST) {
                      foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) {
                    ?>
                        <option value="<?= $DISP_EMP_LIST_ROW->id ?>"><?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_frst_name . ' ' . $DISP_EMP_LIST_ROW->col_last_name ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                  <span class="input-group-append">
                    <button type="button" id="btn_add_widget" class="btn btn-primary">Add</button>
                  </span>
                </div>
              </div>
              <label for="ATTENDANCE_INPF_NAME">Apply Shift Template to Employees:</label>
              <div class="widget_container">

              </div>
            </div>
          </div>
        </div>
      </div>

      <form action="<?php echo base_url('attendance/copy_shift_schedule'); ?>" id="form_copy_shift" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-footer">
          <input type="hidden" id="modal_employee_id" name="modal_employee_id" class="form-control">
          <input type="hidden" id="schedule_id" name="schedule_id" class="form-control">
          <div id="widget_input_container">

          </div>
          <div id="date_shift_container">

          </div>
          <a class='btn btn-primary text-light' id="btn_copy_shift">&nbsp; Apply </a>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- =============== ADJUSTMENT MODAL ================= -->
<div class="modal fade" id="modal_time_adjustment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Adjustment
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">

            <div class="row">
              <div class="col-lg-4">
                <div class="w-100 text-center">
                  <img class="rounded-circle avatar" id="modal_profile_img" style="width: 180px;">
                </div>
              </div>
              <div class="col-lg-8">
                <div class="row">
                  <div class="col-md-6">
                    <label for="">Employee ID</label>
                    <p id="adjust_empl_id"></p>
                    <label for="">Employee Name</label>
                    <p id="adjust_empl_name"></p>
                    <label for="">Attendance Date</label>
                    <p id="adjust_date"></p>
                  </div>
                  <div class="col-md-6">
                    <label for="">Day of Work</label>
                    <p id="adjust_dow"></p>
                    <label for="">Shift for the Day</label><br>
                    <div class="form-inline">
                      <i class="fas fa-circle mr-2" id="modal_shift_color"></i>
                      <p class="mb-0" id="adjust_shift"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <hr>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="required " for="ADJUSTMENT_INPF_TIME_IN">Time In
                  </label>
                  <div class="input-group date" id="timepicker" data-target-input="nearest" style="width: 100% !important;">
                    <input type="text" class="form-control datetimepicker-input time_in_text mr-0" name="time_in_text" data-target="#timepicker" id="time_in_text" placeholder="hr:min" required>
                    <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="far fa-clock"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="required " for="ADJUSTMENT_INPF_TIME_OUT">Time Out
                  </label>
                  <div class="input-group date" id="timepicker2" data-target-input="nearest" style="width: 100% !important;">
                    <input type="text" class="form-control datetimepicker-input time_out_text mr-0" name="time_out_text" data-target="#timepicker2" id="time_out_text" placeholder="hr:min" required>
                    <div class="input-group-append" data-target="#timepicker2" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="far fa-clock"></i></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="ADJUSTMENT_INPF_TIME_IN">Status
                  </label>
                  <select name="attendance_status" id="attendance_status" class="form-control">
                    <option value="">Choose...</option>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                    <option value="Rest">Rest</option>
                    <option value="Abnormal">Abnormal</option>
                    <option value="Incomplete">Incomplete</option>
                    <option value="Paid Leave">Paid Leave</option>
                    <option value="Holiday: Rest">Holiday: Rest</option>
                    <option value="Holiday: Absent">Holiday: Absent</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="required " for="attendance_shift">Shift
                  </label>
                  <select name="attendance_shift" id="attendance_shift" class="form-control">
                    <?php
                    if ($DISP_WORK_SHIFT) {
                      foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                    ?>
                        <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>" shift_code="<?= $DISP_WORK_SHIFT_ROW->code ?>"> <?= '[' . $DISP_WORK_SHIFT_ROW->code . '] ' . $DISP_WORK_SHIFT_ROW->time_in . ' - ' . $DISP_WORK_SHIFT_ROW->time_out ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>

            <select name="attendance_remarks" style="display: none;" id="attendance_remarks" class="form-control">
              <option value="">Choose...</option>
              <option value="Late">Late</option>
              <option value="Overtime">Overtime</option>
              <option value="Undertime">Undertime</option>
              <option value="Abnormal">Abnormal</option>
            </select>

            <hr>

            <div class="mb-4">
              <a href="#" id="btn_show_attendance">Show Attendance Count &nbsp;&nbsp;<i class="fas fa-chevron-up rotate-right" id="chevron_icon"></i> </a>
            </div>

            <div id="attendance_count_container" style="display:none;">

              <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px;">
                <span class="pl-3" style="font-size: 14px !important;">Basic</span>
              </div>
              <div class="card p-3">
                <div class="row px-3">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-9">
                        <p>Actual Working Days (Daily):</p>
                      </div>
                      <div class="col-3"> <input type="number" class="form-control" id="work_days_mul"> </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Rest/Special Holiday (Hourly):</p>
                      </div>
                      <div class="col-3"> <input type="number" class="form-control" id="sp_hol_mul"> </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Regular Holiday (Hourly):</p>
                      </div>
                      <div class="col-3"> <input type="number" class="form-control" id="reg_hol_mul"> </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Rest + OT (Hourly):</p>
                      </div>
                      <div class="col-3"> <input type="number" class="form-control" id="rest_ot_mul"> </div>
                    </div>

                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-9">
                        <p>No Time in / Time Out (Daily):</p>
                      </div>
                      <div class="col-3"> <input type="number" class="form-control" id="no_ti_to_mul"> </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Rest + Special Holiday (Hourly):</p>
                      </div>
                      <div class="col-3"> <input type="number" class="form-control" id="rest_sp_hol_mul"> </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Rest + Regular Holiday (Hourly):</p>
                      </div>
                      <div class="col-3"> <input type="number" class="form-control" id="rest_reg_hol_mul"> </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Rest + Night Diff + OT (Hourly):</p>
                      </div>
                      <div class="col-3"> <input type="number" class="form-control" id="rest_nd_ot_mul"> </div>
                    </div>
                  </div>
                </div>
              </div>

              <br>

              <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px;">
                <span class="pl-3" style="font-size: 14px !important;">Absences /Tardiness /Undertime /Leave /Half Day</span>
              </div>
              <div class="card p-3">
                <div class="row px-3">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-8">
                        <p>Absences (Daily):</p>
                      </div>
                      <div class="col-4"> <input type="number" class="form-control" id="absences_mul"> </div>
                    </div>
                    <div class="row">
                      <div class="col-8">
                        <p>Late (Hourly):</p>
                      </div>
                      <div class="col-4"> <input type="number" class="form-control" id="tard_mul"> </div>
                    </div>
                    <div class="row">
                      <div class="col-8">
                        <p>Half Day (Hourly):</p>
                      </div>
                      <div class="col-4"> <input type="number" class="form-control" id="half_day_mul"> </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-8">
                        <p>Undertime (Hourly):</p>
                      </div>
                      <div class="col-4"> <input type="number" class="form-control" id="undertime_mul"> </div>
                    </div>
                    <div class="row">
                      <div class="col-8">
                        <p>Paid Leave (Daily):</p>
                      </div>
                      <div class="col-4"> <input type="number" class="form-control" id="leave_mul"> </div>
                    </div>
                  </div>
                  <div class="col-md-4">

                  </div>
                </div>
              </div>

              <!-- <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px;" style="display:none !important;">
                <span class="pl-3" style="font-size: 14px !important; display: none;">Calculated Night Differential & Overtime</span>
              </div> -->
              <div class="card p-3" style="display:none;">
                <div class="row px-3">
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-8">
                        <p>Night Diff:</p>
                      </div>
                      <div class="col-4"> <input type="number" class="form-control" id="night_diff_mul"> </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-8">
                        <p>Regular OT:</p>
                      </div>
                      <div class="col-4"> <input type="number" class="form-control" id="reg_ot_mul"> </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-8">
                        <p>Night Shift OT:</p>
                      </div>
                      <div class="col-4"> <input type="number" class="form-control" id="ns_ot_mul"> </div>
                    </div>
                  </div>
                </div>
              </div>

              <br>

              <hr>

              <div class="form-inline mb-2" style="display:none;">
                <p class="text-bold mr-4 mt-2">Approve Calculated Overtime?</p>
                <a href="#" id="btn_appr_yes" class="btn py-1 btn-primary">Yes</a>
                <a href="#" id="btn_appr_no" class="btn py-1 btn-danger ml-2">No</a>
              </div>

              <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px;">
                <span class="pl-3" style="font-size: 14px !important;">Approved Night Differential & Overtime</span>
              </div>
              <div class="card p-3">
                <div class="row px-3">
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-8">
                        <p>Night Diff:</p>
                      </div>
                      <div class="col-4"> <input type="number" value="0.00" class="form-control" id="approved_night_diff_mul" disabled> </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-8">
                        <p>Regular OT:</p>
                      </div>
                      <div class="col-4"> <input type="number" value="0.00" class="form-control" id="approved_reg_ot_mul" disabled> </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-8">
                        <p>Night Shift OT:</p>
                      </div>
                      <div class="col-4"> <input type="number" value="0.00" class="form-control" id="approved_ns_ot_mul" disabled> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <p class="text-danger" id="shift_error_indicator" style="display: none;"></p>
        <button class='btn btn-primary text-light' id="btn_adjust_time">&nbsp;Save</button>
      </div>
    </div>
  </div>
</div>







<!-- =============== ATTENDANCE SUMMARY ================= -->
<div class="modal fade" id="modal_attendance_summary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Attendance Summary
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">

            <div class="row">
              <div class="col-lg-12">
                <div class="w-100 text-center">
                  <img src="<?= base_url() ?>user_images/default_profile_img3.png" id="employee_img_sum" class="rounded-circle avatar" style="width: 180px; margin-bottom: -60px; position:relative; z-index: 55;">
                  <div class="card mx-auto" style="height: 200px; width: 70%;position:relative; z-index: 2;">
                    <div style="padding-top: 60px;" class="pl-5 pr-5 ">
                      <p class="text-bold mb-0" style="font-size: 20px;" id="employee_name_sum">HrCare User</p>
                      <p class="text-primary text-bold" id="employee_position_sum">Employee</p>
                    </div>
                    <div class="pt-3 bg-secondary">
                      <label class="mb-2">Cut-off Period</label>
                      <p id="cutoff_period_sum">0</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <br>

            <div class="row justify-content-center mb-4 px-3">
              <div class="col-md-4 w-100 text-center">
                <p class="text-white px-3 py-1 mb-0 bg-success display_total" style="font-size: 15px;border-radius: 8px;">Working Days: &nbsp;<span id="total_working_days"></span></p>
              </div>
              <div class="col-md-4 w-100 text-center">
                <p class="text-white px-3 py-1 mb-0 bg-secondary display_total" style="font-size: 15px;border-radius: 8px;">Rest Days: &nbsp;<span id="total_rest_day"></span></p>
              </div>
              <div class="col-md-4 w-100 text-center">
                <p class="text-white px-3 py-1 mb-0 bg-danger display_total" style="font-size: 15px;border-radius: 8px;">Unassigned Shifts: &nbsp;<span id="total_unassigned_shift"></span></p>
              </div>
            </div>

            <div class="row justify-content-center mb-4 px-3">
              <div class="col-md-4 w-100 text-center">
                <p class="mb-0 px-3 py-1 mb-2 text-white bg-primary display_total" style="font-size: 15px;border-radius: 8px;"> Days Present: &nbsp;<span id="total_present"></span></p>
              </div>
              <div class="col-md-4 w-100 text-center">
                <p class="mb-0 px-3 py-1 mb-2 text-white bg-primary display_total" style="font-size: 15px;border-radius: 8px;">Days Absent: &nbsp;<span id="total_absent"></span></p>
              </div>
              <div class="col-md-4 w-100 text-center">
                <p class="mb-0 px-3 py-1 mb-2 text-white bg-primary display_total" style="font-size: 15px;border-radius: 8px;">Days Late: &nbsp;<span id="total_late"></span></p>
              </div>
            </div>



            <div id="attendance_count_container">

              <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px;">
                <span class="pl-3" style="font-size: 14px !important;">Basic</span>
              </div>
              <div class="card p-3">
                <div class="row px-3">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-9">
                        <p>Actual Working days (Daily):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="work_days_sum">0</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Rest/Special Holiday (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="sp_hol_sum">0</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Regular Holiday (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="reg_hol_sum">0</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Rest + OT (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="rest_ot_sum">0</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-9">
                        <p>No Time in / Time Out (Daily):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="no_ti_to_sum">0</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Rest + Special Holiday (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="rest_sp_hol_sum">0</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Rest + Regular Holiday (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="rest_reg_hol_sum">0</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Rest + Night Diff + OT (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="rest_nd_ot_sum">0</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <br>

              <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px;">
                <span class="pl-3" style="font-size: 14px !important;">Absences /Tardiness /Undertime /Leave /Half Day</span>
              </div>
              <div class="card p-3">
                <div class="row px-3">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-9">
                        <p>Absences (Daily):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="absences_sum">0</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Tardiness (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="tard_sum">0</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Paid Leave (Daily):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="leave_sum">0</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-9">
                        <p>Undertime (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="undertime_sum">0</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-9">
                        <p>Half Day (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="half_day_sum">0</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">

                  </div>
                </div>
              </div>

              <br>

              <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px; display: none;">
                <span class="pl-3" style="font-size: 14px !important; display: none;">Calculated Night Differential & Overtime</span>
              </div>
              <div class="card p-3" style="display: none;">
                <div class="row px-3">
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-9">
                        <p>Night Diff (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="night_diff_sum">0</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-9">
                        <p>Regular OT (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="reg_ot_sum">0</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-9">
                        <p>Night Shift OT (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="ns_ot_sum">0</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <br>

              <div class="bg-dark py-1" style="border-radius: 5px 5px 0px 0px;">
                <span class="pl-3" style="font-size: 14px !important;">Approved Night Differential & Overtime</span>
              </div>
              <div class="card p-3">
                <div class="row px-3">
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-9">
                        <p>Night Diff (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="approved_night_diff_sum">0</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-9">
                        <p>Regular OT (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="approved_reg_ot_sum">0</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-9">
                        <p>Night Shift OT (Hourly):</p>
                      </div>
                      <div class="col-3">
                        <p class="float-right" id="approved_ns_ot_sum">0</p>
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
</div>

<!-- jQuery -->
<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js">
</script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js">
</script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js">
</script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js">
</script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js">
</script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
</script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/adminlte.js">
</script>
<!-- Full Calendar 2.2.5 -->
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js">
</script>
<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js">
</script>
<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js">
</script>
<!-- Toastr -->
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js">
</script>
<!-- DateRange Picker -->
<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js">
</script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Table Sorter -->
<script type="text/javascript" src="<?= base_url(); ?>plugins/tablesorter-master/dist/js/jquery.tablesorter.min.js"></script>
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
    var base_url = '<?= base_url(); ?>';

    // filtration variables
    var department;
    var line;
    var group;
    var section;

    // variable for copy shift
    var department_copy;
    var line_copy;
    var group_copy;
    var section_copy;

    var url_filter_by_line = '<?= base_url() ?>attendance/get_employee_data_filter_by_line';
    var url_filter_by_group = '<?= base_url() ?>attendance/get_employee_data_filter_by_group';
    var url_filter_by_section = '<?= base_url() ?>attendance/get_employee_data_filter_by_sect';
    var url_get_all_empl_data = '<?= base_url() ?>employees/get_all_employee_data';
    var url_filter_by_department = '<?= base_url() ?>attendance/get_employee_data_filter_by_dept';
    var url_filter_section_by_department = '<?= base_url() ?>attendance/get_employee_section_data_filter_by_dept';

    var url_get_filter_data = '<?= base_url() ?>attendance/get_filter_data';
    var url_get_filter_data_department = '<?= base_url() ?>attendance/get_filter_data_department';
    var url_get_filter_data_section = '<?= base_url() ?>attendance/get_filter_data_section';
    var url_get_filter_data_group = '<?= base_url() ?>attendance/get_filter_data_group';
    var url_get_filter_data_line = '<?= base_url() ?>attendance/get_filter_data_line';
    var url_get_all_filter_data = '<?= base_url() ?>attendance/get_all_filter_data';

    var url_holiday = '<?php echo base_url(); ?>attendance/get_holiday_data';
    var url_update_status_remarks = '<?php echo base_url(); ?>attendance/update_status_remarks';

    var url_get_ready_for_payslip = '<?php echo base_url(); ?>attendance/get_ready_for_payslip';
    var url_get_not_ready_for_payslip = '<?php echo base_url(); ?>attendance/get_not_ready_for_payslip';

    var url_get_employee_data_via_cmid = '<?php echo base_url(); ?>attendance/get_employee_data_via_cmid';

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






    var locked_employees_arr = [];
    var unlocked_employees_arr = [];

    // ======================================================== GET NUMBER OF LOCKED AND NOT LOCKED EMPLOYESS ================================
    function count_locked_and_not_locked(date_period) {
      get_ready_for_payslip(url_get_ready_for_payslip, date_period).then(function(data) {

        locked_employees_arr = [];

        var option = $('#employee_id').children();

        // console.log('Ready For Payslip: ' + data);

        var filtered_empl_arr = [];
        Array.from(option).forEach(function(element) {
          var text = $(element).text();
          var position = $(element).attr('position');
          var group = $(element).attr('group');
          var split_text = text.split(' - ');
          text = split_text[0];
          name = split_text[1];

          var empl_info_arr = [text + '/' + name + "/" + position + '/' + group];

          if (data.includes(text)) {
            filtered_empl_arr.push(empl_info_arr);
            locked_employees_arr.push(empl_info_arr);
          }
        })

        // console.log('Ready For Payslip: ' + filtered_empl_arr);
        $('#ready_count').text(filtered_empl_arr.length);
      })

      get_not_ready_for_payslip(url_get_not_ready_for_payslip, date_period).then(function(data) {
        unlocked_employees_arr = [];

        var option = $('#employee_id').children();
        // console.log(data);

        // console.log('Not Ready For Payslip: ' + data);

        var filtered_empl_arr = [];
        Array.from(option).forEach(function(element) {
          var text = $(element).text();
          var position = $(element).attr('position');
          var group = $(element).attr('group');
          var split_text = text.split(' - ');
          text = split_text[0];
          name = split_text[1];

          var empl_info_arr = [text + '/' + name + "/" + position + '/' + group];

          if (data.includes(text)) {
            filtered_empl_arr.push(empl_info_arr);
            unlocked_employees_arr.push(empl_info_arr);
          }
        })
        $('#not_ready_count').text(filtered_empl_arr.length);
      })

      var option = $('#employee_id').children();
      var filtered_empl_arr = [];
      Array.from(option).forEach(function(element) {
        var value = $(element).attr('value');
        if (value != '') {
          filtered_empl_arr.push(value);
        }
      })
      $('#total_employees').text(filtered_empl_arr.length);
    }

    // function count_locked_and_not_locked_via_empl(){

    // }

    // count_locked_and_not_locked_via_empl();




    $('.card_ready_for_payslip').click(function(e) {
      // console.log('Ready for payslip: ' + locked_employees_arr);
      $('#tbl_count_empl_ready_for_payslip').html('');

      locked_employees_arr.forEach(function(data) {
        // console.log(data[0]);
        var split_data = data[0].split('/');
        var empl_cmid = split_data[0];
        var empl_name = split_data[1];
        var empl_position = split_data[2];
        var empl_group = split_data[3];

        $('#tbl_count_empl_ready_for_payslip').append(`
          <tr>
            <td>` + empl_cmid + `</td>
            <td>` + empl_name + `</td>
            <td>` + empl_position + `</td>
            <td>` + empl_group + `</td>
          </tr>
        `);
      })
    })

    $('.card_not_ready_for_payslip').click(function(e) {
      // console.log('Not Ready for payslip: ' + unlocked_employees_arr);
      $('#tbl_count_empl_not_ready_for_payslip').html('');

      unlocked_employees_arr.forEach(function(data) {
        // console.log(data[0]);
        var split_data = data[0].split('/');
        var empl_cmid = split_data[0];
        var empl_name = split_data[1];
        var empl_position = split_data[2];
        var empl_group = split_data[3];

        $('#tbl_count_empl_not_ready_for_payslip').append(`
          <tr>
            <td>` + empl_cmid + `</td>
            <td>` + empl_name + `</td>
            <td>` + empl_position + `</td>
            <td>` + empl_group + `</td>
          </tr>
        `);
      })
    })















    // ======================================================== PREV AND NEXT EMPLOYESS ================================

    $('#btn_prev').click(function() {
      var url2 = '<?php echo base_url(); ?>attendance/get_employee_data';
      var prev_option = $('#employee_id option:selected').prev();
      var element_value = $(prev_option).attr('value');

      if (element_value) {
        $('#employee_id').val(element_value);
        $('#btn_next').prop('disabled', false);

        var date_period = $('#cutoff_period').val();
        // console.log(date_period);
        load_attendance_data(element_value, date_period);
      } else {
        $(this).prop('disabled', true);
      }

    })

    $('#btn_next').click(function() {
      var next_option = $('#employee_id option:selected').next();
      var element_value = $(next_option).attr('value');
      if (element_value) {
        $('#employee_id').val(element_value);
        $('#btn_prev').prop('disabled', false);
        var date_period = $('#cutoff_period').val();
        // console.log(date_period);
        load_attendance_data(element_value, date_period);

      } else {
        $(this).prop('disabled', true);
      }
    })


    function load_attendance_data(employee_id, date_period) {
      var url2 = '<?php echo base_url(); ?>attendance/get_employee_data';

      // show loading indicator
      $('#loader_gif').show();

      get_employee_data(url2, employee_id, date_period).then(data => {
        if ($('#cutoff_period').val()) {
          $('#cutoff_container').html('');
          data.cutoff_data.forEach((x) => {
            var status_color = '';
            var remarks_color = '';
            var cutoff_id = x.id;
            var db_date = x.date;
            var db_date = db_date.split(" ");
            var date_period = moment(x.date).format('LL');
            var day_of_work = moment(x.date).format('dddd');

            var work_day = '';
            var no_ti_to = '';
            var rd_sp = '';
            var reg_hol = '';
            var rd_reg = '';
            var rd_add_sp = '';
            var abs = '';
            var tard = '';
            var ut = '';
            var nd = '';
            var reg_ot = '';
            var ns_ot = '';
            var paid_leave = '';
            var half_day = '';
            var rest_ot = '';
            var rest_nd_ot = '';
            var tr_bg_color = '';

            var approved_night_diff = x.appr_night_diff;
            var approved_reg_ot = x.appr_reg_ot;
            var approved_ns_ot = x.appr_ns_ot;

            var isApprove = x.approved;

            if (x.work_day != 0) {
              work_day = x.work_day;
            }
            if (x.no_ti_to != 0) {
              no_ti_to = x.no_ti_to;
            }
            if (x.bp_sp_hol != 0) {
              rd_sp = x.bp_sp_hol;
            }
            if (x.bp_reg_hol != 0) {
              reg_hol = x.bp_reg_hol;
            }
            if (x.bp_reg_hol_rest != 0) {
              rd_reg = x.bp_reg_hol_rest;
            }
            if (x.bp_sp_rest != 0) {
              rd_add_sp = x.bp_sp_rest;
            }
            if (x.absent != 0) {
              abs = x.absent;
            }
            if (x.late != 0) {
              tard = x.late;
            }
            if (x.undertime != 0) {
              ut = x.undertime;
            }

            if ((x.bp_reg_ns != 0) || (x.appr_night_diff != 0)) {
              nd = parseFloat(x.appr_night_diff).toFixed(2) + ' (' + parseFloat(x.bp_reg_ns).toFixed(2) + ')';
            }
            if ((x.ot_reg != 0) || (x.appr_reg_ot != 0)) {
              reg_ot = parseFloat(x.appr_reg_ot).toFixed(2) + ' (' + parseFloat(x.ot_reg).toFixed(2) + ')';
            }
            if ((x.ot_reg_ns != 0) || (x.appr_ns_ot != 0)) {
              ns_ot = parseFloat(x.appr_ns_ot).toFixed(2) + ' (' + parseFloat(x.ot_reg_ns).toFixed(2) + ')';
            }

            if (x.paid_leave != 0) {
              paid_leave = x.paid_leave;
            }
            if (x.half_day != 0) {
              half_day = x.half_day;
            }
            if (x.rest_ot != 0) {
              rest_ot = x.rest_ot;
            }
            if (x.rest_nd_ot != 0) {
              rest_nd_ot = x.rest_nd_ot;
            }



            if (x.row_color) {
              tr_bg_color = x.row_color;
            } else {
              tr_bg_color = '#fff';
            }

            var db_shift_id = '';
            if (x.shift_id) {
              db_shift_id = x.shift_id;
            }

            var db_shift_id = '';
            if (x.shift_id) {
              db_shift_id = x.shift_id;
            }

            var db_status = '';
            var db_remarks = '';
            if (x.status) {
              db_status = x.status;
              if (x.status == 'Present') {
                status_color = 'black';
              } else if (x.status == 'Absent') {
                status_color = 'black';
              } else if (x.status == 'Rest') {
                status_color = 'black';
              }
            }
            if (x.remarks) {
              db_remarks = x.remarks;
              if (x.remarks == 'Late') {
                remarks_color = 'black';
              }
            }

            var db_time_in = '';
            var db_time_out = '';

            if (x.time_in != '00:00:00') {
              db_time_in = x.time_in;
            }

            if (x.time_out != '00:00:00') {
              db_time_out = x.time_out;
            }

            var empl_arr = [];
            get_employee_data(url2, x.empl_id, $('#cutoff_period').val()).then(data1 => {
              data1.employee_data.forEach((x) => {
                empl_arr.push(x.col_frst_name + " " + x.col_last_name);
                empl_arr.push(x.id);
              })

              var holiday_arr = [];
              get_holiday_data(url_holiday).then(data2 => {
                data2.holiday.forEach((x) => {
                  holiday_arr.push(x.col_holi_date);
                  holiday_arr.push(x.col_holi_type);
                })

                var day_code = '';
                if (holiday_arr.includes(db_date[0])) {
                  var holi_index = holiday_arr.indexOf(db_date[0]);
                  holi_index++;

                  day_code = holiday_arr[holi_index];
                } else {
                  day_code = 'Regular';
                }

                var shift_arr = [];
                get_shift_data(url4, db_shift_id).then(data4 => {

                  data4.forEach((x) => {
                    shift_arr.push(x.code);
                    shift_arr.push(x.time_in);
                    shift_arr.push(x.time_out);
                    shift_arr.push(x.color);
                    shift_arr.push(x.next_day);
                    shift_arr.push(x.has_break);
                    shift_arr.push(x.night_shift);
                    shift_arr.push(x.day_shift_OT);
                    shift_arr.push(x.night_shift_OT);
                    shift_arr.push(x.work_hours);
                    shift_arr.push(x.time_out_ot);
                    shift_arr.push(x.id);
                  })

                  var shift_name = '';
                  if (shift_arr.length > 0) {
                    var shift_code = shift_arr[0];
                    var shift_time_in = shift_arr[1];
                    var shift_time_out = shift_arr[2];
                    var shift_color = shift_arr[3];
                    var shift_next_day = shift_arr[4];
                    var shift_has_break = shift_arr[5];
                    var night_shift = shift_arr[6];
                    var day_shift_OT = shift_arr[7];
                    var night_shift_OT = shift_arr[8];
                    var work_hours = shift_arr[9];
                    var time_out_ot = shift_arr[10];
                    var shift_id = shift_arr[11];

                    shift_name = '[' + shift_code + ']' + ' ' + shift_time_in + ' - ' + shift_time_out;
                  }

                  $('#cutoff_container').append(`
                    <tr class="cutoff" style="cursor: pointer;background-color: ` + tr_bg_color + `" data-toggle="modal" data-target="#modal_time_adjustment" att_shift_id="` + shift_id + `" approved="` + isApprove + `" att_id="` + cutoff_id + `" att_date="` + db_date + `" dow="` + day_of_work + `" att_empl_id="` + empl_arr[1] + `" att_empl_name="` + empl_arr[0] + `" att_shift="` + shift_name + `" att_shift_color="` + shift_color + `" att_time_in="` + db_time_in + `" att_time_out="` + db_time_out + `"  att_status="` + db_status + `" att_remarks="` + db_remarks + `">
                        <td attendance_date="` + db_date + `">` + db_date + `</td>
                        <td>` + day_of_work + `</td>
                        <td style="display: none;" empl_id="` + empl_arr[1] + `">` + empl_arr[0] + `</td>
                        <td>` + day_code + `</td>
                        <td class="shift_num" time_out_ot="` + time_out_ot + `" work_hours="` + work_hours + `" night_shift="` + night_shift + `" day_shift_OT="` + day_shift_OT + `" night_shift_OT="` + night_shift_OT + `" has_break="` + shift_has_break + `" next_day="` + shift_next_day + `" time_in="` + shift_time_in + `" time_out="` + shift_time_out + `" shift_id="` + db_shift_id + `">` + shift_name + `</td>
                        <td class="db_time_in" row_id="` + cutoff_id + `" >` + db_time_in + `</td>
                        <td class="db_time_out" row_id="` + cutoff_id + `" >` + db_time_out + `</td>
                        <td  style="font-weight: 600; color:` + status_color + `">` + db_status + `</td>
                        <td  style=" display:none; font-weight: 600; color:` + remarks_color + `">` + db_remarks + `</td>
                        <td >` + work_day + `</td>
                        <td >` + no_ti_to + `</td>
                        <td >` + rd_sp + `</td>
                        <td >` + reg_hol + `</td>
                        <td >` + rd_reg + `</td>
                        <td >` + rd_add_sp + `</td>
                        <td >` + abs + `</td>
                        <td >` + tard + `</td>
                        <td >` + ut + `</td>
                        <td  approved_reg_ot="` + approved_reg_ot + `">` + reg_ot + `</td>
                        <td  approved_night_diff="` + approved_night_diff + `">` + nd + `</td>
                        <td  approved_ns_ot="` + approved_ns_ot + `">` + ns_ot + `</td>
                        <td >` + paid_leave + `</td>
                        <td >` + half_day + `</td>
                        <td >` + rest_ot + `</td>
                        <td >` + rest_nd_ot + `</td>
                    </tr>
                  `);
                  set_shift();
                  is_executed = true;

                  // check if attendance calculation is already approved. If yes, disable calc and view button
                  if (isApprove > 0) {
                    $('#btn_disapprove_attendance').prop('disabled', false);
                    $('#btn_calculate_attendance').prop('disabled', true);
                    $('#btn_approve_attendance').prop('disabled', true);
                    $('#copy_shift_toggle_modal').prop('disabled', true);
                    $('#apply_template_toggle_modal').prop('disabled', true);
                    $('.cutoff').each(function() {
                      $(this).attr('data-toggle', '');
                    })
                  } else {
                    $('#btn_approve_attendance').prop('disabled', false);
                    $('#btn_disapprove_attendance').prop('disabled', true);
                    $('#btn_calculate_attendance').prop('disabled', false);
                    $('#copy_shift_toggle_modal').prop('disabled', false);
                    $('#apply_template_toggle_modal').prop('disabled', false);
                    $('.cutoff').each(function() {
                      $(this).attr('data-toggle', 'modal');
                    })
                  }
                  $('#btn_view_att_summary').prop('disabled', false);


                })
              })
            })
          })
        }
      })
    }






























    // =========================== GENERATE DATES AND DAYS BASED ON CHOSEN PERIOD ====================================
    var url = '<?php echo base_url(); ?>attendance/get_cutoff_schedule_data';
    $('#cutoff_period').change(function() {
      $('#cutoff_container').html('');
      var date = $(this).val();
      var employee_id = $('#employee_id').val();

      // show loading indicator
      $('#loader_gif').show();
      count_locked_and_not_locked(date);

      get_employee_data(url2, employee_id, date).then(data => {
        if ($('#cutoff_period').val()) {
          $('#cutoff_container').html('');
          data.cutoff_data.forEach((x) => {
            var status_color = '';
            var remarks_color = '';
            var cutoff_id = x.id;
            var db_date = x.date;
            var db_date = db_date.split(" ");
            var date_period = moment(x.date).format('LL');
            var day_of_work = moment(x.date).format('dddd');

            var work_day = '';
            var no_ti_to = '';
            var rd_sp = '';
            var reg_hol = '';
            var rd_reg = '';
            var rd_add_sp = '';
            var abs = '';
            var tard = '';
            var ut = '';
            var nd = '';
            var reg_ot = '';
            var ns_ot = '';
            var paid_leave = '';
            var half_day = '';
            var rest_ot = '';
            var rest_nd_ot = '';
            var tr_bg_color = '';

            var approved_night_diff = x.appr_night_diff;
            var approved_reg_ot = x.appr_reg_ot;
            var approved_ns_ot = x.appr_ns_ot;

            var isApprove = x.approved;

            if (x.work_day != 0) {
              work_day = x.work_day;
            }
            if (x.no_ti_to != 0) {
              no_ti_to = x.no_ti_to;
            }
            if (x.bp_sp_hol != 0) {
              rd_sp = x.bp_sp_hol;
            }
            if (x.bp_reg_hol != 0) {
              reg_hol = x.bp_reg_hol;
            }
            if (x.bp_reg_hol_rest != 0) {
              rd_reg = x.bp_reg_hol_rest;
            }
            if (x.bp_sp_rest != 0) {
              rd_add_sp = x.bp_sp_rest;
            }
            if (x.absent != 0) {
              abs = x.absent;
            }
            if (x.late != 0) {
              tard = x.late;
            }
            if (x.undertime != 0) {
              ut = x.undertime;
            }

            if ((x.bp_reg_ns != 0) || (x.appr_night_diff != 0)) {
              nd = parseFloat(x.appr_night_diff).toFixed(2) + ' (' + parseFloat(x.bp_reg_ns).toFixed(2) + ')';
              // nd = parseFloat(x.appr_night_diff).toFixed(2);
            }
            if ((x.ot_reg != 0) || (x.appr_reg_ot != 0)) {
              reg_ot = parseFloat(x.appr_reg_ot).toFixed(2) + ' (' + parseFloat(x.ot_reg).toFixed(2) + ')';
              // reg_ot = parseFloat(x.appr_reg_ot).toFixed(2);
            }
            if ((x.ot_reg_ns != 0) || (x.appr_ns_ot != 0)) {
              ns_ot = parseFloat(x.appr_ns_ot).toFixed(2) + ' (' + parseFloat(x.ot_reg_ns).toFixed(2) + ')';
              // ns_ot = parseFloat(x.appr_ns_ot).toFixed(2);
            }

            if (x.paid_leave != 0) {
              paid_leave = x.paid_leave;
            }
            if (x.half_day != 0) {
              half_day = x.half_day;
            }
            if (x.rest_ot != 0) {
              rest_ot = x.rest_ot;
            }
            if (x.rest_nd_ot != 0) {
              rest_nd_ot = x.rest_nd_ot;
            }

            if (x.row_color) {
              tr_bg_color = x.row_color;
            } else {
              tr_bg_color = '#fff';
            }


            var db_shift_id = '';
            if (x.shift_id) {
              db_shift_id = x.shift_id;
            }

            var db_status = '';
            var db_remarks = '';
            if (x.status) {
              db_status = x.status;
              if (x.status == 'Present') {
                status_color = 'black';
              } else if (x.status == 'Absent') {
                status_color = 'black';
              } else if (x.status == 'Rest') {
                status_color = 'black';
              }
            }
            if (x.remarks) {
              db_remarks = x.remarks;
              if (x.remarks == 'Late') {
                remarks_color = 'black';
              }
            }

            var db_time_in = '';
            var db_time_out = '';

            if (x.time_in != '00:00:00') {
              db_time_in = x.time_in;
            }

            if (x.time_out != '00:00:00') {
              db_time_out = x.time_out;
            }

            var empl_arr = [];
            get_employee_data(url2, x.empl_id, $('#cutoff_period').val()).then(data1 => {
              data1.employee_data.forEach((x) => {
                empl_arr.push(x.col_frst_name + " " + x.col_last_name);
                empl_arr.push(x.id);
                empl_arr.push(x.col_empl_group);
              })

              var holiday_arr = [];
              get_holiday_data(url_holiday).then(data2 => {
                data2.holiday.forEach((x) => {
                  holiday_arr.push(x.col_holi_date);
                  holiday_arr.push(x.col_holi_type);
                })

                var day_code = '';
                if (holiday_arr.includes(db_date[0])) {
                  var holi_index = holiday_arr.indexOf(db_date[0]);
                  holi_index++;

                  day_code = holiday_arr[holi_index];
                } else {
                  day_code = 'Regular';
                }

                var shift_arr = [];
                get_shift_data(url4, db_shift_id).then(data4 => {

                  data4.forEach((x) => {
                    shift_arr.push(x.code);
                    shift_arr.push(x.time_in);
                    shift_arr.push(x.time_out);
                    shift_arr.push(x.color);
                    shift_arr.push(x.next_day);
                    shift_arr.push(x.has_break);
                    shift_arr.push(x.night_shift);
                    shift_arr.push(x.day_shift_OT);
                    shift_arr.push(x.night_shift_OT);
                    shift_arr.push(x.work_hours);
                    shift_arr.push(x.time_out_ot);
                    shift_arr.push(x.id);
                  })

                  var shift_name = '';
                  if (shift_arr.length > 0) {
                    var shift_code = shift_arr[0];
                    var shift_time_in = shift_arr[1];
                    var shift_time_out = shift_arr[2];
                    var shift_color = shift_arr[3];
                    var shift_next_day = shift_arr[4];
                    var shift_has_break = shift_arr[5];
                    var night_shift = shift_arr[6];
                    var day_shift_OT = shift_arr[7];
                    var night_shift_OT = shift_arr[8];
                    var work_hours = shift_arr[9];
                    var time_out_ot = shift_arr[10];
                    var shift_id = shift_arr[11];

                    shift_name = '[' + shift_code + ']' + ' ' + shift_time_in + ' - ' + shift_time_out;
                  }


                  $('#cutoff_container').append(`
                      <tr class="cutoff" style="cursor: pointer;background-color: ` + tr_bg_color + `" data-toggle="modal" data-target="#modal_time_adjustment" att_shift_id="` + shift_id + `" approved="` + isApprove + `" att_id="` + cutoff_id + `" att_date="` + db_date + `" dow="` + day_of_work + `" att_empl_id="` + empl_arr[1] + `" att_empl_name="` + empl_arr[0] + `" att_shift="` + shift_name + `" att_shift_color="` + shift_color + `" att_time_in="` + db_time_in + `" att_time_out="` + db_time_out + `" att_status="` + db_status + `" att_remarks="` + db_remarks + `">
                          <td attendance_date="` + db_date + `">` + db_date + `</td>
                          <td>` + day_of_work + `</td>
                          <td style="display: none;" empl_group="` + empl_arr[2] + `" empl_id="` + empl_arr[1] + `">` + empl_arr[0] + `</td>
                          <td>` + day_code + `</td>
                          <td class="shift_num" time_out_ot="` + time_out_ot + `" work_hours="` + work_hours + `" night_shift="` + night_shift + `" day_shift_OT="` + day_shift_OT + `" night_shift_OT="` + night_shift_OT + `" has_break="` + shift_has_break + `" next_day="` + shift_next_day + `" time_in="` + shift_time_in + `" time_out="` + shift_time_out + `" shift_id="` + db_shift_id + `">` + shift_name + `</td>
                          <td class="db_time_in" row_id="` + cutoff_id + `" >` + db_time_in + `</td>
                          <td class="db_time_out" row_id="` + cutoff_id + `" >` + db_time_out + `</td>
                          <td  style="font-weight: 600; color:` + status_color + `">` + db_status + `</td>
                          <td  style="font-weight: 600; display:none; color:` + remarks_color + `">` + db_remarks + `</td>
                          <td >` + work_day + `</td>
                          <td >` + no_ti_to + `</td>
                          <td >` + rd_sp + `</td>
                          <td >` + reg_hol + `</td>
                          <td >` + rd_reg + `</td>
                          <td >` + rd_add_sp + `</td>
                          <td >` + abs + `</td>
                          <td >` + tard + `</td>
                          <td >` + ut + `</td>
                          <td  approved_reg_ot="` + approved_reg_ot + `">` + reg_ot + `</td>
                          <td  approved_night_diff="` + approved_night_diff + `">` + nd + `</td>
                          <td  approved_ns_ot="` + approved_ns_ot + `">` + ns_ot + `</td>
                          <td >` + paid_leave + `</td>
                          <td >` + half_day + `</td>
                          <td >` + rest_ot + `</td>
                          <td >` + rest_nd_ot + `</td>
                      </tr>
                    `);

                  set_shift();
                  is_executed = true;

                  // check if attendance calculation is already approved. If yes, disable calc and view button
                  if (isApprove > 0) {
                    $('#btn_disapprove_attendance').prop('disabled', false);
                    $('#btn_calculate_attendance').prop('disabled', true);
                    $('#btn_approve_attendance').prop('disabled', true);
                    $('#copy_shift_toggle_modal').prop('disabled', true);
                    $('#apply_template_toggle_modal').prop('disabled', true);
                    $('.cutoff').each(function() {
                      $(this).attr('data-toggle', '');
                    })
                  } else {
                    $('#btn_approve_attendance').prop('disabled', false);
                    $('#btn_disapprove_attendance').prop('disabled', true);
                    $('#btn_calculate_attendance').prop('disabled', false);
                    $('.cutoff').each(function() {
                      $(this).attr('data-toggle', 'modal');
                    })
                    $('#copy_shift_toggle_modal').prop('disabled', false);
                    $('#apply_template_toggle_modal').prop('disabled', false);
                  }
                  $('#btn_view_att_summary').prop('disabled', false);



                })
              })
            })
          })
        }
      })
    })



    // ============================== GET EMPLOYEE DATA BASED ON CHOSEND ID/NAME ====================================
    var url2 = '<?php echo base_url(); ?>attendance/get_employee_data';
    $('#employee_id').change(function() {
      var employee_id = $(this).val();
      var date_period = $('#cutoff_period').val();

      // show loading indicator
      $('#loader_gif').show();

      get_employee_data(url2, employee_id, date_period).then(data => {
        if ($('#cutoff_period').val()) {
          $('#cutoff_container').html('');
          data.cutoff_data.forEach((x) => {
            var status_color = '';
            var remarks_color = '';
            var cutoff_id = x.id;
            var db_date = x.date;
            var db_date = db_date.split(" ");
            var date_period = moment(x.date).format('LL');
            var day_of_work = moment(x.date).format('dddd');

            var work_day = '';
            var no_ti_to = '';
            var rd_sp = '';
            var reg_hol = '';
            var rd_reg = '';
            var rd_add_sp = '';
            var abs = '';
            var tard = '';
            var ut = '';
            var nd = '';
            var reg_ot = '';
            var ns_ot = '';
            var paid_leave = '';
            var half_day = '';
            var rest_ot = '';
            var rest_nd_ot = '';
            var tr_bg_color = '';

            var approved_night_diff = x.appr_night_diff;
            var approved_reg_ot = x.appr_reg_ot;
            var approved_ns_ot = x.appr_ns_ot;

            var isApprove = x.approved;

            if (x.work_day != 0) {
              work_day = x.work_day;
            }
            if (x.no_ti_to != 0) {
              no_ti_to = x.no_ti_to;
            }
            if (x.bp_sp_hol != 0) {
              rd_sp = x.bp_sp_hol;
            }
            if (x.bp_reg_hol != 0) {
              reg_hol = x.bp_reg_hol;
            }
            if (x.bp_reg_hol_rest != 0) {
              rd_reg = x.bp_reg_hol_rest;
            }
            if (x.bp_sp_rest != 0) {
              rd_add_sp = x.bp_sp_rest;
            }
            if (x.absent != 0) {
              abs = x.absent;
            }
            if (x.late != 0) {
              tard = x.late;
            }
            if (x.undertime != 0) {
              ut = x.undertime;
            }

            if ((x.bp_reg_ns != 0) || (x.appr_night_diff != 0)) {
              nd = parseFloat(x.appr_night_diff).toFixed(2) + ' (' + parseFloat(x.bp_reg_ns).toFixed(2) + ')';
            }
            if ((x.ot_reg != 0) || (x.appr_reg_ot != 0)) {
              reg_ot = parseFloat(x.appr_reg_ot).toFixed(2) + ' (' + parseFloat(x.ot_reg).toFixed(2) + ')';
            }
            if ((x.ot_reg_ns != 0) || (x.appr_ns_ot != 0)) {
              ns_ot = parseFloat(x.appr_ns_ot).toFixed(2) + ' (' + parseFloat(x.ot_reg_ns).toFixed(2) + ')';
            }

            if (x.paid_leave != 0) {
              paid_leave = x.paid_leave;
            }
            if (x.half_day != 0) {
              half_day = x.half_day;
            }
            if (x.rest_ot != 0) {
              rest_ot = x.rest_ot;
            }
            if (x.rest_nd_ot != 0) {
              rest_nd_ot = x.rest_nd_ot;
            }



            if (x.row_color) {
              tr_bg_color = x.row_color;
            } else {
              tr_bg_color = '#fff';
            }

            var db_shift_id = '';
            if (x.shift_id) {
              db_shift_id = x.shift_id;
            }

            var db_shift_id = '';
            if (x.shift_id) {
              db_shift_id = x.shift_id;
            }

            var db_status = '';
            var db_remarks = '';
            if (x.status) {
              db_status = x.status;
              if (x.status == 'Present') {
                status_color = 'black';
              } else if (x.status == 'Absent') {
                status_color = 'black';
              } else if (x.status == 'Rest') {
                status_color = 'black';
              }
            }
            if (x.remarks) {
              db_remarks = x.remarks;
              if (x.remarks == 'Late') {
                remarks_color = 'black';
              }
            }

            var db_time_in = '';
            var db_time_out = '';

            if (x.time_in != '00:00:00') {
              db_time_in = x.time_in;
            }

            if (x.time_out != '00:00:00') {
              db_time_out = x.time_out;
            }

            var empl_arr = [];
            get_employee_data(url2, x.empl_id, $('#cutoff_period').val()).then(data1 => {
              data1.employee_data.forEach((x) => {
                empl_arr.push(x.col_frst_name + " " + x.col_last_name);
                empl_arr.push(x.id);
                empl_arr.push(x.col_empl_group);
              })

              var holiday_arr = [];
              get_holiday_data(url_holiday).then(data2 => {
                data2.holiday.forEach((x) => {
                  holiday_arr.push(x.col_holi_date);
                  holiday_arr.push(x.col_holi_type);
                })

                var day_code = '';
                if (holiday_arr.includes(db_date[0])) {
                  var holi_index = holiday_arr.indexOf(db_date[0]);
                  holi_index++;

                  day_code = holiday_arr[holi_index];
                } else {
                  day_code = 'Regular';
                }

                var shift_arr = [];
                get_shift_data(url4, db_shift_id).then(data4 => {

                  data4.forEach((x) => {
                    shift_arr.push(x.code);
                    shift_arr.push(x.time_in);
                    shift_arr.push(x.time_out);
                    shift_arr.push(x.color);
                    shift_arr.push(x.next_day);
                    shift_arr.push(x.has_break);
                    shift_arr.push(x.night_shift);
                    shift_arr.push(x.day_shift_OT);
                    shift_arr.push(x.night_shift_OT);
                    shift_arr.push(x.work_hours);
                    shift_arr.push(x.time_out_ot);
                    shift_arr.push(x.id);
                  })

                  var shift_name = '';
                  if (shift_arr.length > 0) {
                    var shift_code = shift_arr[0];
                    var shift_time_in = shift_arr[1];
                    var shift_time_out = shift_arr[2];
                    var shift_color = shift_arr[3];
                    var shift_next_day = shift_arr[4];
                    var shift_has_break = shift_arr[5];
                    var night_shift = shift_arr[6];
                    var day_shift_OT = shift_arr[7];
                    var night_shift_OT = shift_arr[8];
                    var work_hours = shift_arr[9];
                    var time_out_ot = shift_arr[10];
                    var shift_id = shift_arr[11];

                    shift_name = '[' + shift_code + ']' + ' ' + shift_time_in + ' - ' + shift_time_out;
                  }

                  $('#cutoff_container').append(`
                      <tr class="cutoff" style="cursor: pointer;background-color: ` + tr_bg_color + `" data-toggle="modal" data-target="#modal_time_adjustment" att_shift_id="` + shift_id + `" approved="` + isApprove + `" att_id="` + cutoff_id + `" att_date="` + db_date + `" dow="` + day_of_work + `" att_empl_id="` + empl_arr[1] + `" att_empl_name="` + empl_arr[0] + `" att_shift="` + shift_name + `" att_shift_color="` + shift_color + `" att_time_in="` + db_time_in + `" att_time_out="` + db_time_out + `"  att_status="` + db_status + `" att_remarks="` + db_remarks + `">
                          <td attendance_date="` + db_date + `">` + db_date + `</td>
                          <td>` + day_of_work + `</td>
                          <td style="display: none;" empl_group="` + empl_arr[2] + ` empl_id="` + empl_arr[1] + `">` + empl_arr[0] + `</td>
                          <td>` + day_code + `</td>
                          <td class="shift_num" time_out_ot="` + time_out_ot + `" work_hours="` + work_hours + `" night_shift="` + night_shift + `" day_shift_OT="` + day_shift_OT + `" night_shift_OT="` + night_shift_OT + `" has_break="` + shift_has_break + `" next_day="` + shift_next_day + `" time_in="` + shift_time_in + `" time_out="` + shift_time_out + `" shift_id="` + db_shift_id + `">` + shift_name + `</td>
                          <td class="db_time_in" row_id="` + cutoff_id + `" >` + db_time_in + `</td>
                          <td class="db_time_out" row_id="` + cutoff_id + `" >` + db_time_out + `</td>
                          <td  style="font-weight: 600; color:` + status_color + `">` + db_status + `</td>
                          <td  style=" display:none; font-weight: 600; color:` + remarks_color + `">` + db_remarks + `</td>
                          <td >` + work_day + `</td>
                          <td >` + no_ti_to + `</td>
                          <td >` + rd_sp + `</td>
                          <td >` + reg_hol + `</td>
                          <td >` + rd_reg + `</td>
                          <td >` + rd_add_sp + `</td>
                          <td >` + abs + `</td>
                          <td >` + tard + `</td>
                          <td >` + ut + `</td>
                          <td  approved_reg_ot="` + approved_reg_ot + `">` + reg_ot + `</td>
                          <td  approved_night_diff="` + approved_night_diff + `">` + nd + `</td>
                          <td  approved_ns_ot="` + approved_ns_ot + `">` + ns_ot + `</td>
                          <td >` + paid_leave + `</td>
                          <td >` + half_day + `</td>
                          <td >` + rest_ot + `</td>
                          <td >` + rest_nd_ot + `</td>
                      </tr>
                    `);
                  set_shift();
                  is_executed = true;

                  // check if attendance calculation is already approved. If yes, disable calc and view button
                  if (isApprove > 0) {
                    $('#btn_disapprove_attendance').prop('disabled', false);
                    $('#btn_calculate_attendance').prop('disabled', true);
                    $('#btn_approve_attendance').prop('disabled', true);
                    $('#copy_shift_toggle_modal').prop('disabled', true);
                    $('#apply_template_toggle_modal').prop('disabled', true);
                    $('.cutoff').each(function() {
                      $(this).attr('data-toggle', '');
                    })
                  } else {
                    $('#btn_approve_attendance').prop('disabled', false);
                    $('#btn_disapprove_attendance').prop('disabled', true);
                    $('#btn_calculate_attendance').prop('disabled', false);
                    $('#copy_shift_toggle_modal').prop('disabled', false);
                    $('#apply_template_toggle_modal').prop('disabled', false);
                    $('.cutoff').each(function() {
                      $(this).attr('data-toggle', 'modal');
                    })
                  }
                  $('#btn_view_att_summary').prop('disabled', false);


                })
              })
            })
          })
        }
      })

    })


    function load_auto_sort() {
      $("#tbl_attendance").trigger("update");
      if ($(".tablesorter-headerUnSorted[data-column=0]").length > 0) {
        $(".tablesorter-headerUnSorted[data-column=0]").click();
      }
    }


    var url_attendance = '<?= base_url() ?>attendance/get_attendance_data_based_id';


    // ================================================== DISPLAY ATTENDANCE VALUES IN MODAL ===========================================
    setInterval(() => {
      if (is_executed == true) {
        load_auto_sort();
        is_executed = false;
        $('#cutoff_container').show();
        $('#loader_gif').hide();

        var total_unassigned_shift_arr = [];
        var check_unassigned_count = '';

        var check_status_arr = [];
        var check_status_count = '';
        $('.cutoff').each(function() {
          var shift_data = $($(this).children()[4]).text();
          var status_data = $($(this).children()[7]).text();
          var approved = $(this).attr('approved');

          // count total unassigned shifts
          if ((shift_data == '') || (shift_data == ' ') || (shift_data == null)) {
            total_unassigned_shift_arr.push(1);
            check_unassigned_count = total_unassigned_shift_arr.reduce(add_array_values);
          }

          // count total unassigned and incomplete shift 
          // if((shift_data == '') || (shift_data == ' ') || (shift_data == null) || (status_data=='Unassigned') || (status_data=='Abnormal') || (parseInt(approved)) > 0){

          // if((shift_data == '') || (shift_data == ' ') || (shift_data == null) || (status_data=='Unassigned') || (parseInt(approved)) > 0){
          //   check_status_arr.push(1);
          //   check_status_count = check_status_arr.reduce(add_array_values);
          // }
        })

        if (parseInt(check_unassigned_count) > 0) {
          $('#shift_warning_icon').show();
          $('#shift_warning_icon').attr('title', 'Warning: Employee has ' + check_unassigned_count + ' unassigned shifts.');
        } else {
          $('#shift_warning_icon').hide();
        }

        // if(check_status_count > 0){
        //   $('#btn_approve_attendance').prop('disabled', true);
        // } else {

        //   $('#btn_approve_attendance').prop('disabled', false);
        // }




        // get cutoff data to modal
        $('.cutoff').click(function() {
          var parent = $(this);
          var parent_container = Array.from(parent)[0];
          var td_time_in = $(parent_container.childNodes[11]).text();
          var td_time_out = $(parent_container.childNodes[13]).text();
          var td_status = $(parent_container.childNodes[15]).text();

          $('#adjust_date').text($(this).attr('att_date'));
          $('#adjust_empl_id').text($(this).attr('att_empl_id'));
          $('#adjust_empl_name').text($(this).attr('att_empl_name'));
          $('#adjust_dow').text($(this).attr('dow'));
          $('#adjust_shift').text($(this).attr('att_shift'));
          $('#attendance_shift').val($(this).attr('att_shift_id'));

          $('#modal_shift_color').attr('style', 'color: ' + $(this).attr('att_shift_color'));
          get_employee_data(url2, $(this).attr('att_empl_id'), $('#cutoff_period').val()).then(data => {
            data.employee_data.forEach(function(x) {
              if (x.col_imag_path) {
                $('#modal_profile_img').attr('src', base_url + 'user_images/' + x.col_imag_path);
              } else {
                $('#modal_profile_img').attr('src', base_url + 'user_images/default_profile_img3.png');
              }

            })
          })

          $('#time_in_text').val(td_time_in);
          $('#time_out_text').val(td_time_out);
          $('#attendance_status').val(td_status);

          var attendance_id = $(this).attr('att_id');
          get_attendance_data_based_id(url_attendance, attendance_id).then((attendance_row) => {
            Array.from(attendance_row).forEach(function(data) {
              $('#work_days_mul').val(data.work_day);
              $('#sp_hol_mul').val(data.bp_sp_hol);
              $('#reg_hol_mul').val(data.bp_reg_hol);
              $('#no_ti_to_mul').val(data.no_ti_to);
              $('#rest_sp_hol_mul').val(data.bp_sp_rest);
              $('#rest_reg_hol_mul').val(data.bp_reg_hol_rest);
              $('#absences_mul').val(data.absent);
              $('#tard_mul').val(data.late);
              $('#undertime_mul').val(data.undertime);
              $('#night_diff_mul').val(data.bp_reg_ns);
              $('#reg_ot_mul').val(data.ot_reg);
              $('#ns_ot_mul').val(data.ot_reg_ns);
              $('#leave_mul').val(data.paid_leave);
              $('#half_day_mul').val(data.half_day);
              $('#rest_ot_mul').val(data.rest_ot);
              $('#rest_nd_ot_mul').val(data.rest_nd_ot);
              $('#approved_night_diff_mul').val(data.appr_night_diff);
              $('#approved_reg_ot_mul').val(data.appr_reg_ot);
              $('#approved_ns_ot_mul').val(data.appr_ns_ot);

            })
          })
        })
      }
    }, 10);


    // =================================== SHOW ATTENDANCE COUNT =================================
    $('#btn_show_attendance').click(function() {
      if ($('#chevron_icon').hasClass('rotate-right')) {
        $('#chevron_icon').removeClass('rotate-right');
        $('#chevron_icon').addClass('rotate-left');
      } else if ($('#chevron_icon').hasClass('rotate-left')) {
        $('#chevron_icon').removeClass('rotate-left');
        $('#chevron_icon').addClass('rotate-right');
      }

      $('#attendance_count_container').toggle(300);
    })






    // YES BTN (APPROVE OT ND)
    $('#btn_appr_yes').click(function() {
      var appr_night_diff = $('#night_diff_mul').val();
      var appr_reg_ot = $('#reg_ot_mul').val();
      var appr_ns_ot = $('#ns_ot_mul').val();

      $('#approved_night_diff_mul').val(appr_night_diff);
      $('#approved_reg_ot_mul').val(appr_reg_ot);
      $('#approved_ns_ot_mul').val(appr_ns_ot);
    })

    // NO BTN (APPROVE OT ND)
    $('#btn_appr_no').click(function() {

      $('#approved_night_diff_mul').val(0.00);
      $('#approved_reg_ot_mul').val(0.00);
      $('#approved_ns_ot_mul').val(0.00);

    })







    // get shift template data
    var url3 = '<?php echo base_url(); ?>attendance/get_work_shift_data';
    // get shift data
    var url4 = '<?php echo base_url(); ?>attendance/get_shift_data';


    // Display Shift id in the modal
    function set_shift() {
      $('.BTN_SET_SHIFT').click(function(e) {
        e.preventDefault();
        var parent = $(this).parent().parent().parent();
        var parent_container = Array.from(parent)[0];
        var shift_id = $(parent_container.childNodes[9]).attr('shift_id');
        var cutoff_id = $(this).attr('cutoff_id');
        $('#schedule_id').val(cutoff_id);
        $('#set_shift_name').val(shift_id);

        var employee_id = $(parent_container.childNodes[5]).attr('empl_id');
        $('#modal_employee_id').val(employee_id);

        var date_period = $(parent_container.childNodes[1]).attr('empl_id');

      })
    }

    // ====================================================== UPDT SHIFT ===========================================
    $('#btn_updt_shift').click(function() {
      var schedule_id = $('#schedule_id').val();
      var shift_id = $('#set_shift_name').val();

      var selector = 'a[cutoff_id|=' + schedule_id + ']';
      var parent = $(selector).parent().parent().parent();
      var parent_container = Array.from(parent)[0];
      $(parent_container.childNodes[9]).text(shift_id);

      get_shift_data(url4, shift_id).then(data => {
        if (data.length > 0) {
          data.forEach((x) => {
            $(parent_container.childNodes[9]).text('[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out);
          });
        }
      })

      $('#modal_set_shift').modal('toggle');
    })



    // =============================================== CONVERT TIME FORMAT ===========================================
    const convertTime12to24 = (time12h) => {
      const [time, modifier] = time12h.split(' ');

      let [hours, minutes] = time.split(':');

      if (hours === '12') {
        hours = '00';
      }

      if (modifier === 'PM') {
        hours = parseInt(hours, 10) + 12;
      }

      if (hours < 10) {
        if (hours == "00") {
          return `${hours}:${minutes}:00`;
        } else {
          return `0${hours}:${minutes}:00`;
        }

      } else {
        return `${hours}:${minutes}:00`;
      }
    }







    // ============================================= ADJUST TIME IN TIME OUT AND STATUS ============================================
    var url_adjustment = '<?= base_url() ?>attendance/updt_attendance_time_out_async';
    var url_updt_shift_async = '<?php echo base_url(); ?>attendance/updt_shift_async';

    $('#btn_adjust_time').click(function() {
      var adjust_date = $('#adjust_date').text();
      var adjust_empl_id = $('#adjust_empl_id').text();
      var adjust_empl_name = $('#adjust_empl_name').text();
      var adjust_dow = $('#adjust_dow').text();
      var adjust_shift = $('#adjust_shift').text();
      var time_in_text = $('#time_in_text').val();
      var time_out_text = $('#time_out_text').val();

      var adjust_status = $('#attendance_status').val();
      var adjust_remarks = $('#attendance_remarks').val();
      var shift_id = $('#attendance_shift').val();
      var shift_name = $('#attendance_shift option:selected').text();


      if (shift_name != '') {

        var split_shift_name = shift_name.split('] ');
        var split_shift_time = split_shift_name[1].split(' - ');

        var shift_time_in = split_shift_time[0];
        var shift_time_out = split_shift_time[1];

        var work_days_mul = $('#work_days_mul').val();
        var sp_hol_mul = $('#sp_hol_mul').val();
        var reg_hol_mul = $('#reg_hol_mul').val();
        var no_ti_to_mul = $('#no_ti_to_mul').val();
        var rest_sp_hol_mul = $('#rest_sp_hol_mul').val();
        var rest_reg_hol_mul = $('#rest_reg_hol_mul').val();
        var absences_mul = $('#absences_mul').val();
        var tard_mul = $('#tard_mul').val();
        var undertime_mul = $('#undertime_mul').val();
        var night_diff_mul = $('#night_diff_mul').val();
        var reg_ot_mul = $('#reg_ot_mul').val();
        var ns_ot_mul = $('#ns_ot_mul').val();
        var leave_mul = $('#leave_mul').val();
        var half_day_mul = $('#half_day_mul').val();
        var rest_ot_mul = $('#rest_ot_mul').val();
        var rest_nd_ot_mul = $('#rest_nd_ot_mul').val();

        var approved_night_diff_mul = $('#approved_night_diff_mul').val();
        var approved_reg_ot_mul = $('#approved_reg_ot_mul').val();
        var approved_ns_ot_mul = $('#approved_ns_ot_mul').val();

        var time_in = time_in_text;
        if ((time_in_text.includes('AM')) || (time_in_text.includes('PM'))) {
          time_in = convertTime12to24(time_in_text);
        }

        var time_out = time_out_text;
        if ((time_out_text.includes('AM')) || (time_out_text.includes('PM'))) {
          time_out = convertTime12to24(time_out_text);
        }

        var parent_tr = $('[attendance_date="' + adjust_date + '"]').parent();
        var parent_tr_container = Array.from(parent_tr)[0];

        var td_shift = parent_tr_container.childNodes[9];
        var td_time_in = parent_tr_container.childNodes[11];
        var td_time_out = parent_tr_container.childNodes[13];
        var td_status = parent_tr_container.childNodes[15];
        var td_remarks = parent_tr_container.childNodes[17];

        var td_working_day = parent_tr_container.childNodes[19];
        var td_no_ti_to = parent_tr_container.childNodes[21];
        var td_rd_sp = parent_tr_container.childNodes[23];
        var td_reg_hol = parent_tr_container.childNodes[25];
        var td_rd_reg = parent_tr_container.childNodes[27];
        var td_rd_add_sp = parent_tr_container.childNodes[29];
        var td_abs = parent_tr_container.childNodes[31];
        var td_tard = parent_tr_container.childNodes[33];
        var td_ut = parent_tr_container.childNodes[35];
        var td_nd = parent_tr_container.childNodes[39];
        var td_reg_ot = parent_tr_container.childNodes[37];
        var td_ns_ot = parent_tr_container.childNodes[41];
        var td_leave = parent_tr_container.childNodes[43];
        var td_half_day = parent_tr_container.childNodes[45];
        var td_rest_ot = parent_tr_container.childNodes[47];
        var td_rest_nd_ot = parent_tr_container.childNodes[49];

        var manual_color = '#c7ffd4';

        work_days_val = parseFloat(work_days_mul).toFixed(2);
        sp_hol_val = parseFloat(sp_hol_mul).toFixed(2);
        reg_hol_val = parseFloat(reg_hol_mul).toFixed(2);
        no_ti_to_val = parseFloat(no_ti_to_mul).toFixed(2);
        rest_sp_hol_val = parseFloat(rest_sp_hol_mul).toFixed(2);
        rest_reg_hol_val = parseFloat(rest_reg_hol_mul).toFixed(2);
        absences_val = parseFloat(absences_mul).toFixed(2);
        tard_val = parseFloat(tard_mul).toFixed(2);
        undertime_val = parseFloat(undertime_mul).toFixed(2);
        night_diff_val = parseFloat(night_diff_mul).toFixed(2);
        reg_ot_val = parseFloat(reg_ot_mul).toFixed(2);
        ns_ot_val = parseFloat(ns_ot_mul).toFixed(2);
        leave_val = parseFloat(leave_mul).toFixed(2);
        half_day_val = parseFloat(half_day_mul).toFixed(2);
        rest_ot_val = parseFloat(rest_ot_mul).toFixed(2);
        rest_nd_ot_val = parseFloat(rest_nd_ot_mul).toFixed(2);
        approved_night_diff_val = parseFloat(approved_night_diff_mul).toFixed(2);
        approved_reg_ot_val = parseFloat(approved_reg_ot_mul).toFixed(2);
        approved_ns_ot_val = parseFloat(approved_ns_ot_mul).toFixed(2);

        $(td_shift).text(shift_name);
        get_shift_data(url4, shift_id).then(data => {
          Array.from(data).forEach(function(x) {
            $(td_shift).attr('time_in', x.time_in);
            $(td_shift).attr('time_out', x.time_out);
            $(td_shift).attr('shift_id', x.id);
            $(td_shift).attr('has_break', x.has_break);
            $(td_shift).attr('next_day', x.next_day);
            $(td_shift).attr('day_shift_ot', x.day_shift_OT);
            $(td_shift).attr('night_shift_ot', x.night_shift_OT);
            $(td_shift).attr('work_hours', x.work_hours);
            $(td_shift).attr('time_out_ot', x.time_out_ot);
            $(td_shift).attr('night_shift', x.night_shift);
            $(td_shift).parent().attr('att_shift_id', x.id);
            $(td_shift).parent().attr('att_shift', shift_name);
            $(td_shift).parent().attr('att_shift_color', x.color);
          })
        })


        $(td_time_in).text(time_in);
        $(td_time_out).text(time_out);
        $(td_status).text(adjust_status);
        $(td_remarks).text(adjust_remarks);

        if (work_days_val > 0.00) {
          $(td_working_day).text(work_days_val);
        } else {
          $(td_working_day).text('');
        }
        if (no_ti_to_val > 0.00) {
          $(td_no_ti_to).text(no_ti_to_val);
        } else {
          $(td_no_ti_to).text('');
        }
        if (sp_hol_val > 0.00) {
          $(td_rd_sp).text(sp_hol_val);
        } else {
          $(td_rd_sp).text('');
        }
        if (reg_hol_val > 0.00) {
          $(td_reg_hol).text(reg_hol_val);
        } else {
          $(td_reg_hol).text('');
        }
        if (rest_reg_hol_val > 0.00) {
          $(td_rd_reg).text(rest_reg_hol_val);
        } else {
          $(td_rd_reg).text('');
        }
        if (rest_sp_hol_val > 0.00) {
          $(td_rd_add_sp).text(rest_sp_hol_val);
        } else {
          $(td_rd_add_sp).text('');
        }
        if (absences_val > 0.00) {
          $(td_abs).text(absences_val);
        } else {
          $(td_abs).text('');
        }
        if (tard_val > 0.00) {
          $(td_tard).text(tard_val);
        } else {
          $(td_tard).text('');
        }
        if (undertime_val > 0.00) {
          $(td_ut).text(undertime_val);
        } else {
          $(td_ut).text('');
        }
        if (leave_val > 0.00) {
          $(td_leave).text(leave_val);
        } else {
          $(td_leave).text('');
        }
        if (half_day_val > 0.00) {
          $(td_half_day).text(half_day_val);
        } else {
          $(td_half_day).text('');
        }
        if (rest_ot_val > 0.00) {
          $(td_rest_ot).text(rest_ot_val);
        } else {
          $(td_rest_ot).text('');
        }
        if (rest_nd_ot_val > 0.00) {
          $(td_rest_nd_ot).text(rest_nd_ot_val);
        } else {
          $(td_rest_nd_ot).text('');
        }

        if ((night_diff_val > 0.00) || (approved_night_diff_val > 0.00)) {
          $(td_nd).html(approved_night_diff_val + ' ' + '(' + night_diff_val + ')');
        } else {
          $(td_nd).text('');
        }
        if ((reg_ot_val > 0.00) || (approved_reg_ot_val > 0.00)) {
          $(td_reg_ot).html(approved_reg_ot_val + ' ' + '(' + reg_ot_val + ')');
        } else {
          $(td_reg_ot).text('');
        }
        if ((ns_ot_val > 0.00) || (approved_ns_ot_val > 0.00)) {
          $(td_ns_ot).html(approved_ns_ot_val + ' ' + '(' + ns_ot_val + ')');
        } else {
          $(td_ns_ot).text('');
        }

        $(parent_tr_container).css({
          'backgroundColor': manual_color
        })

        updt_attendance_time_out_async(
          url_adjustment,
          adjust_date,
          adjust_empl_id,
          time_in,
          time_out,
          adjust_status,
          adjust_remarks,
          work_days_mul,
          sp_hol_mul,
          reg_hol_mul,
          no_ti_to_mul,
          rest_sp_hol_mul,
          rest_reg_hol_mul,
          absences_mul,
          tard_mul,
          undertime_mul,
          night_diff_mul,
          reg_ot_mul,
          ns_ot_mul,
          leave_mul,
          half_day_mul,
          rest_ot_mul,
          rest_nd_ot_mul,
          manual_color,
          approved_night_diff_mul,
          approved_reg_ot_mul,
          approved_ns_ot_mul,
          shift_id
        ).then(data => {
          console.log(data);
        })

        $('#modal_time_adjustment').modal('toggle');
      } else {
        $('#attendance_shift').addClass('is-invalid');
        $('#shift_error_indicator').text('Shift is required');
        $('#shift_error_indicator').show();
      }

    })



    $('#attendance_shift').change(function(e) {
      $('#attendance_shift').removeClass('is-invalid');
      $('#shift_error_indicator').text('');
      $('#shift_error_indicator').hide();
    })


    // ================================= APPLY SHIFT TEMPLATE MODAL =======================================
    $('#apply_template_toggle_modal').click(function() {
      $('#from_date').html(''); // clear date upon clicking toggle modal
      $('#to_date').html(''); // clear date upon clicking toggle modal
      $('#from_date').append(`
        <option value="">Choose Date...</option>
      `); // set inital empty value
      $('#to_date').append(`
        <option value="">Choose Date...</option>
      `); // set inital empty value


      dates = []; // store array of dates from table
      Array.from($('.cutoff')).forEach(function(element) {
        var date = $(element.childNodes[1]).text();
        dates.push(date);
      })
      dates.forEach(function(value) {
        $('#from_date').append(`
          <option value="` + value + `">` + value + `</option>
        `);
        $('#to_date').append(`
          <option value="` + value + `">` + value + `</option>
        `)
      })
    })





    // get shift template data
    var url_get_work_shift_data = '<?php echo base_url(); ?>attendance/get_work_shift_data';
    // get shift data
    var url_get_shift_data = '<?php echo base_url(); ?>attendance/get_shift_data';
    // ============================== APPLY SHIFT TEMPLATE ====================================
    $('#btn_apply_template').click(function(e) {
      e.preventDefault();

      Swal.fire({
        title: 'Do you want to apply this template?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          var template_id = $('#work_shift_template').val();
          get_work_shift_data(url_get_work_shift_data, template_id).then(data => {

            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();

            if (from_date && to_date) {
              dates = []; // store array of dates from table
              Array.from($('.cutoff')).forEach(function(element) {
                var date = $(element.childNodes[1]).text();
                dates.push(date);
              })

              var start = dates.indexOf(from_date); // get the index of date from dates array
              var end = (dates.indexOf(to_date)) + 1; // get the index of date from dates array

              var filtered_dates = dates.slice(start, end); // slice the array with the range beginning with start to end

              Array.from($('.cutoff')).forEach(function(tr) {
                filtered_dates.forEach(function(date) {
                  var tbl_date = $(tr.childNodes[1]).text();
                  var tbl_dow = $(tr.childNodes[3]).text();
                  if (date.includes(tbl_date)) {
                    switch (tbl_dow) {
                      case 'Monday':
                        get_shift_data(url_get_shift_data, data[0].monday).then(shift_data => {

                          if (shift_data.length > 0) {
                            shift_data.forEach((x) => {
                              var apply_shift_name = '[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out;
                              $(tr.childNodes[9]).text(apply_shift_name);
                              $(tr.childNodes[9]).attr('time_in', x.time_in);
                              $(tr.childNodes[9]).attr('time_out', x.time_out);
                              $(tr.childNodes[9]).attr('shift_id', x.id);
                              $(tr.childNodes[9]).attr('has_break', x.has_break);
                              $(tr.childNodes[9]).attr('next_day', x.next_day);
                              $(tr.childNodes[9]).attr('day_shift_ot', x.day_shift_OT);
                              $(tr.childNodes[9]).attr('night_shift_ot', x.night_shift_OT);
                              $(tr.childNodes[9]).attr('work_hours', x.work_hours);
                              $(tr.childNodes[9]).attr('time_out_ot', x.time_out_ot);
                              $(tr.childNodes[9]).attr('night_shift', x.night_shift);
                              $(tr.childNodes[9]).parent().attr('att_shift_id', x.id);
                              $(tr.childNodes[9]).parent().attr('att_shift', apply_shift_name);
                              $(tr.childNodes[9]).parent().attr('att_shift_color', x.color);
                              var att_id = $(tr).attr('att_id');
                              var shift_id = x.id;

                              updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                                // enter code after update
                                console.log(att_id);
                              })
                            });
                          }
                        })
                        break;
                      case 'Tuesday':
                        get_shift_data(url_get_shift_data, data[0].tuesday).then(shift_data => {

                          if (shift_data.length > 0) {
                            shift_data.forEach((x) => {
                              var apply_shift_name = '[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out;
                              $(tr.childNodes[9]).text(apply_shift_name);
                              $(tr.childNodes[9]).attr('time_in', x.time_in);
                              $(tr.childNodes[9]).attr('time_out', x.time_out);
                              $(tr.childNodes[9]).attr('shift_id', x.id);
                              $(tr.childNodes[9]).attr('has_break', x.has_break);
                              $(tr.childNodes[9]).attr('next_day', x.next_day);
                              $(tr.childNodes[9]).attr('day_shift_ot', x.day_shift_OT);
                              $(tr.childNodes[9]).attr('night_shift_ot', x.night_shift_OT);
                              $(tr.childNodes[9]).attr('work_hours', x.work_hours);
                              $(tr.childNodes[9]).attr('time_out_ot', x.time_out_ot);
                              $(tr.childNodes[9]).attr('night_shift', x.night_shift);
                              $(tr.childNodes[9]).parent().attr('att_shift_id', x.id);
                              $(tr.childNodes[9]).parent().attr('att_shift', apply_shift_name);
                              $(tr.childNodes[9]).parent().attr('att_shift_color', x.color);
                              var att_id = $(tr).attr('att_id');
                              var shift_id = x.id;

                              updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                                // enter code after update
                                console.log(att_id);
                              })
                            });
                          }
                        })
                        break;
                      case 'Wednesday':
                        get_shift_data(url_get_shift_data, data[0].wednesday).then(shift_data => {

                          if (shift_data.length > 0) {
                            shift_data.forEach((x) => {
                              var apply_shift_name = '[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out;
                              $(tr.childNodes[9]).text(apply_shift_name);
                              $(tr.childNodes[9]).attr('time_in', x.time_in);
                              $(tr.childNodes[9]).attr('time_out', x.time_out);
                              $(tr.childNodes[9]).attr('shift_id', x.id);
                              $(tr.childNodes[9]).attr('has_break', x.has_break);
                              $(tr.childNodes[9]).attr('next_day', x.next_day);
                              $(tr.childNodes[9]).attr('day_shift_ot', x.day_shift_OT);
                              $(tr.childNodes[9]).attr('night_shift_ot', x.night_shift_OT);
                              $(tr.childNodes[9]).attr('work_hours', x.work_hours);
                              $(tr.childNodes[9]).attr('time_out_ot', x.time_out_ot);
                              $(tr.childNodes[9]).attr('night_shift', x.night_shift);
                              $(tr.childNodes[9]).parent().attr('att_shift_id', x.id);
                              $(tr.childNodes[9]).parent().attr('att_shift', apply_shift_name);
                              $(tr.childNodes[9]).parent().attr('att_shift_color', x.color);
                              var att_id = $(tr).attr('att_id');
                              var shift_id = x.id;

                              updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                                // enter code after update
                                console.log(att_id);
                              })
                            });
                          }
                        })
                        break;
                      case 'Thursday':
                        get_shift_data(url_get_shift_data, data[0].thursday).then(shift_data => {

                          if (shift_data.length > 0) {
                            shift_data.forEach((x) => {
                              var apply_shift_name = '[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out;
                              $(tr.childNodes[9]).text(apply_shift_name);
                              $(tr.childNodes[9]).attr('time_in', x.time_in);
                              $(tr.childNodes[9]).attr('time_out', x.time_out);
                              $(tr.childNodes[9]).attr('shift_id', x.id);
                              $(tr.childNodes[9]).attr('has_break', x.has_break);
                              $(tr.childNodes[9]).attr('next_day', x.next_day);
                              $(tr.childNodes[9]).attr('day_shift_ot', x.day_shift_OT);
                              $(tr.childNodes[9]).attr('night_shift_ot', x.night_shift_OT);
                              $(tr.childNodes[9]).attr('work_hours', x.work_hours);
                              $(tr.childNodes[9]).attr('time_out_ot', x.time_out_ot);
                              $(tr.childNodes[9]).attr('night_shift', x.night_shift);
                              $(tr.childNodes[9]).parent().attr('att_shift_id', x.id);
                              $(tr.childNodes[9]).parent().attr('att_shift', apply_shift_name);
                              $(tr.childNodes[9]).parent().attr('att_shift_color', x.color);
                              var att_id = $(tr).attr('att_id');
                              var shift_id = x.id;

                              updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                                // enter code after update
                                console.log(att_id);
                              })
                            });
                          }
                        })
                        break;
                      case 'Friday':
                        get_shift_data(url_get_shift_data, data[0].friday).then(shift_data => {

                          if (shift_data.length > 0) {
                            shift_data.forEach((x) => {
                              var apply_shift_name = '[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out;
                              $(tr.childNodes[9]).text(apply_shift_name);
                              $(tr.childNodes[9]).attr('time_in', x.time_in);
                              $(tr.childNodes[9]).attr('time_out', x.time_out);
                              $(tr.childNodes[9]).attr('shift_id', x.id);
                              $(tr.childNodes[9]).attr('has_break', x.has_break);
                              $(tr.childNodes[9]).attr('next_day', x.next_day);
                              $(tr.childNodes[9]).attr('day_shift_ot', x.day_shift_OT);
                              $(tr.childNodes[9]).attr('night_shift_ot', x.night_shift_OT);
                              $(tr.childNodes[9]).attr('work_hours', x.work_hours);
                              $(tr.childNodes[9]).attr('time_out_ot', x.time_out_ot);
                              $(tr.childNodes[9]).attr('night_shift', x.night_shift);
                              $(tr.childNodes[9]).parent().attr('att_shift_id', x.id);
                              $(tr.childNodes[9]).parent().attr('att_shift', apply_shift_name);
                              $(tr.childNodes[9]).parent().attr('att_shift_color', x.color);
                              var att_id = $(tr).attr('att_id');
                              var shift_id = x.id;

                              updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                                // enter code after update
                                console.log(att_id);
                              })
                            });
                          }
                        })
                        break;
                      case 'Saturday':
                        get_shift_data(url_get_shift_data, data[0].saturday).then(shift_data => {

                          if (shift_data.length > 0) {
                            shift_data.forEach((x) => {
                              var apply_shift_name = '[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out;
                              $(tr.childNodes[9]).text(apply_shift_name);
                              $(tr.childNodes[9]).attr('time_in', x.time_in);
                              $(tr.childNodes[9]).attr('time_out', x.time_out);
                              $(tr.childNodes[9]).attr('shift_id', x.id);
                              $(tr.childNodes[9]).attr('has_break', x.has_break);
                              $(tr.childNodes[9]).attr('next_day', x.next_day);
                              $(tr.childNodes[9]).attr('day_shift_ot', x.day_shift_OT);
                              $(tr.childNodes[9]).attr('night_shift_ot', x.night_shift_OT);
                              $(tr.childNodes[9]).attr('work_hours', x.work_hours);
                              $(tr.childNodes[9]).attr('time_out_ot', x.time_out_ot);
                              $(tr.childNodes[9]).attr('night_shift', x.night_shift);
                              $(tr.childNodes[9]).parent().attr('att_shift_id', x.id);
                              $(tr.childNodes[9]).parent().attr('att_shift', apply_shift_name);
                              $(tr.childNodes[9]).parent().attr('att_shift_color', x.color);
                              var att_id = $(tr).attr('att_id');
                              var shift_id = x.id;

                              updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                                // enter code after update
                                console.log(att_id);
                              })
                            });
                          }
                        })
                        break;
                      case 'Sunday':
                        get_shift_data(url_get_shift_data, data[0].sunday).then(shift_data => {

                          if (shift_data.length > 0) {
                            shift_data.forEach((x) => {
                              var apply_shift_name = '[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out;
                              $(tr.childNodes[9]).text(apply_shift_name);
                              $(tr.childNodes[9]).attr('time_in', x.time_in);
                              $(tr.childNodes[9]).attr('time_out', x.time_out);
                              $(tr.childNodes[9]).attr('shift_id', x.id);
                              $(tr.childNodes[9]).attr('has_break', x.has_break);
                              $(tr.childNodes[9]).attr('next_day', x.next_day);
                              $(tr.childNodes[9]).attr('day_shift_ot', x.day_shift_OT);
                              $(tr.childNodes[9]).attr('night_shift_ot', x.night_shift_OT);
                              $(tr.childNodes[9]).attr('work_hours', x.work_hours);
                              $(tr.childNodes[9]).attr('time_out_ot', x.time_out_ot);
                              $(tr.childNodes[9]).attr('night_shift', x.night_shift);
                              $(tr.childNodes[9]).parent().attr('att_shift_id', x.id);
                              $(tr.childNodes[9]).parent().attr('att_shift', apply_shift_name);
                              $(tr.childNodes[9]).parent().attr('att_shift_color', x.color);
                              var att_id = $(tr).attr('att_id');
                              var shift_id = x.id;

                              updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                                // enter code after update
                                console.log(att_id);
                              })
                            });
                          }
                        })
                        break;
                      default:
                        $(tr.childNodes[9]).text('');
                    }
                  }
                })
              })
            } else {
              // console.log('No existing date range');
              Array.from($('.cutoff')).forEach(function(element) {
                switch ($(element.childNodes[3]).text()) {
                  case 'Monday':
                    get_shift_data(url_get_shift_data, data[0].monday).then(data => {
                      data.forEach((x) => {
                        $(element.childNodes[9]).text('[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out);
                        var att_id = $(element).attr('att_id');
                        var shift_id = x.id;

                        updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                          // enter code after update
                          console.log(att_id);
                        })
                      });
                    })
                    break;
                  case 'Tuesday':
                    get_shift_data(url_get_shift_data, data[0].tuesday).then(data => {
                      if (data.length > 0) {
                        data.forEach((x) => {
                          $(element.childNodes[9]).text('[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out);
                          var att_id = $(element).attr('att_id');
                          var shift_id = x.id;

                          updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                            // enter code after update
                            console.log(att_id);
                          })
                        });
                      }
                    })
                    break;
                  case 'Wednesday':
                    get_shift_data(url_get_shift_data, data[0].wednesday).then(data => {
                      if (data.length > 0) {
                        data.forEach((x) => {
                          $(element.childNodes[9]).text('[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out);
                          var att_id = $(element).attr('att_id');
                          var shift_id = x.id;

                          updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                            // enter code after update
                            console.log(att_id);
                          })
                        });
                      }
                    })
                    break;
                  case 'Thursday':
                    get_shift_data(url_get_shift_data, data[0].thursday).then(data => {
                      if (data.length > 0) {
                        data.forEach((x) => {
                          $(element.childNodes[9]).text('[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out);
                          var att_id = $(element).attr('att_id');
                          var shift_id = x.id;

                          updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                            // enter code after update
                            console.log(att_id);
                          })
                        });
                      }
                    })
                    break;
                  case 'Friday':
                    get_shift_data(url_get_shift_data, data[0].friday).then(data => {
                      if (data.length > 0) {
                        data.forEach((x) => {
                          $(element.childNodes[9]).text('[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out);
                          var att_id = $(element).attr('att_id');
                          var shift_id = x.id;

                          updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                            // enter code after update
                            console.log(att_id);
                          })
                        });
                      }
                    })
                    break;
                  case 'Saturday':
                    get_shift_data(url_get_shift_data, data[0].saturday).then(data => {
                      if (data.length > 0) {
                        data.forEach((x) => {
                          $(element.childNodes[9]).text('[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out);
                          var att_id = $(element).attr('att_id');
                          var shift_id = x.id;

                          updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                            // enter code after update
                            console.log(att_id);
                          })
                        });
                      }
                    })
                    break;
                  case 'Sunday':
                    get_shift_data(url_get_shift_data, data[0].sunday).then(data => {
                      if (data.length > 0) {
                        data.forEach((x) => {
                          $(element.childNodes[9]).text('[' + x.code + ']' + ' ' + x.time_in + ' - ' + x.time_out);
                          var att_id = $(element).attr('att_id');
                          var shift_id = x.id;

                          updt_shift_async(url_updt_shift_async, shift_id, att_id).then(data => {
                            // enter code after update
                            console.log(att_id);
                          })
                        });
                      }
                    })
                    break;
                  default:
                    $(element.childNodes[9]).text('');
                }
              })
            }
          })
          $('#modal_apply_template').modal('toggle');
        }
      })
    })


    $('#btn_add_widget').click(function() {
      var employee_id = $('#modal_employee_id_group').val();
      var employee_cmid = $('#modal_employee_id_group option:selected').text();
      $('.widget_container').append(`
        <span empl_id="` + employee_id + `" class="widget">
          ` + employee_cmid + `
          <span class="remove_widget">x</span>
        </span>
      `);

      $('#widget_input_container').append(`
        <input type="hidden" id="empl_` + employee_id + `" value="` + employee_id + `" name="employees[]">
      `)

      $('#modal_employee_id_group option[value=' + employee_id + ']').remove();







      $('.remove_widget').click(function() {
        var remove_empl_id = $(this).parent().attr('empl_id');
        var remove_empl_cmid = $(this).parent().text();
        remove_empl_cmid_new = remove_empl_cmid.replace('x', '');

        $('.widget_container span[empl_id=' + remove_empl_id + ']').remove();
        $('#widget_input_container input[id=empl_' + remove_empl_id + ']').remove();

        if ($('#modal_employee_id_group').find('option[value=' + remove_empl_id + ']').length == 0) {
          $('#modal_employee_id_group').append(`
            <option value="` + remove_empl_id + `">` + remove_empl_cmid_new.trim() + `</option>
          `)
        }
      })
    })


    // ====================== COPY SHIFT TRIGGER MODAL ========================
    $('#copy_shift_toggle_modal').click(function() {
      Array.from($('.cutoff')).forEach(function(element) {
        var shift = $(element.childNodes[9]).attr('shift_id');
        var date = $(element.childNodes[1]).text();

        $('#date_shift_container').append(`
          <input type="hidden" value="` + date + ` ` + shift + `" name="date_shift[]">
        `)
      })
    })


    $('#btn_copy_shift').click(function(e) {
      e.preventDefault();
      var widget_length = $('.widget').length;
      if (widget_length > 0) {
        Swal.fire({
          title: 'Do you want to apply this shift to other employees?',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
            $('#form_copy_shift').submit();
          }
        })
      } else {
        Swal.fire(
          'No employees selected',
          'Please select employees where the copied shift will be applied',
          'warning'
        )
      }
    })








    function set_attendance_lock_status() {
      var inc_unass_arr = [];
      Array.from($('.cutoff')).forEach(function(tr) {
        var td_status = $(tr)[0].childNodes[15];
        // if(($(td_status).text() == 'Unassigned') || ($(td_status).text() == 'Incomplete') || ($(td_status).text() == 'Abnormal')){
        // if(($(td_status).text() == 'Unassigned') || ($(td_status).text() == 'Incomplete')){
        // if(($(td_status).text() == 'Unassigned')){
        // // if(($(td_status).text() == 'Unassigned')){
        //   inc_unass_arr.push(1);
        // }
      })

      console.log(inc_unass_arr.length);

      // if(inc_unass_arr.length > 0){
      //   $('#btn_approve_attendance').prop('disabled', true);
      // } else {
      //   $('#btn_approve_attendance').prop('disabled', false);
      // }
    }







    // ======================================= CALCULATE ATTENDANCE =====================================
    var url_update_attendance_calculation = '<?= base_url() ?>attendance/update_attendance_calculation';
    $('#btn_calculate_attendance').click(function() {
      calculate();
      save_to_db();

      var inc_unass_arr = [];
      // Array.from($('.cutoff')).forEach(function(tr){
      //   var td_status = $(tr)[0].childNodes[15];
      //   // if(($(td_status).text() == 'Unassigned') || ($(td_status).text() == 'Incomplete') || ($(td_status).text() == 'Abnormal')){
      //   if(($(td_status).text() == 'Unassigned')){
      //   // if(($(td_status).text() == 'Unassigned')){
      //     inc_unass_arr.push(1);
      //   }
      // })

      // console.log(inc_unass_arr.length);

      // if(inc_unass_arr.length > 0){
      //   $('#btn_approve_attendance').prop('disabled', true);
      // } else {
      //   $('#btn_approve_attendance').prop('disabled', false);
      // }
    })

    var url_update_approve_attendance = '<?= base_url() ?>attendance/update_approve_attendance';
    $('#btn_approve_attendance').click(function() {
      $('#btn_calculate_attendance').prop('disabled', true);
      $('#btn_disapprove_attendance').prop('disabled', false);
      $('#btn_approve_attendance').prop('disabled', true);
      $('#copy_shift_toggle_modal').prop('disabled', true);
      $('#apply_template_toggle_modal').prop('disabled', true);
      $('.cutoff').each(function() {
        $(this).attr('data-toggle', '');

        var parent_tr = $(this)[0];
        var date = $(parent_tr.childNodes[1]).text();
        var empl_id = $(parent_tr.childNodes[5]).attr('empl_id');
        var isApprove = 1;
        var row_color = '#ccc';

        update_approve_attendance(url_update_approve_attendance, date, empl_id, isApprove, row_color).then(function(data) {
          console.log(data);
        });

        $(parent_tr).css({
          'backgroundColor': '#ccc'
        })
      })
    })

    $('#btn_disapprove_attendance').click(function() {
      $('#btn_calculate_attendance').prop('disabled', false);
      $('#btn_approve_attendance').prop('disabled', false);
      $('#btn_disapprove_attendance').prop('disabled', true);
      $('#copy_shift_toggle_modal').prop('disabled', false);
      $('#apply_template_toggle_modal').prop('disabled', false);
      $('.cutoff').each(function() {
        $(this).attr('data-toggle', 'modal');

        var parent_tr = $(this)[0];
        var date = $(parent_tr.childNodes[1]).text();
        var empl_id = $(parent_tr.childNodes[5]).attr('empl_id');
        var isApprove = 0;
        var row_color = '#fff';

        update_approve_attendance(url_update_approve_attendance, date, empl_id, isApprove, row_color).then(function(data) {
          console.log(data);
        });

        $(parent_tr).css({
          'backgroundColor': '#fff'
        })
      })
    })




    function calculate() {
      Array.from($('.cutoff')).forEach(function(tr) {
        var show_childNodes = $(tr)[0].childNodes;
        // console.log(show_childNodes);

        var td_date = $(tr)[0].childNodes[1];
        var td_dow = $(tr)[0].childNodes[3];
        var td_day_code = $(tr)[0].childNodes[7];
        var td_empl_id = $(tr)[0].childNodes[5];
        var td_shift = $(tr)[0].childNodes[9];
        var td_time_in = $(tr)[0].childNodes[11];
        var td_time_out = $(tr)[0].childNodes[13];
        var td_status = $(tr)[0].childNodes[15];

        var td_working_day = $(tr)[0].childNodes[19];
        var td_no_ti_to = $(tr)[0].childNodes[21];
        var td_rd_sp = $(tr)[0].childNodes[23];
        var td_reg_hol = $(tr)[0].childNodes[25];
        var td_rd_reg = $(tr)[0].childNodes[27];
        var td_rd_add_sp = $(tr)[0].childNodes[29];
        var td_abs = $(tr)[0].childNodes[31];
        var td_tard = $(tr)[0].childNodes[33];
        var td_ut = $(tr)[0].childNodes[35];
        var td_nd = $(tr)[0].childNodes[39];
        var td_reg_ot = $(tr)[0].childNodes[37];
        var td_ns_ot = $(tr)[0].childNodes[41];
        var td_pd_l = $(tr)[0].childNodes[43];
        var td_half_day = $(tr)[0].childNodes[45];
        var td_rest_ot = $(tr)[0].childNodes[47];

        // fetch texts
        var date = $(td_date).text();
        var dow = $(td_dow).text();
        var day_code = $(td_day_code).text();
        var time_in = $(td_time_in).text();
        var time_out = $(td_time_out).text();
        var empl_group = $(td_empl_id).attr('empl_group');
        var empl_id = $(td_empl_id).attr('empl_id');
        var hasNextDay = $(td_shift).attr('next_day');
        var hasBreak = $(td_shift).attr('has_break');
        var shift_time_in = $(td_shift).attr('time_in');
        var shift_time_out = $(td_shift).attr('time_out');
        var night_shift = $(td_shift).attr('night_shift');
        var day_shift_OT = $(td_shift).attr('day_shift_OT');
        var night_shift_OT = $(td_shift).attr('night_shift_OT');
        var work_hours = $(td_shift).attr('work_hours');
        var time_out_ot = $(td_shift).attr('time_out_ot');
        var approved_night_diff = $(td_nd).attr('approved_night_diff');
        var approved_reg_ot = $(td_reg_ot).attr('approved_reg_ot');
        var approved_ns_ot = $(td_ns_ot).attr('approved_ns_ot');
        var paid_leave = $(td_pd_l).text();

        var approved_night_diff = parseFloat(approved_night_diff).toFixed(2);
        var approved_reg_ot = parseFloat(approved_reg_ot).toFixed(2);
        var approved_ns_ot = parseFloat(approved_ns_ot).toFixed(2);

        if ((night_shift != 0)) {
          var night_shift = (parseFloat(night_shift)).toFixed(2);
        } else {
          var night_shift = '';
        }

        if ((day_shift_OT != 0)) {
          var day_shift_OT = (parseFloat(day_shift_OT)).toFixed(2);
        } else {
          var day_shift_OT = '';
        }

        if ((night_shift_OT != 0)) {
          var night_shift_OT = (parseFloat(night_shift_OT)).toFixed(2);
        } else {
          var night_shift_OT = '';
        }

        if ((work_hours != 0)) {
          var work_hours = (parseFloat(work_hours)).toFixed(2);
        } else {
          var work_hours = '';
        }


        // GET SHIFT CODE 
        var shift_name = $(td_shift).text();
        var split_shift_name = shift_name.split(']');
        var shift_code = split_shift_name[0].replace('[', '');
        shift_code = shift_code.trim();

        var time_in_diff;
        var time_out_diff;

        $(td_status).text('');
        $(td_working_day).text('');
        $(td_no_ti_to).text('');
        $(td_rd_sp).text('');
        // $(td_reg_hol).text('');
        $(td_rd_reg).text('');
        $(td_rd_add_sp).text('');
        $(td_abs).text('');
        $(td_tard).text('');
        $(td_ut).text('');
        // $(td_nd).text('');
        // $(td_reg_ot).text('');
        // $(td_ns_ot).text('');
        // $(td_rest_ot).text('');





        if (paid_leave > 0) {
          $(td_status).text('Paid Leave');
        } else {
          if (!shift_name) {
            $(td_status).text('Unassigned');
            $(td_working_day).text('');
            $(td_no_ti_to).text('');
            $(td_abs).text('');
            $(td_tard).text('');
            $(td_ut).text('');
          } else {
            if (time_in && time_out) {

              console.log('time_in: ' + time_in);
              console.log('time_out: ' + time_out);
              console.log('shift_time_in: ' + shift_time_in);
              console.log('shift_time_out: ' + shift_time_out);
              console.log('work_hours: ' + work_hours);

              var workinghours = calculate_work_duration(hasNextDay, time_in, time_out, shift_time_in, shift_time_out, work_hours);
              var realhours = calculate_real_duration(hasNextDay, time_in, time_out, shift_time_in, shift_time_out, work_hours);

              console.log('date: ' + date);
              console.log('shift_name: ' + shift_name);
              console.log('workinghours: ' + workinghours);
              console.log('REALLLLL: ' + realhours)

              if (realhours == 4) {
                // console.log(realhours)
                $(td_abs).text('');
                $(td_status).text('Present');
                $(td_working_day).text('1.00');
                $(td_half_day).text('4.00');
              } else {

                if (workinghours < 4) {
                  if ((shift_code == 'REST') || (shift_code == 'NWS')) {
                    $(td_status).text('Rest');
                  } else {
                    if (day_code == 'Regular') {
                      $(td_status).text('Absent');

                      if (parseFloat(work_hours) == 8) {
                        $(td_abs).text('1.00');
                      } else if (parseFloat(work_hours) == 6) {
                        $(td_abs).text('0.75');
                      } else if (parseFloat(work_hours) == 4) {
                        $(td_abs).text('0.50');
                      } else {
                        $(td_abs).text('');
                      }

                      $(td_nd).text('');
                      $(td_reg_ot).text('');
                      $(td_ns_ot).text('');
                    } else {
                      $(td_status).text('Holiday');
                    }
                  }
                } else {
                  if (((hasNextDay != 'true') && (time_in < time_out)) || ((hasNextDay == 'true') && (time_in > time_out))) {

                    //REGULAR OVERTIME COUNT CALCULATION
                    var ded_ot_count = 0;
                    var reg_ot_count = 0;
                    if ((time_out > shift_time_out) && (time_out < time_out_ot)) {
                      ded_ot_count = deduction_out(time_out, time_out_ot);
                      console.log('ded_ot_count: ' + ded_ot_count);
                    }

                    if (time_out <= shift_time_out) {
                      reg_ot_count = 0;

                    } else {
                      reg_ot_count = day_shift_OT - ded_ot_count;
                    }

                    if (reg_ot_count < 0) {
                      reg_ot_count = 0;
                    }

                    if ((reg_ot_count == 0) && (approved_reg_ot == 0)) {
                      $(td_reg_ot).text('');
                    } else {
                      if (dow == 'Saturday') {
                        console.log('sabado ngayon');
                        console.log('shift code: ' + shift_code);
                        if (shift_code == 'REST') {
                          if ($(td_rest_ot).text() == '') {
                            if (reg_ot_count > 0) {
                              $(td_rest_ot).text(reg_ot_count.toFixed(2));
                            }
                          }
                        } else {
                          if ($(td_reg_ot).text() == '') {
                            if ($(td_reg_ot).text() != '') {
                              $(td_reg_ot).text(reg_ot_count + ' (' + reg_ot_count.toFixed(2) + ')');
                            }
                          }
                        }

                      } else {
                        if ($(td_reg_ot).text() != '') {
                          $(td_reg_ot).text(approved_reg_ot + ' (' + reg_ot_count.toFixed(2) + ')');
                        }
                      }

                    }


                    //NIGHT DIFFERENTIAL OVERTIME COUNT CALCULATION
                    var ded_ns_ot_count = 0;
                    var ns_ot_count = 0;
                    if ((time_out > shift_time_out) && (time_out < time_out_ot)) {
                      ded_ns_ot_count = deduction_out(time_out, time_out_ot);
                    }

                    if (time_out <= shift_time_out) {
                      ns_ot_count = 0;
                    } else {
                      ns_ot_count = night_shift_OT - ded_ns_ot_count;
                    }

                    if (ns_ot_count < 0) {
                      ns_ot_count = 0;
                    }

                    if ((ns_ot_count == 0) && (approved_ns_ot == 0)) {
                      $(td_ns_ot).text('');
                    } else {
                      if ($(td_ns_ot).text() != '') {
                        $(td_ns_ot).text(approved_ns_ot + ' (' + ns_ot_count.toFixed(2) + ')');
                      }
                    }


                    //NIGHT DIFFERENTIAL COUNT CALCULATION
                    var undertime_count = deduction_out(time_out, shift_time_out);
                    var night_diff_count = night_shift - undertime_count;

                    if (night_diff_count < 0) {
                      night_diff_count = 0;
                    }

                    if ((night_diff_count == 0) && (approved_night_diff == 0)) {
                      $(td_nd).text('');
                    } else {
                      $(td_nd).text(approved_night_diff + ' (' + night_diff_count.toFixed(2) + ')');
                    }


                    $(td_working_day).text('1.00');
                    $(td_status).text('Present');

                    //TARDINESS COUNT CALCULATION
                    if (time_in > shift_time_in) {
                      var late_count = deduction_in(time_in, shift_time_in);

                      if (late_count == 0) {
                        $(td_tard).text('');
                      } else {
                        $(td_tard).text(late_count.toFixed(2));
                      }

                    } else {}



                    // SATURDAY SHIFT + EXCESS HOURS COMPUTATION
                    if (shift_code.includes('SAT')) {
                      var duration = calculate_work_duration(hasNextDay, time_in, time_out, shift_time_in, shift_time_out, work_hours);

                      console.log('SATURDAY TIME IN: ' + time_in);
                      console.log('SATURDAY TIME OUT: ' + time_out);
                      console.log('SATURDAY SHIFT TIME IN: ' + shift_time_in);
                      console.log('SATURDAY SHIFT TIME OUT: ' + shift_time_out);
                      console.log('SATURDAY DURATION: ' + duration);

                      if ((time_out > shift_time_out) && (time_out < time_out_ot)) {
                        ded_ot_count = deduction_out(shift_time_out, time_out);

                        if (Number.isInteger(ded_ot_count) == false) {
                          ded_ot_count = ded_ot_count - 0.5;
                          $(td_rest_ot).text(ded_ot_count);
                          $(td_rd_sp).text();

                          if (duration == work_hours) {
                            $(td_rd_sp).text(duration);
                            $(td_rest_ot).text(ded_ot_count);
                          } else if (duration <= work_hours) {
                            $(td_rd_sp).text(duration);

                            var real_work_duration = work_hours - duration;
                            var rest_day_ot_pay = ded_ot_count - real_work_duration;

                            if (rest_day_ot_pay > 0) {
                              $(td_rest_ot).text(rest_day_ot_pay);
                            } else {
                              $(td_rest_ot).text('');
                            }
                          }
                        }

                      }

                    }


                    //REGULAR + WORKING DAY UNDERTIME COMPUTATION
                    if ((day_code == 'Regular') && (shift_code != 'REST') && (shift_code != 'NWS')) {
                      if (time_out < shift_time_out) {
                        if (undertime_count == 0) {
                          $(td_ut).text('');
                        } else {
                          $(td_ut).text(undertime_count.toFixed(2));
                        }
                      } else {

                      }
                    }

                    //REGULAR + RESTDAY EXCESS PAY COMPUTATION
                    else if ((day_code == 'Regular') && ((shift_code == 'REST') || (shift_code == 'NWS'))) {
                      var duration = calculate_work_duration(hasNextDay, time_in, time_out, shift_time_in, shift_time_out, work_hours);

                      $(td_rd_sp).text((duration).toFixed(2));

                    }

                    //SPECIAL + WORKING EXCESS PAY COMPUTATION
                    else if ((day_code == 'Special Non-working holiday') && (shift_code != 'REST') && (shift_code != 'NWS')) {
                      var duration = calculate_work_duration(hasNextDay, time_in, time_out, shift_time_in, shift_time_out, work_hours);
                      $(td_rd_sp).text((duration).toFixed(2));
                    }

                    //SPECIAL + REST EXCESS PAY COMPUTATION
                    else if ((day_code == 'Special Non-working holiday') && ((shift_code == 'REST') || (shift_code == 'NWS'))) {

                      var duration = calculate_work_duration(hasNextDay, time_in, time_out, shift_time_in, shift_time_out, work_hours);


                      // $(td_rd_sp).text((duration).toFixed(2));
                      $(td_rd_add_sp).text((duration).toFixed(2));
                    }

                    //REGULAR HOLIDAY + WORKING EXCESS PAY COMPUTATION
                    else if ((day_code == 'Regular holiday') && (shift_code != 'REST') && (shift_code != 'NWS')) {

                      var duration = calculate_work_duration(hasNextDay, time_in, time_out, shift_time_in, shift_time_out, work_hours);

                      // $(td_reg_hol).text((duration).toFixed(2));

                    }

                    //REGULAR HOLIDAY + REST EXCESS PAY COMPUTATION
                    else if ((day_code == 'Regular holiday') && ((shift_code == 'REST') || (shift_code == 'NWS'))) {

                      var duration = calculate_work_duration(hasNextDay, time_in, time_out, shift_time_in, shift_time_out, work_hours);

                      $(td_rd_reg).text((duration).toFixed(2));
                    }

                    //ELSE
                    else {

                    }
                  }
                  // Not INCLUDED
                  else {
                    $(td_status).text('Abnormal');
                  }
                }
              }
            }

            // Not INCLUDED
            else if (!time_in && !time_out) {
              if ((day_code != 'Regular')) {
                if ((shift_code == 'REST') || (shift_code == 'NWS')) {
                  $(td_status).text('Holiday: Rest');
                } else {
                  $(td_status).text('Holiday: Absent');
                }
              } else {
                if ((shift_code == 'REST') || (shift_code == 'NWS')) {
                  $(td_status).text('Rest');
                } else {
                  $(td_status).text('Absent');

                  if (parseFloat(work_hours) == 8) {
                    $(td_abs).text('1.00');
                  } else if (parseFloat(work_hours) == 6) {
                    $(td_abs).text('0.75');
                  } else if (parseFloat(work_hours) == 4) {
                    $(td_abs).text('0.50');
                  } else {
                    $(td_abs).text('');
                  }

                  $(td_nd).text('');
                  $(td_reg_ot).text('');
                  $(td_ns_ot).text('');
                }
              }
            } else {
              $(td_status).text('Incomplete');
              $(td_no_ti_to).text('1.00');
            }
          }
        }

        if (paid_leave > 0) {
          $(td_abs).text('');
          $(td_reg_ot).text('');
          $(td_rest_ot).text('');
          $(td_nd).text('');
        }

        console.log('============================');
      })
    }

    function convert_time_to_float(time, type) {
      var converted_time;
      var split_time_in = time.split(':');

      if (type == 'minute') {
        converted_time = (parseFloat(split_time_in[0]) * 60) + parseFloat(split_time_in[1]);
      } else {
        converted_time = parseFloat(split_time_in[0]) + (parseFloat(split_time_in[1]) / 60);
      }

      return converted_time;
    }

    function calculate_work_duration(hasNextDay, time_in, time_out, shift_time_in, shift_time_out, work_hours) {


      var work_duration = parseFloat(work_hours) - deduction_in(time_in, shift_time_in) - deduction_out(time_out, shift_time_out);
      console.log('work hours: ' + parseFloat(work_hours));
      console.log('deduction_in: ' + deduction_in(time_in, shift_time_in));
      console.log('deduction_out: ' + deduction_out(time_out, shift_time_out));
      return work_duration;
    }

    function calculate_real_duration(hasNextDay, time_in, time_out, shift_time_in, shift_time_out, work_hours) {

      var act_time_in;

      if (time_in >= shift_time_in) {
        act_time_in = time_in;
      } else {
        act_time_in = shift_time_in;
      }

      var exc_dec_in = 0;
      var exc_dec_out = 0;

      var hour_in = convert_time_to_float(act_time_in, 'hour');
      var hour_out = convert_time_to_float(time_out, 'hour');

      var hour_whole_in = hour_in - (hour_in % 1);
      var hour_whole_out = hour_out - (hour_out % 1);
      //7:47 = 8
      //7:15 = 7.5
      if (hour_in % 1 > 0.5) {
        exc_dec_in = 1;
      } else {
        exc_dec_in = 0.5;
      }

      if (hour_out % 1 > 0.5) {
        exc_dec_out = 0.5;
      } else {
        exc_dec_out = 0;
      }

      console.log(hour_whole_in);
      console.log(exc_dec_in);
      console.log(hour_whole_out);
      console.log(exc_dec_out);

      if (time_in < shift_time_in) {
        exc_dec_in = 0;
      }

      var res_in = hour_whole_in + exc_dec_in;
      var res_out = hour_whole_out + exc_dec_out;


      var work_duration = res_out - res_in;

      console.log(res_in);
      console.log(res_out);

      return work_duration;
    }

    function deduction_in(time_in, shift_in) {
      var shift_in_min = convert_time_to_float(shift_in, 'minute');
      var time_in_min = convert_time_to_float(time_in, 'minute');
      var in_min = time_in_min - shift_in_min;
      var in_ded = 0;

      if ((in_min > 0) && (in_min <= 5)) {
        in_ded = 0.5;
      } else if ((in_min > 5) && (in_min <= 60)) {
        in_ded = 1;
      } else if ((in_min > 60) && (in_min <= 65)) {
        in_ded = 1.5;
      } else if ((in_min > 65) && (in_min <= 120)) {
        in_ded = 2.0;
      } else if ((in_min > 120) && (in_min <= 125)) {
        in_ded = 2.5;
      } else if ((in_min > 125) && (in_min <= 180)) {
        in_ded = 3.0;
      } else if ((in_min > 180) && (in_min <= 185)) {
        in_ded = 3.5;
      } else if ((in_min > 185) && (in_min <= 240)) {
        in_ded = 4.0;
      } else if ((in_min > 240) && (in_min <= 245)) {
        in_ded = 4.5;
      } else if ((in_min > 245) && (in_min <= 300)) {
        in_ded = 5.0;
      } else if ((in_min > 300) && (in_min <= 305)) {
        in_ded = 5.5;
      } else if ((in_min > 305) && (in_min <= 360)) {
        in_ded = 6.0;
      }

      return in_ded;
    }



    function deduction_out(time_out, shift_out) {
      var shift_out_min = convert_time_to_float(shift_out, 'minute');
      var time_out_min = convert_time_to_float(time_out, 'minute');
      var out_min = shift_out_min - time_out_min;
      var out_ded = 0;

      if ((out_min > 0) && (out_min <= 30)) {
        out_ded = 0.5;
      } else if ((out_min > 30) && (out_min <= 60)) {
        out_ded = 1.0;
      } else if ((out_min > 60) && (out_min <= 90)) {
        out_ded = 1.5;
      } else if ((out_min > 90) && (out_min <= 120)) {
        out_ded = 2.0;
      } else if ((out_min > 120) && (out_min <= 150)) {
        out_ded = 2.5;
      } else if ((out_min > 150) && (out_min <= 180)) {
        out_ded = 3.0;
      } else if ((out_min > 180) && (out_min <= 210)) {
        out_ded = 3.5;
      } else if ((out_min > 210) && (out_min <= 240)) {
        out_ded = 4.0;
      } else if ((out_min > 240) && (out_min <= 270)) {
        out_ded = 4.5;
      } else if ((out_min > 270) && (out_min <= 300)) {
        out_ded = 5.0;
      } else if ((out_min > 300) && (out_min <= 330)) {
        out_ded = 5.5;
      } else if ((out_min > 330) && (out_min <= 360)) {
        out_ded = 6.0;
      } else if ((out_min > 360) && (out_min <= 390)) {
        out_ded = 6.5;
      } else if ((out_min > 390) && (out_min <= 420)) {
        out_ded = 7.0;
      } else if ((out_min > 420) && (out_min <= 450)) {
        out_ded = 7.5;
      } else if ((out_min > 450) && (out_min <= 480)) {
        out_ded = 8.0;
      }

      return out_ded;
    }




    function save_to_db() {
      Array.from($('.cutoff')).forEach(function(tr) {
        var parent_tr_container = $(tr)[0];
        var show_childNodes = $(tr)[0].childNodes;

        // TD CONTAINER
        var td_date = $(tr)[0].childNodes[1];
        var td_day_code = $(tr)[0].childNodes[7];
        var td_empl_id = $(tr)[0].childNodes[5];
        var td_shift = $(tr)[0].childNodes[9];
        var td_time_in = $(tr)[0].childNodes[11];
        var td_time_out = $(tr)[0].childNodes[13];
        var td_status = $(tr)[0].childNodes[15];

        var td_working_day = $(tr)[0].childNodes[19];
        var td_no_ti_to = $(tr)[0].childNodes[21];
        var td_rd_sp = $(tr)[0].childNodes[23];
        var td_reg_hol = $(tr)[0].childNodes[25];
        var td_rd_reg = $(tr)[0].childNodes[27];
        var td_rd_add_sp = $(tr)[0].childNodes[29];
        var td_abs = $(tr)[0].childNodes[31];
        var td_tard = $(tr)[0].childNodes[33];
        var td_ut = $(tr)[0].childNodes[35];
        var td_nd = $(tr)[0].childNodes[39];
        var td_reg_ot = $(tr)[0].childNodes[37];
        var td_ns_ot = $(tr)[0].childNodes[41];
        var td_leave = $(tr)[0].childNodes[43];
        var td_half_day = $(tr)[0].childNodes[45];
        var td_rest_ot = $(tr)[0].childNodes[47];
        var td_rest_nd_ot = $(tr)[0].childNodes[49];

        // TD TEXTS
        var date = $(td_date).text();
        var day_code = $(td_day_code).text();
        var empl_id = $(td_empl_id).attr('empl_id');
        var shift = $(td_shift).text();
        var time_in = $(td_time_in).text();
        var time_out = $(td_time_out).text();
        var status = $(td_status).text();

        var working_days = $(td_working_day).text();
        var no_ti_to = $(td_no_ti_to).text();
        var rd_sp = $(td_rd_sp).text();
        var reg_hol = $(td_reg_hol).text();
        var rd_reg = $(td_rd_reg).text();
        var rd_add_sp = $(td_rd_add_sp).text();
        var abs = $(td_abs).text();
        var tard = $(td_tard).text();
        var ut = $(td_ut).text();
        var nd = $(td_nd).text();
        var reg_ot = $(td_reg_ot).text();
        var ns_ot = $(td_ns_ot).text();
        var leave = $(td_leave).text();
        var half_day = $(td_half_day).text();
        var rest_ot = $(td_rest_ot).text();
        var rest_nd_ot = $(td_rest_nd_ot).text();

        var calc_color = '#def1ff';
        // var calc_single_color = '#c7ffd4';

        if (date == '') {
          date = 0;
        }
        if (day_code == '') {
          day_code = 0;
        }
        if (empl_id == '') {
          empl_id = 0;
        }
        if (shift == '') {
          shift = 0;
        }
        if (time_in == '') {
          time_in = 0;
        }
        if (time_out == '') {
          time_out = 0;
        }
        if (status == '') {
          status = 0;
        }

        if (working_days == '') {
          working_days = 0;
        }
        if (no_ti_to == '') {
          no_ti_to = 0;
        }
        if (rd_sp == '') {
          rd_sp = 0;
        }
        if (reg_hol == '') {
          reg_hol = 0;
        }
        if (rd_reg == '') {
          rd_reg = 0;
        }
        if (rd_add_sp == '') {
          rd_add_sp = 0;
        }
        if (abs == '') {
          abs = 0;
        }
        if (tard == '') {
          tard = 0;
        }
        if (ut == '') {
          ut = 0;
        }

        appr_nd = 0;
        appr_reg_ot = 0;
        appr_ns_ot = 0;

        if (nd == '') {
          nd = 0;
        } else {
          if (nd.includes(')')) {
            var split_nd = nd.split('(');
            var nd = split_nd[1].replace(')', '');
            var appr_nd = split_nd[0].replace(' ', '');
          }
        }

        if (reg_ot == '') {
          reg_ot = 0;
        } else {
          if (reg_ot.includes(')')) {
            var split_reg_ot = reg_ot.split('(');
            var reg_ot = split_reg_ot[1].replace(')', '');
            var appr_reg_ot = split_reg_ot[0].replace(' ', '');
          }
        }

        if (ns_ot == '') {
          ns_ot = 0;
        } else {
          if (ns_ot.includes(')')) {
            var split_ns_ot = ns_ot.split('(');
            var ns_ot = split_ns_ot[1].replace(')', '');
            var appr_ns_ot = split_ns_ot[0].replace(' ', '');
          }
        }





        if (leave == '') {
          leave = 0;
        }
        if (half_day == '') {
          half_day = 0;
        }
        if (rest_ot == '') {
          rest_ot = 0;
        }
        if (rest_nd_ot == '') {
          rest_nd_ot = 0;
        }

        update_attendance_calculation(url_update_attendance_calculation, date, empl_id, status, working_days, no_ti_to, rd_sp, reg_hol, rd_reg, rd_add_sp, abs, tard, ut, nd, reg_ot, ns_ot, leave, half_day, calc_color, appr_nd, appr_reg_ot, appr_ns_ot, rest_ot, rest_nd_ot).then(function(data) {
          console.log(data);
        })

        $(tr).css({
          'backgroundColor': calc_color
        })

      })
    }


    function hexToRgb(hex) {
      var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
      return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
      } : null;
    }






























    // ======================================= VIEW ATTENDANCE SUMMARY -================================
    $('#btn_view_att_summary').click(function() {
      var empl_id = $('#employee_id').val();
      var cutoff_period = $('#cutoff_period').val();
      var split_cutoff_period = cutoff_period.split(' - ');

      // clear current values
      $('#total_working_days').html(0);
      $('#total_rest_day').html(0);
      $('#total_unassigned_shift').html(0);
      $('#total_present').html(0);
      $('#total_absent').html(0);
      $('#total_late').html(0);

      // count total working days
      var total_working_days_arr = [];
      var total_rest_day_arr = [];
      var total_unassigned_shift_arr = [];
      var total_present_arr = [];
      var total_absent_arr = [];
      var total_late_arr = [];

      if (split_cutoff_period[0] && split_cutoff_period[1] && empl_id) {
        get_employee_data(url2, empl_id, cutoff_period).then(data => {

          // DEFINE ARRAY VARIABLES
          var work_days_arr = [];
          var sp_hol_arr = [];
          var reg_hol_arr = [];
          var no_ti_to_arr = [];
          var rest_sp_hol_arr = [];
          var rest_reg_hol_arr = [];
          var night_diff_arr = [];
          var reg_ot_arr = [];
          var ns_ot_arr = [];
          var absences_arr = [];
          var tard_arr = [];
          var undertime_arr = [];

          var appr_reg_ot_arr = [];
          var appr_night_diff_arr = [];
          var appr_nd_ot_arr = [];

          var leave_arr = [];
          var half_day_arr = [];

          var rest_ot_arr = [];
          var rest_nd_ot_arr = [];

          data.cutoff_data.forEach((x) => {
            // PUSH VALUES TO ARRAY
            work_days_arr.push(parseFloat(x.work_day));
            sp_hol_arr.push(parseFloat(x.bp_sp_hol));
            reg_hol_arr.push(parseFloat(x.bp_reg_hol));
            no_ti_to_arr.push(parseFloat(x.no_ti_to));
            rest_sp_hol_arr.push(parseFloat(x.bp_sp_rest));
            rest_reg_hol_arr.push(parseFloat(x.bp_reg_hol_rest));
            night_diff_arr.push(parseFloat(x.bp_reg_ns));
            reg_ot_arr.push(parseFloat(x.ot_reg));
            ns_ot_arr.push(parseFloat(x.ot_reg_ns));
            absences_arr.push(parseFloat(x.absent));
            tard_arr.push(parseFloat(x.late));
            undertime_arr.push(parseFloat(x.undertime));

            appr_reg_ot_arr.push(parseFloat(x.appr_reg_ot));
            appr_night_diff_arr.push(parseFloat(x.appr_night_diff));
            appr_nd_ot_arr.push(parseFloat(x.appr_ns_ot));

            leave_arr.push(parseFloat(x.paid_leave));
            half_day_arr.push(parseFloat(x.half_day));

            rest_ot_arr.push(parseFloat(x.rest_ot));
            rest_nd_ot_arr.push(parseFloat(x.rest_nd_ot));
          })

          // ADD ARRAY VALUES
          var work_days_total = work_days_arr.reduce(add_array_values);
          var sp_hol_total = sp_hol_arr.reduce(add_array_values);
          var reg_hol_total = reg_hol_arr.reduce(add_array_values);
          var no_ti_to_total = no_ti_to_arr.reduce(add_array_values);
          var rest_sp_hol_total = rest_sp_hol_arr.reduce(add_array_values);
          var rest_reg_hol_total = rest_reg_hol_arr.reduce(add_array_values);
          var night_diff_total = night_diff_arr.reduce(add_array_values);
          var reg_ot_total = reg_ot_arr.reduce(add_array_values);
          var ns_ot_total = ns_ot_arr.reduce(add_array_values);
          var absences_total = absences_arr.reduce(add_array_values);
          var tard_total = tard_arr.reduce(add_array_values);
          var undertime_total = undertime_arr.reduce(add_array_values);

          var appr_reg_ot_total = appr_reg_ot_arr.reduce(add_array_values);
          var appr_night_diff_total = appr_night_diff_arr.reduce(add_array_values);
          var appr_nd_ot_total = appr_nd_ot_arr.reduce(add_array_values);

          var leave_total = leave_arr.reduce(add_array_values);
          var half_day_total = half_day_arr.reduce(add_array_values);

          var rest_ot_total = rest_ot_arr.reduce(add_array_values);
          var rest_nd_ot_total = rest_nd_ot_arr.reduce(add_array_values);

          // APPEND TO TEXTS
          $('#work_days_sum').text(work_days_total.toFixed(2));
          $('#sp_hol_sum').text(sp_hol_total.toFixed(2));
          $('#reg_hol_sum').text(reg_hol_total.toFixed(2));
          $('#no_ti_to_sum').text(no_ti_to_total.toFixed(2));
          $('#rest_sp_hol_sum').text(rest_sp_hol_total.toFixed(2));
          $('#rest_reg_hol_sum').text(rest_reg_hol_total.toFixed(2));
          $('#night_diff_sum').text(night_diff_total.toFixed(2));
          $('#reg_ot_sum').text(reg_ot_total.toFixed(2));
          $('#ns_ot_sum').text(ns_ot_total.toFixed(2));
          $('#absences_sum').text(absences_total.toFixed(2));
          $('#tard_sum').text(tard_total.toFixed(2));
          $('#undertime_sum').text(undertime_total.toFixed(2));

          $('#approved_night_diff_sum').text(appr_night_diff_total.toFixed(2));
          $('#approved_reg_ot_sum').text(appr_reg_ot_total.toFixed(2));
          $('#approved_ns_ot_sum').text(appr_nd_ot_total.toFixed(2));

          $('#leave_sum').text(leave_total.toFixed(2));
          $('#half_day_sum').text(half_day_total.toFixed(2));

          $('#rest_ot_sum').text(rest_ot_total.toFixed(2));
          $('#rest_nd_ot_sum').text(rest_nd_ot_total.toFixed(2));

          data.employee_data.forEach((x) => {
            $('#employee_name_sum').html(x.col_frst_name + " " + x.col_last_name);
            $('#employee_position_sum').html(x.col_empl_posi);
            $('#cutoff_period_sum').html(cutoff_period);
            if (x.col_imag_path) {
              $('#employee_img_sum').attr('src', base_url + 'user_images/' + x.col_imag_path);
            } else {
              $('#employee_img_sum').attr('src', base_url + 'user_images/default_profile_img3.png');
            }
          })

          $('.cutoff').each(function() {
            // console.log($(this).children());

            var status_data = $($(this).children()[7]).text();
            var remarks_data = $($(this).children()[8]).text();
            var shift_data = $($(this).children()[4]).text();
            var split_shift_data = shift_data.split(' ');
            var shift_code = split_shift_data[0];
            var replace_str1 = shift_code.replace('[', '');
            var shift_code = replace_str1.replace(']', '');

            // count total working days
            if ((shift_code != 'REST') && (shift_code != 'NWS') && (shift_code != '')) {
              total_working_days_arr.push(1);
              $('#total_working_days').text(total_working_days_arr.reduce(add_array_values));
            };

            // count total days on REST
            if ((shift_code == 'REST') || (shift_code == 'NWS')) {
              total_rest_day_arr.push(1);
              $('#total_rest_day').text(total_rest_day_arr.reduce(add_array_values));
            }

            // count total unassigned shifts
            if ((shift_data == '') || (shift_data == ' ') || (shift_data == null)) {
              total_unassigned_shift_arr.push(1);
              $('#total_unassigned_shift').text(total_unassigned_shift_arr.reduce(add_array_values));
            }

            // count days present
            if (status_data == 'Present') {
              total_present_arr.push(1);
              $('#total_present').text(total_present_arr.reduce(add_array_values));
            }

            //count days absent
            if (status_data == 'Absent') {
              total_absent_arr.push(1);
              $('#total_absent').text(total_absent_arr.reduce(add_array_values));
            }

            //count days absent
            if (remarks_data == 'Late') {
              total_late_arr.push(1);
              $('#total_late').text(total_late_arr.reduce(add_array_values));
            }
          })

          $('#total_working_days').text();
        })
      }
    })

    function add_array_values(a, b) {
      return a + b;
    }































    // ============================================== FILTRATION =======================================

    function display_filtered_data(department, line, group, section) {
      $('#employee_id').html('');
      get_filter_data(url_get_filter_data, department, line, group, section).then(function(data) {
        $('#employee_id').append(`
          <option value="">Choose Employee...</option>
        `);
        Array.from(data).forEach(function(x) {
          $('#employee_id').append(`
            <option value="` + x.id + `">` + x.col_empl_cmid + ` - ` + x.col_frst_name + ` ` + x.col_last_name + `</option>
          `);
        })
        count_locked_and_not_locked($('#cutoff_period').val());
      })
    }

    function display_filtered_data_copy_shift(department, line, group, section) {
      $('#modal_employee_id_group').html('');
      get_filter_data(url_get_filter_data, department, line, group, section).then(function(data) {
        $('#modal_employee_id_group').append(`
          <option value="" disabled>Choose Employee...</option>
        `);
        Array.from(data).forEach(function(x) {
          $('#modal_employee_id_group').append(`
            <option value="` + x.id + `">` + x.col_empl_cmid + ` - ` + x.col_frst_name + ` ` + x.col_last_name + `</option> 
          `);
        })
      })
    }




    // ======================= FILTER BY DEPARTMENT ================================

    $('#filter_by_department').change(function() {
      section = $('#filter_by_section').val();
      department = $(this).val();
      group = $('#filter_by_group').val();
      line = $('#filter_by_line').val();

      display_filtered_data(department, line, group, section);

      get_filter_data(url_get_filter_data_section, department, line, group, section).then(function(data) {
        if (!section) {
          $('#filter_by_section').html('');
          $('#filter_by_section').append(`<option value="">All Sections</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_sect != '') {
            $('#filter_by_section').append(`
                      <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_group, department, line, group, section).then(function(data) {
        if (!group) {
          $('#filter_by_group').html('');
          $('#filter_by_group').append(`<option value="">All Groups</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_group != '') {
            $('#filter_by_group').append(`
                      <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_line, department, line, group, section).then(function(data) {
        if (!line) {
          $('#filter_by_line').html('');
          $('#filter_by_line').append(`<option value="">All Lines</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_line != '') {
            $('#filter_by_line').append(`
                      <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                  `);
          }
        })
      })
    })

    // ======================= FILTER BY SECTION ================================

    $('#filter_by_section').change(function() {
      section = $(this).val();
      department = $('#filter_by_department').val();
      group = $('#filter_by_group').val();
      line = $('#filter_by_line').val();

      display_filtered_data(department, line, group, section);

      get_filter_data(url_get_filter_data_department, department, line, group, section).then(function(data) {
        if (!department) {
          $('#filter_by_department').html('');
          $('#filter_by_department').append(`<option value="">All Departments</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_dept != '') {
            $('#filter_by_department').append(`
                      <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_group, department, line, group, section).then(function(data) {
        if (!group) {
          $('#filter_by_group').html('');
          $('#filter_by_group').append(`<option value="">All Groups</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_group != '') {
            $('#filter_by_group').append(`
                      <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_line, department, line, group, section).then(function(data) {
        if (!line) {
          $('#filter_by_line').html('');
          $('#filter_by_line').append(`<option value="">All Lines</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_line != '') {
            $('#filter_by_line').append(`
                      <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                  `);
          }
        })
      })
    })

    // ======================= FILTER BY Group ================================

    $('#filter_by_group').change(function() {
      section = $('#filter_by_section').val();
      department = $('#filter_by_department').val();
      group = $(this).val();
      line = $('#filter_by_line').val();

      display_filtered_data(department, line, group, section);

      get_filter_data(url_get_filter_data_department, department, line, group, section).then(function(data) {
        if (!department) {
          $('#filter_by_department').html('');
          $('#filter_by_department').append(`<option value="">All Departments</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_dept != '') {
            $('#filter_by_department').append(`
                      <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_section, department, line, group, section).then(function(data) {
        if (!section) {
          $('#filter_by_section').html('');
          $('#filter_by_section').append(`<option value="">All Sections</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_sect != '') {
            $('#filter_by_section').append(`
                      <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_line, department, line, group, section).then(function(data) {
        if (!line) {
          $('#filter_by_line').html('');
          $('#filter_by_line').append(`<option value="">All Lines</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_line != '') {
            $('#filter_by_line').append(`
                      <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                  `);
          }
        })
      })
    })

    // ======================= FILTER BY Line ================================

    $('#filter_by_line').change(function() {
      section = $('#filter_by_section').val();
      department = $('#filter_by_department').val();
      group = $('#filter_by_group').val();
      line = $(this).val();

      display_filtered_data(department, line, group, section);

      get_filter_data(url_get_filter_data_department, department, line, group, section).then(function(data) {
        if (!department) {
          $('#filter_by_department').html('');
          $('#filter_by_department').append(`<option value="">All Departments</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_dept != '') {
            $('#filter_by_department').append(`
                      <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_section, department, line, group, section).then(function(data) {
        if (!section) {
          $('#filter_by_section').html('');
          $('#filter_by_section').append(`<option value="">All Sections</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_sect != '') {
            $('#filter_by_section').append(`
                      <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_group, department, line, group, section).then(function(data) {
        if (!group) {
          $('#filter_by_group').html('');
          $('#filter_by_group').append(`<option value="">All Groups</option>`);
        }

        Array.from(data).forEach(function(x) {
          if (x.col_empl_group != '') {
            $('#filter_by_group').append(`
                      <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                  `);
          }
        })
      })
    })


    // ======================================================== FILTER BY STATUS ================================
    $('#filter_by_status').change(function(e) {
      var status = $(this).val();
      var date_period = $('#cutoff_period').val();
      e.preventDefault();

      if (date_period) {
        if (status == "ready") {
          $('#employee_id').html('');

          get_ready_for_payslip(url_get_ready_for_payslip, date_period).then(function(data) {
            var empl_cmid_arr = data.sort();
            var new_empl_cmid_arr = empl_cmid_arr.map(function(x) {
              return parseInt(x, 10);
            });
            new_empl_cmid_arr.sort(function(a, b) {
              return a - b;
            });
            Array.from(new_empl_cmid_arr).forEach(function(x) {
              var empl_cmid = x;
              get_employee_data_via_cmid(url_get_employee_data_via_cmid, empl_cmid).then(function(data1) {
                data1.forEach(function(y) {
                  $('#employee_id').append(`
                    <option value="` + y.id + `">` + y.col_empl_cmid + ' - ' + y.col_frst_name + ' ' + y.col_last_name + `</option>
                  `)
                })

              })
            })
            setTimeout(() => {
              load_attendance_data($('#employee_id').val(), date_period);
            }, 700);
          })
        } else if (status == "not_ready") {
          $('#employee_id').html('');

          get_not_ready_for_payslip(url_get_not_ready_for_payslip, date_period).then(function(data) {
            var empl_cmid_arr = data.sort();
            var new_empl_cmid_arr = empl_cmid_arr.map(function(x) {
              return parseInt(x, 10);
            });
            new_empl_cmid_arr.sort(function(a, b) {
              return a - b;
            });
            Array.from(new_empl_cmid_arr).forEach(function(x) {
              var empl_cmid = x;
              get_employee_data_via_cmid(url_get_employee_data_via_cmid, empl_cmid).then(function(data1) {
                data1.forEach(function(y) {
                  $('#employee_id').append(`
                    <option value="` + y.id + `">` + y.col_empl_cmid + ' - ' + y.col_frst_name + ' ' + y.col_last_name + `</option>
                  `)
                })

              })
            })
            setTimeout(() => {
              load_attendance_data($('#employee_id').val(), date_period);
            }, 700);
          })
        }
      } else {
        Swal.fire(
          'Please select a Cut-off Period',
          '',
          'warning'
        )
        $('#filter_by_status').html('');
        $('#filter_by_status').append(`
          <option value="">Choose...</option>
          <option value="not_ready">Not Ready for Payslip</option>
          <option value="ready">Ready for Payslip</option>
        `)
      }

    })

    // ========================================== CLEAR FILTER ===============================================
    $('#btn_clear_filter').click(function() {
      $('#filter_by_section').val('');
      $('#filter_by_department').val('');
      $('#filter_by_group').val('');
      $('#filter_by_line').val('');
      $('#filter_by_status').val('');

      $('#employee_id').html('');
      get_all_employee_data(url_get_all_empl_data).then(function(data) {
        $('#employee_id').append(`
          <option value="">Choose Employee...</option>
        `);
        Array.from(data).forEach(function(x) {
          $('#employee_id').append(`
            <option value="` + x.id + `">` + x.col_empl_cmid + ` - ` + x.col_frst_name + ` ` + x.col_last_name + `</option>
          `);
        })
        count_locked_and_not_locked($('#cutoff_period').val());
      })

      get_all_filter_data(url_get_all_filter_data).then(function(data) {

        $('#filter_by_group').html('');
        $('#filter_by_section').html('');
        $('#filter_by_department').html('');
        $('#filter_by_line').html('');
        $('#filter_by_status').html('');

        $('#filter_by_group').append('<option value="">All Groups</option>');
        $('#filter_by_section').append('<option value="">All Sections</option>');
        $('#filter_by_department').append('<option value="">All Departments</option>');
        $('#filter_by_line').append('<option value="">All Lines</option>');
        $('#filter_by_status').append('<option value="">Choose...</option>');

        Array.from(data.DISP_Group).forEach(function(x) {
          if (x.col_empl_group != '') {
            $('#filter_by_group').append(`
                    <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                `)
          }
        })
        Array.from(data.DISP_DISTINCT_SECTION).forEach(function(x) {
          if (x.col_empl_sect != '') {
            $('#filter_by_section').append(`
                    <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                `)
          }
        })
        Array.from(data.DISP_DISTINCT_DEPARTMENT).forEach(function(x) {
          if (x.col_empl_dept != '') {
            $('#filter_by_department').append(`
                    <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                `)
          }
        })
        Array.from(data.DISP_Line).forEach(function(x) {
          if (x.col_empl_line != '') {
            $('#filter_by_line').append(`
                    <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                `)
          }
        })

        $('#filter_by_status').append(`
            <option value="not_ready">Not Ready for Payslip</option>
            <option value="ready">Ready for Payslip</option>
        `)

      })
    })










    /* 
     *
     *
     *   ================================ COPY SHIFT FILTER FOR EMPLOYEES ===========================
     *
     *
     */

    // ======================= FILTER BY DEPARTMENT - COPY SHIFT ================================

    $('#copy_filter_by_department').change(function() {
      section_copy = $('#copy_filter_by_section').val();
      department_copy = $(this).val();
      group_copy = $('#copy_filter_by_group').val();
      line_copy = $('#copy_filter_by_line').val();

      display_filtered_data_copy_shift(department_copy, line_copy, group_copy, section_copy);


      get_filter_data(url_get_filter_data_section, department_copy, line_copy, group_copy, section_copy).then(function(data) {
        if (!section_copy) {
          $('#copy_filter_by_section').html('');
          $('#copy_filter_by_section').append(`<option value="">All Sections</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_sect != '') {
            $('#copy_filter_by_section').append(`
                      <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_group, department_copy, line_copy, group_copy, section_copy).then(function(data) {
        if (!group_copy) {
          $('#copy_filter_by_group').html('');
          $('#copy_filter_by_group').append(`<option value="">All Groups</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_group != '') {
            $('#copy_filter_by_group').append(`
                      <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_line, department_copy, line_copy, group_copy, section_copy).then(function(data) {
        if (!line_copy) {
          $('#copy_filter_by_line').html('');
          $('#copy_filter_by_line').append(`<option value="">All Lines</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_line != '') {
            $('#copy_filter_by_line').append(`
                      <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                  `);
          }
        })
      })
    })

    // ======================= FILTER BY SECTION - COPY SHIFT ================================

    $('#copy_filter_by_section').change(function() {
      section_copy = $(this).val();
      department_copy = $('#copy_filter_by_department').val();
      group_copy = $('#copy_filter_by_group').val();
      line_copy = $('#copy_filter_by_line').val();

      display_filtered_data_copy_shift(department_copy, line_copy, group_copy, section_copy);

      get_filter_data(url_get_filter_data_department, department_copy, line_copy, group_copy, section_copy).then(function(data) {
        if (!department_copy) {
          $('#copy_filter_by_department').html('');
          $('#copy_filter_by_department').append(`<option value="">All Departments</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_dept != '') {
            $('#copy_filter_by_department').append(`
                      <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_group, department_copy, line_copy, group_copy, section_copy).then(function(data) {
        if (!group_copy) {
          $('#copy_filter_by_group').html('');
          $('#copy_filter_by_group').append(`<option value="">All Groups</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_group != '') {
            $('#copy_filter_by_group').append(`
                      <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_line, department_copy, line_copy, group_copy, section_copy).then(function(data) {
        if (!line_copy) {
          $('#copy_filter_by_line').html('');
          $('#copy_filter_by_line').append(`<option value="">All Lines</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_line != '') {
            $('#copy_filter_by_line').append(`
                      <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                  `);
          }
        })
      })
    })

    // ======================= FILTER BY GROUP - COPY SHIFT ================================
    $('#copy_filter_by_group').change(function() {
      section_copy = $('#copy_filter_by_section').val();
      department_copy = $('#copy_filter_by_department').val();
      group_copy = $(this).val();
      line_copy = $('#copy_filter_by_line').val();

      display_filtered_data_copy_shift(department_copy, line_copy, group_copy, section_copy);

      get_filter_data(url_get_filter_data_department, department_copy, line_copy, group_copy, section_copy).then(function(data) {
        if (!department_copy) {
          $('#copy_filter_by_department').html('');
          $('#copy_filter_by_department').append(`<option value="">All Departments</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_dept != '') {
            $('#copy_filter_by_department').append(`
                      <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_section, department_copy, line_copy, group_copy, section_copy).then(function(data) {
        if (!section_copy) {
          $('#copy_filter_by_section').html('');
          $('#copy_filter_by_section').append(`<option value="">All Sections</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_sect != '') {
            $('#copy_filter_by_section').append(`
                      <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_line, department_copy, line_copy, group_copy, section_copy).then(function(data) {
        if (!line_copy) {
          $('#copy_filter_by_line').html('');
          $('#copy_filter_by_line').append(`<option value="">All Lines</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_line != '') {
            $('#copy_filter_by_line').append(`
                      <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                  `);
          }
        })
      })
    })

    // ======================= FILTER BY LINE - COPY SHIFT ================================
    $('#copy_filter_by_line').change(function() {
      section_copy = $('#copy_filter_by_section').val();
      department_copy = $('#copy_filter_by_department').val();
      group_copy = $('#copy_filter_by_group').val();
      line_copy = $(this).val();

      display_filtered_data_copy_shift(department_copy, line_copy, group_copy, section_copy);

      get_filter_data(url_get_filter_data_department, department_copy, line_copy, group_copy, section_copy).then(function(data) {
        if (!department_copy) {
          $('#copy_filter_by_department').html('');
          $('#copy_filter_by_department').append(`<option value="">All Departments</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_dept != '') {
            $('#copy_filter_by_department').append(`
                      <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_section, department_copy, line_copy, group_copy, section_copy).then(function(data) {
        if (!section_copy) {
          $('#copy_filter_by_section').html('');
          $('#copy_filter_by_section').append(`<option value="">All Sections</option>`);
        }
        Array.from(data).forEach(function(x) {
          if (x.col_empl_sect != '') {
            $('#copy_filter_by_section').append(`
                      <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                  `);
          }
        })
      })
      get_filter_data(url_get_filter_data_group, department_copy, line_copy, group_copy, section_copy).then(function(data) {
        if (!group_copy) {
          $('#copy_filter_by_group').html('');
          $('#copy_filter_by_group').append(`<option value="">All Groups</option>`);
        }

        Array.from(data).forEach(function(x) {
          if (x.col_empl_group != '') {
            $('#copy_filter_by_group').append(`
                      <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                  `);
          }
        })
      })
    })


    // ========================================== CLEAR FILTER - COPY SHIFT ===============================================
    $('#btn_copy_clear_filter').click(function() {
      $('#copy_filter_by_section').val('');
      $('#copy_filter_by_department').val('');
      $('#copy_filter_by_group').val('');
      $('#copy_filter_by_line').val('');

      $('#modal_employee_id_group').html('');
      get_all_employee_data(url_get_all_empl_data).then(function(data) {
        $('#modal_employee_id_group').append(`
          <option value="">Choose Employee...</option>
        `);
        Array.from(data).forEach(function(x) {
          $('#modal_employee_id_group').append(`
            <option value="` + x.id + `">` + x.col_empl_cmid + ` - ` + x.col_frst_name + ` ` + x.col_last_name + `</option> 
          `);
        })
      })

      get_all_filter_data(url_get_all_filter_data).then(function(data) {

        $('#copy_filter_by_group').html('');
        $('#copy_filter_by_section').html('');
        $('#copy_filter_by_department').html('');
        $('#copy_filter_by_line').html('');

        $('#copy_filter_by_group').append('<option value="">All Groups</option>');
        $('#copy_filter_by_section').append('<option value="">All Sections</option>');
        $('#copy_filter_by_department').append('<option value="">All Departments</option>');
        $('#copy_filter_by_line').append('<option value="">All Lines</option>');

        Array.from(data.DISP_Group).forEach(function(x) {
          if (x.col_empl_group != '') {
            $('#copy_filter_by_group').append(`
                    <option value="` + x.col_empl_group + `">` + x.col_empl_group + `</option>
                `)
          }
        })
        Array.from(data.DISP_DISTINCT_SECTION).forEach(function(x) {
          if (x.col_empl_sect != '') {
            $('#copy_filter_by_section').append(`
                    <option value="` + x.col_empl_sect + `">` + x.col_empl_sect + `</option>
                `)
          }
        })
        Array.from(data.DISP_DISTINCT_DEPARTMENT).forEach(function(x) {
          if (x.col_empl_dept != '') {
            $('#copy_filter_by_department').append(`
                    <option value="` + x.col_empl_dept + `">` + x.col_empl_dept + `</option>
                `)
          }
        })
        Array.from(data.DISP_Line).forEach(function(x) {
          if (x.col_empl_line != '') {
            $('#copy_filter_by_line').append(`
                    <option value="` + x.col_empl_line + `">` + x.col_empl_line + `</option>
                `)
          }
        })

      })
    })


























    // =========================================== ASYNC FUNCTIONS ==============================================
    async function update_attendance_calculation(url, date, empl_id, status, working_days, no_ti_to, rd_sp, reg_hol, rd_reg, rd_add_sp, abs, tard, ut, nd, reg_ot, ns_ot, leave, half_day, calc_color, appr_nd, appr_reg_ot, appr_ns_ot, rest_ot, rest_nd_ot) {
      var formData = new FormData();
      formData.append('date', date);
      formData.append('empl_id', empl_id);
      formData.append('status', status);
      formData.append('working_days', working_days);
      formData.append('no_ti_to', no_ti_to);
      formData.append('rd_sp', rd_sp);
      formData.append('reg_hol', reg_hol);
      formData.append('rd_reg', rd_reg);
      formData.append('rd_add_sp', rd_add_sp);
      formData.append('abs', abs);
      formData.append('tard', tard);
      formData.append('ut', ut);
      formData.append('nd', nd);
      formData.append('reg_ot', reg_ot);
      formData.append('ns_ot', ns_ot);
      formData.append('leave', leave);
      formData.append('half_day', half_day);
      formData.append('calc_color', calc_color);
      formData.append('appr_nd', appr_nd);
      formData.append('appr_reg_ot', appr_reg_ot);
      formData.append('appr_ns_ot', appr_ns_ot);
      formData.append('rest_ot', rest_ot);
      formData.append('rest_nd_ot', rest_nd_ot);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function update_approve_attendance(url, date, empl_id, isApprove, row_color) {
      var formData = new FormData();
      formData.append('date', date);
      formData.append('empl_id', empl_id);
      formData.append('isApprove', isApprove);
      formData.append('row_color', row_color);
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

    async function get_employee_section_data_filter_by_dept(url, department) {
      var formData = new FormData();
      formData.append('department', department);
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

    async function get_all_employee_data(url) {
      var formData = new FormData();
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_attendance_data_based_id(url, attendance_id) {
      var formData = new FormData();
      formData.append('attendance_id', attendance_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function updt_attendance_time_out_async(
      url,
      att_date,
      att_employee_id,
      time_in,
      time_out,
      status,
      remarks,
      work_days_mul,
      sp_hol_mul,
      reg_hol_mul,
      no_ti_to_mul,
      rest_sp_hol_mul,
      rest_reg_hol_mul,
      absences_mul,
      tard_mul,
      undertime_mul,
      night_diff_mul,
      reg_ot_mul,
      ns_ot_mul,
      leave_mul,
      half_day_mul,
      rest_ot_mul,
      rest_nd_ot_mul,
      manual_color,
      approved_night_diff_mul,
      approved_reg_ot_mul,
      approved_ns_ot_mul,
      shift_id
    ) {
      var formData = new FormData();
      formData.append('att_date', att_date);
      formData.append('att_employee', att_employee_id);
      formData.append('att_time_in', time_in);
      formData.append('att_time_out', time_out);
      formData.append('att_status', status);
      formData.append('att_remarks', remarks);

      formData.append('work_days_mul', work_days_mul);
      formData.append('sp_hol_mul', sp_hol_mul);
      formData.append('reg_hol_mul', reg_hol_mul);
      formData.append('no_ti_to_mul', no_ti_to_mul);
      formData.append('rest_sp_hol_mul', rest_sp_hol_mul);
      formData.append('rest_reg_hol_mul', rest_reg_hol_mul);
      formData.append('absences_mul', absences_mul);
      formData.append('tard_mul', tard_mul);
      formData.append('undertime_mul', undertime_mul);
      formData.append('night_diff_mul', night_diff_mul);
      formData.append('reg_ot_mul', reg_ot_mul);
      formData.append('ns_ot_mul', ns_ot_mul);
      formData.append('leave_mul', leave_mul);
      formData.append('half_day_mul', half_day_mul);
      formData.append('rest_ot_mul', rest_ot_mul);
      formData.append('rest_nd_ot_mul', rest_nd_ot_mul);
      formData.append('manual_color', manual_color);
      formData.append('approved_night_diff_mul', approved_night_diff_mul);
      formData.append('approved_reg_ot_mul', approved_reg_ot_mul);
      formData.append('approved_ns_ot_mul', approved_ns_ot_mul);
      formData.append('shift_id', shift_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });

      return response.json();
    }




    async function get_work_shift_data(url, template_id) {
      var formData = new FormData();
      formData.append('template_id', template_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_cutoff_schedule_data(url, date) {
      var formData = new FormData();
      formData.append('cutoff_date_period', date);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_employee_data(url, employee_id, date_period) {
      var formData = new FormData();
      formData.append('employee_id', employee_id);
      formData.append('date_period', date_period);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_shift_data(url, shift_id) {
      var formData = new FormData();
      formData.append('shift_id', shift_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_holiday_data(url) {
      var formData = new FormData();
      formData.append('shift_id', 'shift');
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_employee_data_via_cmid(url, empl_cmid) {
      var formData = new FormData();
      formData.append('empl_cmid', empl_cmid);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }


    // ======================================== ASYNC SHIFT ADJUSTMENT ========================================
    async function updt_shift_async(url, shift_id, attendance_id) {
      var formData = new FormData();
      formData.append('shift_id', shift_id);
      formData.append('attendance_id', attendance_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_work_shift_data(url, template_id) {
      var formData = new FormData();
      formData.append('template_id', template_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_shift_data(url, shift_id) {
      var formData = new FormData();
      formData.append('shift_id', shift_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }


    // ================================ GET READY FOR PAYSLIP AND NOT READY FOR PAYSLIP ===================================
    async function get_ready_for_payslip(url, date_period) {
      var formData = new FormData();
      formData.append('date_period', date_period);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    async function get_not_ready_for_payslip(url, date_period) {
      var formData = new FormData();
      formData.append('date_period', date_period);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    // ================================ ASYNC FILTER ===================================

    async function get_filter_data(url, department, line, group, section) {
      var formData = new FormData();
      formData.append('department', department);
      formData.append('line', line);
      formData.append('group', group);
      formData.append('section', section);
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
</body>

</html>



<!-- SELECT * FROM `tbl_empl_info` WHERE id='1000004' OR id='1000022' OR id='1134' OR id='1149' OR id='1150' OR id='1270' OR id='1429' -->