<!------------------------------------------------------ A. PAGE INFORMATION  -----------------------------------------------------

TECHNOS SYSTEM ENGINEERING INC.

EyeBox HRMS

@author     Technos Developers

@datetime   16 November 2022

@purpose    Company Contributions

CONTROLLER FILES:

MODEL FILES:

----------------------------------------------------------- A. STYLESHEETS  ----------------------------------------------------->

<?php $this->load->view('templates/css_link') ?>

<?php $this->load->view('templates/companycontribution_style'); ?>

<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

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

    <div class="p-3">

        <div class="flex-fill">

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">

                        <a href="<?= base_url() ?>nav_superadmins">Super Administrator</a>

                        </a>

                    </li>

                    <li class="breadcrumb-item active" aria-current="page">Module Activation

                    </li>

                </ol>

            </nav>

            <div class="row">

                <!-- Title Text -->

                <div class="col-md-6">

                    <h1 class="page-title">Module Activation<h1>

                </div>

                <div class="col-md-6" style="text-align: right;">

                </div>

            </div>

            <!-- Title Header Line -->

            <hr>

           

            <div class="card">

                <div class="card-body">

                <form action="<?=base_url();?>superadministrators/update_status" id="form_edit_position" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">

                    <div class="  col-md-12 items">

                        <div class="container d-flex justify-content-end">

                            <button type="submit" class='btn btn-primary px-3 text-light' id="EDIT_BTN_SAVE">&nbsp;Save</button>

                        </div>

                        <div class="check_module">

                            <input type="hidden" name="data[self_service][id]" value="<?= $DISP_STATUS['id'] ?>">

                            <div class="form-check mb-3 module_data">

                                <input class="form-check-input select_all"   name="data[self_service][values][]"   value="1" type="checkbox" id="self_service_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="self_service_tab"><strong>Self-Service</strong></label></a>

                            </div>

                            <div class="row">

                                <ul class="col-md-6 col-sm-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[self_service][values][]" value="My Profile" id="my_profile">

                                            <label class="form-check-label" for="my_profile">My Profile</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data"  type="checkbox" name="data[self_service][values][]" value="My Time Record" id="my_time_record">

                                            <label class="form-check-label" for="my_time_record">My Time Record</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data"   type="checkbox" name="data[self_service][values][]" value="My Complaints" id="my_complaints">

                                            <label class="form-check-label" for="my_complaints">My Complaints</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data"   type="checkbox" name="data[self_service][values][]" value="My Leaves" id="my_leave">

                                            <label class="form-check-label" for="my_leave">My Leaves</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[self_service][values][]" value="My Overtimes" id="my_overtime">

                                            <label class="form-check-label" for="my_overtime">My Overtime</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data"   type="checkbox" name="data[self_service][values][]" value="My Time Adjustments" id="my_time_adjustment">

                                            <label class="form-check-label" for="my_time_adjustment">My Time Adjustment</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[self_service][values][]" value="My Payslips" id="my_payslips">

                                            <label class="form-check-label" for="my_payslips">My Payslips</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data"   type="checkbox" name="data[self_service][values][]" value="My Onboarding" id="my_onboarding">

                                            <label class="form-check-label" for="my_onboarding">My Onboarding</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data"   type="checkbox" name="data[self_service][values][]" value="My Survey" id="my_survey">

                                            <label class="form-check-label" for="my_survey">My Survey</label>

                                        </div>

                                    </li>

                                </ul>

                                <ul class="col col-md-6 col-sm-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data"  type="checkbox" name="data[self_service][values][]" value="My Team" id="my_team">

                                            <label class="form-check-label" for="my_team">My Team</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data"  type="checkbox" name="data[self_service][values][]" value="My Calendar" id="my_calendar">

                                            <label class="form-check-label" for="my_calendar">My Calendar</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data"  type="checkbox" name="data[self_service][values][]" value="My Tasks" id="my_tasks">

                                            <label class="form-check-label" for="my_tasks">My Tasks</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data"  type="checkbox" name="data[self_service][values][]" value="My Time InAndOut" id="my_time_in_out">

                                            <label class="form-check-label" for="my_time_in_out">My Time In/Out</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data"   type="checkbox" name="data[self_service][values][]" value="My Support Requests" id="my_support_requests">

                                            <label class="form-check-label" for="my_support_requests">My Support Requests</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[self_service][values][]" value="My Warnings" id="my_warnings">

                                            <label class="form-check-label" for="my_warnings">My Warnings</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data"  type="checkbox" name="data[self_service][values][]" value="My Trainings" id="my_trainings">

                                            <label class="form-check-label" for="my_trainings">My Trainings</label>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <div class="check_module">

                            <div class="form-check mb-3 module_data">

                                <input type="hidden" name="data[company][id]" value="<?=$DISP_COMPANY_STATUS['id']?>">

                                <input class="form-check-input select_all"   name="data[company][values][]" value="1" type="checkbox" id="company_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="company_tab"><strong>Company</strong></label></a>

                            </div>

                            <div class="row">

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[company][values][]" value="Company About the Company" id="about_company">

                                            <label class="form-check-label" for="about_company">About the company</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data"  type="checkbox" name="data[company][values][]" value="Company Announcements" id="announcements">

                                            <label class="form-check-label" for="announcements">Announcements</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[company][values][]" value="Company Policies" id="policies">

                                            <label class="form-check-label" for="policies">Policies</label>

                                        </div>

                                    </li>

                                </ul>

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[company][values][]" value="Organizational Chart" id="org_chart">

                                            <label class="form-check-label" for="org_chart">Organizational Chart</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[company][values][]" value="Company Holidays" id="holidays">

                                            <label class="form-check-label" for="holidays">Holidays</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[company][values][]" value="Company Knowledge Base" id="knowledge_base">

                                            <label class="form-check-label" for="knowledge_base">Knowledge Base</label>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!-- Employee -->

                        <div class="check_module">

                            <div class="form-check mb-3 module_data">

                                <input type="hidden" name="data[employee][id]" value="<?=$DISP_EMPLOYEE_STATUS['id']?>">

                                <input class="form-check-input select_all"  name="data[employee][values][]" value="1" type="checkbox" id="emplyee_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="emplyee_tab"><strong>Employee</strong></label></a>

                            </div>

                            <div class="row">

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[employee][values][]" value="Employee Directory" id="employee_dir">

                                            <label class="form-check-label" for="employee_dir">Employee Directory</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[employee][values][]" value="Allowance Assignment" id="allowance_assignment">

                                            <label class="form-check-label" for="allowance_assignment">Allowance Assignment</label>

                                        </div>

                                    </li>
                                </ul>

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[employee][values][]" value="Deduction Assignment" id="deduction_assignment">

                                            <label class="form-check-label" for="deduction_assignment">Deduction Assignment</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[employee][values][]" value="Skill Assignment" id="skill_assignment">

                                            <label class="form-check-label" for="skill_assignment">Skill Assignment</label>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!-- HR Essetials -->

                        <div class="check_module">

                            <div class="form-check mb-3 module_data">

                                <input type="hidden" name="data[hr][id]" value="<?=$DISP_HR_STATUS['id']?>">

                                <input class="form-check-input select_all"  name="data[hr][values][]" value="hr_modules" type="checkbox" id="hr_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="hr_tab"><strong>HR Essetials</strong></label></a>

                            </div>

                            <div class="row">

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Announcements" id="hr_announcements">

                                            <label class="form-check-label" for="hr_announcements">Announcements</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Warnings" id="hr_warnings">

                                            <label class="form-check-label" for="hr_warnings">Warnings</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Support" id="hr_support">

                                            <label class="form-check-label" for="hr_support">Support</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Reports" id="hr_reports">

                                            <label class="form-check-label" for="hr_reports">Reports</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Policies" id="hr_policies">

                                            <label class="form-check-label" for="hr_policies">Policies</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR About the Company" id="hr_about_the_company">

                                            <label class="form-check-label" for="hr_about_the_company">About the Company</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Welcome Messages" id="hr_welcome_messages">

                                            <label class="form-check-label" for="hr_welcome_messages">Welcome Messages</label>

                                        </div>

                                    </li>

                                </ul>

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Forms" id="hr_forms">

                                            <label class="form-check-label" for="hr_forms">Forms</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Complaint" id="hr_complaint">

                                            <label class="form-check-label" for="hr_complaint">Complaint</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Starter Guide" id="hr_starter_guide">

                                            <label class="form-check-label" for="hr_starter_guide">Starter Guide</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Survey" id="hr_survey">

                                            <label class="form-check-label" for="hr_survey">Survey</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Knowledge Base" id="hr_knowledge_base">

                                            <label class="form-check-label" for="hr_knowledge_base">Knowledge Base</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[hr][values][]" value="HR Events" id="hr_events">

                                            <label class="form-check-label" for="hr_events">Events</label>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!-- END -->

                        <!-- Attendance -->

                        <div class="check_module">

                            <div class="form-check mb-3 module_data">

                                <input type="hidden" name="data[attendance][id]" value="<?=$DISP_ATTENDANCE_STATUS['id']?>">

                                <input class="form-check-input select_all"  name="data[attendance][values][]" value="attendance_modules" type="checkbox" id="attendance_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="attendance_tab"><strong>Attendance</strong></label></a>

                            </div>

                            <div class="row">

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[attendance][values][]" value="Attendance Records" id="attendance_records">

                                            <label class="form-check-label" for="attendance_records">Attendance Records</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[attendance][values][]" value="Daily Attendance" id="daily_attendance">

                                            <label class="form-check-label" for="daily_attendance">Daily Attendance</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[attendance][values][]" value="Work Shifts" id="work_shifts">

                                            <label class="form-check-label" for="work_shifts">Work Shifts</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[attendance][values][]" value="Shift Template" id="shift_template">

                                            <label class="form-check-label" for="shift_template">Shift Template</label>

                                        </div>

                                    </li>

                                </ul>

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[attendance][values][]" value="Attendance Holidays" id="attendance_holidays">

                                            <label class="form-check-label" for="attendance_holidays">Holidays</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[attendance][values][]" value="Attendance Overtime" id="att_overtime">

                                            <label class="form-check-label" for="att_overtime">Overtime</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[attendance][values][]" value="Time Adjustment List" id="time_adjustment_list">

                                            <label class="form-check-label" for="time_adjustment_lis">Time Adjustment List</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[attendance][values][]" value="Overtime Approval Route" id="overtime_approval_route">

                                            <label class="form-check-label" for="overtime_approval_route">Overtime Approval Route</label>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!-- END -->

                        <!-- Leave -->

                        <div class="check_module">

                            <div class="form-check mb-3 module_data">

                                <input type="hidden" name="data[leave][id]" value="<?=$DISP_LEAVE_STATUS['id']?>">

                                <input class="form-check-input select_all"  name="module[]" value="leave_modules" type="checkbox" id="leave_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="leave_tab"><strong>Leave</strong></label></a>

                            </div>

                            <div class="row">

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[leave][values][]" value="Leave Leaves" id="leave">

                                            <label class="form-check-label" for="leave">Leave</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[leave][values][]" value="Leave Entitlement" id="leave_entitlement">

                                            <label class="form-check-label" for="leave_entitlement">Leave Entitlements</label>

                                        </div>

                                    </li>

                                </ul>

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[leave][values][]" value="Leave Approval Route" id="leave_approval_route">

                                            <label class="form-check-label" for="leave_approval_route">Leave Approval Route</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[leave][values][]" value="Leave Types" id="leave_types">

                                            <label class="form-check-label" for="leave_types">Leave Types</label>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!-- END -->

                        <!-- Payrool -->

                    <div class="check_module">

                        <div class="form-check mb-3 module_data">

                            <input type="hidden" name="data[payroll][id]" value="<?=$DISP_PAYROLL_STATUS['id']?>">

                            <input class="form-check-input select_all"  name="data[payroll][values][]" value="payroll_modules" type="checkbox" id="payrool_tab">

                            <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="payrool_tab"><strong>Payroll</strong></label></a>

                        </div>

                        <div class="row">

                            <ul class="col-md-6">

                                <li class="list-unstyled mb-2">

                                    <div class="form-check">

                                        <input class="form-check-input check_data" type="checkbox" name="data[payroll][values][]" value="Payslip Generator" id="payslip_generator">

                                        <label class="form-check-label" for="payslip_generator">Payslip Generator</label>

                                    </div>

                                </li>

                                <li class="list-unstyled mb-2">

                                    <div class="form-check">

                                        <input class="form-check-input check_data" type="checkbox" name="data[payroll][values][]" value="Company Contributions" id="company_contributions">

                                        <label class="form-check-label" for="company_contributions">Company Contributions</label>

                                    </div>

                                </li>

                                <li class="list-unstyled mb-2">

                                    <div class="form-check">

                                        <input class="form-check-input check_data" type="checkbox" name="data[payroll][values][]" value="13th Month Pay" id="13th_month_pay">

                                        <label class="form-check-label" for="13th_month_pay">13th Month Pay</label>

                                    </div>

                                </li>

                                <li class="list-unstyled mb-2">

                                    <div class="form-check">

                                        <input class="form-check-input check_data" type="checkbox" name="data[payroll][values][]" value="Reimbursement" id="reimbursement">

                                        <label class="form-check-label" for="reimbursement">Reimbursement</label>

                                    </div>

                                </li>

                                <li class="list-unstyled mb-2">

                                    <div class="form-check">

                                        <input class="form-check-input check_data" type="checkbox" name="data[payroll][values][]" value="Loans" id="loans">

                                        <label class="form-check-label" for="loans">Loans</label>

                                    </div>

                                </li>

                            </ul>

                            <ul class="col-md-6">

                                <li class="list-unstyled mb-2">

                                    <div class="form-check">

                                        <input class="form-check-input check_data" type="checkbox" name="data[payroll][values][]" value="Payroll Schedule" id="payroll_schedule">

                                        <label class="form-check-label" for="payroll_schedule">Payroll Schedule</label>

                                    </div>

                                </li>

                                <li class="list-unstyled mb-2">

                                    <div class="form-check">

                                        <input class="form-check-input check_data" type="checkbox" name="data[payroll][values][]" value="SSS Rates" id="sss_rates">

                                        <label class="form-check-label" for="sss_rates">SSS Rates</label>

                                    </div>

                                </li>

                                <li class="list-unstyled mb-2">

                                    <div class="form-check">

                                        <input class="form-check-input check_data" type="checkbox" name="data[payroll][values][]" value="Philhealth Rates" id="philhealth_rates">

                                        <label class="form-check-label" for="philhealth_rates">Philhealth Rates</label>

                                    </div>

                                </li>

                                <li class="list-unstyled mb-2">

                                    <div class="form-check">

                                        <input class="form-check-input check_data" type="checkbox" name="data[payroll][values][]" value="HDMF Rates" id="hdmf_rates">

                                        <label class="form-check-label" for="hdmf_rates">HDMF Rates</label>

                                    </div>

                                </li>

                                <li class="list-unstyled mb-2">

                                    <div class="form-check">

                                        <input class="form-check-input check_data" type="checkbox" name="data[payroll][values][]" value="Withholding Tax" id="withholding_tax">

                                        <label class="form-check-label" for="withholding_tax">Withholding Tax</label>

                                    </div>

                                </li>

                            </ul>

                        </div>

                        </div>

                        <!-- End -->

                        <!-- Recruitment -->

                        <div class="check_module">

                            <div class="form-check mb-3 module_data">

                                <input type="hidden" name="data[recruitment][id]" value="<?=$DISP_REC_STATUS['id']?>">

                                <input class="form-check-input select_all"  name="data[recruitment][values][]" value="recruitment_modules" type="checkbox" id="recruitment_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="recruitment_tab"><strong>Recruitment</strong></label></a>

                            </div>

                            <div class="row">

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[recruitment][values][]" value="Job Posting" id="job_posting">

                                            <label class="form-check-label" for="job_posting">Job Posting</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[recruitment][values][]" value="Applicant Tracking" id="applicant_tracking">

                                            <label class="form-check-label" for="applicant_tracking">Applicant Tracking</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[recruitment][values][]" value="Examination List" id="examination_list">

                                            <label class="form-check-label" for="examination_list">Examination List</label>

                                        </div>

                                    </li>

                                </ul>

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[recruitment][values][]" value="Exam Forms" id="exam_forms">

                                            <label class="form-check-label" for="exam_forms">Exam Forms</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[recruitment][values][]" value="Recruitment Onboarding" id="recrut_onboarding">

                                            <label class="form-check-label" for="recrut_onboarding">Onboarding</label>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!-- End -->

                        <!-- Learn and Development -->

                        <div class="check_module">

                            <div class="form-check mb-3 module_data">

                                <input type="hidden" name="data[learn_and_develop][id]" value="<?=$DISP_LEARN_STATUS['id']?>">

                                <input class="form-check-input select_all"  name="data[learn_and_develop][values][]" value="learn&develop_modules" type="checkbox" id="learn_development_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="learn_development_tab"><strong>Learn and Development</strong></label></a>

                            </div>

                            <div class="row">

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[learn_and_develop][values][]" value="Learn and Development Trainings" id="lrnD_trainings">

                                            <label class="form-check-label" for="lrnD_trainings">Trainings</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[learn_and_develop][values][]" value="Training Calendar" id="training_calendar">

                                            <label class="form-check-label" for="training_calendar">Training Calendar</label>

                                        </div>

                                    </li>

                                </ul>

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[learn_and_develop][values][]" value="Learn and Development Skills" id="learn_and_development_skills">

                                            <label class="form-check-label" for="learn_and_development_skills">Skills</label>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!-- End -->

                        <!-- Performance -->

                        <div class="check_module">

                            <div class="form-check mb-3 module_data">

                                <input type="hidden" name="data[performance][id]" value="<?=$DISP_PERFORMANCE_STATUS['id']?>">

                                <input class="form-check-input select_all"  name="data[performance][values][]" value="performance_modules" type="checkbox" id="performance_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="performance_tab"><strong>Performance</strong></label></a>

                            </div>

                            <div class="row">

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[performance][values][]" value="Promotions" id="promotions">

                                            <label class="form-check-label" for="promotions">Promotions</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[performance][values][]" value="Apprasals" id="apprasals">

                                            <label class="form-check-label" for="apprasals">Apprasals</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[performance][values][]" value="KPIs" id="kpis">

                                            <label class="form-check-label" for="kpis">KPIs</label>

                                        </div>

                                    </li>

                                </ul>

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[performance][values][]" value="Goals" id="goals">

                                            <label class="form-check-label" for="goals">Goals</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[performance][values][]" value="Review Templates" id="review_templates">

                                            <label class="form-check-label" for="review_templates">Review Templates</label>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!-- End -->

                        <!-- Rewards -->

                        <div class="check_module">

                            <div class="form-check mb-3 module_data">

                                <input type="hidden" name="data[rewards][id]" value="<?=$DISP_REWARDS_STATUS['id']?>">

                                <input class="form-check-input select_all"  name="data[rewards][values][]" value="rewards_modules" type="checkbox" id="rewards_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="rewards_tab"><strong>Rewards</strong></label></a>

                            </div>

                            <div class="row">

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[rewards][values][]" value="Service Awards" id="service_awards">

                                            <label class="form-check-label" for="service_awards">Service Awards</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[rewards][values][]" value="Awards List" id="awards_list">

                                            <label class="form-check-label" for="awards_list">Awards List</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[rewards][values][]" value="Certificate Templates" id="certificate_templates">

                                            <label class="form-check-label" for="certificate_templates">Certificate Templates</label>

                                        </div>

                                    </li>

                                </ul>

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[rewards][values][]" value="Award Types" id="award_types">

                                            <label class="form-check-label" for="award_types">Award Types</label>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!-- End -->

                        <!-- Exit Management -->

                        <div class="check_module">

                            <div class="form-check mb-3 module_data">

                                <input type="hidden" name="data[exist_management][id]" value="<?=$DISP_EXIT_STATUS['id']?>">

                                <input class="form-check-input select_all"  name="data[exist_management][values][]" value="exist_management_modules" type="checkbox" id="exit_management_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="exit_management_tab"><strong>Exit Management</strong></label></a>

                            </div>

                            <div class="row">

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[exist_management][values][]" value="Resignation" id="resignation">

                                            <label class="form-check-label" for="resignation">Resignation</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[exist_management][values][]" value="Offboarding" id="offboarding">

                                            <label class="form-check-label" for="offboardings">Offboarding</label>

                                        </div>

                                    </li>                       

                                </ul>

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[exist_management][values][]" value="Clearance" id="clearance">

                                            <label class="form-check-label" for="clearance">Clearance</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[exist_management][values][]" value="Exit Interview" id="exit_interview">

                                            <label class="form-check-label" for="exit_interview">Exit Interview</label>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!-- End -->

                        <!-- Assets -->

                        <div class="check_module">

                            <div class="form-check mb-3 module_data">

                                <input type="hidden" name="data[assets][id]" value="<?=$DISP_ASSET_STATUS['id']?>">

                                <input class="form-check-input select_all"  name="data[assets][values][]" value="asset_modules" type="checkbox" id="assets_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="assets_tab"><strong>Assets</strong></label></a>

                            </div>

                            <div class="row">

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[assets][values][]" value="Assets" id="assets">

                                            <label class="form-check-label" for="assets">Assets</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[assets][values][]" value="Stock Rooms" id="stock_rooms">

                                            <label class="form-check-label" for="stock_rooms">Stock Rooms</label>

                                        </div>

                                    </li>                       

                                </ul>

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[assets][values][]" value="Location" id="location">

                                            <label class="form-check-label" for="location">Location</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[assets][values][]" value="Asset Categories" id="asset_categories">

                                            <label class="form-check-label" for="asset_categories">Asset Categories</label>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!-- End -->

                        <!-- Project Management -->

                    <div class="check_module">

                        <div class="form-check mb-3 module_data">

                                <input type="hidden" name="data[project_management][id]" value="<?=$DISP_PROJ_STATUS['id']?>">

                                <input class="form-check-input select_all"  name="data[project_management][values][]" value="project_management_modules" type="checkbox" id="project_management_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="project_management_tab"><strong>Project Management</strong></label></a>

                        </div>

                        <div class="row">

                            <ul class="col-md-6">

                                <li class="list-unstyled mb-2">

                                    <div class="form-check">

                                        <input class="form-check-input check_data" type="checkbox" name="data[project_management][values][]" value="Task Management" id="task_management">

                                        <label class="form-check-label" for="task_management">Task Management</label>

                                    </div>

                                </li>

                                <li class="list-unstyled mb-2">

                                    <div class="form-check">

                                        <input class="form-check-input check_data" type="checkbox" name="data[project_management][values][]" value="Kanban Board" id="kanban_board">

                                        <label class="form-check-label" for="kanban_board">Kanban Board</label>

                                    </div>

                                </li>                       

                            </ul>

                            <ul class="col-md-6">

                                <li class="list-unstyled mb-2">

                                    <div class="form-check">

                                        <input class="form-check-input check_data" type="checkbox" name="data[project_management][values][]" value="Project Management Schedule" id="prmgt_schedule">

                                        <label class="form-check-label" for="prmgt_schedule">Schedule</label>

                                    </div>

                                </li>

                            </ul>

                        </div>

                    </div>

                        <!-- END -->

                        <!-- Administrator -->

                        <div class="check_module">

                            <div class="form-check mb-3 module_data">

                                <input type="hidden" name="data[admin][id]" value="<?=$DISP_ADMIN_STATUS['id']?>">

                                <input class="form-check-input select_all" name="data[admin][values][]" value="administrator_modules"  type="checkbox" id="administrator_tab">

                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="administrator_tab"><strong>Administrator</strong></label></a>

                            </div>

                            <div class="row">

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[admin][values][]" value="Access Management" id="access_management">

                                            <label class="form-check-label" for="access_management">Access Management</label>

                                        </div>

                                    </li>

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[admin][values][]" value="Home Settings" id="home_settings">

                                            <label class="form-check-label" for="home_settings">Home Settings</label>

                                        </div>

                                    </li>                       

                                </ul>

                                <ul class="col-md-6">

                                    <li class="list-unstyled mb-2">

                                        <div class="form-check">

                                            <input class="form-check-input check_data" type="checkbox" name="data[admin][values][]" value="User Accessibility" id="user_accessibility">

                                            <label class="form-check-label" for="user_accessibility">User Accessibility</label>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!-- End -->

                    </div>

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

