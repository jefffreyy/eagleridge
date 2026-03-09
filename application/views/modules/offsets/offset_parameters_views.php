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
    

  .switch {
        margin-top: 11px;
        margin-left: 7px;
        position: relative;
        display: block;
        width: 50px;
        height: 26px;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    .switch input {
        display: none;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 21px;
        width: 21px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50px;
    }
    input:checked+.slider:before {
        background-color: limegreen;
    }
    input:checked+.slider:before {
        transform: translateX(23px);
    }

    .ip_on{
      font-size: 15px;
      font-weight: bold;
      color: green;
      margin-top: 11px;
      margin-left: 5px;
      background-color: #a0f2c1;
      padding: 2px 10px;
      border-radius: 12px;
    }
    .ip_off{
      font-size: 15px;
      font-weight: bold;
      color: #fff;
      margin-top: 11px;
      margin-left: 5px;
      background-color: #d4a981;
      padding: 2px 10px;
      border-radius: 12px;
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
                    <h1 class="page-title"><a href="<?= base_url().'offsets/entitlements';?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Offset Setting<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <!-- Title Header Line -->
            <hr>
            <!-- row starts -->
            

            <div class="row justify-content-center">
                
                

                <div class="card col-xl-8 col-lg-4 col-md-6 col-12 ml-2">
                    <div class="row">
                        <form action="<?php echo base_url().'offsets/update_offset_setting';?>"  method="post" accept-charset="utf-8" class="p-0" >
                            <label class="switch p-0">
                                
                                <input class="switch_on p-0" type="checkbox" <?= $SYSTEM_OFFSET_SETTING == '0' ? '' : 'checked';?> name="val_setting" onchange="this.form.submit()" >
                                <span class="slider round" id="branch"></span>
                            </label>
                        </form>
                        <p class="ip_off" <?= $SYSTEM_OFFSET_SETTING == '0' ? '' : 'hidden';?>>Manual</p>
                        <p class="ip_on" <?= $SYSTEM_OFFSET_SETTING == '1' ? '' : 'hidden';?>>Auto</p>
                    </div>

                    <form action="<?php echo base_url(); ?>offsets/update_general_settings" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data" <?= $SYSTEM_OFFSET_SETTING == '1' ? '' : 'hidden';?>>
                        <div class="form-group" style="margin-bottom: 40px">
                            <!-- <label class="required" for="UPDATE_NAME">Company Name: </label> -->
                            <div class="row">
                                <div class="col-3">
                                    <label for="">Maximum Vacation Leave</label>
                                </div>
                                <div class="col-9">
                                    <input type="number" class="form-control" name="update_OFFSET_VACATION_LEAVE" id="update_OFFSET_VACATION_LEAVE" value="<?=$OFFSET_VACATION_LEAVE['value']?>">
                                </div>
                            </div>

                            <div class="row  mt-3">
                                <div class="col-3">
                                    <label for="">Maximum Sick Leave</label>
                                </div>
                                <div class="col-9">
                                    <input type="number" class="form-control" name="update_OFFSET_SICK_LEAVE" id="update_OFFSET_SICK_LEAVE" value="<?=$OFFSET_SICK_LEAVE['value']?>">
                                </div>
                            </div>

                        </div>

                        <div class="col-2 float-right">
                            <button class="btn w-100 btn-primary btn-block " id="update_btn" type="submit"><i class="fa-duotone fa-pen-to-square"></i>&nbsp;Update</button>
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