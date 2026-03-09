    <div class="  col-md-12 items">
                        <?php if ($is_super_admin==1) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="selfservices_modules" type="checkbox" id="self_service_tab">
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
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Loans" id="my_loans">
                                                <label class="form-check-label" for="my_loans">My Loans</label>
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
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="My Offsets" id="my_offsets">
                                                <label class="form-check-label" for="my_offsets">My Offsets</label>
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
                        <?php } return?>
                        <?php if ($MODULES['company'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="company_modules" type="checkbox" id="company_tab">
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
                        <?php if ($MODULES['employee'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="employee_modules" type="checkbox" id="emplyee_tab">
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
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Approval Route" id="approval_routes">
                                                <label class="form-check-label" for="approval_routes">Approval Route</label>
                                            </div>
                                        </li>

                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Manage Salary" id="manage_salary">
                                                <label class="form-check-label" for="manage_salary">Manage Salary</label>
                                            </div>
                                        </li>


                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Setup Organizatonal Chart" id="setup_organizatonal_chart">
                                                <label class="form-check-label" for="setup_organizatonal_chart">Setup Organizatonal Chart</label>
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

                        <!-- Attendance -->
                        <?php if ($MODULES['attendance'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="attendance_modules" type="checkbox" id="attendance_tab">
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
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Attendance Summary" id="attendance_summary">
                                                <label class="form-check-label" for="attendance_summary">Attendance Summary</label>
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
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Shift Assignment" id="shift_assignment">
                                                <label class="form-check-label" for="shift_assignment">Shift Assignment</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Import Attendance" id="import_attendance">
                                                <label class="form-check-label" for="import_attendance">Time Records</label>
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
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Time Adjustment List" id="time_adjustment_list">
                                                <label class="form-check-label" for="time_adjustment_lis">Time Adjustment List</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Attendance Undertime" id="attendance_undertime">
                                                <label class="form-check-label" for="attendance_undertime">Undertime</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- END -->
                        <!-- Leave -->
                        <?php if ($MODULES['leave'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="leave_modules" type="checkbox" id="leave_tab">
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
                                    
                                </div>
                            </div>
                        <?php } ?>
                        <!-- END -->
                        <!-- Overtime -->
                        <?php if ($MODULES['overtimes'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="overtime_modules" type="checkbox" id="overtime_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="overtime_tab"><strong>Overtime</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Overtime-Overtime Request" id="overtime_overtime_request">
                                                <label class="form-check-label" for="overtime_overtime_request">Overtime Request</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Overtime-Holiday Work" id="overtime_holiday_work">
                                                <label class="form-check-label" for="overtime_holiday_work">Holiday Work</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($MODULES['teams'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="team_modules" type="checkbox" id="teams_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="overtime_tab"><strong>Team</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Apply Leaves" id="apply_leaves">
                                                <label class="form-check-label" for="apply_leaves">Apply Leaves</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Apply Overtimes" id="apply_overtimes">
                                                <label class="form-check-label" for="apply_overtimes">Apply Overtimes</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Apply Time Adjustments" id="apply_time_adjustments">
                                                <label class="form-check-label" for="apply_time_adjustments">Apply Time Adjustments</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Apply Holiday Works" id="apply_holiday_works">
                                                <label class="form-check-label" for="apply_holiday_works">Apply Holiday Works</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- END -->
                        <!-- Overtime -->
                        <?php if ($MODULES['reports'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="report_modules" type="checkbox" id="reports_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="reports_tab"><strong>Reports</strong></label></a>
                                </div>
                                
                            </div>
                        <?php } ?>
                        <!-- END -->
                        <!-- Payroll -->
                        <?php if ($MODULES['payroll'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="payroll_modules" type="checkbox" id="payroll_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="payroll_tab"><strong>Payroll</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Payroll Generation" id="payroll_status">
                                                <label class="form-check-label" for="payroll_status">Payroll Generation</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Custom Contributions" id="custom_contributions">
                                                <label class="form-check-label" for="custom_contributions">Custom Contributions</label>
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
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="HDMF Contribution Table" id="hdmf_contributions">
                                                <label class="form-check-label" for="hdmf_contributions">HDMF Contribution Table</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="SSS Contribution Table" id="sss_contributiom">
                                                <label class="form-check-label" for="sss_contributiom">SSS Contribution Table</label>
                                            </div>
                                        </li>
                                                                               
                                       
                                        
                                    </ul>
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Withholding Tax Table" id="withholding_tax">
                                                <label class="form-check-label" for="withholding_tax">Withholding Tax</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Payroll Schedule" id="payroll_schedule">
                                                <label class="form-check-label" for="payroll_schedule">Payroll Schedule</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="PhilHealth Contribution Table" id="philhealth_contribution_table">
                                                <label class="form-check-label" for="philhealth_contribution_table">Philhealth Contribution Table</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Government Contribution" id="government_contribuion">
                                                <label class="form-check-label" for="government_contribuion">Government Contribution</label>
                                            </div>
                                        </li>
                                                                               
                                       
                                        
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- End -->
                        <!-- Recruitment -->
                        <?php if ($MODULES['recruitment'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="recruitment_modules" type="checkbox" id="recruitment_tab">
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
                        <!-- HR Essetials -->
                        <?php if ($MODULES['hr'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="hr_modules" type="checkbox" id="hr_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="hr_tab"><strong>HR Essentials</strong></label></a>
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
                        <!-- Learn and Development -->
                        <?php if ($MODULES['benefits'] != '0') { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="benefits_modules" type="checkbox" id="benefits_tab">
                                    <a href="#"><label class="form-check-label" style="cursor: pointer; color: black;" for="benefits_tab"><strong>Benefits</strong></label></a>
                                </div>
                                <div class="row">
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Dynamic Benefits" id="dynamic_benefits">
                                                <label class="form-check-label" for="dynamic_benefits">Dynamic Benefits</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Earnings" id="earnings">
                                                <label class="form-check-label" for="earnings">Earnings</label>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="col-md-6">
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Loans Benefits" id="loans_benefits">
                                                <label class="form-check-label" for="loans_benefits">Loans Benefits</label>
                                            </div>
                                        </li>
                                        <li class="list-unstyled mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input check_data" type="checkbox" name="data[]" value="Adjustments Benefits" id="adjustments_benefits">
                                                <label class="form-check-label" for="adjustments_benefits">Adjustments Benefits</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- End -->
                        <!-- Administrator -->
                        <?php if ($MODULES['administrator']) { ?>
                            <div class="check_module">
                                <div class="form-check mb-3 module_data">
                                    <input class="form-check-input select_all" name="module[]" value="administrator_modules" type="checkbox" id="administrator_tab">
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
                                                <label class="form-check-label" for="ip_address">IP Address</label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- End -->
</div>