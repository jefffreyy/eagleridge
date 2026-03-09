<?php $this->load->view('templates/css_link'); ?>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <div class="row  pt-1">
                <div class="col-md-6">
                    <h1 class="page-title d-flex align-items-center"><a onclick="afterRenderFunction()" href="<?= base_url() . 'companies'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
</a>&nbsp;About The Company</h1>
                </div>
                <div class="col-md-6 button-title"> </div>
            </div>
            <hr>

            <div id="html-content">
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/jquery_link'); ?>
    <script>
        var htmlContent = <?php echo !empty($htmlContent) ? json_encode($htmlContent) : 'null'; ?>;
        console.log('htmlContent', htmlContent);
        if (htmlContent !== null) {
            $("#html-content").html(htmlContent);
        }
    </script>
</body>

</html>