<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/companycontribution_style'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>administrators">Administrator</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">User Accessibility
                </li>
            </ol>
        </nav>
        <div class="row mb-2">
            <div class="col-md-6 p-2">
                <h1 class="page-title">User Accessibility List </h1>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <button type="button" id="btn_add" class="btn btn-primary" data-toggle="modal" data-target="#modal_form">Add user access</button>
            </div>
        </div>
        <!-- Title Header Line -->
        <hr>
        <div class="col-12">
            <div class="card p-0">
                <table class="m-0 table table-hover" id="positions_tbl">
                    <thead>
                        <tr>
                            <th>Access ID</th>
                            <th>Position Title</th>
                            <th>User Access</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($USER_ACCESS as $user) { ?>
                            <tr>
                                <td>ACCESS<?= str_pad($user['id'], 3, '0', STR_PAD_LEFT) ?></td>
                                <td class="user_access"><?= $user["user_access"] ?></td>
                                <td><?= $user["user_page"] ?></td>
                                <td>
                                    <a class="btn btn-sm btn_edit indigo lighten-2 edit_position" data-id="<?= $user["id"] ?>" title="Edit" data-toggle="modal" data-target="#modal_form">
                                        <i class="fas fa-edit" id="edit"></i>
                                    </a></i>
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
                <h4 class="modal-title ml-1" id="ModalLabel">Edit Positionsssssssssssssssssssssss</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url().'administrators/update_user_access'; ?>" id="form_edit_position" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
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
<?php if($MODULES['Self-Service']!='0') {?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="selfservices_modules" type="checkbox" id="self_service_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="self_service_tab"><strong>Self-Service</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6 col-sm-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Profile" id="my_profile">
                                            <label class="form-check-label" for="my_profile">My Profile</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Attendance Record" id="my_time_in/out_record">
                                            <label class="form-check-label" for="my_time_in/out_record">My Attendance Record</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Complaints" id="my_complaints">
                                            <label class="form-check-label" for="my_complaints">My Complaints</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Leaves" id="my_leave">
                                            <label class="form-check-label" for="my_leave">My Leaves</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Overtimes" id="my_overtime">
                                            <label class="form-check-label" for="my_overtime">My Overtime</label>
                                        </div>
                                    </li>

                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Time Adjustments" id="my_time_adjustment">
                                            <label class="form-check-label" for="my_time_adjustment">My Time Adjustment</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Payslips" id="my_payslips">
                                            <label class="form-check-label" for="my_payslips">My Payslips</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Onboarding" id="my_onboarding">
                                            <label class="form-check-label" for="my_onboarding">My Onboarding</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Survey" id="my_survey">
                                            <label class="form-check-label" for="my_survey">My Survey</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Overtime Approval" id="overtime_approval">
                                            <label class="form-check-label" for="overtime_approval">Overtime Approval</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Time Adjustment Approval" id="time_adjustment_approval">
                                            <label class="form-check-label" for="time_adjustment_approval">Time Adjustment Approval</label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="col col-md-6 col-sm-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Team" id="my_team">
                                            <label class="form-check-label" for="my_team">My Team</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Calendar" id="my_calendar">
                                            <label class="form-check-label" for="my_calendar">My Calendar</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Tasks" id="my_tasks">
                                            <label class="form-check-label" for="my_tasks">My Tasks</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Remote Attendance" id="my_time_in_out">
                                            <label class="form-check-label" for="my_time_in_out">Remote Attendance</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Support Requests" id="my_support_requests">
                                            <label class="form-check-label" for="my_support_requests">My Support Requests</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Warnings" id="my_warnings">
                                            <label class="form-check-label" for="my_warnings">My Warnings</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Trainings" id="my_trainings">
                                            <label class="form-check-label" for="my_trainings">My Trainings</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Activity Logs" id="activity_logs">
                                            <label class="form-check-label" for="activity_logs">Activity Logs</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Notifications" id="notification">
                                            <label class="form-check-label" for="notification">Notifications</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Leave Approval" id="leave_approval">
                                            <label class="form-check-label" for="leave_approval">Leave Approval</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Holiday Work" id="my_holiday_work">
                                            <label class="form-check-label" for="my_holiday_work">My Holiday Work</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Holiday Work Approval" id="holiday_work_approval">
                                            <label class="form-check-label" for="holiday_work_approval">Holiday Work Approval</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
<?php } ?>
<?php if($MODULES['company']!='0') { ?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="company_modules" type="checkbox" id="company_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="company_tab"><strong>Company</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Company-About the Company" id="about_company">
                                            <label class="form-check-label" for="about_company">About the company</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Company Announcements" id="announcements">
                                            <label class="form-check-label" for="announcements">Announcements</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Company Policies" id="policies">
                                            <label class="form-check-label" for="policies">Policies</label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Organizational Chart" id="org_chart">
                                            <label class="form-check-label" for="org_chart">Organizational Chart</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Company Holidays" id="holidays">
                                            <label class="form-check-label" for="holidays">Holidays</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Company Knowledge Base" id="knowledge_base">
                                            <label class="form-check-label" for="knowledge_base">Knowledge Base</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
<?php } ?>
                        <!-- Employee -->
<?php if($MODULES['employee']!='0'){ ?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="employee_modules" type="checkbox" id="emplyee_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="emplyee_tab"><strong>Employee</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Employee Directory" id="employee_dir">
                                            <label class="form-check-label" for="employee_dir">Employee Directory</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Allowance Assignment" id="allowance_assignment">
                                            <label class="form-check-label" for="allowance_assignment">Allowance Assignment</label>
                                        </div>
                                    </li>

                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Taxable Allowance" id="taxable_allowance">
                                            <label class="form-check-label" for="taxable_allowance">Taxable Allowance</label>
                                        </div>
                                    </li>

                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Taxable Deduction" id="taxable_deduction">
                                            <label class="form-check-label" for="taxable_deduction">Taxable Deduction</label>
                                        </div>
                                    </li>
                                    
                                    
                                    <!-- <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Allowances" id="allowances">
                                            <label class="form-check-label" for="allowances">Allowances</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Deductions" id="deductions">
                                            <label class="form-check-label" for="deductions">Deductions</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Skill Name" id="skill_names">
                                            <label class="form-check-label" for="skill_names">Skill Name</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HMO" id="hmo">
                                            <label class="form-check-label" for="hmo">HMO</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Departments" id="departments">
                                            <label class="form-check-label" for="departments">Departments</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Sections" id="sections">
                                            <label class="form-check-label" for="sections">Sections</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Groups" id="groups">
                                            <label class="form-check-label" for="groups">Groups</label>
                                        </div>
                                    </li> -->
                                </ul>
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Deduction Assignment" id="deduction_assignment">
                                                <label class="form-check-label" for="deduction_assignment">Deduction Assignment</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Skill Assignment" id="skill_assignment">
                                                <label class="form-check-label" for="skill_assignment">Skill Assignment</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Non-Taxable Allowance" id="non_taxable_allowance">
                                                <label class="form-check-label" for="non_taxable_allowance">Non-Taxable Allowance</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Non-Taxable Deduction" id="non_taxable_deduction">
                                                <label class="form-check-label" for="non_taxable_deduction">Non-Taxable Deduction</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Salary Details" id="salary_details">
                                                <label class="form-check-label" for="salary_details">Salary Details</label>
                                            </div>
                                        </li>
                                    <!-- <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Positions" id="positions">
                                            <label class="form-check-label" for="positions">Positions</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Employment Types" id="employee_types">
                                            <label class="form-check-label" for="employee_types">Employment Types</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Line" id="line">
                                            <label class="form-check-label" for="line">Line</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Skill Level" id="skill_levels">
                                            <label class="form-check-label" for="skill_levels">Skill Level</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Gender" id="gender">
                                            <label class="form-check-label" for="skill_level">Gender</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Nationality" id="nationality">
                                            <label class="form-check-label" for="nationality">Nationality</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Shirt Size" id="shirt_size">
                                            <label class="form-check-label" for="shirt_size">Shirt Size</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Marital Status" id="marital_status">
                                            <label class="form-check-label" for="marital_status">Marital Status</label>
                                        </div>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
<?php } ?>
                        <!-- HR Essetials -->
<?php if($MODULES['hr']!='0') { ?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="hr_modules" type="checkbox" id="hr_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="hr_tab"><strong>HR Essetials</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR Dashboard" id="hr_dashboard">
                                            <label class="form-check-label" for="hr_dashboard">HR Dashboard</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR Announcements" id="hr_announcements">
                                            <label class="form-check-label" for="hr_announcements">Announcements</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR Warnings" id="hr_warnings">
                                            <label class="form-check-label" for="hr_warnings">Warnings</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR Support" id="hr_support">
                                            <label class="form-check-label" for="hr_support">Support</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR Reports" id="hr_reports">
                                            <label class="form-check-label" for="hr_reports">Reports</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR Policies" id="hr_policies">
                                            <label class="form-check-label" for="hr_policies">Policies</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR About the Company" id="hr_about_the_company">
                                            <label class="form-check-label" for="hr_about_the_company">About the Company</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR Welcome Messages" id="hr_welcome_messages">
                                            <label class="form-check-label" for="hr_welcome_messages">Welcome Messages</label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR Forms" id="hr_forms">
                                            <label class="form-check-label" for="hr_forms">Forms</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR Complaint" id="hr_complaint">
                                            <label class="form-check-label" for="hr_complaint">Complaint</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR Starter Guide" id="hr_starter_guide">
                                            <label class="form-check-label" for="hr_starter_guide">Starter Guide</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR Survey" id="hr_survey">
                                            <label class="form-check-label" for="hr_survey">Survey</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR Knowledge Base" id="hr_knowledge_base">
                                            <label class="form-check-label" for="hr_knowledge_base">Knowledge Base</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HR Events" id="hr_events">
                                            <label class="form-check-label" for="hr_events">Events</label>
                                        </div>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
<?php } ?>
                        <!-- END -->
                        <!-- Attendance -->
<?php if($MODULES['attendance']!='0') { ?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="attendance_modules" type="checkbox" id="attendance_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="attendance_tab"><strong>Attendance</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Attendance Records" id="attendance_records">
                                            <label class="form-check-label" for="attendance_records">Attendance Records</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Daily Attendance" id="daily_attendance">
                                            <label class="form-check-label" for="daily_attendance">Daily Attendance</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Work Shifts" id="work_shifts">
                                            <label class="form-check-label" for="work_shifts">Work Shifts</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Shift Template" id="shift_template">
                                            <label class="form-check-label" for="shift_template">Shift Template</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Shift Assignment" id="shift_assignment">
                                            <label class="form-check-label" for="shift_assignment">Shift Assignment</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Zkteco Code" id="zkteco_code">
                                            <label class="form-check-label" for="zkteco_code">Zkteco Code</label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Attendance Holidays" id="attendance_holidays">
                                            <label class="form-check-label" for="attendance_holidays">Holidays</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Overtime Requests" id="overtime">
                                            <label class="form-check-label" for="overtime">Overtime</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Time Adjustment List" id="time_adjustment_list">
                                            <label class="form-check-label" for="time_adjustment_lis">Time Adjustment List</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Overtime Approval Route" id="overtime_approval_route">
                                            <label class="form-check-label" for="hr_complaint">Overtime Approval Route</label>
                                        </div>
                                    </li>

                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Zkteco Attendance" id="zkteco_attendance">
                                            <label class="form-check-label" for="zkteco_attendance">Zkteco Attendance</label>
                                        </div>
                                    </li>

                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Holiday Work" id="holiday_work">
                                            <label class="form-check-label" for="holiday_work">Holiday Work</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
<?php } ?>
                        <!-- END -->
                        <!-- Leave -->
<?php if($MODULES['leave']!='0') { ?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="leave_modules" type="checkbox" id="leave_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="leave_tab"><strong>Leave</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Leave Request" id="leave_request">
                                            <label class="form-check-label" for="leave">Leave Request</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Leave Entitlement" id="leave_entitlement">
                                            <label class="form-check-label" for="leave_entitlement">Leave Entitlements</label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Leave Approval Route" id="leave_approval_route">
                                            <label class="form-check-label" for="leave_approval_route">Leave Approval Route</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Leave Types" id="leave_types">
                                            <label class="form-check-label" for="leave_types">Leave Types</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
<?php } ?>
                        <!-- END -->
                        <!-- Payrool -->
<?php if($MODULES['payroll']!='0') { ?>
                    <div class="check_module">
                        <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="payroll_modules" type="checkbox" id="payroll_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="payroll_tab"><strong>Payroll</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Payslip Generator" id="payslip_generator">
                                            <label class="form-check-label" for="payslip_generator">Payslip Generator</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Company Contributions" id="company_contributions">
                                            <label class="form-check-label" for="company_contributions">Company Contributions</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Deductions" id="payroll_deduction">
                                            <label class="form-check-label" for="payroll_deduction">Deductions</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Other Deductions" id="other_deductions">
                                            <label class="form-check-label" for="cash_advance">Other Deductions</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Cash Advance" id="cash_advance">
                                            <label class="form-check-label" for="cash_advance">Cash Advance</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="13th Month Pay" id="13th_month_pay">
                                            <label class="form-check-label" for="13th_month_pay">13th Month Pay</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Reimbursement" id="reimbursement">
                                            <label class="form-check-label" for="reimbursement">Reimbursement</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Loans" id="loans">
                                            <label class="form-check-label" for="loans">Loans</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Custom Contributions" id="Custom_contributions">
                                            <label class="form-check-label" for="Custom_contributions">Custom Contributions</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Withholding Tax" id="withholding_tax">
                                            <label class="form-check-label" for="withholding_tax">Withholding Tax</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Payroll Payslips" id="payroll_payslips">
                                            <label class="form-check-label" for="payroll_payslips">Payroll Payslips</label>
                                        </div>
                                    </li>
                                </ul>

                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Payroll Schedule" id="payroll_schedule">
                                            <label class="form-check-label" for="payroll_schedule">Payroll Schedule</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="SSS Rates" id="sss_rates">
                                            <label class="form-check-label" for="sss_rates">SSS Rates</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Philhealth Rates" id="philhealth_rates">
                                            <label class="form-check-label" for="philhealth_rates">Philhealth Rates</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="HDMF Rates" id="hdmf_rates">
                                            <label class="form-check-label" for="hdmf_rates">HDMF Rates</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Custom SSS Contribution" id="custom_sss_contribution">
                                            <label class="form-check-label" for="custom_sss_contribution">Custom SSS Contribution</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Custom Pagibig Contibution" id="custom_pagibig_contibution">
                                            <label class="form-check-label" for="custom_pagibig_contibution">Custom Pagibig Contibution</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Custom Philhealth Contribution" id="custom_philhealth_contribution">
                                            <label class="form-check-label" for="custom_philhealth_contribution">Custom Philhealth Contribution</label>
                                        </div>
                                    </li>

                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Attendance Records Lock" id="attendance_records_lock">
                                            <label class="form-check-label" for="attendance_records_lock">Attendance Records Lock</label>
                                        </div>
                                    </li>

                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Payroll Assignment" id="payroll_assignment">
                                            <label class="form-check-label" for="payroll_assignment">Payroll Assignment</label>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
<?php } ?>
                        <!-- End -->
                        <!-- Recruitment -->
<?php if($MODULES['recruitment']!='0') { ?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="recruitment_modules" type="checkbox" id="recruitment_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="recruitment_tab"><strong>Recruitment</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Job Posting" id="job_posting">
                                            <label class="form-check-label" for="job_posting">Job Posting</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Applicant Tracking" id="applicant_tracking">
                                            <label class="form-check-label" for="applicant_tracking">Applicant Tracking</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Examination List" id="examination_list">
                                            <label class="form-check-label" for="examination_list">Examination List</label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Exam Forms" id="exam_forms">
                                            <label class="form-check-label" for="exam_forms">Exam Forms</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Recruitment Onboarding" id="onboarding">
                                            <label class="form-check-label" for="onboarding">Onboarding</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
<?php } ?>
                        <!-- End -->
                        <!-- Learn and Development -->
<?php if($MODULES['learn&develop']!='0') { ?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="learn&develop_modules" type="checkbox" id="learn_development_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="learn_development_tab"><strong>Learn and Development</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="learn&develop_Trainings" id="learn&develop_trainings">
                                            <label class="form-check-label" for="learn&develop_trainings">Trainings</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Training Calendar" id="training_calendar">
                                            <label class="form-check-label" for="training_calendar">Training Calendar</label>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Learn and Development Skills" id="learn_and_development_skills">
                                            <label class="form-check-label" for="learn_and_development_skills">Skills</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
<?php } ?>
                        <!-- End -->
                        <!-- Performance -->
<?php if($MODULES['performance']!='0'){ ?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="performance_modules" type="checkbox" id="performance_tab">
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
<?php } ?>
                        <!-- End -->
                        <!-- Rewards -->
<?php if($MODULES['rewards']!='0') { ?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="rewards_modules" type="checkbox" id="rewards_tab">
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
<?php } ?>
                        <!-- End -->
                        <!-- Exit Management -->
<?php if($MODULES['exitManagement']!='0') { ?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="exist_management_modules" type="checkbox" id="exit_management_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="exit_management_tab"><strong>Exit Management</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Resignation" id="resignation">
                                            <label class="form-check-label" for="resignation">Resignation</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Offboarding" id="offboarding">
                                            <label class="form-check-label" for="offboardings">Offboarding</label>
                                        </div>
                                    </li>                       
                                </ul>
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Clearance" id="clearance">
                                            <label class="form-check-label" for="clearance">Clearance</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Exit Interview" id="exit_interview">
                                            <label class="form-check-label" for="exit_interview">Exit Interview</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
<?php } ?>
                        <!-- End -->
                        <!-- Assets -->
<?php if($MODULES['asset']!='0') { ?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="asset_modules" type="checkbox" id="assets_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="assets_tab"><strong>Assets</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Assets" id="assets">
                                            <label class="form-check-label" for="assets">Assets</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Stock Rooms" id="stock_rooms">
                                            <label class="form-check-label" for="stock_rooms">Stock Rooms</label>
                                        </div>
                                    </li>                       
                                </ul>
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Location" id="location">
                                            <label class="form-check-label" for="location">Location</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Asset Categories" id="asset_categories">
                                            <label class="form-check-label" for="asset_categories">Asset Categories</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
<?php } ?>
                        <!-- End -->
                        <!-- Project Management -->
<?php if($MODULES['projectManagement']!='0') { ?>
                    <div class="check_module">
                        <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all"  name="module[]" value="project_management_modules" type="checkbox" id="project_management_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="project_management_tab"><strong>Project Management</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Task Management" id="task_management">
                                            <label class="form-check-label" for="task_management">Task Management</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Kanban Board" id="kanban_board">
                                            <label class="form-check-label" for="kanban_board">Kanban Board</label>
                                        </div>
                                    </li>                       
                                </ul>
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Schedule" id="schedule">
                                            <label class="form-check-label" for="schedule">Schedule</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Projects" id="projects">
                                            <label class="form-check-label" for="project">Projects</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
<?php } ?>
                        <!-- END -->


                                                <!-- messaging -->
<!--<?php if($MODULES['messaging']){ ?>-->
<!--                        <div class="check_module">-->
<!--                            <div class="form-check mb-3 module_data">-->
<!--                                <input class="form-check-input select_all" name="module[]" value="messaging_modules"  type="checkbox" id="messaging_tab">-->
<!--                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="messaging_tab"><strong>Messaging</strong></label></a>-->
<!--                            </div>-->
<!--                            <div class="row">-->
<!--                                <ul class="col-md-6">-->
<!--                                    <li class="list-unstyled mb-2">-->
<!--                                        <div class="form-check">-->
<!--                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="SMS Message" id="sms_message">-->
<!--                                            <label class="form-check-label" for="sms_message">SMS Message</label>-->
<!--                                        </div>-->
<!--                                    </li>-->

                                           
<!--                                </ul>-->
<!--                                <ul class="col-md-6">-->
             
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </div>-->
<!--<?php } ?>-->




                        <!-- Administrator -->
<?php if($MODULES['administrator']){ ?>
                        <div class="check_module">
                            <div class="form-check mb-3 module_data">
                                <input class="form-check-input select_all" name="module[]" value="administrator_modules"  type="checkbox" id="administrator_tab">
                                <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="administrator_tab"><strong>Administrator</strong></label></a>
                            </div>
                            <div class="row">
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Access Management" id="access_management">
                                            <label class="form-check-label" for="access_management">Access Management</label>
                                        </div>
                                    </li>

                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Home Settings" id="home_settings">
                                            <label class="form-check-label" for="home_settings">Home Settings</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Activity Logs(Admin)" id="activity_logs_admin">
                                            <label class="form-check-label" for="activity_logs_admin">Activity Logs</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="General Settings" id="general_settings">
                                            <label class="form-check-label" for="general_settings">General Settings</label>
                                        </div>
                                    </li>                       
                                </ul>
                                <ul class="col-md-6">
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="User Accessibility" id="user_accessibility">
                                            <label class="form-check-label" for="user_accessibility">User Accessibility</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Standard Settings" id="standard_settings">
                                            <label class="form-check-label" for="standard_settings">Standard Settings</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="Company Structure" id="company_structure_settings">
                                            <label class="form-check-label" for="company_structure_settings">Company Structure Settings</label>
                                        </div>
                                    </li>
                                    <li class="list-unstyled mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input check_data" type="checkbox" name="data[]" value="IP Address" id="ip_address">
                                            <label class="form-check-label" for="ip_address">Ip Address</label>
                                        </div>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
<?php } ?>
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

<?php
if ($this->session->userdata('SESS_SUCC_MSG')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('SESS_SUCC_MSG'); ?>'
      })
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG');
}
?>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    $(document).ready(function() {
        var url = '<?= base_url() ?>administrators';
        var url_add='<?= base_url() ?>administrators/add_user_access';
        var url_update='<?= base_url() ?>administrators/update_user_access';
        
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
            $("#position_name").prop("disabled",false);
            $('form').attr("action",url_update);
            let id = $(this).attr("data-id");
            $("#position_id").val(id);
            $("input[type='checkbox']").prop("checked", false);
            let user_access = $(this).parent().siblings("td.user_access").text();
            $("#position_name").val(user_access);
            fetch(url + '/get_user_access_by_id/' + id).then(response => {
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