<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title"><a href="<?= base_url('reports/goverment_forms'); ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Form Settings<h1>
            </div>
        </div>  
        <div class=" py-3 ">
            <div class="card col-11 col-md-8 col-lg-8 m-auto">
                <div class="card-header">
                    <h3>Employer's Information</h3>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('reports/update_form_setting') ?>" method="POST">
                        <div class="row d-flex justify-content-center">
                            <div class="form-group col-11 col-md-6">
                                <label class="required">Fullname</label>
                                <input type="text" class="form-control" required name="employers" value="<?= $EMPLOYERS_NAME ?>">
                            </div>
                            <div class="form-group col-11 col-md-6">
                                <label class="required">Email</label>
                                <input type="mail" class="form-control" required name="employers_email" value="<?= $EMPLOYERS_EMAIL ?>">
                            </div>
                            <div class="form-group col-11 col-md-6">
                                <label>Telephone Number</label>
                                <input type="text" class="form-control" name="employers_tel_num" value="<?= $TELEPHONE ?>">
                            </div>
                            <div class="form-group col-11 col-md-6">
                                <label>Mobile Number</label>
                                <input type="mail" class="form-control" name="employers_mob_num" value="<?= $MOBILE_NUMBER ?>">
                            </div>
                            <div class="form-group col-11 col-md-6">
                                <label class="required">Tin Number</label>
                                <input type="text" class="form-control" required name="company_tin" value="<?= $EMPLOYERS_TIN ?>">
                            </div>
                            <div class="form-group col-11 col-md-6">
                                <label class="required">RDO Code</label>
                                <input type="text" class="form-control" required value="<?= $RDO_CODE ?>" required name="rdo_code">
                            </div>
                            <div class="form-group col-11 col-md-6">
                                <label class="required">SSS ID</label>
                                <input type="text" required class="form-control" value="<?= $SSS_ID ?>" name="employers_sss">
                            </div>
                            <div class="form-group col-11 col-md-6">
                                <label>Company Website</label>
                                <input type="text" class="form-control" value="<?= $COMPANY_WEB ?>" name="company_website">
                            </div>

                            <div class="row form-group col-11 col-md-12">
                                <label class="col-12 required">Company Address</label>
                                <textarea class="form-control col-12 col-lg-6" name="employers_add" required value="<?= $EMPLOYERS_ADD ?>" class="form-control w-50" rows="3"><?= $EMPLOYERS_ADD ?></textarea>
                            </div>
                            <div class="row form-group col-11 col-md-12">
                                <label class="col-12 required">Zip Code</label>
                                <input type="text" class="form-control col-12 col-lg-6" required value="<?= $ZIP_CODE ?>" name="employers_zip_code">
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary d-block ml-auto">Submit</button>
                    </form>
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