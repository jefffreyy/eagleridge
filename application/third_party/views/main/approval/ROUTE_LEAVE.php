<style>
  div.dataTables_wrapper div.dataTables_paginate {
    display: flex;
  }

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
    font-size: 11.5px !important;
    border: none !important;
  }

  label.required::after {
    content: " *";
    color: red;
  }

  /* .ot_adj_tab{
    border: none !important;
    box-shadow: none;
    background-color: transparent !important;
    color: #0D74BC;

  }
  .ot_adj_tab:hover{
    background-color: #ccc !important;
    color: white !important;
  } */
</style>

<?php

$approver_id = '';
if (count($DISP_APPROVER) > 0) {
  foreach ($DISP_APPROVER as $DISP_APPROVER_ROW) {
    $approver_id = $DISP_APPROVER_ROW->id;
  }
}

?>


<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Pagination -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">
<!-- Datatables -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row">
      <div class="col-md-6">
        <h1 class="page-title">Approval Route - Leave</h1>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="#" style="width: 200px;" class="btn btn-primary shadow-none">Leave</a>
        <a href="<?= base_url() ?>approval/approval_route_ot_adj" style="width: 200px;" class="btn btn-primary shadow-none">Overtime / Time Adjustment</a>
      </div>

    </div>
    <hr>
    <div class="col-6" style="text-align: left;">
      <a href="#" class="btn btn-primary text-white mt-2" id="GROUP_APPROVAL_UPDT" approval_id="<?php if ($approver_id) {
                                                                                                  echo $approver_id;
                                                                                                }  ?>" data-toggle="modal" data-target="#modal_groups_approver">Group Approvers</a>
      <a href="#" class="btn btn-primary text-white mt-2" id="APPROVAL_UPDT" approval_id="<?php if ($approver_id) {
                                                                                            echo $approver_id;
                                                                                          }  ?>" data-toggle="modal" data-target="#modal_assign_approver">Update Approvers</a>
    </div>
  </div>

  <div class="card p-4 tab-pane active" id="for_approval" style="border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
    <table class="table table-hover table-xs mb-0" id="for_approval_tbl">
      <thead>
        <tr>
          <th rowspan="2" class="text-center" style="vertical-align: middle; border-bottom: 1px solid #e1e1e1 !important;">Employee ID</th>
          <th rowspan="2" class="text-center" style="width: 280px !important; vertical-align: middle; border-left: 1px solid #e1e1e1 !important; border-bottom: 1px solid #e1e1e1 !important;">Employee</th>
          <th rowspan="2" class="text-center" style="width: 150px !important; vertical-align: middle; border-left: 1px solid #e1e1e1 !important; border-bottom: 1px solid #e1e1e1 !important;">Group</th>
          <th colspan="2" class="text-center" style="border-bottom: 1px solid #e1e1e1 !important; border-left: 1px solid #e1e1e1 !important;">Approver 1</th>
          <th colspan="3" class="text-center" style="border-bottom: 1px solid #e1e1e1 !important; border-left: 1px solid #e1e1e1 !important;">Approver 2</th>
          <th colspan="2" class="text-center" style="border-bottom: 1px solid #e1e1e1 !important; border-left: 1px solid #e1e1e1 !important;">Approver 3 (Staff Only)</th>
          <!-- <th rowspan="2" class="text-center" style="vertical-align: middle; border-bottom: 1px solid #e1e1e1 !important;">Action</th> -->
        </tr>
        <tr>
          <th class="text-center" style="border: 1px solid #e1e1e1 !important;">Approver A</th>
          <th class="text-center" style="border: 1px solid #e1e1e1 !important;">Approver B</th>
          <th class="text-center" style="border: 1px solid #e1e1e1 !important;">Approver A</th>
          <th class="text-center" style="border: 1px solid #e1e1e1 !important;">Approver B</th>
          <th class="text-center" style="border: 1px solid #e1e1e1 !important;">Approver C</th>
          <th class="text-center" style="border: 1px solid #e1e1e1 !important;">Approver A</th>
          <th class="text-center" style="border-bottom: 1px solid #e1e1e1 !important;">Approver B</th>
          <!-- <th class="text-center" ></th> -->
        </tr>
      </thead>
      <tbody style="font-weight: 500 !important;" id="tbl_application_container">
        <?php

        if ($DISP_EMPLOYEES) {
          foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {

            $empl_cmid = $DISP_EMPLOYEES_ROW->col_empl_cmid;
            $empl_id = $DISP_EMPLOYEES_ROW->id;
            $empl_firstname = $DISP_EMPLOYEES_ROW->col_frst_name;
            $empl_lastname = $DISP_EMPLOYEES_ROW->col_last_name;
            if (!empty($DISP_EMPLOYEES_ROW->col_midl_name)) {
              $empl_initials = $DISP_EMPLOYEES_ROW->col_midl_name[0] . '.';
            } else {
              $empl_initials = '';
            }

            $empl_group = 'No Group';
            if ($DISP_EMPLOYEES_ROW->col_empl_group) {
              $empl_group = $DISP_EMPLOYEES_ROW->col_empl_group;
            }


            $empl_img = '';
            if ($DISP_EMPLOYEES_ROW->col_imag_path) {
              $empl_img = $DISP_EMPLOYEES_ROW->col_imag_path;
            } else {
              $empl_img = 'default_profile_img3.png';
            }

            $group_approver_data = $this->approval_route_mod->MOD_DISP_GROUP_APPROVERS($empl_group);

            $approver1 = '';
            $approver2 = '';

            if ($group_approver_data) {
              $approver1 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($group_approver_data[0]->approver1);
              $approver2 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($group_approver_data[0]->approver2);
            }

            $approver3 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER[0]->approver3);
            $approver4 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER[0]->approver4);
            $approver5 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER[0]->approver5);
            $approver6 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER[0]->approver6);
            $approver7 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER[0]->approver7);

            $appr1_id = '';
            $appr1_firstname = '';
            $appr1_lastname = '';
            $appr1_initials = '';

            $appr2_id = '';
            $appr2_firstname = '';
            $appr2_lastname = '';
            $appr2_initials = '';

            $appr3_id = '';
            $appr3_firstname = '';
            $appr3_lastname = '';
            $appr3_initials = '';

            $appr4_id = '';
            $appr4_firstname = '';
            $appr4_lastname = '';
            $appr4_initials = '';

            $appr5_id = '';
            $appr5_firstname = '';
            $appr5_lastname = '';
            $appr5_initials = '';

            $appr6_id = '';
            $appr6_firstname = '';
            $appr6_lastname = '';
            $appr6_initials = '';

            $appr7_id = '';
            $appr7_firstname = '';
            $appr7_lastname = '';
            $appr7_initials = '';


            if ($approver1) {
              $appr1_id = $approver1[0]->id;
              $appr1_firstname = $approver1[0]->col_frst_name;
              $appr1_lastname = $approver1[0]->col_last_name;
              if (!empty($approver1[0]->col_midl_name)) {
                $appr1_initials = $approver1[0]->col_midl_name[0] . '.';
              }
            }

            if ($approver2) {
              $appr2_id = $approver2[0]->id;
              $appr2_firstname = $approver2[0]->col_frst_name;
              $appr2_lastname = $approver2[0]->col_last_name;
              if (!empty($approver2[0]->col_midl_name)) {
                $appr2_initials = $approver2[0]->col_midl_name[0] . '.';
              }
            }

            if ($approver3) {
              $appr3_id = $approver3[0]->id;
              $appr3_firstname = $approver3[0]->col_frst_name;
              $appr3_lastname = $approver3[0]->col_last_name;
              if (!empty($approver3[0]->col_midl_name)) {
                $appr3_initials = $approver3[0]->col_midl_name[0] . '.';
              }
            }

            if ($approver4) {
              $appr4_id = $approver4[0]->id;
              $appr4_firstname = $approver4[0]->col_frst_name;
              $appr4_lastname = $approver4[0]->col_last_name;
              if (!empty($approver4[0]->col_midl_name)) {
                $appr4_initials = $approver4[0]->col_midl_name[0] . '.';
              }
            }

            if ($approver5) {
              $appr5_id = $approver5[0]->id;
              $appr5_firstname = $approver5[0]->col_frst_name;
              $appr5_lastname = $approver5[0]->col_last_name;
              if (!empty($approver5[0]->col_midl_name)) {
                $appr5_initials = $approver5[0]->col_midl_name[0] . '.';
              }
            }

            if ($approver6) {
              $appr6_id = $approver6[0]->id;
              $appr6_firstname = $approver6[0]->col_frst_name;
              $appr6_lastname = $approver6[0]->col_last_name;
              if (!empty($approver6[0]->col_midl_name)) {
                $appr6_initials = $approver6[0]->col_midl_name[0] . '.';
              }
            }

            if ($approver7) {
              $appr7_id = $approver7[0]->id;
              $appr7_firstname = $approver7[0]->col_frst_name;
              $appr7_lastname = $approver7[0]->col_last_name;
              if (!empty($approver7[0]->col_midl_name)) {
                $appr7_initials = $approver7[0]->col_midl_name[0] . '.';
              }
            }

        ?>

            <tr>
              <td class="text-center"><?= $empl_cmid  ?></td>
              <td style="width: 280px !important; border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $empl_id ?>" class="text-primary"> <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($empl_img) {
                                                                                                                                                                                                                                                        echo base_url() . 'user_images/' . $empl_img;
                                                                                                                                                                                                                                                      } else {
                                                                                                                                                                                                                                                        echo base_url() . 'user_images/default_profile_img3.png';
                                                                                                                                                                                                                                                      } ?>">&nbsp;&nbsp; <?= $empl_lastname . ' ' . $empl_firstname . ' ' . $empl_initials ?></a></td>
              <td class="text-center" style="width: 150px !important; border-left: 1px solid #e1e1e1 !important;"><?= $empl_group ?></a></td>

              <!-- Approver 1 -->
              <td class="text-center" style="border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr1_id ?>" class="text-primary"><?= $appr1_lastname . ' ' . $appr1_firstname . ' ' . $appr1_initials ?></a></td>
              <td class="text-center" style="border-right: 1px solid #e1e1e1 !important;  border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr2_id ?>" class="text-primary"><?= $appr2_lastname . ' ' . $appr2_firstname . ' ' . $appr2_initials ?></a></td>

              <!-- Approver 2 -->
              <td class="text-center" style="border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr3_id ?>" class="text-primary"><?= $appr3_lastname . ' ' . $appr3_firstname . ' ' . $appr3_initials ?></a></td>
              <td class="text-center" style="border-right: 1px solid #e1e1e1 !important;  border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr4_id ?>" class="text-primary"><?= $appr4_lastname . ' ' . $appr4_firstname . ' ' . $appr4_initials ?></a></td>
              <td class="text-center" style="border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr5_id ?>" class="text-primary"><?= $appr5_lastname . ' ' . $appr5_firstname . ' ' . $appr5_initials ?></a></td>

              <!-- Approver 3 -->
              <td class="text-center" style="border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr6_id ?>" class="text-primary"><?php if ($empl_group == 'STAFF') {
                                                                                                                                                                                  echo $appr6_lastname . ' ' . $appr6_firstname . ' ' . $appr6_initials;
                                                                                                                                                                                } ?></a></td>
              <td class="text-center" style="border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr7_id ?>" class="text-primary"><?php if ($empl_group == 'STAFF') {
                                                                                                                                                                                  echo $appr7_lastname . ' ' . $appr7_firstname . ' ' . $appr7_initials;
                                                                                                                                                                                } ?></a></td>
            </tr>

        <?php
          }
        }

        ?>

      </tbody>
    </table>
    <!-- <center><ul id="btn_pagination" class="pagination mr-auto ml-auto"></ul></center> -->
  </div>
