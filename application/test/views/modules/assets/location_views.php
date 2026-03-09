<!------------------------------------------------------ A. PAGE INFORMATION  -----------------------------------------------------
  
TECHNOS SYSTEM ENGINEERING INC.
EyeBox HRMS

@author     Technos Developers
@datetime   23 November 2022
@purpose    Setting / Location

CONTROLLER FILES:


MODEL FILES:
  





----------------------------------------------------------- A. STYLESHEETS  ----------------------------------------------------->

<?php $this->load->view('templates/css_link'); ?>

<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<?php 
  $id_code = "LOC";
?>

<div class="content-wrapper">
  <div class="p-3">
    <div class="flex-fill">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
          <a href="<?= base_url() ?>nav_assets">Asset</a>
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Location
          </li>
        </ol>
      </nav>
      <div class="row pr-3 mb-2">
        <div class="col">
          <h1 class="page-title">Location
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
          <a class="btn btn-primary float-right" title="Add" href="#" data-toggle="modal" data-target="#modal_add_location">
            <i class="fas fa-fw fa-plus">
            </i> Add
          </a>
        </div>
      </div>
      <div class="card">
        <table class="table table-hover table-xs">
          <thead>
            <tr>
              <th>Location ID</th>
              <th>Name
              </th>
              <th>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
if($DISP_LOCATION_INFO){
foreach($DISP_LOCATION_INFO as $ROW_LOCATION_INFO){
  $application_id = $id_code . str_pad($ROW_LOCATION_INFO->id, 5, '0', STR_PAD_LEFT); ?>
            <tr>
              <td>
                <?= $application_id ?>
              </td>
              <td>
                <?=$ROW_LOCATION_INFO->name?>
              </td>
              <td class="">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                  <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                    <a class="btn btn-sm indigo lighten-2" location_id="<?=$ROW_LOCATION_INFO->id?>" title="Edit" data-toggle="modal" data-target="#modal_edit_location" >
                      <i class="fas fa-edit">
                      </i>
                    </a>
                    <a class="btn btn-sm indigo lighten-2 text-danger LOC_BTN_DLT" delete_key="<?=$ROW_LOCATION_INFO->id?>">
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
<div class="modal fade" id="modal_add_location" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Add Location
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('settings/insrt_location'); ?>" id="LOC_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="LOC_INPF_NAME">Name
                </label>
                <input class="form-control form-control " type="text" name="LOC_INPF_NAME" id="LOC_INPF_NAME">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class='btn btn-primary text-light' id="LOC_BTN_SAVE">&nbsp; Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit position -->
<div class="modal fade" id="modal_edit_location" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0" style="border-bottom: none;">
        <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Location
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <form action="<?php echo base_url('settings/updt_location'); ?>" id="LOC_FORM_EDIT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="required " for="asset_code">Name
                </label>
                <input class="form-control form-control " type="text" name="UPDT_LOC_INPF_NAME" id="UPDT_LOC_INPF_NAME" required>
              </div>
            </div>
            <input type="hidden" name="UPDT_LOC_INPF_ID" id="UPDT_LOC_INPF_ID">
          </div>
        </div>
        <div class="modal-footer">
          <a class='btn btn-primary text-light' id="LOC_BTN_UPDT">&nbsp; Update
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



  <!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
  <?php $this->load->view('templates/jquery_link'); ?>





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
if($this->session->userdata('SESS_SUCC_MSG_INSRT_LOC')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_LOC'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_INSRT_LOC');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_UPDT_LOC')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDT_LOC'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_UPDT_LOC');
}
?>
<?php
if($this->session->userdata('SESS_SUCC_MSG_DLT_LOC')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('SESS_SUCC_MSG_DLT_LOC'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_DLT_LOC');
}
?>
<script>
  $(document).ready(function(){
    // Get & Display Data to Edit Modal Using Async JS function
    var url = '<?php echo base_url(); ?>settings/getLocationData';
    const openModalButton = document.querySelectorAll('[data-target]');
    openModalButton.forEach(button => {
      button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.target);
        getLocationData(url,button.getAttribute('location_id')).then(data => {
          if(data.length > 0)
          {
            data.forEach((x) => {
              document.getElementById('UPDT_LOC_INPF_ID').value = x.id;
              document.getElementById('UPDT_LOC_INPF_NAME').value = x.name;
            });
          }
        });
      });
    });
    async function getLocationData(url,location_id) {
      var formData = new FormData();
      formData.append('LOC_GET_LOC_DATA', location_id);
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      return response.json();
    }
    // Update Position
    $('#LOC_BTN_UPDT').click(function(){
      var location_name = $('#UPDT_LOC_INPF_NAME').val();
      var hasErr = 0;
      if(!location_name){
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
            $('#LOC_FORM_EDIT').submit();
          }
        })
      }
      else {
        $('#UPDT_LOC_INPF_NAME').addClass('is-invalid');
      }
    })
    $('#UPDT_LOC_INPF_NAME').keyup(function(){
      $('#UPDT_LOC_INPF_NAME').removeClass('is-invalid');
    })
    // Delete Position
    $('.LOC_BTN_DLT').click(function(e){
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
          window.location.href = "<?= base_url(); ?>settings/dlt_location?delete_id="+user_deleteKey;
        }
      })
    })
  })
</script>
</body>
</html>