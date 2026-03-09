<?php $this->load->view('templates/css_link'); ?>
<?php
$id_code = "SHT";
?>

<div class="content-wrapper">
  <div class="p-3">
    <div class="flex-fill">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url() ?>attendances">Attendance</a></li>

          <li class="breadcrumb-item active" aria-current="page">Shift Template</li>
        </ol>
      </nav>

      <div class="row pr-3 mb-2">
        <div class="col">
          <h1 class="page-title">Shift Template</h1>
        </div>
      </div>

      <div class="row mb-2">
        <div class="col">
          <form class="new_q" id="new_q" action="#" accept-charset="UTF-8" method="get">
            <div class="form-row align-items-center">
              <div class="col mb-1">
                <input autofocus="autofocus" class="form-control" placeholder="Search..." type="search" name="work_pattern_search" id="work_pattern_search">
              </div>
            </div>
          </form>
        </div>

        <div class="col-md-6 button-title">
          <a href="#" class="btn btn-primary shadow-none" id="btn_export"><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>
        </div>

        <div>
          <a class="btn btn-primary float-right" title="Add" href="#" data-toggle="modal" data-target="#modal_add_ShiftTemplate">
            <i class="fas fa-fw fa-plus">
            </i> Add
          </a>
        </div>
      </div>

      <div class="card">
        <div class="row">
          <div class="col">
            <div class="table-responsive">
              <table class="table table-hover table-xs" id="TableToExport">
                <thead>
                  <tr>
                    <th>Shift Template ID</th>
                    <th>Code
                    </th>
                    <th>Name
                    </th>
                    <th>Monday
                    </th>
                    <th>Tuesday
                    </th>
                    <th>Wednesday
                    </th>
                    <th>Thursday
                    </th>
                    <th>Friday
                    </th>
                    <th>Saturday
                    </th>
                    <th>Sunday
                    </th>
                    <th>
                    </th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  if ($DISP_SHIFTTEMPLATE_INFO) {
                    foreach ($DISP_SHIFTTEMPLATE_INFO as $ROW_SHIFTTEMPLATE_INFO) {
                      $application_id = $id_code . str_pad($ROW_SHIFTTEMPLATE_INFO->id, 5, '0', STR_PAD_LEFT);
                  ?>
                      <tr>
                        <td>
                          <?= $application_id ?>
                        </td>
                        <td>
                          <?=
                          $ROW_SHIFTTEMPLATE_INFO->code
                          ?>
                        </td>
                        <td>
                          <?=
                          $ROW_SHIFTTEMPLATE_INFO->name
                          ?>
                        </td>
                        <td>
                          <?php
                          $monday = $this->attendance_model->MOD_GET_WRK_SHFT_DATA($ROW_SHIFTTEMPLATE_INFO->monday);

                          echo isset($monday[0]->name) ? $monday[0]->name : '';
                          ?>
                        </td>
                        <td>
                          <?php
                          $tuesday = $this->attendance_model->MOD_GET_WRK_SHFT_DATA($ROW_SHIFTTEMPLATE_INFO->tuesday);
                          echo isset($tuesday[0]->name) ? $monday[0]->name : '';
                          ?>
                        </td>
                        <td>
                          <?php
                          $wednesday = $this->attendance_model->MOD_GET_WRK_SHFT_DATA($ROW_SHIFTTEMPLATE_INFO->wednesday);
                          echo isset($wednesday[0]->name) ? $monday[0]->name : '';
                          ?>
                        </td>
                        <td>
                          <?php
                          $thursday = $this->attendance_model->MOD_GET_WRK_SHFT_DATA($ROW_SHIFTTEMPLATE_INFO->thursday);
                          echo isset($thursday[0]->name) ? $monday[0]->name : '';
                          ?>
                        </td>
                        <td>
                          <?php
                          $friday = $this->attendance_model->MOD_GET_WRK_SHFT_DATA($ROW_SHIFTTEMPLATE_INFO->friday);
                          echo isset($friday[0]->name) ? $monday[0]->name : '';
                          ?>
                        </td>
                        <td>
                          <?php
                          $saturday = $this->attendance_model->MOD_GET_WRK_SHFT_DATA($ROW_SHIFTTEMPLATE_INFO->monday);
                          echo isset($saturday[0]->name) ? $monday[0]->name : '';
                          ?>
                        </td>
                        <td>
                          <?php
                          $sunday = $this->attendance_model->MOD_GET_WRK_SHFT_DATA($ROW_SHIFTTEMPLATE_INFO->sunday);
                          echo isset($sunday[0]->name) ? $monday[0]->name : '';
                          ?>
                        </td>
                        <td class="">
                          <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                              <a class="btn btn-sm indigo lighten-2" ShiftTemplate_id="<?= $ROW_SHIFTTEMPLATE_INFO->id ?>" title="Edit" data-toggle="modal" data-target="#modal_edit_ShiftTemplate">
                                <i class="fas fa-edit">
                                </i>
                              </a>
                              <a class="btn btn-sm indigo lighten-2 text-danger SHIFTTEMPLATE_BTN_DLT" delete_key="<?= $ROW_SHIFTTEMPLATE_INFO->id ?>">
                                <i class="fas fa-trash">
                                </i>
                              </a>
                            </div>
                          </div>
                        </td>
                      </tr>

                    <?php
                    }
                  } else { ?>
                    <tr class="table-active">
                      <td colspan="9">
                        <center>No Data Yet</center>
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
    </div>
  </div>
</div>

<aside class="control-sidebar control-sidebar-dark"></aside>
<div class="modal fade" id="modal_add_ShiftTemplate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Add Shift Template</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php echo base_url('attendances/insrt_shiftTemplate'); ?>" id="SHIFTTEMPLATE_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="SHIFTTEMPLATE_INPF_NAME">Code</label>
                <input class="form-control form-control " type="text" name="SHIFTTEMPLATE_INPF_CODE" id="SHIFTTEMPLATE_INPF_CODE">
              </div>

              <div class="form-group">
                <label class="required " for="SHIFTTEMPLATE_INPF_NAME">Template Name</label>
                <input class="form-control form-control " type="text" name="SHIFTTEMPLATE_INPF_NAME" id="SHIFTTEMPLATE_INPF_NAME">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="required " for="SHIFTTEMPLATE_INPF_NAME">Monday</label>
                <select name="SHIFTTEMPLATE_INPF_MONDAY" id="SHIFTTEMPLATE_INPF_MONDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="required " for="SHIFTTEMPLATE_INPF_NAME">Tuesday</label>
                <select name="SHIFTTEMPLATE_INPF_TUESDAY" id="SHIFTTEMPLATE_INPF_TUESDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="required " for="SHIFTTEMPLATE_INPF_NAME">Wednesday </label>
                <select name="SHIFTTEMPLATE_INPF_WEDNESDAY" id="SHIFTTEMPLATE_INPF_WEDNESDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="required " for="SHIFTTEMPLATE_INPF_NAME">Thursday
                </label>
                <select name="SHIFTTEMPLATE_INPF_THURSDAY" id="SHIFTTEMPLATE_INPF_THURSDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="required " for="SHIFTTEMPLATE_INPF_NAME">Friday
                </label>
                <select name="SHIFTTEMPLATE_INPF_FRIDAY" id="SHIFTTEMPLATE_INPF_FRIDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="required " for="SHIFTTEMPLATE_INPF_NAME">Saturday
                </label>
                <select name="SHIFTTEMPLATE_INPF_SATURDAY" id="SHIFTTEMPLATE_INPF_SATURDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="required " for="SHIFTTEMPLATE_INPF_NAME">Sunday
                </label>
                <select name="SHIFTTEMPLATE_INPF_SUNDAY" id="SHIFTTEMPLATE_INPF_SUNDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
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
          <button class='btn btn-primary text-light' id="SHIFTTEMPLATE_BTN_SAVE">&nbsp; Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_edit_ShiftTemplate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Shift Template</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php echo base_url('attendances/updt_shiftTemplate'); ?>" id="SHIFTTEMPLATE_FORM_EDIT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="SHIFTTEMPLATE_INPF_NAME">Code</label>
                <input class="form-control form-control " type="text" name="UPDT_SHIFTTEMPLATE_INPF_CODE" id="UPDT_SHIFTTEMPLATE_INPF_CODE">
              </div>

              <div class="form-group">
                <label class="required " for="SHIFTTEMPLATE_INPF_NAME">Template Name</label>
                <input class="form-control form-control " type="text" name="UPDT_SHIFTTEMPLATE_INPF_NAME" id="UPDT_SHIFTTEMPLATE_INPF_NAME">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="required " for="UPDT_SHIFTTEMPLATE_INPF_NAME">Monday</label>
                <select name="UPDT_SHIFTTEMPLATE_INPF_MONDAY" id="UPDT_SHIFTTEMPLATE_INPF_MONDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="required " for="UPDT_SHIFTTEMPLATE_INPF_NAME">Tuesday </label>
                <select name="UPDT_SHIFTTEMPLATE_INPF_TUESDAY" id="UPDT_SHIFTTEMPLATE_INPF_TUESDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="required " for="UPDT_SHIFTTEMPLATE_INPF_NAME">Wednesday</label>
                <select name="UPDT_SHIFTTEMPLATE_INPF_WEDNESDAY" id="UPDT_SHIFTTEMPLATE_INPF_WEDNESDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="required " for="UPDT_SHIFTTEMPLATE_INPF_NAME">Thursday
                </label>
                <select name="UPDT_SHIFTTEMPLATE_INPF_THURSDAY" id="UPDT_SHIFTTEMPLATE_INPF_THURSDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="required " for="UPDT_SHIFTTEMPLATE_INPF_NAME">Friday
                </label>
                <select name="UPDT_SHIFTTEMPLATE_INPF_FRIDAY" id="UPDT_SHIFTTEMPLATE_INPF_FRIDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="required " for="UPDT_SHIFTTEMPLATE_INPF_NAME">Saturday</label>
                <select name="UPDT_SHIFTTEMPLATE_INPF_SATURDAY" id="UPDT_SHIFTTEMPLATE_INPF_SATURDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label class="required " for="UPDT_SHIFTTEMPLATE_INPF_NAME">Sunday</label>
                <select name="UPDT_SHIFTTEMPLATE_INPF_SUNDAY" id="UPDT_SHIFTTEMPLATE_INPF_SUNDAY" class="form-control">
                  <option value="">Choose Work Shift...</option>
                  <?php
                  if ($DISP_WORK_SHIFT) {
                    foreach ($DISP_WORK_SHIFT as $DISP_WORK_SHIFT_ROW) {
                  ?>
                      <option value="<?= $DISP_WORK_SHIFT_ROW->id ?>"><?= $DISP_WORK_SHIFT_ROW->name ?></option>
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
          <input type="hidden" name="UPDT_SHIFTTEMPLATE_INPF_ID" id="UPDT_SHIFTTEMPLATE_INPF_ID">
          <a class='btn btn-primary text-light' id="SHIFTTEMPLATE_BTN_UPDT">&nbsp; Update
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
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

<?php $this->load->view('templates/jquery_link'); ?>
<script>

  $(function() {
    $('div#froala-editor').froalaEditor({
      toolbarButtons: ['undo', 'redo', '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting', 'html'],
      toolbarButtonsXS: ['undo', 'redo', '-', 'bold', 'italic', 'html']
    })
    $('i.fa.fa-rotate-left').attr('class')
  });
</script>

<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_SHIFTTEMPLATE')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_SHIFTTEMPLATE'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_SHIFTTEMPLATE');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_UPDT_SHIFTTEMPLATE')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_SHIFTTEMPLATE'); ?>',
      '',
      'success'
    )
  </script>
<?php

  $this->session->unset_userdata('SESS_SUCC_MSG_UPDT_SHIFTTEMPLATE');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_DLT_SHIFTTEMPLATE')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_SHIFTTEMPLATE'); ?>',
      '',
      'success'
    )
  </script>
