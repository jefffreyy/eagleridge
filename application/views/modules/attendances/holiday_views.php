<?php $this->load->view('templates/css_link'); ?>
<?php
$id_code = "HOL";
?>
<div class="content-wrapper">
  <div class="p-3">
    <div class="flex-fill">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url() ?>attendances">Attendance </a>
          </li>

          <li class="breadcrumb-item active" aria-current="page">Holiday </li>
        </ol>
      </nav>

      <div class="row pr-3 mb-2">
        <div class="col">
          <h1 class="page-title">Holiday
          </h1>
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
          <a href="#" class="btn btn-primary shadow-none" id="btn_export" style="float:right"><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>
        </div>

        <div>
          <a class="btn btn-primary float-right" title="Add" href="#" data-toggle="modal" data-target="#modal_add_holiday">
            <i class="fas fa-fw fa-plus">
            </i> New Holiday
          </a>
        </div>
      </div>

      <div class="card">
        <div class="row">
          <div class="col">
            <div class="table-responsive">
              <table class="table table-hover table-xs" id="TableToExport">
                <thead>
                  <th>Holiday ID</th>
                  <th>Name</th>
                  <th>Starts&nbsp;On</th>
                  <th>Regular&nbsp;Holiday</th>
                  <th></th>
                </thead>

                <tbody>
                  <?php
                  if ($DISP_HOLIDAY_INFO) {
                    foreach ($DISP_HOLIDAY_INFO as $ROW_HOLIDAY_INFO) {
                      $application_id = $id_code . str_pad($ROW_HOLIDAY_INFO->id, 5, '0', STR_PAD_LEFT);
                  ?>
                      <tr>
                        <td>
                          <?= $application_id ?>
                        </td>
                        <td>
                          <?= $ROW_HOLIDAY_INFO->name ?>
                        </td>
                        <td>
                          <?= $ROW_HOLIDAY_INFO->col_holi_date ?>
                        </td>
                        <td>
                          <?= $ROW_HOLIDAY_INFO->col_holi_type ?>
                        </td>

                        <td class="">
                          <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                              <a class="btn btn-sm indigo lighten-2" holiday_id="<?= $ROW_HOLIDAY_INFO->id ?>" title="Edit" data-toggle="modal" data-target="#modal_edit_holiday">
                                <i class="fas fa-edit"></i>
                              </a>

                              <a class="btn btn-sm indigo lighten-2 text-danger HOLIDAY_BTN_DLT" delete_key="<?= $ROW_HOLIDAY_INFO->id ?>">
                               <img src="<?= base_url('assets_system/icons/trash-solid.svg') ?>" alt="">

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
                        <center>No Records</center>
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
<div class="modal fade" id="modal_add_holiday" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Add Holiday</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>

      <form action="<?php echo base_url('attendances/insrt_holiday'); ?>" id="HOLIDAY_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="HOLIDAY_INPF_NAME">Name</label>
                <input class="form-control form-control " type="text" name="HOLIDAY_INPF_NAME" id="HOLIDAY_INPF_NAME" required>
              </div>

              <div class="form-group">
                <label class="required " for="HOLIDAY_INPF_DATE">Date </label>
                <input class="form-control form-control " type="date" name="HOLIDAY_INPF_DATE" id="HOLIDAY_INPF_DATE" required>
              </div>

              <div class="form-group">
                <label class="required " for="HOLIDAY_INPF_TYPE">Type
                </label>

                <select class="form-control form-control " type="text" name="HOLIDAY_INPF_TYPE" id="HOLIDAY_INPF_TYPE" required>
                  <option value="">Choose...</option>
                  <option value="Regular holiday">Regular holiday</option>
                  <option value="Special Non-working holiday">Special Non-working holiday</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button class='btn btn-primary text-light' id="HOLIDAY_BTN_SAVE">&nbsp; Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_edit_holiday" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Holiday</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>

      <form action="<?php echo base_url('attendances/updt_holiday'); ?>" id="HOLIDAY_FORM_EDIT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="UPDT_HOLIDAY_INPF_NAME">Name</label>
                <input class="form-control form-control " type="text" name="UPDT_HOLIDAY_INPF_NAME" id="UPDT_HOLIDAY_INPF_NAME" required>
              </div>

              <div class="form-group">
                <label class="required " for="UPDT_HOLIDAY_INPF_DATE">Date</label>
                <input class="form-control form-control " type="date" name="UPDT_HOLIDAY_INPF_DATE" id="UPDT_HOLIDAY_INPF_DATE" required>
              </div>

              <div class="form-group">
                <label class="required " for="UPDT_HOLIDAY_INPF_TYPE">Type </label>
                <select class="form-control form-control " type="text" name="UPDT_HOLIDAY_INPF_TYPE" id="UPDT_HOLIDAY_INPF_TYPE" required>
                  <option value="">Choose...</option>
                  <option value="Regular holiday">Regular holiday</option>
                  <option value="Special Non-working holiday">Special Non-working holiday</option>
                </select>
              </div>
            </div>

            <input type="hidden" name="UPDT_HOLIDAY_INPF_ID" id="UPDT_HOLIDAY_INPF_ID">
          </div>
        </div>
        
        <div class="modal-footer">
          <a class='btn btn-primary text-light' id="HOLIDAY_BTN_UPDT">&nbsp; Update
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
          <span aria-hidden="true" class="text-white">&times;
          </span>
        </button>
      </div>

      <div class="modal-body">
        <p>Hi are you sure you want to logout?</p>
      </div>

      <div class="modal-footer pb-1 pt-1">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
        </button>
        <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout</a>
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
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_HOLIDAY')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_HOLIDAY'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_HOLIDAY');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_UPDT_HOLIDAY')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_HOLIDAY'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_UPDT_HOLIDAY');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_DLT_HOLIDAY')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_HOLIDAY'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_DLT_HOLIDAY');
}
?>
<script>
  $(document).ready(function() {
    var url = '<?php echo base_url(); ?>settings/getHolidayData';
    const openModalButton = document.querySelectorAll('[data-target]');
    openModalButton.forEach(button => {
      button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        getHolidayData(url, button.getAttribute('holiday_id')).then(data => {
          if (data.length > 0) {
            data.forEach((x) => {
              document.getElementById('UPDT_HOLIDAY_INPF_ID').value = x.id;
              document.getElementById('UPDT_HOLIDAY_INPF_NAME').value = x.name;
              document.getElementById('UPDT_HOLIDAY_INPF_DATE').value = x.col_holi_date;
              document.getElementById('UPDT_HOLIDAY_INPF_TYPE').value = x.col_holi_type;
            });
          }
        });
      });
    });
    async function getHolidayData(url, holiday_id) {
      var formData = new FormData();
      formData.append('HOLIDAY_GET_HOLIDAY_DATA', holiday_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }

    $('#HOLIDAY_BTN_UPDT').click(function() {
      var holiday_name = $('#UPDT_HOLIDAY_INPF_NAME').val();
      var holiday_date = $('#UPDT_HOLIDAY_INPF_DATE').val();
      var holiday_type = $('#UPDT_HOLIDAY_INPF_TYPE').val();
      var hasErr = 0;
      if (!holiday_name) {
        hasErr++;
        $('#UPDT_HOLIDAY_INPF_NAME').addClass('is-invalid');
      }

      if (!holiday_date) {
        hasErr++;
        $('#UPDT_HOLIDAY_INPF_DATE').addClass('is-invalid');
      }

      if (!holiday_type) {
        hasErr++;
        $('#UPDT_HOLIDAY_INPF_TYPE').addClass('is-invalid');
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
            $('#HOLIDAY_FORM_EDIT').submit();
          }
        })
      }
    })

    $('#UPDT_HOLIDAY_INPF_NAME').keyup(function() {
      $('#UPDT_HOLIDAY_INPF_NAME').removeClass('is-invalid');
    })
    $('#UPDT_HOLIDAY_INPF_DATE').keyup(function() {
      $('#UPDT_HOLIDAY_INPF_DATE').removeClass('is-invalid');
    })
    $('#UPDT_HOLIDAY_INPF_TYPE').keyup(function() {
      $('#UPDT_HOLIDAY_INPF_TYPE').removeClass('is-invalid');
    })
    $('.HOLIDAY_BTN_DLT').click(function(e) {
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
          window.location.href = "<?= base_url(); ?>attendances/dlt_holiday?delete_id=" + user_deleteKey;
        }
      })
    })
  })
</script>
    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script>

  document.getElementById("btn_export").addEventListener('click', function() {
    var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
    XLSX.writeFile(wb, "Holidays.xlsx");

  });
</script>

</body>

</html>