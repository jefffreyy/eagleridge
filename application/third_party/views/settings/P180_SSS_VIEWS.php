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
          <li class="breadcrumb-item active" aria-current="page">SSS
          </li>
        </ol>
      </nav>
      <div class="row pr-3 mb-2">
        <div class="col">
          <h1 class="page-title">Social Security System (SSS)
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
        </div>
      </div>
      <div class="card">
        <table class="table table-hover table-xs">
          <thead>
            <tr>
              <th>Year</th>
              <th>Salary min</th>
              <th>Salary max</th>
              <th>RSS_ER</th>
              <th>RSS_EE</th>
              <th>RSS_TOT</th>
              <th>EC_ER</th>
              <th>EC_EE</th>
              <th>EC_TOT</th>
              <th>MPF_ER</th>
              <th>MPF_EE</th>
              <th>MPF_TOT</th>
              <th>ER</th>
              <th>EE</th>
              <th>TOTAL</th>
            </tr>
          </thead>
          <tbody>
            <?php
if($DISP_SSS_INFO){
foreach($DISP_SSS_INFO as $ROW_SSS_INFO){ ?>
            <tr>
              <td><?=$ROW_SSS_INFO->year?></td>
              <td><?=$ROW_SSS_INFO->salary_min?></td>
              <td><?=$ROW_SSS_INFO->salary_max?></td>
              <td><?=$ROW_SSS_INFO->rss_er?></td>
              <td><?=$ROW_SSS_INFO->rss_ee?></td>
              <td><?=$ROW_SSS_INFO->rss_tot?></td>
              <td><?=$ROW_SSS_INFO->ec_er?></td>
              <td><?=$ROW_SSS_INFO->ec_ee?></td>
              <td><?=$ROW_SSS_INFO->ec_tot?></td>
              <td><?=$ROW_SSS_INFO->mpf_er?></td>
              <td><?=$ROW_SSS_INFO->mpf_ee?></td>
              <td><?=$ROW_SSS_INFO->mpf_tot?></td>
              <td><?=$ROW_SSS_INFO->er?></td>
              <td><?=$ROW_SSS_INFO->ee?></td>
              <td><?=$ROW_SSS_INFO->tot?></td>
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
</body>
</html>
