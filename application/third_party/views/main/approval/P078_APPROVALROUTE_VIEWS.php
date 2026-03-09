<style>
  .btn-group .btn{
    padding: 0px 12px;
  }
  .page-title{
    font-weight: 600;
    color: #424F5C;
    font-size: 33px;
  }
  th,td{
    font-size: 13px !important;
    border: none !important;
  }
  label.required::after{
    content:" *";
    color: red;
  }
</style>
<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Include Editor style. -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<!-- For image viewer -->
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
<div class="content-wrapper">
  <div class="p-3">
    <div class="flex-fill">
        <div class="row pr-3 mb-2">
            <div class="col-6">
                <h1 class="page-title">Approval Route
                </h1>
            </div>
            <div class="col-6">
                <a href="#" class="btn btn-primary text-white mt-2 float-right" data-toggle="modal" data-target="#modal_assign_approver">Assign Approvers</a>
                <a href="<?= base_url() ?>csv/import_approval_route" class="btn btn-primary text-white mt-2 float-right mr-2">Import CSV</a>
            </div>
        </div>
        <div class="card p-4 tab-pane active" id="for_approval" style="border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
            <table class="table table-hover table-xs mb-0" id="for_approval_tbl">
                <thead>
                  <tr>
                    <th rowspan="2" class="text-center" style="vertical-align: middle; border-bottom: 1px solid #e1e1e1 !important;">Approval id</th>
                    <th rowspan="2" class="text-center" style="vertical-align: middle; border-left: 1px solid #e1e1e1 !important; border-bottom: 1px solid #e1e1e1 !important;">Employee</th>
                    <th colspan="2" class="text-center" style="border-right: 1px solid #e1e1e1 !important; border-left: 1px solid #e1e1e1 !important; border-bottom: 1px dashed #e1e1e1 !important;">Approver 1</th>
                    <th colspan="2" class="text-center" style="border-right: 1px solid #e1e1e1 !important; border-left: 1px solid #e1e1e1 !important; border-bottom: 1px dashed #e1e1e1 !important;">Approver 2</th>
                    <th colspan="2" class="text-center" style="border-right: 1px solid #e1e1e1 !important; border-left: 1px solid #e1e1e1 !important; border-bottom: 1px dashed #e1e1e1 !important;">Approver 3</th>
                    <th rowspan="2" class="text-center" style="vertical-align: middle; border-bottom: 1px solid #e1e1e1 !important;">Action</th>
                  </tr>
                  <tr>
                    <th class="text-center" style=" border-left: 1px solid #e1e1e1 !important;  border-bottom: 1px solid #e1e1e1 !important;">Approver A</th>
                    <th class="text-center" style=" border-right: 1px solid #e1e1e1 !important;  border-bottom: 1px solid #e1e1e1 !important;">Approver B</th>
                    <th class="text-center" style=" border-left: 1px solid #e1e1e1 !important;  border-bottom: 1px solid #e1e1e1 !important;">Approver A</th>
                    <th class="text-center" style=" border-right: 1px solid #e1e1e1 !important;  border-bottom: 1px solid #e1e1e1 !important;">Approver B</th>
                    <th class="text-center" style=" border-left: 1px solid #e1e1e1 !important;  border-bottom: 1px solid #e1e1e1 !important;">Approver A</th>
                    <th class="text-center" style=" border-right: 1px solid #e1e1e1 !important;  border-bottom: 1px solid #e1e1e1 !important;">Approver B</th>
                    <th class="text-center"></th>
                  </tr>
                </thead>
                <tbody style="font-weight: 500 !important;">
                <?php 
                    if($DISP_APPROVER){
                        foreach($DISP_APPROVER as $DISP_APPROVER_ROW){
                            $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER_ROW->employee);
                            $approver1 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER_ROW->approver1);
                            $approver2 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER_ROW->approver2);
                            $approver3 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER_ROW->approver3);
                            $approver4 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER_ROW->approver4);
                            $approver5 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER_ROW->approver5);
                            $approver6 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER_ROW->approver6);

                            $empl_id = '';
                            $empl_img = '';
                            $empl_firstname = '';
                            $empl_lastname = '';
                            $appr1_firstname = '';
                            $appr1_lastname = '';
                            $appr2_firstname = '';
                            $appr2_lastname = '';
                            $appr3_firstname = '';
                            $appr3_lastname = '';
                            $appr4_firstname = '';
                            $appr4_lastname = '';
                            $appr5_firstname = '';
                            $appr5_lastname = '';
                            $appr6_firstname = '';
                            $appr6_lastname = '';

                            if($employee){
                              $empl_id = $employee[0]->id;
                              $empl_img = $employee[0]->col_imag_path;
                              $empl_firstname = $employee[0]->col_frst_name;
                              $empl_lastname = $employee[0]->col_last_name;
                            }

                            if($approver1){
                              $appr1_id = $approver1[0]->id;
                              $appr1_firstname = $approver1[0]->col_frst_name;
                              $appr1_lastname = $approver1[0]->col_last_name;
                            }

                            if($approver2){
                              $appr2_id = $approver2[0]->id;
                              $appr2_firstname = $approver2[0]->col_frst_name;
                              $appr2_lastname = $approver2[0]->col_last_name;
                            }

                            if($approver3){
                              $appr3_id = $approver3[0]->id;
                              $appr3_firstname = $approver3[0]->col_frst_name;
                              $appr3_lastname = $approver3[0]->col_last_name;
                            }

                            if($approver4){
                              $appr4_id = $approver4[0]->id;
                              $appr4_firstname = $approver4[0]->col_frst_name;
                              $appr4_lastname = $approver4[0]->col_last_name;
                            }

                            if($approver5){
                              $appr5_id = $approver5[0]->id;
                              $appr5_firstname = $approver5[0]->col_frst_name;
                              $appr5_lastname = $approver5[0]->col_last_name;
                            }

                            if($approver6){
                              $appr6_id = $approver6[0]->id;
                              $appr6_firstname = $approver6[0]->col_frst_name;
                              $appr6_lastname = $approver6[0]->col_last_name;
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?= str_pad($DISP_APPROVER_ROW->id,5,"0",STR_PAD_LEFT ) ?></td>
                                <td style="border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?=$empl_id?>" class="text-primary"> <img class="rounded-circle avatar " width="35" height="35" src="<?php if($empl_img){echo base_url().'user_images/'.$empl_img;} else {echo base_url().'user_images/default_profile_img3.png';}?>">&nbsp;&nbsp; <?= $empl_firstname.' '.$empl_lastname ?></a></td>
                                <td class="text-center" style="border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr1_id ?>" class="text-primary"><?= $appr1_firstname.' '.$appr1_lastname ?></a></td>
                                <td class="text-center" style="border-right: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr2_id ?>" class="text-primary"><?= $appr2_firstname.' '.$appr2_lastname ?></a></td>
                                <td class="text-center" style="border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr3_id ?>" class="text-primary"><?= $appr3_firstname.' '.$appr3_lastname ?></a></td>
                                <td class="text-center" style="border-right: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr4_id ?>" class="text-primary"><?= $appr4_firstname.' '.$appr4_lastname ?></a></td>
                                <td class="text-center" style="border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr5_id ?>" class="text-primary"><?= $appr5_firstname.' '.$appr5_lastname ?></a></td>
                                <td class="text-center" style="border-right: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr6_id ?>" class="text-primary"><?= $appr6_firstname.' '.$appr6_lastname ?></a></td>
                                <td>
                                    <center>
                                      <a class="btn btn-sm indigo lighten-2 APPROVAL_UPDT" approval_id="<?=$DISP_APPROVER_ROW->id?>" title="Edit" id="btn_edit_approval_route" data-toggle="modal" data-target="#modal_updt_approver" >
                                          <i class="fas fa-edit">
                                          </i>
                                      </a>
                                      <a class="btn btn-sm indigo lighten-2 text-danger APPROVAL_DLT" delete_key="<?=$DISP_APPROVER_ROW->id?>">
                                          <i class="fas fa-trash">
                                          </i>
                                      </a>
                                    </center>
                                </td>
                            </tr>
                        <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- flex-fill -->
  </div>
  <!-- p-3 -->
</div>
<!-- content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>


<!-- ASSIGN APPROVER MODAL -->
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
      <form action="<?php echo base_url('approval/assign_approvers'); ?>" id="FORM_REJECT_LEAVE" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="INSRT_EMPLOYEE">Assign to Employee
                </label>
                <select name="INSRT_EMPLOYEE" id="INSRT_EMPLOYEE" class="form-control">
                    <option value="">Choose Employee...</option>
                    <?php 
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid.' - '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="INSRT_APPROVER1">Approver 1-A
                </label>
                <select name="INSRT_APPROVER1" id="INSRT_APPROVER1" class="form-control">
                    <option value="">Choose Approver A...</option>
                    <?php 
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid.' - '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="INSRT_APPROVER2">Approver 1-B
                </label>
                <select name="INSRT_APPROVER2" id="INSRT_APPROVER2" class="form-control">
                    <option value="">Choose Approver B...</option>
                    <?php 
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid.' - '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="INSRT_APPROVER3">Approver 2-A
                </label>
                <select name="INSRT_APPROVER3" id="INSRT_APPROVER3" class="form-control">
                    <option value="">Choose Approver A...</option>
                    <?php 
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid.' - '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="INSRT_APPROVER4">Approver 2-B
                </label>
                <select name="INSRT_APPROVER4" id="INSRT_APPROVER4" class="form-control">
                    <option value="">Choose Approver B...</option>
                    <?php 
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid.' - '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="INSRT_APPROVER5">Approver 3-A
                </label>
                <select name="INSRT_APPROVER5" id="INSRT_APPROVER5" class="form-control">
                    <option value="">Choose Approver A...</option>
                    <?php 
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid.' - '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="INSRT_APPROVER6">Approver 3-B
                </label>
                <select name="INSRT_APPROVER6" id="INSRT_APPROVER6" class="form-control">
                    <option value="">Choose Approver B...</option>
                    <?php 
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid.' - '.$DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
            </div>
            <input type="hidden" name="REJECT_LEAVE_ID" id="REJECT_LEAVE_ID">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class='btn btn-primary text-light' id="BTN_SUBMIT">&nbsp; Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="modal_updt_approver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
      <form action="<?php echo base_url('approval/update_approvers'); ?>" id="FORM_REJECT_LEAVE" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="UPDT_EMPLOYEE">Assign to Employee
                </label>
                <select name="UPDT_EMPLOYEE" id="UPDT_EMPLOYEE" class="form-control">
                    <option value="">Choose Employee...</option>
                    <?php 
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER1">Approver 1-A
                </label>
                <select name="UPDT_APPROVER1" id="UPDT_APPROVER1" class="form-control">
                    <option value="">Choose Approver A...</option>
                    <?php 
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER2">Approver 1-B
                </label>
                <select name="UPDT_APPROVER2" id="UPDT_APPROVER2" class="form-control">
                    <option value="">Choose Approver B...</option>
                    <?php 
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER3">Approver 2-A
                </label>
                <select name="UPDT_APPROVER3" id="UPDT_APPROVER3" class="form-control">
                    <option value="">Choose Approver A...</option>
                    <?php 
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
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
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER5">Approver 3-A
                </label>
                <select name="UPDT_APPROVER5" id="UPDT_APPROVER5" class="form-control">
                    <option value="">Choose Approver A...</option>
                    <?php 
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER6">Approver 3-B
                </label>
                <select name="UPDT_APPROVER6" id="UPDT_APPROVER6" class="form-control">
                    <option value="">Choose Approver B...</option>
                    <?php 
                        if($DISP_EMPLOYEES){
                            foreach($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW){
                            ?>
                                <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_frst_name.' '.$DISP_EMPLOYEES_ROW->col_last_name ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
              </div>
            </div>
            <input type="hidden" name="UPDT_APPROVAL_ID" id="UPDT_APPROVAL_ID">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class='btn btn-primary text-light' id="BTN_UPDT">&nbsp; Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>



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
        <a href="<?php echo base_url().'login/logout'; ?>" class="btn btn-info">Logout
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
<!-- SESSION MESSAGES -->
<?php
if($this->session->userdata('SESS_SUCC_MSG_INSRT_CSV')){
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
if($this->session->userdata('SESS_ERR_MSG_INSRT_APPROVER')){
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
if($this->session->userdata('SESS_SUCC_MSG_INSRT_APPROVER')){
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
if($this->session->userdata('SESS_ERR_MSG_UPDT_APPROVER')){
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
if($this->session->userdata('SESS_ERR_MSG_DLT_APPROVER')){
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
if($this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE')){
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
if($this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE')){
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
  $(document).ready(function(){

    // Get & Display Data to Edit Modal Using Async JS function
    var url = '<?php echo base_url(); ?>approval/get_approval_route_data';

    $('.APPROVAL_UPDT').click(function(){
      get_approval_route_data(url,$(this).attr('approval_id')).then(data => {
        if(data.length > 0)
        {
          data.forEach((x) => {

            $('#UPDT_APPROVAL_ID').val(x.id);
            $('#UPDT_EMPLOYEE').val(x.employee);
            $('#UPDT_APPROVER1').val(x.approver1);
            $('#UPDT_APPROVER2').val(x.approver2);
            $('#UPDT_APPROVER3').val(x.approver3);
            $('#UPDT_APPROVER4').val(x.approver4);
            $('#UPDT_APPROVER5').val(x.approver5);
            $('#UPDT_APPROVER6').val(x.approver6);

          });
        }
      });
    })

    


    async function get_approval_route_data(url,approval_id) {
      var formData = new FormData();
      formData.append('approval_id', approval_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    // Delete Position
    $('.APPROVAL_DLT').click(function(e){
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
          window.location.href = "<?= base_url(); ?>approval/dlt_approval_route?delete_id="+user_deleteKey;
        }
      })
    })

  })
</script>
</body>
</html>
