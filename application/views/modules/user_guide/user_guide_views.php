<html>

<?php $this->load->view('templates/css_link'); ?>

<style>
    .text-wrapper {

        white-space: normal;
        /* or break-spaces for better word wrap */

    }

    .text-wrapper {

        overflow: hidden;

        text-overflow: ellipsis;

    }
</style>

<div class="content-wrapper">

    <div class="container-fluid p-4">
        <?php if ($general_guide) : ?>
            <div class="row">
                <div class="col-md-6">
                    <h1 class="page-title">Guide for General Users </h1>
                </div>
            </div>
            <hr class="mt-1">

            <div class="row gy-5">
                <?php if ($login_guide) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/u-q1HL8ksJ4" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Login Account and Forgot Password</p>
                        <p>Login</p>
                    </div>
                <?php endif; ?>

                <?php if ($change_pass) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/OIbb6KcMLyE" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Change Password</p>
                        <p>Self-Service Module > My Profile</p>
                    </div>
                <?php endif; ?>

                <?php if ($userguide_ot_req) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/0rQWoeSGp1M" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Overtime Filing/Request</p>
                        <p>Self-Service Module > My Overtime</p>
                    </div>
                <?php endif; ?>

                <?php if ($userguide_leave_req) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/cPA8HMmebdw" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Leave Filing/Request</p>
                        <p>Self-Service Module > My Leaves</p>
                    </div>
                <?php endif; ?>

                <?php if ($userguide_holiday_req) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/cLVZwoGtHik" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Holiday Work Filing/Request</p>
                        <p>Self-Service Module > My Holiday Work Request</p>
                    </div>
                <?php endif; ?>

                <?php if ($userguide_time_adj) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/rQDa0fpO1fY" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Time Adjustment Filing/Request</p>
                        <p>Self-Service Module > My Time Adjustment</p>
                    </div>
                <?php endif; ?>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/general_users/APPLY_HOLIDAY_WORKS.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Holiday Wrok Filing/Request</p>
                    <p>Self-Service Module > My Holiday Work</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/general_users/Clock_inClock_out.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Clocking In/Out Using Remote Attendance</p>
                    <p>Self-Service Module > My Remote Attendance</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/general_users/Complaint.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Filing Complaint</p>
                    <p>Self-Service Module > My Complaints</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/general_users/Offset.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Filing Offset</p>
                    <p>Self-Service Module > My Offsets</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/general_users/Reimbursement.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Request Reimbursement</p>
                    <p>Self-Service Module > My Reimburments</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/general_users/Support_Request.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Requesting Support</p>
                    <p>Self-Service Module > My Support Requests</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/general_users/Task.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Viewing And Adding Task</p>
                    <p>Self-Service Module > My Tasks</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/general_users/Warnings.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">View/Add Warning</p>
                    <p>Self-Service Module > My Warnings</p>
                </div>

            </div>
        <?php endif ?>

        <?php if ($hr_guide) : ?>
            <div class="row">
                <div class="col-md-6">
                    <h1 class="page-title">Guide for HR Staff </h1>
                </div>
            </div>
            <hr class="mt-1">

            <div class="row gy-5">
                <!-- <?php if ($userguide_add_edit) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/aFpkCPvwIq0" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Add/Edit Employee Records</p>
                        <p>Employee Module > Directory</p>
                    </div>
                <?php endif ?> -->

                <!-- <?php if ($userguide_hr_active_inactive) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/1gxLS_m4wvY" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Set Active/Inactive Employee</p>
                        <p>Employee Module > Directory</p>
                    </div>
                <?php endif ?> -->
                <!-- <?php if ($userguide_add_edit_workshift) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/Z1ElyhB2utg" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Add/Edit Work Shifts</p>
                        <p>Timekeeping Module > Work Shifts</p>
                    </div>
                <?php endif ?> -->

                <?php if ($userguide_shift_assign) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/eWoJqrm54I0" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Shift Assignment</p>
                        <p>Timekeeping Module > Shift Assignment</p>
                    </div>
                <?php endif ?>

                <?php if ($userguide_leave_approval) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/RR9X0Eg113U" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Set Leave Approval - Route</p>
                        <p>Leave Module > Approval Route</p>
                    </div>
                <?php endif ?>

                <!-- <?php if ($userguide_ot_approval) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/V0Q0wJDR_dU" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Set Overtime Approval - Route</p>
                        <p>Timekeeping Module > Approval Route</p>
                    </div>
                <?php endif ?> -->

                <?php if ($userguide_benefits) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/mpOwuNsaCjQ" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper"> Set Up Dynamic Benefits</p>
                        <p>Benefits >Dynamic Benefits</p>
                    </div>
                <?php endif ?>
                <!-- <?php if ($userguide_announcement) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/XnEh2CBN9To" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper"> Add Announcement</p>
                        <p>Hr Essentials > Announcement</p>
                    </div>
                <?php endif ?> -->
                <!-- <?php if ($userguide_edit_company) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/0fjnjO33e_k" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper"> Edit The About The Company</p>
                        <p>Hr Essentials >About The Company</p>
                    </div>
                <?php endif ?> -->
                <?php if ($userguide_add_policy) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/MBvSuHSzQLk" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper"> Add Policy</p>
                        <p>Hr Essentials >Policies</p>
                    </div>
                <?php endif ?>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/activate_inactivate_employee.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Set Active/Inactive Employee</p>
                    <p>Hr Essentials >Set Active/Inactive Employee</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/Add_and_Edit_Employee.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Add/Edit Employee Records</p>
                    <p>Employee Modules > Employee Directory</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/Announcement.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Add Announcement</p>
                    <p>Hr Essentials > Announcements</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/Workshifts.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Add/Edit Workshifts</p>
                    <p>Time & Attendance Modules > Workshifts</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/APPROVAL_ROUTE.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Setting Approval Route</p>
                    <p>Employee Modules > Approval Route</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/APPLY_TIME_ADJUSTMENTS.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Apply Time Adjustment</p>
                    <p>Time & Attendance Modules > Time Adjustment List</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/APPLY_HOLIDAY_WORKS.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Apply Holiday Work</p>
                    <p>Team Module > Apply Holiday Work</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/cash_advance.mp4" allowfullscreen></iframe>
                    </div>

                    <p class="h5 mt-2 mb-1 text-wrapper">Request Cash Advance</p>
                    <p>Earn/Deduct/Loan Module > Cash Advance</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/Dependents.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Setting Employee Dependents</p>
                    <p>Employee Modules > Employee Directory</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/Documents.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Uploading Employee Documents</p>
                    <p>Employee Modules > Employee Directory</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/EDIT_EMERGENCY_CONTACTS.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Edit Employee Emergency Contacts</p>
                    <p>Employee Modules > Employee Directory</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/GEO_FENCE.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Setting Up Geo Fencing</p>
                    <p>Employees Module > Assign Geo Fencing</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/HOW_TO_ADD_ATTENDANCE_RECORD.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Add Attendance Records</p>
                    <p>Time & Attendance Modules  > Time Records</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/HOW_TO_ADD_OFFSET_LIST.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Add Offset Lists</p>
                    <p>Time & Attendance Modules  > Offset Lists</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/HOW_TO_ADD_PAYROLL_SCHEDULE.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Add Payroll Schedule</p>
                    <p>Time & Attendance Modules  > Add Payroll Schedule</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/HOW_TO_ADD_TIME_ADJUSTMENT_LIST.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Add Time Adjustment Lists</p>
                    <p>Time & Attendance Modules  > Add Time Adjustment List</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/edit_employment_details.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Edit Employee's Employment Details</p>
                    <p>Employees Module > Edit Employee's Employment Details</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/edit_personal_details.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Edit Personal Details</p>
                    <p>Employees Module > Edit Personal Details</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/employee_requirements.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Upload Employee Requirements</p>
                    <p>Employees Module > Upload Employee Requirements</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/edit_employee_id.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Edit Employee ID Details</p>
                    <p>Employees Module > Edit Employee ID Details</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/edit_biometric_id.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Edit Employee Biometric ID</p>
                    <p>Employees Module > Edit Employee Biometric ID</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/edit_compendation_details.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Edit Employee Compensation Details</p>
                    <p>Employees Module > Edit Employee Compensation Details</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/edit_employee_education.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Edit Employee Education Details</p>
                    <p>Employees Module > Edit Employee Education Details</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/endorsing_employee_to_payroll.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Endorsing Employee To Payroll</p>
                    <p>Time & Attendance Modules  > Attendance Summary</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/print_payroll_report.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Print Payroll Reports</p>
                    <p>Hr Essentials >Print Payroll Reports</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/leave_request.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Requesting Leave</p>
                    <p>Hr Essentials >Requesting Leave</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/PAYROLL_ASSIGNMENT.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Assigning Payroll</p>
                    <p>Employee Module > Payroll Assignment</p>
                </div>

               
                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/SETUP_ORGANIZATIONAL_CHART.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Setup Organizational Chart</p>
                    <p>Employee Modules > Setup Organizational Chart</p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/hr_users/Workshifts.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Adding Workshift</p>
                    <p>Time & Attendance Modules > Workshifts</p>
                </div>




            </div>
        <?php endif ?>

        <?php if ($admin_guide) : ?>
            <div class="row">

                <div class="col-md-6">
                    <h1 class="page-title">Guide for Administrator </h1>
                </div>
            </div>
            <hr class="mt-1">

            <div class="row gy-5">
                <?php if ($userguide_active_inactive) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/qUsmphCUCj4" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Set Active/Inactive Employees</p>
                        <p>Administrator Module > Access Management</p>
                    </div>
                <?php endif ?>

                <?php if ($userguide_reset_pass) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/38mAVJmgOwA" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Reset Password</p>
                        <p>Administrator Module > Access Management</p>
                    </div>
                <?php endif ?>

                <?php if ($userguide_useraccess) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/UJlRsbIAvGM" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Set User Access</p>
                        <p>Administrator Module > Access Management</p>
                    </div>
                <?php endif ?>

                <?php if ($userguide_ip_whitelist) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/H0N1XqsFJgU" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Set IP Address Whitelisting</p>
                        <p>Administrator Module > IP Address</p>
                    </div>
                <?php endif ?>

                <?php if ($userguide_set_home) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/MVKOBknOx8o" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Set Up Home Settings</p>
                        <p>Administrator Module > Home Settings</p>
                    </div>
                <?php endif ?>

                <?php if ($userguide_set_company) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/9V1LeZmgxJc" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper">Set Company Structure Settings</p>
                        <p>Administrator Module > Company Structure Settings</p>
                    </div>
                <?php endif ?>

                <?php if ($userguide_set_useraccess) : ?>
                    <div class="col-md-3">
                        <div class=" w-100">
                            <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://www.youtube.com/embed/8vrXYAKg2yc" allowfullscreen></iframe>
                        </div>
                        <p class="h5 mt-2 mb-1 text-wrapper"> Set Up User Accessibility</p>
                        <p>Administrator Module >Administrator Accessibility </p>
                    </div>
                <?php endif ?>
                
                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/administrator/ADDED_PROFILE.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Adding User Access Profile</p>
                    <p>Administrator Module >User Accessibility </p>
                </div>

                <div class="col-md-3">
                    <div class=" w-100">
                        <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/administrator/QUICK_EDIT.mp4" allowfullscreen></iframe>
                    </div>
                    <p class="h5 mt-2 mb-1 text-wrapper">Quick Edit Employee User Access</p>
                    <p>Administrator Module >User Accessibility </p>
                </div>


            </div>
        <?php endif ?>


        <div class="row">

            <div class="col-md-6">
                <h1 class="page-title">Payroll Userguide</h1>
            </div>
        </div>
        <hr class="mt-1">

        <div class="row gy-5">
            <div class="col-md-3">
                <div class=" w-100">
                    <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/payroll/Custom_Contribution.mp4" allowfullscreen></iframe>
                </div>
                <p class="h5 mt-2 mb-1 text-wrapper">Assigning Employee Custom Contribution</p>
                <p>Payroll Module > Custom Contribution </p>
            </div>
            <div class="col-md-3">
                <div class=" w-100">
                    <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/payroll/Generate_Payslip.mp4" allowfullscreen></iframe>
                </div>
                <p class="h5 mt-2 mb-1 text-wrapper">Generating Payslip</p>
                <p>Payroll Module >Payroll Generation </p>
            </div>
            <div class="col-md-3">
                <div class=" w-100">
                    <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/payroll/Manage_Salary.mp4" allowfullscreen></iframe>
                </div>
                <p class="h5 mt-2 mb-1 text-wrapper">Assign Employee Salary</p>
                <p>Payroll Module >Manage Salary </p>
            </div>
            <div class="col-md-3">
                <div class=" w-100">
                    <iframe height="200px" class="w-100 rounded-5  d-block m-auto" src="https://technos-systems.com/_eyeboxroot/videos/payroll/Payroll_Schedule.mp4" allowfullscreen></iframe>
                </div>
                <p class="h5 mt-2 mb-1 text-wrapper">Generate Payroll Schedule For Employees</p>
                <p>Payroll Module > Payroll Schedule </p>
            </div>

        </div>



    </div>


</div>



<?php $this->load->view('templates/jquery_link'); ?>

<script>
    // Document ready event

    $(document).ready(function() {

        // Maximum length for truncation

        const maxLength = 50;



        // Select all elements with the "text-wrapper" class

        $('.text-wrapper').each(function() {

            // Check if the text exceeds the maximum length

            if ($(this).text().length > maxLength) {

                // Truncate the text and add ellipsis

                const truncatedText = $(this).text().slice(0, maxLength) + '...';

                $(this).text(truncatedText);

            }

        });

    });
</script>

</html>