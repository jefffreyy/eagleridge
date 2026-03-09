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
          <li class="breadcrumb-item active" aria-current="page">Other Taxable Income
          </li>
        </ol>
      </nav>
      <div class="row pr-3 mb-2">
        <div class="col">
          <h1 class="page-title">Other Taxable Income
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
        <!-- <div class="col ml-auto">
          <a class="btn btn-primary float-right" title="Add" href="#" data-toggle="modal" data-target="#modal_add_OtherTaxableIncome">
            <i class="fas fa-fw fa-plus">
            </i> Add
          </a>
        </div> -->
      </div>
      <div class="card">
        <table class="table table-hover table-xs">
          <thead>
            <tr>
              <th>Name
              </th>
              <th>Value
              </th>
              <th>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
if($DISP_OTHERTAXABLEINCOME_INFO){
foreach($DISP_OTHERTAXABLEINCOME_INFO as $ROW_OTHERTAXABLEINCOME_INFO){ ?>
            <tr>
              <td>
                <?=$ROW_OTHERTAXABLEINCOME_INFO->name?>
              </td>
              <td>
                <?=$ROW_OTHERTAXABLEINCOME_INFO->value?>
              </td>
              <td class="">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                  <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                    <a class="btn btn-sm indigo lighten-2" OtherTaxableIncome_id="<?=$ROW_OTHERTAXABLEINCOME_INFO->id?>" title="Edit" data-toggle="modal" data-target="#modal_edit_OtherTaxableIncome" >
                      <i class="fas fa-edit">
                      </i>
                    </a>
                    <!-- <a class="btn btn-sm indigo lighten-2 text-danger OTHERTAXABLEINCOME_BTN_DLT" delete_key="<?=$ROW_OTHERTAXABLEINCOME_INFO->id?>">
                      <i class="fas fa-trash">
                      </i>
                    </a> -->
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
<div class="modal fade" id="modal_add_OtherTaxableIncome" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Add Other Taxable Income
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('settings/insrt_OtherTaxableIncome'); ?>" id="OTHERTAXABLEINCOME_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="OTHERTAXABLEINCOME_INPF_NAME">Name
                </label>
                <input class="form-control form-control " type="text" name="OTHERTAXABLEINCOME_INPF_NAME" id="OTHERTAXABLEINCOME_INPF_NAME">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class='btn btn-primary text-light' id="OTHERTAXABLEINCOME_BTN_SAVE">&nbsp; Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit position -->
<div class="modal fade" id="modal_edit_OtherTaxableIncome" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Other Taxable Income
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('settings/updt_OtherTaxableIncome'); ?>" id="OTHERTAXABLEINCOME_FORM_EDIT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="UPDT_OTHERTAXABLEINCOME_INPF_NAME">Name
                </label>
                <input class="form-control form-control " type="text" name="UPDT_OTHERTAXABLEINCOME_INPF_NAME" id="UPDT_OTHERTAXABLEINCOME_INPF_NAME" required>
              </div>
              <div class="form-group">
                <label class="required " for="UPDT_OTHERTAXABLEINCOME_INPF_VALUE">Value
                </label>
                <input class="form-control form-control " type="text" name="UPDT_OTHERTAXABLEINCOME_INPF_VALUE" id="UPDT_OTHERTAXABLEINCOME_INPF_VALUE" required>
              </div>
            </div>
            <input type="hidden" name="UPDT_OTHERTAXABLEINCOME_INPF_ID" id="UPDT_OTHERTAXABLEINCOME_INPF_ID">
          </div>
        </div>
        <div class="modal-footer">
          <a class='btn btn-primary text-light' id="OTHERTAXABLEINCOME_BTN_UPDT">&nbsp; Update
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
if($this->session->userdata('SESS_SUCC_MSG_INSRT_OTHERTAXABLEINCOME')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_OTHERTAXABLEINCOME'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_INSRT_OTHERTAXABLEINCOME');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_UPDT_OTHERTAXABLEINCOME')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_OTHERTAXABLEINCOME'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_UPDT_OTHERTAXABLEINCOME');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_DLT_OTHERTAXABLEINCOME')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_OTHERTAXABLEINCOME'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_DLT_OTHERTAXABLEINCOME');
}
?>
<script>
  $(document).ready(function(){
    // Get & Display Data to Edit Modal Using Async JS function
    var url = '<?php echo base_url(); ?>settings/getOtherTaxableIncomeData';
    const openModalButton = document.querySelectorAll('[data-target]');
    openModalButton.forEach(button => {
      button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        getOtherTaxableIncomeData(url,button.getAttribute('OtherTaxableIncome_id')).then(data => {
          if(data.length > 0)
          {
            data.forEach((x) => {
              document.getElementById('UPDT_OTHERTAXABLEINCOME_INPF_ID').value = x.id;
              document.getElementById('UPDT_OTHERTAXABLEINCOME_INPF_NAME').value = x.name;
              document.getElementById('UPDT_OTHERTAXABLEINCOME_INPF_VALUE').value = x.value;
            });
          }
        });
      });
    });
    async function getOtherTaxableIncomeData(url,OtherTaxableIncome_id) {
      var formData = new FormData();
      formData.append('OTHERTAXABLEINCOME_GET_OTHERTAXABLEINCOME_DATA', OtherTaxableIncome_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }
    // Update Position
    $('#OTHERTAXABLEINCOME_BTN_UPDT').click(function(){
      var OtherTaxableIncome_name = $('#UPDT_OTHERTAXABLEINCOME_INPF_NAME').val();
      var hasErr = 0;
      if(!OtherTaxableIncome_name){
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
            $('#OTHERTAXABLEINCOME_FORM_EDIT').submit();
          }
        })
      }
      else {
        $('#UPDT_OTHERTAXABLEINCOME_INPF_NAME').addClass('is-invalid');
      }
    })
    $('#UPDT_OTHERTAXABLEINCOME_INPF_NAME').keyup(function(){
      $('#UPDT_OTHERTAXABLEINCOME_INPF_NAME').removeClass('is-invalid');
    })
    // Delete Position
    $('.OTHERTAXABLEINCOME_BTN_DLT').click(function(e){
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
          window.location.href = "<?= base_url(); ?>settings/dlt_OtherTaxableIncome?delete_id="+user_deleteKey;
        }
      })
    })
  })
</script>
</body>
</html>
