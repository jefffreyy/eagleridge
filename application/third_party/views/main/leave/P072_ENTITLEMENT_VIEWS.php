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
<div class="content-wrapper">
  <div class="p-3">
    <div class="flex-fill">
      <div class="row pr-3 mb-2">
        <div class="col">
          <h1 class="page-title">Entitlement
          </h1>
        </div>
      </div>
      <div class="card p-4">
        <!-- <div class="card-header" style="background-color: #fff !important; border-bottom: none !important;">
          
        </div> -->
        <form action="<?php echo base_url('leave/insrt_entitlement'); ?>" id="assign_leave_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
          <div class="row">
            <div class="col-md-6" style="border-right: 1px solid #ccc;">
                <div class="form-group">
                    <label class="required" for="INSRT_ASSIGN_EMPL">Assign to Employee
                    </label>
                    <select class="form-control" name="INSRT_ASSIGN_EMPL" id="INSRT_ASSIGN_EMPL" required>
                      <option value="">Choose...</option>
                      <?php 
                          foreach($DISP_EMPL_INFO as $DISP_EMPL_INFO_ROW){
                            if($DISP_EMPL_INFO_ROW->col_empl_repo == $this->session->userdata('SESS_USER_ID')){
                          ?>
                              <option value="<?= $DISP_EMPL_INFO_ROW->id ?>"><?= $DISP_EMPL_INFO_ROW->col_frst_name.' '.$DISP_EMPL_INFO_ROW->col_last_name ?></option>
                          <?php
                            }
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
                            foreach($DISP_LEAVETYPES_INFO as $DISP_LEAVETYPES_INFO_ROW){
                            ?>
                            <option value="<?= $DISP_LEAVETYPES_INFO_ROW->name ?>"><?= $DISP_LEAVETYPES_INFO_ROW->name ?></option>
                            <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label class="required" for="INSRT_LEAVE_VALUE">Value (Hours)
                    </label>
                    <input class="form-control" type="number" name="INSRT_LEAVE_VALUE" id="INSRT_LEAVE_VALUE" step="0.1" placeholder="Enter number of hours" required>
                </div>
                <!-- <small id="valueHelp" class="form-text text-muted">(If you want to include half of a day, just include .5)</small> -->
            </div>

            <div class="col-md-2">
                <div class="form-group w-100 mt-4 float-left">
                  <label class="mb-0">Vacation Leave:</label>&nbsp;&nbsp;
                  <span class="float-right" id="vacation_balance">0</span>
                </div>
                <div class="form-group w-100 mt-4 float-left">
                  <label class="mb-0">Sick Leave:</label>&nbsp;&nbsp;
                  <span class="float-right" id="sick_balance">0</span>
                </div>
                <div class="form-group w-100 mt-4 float-left">
                  <label class="mb-0">Maternity Leave:</label>&nbsp;&nbsp;
                  <span class="float-right" id="maternity_balance">0</span>
                </div>
                <div class="form-group w-100 mt-4 float-left">
                  <label class="mb-0">Parental Leave:</label>&nbsp;&nbsp;
                  <span class="float-right" id="parental_balance">0</span>
                </div>
            </div>

            <div class="col-md-1"></div>

            <div class="col-md-3 pr-5">
                <div class="form-group w-100 mt-4 float-left">
                  <label class="mb-0">Paternity Leave:</label>&nbsp;&nbsp;
                  <span class="float-right" id="paternal_balance">0</span>
                </div>
                <div class="form-group w-100 mt-4 float-left">
                  <label class="mb-0">Service Incentive Leave:</label>&nbsp;&nbsp;
                  <span class="float-right" id="service_incentive_balance">0</span>
                </div>
                <div class="form-group w-100 mt-4 float-left">
                  <label class="mb-0">Solo Incentive Leave:</label>&nbsp;&nbsp;
                  <span class="float-right" id="solo_incentive_balance">0</span>
                </div>
            </div>

          </div>
          <br>
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
              <input type="hidden" name="INSRT_ASSIGNED_BY" value="<?= $this->session->userdata('SESS_USER_ID')?>">
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
<!-- SESSION MESSAGES -->
<?php
if($this->session->userdata('SESS_SUCC_MSG_INSRT_ENTITLEMENT')){
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
<script>
  $(document).ready(function(){

    var url = '<?php echo base_url(); ?>leave/getEmployeeData';
    $('#INSRT_ASSIGN_EMPL').change(function(){
      var employee_id = $('#INSRT_ASSIGN_EMPL').val();
      console.log(employee_id);
      getEmployeeData(url,employee_id).then(data => {
        if(data.length > 0)
        {
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

    async function getEmployeeData(url,employee_id) {
      var formData = new FormData();
      formData.append('employee_id', employee_id);
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
