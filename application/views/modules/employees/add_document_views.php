<html>
<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>employees/directories">Employee List</a></li>

                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>employees/personal?id=<?= $C_USER_ID ?>">Personal Info</a> </li>

                <li class="breadcrumb-item active" aria-current="page">Add Document </li>
            </ol>
        </nav>

        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title"><a href="<?= base_url() ?>employees/personal?id=<?= $C_USER_ID ?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Add Documents<h1>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <form action="<?php echo base_url('employees/save_document'); ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="user_id" value="<?= $C_USER_ID ?>">
                                    <label for="customFile">Document</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="document" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>

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

<aside class="control-sidebar control-sidebar-dark">
</aside>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script> $.widget.bridge('uibutton', $.ui.button) </script>
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
if ($this->session->flashdata('SESS_SUCC_DOC')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->flashdata('SESS_SUCC_DOC'); ?>',
            '',
            'success'
        )
    </script>
<?php
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

<script>
    $(document).ready(function() {
        var input = $("#customFile");
        var label = $(".custom-file-label");
        input.on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            label.html(fileName);
        });
    })
</script>
</body>

</html>