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
</style>

<div class="content-wrapper">
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
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4" id="<?= $module["id"] ?>" class="wrap-it">
                    <a href="<?= base_url() . $module["url"] ?>" style="text-decoration: none;   color: black;">

                        <div class="info-box position-relative" style="box-shadow: none!important;">
                            <span class="info-box-icon" style="background-color: #AEE2F1">
                                <img src="<?= base_url('assets_system/icons/' . $module['icon']) ?>" />
                            </span>
                            <div class="info-box-content" style="line-height: 20px;">
                                <span style="font-size:15px !important ;font-weight:600; word-wrap:break-word !important;"><?= $module["title"] ?>
            
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

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
    $('[data-toggle="tooltip"]').tooltip()
    // When the user leaves the page, remove the active item from local storage. this is for scrollbar to reset the active button
    window.addEventListener("unload", () => {
        const activeLinkId = localStorage.getItem('activeLinkId');
        localStorage.removeItem("activeLinkId");
    });
</script>
</body>

</html>