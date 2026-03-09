
<?php $this->load->view('templates/css_link') ?>
<?php $this->load->view('templates/companycontribution_style'); ?>

<style>
    .switch {
        position: relative;
        display: block;
        width: 50px;
        height: 26px;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    .switch input {
        display: none;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 21px;
        width: 21px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50px;
    }
    input:checked+.slider:before {
        background-color: limegreen;
    }
    input:checked+.slider:before {
        transform: translateX(23px);
    }
</style>
<div class="content-wrapper">
    <div class="p-4">
        <div class="flex-fill">
            <div class="row">
                <!-- Title Text -->
                <div class="col d-flex align-items-center">
                    <a href="<?= base_url() . 'superadministrators'; ?>"><img style="width: 24px; height: 24px; margin: 0 7px 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>
                    <h1 style="font-size: 24px;" class="page-title d-inline">Module Activation</h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <!-- Title Header Line -->
            <hr>
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url(); ?>superadministrators/update_status" id="form_edit_position" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                        <div class="  col-md-12 items">
                            <div class="container d-none d-lg-flex justify-content-end">
                                <button type="submit" class='btn btn-primary px-3 text-light' id="EDIT_BTN_SAVE"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                            </div>
                            <div class="check_module">
                                <input type="hidden" name="data[self_service][id]" value="<?= $DISP_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="self_service_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="self_service_tab"><strong>Self-Service</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6 col-sm-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Profile') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Profile" id="my_profile">
                                                <label class="form-check-label" for="my_profile">My Profile</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Attendance Record') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Attendance Record" id="my_time_in/out_record">
                                                <label class="form-check-label" for="my_time_in/out_record">My Attendance Record</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Complaints') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Complaints" id="my_complaints">
                                                <label class="form-check-label" for="my_complaints">My Complaints</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Leaves') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Leaves" id="my_leave">
                                                <label class="form-check-label" for="my_leave">My Leaves</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Loans') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Loans" id="my_loans">
                                                <label class="form-check-label" for="my_loans">My Loans</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Overtimes') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Overtimes" id="my_overtime">
                                                <label class="form-check-label" for="my_overtime">My Overtime</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Offsets') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Offsets" id="my_offsets">
                                                <label class="form-check-label" for="my_offsets">My Offsets</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Time Adjustments') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Time Adjustments" id="my_time_adjustment">
                                                <label class="form-check-label" for="my_time_adjustment">My Time Adjustment</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Payslips') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Payslips" id="my_payslips">
                                                <label class="form-check-label" for="my_payslips">My Payslips</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'Overtime Approval') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="Overtime Approval" id="overtime_approval">
                                                <label class="form-check-label" for="overtime_approval">Overtime Approval</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'Time Adjustment Approval') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="Time Adjustment Approval" id="time_adjustment_approval">
                                                <label class="form-check-label" for="time_adjustment_approval">Time Adjustment Approval</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'Backup Approvals') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="Backup Approvals" id="backup_approval">
                                                <label class="form-check-label" for="backup_approval">Backup Approval</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'Shift Request Approvals') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="Shift Request Approvals" id="shift_request_approvals">
                                                <label class="form-check-label" for="shift_request_approvals">Shift Request Approvals</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Shift Assignment') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Shift Assignment" id="my_shift_assignment">
                                                <label class="form-check-label" for="my_shift_assignment">My Shift Assignment</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Change Off Request') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Change Off Request" id="my_change_off_request">
                                                <label class="form-check-label" for="my_change_off_request">My Change Off Request</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'Change Off Approval') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="Change Off Approval" id="change_off_approval">
                                                <label class="form-check-label" for="change_off_approval">Change Off Approval</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'Undertime Request Approval') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="Undertime Request Approval" id="undertime_request_approval">
                                                <label class="form-check-label" for="undertime_request_approval">Undertime Request Approval</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'Offset Approval') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="Offset Approval" id="offset_approval">
                                                <label class="form-check-label" for="offset_approval">Offset Approval</label>
                                            </div>
                                        </li>

                                    </ul>
                                    <ul class="col col-md-6 col-sm-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Team') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Team" id="my_team">
                                                <label class="form-check-label" for="my_team">My Team</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Calendar') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Calendar" id="my_calendar">
                                                <label class="form-check-label" for="my_calendar">My Calendar</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Task') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Tasks" id="my_tasks">
                                                <label class="form-check-label" for="my_tasks">My Tasks</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Cash Advances') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Cash Advances">
                                                <label class="form-check-label">My Cash Advances</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Reimbursements') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Reimbursements" id="remote_attendance">
                                                <label class="form-check-label" for="remote_attendance">My Reimbursements</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Support Requests') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Support Requests" id="my_support_requests">
                                                <label class="form-check-label" for="my_support_requests">My Support Requests</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Warnings') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Warnings" id="my_warnings">
                                                <label class="form-check-label" for="my_warnings">My Warnings</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'Notifications') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="Notifications" id="notification">
                                                <label class="form-check-label" for="notification">Notifications</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'Leave Approval') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="Leave Approval" id="leave_approval">
                                                <label class="form-check-label" for="leave_approval">Leave Approval</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Holiday Work') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Holiday Work" id="my_holiday_work">
                                                <label class="form-check-label" for="my_holiday_work">My Holiday Work</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'Holiday Work Approval') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="Holiday Work Approval" id="holiday_work_approval">
                                                <label class="form-check-label" for="holiday_work_approval">Holiday Work Approval</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'Remote Attendance') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="Remote Attendance" id="remote_attendance">
                                                <label class="form-check-label" for="remote_attendance">Remote Attendance</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Assets') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Assets">
                                                <label class="form-check-label">My Assets</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Activities') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Activities">
                                                <label class="form-check-label">My Activities</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Messages') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Messages">
                                                <label class="form-check-label">My Messages</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'Nurse Approval') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="Nurse Approval">
                                                <label class="form-check-label">Nurse Approval</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Change Shift Request') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Change Shift Request">
                                                <label class="form-check-label">My Change Shift Request</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Undertime Request') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Undertime Request">
                                                <label class="form-check-label">My Undertime Request</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Exempt Undertime Request') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Exempt Undertime Request">
                                                <label class="form-check-label">My Exempt Undertime Request</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'Change Shift Approval') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="Change Shift Approval">
                                                <label class="form-check-label">Change Shift Approval</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_STATUS['value'], 'My Exempt Undertime Approval') !== false ? 'checked' : '' ?> name="data[self_service][values][]" value="My Exempt Undertime Approval">
                                                <label class="form-check-label">My Exempt Undertime Approval</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="check_module">
                                <input type="hidden" name="data[company][id]" value="<?= $DISP_COMPANY_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_COMPANY_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="company_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="company_tab"><strong>Company</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_COMPANY_STATUS['value'], 'Company-About the Company') !== false ? 'checked' : '' ?> name="data[company][values][]" value="Company-About the Company" id="about_the_company">
                                                <label class="form-check-label" for="about_the_company">About the Company</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_COMPANY_STATUS['value'], 'Company-Announcements') !== false ? 'checked' : '' ?> name="data[company][values][]" value="Company-Announcements" id="company_announcements">
                                                <label class="form-check-label" for="company_announcements">Announcements</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_COMPANY_STATUS['value'], 'Company-Policies ') !== false ? 'checked' : '' ?> name="data[company][values][]" value="Company-Policies " id="company_policies">
                                                <label class="form-check-label" for="company_policies">Policies</label>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_COMPANY_STATUS['value'], 'Company-Organizational Chart') !== false ? 'checked' : '' ?> name="data[company][values][]" value="Company-Organizational Chart" id="company_organizational_chart">
                                                <label class="form-check-label" for="company_organizational_chart">Organizational Chart</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_COMPANY_STATUS['value'], 'Company-Holidays ') !== false ? 'checked' : '' ?> name="data[company][values][]" value="Company-Holidays" id="company_holidays">
                                                <label class="form-check-label" for="company_holidays">Holidays</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_COMPANY_STATUS['value'], 'Company-Knowledge Base') !== false ? 'checked' : '' ?> name="data[company][values][]" value="Company-Knowledge Base" id="company_knowledbase">
                                                <label class="form-check-label" for="company_knowledbase">Knowledge Base</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--Teams-->
                            <div class="check_module">
                                <input type="hidden" name="data[teams][id]" value="<?= $DISP_TEAMS_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_TEAMS_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="teams_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="teams_tab"><strong>Teams</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Apply Leaves') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Apply Leaves" id="apply_leaves">
                                                <label class="form-check-label" for="apply_leaves">Apply Leaves</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Apply Overtimes') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Apply Overtimes" id="apply_overtimes">
                                                <label class="form-check-label" for="apply_overtimes">Apply Overtimes</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Apply Time Adjustments') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Apply Time Adjustments" id="apply_time_adjustments">
                                                <label class="form-check-label" for="apply_time_adjustments">Apply Time Adjustments</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Apply Holiday Works') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Apply Holiday Works" id="apply_holidaywork">
                                                <label class="form-check-label" for="apply_holidaywork">Apply Holiday Work</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Change Shift Request') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Change Shift Request" id="change_shift">
                                                <label class="form-check-label" for="change_shift">Change Shift Request</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Change Off Request') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Change Off Request" id="team_change_off">
                                                <label class="form-check-label" for="team_change_off">Change Off Request</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Undertime Approval') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Undertime Approval" id="undertime">
                                                <label class="form-check-label" for="change_shift">Undertime Approval</label>
                                            </div>
                                        </li>
                                    </ul>

                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Undertime Request') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Undertime Request" id="undertime">
                                                <label class="form-check-label" for="change_shift">Undertime Request</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Change Shift Approval') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Change Shift Approval" id="changeshift_approval">
                                                <label class="form-check-label" for="changeshift_approval">Change Shift Approval</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Shift Assignment') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Shift Assignment" id="shift_assignment">
                                                <label class="form-check-label" for="shift_assignment">Shift Assignment</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Shift Approval') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Shift Approval" id="shift_approval">
                                                <label class="form-check-label" for="shift_assignment">Shift Approval</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Shift Approver') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Shift Approver" id="shift_approver">
                                                <label class="form-check-label" for="shift_approver">Shift Approver</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Apply Offsets') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Apply Offsets" id="apply_offsets">
                                                <label class="form-check-label" for="apply_offsets">Apply Offsets</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_TEAMS_STATUS['value'], 'Exempt Undertime') !== false ? 'checked' : '' ?> name="data[teams][values][]" value="Exempt Undertime" id="apply_exempt_undertime">
                                                <label class="form-check-label" for="apply_exempt_undertime">Exempt Undertime</label>
                                            </div>
                                        </li>


                                    </ul>
                                </div>
                            </div>
                            <!-- Report -->
                            <div class="check_module">
                                <input type="hidden" name="data[reports][id]" value="<?= $DISP_REPORTS_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_TEAMS_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="teams_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="teams_tab"><strong>Reports</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_REPORTS_STATUS['value'], 'Employee Information Reports') !== false ? 'checked' : '' ?> name="data[reports][values][]" value="Employee Information Reports">
                                                <label class="form-check-label">Employee Information Reports</label>
                                            </div>
                                        </li>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_REPORTS_STATUS['value'], 'Employee Record Reports') !== false ? 'checked' : '' ?> name="data[reports][values][]" value="Employee Record Reports">
                                                <label class="form-check-label">Employee Record Reports</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_REPORTS_STATUS['value'], 'Timekeeping/Attendance Reports') !== false ? 'checked' : '' ?> name="data[reports][values][]" value="Timekeeping/Attendance Reports">
                                                <label class="form-check-label">Timekeeping/Attendance Reports</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_REPORTS_STATUS['value'], 'Report Generation') !== false ? 'checked' : '' ?> name="data[reports][values][]" value="Report Generation">
                                                <label class="form-check-label">Report Generation</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_REPORTS_STATUS['value'], 'Government Remittance Forms') !== false ? 'checked' : '' ?> name="data[reports][values][]" value="Government Remittance Forms">
                                                <label class="form-check-label">Government Remittance Forms</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- End -->
                            <!-- Employee -->
                            <div class="check_module">
                                <input type="hidden" name="data[employee][id]" value="<?= $DISP_EMPLOYEE_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_EMPLOYEE_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="employee_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="employee_tab"><strong>Employee</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_EMPLOYEE_STATUS['value'], 'Employee Directory') !== false ? 'checked' : '' ?> name="data[employee][values][]" value="Employee Directory" id="employee_directory">
                                                <label class="form-check-label" for="employee_directory">Employee Directory</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_EMPLOYEE_STATUS['value'], 'Approval Route') !== false ? 'checked' : '' ?> name="data[employee][values][]" value="Approval Route" id="employee_approval_route">
                                                <label class="form-check-label" for="employee_approval_route">Approval Route</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_EMPLOYEE_STATUS['value'], 'Manage Salary') !== false ? 'checked' : '' ?> name="data[employee][values][]" value="Manage Salary" id="manage_salary">
                                                <label class="form-check-label" for="manage_salary">Manage Salary</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_EMPLOYEE_STATUS['value'], 'Setup Organizational Chart') !== false ? 'checked' : '' ?> name="data[employee][values][]" value="Setup Organizational Chart" id="setup_organizational_chart">
                                                <label class="form-check-label" for="setup_organizational_chart">Setup Organizational Chart</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_EMPLOYEE_STATUS['value'], 'Payroll Assignment') !== false ? 'checked' : '' ?> name="data[employee][values][]" value="Payroll Assignment" id="payroll_assignment">
                                                <label class="form-check-label" for="payroll_assignment">Payroll Assignment</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_EMPLOYEE_STATUS['value'], 'Custom Group Assignment') !== false ? 'checked' : '' ?> name="data[employee][values][]" value="Custom Group Assignment" id="custom_group_assignment">
                                                <label class="form-check-label" for="custom_group_assignment">Custom Group Assignment</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_EMPLOYEE_STATUS['value'], 'Work Days') !== false ? 'checked' : '' ?> name="data[employee][values][]" value="Work Days" id="work_days">
                                                <label class="form-check-label" for="work_days">Work Days</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_EMPLOYEE_STATUS['value'], 'Offboarding') !== false ? 'checked' : '' ?> name="data[employee][values][]" value="Offboarding" id="offboarding">
                                                <label class="form-check-label" for="work_days">Offboarding</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_EMPLOYEE_STATUS['value'], 'Onboarding') !== false ? 'checked' : '' ?> name="data[employee][values][]" value="Onboarding" id="onboarding">
                                                <label class="form-check-label" for="onboarding">Onboarding</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_EMPLOYEE_STATUS['value'], 'Max Wire') !== false ? 'checked' : '' ?> name="data[employee][values][]" value="Max Wire" id="max_wire">
                                                <label class="form-check-label" for="max_wire">Max Wire</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input check_data" type="checkbox" 
                                                    <?=strpos($DISP_EMPLOYEE_STATUS['value'], 'Assign Geo Fence')!==false? 'checked' : '' ?>
                                                    name="data[employee][values][]" value="Assign Geo Fence" >
                                                    <label class="form-check-label">Assign Geo Fence</label>
                                                </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Attendance -->
                            <div class="check_module">
                                <input type="hidden" name="data[attendance][id]" value="<?= $DISP_ATTENDANCE_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_ATTENDANCE_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="attendance_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="attendance_tab"><strong>Time And Attendance</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Attendance Records') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Attendance Records" id="attendance_records">
                                                <label class="form-check-label" for="attendance_records">Attendance Records</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Attendance Summary') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Attendance Summary" id="attendance_summary">
                                                <label class="form-check-label" for="attendance_summary">Attendance Summary</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Daily Attendance') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Daily Attendance" id="daily_attendance">
                                                <label class="form-check-label" for="daily_attendance">Daily Attendance</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Work Shifts') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Work Shifts" id="work_shifts">
                                                <label class="form-check-label" for="work_shifts">Work Shifts</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Shift Assignment') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Shift Assignment" id="shift_assignments">
                                                <label class="form-check-label" for="shift_assignments">Shift Assignment</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Time Records') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Time Records" id="time_records">
                                                <label class="form-check-label" for="time_records">Time Records</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Converter') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Converter" id="converter">
                                                <label class="form-check-label" for="time_records">Converter</label>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Holidays') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Holidays" id="holidays">
                                                <label class="form-check-label" for="holidays">Holidays</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Time Adjustment List') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Time Adjustment List" id="time_adjustment_list">
                                                <label class="form-check-label" for="attendance_timeadjustment_list">Time Adjustment List</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Offset Request') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Offset Request" id="offset_lists">
                                                <label class="form-check-label" for="offset_lists">Offset List</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Zkteco Attendance') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Zkteco Attendance" id="zkteco_attendance">
                                                <label class="form-check-label" for="zkteco_attendance">Biometric Records</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Zkteco Code') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Zkteco Code" id="zkteco_code">
                                                <label class="form-check-label" for="zkteco_code">Biometric User ID</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Advance Attendance') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Advance Attendance" id="advance_attendance">
                                                <label class="form-check-label" for="advance_attendance">Advance Filing of Time Records</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ATTENDANCE_STATUS['value'], 'Attendance Undertime') !== false ? 'checked' : '' ?> name="data[attendance][values][]" value="Attendance Undertime" id="attendance_undertime">
                                                <label class="form-check-label" for="attendance_undertime">Attendance Undertime</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- END -->
                            <!-- HR Essentials -->
                            <div class="check_module">
                                <input type="hidden" name="data[hr_essentials][id]" value="<?= $DISP_HR_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_HR_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="hr_essentials_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="hr_essentials_tab"><strong>HR Essentials</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_HR_STATUS['value'], 'HR About the Company') !== false ? 'checked' : '' ?> name="data[hr_essentials][values][]" value="HR About the Company" id="hr_about_company">
                                                <label class="form-check-label" for="hr_about_company">About the Company</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_HR_STATUS['value'], 'HR Announcements') !== false ? 'checked' : '' ?> name="data[hr_essentials][values][]" value="HR Announcements" id="hr_announcements">
                                                <label class="form-check-label" for="hr_announcements">Announcements</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_HR_STATUS['value'], 'HR Warnings') !== false ? 'checked' : '' ?> name="data[hr_essentials][values][]" value="HR Warnings" id="hr_warnings">
                                                <label class="form-check-label" for="hr_warnings">Warnings</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_HR_STATUS['value'], 'HR Support') !== false ? 'checked' : '' ?> name="data[hr_essentials][values][]" value="HR Support" id="hr_support">
                                                <label class="form-check-label" for="hr_support">Support</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_HR_STATUS['value'], 'HR Activities') !== false ? 'checked' : '' ?> name="data[hr_essentials][values][]" value="HR Activities">
                                                <label class="form-check-label">Activities</label>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="col-md-6">
                                        <!-- <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Forms" id="hr_forms">
                                                <label class="form-check-label" for="hr_forms">Forms</label>
                                            </div>
                                        </li> -->
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_HR_STATUS['value'], 'HR Complaint') !== false ? 'checked' : '' ?> name="data[hr_essentials][values][]" value="HR Complaint" id="hr_complaint">
                                                <label class="form-check-label" for="hr_complaint">Complaint</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_HR_STATUS['value'], 'HR Survey') !== false ? 'checked' : '' ?> name="data[hr_essentials][values][]" value="HR Survey" id="hr_survey">
                                                <label class="form-check-label" for="hr_survey">Survey</label>
                                            </div>
                                        </li>
                                        <!-- <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Knowledge Base" id="hr_knowledge_base">
                                                <label class="form-check-label" for="hr_knowledge_base">Knowledge Base</label>
                                            </div>
                                        </li> -->
                                        <!-- <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Events" id="hr_events">
                                                <label class="form-check-label" for="hr_events">Events</label>
                                            </div>
                                        </li> -->
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_HR_STATUS['value'], 'HR Policies') !== false ? 'checked' : '' ?> name="data[hr_essentials][values][]" value="HR Policies" id="hr_policies">
                                                <label class="form-check-label" for="hr_policies">Policies</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_HR_STATUS['value'], 'HR Welcome Messages') !== false ? 'checked' : '' ?> name="data[hr_essentials][values][]" value="HR Welcome Messages" id="hr_welcome_messages">
                                                <label class="form-check-label" for="hr_welcome_messages">Welcome Messages</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- END -->
                            <!-- Leave -->
                            <div class="check_module">
                                <input type="hidden" name="data[leave][id]" value="<?= $DISP_LEAVE_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_LEAVE_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="leave_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="leave_tab"><strong>Leave</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_LEAVE_STATUS['value'], 'Leave Request') !== false ? 'checked' : '' ?> name="data[leave][values][]" value="Leave Request" id="leave_requests">
                                                <label class="form-check-label" for="leave_requests">Leave Request</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_LEAVE_STATUS['value'], 'Leave Entitlement') !== false ? 'checked' : '' ?> name="data[leave][values][]" value="Leave Entitlement" id="leave_entitlement">
                                                <label class="form-check-label" for="leave_entitlement">Leave Entitlement</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- END -->
                            <!-- Overtime -->
                            <div class="check_module">
                                <input type="hidden" name="data[overtimes][id]" value="<?= $DISP_OVERTIME_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_OVERTIME_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="overtime_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="overtime_tab"><strong>Overtime</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_OVERTIME_STATUS['value'], 'Overtime-Holiday Work') !== false ? 'checked' : '' ?> name="data[overtimes][values][]" value="Overtime-Holiday Work" id="holiday_work">
                                                <label class="form-check-label" for="Overtime-Holiday Work">Holiday Work</label>
                                            </div>
                                        </li>
                                        <!-- <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_OVERTIME_STATUS['value'], 'Overtime-Overtime Request') !== false ? 'checked' : '' ?> name="data[overtimes][values][]" value="Overtime-Overtime Request" id="overtime_request">
                                                <label class="form-check-label" for="overtime_request">Overtime Request</label>
                                            </div>
                                        </li> -->
                                    </ul>
                                </div>
                            </div>
                            <!-- END -->

                            <!-- Requests -->
                            <div class="check_module">
                                <input type="hidden" name="data[requests][id]" value="<?= $DISP_REQUESTS_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_REQUESTS_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="requests_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="requests_tab"><strong>Request</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_REQUESTS_STATUS['value'], 'Change-Shift Request') !== false ? 'checked' : '' ?> name="data[requests][values][]" value="Change-Shift Request" id="change_request">
                                                <label class="form-check-label" for="Change-Shift Request">Change Shift Request</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_REQUESTS_STATUS['value'], 'Change-Off Request') !== false ? 'checked' : '' ?> name="data[requests][values][]" value="Change-Off Request" id="changeoff_request">
                                                <label class="form-check-label" for="Change-Off Request">Change Off Request</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_REQUESTS_STATUS['value'], 'Undertime-Request') !== false ? 'checked' : '' ?> name="data[requests][values][]" value="Undertime-Request" id="undertime_request">
                                                <label class="form-check-label" for="Undertime-Request">Undertime Request</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_REQUESTS_STATUS['value'], 'Exempt Undertime Approval') !== false ? 'checked' : '' ?> name="data[requests][values][]" value="Exempt Undertime Approval" id="exempt_undertime_request">
                                                <label class="form-check-label" for="exempt_undertime_request">Exempt Undertime Approval</label>
                                            </div>
                                        </li>

                                    </ul>
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_REQUESTS_STATUS['value'], 'Offset-Request') !== false ? 'checked' : '' ?> name="data[requests][values][]" value="Offset-Request" id="offset_request">
                                                <label class="form-check-label" for="Offset-Request">Offset Request</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_REQUESTS_STATUS['value'], 'Overtime-Overtime Request') !== false ? 'checked' : '' ?> name="data[requests][values][]" value="Overtime-Overtime Request" id="overtime_request">
                                                <label class="form-check-label" for="Overtime-Overtime Request">Overtime Request</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_REQUESTS_STATUS['value'], 'Leave Request') !== false ? 'checked' : '' ?> name="data[requests][values][]" value="Leave Request" id="leave_request">
                                                <label class="form-check-label" for="Leave-Request">Leave Request</label>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <!-- END -->

                            <!--Earn/Deduct/Loan-->
                            <div class="check_module">
                                <input type="hidden" name="data[benefits][id]" value="<?= $DISP_BENEFITS_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_BENEFITS_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="benefits_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="benefits_tab"><strong>Earn/Deduct/Loan</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_BENEFITS_STATUS['value'], 'Non-Taxable Allowances') !== false ? 'checked' : '' ?> name="data[benefits][values][]" value="Non-Taxable Allowances">
                                                <label class="form-check-label">Non-Taxable Allowances</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_BENEFITS_STATUS['value'], 'Taxable Allowances') !== false ? 'checked' : '' ?> name="data[benefits][values][]" value="Taxable Allowances">
                                                <label class="form-check-label">Taxable Allowances</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_BENEFITS_STATUS['value'], 'Deductions') !== false ? 'checked' : '' ?> name="data[benefits][values][]" value="Deductions" id="other_deductions">
                                                <label class="form-check-label" for="other_deductions">Deductions</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_BENEFITS_STATUS['value'], 'Union Dues') !== false ? 'checked' : '' ?> name="data[benefits][values][]" value="Union Dues" id="union_dues">
                                                <label class="form-check-label" for="union_dues">Union Dues</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_BENEFITS_STATUS['value'], 'Cash Advances') !== false ? 'checked' : '' ?> name="data[benefits][values][]" value="Cash Advances">
                                                <label class="form-check-label">Cash Advances</label>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_BENEFITS_STATUS['value'], 'Loans Benefits') !== false ? 'checked' : '' ?> name="data[benefits][values][]" value="Loans Benefits" id="loan_benefits">
                                                <label class="form-check-label" for="loan_benefits">Loan Benefits</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_BENEFITS_STATUS['value'], 'Adjustments Benefits') !== false ? 'checked' : '' ?> name="data[benefits][values][]" value="Adjustments Benefits" id="adjustments_benefits">
                                                <label class="form-check-label" for="adjustments_benefits">Adjustment Benefits</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_BENEFITS_STATUS['value'], 'Reimbursement') !== false ? 'checked' : '' ?> name="data[benefits][values][]" value="Reimbursement">
                                                <label class="form-check-label">Reimbursement</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Payroll -->
                            <div class="check_module">
                                <input type="hidden" name="data[payroll][id]" value="<?= $DISP_PAYROLL_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_PAYROLL_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="payroll_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="payroll_tab"><strong>Payroll</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_PAYROLL_STATUS['value'], 'Payroll Generation') !== false ? 'checked' : '' ?> name="data[payroll][values][]" value="Payroll Generation" id="payroll_generations">
                                                <label class="form-check-label" for="payroll_generations">Payroll Generation</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_PAYROLL_STATUS['value'], 'Custom Contributions') !== false ? 'checked' : '' ?> name="data[payroll][values][]" value="Custom Contributions" id="custom_contributions">
                                                <label class="form-check-label" for="custom_contributions">Custom Contributions</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_PAYROLL_STATUS['value'], '13th Month Pay') !== false ? 'checked' : '' ?> name="data[payroll][values][]" value="13th Month Pay" id="13th_month_pay">
                                                <label class="form-check-label" for="13th_month_pay">13th Month Pay</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_PAYROLL_STATUS['value'], 'HDMF Contribution Table') !== false ? 'checked' : '' ?> name="data[payroll][values][]" value="HDMF Contribution Table" id="hdmf_contribution_table">
                                                <label class="form-check-label" for="hdmf_contribution_table">HDMF Contribution Table</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_PAYROLL_STATUS['value'], 'SSS Contribution Table') !== false ? 'checked' : '' ?> name="data[payroll][values][]" value="SSS Contribution Table" id="sss_contributions_table">
                                                <label class="form-check-label" for="sss_contributions_table">SSS Contribution Table</label>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_PAYROLL_STATUS['value'], 'Withholding Tax Table') !== false ? 'checked' : '' ?> name="data[payroll][values][]" value="Withholding Tax Table" id="payroll_tax">
                                                <label class="form-check-label" for="payroll_tax">Withholding Tax</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_PAYROLL_STATUS['value'], 'Payroll Schedule') !== false ? 'checked' : '' ?> name="data[payroll][values][]" value="Payroll Schedule" id="payroll_schedule">
                                                <label class="form-check-label" for="payroll_schedule">Payroll Schedule</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_PAYROLL_STATUS['value'], 'PhilHealth Contribution Table') !== false ? 'checked' : '' ?> name="data[payroll][values][]" value="PhilHealth Contribution Table" id="philhealth_contribution_trading">
                                                <label class="form-check-label" for="philhealth_contribution_trading">PhilHealth Contribution Table</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_PAYROLL_STATUS['value'], 'Government Contribution') !== false ? 'checked' : '' ?> name="data[payroll][values][]" value="Government Contribution" id="government_contribution">
                                                <label class="form-check-label" for="government_contribution">Government Contribution</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_PAYROLL_STATUS['value'], 'Manage Salary') !== false ? 'checked' : '' ?> name="data[payroll][values][]" value="Manage Salary" id="manage_salary">
                                                <label class="form-check-label" for="manage_salary">Manage Salary</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- End -->
                            <!-- Assets -->
                            <div class="check_module">
                                <input type="hidden" name="data[asset][id]" value="<?= $DISP_ASSETS_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_ASSETS_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="asset_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="asset_tab"><strong>Assets</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ASSET_STATUS['value'], 'Assets') !== false ? 'checked' : '' ?> name="data[asset][values][]" value="Assets">
                                                <label class="form-check-label">Assets</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ASSET_STATUS['value'], 'Stock Rooms') !== false ? 'checked' : '' ?> name="data[asset][values][]" value="Stock Rooms">
                                                <label class="form-check-label">Stock Rooms</label>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ASSET_STATUS['value'], 'Location') !== false ? 'checked' : '' ?> name="data[asset][values][]" value="Location">
                                                <label class="form-check-label">Location</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ASSET_STATUS['value'], 'Asset Categories') !== false ? 'checked' : '' ?> name="data[asset][values][]" value="Asset Categories">
                                                <label class="form-check-label">Asset Categories</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- end -->
                            <!-- Administrator -->
                            <div class="check_module">
                                <input type="hidden" name="data[administrators][id]" value="<?= $DISP_ADMIN_STATUS['id'] ?>">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" <?= $DISP_ADMIN_STATUS['value'] != 0 ? 'checked' : '' ?> type="checkbox" id="administrator_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="administrator_tab"><strong>Administrator</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ADMIN_STATUS['value'], 'Access Management') !== false ? 'checked' : '' ?> name="data[administrators][values][]" value="Access Management" id="access_management">
                                                <label class="form-check-label" for="access_management">Access Management</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ADMIN_STATUS['value'], 'IP Address') !== false ? 'checked' : '' ?> name="data[administrators][values][]" value="IP Address" id="ip_address">
                                                <label class="form-check-label" for="ip_address">IP Address</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ADMIN_STATUS['value'], 'User Accessibility') !== false ? 'checked' : '' ?> name="data[administrators][values][]" value="User Accessibility" id="user_accessibility">
                                                <label class="form-check-label" for="user_accessibility">User Accessibility</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ADMIN_STATUS['value'], 'User Access Logs') !== false ? 'checked' : '' ?> name="data[administrators][values][]" value="User Access Logs" id="user_access_logs">
                                                <label class="form-check-label" for="user_access_logs">User Access Logs</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ADMIN_STATUS['value'], 'General Settings') !== false ? 'checked' : '' ?> name="data[administrators][values][]" value="General Settings" id="general_settings">
                                                <label class="form-check-label" for="general_settings">General Settings</label>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ADMIN_STATUS['value'], 'Self Service Settings') !== false ? 'checked' : '' ?> name="data[administrators][values][]" value="Self Service Settings" id="selfservice_settings">
                                                <label class="form-check-label" for="selfservice_settings">Self Service Settings</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ADMIN_STATUS['value'], 'Admin-Activity Logs') !== false ? 'checked' : '' ?> name="data[administrators][values][]" value="Admin-Activity Logs" id="activity_logs">
                                                <label class="form-check-label" for="activity_logs">Activity Logs</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ADMIN_STATUS['value'], 'Admin-Request List') !== false ? 'checked' : '' ?> name="data[administrators][values][]" value="Admin-Request List" id="request_list_admin">
                                                <label class="form-check-label">Request List</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" <?= strpos($DISP_ADMIN_STATUS['value'], 'Admin-Geo Fencing Settings') !== false ? 'checked' : '' ?> name="data[administrators][values][]" value="Admin-Geo Fencing Settings">
                                                <label class="form-check-label">Geo Fencing Settings</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- End -->
                        </div>
                </div>
                <div class="container d-flex d-lg-none justify-content-end">
                    <button type="submit" class='btn btn-primary px-3 text-light' id="EDIT_BTN_SAVE"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<aside class="control-sidebar control-sidebar-dark">
