<?php $this->load->view('templates/css_link'); ?>

<style>
    label {

        color: black;

    }
</style>

<div class="content-wrapper">

    <div class="row">
        <div class="col-md-6 mt-4 mx-3">
            <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('selfservices/my_assets') ?>"> <img style="width: 34px; height: 34px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                
            <h1>
        </div>


    </div>

    <div class="container-fluid px-4">



        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">

                        <div class="row">



                            <div class="col-md-12">

                                <div class="form-group">

                                    <label class="text-dark" for="input_id">ID</label>

                                    <input type="hidden" name="id" value="<?= $DISP_ASSET->id ?>" />

                                    <input type="text" class="form-control" name="input_id" id="input_id" disabled value="<?= 'AST' . str_pad($DISP_ASSET->id, 5, '0', STR_PAD_LEFT) ?>" readonly>

                                </div>

                                <!-- <div class="form-group">

                                    <label class="" for="input_create_date">Create Date</label>

                                    <input type="datetime-local" class="form-control" name="input_create_date" id="input_create_date" disabled value="<?= $DISP_ASSET->create_date ?>" readonly>

                                </div> -->

                                <div class="form-group">
                                        <label class="" for="input_create_date">Create Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($DISP_ASSET->create_date) ? 
                                        date_format(date_create($DISP_ASSET->create_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>


                                <label class="">Assigned To:</label>
                                <input type="text" value="<?= $DISP_ASSET->col_empl_cmid . ' - ' . $DISP_ASSET->col_last_name . ' ' . $DISP_ASSET->col_frst_name ?>" class="form-control" readonly>



                                <div class="form-group mt-2">
                                    <label for="INSRT_ASSET_NAME">Name</label>
                                    <input class="form-control form-control " value="<?= $DISP_ASSET->col_asset_name ?>" type="text" name="col_asset_name" id="INSRT_ASSET_NAME" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="INSRT_ASSET_SERIAL">Serial Number</label>
                                    <input class="form-control form-control " value="<?= $DISP_ASSET->col_asset_serial ?>" type="text" name="col_asset_serial" id="INSRT_ASSET_SERIAL" readonly>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="INSRT_ASSET_CATEGORY">Category</label>
                                            <input type="text" value="<?= $DISP_ASSET->asset_category_name ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="INSRT_ASSET_LOCATION">Location</label>
                                            <input type="text" value="<?= $DISP_ASSET->location_name ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="INSRT_ASSET_PRICE">Price (&#8369;)</label>
                                            <input class="form-control " value="<?= $DISP_ASSET->col_asset_price ?>" type="text" name="col_asset_price" id="INSRT_ASSET_PRICE" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="INSRT_ASSET_WARRANTY_EXP">Warranty Expires On</label>
                                            <input class="form-control" value="<?= !empty($DISP_ASSET->col_asset_warranty_exp) ? date_format(date_create($DISP_ASSET->col_asset_warranty_exp), $DATE_FORMAT) : '' ?>"  name="col_asset_warranty_exp" id="INSRT_ASSET_WARRANTY_EXP" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="asset_code">Description</label>
                                            <textarea class="form-control" value="<?= $DISP_ASSET->col_asset_description ?>" name="col_asset_description" id="INSRT_ASSET_DESCRIPTION" cols="30" rows="5" readonly></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php $this->load->view('templates/jquery_link'); ?>