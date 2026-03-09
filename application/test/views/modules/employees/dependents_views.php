<html>
<?php
$user_id    = $C_EMP_ID;
?>
<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">

    <div class="container-fluid p-4">

        <nav aria-label="breadcrumb">

            <ol class="breadcrumb">

                <li class="breadcrumb-item">

                    <a href="<?= base_url() ?>employees/directories">Employee List</a>

                </li>

                <li class="breadcrumb-item">

                    <a href="<?= base_url() ?>employees/personal?id=<?=$user_id?>" >Personal Details</a>

                </li>

                <li class="breadcrumb-item active" aria-current="page">Add dependents

                </li>

            </ol>

        </nav>



        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <!-- form start -->

                    <form action="<?php echo base_url()?>employees/<?=$C_FUNCTION?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        
                        <div class="modal-body pb-5">
                            <?php $this->load->view('modules/employees/partials/_dependent',array("DEPENT_DATA"=>$C_DEPENT_DATA))?>
                            <div class="row">

                                <div class="col-md-12">

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