</aside>
<!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
<?php $this->load->view('templates/jquery_link'); ?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_APPLY')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_APPLY'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_APPLY');
}
?>
<script>
    $(document).ready(function() {
        var url = '<?= base_url() ?>superadministrators';
        var url_add = '<?= base_url() ?>users_access/add_user_access';
        var url_update = '<?= base_url() ?>users_access/update_user_access';
        fetch(url + '/get_modules').then(response => {
            return response.json();
        }).then(res => {
            // console.log(res);
            $('input.check_data').each(function() {
                if (res[0]["user_page"].search($(this).val()) >= 0 && $(this).val() != "") {
                    $(this).prop("checked", true);
                }
            })
        }).then(() => {
            $('.select_all').each(function() {
                let check_all = false;
                let check_box = $(this).parent().siblings("div.row").children('ul').children('li').children('div').children('input');
                check_box.each(function() {
                    if ($(this).is(':checked')) {
                        check_all = true;
                    }
                })
                $(this).prop("checked", check_all);
            })
        })
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
            $("#position_name").prop("disabled", true);
            $('form').attr("action", url_update);
            let id = $(this).attr("data-id");
            $("#position_id").val(id);
            $("input[type='checkbox']").prop("checked", false);
            let user_access = $(this).parent().siblings("td.user_access").text();
            $("#position_name").val(user_access);
            fetch(url + '/get_user_access_by_id/' + id).then(response => {
                return response.json();
            }).then(res => {
                $('input.check_data').each(function() {
                    if (res[0]["user_page"].search($(this).val()) >= 0 && $(this).val() != "") {
                        $(this).prop("checked", true);
                    }
                })
            }).then(() => {
                $('.select_all').each(function() {
                    let check_all = false;
                    let check_box = $(this).parent().siblings("div.row").children('ul').children('li').children('div').children('input');
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
                let check_boxes = row_div.children('ul').children('li').children('div').children('input');
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
            if ($(this).is(':checked')) {
                $(this).parent().siblings("div.row").children('ul').children('li').children('div').children('input').prop("checked", true);
            } else {
                $(this).parent().siblings("div.row").children('ul').children('li').children('div').children('input').prop("checked", false);
            }
        })
    })
</script>
</body>
</html>