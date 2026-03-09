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
  }
  label.required::after{
    content:" *";
    color: red;
  }
</style>
<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Daterange Picker -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/daterangepicker/daterangepicker.css">
<!-- Tempus Dominus -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Include Editor style. -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<div class="content-wrapper">
  <div class="p-3">
    <div class="flex-fill">
      <div class="row pr-3 mb-2">
        <div class="col">
          <h1 class="page-title">Timesheet
          </h1>
        </div>
      </div>
      <div class="row mb-4">
          <div class="col-3">
                <label for="search_employees" style="font-weight: 500">Search Employees</label>
                <select name="search_employees" id="search_employees" class="form-control">
                    <option value="Juan Dela Cruz">Juan Dela Cruz</option>
                </select>
          </div>
          <div class="col-3">
                <label for="select_period" style="font-weight: 500">Select Period</label>
                <input type="text" class="form-control float-right" id="reservation">
          </div>
      </div>
      <div class="card">
        <table class="table table-hover table-xs">
          <thead>
            <tr>
              <th>Date</th>
              <th>Time In</th>
              <th>Time Out</th>
              <th>Regular WH</th>
              <th>Over Time</th>
              <th>Total WH</th>
              <th>Reported MH</th>
              <th>Remarks</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                <td>23 Sep Wed</td>
                <td>7:13</td>
                <td>18:03</td>
                <td>9.00</td>
                <td>0.00</td>
                <td>9.00</td>
                <td>0.00</td>
                <td></td>
              </tr>
              <tr>
                <td>24 Sep Thu</td>
                <td>7:06</td>
                <td>18:03</td>
                <td>9.00</td>
                <td>0.00</td>
                <td>9.00</td>
                <td>0.00</td>
                <td></td>
              </tr>
              <tr>
                <td>25 Sep Fri</td>
                <td>7:06</td>
                <td>18:03</td>
                <td>98.00</td>
                <td>0.00</td>
                <td>8.00</td>
                <td>0.00</td>
                <td></td>
              </tr>
              <tr>
                <td>26 Sep Sat</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td></td>
              </tr>
              <tr>
                <td>27 Sep Sun</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td></td>
              </tr>
              <tr>
                <td>28 Sep Mon</td>
                <td>07:07</td>
                <td>18:04</td>
                <td>9.00</td>
                <td>0.00</td>
                <td>9.00</td>
                <td>0.00</td>
                <td></td>
              </tr>
              <tr>
                <td>29 Sep Tue</td>
                <td>07:13</td>
                <td>18:03</td>
                <td>9.00</td>
                <td>0.00</td>
                <td>9.00</td>
                <td>0.00</td>
                <td></td>
              </tr>
              <tr>
                <td>30 Sep Wed</td>
                <td>7:10</td>
                <td>18:03</td>
                <td>9.00</td>
                <td>0.00</td>
                <td>9.00</td>
                <td>0.00</td>
                <td></td>
              </tr>
              <tr>
                <td>01 Oct Thu</td>
                <td>7:09</td>
                <td>18:02</td>
                <td>9.00</td>
                <td>0.00</td>
                <td>9.00</td>
                <td>0.00</td>
                <td></td>
              </tr>
              <tr>
                <td>02 Oct Fri</td>
                <td>7:09</td>
                <td>18:06</td>
                <td>9.00</td>
                <td>0.00</td>
                <td>9.00</td>
                <td>0.00</td>
                <td></td>
              </tr>
              <tr>
                <td>03 Oct Sat</td>
                <td>7:09</td>
                <td>18:04</td>
                <td>9.00</td>
                <td>0.00</td>
                <td>9.00</td>
                <td>0.00</td>
                <td></td>
              </tr>
              
