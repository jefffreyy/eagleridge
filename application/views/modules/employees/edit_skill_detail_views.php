<html>
<?php $this->load->view('templates/css_link'); ?>
<?php
$user_id    = $C_EMP_ID;
$skill_id   = '';
$name       = '';
$value      = '';
if ($C_SKILLS_MATRIX) {
    foreach ($C_SKILLS_MATRIX as $C_SKILLS_MATRIX_ROW) {
        $skill_id               = $C_SKILLS_MATRIX_ROW->id;
        $name                   = $C_SKILLS_MATRIX_ROW->name;
        $value                  = $C_SKILLS_MATRIX_ROW->value;
    }
}
?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>employees/directories">Employee List</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>employees/personal?id=<?= $user_id ?>">Personal Details</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><?= $C_current_page ?>
                </li>
            </ol>
        </nav>
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title"><a href="<?= base_url() ?>employees/personal?id=<?= $user_id ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">
                    </a>&nbsp;Add Skill<h1>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <form action="<?php echo base_url() ?>employees/<?= $C_FUNCTION ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php $this->load->view('modules/employees/partials/_skill_detail', array("SKILLS_NAME" => $C_SKILLS_NAME, "SKILLS_LEVEL" => $C_SKILLS_LEVEL, "SKILLS_MATRIX" => $C_SKILLS_MATRIX)) ?>
                                    <div class="modal-footer">
                                        <button type="submit" href="#" class="btn btn-success px-5 float-right">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<aside class="control-sidebar control-sidebar-dark"> </aside>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

</script>
<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<?php

if ($this->session->userdata('SESS_SUCC_UPDT')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_UPDT'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_UPDT');
}
?>
<?php function convert_id2name($array, $pos)
{
    $name = "";
    foreach ($array as $e) {
        if ($e->id == $pos) {
            $name = $e->name;
        }
    }
    if ($name == "") {
        $name = "error: can't be found";
    }
    return $name;
}
?>
</body>

</html>