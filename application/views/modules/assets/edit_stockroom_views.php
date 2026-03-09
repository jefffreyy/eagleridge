<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper" style="min-height: 624px;">

    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
        <h2><a href="<?= base_url() . 'assets/stockrooms'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">
                        <?php echo form_open('assets/update_stockroom'); ?>

                        <div class="row">
                            <div class="col-md-12">


                            <div class="form-group">
                                    <input type="hidden" name="id" value="<?= $DISP_STOCKROOM->id ?>">
                                    <label class="required" for="INSRT_ASSET_NAME">Name</label>
                                    <input class="form-control" value="<?= $DISP_STOCKROOM->name ?>" type="text" name="name" id="INSRT_ASSET_NAME" required>
                                </div>


                            </div>
                        </div>


                        <div class="mr-2" style="float: right !important">

                            <button type='submit' id="btn_add" class="btn technos-button-blue shadow-none rounded " ;="">

                                Submit</button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php $this->load->view('templates/jquery_link'); ?>

<?php

if ($this->session->flashdata('SUCC')) {

?>

    <script>
        Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
    </script>

<?php

}

?>

<?php

if ($this->session->flashdata('ERR')) {

?>

    <script>
        Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',

            '',

            'error'

        )
    </script>

<?php

}

?>