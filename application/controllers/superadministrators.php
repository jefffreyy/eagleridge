<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class superadministrators extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('modules/superadministrators_model');
        $this->load->model('templates/main_nav_model');
        $this->load->library('session');
        $this->load->helper('form');

        // auto login starts
        $this->load->model('admin_model');
        $auto_login = $this->admin_model->get_system_setup_by_setting2('auto_login', '0');
        if ($auto_login == '1' && empty($this->session->userdata('SESS_USER_ID'))) {
            $this->session->set_userdata('SESS_USER_ID', 1);
        }
        // auto login ends

        if ($this->session->userdata('SESS_USER_ID') == '') {
            redirect('login/session_expired');
        }

        $maintenance      = $this->login_model->GET_MAINTENANCE();
        $isAdmin          = $this->session->userdata('SESS_ADMIN');
        if ($maintenance == '1' && $isAdmin != 1) {
            redirect('login/maintenance');
        }
    }
    function index()
    {
        $data["Modules"] =  array(
            array("title" => "Setup",                "icon" => "screwdriver-wrench-solid.svg",             "info" => "Lets you customize and update the logos and name of the company.",             "url" => "superadministrators/setups",          "access" => "Super Administrator", "id" => "setups"),
            array("title" => "Module Activation",                "icon" => "check-double-solid.svg",             "info" => "Lets you customize modules you only want see.",             "url" => "superadministrators/module_activations",          "access" => "Super Administrator", "id" => "module_activations"),
            array("title" => "Truncate Tables",                "icon" => "check-double-solid.svg",             "info" => "Allows administrator to reset or delete all the data within a database table.",             "url" => "superadministrators/truncate_database_tables",          "access" => "Super Administrator", "id" => "truncate_database_tables"),
            array("title" => "Configuration",                "icon" => "check-double-solid.svg",             "info" => "Allow administrators configure how system updates and maintenance tasks are handled. This includes specifying maintenance windows, update notification preferences, and automated update settings.",             "url" => "superadministrators/configurations",          "access" => "Super Administrator", "id" => "configurations"),
            array("title" => "System Variables",                "icon" => "check-double-solid.svg",             "info" => "These variables are used to control various aspects of the HRMS, influencing its behavior, appearance, and functionality across the entire system.",             "url" => "superadministrators/system_variables",          "access" => "Super Administrator", "id" => "system_variables"),
            array("title" => "Request List",                "icon" => "check-double-solid.svg",             "info" => "These variables are used to control various aspects of the HRMS, influencing its behavior, appearance, and functionality across the entire system.",             "url" => "superadministrators/request_list",          "access" => "Super Administrator", "id" => "request_list_super"),

        );

        $data["title_page"]                 = "Super Administrator";
        $data["title_description"]                 = "Access Everything: Exlusive for Technos Systems Maintenance Unit";
        // $data["maiya_theme"]                = $this->superadministrators_model->GET_MAYA_THEME();
        $user_access_id                     = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
        $data['DISP_USER_ACCESS_PAGE']      = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
        $array_page                         = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
        // $data['Modules']                    = filter_array($data["Modules"], $array_page);
        $data['DISP_SADMIN_STATUS']                 = $this->superadministrators_model->GET_SADMIN_STATUS1($this->session->userdata('SESS_USER_ID'));
        if ($this->session->userdata("SESS_ADMIN")) {
            $data["maiya_theme"]                        = $this->superadministrators_model->GET_MAYA_THEME();

            $this->load->view('templates/header');
            // $this->load->view('modules/superadministrators/super_administrator_views',$data);
            $this->load->view('templates/main_container', $data);
            // Selfservices Module
            $data2["Modules"] =  array(
                array("title" => "My Profile",                "icon" => "address-card-duotone.svg",             "info" => "View your personal and employment information, and access resources all in one page.",                                        "url" => "selfservices/my_profile_personal",          "access" => "Self-Service", "id" => "my_profile"),
                array("title" => "My Team",                   "icon" => "people-group-duotone.svg",             "info" => "Visually maps your company's structure, helping you understand whom you report to, who your immediate members are all at a glance.",   "url" => "selfservices/my_teams",                     "access" => "Self-Service", "id" => "my_team"),
                array("title" => "My Calendar",               "icon" => "calendar-range-duotone.svg",           "info" => "Centralizes your work schedule, tasks, and holidays, ensuring you stay organized and informed.",                                       "url" => "selfservices/my_calendars",                 "access" => "Self-Service", "id" => "my_calendar"),
                array("title" => "My Tasks",                  "icon" => "diagram-subtask-duotone.svg",          "info" => "View your to-dos, streamlining your workflow and keeping you on top of deadlines.", "url" => "selfservices/my_tasks",                     "access" => "Self-Service", "id" => "my_tasks"),
                array("title" => "My Attendance Record",      "icon" => "clock-duotone.svg",                    "info" => "Track your In/Out, view your leave, and stay in the loop on your timekeeping, all in one place.", "url" => "selfservices/my_time_records",              "access" => "Self-Service", "id" => "my_time_records"),
                array("title" => "Remote Attendance",         "icon" => "map-location-dot-duotone.svg",         "info" => "Check-in and Check-out remotely", "url" => "selfservices/my_time_in_outs",              "access" => "Self-Service", "id" => "my_time_in_outs"),
                array("title" => "My Time Adjustments",       "icon" => "rotate-duotone.svg",                   "info" => "Manage and rectify inaccuracies in your recorded work hours", "url" => "selfservices/my_time_adjustments",          "access" => "Self-Service", "id" => "my_time_adjustments"),
                array("title" => "My Leaves",                 "icon" => "house-person-leave-duotone.svg",       "info" => "View, track, and manage your accrued time off, empowering you to plan holidays and ensure you never miss a day.", "url" => "selfservices/my_leaves",                    "access" => "Self-Service", "id" => "my_leaves"),
                array("title" => "My Overtimes",              "icon" => "gauge-max-duotone.svg",                "info" => "View, track, and manage overtime hours and pay with ease", "url" => "selfservices/my_overtimes",                 "access" => "Self-Service", "id" => "my_overtimes"),
                array("title" => "My Offsets",                "icon" => "gauge-max-duotone.svg",                "info" => "View, track, and manage offsets hours and pay with ease", "url" => "selfservices/my_offsets",                 "access" => "Self-Service", "id" => "my_offsets"),
                array("title" => "My Holiday Work",           "icon" => "car-building-duotone.svg",             "info" => "View, track, and manage Holiday and pay with ease", "url" => "selfservices/my_holiday_work",              "access" => "Self-Service", "id" => "my_holiday_work"),
                array("title" => "My Payslips",               "icon" => "file-invoice-duotone.svg",             "info" => "Access and review your payslips anytime, anywhere.", "url" => "selfservices/my_payslips",                  "access" => "Self-Service", "id" => "my_payslips"),
                array("title" => "My Support Requests",       "icon" => "comments-question-check-duotone.svg",  "info" => "Track, respond to, and resolve all your HR-related issues", "url" => "selfservices/my_support_requests",          "access" => "Self-Service", "id" => "my_support_requests"),
                array("title" => "My Complaints",             "icon" => "person-sign-duotone.svg",              "info" => "Track and manage any grievances you've lodged with HR.", "url" => "selfservices/my_complaints",                "access" => "Self-Service", "id" => "my_complaints"),
                array("title" => "My Warnings",               "icon" => "circle-exclamation-duotone.svg",       "info" => "Check any disciplinary warnings issued to you", "url" => "selfservices/my_warnings",                  "access" => "Self-Service", "id" => "my_warnings"),
                array("title" => "My Loans",                  "icon" => "circle-exclamation-duotone.svg",       "info" => "View loan details, installments due, and repayment progress", "url" => "selfservices/my_loans",                     "access" => "Self-Service", "id" => "my_loans"),
                array("title" => "Notifications",             "icon" => "light-emergency-on-duotone.svg",       "info" => "Receive reminders for tasks, approvals, and deadlines", "url" => "selfservices/notifications",                "access" => "Self-Service", "id" => "notifications"),
                array("title" => "Leave Approval",            "icon" => "plane-circle-check-duotone.svg",       "info" => "Review and approve (or deny) leave requests submitted by your team", "url" => "selfservices/leave_approval",               "access" => "Self-Service", "id" => "leave_approval"),
                array("title" => "Overtime Approval",         "icon" => "person-circle-check-duotone.svg",      "info" => "Manage employee overtime requests, ensuring compliance with policies.", "url" => "selfservices/overtime_approval",            "access" => "Self-Service", "id" => "overtime_approval"),
                array("title" => "Holiday Work Approval",     "icon" => "car-building-duotone.svg",             "info" => "Review and approve requests to work on holidays for specific duties", "url" => "selfservices/holidaywork_approval",         "access" => "Self-Service", "id" => "holidaywork_approval"),
                array("title" => "Time Adjustment Approval",  "icon" => "reply-clock-duotone_ss.svg",              "info" => "Handle employee requests to adjust their recorded working hours.", "url" => "selfservices/time_adjustment_approval",     "access" => "Self-Service", "id" => "time_adjustment_approval"),
                // array("title" => "Offset Approval",           "icon" => "reply-clock-duotone.svg",              "url" => "selfservices/offset_approval",              "access" => "Self-Service", "id" => "offset_approval"),
                array("title" => "Backup Approvals",          "icon" => "stamp-duotone.svg",                    "info" => "Handle employee requests approval as secondary approver.", "url" => "selfservices/backup_approvals",             "access" => "Self-Service", "id" => "backup_approval"),
            );
            $data2["title_page"]                 = "Self-services";
            $data2["title_description"]                 = "Allows employees to manage and accessing their own HR-related information. Employees can perform various tasks without having to rely on the HR department for every transaction.";

            $this->load->view('templates/main_container_superadmin', $data2);


            // Company Module
            $data3["Modules"] =  array(
                array("title" => "About the Company",    "value" => "Company-About the Company", "icon" => "buildings-duotone.svg",      "info" => "Access information about the company's mission, values, history.",       "url" => "companies/about_the_company",    "access" => "Company", "id" => "about_the_company"),
                array("title" => "Announcements",        "value" => "Company Announcements",     "icon" => "bullhorn-duotone.svg",        "info" => "Stay informed about important company news, events, and updates",      "url" => "companies/announcements",        "access" => "Company", "id" => "announcements"),
                array("title" => "Policies",             "value" => "Company Policies",          "icon" => "scale-balanced-duotone.svg",  "info" => "View and understand company policies on various matters, like conduct, leave, benefits, and safety.",      "url" => "companies/policies",             "access" => "Company", "id" => "policies"),
                array("title" => "Organizational Chart", "value" => "Organizational Chart",      "icon" => "sitemap-duotone.svg",          "info" => "See the company's structure and who reports to whom.",     "url" => "companies/organizational_chart", "access" => "Company", "id" => "organizational_chart"),
                array("title" => "Holidays",             "value" => "Company Holidays",          "icon" => "person-hiking-duotone_dark.svg",    "info" => "Review the official company holiday calendar and schedule.",     "url" => "companies/holidays",             "access" => "Company", "id" => "holidays"),
                array("title" => "Knowledge Base",       "value" => "Company Knowledge Base",    "icon" => "head-side-brain-duotone.svg",  "info" => "Access self-service guides, tutorials, and resources on policies, benefits, and processes.",     "url" => "companies/knowledges_bases",     "access" => "Company", "id" => "knowlegde_base"),
            );
            $data3["title_page"]                                = "Company Module";

            $data3["title_description"]                 = "Up-to-date details about the organization, its structure, and other essential information";


            $this->load->view('templates/main_container_superadmin', $data3);


            
            // Teams Module
            $data4["Modules"] =  array(
                array("title" => "Apply Leaves",                  "value" => "Apply Leaves",               "icon" => "house-person-leave-duotone.svg",                 "info" => "This system maintains accurate and up-to-date records of employees' leave balances, usage, and history.",           "url" => "teams/apply_leaves",       "access" => "Teams",  "id" => "apply_leaves"),
                array("title" => "Apply Overtimes",               "value" => "Apply Overtimes",           "icon" => "clock-duotone.svg",                            "info" => "This system maintains accurate records of employees' overtime hours, ensuring that both employees and the organization have a clear view of overtime usage.",           "url" => "teams/apply_overtimes",      "access" => "Teams", "id" => "apply_overtimes"),
                array("title" => "Apply Time Adjustments",        "value" => "Apply Time Adjustments",    "icon" => "rotate-duotone.svg",                           "info" => "This system provides transparency in the time adjustment process. Employees can submit requests, track the status of their requests, and receive notifications about approvals or denials.",           "url" => "teams/apply_time_adjustments",      "access" => "Teams", "id" => "apply_time_adj"),
                array("title" => "Apply Holiday Works",           "value" => "Apply Holiday Works",       "icon" => "calendar-xmark-duotone-2xl.svg",                   "info" => "This system allow employees to initiate requests for holiday work, view their holiday work history, and access information related to compensation policies.",             "url" => "teams/apply_holiday_works",      "access" => "Teams", "id" => "apply_holiday_works")
            );
            $data4["title_page"]                                   = "Teams Management";
            $data4["title_description"]                            = "Allows supervisors and managers to organize and manage the team members within an organization";

            $this->load->view('templates/main_container_superadmin', $data4);

            // Employees Module
            $data5["Modules"] =  array(
                array("title" => "Employee Directory",                "icon" => "users-gear-duotone.svg",             "url" => "employees/directories",             "info" => "Views essential information for each employee, status, designation.",           "access" => "Employee", "id" => "employee_directory"),
                array("title" => "Manage Salary",                     "icon" => "money-bill-1-wave-duotone.svg",      "url" => "employees/salary_details",          "info" => "Configure salary amount and type for each employee",           "access" => "Employee", "id" => "salary_details"),
                array("title" => "Payroll Assignment",                "icon" => "object-ungroup-duotone.svg",         "url" => "employees/payroll_assignment",      "info" => "Configure payslip processing designation",           "access" => "Payroll", "id" => "payroll_assignment"),
                array("title" => "Setup Organizatonal Chart",         "icon" => "sitemap-duotone.svg",                "url" => "employees/setup_organization",      "info" => "Define employee positions and roles within the organization",           "access" => "Employee", "id" => "non-taxable_allowance"),
                array("title" => "Approval Route",                    "icon" => "check-to-slot-duotone.svg",          "url" => "employees/approval_routes",         "info" => "Establish approvers and a sequential workflow for requests to move through predefined approver orders.",             "access" => "Employee", "id" => "approval_route")
            );
            $data5['settings']                   = "employees/employee_types";
            $data5["title_page"]                 = "Employee Information Management";
            $data5["title_description"]          = "Provides HR with tools and functionalities to efficiently handle Employee data, and ensure compliance";

            $this->load->view('templates/main_container_superadmin', $data5);

            // Attendance Module
            $data6["Modules"] =  array(
                array("title" => "Attendance Records",      "value" => "Attendance Records",      "info" => "Views detailed employees in/out and attendance record", "icon" => "calendar-clock-duotone-att.svg",                   "url" => "attendances/attendance_records",     "access" => "Attendance",  "id" => "attendance_records"),
                array("title" => "Attendance Summary",      "value" => "Attendance Summary",      "info" => "Views summarized attendance record of all employees. HR can export and endorse the list to payroll.", "icon" => "table-list-duotone-att.svg",                   "url" => "attendances/attendance_summary",     "access" => "Attendance",  "id" => "attendance_summary"),
                array("title" => "Daily Attendance",        "value" => "Daily Attendance",        "info" => "Views daily summarized attendance record of all employees.", "icon" => "sun-duotone-att.svg",                                     "url" => "attendances/daily_attendances",      "access" => "Attendance", "id" => "daily_attendance"),
                array("title" => "Shift Assignment",        "value" => "Shift Assignment",        "info" => "Assign specific work shifts or schedules to individual employees or groups of employees within an organization.", "icon" => "chart-gantt-duotone-att.svg",                      "url" => "attendances/shift_assignment",       "access" => "Attendance",  "id" => "shift_assignment"),
                array("title" => "Work Shifts",             "value" => "Work Shifts",             "info" => "Define, configure, and manage the work shifts or schedules for employees within an organization.", "icon" => "moon-over-sun-duotone-att.svg",                    "url" => "attendances/work_shifts",            "access" => "Attendance",  "id" => "work_shifts"),
                array("title" => "Holidays",                "value" => "Attendance Holidays",     "info" => "Define and manage the list of official holidays for an organization", "icon" => "person-hiking-duotone_dark.svg",                    "url" => "attendances/holidays",               "access" => "Attendance",  "id" => "holidays"),
                array("title" => "Time Adjustment List",    "value" => "Time Adjustment List",    "info" => "Review, manage, and process time adjustments made by employees.", "icon" => "reply-clock-duotone_ss.svg",                      "url" => "attendances/time_adjustment_lists",  "access" => "Attendance",  "id" => "time_adjustment_list"),
                array("title" => "Offset List",            "value" => "Offset Request",          "info" => "Review, manage, and process offsets to correct discrepancies", "icon" => "reply-clock-duotone_ss.svg",                      "url" => "attendances/offset_lists",           "access" => "Attendance",  "id" => "offset_lists"),
                array("title" => "Biometric Records",       "value" => "Zkteco Attendance",       "info" => "Views attendance data from Biometric devices", "icon" => "fingerprint-duotone-att.svg",                      "url" => "attendances/zkteco_attendance",      "access" => "Attendance",  "id" => "zkteco_attendance"),
                array("title" => "Biometric User ID",       "value" => "Zkteco Code",             "info" => "Configure and synchronize Employee ID and Biometrics ID", "icon" => "user-group-simple-duotone-att.svg",                "url" => "attendances/zkteco_code",            "access" => "Attendance",  "id" => "zkteco_code"),
                array("title" => "Time Records",              "value" => "Import Attendance",       "info" => "Views essential information for each employee, status, designation.", "icon" => "file-import-duotone-att.svg",               "url" => "attendances/edit_attendance_summary",            "access" => "Attendance",  "id" => "import_attendance"),
                array("title" => "Advance Filing of Time Records",              "value" => "Advance Attendance",       "info" => "Views essential information for each employee, status, designation.", "icon" => "file-import-duotone-att.svg",               "url" => "attendances/update_attendance_summary_advance",            "access" => "Attendance",  "id" => "advance_attendance"),
                array("title" => "Exempt Undertime",             "value" => "Attendance Undertime",       "info" => "Views essential information for each employee, status, designation.", "icon" => "file-import-duotone-att.svg",               "url" => "attendances/undertime",            "access" => "Attendance",  "id" => "undertime"),
            );
            $data6['settings']                   = "attendances/setting_holidays";
            $data6["title_page"]                                   = "Time and Attendance Management";
            $data6["title_description"]                            = "Focuses on tracking and managing employee work hours, attendance, and related data";

            $this->load->view('templates/main_container_superadmin', $data6);

            // Leaves Module
            $data7["Modules"] =  array(
                array("title" => "Leave Request",        "icon" => "house-person-leave-duotone.svg",         "info" => "Lets you view the leave requests and initiate the leave request process by submitting a formal request for time off.",        "url" => "leaves/leave_lists",     "access" => "Leave", "id" => "leave_request"),
                array("title" => "Leave Entitlement",    "icon" => "sliders-duotone.svg",                      "info" => "Lets you set initial allocation of a specific number of leave days or hours to each employee.",        "url" => "leaves/entitlements",    "access" => "Leave", "id" => "leave_entitlement"),
            );


            $data7["title_page"]                            = "Leave Management";
            $data7['settings']                           = "leaves/settings_leavepolicies";
            $data7["title_description"]                  = "Allows you to oversee and administer leave policies, monitor employee absences, and ensure compliance with company regulations";

            $this->load->view('templates/main_container_superadmin', $data7);

            // Overtime Modules
            $data8["Modules"] =  array(
                array("title" => "Overtime",     "value" => "Overtime-Overtime Request",      "icon" => "clock-nine-duotone.svg",            "info" => "Lets you view and initiate an overtime request for hours worked beyond their regular work schedule. ",      "url" => "overtimes/overtime",         "access" => "Overtime", "id" => "overtime_overtime"),
                array("title" => "Holiday Work", "value" => "Overtime-Holiday Work",          "icon" => "calendar-xmark-duotone-2xl.svg",    "info" => "Lets you view and initiate a holiday work overtime request for hours worked on a recognized holiday. ",      "url" => "overtimes/holiday_works",    "access" => "Overtime", "id" => "overtime_holidaywork"),
            );
            $data8['settings']                       = "overtimes/overtime_step";
            $data8["title_page"]                     = "Overtime Management";
            $data8["title_description"]              = "Allows you to oversee and administer overtime policies, and ensure compliance with company regulations";

            $this->load->view('templates/main_container_superadmin', $data8);

            // Earnings Module
            $data9["Modules"] =  array(
                // array("title" => "Dynamic Benefits",            "value" => "Dynamic Benefits",              "icon" => "fa-kit fa-fixeddynamic",                   "url" => "benefits/dynamic",              "access" => "Benefits",  "id" => "dynamic"),
                array("title" => "Earnings/Deductions",                    "value" => "Earnings/Deductions",                      "icon" => "fixedbenefits.svg",             "info" => "Lets you view various elements beyond the base salary, such as allowances, bonuses, incentives, and other monetary components.",                           "url" => "benefits/fixed?income_type=Earnings",                "access" => "Benefits",  "id" => "fixed"),
                array("title" => "Deductions",                  "value" => "Other Deductions",              "icon" => "hand-holding-dollar-solid.svg",       "info" => "Miscellaneous deductions from an employee's salary or compensation package. ",                 "url" => "benefits/fixed?income_type=Deductions",     "access" => "Benefits",  "id" => "other_deductions"),
                array("title" => "Loans",                       "value" => "Loans Benefits",                "icon" => "loans.svg",                     "info" => "Lets you view and track the status of benefits loans, including details such as the outstanding loan balance.",                                                 "url" => "benefits/loans",                "access" => "Benefits",  "id" => "loans"),
                array("title" => "Adjustment",                  "value" => "Adjustments Benefits",          "icon" => "square-sliders-vertical-solid.svg",   "info" => "Effective dates, and any actions required on the part of the employees.",        "url" => "benefits/adjustment",           "access" => "Benefits",  "id" => "adjustment"),
            );

            $data9['settings']                                  = "benefits/setting_general";
            $data9["title_page"]                                = "Earnings/Deductions/Loans Management";
            $data9["title_description"]                         = "Allows HR to manage and administer employee benefits, deductions, and loans";

            $this->load->view('templates/main_container_superadmin', $data9);

            // Payroll Module
            $data10["Modules"] =  array(
                array("title" => "Payroll Generation",              "value" => "Payroll Status",                "info" => "",       "icon" => "print-duotone.svg",                "url" => "payrolls/payroll_status",             "access" => "Payroll", "id" => "payroll_status"),
                array("title" => "13th Month Pay",                  "value" => "13th Month Pay",                "info" => "",       "icon" => "hand-holding-dollar-duotone.svg",  "url" => "payrolls/thitteenthmonthpay",         "access" => "Payroll", "id" => "13th_month_pay"),
                array("title" => "Payroll Schedule",                "value" => "Payroll Schedule",              "info" => "",       "icon" => "calendar-check-duotone.svg",       "url" => "payrolls/payroll_schedules",          "access" => "Payroll", "id" => "payrolls"),
                array("title" => "Custom Contributions",            "value" => "Custom Contributions",          "info" => "",       "icon" => "piggy-bank-duotone.svg",           "url" => "payrolls/custom_contributions",       "access" => "Payroll", "id" => "custom_contributions"),
                // array("title" => "SSS Contribution Table",          "value" => "SSS Contribution",              "info" => "",       "icon" => "sss.svg",                          "url" => "payrolls/payroll_sss",                "access" => "Payroll", "id" => "payroll_sss"),
                // array("title" => "PhilHealth Contribution Table",   "value" => "Payroll PhilHealth",            "info" => "",       "icon" => "phic.svg",                         "url" => "payrolls/payroll_philhealth",         "access" => "Payroll", "id" => "payroll_philhealth"),
                // array("title" => "HDMF Contribution Table",         "value" => "Payroll HDMF",                  "info" => "",       "icon" => "hdmf.svg",                         "url" => "payrolls/payroll_hdmf",               "access" => "Payroll", "id" => "payroll_hdmf"),
                array("title" => "Withholding Tax Table",           "value" => "Payroll Tax",                   "info" => "",       "icon" => "wtax.svg",                         "url" => "payrolls/payroll_tax",                "access" => "Payroll", "id" => "payroll_tax"),
                array("title" => "Government Contribution",         "value" => "Government Contribution",       "info" => "",       "icon" => "wtax.svg",                         "url" => "payrolls/government_contribution",    "access" => "Payroll", "id" => "government_contribution"),
            );
            $data10['settings']                       = "payrolls/setting_constant";
            $data10["title_page"]                     = "Payroll Module";
            $data10["title_description"]                = "Overseeing payroll processes, ensuring accurate and timely salary payments, and maintaining compliance with tax and labor regulations";

            $this->load->view('templates/main_container_superadmin', $data10);

            // HR Essentials
            $data11["Modules"] =  array(
                array("title" => "About the Company",   "value" => "HR About the Company", "info" => "", "icon" => "buildings-duotone_hr.svg",               "url" => "hressentials/about_the_company", "access" => "HR Essentials",   "id" => "about_the_company"),
                array("title" => "Announcements",       "value" => "HR Announcements",     "info" => "", "icon" => "bullhorn-duotone_hr.svg",               "url" => "hressentials/announcements",    "access" => "HR Essentials",   "id" => "announcements"),
                array("title" => "Welcome Message",    "value" => "HR Welcome Messages",  "info" => "", "icon" => "scroll-duotone.svg",                        "url" => "hressentials/welcome_messages", "access" => "HR Essentials",   "id" => "welcome_messages"),
                array("title" => "Warnings",            "value" => "HR Warnings",          "info" => "", "icon" => "triangle-exclamation-duotone.svg",   "url" => "hressentials/warnings",         "access" => "HR Essentials",   "id" => "warnings"),
                array("title" => "Support",             "value" => "HR Support",           "info" => "", "icon" => "messages-question-duotone.svg",      "url" => "hressentials/supports",         "access" => "HR Essentials",   "id" => "support"),
                //   array("title" => "Forms",               "value" => "HR Forms",             "icon" => "fa-duotone fa-messages-question",      "url" => "hressentials/forms",            "access" => "HR Essentials",   "id" => "forms"),
                array("title" => "Complaint",           "value" => "HR Complaint",        "info" => "", "icon" => "person-sign-duotone_hr.svg",            "url" => "hressentials/complaints",       "access" => "HR Essentials",   "id" => "complaint"),
                array("title" => "Survey",              "value" => "HR Survey",            "info" => "", "icon" => "square-poll-vertical-duotone.svg",   "url" => "hressentials/surveys",          "access" => "HR Essentials",   "id" => "survey"),
                //   array("title" => "Events",              "value" => "HR Events",           "icon" => "fas fa-calendar-check",                "url" => "hressentials/events",           "access" => "HR Essentials",   "id" => "events"),
                array("title" => "Policies",            "value" => "HR Policies",         "info" => "", "icon" => "scale-balanced-duotone_hr.svg",         "url" => "hressentials/policies",         "access" => "HR Essentials",   "id" => "policies"),
            );
            $data11["title_page"]             = "HR Essentials";
            $data11["title_description"]      = "Includes fundamental and core functionalities essential for HR management";

            $this->load->view('templates/main_container_superadmin', $data11);

            // Admin MOdule
            $data12["Modules"]    =  array(
                array("title" => "Access Management",           "value" => "Access Management",     "icon" => "building-lock-duotone.svg",        "info" => "Allows administrators to define different user roles, each with specific permissions and access levels. Common roles may include HR administrators, managers, and other staff members. ",        "url" => "administrators/access",               "access" => "Administrator", "id" => "access_management"),
                // array("title" => "Home Settings",               "value" => "Home Settings",         "icon" => "fa-duotone fa-house-user",                   "url" => "administrators/homesettings",         "access" => "Administrator", "id" => "home_settings"),
                array("title" => "User Accessibility",          "value" => "User Accessibility",    "icon" => "plane-circle-check-duotone.svg",   "info" => "Allows administrators to have fine-tuned permissions tailored to their job responsibilities. This ensures that individuals only have access to the features and data necessary for their roles.",        "url" => "administrators/useraccess",           "access" => "Administrator", "id" => "user_accessibility"),
                // array("title" => "Default Options",           "value" => "Standard Settings",     "icon" => "building-shield-duotone.svg",      "info"=>"Let administrators assign specific roles within the system based on their positions or responsibilities in the organization.",        "url" => "administrators/positions",             "access" => "Administrator", "id" => "standard_settings"),
                array("title" => "User Access Logs",            "value" => "User Access Logs",     "icon" => "plane-circle-check-duotone.svg", "info" => '',               "url" => "administrators/user_access_logs",    "access" => "Administrator", "id" => "user_access_logs"),
                array("title" => "Activity Logs",               "value" => "Activity Logs(Admin)",  "icon" => "universal-access-duotone.svg",     "info" => "These logs provide a comprehensive audit trail of changes, updates, and interactions within the HRMS.",               "url" => "administrators/activity_logs",        "access" => "Administrator", "id" => "activity_logs"),
                array("title" => "IP Address",                  "value" => "IP Address",            "icon" => "block-brick-fire-duotone.svg",     "info" => "Lets you view or add users allowed to access the HRMS based on their IP (Internet Protocol) address.",        "url" => "administrators/ip_address",           "access" => "Administrator", "id" => "ip_address"),
                array("title" => "General Settings",            "value" => "General Settings",      "icon" => "gears-duotone.svg",       "info" => "Allows administrators configure parameters and options that control the overall behavior and appearance of the system.",          "url" => "administrators/generalsettings",      "access" => "Administrator", "id" => "general_settings"),
                array("title" => "Self Service Settings",       "value" => "Self Service Settings", "icon" => "solar-system-duotone.svg",         "info" => "Allows administrators disable or enable additional type of absences (Absences AWOL or Absences LWOP)",        "url" => "administrators/self_service_settings", "access" => "Administrator", "id" => "self_service_settings"),
            );

            $data12["title_page"]                    = "Administrator Module";
            $data12["title_description"]              = "Serves as the central control panel for managing system-wide settings, user access, and overall configuration";

            $this->load->view('templates/main_container_superadmin', $data12);
        } else {
            $this->load->view('templates/header');
            $this->load->view('modules/superadministrators/404_page_views');
        }
    }

    function request_list(){
        $selectColumns = [
            ['selectStatement' => 'id,request_details,status'],
          ];
          $filter = [
            // ['year' => $tab],
          ];
          $table = 'tbl_requests_list';
          $dataTable               = $this->superadministrators_model->get_table($table, $filter, $selectColumns);
        //   $dataTable               = json_encode($dataTable);
          $data["dataTable"]    = $dataTable;
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/request_list_views',$data);
    }

    function update_request_list(){
      $input_data = $this->input->post();
      $id = $input_data['id'];
      $validKeys = [
        'request_details',
        'status',
      ];
      $input_data             = array_intersect_key($input_data, array_flip($validKeys));
      if (!(isset($input_data['request_details']) && !empty($input_data['request_details']))) {
        $this->session->set_flashdata('ERR', 'Request details is required');
        redirect($this->input->server('HTTP_REFERER'));
      }
      $input_data['edit_date'] = date('Y-m-d H:i:s');
      $input_data['is_deleted'] = '0';
      $input_data['edit_user'] = $this->session->userdata('SESS_USER_ID'); 

      $table = 'tbl_requests_list';
      $res = $this->superadministrators_model->update_data_table($table ,$input_data,$id);
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Successfully Submitted');
      } else {
        $this->session->set_flashdata('ERR', 'Submission Failed');
      }
      redirect($this->input->server('HTTP_REFERER'));
    }
    function add_request_list(){
      $input_data = $this->input->post(); 
      $validKeys = [
        'request_details',
      ];
      $input_data             = array_intersect_key($input_data, array_flip($validKeys));
      if (!(isset($input_data['request_details']) && !empty($input_data['request_details']))) {
        $this->session->set_flashdata('ERR', 'Request details is required');
        redirect($this->input->server('HTTP_REFERER'));
      }
      $input_data['create_date'] = date('Y-m-d H:i:s');
      $input_data['edit_date'] = date('Y-m-d H:i:s');
      $input_data['is_deleted'] = '0';
      $input_data['status'] = 'For Request';
      $input_data['edit_user'] = $this->session->userdata('SESS_USER_ID'); 

      $table = 'tbl_requests_list';
      $res = $this->superadministrators_model->insert_data_table($table ,$input_data);
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Successfully Submitted');
      } else {
        $this->session->set_flashdata('ERR', 'Submission Failed');
      }
      redirect($this->input->server('HTTP_REFERER'));
    }

    function view_request_list($id){
        $selectColumns = [
            ['selectStatement' => 'id,request_details,status'],
          ];
          $filter = [
            ['id' => $id],
          ];
          $table = 'tbl_requests_list';
          $dataTable               = $this->superadministrators_model->get_table($table, $filter, $selectColumns);

          $data["dataTable"]    = $dataTable;
        echo json_encode($data);
    }

    function setups()
    {
        $data['DISP_NAME']                          = $this->superadministrators_model->GET_NAME();
        $data['DISP_LOGO']                          = $this->superadministrators_model->GET_LOGO();
        $data['DISP_NAVBAR']                        = $this->superadministrators_model->GET_NAVBAR();
        $data['DISP_HEADER']                        = $this->superadministrators_model->GET_HEADER();
        $data['DISP_MOBILE_BANNER']                 = $this->superadministrators_model->GET_MOBILE_BANNER();
        $data['DISP_DESKTOP_BANNER']                = $this->superadministrators_model->GET_DESKTOP_BANNER();
        $data['DISP_HEADER_CONTENT']                = $this->superadministrators_model->GET_HEADER_CONTENT();
        $data['DISP_FOOTER_CONTENT']                = $this->superadministrators_model->GET_FOOTER_CONTENT();
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/setup_views', $data);
    }

    function update_reset_maiya()
    {
        $this->superadministrators_model->UPDATE_MAIYA_THEME();
        $this->superadministrators_model->UPDATE_MAIYA_NAME();
        $this->superadministrators_model->UPDATE_MAIYA_HEADER();
        $this->superadministrators_model->UPDATE_MAIYA_LOGO();
        $this->superadministrators_model->UPDATE_MAIYA_NAVBAR_LOGO();
        $this->superadministrators_model->UPDATE_MAIYA__MOBILE_HEADER_LOGO();


        redirect("superadministrators/setups");
    }
    function update_reset_eyebox()
    {
        $this->superadministrators_model->UPDATE_EYEBOX_THEME();
        $this->superadministrators_model->UPDATE_EYEBOX_NAME();
        $this->superadministrators_model->UPDATE_EYEBOX_HEADER();
        $this->superadministrators_model->UPDATE_EYEBOX_LOGO();
        $this->superadministrators_model->UPDATE_EYEBOX_NAVBAR_LOGO();
        $this->superadministrators_model->UPDATE_EYEBOX__MOBILE_HEADER_LOGO();
        redirect("superadministrators/setups");
    }

    function module_activations()
    {
        $data['DISP_STATUS']                        = $this->superadministrators_model->GET_STATUS();
        $data['DISP_COMPANY_STATUS']                = $this->superadministrators_model->GET_COMPANY_STATUS();
        $data['DISP_TEAMS_STATUS']                  = $this->superadministrators_model->GET_TEAMS_STATUS();
        $data['DISP_EMPLOYEE_STATUS']               = $this->superadministrators_model->GET_EMPLOYEE_STATUS();
        $data['DISP_HR_STATUS']                     = $this->superadministrators_model->GET_HR_STATUS();
        $data['DISP_ATTENDANCE_STATUS']             = $this->superadministrators_model->GET_ATTENDANCE_STATUS();
        $data['DISP_LEAVE_STATUS']                  = $this->superadministrators_model->GET_LEAVE_STATUS();
        $data['DISP_PAYROLL_STATUS']                = $this->superadministrators_model->GET_PAYROLL_STATUS();
        $data['DISP_BENEFITS_STATUS']               = $this->superadministrators_model->GET_BENEFITS_STATUS();
        $data['DISP_REC_STATUS']                    = $this->superadministrators_model->GET_REC_STATUS();
        $data['DISP_LEARN_STATUS']                  = $this->superadministrators_model->GET_LEARN_STATUS();
        $data['DISP_PERFORMANCE_STATUS']            = $this->superadministrators_model->GET_PERFORMANCE_STATUS();
        $data['DISP_REWARDS_STATUS']                = $this->superadministrators_model->GET_REWARDS_STATUS();
        $data['DISP_EXIT_STATUS']                   = $this->superadministrators_model->GET_EXIT_STATUS();
        $data['DISP_ASSET_STATUS']                  = $this->superadministrators_model->GET_ASSET_STATUS();
        $data['DISP_PROJ_STATUS']                   = $this->superadministrators_model->GET_PROJ_STATUS();
        $data['DISP_ADMIN_STATUS']                  = $this->superadministrators_model->GET_ADMIN_STATUS();
        $data['DISP_OVERTIME_STATUS']               = $this->superadministrators_model->GET_SYSTEM_SETUP('overtimes');
        $data['DISP_ASSETS_STATUS']                 = $this->superadministrators_model->GET_SYSTEM_SETUP('asset');
        $data['DISP_REPORTS_STATUS']                = $this->superadministrators_model->GET_SYSTEM_SETUP('reports');
        $data['DISP_REQUESTS_STATUS']               = $this->superadministrators_model->GET_SYSTEM_SETUP('requests');
        // echo '<pre>';
        // var_dump($data['DISP_STATUS']);
        // return;
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/module_activation_views', $data);
    }

    function configurations_old()
    {
        $data["C_MAINTENANCE"]              = $this->superadministrators_model->GET_MAINTENANCE();
        $data["C_TIME_OUT"]                 = $this->superadministrators_model->GET_TIME_OUT();
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/configuration_views', $data);
    }
    function configurations()
    {
        $data['max_active_user']                           = $this->superadministrators_model->get_system_setup_by_setting('max_active_user');
        $data['maintenance']                               = $this->superadministrators_model->get_system_setup_by_setting('maintenance');
        $data['time_out']                                  = $this->superadministrators_model->get_system_setup_by_setting('time_out');
        // $data['requireApprovers']                           = $this->superadministrators_model->get_system_setup_by_setting('requireApprovers');
        $data['auto_login']                                  = $this->superadministrators_model->get_system_setup_by_setting2('auto_login', '0');
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/configurations_views', $data);
    }
    function system_reset()
    {
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/system_reset_views');
    }

    function end_trial(){
        
        $data['end_trial_val']                           = $this->superadministrators_model->get_system_setup_by_setting('end_trial');
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/end_trial_views', $data);
    }

    function attendance_record_setting()
    {
        $data['eagleridge_attendace_record']                           = $this->superadministrators_model->get_system_setup_by_setting2('eagleridge_attendace_record', '0');
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/attendance_record_setting_views', $data);
    }

    function update_end_trial(){
        $end_trial_data = $this->input->post('end_trial');
        
        ($end_trial_data != '') ?  $end_trial_data:  $end_trial_data = '';

        $this->superadministrators_model->UPDATE_END_TRIAL($end_trial_data, 'end_trial');
        $this->session->set_flashdata('SUCC', 'Settings successfully updated');
        redirect($this->input->server('HTTP_REFERER'));
    }

    function update_attendance_record_setting(){
        $eagle_ridge_setting_val = $this->input->post('eagleridge_attendace_record');

        $this->superadministrators_model->UPDATE_SYSTEM_SETUP_VALUE('eagleridge_attendace_record', $eagle_ridge_setting_val);
        $this->session->set_flashdata('SUCC', 'Settings Successfully updated');
        redirect($this->input->server('HTTP_REFERER'));
    }

    function update_configurations()
    {
        $input_data = $this->input->post();
        // echo '<pre>';
        // var_dump($input_data); die();
        if (!isset($input_data['maintenance'])) {
            $input_data['maintenance'] = 0;
        } else {
            $input_data['maintenance'] = 1;
        }
        $validKeys = [
            'max_active_user',
            'maintenance',
            'time_out',
            'auto_login',
        ];
        $input_data             = array_intersect_key($input_data, array_flip($validKeys));
        // echo '<pre>';
        // var_dump($input_data);
        // return;
        // $settings= array_keys($input_data);
        $res = $this->superadministrators_model->UPDATE_HOME_SETTINGS($input_data);
        // var_dump($res);die();
        if ($res) {
            $this->session->set_flashdata('SUCC', 'Settings Successfully updated');
        } else {
            $this->session->set_flashdata('ERR', 'Settings Unable to update');
        }
        redirect($this->input->server('HTTP_REFERER'));
    }


    function system_variables()
    {
        $data['SET_UP_VARIABLES']           = $this->superadministrators_model->GET_SET_UP_VARIABLES();
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/system_variable_views', $data);
    }
    function update_system_varibles()
    {
        $data           = $this->input->post();
        $process_data   = array();
        foreach ($data as $key => $val) {
            $process_data[] = array(
                'id'        => $val['id'],
                'setting'   => $key,
                'value'     => $val['value']
            );
        }
        $res = $this->superadministrators_model->UPDATE_SETUP_VARIABLES($process_data);
        // if(!$res){
        //     $this->session->set_flashdata('error', 'Unable to update system variables');
        //     redirect('superadministrators/system_variables');
        //     return;
        // }
        $this->session->set_flashdata('success', 'Successfully Updated!');
        redirect('superadministrators/system_variables');
    }
    function system_data_reset()
    {
        // $user_id = $this->session->userdata('SESS_USER_ID');
        $input_data = $this->input->post();
        // echo json_encode($input_data);
        $messageError = '';
        // $input_data['empl_id'] = $user_id;
        $username = $input_data['username'];
        $password = $input_data['password'];
        $res = $this->superadministrators_model->checkUserPassword($username, $password);
        if (!$res) {
            echo json_encode(array('messageError' =>  'Invalid username and or password'));
            return;
        }
        // $this->session->set_flashdata('SUCC', 'Successfully Updated!');
        // redirect('superadministrators/system_reset');
        $tables = $this->superadministrators_model->GET_ALL_TABLES();
        foreach ($tables as $table) {
            if (
                $table != 'tbl_system_user_admin' &&
                $table != 'tbl_system_setup' &&
                $table != 'tbl_employee_infos' &&
                $table != 'tbl_special_account' &&
                $table != 'tbl_system_adminusers' &&
                $table != 'tbl_system_useraccess' &&
                $table != 'tbl_payroll_period' &&
                $table != 'tbl_std_holidays' &&
                $table != 'tbl_payroll_sss' &&
                $table != 'tbl_payroll_philhealth' &&
                $table != 'tbl_std_adjustments' &&
                $table != 'tbl_std_allowances' &&
                $table != 'tbl_std_allowances_nontax' &&
                $table != 'tbl_std_allowances_tax' &&
                $table != 'tbl_std_assetcategories' &&
                $table != 'tbl_std_banks' &&
                $table != 'tbl_std_bloodtypes' &&
                $table != 'tbl_std_branches' &&
                $table != 'tbl_std_companylocations' &&
                $table != 'tbl_std_custom_contribution' &&
                $table != 'tbl_std_deductions' &&
                $table != 'tbl_std_deductions_nontax' &&
                $table != 'tbl_std_deductions_tax' &&
                $table != 'tbl_std_departments' &&
                $table != 'tbl_std_divisions' &&
                $table != 'tbl_std_employeetypes' &&
                $table != 'tbl_std_genders' &&
                $table != 'tbl_std_groups' &&
                $table != 'tbl_std_hmos' &&
                $table != 'tbl_std_holidays' &&
                $table != 'tbl_std_knowledgearticles' &&
                $table != 'tbl_std_knowledgecategories' &&
                $table != 'tbl_std_leavetypes' &&
                $table != 'tbl_std_lines' &&
                $table != 'tbl_std_maritalstatuses' &&
                $table != 'tbl_std_nationalities' &&
                $table != 'tbl_std_paygrade' &&
                $table != 'tbl_std_positions' &&
                $table != 'tbl_std_religions' &&
                $table != 'tbl_std_sections' &&
                $table != 'tbl_std_shirtsizes' &&
                $table != 'tbl_std_skilllevels' &&
                $table != 'tbl_std_skillnames' &&
                $table != 'tbl_std_stockrooms' &&
                $table != 'tbl_std_teams' &&
                $table != 'tbl_std_terminationtypes' &&
                $table != 'tbl_std_years' &&
                $table != 'tbl_attendance_shifts'
            ) {
                $result = $this->superadministrators_model->TRUNCATE_DATABASE_TABLE($table);
            }
        }
        echo json_encode(array('messageSuccess' =>  'Resetting Data Successful'));
    }

    function time_out()
    {

        $id                 = $this->input->post('id');
        $is_on              = $this->input->post('main_on');
        $minutes            = 0;
        if ($is_on == 'on') {
            $minutes        = $this->input->post('minutes');
            $this->superadministrators_model->MOD_UPDATE_TIME_OUT($id, $minutes);
        } else {
            $this->superadministrators_model->MOD_UPDATE_TIME_OUT($id, $minutes);
        }
        redirect('superadministrators/configurations');
    }


    //======================================================== UPDATE SET_UPS FUNCTION ================================================================
    function update_company_name()
    {
        $companyName                                = $this->input->post('UPDATE_NAME');
        $this->superadministrators_model->MOD_UPDATE_NAME($companyName);
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPLY', '  Submitted Successfully!');
        redirect('superadministrators/setups');
    }
    function update_header_content()
    {
        $h_content                                  = $this->input->post('header');
        $this->superadministrators_model->UPDATE_HEADER_CONTENT($h_content);
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPLY', '  Submitted Successfully!');
        redirect('superadministrators/setups');
    }
    function update_footer_content()
    {
        $f_content                                  = $this->input->post('footer');
        $this->superadministrators_model->UPDATE_FOOTER_CONTENT($f_content);
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPLY', ' Submitted Successfully!');
        redirect('superadministrators/setups');
    }
    function update_logo()
    {
        $get_logo_name                              = $_FILES['INSRT_LOGIN_LOGO']['name'];
        $config['upload_path']                      = './assets_system/images/';
        $config['allowed_types']                    = 'gif|jpg|jpeg|png|webp';
        $config['file_name']                        = $get_logo_name ;
        $config['overwrite']                        = 'TRUE';
        $this->load->library('upload', $config);
        if ($_FILES['INSRT_LOGIN_LOGO']['size'] != 0) {
            if ($this->upload->do_upload('INSRT_LOGIN_LOGO')) {
                $data_upload                            = array('INSRT_LOGIN_LOGO' => $this->upload->data());
                $logo_img                               = $data_upload['INSRT_LOGIN_LOGO']['file_name'];
                // echo '<pre>'; var_dump($logo_img); die();
                $this->superadministrators_model->INSERT_LOGO($logo_img);
                $this->session->set_flashdata('SESS_SUCC', 'New Login Logo Image was Added!');
            } else {
                $error                                  = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('SESS_ERR_IMAGE', $error['error']);
            }
        } else {
            $this->session->set_flashdata('SESS_ERR_IMAGE', 'No Login Logo Image was selected');
        }
        redirect('superadministrators/setups');
    }
    function update_navbar()
    {
        $get_logo_name                              = $_FILES['INSRT_NAVBAR_LOGO']['name'];
        $config['upload_path']                      = './assets_system/images/';
        $config['allowed_types']                    = 'gif|jpg|jpeg|png|webp';
        $config['file_name']                        = 'navbar_logo.png';
        $config['overwrite']                        = 'TRUE';
        $this->load->library('upload', $config);
        if ($_FILES['INSRT_NAVBAR_LOGO']['size'] != 0) {
            if ($this->upload->do_upload('INSRT_NAVBAR_LOGO')) {
                $data_upload                            = array('INSRT_NAVBAR_LOGO' => $this->upload->data());
                $logo_img                               = $data_upload['INSRT_NAVBAR_LOGO']['file_name'];
                $this->superadministrators_model->INSERT_NAVBAR($logo_img);
                $this->session->set_flashdata('SESS_SUCC', 'New Navigation Bar Logo was Added!');
            } else {
                $error                                  = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('SESS_ERR_IMAGE', $error['error']);
            }
        } else {
            $this->session->set_flashdata('SESS_ERR_IMAGE', 'No File selected');
        }
        redirect('superadministrators/setups');
    }



    function truncate_all_tables()
    {

        $res = $this->superadministrators_model->TRUNCATE_ALL_TABLE();
        $db_name_1 = "tbl_std_leavetypes";
        $data_1 = array(
            array(
                'create_date'   => date('Y-m-d H:i:s'),
                'edit_date'     => date('Y-m-d H:i:s'),
                'edit_user'     => $this->session->userdata('SESS_USER_ID'),
                'is_deleted'    => 0,
                'name'          => 'Leave without Pay (LWOP)',
                'status'        => 'Active'
            ),
            array(
                'create_date'   => date('Y-m-d H:i:s'),
                'edit_date'     => date('Y-m-d H:i:s'),
                'edit_user'     => $this->session->userdata('SESS_USER_ID'),
                'is_deleted'    => 0,
                'name'          => 'Vacation Leave',
                'status'        => 'Active'
            ),
            array(
                'create_date'   => date('Y-m-d H:i:s'),
                'edit_date'     => date('Y-m-d H:i:s'),
                'edit_user'     => $this->session->userdata('SESS_USER_ID'),
                'is_deleted'    => 0,
                'name'          => 'Sick Leave',
                'status'        => 'Active'
            ),
        );



        $db_name_3 = "tbl_attendance_shifts";
        $data_3 = array(
            array(
                'create_date'           => date('Y-m-d H:i:s'),
                'edit_date'             => date('Y-m-d H:i:s'),
                'edit_user'             => $this->session->userdata('SESS_USER_ID'),
                'is_deleted'            => 0,
                'code'         => 'REST',
                'name'             => 'REST',
                'color'              => '#c4c4c4',
                'time_regular_enable' => '',
                'time_regular_start' => '',
                'time_regular_end' => '',
                'time_regular_reg'         => 0,
                'time_regular_nd'         => 0,
                'time_break_enable' => '',
                'time_break_start'         => '00:00:00',
                'time_break_end'       => '00:00:00',
                'time_break_isexcluded' => '',
                'time_break_hours'         => 0,
                'time_overtime_enable' => '',
                'time_overtime_start'         => '00:00:00',
                'time_overtime_end'         => '00:00:00',
                'time_overtime_ot'         => 0,
                'time_overtime_nd'         => 0,
                'status'         => 'Active',
                'time_in'         => '00:00:00',
                'time_out'         => '00:00:00',
                'time_in_2'         => '00:00:00',
                'time_out_2'         => '00:00:00',
                'time_out_ot'         => '00:00:00',
                'next_day'         => '',
                'fixed'         => 0,
                'lunch_break_start' => '',
                'lunch_break_end' => '',

            ),
            array(
                'create_date'           => date('Y-m-d H:i:s'),
                'edit_date'             => date('Y-m-d H:i:s'),
                'edit_user'             => $this->session->userdata('SESS_USER_ID'),
                'is_deleted'            => 0,
                'code'         => 'DS 8-5',
                'name'             => 'Morning DS 8-5',
                'color'              => '#ff001f',
                'time_regular_enable' => 1,
                'time_regular_start' => '07:00:00',
                'time_regular_end' => '17:00:00',
                'time_regular_reg'         => 10,
                'time_regular_nd'         => 0,
                'time_break_enable' => 1,
                'time_break_start'         => '12:00:00',
                'time_break_end'       => '13:00:00',
                'time_break_isexcluded' => 0,
                'time_break_hours'         => 0,
                'time_overtime_enable' => '',
                'time_overtime_start'         => '00:00:00',
                'time_overtime_end'         => '00:00:00',
                'time_overtime_ot'         => 0,
                'time_overtime_nd'         => 0,
                'status'         => 'Active',
                'time_in'         => '00:00:00',
                'time_out'         => '00:00:00',
                'time_in_2'         => '00:00:00',
                'time_out_2'         => '00:00:00',
                'time_out_ot'         => '00:00:00',
                'next_day'         => '',
                'fixed'         => 0,
                'lunch_break_start' => '',
                'lunch_break_end' => ''
            )
        );
        $this->superadministrators_model->INSERT_DEFAULT_DATA($db_name_1, $data_1);
        $this->superadministrators_model->TRUNCATE_ALL_TABLE2();
        $this->superadministrators_model->INSERT_DEFAULT_DATA($db_name_3, $data_3);
        $this->superadministrators_model->INSERT_CUT_OFF();

        // redirect('login');

    }

    function truncate_database_tables()
    {
        $data["tables"]         = $this->superadministrators_model->GET_ALL_TABLES();
        $this->load->view('templates/header');
        $this->load->view('modules/superadministrators/truncate_table_views', $data);
    }
    function db_tracate($db_name)
    {
        if ($db_name == 'tbl_system_setup') {
            redirect('database_tables');
            return;
        }
        $res = $this->superadministrators_model->DB_RESET($db_name);
        if ($db_name == 'tbl_std_leavetypes' && $res) {
            $data = array(
                array(
                    'create_date'   => date('Y-m-d H:i:s'),
                    'edit_date'     => date('Y-m-d H:i:s'),
                    'edit_user'     => $this->session->userdata('SESS_USER_ID'),
                    'is_deleted'    => 0,
                    'name'          => 'Leave without Pay (LWOP)',
                    'status'        => 'Active'
                ),
                array(
                    'create_date'   => date('Y-m-d H:i:s'),
                    'edit_date'     => date('Y-m-d H:i:s'),
                    'edit_user'     => $this->session->userdata('SESS_USER_ID'),
                    'is_deleted'    => 0,
                    'name'          => 'Vacation Leave',
                    'status'        => 'Active'
                ),
                array(
                    'create_date'   => date('Y-m-d H:i:s'),
                    'edit_date'     => date('Y-m-d H:i:s'),
                    'edit_user'     => $this->session->userdata('SESS_USER_ID'),
                    'is_deleted'    => 0,
                    'name'          => 'Sick Leave',
                    'status'        => 'Active'
                ),
            );
            $default = $this->superadministrators_model->INSERT_DEFAULT_DATA($db_name, $data);
        }
    }
    function update_header()
    {
        $get_logo_name                              = $_FILES['INSRT_HEADER_LOGO']['name'];
        $config['upload_path']                      = './assets_system/images/';
        $config['allowed_types']                    = 'gif|jpg|jpeg|png|webp';
        $config['file_name']                        = "header_logo1.png";
        $config['overwrite']                        = 'TRUE';
        $this->load->library('upload', $config);
        if ($_FILES['INSRT_HEADER_LOGO']['size'] != 0) {
            if ($this->upload->do_upload('INSRT_HEADER_LOGO')) {
                $data_upload                        = array('INSRT_HEADER_LOGO' => $this->upload->data());
                $logo_img                           = $data_upload['INSRT_HEADER_LOGO']['file_name'];
                $this->superadministrators_model->INSERT_HEADER($logo_img);
                $this->session->set_flashdata('SESS_SUCC', 'New Header Logo(Mobile) Image was Added!');
                redirect('superadministrators/setups');
            } else {
                $error                                  = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('SESS_ERR_IMAGE', $error['error']);
                redirect('superadministrators/setups');
            }
        } else {
            $error                                  = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('SESS_ERR_IMAGE', $error['error']);
            redirect('superadministrators/setups');
        }
        $this->session->set_userdata('SESS_ERR_IMAGE', '  Unexpected Error Occured!');
        redirect('superadministrators/setups');
    }
    function mobile_banner()
    {
        $get_logo_name                              = $_FILES['INSRT_MOBILE_BANNER']['name'];
        $config['upload_path']                      = './assets_system/images/';
        $config['allowed_types']                    = 'gif|jpg|jpeg|png|webp';
        $config['file_name']                        = $get_logo_name;
        $config['overwrite']                        = 'TRUE';
        $this->load->library('upload', $config);
        if ($_FILES['INSRT_MOBILE_BANNER']['size'] != 0) {
            if ($this->upload->do_upload('INSRT_MOBILE_BANNER')) {
                $data_upload                        = array('INSRT_MOBILE_BANNER' => $this->upload->data());
                $logo_img                           = $data_upload['INSRT_MOBILE_BANNER']['file_name'];
                $this->superadministrators_model->UPDATE_MOBILE_BANNER($logo_img);
                $this->session->set_flashdata('SESS_SUCC', 'New Banner Logo(Mobile) Image was Added!');
            } else {
                $error                              = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('SESS_ERR_IMAGE', $error['error']);
                redirect('superadministrators/setups');
            }
        } else {
            $this->session->set_flashdata('SESS_ERR_IMAGE', 'No Banner Logo(Mobile) Image was selected');
            redirect('superadministrators/setups');
        }
        $this->session->set_flashdata('SESS_ERR_IMAGE', '  Unexpected Error occured!');
        redirect('superadministrators/setups');
    }
    function desktop_banner()
    {
        $get_logo_name                              = $_FILES['INSRT_DESKTOP_BANNER']['name'];
        $config['upload_path']                      = './assets_system/images';
        $config['allowed_types']                    = 'gif|jpg|jpeg|png|webp';
        $config['file_name']                        = $get_logo_name;
        $config['overwrite']                        = 'TRUE';
        $this->load->library('upload', $config);
        if ($_FILES['INSRT_DESKTOP_BANNER']['size'] != 0) {
            if ($this->upload->do_upload('INSRT_DESKTOP_BANNER')) {
                $data_upload                        = array('INSRT_DESKTOP_BANNER' => $this->upload->data());
                $logo_img                           = $data_upload['INSRT_DESKTOP_BANNER']['file_name'];
                $this->superadministrators_model->UPDATE_DESKTOP_BANNER($logo_img);
                $this->session->set_flashdata('SESS_SUCC', 'New Banner Logo(Desktop) Image  was Added!');
                redirect('superadministrators/setups');
            } else {
                $error                              = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('SESS_ERR_IMAGE', $error['error']);
                redirect('superadministrators/setups');
            }
        } else {
            $this->session->set_flashdata('SESS_ERR_IMAGE', 'No Banner Logo(Desktop) Image  was selected');
            redirect('superadministrators/setups');
        }
        // $this->session->set_flashdata('SESS_SUCC', '  Submitted Successfully!');
        redirect('superadministrators/setups');
    }
    //======================================================== UPDATE MODULE ACTIVAITON =========================================================
    function update_status()
    {
        $data_check                                 = $this->input->post('data');
        // echo '<pre>';
        // var_dump($data_check);
        // return;
        foreach ($data_check as $data) {
            $status_id                              = isset($data['id']) ? $data['id'] : '';
            $value                                  = isset($data['values']) ? implode(" ,", $data['values']) : 0;
            $this->superadministrators_model->MOD_UPDATE_STATUS($value, $status_id);
        }
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPLY', '  Updated Successfully!');
        redirect('superadministrators/module_activations');
    }

    function update_maintenance()
    {
        $id             = $this->input->post('id');
        $value          = $this->input->post('main_on');
        $checked = ($value == '') ? 0 : 1;
        $this->superadministrators_model->MOD_UPDATE_STATUS($checked, $id);
        redirect("superadministrators/configurations");
    }


    function update_process($status_id, $value)
    {
        $checked = ($value == '') ? 0 : $value;
        $this->superadministrators_model->MOD_UPDATE_STATUS($checked, $status_id);
    }
    function get_modules()
    {
        $data[] = $this->superadministrators_model->GET_STATUS();
        $data[] = $this->superadministrators_model->GET_COMPANY_STATUS();
        $data[] = $this->superadministrators_model->GET_EMPLOYEE_STATUS();
        $data[] = $this->superadministrators_model->GET_HR_STATUS();
        $data[] = $this->superadministrators_model->GET_ATTENDANCE_STATUS();
        $data[] = $this->superadministrators_model->GET_LEAVE_STATUS();
        $data[] = $this->superadministrators_model->GET_PAYROLL_STATUS();
        $data[] = $this->superadministrators_model->GET_REC_STATUS();
        $data[] = $this->superadministrators_model->GET_LEARN_STATUS();
        $data[] = $this->superadministrators_model->GET_PERFORMANCE_STATUS();
        $data[] = $this->superadministrators_model->GET_REWARDS_STATUS();
        $data[] = $this->superadministrators_model->GET_EXIT_STATUS();
        $data[] = $this->superadministrators_model->GET_ASSET_STATUS();
        $data[] = $this->superadministrators_model->GET_PROJ_STATUS();
        $data[] = $this->superadministrators_model->GET_ADMIN_STATUS();
        // echo "<pre>";
        //     var_dump($data);
        // echo "</pre>";
        $data_string = array();
        $data_string[0]["user_page"] = "";
        foreach ($data as $module) {
            $data_string[0]["user_page"] .= $module['value'];
        }
        echo json_encode($data_string);
    }


    function insrt_attachment()
    {
        $attachment = $_FILES["INSRT_ATTACHMENT"]["name"];
        $response = $this->superadministrators_model->MOD_INSRT_ANNOUNCEMENTS($attachment);
        if ($response) {
            $upload_response = $this->do_upload();
            $this->session->set_userdata('SESS_SUCC_MSG_INSRT_ANNOUNCEMENTS', 'Knowledge Bases Added Successfully!');
        }
        redirect('superadministrators/configurations');
    }
    function get_time_out()
    {
        $time_out = $this->superadministrators_model->GET_TIME_OUT();
        echo json_encode($time_out);
    }

    public function do_upload()
    {
        $config['upload_path'] = './assets_system/sample_file/';
        $config['allowed_types'] = '*';
        $config['max_size'] = 0;
        $config['max_width'] = 0;
        $config['max_height'] = 0;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('INSRT_ATTACHMENT')) {
            $error = array('error' => $this->upload->display_errors());
            return $error;
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data;
        }
    }
}
