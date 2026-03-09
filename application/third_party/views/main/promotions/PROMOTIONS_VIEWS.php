<style>
    div.dataTables_wrapper div.dataTables_paginate {
        display: flex;
    }

    .btn-group .btn {
        padding: 0px 12px;
    }

    .page-title {
        font-weight: 600;
        color: #424F5C;
        font-size: 33px;
    }

    th,
    td {
        font-size: 13px !important;
        border-top: none !important;
    }

    label.required::after {
        content: " *";
        color: red;
    }

    .card-body {
        padding: 15px 20px !important;
    }

    #tab_pills_container li a.active {
        border-bottom: 1px solid #dee2e6;
        border-bottom-left-radius: .25rem;
        border-bottom-right-radius: .25rem;
        background-color: #0f67a3 !important;
        color: #fff !important;
    }

    #tab_pills_container li a:not(.active):hover {
        background-color: #ccc !important;
    }

    .approval_card {
        cursor: pointer;
        border-bottom: 1px solid #dadada;
    }

    .approval_card img {
        width: 40px;
        height: 40px;
    }

    .approval_card p {
        font-size: 10px;
    }

    .approval_card a:not(.btn) {
        font-size: 10px;
    }

    .approval_card:hover {
        background-color: #E0F2FF;
    }

    .view_overtime_details:hover {
        background-color: #E0F2FF;
    }

    .view_adjustment_details:hover {
        background-color: #E0F2FF;
    }

    .btn-primary-inactive {
        background-color: #bfe3fb;
        color: #0D74BC !important;
    }

    .btn-primary-inactive:hover {
        background-color: #76c4f8;
        color: #fff !important;
    }

    .hide {
        display: none;
        border: none;
    }
