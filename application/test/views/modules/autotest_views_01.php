<html>
<?php $this->load->view('templates/css_link'); ?>


<body>
    <div>
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="">Autotest Log</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Autotest Log
                    </li>
                </ol>
            </nav>
            <div class="row pt-1">
                <div class="col-md-6">
                    <h1 class="page-title">Autotest Log<h1>
                </div>
            </div>

            <hr>
            <div class="card border-0 p-0 m-0">

                <div class="p-2">

                    <div>
                        <!-- <button class="btn technos-button-gray shadow-none rounded bulk-button" id="bulk_approved" data-toggle="modal" data-target="#modal_bulk_approved"><i class=""></i>&nbsp;Bulk as Approve</button>
                        <button class="btn technos-button-gray shadow-none rounded bulk-button" id="bulk_reject" data-toggle="modal" data-target="#modal_bulk_reject"><i class=""></i>&nbsp;Bulk as Reject</button> -->
                        <div class="float-right ">
                            <p class="p-0 m-0 d-inline" style="color: gray">Showing 1 to 7 of 7 entries&nbsp;</p>
                            <ul class="d-inline pagination m-0 p-0 ">
                                <li><a>
                                        < </a>
                                </li>
                                <li><a href="">1 </a></li>
                                <!-- <li><a>... </a></li>
                                    <li><a href=""> </a></li>
                                    <li><a style="color:white ; background-color:#007bff !important"></a></li>
                                    <li><a href=""> </a></li>
                                    <li><a>... </a></li>
                                    <li><a href=""> </a></li> -->
                                <li><a style="margin-right: 10px;">> </a></li>
                            </ul>
                            <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                            <select id="row_dropdown d-inline" class="custom-select" style="width: auto;">
                                <option value=""> 25 </option>
                                <option value=""> 50 </option>
                                <option value=""> 100 </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover m-0" id="TableToExport" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">Site</th>
                                <th class="text-center">Group ID</th>
                                <th class="text-center">Test ID</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Result</th>
                                <th class="text-center">Time</th>
                            </tr>

                        </thead>
                        <tbody id="tbl_application_container">
                        <?php 
    if (isset($DISP_RESULT_SUCCESS)) {
        foreach ($DISP_RESULT_SUCCESS as $DISP_RESULT_SUCCESS_ROW) {
            ?>
            <tr>
                <td class="text-center"><?= $DISP_RESULT_SUCCESS_ROW->test_date ?></td>
                <td class="text-center"><?= $DISP_RESULT_SUCCESS_ROW->test_site ?></td>
                <td class="text-center"><?= $DISP_RESULT_SUCCESS_ROW->group_id ?></td>
                <td class="text-center"><?= $DISP_RESULT_SUCCESS_ROW->test_id ?></td>
                <td class="text-center"><?= $DISP_RESULT_SUCCESS_ROW->test_title ?></td>
                <td class="text-center"><?= $DISP_RESULT_SUCCESS_ROW->test_result ?></td>
                <td class="text-center"><?= $DISP_RESULT_SUCCESS_ROW->test_time ?></td>
            </tr>
            <?php
        }
    }
    
    else if (isset($DISP_RESULT_FAILED)) {
        foreach ($DISP_RESULT_FAILED as $DISP_RESULT_FAILED_ROW) {
            ?>
            <tr>
                <td class="text-center"><?= $DISP_RESULT_FAILED_ROW->test_date ?></td>
                <td class="text-center"><?= $DISP_RESULT_FAILED_ROW->test_site ?></td>
                <td class="text-center"><?= $DISP_RESULT_FAILED_ROW->group_id ?></td>
                <td class="text-center"><?= $DISP_RESULT_FAILED_ROW->test_id ?></td>
                <td class="text-center"><?= $DISP_RESULT_FAILED_ROW->test_title ?></td>
                <td class="text-center"><?= $DISP_RESULT_FAILED_ROW->test_result ?></td>
                <td class="text-center"><?= $DISP_RESULT_FAILED_ROW->test_time ?></td>
            </tr>
            <?php
        }
    }

    if ((!isset($DISP_RESULT_SUCCESS) || empty($DISP_RESULT_SUCCESS)) && (!isset($DISP_RESULT_FAILED) || empty($DISP_RESULT_FAILED))) {
        ?>
        <tr class="table-active">
            <td colspan="7">
                <center>No Data</center>
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
    </div>

</body>

</html>