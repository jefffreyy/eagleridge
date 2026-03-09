<html>
<?php $this->load->view('templates/css_link'); ?>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'administrators' ?>">Administrator</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'administrators/ip_address' ?>">IP&nbsp;Address</a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">Add&nbsp;IP&nbsp;Address
                    </li>
                </ol>
            </nav>
            <div class="row d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?=base_url().'administrators/insert_ip_address'?>" method="POST">

                                        <div class="form-group ">
                                            <label class="required">Status</label>
                                            <input type="text" class="form-control" name="insrt_status" id="insrt_status" value="Active" readonly>
                                        </div>
                                        
                                        <div class="form-group ">
                                            <label class="required">IP Address</label>
                                            <input type="text" class="form-control" name="insrt_ip_add" id="insrt_ip_add" required>
                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Remarks</label>
                                            <input type="text" class="form-control" name="insrt_remarks" id="insrt_remarks" required>
                                        </div>

                                        <div class="mr-2" style="float: right !important">
                                            <input type="submit" class="btn technos-button-green shadow-none rounded " value="Submit" id="submit">
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