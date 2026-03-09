<html>
<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row pt-1">
            <div class="col-md-6">
                <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'administrators'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;User Accessibility List </h1>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <button type="button" id="btn_add" class="btn btn-primary" data-toggle="modal" data-target="#modal_form"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">&nbsp;Add user access</button>
            </div>
        </div>
        <!-- Title Header Line -->
        <hr>



        <div class="col-12">
            <div class="card p-0 table-responsive">
                <table class="m-0 table table-bordered table-hover" id="positions_tbl">
                    <thead>
                        <tr>
                            <th>ACCESS ID</th>
                            <th>POSITION TITLE</th>
                            <th>USER ACCESS</th>
                            <th class="text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($USER_ACCESS) {
                            foreach ($USER_ACCESS as $user) { ?>
                                <tr>
                                    <td>ACCESS<?= str_pad($user['id'], 3, '0', STR_PAD_LEFT) ?></td>
                                    <td class="user_access"><?= $user["user_access"] ?></td>
                                    <td><?= $user["user_page"] ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn_edit indigo lighten-2 edit_position" data-id="<?= $user["id"] ?>" title="Edit" data-toggle="modal" data-target="#modal_form">
                                            <img src="<?= base_url('assets_system/icons/pen-to-square-solid.svg') ?>" alt="" id="edit">
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr class="table-active">
                                <td colspan="12">
                                    <center>No Records</center>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- Edit Position Modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="ModalLabel">Edit Positions</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url() . 'administrators/update_user_access'; ?>" id="form_edit_position" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="required" style="font-size: 17px; font-weight: 600;" for="pos_name">User</p>
                                <input class="form-control form-control" type="text" id="position_name" name="position_name" required disabled>
                                <input class="form-control form-control" type="text" id="position_id" name="position_id" hidden>
                            </div>
                        </div>
                    </div>

                    <div class="  col-md-12 items">
                        <?php if (isset($MODULES['Self-Service'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="selfservices_modules" type="checkbox" id="self_service_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="self_service_tab"><strong>Self-Service</strong></label></a>
                                </div>
                                <div class="row">

                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['Self-Service'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= $module ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (isset($MODULES['company'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="company_modules" type="checkbox" id="company_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="company_tab"><strong>Company</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['company'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= str_replace('Company-', '', $module) ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- Employee -->
                        <?php if (isset($MODULES['employee'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="employee_modules" type="checkbox" id="emplyee_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="emplyee_tab"><strong>Employee</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['employee'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= $module ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Attendance -->
                        <?php if (isset($MODULES['attendance'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="attendance_modules" type="checkbox" id="attendance_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="attendance_tab"><strong>Time and Attendance</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['attendance'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= $module ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- END -->
                        <!-- Leave -->
                        <?php if (isset($MODULES['leave'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="leave_modules" type="checkbox" id="leave_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="leave_tab"><strong>Leave</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['leave'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= $module ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>

                                </div>
                            </div>
                        <?php } ?>
                        <!-- END -->
                        <!-- Offset -->
                        <!-- <?php if ($MODULES['offset'] != '0') { ?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="offset_modules" type="checkbox" id="offset_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="offset_tab"><strong>Offset</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Offset Request" id="leave_request">
                                            <label class="form-check-label" for="leave">Offset Request</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Offset Entitlement" id="offset_entitlement">
                                            <label class="form-check-label" for="offset_entitlement">Offset Entitlements</label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Offset Approval Route" id="offset_approval_route">
                                            <label class="form-check-label" for="offset_approval_route">Offset Approval Route</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Offset Types" id="offset_types">
                                            <label class="form-check-label" for="offset_types">Offset Types</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
<?php } ?> -->
                        <!-- END -->
                        <!-- Overtime -->
                        <?php if (isset($MODULES['overtimes'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="overtime_modules" type="checkbox" id="overtime_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="overtime_tab"><strong>Overtime</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['overtimes'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= str_replace('Overtime-', '', $module) ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Overtime -->
                        <?php if (isset($MODULES['requests'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="overtime_modules" type="checkbox" id="overtime_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="overtime_tab"><strong>Requests</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['requests'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= str_replace('Overtime-', '', $module) ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- END -->

                        <?php if (isset($MODULES['teams'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="team_modules" type="checkbox" id="teams_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="teams_tab"><strong>Team</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['teams'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= $module ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- END -->
                        <!-- Overtime -->
                        <?php if (isset($MODULES['reports'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="report_modules" type="checkbox" id="reports_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="reports_tab"><strong>Reports</strong></label></a>

                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['reports'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= $module ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>

                            </div>
                        <?php } ?>
                        <!-- END -->
                        <!-- Payroll -->
                        <?php if (isset($MODULES['payroll'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="payroll_modules" type="checkbox" id="payroll_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="payroll_tab"><strong>Payroll</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['payroll'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= $module ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- End -->
                        <!-- Recruitment -->
                        <?php if (isset($MODULES['recruitment'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="recruitment_modules" type="checkbox" id="recruitment_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="recruitment_tab"><strong>Recruitment</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['recruitment'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= $module ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- End -->
                        <!-- HR Essetials -->
                        <?php if (isset($MODULES['hr'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="hr_modules" type="checkbox" id="hr_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="hr_tab"><strong>HR Essentials</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['hr'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= str_replace("HR ", "", $module); ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- END -->
                        <!-- Learn and Development -->
                        <?php if (isset($MODULES['benefits'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="benefits_modules" type="checkbox" id="benefits_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="benefits_tab"><strong>Earn/Deduct/Loan</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['benefits'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= $module ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- End -->
                        <!-- Assets -->
                        <?php if (isset($MODULES['asset'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="asset_modules" type="checkbox" id="assets_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="assets_tab"><strong>Assets</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['asset'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= $module ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- End -->
                        <!-- Administrator -->
                        <?php if (isset($MODULES['administrator'])) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="administrator_modules" type="checkbox" id="administrator_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="administrator_tab"><strong>Administrator</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <?php foreach ($MODULES['administrator'] as $module) : ?>
                                                <li class="col-6 list-unstyled mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input check_data" type="checkbox" name="data[]" value="<?= trim($module) ?>">
                                                        <label class="form-check-label"><?= str_replace("Admin-", "", $module); ?></label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- End -->
                        <!-- General Userguide -->
                        <?php if ($MODULES['general_userguide'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="general_userguide_modules" type="checkbox" id="general_userguide_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="general_userguide_tab"><strong>Guide for General Users</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_login_account" id="userguide_login_account">
                                                <label class="form-check-label" for="userguide_login_account">Login Account and Forgot Password</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_change_pass" id="userguide_change_pass">
                                                <label class="form-check-label" for="userguide_change_pass">Change Password</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_ot_req" id="userguide_ot_req">
                                                <label class="form-check-label" for="userguide_ot_req">Overtime Filing/Request</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_leave_req" id="userguide_leave_req">
                                                <label class="form-check-label" for="userguide_leave_req">Leave Filing/Request</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_holiday_req" id="userguide_holiday_req">
                                                <label class="form-check-label" for="userguide_holiday_req">Holiday Work Filing/Request</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_time_adj" id="userguide_time_adj">
                                                <label class="form-check-label" for="userguide_time_adj">Time Adjustment Filing/Request</label>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        <?php } ?>
                        <!-- end -->
                        <!-- HR Userguide -->
                        <?php if ($MODULES['hr_userguide'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="hr_guide_modules" type="checkbox" id="hr_guide_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="hr_guide_tab"><strong>Guide for HR Staff</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_add_edit" id="userguide_add_edit">
                                                <label class="form-check-label" for="userguide_add_edit">Add/Edit Employee Records</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_hr_active_inactive" id="userguide_hr_active_inactive">
                                                <label class="form-check-label" for="userguide_hr_active_inactive">Set Active/Inactive Employee</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_add_edit_workshift" id="userguide_add_edit_workshift">
                                                <label class="form-check-label" for="userguide_add_edit_workshift">Add/Edit Work Shifts</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_shift_assign" id="userguide_shift_assign">
                                                <label class="form-check-label" for="userguide_shift_assign">Shift Assignment</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_leave_approval" id="userguide_leave_approval">
                                                <label class="form-check-label" for="userguide_leave_approval">Set Leave Approval - Route</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_ot_approval" id="userguide_ot_approval">
                                                <label class="form-check-label" for="userguide_ot_approval">Set Overtime Approval - Route</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_benefits" id="userguide_benefits">
                                                <label class="form-check-label" for="userguide_benefits">Set Up Dynamic Benefits</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_announcement" id="userguide_announcement">
                                                <label class="form-check-label" for="userguide_announcement">Add Announcement</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_edit_company" id="userguide_edit_company">
                                                <label class="form-check-label" for="userguide_edit_company">Edit The About The Company</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_add_policy" id="userguide_add_policy">
                                                <label class="form-check-label" for="userguide_add_policy">Add Policy</label>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        <?php } ?>
                        <!-- end -->
                        <!-- Admin Userguide -->
                        <?php if ($MODULES['admin_userguide'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="admin_modules" type="checkbox" id="admin_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="admin_tab"><strong>Guide for Administrator</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_active_inactive" id="userguide_active_inactive">
                                                <label class="form-check-label" for="userguide_active_inactive">Set Active/Inactive Employees</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_reset_pass" id="userguide_reset_pass">
                                                <label class="form-check-label" for="userguide_reset_pass">Reset Password</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_useraccess" id="userguide_useraccess">
                                                <label class="form-check-label" for="userguide_useraccess">Set User Access</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_ip_whitelist" id="userguide_ip_whitelist">
                                                <label class="form-check-label" for="userguide_ip_whitelist">Set IP Address Whitelisting</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_set_home" id="userguide_set_home">
                                                <label class="form-check-label" for="userguide_set_home">Set Up Home Settings</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_set_company" id="userguide_set_company">
                                                <label class="form-check-label" for="userguide_set_company">Set Company Structure Settings</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="userguide_set_useraccess" id="userguide_set_useraccess">
                                                <label class="form-check-label" for="userguide_set_useraccess">Set Up User Accessibility</label>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        <?php } ?>
                        <!-- end -->


                        <!-- End -->
                        <!-- Performance -->
                        <!-- <?php if ($MODULES['performance'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="performance_modules" type="checkbox" id="performance_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="performance_tab"><strong>Performance</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Promotions" id="promotions">
                                                <label class="form-check-label" for="promotions">Promotions</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Apprasals" id="apprasals">
                                                <label class="form-check-label" for="apprasals">Apprasals</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="KPIs" id="kpis">
                                                <label class="form-check-label" for="kpis">KPIs</label>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Goals" id="goals">
                                                <label class="form-check-label" for="goals">Goals</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Review Templates" id="review_templates">
                                                <label class="form-check-label" for="review_templates">Review Templates</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?> -->
                        <!-- End -->
                        <!-- Rewards -->
                        <!-- <?php if ($MODULES['rewards'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="rewards_modules" type="checkbox" id="rewards_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="rewards_tab"><strong>Rewards</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Service Awards" id="service_awards">
                                                <label class="form-check-label" for="service_awards">Service Awards</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Awards List" id="awards_list">
                                                <label class="form-check-label" for="awards_list">Awards List</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Certificate Templates" id="certificate_templates">
                                                <label class="form-check-label" for="certificate_templates">Certificate Templates</label>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Award Types" id="award_types">
                                                <label class="form-check-label" for="award_types">Award Types</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?> -->
                        <!-- End -->





                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
                <button type="submit" class='btn btn-primary text-light' id="edit_btn_save">&nbsp;Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<?php $this->load->view('templates/jquery_link'); ?>

<?php if ($this->session->userdata('SESS_SUCC_MSG')) : ?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->userdata('SESS_SUCC_MSG'); ?>'
        })
    </script>
    <?php $this->session->unset_userdata('SESS_SUCC_MSG'); ?>
<?php endif; ?>

<?php if ($this->session->userdata('SESS_ERR_MSG')) : ?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: '<?php echo $this->session->userdata('SESS_ERR_MSG'); ?>'
        })
    </script>
    <?php $this->session->unset_userdata('SESS_ERR_MSG'); ?>
<?php endif; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    $(document).ready(function() {
        var url = '<?= base_url() ?>administrators';
        var url_add = '<?= base_url() ?>administrators/add_user_access';
        var url_update = '<?= base_url() ?>administrators/update_user_access';

        $("#btn_add").on("click", function() {
            $("#position_name").val("");
            $("input[type='checkbox']").prop("checked", false);
            $("#ModalLabel").text("Add new user access");
            $("position_name").val("");
            $("#position_name").prop("disabled", false);
            $('form').attr("action", url_add);
        })
        $(".btn_edit").on("click", function() {
            $("#ModalLabel").text("Edit user access");
            $("#position_name").prop("disabled", false);
            $('form').attr("action", url_update);
            let id = $(this).attr("data-id");
            $("#position_id").val(id);
            $("input[type='checkbox']").prop("checked", false);
            let user_access = $(this).parent().siblings("td.user_access").text();
            if (user_access.toLowerCase() == 'default') {
                $("#position_name").prop("disabled", true);
            }
            $("#position_name").val(user_access);
            // console.log(url + '/get_user_access_by_id/' + id)
            // $.get(url + '/get_user_access_by_id/' + id,function(res){
            //     console.log(res)
            // })
            fetch(url + '/get_user_access_by_id/' + id).then(response => {
                return response.json();
            }).then(res => {
                // console.log(res);
                $('input.check_data').each(function() {
                    let input_value = $(this).val();
                    let user_modules = res[0]["user_page"].split(', ');
                    // console.log(user_modules);
                    if (user_modules.indexOf(input_value) >= 0) {
                        $(this).prop("checked", true);
                    }
                    // if (res[0]["user_page"].search($(this).val()) >= 0 && $(this).val() != "") {
                    //     $(this).prop("checked", true);
                    // }
                })
            }).then(() => {
                $('.select_all').each(function() {
                    let check_all = false;
                    let check_box = $(this).parent().siblings("div.row").find('input');
                    check_box.each(function() {
                        if ($(this).is(':checked')) {
                            check_all = true;
                        }
                    })
                    $(this).prop("checked", check_all);
                })
            })
        })
        $('input.check_data').on("click", function() {
            let select_all_input = $(this).parentsUntil($(".check_module")).siblings(".module_data").children("input.select_all");
            if ($(this).is(':checked')) {
                $(this).parentsUntil(select_all_input.prop("checked", true));
            } else {
                let row_div = $(this).parentsUntil($(".check_module"));
                let check_boxes = row_div.children('ul').find('input');
                let check = false;
                check_boxes.each(function() {
                    if ($(this).is(':checked')) {
                        check = true;
                    }
                })
                row_div.siblings(".module_data").children("input.select_all").prop("checked", check);
            }
        })
        $(".select_all").on("click", function() {
            // console.log($(this))
            if ($(this).is(':checked')) {
                $(this).parent().siblings("div.row").find('input').prop('checked', true)
            } else {
                $(this).parent().siblings("div.row").find('input').prop('checked', false)
                // $(this).parent().siblings("div.row").children('ul').children('li').children('div').children('input').prop("checked", false);
            }
        })
    })
</script>


</body>

</html>