<?php $this->load->view('templates/css_link');
if ($maiya_theme["value"] == 1) {
    $theme_color = "background-color: #00d2ff";
} else {
    $theme_color = "background-color: #FFE083";
}
?>

<style>
    .wrap-it {
        overflow-wrap: break-word !important;
    }

    .missing_count {
        display: inline-block;
        margin: 5px 1px 0 1px;
        min-width: 20px;
        height: 20px;
        background: #f56767;
        color: white;
        border-radius: 20px;
        padding: 0 5px;
        text-align: center;
        font-size: 12px;
        font-weight: 500;
    }

  .loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    
  }
  .loading-spinner {
    border: 4px solid #f3f3f3; 
    border-top: 4px solid #3498db; 
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite; 
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>

<div class="content-wrapper">
<div id="loadingOverlay" class="loading-overlay" hidden>
  <div class="loading-spinner"></div>
</div>
    <div class="container-fluid p-4">
        <div class="row">
            <!-- Title Text -->
            <div class="col-md-5">
                <h1 class="page-title"><?= $title_page ?></h1>
                <?= $title_description ?>
            </div>
            <div class="col-md-1">

            </div>
            <div class="col-md-6" style="text-align: right;">
                <?php if (isset($settings)) { ?>
                    <a href="<?= site_url($settings) ?>" class="btn btn-primary text-light"><img style="width: 18px; height: 18px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/gears-duotone_xs.svg') ?>" alt="" />&nbsp;Settings</a>
                <?php } ?>
            </div>
        </div>
        <!-- Title Header Line -->
        <hr>
        <div class="row">
            <?php foreach ($Modules as $module) { ?>
                <?php $remote_attendance = ($module["title"] == "Remote Attendance" && $DISP_REMOTE_ATTENDANCE == 0) ?  "hidden" :  ""; ?>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4" id="<?= $module["id"] ?>" class="wrap-it " style="" <?=$remote_attendance;?>>
                    <a onclick="afterRenderFunction()" href="<?= base_url() . $module["url"] ?>" style="text-decoration: none; color: black;">
                        <div class="info-box position-relative " style="box-shadow: none!important; min-height: 100px; max-height: 150px;" >
                            <span class="info-box-icon" style="background-color: #AEE2F1">
                                <img src="<?= base_url('assets_system/icons/' . $module['icon']) ?>" />
                            </span>
                            <div class="info-box-content" style="line-height: 20px;">
                                <span style="font-size:15px !important ;font-weight:600; word-wrap:break-word !important;"><?= $module["title"] ?>
                                    <?php if ($module["title"] == "Approval Route") { ?>
                                        <p style="<?= $approvers_count  == 0 ? 'display: none;' : '' ?>" class="missing_count"><?= $approvers_count ?></p>
                                    <?php } ?>
                                    <?php if ($module["title"] == "Manage Salary") : ?>
                                        <p style="<?= $salary_type_and_rate_count  == 0 ? 'display: none;' : '' ?>" class="missing_count"><?= $salary_type_and_rate_count ?></p>
                                    <?php endif; ?>
                                    <?php if ($module["title"] == "Setup Organizatonal Chart") : ?>
                                        <p style="<?= $assign_to_count  == 0 ? 'display: none;' : '' ?>"  class="missing_count"><?= $assign_to_count ?></p>
                                    <?php endif; ?>
                                    <?php if ($module["title"] == "Payroll Assignment") : ?>
                                        <p style="<?= $payroll_assign_count == 0 ? 'display: none;' : '' ?>" class="missing_count"><?= $payroll_assign_count ?></p>
                                    <?php endif; ?>
                                    <?php if ($module["title"] == "Leave Request") : ?>
                                        <p style="<?= $leave_request_pending_count == 0 ? 'display: none;' : '' ?>" class="missing_count"><?= $leave_request_pending_count ?></p>
                                    <?php endif; ?>
                                    <?php if ($module["title"] == "Leave Entitlement") : ?>
                                        <p style="<?= $leave_entitlement_count == 0 ? 'display: none;' : '' ?>" class="missing_count"><?= $leave_entitlement_count ?></p>
                                    <?php endif; ?>
                                    <?php if ($module["title"] == "Overtime") : ?>
                                        <p style="<?= $overtime_pending_count == 0 ? 'display: none;' : '' ?>" class="missing_count"><?= $overtime_pending_count ?></p>
                                    <?php endif; ?>
                                    <?php if ($module["title"] == "Holiday Work") : ?>
                                        <p style="<?= $holiday_work_pending_count == 0 ? 'display: none;' : '' ?>" class="missing_count"><?= $holiday_work_pending_count ?></p>
                                    <?php endif; ?>

                                </span>

                                <span style="font-size:13px !important ;font-weight:400; word-wrap:break-word !important;color: #777777"><?= $module['info'] ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<?php $this->load->view('templates/jquery_link'); ?>

<script>
    $('[data-toggle="tooltip"]').tooltip()

    window.addEventListener("unload", () => {
        const activeLinkId = localStorage.getItem('activeLinkId');
        localStorage.removeItem("activeLinkId");
    });
</script>
<script>
  function afterRenderFunction(){
    var loadingOverlay = document.getElementById('loadingOverlay');
    loadingOverlay.hidden = false;
  }
</script>

</body>

</html>