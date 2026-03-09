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

<?php 
    $user = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($this->session->userdata('SESS_USER_ID'));
    $vacation_balance = $user[0]->col_leave_vacation;
    $sick_balance = $user[0]->col_leave_sick;
    $maternity_balance = $user[0]->col_leave_maternity;
    $parental_balance = $user[0]->col_leave_parental;
    $paternal_balance = $user[0]->col_leave_paternal;
    //$rehabilitation_balance = $user[0]->col_leave_rehabilitation;
    $service_incentive_balance = $user[0]->col_leave_service_incentive;
    $solo_incentive = $user[0]->col_leave_solo_incentive;
?>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
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
          <h1 class="page-title">Apply Leave
          </h1>
        </div>
      </div>
      <div class="card p-4">
        <!-- <div class="card-header" style="background-color: #fff !important; border-bottom: none !important;">
          
        </div> -->
        <form action="<?php echo base_url('leave/insrt_apply_leave'); ?>" id="apply_leave_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6" style="border-right: 1px solid #ccc;">
              <div class="form-group clearfix my-4 text-center">
                  <div class="icheck-primary d-inline">
                      <input type="radio" id="leave_single_day" value="leave_single_day" name="leave_class" checked>
                      <label class="radio_label" for="leave_single_day">
                          Single Entry
                      </label>
                  </div>
                  <div class="icheck-primary d-inline ml-4">
                      <input type="radio" id="leave_multiple_days" value="leave_multiple_days" name="leave_class">
                      <label class="radio_label" for="leave_multiple_days">
                          Multiple Entry
                      </label>
                  </div>
              </div>
              <div id="single_leave">
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_TYPE">Leave Type
                  </label>
                  <select class="form-control" name="INSRT_LEAVE_TYPE" id="INSRT_LEAVE_TYPE">
                    <option value="">Choose...</option>
                    <?php 
                      foreach($DISP_LEAVETYPES_INFO as $DISP_LEAVETYPES_INFO_ROW){
                      ?>
                        <option value="<?= $DISP_LEAVETYPES_INFO_ROW->name ?>"><?= $DISP_LEAVETYPES_INFO_ROW->name ?></option>
                      <?php
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_DATE">Date
                  </label>
                  <input class="form-control" type="date" name="INSRT_LEAVE_DATE" id="INSRT_LEAVE_DATE">
                </div>
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_DURATION">Duration (Hours)
                  </label>
                  <!-- <input type="number" name="INSRT_LEAVE_DURATION" id="INSRT_LEAVE_DURATION"> -->
                  <select class="form-control" name="INSRT_LEAVE_DURATION" id="INSRT_LEAVE_DURATION">
                    <option value="">Choose...</option>
                    <option value="0.5">Half Day</option>
                    <option value="1">Full Day</option>
                    <!-- <option value="3">3 hrs</option>
                    <option value="4">4 hrs</option>
                    <option value="5">5 hrs</option>
                    <option value="6">6 hrs</option>
                    <option value="7">7 hrs</option>
                    <option value="8">8 hrs</option>
                    <option value="9">9 hrs</option>
                    <option value="10">10 hrs</option>
                    <option value="11">11 hrs</option>
                    <option value="12">12 hrs</option>
                    <option value="13">13 hrs</option>
                    <option value="14">14 hrs</option>
                    <option value="15">15 hrs</option>
                    <option value="16">16 hrs</option>
                    <option value="17">17 hrs</option>
                    <option value="18">18 hrs</option>
                    <option value="19">19 hrs</option>
                    <option value="20">20 hrs</option>
                    <option value="21">21 hrs</option>
                    <option value="22">22 hrs</option>
                    <option value="23">23 hrs</option>
                    <option value="24">24 hrs</option> -->
                  </select>
                </div>
              </div>
              <div id="multiple_leave" style="display:none;">
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_TYPE_MULTIPLE">Leave Type
                  </label>
                  <select class="form-control" name="INSRT_LEAVE_TYPE_MULTIPLE" id="INSRT_LEAVE_TYPE_MULTIPLE">
                    <option value="">Choose...</option>
                    <?php 
                      foreach($DISP_LEAVETYPES_INFO as $DISP_LEAVETYPES_INFO_ROW){
                      ?>
                        <option value="<?= $DISP_LEAVETYPES_INFO_ROW->name ?>"><?= $DISP_LEAVETYPES_INFO_ROW->name ?></option>
                      <?php
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_DATE_FROM">From Date
                  </label>
                  <input class="form-control" type="date" name="INSRT_LEAVE_DATE_FROM" id="INSRT_LEAVE_DATE_FROM">
                </div>
                <div class="form-group">
                  <label class="required" for="INSRT_LEAVE_DATE_TO">To Date
                  </label>
                  <input class="form-control" type="date" name="INSRT_LEAVE_DATE_TO" id="INSRT_LEAVE_DATE_TO">
                </div>
              </div>
            </div>
            
            <div class="col-md-2">
              <div class="form-group w-100 mt-4 float-left">
                <label class="mb-0">Vacation Leave:</label>&nbsp;&nbsp;
                <span class="float-right"><?= $vacation_balance ?></span>
              </div>
              <div class="form-group w-100 mt-4 float-left">
                <label class="mb-0">Sick Leave:</label>&nbsp;&nbsp;
                <span class="float-right"><?= $sick_balance ?></span>
              </div>
              <div class="form-group w-100 mt-4 float-left">
                <label class="mb-0">Maternity Leave:</label>&nbsp;&nbsp;
                <span class="float-right"><?= $maternity_balance ?></span>
              </div>
              <div class="form-group w-100 mt-4 float-left">
                <label class="mb-0">Parental Leave:</label>&nbsp;&nbsp;
                <span class="float-right"><?= $parental_balance ?></span>
              </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3 pr-5">
              <div class="form-group w-100 mt-4 float-left">
                <label class="mb-0">Paternity Leave:</label>&nbsp;&nbsp;
                <span  class="float-right"><?= $paternal_balance ?></span>
              </div>
              <div class="form-group w-100 mt-4 float-left">
                <label class="mb-0">Service Incentive Leave:</label>&nbsp;&nbsp;
                <span  class="float-right"><?= $service_incentive_balance ?></span>
              </div>
              <div class="form-group w-100 mt-4 float-left">
                <label class="mb-0">Solo Incentive Leave:</label>&nbsp;&nbsp;
                <span  class="float-right"><?= $solo_incentive ?></span>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="INSRT_LEAVE_TO_DATE">Reason for Leave
                </label>
                <textarea class="form-control" name="INSRT_LEAVE_COMMENT" id="INSRT_LEAVE_COMMENT" cols="30" rows="5"></textarea>
              </div>
              <div class="form-group" id="leave_file" style="display: none;">
                <label for="INSRT_LEAVE_FILE">Medical Certificate &nbsp;&nbsp; <span class="text-muted">(Optional)</span> 
                </label>
                <div class="row">
                  <div class="col-6">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input fileficker" id="INSRT_LEAVE_FILE" name="INSRT_LEAVE_FILE" multiple="" accept=".jpg, .jpeg, .png">
                            <label class="custom-file-label" for="INSRT_LEAVE_FILE">Choose file</label>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 w-100">
              <input type="hidden" name="EMPL_ID" value="<?= $this->session->userdata('SESS_USER_ID')?>">
              <button class="btn btn-primary float-right" id="INSRT_LEAVE_BTN" type="submit">Apply</button>
            </div>
          </div>
        </form>
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
if($this->session->userdata('SESS_SUCC_MSG_INSRT_APPLY_LEAVE')){
?>
<script>
  Swal.fire(
    "<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_APPLY_LEAVE'); ?>",
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_INSRT_APPLY_LEAVE');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_UPDT_APPLY_LEAVE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_APPLY_LEAVE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_UPDT_APPLY_LEAVE');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_DLT_APPLY_LEAVE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_APPLY_LEAVE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_DLT_APPLY_LEAVE');
}
?>
<?php
if($this->session->userdata('SESS_ERR_MSG_INSRT_APPLY_LEAVE')){
?>
<script>
  Swal.fire(
    "<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_APPLY_LEAVE'); ?>",
    '',
    'warning'
  )
</script>
<?php
$this->session->unset_userdata('SESS_ERR_MSG_INSRT_APPLY_LEAVE');
}
?>
<script>
  $(document).ready(function(){

    // Check if leave is single day or multiple days (bulk)
    $('input[type=radio][name=leave_class]').change(function() {
        if (this.value == 'leave_single_day') {
          $('#single_leave').show(400);
            $('#multiple_leave').hide(400);

            // if single leave is checked, require all the fields under that div
            $('#INSRT_LEAVE_TYPE').prop('required',true);
            $('#INSRT_LEAVE_DATE').prop('required',true);
            $('#INSRT_LEAVE_DURATION').prop('required',true);

            // if multpile leave is checked, require all the fields under that div
            $('#INSRT_LEAVE_TYPE_MULTIPLE').prop('required',false);
            $('#INSRT_LEAVE_DATE_FROM').prop('required',false);
            $('#INSRT_LEAVE_DATE_TO').prop('required',false);
        }
        else if (this.value == 'leave_multiple_days') {
            $('#multiple_leave').show(400);
            $('#single_leave').hide(400);

            // if multpile leave is checked, require all the fields under that div
            $('#INSRT_LEAVE_TYPE_MULTIPLE').prop('required',true);
            $('#INSRT_LEAVE_DATE_FROM').prop('required',true);
            $('#INSRT_LEAVE_DATE_TO').prop('required',true);

            // if single leave is checked, unrequire all the fields under that div
            $('#INSRT_LEAVE_TYPE').prop('required',false);
            $('#INSRT_LEAVE_DATE').prop('required',false);
            $('#INSRT_LEAVE_DURATION').prop('required',false);

        }
    });

    // Show file input when sick leave is chosen
    $('#INSRT_LEAVE_TYPE').change(function(){
      if($('#INSRT_LEAVE_TYPE').val() == 'Sick Leave'){
        $('#leave_file').show(400);
      } else {
        $('#leave_file').hide(400);
      }
    })
    $('#INSRT_LEAVE_TYPE_MULTIPLE').change(function(){
      if($('#INSRT_LEAVE_TYPE_MULTIPLE').val() == 'Sick Leave'){
        $('#leave_file').show(400);
      } else {
        $('#leave_file').hide(400);
      }
    })




    // Get & Display Data to Edit Modal Using Async JS function
    var url = '<?php echo base_url(); ?>leave/getapply_leaveData';
    const openModalButton = document.querySelectorAll('[data-target]');
    openModalButton.forEach(button => {
      button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        getapply_leaveData(url,button.getAttribute('apply_leave_id')).then(data => {
          if(data.length > 0)
          {
            data.forEach((x) => {
              document.getElementById('UPDT_APPLY_LEAVE_INPF_ID').value = x.id;
              document.getElementById('UPDT_APPLY_LEAVE_INPF_NAME').value = x.name;
            });
          }
        });
      });
    });
    async function getapply_leaveData(url,apply_leave_id) {
      var formData = new FormData();
      formData.append('APPLY_LEAVE_GET_APPLY_LEAVE_DATA', apply_leave_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }
    // Update Position
    $('#APPLY_LEAVE_BTN_UPDT').click(function(){
      var apply_leave_name = $('#UPDT_APPLY_LEAVE_INPF_NAME').val();
      var hasErr = 0;
      if(!apply_leave_name){
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
            $('#APPLY_LEAVE_FORM_EDIT').submit();
          }
        })
      }
      else {
        $('#UPDT_APPLY_LEAVE_INPF_NAME').addClass('is-invalid');
      }
    })
    $('#UPDT_APPLY_LEAVE_INPF_NAME').keyup(function(){
      $('#UPDT_APPLY_LEAVE_INPF_NAME').removeClass('is-invalid');
    })
    // Delete Position
    $('.APPLY_LEAVE_BTN_DLT').click(function(e){
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
          window.location.href = "<?= base_url(); ?>leave/dlt_apply_leave?delete_id="+user_deleteKey;
        }
      })
    })
  })
</script>
</body>
</html>
