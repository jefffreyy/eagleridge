<style>
    .card{
        padding: 20px;
    }
    li a{
        color: #0D74BC;
    }
    a:hover{
        text-decoration: none;
    }
    .activity td{
        padding: 6.8px 20px;
    }
    .page-item .active{
        background-color: #0D74BC !important;
    }
    .required:after {
        content: " *";
    }

    .required:after {
        content: " *";
        color: red;
    }
    li a{
        font-size: 14px;
    }
    .header-elements a{
        font-size: 14px;
    }
    .list-icons a{
        font-size: 11.2px;
        color: #197fc7;
    }
    .profile{
        padding: 20px 0px 0px;
    }
    .profile-img{
        display: inline-block;
        padding-right: 20px;
    }
    .profile-disc{
        margin-left: 100px;
    }
    .profile-name{
        font-weight: bold;
        font-size:16px;
        color: black;
    }
    .position{
        font-weight: bold;
        font-size: 15px;
        color: #B0B0B0;
    }
    .divider{
        margin-top: 50px;
    }
    .social-div a{
        padding: 10px 15px;
        color: #6a6a6a;
        font-size: 15px;
    }
    .label-note{
        background-color: #fde6d8;
        padding: 5px 10px;
        border-radius: 30px;
        color: #c46632;
        font-weight: bold;
        text-align: center;
        line-height: normal;
    }
    table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
   
    }
    th, td {
    text-align: left;
    padding: 8px;
    font-size: 14px;
    font-weight: normal;
    }

    .col-xs-15,
    .col-sm-15,
    .col-md-15,
    .col-lg-15 {
        position: relative;
        min-height: 1px;
        padding-right: 10px;
        padding-left: 10px;
        width: 100%;
    }
    @media (min-width: 768px) {
    .col-sm-15 {
            width: 20%;
            float: left;
        }
    }
    @media (min-width: 992px) {
        .col-lg-15 {
            width: 50%;
            float: left;
        }
    }
    @media (min-width: 1300px) {
        .col-lg-15 {
            width: 20%;
            float: left;
        }
    }

    
