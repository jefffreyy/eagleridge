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

  /* .leave_tab{
    border: none !important;
    box-shadow: none;
    background-color: transparent !important;
    color: #0D74BC;
  }
  .leave_tab:hover{
    background-color: #ccc !important;
    color: white !important;
  } */
</style>
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
        <h1 class="page-title">Approval Route - Overtime / Time Adjustment </h1>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a style="width: 200px;" href="<?= base_url() ?>approval/approval_route_leave" class="btn btn-primary shadow-none">Leave</a>
        <a style="width: 200px;" href="#" class="btn btn-primary shadow-none">Overtime / Time Adjustment</a>
      </div>
    </div>
    <hr>
    <div class="col-6" style="text-align: left;">
      <a href="#" class="btn btn-primary shadow-none" id="APPROVAL_UPDT" approval_id="<?= $DISP_APPROVER[0]->id ?>" data-toggle="modal" data-target="#modal_assign_approver">Update Approvers</a>
    </div>
  </div>
  <div class="card p-4 tab-pane active" id="for_approval" style="border-top: none !important; border-radius: 3px !important; box-shadow: none !important;">
    <table class="table table-hover table-xs mb-0" id="for_approval_tbl">
      <thead>
        <tr>
          <th rowspan="2" class="text-center" style="vertical-align: middle; border-bottom: 1px solid #e1e1e1 !important;">Employee ID</th>
          <th rowspan="2" class="text-center" style="width: 280px !important; vertical-align: middle; border-left: 1px solid #e1e1e1 !important; border-bottom: 1px solid #e1e1e1 !important;">Employee</th>
          <th rowspan="2" class="text-center" style="width: 150px !important; vertical-align: middle; border-left: 1px solid #e1e1e1 !important; border-bottom: 1px solid #e1e1e1 !important;">Group</th>
          <th colspan="3" class="text-center" style="vertical-align: middle; border-right: 1px solid #e1e1e1 !important; border-left: 1px solid #e1e1e1 !important; border-bottom: 1px dashed #e1e1e1 !important;">Approver 1</th>
          <th colspan="2" class="text-center" style="vertical-align: middle; border-right: 1px solid #e1e1e1 !important; border-left: 1px solid #e1e1e1 !important; border-bottom: 1px dashed #e1e1e1 !important;">Approver 2</th>
          <!-- <th rowspan="2" class="text-center" style="vertical-align: middle; border-bottom: 1px solid #e1e1e1 !important;">Action</th> -->
        </tr>
        <tr>
          <th class="text-center" style=" border-left: 1px solid #e1e1e1 !important;  border-bottom: 1px solid #e1e1e1 !important; ">Approver A</th>
          <th class="text-center" style=" border-right: 1px solid #e1e1e1 !important;  border-left: 1px solid #e1e1e1 !important;  border-bottom: 1px solid #e1e1e1 !important ">Approver B</th>
          <th class="text-center" style=" border-right: 1px solid #e1e1e1 !important;  border-bottom: 1px solid #e1e1e1 !important; ">Approver C</th>
          <th class="text-center" style=" border-right: 1px solid #e1e1e1 !important;  border-left: 1px solid #e1e1e1 !important;  border-bottom: 1px solid #e1e1e1 !important ">Approver A</th>
          <th class="text-center" style=" border-right: 1px solid #e1e1e1 !important;  border-bottom: 1px solid #e1e1e1 !important; ">Approver B</th>
          <!-- <th class="text-center" ></th> -->
        </tr>
      </thead>
      <tbody style="font-weight: 500 !important;">

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

            $empl_img = '';
            if ($DISP_EMPLOYEES_ROW->col_imag_path) {
              $empl_img = $DISP_EMPLOYEES_ROW->col_imag_path;
            } else {
              $empl_img = 'default_profile_img3.png';
            }

            $empl_group = 'No Group';
            if ($DISP_EMPLOYEES_ROW->col_empl_group) {
              $empl_group = $DISP_EMPLOYEES_ROW->col_empl_group;
            }

            $approver1 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER[0]->approver1);
            $approver2 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER[0]->approver2);
            $approver3 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER[0]->approver3);
            $approver4 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER[0]->approver4);
            $approver5 = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($DISP_APPROVER[0]->approver5);


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
        ?>
            <tr>
              <td class="text-center"><?= $empl_cmid ?></td>
              <td style="width: 280px !important; border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $empl_id ?>" class="text-primary"> <img class="rounded-circle avatar " width="35" height="35" src="<?php if ($empl_img) {
                                                                                                                                                                                                                                                        echo base_url() . 'user_images/' . $empl_img;
                                                                                                                                                                                                                                                      } else {
                                                                                                                                                                                                                                                        echo base_url() . 'user_images/default_profile_img3.png';
                                                                                                                                                                                                                                                      } ?>">&nbsp;&nbsp; <?= $empl_lastname . ' ' . $empl_firstname . ' ' . $empl_initials ?></a></td>
              <td class="text-center" style="width: 150px !important; border-left: 1px solid #e1e1e1 !important;"><?= $empl_group ?></td>
              <td class="text-center" style="border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr1_id ?>" class="text-primary"><?= $appr1_lastname . ' ' . $appr1_firstname . ' ' . $appr1_initials ?></a></td>
              <td class="text-center" style="border-right: 1px solid #e1e1e1 !important;  border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr2_id ?>" class="text-primary"><?= $appr2_lastname . ' ' . $appr2_firstname . ' ' . $appr2_initials ?></a></td>
              <td class="text-center" style="border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr3_id ?>" class="text-primary"><?= $appr3_lastname . ' ' . $appr3_firstname . ' ' . $appr3_initials ?></a></td>
              <td class="text-center" style="border-right: 1px solid #e1e1e1 !important;  border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr4_id ?>" class="text-primary"><?= $appr4_lastname . ' ' . $appr4_firstname . ' ' . $appr4_initials ?></a></td>
              <td class="text-center" style="border-left: 1px solid #e1e1e1 !important;"><a href="<?= base_url() ?>employees/personal?id=<?= $appr5_id ?>" class="text-primary"><?= $appr5_lastname . ' ' . $appr5_firstname . ' ' . $appr5_initials ?></a></td>
            </tr>

        <?php
          }
        }
        ?>

      </tbody>
    </table>
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
      <form action="<?php echo base_url('approval/assign_approvers_ot_adj'); ?>" id="FORM_REJECT_LEAVE" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="UPDT_APPROVER1">Approver 1-A
                </label>
                <select name="UPDT_APPROVER1" id="UPDT_APPROVER1" class="form-control">
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
                <label class="required " for="UPDT_APPROVER2">Approver 1-B
                </label>
                <select name="UPDT_APPROVER2" id="UPDT_APPROVER2" class="form-control">
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
                <label class="required " for="UPDT_APPROVER3">Approver 1-C
                </label>
                <select name="UPDT_APPROVER3" id="UPDT_APPROVER3" class="form-control">
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
                <label class="required " for="UPDT_APPROVER4">Approver 2-A
                </label>
                <select name="UPDT_APPROVER4" id="UPDT_APPROVER4" class="form-control">
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
                <label class="required " for="UPDT_APPROVER5">Approver 2-B
                </label>
                <select name="UPDT_APPROVER5" id="UPDT_APPROVER5" class="form-control">
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
          <button type="submit" class='btn btn-primary text-light'>&nbsp; Save
          </button>
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
    var url = '<?php echo base_url(); ?>approval/get_approval_route_ot_adj';

    $('#APPROVAL_UPDT').click(function() {
      get_approval_route_ot_adj(url, $(this).attr('approval_id')).then(data => {
        if (data.length > 0) {
          data.forEach((x) => {

            $('#UPDT_APPROVAL_ID').val(x.id);
            $('#UPDT_APPROVER1').val(x.approver1);
            $('#UPDT_APPROVER2').val(x.approver2);
            $('#UPDT_APPROVER3').val(x.approver3);
            $('#UPDT_APPROVER4').val(x.approver4);
            $('#UPDT_APPROVER5').val(x.approver5);

          });
        }
      });
    })




    async function get_approval_route_ot_adj(url, approval_id) {
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