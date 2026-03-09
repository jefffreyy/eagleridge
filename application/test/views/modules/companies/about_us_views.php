<html>
    <body>
<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>companies">Company</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">About the Company
                </li>
            </ol>
        </nav>
        <?php
        if ($DISP_ALL_DATA) {
                    foreach($DISP_ALL_DATA as $DISP_ROW_COUNT){?>
        <div class="row">
            <!-- Title Text -->
            <div class="col-md-6">
                <h1 class="page-title">About the Company<h1>
            </div>
            <!-- <div class="col-md-6" style="text-align: right;">
            <a href="<?=base_url().'companies/edit_about'?>" class=" btn technos-button-green shadow-none rounded" id="edit_about">&nbsp;Edit About</a> 
            </div> -->
        </div>
        <hr>
        <!-- Title Header Line -->
        <div class="row">
            <!-- My Info -->
            <div class>
                <div>
                    <div style="margin-left:40px;">
                        <span class="info-box-text" style="font-size:20px">
                            <?=$DISP_ROW_COUNT->about_cmp?>
                        </span>
                    </div>
                </div>            
            </div>
        </div>
    </div>
    <div class="container-fluid p-4">
        <div class="row">
            <!-- Title Text -->
            <div class="col-md-6">
                <h1 class="page-title">Mission<h1>
            </div>
            <div class="col-md-6" style="text-align: right;">
            </div>
        </div>
        <hr>
        <!-- Title Header Line -->
        <div class="row">
            <!-- My Info -->
            <div class>
                <div>
                    <div style="margin-left:40px;">
                        <span class="info-box-text" style="font-size:20px">
                        <?=$DISP_ROW_COUNT->mission?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid p-4">
        <div class="row">
            <!-- Title Text -->
            <div class="col-md-6">
                <h1 class="page-title">Vision<h1>
            </div>
            <div class="col-md-6" style="text-align: right;">
            </div>
        </div>
        <hr>
        <!-- Title Header Line -->
        <div class="row">
            <!-- My Info -->
            <div class>
                <div>
                    <div style="margin-left:40px;">
                        <span class="info-box-text" style="font-size:20px">
                        <?=$DISP_ROW_COUNT->vision?>
                        </span>
                    </div>
                </div>            
            </div>
        </div>
    </div>
                <?php    }
                }?>
</div>
<aside class="control-sidebar control-sidebar-dark">
</aside>
<!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->

<?php $this->load->view('templates/jquery_link'); ?>

<?php
if ($this->session->userdata('MSG')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('MSG'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('MSG');
}
?>

<?php
if ($this->session->userdata('MSG_EDIT_ABOUT_US')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('MSG_EDIT_ABOUT_US'); ?>'
      })
</script>
<?php
$this->session->unset_userdata('MSG_EDIT_ABOUT_US');
}
?>
</body>
</html>