</style>

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

	<div class="content-wrapper">
		<div class="container-fluid p-4">
            <div class="row mb-2">
                <div class = "col-md-6">
                    <h1><b>Accessibility</b><h1>
                </div>
                <div class = "col-md-6" style = "text-align: right;">
                        <!-- <a href = "<?=base_url()?>employees/new_employee" type ="button" class = "btn btn-primary shadow-none"><i class="fas fa-plus"></i> Add Employee</a> -->
                    <!-- <a href = "#" id="save_user_access" type ="button" class = "btn btn-primary shadow-none">Save Changes</a>
                    <div class="spinner-border text-primary" style="display: none;" id="loading_indicator_user_access"></div> -->
                </div>
            </div>
            <div class = "row mb-3">
                <div class = "col-md-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1" style = "background-color: white;"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search by name, email or phone number" id="filter_employee" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-md-8">
                    <!-- <div class="float-right">
                        <a class="btn btn-primary float-right" title="Add" href="#" data-toggle="modal" data-target="#modal_add_position">
                            <i class="fas fa-fw fa-plus"></i> Add
                        </a>
                    </div> -->
                </div>
            </div>

            <div class="card border-0 mt-4" style = "padding: 0px; margin: 0px">
                <table class="table table-hover" id="positions_tbl">
                    <thead>
                        <tr>
                            <th>Position Title</th>
                            <th>User Access</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($DISP_POSITION_INFO) {
                            foreach($DISP_POSITION_INFO as $DISP_POSITION_INFO_ROW){ 
                                ?>
                                    <tr>
                                        <td><?=$DISP_POSITION_INFO_ROW->name?></td>
                                        <td><?php echo str_replace(',', ', ', $DISP_POSITION_INFO_ROW->user_access); ?></td>
                                        <td class="">
                                            <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                                    <a class="btn btn-sm indigo lighten-2 edit_position" position_name="<?= $DISP_POSITION_INFO_ROW->name ?>" position_id="<?=$DISP_POSITION_INFO_ROW->id?>" title="Edit" data-toggle="modal" data-target="#modal_edit_position" >
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                            }
                        } else { 
                        ?>
                            <tr>
                                <td colspan='3'>No Data Yet</td>
                            </tr>
                        <?php 
                            } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
	</div>

	<aside class="control-sidebar control-sidebar-dark"></aside>

    <!-- Add Position Modal -->
    <div class="modal fade" id="modal_add_position" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Positions</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('admin/insrt_position'); ?>" id="form_add_position" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="required" style="font-size: 17px; font-weight: 600;" for="pos_name">Position Title</p>
                                    <input class="form-control form-control" type="text" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-6">
                                        
                                        <p class="required" style="font-size: 17px; font-weight: 600;">User Access</p>
                                        <!-- <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="self_service_tab">
                                            <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="self_service_tab"><strong>Self-Service</strong></label></a>
                                        </div>
                                        <ul class="mt-3">
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input self_service_tab" type="checkbox" value="My Info" id="my_info" name="my_info">
                                                    <label class="form-check-label" for="my_info">My Info</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input self_service_tab" type="checkbox" value="My Time Record" id="my_time_record" name="my_time_record">
                                                    <label class="form-check-label" for="my_time_record">My Time Record</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input self_service_tab" type="checkbox" value="My Leave" id="my_leave" name="my_leave">
                                                    <label class="form-check-label" for="my_leave">My Leave</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input self_service_tab" type="checkbox" value="My Overtime" id="my_overtime" name="my_overtime">
                                                    <label class="form-check-label" for="my_overtime">My Overtime</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input self_service_tab" type="checkbox" value="My Time Adjustment" id="my_time_adjustment" name="my_time_adjustment">
                                                    <label class="form-check-label" for="my_time_adjustment">My Time Adjustment</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input self_service_tab" type="checkbox" value="My Payslips" id="my_payslips" name="my_payslips">
                                                    <label class="form-check-label" for="my_payslips">My Payslips</label>
                                                </div>
                                            </li>
                                        </ul> -->

                                        <!-- <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="supervision_tab">
                                            <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="supervision_tab"><strong>Supervision</strong></label></a>
                                        </div>
                                        <ul class="mt-3">
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input supervision_tab" type="checkbox" value="Assign Leave" id="supervision_assign_leave" name="supervision_assign_leave">
                                                    <label class="form-check-label" for="supervision_assign_leave">Assign Leave</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input supervision_tab" type="checkbox" value="Assign Overtime" id="supervision_assign_overtime" name="supervision_assign_overtime">
                                                    <label class="form-check-label" for="supervision_assign_overtime">Assign Overtime</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input supervision_tab" type="checkbox" value="Daily Time Record" id="supervision_dtr" name="supervision_dtr">
                                                    <label class="form-check-label" for="supervision_dtr">Daily Time Record</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input supervision_tab" type="checkbox" value="Approval" id="supervision_approval" name="supervision_approval">
                                                    <label class="form-check-label" for="supervision_approval">Approval</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input supervision_tab" type="checkbox" value="Time Adjustment" id="supervision_time_adjustment" name="supervision_time_adjustment">
                                                    <label class="form-check-label" for="supervision_time_adjustment">Time Adjustment</label>
                                                </div>
                                            </li>
                                        </ul>

                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="accounting_tab">
                                            <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="accounting_tab"><strong>Accounting</strong></label></a>
                                        </div>
                                        <ul class="mt-3">
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input accounting_tab" type="checkbox" value="Payslip Generator" id="accounting_payslip_generator" name="accounting_payslip_generator">
                                                    <label class="form-check-label" for="accounting_payslip_generator">Payslip Generator</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input accounting_tab" type="checkbox" value="Loans" id="accounting_loans" name="accounting_loans">
                                                    <label class="form-check-label" for="accounting_loans">Loans</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input accounting_tab" type="checkbox" value="Company Contributions" id="accounting_company_contributions" name="accounting_company_contributions">
                                                    <label class="form-check-label" for="accounting_company_contributions">Company Contributions</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input accounting_tab" type="checkbox" value="Assets" id="accounting_assets" name="accounting_assets">
                                                    <label class="form-check-label" for="accounting_assets">Assets</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input accounting_tab" type="checkbox" value="Bank Details" id="accounting_bank_details" name="accounting_bank_details">
                                                    <label class="form-check-label" for="accounting_bank_details">Bank Details</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input accounting_tab" type="checkbox" value="Import CSV" id="accounting_import_csv" name="accounting_import_csv">
                                                    <label class="form-check-label" for="accounting_import_csv">Import CSV</label>
                                                </div>
                                            </li>
                                        </ul> -->

                                    </div>

                                    <div class="col-md-6">
                                        <!-- <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="human_resource_tab">
                                            <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="human_resource_tab"><strong>Human Resource</strong></label></a>
                                        </div>
                                        <ul class="mt-3">
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Employee List" id="hr_employee_list" name="hr_employee_list">
                                                    <label class="form-check-label" for="hr_employee_list">Employee List</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Daily Attendance" id="hr_daily_attendance" name="hr_daily_attendance">
                                                    <label class="form-check-label" for="hr_daily_attendance">Daily Attendance</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Attendance Records" id="hr_attendance_records" name="hr_attendance_records">
                                                    <label class="form-check-label" for="hr_attendance_records">Attendance Records</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Attendance Reports" id="hr_attendance_reports" name="hr_attendance_reports">
                                                    <label class="form-check-label" for="hr_attendance_reports">Attendance Reports</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Leave" id="hr_leave" name="hr_leave">
                                                    <label class="form-check-label" for="hr_leave">Leave</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Entitlement List" id="hr_entitlement_list" name="hr_entitlement_list">
                                                    <label class="form-check-label" for="hr_entitlement_list">Entitlement List</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Overtime" id="hr_overtime" name="hr_overtime">
                                                    <label class="form-check-label" for="hr_overtime">Overtime</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Time Adjustment" id="hr_time_adjustment" name="hr_time_adjustment">
                                                    <label class="form-check-label" for="hr_time_adjustment">Time Adjustment</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Loans" id="hr_loans" name="hr_loans">
                                                    <label class="form-check-label" for="hr_loans">Loans</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Allowances" id="hr_allowances" name="hr_allowances">
                                                    <label class="form-check-label" for="hr_allowances">Allowances</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Deductions" id="hr_deductions" name="hr_deductions">
                                                    <label class="form-check-label" for="hr_deductions">Deductions</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Approval Route" id="hr_approval_route" name="hr_approval_route">
                                                    <label class="form-check-label" for="hr_approval_route">Approval Route</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Remote Attendance" id="hr_remote_attendance" name="hr_remote_attendance">
                                                    <label class="form-check-label" for="hr_remote_attendance">Remote Attendance</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Announcements" id="hr_announcements" name="hr_announcements">
                                                    <label class="form-check-label" for="hr_announcements">Announcements</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Import Employees Data" id="hr_import_employees_data" name="hr_import_employees_data">
                                                    <label class="form-check-label" for="hr_import_employees_data">Import Employees Data</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Import Attendance Record" id="hr_import_attendance_record" name="hr_import_attendance_record">
                                                    <label class="form-check-label" for="hr_import_attendance_record">Import Attendance Record</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input human_resource_tab" type="checkbox" value="Biometrics Data" id="hr_biometrics_data" name="hr_biometrics_data">
                                                    <label class="form-check-label" for="hr_biometrics_data">Biometrics Data</label>
                                                </div>
                                            </li>
                                        </ul> -->

                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' id="ADD_BTN_SAVE">&nbsp;Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <!-- Edit Position Modal -->
    <div class="modal fade" id="modal_edit_position" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Positions</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo base_url('admin/updt_position'); ?>" id="form_edit_position" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="required" style="font-size: 17px; font-weight: 600;" for="pos_name">Position Title</p>
                                    <input class="form-control form-control" type="text" id="position_name" name="position_name" required disabled>
                                    <input class="form-control form-control" type="text" id="position_id" name="position_id" hidden>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-6">
                                        <p class="required" style="font-size: 17px; font-weight: 600;">User Access</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="self_service_tab">
                                            <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="self_service_tab"><strong>Self-Service</strong></label></a>
                                        </div>
                                        <ul class="mt-3">
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input self_service_tab" type="checkbox" value="My Info" id="my_info" name="my_info">
                                                    <label class="form-check-label" for="my_info">My Info</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input self_service_tab" type="checkbox" value="My Time Record" id="my_time_record" name="my_time_record">
                                                    <label class="form-check-label" for="my_time_record">My Time Record</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input self_service_tab" type="checkbox" value="My Leave" id="my_leave" name="my_leave">
                                                    <label class="form-check-label" for="my_leave">My Leave</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input self_service_tab" type="checkbox" value="My Overtime" id="my_overtime" name="my_overtime">
                                                    <label class="form-check-label" for="my_overtime">My Overtime</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input self_service_tab" type="checkbox" value="My Time Adjustment" id="my_time_adjustment" name="my_time_adjustment">
                                                    <label class="form-check-label" for="my_time_adjustment">My Time Adjustment</label>
                                                </div>
                                            </li>
                                            <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input self_service_tab" type="checkbox" value="My Payslips" id="my_payslips" name="my_payslips">
                                                    <label class="form-check-label" for="my_payslips">My Payslips</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-6">
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-primary text-light' id="EDIT_BTN_SAVE">&nbsp;Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




	<script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
        $.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- jQuery Knob Chart -->
	<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
	<!-- Summernote -->
	<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- Datatables -->
    <script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
	<!-- Full Calendar 2.2.5 -->
	<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
	<!-- Sweet Alert -->
	<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
	<!-- Toastr -->
	<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
    <?php
    if($this->session->userdata('SESS_SUCC_INSRT')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_INSRT'); ?>',
            '',
            'success'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_SUCC_INSRT');
    }
    ?>
    <?php
    if($this->session->userdata('SESS_ERR_IMAGE')){
    ?>
        <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_ERR_IMAGE'); ?>',
            '',
            'warning'
        )
        </script>
    <?php
    $this->session->unset_userdata('SESS_ERR_IMAGE');
    }
    ?>
    <!-- SESSION MESSAGES -->
    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_CSV'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_CSV');
    }
    ?>

    
    <?php
    if ($this->session->userdata('SESS_WARN_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_WARN_MSG_INSRT_CSV'); ?>',
                '',
                'warning'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_WARN_MSG_INSRT_CSV');
    }
    ?>

    <?php
    if ($this->session->userdata('SESS_ERR_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_CSV'); ?>',
                '',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_ERR_MSG_INSRT_CSV');
    }
    ?>






















    <script>
        $(document).ready(function(){

            var url_updt_user_access = '<?= base_url() ?>admin/updt_user_access';
            var url_get_user_access = '<?= base_url() ?>admin/get_user_access';


            var empl_tbl = $('#positions_tbl').DataTable({
                "paging": false,
                "searching": true,
                "ordering": false,
                "autoWidth": false,
                "info": true,
                columnDefs: [
                    { type: 'formatted-num', targets: 0 }
                ]
            })
            $('#positions_tbl_filter').parent().parent().hide();
            $('#positions_tbl_info').parent().parent().hide();

            $('#filter_employee').on( 'keyup', function () {
                empl_tbl.search( this.value ).draw();
            } );


            $('#self_service_tab').click(function(e){
                if (this.checked == true){
                    Array.from($('.self_service_tab')).forEach(function(element){
                        $(element).prop('checked', true);
                    })
                } else {
                    Array.from($('.self_service_tab')).forEach(function(element){
                        $(element).prop('checked', false);
                    })
                }
            })

            $('#supervision_tab').click(function(e){
                if (this.checked == true){
                    Array.from($('.supervision_tab')).forEach(function(element){
                        $(element).prop('checked', true);
                    })
                } else {
                    Array.from($('.supervision_tab')).forEach(function(element){
                        $(element).prop('checked', false);
                    })
                }
            })

            $('#human_resource_tab').click(function(e){
                if (this.checked == true){
                    Array.from($('.human_resource_tab')).forEach(function(element){
                        $(element).prop('checked', true);
                    })
                } else {
                    Array.from($('.human_resource_tab')).forEach(function(element){
                        $(element).prop('checked', false);
                    })
                }
            })

            $('#accounting_tab').click(function(e){
                if (this.checked == true){
                    Array.from($('.accounting_tab')).forEach(function(element){
                        $(element).prop('checked', true);
                    })
                } else {
                    Array.from($('.accounting_tab')).forEach(function(element){
                        $(element).prop('checked', false);
                    })
                }
            })








            
            // ================================== EDIT POSITION ======================================
            $('.edit_position').click(function(e){
                var position_name = $(this).attr('position_name');
                var position_id = $(this).attr('position_id');

                $('#position_name').val(position_name);
                $('#position_id').val(position_id);



                get_user_access(url_get_user_access, position_id).then(function(data){

                    Array.from(data).forEach(function(x){
                        var user_access = x.user_access.split(',');

                        $('#self_service_tab').prop('checked',false);
                        $('#my_info').prop('checked',false);
                        $('#my_time_record').prop('checked',false);
                        $('#my_leave').prop('checked',false);
                        $('#my_overtime').prop('checked',false);
                        $('#my_time_adjustment').prop('checked',false);
                        $('#my_payslips').prop('checked',false);

                        Array.from(user_access).forEach(function(page){
                            switch(page){
                                case 'My Info':
                                        $('#my_info').prop('checked',true);
                                        $('#self_service_tab').prop('checked',true);
                                    break;
                                case 'My Time Record':
                                        $('#my_time_record').prop('checked',true);
                                        $('#self_service_tab').prop('checked',true);
                                    break;
                                case 'My Leave':
                                        $('#my_leave').prop('checked',true);
                                        $('#self_service_tab').prop('checked',true);
                                    break;
                                case 'My Overtime':
                                        $('#my_overtime').prop('checked',true);
                                        $('#self_service_tab').prop('checked',true);
                                    break;
                                case 'My Time Adjustment':
                                        $('#my_time_adjustment').prop('checked',true);
                                        $('#self_service_tab').prop('checked',true);
                                    break;
                                case 'My Payslips':
                                        $('#my_payslips').prop('checked',true);
                                        $('#self_service_tab').prop('checked',true);
                                    break;
                                default:
                                    // code block
                            } 
                        })
                    })
                    
                })
            })














            // ================================== EDIT USER ACCESS ======================================
            async function updt_user_access(url, position_id){
            var formData = new FormData();
            formData.append('position_id', position_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }

            async function get_user_access(url, position_id){
            var formData = new FormData();
            formData.append('position_id', position_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
            }
        

            // ================================== RESET PASSWORD ======================================
            // async function reset_empl_password(url, empl_id){
            // var formData = new FormData();
            // formData.append('empl_id', empl_id);
            // const response = await fetch(url, {
            //     method: 'POST',
            //     body: formData
            // });
            // return response.json();
            // }
        
        })
        
    </script>
</body>
</html>
