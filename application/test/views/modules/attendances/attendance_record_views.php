  <?php $this->load->view('templates/css_link'); 
   $DISP_NAVBAR = $this->header_model->get_navbar();
  ?>
  <style>
    tr.bg-light-regular {
      background-color: #FFFFFF;
    }

    tr.bg-light-rest {
      background-color: #FFF4F2;
    }

    tr.bg-light-legal {
      background-color: #DEF0FE;
    }

    tr.bg-light-special {
      background-color: #F5E9FF;
    }

    @media (max-width: 780px) {
      .shift {
        margin-top: 20px;
      }
    }

    td {
      word-wrap: break-word !important;
      overflow: visible;
    }

    .error {
      padding: 7px;
      text-align: center;
      border: 3px solid red;
      width: 100%;
      height: 50px;
      font-size: 18px;
      color: red;
      font-weight: bold;
      margin: 10px 0;
    }

    .filter_menu_wrap{
      max-height:0;
      width: 100%;
      overflow: hidden;
      transition: max-height 0.5s ease-in-out;
    }

    .filter_menu_wrap.open-filter{
      max-height:100vh;
      width: 100%
    }

    .endorsed-box{
      margin-top: 5px;
      display: flex;
      align-items: center;
      width: 100%;
      background-color: #FFEBEB;
      border-radius: 5px 5px 0 0;
    }

    .endorsed-box-2{
      margin-top: 5px;
      display: flex;
      align-items: center;
      width: 100%;
      background-color: #BFFFD7;
      border-radius: 5px 5px 0 0;
    }

    .endorsed-box span{
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #fff;
      border-radius: 5px;
      width: 30px;
      padding: 2px;
      margin: 0 5px 0 0;
    }

    .endorsed-box-2 span{
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #fff;
      border-radius: 5px;
      width: 30px;
      padding: 2px;
      margin: 0 5px 0 0;
    }
    
    .endorsed-box label{
      display: flex;
      align-items: center;
      background-color: #FFEBEB;
      border: none;
      border-radius: 5px;
      padding: 5px;
      width: 100%;
      margin: 0;
    }

    .endorsed-box-2 label{
      display: flex;
      align-items: center;
      background-color: #BFFFD7;
      border: none;
      border-radius: 5px;
      padding: 5px;
      width: 100%;
      margin: 0;
    }

    .dropdown {
      position: relative;
      z-index: 100;
    }

    .dropdown-button {
      padding: 10px;
      background-color: #f1f1f1;
      border: 1px solid #ccc;
      cursor: pointer;
    }

    .dropdown-list {
      display: none;
      position: absolute;
      background-color: #fff;
      border: 1px solid #ccc;
      list-style: none;
      padding: 0;
      margin: 0;
      width: 100%;
    }

    .dropdown-list li {
      padding: 10px;
      cursor: pointer;
    }

    .dropdown-list li:hover {
      background-color: #f9f9f9;
    }

  </style>

  <body>
    <!-- Content Starts -->
    <div class="content-wrapper">
      <div class="container-fluid p-4">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="<?= base_url() . 'attendances' ?>">Attendance
              </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Attendance Records
            </li>
          </ol>
        </nav>
        <div class="row">
          <!-- Title Text -->
          <div class="col-md-6">
            <h1 class="page-title">Attendance Records</h1>
          </div>
          <!-- Title Button -->
          <div class="col-md-6 button-title">
            <a href="<?= base_url() . 'attendances/attendance_rec_csv'; ?>" class="btn btn-primary shadow-none"><i class="fas fa-file-import"></i>&nbsp;Bulk Import</a>
            <!--<a href="#" id="btn_application" data-toggle="modal" data-target="#modal_attendance_records" class="btn btn-export_pdf btn-primary shadow-none"><i class="fas fa-file-export"></i>Export PDF</a> -->
            <a href="#" id="btn_export" class="btn btn-primary shadow-none"><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>
            <button class='btn-export_pdf btn btn-primary'><i class="fas fa-file-export"></i>&nbsp;Export PDF</button>
          </div>
        </div>
        <hr>
       
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
                  <a class='btn btn-primary text-light' id="btn_exports"><i class="fas fa-file-export"></i> &nbsp; Export CSV
                  </a>
                </div>
              </form>
            </div>
          </div>


          <div class="row mb-3">
            <div class="col-md-2">
              <div class="row">
                <div class="col-md-12 ">
                  <div style="width: 100%;">
                    <p class="text-secondary text-bold" style="font-size: 18px;">Filter Display:</p>
                    <label for="search_employees" style="font-weight: 500">Cut-off Period</label>
                  </div>
                  <div class="flex-fill">
                    <select name="cutoff_period" id="cutoff_period" class="form-control">
                      <?php
                      if ($DISP_PAYROLL_SCHED) {
                        foreach ($DISP_PAYROLL_SCHED as $DISP_PAYROLL_SCHED_ROW) {
                      ?>
                          <option value="<?= $DISP_PAYROLL_SCHED_ROW->id ?>" <?php echo $INI_PAYROLL == $DISP_PAYROLL_SCHED_ROW->id ? 'selected' : '' ?>>
                            <?= $DISP_PAYROLL_SCHED_ROW->name ?>
                          </option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <!--- Not yet endorsed to payroll -->
                <div class="col-md-12 " hidden>
                  <div class="endorsed-box">
                    <label for="search_employees" style="font-weight: 500">Not&nbsp;yet&nbsp;endorsed&nbsp;to&nbsp;payroll&nbsp;</label><span><?=count($DISP_NOT_READY_PAYSLIP)?></span>
                  </div>
                  <div class="flex-fill d-flex">
                    <select name="not_endorsed_payslip" id="not_endorsed_payslip" class="custom-select">
                      <?php
                      if ($DISP_NOT_READY_PAYSLIP) {
                        foreach ($DISP_NOT_READY_PAYSLIP as $NOT_READY_PAYSLIP_ROW) {
                          if ($NOT_READY_PAYSLIP_ROW->col_midl_name) {
                            $midl_ini = $NOT_READY_PAYSLIP_ROW->col_midl_name[0] . '.';
                          } else {
                            $midl_ini = '';
                          }
                      ?>
                          <option value="<?= $NOT_READY_PAYSLIP_ROW->id ?>"  position="<?= $NOT_READY_PAYSLIP_ROW->col_empl_posi ?>" >
                            <?= $NOT_READY_PAYSLIP_ROW->col_empl_cmid . ' - ' . $NOT_READY_PAYSLIP_ROW->col_last_name . ', ' . $NOT_READY_PAYSLIP_ROW->col_frst_name . ' ' . $midl_ini ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <!-- Endorsed to payroll -->
                <div class="col-md-12 " hidden>
                  <div class="endorsed-box-2">
                    <label for="search_employees" style="font-weight: 500">Endorsed&nbsp;to&nbsp;payroll</label><span><?=count($DISP_READY_PAYSLIP)?></span>
                  </div>
                  <div class="flex-fill d-flex">
                    <select name="endorsed_payslip" id="endorsed_payslip" class="custom-select">
                      <?php
                      if ($DISP_READY_PAYSLIP) {
                        foreach ($DISP_READY_PAYSLIP as $DISP_READY_PAYSLIP_ROW) {
                          if ($DISP_READY_PAYSLIP_ROW->col_midl_name) {
                            $midl_ini = $DISP_READY_PAYSLIP_ROW->col_midl_name[0] . '.';
                          } else {
                            $midl_ini = '';
                          }
                      ?>
                          <option value="<?= $DISP_READY_PAYSLIP_ROW->id ?>"  position="<?= $DISP_READY_PAYSLIP_ROW->col_empl_posi ?>" ?>
                            <?= $DISP_READY_PAYSLIP_ROW->col_empl_cmid . ' - ' . $DISP_READY_PAYSLIP_ROW->col_last_name . ', ' . $DISP_READY_PAYSLIP_ROW->col_frst_name . ' ' . $midl_ini ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <!-- <div class="col-md-12 mb-1 mt-2">
                  <div class="endorsed-box" style = "background-color: #FFEBEB !important">
                    <button style = "background-color: #FFEBEB !important">Not yet endorsed to payroll</button> <span>5</span> 
                  </div> 
                </div>  -->


                <div class="col-md-12 ">
                  <div style="width: 100px;">
                    <label for="search_employees" style="font-weight: 500">Employee</label>
                  </div>
                  <div class="flex-fill d-flex">
                    <select name="employee_id" id="employee_id" class="custom-select">
                      <?php
                      if ($DISP_EMP_LIST) {
                        foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) {
                          if ($DISP_EMP_LIST_ROW->col_midl_name) {
                            $midl_ini = $DISP_EMP_LIST_ROW->col_midl_name[0] . '.';
                          } else {
                            $midl_ini = '';
                          }
                      ?>
                          <option value="<?= $DISP_EMP_LIST_ROW->id ?>" <?php echo $INI_EMPL == $DISP_EMP_LIST_ROW->id ? 'selected' : '' ?> position="<?= $DISP_EMP_LIST_ROW->col_empl_posi ?>" group="<?= $DISP_EMP_LIST_ROW->col_empl_group ?>">
                            <?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name . ' ' . $midl_ini ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-12 ">
                  <div style="width: 100px;">
                    <label for="search_employees" style="font-weight: 500">Type:</label>
                  </div>
                  <div class="flex-fill d-flex">
                    <select name="employee_type" id="employee_type" class="custom-select" disabled>
                      
                          <option><?= $SALARY_TYPE ?></option>
                     
                    </select>
                  </div>
                </div>
                
                
                 
                
                <!-- filter_menu_wrap Start  -->
                <!-- <div class="col-md-12 ">
                  <div class="form-control"  style="display: flex; justify-content: space-between; align-items: center;">
                    <button>Not yet endorsed to payroll</button> <span>5</span> 
                  </div>
                </div> -->

                <!-- <div class="col-md-12 ">
                  <div class="flex-fill d-flex">
                    <select name="employee_id" id="employee_id" class="custom-select" >
                      <?php
                      if ($DISP_EMP_LIST) {
                        foreach ($DISP_EMP_LIST as $DISP_EMP_LIST_ROW) {
                          if ($DISP_EMP_LIST_ROW->col_midl_name) {
                            $midl_ini = $DISP_EMP_LIST_ROW->col_midl_name[0] . '.';
                          } else {
                            $midl_ini = '';
                          }
                      ?>
                          <option value="<?= $DISP_EMP_LIST_ROW->id ?>" <?php echo $INI_EMPL == $DISP_EMP_LIST_ROW->id ? 'selected' : '' ?> position="<?= $DISP_EMP_LIST_ROW->col_empl_posi ?>" group="<?= $DISP_EMP_LIST_ROW->col_empl_group ?>">
                            <?= $DISP_EMP_LIST_ROW->col_empl_cmid . ' - ' . $DISP_EMP_LIST_ROW->col_last_name . ', ' . $DISP_EMP_LIST_ROW->col_frst_name . ' ' . $midl_ini ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                    
                  </div>
                  <span>5</span> 
                </div> -->


                <!-- filter_menu_wrap Start  -->
                <div class="col-md-12 ">
                <p class="mb-1  " style="font-weight: 500">Filter</p>
                <button class="form-control" onclick="toggleFilter()" style="display: flex; justify-content: space-between; align-items: center;">Filter by Designation <i class="fa-solid fa-caret-down"></i></button>
                </div>
                
                  
                <div class="filter_menu_wrap" id="filter_menu_wrap"> 
                  <div class="col-md-12 ">
                    <div style="width: 100px;">
                      <label for="search_employees" style="font-weight: 500">Salary Type</label>
                    </div>
                    <div class="flex-fill d-flex">
                      <select name="salary_type" id="salary_type" class="form-control" disabled>
                        <option selected><?= $SALARY_TYPE ?></option>
                      </select>
                      <!-- <button class="btn btn-primary ml-2" id="btn_prev" title="Previous Employee"><i class="fas fa-angle-left"></i></button>
                      <button class="btn btn-primary ml-1" id="btn_next" title="Next Employee"><i class="fas fa-angle-right"></i></button> -->

                    </div>
                  </div>

                  <div class="col-md-12" <?php echo ($DISP_VIEW_DEPARTMENT ? "" : "hidden") ?>>
                    <p class="mb-1  " style="font-weight: 500">Department</p>
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
                            <option value="<?= $DISP_DISTINCT_DEPARTMENT_ROW->id ?>" <?= isset($_GET["dept"]) && $_GET["dept"] == $DISP_DISTINCT_DEPARTMENT_ROW->id ? 'selected' : '' ?>>
                              <?= $DISP_DISTINCT_DEPARTMENT_ROW->name ?>
                            </option>
                      <?php
                          }
                        }
                      }
                      ?>
                    </select>
                  </div>
                  
                  <div class="col-md-12" <?php echo ($DISP_VIEW_BRANCH ? "" : "hidden") ?>>
                    <p class="mb-1  " style="font-weight: 500">Branch</p>
                    <select name="dept" id="filter_by_branch" class="form-control">
                      <?php
                      if ($DISP_DISTINCT_BRANCH) {
                      ?>
                        <option value="all" <?php foreach ($DISP_DISTINCT_BRANCH as $DISP_DISTINCT_BRANCH_ROW_1) {
                                              if ($DISP_DISTINCT_BRANCH_ROW_1->name == '') {
                                                echo 'selected';
                                              }
                                            } ?>>All Branch</option>
                        <?php
                        foreach ($DISP_DISTINCT_BRANCH as $DISP_DISTINCT_BRANCH_ROW) {
                          if ($DISP_DISTINCT_BRANCH_ROW->name != '') {
                        ?>
                            <option value="<?= $DISP_DISTINCT_BRANCH_ROW->id ?>" <?= isset($_GET["branch"]) && $_GET["branch"] == $DISP_DISTINCT_BRANCH_ROW->id ? 'selected' : '' ?>>
                              <?= $DISP_DISTINCT_BRANCH_ROW->name ?>
                            </option>
                      <?php
                          }
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-md-12" <?php echo ($DISP_VIEW_DIVISION ? "" : "hidden") ?>>
                    <p class="mb-1  " style="font-weight: 500">Division</p>
                    <select name="dept" id="filter_by_division" class="form-control">
                      <?php
                      if ($DISP_DISTINCT_DIVISION) {
                      ?>
                        <option value="all" <?php foreach ($DISP_DISTINCT_DIVISION as $DISP_DISTINCT_DIVISION_ROW_1) {
                                              if ($DISP_DISTINCT_DIVISION_ROW_1->name == '') {
                                                echo 'selected';
                                              }
                                            } ?>>All Division</option>
                        <?php
                        foreach ($DISP_DISTINCT_DIVISION as $DISP_DISTINCT_DIVISION_ROW) {
                          if ($DISP_DISTINCT_DIVISION_ROW->name != '') {
                        ?>
                            <option value="<?= $DISP_DISTINCT_DIVISION_ROW->id ?>" <?= isset($_GET["division"]) && $_GET["division"] == $DISP_DISTINCT_DIVISION_ROW->id ? 'selected' : '' ?>>
                              <?= $DISP_DISTINCT_DIVISION_ROW->name ?>
                            </option>
                      <?php
                          }
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-md-12" <?php echo ($DISP_VIEW_TEAM ? "" : "hidden") ?>>
                    <p class="mb-1  " style="font-weight: 500">Team</p>
                    <select name="dept" id="filter_by_team" class="form-control">
                      <?php
                      if ($DISP_DISTINCT_TEAM) {
                      ?>
                        <option value="all" <?php foreach ($DISP_DISTINCT_TEAM as $DISP_DISTINCT_TEAM_ROW_1) {
                                              if ($DISP_DISTINCT_TEAM_ROW_1->name == '') {
                                                echo 'selected';
                                              }
                                            } ?>>All Team</option>
                        <?php
                        foreach ($DISP_DISTINCT_TEAM as $DISP_DISTINCT_TEAM_ROW) {
                          if ($DISP_DISTINCT_TEAM_ROW->name != '') {
                        ?>
                            <option value="<?= $DISP_DISTINCT_TEAM_ROW->id ?>" <?= isset($_GET["team"]) && $_GET["team"] == $DISP_DISTINCT_TEAM_ROW->id ? 'selected' : '' ?>>
                              <?= $DISP_DISTINCT_TEAM_ROW->name ?>
                            </option>
                      <?php
                          }
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-md-12" <?php echo ($DISP_VIEW_SECTION ? "" : "hidden") ?>>
                    <p class="mb-1  " style="font-weight: 500">Section</p>
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
                            <option value="<?= $DISP_DISTINCT_SECTION_ROW->id ?>" <?= isset($_GET["section"]) && $_GET["section"] == $DISP_DISTINCT_SECTION_ROW->id ? 'selected' : "" ?>>
                              <?= $DISP_DISTINCT_SECTION_ROW->name ?>
                            </option>
                      <?php
                          }
                        }
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-12" <?php echo ($DISP_VIEW_GROUP ? "" : "hidden") ?>>
                    <p class="mb-1  " style="font-weight: 500">Group</p>
                    <select name="group" id="filter_by_group" class="form-control">
                      <?php
                      if ($DISP_Group) {
                      ?>
                        <option value="all" <?php foreach ($DISP_Group as $DISP_Group_ROW_1) {
                                              if ($DISP_Group_ROW_1->name == '') {
                                                echo 'selected';
                                              }
                                            } ?>>All Groups</option>
                        <?php
                        foreach ($DISP_Group as $DISP_Group_ROW) {
                          if ($DISP_Group_ROW->name != '') {
                        ?>
                            <option value="<?= $DISP_Group_ROW->id ?>" <?= isset($_GET["group"]) && $_GET["group"] == $DISP_Group_ROW->id ? 'selected' : "" ?>>
                              <?= $DISP_Group_ROW->name ?>
                            </option>
                      <?php
                          }
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-md-12" <?php echo ($DISP_VIEW_LINE ? "" : "hidden") ?>>
                    <p class="mb-1  " style="font-weight: 500">Line</p>
                    <select name="line" id="filter_by_line" class="form-control">
                      <?php
                      if ($DISP_Line) {
                      ?>
                        <option value="all" <?php foreach ($DISP_Line as $DISP_Line_ROW_1) {
                                              if ($DISP_Line_ROW_1->name == '') {
                                                echo 'selected';
                                              }
                                            } ?>>All Lines</option>
                        <?php
                        foreach ($DISP_Line as $DISP_Line_ROW) {
                          if ($DISP_Line_ROW->name != '') {
                        ?>
                            <option value="<?= $DISP_Line_ROW->id ?>" <?= isset($_GET["line"]) && $_GET["line"] == $DISP_Line_ROW->id ? 'selected' : '' ?>><?= $DISP_Line_ROW->name ?></option>
                      <?php
                          }
                        }
                      }
                      ?>
                    </select>
                  </div>



                  <!-- <div class="col-md-12">
                    <p class="mb-1  ">Status</p>
                    <select name="status" id="filter_by_status" class="form-control">
                      <option value="">Choose...</option>
                      <option value="not_ready" <?= isset($_GET['status']) && $_GET['status'] == 'not_ready' ? 'selected' : '' ?>>Not Ready for Payslip</option>
                      <option value="ready" <?= isset($_GET['status']) && $_GET['status'] == 'ready' ? 'selected' : '' ?>>Ready for Payslip</option>
                    </select>
                  </div> -->
                  <div class="col-md-12">
                    <p class="mb-1  " style="font-weight: 500">Action</p>
                    <a href=<?= base_url() . "attendances/attendance_records" ?> id="btn_clear_filter" class="col btn btn-secondary mx-1">Clear Filter</a>
                  </div>

                </div> <!-- filter_menu_warp end -->

                

              </div>

                

            </div>
            <div class="col-md-2">
              <div style="width: 100%;">
                <p class="text-secondary text-bold" style="font-size: 18px;">Summary:</p>
              </div>
              <div class="row">
                <div class="col-md-12 pr-1">
                  <div class="card" style="padding: 0px !important">
                    <div class="card-body p-0" style="padding: 0px !important">
                      <table class="table table-bordered table-sm text-center">
                        <thead>
                          <tr>
                            <th colspan="2">Attendance</th>
                          </tr>
                          <!-- <tr>
                          <th>Item</th>
                          <th>Count</th>
                        </tr> -->
                        </thead>
                        <tbody>
                          <tr class='row-attendance'>
                            <td class="p-1 text-left"  width = '60%'>Present (day/s)</td>
                            <td class='p-1 attendanceData text-right' width = '40%'><?= $SUM_PRESENT ?></td>
                          </tr>
                          <tr class='row-attendance'>
                            <td class="p-1 text-left"  width = '60%'>Absent (hr/s)</td>
                            <td class='p-1 attendanceData text-right' width = '40%'><?= $SUM_ABSENT ?></td>
                          </tr>
                          <tr class='row-attendance'>
                            <td class="p-1 text-left"  width = '60%'>Tardiness (hr/s)</td>
                            <td class='p-1 attendanceData text-right' width = '40%'><?= $SUM_TARDINESS ?></td>
                          </tr>
                          <tr class='row-attendance'>
                            <td class="p-1 text-left"  width = '60%'>Undertime (hr/s)</td>
                            <td class='p-1 attendanceData text-right' width = '40%'><?= $SUM_UNDERTIME ?></td>
                          </tr>
                          <!-- <tr class='row-attendance'>
                          <td class="p-1">Slider (day/s)</td>
                          <td class='attendanceData'><?= $SUM_SLIDER ?></td>
                        </tr> -->
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 pr-1">
                  <div class="card" style="padding: 0px !important">
                    <div class="card-body p-0" style="padding: 0px !important">
                      <table class="table table-bordered table-sm text-center">
                        <thead>
                          <tr>
                            <th colspan="2">Leaves</th>
                          </tr>
                          <!-- <tr>
                        <th>Item</th>
                        <th>Count</th>
                      </tr> -->
                        </thead>
                        <tbody>
                          <tr>
                            <td class="p-1 text-left"  width = '60%'>Paid Leave</td>
                            <td class='p-1 leaveData text-right'  width = '40%'><?= $SUM_PAID_LEAVE ?></td>
                          </tr>
                          <tr>
                            <td class="p-1 text-left"  width = '60%'>Leave without Pay</td>
                            <td class='p-1 leaveData text-right' width = '40%'><?= $SUM_LWOP ?></td>
                          </tr>
                          <tr>
                            <td class="p-1 text-left"  width = '60%'>AWOL</td>
                            <td class='p-1 leaveData text-right' width = '40%'><?= $SUM_AWOL ?></td>
                          </tr>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="card" style="padding: 0px !important">
                    <div class="card-body p-0" style="padding: 0px !important">
                      <table class="table table-bordered table-sm text-center">
                        <thead>
                          <!-- <tr>
                            <th colspan="2">Regular</th>
                          </tr> -->
                          <tr>
                            <th class='p-1' width = '20%'>Type</th>
                            <th class='p-1' width = '20%'>REG</th>
                            <th class='p-1' width = '20%'>OT</th>
                            <th class='p-1' width = '20%'>ND</th>
                            <th class='p-1' width = '20%'>NDOT</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class='p-1 regDayData text-left'>REG</td>
                            <td class='p-1 regDayData'><?= $SUM_REG_HOURS ?></td>
                            <td class='p-1 regDayData'><?= $SUM_REG_OT ?></td>
                            <td class='p-1 regDayData'><?= $SUM_REG_ND ?></td>
                            <td class='p-1 regDayData'><?= $SUM_REG_NDOT ?></td>
                          </tr>
                          <tr>
                            <td class='p-1 regDayData text-left'>RST</td>
                            <td class='p-1 regDayData'><?= $SUM_REST_HOURS ?></td>
                            <td class='p-1 regDayData'><?= $SUM_REST_OT ?></td>
                            <td class='p-1 regDayData'><?= $SUM_REST_ND ?></td>
                            <td class='p-1 regDayData'><?= $SUM_REST_NDOT ?></td>
                          </tr>
                          <tr>
                            <td class='p-1 regDayData text-left'>LEG</td>
                            <td class='p-1 regDayData'><?= $SUM_LEG_HOURS ?></td>
                            <td class='p-1 regDayData'><?= $SUM_LEG_OT ?></td>
                            <td class='p-1 regDayData'><?= $SUM_LEG_ND ?></td>
                            <td class='p-1 regDayData'><?= $SUM_LEG_NDOT ?></td>
                          </tr>
                          <tr>
                            <td class='p-1 regDayData text-left'>RST+LEG</td>
                            <td class='p-1 regDayData'><?= $SUM_LEGREST_HOURS ?></td>
                            <td class='p-1 regDayData'><?= $SUM_LEGREST_OT ?></td>
                            <td class='p-1 regDayData'><?= $SUM_LEGREST_ND ?></td>
                            <td class='p-1 regDayData'><?= $SUM_LEGREST_NDOT ?></td>
                          </tr>
                          <tr>
                            <td class='p-1 regDayData text-left'>SPE </td>
                            <td class='p-1 regDayData'><?= $SUM_SPE_HOURS ?></td>
                            <td class='p-1 regDayData'><?= $SUM_SPE_OT ?></td>
                            <td class='p-1 regDayData'><?= $SUM_SPE_ND ?></td>
                            <td class='p-1 regDayData'><?= $SUM_SPE_NDOT ?></td>
                          </tr>
                     
                          <tr>
                            <td class='p-1 regDayData text-left'>RST+SPE</td>
                            <td class='p-1 regDayData'><?= $SUM_SPEREST_HOURS ?></td>
                            <td class='p-1 regDayData'><?= $SUM_SPEREST_OT ?></td>
                            <td class='p-1 regDayData'><?= $SUM_SPEREST_ND ?></td>
                            <td class='p-1 regDayData'><?= $SUM_SPEREST_NDOT ?></td>
                          </tr> 
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
             

              </div>
            </div>
            <div class="col-md-8">
              <!-- <div style="width: 100%;">
                <p class="text-secondary text-bold" style="font-size: 18px;">Attendance Record:</p>

              </div> -->
              <div class="row">
                <div class="col-md-4">
                <p class="text-secondary text-bold" style="font-size: 18px;">Attendance Record:</p>
                <!-- <button type="submit" class='btn btn-success text-light ml-2' id="endorse_to_payroll" <?php echo ($ERROR_SHIFT_ASSIGN ? 'disabled' : 'enabled')  ?>><i class="fa-duotone fa-arrow-right-to-arc"></i>&nbsp;Endorse to Payroll</button> -->
                </div>
                <div class="col-md-8 ">
                    <button style="float: right;" type="submit" class='btn <?php echo ($ERROR_SHIFT_ASSIGN ? 'btn-dark' : 'btn-success')  ?> text-light ml-2' id="endorse_to_payroll" <?php echo ($ERROR_SHIFT_ASSIGN ? 'disabled' : 'enabled')  ?>><i class="fa-duotone fa-arrow-right-to-arc"></i>&nbsp;Endorse to Payroll</button>
                  
                </div>
              </div>
              <div class="card mt-2">
                <div class="table-responsive" style = "min-height: 70vh !important">
                  <table class="table table-bordered table-xs mb-0 hover-highlight" id="TableToExport" >
                    <thead>
                    <tr style = "line-height: 7px">
                          <th rowspan = "3" style="text-align: center">Date</th>
                          <th rowspan = "3" style="text-align: center">Day&nbsp;Code</th>
                          <th rowspan = "3" style="text-align: center">Shift&nbsp;Code</th>
                          <th colspan = "6" style="text-align: center">Shift Time</th>
                          <th colspan = "4" style="text-align: center">Actual Time</th>
                          <th rowspan = "3" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">REG</th>
                          <th rowspan = "3" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">ND</th>

                          <th rowspan = "2" colspan = "2" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">SHIFT</th>
                          <th rowspan = "2" colspan = "2" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">APPRV</th>
                          <!-- <th rowspan = "3" style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">NDOT</th> -->
                          <th rowspan = "2" colspan = "3" style="text-align: center">Absences</th>
                          <th rowspan = "2" colspan = "4" style="text-align: center">Deductions</th>
                          <th rowspan = "3" style="min-width: 100px !important">Remarks</th>
                          <!-- <th rowspan = "2">Date</th> -->
                      </tr>
                      <tr style = "line-height: 7px">
                     
                          <th colspan = "2" style="text-align: center">Regular</th>
                          <th colspan = "2" style="text-align: center">Break</th>
                          <th colspan = "2" style="text-align: center">Overtime</th>
                          <th colspan = "2" style="text-align: center">Regular</th>
                          <th colspan = "2" style="text-align: center">Break</th>
                          <!-- <th rowspan = "2">Date</th> -->
                      </tr>
                      <tr style = "line-height: 7px">
                        <!-- <th style="min-width: 130px !important; padding-left: 0px;padding-right: 0px; text-align: center">Date</th> -->
                        <!-- <th style="min-width: 80px  !important; padding-left: 0px;padding-right: 0px; text-align: center">Day&nbsp;Code</th> -->
                        <!-- <th style="min-width: 80px !important; padding-left: 0px;padding-right: 0px; text-align: center">Shift</th> -->
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">IN</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OUT</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">IN</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OUT</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">IN</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OUT</th>

                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">IN</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OUT</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">IN</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center">OUT</th>
                       
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">OT</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">NDOT</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">OT</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">NDOT</th>
                        <!-- <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">REG</th> -->
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #DAFFDA">PAID</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #FFDADA">LWOP</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #FFDADA">AWOL</th>
                    
                        <!-- <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #FFDADA">ABS</th> -->
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #FFDADA">TARD</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #FFDADA">UT</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #FFDADA">EARB</th>
                        <th style="min-width: 50px  !important; padding-left: 0px;padding-right: 0px; text-align: center;  background-color: #FFDADA">OVRB</th>
                        
                
                       
                      </tr>
                    </thead>
                    <tbody id="cutoff_container">
                      <?php foreach ($DATE_RANGE as $date) {

                        if ($date['holi_type'] == 'REGULAR' && $date['shift'] != "REST") {
                          $row_color = 'bg-light-regular';
                        } elseif ($date['holi_type'] == 'REGULAR' && $date['shift'] == "REST") {
                          $row_color = 'bg-light-rest';
                        } elseif ($date['holi_type'] == 'LEGAL' && $date['shift'] != "REST") {
                          $row_color = 'bg-light-legal';
                        } elseif ($date['holi_type'] == 'LEGAL' && $date['shift'] == "REST") {
                          $row_color = 'bg-light-legal';
                        } elseif ($date['holi_type'] == 'SPECIAL' && $date['shift'] != "REST") {
                          $row_color = 'bg-light-special';
                        } elseif ($date['holi_type'] == 'SPECIAL' && $date['shift'] == "REST") {
                          $row_color = 'bg-light-special';
                        }


                      ?>
                        <tr class="<?= $row_color ?> cutoff">
                          <td><?= $date["Date"] ?></td>
                          <td hidden><?= $date["Date_PDF"] ?></td>
                          <td><?= $date['holi_type'] ?></td>
                          <td><?php 
                          
                          if($date['shift']!="-"){
                            echo $date['shift'];
                          }
                          else{
                            echo '<i class="fa-duotone fa-circle-exclamation fa-xl" style="--fa-primary-color: #ff0000; --fa-secondary-color: #ff0000;"></i>&nbsp;No assigned Shift';
                          
                          }
                          
                          
                          
                          ?></td>
                          <!-- <td hidden><?= $date["shift_PDF"] ?></td> -->
                          <td><?= $date['shift_regular_start'] ?></td>
                          <td><?= $date['shift_regular_end'] ?></td>
                          <td><?= $date['shift_break_start'] ?></td>
                          <td><?= $date['shift_break_end'] ?></td>
                          <td><?= $date['shift_overtime_start'] ?></td>
                          <td><?= $date['shift_overtime_end'] ?></td>


                          <td><?= $date['time_in'] ?></td>
                          <td><?= $date['time_out'] ?></td>
                          <td><?= $date['break_in'] ?></td>
                          <td><?= $date['break_out'] ?></td>
                       
                          <td><?= $date['reg_hrs'] ?></td>
                          <td><?= $date['nd'] ?></td>
                          <td><?= $date['reg_ot'] ?></td>
                          <td><?= $date['nd_ot'] ?></td>
                          <td><?= $date['reg_ot'] ?></td>
                          <td><?= $date['nd_ot'] ?></td>
                          <td><?= $date['paid_leave'] ?></td>
                          <td><?= $date['lwop'] ?></td>
                          <td><?= $date['awol'] ?></td>
                          <td><?= $date['tardiness'] ?></td>
                          <td><?= $date['undertime'] ?></td>
                          <td><?= $date['earlybreak'] ?></td>
                          <td><?= $date['overbreak'] ?></td>
                
                  
                          <td><?= $date['remarks'] ?></td>
                        </tr>
                      <?php } ?>
                      <!-- Message if no entries -->
                    </tbody>
                  </table>


                </div>
              </div>
              <div class="alert alert-light" disabled role="alert" <?php echo ($ERROR_SHIFT_ASSIGN ? '' : 'hidden')  ?> style="float: left;">
                <i class="fa-duotone fa-circle-exclamation fa-beat-fade fa-xl" style="--fa-primary-color: #ff0000; --fa-secondary-color: #ff0000;"></i>&nbsp; Please complete the Shift Assignment&nbsp;<a class="alert-link" href="<?= base_url()?>/attendances/shift_assignment?period=<?= $INI_PAYROLL ?>"> Goto Shift Assignment </a>
              </div>
              <div class="ml-2 alert alert-light" disabled role="alert" <?php echo ($DISP_LOCK_DATA ? '' : 'hidden')  ?> style="float: left;">
                <i class="fa-duotone fa-circle-check fa-bounce fa-xl" style="--fa-primary-color: #008f18; --fa-secondary-color: #00ff4c;"></i>&nbsp; Endorsed to Payroll
              </div>
              <div class="ml-2 alert alert-light" disabled role="alert" <?php echo (!$DISP_LOCK_DATA ? '' : 'hidden')  ?> style="float: left;">
              <i class="fa-duotone fa-circle-info fa-xl"></i>&nbsp; Not yet Endorsed to Payroll
              </div>
              <div class="ml-2 alert alert-light" disabled role="alert" <?php echo ($DISP_PAYSLIP_DATA ? '' : 'hidden')  ?> style="float: left;">
                <i class="fa-duotone fa-file-invoice fa-beat fa-xl" style="--fa-primary-color: #008f18; --fa-secondary-color: #00ff4c;"></i>&nbsp; Payslip Generated
              </div>
              <div class="ml-2 alert alert-light" disabled role="alert" <?php echo ($DISP_LEAVE_DATA ? '' : 'hidden')  ?> style="float: left;">
             <i class="fa-duotone fa-brake-warning fa-beat-fade fa-xl" style="--fa-primary-color: #ffa200; --fa-secondary-color: #ffbb00;"></i>&nbsp; Pending Leave Approval
              </div>
              <div class="ml-2 alert alert-light" disabled role="alert" <?php echo ($DISP_TIME_DATA ? '' : 'hidden')  ?> style="float: left;">
             <i class="fa-duotone fa-brake-warning fa-beat-fade fa-xl" style="--fa-primary-color: #ffa200; --fa-secondary-color: #ffbb00;"></i>&nbsp; Pending Time Adjustment Approval
              </div>
              <div class="ml-2 alert alert-light" disabled role="alert" <?php echo ($DISP_OVERTIME_DATA ? '' : 'hidden')  ?> style="float: left;">
             <i class="fa-duotone fa-brake-warning fa-beat-fade fa-xl" style="--fa-primary-color: #ffa200; --fa-secondary-color: #ffbb00;"></i>&nbsp; Pending Overtime Approval
              </div>
              <div class="ml-2 alert alert-light" disabled role="alert" <?php echo ($DISP_HOLIDAY_DATA ? '' : 'hidden')  ?> style="float: left;">
             <i class="fa-duotone fa-brake-warning fa-beat-fade fa-xl" style="--fa-primary-color: #ffa200; --fa-secondary-color: #ffbb00;"></i>&nbsp; Pending Holiday Work Approval
              </div>
            </div>
          </div>






          <!-- /.card -->


          <form action="<?php echo base_url() . "attendances/attendance_lock"; ?>" id="send_endorse_to_payroll" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
            <input type="hidden" name="EMPL_ID" id="EMPL_ID" value=<?= $INI_EMPL ?>> <!-- $DISP_EMP_LIST_ROW->id -->
            <input type="hidden" name="PAYROLL_SCHED" id="PAYROLL_SCHED" value=<?= $INI_PAYROLL ?>>

            <input type="hidden" name="SUM_PRESENT" id="SUM_PRESENT" value=<?= $SUM_PRESENT ?>>
            <input type="hidden" name="SUM_ABSENT" id="SUM_ABSENT" value=<?= $SUM_ABSENT ?>>
            <input type="hidden" name="SUM_TARDINESS" id="SUM_TARDINESS" value=<?= $SUM_TARDINESS ?>>
            <input type="hidden" name="SUM_UNDERTIME" id="SUM_UNDERTIME" value=<?= $SUM_UNDERTIME ?>>
            <input type="hidden" name="SUM_PAID_LEAVE" id="SUM_PAID_LEAVE" value=<?= $SUM_PAID_LEAVE ?>>
            <input type="hidden" name="SUM_REG_HOURS" id="SUM_REG_HOURS" value=<?= $SUM_REG_HOURS ?>>
            <input type="hidden" name="SUM_REG_OT" id="SUM_REG_OT" value=<?= $SUM_REG_OT ?>>
            <input type="hidden" name="SUM_REG_ND" id="SUM_REG_ND" value=<?= $SUM_REG_ND ?>>
            <input type="hidden" name="SUM_REG_NDOT" id="SUM_REG_NDOT" value=<?= $SUM_REG_NDOT ?>>
            <input type="hidden" name="SUM_REST_HOURS" id="SUM_REST_HOURS" value=<?= $SUM_REST_HOURS ?>>
            <input type="hidden" name="SUM_REST_OT" id="SUM_REST_OT" value=<?= $SUM_REST_OT ?>>
            <input type="hidden" name="SUM_REST_ND" id="SUM_REST_ND" value=<?= $SUM_REST_ND ?>>
            <input type="hidden" name="SUM_REST_NDOT" id="SUM_REST_NDOT" value=<?= $SUM_REST_NDOT ?>>
            <input type="hidden" name="SUM_LEG_HOURS" id="SUM_LEG_HOURS" value=<?= $SUM_LEG_HOURS ?>>
            <input type="hidden" name="SUM_LEG_OT" id="SUM_LEG_OT" value=<?= $SUM_LEG_OT ?>>
            <input type="hidden" name="SUM_LEG_ND" id="SUM_LEG_ND" value=<?= $SUM_LEG_ND ?>>
            <input type="hidden" name="SUM_LEG_NDOT" id="SUM_LEG_NDOT" value=<?= $SUM_LEG_NDOT ?>>
            <input type="hidden" name="SUM_LEGREST_HOURS" id="SUM_LEGREST_HOURS" value=<?= $SUM_LEGREST_HOURS ?>>
            <input type="hidden" name="SUM_LEGREST_OT" id="SUM_LEGREST_OT" value=<?= $SUM_LEGREST_OT ?>>
            <input type="hidden" name="SUM_LEGREST_ND" id="SUM_LEGREST_ND" value=<?= $SUM_LEGREST_ND ?>>
            <input type="hidden" name="SUM_LEGREST_NDOT" id="SUM_LEGREST_NDOT" value=<?= $SUM_LEGREST_NDOT ?>>
            <input type="hidden" name="SUM_SPE_HOURS" id="SUM_SPE_HOURS" value=<?= $SUM_SPE_HOURS ?>>
            <input type="hidden" name="SUM_SPE_OT" id="SUM_SPE_OT" value=<?= $SUM_SPE_OT ?>>
            <input type="hidden" name="SUM_SPE_ND" id="SUM_SPE_ND" value=<?= $SUM_SPE_ND ?>>
            <input type="hidden" name="SUM_SPE_NDOT" id="SUM_SPE_NDOT" value=<?= $SUM_SPE_NDOT ?>>
            <input type="hidden" name="SUM_SPEREST_HOURS" id="SUM_SPEREST_HOURS" value=<?= $SUM_SPEREST_HOURS ?>>
            <input type="hidden" name="SUM_SPEREST_OT" id="SUM_SPEREST_OT" value=<?= $SUM_SPEREST_OT ?>>
            <input type="hidden" name="SUM_SPEREST_ND" id="SUM_SPEREST_ND" value=<?= $SUM_SPEREST_ND ?>>
            <input type="hidden" name="SUM_SPEREST_NDOT" id="SUM_SPEREST_NDOT" value=<?= $SUM_SPEREST_NDOT ?>>


            <!-- <button type="submit" class='btn btn-primary text-light' id="endorse_to_payroll">Endorse to Payroll</button> -->

          </form>
        </div><!--End fluid-->
      </div>
    </div>
    <!-- /.control-sidebar -->

    <!-- jQuery -->
    <?php $this->load->view('templates/jquery_link'); ?>



    <!-- SESSION MESSAGES -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>


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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
      $(document).ready(function() {
        var base_url = '<?= base_url(); ?>';
        $('#employee_id').select2(); // to add search feature when selecting
        $('#endorsed_payslip').select2();
        $('#not_endorsed_payslip').select2();
        
        
        // $('#employee_id').select2({
        //   dropdownAutoWidth: true
        // });
        // $('#employee_id').select2('open');

        function writeData(doc, xAxis, yAxis, className) {
          $(className).each(function() {
            doc.text(xAxis, yAxis, $(this).text());
            yAxis += 3.5
          });
        }
        async function getData() {
          console.log('<?= base_url() ?>attendances/getEmployee/' + $('#employee_id').val())
          try {
            const data = await $.ajax({
              url: '<?= base_url() ?>attendances/getEmployee/' + $('#employee_id').val(),
              method: 'GET',
              dataType: 'json'
            });
            return data;
          } catch (error) {
            console.error(error);
          }
        }

        function writeText(doc, x, y, text) {
          if (!text) {
            text = '';
          }
          doc.text(x, y, text);
        }
        $(".btn-export_pdf").on("click", function() {

          getData().then((res) => {
            // console.log(res);
            var employeeInfo = res[0];
            var imgData = "<?= base64_encode(file_get_contents(base_url('assets_system/images/'.$DISP_NAVBAR['value']))) ?>"
            var pdfImage = "<?= base64_encode(file_get_contents(base_url('assets_system/forms/attendance_summary_new.jpg'))) ?>"
            var doc = new jsPDF("p", "mm", "a4");
            var width = doc.internal.pageSize.width;
            var height = doc.internal.pageSize.height;
            var dateData = "<?= date("Y-m-d") ?>";


            var xAjustment = 8;
            doc.setFontSize(40)
            doc.addImage("data:image/jpg;base64," + pdfImage, 'JPG', 0, 0, width, height)
            doc.addImage("data:image/png;base64," + imgData, 'PNG', 10, 10, 60, 0)
            // HEADER LEFT
            // attendance table
            doc.setFontSize(7)
            writeText(doc, 50, 43, dateData)
            writeText(doc, 50, 43, dateData);
            writeText(doc, 50, 46, employeeInfo.lastname + ' ' + employeeInfo.firstname + ', ' + employeeInfo.middlename);
            writeText(doc, 50, 49.5, employeeInfo.position);
            writeText(doc, 50, 53, employeeInfo.salary_type);
            // HEADER RIGHT
            writeText(doc, 137, 43, $('#cutoff_period option:selected').text().trim());
            writeText(doc, 137, 46, employeeInfo.department);
            writeText(doc, 137, 49.5, employeeInfo.project_name);
            writeText(doc, 137, 53, employeeInfo.empl_group);

            writeData(doc, 40, 63, '.attendanceData')
            // writeData(doc, 85, 63, '.regDayData')
            writeData(doc, 127, 63, '.legalDayData')
            writeData(doc, 171, 63, '.restLegalData')
            writeData(doc, 171, 87, '.leaveData')
            writeData(doc, 85, 83.5, '.restDayData')
            writeData(doc, 127, 83.5, '.specialData')
            writeData(doc, 171, 83.5, '.restSpecialData')
            let yAxis = 105;
            Array.from($('.cutoff')).forEach(function(row) {
              doc.text(19, yAxis, $(row).children()[1].innerText)
              doc.text(39, yAxis, $(row).children()[2].innerText)
              doc.text(55, yAxis, $(row).children()[4].innerText)
              doc.text(78.5, yAxis, $(row).children()[5].innerText)
              doc.text(86.5, yAxis, $(row).children()[6].innerText)
              doc.text(94.5, yAxis, $(row).children()[7].innerText)
              doc.text(102.5, yAxis, $(row).children()[8].innerText)
              doc.text(110.5, yAxis, $(row).children()[9].innerText)
              doc.text(118.5, yAxis, $(row).children()[10].innerText)
              doc.text(126.5, yAxis, $(row).children()[11].innerText)
              doc.text(134.5, yAxis, $(row).children()[12].innerText)
              doc.text(142.5, yAxis, $(row).children()[13].innerText)
              doc.text(150.5, yAxis, $(row).children()[14].innerText)
              doc.text(158.5, yAxis, $(row).children()[15].innerText)
              doc.text(166.5, yAxis, $(row).children()[16].innerText)
              doc.text(174.5, yAxis, $(row).children()[17].innerText)
              yAxis += 5.41
            })
            window.open(doc.output('bloburl'), '_blank');
          })


        });

        $("#btn_apply_filter").on("click", function() {
          filter_data();
        })

        function reformatDate(date) {
          var dateString = date;
          var dateObject = new Date(dateString);
          var formattedDate = dateObject.toLocaleString('default', {
            month: 'short',
            day: 'numeric'
          });
          return formattedDate;
        }
        $("#filter_by_department").on("change", function() {
          filter_data();
        })
        $("#filter_by_branch").on("change", function() {
          filter_data();
        })
        $("#filter_by_division").on("change", function() {
          filter_data();
        })
        $("#filter_by_team").on("change", function() {
          filter_data();
        })
        $("#filter_by_section").on("change", function() {
          filter_data();
        })
        $("#filter_by_group").on("change", function() {
          filter_data();
        })
        $("#filter_by_line").on("change", function() {
          filter_data();
        })
        $("#filter_by_status").on("change", function() {
          filter_data();
        })
        $("#cutoff_period").on("change", function() {
          filter_data();
        })
        $("#employee_id").on("change", function() {
          filter_data();
        })

        $('#endorse_to_payroll').click(function() {
          $("#send_endorse_to_payroll").submit();
        })


        $('#btn_prev').click(function() {
          var prev_option = $('#employee_id option:selected').prev();
          var element_value = $(prev_option).attr('value');
          if (element_value) {
            $('#employee_id').val(element_value);
            $('#btn_next').prop('disabled', false);
          } else {
            $(this).prop('disabled', true);
          }

          filter_data();
        })
        $('#btn_next').click(function() {
          var next_option = $('#employee_id option:selected').next();
          var element_value = $(next_option).attr('value');
          if (element_value) {
            $('#employee_id').val(element_value);
            $('#btn_prev').prop('disabled', false);
          } else {
            $(this).prop('disabled', true);
          }

          filter_data();
        })

        function filter_data() {
          let team = $("#filter_by_team").find(":selected").val();
          let division = $("#filter_by_division").find(":selected").val();
          let branch = $("#filter_by_branch").find(":selected").val();
          let department = $("#filter_by_department").find(":selected").val();
          let section = $("#filter_by_section").find(":selected").val();
          let group = $("#filter_by_group").find(":selected").val();
          let line = $("#filter_by_line").find(":selected").val();
          let status = $("#filter_by_status").find(":selected").val();
          let cut_off = $("#cutoff_period").find(":selected").val();
          let employee = $("#employee_id").find(":selected").val();


          window.location = base_url + "attendances/attendance_records?dept=" + department + "&branch=" + branch + "&division=" + division + "&team=" + team + "&section=" + section + "&group=" + group + "&line=" + line + "&status=" + status +
            "&period=" + cut_off + "&employee=" + employee;
        }

      })


      let filter_menu_wrap = document.getElementById("filter_menu_wrap");
      function toggleFilter(){
        filter_menu_wrap.classList.toggle("open-filter");
      }

      function toggleDropdown() {
        var dropdownList = document.getElementById("myDropdown");
        dropdownList.style.display = dropdownList.style.display === "block" ? "none" : "block";
      }

      function selectItem(item) {
        var dropdownButton = document.querySelector(".dropdown-button");
        dropdownButton.textContent = item;
        toggleDropdown();
      }

    </script>

    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script>
      document.getElementById("btn_export").addEventListener('click', function() {
        /* Create worksheet from HTML DOM TABLE */
        var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
        /* Export to file (start a download) */
        XLSX.writeFile(wb, "Attendance Record.xlsx");
      });
    </script>
  </body>

  </html>
  <!-- SELECT * FROM `tbl_empl_info` WHERE id='1000004' OR id='1000022' OR id='1134' OR id='1149' OR id='1150' OR id='1270' OR id='1429' -->