</div>
</div>




<aside class="control-sidebar control-sidebar-dark">
</aside>









<div class="modal fade" id="modal_assign_approver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
      <form action="<?php echo base_url('approval/assign_approvers_leave'); ?>" id="form_updt_approvers" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER3">Approver 2-A
                </label>
                <select name="UPDT_APPROVER3" id="UPDT_APPROVER3" class="form-control">
                  <option value="">Choose Approver A...</option>
                  <?php
                  if ($DISP_EMPLOYEES) {
                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
                  ?>
                      <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER4">Approver 2-B
                </label>
                <select name="UPDT_APPROVER4" id="UPDT_APPROVER4" class="form-control">
                  <option value="">Choose Approver B...</option>
                  <?php
                  if ($DISP_EMPLOYEES) {
                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
                  ?>
                      <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER5">Approver 2-C
                </label>
                <select name="UPDT_APPROVER5" id="UPDT_APPROVER5" class="form-control">
                  <option value="">Choose Approver C...</option>
                  <?php
                  if ($DISP_EMPLOYEES) {
                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
                  ?>
                      <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="UPDT_APPROVER6">Approver 3-A (For Staff Only)
                </label>
                <select name="UPDT_APPROVER6" id="UPDT_APPROVER6" class="form-control">
                  <option value="">Choose Approver A...</option>
                  <?php
                  if ($DISP_EMPLOYEES) {
                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
                  ?>
                      <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="UPDT_APPROVER7">Approver 3-B (For Staff Only)
                </label>
                <select name="UPDT_APPROVER7" id="UPDT_APPROVER7" class="form-control">
                  <option value="">Choose Approver B...</option>
                  <?php
                  if ($DISP_EMPLOYEES) {
                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
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
          <input type="hidden" name="UPDT_APPROVAL_ID" id="UPDT_APPROVAL_ID">
          <a type="submit" id="updt_approval_route" class='btn btn-primary text-light'>&nbsp; Save</a>
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
        <h4 class="modal-title ml-1" id="exampleModalLabel">Approvers Per Group
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('approval/assign_approvers_leave'); ?>" id="FORM_REJECT_LEAVE" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>Group</th>
                    <th class="text-center">Approver 1 - A</th>
                    <th class="text-center">Approver 1 - B</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($DISP_Group) {
                    foreach ($DISP_Group as $DISP_GROUP_ROW) {
                      // if($DISP_GROUP_ROW->col_empl_group != ''){
                  ?>
                      <tr class="row_group_approvers">
                        <td class="group_name"><?php if ($DISP_GROUP_ROW->col_empl_group != '') {
                                                  echo $DISP_GROUP_ROW->col_empl_group;
                                                } else {
                                                  echo 'No Group';
                                                } ?> </td>
                        <td>
                          <select name="group_approver1" class="form-control group_approver1">
                            <option value="">Choose Approver 1 - A</option>
                            <?php
                            if ($DISP_EMPLOYEES) {
                              foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) {
                                $group_approver_data = $this->approval_route_mod->MOD_CHK_GROUP_APPROVERS_EXIST($DISP_GROUP_ROW->col_empl_group);
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
                                $group_approver_data = $this->approval_route_mod->MOD_CHK_GROUP_APPROVERS_EXIST($DISP_GROUP_ROW->col_empl_group);
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
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js">
</script>
<!-- Pagination -->
<script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>
<!-- Datatables -->
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
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
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_APPROVER')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_APPROVER'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_APPROVER');
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
<script>
  $(document).ready(function() {

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

    // Get & Display Data to Edit Modal Using Async JS function
    var url_get_approval_route_leave = '<?php echo base_url(); ?>approval/get_approval_route_leave';
    var url_save_group_approvers_leave = '<?php echo base_url(); ?>approval/save_group_approvers_leave';

    $('#APPROVAL_UPDT').click(function() {

      get_approval_route_leave(url_get_approval_route_leave, $(this).attr('approval_id')).then(data => {
        if (data.length > 0) {
          data.forEach((x) => {

            $('#UPDT_APPROVAL_ID').val(x.id);
            // $('#UPDT_APPROVER1').val(x.approver1);
            // $('#UPDT_APPROVER2').val(x.approver2);
            $('#UPDT_APPROVER3').val(x.approver3);
            $('#UPDT_APPROVER4').val(x.approver4);
            $('#UPDT_APPROVER5').val(x.approver5);
            $('#UPDT_APPROVER6').val(x.approver6);
            $('#UPDT_APPROVER7').val(x.approver6);

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
</body>

</html>