if ($this->session->userdata('SESS_SUCC_MSG_ADD_PAYROLL')) {

?>

    <script>

        Swal.fire(

            '<?php echo $this->session->userdata('SESS_SUCC_MSG_ADD_PAYROLL'); ?>',

            '',

            'success'

        )

    </script>

<?php

    $this->session->unset_userdata('SESS_SUCC_MSG_ADD_PAYROLL');

}

?>



<script>

    $(document).ready(function() {

        var url = '<?= base_url() ?>superadministrators';

        var url_add='<?= base_url() ?>users_access/add_user_access';

        var url_update='<?= base_url() ?>users_access/update_user_access';

        fetch(url + '/get_modules').then(response => {

                return response.json();

            }).then(res => {

                console.log(res);

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

        $("#btn_add").on("click",function(){

            $("#position_name").val("");

            $("input[type='checkbox']").prop("checked", false);

            $("#ModalLabel").text("Add new user access");

            $("position_name").val("");

            $("#position_name").prop("disabled",false);

            $('form').attr("action",url_add);

        })

        $(".btn_edit").on("click", function() {

            $("#ModalLabel").text("Edit user access");

            $("#position_name").prop("disabled",true);

            $('form').attr("action",url_update);

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

        $('input.check_data').on("click",function(){

            let select_all_input=$(this).parentsUntil($(".check_module")).siblings(".module_data").children("input.select_all");

            if ($(this).is(':checked')) {

                $(this).parentsUntil(select_all_input.prop("checked",true));

            }else{

                let row_div=$(this).parentsUntil($(".check_module"));

                let check_boxes=row_div.children('ul').children('li').children('div').children('input');

                let check = false;

                check_boxes.each(function() {

                    if ($(this).is(':checked')) {

                        check = true;

                    }

                })

                row_div.siblings(".module_data").children("input.select_all").prop("checked",check);

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