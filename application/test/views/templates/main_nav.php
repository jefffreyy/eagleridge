<!-- <script src="https://kit.fontawesome.com/1112982c9a.js" crossorigin="anonymous"></script> -->
<?php $this->load->view('templates/css_link'); ?>



<style>
.wrap-it{
    overflow-wrap: break-word !important;
}

</style>

<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row">
            <!-- Title Text -->
            <div class="col-md-6">
                <h1 class="page-title"><?= $title_page ?><h1>
            </div>
            <div class="col-md-6" style="text-align: right;">
            </div>
        </div>
        <!-- Title Header Line -->
        <hr>
        <div class="row">
            <?php foreach ($Modules as $module) { ?>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4" id="<?= $module["id"] ?>" class="wrap-it">
                    <a href="<?= base_url() . $module["url"] ?>" style="text-decoration: none;   color: black;">
                        <div class="info-box" style = "box-shadow: none!important;">
                            <span class="info-box-icon" style = "background-color: #FFE083;">
                                
                                <i class='<?=$module['icon']?>'></i>
                            </span>
                            <div class="info-box-content" >
                                <span  style="font-size:large !important ; word-wrap:break-word !important;" ><?= $module["title"] ?></span>

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

    // When the user leaves the page, remove the active item from local storage. this is for scrollbar to reset the active button
    window.addEventListener("unload", () => {
        const activeLinkId = localStorage.getItem('activeLinkId');
        localStorage.removeItem("activeLinkId");
    });
    
</script>
</body>

</html>