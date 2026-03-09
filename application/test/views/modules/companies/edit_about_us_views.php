<html>
<?php $this->load->view('templates/css_link'); ?>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'companies' ?>">Company</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'companies/about_the_company' ?>">About the Company</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit&nbsp;About
                    </li>
                </ol>
            </nav>
            <div class="row d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?= base_url().'companies/edit_about_us_data'; ?>" method="POST">

                                        <?php if ($DISP_ALL_DATA) {
                                            foreach ($DISP_ALL_DATA as $DISP_ROW) { ?>

                                                <div class="form-group ">
                                                    <label class="required">About the Company</label>

                                                    <textarea name="about" class="form-control" id="" rows="4" cols="50" required> <?= $DISP_ROW->about_cmp ?></textarea>
                                                </div>

                                                <div class="form-group ">
                                                    <label class="required">Mission</label>
                                                    <textarea name="mission" class="form-control" id="" rows="4" cols="50" required><?= $DISP_ROW->mission ?></textarea>
                                                </div>

                                                <div class="form-group ">
                                                    <label class="required">Vision</label>
                                                    <textarea name="vision" class="form-control" id="" rows="4" cols="50" required><?= $DISP_ROW->vision ?></textarea>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <div class="mr-2" style="float: right !important">
                                            <input type="submit" class="btn technos-button-green shadow-none rounded " value="Submit" id="submit_button">
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

    </script>
</body>

</html>