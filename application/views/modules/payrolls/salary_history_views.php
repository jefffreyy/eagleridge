<?php $this->load->view('templates/css_link'); ?>

<body>
    <!-- Content Starts -->
    <div class="content-wrapper">
        <div class="container-fluid p-4">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>payrolls/salary_details">Salary Details
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Salary History
                    </li>
                </ol>
            </nav>

            <div class="row  pt-1"> <!-- Title starts -->
                <div class="col-md-6">
                    <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'payrolls/salary_details'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Salary History</h1>
                </div>
                <div class="col-md-6 button-title">
                    <!-- <a href="<?= base_url() . 'leaves/shift_import_csv'; ?>" id="btn_application" class="btn btn-primary shadow-none"><i class="fas fa-file-import"></i>Import CSV</a> -->
                    <!-- <a href="<?= base_url() . 'leaves/bulk_import'; ?>" id="btn_application" class="btn technos-button-green shadow-none"><i class="fas fa-file-import"></i>Bulk Import</a>-->
                    <!-- <a href="#" id="btn_export" class="btn technos-button-gray shadow-none rounded"><i class="fas fa-file-export"></i>Export XLSX</a>  -->
                    <!-- <a href="#" id="btn_application" data-toggle="modal" data-target="#modal_attendance_records" class="btn btn-primary shadow-none"><i class="fas fa-file-export"></i>Export CSV</a> -->
                </div>
            </div><!-- Title Ends -->
            <hr>

            <div class="col-md-8 card p-1" id="content_container">
                <div class="card-title pl-4 pt-0 pb-0 text-bold header-title" style="color: green">
                    <span><img class="mb-1" style="width: 21px; height: 21px; margin-right: 7px;" src="<?= base_url('assets_system/icons/book-open-solid.svg') ?>" alt="">Salary Change Logs <span>(<?= $employee ?>)</span></span>
                </div>
                <hr class="mb-0">
                <div class="row pl-3 pr-3">
                    <div class="table-responsive">
                        <table class="table table table-hover table-nowrap mb-0" style="border:none;">
                            <tbody>
                                <thead>
                                    <th scope="col">Date</th>
                                    <!-- <th scope="col">Updated By</th> -->
                                    <th scope="col">Category</th>
                                    <th scope="col">From</th>
                                    <th scope="col">To</th>
                                </thead>
                                <?php
                                if ($C_LOGS) {
                                    foreach ($C_LOGS as $C_LOGS_ROW) {
                                ?>
                                        <tr>
                                            <td><?= $C_LOGS_ROW->log_date ? explode(" ", $C_LOGS_ROW->log_date)[0] : '<a class="text-danger">No data</a>' ?></td>
                                            <!-- <td><?= $C_LOGS_ROW->col_frst_name ? $C_LOGS_ROW->col_frst_name.' '.$C_LOGS_ROW->col_last_name  : '<a class="text-danger">No data</a>' ?></td> -->
                                            <td><?= $C_LOGS_ROW->category ? $C_LOGS_ROW->category : '<a class="text-danger">No data</a>' ?></td>
                                            <td><?= $C_LOGS_ROW->from_val ? $C_LOGS_ROW->from_val : '<a class="text-danger">No data</a>' ?></td>
                                            <td><?= $C_LOGS_ROW->to_val ? $C_LOGS_ROW->to_val : '<a class="text-danger">No data</a>' ?></td>
                                           
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <!-- Message if no entries -->
                                    <tr class="table-active">
                                        <td colspan="9">
                                            <center>No Data Yet</center>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div><!--End fluid-->
    </div> <!-- Content Ends -->

    <!-- jQuery -->
    <?php $this->load->view('templates/jquery_link'); ?>

    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
</body>

</html>