<?php

  $this->session->unset_userdata('SESS_SUCC_MSG_DLT_SHIFTTEMPLATE');
}
?>
<script>
  $(document).ready(function() {
    var url = '<?php echo base_url(); ?>settings/getShiftTemplateData';
    const openModalButton = document.querySelectorAll('[data-target]');
    openModalButton.forEach(button => {
      button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        getShiftTemplateData(url, button.getAttribute('ShiftTemplate_id')).then(data => {
          if (data.length > 0) {
            data.forEach((x) => {
              document.getElementById('UPDT_SHIFTTEMPLATE_INPF_ID').value        = x.id;
              document.getElementById('UPDT_SHIFTTEMPLATE_INPF_NAME').value      = x.name;
              document.getElementById('UPDT_SHIFTTEMPLATE_INPF_CODE').value      = x.code;
              document.getElementById('UPDT_SHIFTTEMPLATE_INPF_MONDAY').value    = x.monday;
              document.getElementById('UPDT_SHIFTTEMPLATE_INPF_TUESDAY').value   = x.tuesday;
              document.getElementById('UPDT_SHIFTTEMPLATE_INPF_WEDNESDAY').value = x.wednesday;
              document.getElementById('UPDT_SHIFTTEMPLATE_INPF_THURSDAY').value  = x.thursday;
              document.getElementById('UPDT_SHIFTTEMPLATE_INPF_FRIDAY').value    = x.friday;
              document.getElementById('UPDT_SHIFTTEMPLATE_INPF_SATURDAY').value  = x.saturday;
              document.getElementById('UPDT_SHIFTTEMPLATE_INPF_SUNDAY').value    = x.sunday;
            });
          }
        });
      });
    });
    async function getShiftTemplateData(url, ShiftTemplate_id) {
      var formData = new FormData();
      formData.append('SHIFTTEMPLATE_GET_SHIFTTEMPLATE_DATA', ShiftTemplate_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    $('#SHIFTTEMPLATE_BTN_UPDT').click(function(e) {
      e.preventDefault();
      var ShiftTemplate_name = $('#UPDT_SHIFTTEMPLATE_INPF_NAME').val();
      var hasErr = 0;
      if (!ShiftTemplate_name) {
        hasErr++;
      }

      if (hasErr == 0) {
        Swal.fire({
          title: 'Do you want to save the following changes?',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
            $('#SHIFTTEMPLATE_FORM_EDIT').submit();
          }
        })
      } 
      else {
        $('#UPDT_SHIFTTEMPLATE_INPF_NAME').addClass('is-invalid');
      }
    })
    $('#UPDT_SHIFTTEMPLATE_INPF_NAME').keyup(function() {
      $('#UPDT_SHIFTTEMPLATE_INPF_NAME').removeClass('is-invalid');
    })

    $('.SHIFTTEMPLATE_BTN_DLT').click(function(e) {
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
          window.location.href = "<?= base_url(); ?>attendances/dlt_ShiftTemplate?delete_id=" + user_deleteKey;
        }
      })
    })
  })
</script>

<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script>
  document.getElementById("btn_export").addEventListener('click', function() {
    var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
    XLSX.writeFile(wb, "Shift Template.xlsx");
  });
</script>

</body>

</html>