<?php $this->load->view('templates/css_link'); ?>

<style>
    label {

        color: black;

    }
</style>

<div class="content-wrapper">

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

                        <div class="row">

                            <div class="col-md-12">

                                <form action="<?= base_url('assets/update_asset') ?>" method='POST'>

                                    <div class="form-group">

                                        <label class="text-dark" for="input_id">ID</label>

                                        <input type="hidden" name="id" value="<?= $DISP_ASSET->id ?>" />

                                        <input type="text" class="form-control" name="input_id" id="input_id" disabled value="<?= 'AST' . str_pad($DISP_ASSET->id, 5, '0', STR_PAD_LEFT) ?>">

                                    </div>

                                    <div class="form-group">
                                        <label class="" for="input_create_date">Create Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($DISP_ASSET->create_date) ? 
                                        date_format(date_create($DISP_ASSET->create_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>

                                    <!-- <div class="form-group">

                                        <label class="" for="input_create_date">Create Date</label>

                                        <input type="datetime-local" class="form-control" name="input_create_date" id="input_create_date" disabled value="<?= $DISP_ASSET->create_date ?>">

                                    </div> -->

                                    <label class="">Assigned To:</label>

                                    <select class="form-control" name="col_asset_assigned_to" id="input_edit_user">


                                        <option value="<?= $DISP_ASSET->id ?>" selected>
                                            <?php
                                            $name = $DISP_ASSET->col_empl_cmid . '-' . $DISP_ASSET->col_last_name;
                                            if (!empty($DISP_ASSET->col_suffix)) $name = $name . ' ' . $DISP_ASSET->col_suffix;
                                            if (!empty($DISP_ASSET->col_frst_name)) $name = $name . ', ' . $DISP_ASSET->col_frst_name;
                                            if (!empty($DISP_ASSET->col_midl_name)) $name = $name . ' ' . $DISP_ASSET->col_midl_name[0] . '.';
                                            // $DISP_ASSET->col_empl_cmid.' - '.$DISP_ASSET->col_frst_name.' '.$ANNOUNCEMENT->col_last_name 
                                            echo $name;
                                            ?>
                                        </option>
                                        <?php foreach ($DISP_EMPLOYEES as $employees) { ?>
                                            <option value="<?= $employees->id ?>">
                                                <?= $employees->col_empl_cmid . ' - ' . $employees->col_frst_name . ' ' . $employees->col_last_name ?>
                                            </option>
                                        <?php } ?>

                                    </select>


                                    <div class="form-group mt-2">
                                        <label class="required" for="INSRT_ASSET_NAME">Name</label>
                                        <input class="form-control form-control " value="<?= $DISP_ASSET->col_asset_name ?>" type="text" name="col_asset_name" id="INSRT_ASSET_NAME" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="INSRT_ASSET_SERIAL">Serial Number</label>
                                        <input class="form-control form-control " value="<?= $DISP_ASSET->col_asset_serial ?>" type="text" name="col_asset_serial" id="INSRT_ASSET_SERIAL" required>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="required" for="INSRT_ASSET_CATEGORY">Category</label>
                                                <select name="col_asset_category" id="INSRT_ASSET_CATEGORY" class="form-control" required>
                                                    <option value="<?= $DISP_ASSET->asset_category_id ?>"><?= $DISP_ASSET->asset_category_name ?></option>
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
                                                    <option value="<?= $DISP_ASSET->location_id ?>"><?= $DISP_ASSET->location_name ?></option>
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
                                                <input class="form-control " value="<?= $DISP_ASSET->col_asset_price ?>" type="text" name="col_asset_price" id="INSRT_ASSET_PRICE">
                                            </div>

                                            <div class="form-group">
                                                <label for="INSRT_ASSET_WARRANTY_EXP">Warranty Expires On</label>
                                                <input class="form-control" value="<?= $DISP_ASSET->col_asset_warranty_exp ?>" type="date" name="col_asset_warranty_exp" id="INSRT_ASSET_WARRANTY_EXP">
                                            </div>

                                            <div class="form-group">
                                                <label for="asset_code">Description</label>
                                                <textarea class="form-control" value="<?= $DISP_ASSET->col_asset_description ?>" name="col_asset_description" id="INSRT_ASSET_DESCRIPTION" cols="30" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="mr-2" style="float: right !important">

                                        <button type='submit' id="btn_edit" class="btn technos-button-blue shadow-none rounded " ;> Submit</button>

                                    </div>

                                </form>

                            </div>

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
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success!',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('SUCC'); ?>'
        })
    </script>
<?php
}
?>


<?php
if ($this->session->flashdata('ERR')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('ERR'); ?>'
        })
    </script>
<?php
}
?>