</style>
<?php
//GLOBAL VARIABLES
$API_URL = base_url() . "promotions";
$PAGE_TITLE = "Promotion Endorsement List";
$PAGE_TITLE2 = "Promotion Approval List";
$PAGE_TITLE3 = "My Endorsement";
$ADD_BTN_NAME = "Add Endorsement";
$TAB_URL = base_url() . "promotions/for_approval";
$TAB_URL2 = base_url() . "promotions/my_endorsements";
?>
<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Datatables -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
<!-- Pagination -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">
<div class="content-wrapper">
    <div class="Container-fluid p-4">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs border-0" id="tab_pills_container">
                    <li class="nav-item">
                        <a id="overallTab" class="nav-link" href="<?= $API_URL ?>">Endorsement List</a>
                    </li>
                    <li class="nav-item">
                        <a id="forApprovalTab" class="nav-link" href="<?= $TAB_URL ?>">For Approval</a>
                    </li>
                    <li class="nav-item">
                        <a id="myTab" class="nav-link" href="<?= $TAB_URL2 ?>">My Endorsement</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content mt-5">
            <div class="tab-pane" id="overallTabPane">
                <h1 class="page-title"><?= $PAGE_TITLE ?></h1>
                <hr>
            </div>
            <div class="tab-pane" id="forApprovalTabPane">
                <h1 class="page-title"><?= $PAGE_TITLE2 ?></h1>
                <hr>
            </div>
            <div class="tab-pane" id="myTabPane">
                <div class="row w-100">
                    <div class="col-md-6">
                        <h1 class="page-title"><?= $PAGE_TITLE3 ?></h1>
                    </div>
                    <div class="col-md-6" style="text-align: right;">
                        <a href="#" class="btn btn-primary shadow-none" data-toggle="modal" data-target="#add_modal">
                            <i class="fas fa-plus"></i> <?= $ADD_BTN_NAME ?>
                        </a>
                    </div>
                </div>
                <hr>
            </div>

            <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
                <table class="table table-hover">
                    <thead>
                        <th>Promotion ID</th>
                        <th>Employee</th>
                        <th>Position</th>
                        <th>Endorser</th>
                        <th>Endorsement Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="tbl_application_container">
                        <?php
                        foreach ($DISP_TABLE as $DISP_TABLE_ROW) {
                        ?>
                            <tr>
                                <td style="cursor:pointer" data-toggle="modal" data-target="#editViewModal" onclick="getOneData(<?= $DISP_TABLE_ROW->id ?>, 'view')">
                                    <?= $DISP_TABLE_ROW->promotion_id ?>
                                </td>
                                <td style="cursor:pointer" data-toggle="modal" data-target="#editViewModal" onclick="getOneData(<?= $DISP_TABLE_ROW->id ?>, 'view')">
                                    <img class="rounded-circle avatar " width="35" height="35" src="<?= $DISP_TABLE_ROW->employee_image ?>" alt="" />
                                    <?= $DISP_TABLE_ROW->employee ?>
                                </td>
                                <td style="cursor:pointer" data-toggle="modal" data-target="#editViewModal" onclick="getOneData(<?= $DISP_TABLE_ROW->id ?>, 'view')">
                                    <?= $DISP_TABLE_ROW->positionName ?>
                                </td>
                                <td style="cursor:pointer" data-toggle="modal" data-target="#editViewModal" onclick="getOneData(<?= $DISP_TABLE_ROW->id ?>, 'view')">
                                    <?= $DISP_TABLE_ROW->endorser ?>
                                </td>
                                <td style="cursor:pointer" data-toggle="modal" data-target="#editViewModal" onclick="getOneData(<?= $DISP_TABLE_ROW->id ?>, 'view')">
                                    <?= date('l, F j, Y', strtotime($DISP_TABLE_ROW->endorsed_date)) ?></td>
                                <td style="cursor:pointer" data-toggle="modal" data-target="#editViewModal" onclick="getOneData(<?= $DISP_TABLE_ROW->id ?>, 'view')">
                                    <?= $DISP_TABLE_ROW->status ?>
                                </td>
                                <td>
                                    <button class="btn btn-primary shadow-none mr-2" data-toggle="modal" data-target="#editViewModal" onclick="getOneData(<?= $DISP_TABLE_ROW->id ?>, 'view')" value="<?= $DISP_TABLE_ROW->id ?>">View</button>
                                    <?php
                                    if ($DISP_TABLE_ROW->edit_allowed) {
                                    ?>
                                        <button class="btn btn-secondary shadow-none" data-toggle="modal" data-target="#editViewModal" onclick="getOneData(<?= $DISP_TABLE_ROW->id ?>, 'edit')" value="<?= $DISP_TABLE_ROW->id ?>">Edit</button>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

                <p id="btn_pagination" class="pagination ml-auto mr-auto">
                    <?php echo $links ?>
                </p>
            </div>
        </div>
    </div>
</div>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>

<!-- ADD ENDORSEMENT -->
<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0 ml-1">Endorsement Info
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pb-5">
                <form action="<?php echo base_url('promotions/add_endorsement'); ?>" id="add_endrorsement" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="INSRT_STATUS">Status</label>
                                <input hidden type="text" name="INSRT_STATUS" id="INSRT_STATUS" class="form-control" value="New">
                                <select class="form-control" id="" disabled>
                                    <option id="" name="" value="New">New</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="INSRT_ENDORSER_NAME">Endorser Name</label>
                                <?php
                                $user_data = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($this->session->userdata('SESS_USER_ID'));
                                if (!empty($user_data[0]->col_midl_name)) {
                                    $midl_ini = $user_data[0]->col_midl_name[0] . '.';
                                } else {
                                    $midl_ini = '';
                                }
                                ?>
                                <input hidden type="text" name="INSRT_ENDORSER_NAME" id="INSRT_ENDORSER_NAME" class="form-control" value="<?= $this->session->userdata('SESS_USER_ID') ?>">
                                <input disabled type="text" name="" id="DISABLED_INSRT_ENDORSER_NAME" class="form-control" value="<?= $user_data[0]->col_empl_cmid . ' - ' . $user_data[0]->col_last_name . ', ' . $user_data[0]->col_frst_name . ' ' . $midl_ini; ?>">
                                <?php
                                ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required" for="INSRT_EMPLOYEE_ID">Employee Name</label>
                                <select class="form-control" name="INSRT_EMPLOYEE_ID" id="INSRT_EMPLOYEE_ID">
                                    <option value="">Choose...</option>
                                    <?php
                                    foreach ($DISP_EMPL_INFO as $DISP_EMPL_INFO_ROW) {
                                    ?>
                                        <option value="<?= $DISP_EMPL_INFO_ROW->id ?>"><?= $DISP_EMPL_INFO_ROW->col_empl_cmid . ' - ' . $DISP_EMPL_INFO_ROW->col_frst_name . ' ' . $DISP_EMPL_INFO_ROW->col_last_name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <small class="text-danger" id="employeeIdErrorMsg" hidden>Employee is required</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required" for="INSRT_PROMOTE_TO">Promote To</label>
                                <select class="form-control" name="INSRT_PROMOTE_TO" id="INSRT_PROMOTE_TO">
                                    <option value="">Choose...</option>
                                    <?php
                                    foreach ($DISP_EMP_POSITION as $DISP_EMP_POSITION_ROW) {
                                    ?>
                                        <option value="<?= $DISP_EMP_POSITION_ROW->id ?>"><?= $DISP_EMP_POSITION_ROW->name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <small class="text-danger" id="positionIdErrorMsg" hidden>Position is required</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required" for="INSRT_DESCRIPTION">Description</label>
                                <textarea class="form-control" name="INSRT_DESCRIPTION" id="INSRT_DESCRIPTION" cols="30" rows="5"></textarea>
                                <small class="text-danger" id="descriptionErrorMsg" hidden>Description is required</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="INSRT_ATTACHMENT">Attachment</label>
                                <div class="input-group">
                                    <input type="file" name="INSRT_ATTACHMENT" class="form-control" id="INSRT_ATTACHMENT" accept=".doc, .docx, .ppt, .pptx, .xls, .xlsx, .pdf">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 w-100">
                            <!-- <a href="#" class="btn btn-primary float-right text-white" id="INSRT_ENDORSEMENT_BTN">Add</a> -->
                            <button class="btn btn-primary float-right text-white" id="INSRT_ENDORSEMENT_BTN" type="button">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- UPDATE/VIEW ENDORSEMENT -->
<div class="modal fade" id="editViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0 ml-1">Endorsement Info
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body pb-5">
                <form action="<?php echo base_url('promotions/update_endorsement'); ?>" id="update_endrorsement" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                    <div class="row">
                        <input hidden type="text" name="UPDATE_ID" id="UPDATE_ID" class="form-control" value="">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="VIEW_STATUS">Status</label>
                                <select class="form-control" name="VIEW_STATUS" id="VIEW_STATUS_SELECT" onchange="changeStatus()" disabled>
                                    <option value="New">New</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Returned">Returned</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Reject">Reject</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="VIEW_ENDORSER_NAME">Endorser Name</label>
                                <input disabled type="text" name="" id="VIEW_ENDORSER_NAME" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="VIEW_ENDORSER_DATETIME">Endorsed Date Time</label>
                                <input class="form-control" type="datetime-local" value="" name="VIEW_ENDORSER_DATETIME" id="VIEW_ENDORSER_DATETIME" disabled>
                                <?php
                                ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required" for="VIEW_PROMOTION_ID">Promotion ID</label>
                                <input class="form-control" type="text" value="" name="VIEW_PROMOTION_ID" id="VIEW_PROMOTION_ID" disabled>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required" for="VIEW_EMPLOYEE_ID">Employee Name</label>
                                <select class="form-control" name="VIEW_EMPLOYEE_ID" id="" disabled>
                                    <?php
                                    foreach ($DISP_EMPL_INFO as $DISP_EMPL_INFO_ROW) {
                                    ?>
                                        <option value="<?= $DISP_EMPL_INFO_ROW->id ?>"><?= $DISP_EMPL_INFO_ROW->col_empl_cmid . ' - ' . $DISP_EMPL_INFO_ROW->col_frst_name . ' ' . $DISP_EMPL_INFO_ROW->col_last_name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required" for="VIEW_PROMOTE_TO">Promote To</label>
                                <select class="form-control" name="VIEW_PROMOTE_TO" id="VIEW_PROMOTE_TO" disabled>
                                    <?php
                                    foreach ($DISP_EMP_POSITION as $DISP_EMP_POSITION_ROW) {
                                    ?>
                                        <option value="<?= $DISP_EMP_POSITION_ROW->id ?>"><?= $DISP_EMP_POSITION_ROW->name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required" for="VIEW_DESCRIPTION">Description</label>
                                <textarea class="form-control" name="VIEW_DESCRIPTION" id="VIEW_DESCRIPTION" cols="30" rows="5" disabled></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="VIEW_ATTACHEMENT">Attachment</label>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input class="form-control" type="text" value="" name="" id="VIEW_ATTACHEMENT" disabled>
                                <div class="input-group">
                                    <input hidden type="file" name="UPDATE_ATTACHMENT" class="form-control" id="UPDATE_ATTACHMENT" accept=".doc, .docx, .ppt, .pptx, .xls, .xlsx, .pdf">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <a href="" target="_blank" class="btn btn-primary shadow-none w-100" id="downloadBtn">Download</a>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-primary shadow-none w-100" onclick="editUpload()" id="uploadBtn" disabled>Upload New</button>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="required" for="VIEW_APPROVER_NAME">Approver Name</label>
                                <input class="form-control" type="text" value="" name="VIEW_APPROVER_NAME" id="VIEW_APPROVER_NAME" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="VIEW_DECISION_DATETIME">Decision Date Time</label>
                                <input class="form-control" type="datetime-local" value="" name="VIEW_DECISION_DATETIME" id="VIEW_DECISION_DATETIME" disabled>
                                <?php
                                ?>
                            </div>
                        </div>
                        <div class="col-6 mt-5">
                            <div class="form-group mb-0">
                                <label for="VIEW_EFFECTIVITY_DATETIME">Effectivity Date</label>
                                <input class="form-control" type="date" value="" name="VIEW_EFFECTIVITY_DATETIME" id="VIEW_EFFECTIVITY_DATETIME" disabled>
                                <?php
                                ?>
                            </div>
                            <div>
                                <small class="text-danger" id="effectivityErrorMsg" hidden>Effectivity Date is required</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <label class="required" for="VIEW_REMARKS">Remarks</label>
                                <textarea class="form-control" name="VIEW_REMARKS" id="VIEW_REMARKS" cols="30" rows="5" value="" disabled></textarea>
                            </div>
                            <div>
                                <small class="text-danger" id="remarksErrorMsg" hidden>Remarks is required</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 w-100">
                            <button class="btn btn-primary shadow-none float-right text-white" data-dismiss="modal" aria-label="Close" id="updateCloseBtn">Close</button>
                            <a href="#" class="btn btn-primary float-right text-white" id="UPDATE_ENDORSEMENT_BTN">Update</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js">
</script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js">
</script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js">
</script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js">
</script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js">
</script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
</script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/adminlte.js">
</script>
<!-- Full Calendar 2.2.5 -->
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js">
</script>
<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js">
</script>
<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js">
</script>
<!-- Toastr -->
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js">
</script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js">
</script>
<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/js/froala_editor.pkgd.min.js">
</script>
<!-- Pagination -->
<script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>
<!-- Bootstrap Table -->
<script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>
<!-- Initialize the editor. -->
<script>
    async function getOneData(id, action) {
        let url = '<?= base_url() ?>promotions/get_one_endorsement?id=' + id;
        const response = await fetch(url).then(res => res.text()).then(rep => {
            const endorsement = JSON.parse(rep);
            let promotionId = "";
            if (endorsement.id.length == 1) {
                promotionId = "PRM0000" + endorsement.id;
            } else if (endorsement.id.length == 2) {
                promotionId = "PRM000" + endorsement.id;
            } else if (endorsement.id.length == 3) {
                promotionId = "PRM00" + endorsement.id;
            } else if (endorsement.id.length == 4) {
                promotionId = "PRM0" + endorsement.id;
            } else {
                promotionId = "PRM" + endorsement.id;
            }

            endorsement.endorser_id
            endorsement.id
            endorsement.reg_date
            endorsement.employee_image
            $("#VIEW_ENDORSER_NAME").val(endorsement.endorser);
            $("#VIEW_PROMOTION_ID").val(promotionId);
            $("#VIEW_EMPLOYEE_ID").val(endorsement.employee_id);
            $("#VIEW_ENDORSER_DATETIME").val(endorsement.endorsed_date);
            $("#VIEW_STATUS_SELECT").val(endorsement.status);
            $("#VIEW_PROMOTE_TO").val(endorsement.position_id);
            $("#VIEW_DESCRIPTION").val(endorsement.description);
            $("#VIEW_ATTACHEMENT").val(endorsement.attachment);
            $("#VIEW_REMARKS").val(endorsement.remarks);
            $("#UPDATE_ID").val(endorsement.id);
            let downloadUrl = '<?= base_url() ?>promotions/' + endorsement.attachment;
            $("#downloadBtn").attr("href", downloadUrl);

            var today = new Date(endorsement.effectivity_date);
            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            $("#VIEW_EFFECTIVITY_DATETIME").val(date);
            $('#VIEW_ATTACHEMENT').removeAttr('hidden');
            $('#UPDATE_ATTACHMENT').attr('hidden', true);
            $('#uploadBtn').text('Upload New');
            $("#VIEW_STATUS_SELECT").attr("disabled", "disabled");
            $("#VIEW_EFFECTIVITY_DATETIME").attr("disabled", "disabled");
            console.log(action)
            if (action == "edit") {
                if (endorsement.status == "New") {
                    $("#VIEW_STATUS_SELECT").removeAttr("disabled");
                    $("#VIEW_PROMOTE_TO").attr("disabled", "disabled");
                    $("#VIEW_DESCRIPTION").attr("disabled", "disabled");
                    $("#VIEW_APPROVER_NAME").val(endorsement.approver);
                    $("#VIEW_DECISION_DATETIME").val(endorsement.decision_date);
                } else if (endorsement.status == "Pending") {
                    $("#VIEW_STATUS_SELECT").removeAttr("disabled");
                } else {
                    $("#VIEW_STATUS_SELECT").attr("disabled", "disabled");
                    $("#VIEW_EFFECTIVITY_DATETIME").attr("disabled", "disabled");
                    $("#VIEW_REMARKS").attr("disabled", "disabled");
                    $("#VIEW_PROMOTE_TO").removeAttr("disabled");
                    $("#VIEW_DESCRIPTION").removeAttr("disabled");
                }
                $("#uploadBtn").removeAttr("disabled");
                $("#updateCloseBtn").css("display", "none");
                $("#UPDATE_ENDORSEMENT_BTN").css("display", "block");

            } else {
                $("#VIEW_DECISION_DATETIME").val(endorsement.decision_date);
                $("#updateCloseBtn").css("display", "block");
                $("#UPDATE_ENDORSEMENT_BTN").css("display", "none");
                $("#VIEW_STATUS_SELECT").attr("disabled", "disabled");
                $("#VIEW_EFFECTIVITY_DATETIME").attr("disabled", "disabled");
                $("#VIEW_REMARKS").attr("disabled", "disabled");
                $("#VIEW_PROMOTE_TO").attr("disabled", "disabled");
                $("#VIEW_DESCRIPTION").attr("disabled", "disabled");
                $("#uploadBtn").attr("disabled", "disabled");
            }
        });
    }

    $(document).ready(function() {
        if (window.location.href.includes("promotions/my_endorsements")) {
            $("#myTab").addClass("active");
            $("#myTabPane").addClass("active");
        } else if (window.location.href.includes("promotions/for_approval")) {
            $("#forApprovalTab").addClass("active");
            $("#forApprovalTabPane").addClass("active");
        } else {
            $("#overallTab").addClass("active");
            $("#overallTabPane").addClass("active");
        }
    })

    $('#INSRT_ENDORSEMENT_BTN').click(function(e) {
        var employmentId = $('#INSRT_EMPLOYEE_ID').val();
        var positionId = $('#INSRT_PROMOTE_TO').val();
        var description = $('#INSRT_DESCRIPTION').val();

        $('#employeeIdErrorMsg').attr("hidden", true);
        $('#positionIdErrorMsg').attr("hidden", true);
        $('#descriptionErrorMsg').attr("hidden", true);
        var hasErr = 0;

        if (!employmentId) {
            hasErr++;
            $('#INSRT_EMPLOYEE_ID').addClass('is-invalid');
            $('#employeeIdErrorMsg').removeAttr("hidden");
        }
        if (!positionId) {
            hasErr++;
            $('#INSRT_PROMOTE_TO').addClass('is-invalid');
            $('#positionIdErrorMsg').removeAttr("hidden");
        }

        if (!description) {
            hasErr++;
            $('#INSRT_DESCRIPTION').addClass('is-invalid');
            $('#descriptionErrorMsg').removeAttr("hidden");
        }

        if (!hasErr) {
            $('#add_endrorsement').submit();
        } else {
            e.preventDefault();
        }
    })

    $('#INSRT_EMPLOYEE_ID').change(function() {
        $('#INSRT_EMPLOYEE_ID').removeClass('is-invalid');
    })

    $('#INSRT_PROMOTE_TO').change(function() {
        $('#INSRT_PROMOTE_TO').removeClass('is-invalid');
    })

    $('#INSRT_DESCRIPTION').change(function() {
        $('#INSRT_DESCRIPTION').removeClass('is-invalid');
    })

    $('#INSRT_ATTACHMENT').change(function() {
        $('#INSRT_ATTACHMENT').removeClass('is-invalid');
    })

    $('#UPDATE_ENDORSEMENT_BTN').click(function(e) {
        var effectivityDate = $('#VIEW_EFFECTIVITY_DATETIME').val();
        var remarks = $('#VIEW_REMARKS').val();
        var status = $('#VIEW_STATUS').val();

        $('#effectivityErrorMsg').attr("hidden", true);
        $('#remarksErrorMsg').attr("hidden", true);
        var hasErr = 0;

        if (!effectivityDate && status == "Approved") {
            hasErr++;
            $('#VIEW_EFFECTIVITY_DATETIME').addClass('is-invalid');
            $('#effectivityErrorMsg').removeAttr("hidden");
        }
        if (!remarks && status == "Approved") {
            hasErr++;
            $('#VIEW_REMARKS').addClass('is-invalid');
            $('#remarksErrorMsg').removeAttr("hidden");
        }

        if (!hasErr) {
            $('#update_endrorsement').submit();
        } else {
            e.preventDefault();
        }
    })

    $('#VIEW_EFFECTIVITY_DATETIME').change(function() {
        $('#VIEW_EFFECTIVITY_DATETIME').removeClass('is-invalid');
    })

    $('#VIEW_REMARKS').change(function() {
        $('#VIEW_REMARKS').removeClass('is-invalid');
    })

    function editUpload() {
        if (jQuery('#UPDATE_ATTACHMENT')[0].hasAttribute('hidden')) {
            $('#UPDATE_ATTACHMENT').removeAttr('hidden');
            $('#VIEW_ATTACHEMENT').attr('hidden', true);
            $('#uploadBtn').text('Cancel Upload');
        } else {
            $('#VIEW_ATTACHEMENT').removeAttr('hidden');
            $('#UPDATE_ATTACHMENT').attr('hidden', true);
            $('#uploadBtn').text('Upload New');
        }
    }

    function changeStatus() {
        if ($("#VIEW_STATUS_SELECT").val() == "Approved") {
            $("#VIEW_EFFECTIVITY_DATETIME").removeAttr("disabled");
            $("#VIEW_REMARKS").removeAttr("disabled");
        } else {
            $("#VIEW_EFFECTIVITY_DATETIME").attr("disabled", "disabled");
            $("#VIEW_REMARKS").attr("disabled", "disabled");
        }
    }
</script>

<!-- SESSION MESSAGES -->
<?php
if ($this->session->userdata('SESS_SUCC_MSG_ADD')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_ADD'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_ADD');
}

if ($this->session->userdata('SESS_SUCC_MSG_UPDATE')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_UPDATE'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_UPDATE');
}

if ($this->session->userdata('SESS_ERROR_MSG')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_ERROR_MSG'); ?>',
            '',
            'error'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_ERROR_MSG');
}

?>


</body>

</html>