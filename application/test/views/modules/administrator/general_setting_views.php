<!----------------------------------------------------------- A. STYLESHEETS ----------------------------------------------------->
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/companycontribution_style'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<style>
    /* *{
        outline: 1px solid gray;
    } */
    .image {
        display: flex;
        flex-direction: column;
    }

    .image p {
        margin-left: 8px;
        font-size: 12px;
    }
    
</style>
<div class="content-wrapper">
    <div class="p-3">
        <div class="flex-fill">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>administrators">Administrator</a>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">General Settings
                    </li>
                </ol>
            </nav>
            <div class="row">
                <!-- Title Text -->
                <div class="col-md-6">
                    <h1 class="page-title">General Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <!-- Title Header Line -->
            <hr>
            <!-- row starts -->
            <div class="row justify-content-center">
                <div class="card col-xl-8 col-lg-4 col-md-6 col-12 ml-2">
                    <form action="<?php echo base_url(); ?>administrators/update_general_settings" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                        <div class="form-group" style="margin-bottom: 40px">
                            <!-- <label class="required" for="UPDATE_NAME">Company Name: </label> -->
                            <div class="row">
                                <div class="col-3">
                                    <label for="">Company Name</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" name="update_comp_name" id="update_comp_name" value="<?= $DISP_COMPANY_NAME['value'] ?>">
                                </div>
                            </div>

                            <div class="row  mt-3">
                                <div class="col-3">
                                    <label for="">Header Content</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" name="update_header_content" id="update_header_content" value="<?= $DISP_HEADER_CONTENT['value'] ?>">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-3">
                                    <label for="">Side Navbar Logo</label>
                                </div>
                                <div class="col-9">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input fileficker" id="update_nav_logo" name="update_nav_logo" multiple="" accept=".jpg, .jpeg, .png">
                                            <label class="custom-file-label" id="preview_nav_logo" for="update_nav_logo">Choose file
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-1 image">
                                        <img style="width:160px; object-fit:contain" src="<?= base_url() ?>assets_system/images/<?= $DISP_NAVBAR_LOGO['value']; ?>">
                                        <p>Will be used in side menu</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-3">
                                    <label for="">Login Form Logo</label>
                                </div>
                                <div class="col-9">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input fileficker" id="update_login_logo" name="update_login_logo" multiple="" accept=".jpg, .jpeg, .png">
                                            <label class="custom-file-label" id="preview_login_logo" for="update_login_logo">Choose file
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-1 image">
                                        <img style="width:160px; object-fit:contain" src="<?= base_url() ?>assets_system/images/<?= $DISP_LOGIN_LOGO['value']; ?>">
                                        <p>Will be used in login form</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-3">
                                    <label for="">Header Logo (Mobile)</label>
                                </div>
                                <div class="col-9">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input fileficker" id="update_header_logo" name="update_header_logo" multiple="" accept=".jpg, .jpeg, .png">
                                            <label class="custom-file-label" id="preview_header_logo" for="update_header_logo">Choose file
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-1 image">
                                        <img style="width:160px; object-fit:contain" src="<?= base_url() ?>assets_system/images/<?= $DISP_HEADER_LOGO['value']; ?>">
                                        <p>Will be used in header in mobile size</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-2 float-right">
                            <button class="btn w-100 btn-primary btn-block " id="update_btn" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- row ends -->
    </div>
</div>
</div>
<aside class="control-sidebar control-sidebar-dark">
</aside>
<?php $this->load->view('templates/jquery_link'); ?>

<?php
if ($this->session->userdata('SESS_UPDATE')) {
?>
<script>
    Swal.fire(
        '<?php echo $this->session->userdata('SESS_UPDATE'); ?>',
        '',
        'success'
    )
</script>
<?php
$this->session->unset_userdata('SESS_UPDATE');
} 
?>

<?php
if ($this->session->userdata('SESS_SUCC_UPDATE')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('SESS_SUCC_UPDATE'); ?>'
      })
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_UPDATE');
}
?>


<script>
    $(function() {
        function update_login_logo(uploader) {
            if (uploader.files && uploader.files[0]) {
                $('#preview_login_logo').text(uploader.files[0].name);
            }
        }
        $("#update_login_logo").change(function() {
            update_login_logo(this);
        });
        
        function update_header_logo(uploader) {
            if (uploader.files && uploader.files[0]) {
                $('#preview_header_logo').text(uploader.files[0].name);
            }
        }
        $("#update_header_logo").change(function() {
            update_header_logo(this);
        });

        function update_nav_logo(uploader) {
            if (uploader.files && uploader.files[0]) {
                $('#preview_nav_logo').text(uploader.files[0].name);
            }
        }
        $("#update_nav_logo").change(function() {
            update_nav_logo(this);
        });
        
        
    });
</script>