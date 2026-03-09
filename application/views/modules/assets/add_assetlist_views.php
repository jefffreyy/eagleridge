<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper" style="min-height: 624px;">

    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url() . 'assets/assetslists'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">
                        <?php echo form_open('assets/add_asset'); ?>

                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="col_asset_assigned_by" value="<?= $this->session->userdata('SESS_USER_ID')  ?>">
                                <div class="form-group">
                                    <label class="required" for="INSRT_ASSIGN_TO">Assign To:</label>
                                    <select name="col_asset_assigned_to" id="" class="form-control">
                                        <?php foreach ($DISP_EMPLOYEES as $employees) { ?>
                                            <option value="<?= $employees->id ?>">
                                                <?= $employees->col_empl_cmid . ' - ' . $employees->col_frst_name . ' ' . $employees->col_last_name ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="required" for="INSRT_ASSET_NAME">Name</label>
                                    <input class="form-control form-control " type="text" name="col_asset_name" id="INSRT_ASSET_NAME" required>
                                </div>

                                <div class="form-group">
                                    <label class="required" for="INSRT_ASSET_SERIAL">Serial Number</label>
                                    <input class="form-control form-control " type="text" name="col_asset_serial" id="INSRT_ASSET_SERIAL" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="required" for="INSRT_ASSET_CATEGORY">Category</label>
                                    <select name="col_asset_category" id="INSRT_ASSET_CATEGORY" class="form-control" required>
                                        <option value="">-- Select -- </option>
                                        <?php
                                        foreach ($DISP_ASSET_CATEGORY as $DISP_ASSET_CATEGORY_ROW) {
                                        ?>
                                            <option value="<?= $DISP_ASSET_CATEGORY_ROW->id ?>"><?= $DISP_ASSET_CATEGORY_ROW->name ?></option>
                                        <?php

                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label class="required" for="INSRT_ASSET_LOCATION">Location</label>
                                    <select name="col_asset_location" id="INSRT_ASSET_LOCATION" class="form-control" required>
                                        <option value="">-- Select -- </option>
                                        <?php
                                        foreach ($DISP_LOCATION_INFO as $DISP_LOCATION_INFO_ROW) {
                                        ?>
                                            <option value="<?= $DISP_LOCATION_INFO_ROW->id ?>"><?= $DISP_LOCATION_INFO_ROW->name ?></option>
                                        <?php
                                        }

                                        ?>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="INSRT_ASSET_PRICE">Price (&#8369;)</label>
                                    <input class="form-control " type="text" name="col_asset_price" id="INSRT_ASSET_PRICE">
                                </div>

                                <div class="form-group">
                                    <label for="INSRT_ASSET_WARRANTY_EXP">Warranty Expires On</label>
                                    <input class="form-control" type="date" name="col_asset_warranty_exp" id="INSRT_ASSET_WARRANTY_EXP">
                                </div>

                                <div class="form-group">
                                    <label for="asset_code">Description</label>
                                    <textarea class="form-control" name="col_asset_description" id="INSRT_ASSET_DESCRIPTION" cols="30" rows="5"></textarea>
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


<script>
    document.getElementById('INSRT_ASSET_PRICE').addEventListener('input', function() {
        var inputValue = parseFloat(this.value); 
            if (isNaN(inputValue) || inputValue <= 0 || inputValue > 1000000) {
                this.setCustomValidity('Invalid value. Please input a valid price.');
                this.classList.add('is-invalid'); 
            } else {
                this.setCustomValidity(''); 
                this.classList.remove('is-invalid'); 
            }
    });
</script>

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

