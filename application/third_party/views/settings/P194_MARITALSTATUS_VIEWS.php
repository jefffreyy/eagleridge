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
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Include Editor style. -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<div class="content-wrapper">
  <div class="p-3">
    <div class="flex-fill">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?=base_url()?>settings">Settings
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Marital Status
          </li>
        </ol>
      </nav>
      <div class="row pr-3 mb-2">
        <div class="col">
          <h1 class="page-title">Marital Status
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
          <a class="btn btn-primary float-right" title="Add" href="#" data-toggle="modal" data-target="#modal_add_martial_status">
            <i class="fas fa-fw fa-plus">
            </i> Add
          </a>
        </div>
      </div>
      <div class="card">
        <table class="table table-hover table-xs">
          <thead>
            <tr>
              <th>Name
              </th>
              <th>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
if($DISP_MRTL_STAT_INFO){
foreach($DISP_MRTL_STAT_INFO as $ROW_MRTL_STAT_INFO){ ?>
            <tr>
              <td>
                <?=$ROW_MRTL_STAT_INFO->name?>
              </td>
              <td class="">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                  <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                    <a class="btn btn-sm indigo lighten-2" martial_status_id="<?=$ROW_MRTL_STAT_INFO->id?>" title="Edit" data-toggle="modal" data-target="#modal_edit_martial_status" >
                      <i class="fas fa-edit">
                      </i>
                    </a>
                    <a class="btn btn-sm indigo lighten-2 text-danger MRTL_STAT_BTN_DLT" delete_key="<?=$ROW_MRTL_STAT_INFO->id?>">
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
<!-- /.control-sidebar -->
<!-- Add position -->
<div class="modal fade" id="modal_add_martial_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Add Marital Status
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('settings/insrt_martial_status'); ?>" id="MRTL_STAT_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="MRTL_STAT_INPF_NAME">Name
                </label>
                <input class="form-control form-control " type="text" name="MRTL_STAT_INPF_NAME" id="MRTL_STAT_INPF_NAME">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class='btn btn-primary text-light' id="MRTL_STAT_BTN_SAVE">&nbsp; Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit position -->
<div class="modal fade" id="modal_edit_martial_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Marital Status
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('settings/updt_martial_status'); ?>" id="MRTL_STAT_FORM_EDIT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="asset_code">Name
                </label>
                <input class="form-control form-control " type="text" name="UPDT_MRTL_STAT_INPF_NAME" id="UPDT_MRTL_STAT_INPF_NAME" required>
              </div>
            </div>
            <input type="hidden" name="UPDT_MRTL_STAT_INPF_ID" id="UPDT_MRTL_STAT_INPF_ID">
          </div>
        </div>
        <div class="modal-footer">
          <a class='btn btn-primary text-light' id="MRTL_STAT_BTN_UPDT">&nbsp; Update
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
if($this->session->userdata('SESS_SUCC_MSG_INSRT_MRTL_STAT')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_MRTL_STAT'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_INSRT_MRTL_STAT');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_UPDT_MRTL_STAT')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_MRTL_STAT'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_UPDT_MRTL_STAT');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_DLT_MRTL_STAT')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_MRTL_STAT'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_DLT_MRTL_STAT');
}
?>
<script>
  $(document).ready(function(){
    // Get & Display Data to Edit Modal Using Async JS function
    var url = '<?php echo base_url(); ?>settings/getmrtl_statData';
    const openModalButton = document.querySelectorAll('[data-target]');
    openModalButton.forEach(button => {
      button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        getmrtl_statData(url,button.getAttribute('martial_status_id')).then(data => {
          if(data.length > 0)
          {
            data.forEach((x) => {
              document.getElementById('UPDT_MRTL_STAT_INPF_ID').value = x.id;
              document.getElementById('UPDT_MRTL_STAT_INPF_NAME').value = x.name;
            });
          }
        });
      });
    });
    async function getmrtl_statData(url,martial_status_id) {
      var formData = new FormData();
      formData.append('MRTL_STAT_GET_MRTL_STAT_DATA', martial_status_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }
    // Update Position
    $('#MRTL_STAT_BTN_UPDT').click(function(){
      var martial_status_name = $('#UPDT_MRTL_STAT_INPF_NAME').val();
      var hasErr = 0;
      if(!martial_status_name){
        hasErr++;
      }
      if(hasErr == 0){
        Swal.fire({
          title: 'Do you want to save the following changes?',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        } ).then((result) => {
          if (result.isConfirmed) {
            $('#MRTL_STAT_FORM_EDIT').submit();
          }
        })
      }
      else {
        $('#UPDT_MRTL_STAT_INPF_NAME').addClass('is-invalid');
      }
    })
    $('#UPDT_MRTL_STAT_INPF_NAME').keyup(function(){
      $('#UPDT_MRTL_STAT_INPF_NAME').removeClass('is-invalid');
    })
    // Delete Position
    $('.MRTL_STAT_BTN_DLT').click(function(e){
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
          window.location.href = "<?= base_url(); ?>settings/dlt_martial_status?delete_id="+user_deleteKey;
        }
      })
    })
  })
</script>
</body>
</html>
