<html>

<?php $this->load->view('templates/css_link'); ?>


<div class="content-wrapper">

    <div class="container-fluid p-4">

        <nav aria-label="breadcrumb">

            <ol class="breadcrumb">

                <li class="breadcrumb-item">

                    <a href="<?= base_url() ?>employees/directories">Employee List</a>

                </li>
                <li class="breadcrumb-item">

                    <a href="<?= base_url() ?>employees/personal?id=<?=$C_USER_ID?>">Personal Info</a>

                </li>
                <li class="breadcrumb-item active" aria-current="page"><?=$current_page?>

                </li>

            </ol>

        </nav>



        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <!-- form start -->

                    <form action="<?=base_url();?>employees/<?=$C_function?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">

                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="user_id" value="<?=$C_USER_ID?>">
                                    <?php $this->load->view("modules/employees/partials/_emergency_contact",array("contact_info"=>$C_emergency_contact)) ?>
                                    <div class="modal-footer">
                                        <button type="submit" href="#" class="btn btn-success px-5 float-right">Submit</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>

                    <!-- form ends -->

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

<!-- jQuery -->

<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>

<!-- jQuery UI 1.11.4 -->

<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<script>

    $.widget.bridge('uibutton', $.ui.button)

</script>

<!-- Bootstrap 4 -->

<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- jQuery Knob Chart -->

<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>

<!-- Summernote -->

<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>

<!-- overlayScrollbars -->

<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- AdminLTE App -->

<script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>

<!-- Full Calendar 2.2.5 -->

<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>

<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>

<!-- Sweet Alert -->

<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>

<!-- Toastr -->

<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>

<!-- AdminLTE for demo purposes -->

<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>





<?php

if ($this->session->flashdata('SESS_SUCC')) {

?>

    <script>

        Swal.fire(

            '<?php echo $this->session->flashdata('SESS_SUCC'); ?>',

            '',

            'success'

        )

    </script>

<?php

}
else if($this->session->flashdata('SESS_ERR')){ ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '<?php echo $this->session->flashdata('SESS_ERR')?>',
        })
</script>
    
<?php }

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