<style>
  .card{
    padding: 0px 14px 10px;
  }
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
    border-top: none !important;
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
<div class="content-wrapper">
  <div class="p-3">
    <div class="flex-fill">
      <div class="row pr-3 mb-2">
        <div class="col">
          <h1 class="page-title">Disciplinary Case
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
        <div class="col ml-auto">
          <!-- <a class="btn btn-primary float-right" title="Add" href="#" data-toggle="modal" data-target="#modal_add_disp_case"> -->
          <a class="btn btn-primary float-right" title="Add" href="#">
            <i class="fas fa-fw fa-plus">
            </i> Add
          </a>
        </div>
      </div>
      <div class="card">
        <table class="table table-hover table-xs">
          <thead>
            <tr class="py-3">
              <th class="py-3">Employee</th>
              <th class="py-3">Case Name</th>
              <th class="py-3" style="width: 500px;">Description</th>
              <th class="py-3">Created By</th>
              <th class="py-3">Created On</th>
              <th class="py-3 text-center" style="width: 150px;">Disciplinary Actions</th>
              <th class="py-3">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Juan Dela Cruz</td>
              <td>Using company property for personal purposes</td>
              <td>Last week, company vehicle was used unnecessarily for his personal journeys.</td>
              <td>Admin</td>
              <td>Thu, 27 Sep 2021</td>
              <td class="text-center">View</td>
              <td>In Progress</td>
            </tr>
            <tr>
              <td>Tom Walker</td>
              <td>Drug and alcohol use</td>
              <td>Walker has bought some drugs and sold them to his colleagues during the working hours.</td>
              <td>Kevin Del Evaristo</td>
              <td>Thu, 25 Apr 2021</td>
              <td class="text-center">View</td>
              <td>In Progress</td>
            </tr>
            <tr>
              <td>Russel Cruz</td>
              <td>Verbal abuse and violent conduct</td>
              <td>Verbal abuse and violent conduct against a co-worker</td>
              <td>Admin</td>
              <td>Fri, 31 Mar 2020</td>
              <td class="text-center">View</td>
              <td>In Progress</td>
            </tr>
            <tr>
              <td>Brody Alan</td>
              <td>Stolen a company owned mobile phone</td>
              <td>Brody has stolen a company owned Apple mobile phone which was used as a shared device among QA Engineers for testing purposes.</td>
              <td>Admin</td>
              <td>Sun, 11 Aug 2020</td>
              <td class="text-center">View</td>
              <td>Close</td>
            </tr>
            <tr>
              <td>Kevin Mathews</td>
              <td>Parked his car in handicap parking without permit</td>
              <td>This would be the 2nd and the last warning</td>
              <td>Admin</td>
              <td>Fri, 23 Jan 2019</td>
              <td class="text-center">View</td>
              <td>Close</td>
            </tr>
            

<!--             <?php
if($DISP_DISP_CASE_INFO){
foreach($DISP_DISP_CASE_INFO as $ROW_DISP_CASE_INFO){ ?>
            <tr>
              <td><?=$ROW_DISP_CASE_INFO->name?></td>
              
              <td class="">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                  <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                    <a class="btn btn-sm indigo lighten-2" disp_case_id="<?=$ROW_DISP_CASE_INFO->id?>" title="Edit" data-toggle="modal" data-target="#modal_edit_disp_case" >
                      <i class="fas fa-edit">
                      </i>
                    </a>
                    <a class="btn btn-sm indigo lighten-2 text-danger DISP_CASE_BTN_DLT" delete_key="<?=$ROW_DISP_CASE_INFO->id?>">
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
<div class="modal fade" id="modal_add_disp_case" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Add Disciplinary Case
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('discipline/insrt_disp_case'); ?>" id="DISP_CASE_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="DISP_CASE_INPF_NAME">Name
                </label>
                <input class="form-control form-control " type="text" name="DISP_CASE_INPF_NAME" id="DISP_CASE_INPF_NAME">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class='btn btn-primary text-light' id="DISP_CASE_BTN_SAVE">&nbsp; Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit position -->
<div class="modal fade" id="modal_edit_disp_case" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Disciplinary Case
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('discipline/updt_disp_case'); ?>" id="DISP_CASE_FORM_EDIT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="asset_code">Name
                </label>
                <input class="form-control form-control " type="text" name="UPDT_DISP_CASE_INPF_NAME" id="UPDT_DISP_CASE_INPF_NAME" required>
              </div>
            </div>
            <input type="hidden" name="UPDT_DISP_CASE_INPF_ID" id="UPDT_DISP_CASE_INPF_ID">
          </div>
        </div>
        <div class="modal-footer">
          <a class='btn btn-primary text-light' id="DISP_CASE_BTN_UPDT">&nbsp; Update
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
if($this->session->userdata('SESS_SUCC_MSG_INSRT_DISP_CASE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_DISP_CASE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_INSRT_DISP_CASE');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_UPDT_DISP_CASE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_DISP_CASE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_UPDT_DISP_CASE');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_DLT_DISP_CASE')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_DISP_CASE'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_DLT_DISP_CASE');
}
?>
<script>
  $(document).ready(function(){
    // Get & Display Data to Edit Modal Using Async JS function
    var url = '<?php echo base_url(); ?>discipline/getDISP_CASEData';
    const openModalButton = document.querySelectorAll('[data-target]');
    openModalButton.forEach(button => {
      button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        getDISP_CASEData(url,button.getAttribute('disp_case_id')).then(data => {
          if(data.length > 0)
          {
            data.forEach((x) => {
              document.getElementById('UPDT_DISP_CASE_INPF_ID').value = x.id;
              document.getElementById('UPDT_DISP_CASE_INPF_NAME').value = x.name;
            });
          }
        });
      });
    });
    async function getDISP_CASEData(url,disp_case_id) {
      var formData = new FormData();
      formData.append('DISP_CASE_GET_DISP_CASE_DATA', disp_case_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }
    // Update Position
    $('#DISP_CASE_BTN_UPDT').click(function(){
      var disp_case_name = $('#UPDT_DISP_CASE_INPF_NAME').val();
      var hasErr = 0;
      if(!disp_case_name){
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
            $('#DISP_CASE_FORM_EDIT').submit();
          }
        })
      }
      else {
        $('#UPDT_DISP_CASE_INPF_NAME').addClass('is-invalid');
      }
    })
    $('#UPDT_DISP_CASE_INPF_NAME').keyup(function(){
      $('#UPDT_DISP_CASE_INPF_NAME').removeClass('is-invalid');
    })
    // Delete Position
    $('.DISP_CASE_BTN_DLT').click(function(e){
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
          window.location.href = "<?= base_url(); ?>discipline/dlt_disp_case?delete_id="+user_deleteKey;
        }
      })
    })
  })
</script>
</body>
</html>