<!--             <?php
if($DISP_PAYROLL_INFO){
foreach($DISP_PAYROLL_INFO as $ROW_PAYROLL_INFO){ ?>
            <tr>
              <td>
                <?=$ROW_PAYROLL_INFO->name?>
              </td>
              <td class="">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                  <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                    <a class="btn btn-sm indigo lighten-2" payroll_id="<?=$ROW_PAYROLL_INFO->id?>" title="Edit" data-toggle="modal" data-target="#modal_edit_payroll" >
                      <i class="fas fa-edit">
                      </i>
                    </a>
                    <a class="btn btn-sm indigo lighten-2 text-danger PAYROLL_BTN_DLT" delete_key="<?=$ROW_PAYROLL_INFO->id?>">
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
            <tr>
              <td colspan='3'>No Data Yet
              </td>
            </tr>
            <?php
}
?> -->
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
<!-- /.control-sidebar -->
<!-- Add position -->
<div class="modal fade" id="modal_add_payroll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Add Payroll
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('payroll/insrt_payroll'); ?>" id="PAYROLL_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="PAYROLL_INPF_NAME">Name
                </label>
                <input class="form-control form-control " type="text" name="PAYROLL_INPF_NAME" id="PAYROLL_INPF_NAME">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class='btn btn-primary text-light' id="PAYROLL_BTN_SAVE">&nbsp; Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit position -->
<div class="modal fade" id="modal_edit_payroll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Payroll
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('payroll/updt_payroll'); ?>" id="PAYROLL_FORM_EDIT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="asset_code">Name
                </label>
                <input class="form-control form-control " type="text" name="UPDT_PAYROLL_INPF_NAME" id="UPDT_PAYROLL_INPF_NAME" required>
              </div>
            </div>
            <input type="hidden" name="UPDT_PAYROLL_INPF_ID" id="UPDT_PAYROLL_INPF_ID">
          </div>
        </div>
        <div class="modal-footer">
          <a class='btn btn-primary text-light' id="PAYROLL_BTN_UPDT">&nbsp; Update
          </a>
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
<!-- DateRange Picker -->
<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js">
</script>
<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/js/froala_editor.pkgd.min.js">
</script>
<!-- Initialize the editor. -->
<script>
  $(function() {
    $('div#froala-editor').froalaEditor({
      // Set custom buttons with separator between them.
      toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting','html'],
      toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic','html']
    }
                                       )
    $('i.fa.fa-rotate-left').attr('class')
  }
   );
</script>
<!-- SESSION MESSAGES -->
<?php
if($this->session->userdata('SESS_SUCC_MSG_INSRT_PAYROLL')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_PAYROLL'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_INSRT_PAYROLL');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_UPDT_PAYROLL')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_PAYROLL'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_UPDT_PAYROLL');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_DLT_PAYROLL')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_PAYROLL'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_DLT_PAYROLL');
}
?>
<script>
  $(document).ready(function(){
    $('#reservation').daterangepicker()
    // Get & Display Data to Edit Modal Using Async JS function
    var url = '<?php echo base_url(); ?>payroll/getPayrollData';
    const openModalButton = document.querySelectorAll('[data-target]');
    openModalButton.forEach(button => {
      button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        getPayrollData(url,button.getAttribute('payroll_id')).then(data => {
          if(data.length > 0)
          {
            data.forEach((x) => {
              document.getElementById('UPDT_PAYROLL_INPF_ID').value = x.id;
              document.getElementById('UPDT_PAYROLL_INPF_NAME').value = x.name;
            });
          }
        });
      });
    });
    async function getPayrollData(url,payroll_id) {
      var formData = new FormData();
      formData.append('PAYROLL_GET_PAYROLL_DATA', payroll_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }
    // Update Position
    $('#PAYROLL_BTN_UPDT').click(function(){
      var payroll_name = $('#UPDT_PAYROLL_INPF_NAME').val();
      var hasErr = 0;
      if(!payroll_name){
        hasErr++;
      }
      if(hasErr == 0){
        Swal.fire({
          title: 'Do you want to save the following changes?',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
            $('#PAYROLL_FORM_EDIT').submit();
          }
        })
      }
      else {
        $('#UPDT_PAYROLL_INPF_NAME').addClass('is-invalid');
      }
    })
    $('#UPDT_PAYROLL_INPF_NAME').keyup(function(){
      $('#UPDT_PAYROLL_INPF_NAME').removeClass('is-invalid');
    })
    // Delete Position
    $('.PAYROLL_BTN_DLT').click(function(e){
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
          window.location.href = "<?= base_url(); ?>payroll/dlt_payroll?delete_id="+user_deleteKey;
        }
      })
    })
  })
</script>
</body>
</html>
